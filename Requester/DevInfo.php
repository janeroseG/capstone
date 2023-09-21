<?php
$msg = "";
define('TITLE', 'Developers');
define('PAGE', 'DevInfo');
include('includes/header.php');
include('../dbConnection.php');
session_start();
if ($_SESSION['is_login']) {
    $rEmail = $_SESSION['rEmail'];
} else {
    echo "<script> location.href='RequesterLogin.php'</script>";
}
?>

<!-- Include the CSS file -->
<link rel="stylesheet" href="../css/Dev1.css">
<div class="col-sm-9 col-md-10">
  <h1>Synergy</h1>
  <div class="feature-container">
    <div class="feature">
      <p>Hacker</p>
      <img src="../images/jane.jpg" alt="easy icon" class="bottom-image">
      <p>Janerose G. Culanibang</p>
    </div>
    <div class="feature">
      <p>Hacker</p>
      <img src="../images/lorenz1.png" alt="secure icon" class="bottom-image">
      <p>Lorenz Landero</p>
    </div>
    <div class="feature">
      <p>Hacker</p>
      <img src="../images/sister.png" alt="scalable icon" class="bottom-image">
      <p>Evangelin Bunado</p>
    </div>
    <div class="feature">
      <p>Hipster</p>
      <img src="../images/kenneth.png" alt="Kenneth" class="bottom-image">
      <p>Kenneth Sarucam</p>
    </div>
    <div class="feature">
      <p>Hipster</p>
      <img src="../images/katlene.png" alt="Katlene" class="bottom-image">
      <p>Danmer Kathlene Bregondo</p>
    </div>
  </div>
<hr></hr>
  <!-- Use the same class "feature" for feature1 -->
  <div class="feature1-container">
  <div class="feature1">
      <p>Project Adviser</p>
      <img src="../images/jane.jpg" alt="easy icon" class="bottom-image">
      <p>Ryan H. Teo</p>
    </div>
    <div class="feature1">
      <p>Project Owner</p>
      <img src="../images/lorenz1.png" alt="secure icon" class="bottom-image">
      <p>Ritchie Nuevo</p>
    </div>
    </div>
</div>
</div>
<style>
  .col-sm-9.col-md-10 {
    margin-top: 20px;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  }
</style>
<?php
include('includes/footer.php');
?>
