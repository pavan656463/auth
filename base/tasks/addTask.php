<div>
    <form action="/auth/base/base.php" id = "addTaskForm" method="post">
        <div class="mb-3">
            <label for="" class="form-label">Title</label>
            <input type="text" class="form-control" name="title" id="title" aria-describedby="helpId" placeholder="" />
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
        </div>

        <div class="mb-3">
            <label for="" class="form-label">Assign To</label>
            <input type="text" class="form-control" name="assignee" id="assignee" aria-describedby="helpId"
                placeholder="Add your text here..." />
        </div>
        <button type="submit" class="btn btn-primary" name="submit" style = "background-color:#20c997;border:none;">Add Task</button>
        <?php
        task($conn); // function in base.php 
        ?>
    </form>
</div>