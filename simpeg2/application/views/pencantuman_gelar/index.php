<div class="container">
	<p><h2>Pencantuman Gelar</h2></p>
	<table class="table  striped span12">
	<thead>
		<tr>
			<th rowspan="2">Tahun</th>
			<th colspan="12">Bulan</th>			
			<th rowspan="2">Jumlah</th>
		</tr>
		<tr>
			<th>Januari</th>
			<th>Februari</th>
			<th>Maret</th>
			<th>April</th>
			<th>Mei</th>
			<th>Juni</th>
			<th>Juli</th>
			<th>Agustus</th>
			<th>September</th>
			<th>Oktober</th>
			<th>November</th>
			<th>Desember</th>
		</tr>
	</thead>
	<tbody>
		<?php if(sizeof($rekap)>0): ?>
		<?php foreach($rekap as $r): ?>
		<tr>
			<td><?php echo $r->tahun ?></td>
			<td><?php echo $r->januari ?></td>
			<td><?php echo $r->februari ?></td>
			<td><?php echo $r->maret ?></td>
			<td><?php echo $r->april ?></td>
			<td><?php echo $r->mei ?></td>
			<td><?php echo $r->juni ?></td>
			<td><?php echo $r->juli ?></td>
			<td><?php echo $r->agustus ?></td>
			<td><?php echo $r->september ?></td>
			<td><?php echo $r->oktober ?></td>
			<td><?php echo $r->november ?></td>
			<td><?php echo $r->desember ?></td>
			<td><?php echo $r->jumlah ?></td>
		</tr>
		<?php endforeach; ?>
		<?php else:?>
		<tr>
			<td colspan="7">Tidak ada data yang dapat disajikan</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
	</table>
</div>
<!--  End of file index.php -->
<!--  Location: ./application/views/cuti/index.php  -->
