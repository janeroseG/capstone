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
<div class="col-sm-9 col-md-10" style="margin-top:-15px;left: 230px">
<div class="feature-container">
  <div class="feature">
    <p>Hacker</p>
    <img src="../images/jane.jpg" alt="easy icon" class="bottom-image">
    <p>Janerose G. Culanibang</p>
    <!-- Description for Janerose -->
    <div class="description">Project Manager and Software Analyst, 
      responsible for managing and bringing up the whole team with whatever progress it may produce throughout the time frame . </div>
  </div>

  <div class="feature">
    <p>Hacker</p>
    <img src="../images/lorenz1.png" alt="secure icon" class="bottom-image">
    <p>Lorenz Landero</p>
    <!-- Description for Lorenz -->
    <div class="description">As a software developer in our capstone project, I am responsible for 
      building and developing the system we are working on.</div>
  </div>

  <div class="feature">
    <p>Hacker</p>
    <img src="../images/sister.png" alt="scalable icon" class="bottom-image">
    <p>Evangelin Bunado</p>
    <!-- Description for Evangelin -->
    <div class="description">Charge to ensure the software created by developers is fit for
       purpose, responsible for both the quality of software development and deployment.
</div>
  </div>

  <div class="feature">
    <p>Hipster</p>
    <img src="../images/kenneth.png" alt="Kenneth" class="bottom-image">
    <p>Kenneth Sarucam</p>
    <!-- Description for Kenneth -->
    <div class="description"> UX Designer of the team, consistent team worker
       that adapts to challenging situation.Make imaginations to reality .</div>
  </div>

  <div class="feature">
    <p>Hipster</p>
    <img src="../images/katlene.png" alt="Katlene" class="bottom-image">
    <p>Danmer Kathlene Bregondo</p>
    <!-- Description for Kathlene -->
    <div class="description">Technical Writer of the team in capstone and Research one responsible for
       updating the e-Portfolio regularly and taking notes of all the plans and changes of the project. </div>
  </div>
</div>

<hr></hr>

<div class="feature1-container">
  <div class="feature1">
    <p>Project Adviser</p>
    <img src="../images/jane.jpg" alt="easy icon" class="bottom-image">
    <p>Ryan H. Teo</p>
    <div class="description1">As an adviser it is my duty to guide and assist th developer throughout the development.</div>
  </div>

  <div class="feature1">
    <p>Project Owner</p>
    <img src="../images/lorenz1.png" alt="secure icon" class="bottom-image">
    <p>Ritchie Nuevo</p>
    <div class="description1">My project is for the monitoring of AgriFresh, providing the support to the developers makes my project possible.</div>
  </div>
</div>
<script>
 const features = document.querySelectorAll('.feature');

features.forEach((feature) => {
  const description = feature.querySelector('.description');

  feature.addEventListener('mouseenter', () => {
    description.style.display = 'block';
  });

  feature.addEventListener('mouseleave', () => {
    description.style.display = 'none';
  });
});
const feature1 = document.querySelectorAll('.feature1');

feature1.forEach((feature1) => {
  const description = feature1.querySelector('.description1');

  feature1.addEventListener('mouseenter', () => {
    description.style.display = 'block';
  });

  feature1.addEventListener('mouseleave', () => {
    description.style.display = 'none';
  });
});
</script>


<style>
  .col-sm-9.col-md-10.p {
    margin-top: 20px;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  }
  .description {
  width: 200px;
  display: none;
  position: absolute;
  background: #808080;
  padding: 10px;
  border: 1px solid #ccc;
  box-shadow: 0 0 10px rgba(0, 0, 0, 5);
  border-radius: 8px;
  top: 30%; /* Position it below the image */
  left: 250; /* Align it with the left edge of the image */
  margin-top: 5px; /* Add some space between the image and description */
}
.description1 {
  width: 200px;
  display: none;
  position: absolute;
  background: #808080;
  padding: 10px;
  border: 1px solid #ccc;
  box-shadow: 0 0 10px rgba(0, 0, 0, 5);
  border-radius: 8px;
  bottom: 35%; 
  left: 250; /* Align it with the left edge of the image */
  margin-top: 5px; /* Add some space between the image and description */
}

</style>
<?php
include('includes/footer.php');
?>
