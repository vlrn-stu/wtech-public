<form action="{{ route('image.upload') }}" method="post" id="ia" enctype="multipart/form-data">
    @csrf
    <div class="form-group col-md-4" >
        <label for="image">Nahraj obrázok</label>
        <input type="file" name="image" class="form-control" required>
    </div>

    <button type="submit" form="ia" class="btn btn-primary mt-3">Nahraj</button>

</form>
