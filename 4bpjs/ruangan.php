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
 
  <form name="form3" id="form3" method="post" enctype="multipart/form-data" action="slipb.php" target="_blank">
  Tanggal Cetak : <input type="text" name="tgl" id="tgl"> 
  
  
  <input type="submit" value="KIB" /> 
  </form> 

              <?php

extract($_POST);
extract($_GET);



?>
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <td>No </td>
                   <td>Lantai</td>
                  <td>Ruang</td>
                       <td>Ruangan</td>
                  <td>Kuasa Ruangan</td>
                  
              
                          <td>EDIT / HAPUS</td>
                </tr>
                <tbody>
          <?php
		  
		  $qir=mysqli_query($link,"select * from ruangan");
		  $i=1;
		  $totq=0;
$jum = 0;
		  while($ir=mysqli_fetch_array($qir))
		  {
		  
		  $qb=mysqli_query($link,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama,nip_baru  from pegawai where id_pegawai =$ir[4]");
		  $barang=mysqli_fetch_array($qb);
		 
		  echo("   <tr>
                  <td>$i 
				   </td>
				     <td>$ir[1]</td>
					  
                  <td>$ir[2]</td>
                  <td>$ir[3]</td>
				  <td>$barang[0]</td>
				 
                          <td nowrap=nowrap><a class='btn btn-danger' href=menu.php?x=delr.php&id=$ir[0]>  <i class='fa fa-trash'></i> </a>
				   <a class='btn btn-success' href=menu.php?x=ruangan.php&edit=$ir[0]#formedit>  <i class='fa fa-pencil'></i> </a></td>
                </tr>");
		  
		  $i++;
		  }
	
		  ?>
                
                </tbody>
                	
                
             
              </thead>
              </table><a name="formedit"></a>
<h5> Input Ruangan </h5>
          <form class="breadcrumb" name="form2" id="form2" method="post" action="menu.php" enctype="multipart/form-data">
          <input type="hidden" name="x" id="x" value="<?php if(isset($edit)) echo("updater.php"); else echo("insertr.php"); ?>">
       
          <table cellpadding="5" cellspacing="0" border="0">
          <tr> <td>Lantai</td> 
          
            <?php if(isset($edit)) { 
		  
		  $qset=mysqli_query($link,"select * from ruangan where id=$edit");
		  $set=mysqli_fetch_array($qset);
		  }
		  ?>
        
          <td> : </td> <td> <input type="text" size="50" name="lantai" id="lantai" <?php if(isset($edit)) echo("value='$set[1]'"); ?>  />  
</td> </tr>
            <tr> <td> Ruang</td> <td> : </td> <td><input type="text" id="ruang" name="ruang" size="50" <?php if(isset($edit)) echo("value='$set[2]'"); ?> /> </td> </tr>
             <tr> <td> Ruangan</td> <td> : </td> <td><input type="text" id="ruangan" name="ruangan" size="50" <?php if(isset($edit)) echo("value='$set[3]'"); ?> /> </td> </tr>
              <tr> <td> Kuasa Ruangan </td> <td> : </td> <td>
              
              <select name="pegawai" id="pegawai" >
              <?php
			  
			  $qpeg=mysqli_query($link,"select id_pegawai,concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama from pegawai");
			  while($peg=mysqli_fetch_array($qpeg))
			  {
			  if($set[4]==$peg[0])
			  echo("<option value=$peg[0] selected=selected > $peg[1] </option>");
			  else
			  echo("<option value=$peg[0]> $peg[1] </option>");
			  }
			  ?>
              </select>
               </td> </tr>
              
            <tr> <td> </td><td> </td><td><input type="submit" value="Simpan" />
            <input type="hidden" name="ide" id="ide" value="<?php echo $edit; ?>" />
             </td>
          
          </table>
          </form>
          <br><br><br><br><br><br>
       
</body>
</html>

<?php
}
else
echo("direct access not allowed");
?>