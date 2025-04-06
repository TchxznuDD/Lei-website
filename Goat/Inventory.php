<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>


<html lang="en">
<head>
<link rel="icon" type="image/png" href="favicon-32x32.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <link rel="stylesheet" href="Dashboard_Admin.css">

    <div class="sidebar">
    <a href="admin_dashboard.php">
    <img src="Picsart_25-03-21_23-37-23-314.png" alt="Logo" class="logo">
</a>
    <h2>Inventory</h2>
    <ul>
        <li><a href="Admin_dashboard.php"><i class="fa fa-home"></i><strong> Manage Users</strong></a></li>
        <li><a href="Income.php"><i class="fa fa-shopping-cart"></i><strong> Income</strong></a></li>
        <li><a href="Inventory.php"><i class="fa fa-file"></i><strong>Inventory</strong></a></li>
        <li><a href="settings2.php"><i class="fa fa-cog"></i><strong> Settings</strong></a></li>
        <li><a href="logout.php"><i class="fa fa-sign-out"></i><strong> Logout</strong></a></li>
    </ul>
</div>
</body>
</html>

    <div class="main-content">
        <div class="navbar">
            <h1>Welcome, Admin!</h1>
        </div>
        

        <div class="content-box">
            <h3>Hi ulit!</h3>
            <p>Wala Laman Huhu</p>
            <p>Coming Soon, Sana </p>
        </div>
    </div>

</body>
</html>