<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $users_file = 'users.txt';

    $users = file($users_file, FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        list($stored_user, $stored_pass) = explode(':', $user);
        if ($stored_user == $username && password_verify($password, $stored_pass)) {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit();
        }
    }
    echo "Invalid credentials!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Login</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
</body>
</html>
