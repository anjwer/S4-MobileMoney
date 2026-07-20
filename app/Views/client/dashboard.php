<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<a href="<?= base_url('client/logout') ?>">Deconnexion</a>

<div class="container-fluid">
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">
                        Solde disponible
                    </p>

                    <h2 class="fw-bold mb-0">
                        <?= $solde["solde"] ?> Ar
                    </h2>
                </div>
            </div>
        </div>


        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center">

                    <div class="row w-100 g-2">

                        <div class="col-md-4">
                            <a href="<?= base_url('client/depot') ?>" 
                            class="btn btn-dark w-100">
                                Dépôt
                            </a>
                        </div>


                        <div class="col-md-4">
                            <a href="<?= base_url('client/retrait') ?>" 
                            class="btn btn-outline-dark w-100">
                                Retrait
                            </a>
                        </div>


                        <div class="col-md-4">
                            <a href="<?= base_url('client/transfert') ?>" 
                            class="btn btn-outline-secondary w-100">
                                Transfert
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>


    <!-- Historique -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-semibold mb-0">
                    Historique des opérations
                </h5>
            </div>


            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Type</th>
                            <th class="text-end">Montant</th>
                        </tr>
                    </thead>

                    <?php if ($historique) {
                        foreach($historique as $h) { ?>
                            <tr>
                                <td><?= $h["reference"] ?></td>
                                <td><?= $h["id_type_operation"] ?></td>
                                <td><?= $h["type_mvt"] ?></td>
                                <td><?= $h["montant"] ?></td>

                            </tr>
                    <?php }
                    } else { ?>
                        <tbody>
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    Aucune opération disponible
                                </td>
                            </tr>
                        </tbody>
                    <?php } ?>

                </table>
            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>