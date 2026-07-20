<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h5 class="fw-semibold mb-4">
                        Effectuer un dépôt
                    </h5>

                    <form method="post" action="<?= base_url('client/depot') ?>">

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
                                    placeholder="Ex: 5 0000"
                                    required
                                >

                                <span class="input-group-text">
                                    Ar
                                </span>
                            </div>
                        </div>


                        <!-- <div class="mb-3">
                            <label class="form-label text-muted">
                                Description (optionnel)
                            </label>

                            <textarea
                                name="description"
                                class="form-control"
                                rows="3"
                                placeholder="Motif du dépôt..."
                            ></textarea>
                        </div> -->


                        <button class="btn btn-dark w-100">
                            Valider le dépôt
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>