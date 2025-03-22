<?php
session_start();
require_once('db_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);

    $sql = "SELECT id, name, password FROM users WHERE name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id']; // Store user ID
            $_SESSION['name'] = $row['name'];

            header("Location: subscription.php");
            exit();
        } else {
            echo '<script>alert("Invalid name or password.");</script>';
        }
    } else {
        echo '<script>alert("Invalid name or password.");</script>';
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
    <meta name="description" content="Rethinklab Learning Login">
    <meta name="author" content="TheNextBigThing">
    <title>Rethinklab Learning - Log In</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="icon" href="Component 1.png">
    <style>
        /* General Page Styling */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom, #1d00fe 0%, rgb(177, 167, 255) 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Form Container */
        .form-container {
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Title */
        h1 {
            font-size: 28px;
            color: #1d00fe;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* Sign-up Text */
        p {
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
        }

        /* Link Styling */
        .white {
            color: #1d00fe;
            text-decoration: none;
            font-weight: bold;
        }

        .white:hover {
            text-decoration: underline;
        }

        /* Form Inputs */
        .form-group {
            margin-bottom: 20px;
            position: relative;
            text-align: left;
        }

        .form-control-input {
            width: 100%;
            padding: 12px;
            border: 2px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 5px;
        }

        .form-control-input:focus {
            border-color: #1d00fe;
            box-shadow: 0 0 8px rgba(97, 76, 175, 0.5);
            outline: none;
        }

        /* Labels */
        .label-control {
            font-size: 14px;
            color: #555;
            font-weight: bold;
        }

        /* Login Button */
        .form-control-submit-button {
            width: 100%;
            padding: 12px;
            background-color: #1d00fe;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s ease;
            font-weight: bold;
        }

        .form-control-submit-button:hover {
            background-color: rgb(102, 83, 252);
        }

        /* Responsive Styling */
        @media (max-width: 780px) {
            .form-container {
                padding: 30px;
                max-width: 90%;
            }

            h1 {
                font-size: 24px;
            }

            p {
                font-size: 14px;
            }

            .form-control-input {
                font-size: 14px;
                padding: 10px;
            }

            .form-control-submit-button {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <main class="form-container">
        <h1>Log In</h1>
        <p>You don't have an account? Then please  
            <a class="white" href="registration.php">Sign Up</a>
        </p>

        <form id="logInForm" method="POST" action="login.php">
            <fieldset>
                <legend class="visually-hidden">Login Details</legend>

                <div class="form-group">
                    <label class="label-control" for="username">Name</label>
                    <input type="text" class="form-control-input" id="username" name="username" required>

                </div>

                <div class="form-group">
                    <label class="label-control" for="password">Password</label>
                    <input type="password" class="form-control-input" id="password" name="password" required>
                </div>

                <div class="form-group">
                    <button type="submit" class="form-control-submit-button">LOG IN</button>
                </div>
            </fieldset>
        </form>
    </main>
</body>
</html>

