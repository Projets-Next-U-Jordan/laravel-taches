
<form action="{{ $task && $task->id ? route('task.update', $task->id) : route('task.store') }}" id="taskForm" method="POST">
    @csrf
    @if($task && $task->id)
        @method('PUT')
    @endif

    <input type="hidden" class="form-control" name="id" id="id" value="{{ old('id', $task ? $task->id : '') }}">                
    <div class="form-group d-flex align-items-center gap-3">
        <label for="name" class="mr-3">Titre</label>
        <input type="text" class="form-control mr-3" name="name" id="name" value="{{ old('name', $task ? $task->name : '') }}">
        <div class="form-check" style="white-space: nowrap;">
            <input class="form-check-input" name="completed" type="checkbox" id="checkbox" {{ old('completed', $task && $task->completed) ? 'checked' : '' }}>
            <label class="form-check-label" for="checkbox">
                Fini ?
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="start">Quand ?</label>
        <input type="datetime-local" class="form-control" name="due_date" id="start" min="{{ date('Y-m-d') }}T00:00" value="{{ old('due_date', $task ? $task->due_date : '') }}">
    </div>

    <div class="form-group">
        <label for="category">Categorie</label>
        <select class="form-control" name="category_id" id="category">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id', $task && $task->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="content">Contenu</label>
        <textarea class="form-control" name="content" id="content">{{ old('content', $task ? $task->content : '') }}</textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" form="taskForm" value="Sauvegarder">
    </div>
</form>