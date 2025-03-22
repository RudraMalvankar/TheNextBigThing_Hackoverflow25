<?php
session_start();
require_once('db_config.php');


\Stripe\Stripe::setApiKey(STRIPE_SECRET);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["plan"], $_POST["customer_id"])) {
    $price_id = $_POST["plan"];
    $customer_id = $_POST["customer_id"];

    try {
        // Create Checkout Session
        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'customer' => $customer_id,
            'line_items' => [[
                'price' => $price_id,
                'quantity' => 1,
            ]],
            'success_url' => 'http://localhost/bytecamp/success.php?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => 'http://localhost/bytecamp/cancel.php',
        ]);

        // Redirect to Stripe checkout
        header("Location: " . $session->url);
        exit();
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
