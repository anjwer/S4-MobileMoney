<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between mb-4">
    <h2>Gestion Epargne</h2>
    <form action="<?= base_url('/client/epargne/save') ?>" method="post">
        <label for="pourcentage">epargne%</label>
        <input type="number" name="pourcentage" id="">
        <input type="hidden" name="id_client" value="<?= $client['id'] ?>" >
        <input type="submit" value="Enregistrer">
    </form>
</div>
</div>


<?= $this->endSection() ?>