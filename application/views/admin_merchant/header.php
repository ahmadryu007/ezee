<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Merchant</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>dist/css/skins/_all-skins.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>plugins/iCheck/flat/blue.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>plugins/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>plugins/daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo $base_url; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
   <!-- fullCalendar 2.2.5-->
  <link rel="stylesheet" href="<?php echo $base_url; ?>plugins/fullcalendar/fullcalendar.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

<!-- Sparkline -->
<script src="<?php echo $base_url; ?>plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo $base_url; ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo $base_url; ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo $base_url; ?>plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="<?php echo $base_url; ?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo $base_url; ?>plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo $base_url; ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo $base_url; ?>plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo $base_url; ?>plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $base_url; ?>dist/js/app.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo $base_url; ?>dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo $base_url; ?>dist/js/demo.js"></script>

  
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <span class="logo-mini"><b>A</b>ez</span>
      <span class="logo-lg"><b>Admin</b>MERCHANT</span>
    </a>
    <nav class="navbar navbar-static-top">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

    </nav>
  </header>
  <aside class="main-sidebar">
    <section class="sidebar">
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="<?php echo $base_url;?>index.php/merchantDashboard">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li>
        <li class="treeview">
          <a href="<?php echo $base_url;?>index.php/merchantToko">
            <i class="fa fa-institution"></i> <span>Data Toko</span>
          </a>
        </li>
        <li class="treeview">
          <a href="<?php echo $base_url;?>index.php/merchantProduk">
            <i class="fa fa-cubes"></i> <span>Data Produk</span>
          </a>
        </li>
        <li class="treeview">
          <a href="<?php echo $base_url;?>index.php/merchantTransaksi">
            <i class="fa fa-dollar"></i> <span>Data Transaksi</span>
          </a>
        </li>
        <li class="treeview">
          <a href="<?php echo $base_url;?>index.php/merchantPelanggan">
            <i class="fa fa-user"></i> <span>Data Pelanggan</span>
          </a>
        </li>
        <li class="treeview">
          <a href="<?php echo $base_url;?>index.php/merchantKartu">
            <i class="fa fa-credit-card"></i> <span>Data Kartu</span>
          </a>
        </li>
        <li class="treeview">
          <a href="<?php echo $base_url;?>index.php/merchantDashboard">
            <i class="fa fa-anchor"></i> <span>Manajemen Pemasaran</span>
          </a>
        </li>
        <li class="treeview">
          <a href="<?php echo $base_url;?>index.php/authent/out">
            <i class="fa fa-share"></i> <span>Logout</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>