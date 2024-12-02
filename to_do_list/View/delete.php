<h1>Bạn chắc chắn muốn xóa sản phẩm này?</h1>
<h3><?php echo $task->title; ?></h3>
<form id="deleteTaskForm">
    <input type="hidden" id="taskID" name="id" value="<?php echo $task->id; ?>" />
    <div class="form-group">
        <input type="submit" value="Delete" class="btn btn-danger" />
        <a class="btn btn-default" href="index.php">Cancel</a>
    </div>
</form>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="http://localhost/AHT_Nov/w3/to_do_list/assets/js/delete.js"></script>