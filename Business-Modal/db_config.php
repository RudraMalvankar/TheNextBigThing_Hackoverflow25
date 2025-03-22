<?php
require 'stripe-php-master/init.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bytecamp"; 

$conn = new mysqli($servername, $username, $password, $dbname);

define('STRIPE_SECRET', 'sk_test_51Nver8SBfXJhVNZFEHGU6ZBJctL2T7CpwLYMLpME6BBSzwyuXqxLfLmh4lpZxB3hJt17xAqRAzK86XML4hadxTTx00qhK9xDDA');
define('STRIPE_PUBLISHABLE', 'pk_test_51Nver8SBfXJhVNZFDJLl6beluy5mv5jfMImMEdrNxhPetSjOnoAfEykskhXmWXwlj5UfOjuIJ86ZBKyDE8Ko274C00WHHjC0jX');

define('STRIPE_WEBHOOK_SECRET', 'whsec_4be45d40ae4483b5485040bbbd1f4531c6ea1682c0b85aa2ee9ddb58ec3f82a5');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
 } 
//  else {
//     echo "Database connected successfully!";
// }

?>
