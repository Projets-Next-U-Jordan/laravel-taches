
<form action="{{ $task && $task->id ? route('task.update', $task->id) : route('task.store') }}" id="taskForm" method="POST">
    @csrf
    @if($task && $task->id)
        @method('PUT')
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
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
        {{-- Disable if $task has duedate --}}
        @php
            use Carbon\Carbon;
            $dueDate = $task->due_date ? Carbon::parse($task->due_date) : Carbon::now()->addHour();            
        @endphp

        <input type="datetime-local" {{ $task->due_date ? 'disabled' : '' }} class="form-control"  name="due_date" id="start" min="{{ date('Y-m-d') }}T00:00" value="{{ old('due_date', $dueDate->format('Y-m-d\TH:i')) }}">
    </div>

    <div class="form-group">
        <label for="category">Categorie</label>
        <select class="form-control" name="category_id" id="category">
            <option value="">Aucune</option>
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