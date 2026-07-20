<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h2 class="mb-4">Configuration des Barèmes</h2>
<div class="table-responsive bg-white shadow rounded p-3">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Tranche de montant</th>
                <th>Frais (Point)</th>
                <th>Frais (DAB)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>100 - 1000 Ar</td>
                <td>100</td>
                <td>-</td>
                <td><button class="btn btn-sm btn-warning">Modifier</button></td>
            </tr>
            <!-- Ajoute une boucle foreach ici pour afficher tes données base.sql -->
        </tbody>
    </table>
</div>
<?= $this->endSection() ?>