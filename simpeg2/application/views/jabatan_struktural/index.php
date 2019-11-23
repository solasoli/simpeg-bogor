<div class="container">
	<p><h2>Rekapitulasi Jabatan Struktural</h2></p>
	<table class="table bordered striped">
	<thead>
		<tr>
			<th >Eselon</th>
			<th >Jumlah</th>			
			<th >Terisi</th>
			<th >Kosong</th>
		</tr>
	</thead>
	<tbody>
		<?php $no=1; ?>
		<?php if(sizeof($rekap)>0): ?>
		<?php foreach($rekap as $r): ?>
		<?php if($no == sizeof($rekap)): ?>
		<tr>
			<td><strong>JUMLAH</strong></td>
			<td><strong><?php echo $r->total ?></strong></td>
			<td><strong><?php echo $r->ada ?></strong></td>			
			<td><strong><?php echo $r->kosong ?></strong></td>
		</tr>
		<?php else: ?>
		<tr>
			<td><?php echo $r->eselon ?></td>
			<td><?php echo $r->total ?></td>
			<td><?php echo $r->ada ?></td>			
			<td><?php echo $r->kosong ?></td>
		</tr>
		<?php endif; ?>
		<?php $no++; ?>
		<?php endforeach; ?>
		<?php else:?>
		<tr class="error">
			<td colspan="4">Tidak ada data yang dapat ditamnpilkan</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
	</table>
</div>

<div class="container">	
	<p><h2>Jabatan Kosong</h2></p>
	<table class="table bordered striped">
	<thead>
		<tr>
			<th>No</th>
			<th>Eselon</th>
			<th>Jabatan</th>
			<th>Unit Kerja</th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 1; ?>
		<?php if($jabatan_kosong): ?>
			<?php foreach($jabatan_kosong as $j): ?>
			<tr>
				<td><?php echo $no++; ?></td>
				<td><?php echo $j->eselon ?></td>
				<td><?php echo $j->jabatan ?></td>
				<td><?php echo $j->nama_baru ?></td>
			</tr>
			<?php endforeach; ?>
		<?php else: ?>
			<tr class="error">
			<td colspan="7">Tidak ada data yang dapat ditampilkan</td>
		</tr>
		<?php endif; ?>
	</tbody>
	</table>
	<?php echo anchor('jabatan_struktural/draft_pelantikan', 'Draft Pelantikan') ?>
</div>
<!--  End of file index.php -->
<!--  Location: ./application/views/hukuman_disiplin/index.php  -->