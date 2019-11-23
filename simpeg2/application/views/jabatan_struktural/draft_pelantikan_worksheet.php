			<strong>DAFTAR JABATAN</strong>
			<table class="table bordered striped" id="daftar_jabatan">
			<thead>
				<tr>
					<th>No</th>
					<th>Jabatan</th>
					<th>Eselon</th>
					<th>Pegawai</th>
					<th>&nbsp;</th>					
				</tr>
			</thead>
			<?php if(is_array($jabatan) && sizeof($jabatan) > 0): ?>
				<?php $i=1;?>
				<?php foreach($jabatan as $huk): ?>
				<?php if($huk->nama_pegawai!='' and $huk->nama_pegawai!='Kosong'): ?>
					<tr>
				<?php else: ?>
					<tr class="ribbed-amber">
				<?php endif; ?>
					<td><?php echo $i++;?></td>
					<td><?php echo $huk->jabatan ?></td>
					<td><?php echo $huk->eselon ?></td>
					<td><?php echo ($huk->nama_pegawai==''?'Kosong':$huk->nama_pegawai); ?></td>
					<td><?php echo anchor('jabatan_struktural/isi_draft_jabatan/'.$huk->id_draft.'/'.$huk->id_j, "Ganti", array("class" => "button bg-green fg-white")); ?></td>					
				</tr>
				<?php endforeach; ?>
			<?php else: ?>
				<tr class="error">
					<td colspan="5"><i>Tidak ada data</i></td>
				</tr>
			<?php endif; ?>		
			</table>
			
<script>
	$(function(){
		$('#daftar_jabatan').dataTable();
	});
</script>