<form action="{{ $category && $category->id ? route('category.update', $category->id) : route('category.store') }}" id="categoryForm" method="POST">
    @csrf
    @if($category && $category->id)
        @method('PUT')
    @endif
    <input type="hidden" name="id" value="{{ old('id', $category ? $category->id : '') }}">
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" style="font-size: 1.5rem" class="form-control" name="name" value="{{ old('name', $category ? $category->name : '') }}">
    </div>
    <div class="form-group">
        <label for="color">Color:</label>
        <input type="color" class="form-control" name="color" value="{{ old('color', $category ? $category->color : '') }}">
    </div>
    <button type="submit" class="btn btn-primary">Sauvegarder</button>
</form>
