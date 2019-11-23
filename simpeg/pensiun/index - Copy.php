<html>
<head>
	<title>PENSIUN</title>
	<script type="text/javascript" src="../js/jquery-1.4.2.min.js" >
	</script>
	<script type="text/javascript" >
		$(document).ready(function(){						
			/*$("#tahun").change(function(){
				load_data();			
			});	
			
			$("#jenjab").change(function(){
				load_data();			
			});*/
		});
		
		function load_data(){
			$("#content").html("<img src='../images/loading.gif' />");
			$.post('rekap_pensiun.php', { eselon: $("#jenjab").val(), tahun: $("#tahun").val() }, function(data){
				$("#content").html(data);			
			});		
		}
	</script>
</head>
<body>
<h1>REKAPITULASI PEGAWAI PEMERINTAH KOTA BOGOR YANG AKAN PENSIUN</h1>
<table>
	<tr>
		<td colspan=2>Data Pegawai Pensiun</td>
	</tr>
	<!--<tr>
		<td>Jenjang Jabatan</td>
		<td>: 
			<select id="jenjab">
				<option value="1">Semua</option>
				<option value="2">Struktural</option>
				<option value="3">NON - Struktural</option>
			</select>
		</td>
	</tr>-->
	<tr>
		<td>Tahun</td>
		<td>: 
			<select id="tahun">
				<?php for($th = 2010; $th <= date('Y') + 10; $th++): ?>
					<option value="<?php echo $th; ?>" <?php if($th == date('Y')) echo "selected"; ?>><?php echo $th; ?></option>
				<?php endfor; ?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Eselon</td>
		<td>: 
			<select id="eselon">
				<option value="">Semua</option>
				<option value="IIa">IIa</option>
				<option value="IIb">IIb</option>
				<option value="IIIa">IIIa</option>
				<option value="IIIb">IIIb</option>
				<option value="IVa">IVa</option>
				<option value="IVb">IVb</option>
				<option value="V">V</option>
			</select>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><input type="button" value="Tampilkan" onclick="load_data()" />
		</td>
	</tr>
</table>
<div id="content" >
</div>
</body>
</html>