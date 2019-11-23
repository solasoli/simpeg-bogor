<?php
require_once("../../konek.php");
include_once("alih_tugas_lib.php");

extract($_POST);

$isContinue = false;
if($startRecord == "")
{
	$startRecord = 0;
	$isContinue = true;
}	
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
		ORDER BY pangkat_gol DESC 
		LIMIT $startRecord, 50";
		
		$result = mysql_query($q);		
		$jumlahPegawai = mysql_num_rows($result);
				
$result = mysql_query($q);	
?>

<?php echo "Total pelaksana: ".$jumlahPegawai." pegawai." ?>
<table class="skpd" border="1" id="tblPegawai">
	<tr>
		<td>
			No.
		</td>
		<td>
			NIP
		</td>
		<td>
			Nama
		</td>
		<td>
			Jabatan
		</td>
		<td>
			Tanggal Lahir
		</td>
		<td>
			Golongan
		</td>
		<td>
			SKPD Baru
		</td>
	</tr>
	<?php $i = 1;?>
	<?php while($r = mysql_fetch_array($result)): ?>
	<tr>
		<td>
			<?php echo $i; ?>
		</td>
		<td>
			<?php echo $r['nip_baru'] ?>
		</td>
		<td>
			<?php echo $r['nama'] ?>
		</td>
		<td>
			<?php echo $r['jabatan'] ?>
		</td>
		<td>
			<?php echo $r['tgl_lahir'] ?>
		</td>
		<td>
			<?php echo $r['pangkat_gol'] ?>
		</td>
		<td>	
		<select id="skpd_baru_<?php echo $r['id_pegawai']?>">
			<?php $result2 = getUnitKerja(); ?>
			<?php while($r2 = mysql_fetch_array($result2)): ?>
				<option value="<?php echo $r2['id_unit_kerja'] ?>" ><?php echo $r2['nama_baru'] ?></value>
			<?php endwhile ?>
		</td>
	</tr>
	<?php $i++; ?>
	<?php endwhile ?>
</table>