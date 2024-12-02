function getTask() {
  let currentUrl = window.location.pathname; // Lấy phần đường dẫn của URL
  let segments = currentUrl.split("/"); // Tách URL thành các đoạn
  let id = segments[segments.length - 1]; // ID thường nằm ở đoạn cuối
  console.log(id); // Kết quả: 123

  $.ajax({
    url: "http://localhost/AHT_Nov/w3/to_do_list/list/edit/" + id,
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

$("#updateForm").submit(function (event) {
  event.preventDefault();
  let id = $("#id").val();
  let title = $("#title").val();
  let status = $("#status").is(":checked");
  let content = $("#content").val();
  let priority = $('input[name="priority"]:checked').val()
    ? $('input[name="priority"]:checked').val()
    : "low";
  console.log(id);
  console.log(title);
  console.log(status);
  console.log(content);
  console.log(priority);
  $.ajax({
    url: "http://localhost/AHT_Nov/w3/to_do_list/list/edit",
    method: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      id: id,
      title: title,
      status: status,
      content: content,
      priority: priority,
    }),
    success: function (response) {
      alert("Task edited successfully!");
      window.location.href = "http://localhost/AHT_Nov/w3/to_do_list/list/";
      gettasks();
    },
    error: function (xhr, status, error) {
      alert("Error: " + error);
    },
  });
});
