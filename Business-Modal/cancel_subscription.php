<?php
session_start();
require 'db_config.php';


\Stripe\Stripe::setApiKey(STRIPE_SECRET);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['subscription_id'])) {
    $subscription_id = $_POST['subscription_id'];

    try {
        // Cancel subscription on Stripe
        $subscription = \Stripe\Subscription::retrieve($subscription_id);
        $subscription->cancel();

        // Update database record
        $stmt = $conn->prepare("UPDATE subscriptions SET status = 'canceled' WHERE subscription_id = ?");
        $stmt->bind_param("s", $subscription_id);
        $stmt->execute();
        $stmt->close();

        $_SESSION['message'] = "Subscription canceled successfully.";
    } catch (Exception $e) {
        $_SESSION['message'] = "Error: " . $e->getMessage();
    }
}

header("Location: dashboard.php");
exit();
?>
