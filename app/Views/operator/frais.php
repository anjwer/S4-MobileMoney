<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Configuration des Barèmes</h2>
    
    <!-- Filtre -->
    <div class="w-25">
        <select id="filterType" class="form-select">
            <option value="1">Dépôt</option>
            <option value="2">Retrait</option>
            <option value="3">Transfert</option>
        </select>
    </div>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFrais">
        + Ajouter
    </button>
</div>

<div class="table-responsive bg-white shadow rounded p-3">
    <table class="table table-hover align-middle" id="tableFrais">
        <thead class="table-light">
            <tr>
                <th>Tranche (Min - Max)</th>
                <th>Frais</th>
                <!--
                <th>Action</th>
                -->
            </tr>
        </thead>
        <tbody>
            <?php foreach($baremes as $b): ?>
            <!-- On stocke le type dans data-type pour le filtre JS -->
            <tr data-type="<?= $b['id_type_operation'] ?>">
                <td><?= $b['borne_min'] ?> - <?= $b['borne_max'] ?> Ar</td>
                <td><?= $b['frais'] ?> Ar</td>
                <!--
                <td>
                    <button class="btn btn-sm btn-warning">Modifier</button>
                </td>
                -->
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    document.getElementById('filterType').addEventListener('change', function() {
        const filterValue = this.value; 
        const rows = document.querySelectorAll('#tableFrais tbody tr');

        rows.forEach(row => {
            if ( row.dataset.type === filterValue) {
                row.style.display = ''; 
            } else {
                row.style.display = 'none'; 
            }
        });
    });
</script>

<?= $this->endSection() ?>