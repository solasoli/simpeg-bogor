
<h2 style="margin-left: 20px;">ADMINISTRASI PENILAIAN PRESTASI KERJA ONLINE</h2>
<?php $this->load->view('skp/header'); ?>
<br>
<div class="grid fluid">
	<div class="row">		
		<div class="span12">
			<h3>Rekapitulasi Penilaian Prestasi Kerja PNS</h3>
			<table class="table bordered hovered striped" id="daftar_pegawai">
				<thead>
					<tr>
						<th>No</th>	
						<th>OPD</th>				
						<th>Jumlah PNS</th>
						<th>#SKP</th>
						<th>%</th>						
					</tr>
				</thead>
				<tbody>	
					<?php $x=1; foreach($list_skpd as $skpd){ ?>
					<tr>
						<td align="center"><?php echo $x++ ?></td>							
						<td ><?php echo $skpd->skpd ?></td>							
						<td ><?php echo $skpd->jml_pegawai ?></td>							
						<td ><?php echo $skpd->jml_skp ?></td>							
						<td ><?php echo round(($skpd->jml_skp) / ($skpd->jml_pegawai + $skpd->jml_skp) *100, 2)  ?></td>							
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
