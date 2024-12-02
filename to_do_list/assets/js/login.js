$("#loginForm").submit(function (event) {
  event.preventDefault();
  let username = $("#username").val();
  let password = $("#password").val();
  console.log(username);
  console.log(password);
  $.ajax({
    url: "http://localhost/AHT_Nov/w3/to_do_list/login",
    method: "POST",
    contentType: "application/json",
    data: JSON.stringify({
      username: username,
      password: password,
    }),
    success: function (response) {
      alert("Logged in successfully!");
      let user = response.data;
      console.log(user);
      window.location.href = "http://localhost/AHT_Nov/w3/to_do_list/list";
      //   gettasks();
    },
    error: function (xhr, status, error) {
      alert("Error logging in: " + error);
    },
  });
});
