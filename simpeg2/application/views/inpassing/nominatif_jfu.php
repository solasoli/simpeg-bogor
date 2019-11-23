<div class="container">
	<h2>Daftar Nominatif</h2>
	<table class="table hovered bordered">
		<thead>
			<tr>				
				<th>No</th>
				<th>Nama</th>
				<th>NIP</th>
				<th>Gol/Ruang</th>
				<th>Jabatan Lama</th>
				<th>Jabatan Baru</th>
				<th>Unit Kerja</th>			
			</tr>
		</thead>
		<tbody>		
			<?php if(sizeof($nominatifs > 0)){ 
				$x =1;
				foreach($nominatifs as $peg){
			?>
			<tr>
				<td><?php echo $x++ ;?></td>
				<td><?php echo anchor(base_url('pegawai/edit/2/'.$peg->id_pegawai),$this->pegawai->get_by_id($peg->id_pegawai)->nama)?></td>
				<td><?php echo $this->pegawai->get_by_id($peg->id_pegawai)->nip_baru?></td>
				<td><?php echo $this->pegawai->get_by_id($peg->id_pegawai)->pangkat_gol?></td>
				<td><?php echo $this->pegawai->get_by_id($peg->id_pegawai)->jabatan?></td>
				<td><?php echo $this->pegawai->get_jabatan(0,$peg->id_pegawai)?></td>
				<td><?php echo $this->pegawai->get_by_id($peg->id_pegawai)->nama_baru?></td>
			<tr>
			<?php }}else { ?>
			<tr>
				<td colspan=7>tidak ada data</td>
			<tr>
			<?php } ?>
		</tbody>
	</table>
</div>