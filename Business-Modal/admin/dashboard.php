<?php
session_start();
require_once('db_config.php');

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

$name = $_SESSION['name'];
$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            display: flex;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            background: #343a40;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        .sidebar h2 {
            margin-bottom: 20px;
            font-size: 1.5rem;
            text-align: center;
        }
        .sidebar a {
            display: block;
            padding: 10px;
            margin: 5px 0;
            background: #495057;
            color: white;
            text-decoration: none;
            text-align: center;
            border-radius: 5px;
            cursor: pointer;
        }
        .sidebar a:hover {
            background: #6c757d;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            background: #007bff;
            color: white;
            border-radius: 5px;
        }
        .logout-btn {
            padding: 8px 15px;
            background: red;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn:hover {
            background: darkred;
        }
        iframe {
            width: 100%;
            height: 85vh;
            border: none;
            background: white;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <h2>Admin Panel</h2>
        <a onclick="loadPage('home.php')">Dashboard</a>
        <a onclick="loadPage('users.php')">Users</a>
        <a onclick="loadPage('stripe.php')">Stripe </a>
    </div>

    <div class="main-content">
        <div class="header">
            <h2>Welcome, <?php echo htmlspecialchars($name); ?>!</h2>
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>

        <iframe id="content-frame" src=""></iframe>
    </div>

    <script>
        function loadPage(page) {
            document.getElementById('content-frame').src = page;
        }
    </script>

</body>
</html>
