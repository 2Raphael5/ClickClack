<div class="publication-container">
<?php
foreach ($publications as $key => $publication) {
    ?>
    <div class="d-flex justify-content-center my-4">
        <div class="card publication-card">
            <img src="<?= "/publication/" . $publication->img ?>" class="card-img-top publication-img" alt="publication image">

            <div class="card-body">
                <p class="card-text publication-text">
                    <?= $publication->text ?>
                </p>
                <?php
                if (!empty($_SESSION["User"]["idUtilisateur"])&&$publication->idUtilisateur == $_SESSION["User"]["idUtilisateur"]) {
                    ?>
                    <a href=<?="/publication/delete/". $publication->idPublication ?> class="btn btn-danger">Supprimer</a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

    <?php
}
?>
</div> 
