<?php
session_start();
if(isset($_SESSION['id']) and isset($_SESSION['unit']))
{ 
include("koneksi.php");
extract($_POST);
extract($_GET);
$id=$_SESSION['id'];
$unit=$_SESSION['unit'];

$qpro=mysqli_query($link,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama from pegawai where id_pegawai=$id");
$pro=mysqli_fetch_array($qpro);

$qun=mysqli_query($link,"select nama_baru from unit_kerja where id_unit_kerja=$unit");
$un=mysqli_fetch_array($qun);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<style type="text/css">

.avatar {
    float: left;
    margin-top: 0em;
    margin-right: 0em;
    position: relative;

    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;

    -webkit-box-shadow: 0 0 0 0px #fff, 0 0 0 0px #FFF, 0 0px 5px 4px rgba(0,0,0,.2);
    -moz-box-shadow: 0 0 0 0px #fff, 0 0 0 0px #FFF, 0 0px 5px 4px rgba(0,0,0,.2);
    box-shadow: 0 0 0 0px #fff, 0 0 0 0px #FFF, 0 0px 5px 4px rgba(0,0,0,.2);
}
</style>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Sistem Informasi Pengaduan Sarana-Prasarana Setdakot Bogor</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
     <div style="width:40px;height:40px;overflow:hidden" class="avatar"><img src="./foto/<?php echo ("$id.jpg"); ?>" width="40px"   /> </div>
     &nbsp;&nbsp;&nbsp;<span  style="color:#FFFFFF; size:10" ><?php echo(" $pro[0] <br> $un[0]"); ?></span>
 

     <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
   
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
          <a class="nav-link" href="user.php?x=keluhan.php">
            <i class="fa fa-fw fa-comment"></i>
            <span class="nav-link-text">Buat Pengaduan</span>          </a>        </li>
       
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="user.php?x=daftarkeluhan.php">
            <i class="fa fa-fw fa-table"></i>
            <span class="nav-link-text">Daftar Pengaduan</span>          </a>        </li>
      
     <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Link">
             <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>            </li>
      </ul>
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>          </a>        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
     
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Logout</a>        </li>
      </ul>
    </div>
  </nav>
  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Dashboard</a>        </li>
        <li class="breadcrumb-item active">My Dashboard</li>
      </ol>
      <!-- Icon Cards-->
     <?PHP
	  if(isset($x))
	  include("$x");
	  else
	  echo("&nbsp;&nbsp;&nbsp;Selamat Datang");

	  
	  ?>
      <!-- Area Chart Example-->
      <!-- Example DataTables Card-->
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © PakOcan 2018</small>        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Keluar dari Aplikasi?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>            </button>
          </div>
          <div class="modal-body">Klik tombol  "Logout" di bawah untuk keluar dari aplikasi ini</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="logout.php">Logout</a>          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Page level plugin JavaScript-->
    <script src="vendor/chart.js/Chart.min.js"></script>
    <script src="vendor/datatables/jquery.dataTables.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin.min.js"></script>
    <!-- Custom scripts for this page-->
    <script src="js/sb-admin-datatables.min.js"></script>
    <script src="js/sb-admin-charts.min.js"></script>
  </div>
</body>
</html>

<?php
}
else
echo("direct access not allowed");
?>