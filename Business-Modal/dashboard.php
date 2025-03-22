<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ✅ Fetch user details
$user_stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$user_stmt->bind_param("i", $user_id);
$user_stmt->execute();
$user_stmt->bind_result($user_name, $user_email);
$user_stmt->fetch();
$user_stmt->close();

// ✅ Fetch subscription details
$sub_stmt = $conn->prepare("SELECT stripe_subscription_id, status, amount_paid, created_at, trial_end FROM subscriptions WHERE user_id = ? ORDER BY created_at DESC LIMIT 1");
$sub_stmt->bind_param("i", $user_id);
$sub_stmt->execute();
$sub_stmt->bind_result($subscription_id, $status, $amount_paid, $created_at, $trial_end);
$sub_stmt->fetch();
$sub_stmt->close();

if ($status !== 'active') {
    header("Location: subscription.php");
    exit();
}

// ✅ Calculate next payment date
$next_payment_date = $trial_end ? date("Y-m-d", $trial_end) : date("Y-m-d", strtotime($created_at . " +1 month"));

// ✅ Calculate days left
$days_left = (strtotime($next_payment_date) - time()) / (60 * 60 * 24);
$days_left = max(0, ceil($days_left));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Bytecamp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7fc;
            font-family: 'Inter', sans-serif;
        }
        .container {
            max-width: 600px;
            margin-top: 50px;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
            background: #ffffff;
        }
        .status-badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 14px;
        }
        .status-active {
            background-color: #28a745;
            color: #ffffff;
        }
        .status-inactive {
            background-color: #dc3545;
            color: #ffffff;
        }
        .btn-custom {
            padding: 10px 15px;
            border-radius: 8px;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-danger {
            background-color: #dc3545;
            border: none;
        }
        .btn-danger:hover {
            background-color: #b02a37;
        }
        .btn-secondary {
            background-color: #6c757d;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card p-4 text-center">
        <h3 class="fw-bold">Welcome, <?= htmlspecialchars($user_name) ?>! 🎉</h3>
        <p class="text-muted"><?= htmlspecialchars($user_email) ?></p>

        <hr>

        <h5 class="fw-semibold">Subscription Details</h5>
        <ul class="list-group list-group-flush text-start">
            <li class="list-group-item">
                <strong>Status:</strong> 
                <span class="status-badge <?= ($status === 'active') ? 'status-active' : 'status-inactive' ?>">
                    <?= ucfirst($status) ?>
                </span>
            </li>
            <li class="list-group-item"><strong>Subscription ID:</strong> <?= htmlspecialchars($subscription_id) ?></li>
            <li class="list-group-item"><strong>Amount Paid:</strong> ₹<?= number_format($amount_paid, 2) ?></li>
            <li class="list-group-item"><strong>Next Payment Date:</strong> <?= $next_payment_date ?> 
                <span class="text-muted">(in <?= $days_left ?> days)</span>
            </li>
        </ul>

        <div class="mt-4 d-flex justify-content-between">
            <a href="logout.php" class="btn btn-secondary btn-custom">Logout</a>
            <button class="btn btn-danger btn-custom" id="cancelSubscription">Cancel Subscription</button>
        </div>
    </div>
</div>

<script>
document.getElementById('cancelSubscription').addEventListener('click', function() {
    if (confirm("Are you sure you want to cancel your subscription?")) {
        window.location.href = "cancel_subscription.php";
    }
});
</script>

</body>
</html>
