<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Click Clack</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="shortcut icon" href="/img/normale.png" type="image/x-icon">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">Click Clack</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="/discussion" class="nav-link">Discussions</a>
                    </li>
                    <li class="nav-item">
                        <a href="/publication/add" class="nav-link">Ajouter une publication</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <?php if (!empty($_SESSION['User'])): ?>
                            <a href="/profil" class="nav-link d-flex align-items-center">
                                <img src="/img/<?= htmlspecialchars($_SESSION['User']['photoProfile']) ?>"
                                    class="rounded-circle object-fit-cover img-fluid" style="width: 50px; height: 50px;"
                                    alt="">
                            </a>
                        <?php else: ?>
                            <a href="/login" class="nav-link d-flex align-items-center"> <img src="/img/utilisateur.png"
                                    class="img-fluid" style="max-width: 50px; height: 50px;" alt="">
                            </a>
                        <?php endif; ?>
                    </li>
                </ul>

            </div>
        </div>
    </nav>


    <?php echo $content ?>


    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="/bootstrap/bootstrap.bundle.min.js"></script>
    <script type="module" src="/script/main.js"></script>

</body>

</html>