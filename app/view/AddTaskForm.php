<form data-callback="getTaskList" method="post" action="<?php echo $putTaskUrl; ?>" class="form form-add-task"
      data-success="Added!">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add\edit task</h4>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <input data-validate="text" type="text" name="taskTitle" class="form-control" placeholder="Task title"
                   value="<?php echo $taskTitle; ?>">
        </div>
        <div class="form-group">
            <input type="text" name="taskDate" class="form-control" placeholder="Date"
                   value="<?php echo $taskDate; ?>">
        </div>
        <div class="form-group">
            <textarea data-validate="text" name="taskContent" class="form-control"
                      placeholder="content"><?php echo $taskContent; ?></textarea>
        </div>
        <div class="form-group">
            <select name="taskLabel" class="form-control">
                <?php foreach ($labels as $key => $label): ?>
                    <option <?php echo $key == $taskLabel ? 'selected ' : ''; ?>
                            value="<?php echo $key; ?>"><?php echo $label; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

            <input type="hidden" name="taskId">

        <div class="messages-container"></div>
    </div>
    <div class="modal-footer text-right">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>