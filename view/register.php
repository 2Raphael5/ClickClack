<h1 class="h3 mb-4 text-center">Créer un compte</h1>

<?php if (!empty($error)): ?>
    <p class="text-danger text-center"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<form action="/register" method="post" class="mx-auto" style="max-width: 400px;">
    <div class="mb-3">
        <label for="pseudo" class="form-label">Pseudo :</label>
        <input type="text" name="pseudo" id="pseudo" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="motDePasse" class="form-label">Mot de passe :</label>
        <input type="password" name="motDePasse" id="motDePasse" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="photoProfile" class="form-label">Photo de profil :</label>
        <select name="photoProfile" id="photoProfile" class="form-select" required>
            <option value="">---</option>
            <option value="kiwi.jpg">Kiwi</option>
            <option value="crabe.jpg">Crabe</option>
            <option value="ananas.png">Ananas</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        Créer mon compte
    </button>
</form>

<p class="mt-3 text-center">
    <a href="/login">Se connecter</a>
</p>