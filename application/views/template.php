<?php 
  $username = ucfirst($this->session->user->username); 
  $profilePicture = $this->session->user->profile_picture;
  $idUser = $this->session->user->id;
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SimLabKal</title>
  <style>
    .daterangepicker{
        z-index: 1100 !important;
    }
  </style>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Head -->
  <?php $this->load->view('_partials/head'); ?>
</head>

<body class="hold-transition skin-black sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header bg-info">
    <!-- Logo -->
    <a href="<?= site_url('dashboard'); ?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SL</b></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>SimLabkal</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">       
       
          <!-- Tasks: style can be found in dropdown.less -->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <!-- <img src="<?php //echo base_url(); ?>assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
              <i class="fa fa-user-circle fa-fw"></i>
              <span class="hidden-xs">
                  <?= $username; ?>
              </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <?php 
                  if (!empty($profilePicture)) {
                    $profilePicture = base_url() . "uploads/images/" . $profilePicture;;
                  } else {
                    $profilePicture = base_url(). "assets/dist/img/avatar.png";
                  }

                ?>
                <img src="<?= $profilePicture ?>" class="img-circle" alt="User Image">
                <p>
                  <?= $username; ?>
                  <small>Member since Nov. 2012</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                  <a href="<?= site_url('auth/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
                </div>
                <div class="pull-left">
                  <a href="<?= site_url('users/edit') . "/" . $idUser; ?>"class="btn btn-default btn-flat">Profile</a> 
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <?php $this->load->view('/_partials/sidebar') ?>;
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <?php 
        ini_set('max_execution_time', 3600000);
        ini_set('memory_limit', '-1');
        echo $contents
     ?>
  </div>
  <!-- /.content-wrapper -->

	<!-- Footer -->
    <?php $this->load->view('_partials/footer'); ?>
</div>
<!-- ./wrapper -->

</body>
</html>
