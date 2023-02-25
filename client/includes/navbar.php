<?php
  include_once ("../php_functions/authenticator.php")
?>

<nav class="main-header navbar navbar-expand navbar-light pt-1 pb-1" style="background-color: royalblue; color: white;">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a style="color:white" class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fa fa-bars"></i></a>
    </li>
  </ul>
  

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Notifications Dropdown Menu -->
    <!-- <li class="nav-item dropdown">
      <a style="color:white" class="nav-link" data-toggle="dropdown" href="#">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">15 Notifications</span>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-2"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-2"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-2"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
      </div>
    </li> -->

    <!--User account-->
    <li class="nav-item dropdown">
      <button style="color:white" class="btn dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
        <i class="fa fa-user"></i> <?php echo $userd['name'] != null ? $userd['name'] : ''  ?>
      </button>
      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <!-- <a class="dropdown-item" href="profile">
          Profile
        </a> -->
        <a class="dropdown-item" href="#" onclick="logout()">
          Logout
        </a>
      </div>
    </li>
  </ul>
</nav>