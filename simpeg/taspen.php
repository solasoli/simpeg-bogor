<?php 
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=pegawai.xls");
	include("konek.php");
	$sql = "select * from pegawai where flag_pensiun = 0";
	$pegawais = mysql_query($sql);
?>
<table border=1>
	<tr>
		<td>NIP</td>
		<td>kdhubkel</td>
		<td>nmkel</td>
		<td>glrdpan</td>
		<td>glrbelakang</td>
		<td>kdjenkel</td>
		<td>tgllahir</td>
		<td>kdstawin</td>
		<td>tglnikah</td>
		<td>tglcerai</td>
		<td>tglwafat</td>
		<td>tglsks</td>
		<td>tatsks</td>
		<td>nosks</td>
		<td>kdtunjang</td>
		<td>nipsuamiistri</td>
		<td>alamat</td>
		<td>propinsi</td>
		<td>Kota/Kab</td>
		<td>Kec</td>
		<td>Desa/kel</td>
		<td>NoKTP</td>
		<td>npwp</td>
	</tr>
	<?php while($pegawai = mysql_fetch_object($pegawais)) { ?>
	<tr>
		<td><?php echo "'".$pegawai->nip_baru ?></td>
		<td>00</td>
		<td><?php echo $pegawai->nama ?></td>
		<td><?php echo $pegawai->gelar_depan ?></td>
		<td><?php echo $pegawai->gelar_belakang ?></td>
		<td><?php 
			//echo $pegawai->jenis_kelamin 
			if ($pegawai->jenis_kelamin == 'L')
				echo '1';
			elseif ($pegawai->jenis_kelamin == 'P')
				echo '2';
			else
				echo 'undefined';
			?>
		</td>
		<td><?php echo $pegawai->tgl_lahir ?></td>
		<td><?php echo $pegawai->status_kawin ?></td>
		<td><?php echo '-' ?></td>
		<td><?php echo '-' ?></td>
		<td><?php echo '-' ?></td>
		<td><?php echo '-' ?></td>
		<td><?php echo '-' ?></td>
		<td><?php echo '-' ?></td>
		<td><?php echo '-' ?></td>
		<td><?php echo '-' ?></td>
		<td><?php echo $pegawai->alamat ?></td>
		<td><?php echo '-' ?></td>
		<td><?php echo $pegawai->kota ?></td>
		<td><?php echo '-' ?></td>
		<td><?php echo '-' ?></td>
		<td><?php echo '-' ?></td>
		<td><?php echo $pegawai->npwp ?></td>
	</tr>
	<?php 
		$keluargas = mysql_query("select * from keluarga where id_pegawai = ".$pegawai->id_pegawai." and id_status in ('9','10') order by tgl_lahir ASC");
		$x = 11;
		while($keluarga = mysql_fetch_object($keluargas)){
	?>
		<tr>
			<td><?php echo "'".$pegawai->nip_baru ?></td>
			<td>
				<?php 
					if($keluarga->id_status == 9) 
						echo '10';
					else
						echo $x++;
					
				?>
			</td>
			<td><?php echo $keluarga->nama ?></td>
			<td><?php echo "" ?></td>
			<td><?php echo ''?></td>
			<td><?php 
					//echo $keluarga->jk 
					if($keluarga->jk == 'P')
						echo "2";
					elseif($keluarga->jk == 'L'){
						echo "1";
					}
				?></td>
			<td><?php echo $keluarga->tgl_lahir ?></td>
			<td></td>
			<td><?php echo $keluarga->tgl_menikah ?></td>
			<td><?php echo $keluarga->tgl_cerai ?></td>
			<td><?php echo '-' ?></td>
			<td><?php echo '-' ?></td>
			<td><?php echo '-' ?></td>
			<td><?php echo '-' ?></td>
			<td><?php 
				if ($keluarga->dapat_tunjangan == '1')
					echo '1';
				elseif ($keluarga->dapat_tunjangan == '0')
					echo '2';
				
				?></td>
			<td><?php echo '-' ?></td>
			<td><?php echo $pegawai->alamat ?></td>
			<td><?php echo '-' ?></td>
			<td><?php echo $pegawai->kota ?></td>
			<td><?php echo '-' ?></td>
			<td><?php echo '-' ?></td>
			<td><?php echo '-' ?></td>
			<td><?php echo '-' ?></td>
		</tr>
	
	<?php }} ?>
</table>
