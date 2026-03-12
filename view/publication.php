<form action="/publication/add" method="post" class="mx-auto" style="max-width: 400px;" enctype="multipart/form-data">
    <div class="mb-3">
        <label for="img">Image</label>
        <input type="file" name="img" accept="image/jpeg,image/png" required>
    </div>

    <div class="mb-3">
        <label for="text" class="form-label">Text</label>
        <input type="text" name="text" id="text" class="form-control">
    </div>

    <button type="submit" class="btn btn-primary w-100"> Poster </button>
</form>