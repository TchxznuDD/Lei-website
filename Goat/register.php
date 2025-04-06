<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "laba_laba_doo";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST["first_name"]);
    $middle_initial = trim($_POST["middle_initial"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $pass = trim($_POST["password"]);
    $confirm_pass = trim($_POST["confirm_password"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($pass) < 8) {
        $error = "Password must be at least 8 characters long.";
    } elseif ($pass !== $confirm_pass) {
        $error = "Passwords do not match.";
    } elseif (!preg_match('/^[A-Z]/', $pass)) {
        $error = "Password must start with a capital letter.";
    } elseif (!preg_match('/\d/', $pass)) {
        $error = "Password must contain at least one number.";
    } elseif (!preg_match('/[\W_]/', $pass)) {
        $error = "Password must contain at least one special character.";
    } else {
        // Check if the email already exists
        $check_query = "SELECT email FROM users WHERE email = ?";
        $stmt = $conn->prepare($check_query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already registered. Please use another email.";
        } else {
            $stmt->close();
            $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);
            $insert_query = "INSERT INTO users (first_name, middle_initial, last_name, email, password) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sssss", $first_name, $middle_initial, $last_name, $email, $hashed_pass);

            if ($stmt->execute()) {
                // Store user data in session
                $_SESSION['first_name'] = $first_name;
                $_SESSION['user_id'] = $conn->insert_id; // Save user ID if you plan to use it for user-specific content
                
                // Provide success message
                $success = "Registration successful! You can now <a href='login.php'>login</a>.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
            
            }
        }
        $stmt->close();
    }

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="favicon-32x32.png">
    <link rel="icon" type="image/x-icon" href="favicon.ico">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="RegisterCSS.css">
    <script>
        function validateForm() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var errorMsg = "";

            if (password.length < 8) {
                errorMsg = "Password must be at least 8 characters long.";
            } else if (password !== confirmPassword) {
                errorMsg = "Passwords do not match.";
            }

            if (errorMsg) {
                document.getElementById("error-msg").innerText = errorMsg;
                return false;
            }
            
            return true;
        }
    </script>
</head>
<body>
    <div class="login-container">
        <img src="Picsart_25-03-21_23-37-23-314.png" alt="Logo" class="logo">
        <h2>"Register Now!"</h2>
        
        <?php if (isset($success)) { echo "<p style='color: green;'>$success</p>"; } ?>
        <p id="error-msg" style="color: red;"> <?php if (isset($error)) { echo $error; } ?> </p>
        
        <form class="login-form" action="register.php" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="first_name"><strong>First Name</strong></label>
                <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>
            </div>
            <div class="form-group">
                <label for="last_name"><strong>Last Name</strong></label>
                <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>
            </div>
            <div class="form-group">
                <label for="middle_name"><strong>Middle Initial</strong></label>
                <input type="text" id="middle_initial" name="middle_initial" placeholder="Enter your middle initial" required>
            </div>
            <div class="form-group">
                <label for="username"><strong>Email</strong></label>
                <input type="text" id="email" name="email" placeholder="Enter your email address" required>
            </div>
            <div class="form-group">
                <label for="password"><strong>Password</strong></label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password"><strong>Confirm Password</strong></label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Re-enter your password" required>
            </div>
            <button type="submit" class="login-button">Register</button>
        </form>

        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>