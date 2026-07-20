<!DOCTYPE html>
<html lang="fr">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Connexion Admin</title>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>
                <form action="<?= base_url('admin/login') ?>" method="post" class="card p-4 shadow">
                    <h3 class="mb-3">Espace Admin</h3>
                    <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                    <input type="password" name="mdp" class="form-control mb-3" placeholder="Mot de passe" required>
                    <button type="submit" class="btn btn-dark w-100">Connexion</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>