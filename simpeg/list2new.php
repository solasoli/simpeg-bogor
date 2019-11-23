<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<style type="text/css">
.bodas {
	color: #FFF;
}
</style>
</head>

<body>

<ul class="nav nav-pills">
  <li class="active">
    <a href="#">Matriks Kelengkapan Berkas</a>
  </li>
  <li><a href="index2.php?x=list_by_subid.php">Hirarki Kepegawaian</a></li>  
</ul>


	Klik Pada Nama Untuk Merubah Data Pegawai SKPD<br /><br />
<?php
$qu=mysqli_query($mysqli,"select id_unit_kerja from current_lokasi_kerja where id_pegawai=$ata[id_pegawai]");
$unit = mysqli_fetch_array($qu);
?>
	
<?php

$qo=mysqli_query($mysqli,"select p.nama, p.nip_baru, p.pangkat_gol, u.nama_baru, k.* \n"
    . "from pegawai p \n"
    . "inner join buffer_kelengkapan_berkas k on k.id_pegawai = p.id_pegawai \n"
    . "inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai\n"
    . "inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja\n"
    . "where flag_pensiun = 0 and u.id_skpd = $unit[0]");
//echo("select nama,pangkat_gol,nip_baru from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where id_unit_kerja=$unit[0] order by nama");

echo("<table id='grid_pegawai'>
	<thead>
		<tr>
			<th width='50'>No</th>
			<th width='200'>Nama</th>
			<th width='200'>NIP</th>
			<th width='70'>Golongan</th>
			<th width='300'>Unit Kerja</th>
			<th width='50'>SK CPNS</th>
			<th width='50'>SK PNS</th>
			<th width='50'>SK KP</th>
			<th width='50'>SK KGB</th>
			<th width='50'>Karpeg</th>
		</tr>
	</thead>
	<tbody>");
$r=1;
while($bata=mysqli_fetch_array($qo))
{
	echo "<tr>";
	echo "<td>$r</td>";
	echo "<td><a href=index2.php?x=box.php&od=$bata[id_pegawai] id=$bata[id_pegawai] >$bata[nama]</a></td>";
	echo "<td>$bata[nip_baru]</td>";
	echo "<td>$bata[pangkat_gol]</td>";
	echo "<td>$bata[nama_baru]</td>";
	if($bata[cpns]) echo "<td>S</td>"; else echo "<td>&nbsp;</td>";
	if($bata[pns]) echo "<td>S</td>"; else echo "<td>&nbsp;</td>";
	if($bata[kp]) echo "<td>S</td>"; else echo "<td>&nbsp;</td>";
	if($bata[kgb]) echo "<td>S</td>"; else echo "<td>&nbsp;</td>";
	if($bata[karpeg]) echo "<td>S</td>"; else echo "<td>&nbsp;</td>";
	echo "</tr>";
	$r++;
}
echo("</tbody></table>");
echo "*S = Sudah dilengkapi";
?>


<script type="text/javascript">
	//$("#satker").hide();
	$("#grid_pegawai").flexigrid({
		height:'auto',
		width:'auto'
	});
	
	$("[draggable=true]").draggable({ 
		start: function(){
			$("#satker").modal('show');		
		},
		stop: function(){
			$("#satker").modal('hide');	
		},
		revert: true,
		clone: true 
		});
		
	$("[droppable=true]").droppable({
		drop: function(event, ui){
			var id_pegawai = ui.helper.context.id;			
			var id_j = $(this).attr('id');
			
			$.post('move_pegawai.php', {id_pegawai: id_pegawai, id_j: id_j}, function(data){
				if(data == '1')
				{
					
				}
				else
				{
					alert('ERROR: \n' + data);
				}				
			});
		}	
	}); 
</script>

</body>
</html>