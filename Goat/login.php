<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laba_laba_doo";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $query = "SELECT id, first_name, email, password, role FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $first_name, $db_email, $hashed_password, $role);
    
    if ($stmt->fetch()) {
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $user_id;
            $_SESSION["first_name"] = $first_name;
            $_SESSION["role"] = $role;  // Set the user role here
            
            if ($role === 'admin') {
                header("Location: admin_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "The email you entered is not registered.";
    }

    $stmt->close();
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laba Laba Doo - Login</title>
    <link rel="stylesheet" href="logincss.css">
    <link rel="icon" type="image/png" href="favicon-32x32.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
</head>
<body>

<div class="login-container">
    <img src="Picsart_25-03-21_23-37-23-314.png" alt="Logo" class="logo">
    <h2>"Laundry Made Easy, Just for You!"</h2>

    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>

    <form class="login-form" action="login.php" method="POST">
        
        <div class="form-group">
            <label for="email"><strong>Email</strong></label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
        </div>
        <div class="form-group">
            <label for="password"><strong>Password</strong></label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
        </div>
        <button type="submit" class="login-button">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Sign up here</a></p>
    <p><strong>Questions?</strong> <strong>Forgot Password?</strong> Contact us @ 
        <u><strong>questions.labalabadoo@gmail.com</strong></u>
    </p>
</div>

</body>
</html>
