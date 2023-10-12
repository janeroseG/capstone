<?php
$msg = "";
include 'dbConnection.php';

if (isset($_GET['reset'])) {
    $reset_code = mysqli_real_escape_string($conn, $_GET['reset']);
    $reset_query = "SELECT * FROM adminlogin_tb WHERE code='$reset_code'";
    $reset_result = mysqli_query($conn, $reset_query);

    if (mysqli_num_rows($reset_result) > 0) {
        if (isset($_POST['submit'])) {
            $aPassword = mysqli_real_escape_string($conn, $_POST['aPassword']);
            $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);

            if ($aPassword === $confirm_password) {
                // Hash the new password
                $hashed_password = password_hash($aPassword, PASSWORD_DEFAULT);

                // Update the password in the database
                $update_query = "UPDATE adminlogin_tb SET a_password='$hashed_password', code='' WHERE code='$reset_code'";
                $update_result = mysqli_query($conn, $update_query);

                if ($update_result) {
                    $msg = "<div class='alert alert-success'>Password Successfully Changed</div>";
                } else {
                    $msg = "<div class='alert alert-danger'>Error updating password</div>";
                }
            } else {
                $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match</div>";
            }
        }
    } else {
        $msg = "<div class='alert alert-danger'>Reset Link does not match.</div>";
    }
} else {
    header("Location: forgot-password1.php"); // Redirect to the forgot password page
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Change Password</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords" content="Change Password" />
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
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid" >
                <div class="main-mockup">
                    <div class="w3l_form align-self" style="background-image: url('images/5a.png');"> </div>
                    <div class="content-wthree">
                        <h2>Change Password</h2>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="password" class="password" name="aPassword" placeholder="Enter Your Password" id="myInput" onkeyup="return validate()" required>
                            <span class="eye" onclick="myFunction()">
                                <i id="hide1" class="fa-solid fa-eye"></i>
                                <i id="hide2" class="fa-solid fa-eye-slash"></i>
                            </span>
                            <ul>
                                <li id="upper">At least one uppercase</li>
                                <li id="lower">At least one lowercase</li>
                                <li id="special_char">At least one special symbol</li>
                                <li id="number">At least one number</li>
                                <li id="length">Make your password at least 6-8 characters</li>
                            </ul>
                            
                            <input type="password" class="confirm-password" name="confirm-password" placeholder="Enter Your Confirm Password" id="confirmPw" onkeyup="return confirmPassword()" required>
                         
                            <button name="submit" class="btn" type="submit">Change Password</button>
                        </form>
                        <div class="social-icons">
                            <p>Back to! <a href="Admin/login.php">Login</a>.</p>
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
