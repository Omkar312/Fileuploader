<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $users_file = 'users.txt';

    // Check for duplicate username
    $users = file($users_file, FILE_IGNORE_NEW_LINES);
    foreach ($users as $user) {
        list($stored_user, ) = explode(':', $user);
        if ($stored_user == $username) {
            die("Username already exists! <a href='register.php'>Try again</a>");
        }
    }

    // Register the user
    file_put_contents($users_file, "$username:$password\n", FILE_APPEND);
    mkdir("uploads/$username", 0755, true);
    echo "Registration successful! <a href='login.php'>Login</a>";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Register</h1>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Register</button>
    </form>
</body>
</html>
