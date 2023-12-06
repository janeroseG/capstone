<?php
session_start(); // Start the session

include 'dbConnection.php'; // Include the database connection
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$msg = ""; // Initialize a message variable

if (isset($_SESSION['rEmail'])) {
    header("Location: RequesterLogin.php");
    die();
}
if (isset($_POST['submit'])) {
    $rName = $_POST['rName'];
    $rEmail = $_POST['rEmail'];
    $rPassword = $_POST['rPassword'];
    $confirmPassword = $_POST['confirm-password'];

    // Capture the selected role from the dropdown
    $role = $_POST['role'];

    // Check if the email already exists in the database
    $stmt = $conn->prepare("SELECT * FROM requesterlogin_tb WHERE r_email = ?");
    $stmt->bind_param("s", $rEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $msg = "<div class='alert alert-danger'>$rEmail - This email address has already been taken.</div>";
    } else {
        if ($rPassword == $confirmPassword) {
            // Generate a random verification token
            $verificationToken = generateVerificationToken();

            // Hash the password
            $hashedPassword = password_hash($rPassword, PASSWORD_BCRYPT);

            // Insert user details and the verification token into the database
            $stmt = $conn->prepare("INSERT INTO requesterlogin_tb (r_name, r_email, r_password, verification_token) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $rName, $rEmail, $hashedPassword, $verificationToken);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Send verification email
                $verificationLink = "http://localhost/ProjectSystem_v2/verify.php?token=$verificationToken&expires=" . (time() + 120);
                $emailSent = sendVerificationEmail($rEmail, $verificationLink);

                if ($emailSent) {
                    $msg = "<div class='alert alert-success'>Registration successful. A verification link has been sent to your email.</div>";
                } else {
                    $msg = "<div class='alert alert-danger'>Registration successful, but email sending failed. Please contact support to verify your email.</div>";
                }

                // Create an array with the data you want to push to Firebase
$dataToFirebase = [
    'r_name' => $rName,
    'r_email' => $rEmail,
    'r_password' => $hashedPassword,
    'verification_token' => $verificationToken
];

// Convert data to JSON format
$jsonData = json_encode($dataToFirebase);

// Firebase Realtime Database URL with node specified
$firebaseUrl = 'https://agrictu-default-rtdb.firebaseio.com/requesterlogin_tb.json';

// Initialize cURL session
$ch = curl_init($firebaseUrl);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST'); // Use POST method to push data
curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

// Execute cURL session
$response = curl_exec($ch);

// Close cURL session
curl_close($ch);

// Handle response from Firebase (check if data is pushed successfully)
if ($response !== false) {
    // Data pushed successfully
    // Your success message or further actions here
} else {
    // Failed to push data
    // Your error message or handling here
}

            } else {
                $msg = "<div class='alert alert-danger'>Registration failed. Please try again later.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
        }
    }
    
}


// Function to generate a random verification token
function generateVerificationToken($length = 64) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $token;
}

// Function to send a verification email
function sendVerificationEmail($to, $verificationLink) {
    if (!isVerificationLinkValid($verificationLink)) {
        return false; // Link has expired
    }

    // Create a PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        // Configure SMTP settings
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'lorenz.landero@ctu.edu.ph';
        $mail->Password = 'cnilhfbtovelmiyj';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Set email content
        $mail->setFrom('from@example.com', 'no reply');
        $mail->addAddress($to);
        $mail->isHTML(true);
        $mail->Subject = 'Email Verification';
        $mail->Body = "Thank you for registering. Please verify your email by clicking the following link: <a href='$verificationLink'>$verificationLink</a>";

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

function isVerificationLinkValid($verificationLink) {
    // Parse the link to get the expiration timestamp
    $parts = parse_url($verificationLink);
    parse_str($parts['query'], $query);

    if (isset($query['expires'])) {
        $expirationTime = intval($query['expires']);

        // Check if the current time is less than the expiration time
        if (time() < $expirationTime) {
            return true;
        }
    }

    return false;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registration Form</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/styh11.css" type="text/css" media="all" />


    <!--//Style-CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

<!-- form section start -->
<section class="w3l-mockup-form" id= "login">
    <div class="container">
        <!-- /form -->
        <div class="workinghny-form-grid" >
            <div class="main-mockup">
                <div class="w3l_form align-self" style="background-image: url('images/5a.png');">
</div>
                <div class="content-wthree">
                    <h2>Create an Account</h2>
                    <p>It's quick and easy.</p>
                    <?php echo $msg; ?>
                    <form action="" method="post">
                        <input type="text" class="name" name="rName" id="name" placeholder="Enter Full Name"
                               value="<?php if (isset($_POST['submit'])) {
                                   echo $rName;
                               } ?>" required>
                        <input type="email" class="email" name="rEmail" id="email" placeholder="Enter Email"
                               value="<?php if (isset($_POST['submit'])) {
                                   echo $rEmail;
                               } ?>" required>

                        <select class="role" name="role" id="role" required>
                            <option value="" disabled selected>Select Role</option>
                            <option value="student">Student</option>
                            <option value="instructor">Instructor</option>
                        </select>
                        <br><br>
                        <div class="input-box">
                            <input type="password" class="password" name="rPassword"  placeholder="Enter Password"
                                   id="myInput" onkeyup="return validate ()" required>
                            <span class="eye" onclick="myFunction()">
                                <i id="hide1" class="fa-solid fa-eye"></i>
                                <i id="hide2" class="fa-solid fa-eye-slash"></i>
                            </span>
                        </div>
                        <ul>
                            <li id='upper'> Atleast one uppercase </li>
                            <li id='lower'> Atleast one lowercase</li>
                            <li id='special_char'> Atleast one special symbol</li>
                            <li id='number'> Atleast one number</li>
                            <li id='length'> Make your password atleast 6-8 character</li>
                        </ul>

                        <div class="input-box">
                            <input type="password" class="confirm-password" name="confirm-password"
                                   placeholder="Confirm Password" id="confirmPw" onkeyup="return confirmPassword()"
                                   required>
                            <span class="eye" onclick="myFunctionpw()">
                                <i id="show1" class="fa-solid fa-eye"></i>
                                <i id="show2" class="fa-solid fa-eye-slash"></i>
                            </span>
                        </div>
                        <button name="submit" class="btn" type="submit">Register</button>

                    </form>
                    <div class="social-icons">
                        <p>Have an account ?<a href="Requester/RequesterLogin.php">Login</a>.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- //form -->
    </div>
</section>
<!-- //form section start -->
<script src="js/script.js"></script>
<script src="js/validation.js"></script>
<script src="js/namevalidate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/7.14.1-0/firebase.js"></script>

<script>
    function myFunction() {
        var x = document.getElementById("myInput");
        var y = document.getElementById("hide1");
        var z = document.getElementById("hide2");

        if (x.type === 'password') {
            x.type = "text";
            y.style.display = "block";
            z.style.display = "none";
        } else {
            x.type = "password";
            y.style.display = "none";
            z.style.display = "block";
        }
    }
</script>
<script>
    // Function to add the 'fade-out' class to the alert after 5 seconds
    function fadeOutAlerts() {
        var alertElements = document.querySelectorAll('.alert');
        alertElements.forEach(function (alertElement) {
            setTimeout(function () {
                alertElement.classList.add('fade-out'); // Add the 'fade-out' class
            }, 5000);
        });
    }

    // Call the fadeOutAlerts function when the page loads
    document.addEventListener('DOMContentLoaded', fadeOutAlerts);
</script>

</body>
</html>
