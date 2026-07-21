<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card p-4 shadow">
            <h3 class="text-center mb-4">Connexion Client</h3>
            <form action="<?= base_url('client/login') ?>" method="post">
                <div class="mb-3">
                    <label class="form-label">Numéro de téléphone</label>
                    <div class="d-flex align-items-center">
                        <span class="me-2">032</span>
                        <input type="text" name="telephone" class="form-control" placeholder="XX XXX XX" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>
        </div>
    </div>

    <a href="<?= base_url('/') ?>">Retour à l'accueil</a>

</div>
<?= $this->endSection() ?>