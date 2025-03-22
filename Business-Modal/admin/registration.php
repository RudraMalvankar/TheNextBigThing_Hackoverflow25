<?php
require_once('db_config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirm_password']);

    // Check if passwords match
    if ($password != $confirmPassword) {
        echo "Passwords do not match!";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);  // Hash the password

        $sql = "INSERT INTO admin (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>Registration</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #4CAF50, #2E7D32);
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }

        .form-container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-8px);
            }
        }

        h1 {
            margin-bottom: 10px;
            color: #333;
        }

        p {
            color: #666;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
            text-align: left;
        }

        .form-control-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 6px;
            outline: none;
            transition: 0.3s;
            font-size: 16px;
        }

        .form-control-input:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.5);
        }

        .form-control-submit-button {
            width: 100%;
            padding: 12px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .form-control-submit-button:hover {
            background: #388E3C;
        }

        .form-container a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Sign Up</h1>
        <p>Fill out the form below to sign up for Brainify. Already have an account? <a href="index.php">Log In</a></p>
        <form id="registrationForm" method="POST" action="registration.php">
            <div class="form-group">
                <input type="text" class="form-control-input" id="name" name="name" required placeholder="Enter Your Name">
            </div>
            <div class="form-group">
                <input type="email" class="form-control-input" id="email" name="email" required placeholder="Email">
            </div>
            <div class="form-group">
                <input type="password" class="form-control-input" id="password" name="password" required placeholder="Password">
            </div>
            <div class="form-group">
                <input type="password" class="form-control-input" id="confirm_password" name="confirm_password" required placeholder="Confirm Password">
            </div>
            <div class="form-group">
                <button type="submit" class="form-control-submit-button">SIGN UP</button>
            </div>
        </form>
    </div>
</body>
</html>
