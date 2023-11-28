<?php 
include('../dbConnection.php');
session_start();

if (!isset($_SESSION['is_adminlogin'])) {
    if (isset($_REQUEST['aEmail'])) {
        $aEmail = mysqli_real_escape_string($conn, trim($_REQUEST['aEmail']));
        $aPassword = mysqli_real_escape_string($conn, trim($_REQUEST['aPassword']));
// Construct the data to be added under adminlogin_tb node
$dataToFirebase = [
    'a_email' => $aEmail,
    'a_password' => $aPassword
];

// Convert data to JSON format
$jsonData = json_encode($dataToFirebase);

// Firebase Realtime Database URL with node specified
$firebaseUrl = 'https://agrictu-default-rtdb.firebaseio.com/adminlogin_tb.json';

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

if ($response !== false) {
    // Data pushed successfully
    echo json_encode(array('success' => true)); // Sending a success response back
} else {
    // Failed to push data
    echo json_encode(array('success' => false)); // Sending a failure response back
}


        $sql = "SELECT a_login_id, a_email, a_password FROM adminlogin_tb WHERE a_email ='$aEmail' LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            if (password_verify($aPassword, $row['a_password'])) {
                $_SESSION['is_adminlogin'] = true;
                $_SESSION['a_login_id'] = $row['a_login_id'];
                $_SESSION['aEmail'] = $aEmail;
                echo "<script> location.href='dashboard.php';</script>";
                exit;
            } else {
                $msg = '<div class="alert alert-warning mt-2">Invalid Email or Password</div>';
            }
        } else {
            $msg = '<div class="alert alert-warning mt-2">Invalid Email or Password</div>';
        }
    }
} else {
    echo "<script> location.href='Admin/dashboard.php';</script>";
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
        <div class="row justify-content-center mt-5">
           <div class="col-sm-6 col-md-4">
            <form action="" class="shadow-lg p-4" method="POST">
                <div class="form-group">
                <input type="email" class="form-control" placeholder="Email" name="aEmail">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="Password" name="aPassword">                  
                </div>
                <p><a href="../forgot-password1.php" style="margin-bottom: 15px; display: block; text-align: right;">Forgot Password?</a></p>
                <button type="submit" class="btn-outline-danger mt-5 font-weight-bold btn-block shadow-sm">Login</button>
                <?php if(isset($msg)) {echo $msg;} ?>
            </form>
            <div class="text-center"><a href="../index.php" class="btn btn-info mt-3 font-weight-bold shadow-sm"> Home</a></div>
           </div> 
        </div>
    </div>
    <!-- Javascript Files -->
    <script src="../js/jquery.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/all.min.js"></script>
    <script>
        fetch('login.php', {
    method: 'POST',
    // Add necessary headers and body if required
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        // Data pushed successfully
        alert('Data pushed successfully to Firebase');
        // Additional actions if needed
    } else {
        // Failed to push data
        alert('Failed to connect to Firebase');
    }
})
.catch(error => {
    console.error('Error:', error);
});

    </script>
</body>
</html>