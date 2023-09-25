<?php
session_start();
if (isset($_SESSION['aEmail'])) {
    header("Location: AdminLogin.php");
    die();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include('../dbConnection.php');

$msg = "";

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
if (isset($_POST['submit'])) {
    $aEmail = mysqli_real_escape_string($conn, $_POST['aEmail']);
    $code = mysqli_real_escape_string($conn, md5(rand()));

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM adminlogin_tb WHERE a_email='{$aEmail}'")) > 0) {
        $query = mysqli_query($conn, "UPDATE adminlogin_tb SET code='{$code}' WHERE a_email='{$aEmail}'");
        if ($query) {
            echo "<div style='display: none;'>";
            // Create an instance; passing `true` enables exceptions
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
                $mail->SMTPAuth   = true; // Enable SMTP authentication
                $mail->Username   = 'lorenz.landero@ctu.edu.ph'; // SMTP username
                $mail->Password   = 'cnilhfbtovelmiyj'; // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
                $mail->Port       = 465; // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                // Recipients
                $mail->setFrom('from@example.com', 'no reply');
                $mail->addAddress($aEmail); // Add a recipient

                // Content
                $mail->isHTML(true); // Set email format to HTML
                $mail->Subject = 'Here is the subject';
                $mail->Body    = 'Here is the verification link <b><a href="http://localhost/YourProjectFolder/Admin/change-password.php?reset=' . $code . '">http://localhost/YourProjectFolder/Admin/change-password.php?reset=' . $code . '</a></b>';

                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
            echo "</div>";        
            $msg = "<div class='alert alert-info'>Successfully Sent a Reset Link.</div>";
        }
    } else {
        $msg = "<div class='alert alert-danger'>$rEmail - This email address does not found.</div>";
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password  Form</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->
    
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="../css/styh11.css" type="text/css" media="all" />

    <!--//Style-CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" rel="stylesheet">

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            
            <div class="workinghny-form-grid" >
                <div class="main-mockup">
                    <div class="w3l_form align-self" style="background-image: url('images/5a.png');"></div>
                         <div class="content-wthree">
                             <h2>Forgot Password</h2>
                                <?php echo $msg; ?>
                                 <form action="" method="post">
                                 <input type="email" class="email" name="aEmail" placeholder="Enter Your Email" required>
                                 <button name="submit" class="btn" type="submit">Send Reset Link</button>
                                 </form>
                                    <div class="social-icons">
                                     <p>Back to! <a href="Admin/login.php">Login</a>.</p>
                                    </div>
                         </div>
                    </div>
                </div>
         </div>
            <!-- //form -->
        </div>
    </section>
</body>

</html>
<script src="js/script.js"></script>
<script src="js/validation.js"></script>
<script src="js/namevalidate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/firebase/7.14.1-0/firebase.js"></script>