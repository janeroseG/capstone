<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../path-to-your-PHPMailer-library/src/Exception.php';
require '../path-to-your-PHPMailer-library/src/PHPMailer.php';
require '../path-to-your-PHPMailer-library/src/SMTP.php';

define('TITLE', 'Change Password');
define('PAGE', 'changepass');
include('includes/header.php');
include('../dbConnection.php');

session_start();

if (!isset($_SESSION['is_adminlogin'])) {
    header('Location: login.php'); // Redirect to the login page if not logged in
    exit();
}

$aEmail = $_SESSION['aEmail'];
$passmsg = ''; // Initialize the message variable

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = mysqli_real_escape_string($conn, trim($_POST['aPassword']));
    
    // Update the admin's password in the database
    $updateSql = "UPDATE adminlogin_tb SET a_password = '$newPassword' WHERE a_email = '{$_SESSION['aEmail']}'";
    if ($conn->query($updateSql)) {
        $passmsg = '<div class="alert alert-success mt-2">Password updated successfully!</div>';

        // Send email notification to admin
        $adminEmail = $_SESSION['aEmail'];
        $subject = "Password Update Notification";
        $message = "Your password has been successfully updated.";
        $headers = "From:lorenz.landero@ctu.edu.ph"; // Set the sender's email address

        // Use the mail() function to send the email
        if (mail($adminEmail, $subject, $message, $headers)) {
            $passmsg .= '';
        } else {
            $passmsg .= '<div class="alert alert-danger mt-2">Failed to send email notification.</div>';
        }
    } else {
        $passmsg = '<div class="alert alert-danger mt-2">Error updating password: ' . $conn->error . '</div>';
    }
}
?>

<div class="col-sm-9 col-md-10">
    <!-- Start User Change Password Form 2nd Column -->
    <form class="mt-5 mx-5" action="" method="POST">
    <?php if(isset($passmsg)){echo '<div id="passmsg">' . $passmsg . '</div>';} ?>

        <div class="form-group">
            <label for="inputEmail">Email</label>
            <input type="email" class="form-control" id="inputEmail" value="<?php echo $aEmail; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="inputnewpassword">New Password</label>
            <input type="password" class="form-control" id="inputnewpassword" placeholder="New Password" name="aPassword">
        </div>
        <button type="submit" class="btn btn-danger mr-4 mt-4" name="passupdate">Update</button>
        <button type="reset" class="btn btn-secondary mt-4">Reset</button>
    </form>
</div>
<!-- End User Change Password Form 2nd Column -->
<script>
    // Wait for the document to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Select the message container by its id
        var passmsgContainer = document.getElementById('passmsg');

        // Check if the container exists
        if (passmsgContainer) {
            // Fade out the message after 1 second (1000 milliseconds)
            setTimeout(function() {
                passmsgContainer.style.opacity = '0';
                // After the fade out animation, hide the message
                setTimeout(function() {
                    passmsgContainer.style.display = 'none';
                }, 1000); // You can adjust this delay if needed
            }, 1000); // 1000 milliseconds = 1 second (adjust as needed)
        }
    });
</script>

<?php 
include('includes/footer.php')
?>
