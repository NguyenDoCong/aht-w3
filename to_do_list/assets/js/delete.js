$("#deleteTaskForm").submit(function (event) {
  event.preventDefault();
  let id = $("#taskID").val();
  console.log("id:", id);

  $.ajax({
    url: "http://localhost/AHT_Nov/w3/to_do_list/list/delete?id=" + id,
    method: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      id: id,
    }),
    success: function (response) {
      alert("task deleted successfully!");
      window.location.href = "http://localhost/AHT_Nov/w3/to_do_list/list/";
    },
    error: function (xhr, status, error) {
      alert("Error deleting task: " + error);
    },
  });
});

function getTask() {
  let currentUrl = window.location.pathname; // Lấy phần đường dẫn của URL
  let segments = currentUrl.split("/"); // Tách URL thành các đoạn
  let id = segments[segments.length - 1]; // ID thường nằm ở đoạn cuối
  console.log(id); // Kết quả: 123

  $.ajax({
    url: "http://localhost/AHT_Nov/w3/to_do_list/list/delete/" + id,
    method: "GET",
    success: function (response) {
      // alert("task deleted successfully!");
      // window.location.href = "http://localhost/AHT_Nov/w3/to_do_list/list/";
    },
    error: function (xhr, status, error) {
      alert("Error: " + error);
    },
  });
}

$(document).ready(function () {
  getTask();
});
