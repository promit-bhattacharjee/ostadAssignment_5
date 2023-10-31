<?php
session_start();

if (!isset($_SESSION['userEmail'])) {
    header("Location: login.php"); 
    exit;
}
if ($_SESSION['role'] === 'admin') {
    header("Location: admin.php"); 
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Page</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['userName']; ?></h1>
    <h2>User Page</h2>
    <p>View user-specific content and perform user-specific operations here.</p>
</body>
</html>
