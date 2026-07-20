<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-4">
        <div class="card bg-info text-white p-3 mb-4 shadow">
            <h5>Mon Solde</h5>
            <h2>50 000 Ar</h2>
        </div>
    </div>
    <div class="col-md-8">
        <div class="btn-group w-100">
            <button class="btn btn-outline-primary">Dépôt</button>
            <button class="btn btn-outline-warning">Retrait</button>
            <button class="btn btn-outline-secondary">Transfert</button>
        </div>
    </div>
</div>

<div class="card mt-4 p-3">
    <h5>Historique des opérations</h5>
    <table class="table">
        <thead><tr><th>Date</th><th>Type</th><th>Montant</th></tr></thead>
        <tbody>
            
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>