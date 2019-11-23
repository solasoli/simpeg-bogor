<?php
if(isset($_SESSION['id']) )
{ 

$id=$_SESSION['id'];


$qpro=mysqli_query($link,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama from pegawai where id_pegawai=$id");
$pro=mysqli_fetch_array($qpro);

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
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>
  <!-- Navigation-->
 
 

              <?php

extract($_POST);
extract($_GET);



?>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <td>No </td>
                   <td>Kode Barang</td>
                  <td>Nama Barang</td>
                       <td>No Register</td>
                  <td>Merk <BR> Tipe</td>
                
                       <td>Bahan</td>
                  <td>Tahun Pembelian</td>
                  
                  
                   <td>Jumlah Barang</td>
                    <td>Harga Total</td>
                  
                   <td>Masa Manfaat</td>
                    <td>Penyusutan Per Tahun</td>
                     <td>Akumulasi Penyusutan</td>
                      <td>Nilai Setelah Penyusutan</td>
                        <td>Hapus Aset</td>
                 
                          
                </tr>
                <tbody>
          <?php
		  
		  $qir=mysqli_query($link,"select * from aset ");
		  $i=1;
		  $totq=0;
$jum = 0;
		  while($ir=mysqli_fetch_array($qir))
		  {
		  
		  $qb=mysqli_query($link,"select barang,kodebarang,masa_manfaat from kode_barang where id=$ir[1]");
		  $barang=mysqli_fetch_array($qb);
		 
		
		
		if($barang[2]==0)
		$barang[2]=1;
		
		  $susu=$ir[5]/$barang[2];
		  $harga  = "Rp ".number_format($ir[5],0,',','.');
		  		  $hasu  = "Rp ".number_format($susu,0,',','.');
				  
				  $ay=date("Y");
				  $tasu=$ay-$ir[3];
				  $aku=$tasu*$susu;
				    $haku  = "Rp ".number_format($aku,0,',','.');
					$sisa=$ir[5]-$aku;
					
					if($sisa<0)
					$sisa=0;
					$hasi  = "Rp ".number_format($sisa,0,',','.');
		  echo("   <tr>
                  <td>$i 
				   </td>
				     <td>$barang[1]</td>
					  
                  <td>$barang[0]</td>
                  <td>$ir[10]</td>
				  <td>$ir[7]</td>
				  
				
                
                  <td>$ir[8]</td>
                  <td>$ir[3]</td>
                
               
				   
				 
				   <td>$ir[4]</td>
				   <td>$harga</td>
				   <td>$barang[2] Tahun </td>
				   <td>$hasu</td>
				   <td>$haku</td>
				   <td>$hasi</td>
				    <td nowrap=nowrap><a class='btn btn-danger' href=menu.php?x=delset.php&id=$ir[0]>  <i class='fa fa-trash'></i> </a>
				  </td>
				 ");
		  
		  $i++;
		  }
	
		  ?>
                
                </tbody>
                	
              </thead>
              </table>
          <br><br><br><br><br><br>
       
</body>
</html>

<?php
}
else
echo("direct access not allowed");
?>