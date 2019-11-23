<div>
	<p><h2>Rekapitulasi Pengambilan CUTI PNS</h2></p>
	<table class="table bordered striped">
	<thead>
		<tr>
			<th rowspan="2">Tahun</th>
			<th colspan="6">Jenis Cuti</th>			
			<th rowspan="2">Jumlah</th>
		</tr>
		<tr>
			<th>Tahunan</th>
			<th>Besar</th>
			<th>Sakit</th>
			<th>Bersalin</th>
			<th>Alasan Penting</th>
			<th>CLTN</th>
		</tr>
	</thead>
	<tbody>
		<?php if(sizeof($rekap)>0): ?>
		<?php foreach($rekap as $r): ?>
			<tr>
				<td><?php echo $r->tahun ?></td>
				<td><?php echo $r->tahunan ?></td>
				<td><?php echo $r->besar ?></td>
				<td><?php echo $r->sakit ?></td>
				<td><?php echo $r->bersalin ?></td>
				<td><?php echo $r->alasan_penting ?></td>
				<td><?php echo $r->cltn ?></td>
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

<div>
	<p><h2>Pegawai yang menjalani CLTN </h2></p>
	<table class="table bordered striped">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>NIP</th>
			<th>Golongan</th>
			<th>Jabatan</th>
			<th>SKPD</th>
			<th>Masa CLTN</th>
		</tr>
	</thead>
	<tbody>
		<?php if(isset($cltn)): ?>
		<?php $i=1; ?>
		<?php foreach($cltn as $c): ?>
		<tr>
			<td><?php echo $i++; ?></td>
			<td><?php echo $c->nama; ?></td>
			<td><?php echo $c->nip_baru; ?></td>
			<td><?php echo $c->pangkat_gol; ?></td>
			<td><?php echo $c->jabatan; ?></td>
			<td><?php echo $c->nama_baru; ?></td>
			<td><?php echo $c->tmt_awal; ?></td>
		</tr>
		<?php endforeach; ?>
		<?php else: ?>
		<tr>
			<td colspan="7">Tidak ada data yang dapat disajikan</td>
		</tr>
		<?php endif; ?>
	</tbody>
	</table>
</div>
<!--  End of file index.php -->
<!--  Location: ./application/views/cuti/index.php  -->
