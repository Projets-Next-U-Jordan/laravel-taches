<div class="modal modal-lg fade" id="viewTask" tabindex="-1" role="dialog" aria-labelledby="viewTaskLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewTaskLabel">View Task</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Complété:</strong> <span id="viewCompleted"></span></p>
                <p><strong>Pour:</strong> <span id="viewStart"></span></p>
                <p><strong>Category:</strong> <span id="viewCategory"></span></p>
                <p><strong>Content</strong><br><textarea readonly style="width:100%" id="viewContent"></textarea></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="deleteButton">Delete</button>
                <button type="button" class="btn btn-primary" id="editButton">Edit</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>