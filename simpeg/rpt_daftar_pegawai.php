<?php require("konek.php"); ?>
<?php 
function loadSKPD(){
	return mysqli_query($mysqli,"SELECT nama_lama, id_unit_kerja FROM unit_kerja ORDER BY nama_lama");
}
?>


<html>
<head>
<title>
	SIMPEG Kota Bogor- Daftar Pegawai Per SKPD
</title>

<script type="text/javascript" src="jquery.js" >
</script>

<script type="text/javascript" >
$(document).ready(function(){	
	$("#skpd").change(function(){
		$('#hanyaPelaksana').attr('checked', false);
		$("#content").html('<img src=images/loadingAnimation.gif />');
		$.post('cunda/rpt_daftar_pegawai/getByIdUnitKerja.php', { id_unit_kerja: $("#skpd").val() }, function(data){
			$("#content").html(data);	
		});
	});
	
	$("#hanyaPelaksana").change(function(){
		if(!$("#hanyaPelaksana").is(':checked'))
		{
			$("#content").html('<img src=images/loadingAnimation.gif />');
			$.post('cunda/rpt_daftar_pegawai/getByIdUnitKerja.php', { id_unit_kerja: $("#skpd").val() }, function(data){
				$("#content").html(data);	
			});
		}
		else
		{
			$("#content").html('<img src=images/loadingAnimation.gif />');
			$.post('cunda/rpt_daftar_pegawai/getByIdUnitKerja.php', { id_unit_kerja: $("#skpd").val(), hanyaPelaksana: true }, function(data){
				$("#content").html(data);	
			});
		}
	});
});
</script>

<style>
#content .skpd{
	border-collapse: collapse;
}

#content .skpd td{
	padding: 10px 10px 10px;
}

#btnSave{
	width: 31px;
	height: 31px;
	background-image: url('images/btnSave.png');
}
</style>

</head>
<body>
<h1>
	Daftar Pegawai Per SKPD
</h1>
<div>
SKPD: 
<select id="skpd">
	<?php $result = loadSKPD(); ?>
	<?php while($r = mysqli_fetch_array($result)): ?>
		<option value="<?php echo $r['id_unit_kerja'] ?>" ><?php echo $r['nama_lama'] ?></value>
	<?php endwhile ?>
</select> &nbsp;&nbsp; 
<input type="checkbox" id="hanyaPelaksana" value="1">Hanya Pelaksana</input>
<!--Filter: <input type="text" id="keywords" /> <i>(NIP, nama, golongan)</i>-->

</div>
<br />
<div id="content">
	Pilih SKPD terlebih dahulu.
</div>
</body>
</html>