<h1 class="h3 mb-4 text-center">Mon profil</h1>

<div class="mx-auto" style="max-width: 400px;">
    <div class="text-center mb-3">
        <img src="/img/<?= htmlspecialchars($user->photoProfile) ?>" alt="Photo de profil" class="rounded-circle object-fit-cover img-fluid" style="width: 200px; height: 200px;">
    </div>

    <p><strong>Pseudo :</strong> <?= htmlspecialchars($user->pseudo) ?></p>

    <div class="mt-3 d-grid gap-2">
        <a href="/profil/edit" class="btn btn-primary">Modifier mon profil</a>
        <a href="/logout" class="btn btn-danger">Se déconnecter</a>
    </div>

    <p class="mt-3 text-center">
        <a href="/">Retour à l'accueil</a>
    </p>
</div>