<?php
session_start();
if (!isset($_SESSION['pilgrim_id'])) {
    header('Location: index.php');
    exit();
}

// Include necessary files
include_once '../config/database.php';
include_once '../src/models/Pilgrim.php';

// Get the pilgrim data
$database = new Database();
$db = $database->getConnection();
$pilgrim = new Pilgrim($db);
$pilgrim->id = $_SESSION['pilgrim_id'];
$pilgrim->getPilgrimByEmail();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Welcome, <?php echo htmlspecialchars($pilgrim->pil_name); ?></h2>
    <p>Email: <?php echo htmlspecialchars($pilgrim->email); ?></p>
    <p>Account Number: <?php echo htmlspecialchars($pilgrim->account_number); ?></p>
    <a href="../src/controllers/AuthController.php?logout=true">Logout</a>
</body>
</html>
