<div>
	<p><h2>Rekapitulasi Penjatuhan Hukuman Disiplin</h2></p>
	<table class="table bordered striped">
	<thead>
		<tr>
			<th rowspan="2">Tahun</th>
			<th colspan="3">Tingkat Hukuman</th>			
			<th rowspan="2">Jumlah</th>
		</tr>
		<tr>
			<th>Ringan</th>
			<th>Sedang</th>
			<th>Berat</th>
		</tr>
	</thead>
	<tbody>
		<?php if(sizeof($rekap)>0): ?>
		<?php foreach($rekap as $r): ?>
		<tr>
			<td><?php echo $r->tahun ?></td>
			<td><?php echo $r->ringan ?></td>
			<td><?php echo $r->sedang ?></td>
			<td><?php echo $r->berat ?></td>
			<td><?php echo $r->jumlah ?></td>
		</tr>
		<?php endforeach; ?>
		<?php else:?>
		<tr class="error">
			<td colspan="7">Tidak ada data yang dapat disajikan</td>
		</tr>
		<?php endif; ?>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
	</table>
</div>

<div>
	<p><h2>Pegawai yang masih aktif menjalani hukuman disiplin penurunan pangkat</h2></p>
	<table class="table bordered striped">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>NIP</th>
			<th>Golongan</th>
			<th>Jabatan</th>
			<th>SKPD</th>
			<th>Masa Hukuman</th>
		</tr>
	</thead>
	<tbody>
		<tr class="error">
			<td colspan="7">Tidak ada data yang dapat disajikan</td>
		</tr>
	</tbody>
	</table>
</div>
<!--  End of file index.php -->
<!--  Location: ./application/views/hukuman_disiplin/index.php  -->