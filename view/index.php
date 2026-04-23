<div class="publication-container">
    <?php foreach ($publications as $publication): ?>
        <div class="d-flex justify-content-center my-4">

            <!-- CARD -->
            <div class="card publication-card shadow-sm" style="cursor:pointer;" data-bs-toggle="modal"
                data-bs-target="#modal<?= $publication->idPublication ?>">

                <img src="<?= "/publication/" . htmlspecialchars($publication->img) ?>" class="card-img-top publication-img"
                    alt="publication image">

                <div class="card-body">

                    <p class="card-text publication-text">
                        <?= htmlspecialchars(mb_strimwidth($publication->text, 0, 25, "...")) ?>
                    </p>

                    <p class="mb-1">
                        <small class="text-muted">
                            Posté par <?= htmlspecialchars($publication->pseudoUtilisateur) ?>
                        </small>
                    </p>

                    <?php if (!empty($_SESSION["User"]["idUtilisateur"]) && $publication->idUtilisateur == $_SESSION["User"]["idUtilisateur"]): ?>
                        <a href="<?= "/publication/delete/" . $publication->idPublication ?>" class="btn btn-danger btn-sm"
                            onclick="event.stopPropagation();"> Supprimer</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- MODAL -->
        <div class="modal fade" id="modal<?= $publication->idPublication ?>" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <?= htmlspecialchars($publication->pseudoUtilisateur) ?>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 text-center mb-3 mb-md-0">
                                <img src="<?= "/publication/" . htmlspecialchars($publication->img) ?>"
                                    class="img-fluid rounded" alt="publication image">
                            </div>

                            <div class="col-md-6" style="max-height:60vh; overflow-y:auto;">

                                <p style="word-break: break-word;">
                                    <?= nl2br(htmlspecialchars($publication->text)) ?>
                                </p>

                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

    <?php endforeach; ?>
</div>