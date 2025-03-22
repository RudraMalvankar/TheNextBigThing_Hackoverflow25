<?php
session_start();

include_once('db_config.php');

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$sqll = "SELECT * FROM entries WHERE Username = '$username' AND aural > 0 AND visual > 0";
$result = $conn->query($sqll);

if ($result && $result->num_rows > 0) {
    // If user's learning style preference is found in the database
    $row = $result->fetch_assoc();
    $learning_style = $row['Preference'];

    // Redirect to appropriate page based on learning style
    switch ($learning_style) {
        case 'Aural':
            header("Location: audio.html");
            break;
        case 'Visual':
            header("Location: video.html");
            break;
        case 'Kinesthetic':
            header("Location: exp.html");
            break;
        case 'Read/Write':
            header("Location: test.html");
            break;
        default:
            // Redirect to a default page if learning style is not recognized
            header("Location: search1.php");
            break;
    }
    exit(); // Make sure to exit after the redirect
}
?>
