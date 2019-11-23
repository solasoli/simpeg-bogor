<h2 style="margin-left: 20px;">ADMINISTRASI PENILAIAN PRESTASI KERJA ONLINE</h2>
<?php $this->load->view('skp/header'); ?>
<br>

<div class="container">
	<div class="grid">
		<table class="table dataTable" id="table-1">
			<thead>
				<tr>
					<th>No</th>
					<th>Nama/NIP/Pangkat-Gol</th>
					<th>Status</th>
					<th>Action</th>					
				</tr>				
			</thead>
			<tbody>
				<?php $n=1; foreach($pegawais as $pns){ ?>
				
				<tr>
					<td><?php echo $n++ ?></td>
					<td><?php echo $pns->nama."<br>".$pns->nip_baru." - ".$pns->pangkat_gol ?></td>
					<td><?php echo $pns->status ?></td>
					<td>
						<?php if($pns->status == 'ALLOWED'){ ?>
						<button class="danger" onclick="toggle_pegawai(<?php echo $pns->id_pegawai ?>)">Tutup</button>
						<?php }else{ ?>
								<button class="success" onclick="toggle_pegawai(<?php echo $pns->id_pegawai ?>)">Buka</button>
						<?php } ?>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">

	$(document).ready(function(){
		$("#table-1").dataTable();
	});
	function toggle_pegawai(id){
		
		$.post('<?php echo base_url('skp/toggle_pegawai') ?>',{id_pegawai: id })
		 .done(function(obj){
			 alert(obj);
			 window.location.reload();
		 });
	}
</script>