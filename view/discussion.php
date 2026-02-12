
<div class="row">
<?php
    foreach ($discussions as $key => $discussion) {
        ?>
  <div class="col-sm-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $discussion->titre?></h5>
                <p class="card-text">Créer par: <?= $discussion->nomUtilisateur?></p>
                <a href="#" class="btn btn-primary">Voir la discussion</a>
            </div>
        </div>
  </div>
        <?php
    }
?>
</div>