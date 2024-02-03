<div class="modal modal-lg fade" id="task" tabindex="-1" role="dialog" aria-labelledby="taskLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="taskLabel">Tâche</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Fermer">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{ route('task.index') }}" id="taskForm">
                @csrf
                <input type="hidden" name="_method" id="method">
                <input type="hidden" class="form-control" name="id" id="id">                
                <div class="form-group d-flex align-items-center gap-3">
                  <label for="name" class="mr-3">Titre</label>
                  <input type="text" class="form-control mr-3" name="name" id="name">
                  <div class="form-check" style="white-space: nowrap;">
                    <input class="form-check-input" name="completed" value="1" type="checkbox" id="checkbox">
                    <label class="form-check-label" for="checkbox">
                        Fini ?
                    </label>
                </div>
              </div>
            
                <div class="form-group">
                    <label for="start">Quand ?</label>
                    <input type="datetime-local" class="form-control" name="due_date" id="start" min="{{ date('Y-m-d') }}T00:00">
                </div>
            
                <div class="form-group">
                    <label for="category">Categorie</label>
                    <select class="form-control" name="category_id" id="category">
                        <option value="">Aucune</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="content">Contenu</label>
                    <textarea class="form-control" name="content" id="content"></textarea>
                </div>

            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
          <input type="submit" class="btn btn-primary" form="taskForm" value="Sauvegarder">
        </div>
      </div>
    </div>
</div>