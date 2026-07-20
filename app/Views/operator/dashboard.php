<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<div class="row">
    <div class="col-8">
        <h2 class="mb-1">Dashboard Opérateur </h2>
    </div>
    <div class="col-4 d-flex justify-content-end">
        <a href="<?= base_url('admin/logout') ?>" class="btn btn-outline-danger">Deconnexion</a>
    </div>
</div>

<div class="row">
    <div class="col-3"><a href="<?= base_url('operator/frais') ?>" class="btn btn-danger">Voir plages de frais</a></div>
    <div class="col-3"><a href="<?= base_url('operator/prefixes') ?>" class="btn btn-primary">Voir les préfixes autorisés</a></div>
</div>

<h3>Situation Opérateur Principal (032)</h3>
<table class="table">
    <thead>
        <tr>
            <th>Total Transfert</th>
            <th>Commission (%)</th>
            <th>Montant Commission</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($mon_operateur as $gain): ?>
        <tr>
            <td><?= number_format($gain['total_transfert'], 2) ?> Ar</td>
            <td><?= $gain['pourcentage'] ?> %</td>
            <td><?= number_format($gain['montant_commission'], 2) ?> Ar</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- 2. Situation Autres Opérateurs -->
<h3>Situation des montants à envoyer aux autres opérateurs</h3>
<table class="table">
    <thead>
        <tr>
            <th>Opérateur</th>
            <th>Total Transfert</th>
            <th>Montant à envoyer (Net)</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($autres_operateurs as $gain): ?>
        <tr>
            <td><?= $gain['prefixe'] ?></td>
            <td><?= number_format($gain['total_transfert'], 2) ?> Ar</td>
            <!-- Calcul : Total - Commission -->
            <td><?= number_format($gain['total_transfert'] - $gain['montant_commission'], 2) ?> Ar</td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

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