<?php
/*keterangan flag
-------------------

**status dapat_tunjangan
-2 : pengurangan belum disetujui
-1 : pengurangan telah disetujui
0  : tidak dapat tunjangan
1  : penambahan telah disetujui
2  : penambahan belum disetujui

**status konfirmasi
4 	: sedang diajukan
5 	: belum diajukan
1 	: pengajuan diterima
-3  :pengajuan ditolak
*/
include('./class/keluarga_class.php');
//include('./konek.php');

$keluarga = new Keluarga_class;

//$kl_peg		= $keluarga->get_all_keluarga_by_pegawai($od);
$k12 = $keluarga->get_tanggal_pengajuan($od);
//$i=1;

//get tgl pengajuan

?>
<h2>Daftar Pengajuan</h2>
<hr/>
<table class="table table-bordered">
	<thead>
	<tr>
		<th>Tanggal Pengajuan</th>
		<th>Jenis Pengajuan</th>
		<th>Nama yang Diajukan</th>
		<th>Status Pengajuan</th>
		<th>Keterangan</th>
	</tr>
	</thead>
	<tbody>
	<?php
		$tgl_sama = 0;
		$tgl_tmp = array();
		$i = 0;
		//$rw0 = mysql_fetch_object($kl_peg);
		if(mysql_num_rows($k12))
		{
		while($rw = mysql_fetch_object($k12))
		{
	?>
	<tr>

		<?php

			echo "<td >" .$rw->tgl_perubahan . "</td>" ;

		?>

		<td><?php $jp = $rw->dapat_tunjangan;
				if($jp == 1 OR $jp == 2)
					echo "Penambahan";
				else if($jp == -2 OR $jp == -1)
					echo "Pengurangan";
			?>
		</td>
		<td>
			<?php
				$tgl = $rw->tgl_perubahan;
				$data_keluarga_tambah = $keluarga->get_keluarga_penambahan($od, $tgl);
				$data_keluarga_kurang = $keluarga->get_keluarga_pengurangan($od, $tgl);

				if($rw->dapat_tunjangan == 1 || $rw->dapat_tunjangan == 2 )
				{
					while($rt = mysql_fetch_array($data_keluarga_tambah))
					{
						echo "- ".$rt['nama']."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					$dt = $rt['id_status'];
					if($dt == 9)
					{
						echo "<label class='label label-success'>Berkas Sudah Lengkap</label> ";
						if($rw->status_konfirmasi == -3)
						{
			?>
							<a href="index3.php?x=modul/ubah_ajukan_ulang.php&id_kel=<?php echo $rt['id_keluarga']?>&id_status=<?php echo $rt['id_status']?>&od=<?php echo $od?>&tun=<?php echo $rw->dapat_tunjangan?>">[Ubah Data]</a>
			<?php
						}
						echo "<br/>";
					}
					else if($dt == 10)
					{
						$id_kel = $rt['id_keluarga'];
						$ck 	= $keluarga->cek_berkas($id_kel, $dt);
						$rck	= mysql_fetch_object($ck);

						//mengecek umur
						$cek_upload = $keluarga->cek_umur_for_berkas($id_kel);
						$cku 		= mysql_fetch_array($cek_upload);
						$cu			= $cku['umur'];

						if(($rck->fc_keterangan_kuliah == NULL && $cu < 21)  || ($rck->fc_keterangan_kuliah != NULL && $cu > 21))
						{
			?>
						<label class='label label-success'>Berkas Sudah Lengkap</label><br/>
			<?php
						}
						else
						{
			?>
							<a class="btn btn-primary btn-sm" href="index3.php?x=modul/lengkapi_berkas.php&id_kel=<?php echo $id_kel;?>&id_status=<?php echo $dt?>&od=<?php echo $od;?>">Lengkapi Berkas</a>
			<?php
						}
						if($rw->status_konfirmasi == -3)
						{
			?>
							<a href="index3.php?x=modul/ubah_ajukan_ulang.php&id_kel=<?php echo $rt['id_keluarga']?>&id_status=<?php echo $rt['id_status']?>&od=<?php echo $od?>&tun=<?php echo $rw->dapat_tunjangan?>&ket=null">[Ubah Data]</a><br/>
			<?php
						}
					}
					}
				}
				else if($rw->dapat_tunjangan == -1 || $rw->dapat_tunjangan == -2 )
				{
					while($rk = mysql_fetch_array($data_keluarga_kurang))
					{
						echo "- ".$rk['nama'];
						if($rw->status_konfirmasi == -3)
						{


			?>
						<a href="index3.php?x=modul/ubah_ajukan_ulang.php&id_kel=<?php echo $rk['id_keluarga']?>&id_status=<?php echo $rk['id_status']?>&od=<?php echo $od?>&tun=<?php echo $rw->dapat_tunjangan?>&ket=<?php echo $rw->keterangan?>">[Ubah Data]</a>
			<?php
						}
						echo "<br/>";
					}
				}
			?>
		</td>
		<td>
			<?php
				if($rw->status_konfirmasi == 5 && ($rw->dapat_tunjangan == 2 OR $rw->dapat_tunjangan == -2))
				{
			?>
				<a onclick="return confirm('Anda yakin ingin mengajukan ?')" href="pk_ajukan_perubahan.php?tgl=<?php echo $rw->tgl_perubahan?>&dt=<?php echo $rw->dapat_tunjangan?>&od=<?php echo $od?>&del=true" class="btn btn-warning btn-sm">Ajukan Perubahan</a>
			<?php
				}
				else if($rw->status_konfirmasi == 4 && ($rw->dapat_tunjangan == -2 || $rw->dapat_tunjangan == 2 || $rw->dapat_tunjangan==1 || $rw->dapat_tunjangan == -1))
				{
			?>
					<label class="label label-warning">Sedang Diajukan</label>
			<?php
				}
				else if($rw->status_konfirmasi == 1 && ($rw->dapat_tunjangan == 1 || $rw->dapat_tunjangan == -1))
				{
			?>
					<a class="btn btn-info btn-sm" href="http://simpeg.kotabogor.go.id/simpeg2/perubahan_keluarga/riwayat_surat_by_tanggal/<?php echo $rw->tgl_perubahan?>/<?php echo $rw->dapat_tunjangan?>/<?php echo $od?>">Unduh Surat</a>
			<?php
				}
				else if($rw->status_konfirmasi == -3)
				{
			?>
					<label class="label label-danger"> Pengajuan Ditolak</label> &nbsp;&nbsp;

			<?php
				}
			?>
		</td>
		<td>
			<?php
			$ket =  $rw->status_konfirmasi;
				if($ket == -3)
				{
					echo $rw->keterangan_penolakan;
			?>
				&nbsp;&nbsp;<a class="btn btn-warning btn-sm" href='pk_ajukan_ulang.php?tgl=<?php echo $rw->tgl_perubahan?>&od=<?php echo $od?>&tun=<?php echo $rw->dapat_tunjangan?>'>Ajukan Ulang</a>
			<?php
				}
			?>
		</td>

	<?php
	}
		}
		else
		{
	?>
			<td colspan="5"><center>Tidak Ada Daftar Pengajuan</center></td>
	<?php
		}
	?>
	</tr>
	</tbody>
</table>
<a class="btn btn-primary btn-sm" href="index3.php?x=modul/tambah_keluarga.php&od=<?php echo $od;?>">Kembali</a>
