<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="shortcut icon" href="/img/normale.png" type="image/x-icon">
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Click Clack</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li>
                        <a href="/login"><img src="/img/utilisateur.png" style="width: 4rem;"></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <?php echo $content ?>


    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <script src="/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="/script/main.js"></script>

</body>

</html>