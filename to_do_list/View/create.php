<?php
include "layout/header.php";
?>

<div class="col-12 col-md-12">
    <div class="row">
        <div class="col-12">
            <h1>Thêm task</h1>
        </div>
        <div class="col-12">
            <form id="addTaskForm">
                <div class="form-group">
                    <label>Tên task</label>
                    <input type="text" class="form-control" name="title" id="title" placeholder="Nhập tên" required>
                </div>
                <div class="form-group">
                    <label for="status">Completed</label>
                    <input type="checkbox" name="status" id="status">
                </div>
                <div class="form-group">
                    <label>Nội dung</label>
                    <input type="text" class="form-control" name="content" id="content" placeholder="Nhập nội dung" required>
                </div>
                <div class="form-group">
                    <label>Ưu tiên</label>
                    <input type="radio" id="low" name="priority" value="low">
                    <label for="low">Low</label>
                    <input type="radio" id="medium" name="priority" value="medium">
                    <label for="medium">Medium</label>
                    <input type="radio" id="high" name="priority" value="high">
                    <label for="high">High</label>
                    <br>
                </div>
                <button type="submit" class="btn btn-primary">Thêm mới</button>
                <button class="btn btn-secondary" onclick="window.history.go(-1); return false;">Hủy</button>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="http://localhost/AHT_Nov/w3/to_do_list/assets/js/create.js"></script>