<?php
session_start();
if (!isset($_SESSION['username'])) header("Location: login.php");

$file = $_GET['file'];
$user_dir = "uploads/" . $_SESSION['username'] . "/";
$file_path = $user_dir . $file;

if (file_exists($file_path)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
    readfile($file_path);
    exit();
}
echo "File not found!";
?>
