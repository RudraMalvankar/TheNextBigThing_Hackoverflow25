<html>

<head>
    <title>Test Your Brain </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>

<body>
<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
session_start();
$_SESSION['form_submitted'] = true;

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "VARK";  // vidhidb -> vp

    $conn = mysqli_connect($servername, $username, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $sqll = "SELECT * FROM entries WHERE Username = '$username' AND Brainscore > 0";
    $resultt = $conn->query($sqll);

    mysqli_close($conn);
}
?>

    <style>
        body {
            background-image: url('color brain.jpeg');
            background-size: cover;
            background-color: #FEFCFF;
        }

        .container {
            background-color: rgba(240, 232, 232, 0.566);
            padding: 20px;
            border-radius: 10px;
            margin-top: 50px;
            margin: 0 auto;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .form-check-label {
            font-weight: normal;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0069d9;
        }

        .logout-button {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .col-md-12.text-center p {
            color: rgb(0, 0, 0);
        }
        
    </style>

    <a href="?logout=true" class="btn btn-danger logout-button">Logout</a>
    <br><br><br>

    <div class="container">
        <h2>
            <img src="images/logo-brain.png" style="max-width: 100%; height: auto;">
        </h2>
        <form method="post" action="Finalresult.php">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>Group</th>
                        <th>Option 1</th>
                        <th>Option 2</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>A</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_a" id="option1" value="option1">
                                <label class="form-check-label" for="option1">
                                    I enjoy working on tasks that involve precision and attention to detail.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_a" id="option2" value="option2">
                                <label class="form-check-label" for="option2">
                                    I enjoy tasks that allow for creative thinking and big-picture ideas.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>B</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_b" id="option3" value="option3">
                                <label class="form-check-label" for="option3">
                                    I prefer structured and well-organized environments.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_b" id="option4" value="option4">
                                <label class="form-check-label" for="option4">
                                    I thrive in flexible and spontaneous environments.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>C</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_c" id="option5" value="option5">
                                <label class="form-check-label" for="option5">
                                    I enjoy tasks that involve analytical thinking and logic.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_c" id="option6" value="option6">
                                <label class="form-check-label" for="option6">
                                    I enjoy tasks that focus on emotional connection and empathy.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>D</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_d" id="option7" value="option7">
                                <label class="form-check-label" for="option7">
                                    I prefer clear rules and guidelines when completing a task.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_d" id="option8" value="option8">
                                <label class="form-check-label" for="option8">
                                    I like tasks that leave room for interpretation and creativity.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>E</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_e" id="option9" value="option9">
                                <label class="form-check-label" for="option9">
                                    I am comfortable working on my own to achieve goals.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_e" id="option10" value="option10">
                                <label class="form-check-label" for="option10">
                                    I thrive when working collaboratively with a team.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>F</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_f" id="option11" value="option11">
                                <label class="form-check-label" for="option11">
                                    I enjoy tasks that are grounded in facts and data.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_f" id="option12" value="option12">
                                <label class="form-check-label" for="option12">
                                    I enjoy tasks that allow me to explore abstract ideas and theories.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>G</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_g" id="option13" value="option13">
                                <label class="form-check-label" for="option13">
                                    I like to focus on one task at a time.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_g" id="option14" value="option14">
                                <label class="form-check-label" for="option14">
                                    I enjoy multitasking and handling multiple responsibilities.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>H</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_h" id="option15" value="option15">
                                <label class="form-check-label" for="option15">
                                    I prefer to follow tried-and-tested methods to complete tasks.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_h" id="option16" value="option16">
                                <label class="form-check-label" for="option16">
                                    I like experimenting with new and innovative ways to complete tasks.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>I</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_i" id="option17" value="option17">
                                <label class="form-check-label" for="option17">
                                    I enjoy working in environments where everything is clear and orderly.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_i" id="option18" value="option18">
                                <label class="form-check-label" for="option18">
                                    I thrive in environments where ambiguity and chaos are the norm.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>J</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_j" id="option19" value="option19">
                                <label class="form-check-label" for="option19">
                                    I prefer consistent and routine tasks.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_j" id="option20" value="option20">
                                <label class="form-check-label" for="option20">
                                    I enjoy tasks that vary and offer something new every time.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>K</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_k" id="option21" value="option21">
                                <label class="form-check-label" for="option21">
                                    I prefer working in a competitive environment.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_k" id="option22" value="option22">
                                <label class="form-check-label" for="option22">
                                    I thrive in a collaborative and supportive environment.
                                </label>
                            </div>
                        </td>
                    </tr>
                     <tr>
                        <td>L</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_l" id="option23" value="option23">
                                <label class="form-check-label" for="option23">
                                    I prefer to work in a predictable and controlled environment.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_l" id="option24" value="option24">
                                <label class="form-check-label" for="option24">
                                    I enjoy working in an environment that is unpredictable and flexible.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>M</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_m" id="option25" value="option25">
                                <label class="form-check-label" for="option25">
                                    I enjoy having clear roles and responsibilities in a team.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_m" id="option26" value="option26">
                                <label class="form-check-label" for="option26">
                                    I prefer a more flexible approach to roles in a team.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>N</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_n" id="option27" value="option27">
                                <label class="form-check-label" for="option27">
                                    I prefer to work on tasks that are clearly defined.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_n" id="option28" value="option28">
                                <label class="form-check-label" for="option28">
                                    I enjoy working on tasks that allow for a lot of flexibility and creativity.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>O</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_o" id="option29" value="option29">
                                <label class="form-check-label" for="option29">
                                    I prefer clear and logical steps when working through tasks.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_o" id="option30" value="option30">
                                <label class="form-check-label" for="option30">
                                    I prefer a more flexible and adaptive approach when completing tasks.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>P</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_p" id="option31" value="option31">
                                <label class="form-check-label" for="option31">
                                    I prefer detailed instructions before starting a task.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_p" id="option32" value="option32">
                                <label class="form-check-label" for="option32">
                                    I enjoy figuring things out as I go along with a task.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Q</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_q" id="option33" value="option33">
                                <label class="form-check-label" for="option33">
                                    I like to stick to my plans and avoid last-minute changes.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_q" id="option34" value="option34">
                                <label class="form-check-label" for="option34">
                                    I enjoy being flexible and adapting plans as needed.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>R</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_r" id="option35" value="option35">
                                <label class="form-check-label" for="option35">
                                    I prefer tasks that are well-organized and structured.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_r" id="option36" value="option36">
                                <label class="form-check-label" for="option36">
                                    I enjoy tasks that are more open-ended and spontaneous.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>S</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_s" id="option37" value="option37">
                                <label class="form-check-label" for="option37">
                                    I enjoy working with numbers and data analysis.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_s" id="option38" value="option38">
                                <label class="form-check-label" for="option38">
                                    I enjoy working with people and social interactions.
                                </label>
                            </div>
                        </td>
                    </tr> 
                    <tr>
                        <td>T</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_t" id="option45" value="option45">
                                <label class="form-check-label" for="option45">
                                    I am comfortable taking a logical and objective approach to decision-making.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_t" id="option46" value="option46">
                                <label class="form-check-label" for="option46">
                                    I tend to rely on my intuition and feelings when making decisions.
                                </label>
                            </div>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>U</td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_u" id="option47" value="option47">
                                <label class="form-check-label" for="option47">
                                    I prefer clearly defined roles and expectations when working in a group.
                                </label>
                            </div>
                        </td>
                        <td style="text-align: justify; width: 48%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="group_u" id="option48" value="option48">
                                <label class="form-check-label" for="option48">
                                    I enjoy working in groups where roles and responsibilities can evolve organically.
                                </label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <button type="submit" style="padding: 10px 20px; background-color: #6c5ce7; color: white; border: none; border-radius: 5px; font-size: 16px;">
        Go to Question 2
    </button>
              
        </form>
    </div>
    <br>
    <div class="col-md-12 text-center">
        <p>© 2025 All Rights Reserved By TheNextBigThing<span>
                <a href="terms-condition.html">Terms & Conditions</a> | <a href="privacy-policy.html">Privacy Policy</a>
            </span></p>
    </div>
    <br>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>


</body>

</html>
