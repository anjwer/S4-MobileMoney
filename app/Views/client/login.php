<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card p-4 shadow">
            <h3 class="text-center mb-4">Connexion Client</h3>
            <form action="<?= base_url('client/login') ?>" method="post">
                <div class="mb-3">
                    <label>Numéro de téléphone</label>
                    <input type="text" name="phone" class="form-control" placeholder="03X XX XXX XX" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>