<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
    <!--link rel="stylesheet" href="assets/DataTables/media/css/jquery.dataTables.css"-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <!--link rel="stylesheet" href="css/dataTables.tableTools.css" type="text/css"-->
    <script src="js/jquery.min.js"></script>
    <script language="javascript" src="js/jquery-ui-1.8.18.custom.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css" type="text/css">
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="	https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js" type="text/javascript"></script>
<style type="text/css">
body,td,th {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 11px;
}
</style>

</head>

<body>
<?php
include("konek.php");
$q=mysqli_query($mysqli,"select * from pegawai inner join pendidikan_terakhir on pegawai.id_pegawai=pendidikan_terakhir.id_pegawai where flag_pensiun=0 and jenjab like 'struktural' and (pangkat_gol like 'III/b' or pangkat_gol like 'III/c' or pangkat_gol like 'III/d' or pangkat_gol like 'IV/a') and id_j is null  order by pangkat_gol desc,level_p");
?>
<table id="list_pegawai"  class="table table-bordered display" width="100%" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td>No</td>
    <td>Nama</td>
    <td>NIP</td>
    <td>TTL</td>
    <td>Pendidikan</td>
       <td>Pangkat Terakhir</td>

  </tr>
  
  <?php
  $i=1;
  while($data=mysqli_fetch_array($q))
  {
	  $t1=substr($data[9],8,2);
	  $b1=substr($data[9],5,2);
	  $th1=substr($data[9],0,4);
	  
	  echo("  <tr>
    <td>$i</td>
    <td>$data[3] $data[1] $data[4] </td>
    <td>$data[nip_baru]</td>
    <td>$t1-$b1-$th1 $data[tempat_lahir]</td>
    <td>$data[tingkat_pendidikan] $data[jurusan_pendidikan]</td>
    <td nowrap>$data[pangkat_gol]<br>");
	$q3=mysqli_query($mysqli,"select tmt from sk where id_pegawai=$data[0] and id_kategori_sk=5 and gol='$data[pangkat_gol]'");
	$tmt=mysqli_fetch_array($q3);
	echo("$tmt[0]");
	 echo("</td></tr>");
	
	$i++;  
  }
  
  ?>
</table>
</body>
</html>
<script type="text/javascript" language="javascript" class="init">
    <?php //echo $_SESSION['id_skpd'] ?>
$(document).ready(function() {
    $('#list_pegawai').DataTable();
  /*$('#list_pegawai').dataTable( {
    "processing": true,
    "serverSide": true,
    "ajax": "list2_data.php?id_skpd=",
		//"searching": false

  });

	$('#list_pegawai tbody').on( 'click', 'button', function () {
        var data = table.row( $(this).parents('tr') ).data();
        alert( data[0] +"'s id_pegawai adalah "+ data[ 4 ] );
    } );*/

} );




</script>