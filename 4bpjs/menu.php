<?php
session_start();
if($_SESSION['id']==1 and $_SESSION['jab']==2)
{
include("koneksi.php");
extract($_POST);
extract($_GET);
$id=$_SESSION['id'];
$jab=$_SESSION['jab'];

$qpro=mysqli_query($link,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama from pegawai where id_pegawai=$id");
$pro=mysqli_fetch_array($qpro);

if($jab==3100)
$title = 'Kepala Bagian Umum pada Sekretariat DPRD Kota Bogor';
else if($jab==3259)
$title = 'Kasubag Rumah Tangga pada Sekretariat DPRD Kota Bogor';
else
$title = 'Pengurus Barang Unit';
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
  <title>Sistem Informasi Keluarga PNS Bogor</title>
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
     <img src="logo.png" width="50px" />
     &nbsp;&nbsp;&nbsp;<span  style="color:#FFFFFF; size:10" ><?php
	 $q=mysqli_query($link,"select count(*) from pegawai where flag_pensiun=0"); $jumlah=mysqli_fetch_array($q);
	 echo("jumlah pegawai hari ini: <b>$jumlah[0]</b>"); ?></span>


     <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">

      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

         <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="menu.php?x=kir.php">
            <i class="fa  fa-edit"></i>
            <span class="nav-link-text">Daftar Keluarga / Dinas</span>          </a>        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="menu.php?x=pdk.php">
            <i class="fa  fa-sticky-note"></i>
            <span class="nav-link-text">Perubahan Data Keluarga</span>          </a>        </li>

             <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="menu.php?x=fir.php">
            <i class="fa  fa-share-alt"></i>
            <span class="nav-link-text">Pensiun Pegawai</span>          </a>        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="menu.php?x=mpm.php">
            <i class="fa fa-fw fa-list"></i>
            <span class="nav-link-text">Mutasi Pegawai Masuk</span>          </a>        </li>

               <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tables">
          <a class="nav-link" href="menu.php?x=susut.php">
            <i class="fa  fa-sort-amount-desc"></i>
            <span class="nav-link-text">Mutasi Pegawai Keluar</span>          </a>        </li>
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
    <div class="container-fluid" style="position:relative  !important; overflow:auto !important;">
      <!-- Breadcrumbs-->

      <?PHP
	  if(isset($x))
	  include("$x");
	  else
	  echo("&nbsp;&nbsp;&nbsp;Selamat Datang");


	  ?>
    </div>
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Copyright © SIMPEG 2018</small>        </div>
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
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="logout.php">Logout</a>          </div>
        </div>
      </div>
    </div>


     <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">percobaan form2</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
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
