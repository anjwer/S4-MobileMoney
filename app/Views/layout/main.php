<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background-color: #f8f9fa; 
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        main {
            flex: 1;
        }
        .nav-link.active { font-weight: bold; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <a class="navbar-brand mb-0 me-2" href="#">Money Pull Up</a>
                <a href="javascript:history.back()" class="text-white text-decoration-none" title="Retour" style="font-size: 1.25rem;">&larr;</a>
            </div>
            <a href="<?= base_url('/') ?>" class="btn btn-outline-light btn-sm">Accueil</a>
        </div>
    </nav>

    <main class="container">
        <?= $this->renderSection('content') ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <footer class="mt-auto py-3 bg-white border-top text-center text-muted w-100">
        <div class="container">
            Projet final S4 - ETU 4025 | ETU 3902
        </div>
    </footer>
</body>
</html>