<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body p-4">

                    <h5 class="fw-semibold mb-4">
                        Effectuer un retrait
                    </h5>


                    <form method="post"  action="<?= base_url('client/retrait') ?>">
                        <div class="mb-3">
                            <label class="form-label text-muted">
                                Montant à retirer
                            </label>


                            <div class="input-group">

                                <input 
                                    type="number"
                                    name="montant"
                                    class="form-control"
                                    min="1"
                                    placeholder="Ex: 10000"
                                    required
                                >

                                <span class="input-group-text">
                                    Ar
                                </span>

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
                            Confirmer le retrait
                        </button>


                    </form>


                </div>

            </div>


        </div>

    </div>

</div>


<?= $this->endSection() ?>