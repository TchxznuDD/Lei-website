<?php
session_start();


if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}


$first_name = isset($_SESSION["first_name"]) ? htmlspecialchars($_SESSION["first_name"]) : "User";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    
    <!-- Favicons -->
    <link rel="icon" type="image/png" href="favicon-32x32.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- Stylesheet -->
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<div class="sidebar">
    <a href="dashboard.php">
        <img src="Picsart_25-03-21_23-37-23-314.png" alt="Logo" class="logo">
    </a>
    <h2>Home</h2>
    <ul>
        <li><a href="dashboard.php"><i class="fa fa-home"></i><strong> Home</strong></a></li>
        <li><a href="orders.php"><i class="fa fa-shopping-cart"></i><strong> Orders</strong></a></li>
        <li><a href="reports.php"><i class="fa fa-file"></i><strong> Reports</strong></a></li>
        <li><a href="settings.php"><i class="fa fa-cog"></i><strong> Settings</strong></a></li>
        <li><a href="logout.php"><i class="fa fa-sign-out"></i><strong> Logout</strong></a></li>
    </ul>
</div>

<div class="main-content">
    <div class="navbar">
        <h1>Welcome, <?php echo $first_name; ?>!</h1>
    </div>

    <div class="content-box">
        <h3>📌 Quick Actions</h3>
        <p>Manage your orders, view reports, and customize settings.</p>
        <p>Coming Soon sa Functions</p>
    </div>
</div>

</body>
</html>
