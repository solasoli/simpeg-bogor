<div>
<h2>Proses Cuti Online</h2>

<table class="table bordered hovered" id="proses_cuti">
<thead>
	<tr>
		<th rowspan="2">No</th>
		<th rowspan="2">Nama</th>
		<th rowspan="2">NIP</th>
		<th rowspan="2">Jenis Cuti</th>
		<th colspan="2">TMT</th>
		<th rowspan="2">Berkas</th>
		<th rowspan="2">Validasi</th>
		<th rowspan="2">Cetak Surat</th>
	</tr>
	<tr>
		<th>Awal</th>
		<th>Selesai</th>
	</tr>
</thead>
<tbody>
		
<?php if(sizeof($cuti) > 0): ?>
	<?php $j=0; ?>
	<?php $i=1; ?>
	<?php foreach($cuti as $cut): ?>

	<tr>		
		<td><?php echo $i++ ?></td>
		<td><?php echo $cut->nama ?></td>
		<td><?php echo $cut->nip_baru ?></td>
		<td><?php echo $cut->deskripsi ?></td>
		<td><?php echo $cut->tmt_awal ?></td>
		<td><?php echo $cut->tmt_selesai ?></td>

		<td>
			<!--<?php echo anchor("cuti/showdata". $berkas[$j]) ?>-->
			<a href="<?php echo site_url(); ?>cuti/showdata<?php echo $berkas[$j] ?>" class="icon-pictures obutton info">&nbsp;Cek Berkas</a>
		</td>
		<td><?php if($cut->status==2){ ?>
			<a href="<?php echo base_url();?>cuti/status?
				id_cuti=<?php echo $cut->id_cuti_pegawai ?>&id_jen=<?php echo $cut->id_jenis_cuti ?>
				&awal=<?php echo $cut->tmt_awal ?>
				&akhir=<?php echo $cut->tmt_selesai ?>
				&id_peg=<?php echo $cut->id_pegawai ?>" 
		><button class="icon-checkmark success">&nbsp;SETUJUI</button></a> <?php } elseif($cut->status==1){ echo "TELAH DISETUJUI";}?>
		<?php if($cut->status==2){ ?>
			<a href="<?php echo base_url();?>cuti/status_tidak?
				id_cuti=<?php echo $cut->id_cuti_pegawai ?>"
		><button class=" icon-cancel-2 warning">&nbsp;TIDAK SETUJU</button></a> <?php } elseif($cut->status==3){ echo "TIDAK DISETUJUI";}?>
		</td>
		<td>
<!--<a class="icon-printer button info" href="<?php echo base_url(); ?>cuti/view_surat_pengajuan">&nbsp;Surat Pengajuan</a>-->&nbsp;
<a class="icon-printer button info" href="<?php echo base_url(); ?>cuti/view_surat_cuti/<?php echo $cut->id_pegawai?>">&nbsp;Surat Cuti</a>
</td>
	</tr>
	<?php 
		$j++;
		endforeach; 
	?>

<?php else: ?>
	<tr>
		<td colspan="9"><i>Tidak ada data</i></td>
	</tr>
<?php endif; ?>
</tbody>
</table>
</div>
<script>
	$(function(){
		$('#proses_cuti').dataTable();
	
	});
</script>