<?php
include('../dbConnection.php');
session_start();
$msg = "";
if (!isset($_SESSION['is_login'])) {
    if (isset($_POST['rEmail']) && isset($_POST['rPassword'])) {
        $rEmail = mysqli_real_escape_string($conn, $_POST['rEmail']);
        $rPassword = mysqli_real_escape_string($conn, $_POST['rPassword']);

        $sql = "SELECT r_email, r_password, is_verified, is_accepted, is_blocked, verification_token, code FROM requesterlogin_tb WHERE r_email = '$rEmail' LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if ($row['is_blocked'] == 1) {
                $msg = '<div class="alert alert-danger mt-2">This account has been blocked by the admin.</div>';
            } elseif ($row['is_verified'] == 1) {
                if ($row['is_accepted'] == 1) {
                    // Check if the password has been updated
                    if (!empty($row['code'])) {
                        // The code field is not empty, which means the password has been updated
                        $storedHashedPassword = password_hash($rPassword, PASSWORD_DEFAULT);

                        // Update the user's password in the database
                        $updatePasswordSql = "UPDATE requesterlogin_tb SET r_password='$storedHashedPassword', code='' WHERE r_email='$rEmail'";
                        $conn->query($updatePasswordSql);
                    } else {
                        $storedHashedPassword = $row['r_password'];
                    }

                    if (password_verify($rPassword, $storedHashedPassword)) {
                        // Password is correct
                        $_SESSION['is_login'] = true;
                        $_SESSION['rEmail'] = $rEmail;
                        echo "<script> location.href='Dashboard.php';</script>";
                        exit;
                    } else {
                        $msg = '<div class="alert alert-danger mt-2">Invalid Password</div>';
                    }
                } else {
                    $msg = '<div class="alert alert-danger mt-2">Your request has not been accepted yet.</div>';
                }
            } else {
                $msg = '<div class="alert alert-danger mt-2">Please verify your email first.</div>';
            }
        } else {
            $msg = '<div class="alert alert-danger mt-2">Invalid Email</div>';
        }
    }
} else {
    echo "<script> location.href='SubmitRequest.php';</script>";
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Form</title>
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
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                <div class="w3l_form align-self" style="background-image: url('../images/3a.png');">  

</div>
                    <div class="content-wthree">
                        <h2>Login Now</h2>
                        <p>Login with your email and password.</p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="email" class="email" name="rEmail" placeholder="Enter Email" required>
                            <div class="input-field">
                                <input type="password" class="password" name="rPassword" placeholder="Enter Password" id="myInput" style="margin-bottom: 2px;" required>
                                <span class="eye" onclick="myFunction()">
                                    <i id="hide1" class="fa-solid fa-eye"></i>
                                    <i id="hide2" class="fa-solid fa-eye-slash"></i>
                                </span>
                            </div>
                            <p><a href="../forgot-password.php" style="margin-bottom: 15px; display: block; text-align: right;">Forgot Password?</a></p>
                            <button name="submit" class="btn" type="submit">Login</button>
                        </form>
                        <div class="social-icons">
                            <p>Create Account?<a href="../UserRegistration.php">Register</a>.</p>
                        </div>
                        <div class="text-center"><a href="../index.php" class="btn btn-info mt-3 font-weight-bold shadow-sm">Back to Home</a></div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
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
</body>

</html>
