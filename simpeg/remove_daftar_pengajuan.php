<?php
include "header.php";
extract($_REQUEST);

if(isset($id_pengajuan))
{
	$qDelete = "DELETE FROM pengajuan WHERE id_pengajuan = $id_pengajuan";
	
	if(mysql_query($qDelete))
	{
	?>
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Data Dihapus</strong><br/>
			Data pengajuan berhasil dihapus.
		</div>
	<?php	
	}
	else 
	{
		?>
		<div class="alert alert-error">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<strong>Penghapusan error</strong><br/>
			Terjadi error ketika mencoba melakukan penghapusan data pengajuan. Silahkan coba kembali atau hubungi administrator SIMPEG.
		</div>
		<?php
		
	}

	include "daftar_pengajuan_kp.php";
}
else 
{
	?>
	<div class="alert alert-warning">
		<strong>Tidak ada pengajuan yang dipilih</strong><br/>
		Silahkan pilih pengajuan yang akan dihapus.
	</div>
	<a href="" class="btn" onclick="history.back()">Kembali</a>
	<?php
}

include "sidebar.php";
include "footer.php";
?>