<?php

$marks = 0;
$brain = null;
$score = 0;
$imagee = null;
$descript = null;
$preference = null;
$Note = null;
$usernamee = null;
$newnote = null;
$newusername = null;
$newpreference = null;
$newbrainscore = null;
$newbraintype = null;
$newname = null;
$newbrainnote = null;

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    if (empty($_POST['group_a']) || empty($_POST['group_b']) || empty($_POST['group_c']) || empty($_POST['group_d']) || empty($_POST['group_e']) || empty($_POST['group_f']) || empty($_POST['group_g']) || empty($_POST['group_h']) || empty($_POST['group_i']) || empty($_POST['group_j']) || empty($_POST['group_k']) || empty($_POST['group_l']) || empty($_POST['group_m']) || empty($_POST['group_n']) || empty($_POST['group_o']) || empty($_POST['group_p']) || empty($_POST['group_q']) || empty($_POST['group_r']) || empty($_POST['group_s']) || empty($_POST['group_t']) || empty($_POST['group_u'])) {
        echo '<script>alert("Please select at least one option for each group_."); window.location.href = "questions2.php";</script>';
        exit();
    }


    if (isset($_POST["group_a"])) {
        $selectedOption = $_POST["group_a"];
        if ($selectedOption === "option1") {
            $marks++;
        }
    }

    if (isset($_POST["group_b"])) {
        $selectedOption = $_POST["group_b"];
        if ($selectedOption === "option4") {
            $marks++;
        }
    }

    if (isset($_POST["group_c"])) {
        $selectedOption = $_POST["group_c"];
        if ($selectedOption === "option6") {
            $marks++;
        }
    }

    if (isset($_POST["group_d"])) {
        $selectedOption = $_POST["group_d"];
        if ($selectedOption === "option9") {
            $marks++;
        }
    }

    if (isset($_POST["group_e"])) {
        $selectedOption = $_POST["group_e"];
        if ($selectedOption === "option11") {
            $marks++;
        }
    }

    if (isset($_POST["group_f"])) {
        $selectedOption = $_POST["group_f"];
        if ($selectedOption === "option13") {
            $marks++;
        }
    }

    if (isset($_POST["group_g"])) {
        $selectedOption = $_POST["group_g"];
        if ($selectedOption === "option14") {
            $marks++;
        }
    }

    if (isset($_POST["group_h"])) {
        $selectedOption = $_POST["group_h"];
        if ($selectedOption === "option16") {
            $marks++;
        }
    }

    if (isset($_POST["group_i"])) {
        $selectedOption = $_POST["group_i"];
        if ($selectedOption === "option18") {
            $marks++;
        }
    }

    if (isset($_POST["group_j"])) {
        $selectedOption = $_POST["group_j"];
        if ($selectedOption === "option21") {
            $marks++;
        }
    }

    if (isset($_POST["group_k"])) {
        $selectedOption = $_POST["group_k"];
        if ($selectedOption === "option23") {
            $marks++;
        }
    }

    if (isset($_POST["group_l"])) {
        $selectedOption = $_POST["group_l"];
        if ($selectedOption === "option25") {
            $marks++;
        }
    }

    if (isset($_POST["group_m"])) {
        $selectedOption = $_POST["group_m"];
        if ($selectedOption === "option26") {
            $marks++;
        }
    }

    if (isset($_POST["group_n"])) {
        $selectedOption = $_POST["group_n"];
        if ($selectedOption === "option28") {
            $marks++;
        }
    }

    if (isset($_POST["group_o"])) {
        $selectedOption = $_POST["group_o"];
        if ($selectedOption === "option30") {
            $marks++;
        }
    }

    if (isset($_POST["group_p"])) {
        $selectedOption = $_POST["group_p"];
        if ($selectedOption === "option33") {
            $marks++;
        }
    }

    if (isset($_POST["group_q"])) {
        $selectedOption = $_POST["group_q"];
        if ($selectedOption === "option35") {
            $marks++;
        }
    }

    if (isset($_POST["group_r"])) {
        $selectedOption = $_POST["group_r"];
        if ($selectedOption === "option37") {
            $marks++;
        }
    }

    if (isset($_POST["group_s"])) {
        $selectedOption = $_POST["group_s"];
        if ($selectedOption === "option38") {
            $marks++;
        }
    }

    if (isset($_POST["group_t"])) {
        $selectedOption = $_POST["group_t"];
        if ($selectedOption === "option40") {
            $marks++;
        }
    }

    if (isset($_POST["group_u"])) {
        $selectedOption = $_POST["group_u"];
        if ($selectedOption === "option42") {
            $marks++;
        }
    }
    $score = $marks;

    if ($score === null) {
        $brain = 'Score Not Available'; // Handle cases where $score is null
    } elseif ($score > 0 && $score <= 5) {
        $imagee = 'images/left brain.jpg';
        $brain = 'Strong Left Brain';
        $descript = 'Your Left brain is strong. You may like to do Maths, Logic, Planning etc. To activate your right brain we will suggest you to persue some creative activity/hobby/sports.';
    } elseif ($score > 5 && $score <= 8) {
        $brain = 'Moderate Left Brain';
        $imagee = 'images/left brain.jpg';
        $descript = "Your left brain is moderately  activated. Usually you may like to practice science, writing, planning , maths, etc. To activate right brain equally we will suggest you to pursue hobbies like Reading/Music/Dance etc.";
    } elseif ($score > 8 && $score <= 13) {
        $brain = 'Balanced Left and Right Brain';
        $imagee = 'images/white brain.png';
        $descript = "Your both left and right brain are equally dominant. Engineering study will be fun for you. The advice for enhancing brain capacity is to involve yourself in sequential as well as out of box thinking. Observing some real time cases and trying to get solution may help.";
    } elseif ($score > 13 && $score <= 16) {
        $brain = 'Moderate Right Brain';
        $imagee = 'assets/img/right brain.jpg';
        $descript = "Right brain dominant people are rare. You are one of them, Congratulations! As you have chosen to be an engineer, you need to work on Maths ,Science ,writing work. Suggest you to work on logical thinking and Science fundamentals.";
    } elseif ($score > 16) {
        $brain = 'Strong Right Brain';
        $imagee = 'images/right brain.jpg';
        $descript = "Right brain dominant people are rare. You are one of them, Congratulations! You share the ability with people like Einstein, Walt Disney,etc. As you have chosen to be an engineer, you need to work on Science fundamentals ( Maths ,Science ,logical,etc)and try to improve sequential thinking capacity by solving more logic problems.";
    } else {
        $brain = 'Invalid Score'; // Handle any other cases
    }




    if (isset($_SESSION['username'])) {
        $usernamee = $_SESSION['username'];
        require_once('db_config.php');

        $query = "UPDATE entries 
    SET Brainscore = '$score' , Braintype = '$brain' , Brainnote = '$descript'
    WHERE Username = '$usernamee' ";
        mysqli_query($conn, $query);


        $querry = "SELECT Preference FROM entries WHERE Username = '$usernamee'";
        $resultss = $conn->query($querry);

        if ($resultss->num_rows > 0) {
            $row = $resultss->fetch_assoc();
            $preference = $row['Preference'];
        }

        $querrrry = "SELECT Note FROM entries WHERE Username = '$usernamee'";
        $resultsss = $conn->query($querrrry);

        if ($resultsss->num_rows > 0) {
            $row = $resultsss->fetch_assoc();
            $Note = $row['Note'];
        }

        mysqli_close($conn);

        
    
    }

    if (isset($_SESSION['username'])) {
        $usernamee = $_SESSION['username'];
        

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }

        $newquery = "SELECT  `Email`, `Username`, `Preference`, `Note`, `Brainscore`, `Braintype` , 'Brainnote' FROM entries WHERE Username = '$usernamee'";
        $newresultss = $conn->query($newquery);
        if ($newresultss->num_rows > 0) {
            $row = $newresultss->fetch_assoc();
            $newnote = $row['Note'];
        
            $newusername = $row['Username'];
            $newpreference = $row['Preference'];
            $newbraintype = $row['Braintype'];
            $newbrainscore = $row['Brainscore'];
            $newbrainnote = $row['Brainnote'];
        }

    }

    

}





?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Learning & Brain Function</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@500;700&family=Great+Vibes&display=swap');

        body {
            background: #f9f9f9;
            text-align: center;
            padding: 50px;
        }
        
        .certificate-container {
            background: #fff;
            padding: 50px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
            border: 15px solid gold;
            width: 900px;
            margin: auto;
            position: relative;
        }

        .certificate-header img {
            max-width: 120px;
            position: absolute;
            top: 40px;
            left: 50%;
            transform: translateX(-50%);
        }

        .certificate-title {
            font-family: 'Playfair Display', serif;
            font-size: 36px;
            font-weight: bold;
            margin-top: 80px;
        }

        .certificate-subtitle {
            font-size: 20px;
            color: #555;
            font-style: italic;
            margin-bottom: 30px;
        }

        .certificate-content {
            font-size: 20px;
            font-family: 'Playfair Display', serif;
            margin: 20px 0;
        }

        .highlight {
            font-weight: bold;
            color: #d4af37;
            font-size: 22px;
        }

        .quote {
            font-style: italic;
            font-size: 18px;
            color: #777;
        }

        .brain-image {
            max-width: 180px;
            margin: 20px auto;
            display: block;
            border: 5px solid gold;
            border-radius: 50%;
        }

        .certificate-footer {
            margin-top: 30px;
            font-size: 16px;
            color: #666;
        }

        .signature {
            font-family: 'Great Vibes', cursive;
            font-size: 30px;
            color: #333;
            margin-top: 40px;
        }

        .btn-print {
            margin-top: 30px;
            font-size: 18px;
            padding: 12px 20px;
            background-color: gold;
            color: black;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-print i {
            margin-right: 5px;
        }

        /* Print Styles */
        @media print {
            .btn-print { display: none; }
            body { background: none; }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="d-flex justify-content-end">
        <form action="brainswitch.php" method="post">
            <button type="submit" class="btn btn-primary btn-lg">
                Proceed
            </button>
        </form>
        <a href="logout.php" class="btn btn-danger btn-lg">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>
</div>


<div class="certificate-container">
    <!-- Logo -->
    <div class="certificate-header">
        <img src="images/logo-results.png" alt="Logo">
    </div>

    <!-- Title -->  
    <h2 class="certificate-title">Certificate of Learning & Brain Function</h2>
    <p class="certificate-subtitle">Presented to</p>

    <!-- Name -->
    <p class="certificate-content"><span class="highlight"><?php echo $usernamee; ?></span></p>

    <p class="certificate-content">For successfully completing the assessment and being recognized as a:</p>

    <p class="certificate-content">Type of Learner: <span class="highlight"><?php echo $newpreference; ?></span></p>
    <p class="quote">"<?php echo $newnote; ?>"</p>

    <p class="certificate-content">Brain Function Type: <span class="highlight"><?php echo $newbraintype; ?></span></p>
    <p class="quote">"<?php echo $descript; ?>"</p>

    <!-- Brain Type Image -->
    <img src="<?php echo $imagee; ?>" alt="<?php echo $newbraintype; ?>" class="brain-image">

    <!-- Signature -->
    <p class="signature">Rudra - Kaivalya - Aditya - Vinesh</p>
    <p class="certificate-footer">Founder | ReThinkLabs</p>

    <!-- Print Button -->
    <button class="btn-print" onclick="window.print();">
        <i class="fa fa-print"></i> Print Certificate
    </button>
</div>

</body>
</html>

