<?php
session_start();

// Redirect to login if not logged in
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$first_name = isset($_SESSION["first_name"]) ? htmlspecialchars($_SESSION["first_name"]) : "User";

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
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

</head>
<body>

<div class="sidebar">
    <a href="Dashboard.php">
    <img src="Picsart_25-03-21_23-37-23-314.png" alt="Logo" class="logo">
</a>
    <h2>Orders</h2>
    <ul>
        <li><a href="Dashboard.php"><i class="fa fa-home"></i><strong> Home</strong></a></li>
        <li><a href="orders.php"><i class="fa fa-shopping-cart"></i><strong> Orders</strong></a></li>
        <li><a href="reports.php"><i class="fa fa-file"></i><strong> Reports</strong></a></li>
        <li><a href="settings.php"><i class="fa fa-cog"></i><strong> Settings</strong></a></li>
        <li><a href="logout.php"><i class="fa fa-sign-out"></i><strong> Logout</strong></a></li>
    </ul>
</div>

    <div class="main-content">
        <div class="navbar">
            <h2>Welcome, <?php echo htmlspecialchars($first_name); ?>!</h2>
        </div>

        <div class="content-box">
            <h3>📌 Reports</h3>
            <p>Idk</p>
            <p>Coming Soon sa Functions</p>
        </div>
    </div>

</body>
</html>
