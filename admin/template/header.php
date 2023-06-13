
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AP Shop | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/adminlte.min.css">
  <!-- data table  -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light py-3">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav">
    <!-- Navbar Search -->
    <?php
      $link = $_SERVER['PHP_SELF'];
      $link_array = explode('/', $link);
      $page = end($link_array);
    ?>
    <?php if($page != 'order_list.php' && $page != 'order_detail.php' && $page != 'add.php' && $page != 'edit.php' && $page != 'add_user.php' && $page != 'edit_user.php' && $page != 'cat_add.php' && $page != 'cat_edit.php' && $page != 'weekly_report.php' && $page != 'monthly_report.php' && $page != 'royal_cus.php' && $page != 'best_selling.php'): ?>
      <li class="nav-item">
          <form class="form-inline" method="post">
            <div class="input-group">
              <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
              <input class="form-control form-control-navbar" name="search" type="search" placeholder="Search" aria-label="Search">
          </form>
        </div>
      </li>
    <?php endif; ?> 
  </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AP Shop</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['user']['name']?> </a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-4">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="index.php" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Products
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="user_list.php" class="nav-link">
              <i class="nav-icon fas fa-users "></i>
              <p>
                Users
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="cat.php" class="nav-link">
              <i class="nav-icon fas fa-list "></i>
              <p>
                Category
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="order_list.php" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Order
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Reports
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="weekly_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Weekley Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="monthly_report.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly Report</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="royal_cus.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Royal Customers</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="best_selling.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Best Selling Items</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">