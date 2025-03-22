<?php
require 'db_config.php';
require 'stripe-php-master/init.php';
file_put_contents('debug_log.txt', print_r($_SERVER, true), FILE_APPEND);

// Set your Stripe secret key
\Stripe\Stripe::setApiKey(STRIPE_SECRET);

// Webhook secret from Stripe dashboard
$endpoint_secret = 'whsec_4be45d40ae4483b5485040bbbd1f4531c6ea1682c0b85aa2ee9ddb58ec3f82a5';


// Retrieve the request body
$payload = @file_get_contents('php://input');
$sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?? '';

// Debug: Check if signature exists
if (!$sig_header) {
    file_put_contents('webhook_errors.txt', "Missing Stripe Signature\n", FILE_APPEND);
    http_response_code(400);
    exit();
}

// Debug: Check if payload is empty
if (!$payload) {
    file_put_contents('webhook_errors.txt', "Empty Payload Received\n", FILE_APPEND);
    http_response_code(400);
    exit();
}

// Verify webhook signature
try {
    $event = \Stripe\Webhook::constructEvent($payload, $sig_header, $endpoint_secret);
} catch (\UnexpectedValueException $e) {
    file_put_contents('webhook_errors.txt', "Invalid payload: " . $e->getMessage() . "\n", FILE_APPEND);
    http_response_code(400);
    exit();
} catch (\Stripe\Exception\SignatureVerificationException $e) {
    file_put_contents('webhook_errors.txt', "Invalid signature: " . $e->getMessage() . "\n", FILE_APPEND);
    http_response_code(400);
    exit();
}

// Log webhook event for debugging
file_put_contents('webhook_log.txt', "Received event: " . $event->type . "\n", FILE_APPEND);

// Database connection
$conn = new mysqli("localhost", "root", "", "bytecamp");

// Check connection
if ($conn->connect_error) {
    file_put_contents('webhook_errors.txt', "Database connection failed: " . $conn->connect_error . "\n", FILE_APPEND);
    http_response_code(500);
    exit();
}

// Handle the event type
switch ($event->type) {
    case 'customer.subscription.created':
    case 'invoice.payment_succeeded':
        $customerId = $event->data->object->customer;
        $subscriptionId = $event->data->object->id;

        // Debugging log
        file_put_contents('webhook_log.txt', "Processing event for Customer: $customerId, Subscription: $subscriptionId\n", FILE_APPEND);

        // Check if user exists in database
        $stmt = $conn->prepare("SELECT * FROM entries WHERE stripe_customer_id = ?");
        $stmt->bind_param("s", $customerId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user) {
            // Update user's subscription status
            $stmt = $conn->prepare("UPDATE entries SET stripe_subscription_id = ?, is_subscribed = 1 WHERE stripe_customer_id = ?");
            $stmt->bind_param("ss", $subscriptionId, $customerId);
            $stmt->execute();
        }
        break;

    default:
        file_put_contents('webhook_log.txt', "Unhandled event type: " . $event->type . "\n", FILE_APPEND);
}

// Close database connection
$conn->close();

http_response_code(200); // Respond with HTTP 200 OK
?>
