<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-between mb-4">
    <h2>Gestion des Préfixes</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPrefixe">+ Ajouter Préfixe</button>
</div>

<div class="table-responsive bg-white shadow rounded p-3">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Préfixe</th>
                <th>Date Ajout</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($prefixes as $p): ?>
            <tr>
                <td><?= $p['prefixe'] ?> <?= $p['notre'] ? ' (Notre)' : '' ?></td>
                <td><?= $p['created_at'] ?></td>
                <td>
                    <a href="<?= base_url('operator/prefixes/delete/'.$p['id']) ?>" 
                       class="btn btn-sm btn-danger" 
                       onclick="return confirm('Confirmer la suppression ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Modale Ajout -->
<div class="modal fade" id="modalPrefixe" tabindex="-1">
    <div class="modal-dialog">
        <form action="<?= base_url('operator/prefixes/save') ?>" method="post" class="modal-content">
            <div class="modal-body">
                <label>Nouveau Préfixe (ex: 032)</label>
                <input type="text" name="prefixe" class="form-control" maxlength="3" required>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>