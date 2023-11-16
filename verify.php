
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Verification</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->

    
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/styh11s.css" type="text/css" media="all" />

    
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
                <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/image2.svg" alt="">
                    </div>
                    </div>
                    <div class="content-wthree">
                        
                        <?php
                    // Include your database connection and other necessary configurations
                    include 'dbConnection.php';

                    // PHP verification code here
                    if (isset($_GET['token'])) {
                        $verificationToken = mysqli_real_escape_string($conn, $_GET['token']);

                        // Check if the verification token exists in the database
                        $query = "SELECT * FROM requesterlogin_tb WHERE verification_token = '$verificationToken'";
                        $result = mysqli_query($conn, $query);

                        if (mysqli_num_rows($result) > 0) {
                            // Update user's verification status in the database
                            $updateQuery = "UPDATE requesterlogin_tb SET is_verified = 1 WHERE verification_token = '$verificationToken'";
                            $updateResult = mysqli_query($conn, $updateQuery);

                            if ($updateResult) {
                                echo "<p class='success-message'><h1>Email verified successfully.</h1></p><br>";
                                echo "<p class='success-message'>You can now log in.</p>";
                            } else {
                                echo "<p class='error-message'><h1>Failed to verify email.</h1></p><br>";
                                echo "<p class='error-message'>Please contact support.</p>";
                            }
                        } else {
                            echo "<p class='error-message'><h1>Invalid verification token.</h1></p><br>";
                        }
                    } else {
                        echo "<p class='error-message'><h1>Verification token not provided.</h1></p><br>";
                    }
                    ?>
                        <div class="social-icons">
                        <button><a href="Requester/RequesterLogin.php">Login</a></button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->
</body>

</html>