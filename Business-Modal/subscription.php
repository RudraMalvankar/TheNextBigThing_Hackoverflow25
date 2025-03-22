

<?php
session_start();
require 'db_config.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Stripe API key
\Stripe\Stripe::setApiKey(STRIPE_SECRET);

$user_id = $_SESSION['user_id'];

// ✅ Fetch user email from the database
$stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Error: User not found in database.");
}

$email = $user['email']; // ✅ Get correct email
$_SESSION['email'] = $email; // ✅ Store in session for future use

// ✅ Create a new Stripe Customer with the correct email
$customer = \Stripe\Customer::create([
    'email' => $email,
]);

try {
    // ✅ Create Stripe Checkout Session with a 7-day trial
    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price' => 'price_1R2SyBSBfXJhVNZFvKXI85ly', // Replace with your Stripe Price ID
            'quantity' => 1,
        ]],
        'mode' => 'subscription',
        'customer_email' => $email, // ✅ Ensures correct email in Stripe Checkout
        'billing_address_collection' => 'required', // Forces billing address input
        'shipping_address_collection' => [
            'allowed_countries' => ['IN'], // Modify as needed
        ],
        // 'subscription_data' => [
        //     'trial_period_days' => 7, // ✅ Adds a 7-day trial period
        // ],
        'success_url' => 'http://localhost/bytecamp/success.php?session_id={CHECKOUT_SESSION_ID}',
        'cancel_url' => 'http://localhost/bytecamp/cancel.php',
    ]);

    // ✅ Redirect user to Stripe Checkout
    header("Location: " . $checkout_session->url);
    exit();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>




<!-- // recuring pice = price_1R2SyBSBfXJhVNZFvKXI85ly -->
