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

<?= $this->endSection() ?>