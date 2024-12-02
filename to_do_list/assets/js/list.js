function render(tasks) {
  let tableBody = $("#taskTable tbody");
  tableBody.empty(); // Xóa dữ liệu cũ trong bảng

  tasks.forEach(function (task, index) {
    let isChecked = task.status === "1" ? "checked" : "";
    tableBody.append(`
      <tr>
        <td>${index + 1}</td>
        <td>${task.title}</td>
        <td>
          <input type="checkbox" id="completed-${
            task.id
          }" value="${task.id}" ${isChecked}>
          <label for="completed-${task.id}">Completed</label>
        </td>
        <td>${task.content}</td>
        <td>${task.priority}</td>
        <td>
          <a class="btn btn-primary" href="http://localhost/AHT_Nov/w3/to_do_list/list/edit/${
            task.id
          }" role="button">Edit</a>
          <a class="btn btn-danger" href="http://localhost/AHT_Nov/w3/to_do_list/list/delete/${
            task.id
          }" role="button">Delete</a>
        </td>
      </tr>
    `);
  });
}

function gettasks() {
  $.ajax({
    url: "http://localhost/AHT_Nov/w3/to_do_list/list/tasks",
    method: "GET",
    success: function (response) {
      if (response.status === 200) {
        let tasks = response.data;
        // console.log(tasks);
        render(tasks);
      } else {
        alert(response.message || "Failed to fetch tasks.");
      }
    },
    error: function (xhr, status, error) {
      alert("Error fetching tasks: " + error);
    },
  });
}

$(document).ready(function () {
  gettasks(); // Gọi hàm lấy danh sách khi tải trang
});

$("#searchForm").submit(function (event) {
  event.preventDefault();
  let query = $("#query").val();
  // console.log(query); // Kết quả: 123

  $.ajax({
    url: "http://localhost/AHT_Nov/w3/to_do_list/list/search/" + query,
    method: "GET",
    contentType: "application/json",
    data: JSON.stringify({
      query: query,
    }),
    success: function (response) {
      // alert("task deleted successfully!");
      //   window.location.href = "http://localhost/AHT_Nov/w3/to_do_list/list/";
      if (response.status === 200) {
        let tasks = response.data;
        // console.log(tasks);
        render(tasks);
      } else {
        alert(response.message || "Failed to find tasks.");
      }
    },
    error: function (xhr, status, error) {
      alert("Error finding task: " + error);
    },
  });
});

$('#filterForm input[type="submit"]').on("click", function (e) {
  e.preventDefault(); // Ngăn chặn form submit mặc định

  // Lấy giá trị của nút submit được nhấn
  var priority = $(this).val();
  console.log(priority); // Kết quả: 123

  $.ajax({
    url: "http://localhost/AHT_Nov/w3/to_do_list/list/filter/" + priority,
    method: "GET",
    // contentType: "application/json",
    // data: JSON.stringify({
    //   priority: priority,
    // }),
    success: function (response) {
      // alert("task deleted successfully!");
      //   window.location.href = "http://localhost/AHT_Nov/w3/to_do_list/list/";
      if (response.status === 200) {
        let tasks = response.data;
        // console.log(tasks);
        render(tasks);
      } else {
        alert(response.message || "Failed to filter tasks.");
      }
    },
    error: function (xhr, status, error) {
      // alert("Error finding task: " + error);
      tasks = [];
      render(tasks);
    },
  });
});

function getCheckedTasks() {
  let checkedTasks = [];

  // Lặp qua tất cả các checkbox được chọn
  $("#taskTable tbody input[type='checkbox']:checked").each(function () {
    // Lấy giá trị của checkbox (task ID)
    checkedTasks.push($(this).val());
  });

  return checkedTasks;
}

$("#changeStatus").submit(function (event) {
  event.preventDefault(); // Ngăn chặn form submit mặc định
  let checkedTasks = getCheckedTasks();
  // console.log("Checked Task IDs:", checkedTasks);
  $.ajax({
    url: "http://localhost/AHT_Nov/w3/to_do_list/list/update/",
    method: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      taskIds: checkedTasks, // Dữ liệu gửi đi
    }),
    // console.log("Checked Task IDs:", checkedTasks);

    success: function (response) {
      // console.log("Response from server:", response); // Kiểm tra phản hồi từ server

      // alert("task changed successfully!");
      //   window.location.href = "http://localhost/AHT_Nov/w3/to_do_list/list/";
      if (response.status === 200) {
        let tasks = response.data;
        // console.log(tasks);
        render(tasks);
      } else {
        alert(response.message || "Failed to change tasks.");
      }
    },
    error: function (xhr, status, error) {
      // alert("Error finding task: " + error);
      tasks = [];
      render(tasks);
    },
  });
});
