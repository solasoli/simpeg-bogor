<?php
if(isset($_SESSION['id']) )
{ 

$id=$_SESSION['id'];




?>
<!DOCTYPE html>
<html lang="en">

<head>
<style type="text/css">
/* Style the Image Used to Trigger the Modal */

/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 25px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.9); /* Black w/ opacity */
}

/* Modal Content (Image) */
.modal-content {
    margin: auto;
    display: block;
    width: 100%;
    max-width: 700px;
}

/* Caption of Modal Image (Image Text) - Same Width as the Image */
#caption {
    margin: auto;
    display: block;
    width: 80%;
    max-width: 700px;
    text-align: center;
    color: #ccc;
    padding: 10px 0;
    height: 150px;
}

/* Add Animation - Zoom in the Modal */
.modal-content, #caption { 
    animation-name: zoom;
    animation-duration: 0.6s;
}

@keyframes zoom {
    from {transform:scale(0)} 
    to {transform:scale(1)}
}

/* The Close Button */
.close {
    position: absolute;
    top: 0px;
    right: 5px;
    color: #f1f1f1;
    font-size: 40px;
    font-weight: bold;
    transition: 0.3s;
}

.close:hover,
.close:focus {
    color: #bbb;
    text-decoration: none;
    cursor: pointer;
}

/* 100% Image Width on Smaller Screens */
@media only screen and (max-width: 700px){
    .modal-content {
        width: 100%;
    }
}


</style>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Pengaduan Aset</title>
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
   <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="#">Data Keluarga</a>        </li>
        <li class="breadcrumb-item active">Perangkat Dinas</li>
      </ol>
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>
  Data Pegawai Masuk
  <form action="menu.php" method="post" name="form1" id="form1" enctype="multipart/form-data">
  
 
Bulan: 
  <select name="ru" id="ru">
<?php
$bul=date("m");
$bulan = array('x','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
for($i=1;$i<=12;$i++)
{
if($i<10)
$j="0$i";
else
$j=$i;
if(@$ru==$j)
echo("<option value=$j selected=selected> $bulan[$i]</option>");
else
echo("<option value=$j> $bulan[$i]</option>");

}

?>
  </select> <select name="tahun" id="tahun">
  <?php
  for($i=date("Y");$i>=2016;$i--)
  {
	if(@$tahun==$i)  
  echo("<option value=$i selected=selected> $i</option>");
  else
  echo("<option value=$i> $i</option>");
  }
  ?>
  </select>
  <input type="hidden" name="x" value="mpm.php" id="x" />
   <input type="submit" value="Tampilkan" />
   
  </form>
 

              <?php

extract($_POST);
extract($_GET);
if(isset($ru))
{
$cari=date("$tahun-").$ru;
$qir=mysqli_query($link,"select nama,nip_baru,status_aktif,nama_baru,pegawai.id_pegawai,tmt from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai = current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja inner join sk on sk.id_pegawai = pegawai.id_pegawai where flag_pensiun=0 and tmt like '$cari%' and id_kategori_sk=55 order by tgl_pensiun_dini");



?>


    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>NO </th>
                  <th>NAMA </th>
                  <th>NIP</th>
                  <th>NIK</th>
                  <th>UNIT KERJA</th>
                 
                  
                </tr>
                <tbody>
          <?php
		  $i=1;
		  while($ir=mysqli_fetch_array($qir))
		  {
		  

		  $qb=mysqli_query($link,"select count(*) from pegawai inner join berkas on berkas.id_pegawai = pegawai.id_pegawai where nm_berkas like '%ktp%' and pegawai.id_pegawai=$ir[4]");
		  $barang=mysqli_fetch_array($qb);
		  
		  if($barang[0]>0)
		  {
		    $qc=mysqli_query($link,"select ket_berkas from pegawai inner join berkas on berkas.id_pegawai = pegawai.id_pegawai where nm_berkas like '%ktp%' and pegawai.id_pegawai=$ir[4]");
		  $arang=mysqli_fetch_array($qc);
		  $nonik=$arang[0];
		  }
		  else
		  $nonik="";
		  
		   $qpi=mysqli_query($link,"select instansi from pindah_instansi inner join instansi on pindah_instansi.id_instansi=instansi.id where id_pegawai=$ir[4]");
		 
		  $pi=mysqli_fetch_array($qpi);
		  
		  
		  
		  echo("   <tr>
                  <td>$i </td>
                  <td>$ir[0]</td>
                  <td>$ir[1]</td>
                  <td>$nonik</td>
                  <td>$ir[3]</td>
				
				              
                </tr>");
		  
		  $i++;
		  }
		  ?>
                
                </tbody>
                
                
             
              </thead>
              </table>
              
             
        
          <br><br><br><br><br><br>
          <?php
		  }
		  ?>
</body>
</html>

<?php
}
else
echo("direct access not allowed");
?>