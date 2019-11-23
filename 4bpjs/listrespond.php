<?php
if(isset($_SESSION['id']) )
{ 

$id=$_SESSION['id'];


$qpro=mysqli_query($link,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama from pegawai where id_pegawai=$id");
$pro=mysqli_fetch_array($qpro);

$qun=mysqli_query($link,"select nama_baru from unit_kerja where id_unit_kerja=$unit");
$un=mysqli_fetch_array($qun);
?>
<!DOCTYPE html>
<html lang="en">

<head>
<style type="text/css">
/* Style the Image Used to Trigger the Modal */

<?php
$qc=mysqli_query($link,"select count(*) from pengaduan where status=1");
$count=mysqli_fetch_array($qc);
for($m=1;$m<=$count[0];$m++)
{
?>
#myImg<?php echo $m; ?> {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}


#myImg<?php echo $m; ?>:hover {opacity: 0.7;}


<?php
}
?>


<?php
$qa=mysqli_query($link,"select count(*) from respond inner join pengaduan on pengaduan.id = respond.id_pengaduan inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai = pengaduan.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where  respond.file_respond is not null");
$coun=mysqli_fetch_array($qa);
for($n=1;$n<=$coun[0];$n++)
{
?>
#myIma<?php echo $n; ?> {
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}




#myIma<?php echo $n; ?>:hover {opacity: 0.7;}



<?php
}
?>
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
Daftar Laporan Pengaduan Aset Sekretariat Daerah
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Aset</th>
                  <th>Foto</th>
                  <th>Keluhan</th>
                  <th>Laporan Dari</th>
                  <th>Tanggal Laporan</th>
                  <th>Respond</th>
                </tr>
                <tbody>
                <?php
				$q1=mysqli_query($link,"select * from pengaduan inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai = pengaduan.id_pegawai where status=1");
				$i=1;
				$j=1;
				$k=1;
				while($data=mysqli_fetch_array($q1))
				{
				$qaset=mysqli_query($link,"select barang from kode_barang where id=$data[2]");
				$aset=mysqli_fetch_array($qaset);
				
				$qpeg=mysqli_query($link,"select nama from pegawai where id_pegawai=$data[1]");
				$peg=mysqli_fetch_array($qpeg);
				
				$t1=substr($data[3],8,2);
				$b1=substr($data[3],5,2);
				$th1=substr($data[3],0,4);
				
				if($data[4]==0)
				$status="belum direspon";
				else if($data[4]==1)
				$status="sudah direspon";
				else if($data[4]==2)
				$status="sudah diselesaikan";
				
				$qbag=mysqli_query($link,"select nama_baru from unit_kerja where id_unit_kerja=$data[id_unit_kerja]");
$bagian=mysqli_fetch_array($qbag);
				
				$qr=mysqli_query($link,"select * from respond where id_pengaduan=$data[0]");
				$re=mysqli_fetch_array($qr);
				
				$qpr=mysqli_query($link,"select nama from pegawai where id_pegawai=$re[2]");
				
			
				$pr=mysqli_fetch_array($qpr);
				
				$t2=substr($re[4],8,2);
				$b2=substr($re[4],5,2);
				$th2=substr($re[4],0,4);
				
				if($re[5]!==NULL)
				$gambar="<img id=myIma$i width=50 src=./respond/$re[0].jpg />";
				else
				$gambar="";
				if($data[6]!=NULL)
				{
				echo("<tr><td> $i</td> <td> $aset[0]</td><td><img id=myImg$j width=50 src=./gambar/$data[0].jpg /> </td><td> $data[4]</td><td>$peg[0]<br> $bagian[0] </td><td> $t1-$b1-$th1</td><td> 				
				$pr[0] ($t2-$b2-$th2)
				<br> $re[3]
				<br> $gambar
				</td> </tr>");
				$j++;
				}
				else
				echo("<tr><td> $i</td> <td> $aset[0]</td><td> </td><td> $data[4]</td><td>$peg[0]<br> $bagian[0] </td><td> $t1-$b1-$th1</td><td> 				
				$pr[0] ($t2-$b2-$th2)
				<br> $re[3]
				<br> $gambar
				</td> </tr>");
				
				$i++;				
				}
				
				?>
                
                </tbody>
                
                
             
              </thead>
              </table>
              <script type="text/javascript">

// Get the modal
var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption


<?php
$qc=mysqli_query($link,"select count(*) from pengaduan where status=1 and file_pengaduan is not null");
$count=mysqli_fetch_array($qc);
for($m=1;$m<=$count[0];$m++)
{
?>
var img<?php echo $m; ?> = document.getElementById('myImg<?php echo $m; ?>');


<?php
}
?>
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");


<?php
$qc=mysqli_query($link,"select count(*) from pengaduan where status=1 and file_pengaduan is not null");
$count=mysqli_fetch_array($qc);
for($m=1;$m<=$count[0];$m++)
{
?>
img<?php echo $m; ?>.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;


}


<?php
}
?>



<?php
$qd=mysqli_query($link,"select count(*) from respond inner join pengaduan on pengaduan.id = respond.id_pengaduan inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai = pengaduan.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where respond.file_respond is not null ");
$coun2=mysqli_fetch_array($qd);
for($o=1;$o<=$coun2[0];$o++)
{
?>
var ima<?php echo $o; ?> = document.getElementById('myIma<?php echo $o; ?>');

<?php
}
?>

<?php
$qb=mysqli_query($link,"select count(*) from respond inner join pengaduan on pengaduan.id = respond.id_pengaduan inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai = pengaduan.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where  respond.file_respond is not null ");
$count2=mysqli_fetch_array($qb);
for($o=1;$o<=$count2[0];$o++)
{
?>
ima<?php echo $o; ?>.onclick = function(){
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
}


<?php
}
?>




// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() { 
  modal.style.display = "none";
}
</script>
</body>
</html>

<?php
}
else
echo("direct access not allowed");
?>