<?php
session_start();
require 'db.php'; // Database connection

// Prevent back navigation after logout
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized access.";
    exit;
}
}
$user_id = $_SESSION['user_id'];

// Fetch user details
require 'db.php'; // Ensure the database connection is included

$stmt = $conn->prepare("SELECT first_name, last_name FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

$first_name = $user['first_name'] ?? 'Unknown';
$last_name = $user['last_name'] ?? 'Unknown';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Password validation
    if (strlen($new_password) < 8) {
        $error = "Password must be at least 8 characters long.";
    } elseif ($new_password !== $confirm_password) {
        $error = "Passwords do not match.";
    } elseif (!preg_match('/^[A-Z]/', $new_password)) {
        $error = "Password must start with a capital letter.";
    } elseif (!preg_match('/\d/', $new_password)) {
        $error = "Password must contain at least one number.";
    } elseif (!preg_match('/[\W_]/', $new_password)) {
        $error = "Password must contain at least one special character.";
    } else {
        // Fetch the current password from the database
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($current_password, $user['password'])) {
            $error = "Incorrect current password.";
        } else {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Update the password
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            if ($stmt->execute([$hashed_password, $user_id])) {
                $success = "Password updated successfully.";
            } else {
                $error = "Error updating password.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="favicon-32x32.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="settingscss.css">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>

    <div class="sidebar">
        <a href="Dashboard.php">
            <img src="Picsart_25-03-21_23-37-23-314.png" alt="Logo" class="logo">
        </a>
        <h2>Settings</h2>
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
            <h2>Account Settings</h2>
        </div>

        <div class="content-box">
            
            <?php
            if (isset($error)) {
                echo "<p style='color: red;'>$error</p>";
            }
            if (isset($success)) {
                echo "<p style='color: green;'>$success</p>";
            }
            ?>
          

            <div class="login-container">
                <form action="settings.php" method="POST">
                <h2>Profile Information</h2>
                <p><strong>First Name:</strong> <?php echo htmlspecialchars($first_name); ?></p>
                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($last_name); ?></p><br>

                <h2>Change Password</h2>

                <label for="password"><strong>Current Password: </strong></label><br>
                <input type="password" name="current_password" placeholder="Current Password" required><br><br>

                <label for="password"><strong>New Password:  </strong></label><br>
                <input type="password" name="new_password" placeholder="New Password" required><br><br>

                <label for="password"><strong>Confirm New Password:  </strong></label><br>
                <input type="password" name="confirm_password" placeholder="Confirm New Password" required><br><br>
                    <button type="submit">Change Password</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>