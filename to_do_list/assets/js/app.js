function gettasks() {
  $.ajax({
    url: "http://localhost/AHT_Nov/l12+/taskManagement/tasks",
    method: "GET",
    success: function (response) {
      let tasks = response.data;
      let tableBody = $("#taskTable tbody");
      tableBody.empty();
      tasks.forEach(function (task) {
        tableBody.append(`
                  <tr>
                      <td>${task.id}</td>
                      <td>${task.name}</td>
                      <td>${task.price}</td>
                      <td><a class="btn btn-primary" href="http://localhost/AHT_Nov/l12+/taskManagement/tasks/edit?id=${task.id}" role="button">Edit</a></td>
                      <td><a class="btn btn-primary" href="http://localhost/AHT_Nov/l12+/taskManagement/tasks/delete?id=${task.id}" role="button">Delete</a></td>
                  </tr>
              `);
      });
    },
  });
}

$("#searchForm").submit(function (event) {
  event.preventDefault();
  let query = $("#search").val();
  console.log("query:", query);

  $.ajax({
    url: "http://localhost/AHT_Nov/l12+/taskManagement/tasks/search",
    method: "GET",
    contentType: "application/json",
    data: { query: query },
    success: function (response) {
      let tasks = response.data;
      let tableBody = $("#taskTable tbody");
      tableBody.empty();
      tasks.forEach(function (task) {
        tableBody.append(`
                  <tr>
                      <td>${task.id}</td>
                      <td>${task.name}</td>
                      <td>${task.price}</td>
                      <td><a class="btn btn-primary" href="http://localhost/AHT_Nov/l12+/taskManagement/tasks/edit?id=${task.id}" role="button">Edit</a></td>
                      <td><a class="btn btn-primary" href="http://localhost/AHT_Nov/l12+/taskManagement/tasks/delete?id=${task.id}" role="button">Delete</a></td>
                  </tr>
              `);
      });
    },
    error: function (xhr, status, error) {
      alert("Error finding task: " + error);
    },
  });
});

$(document).ready(function () {
  gettasks();
});
