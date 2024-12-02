<h2>Cập nhật thông tin Task</h2>
<form id="updateForm">
    <input type="hidden" name="id" id="id" value="<?php echo $task->id; ?>" />
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" id="title" value="<?php echo $task->title; ?>" class="form-control" />
    </div>
    <div class="form-group">
        <label for="status">Completed</label>
        <input type="checkbox" name="status" id="status" value="1" <?php if ($task->status) echo 'checked'; ?>>
    </div>
    <div class="form-group">
        <label>Content</label>
        <textarea name="content" id="content" class="form-control"><?php echo $task->content; ?></textarea>
    </div>
    <div class="form-group">
        <label>Ưu tiên</label>
        <input type="radio" id="low" name="priority" value="low"
            <?php echo ($task->priority == 'low') ? 'checked' : ''; ?>>
        <label for="low">Low</label>
        <input type="radio" id="medium" name="priority" value="medium"
            <?php echo ($task->priority == 'medium') ? 'checked' : ''; ?>>
        <label for="medium">Medium</label>
        <input type="radio" id="high" name="priority" value="high"
            <?php echo ($task->priority == 'high') ? 'checked' : ''; ?>>
        <label for="high">High</label>
        <br>
    </div>
    <div class="form-group">
        <input type="submit" value="Update" class="btn btn-primary" />
        <a href="index.php?page=todos" class="btn btn-default">Cancel</a>
    </div>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="http://localhost/AHT_Nov/w3/to_do_list/assets/js/edit.js"></script>