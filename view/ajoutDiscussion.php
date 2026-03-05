<form action="/discussion/add" method="post" class="mx-auto" style="max-width: 400px;">
    <div class="mb-3">
        <label for="discussion" class="form-label">Titre de la discussion:</label>
        <input type="text" name="discussion" id="discussion" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary w-100">Créer une discussion</button>
    <?php
    if (!empty($error)) {
        ?>
        <p><?= $error?></p>
        <?php
    }
    ?>
</form>