<?php
include("db.php");
extract($_POST);
$q = "select * from pegawai p inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja where (nip_baru = '$nip' or nip_lama = '$nip')";
$rsPeg = mysql_query($q);



if($peg = mysql_fetch_array($rsPeg))
{
	?>
	
	<table>
		<tr>
			<td>
				<img src="../foto/<?php echo $peg['id_pegawai'] ?>.jpg" width="100" />
			</td>							
		</tr>
		<tr>
			<td>
				Nama: 
			</td>
			<td>
				<?php echo $peg['nama']; ?>
			</td>
		</tr>
		<tr>
			<td>
				Golongan
			</td>
			<td>
				<?php echo $peg['pangkat_gol']; ?>
			</td>
		</tr>
		<tr>
			<td>
				SKPD
			</td>
			<td>
				<?php echo $peg['nama_baru']; ?>
			</td>
		</tr>
		<tr>
			<td>
				Jabatan
			</td>
			<td>
				<select id="cboJabatan" name="id_j" >
				<option value="0">-</option>
				<?php 
				$q = "select * from jabatan where tahun = 2011 order by jabatan";
				$rsJab = mysql_query($q);
				
				while($rJab = mysql_fetch_array($rsJab)){
				?>
				<option <?php if($rJab['id_j'] == $peg['id_j'] ) echo "selected" ?> value="<?php echo $rJab['id_j'] ?>"><?php echo $rJab['jabatan'] ?></option>
				<?
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
			
			</td>
			<td>
				<input type="submit" id="btnSave" value="Simpan" />
			</td>
		</tr>
	</table>
	
		
	<?php
}
else
{
	echo "Tidak ditemukan.";
}
?>

<script type="text/javascript" >
$(document).ready(function(){
	$("#btnSave").click(function(){	
		$("#btnSave").attr('value', 'Sedang menyimpan');
		$.post('save.php', { id_pegawai: <?php echo $peg['id_pegawai']; ?>, id_j: $("#cboJabatan").val() }, function(data){
			if(data)
				alert(data);
			else
				alert('ERROR!!.. Update gagal!');
		});		
		$("#btnSave").attr('value', 'Simpan');
	});
}); 
</script>