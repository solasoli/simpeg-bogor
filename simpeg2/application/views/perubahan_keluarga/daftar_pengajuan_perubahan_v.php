<div style="margin-left:10%; margin-right:10%;">
<h2 align="center">Daftar Pengajuan Perubahan Keluarga</h2>
<br/><br/>
<table class="table bordered" id="daftar_pengajuan_perubahan">
	<thead>
		<tr>
			<th>Tanggal Pengajuan</th>
			<th>NIP</th>
			<th>Nama Pegawai</th>
			<th>Jenis Pengajuan</th>
			<th>Status konfirmasi</th>
		</tr>
	</thead>
	<tbody>
	<?php 
		//if($daftar_pengajuan->num_rows() > 0)
		//{
			foreach($daftar_pengajuan->result() as $r)
			{
		 
	?>
				<tr>
					<td><?php echo $r->tgl_perubahan;?> <input type="hidden" id="jumlah" value=<?php echo $daftar_pengajuan->num_rows()?>></td>
					<td><?php echo $r->nip_baru;?></td>
					<td><?php echo $r->nama;?> </td>
					<td><?php $dt = $r->dapat_tunjangan;
							if($dt == 1 OR $dt == 2)
								echo "Penambahan";
							else if($dt == -1 OR $dt == -2)
								echo "Pengurangan";
						?>
						<?php 
							if($dt == 2 OR $dt == -2 )
							{
						?>
						<a class="button info"href="<?php echo base_url();?>perubahan_keluarga/lihat_detail/<?php echo $r->tgl_perubahan;?>/<?php echo $r->id_pegawai;?>/<?php echo $r->dapat_tunjangan?>">Lihat Detail</a>
						<?php
							}
						?>
					</td>
					<?php
						$k = $r->status_konfirmasi;
						if($k == 1)
						{
					?>
						<td><!--<label class="label label-primary">Pengajuan Disetujui</label>-->
							<?php if($dt == -1 OR $dt == -2)
							{
							?>
							<a class="button default" href="<?php echo base_url()?>perubahan_keluarga/surat_pengurangan/<?php echo $r->id_pegawai?>">Unduh Surat</a>
							<?php
							}
							else if($dt == 1 OR $dt == 2)
							{
							?>
								<a class="button default" href="<?php echo base_url()?>perubahan_keluarga/surat_penambahan/<?php echo $r->id_pegawai?>">Unduh Surat</a>
							<?php
							}
							?>
							
						</td>
					<?php
						}
						else if($k == -3)
						{
					?>
						<td><label class="label label-primary">Pengajuan Tidak Disetujui</label></td>
					<?php
						}
						else
						{
					?>
						<td><a class="button success" onclick="return confirm('Apakah Anda menyetujui ?');" href="setuju/<?php echo $dt?>/<?php echo $r->tgl_perubahan?>/<?php echo $r->id_pegawai?>">Setuju</a> &nbsp;&nbsp;<button id="<?php echo $dt . $r->tgl_perubahan . $r->id_pegawai  ; ?>" class="button danger tidak_setuju"> Tidak Setuju</button></td>
					<?php
						}
					?>
				</tr>
	<?php
			}	
		//}
		//else
		//{
	?>
			
	<?php 
		//}
	?>
	</tbody>
</table>
</div>

<script>
	
		$('#daftar_pengajuan_perubahan').dataTable({
				aaSorting : [[4,'desc']]
		});
	
	 $(".tidak_setuju").on('click', function(){

		if( this.id.substr(0,1) == "-")
		{
			var jns_perubahan = this.id.substr(0,2);
			var tgl_perubahan = this.id.substr(2,10);
			var id_pegawai 	  = this.id.substr(12);
		}else{
			var jns_perubahan = this.id.substr(0,1);
			var tgl_perubahan = this.id.substr(1,10);
			var id_pegawai 	  = this.id.substr(11);

		}
		$.Dialog({
			overlay: true,
			shadow: true,
			flat: true,
			draggable: true,
			icon: '<i class="icon-minus"></i>',
			title: 'Flat window',
			content: '',
			padding: 5,
			onShow: function(_dialog){
				var content = '<form class="user-input" method="post" action="<?php echo base_url()?>perubahan_keluarga/update_keterangan/' + jns_perubahan + "/" + tgl_perubahan + "/"+ id_pegawai + '" >' + 
						'<label>Alasan</label>' +
						'<div class="input-control textarea"><textarea name="ket" rows="5" cols="60" required placeholder="Masukkan keterangan" /></div>' +						
						'<div class="form-actions">' +
						'<button class="button primary">Simpan</button>&nbsp;'+
						'<button class="button" type="button" onclick="$.Dialog.close()">Batal</button> '+
						'</div>'+
						'</form>';

				$.Dialog.title("Tidak Setuju");
				$.Dialog.content(content);
			}
		});
	});
</script>