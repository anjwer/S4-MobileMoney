<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h5 class="fw-semibold mb-4">Transfert groupé (divisé)</h5>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('client/transfertMultiple') ?>" id="formMultiple">
                        <?= csrf_field() ?>
                        <input type="hidden" name="telephones" id="hiddenTelephones" value="">

                        <div class="mb-3">
                            <label class="form-label text-muted">Ajouter un destinataire</label>
                            <div class="input-group">
                                <input
                                    type="text"
                                    id="nouveauTel"
                                    class="form-control"
                                    placeholder=" 032 XX XXX XX"
                                    minlength="10"
                                    maxlength="10"
                                    pattern="^[0-9]{10}$"
                                >
                                <button type="button" class="btn btn-outline-dark" id="btnAddTel">Ajouter</button>
                            </div>
                            <small id="verificationNumero" class="d-block mt-1"></small>
                        </div>

                        <div class="mb-3">
                            <ul class="list-group" id="listeDestinataires">
                                <!-- JS items here -->
                            </ul>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Montant à diviser</label>
                            <div class="input-group">
                                <input
                                    type="number"
                                    id="montant"
                                    name="montant"
                                    class="form-control"
                                    min="1"
                                    placeholder="Ex: 50000"
                                    required
                                >
                                <span class="input-group-text">Ar</span>
                            </div>
                        </div>

                        <div id="optionsOperateur" class="card bg-light border-0 mt-3 p-3">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="inclure_frais_retrait"
                                    value="1"
                                    id="prendreFrais"
                                >
                                <label class="form-check-label" for="prendreFrais">
                                    Prendre en charge les frais de retrait des destinataires
                                </label>
                            </div>

                            <hr>
                            <div class="d-flex justify-content-between text-dark">
                                <small class="fw-bold">Part par destinataire (<span id="compteAffichage">0</span>) :</small> 
                                <strong id="montantDivise" class="text-primary">0 Ar</strong>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-dark w-100 mt-4" id="btnSubmit">
                            Envoyer le montant groupé
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const inputTel = document.getElementById('nouveauTel');
    const btnAddTel = document.getElementById('btnAddTel');
    const verificationNumero = document.getElementById('verificationNumero');
    const listeDest = document.getElementById('listeDestinataires');
    const hiddenTels = document.getElementById('hiddenTelephones');
    const inputMontant = document.getElementById('montant');
    const btnSubmit = document.getElementById('btnSubmit');
    const compteAffichage = document.getElementById('compteAffichage');
    const montantDivise = document.getElementById('montantDivise');

    let numeros = [];

    btnAddTel.addEventListener('click', function() {
        const val = inputTel.value.trim();
        if (val.length !== 10) {
            verificationNumero.className = 'text-danger d-block mt-1';
            verificationNumero.innerHTML = 'Le numéro doit comporter exactement 10 chiffres';
            return;
        }
        if (numeros.includes(val)) {
            verificationNumero.className = 'text-warning d-block mt-1';
            verificationNumero.innerHTML = 'Numéro déjà ajouté';
            return;
        }

        verificationNumero.innerHTML = 'Vérification...';
        verificationNumero.className = 'text-muted d-block mt-1';

        fetch("<?= base_url('client/verifierNumero') ?>", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "telephone=" + encodeURIComponent(val)
        })
        .then(r => r.json())
        .then(data => {
            if (data.notre_operateur) {
                verificationNumero.innerHTML = '';
                ajouterNumero(val);
                inputTel.value = '';
            } else {
                verificationNumero.className = "text-danger d-block mt-1";
                verificationNumero.innerHTML = "Numéro non pris en charge par notre opérateur";
            }
        });
    });

    function ajouterNumero(num) {
        numeros.push(num);
        majListe();
    }

    window.retirerNumero = function(num) {
        numeros = numeros.filter(n => n !== num);
        majListe();
    }

    function majListe() {
        listeDest.innerHTML = '';
        numeros.forEach(num => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.innerHTML = num + ` <button type="button" class="btn btn-sm btn-danger py-0 px-2" onclick="retirerNumero('${num}')">&times;</button>`;
            listeDest.appendChild(li);
        });

        hiddenTels.value = numeros.join(',');
        recalculer();
    }

    function recalculer() {
        const nb = numeros.length;
        const total = Number(inputMontant.value) || 0;
        compteAffichage.innerHTML = nb;
        if(nb > 0 && total > 0) {
            const divise = total / nb;
            montantDivise.innerHTML = divise.toLocaleString(undefined, {maximumFractionDigits: 2}) + ' Ar';
        } else {
            montantDivise.innerHTML = '0 Ar';
        }
    }

    inputMontant.addEventListener('input', recalculer);

    document.getElementById('formMultiple').addEventListener('submit', function(e) {
        if(numeros.length === 0) {
            e.preventDefault();
            alert("Veuillez ajouter au moins un destinataire.");
        }
    });

</script>

<?= $this->endSection() ?>
