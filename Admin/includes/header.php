<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="refresh" content="530">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="../css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>  

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/nav.css">

    <title><?php echo TITLE ?></title>
</head>
<body style="background-color:#d9d9d9">
  <!-- Top Navbar -->
  <nav class="navbar navbar-dark fixed-top bg-success flex-md-nowrap p-0 ">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0 logo" href="RequesterProfile.php">
      <img src="../images/agrilogo.png" alt="Logo" style="height: 60px; width: 100px; padding-bottom: 5px;">
    </a>
</nav>
    <!--  Start Container -->
    <div class="container-fluid" style="margin-top:50px;">
    <div class="row">   <!--  Start Row -->
    <nav class="col-sm-2 col-md-3 col-lg-2 bg-gray sidebar py-5 d-print-none"> <!-- Side Bar 1st Column -->
        <div class="sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link <?php if(PAGE == 'dashboard'){echo 'active';} ?>" href="dashboard.php"><i class="fas fa-tachometer-alt"  style= "margin-right: 10px;"> </i>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link <?php if(PAGE == 'accepted'){echo 'active';} ?>" href="accepted.php"><i class="fas fa-align-center"style= "margin-right: 10px;"> </i>Users</a></li>
                <li class="nav-item"><a class="nav-link <?php if(PAGE == 'requesters'){echo 'active';} ?>" href="requester.php"><i class="fas fa-users"style= "margin-right: 10px;"> </i>Requests</a></li>
                <li class="nav-item"><a class="nav-link <?php if(PAGE == 'history'){echo 'active';} ?>" href="history.php"><i class="fas fa-history"style= "margin-right: 10px;"> </i>History</a></li>
                <li class="nav-item"><a class="nav-link <?php if(PAGE == 'latest'){echo 'active';} ?>" href="latest.php"><i class="fas fa-chart-bar" style= "margin-right: 10px;"> </i>Latest Record</a></li>
                <li class="nav-item"><a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt" style= "margin-right: 10px;"></i>Logout</a></li>
        </ul>
        </div>
    </nav>  <!-- End Side Bar 1st Column -->