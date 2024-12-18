<?php
session_start();
if (!isset($_SESSION['username'])) header("Location: login.php");

$user_dir = "uploads/" . $_SESSION['username'] . "/";
if ($_FILES['file']['error'] == 0) {
    $filename = basename($_FILES['file']['name']);
    move_uploaded_file($_FILES['file']['tmp_name'], $user_dir . $filename);
    header("Location: dashboard.php");
} else {
    echo "File upload failed.";
}
?>
