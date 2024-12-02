<?php
include "layout/header.php";
?>

<div class="container">
    <div class="navbar navbar-default">
        <a class="navbar-brand" href="index.php">Login</a>
    </div>

    <?php if (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST" action="" id="loginForm">
        <label for="username">username:</label>
        <input type="username" name="username" id="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <button type="submit">Login</button>
        <button onclick="location.href='http://localhost/AHT_Nov/w3/to_do_list/register'" type="button">Register</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="http://localhost/AHT_Nov/w3/to_do_list/assets/js/login.js"></script>

<?php
include "layout/footer.php";
?>