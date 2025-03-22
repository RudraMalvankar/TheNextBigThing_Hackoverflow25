<?php
session_start();
require 'db_config.php';


\Stripe\Stripe::setApiKey(STRIPE_SECRET);

if (!isset($_GET['session_id'])) {
    header("Location: dashboard.php");
    exit();
}

$session_id = $_GET['session_id'];

try {
    $session = \Stripe\Checkout\Session::retrieve($session_id);
    $subscription_id = $session->subscription;
    $user_id = $_SESSION['user_id'];
    $amount_paid = $session->amount_total / 100; // Convert from cents

    // Store Subscription Data in Database
    $sql = "INSERT INTO subscriptions (user_id, stripe_subscription_id, amount_paid, status, created_at) VALUES (?, ?, ?, 'active', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $subscription_id, $amount_paid);
    
    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Database Error: " . $stmt->error;
    }

    $stmt->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
