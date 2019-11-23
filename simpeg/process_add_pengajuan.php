<?php
session_start();
include "header.php";



include "konek.php";

$qInsertProcess = "INSERT INTO pengajuan
				   (
				   		tgl_pengajuan,
				   		id_pegawai,
				   		id_proses,
				   		tmt_proses
				   )
				   VALUES
				   (
				   		CURDATE(),
				   		$_SESSION[id_pegawai],
				   		$_POST[id_proses],
				   		'$_POST[tmt_proses]'
				   )";

if(mysql_query($qInsertProcess))
{
	?>
	<div class="alert alert-success">
		<strong>Pengajuan Sukses!</strong>
		<p>
			Proses pengajuan anda selesai. Setelah kami verifikasi, SK anda akan kami cetak.			
		</p>		
	</div>
	<a class="btn" href="<?php echo $_POST[fallback_url]; ?>">Kembali</a>
	<?php
	
}


include "sidebar.php";
include "footer.php";
?>