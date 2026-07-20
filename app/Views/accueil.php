<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
    <div class="container mt-5 shadow p-4 bg-white rounded justify-content-center ">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h2>Se connecter en tant que:</h2>
                <div class="row">
                    <div class="col-3"><a href="<?= base_url('admin/login') ?>" class="btn btn-success w-100">Opérateur</a></div>
                    <div class="col-3"><a href="<?= base_url('client/login') ?>" class="btn btn-primary w-100">Client</a></div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>