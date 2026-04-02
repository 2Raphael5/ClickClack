<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Discussions</h3>
        <a href="/discussion/add" class="btn btn-primary">Ajouter une discussion</a>
    </div>

    <div class="row g-4">
        <?php foreach ($discussions as $discussion): ?>

            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">

                        <h5 class="card-title"><?= htmlspecialchars($discussion->titre) ?></h5>

                        <p class="card-text text-muted mb-4">
                            Créé par : <?= htmlspecialchars($discussion->nomUtilisateur) ?>
                        </p>

                        <a href="<?= '/discussion/' . $discussion->idDiscussion ?>"
                            class="btn btn-outline-primary mt-auto w-100">Voir la discussion</a>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </div>
</div>