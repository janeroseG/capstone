<?php
include 'dbConnection.php';
$msg = "";

if (isset($_POST['submit'])) {
    $rName = mysqli_real_escape_string($conn, $_POST['rName']);
    $rEmail = mysqli_real_escape_string($conn, $_POST['rEmail']);
    $rPassword = mysqli_real_escape_string($conn, $_POST['rPassword']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm-password']);

    if (mysqli_num_rows(mysqli_query($conn, "SELECT * FROM requesterlogin_tb WHERE r_email='{$rEmail}'")) > 0) {
        $msg = "<div class='alert alert-danger'>{$rEmail} - This email address has already been taken.</div>";
    } else {
        if ($rPassword == $confirm_password) {
            // Generate a random verification token
            $verificationToken = generateVerificationToken();

            // Insert user details and the verification token into the database
            $sql = "INSERT INTO requesterlogin_tb (r_name, r_email, r_password, verification_token) VALUES ('$rName', '$rEmail', '$rPassword', '$verificationToken')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                // Registration successful

                // Send verification email
                $to = $rEmail;
                $subject = "Email Verification";
                $message = "Thank you for registering. Please verify your email by clicking the following link:\n\n";
                $message .= "http://localhost/ProjectSystem/verify.php?token=$verificationToken";
                $headers = "From: lorenz.landero@ctu.edu.ph"; // Replace with your email

                if (mail($to, $subject, $message, $headers)) {
                    // Email sent successfully
                    $msg = "<div class='alert alert-success'>Registration successful. A verification link has been sent to your email.</div>";
                } else {
                    // Email sending failed
                    $msg = "<div class='alert alert-danger'>Registration successful, but email sending failed. Please contact support to verify your email.</div>";
                }
            } else {
                // Display error message if insertion fails
                $msg = "<div class='alert alert-danger'>Registration failed. Please try again later.</div>";
            }
        } else {
            $msg = "<div class='alert alert-danger'>Password and Confirm Password do not match.</div>";
        }
    }
}
?>