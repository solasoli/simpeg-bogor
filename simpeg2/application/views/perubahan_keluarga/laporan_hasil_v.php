<div style="margin-top:20px;margin-left:10%;margin-right:10%;">
	<?php if($data_pegawai->num_rows() > 0)
	     {
	?>
		<div style="margin-left:90%"><button id="eksport_pdf">Eksport PDF</button></div>
	<?php 
	    }
	?>
	
	<input type="hidden" id="bulan2" value="<?php echo $this->input->get('bulan')?>">
	<input type="hidden" id="tahun2" value="<?php echo $this->input->get('tahun')?>">
<br/>
<table class="table bordered" id="daftar_pengajuan_perubahan">
<thead>
	<tr>
		<th rowspan="2">No</th>
		<th rowspan="2">Nama/NIP</th>
		<th rowspan="2">GOL/RUANG</th>
		<th rowspan="2">Unit Kerja</th>
		<th colspan="4" align="center">Pengurangan</th>
		<th colspan="4" align="center">Penambahan</th>
		<th rowspan="2">Keterangan Menjadi</th>
	</tr>
	<tr>
		<td colspan="2" align="center">SUAMI/ISTRI</td>
		<td colspan="2" align="center">Anak</td>
		<td colspan="2" align="center">SUAMI/ISTRI</td>
		<td colspan="2" align="center">Anak</td>
	</tr>
</thead>
<tbody>
<?php 
	$i = 1;
	$indek_ak_t 	= 0;
	$indek_si_t 	= 0;
	$indek_ak_k		= 0;
	$indek_si_k 	= 0;
	$indek_jk_si_t 	= 0;
	if($data_pegawai->num_rows() > 0)
	{
		foreach($data_pegawai->result() as $r)
		{
?>
<tr>
	<td><?php echo $i++; ?></td>
	<td> <?php echo $r->nama?>/ <?php echo $r->nip_baru?>
	</td>
	<td><?php echo $r->pangkat_gol ;?></td>
	<td><?php echo $r->nama_baru?></td>
	<td><?php echo $data_kurang_suami_istri[$indek_si_k++]?></td>
	<td>SUAMI/ISTRI</td>
	<td><?php echo $data_kurang_anak[$indek_ak_k++]?></td>
	<td>Anak</td>
	<td><?php echo $data_tambah_suami_istri[$indek_si_t++];?></td>
	<td>SUAMI/ISTRI</td>
	<td><?php echo $data_tambah_anak[$indek_ak_t++]?></td>
	<td>Anak</td>
	<td></td>
				<?php 
				}
			}
			else
			{
			?>
			<td colspan=14 align="center"><b>Tidak Ada Data</b></td>
			<?php
			}	
			?>
			</tr>
		
			
			</tbody>
	</table>

	
</div>
<script>
	$(document).ready(function(){
		//$('#daftar_pengajuan_perubahan').dataTable();
		$('#eksport_pdf').click(function(){
			
			window.location = 'get_laporan_by_bulan_tahun/'+$('#bulan2').val()+'/'+$('#tahun2').val();
		});
	});
</script>