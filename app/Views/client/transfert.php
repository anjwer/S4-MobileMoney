<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">


    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h5 class="fw-semibold mb-4">
                        Effectuer un transfert
                    </h5>
                    <form method="post"  action="<?= base_url('client/trasnfert') ?>">
                        <div class="mb-3">
                            <label class="form-label text-muted">Numéro du destinataire</label>
                            <input
                                type="text"
                                name="telephone"
                                class="form-control"
                                placeholder="03X XX XXX XX"
                                required
                            >
                            <small id="verificationNumero"></small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label text-muted">
                                Montant
                            </label>


                            <div class="input-group">
                                <input
                                    type="number"
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
                                    id="prendreFrais"
                                >
                                <label class="form-check-label" for="prendreFrais">
                                    Prendre en charge les frais de transfert
                                </label>
                            </div>

                            <hr>
                            <small class="text-muted">
                                Frais : <strong id="montantFrais">0 Ar</strong>
                            </small>

                            <br>
                            <small class="text-muted">
                                Total débité : <strong id="montantTotal">0 Ar</strong>
                            </small>
                        </div>

                        <!-- <div class="mb-3">

                            <label class="form-label text-muted">
                                Code secret
                            </label>


                            <input
                                type="password"
                                name="code_secret"
                                class="form-control"
                                placeholder="Votre code secret"
                                required
                            >

                        </div> -->


                        <button class="btn btn-dark w-100">
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
    document.getElementById("telephone").addEventListener("input", function () {

        clearTimeout(timer);
        const numero = this.value;

        timer = setTimeout(() => {

            const zone = document.getElementById("verificationNumero");
            if (numero.length !== 10) {
                zone.innerHTML = "";
                zone.className = "";
                return;
            }

            fetch("<?= base_url('client/verifierNumero') ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: "telephone=" + encodeURIComponent(numero)
            })
            .then(r => r.json())
            .then(data => {
                zone.className = data.notre_operateur ? "text-success" : "text-danger";
                zone.innerHTML = data.notre_operateur ? "✓ Numéro appartenant à notre opérateur" : "✗ Numéro non pris en charge par notre opérateur";
            });
        }, 300);
    });
</script>


<script>
    let timer;
    let frais = 0;

    // Elements DOM
    const inputTelephone = document.getElementById("telephone");
    const inputMontant = document.querySelector("input[name='montant']");
    const checkboxFrais = document.getElementById("prendreFrais");

    const zoneVerification = document.getElementById("verificationNumero");
    const blocOperateur = document.getElementById("optionsOperateur");

    const affichageFrais = document.getElementById("montantFrais");
    const affichageTotal = document.getElementById("montantTotal");


    function afficherBlocFrais(visible){
        blocOperateur.style.display = visible ? "block" : "none";
    }

    function afficherVerification(estOperateur){
        if(estOperateur){
            zoneVerification.className = "text-success";
            zoneVerification.innerHTML = "Numéro appartenant à notre opérateur";
            afficherBlocFrais(true);
        } else {
            zoneVerification.className = "text-danger";
            zoneVerification.innerHTML = "Numéro non pris en charge par notre opérateur";
            afficherBlocFrais(false); 
            frais = 0;
        }
        afficherTotal();
    }

    function verifierNumero(numero){
        fetch("<?= base_url('client/verifierNumero') ?>",{
            method:"POST",
            headers:{
                "Content-Type":
                "application/x-www-form-urlencoded"
            },
            body:
            "telephone=" + encodeURIComponent(numero)

        })
        .then(response => response.json())
        .then(data => {
            afficherVerification(
                data.notre_operateur
            );
        });
    }

    function chargerFrais(montant){
        if(montant <= 0){
            frais = 0;
            afficherTotal();
            return;
        }

        fetch("<?= base_url('client/calculFrais') ?>",{
            method:"POST",
            headers:{
                "Content-Type":
                "application/x-www-form-urlencoded"
            },

            body:
            "montant=" + encodeURIComponent(montant)
        })
        .then(response => response.json())
        .then(data => {
            frais = Number(data.frais);
            afficherTotal();
        });
    }


    function afficherTotal(){
        const montant = Number(inputMontant.value) || 0;
        let total = montant;
        if(checkboxFrais.checked){
            total += frais;
        }

        affichageFrais.innerHTML = frais.toLocaleString() + " Ar";
        affichageTotal.innerHTML = total.toLocaleString() + " Ar";
    }


    inputTelephone.addEventListener("input", function() {
        clearTimeout(timer);
        const numero = this.value;

        if(numero.length !== 10){
            zoneVerification.innerHTML = "";
            afficherBlocFrais(false);
            return;
        }

        timer = setTimeout(() => {
            verifierNumero(numero);
        },300);
    });

    inputMontant.addEventListener( "input", function(){
        const montant = Number(this.value) || 0;
        chargerFrais(montant);
    });


    checkboxFrais.addEventListener("change", function(){
        afficherTotal();
    });

</script>
<?= $this->endSection() ?>