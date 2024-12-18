<?php
session_start();
if (!isset($_SESSION['username'])) header("Location: login.php");

$username = $_SESSION['username'];
$user_dir = "uploads/$username/";

if (!is_dir($user_dir)) {
    mkdir($user_dir, 0777, true);
}

$files = glob($user_dir . "*");

// Handle file deletion
if (isset($_GET['delete'])) {
    $file_to_delete = $user_dir . basename($_GET['delete']);
    if (file_exists($file_to_delete)) {
        unlink($file_to_delete); // Delete the file
        header("Location: dashboard.php"); // Refresh the page after deletion
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>

    <!-- Search Bar -->
    <div class="search-bar">
        <input type="text" id="searchInput" placeholder="Search files...">
    </div>

    <!-- File Upload Form -->
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file" required>
        <button type="submit">Upload File</button>
    </form>

    <!-- File List -->
    <h2>Your Files</h2>
    <ul class="file-list" id="fileList">
        <?php foreach ($files as $file): ?>
            <li data-name="<?php echo basename($file); ?>">
                <span><?php echo basename($file); ?></span>
                <div>
                    <!-- Download Link -->
                    <a href="download.php?file=<?php echo basename($file); ?>" style="color: #ff4081; text-decoration: none; margin-right: 10px;">
                        Download
                    </a>
                    <!-- Delete Button -->
                    <a href="?delete=<?php echo basename($file); ?>" style="color: crimson; text-decoration: none;">
                        Delete
                    </a>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>

    <!-- Logout Button -->
    <div class="logout">
        <a href="logout.php"><button>Logout</button></a>
    </div>

    <!-- JavaScript for Search -->
    <script>
        const searchInput = document.getElementById('searchInput');
        const fileList = document.getElementById('fileList');
        const files = fileList.querySelectorAll('li');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.toLowerCase();
            files.forEach(file => {
                const fileName = file.getAttribute('data-name').toLowerCase();
                if (fileName.includes(query)) {
                    file.style.display = 'flex';
                } else {
                    file.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>
