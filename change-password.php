<?php

$msg = "";

include 'dbConnection.php';

if (isset($_GET['reset'])) {
    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM requesterlogin_tb WHERE code='{$_GET['reset']}'")) > 0) {
        if (isset($_POST['submit'])) {
            $rPassword = mysqli_real_escape_string($conn, $_POST['rPassword']);
            $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);

            if ($rPassword === $confirm_password) {
            $query = mysqli_query($conn, "UPDATE requesterlogin_tb SET r_password='{$rPassword}', code='' WHERE code='{$_GET['reset']}'");
                    $msg = "<div class='alert alert-success'>Password Successfully Changed</div>";
            } else {
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
            }
        }
    } else {
        $msg = "<div class='alert alert-danger'>Reset Link do not match.</div>";
    }
} else {
    header("Location: forgot-password.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Login Form</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

<!--/Style-CSS -->
<link rel="stylesheet" href="css/styled.css" type="text/css" media="all" />
<!--//Style-CSS -->

<script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>
<link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="../css/styled.css" type="text/css" media="all" />
 
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
                        <h2>Change Password</h2>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="password" class="password" name="rPassword" placeholder="Enter Your Password" id = "myInput"  onkeyup="return validate ()" required>
                                <span class="eye" onclick="myFunction()">
                                    <i id = "hide1" class="fa-solid fa-eye"></i>
                                    <i id = "hide2" class="fa-solid fa-eye-slash"></i>
                                 </span>
                            <ul>
                                <li id='upper'> Atleast one uppercase </li>
                                <li id='lower'> Atleast one lowercase</li>
                                <li id='special_char'> Atleast one special symbol</li>
                                <li id='number'> Atleast one number</li>
                                <li id='length'> Make your password atleast 6-8 character</li>
                            </ul>
                            
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Enter Your Confirm Password" id ="confirmPw"  onkeyup="return confirmPassword()" required>
                         
                            <button name="submit" class="btn" type="submit">Change Password</button>
                        </form>
                        <div class="social-icons">
                            <p>Back to! <a href="Requester/RequesterLogin.php">Login</a>.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
  

    <script src="js/jquery.min.js"></script>
    <script>
        function validate(){
    var pass = document.getElementById('myInput');
    var upper = document.getElementById('upper');
    var lower = document.getElementById('lower');
    var num = document.getElementById('number');
    var len = document.getElementById('length');
    var sp_char = document.getElementById('special_char');
    // check if pass value contain a number
    if(pass.value.match(/[0-9]/)) {// match is function which matchs a regular expressions
    // password contain 0  to 9 number then 
        num.style.color = 'green'

    }
    else {
        //otherwise
        num.style.color = 'red'
    }
     // check if pass value contain a uppercase
     if(pass.value.match(/[A-Z]/)) {// match is function which matchs a regular expressions
        // password contain A  to Z number then 
            upper.style.color = 'green'
    
    
        }
        else {
            //otherwise
            upper.style.color = 'red'
        }
     // check if pass value contain a lowercase
     if(pass.value.match(/[a-z]/)) {// match is function which matchs a regular expressions
        // password contain A  to Z number then 
            lower.style.color = 'green'
    
    
        }
        else {
            //otherwise
            lower.style.color = 'red'
        }
    // checking for special symbols
    if(pass.value.match(/[!\@\#\$\%\^\&\*\(\)\_\-\+\=\?\>\<\.\,]/)) {// match is function which matchs a regular expressions
        // type all special characters which you want 
            sp_char.style.color = 'green'
        // it returns true if those characters are in password
    
        }
        else {
            //otherwise
            sp_char.style.color = 'red'
        }
    // check length of password
    if(pass.value.length <6){
        len.style.color='green'
    }
    else{
        len.style.color='green'
    }

}
function confirmPassword(){
    var myInput = document.getElementById('myInput');
    var confirmPw = document.getElementById('confirmPw');
    if(myInput.value == confirmPw.value){
        document.getElementById('number').style.display = 'none';
        document.getElementById('length').style.display = 'none';
        document.getElementById('special_char').style.display = 'none';
        document.getElementById('upper').style.display = 'none';
        document.getElementById('lower').style.display = 'none';
    }
    else {
        document.getElementById('number').style.display = 'block';
        document.getElementById('length').style.display = 'block';
        document.getElementById('special_char').style.display = 'block';
        document.getElementById('upper').style.display = 'block';
        document.getElementById('lower').style.display = 'block';
    }
}

        </script>
          <script>
        function myFunction(){
            var x = document.getElementById("myInput");
            var y = document.getElementById("hide1");
            var z = document.getElementById("hide2");

            if(x.type === 'password'){
                x.type = "text";
                y.style.display = "block";
                z.style.display = "none";
            }
            else{
                x.type = "password";
                y.style.display = "none";
                z.style.display = "block";
            }
        }
    </script>
</body>

</html>