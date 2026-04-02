<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h4 class="card-title text-center mb-4">Créer une discussion</h4>

                    <form action="/discussion/add" method="post">

                        <div class="mb-3">
                            <label for="discussion" class="form-label">Titre de la discussion</label>
                            <input type="text" name="discussion" id="discussion" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Créer la discussion</button>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger mt-3 mb-0">
                                <?= $error ?>
                            </div>
                        <?php endif; ?>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>