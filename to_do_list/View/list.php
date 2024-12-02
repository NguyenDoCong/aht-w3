<?php
include "layout/header.php"
?>
<div>
    <h2>Danh sách Task</h2>
    <a href="http://localhost/AHT_Nov/w3/to_do_list/list/add">Thêm mới</a><br><br>
</div>
<div>
    <form id="searchForm" action="">
        <input type="hidden" name="page" value="todos">
        <input type="text" id="query" name="query">
        <input type="submit" value="Search">
    </form>
    <br>
</div>
<div>
    <form id="filterForm">
        <input type="hidden" name="page" value="todos">
        <input type="submit" value="Low" name="Low" id="Low">
        <input type="submit" value="Medium" name="Medium" id="Medium">
        <input type="submit" value="High" name="High" id="High">
        <input type="submit" value="All" name="All" id="All">
    </form>
</div>
<div>
    <form id="changeStatus">
        <table id="taskTable" class="table">
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Content</th>
                    <th>Priority</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <input type="submit" value="Update">
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="http://localhost/AHT_Nov/w3/to_do_list/assets/js/list.js"></script>