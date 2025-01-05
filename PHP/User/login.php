<?php
// Recupere le message d'erreur
$message = $_GET['error'] ?? '';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../../css/loginCSS.css">
</head>
<body>
<div class="login-container">
    <h1>Login</h1>
    <!--Permet d'afficher le message si il y a une erreur-->
    <?php if ($message){echo "<p style='color: red;'>$message</p>";} ?>
    <form method="post" action="process_login.php">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Enter your username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <div class="form-group">
            <button type="submit">Login</button>
        </div>
    </form>
</div>
</body>
</html>
