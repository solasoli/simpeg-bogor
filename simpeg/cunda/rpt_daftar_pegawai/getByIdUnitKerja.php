<?php
require_once("../../konek.php");

extract($_POST);

if($hanyaPelaksana)
{
$q = "SELECT nama, Y.id_unit_kerja, P.id_pegawai, nip_lama, nip_baru, tgl_lahir, jenis_kelamin, pangkat_gol, flag_pensiun, J.jabatan, U.nama_baru
		FROM pegawai P
		INNER JOIN
		(
		  SELECT R.id_pegawai, R.id_unit_kerja FROM riwayat_mutasi_kerja R
		  INNER JOIN
			(
			  SELECT id_pegawai, MAX(id_riwayat) AS max_riwayat
			  FROM riwayat_mutasi_kerja
			  GROUP BY id_pegawai
			) AS X
		  ON R.id_pegawai = X.id_pegawai AND R.id_riwayat = X.max_riwayat

		  WHERE R.id_unit_kerja = '".$id_unit_kerja."'
		)AS Y
		ON P.id_pegawai = Y.id_pegawai
		INNER JOIN unit_kerja U ON U.id_unit_kerja = Y.id_unit_kerja 
		LEFT JOIN jabatan J ON J.id_j = P.id_j
		WHERE flag_pensiun=0 AND (J.jabatan IS NULL OR J.jabatan = '')
		ORDER BY pangkat_gol DESC ";
}	
else
{
$q = "SELECT nama, Y.id_unit_kerja, P.id_pegawai, nip_lama, nip_baru, tgl_lahir, jenis_kelamin, pangkat_gol, flag_pensiun, J.jabatan, U.nama_baru
		FROM pegawai P
		INNER JOIN
		(
		  SELECT R.id_pegawai, R.id_unit_kerja FROM riwayat_mutasi_kerja R
		  INNER JOIN
			(
			  SELECT id_pegawai, MAX(id_riwayat) AS max_riwayat
			  FROM riwayat_mutasi_kerja
			  GROUP BY id_pegawai
			) AS X
		  ON R.id_pegawai = X.id_pegawai AND R.id_riwayat = X.max_riwayat

		  WHERE R.id_unit_kerja = '".$id_unit_kerja."'
		)AS Y
		ON P.id_pegawai = Y.id_pegawai
		INNER JOIN unit_kerja U ON U.id_unit_kerja = Y.id_unit_kerja 
		LEFT JOIN jabatan J ON J.id_j = P.id_j
		WHERE flag_pensiun=0 
		ORDER BY pangkat_gol DESC ";
}
		$result = mysql_query($q);
		$rowsTotal = mysql_num_rows($result);
		
		//if($start)
			//$q = $q."LIMIT $start, ".$MAX_PER_PAGE;
		//else
			//$q = $q."LIMIT 0, ".$MAX_PER_PAGE;
		
		//echo $q;
$result = mysql_query($q);	

function getUnitKerja()
{
	$q = "SELECT id_unit_kerja, nama_baru FROM unit_kerja ORDER BY nama_baru ASC";
	return mysql_query($q);
}
?>

<?php echo "Total Pegawai: ".$rowsTotal." pegawai." ?>
<table class="skpd" border="1">
	<tr>
		<td>
			Nama
		</td>
		<td>
			NIP
		</td>
		<td>
			Pangkat/Gol
		</td>
		<td>
			Jabatan
		</td>
	</tr>
	<?php while($r = mysql_fetch_array($result)): ?>
	<tr>
		<td>
			<?php echo $r['nama'] ?>
		</td>
		<td>
			<?php echo $r['nip_baru'] ?>
		</td>
		<td>
			<?php echo $r['pangkat_gol'] ?>
		</td>
		<td>
			<?php echo $r['jabatan'] ?>
		</td>
	</tr>
	<?php endwhile ?>
</table>




<script type="text/javascript" >
	$(document).ready(function(){
		
		$("#newSKPD").keyup(function(){
			//alert($("#newSKPD").val());
			$.post('cunda/alih_tugas/getUnitKerjaByNamaUnitKerjaBaru.php', { keywords: $("#newSKPD").val() }, function(data){
				$("#SKPDName").val(data);
				$("#newSKPD").focus();
			});
		});
	});
</script>