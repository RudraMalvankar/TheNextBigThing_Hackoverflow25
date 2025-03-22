<?php
session_start();
require 'db_config.php';
require 'stripe-php-master/init.php';

\Stripe\Stripe::setApiKey(STRIPE_SECRET);

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    die("Please log in first.");
}

$username = $_SESSION['username'];

// ✅ Fetch user ID from the database using username
$stmt = $conn->prepare("SELECT * FROM entries WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found.");
}

$user_id = $user['user_id'];  // ✅ Now we have user_id
$email = $user['email'];
$customer_id = $user['stripe_customer_id'];

// ✅ If user doesn't have a Stripe Customer ID, create one
if (!$customer_id) {
    $customer = \Stripe\Customer::create([
        'email' => $email,
        'name'  => $username
    ]);

    // ✅ Store Stripe Customer ID in DB
    $customer_id = $customer->id;
    $stmt = $conn->prepare("UPDATE entries SET stripe_customer_id = ? WHERE user_id = ?");
    $stmt->bind_param("si", $customer_id, $user_id);
    $stmt->execute();
}

// ✅ Create Subscription with Free Trial
try {
    $subscription = \Stripe\Subscription::create([
        'customer' => $customer_id,
        'items' => [['price' => 'price_1R2SyBSBfXJhVNZFvKXI85ly']], // Replace with actual Stripe price ID
        'trial_period_days' => 7,
    ]);

    // ✅ Store subscription ID
    $stmt = $conn->prepare("UPDATE entries SET stripe_subscription_id = ? WHERE user_id = ?");
    $stmt->bind_param("si", $subscription->id, $user_id);
    $stmt->execute();

    // ✅ Redirect user to confirmation page
    header("Location: subscription_success.php");
    exit();
} catch (Exception $e) {
    die("Error: " . $e->getMessage());
}
?>
