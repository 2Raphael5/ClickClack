<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h4 class="card-title text-center mb-4">Nouvelle publication</h4>

                    <form action="/publication/add" method="post" enctype="multipart/form-data">

                        <div class="mb-3">
                            <label for="img" class="form-label">Image</label>
                            <input type="file" name="img" id="img" class="form-control" accept="image/jpeg,image/png"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="text" class="form-label">Texte</label>
                            <input type="text" name="text" id="text" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Poster</button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>