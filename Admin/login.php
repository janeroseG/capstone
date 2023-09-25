<?php 
    include('../dbConnection.php');
    session_start();
    if(!isset($_SESSION ['is_adminlogin'])){
    if(isset($_REQUEST['aEmail'])){
    $aEmail = mysqli_real_escape_string($conn, trim($_REQUEST['aEmail']));
    $aPassword = mysqli_real_escape_string($conn, trim($_REQUEST['aPassword']));
    $sql = "SELECT a_email, a_password FROM adminlogin_tb WHERE a_email ='".$aEmail."' AND a_password = '".$aPassword."' limit 1";
    $result = $conn->query($sql);
    if($result->num_rows == 1){
        $_SESSION['is_adminlogin'] = true;
        $_SESSION['aEmail'] = $aEmail;
        echo "<script> location.href='dashboard.php';</script>";
        exit;
    } else {
        $msg = '<div class="alert alert-warning mt-2">Enter Valid  Email and Password</div>';
    }
}
} else {
    echo"<script> location.href='Admin/dashboard.php';</script>";
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
                <p><a href="./forgot-password.php" style="margin-bottom: 15px; display: block; text-align: right;">Forgot Password?</a></p>
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
</body>
</html>