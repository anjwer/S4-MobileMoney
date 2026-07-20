<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-8">
        <h2 class="mb-1">Dashboard Opérateur </h2>
    </div>
    <div class="col-4 d-flex justify-content-end">
        <a href="<?= base_url('operator/logout') ?>" class="btn btn-outline-danger">Deconnexion</a>
    </div>
</div>

<div class="row">
    <div class="col-3"><a href="<?= base_url('operator/frais') ?>" class="btn btn-danger">Voir plages de frais</a></div>
    <div class="col-3"><a href="<?= base_url('operator/prefixes') ?>" class="btn btn-primary">Voir les préfixes autorisés</a></div>
</div>

<!-- SECTION 1 : GAINS -->
<div class="card shadow-sm mb-5 p-3">
    <h4 class="mb-3">Situation des gains</h4>
    <table class="table table-hover">
        <thead class="table-light">
            <tr>
                <th>Type d'opération</th>
                <th>Nb Opérations</th>
                <th>Volume Total</th>
                <th>Total Gains (Frais)</th>
            </tr>
        </thead>
        <tbody>
            <?php $gain_total = 0;
             foreach($gains as $g): ?>
            <tr>
                <td><?= $g['type_operation'] ?></td>
                <td><?= $g['nombre_operations'] ?></td>
                <td><?= number_format($g['volume_total'], 0, ',', ' ') ?> Ar</td>
                <td class="fw-bold text-success"><?= number_format($g['total_gains_frais'], 0, ',', ' ') ?> Ar</td>
            </tr>
            <?php $gain_total += $g['total_gains_frais'];
         endforeach; ?>
            <tr>
                <td>Gain Total:</td>
                <td class="fw-bold text-success"><?= number_format($gain_total, 0, ',', ' ') ?> Ar</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- SECTION 2 : CLIENTS -->
<div class="card shadow-sm p-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Situation des comptes clients</h4>
        <input type="text" id="searchClient" class="form-control w-25" placeholder="Rechercher numéro...">
    </div>
    <table class="table table-hover" id="tableClients">
        <thead class="table-light">
            <tr>
                <th>Numéro de téléphone</th>
                <th>Solde actuel</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($clients as $c): ?>
            <tr>
                <td class="phone-number"><?= $c['numero_telephone'] ?></td>
                <td><?= number_format($c['solde'], 0, ',', ' ') ?> Ar</td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



<!-- Filtre JS -->
<script>
    document.getElementById('searchClient').addEventListener('keyup', function() {
        let input = this.value.toLowerCase();
        let rows = document.querySelectorAll('#tableClients tbody tr');
        
        rows.forEach(row => {
            let phone = row.querySelector('.phone-number').textContent.toLowerCase();
            row.style.display = phone.includes(input) ? '' : 'none';
        });
    });
</script>

<?= $this->endSection() ?>