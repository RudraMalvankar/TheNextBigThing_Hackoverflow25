<?php
session_start();
require 'config.php';
require 'vendor/autoload.php';

\Stripe\Stripe::setApiKey(STRIPE_SECRET);

if (!isset($_GET['session_id'])) {
    die("Invalid request.");
}

$session_id = $_GET['session_id'];

try {
    $session = \Stripe\Checkout\Session::retrieve($session_id);
    $stripe_customer_id = $session->customer;
    $subscription_id = $session->subscription;
    $amount_paid = $session->amount_total / 100;
    $plan_id = $session->metadata->plan_id;
    
    // Insert into subscriptions table
    $stmt = $conn->prepare("INSERT INTO subscriptions (user_id, stripe_customer_id, stripe_subscription_id, plan_id, amount_paid, status) VALUES (?, ?, ?, ?, ?, 'active')");
    $stmt->bind_param("isssd", $_SESSION['user_id'], $stripe_customer_id, $subscription_id, $plan_id, $amount_paid);
    $stmt->execute();
    $stmt->close();

    $_SESSION['subscription_active'] = true;
    header("Location: dashboard.php");
    exit();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
