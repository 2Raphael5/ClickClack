<h1 class="h3 mb-4 text-center">Modifier mon profil</h1>

<?php if (!empty($error)): ?>
    <p class="text-danger text-center"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form action="/profil/edit" method="post" class="mx-auto" style="max-width: 400px;">
    <div class="mb-3">
        <label for="pseudo" class="form-label">Pseudo :</label>
        <input type="text" name="pseudo" id="pseudo" class="form-control" value="<?= htmlspecialchars($user->pseudo) ?>"
            required>
    </div>

    <div class="mb-3">
        <label for="motDePasse" class="form-label">Nouveau mot de passe : </label>
        <input type="password" name="motDePasse" id="motDePasse" class="form-control">
    </div>

    <div class="mb-3">
        <label for="photoProfile" class="form-label">Photo de profil :</label>
        <select name="photoProfile" id="photoProfile" class="form-select" required>
            <option value="utilisateur.png">---</option>
            <option value="kiwi.jpg" <?= $user->photoProfile === 'kiwi.jpg' ? 'selected' : '' ?>>Kiwi</option>
            <option value="crabe.jpg" <?= $user->photoProfile === 'crabe.jpg' ? 'selected' : '' ?>>Crabe</option>
            <option value="ananas.png" <?= $user->photoProfile === 'ananas.png' ? 'selected' : '' ?>>Ananas</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success w-100">Enregistrer</button>
</form>

<p class="mt-3 text-center">
    <a href="/profil">Annuler</a>
</p>