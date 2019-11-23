<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
	header("Content-type:application/vnd.ms-excel");
	header("Content-Disposition:attachment;filename=".str_replace(" ","_",$diklats->nama_diklat).".xls");
	
	
?>

<html>


<table class="table">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>NIP</th>
			<th>Jabatan</th>
		</tr>
	</thead>
	<tbody>
		<?php $x=1; foreach($details as $detail){ ?>
		<?php //$peg = $this->pegawai->get_by_id($diklat->id_pegawai) ?>
		<tr>
			<td><?php echo $x++; ?></td>
			<td><?php echo $detail->nama_lengkap ?></td>
			<td><?php echo '\''.$detail->nip_baru ?></td>
			<td><?php echo $detail->jabatan ?></td>
		</tr>
		<?php } ?>
	</tbody>
</table>
</html>