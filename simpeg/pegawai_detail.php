<?php
extract($_REQUEST);

$qPegawai = "SELECT * 
			FROM pegawai p 
				INNER JOIN current_lokasi_kerja c ON c.id_pegawai = p.id_pegawai
				INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
			WHERE p.id_pegawai = $id";
$rsPegawai = mysqli_query($mysqli,$qPegawai);
if(mysqli_num_rows($rsPegawai) > 0){
	$pegawai = mysqli_fetch_array($rsPegawai)
	
	?>
	<table>
	<tr>
		<td rowspan="7">
			<img src="<?php echo "foto/$id.jpg"; ?>" />
		</td>
		<td>
		<strong><?php echo "$pegawai[nama]";?><strong/>
		</td>
	</tr>
	<tr>	
		<td>
		<u>NIP:</u><br/>
		<?php echo "$pegawai[nip_baru]"; ?>
		</td>
	</tr>
	<tr>	
		<td>
		<u>Pangkat:</u><br/>
		<?php echo "$pegawai[pangkat_gol]"; ?>
		</td>
	</tr>
	<tr>	
		<td>
		<u>TTL:</u><br/>
		<?php echo "$pegawai[tempat_lahir], $pegawai[tanggal_lahir]"; ?>
		</td>
	</tr>
	<tr>	
		<td>
		<u>Alamat:</u><br/>
		<?php echo "$pegawai[alamat]; ";?>
		</td>
	</tr>
	<tr>	
		<td>
		<u>Telp:</u><br/>
		<?php echo "$pegawai[ponsel] <br/> $pegawai[telepon]"; ?>
		</td>
	</tr>
	<tr>	
		<td>
		<u>Unit Kerja:</u><br/>
		<?php echo "$pegawai[nama_baru]"; ?>
		</td>
	</tr>
	</table>
	<?
}	
else
{
	echo "Data pegawai dengan id $id tidak ditemukan.";
}		
?>



