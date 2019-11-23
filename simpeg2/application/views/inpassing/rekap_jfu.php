<div class="container fluid">

	<legend><h2>Rekap JFU<small><?php echo date('Y') ?></small></h2></legend>
	<?php // print_r($this->jabatan->count_jfu("03.03.005")) ?>
	<table class="table" id="rekapJfu">		
		<thead>
		<tr>
			<th>No</th>
			<th>Kode Jabatan</th>
			<th>Jabatan</th>
			<th>Jumlah</th>
		</tr>
		</thead>
		<tbody>
		<?php $x=1; foreach($list_jfu as $list) { ?>
		<tr>
			<td><?php echo $x++ ?></td>
			<td><?php echo $list->kode_jabatan ?></td>
			<td><?php echo anchor('inpassing/rekap_jfu/'.$list->kode_jabatan,$this->jabatan->get_jfu_name($list->kode_jabatan)->nama_jfu) ?></td>
			<td><?php echo $this->jabatan->count_jfu($list->kode_jabatan)->jumlah ?></td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
	<br/>
	<?php if($this->uri->segment(3)) { ?>
	<div class="divider"></div>
	<legend><h2>Rekap Pegawai JFU <small><?php echo $this->jabatan->get_jfu_name($this->uri->segment(3))->nama_jfu ?></small></h2></legend>
	<table class="table" id="rekapJfu">		
		<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>NIP</th>
			<th>Unit Kerja</th>
		</tr>
		</thead>
		<tbody>
		
		<?php $x=1; foreach($list_pegawai as $listp) { ?>
		<tr>
			<td><?php echo $x++ ?></td>
			<td><?php echo $this->pegawai->get_by_id($listp->id_pegawai)->nama ?></td>
			<td><?php echo $this->pegawai->get_by_id($listp->id_pegawai)->nip_baru  ?></td>
			<td><?php echo $this->pegawai->get_by_id($listp->id_pegawai)->nama_baru ?></td>
		</tr>
		<?php } ?>
		</tbody>
	</table>
	<?php } ?>

<script>
	$(function(){
			$('#rekapJfu').dataTable();
		});
</script>