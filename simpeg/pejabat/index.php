<html>
<head>
<script type="text/javascript" src="../js/jquery-1.4.2.min.js" /></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#loading").hide();
	});
	
	function filterPensiun(){
		$("#btnPensiun").attr("disabled", "disabled");
		$("#loading").show();
		$.post('pensiun_periode.php', { awal: $("#txtPeriode1").val(), akhir: $("#txtPeriode2").val() }, function(data){
			$("#content").html(data);
			$("#btnPensiun").removeAttr("disabled");
			$("#loading").hide();
		});		
	}
</script>
<style type="text/css">
body, input, td{
	font-family: arial;
	font-size: 8pt;
}

input, td{
	border: solid grey 1px;
}

td{
	padding: 3px 3px 3px 3px ;
}

thead td{
	font-weight: bold;
	text-align: center;
	background-color: #a5c3d5;
	color: white;
}

table{
	border-collapse: collapse;
}

#header{
	padding-bottom: 10px;
}

</style>
<title>Pejabat Kota Bogor</title>
</head>
<body>
<div id="header">
Pensiun Periode Tahun <input type="text" id="txtPeriode1"/> s.d <input type="text" id="txtPeriode2"/> <input onclick="filterPensiun()" type="button" id="btnPensiun" value="Tampilkan" />
<img src="../images/loading.gif" id="loading" alt="" height="13" />
</div>
<?php
include_once "../konek.php";

$q = "SELECT t.id_j, s.tmt, s.id_pegawai, j.jabatan, p.nama, p.nip_baru, p.pangkat_gol, CONCAT(UCASE(p.tempat_lahir), ', ', DATE_FORMAT(p.tgl_lahir, '%d-%m-%Y') ) AS ttl
		FROM sk s INNER JOIN
		(
			SELECT j.id_j, MAX(s.tmt) AS max_tmt FROM jabatan j 
			INNER JOIN sk s ON j.id_j = s.id_j
			WHERE j.tahun = 2011 AND s.id_kategori_sk = 10
			GROUP BY j.id_j
			ORDER BY s.id_j
		) AS t ON t.id_j = s.id_j AND s.tmt = t.max_tmt
		INNER JOIN jabatan j ON j.id_j = s.id_j
		INNER JOIN pegawai p ON p.id_pegawai = s.id_pegawai
		WHERE j.tahun = YEAR(CURDATE()) AND p.flag_pensiun = 0
		GROUP BY t.id_j
		ORDER BY p.pangkat_gol DESC";
		
$rs = mysql_query($q);

if($rs != ''){
	?>
	<div id="content">
	<table border="1">			
			<thead>			
				<td>No</td>
				<td>Nama</td>
				<td>NIP</td>
				<td>TTL</td>
				<td>Golongan</td>
				<td>Jabatan</td>
			</thead>
	<?php
	$i = 1;
	while($r = mysql_fetch_array($rs)){
		?>
			<tr>			
				<td><?php echo $i; ?></td>
				<td><?php echo $r[nama]; ?></td>
				<td><?php echo $r[nip_baru]; ?></td>
				<td><?php echo $r[ttl]; ?></td>
				<td><?php echo $r[pangkat_gol]; ?></td>
				<td><?php echo $r[jabatan]; ?></td>
			</tr>
		<?php		
		$i++;
	}
	?>
	</div>
	</table>
	<?php
}
?>
</body>
</html>