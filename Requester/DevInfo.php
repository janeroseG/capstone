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
<link rel="stylesheet" href="../css/dash.css">
<div class="col-sm-9 col-md-10" style="margin-top: 50px; left: 230px;">
<br>
<br>
<div class="image-cards-container">
<div class="image-card">
<img src="../images/jane.jpg" alt="easy icon" class="bottom-image">
  <div class="card-overlay">
  <h2>Project Manager and Software Analyst</h2>
  </div>
</div>
<div class="image-card">
<img src="../images/lorenz1.png" alt="easy icon" class="bottom-image">
  <div class="card-overlay">
  <h2>Project Manager and Software Analyst</h2>
  </div>
</div>
<div class="image-card">
<img src="../images/sister.png" alt="scalable icon" class="bottom-image">
  <div class="card-overlay">
  <h2>Hacker</h2>
  </div>
</div>
<div class="image-card">
<img src="../images/kenneth.png" alt="Kenneth" class="bottom-image">
  <div class="card-overlay">
  <h2>Hipster</h2>
  </div>
</div>

<div class="image-card">
<img src="../images/katlene.png" alt="Katlene" class="bottom-image">
  <div class="card-overlay">
  <h2>Hipster</h2>
  </div>
</div>
</div>

<hr></hr>
<div class="image-cards-container1">
<div class="image-card">
<img src="../images/teo.png" alt="Katlene" class="bottom-image">
  <div class="card-overlay">
  <h2>Project Adviser</h2>
  </div>
</div>
<div class="image-card">
<img src="../images/nuevo.png" alt="Katlene" class="bottom-image">
  <div class="card-overlay">
  <h2>Product Owner</h2>
  </div>
</div>
</div>


<?php
include('includes/footer.php');
?>
