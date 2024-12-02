$("#addTaskForm").submit(function (event) {
  event.preventDefault();
  let title = $("#title").val();
  let status = $("#status").is(":checked");
  let content = $("#content").val();
  let priority = $('input[name="priority"]:checked').val()
    ? $('input[name="priority"]:checked').val()
    : "low";
  console.log(title);
  console.log(status);
  console.log(content);
  console.log(priority);
  $.ajax({
    url: "http://localhost/AHT_Nov/w3/to_do_list/list/add",
    method: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      title: title,
      status: status,
      content: content,
      priority: priority,
    }),
    success: function (response) {
      alert("task added successfully!");
      window.location.href = "http://localhost/AHT_Nov/w3/to_do_list/list/";
      gettasks();
    },
    error: function (xhr, status, error) {
      alert("Error adding task: " + error);
    },
  });
});
