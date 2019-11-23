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
 
<h5> Pencatatan Aset </h5>
          <form class="breadcrumb" name="form2" id="form2" method="post" action="menu.php" enctype="multipart/form-data">
          <input type="hidden" name="x" id="x" value="<?php if(isset($edit)) echo("updatekib.php"); else echo("insertkib.php"); ?>">
       
          <table cellpadding="5" cellspacing="0" border="0">
          <tr> <td> Nama Barang </td> 
          <td> : </td> <td> <input type="text" size="50" name="aset" id="aset"  list="lisaset" 
          <?php if(isset($edit)) { 
		  
		  $qset=mysqli_query($link,"select * from aset where id=$edit");
		  $set=mysqli_fetch_array($qset);
		  
		  $qb2=mysqli_query($link,"select barang,kodebarang from kode_barang where id=$set[1]");
		  $arang=mysqli_fetch_array($qb2);
		  echo ("value='$arang[1] $arang[0]'");  }else echo ("placeholder='ketik nama barang atau kode barang'"); ?>
          >  <datalist id="lisaset">
<?php 

$qry=mysqli_query($link,"SELECT kodebarang,barang From kode_barang");

while ($t=mysqli_fetch_array($qry)) {


echo "<option value='$t[kodebarang] $t[barang]'>";
}
?>
</datalist>	</td> </tr>
            <tr> <td> Merk / Model</td> <td> : </td> <td><input type="text" id="model" name="model" size="50" <?php if(isset($edit)) echo("value='$set[7]'"); ?> /> </td> </tr>
             <tr> <td> No Register</td> <td> : </td> <td><input type="text" id="reg" name="reg" size="50" <?php if(isset($edit)) echo("value='$set[10]'"); ?> /> </td> </tr>
              <tr> <td> Ukuran  </td> <td> : </td> <td><input type="text" id="ukuran" name="ukuran" size="50"  <?php if(isset($edit)) echo("value='$set[9]'"); ?> /> </td> </tr>
              <tr> <td> Bahan </td> <td> : </td> <td><input type="text" id="bahan" name="bahan" size="50"  <?php if(isset($edit)) echo("value='$set[8]'"); ?> /> </td> </tr>
                <tr> <td> Tahun Perolehan </td> <td> : </td> <td> <input type="text" id="tahun" name="tahun" size="10" <?php if(isset($edit)) echo("value=$set[3]"); ?> /> </td> </tr>
                
                   <tr> <td> No Pabrik</td> <td> : </td> <td><input type="text" id="pabrik" name="pabrik" size="50" <?php if(isset($edit)) echo("value='$set[11]'"); ?> /> </td> </tr>
                   <tr> <td> No Rangka</td> <td> : </td> <td><input type="text" id="rangka" name="rangka" size="50" <?php if(isset($edit)) echo("value='$set[12]'"); ?> /> </td> </tr>
                   <tr> <td> No Mesin</td> <td> : </td> <td><input type="text" id="mesin" name="mesin" size="50" <?php if(isset($edit)) echo("value='$set[13]'"); ?> /> </td> </tr>
                 <tr> <td> No Polisi</td> <td> : </td> <td><input type="text" id="polisi" name="polisi" size="50" <?php if(isset($edit)) echo("value='$set[14]'"); ?> /> </td> </tr>
                <tr> <td> No BPKB</td> <td> : </td> <td><input type="text" id="bpkb" name="bpkb" size="50" <?php if(isset($edit)) echo("value='$set[15]'"); ?> /> </td> </tr>
                
                 <tr> <td> Asal-usul / Cara</td> <td> : </td> <td><input type="text" id="asal" name="asal" size="50" <?php if(isset($edit)) echo("value='$set[16]'"); ?> /> </td> </tr>
                
                  <tr> <td> Jumlah Barang </td> <td> : </td> <td> <input type="text" id="jumlah" name="jumlah" size="5"  <?php if(isset($edit)) echo("value=$set[4]"); ?> /></td> </tr>
                    <tr> <td> Harga Perolehan</td> <td> : </td> <td> Rp <input type="text" id="harga" name="harga" size="10" <?php if(isset($edit)) echo("value=$set[5]"); ?> /></td> </tr>
                    
          
            <tr> <td> Keterangan</td> <td> : </td> <td><input type="text" id="keterangan" name="keterangan" size="50" <?php if(isset($edit)) echo("value='$set[17]'"); ?> /> </td> </tr>
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