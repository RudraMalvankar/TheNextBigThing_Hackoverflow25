<?php
session_start();
include 'db_config.php'; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT id, name, email, password FROM admin WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $name, $db_email, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION["admin_id"] = $id;
            $_SESSION["name"] = $name;  // Store name in session
            $_SESSION["email"] = $db_email; // Store email in session
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found!";
    }

    $stmt->close();
    $conn->close();
}
?>



    
 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Brainify Learning Login">
    <meta name="author" content="TheNextBigThing">
    <title>Brainify Learning - Log In</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="icon" href="Component 1.png">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #45a049, #4CAF50);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            padding: 50px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-10px);
        }

        h1 {
            margin-bottom: 15px;
            font-size: 32px;
            color: #333;
        }

        p {
            font-size: 16px;
            color: #666;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-control-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .form-control-input:focus {
            border-color: #4CAF50;
            outline: none;
        }

        .label-control {
            position: absolute;
            top: -10px;
            left: 12px;
            font-size: 14px;
            color: #888;
            transition: 0.3s;
        }

        .form-control-submit-button {
            width: 100%;
            padding: 12px;
            background-color: #4CAF50;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease;
        }

        .form-control-submit-button:hover {
            background-color: #45a049;
        }

        .white {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .white:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Log In</h1>
        <p>Don't have an account? <a class="white" href="registration.php">Sign Up</a></p>
        <form id="logInForm" method="POST" action="index.php">
    <div class="form-group">
        <input type="email" class="form-control-input" id="email" name="email" required>
        <label class="label-control" for="email">Email</label>
    </div>
    <div class="form-group">
        <input type="password" class="form-control-input" id="password" name="password" required>
        <label class="label-control" for="password">Password</label>
    </div>
    <div class="form-group">
        <button type="submit" class="form-control-submit-button">LOG IN</button>
    </div>
</form>

    </div>
</body>
</html>

