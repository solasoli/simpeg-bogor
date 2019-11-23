<?php 
include "../library/format.php";
include "db.php";

try{
	$no_peserta = $_POST['no_peserta'];
	$q = mysql_query("select j.tanggal, j.sesi, ms.nik, register, no_peserta, nama, pen, s.Waktu 
			from jadwal_peserta j 
			inner join ms on ms.nik = j.nik
			inner join sesi_cat s on s.Sesi = j.sesi 
			where no_peserta = replace('$no_peserta', '-','')");
	$r = mysql_fetch_object($q);
	
}catch(Exception $e){
	die($e);
}



$format = new Format;

if(!$r){
		echo "<span class='alert alert-danger'>No Peserta anda tidak ditemukan / tidak lulus seleksi administrasi</span>";
}else{
?>
<br>
<div class="table-responsive">
	<table class="table table-bordered table-hover table-striped">
		<tr>
			<td class="col-md-6"><strong>NIK</strong></td>
			<td><?php echo $r->nik ?></td>
		</tr>
		<tr>
			<td><strong>No. Registrasi</strong></td>
			<td><?php echo $r->register ?></td>
		</tr>
		<tr>
			<td><strong>No. Peserta</strong></td>
			<td><?php echo $r->no_peserta ?></td>
		</tr>
		<tr>
			<td><strong>Nama</strong></td>
			<td><?php echo $r->nama ?></td>
		</tr>
		<tr>
			<td><strong>Jenjang Pendidikan</strong></td>
			<td><?php echo $r->pen ?></td>
		</tr>
		<tr>
			<td><strong>Hari, Tanggal</strong></td>
			<td><?php echo $format->hari($format->date_dmY($r->tanggal,"D")).", ".$format->date_dmY($r->tanggal) ?></td>
		</tr>
		<tr>
			<td><strong>Waktu</strong></td>
			<td><?php echo $r->Waktu.' ('.$r->sesi.')' ?></td>
		</tr>
		<tr>
			<td><strong>Lokasi</strong></td>
			<td><?php echo "SMKN 3 Kota Bogor, Jl. Raya Pajajaran No. 84 Kota Bogor"; ?></td>
		</tr>
	</table>
</div>
<?php
	}
?>
