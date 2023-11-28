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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
   
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/nav.css">
    
    <title><?php echo TITLE ?></title>
</head>

        <body style="background-color:#d9d9d9">
  <!-- Top Navbar -->
  
  <nav class="navbar navbar-dark fixed-top bg-success flex-md-nowrap p-0 ">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0 logo" href="Dashboard.php">
      <img src="../images/agri (2).png" alt="Logo" style="height: 70px; width: 80px; padding-bottom:1px; margin-left: 50px">
    </a>
</nav>
    <!--  Start Container -->
    <div class="container-fluid" style="margin-top:50px;">
    <div class="row">   <!--  Start Row -->
    <nav class=" sidebar col-sm-5 col-md-3 col-lg-2 bg-gray sidebar py-5 d-print-none" style="height: 100vh;"> 
    <div class="sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link <?php if(PAGE == 'Dashboard'){echo 'active';} ?>" href="Dashboard.php"><i class="fas fa-qrcode"  style="margin-right: 10px;"></i>Dashboard</a></li>
                <li class="nav-item"><a class="nav-link <?php if(PAGE == 'DataStatus'){echo 'active';} ?>" href="DataStatus.php"><i class="fas fa-database"  style="margin-right: 10px;"></i>Datalog</a></li>
                <li class="nav-item"><a class="nav-link <?php if(PAGE == 'Analytics'){echo 'active';} ?>" href="Analytics.php"><i class="fas fa-chart-bar"  style="margin-right: 10px;"></i>Analytics</a></li>
                <li class="nav-item"><a class="nav-link <?php if(PAGE == 'DevInfo'){echo 'active';} ?>" href="DevInfo.php"><i class="fas fa-code"  style="margin-right: 10px;"></i>Developers Information</a></li>
                <li class="nav-item"><a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i>Logout</a></li>
              </ul>
        </div>
        
    </nav>  <!-- End Side Bar 1st Column -->