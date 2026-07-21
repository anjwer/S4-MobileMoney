<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h5 class="fw-semibold mb-4">Effectuer un transfert</h5>

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

                    <form method="post" action="<?= base_url('client/transfert') ?>">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label class="form-label text-muted">Numéro du destinataire</label>
                            <input
                                type="text"
                                id="telephone"
                                name="telephone"
                                class="form-control"
                                placeholder="Ex: 0340012345"
                                minlength="10"
                                maxlength="10"
                                pattern="^[0-9]{10}$"
                                title="Veuillez saisir exactement 10 chiffres"
                                required
                            >
                            <small id="verificationNumero" class="d-block mt-1"></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">Montant</label>
                            <div class="input-group">
                                <input
                                    type="number"
                                    id="montant"
                                    name="montant"
                                    class="form-control"
                                    min="1"
                                    placeholder="Ex: 25 000"
                                    required
                                >
                                <span class="input-group-text">Ar</span>
                            </div>
                        </div>

                        <div id="optionsOperateur" class="card bg-light border-0 mt-3 p-3" style="display:none;">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="inclure_frais_retrait"
                                    value="1"
                                    id="prendreFrais"
                                >
                                <label class="form-check-label" for="prendreFrais">
                                    Prendre en charge les frais de retrait du destinataire
                                </label>
                            </div>

                            <hr>
                            <div class="d-flex justify-content-between"><small class="text-muted">Frais de transfert :</small> <strong id="fraisTransfert">0 Ar</strong></div>
                            <div class="d-flex justify-content-between"><small class="text-muted">Frais de retrait inclus :</small> <strong id="fraisRetrait">0 Ar</strong></div>
                            <hr class="my-1">
                            <div class="d-flex justify-content-between text-dark"><small class="fw-bold">Total à débiter :</small> <strong id="montantTotal" class="text-primary">0 Ar</strong></div>
                        </div>

                        <button class="btn btn-dark w-100 mt-4">
                            Envoyer l'argent
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let timer;
    let fraisTransfert = 0;
    let fraisRetrait = 0;

    const inputTelephone = document.getElementById("telephone");
    const inputMontant = document.getElementById("montant");
    const checkboxFrais = document.getElementById("prendreFrais");

    const zoneVerification = document.getElementById("verificationNumero");
    const blocOperateur = document.getElementById("optionsOperateur");

    const affichageFraisTransfert = document.getElementById("fraisTransfert");
    const affichageFraisRetrait = document.getElementById("fraisRetrait");
    const affichageTotal = document.getElementById("montantTotal");

    function afficherBlocFrais(visible) {
        blocOperateur.style.display = visible ? "block" : "none";
    }

    function verifierNumero(numero) {
        fetch("<?= base_url('client/verifierNumero') ?>", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "telephone=" + encodeURIComponent(numero)
        })
        .then(r => r.json())
        .then(data => {
            if (data.notre_operateur) {
                zoneVerification.className = "text-success d-block mt-1";
                zoneVerification.innerHTML = "Numéro appartenant à notre opérateur";
                afficherBlocFrais(true);
            } else {
                zoneVerification.className = "text-danger d-block mt-1";
                zoneVerification.innerHTML = "Numéro non pris en charge par notre opérateur";
                afficherBlocFrais(false);
            }
        });
    }

    function chargerFrais() {
        const montant = Number(inputMontant.value) || 0;
        if (montant <= 0) {
            fraisTransfert = 0;
            fraisRetrait = 0;
            afficherTotal();
            return;
        }

        const inclureRetrait = checkboxFrais.checked;

        fetch("<?= base_url('client/calculerFrais') ?>", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "montant=" + encodeURIComponent(montant) + "&inclure_retrait=" + inclureRetrait
        })
        .then(r => r.json())
        .then(data => {
            fraisTransfert = Number(data.frais_transfert);
            fraisRetrait = Number(data.frais_retrait);
            afficherTotal();
        });
    }

    function afficherTotal() {
        const montant = Number(inputMontant.value) || 0;
        
        const total = montant + fraisTransfert + fraisRetrait;

        affichageFraisTransfert.innerHTML = fraisTransfert.toLocaleString() + " Ar";
        affichageFraisRetrait.innerHTML = fraisRetrait.toLocaleString() + " Ar";
        affichageTotal.innerHTML = total.toLocaleString() + " Ar";
    }

    // Événements
    inputTelephone.addEventListener("input", function() {
        clearTimeout(timer);
        const numero = this.value;
        if (numero.length !== 10) {
            zoneVerification.className = "text-danger d-block mt-1";
            zoneVerification.innerHTML = "Le numéro doit comporter exactement 10 chiffres.";
            afficherBlocFrais(false);
            return;
        }
        timer = setTimeout(() => verifierNumero(numero), 300);
    });

    inputMontant.addEventListener("input", chargerFrais);
    checkboxFrais.addEventListener("change", chargerFrais);
</script>

<?= $this->endSection() ?>