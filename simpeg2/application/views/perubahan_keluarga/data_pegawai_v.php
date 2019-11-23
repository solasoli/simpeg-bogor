<div style="margin-left:5%; margin-right:5%;">
<h2>Data Keluarga Pegawai</h2>
<hr/>
<br/>
<input type="hidden" id="id_p" value="<?php echo $this->uri->segment(3);?>">
<table cellpadding="7px">
	<tr>
		<td width="200px">NIP</td>
		<td width="30px">:</td>
		<td><?php echo $r->nip_baru;?></td>
	</tr>
	<tr>
		<td>Nama Pegawai</td>
		<td>:</td>
		<td><?php echo $r->nama?></td>
	</tr>
</table>
<br/>
<br/>
<div style="margin-left:32%;">
<button class="button primary" id="tambah_jiwa"><i class="icon-plus"></i>&nbsp; Penambahan Jiwa</button>
<button class="button info" id="berkas_dasar">Unggah Berkas Dasar</button>
<button class="button default" id="unduh_surat"><i class="icon-file-pdf"></i> &nbsp;Surat Perubahan Keluarga</button>
<button class="button default" id="surat_pengajuan"><i class="icon-file-pdf"></i> Surat Pengajuan</button>
<button class="button default" id="riwayat_surat"><i class="icon-file"></i> &nbsp; Riwayat Surat</button>
<input type="hidden" name="id_pegawai" id="id_pegawai" value='<?php echo $r->id_pegawai;?>'>
</div>

<!--Data Suami atau Istri-->
<h3>Data Istri/Suami</h3>
<table class="table bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Tempat <br/> Lahir</th>
			<th>Tanggal<br/>Lahir</th>
			<th>Tanggal <br/>Menikah</th>
			<th>Akte <br/>Menikah</th>
			<th>Pekerjaan</th>
			<th>Jenis <br/>Kelamin</th>
			<th>Status<br/> Tunjangan</th>
			<th>Keterangan</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
<?php
	//$jumlah_baris = $keluarga_suami_istri->num_rows();
	$index_si=0;
	$j = 1;
	if($keluarga_suami_istri->num_rows() > 0)
	{
		foreach($keluarga_suami_istri->result() as $r)
		{
?>
		<tr>
			
			<td><?php echo $j++?></td>
			<td><?php echo $r->nama?></td>
			<td><?php echo $r->tempat_lahir?></td>
			<td><?php echo $r->tgl_lahir?></td>
			<td><?php echo $r->tgl_menikah?></td>
			<td><?php echo $r->akte_menikah?></td>
			<td><?php echo $r->pekerjaan?></td>
			<td><?php $jekel = $r->jk;
					  if($jekel == 1)
						echo "Laki-laki";
					  else if($jekel == 2)
						echo "Perempuan";
				?>
			</td>
			<td><?php $dt = $r->dapat_tunjangan;
					if($dt == 1)
						echo 'Dapat Tunjangan';
					else if ($dt == 0 || $dt == -1)
						echo 'Tidak Dapat Tunjangan';
				?>	
			</td>
			<td><?php echo $r->keterangan?></td>
			<td>
				<a class="button"  href="<?php echo base_url();?>perubahan_keluarga/edit_data_keluarga/<?php echo $r->id_keluarga?>/<?php echo $r->id_pegawai?>/<?php echo $r->id_status?>">
					<i class="icon-pencil"></i> Ubah
				</a>
				<a class="button danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ?');" href="<?php echo base_url();?>perubahan_keluarga/delete_data_keluarga/<?php echo $r->id_keluarga?>/<?php echo $r->id_pegawai?>"><i class="icon-remove"></i> Hapus</a>
				<?php
					if($dt == 1)
					{
				?>
				<a class="button warning" href="<?php echo base_url();?>perubahan_keluarga/pengurangan_jiwa/<?php echo $r->id_keluarga?>/<?php echo $r->id_status;?>/<?php echo $this->uri->segment(3)?>"><i class="icon-minus"></i> Pengurangan Jiwa</a>
				<?php
					}
				?>
			</td>
		</tr>
<?php
		}
	}
	else
	{
?>
	<tr>
			<td colspan="11" align="center"><b>Tidak Ada Data</b></td>
			
		</tr>
	</tbody>
<?php 
	}
?>
</table>
<br/>

<!--Data Anak-->
<h3>Data Anak</h3>
<table class="table bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Tempat <br/>Lahir</th>
			<th>Tanggal <br/>Lahir</th>
			<th>Pekerjaan</th>
			<th>Jenis <b/>Kelamin</th>
			<th>Dapat <br/>Tunjangan</th>
			<th>Keterangan</th>
			<th>Status <br/> Berkas</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
<?php 
		$jumlah_baris = $keluarga_suami_istri->num_rows();
		$index_anak = 0;
		if($keluarga_anak->num_rows() > 0)
		{
			$i=1;
			
			foreach($keluarga_anak->result() as $r)
			{
				
?>
		<tr>
			<td>
				<?php echo $i;
				$i++;?>
			</td>
			<td><?php echo $r->nama?></td>
			<td><?php echo $r->tempat_lahir?></td>
			<td><?php echo $r->tgl_lahir?></td>
			<td><?php echo $r->pekerjaan?></td>
			<td><?php 
					$jekel = $r->jk;
					  
					if($jekel == 1)
						echo "Laki-laki";
					else if($jekel == 2)
						echo "Perempuan";
				?>
			</td>
			<td><?php $dt = $r->dapat_tunjangan;
						if($dt == 1)
							echo 'Dapat Tunjangan';
						else if ($dt == 0 || $dt == -1)
							echo 'Tidak Dapat Tunjangan';
				?>
			</td>
			<td><?php echo $r->keterangan;?></td>
			<?php 
				if($status_ak[$index_anak] == 1 && $dt == 1)
				{
					$index_anak++;
					
			?>
					<td><div style='background:grey;color:white;'>Berkas Sudah Lengkap</div></td>
			<?php
				}
				else if($status_ak[$index_anak] == 0 && $dt == 1)
				{
					$index_anak++;
			?>
					<td><a  class="button default" href="<?php echo base_url()?>perubahan_keluarga/lengkapi_berkas_anak/<?php echo $r->id_keluarga?>/<?php echo $this->uri->segment(3)?>">Lengkapi Berkas</a></td>
			<?php
				}
				else
				{
					$status_ak[$index_anak];
			?>
					<td>-</td>
			<?php
				}
			?>
			<td>
				<a class="button"  href="<?php echo base_url();?>perubahan_keluarga/edit_data_keluarga/<?php echo $r->id_keluarga?>/<?php echo $r->id_pegawai?>/<?php echo $r->id_status?>">
							<i class="icon-pencil"></i> Ubah
				</a>
				<a class="button danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ?');" href="<?php echo base_url();?>perubahan_keluarga/delete_data_keluarga/<?php echo $r->id_keluarga?>/<?php echo $r->id_pegawai?>">
					<i class="icon-remove"></i> Hapus
				</a>
				<?php
					if($dt == 1)
					{
				?>
				<a class="button warning" href="<?php echo base_url();?>perubahan_keluarga/pengurangan_jiwa/<?php echo $r->id_keluarga?>/<?php echo $r->id_status;?>/<?php echo $this->uri->segment(3)?>">
					<i class="icon-minus"></i> Pengurangan Jiwa
				</a>
				<?php
					}
				?>
			</td>
		</tr>
<?php
			}
		}
		else
		{
?>
		<tr>
			<td colspan="10" align="center"><b>Tidak Ada Data</b></td>
			
		</tr>
<?php
		}
?>
	</tbody>
</table>
<br/><br/>
<!--Data Keluarga Lainnya-->
<h3>Data Anggota Keluarga Lainnya</h3>
<table class="table bordered">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Tempat <br/>Lahir</th>
			<th>Tanggal <br/>Lahir</th>
			<th>Pekerjaan</th>
			<th>Jenis <b/>Kelamin</th>
			<th>Keterangan</th>
			<th>Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$k = 1;
			if($keluarga_lainnya->num_rows()>0)
			{
				foreach($keluarga_lainnya->result() as $r)
				{
		?>
				<tr>
					<td>
						<?php echo $k;
						$k++;?>
					</td>
					<td><?php echo $r->nama?></td>
					<td><?php echo $r->tempat_lahir?></td>
					<td><?php echo $r->tgl_lahir?></td>
					<td><?php echo $r->pekerjaan?></td>
					<td><?php 
							$jekel = $r->jk;
							  
							if($jekel == 2)
								echo "Perempuan";
							else if($jekel == 1)
								echo "Laki-laki";
						?>
					</td>
					<td><?php echo $r->keterangan;?></td>
					<td><a class="button"  href="<?php echo base_url();?>perubahan_keluarga/edit_data_keluarga/<?php echo $r->id_keluarga?>/<?php echo $r->id_pegawai?>/<?php echo $r->id_status?>">
							<i class="icon-pencil"></i> Ubah
						</a>
						<a class="button danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ?');" href="<?php echo base_url();?>perubahan_keluarga/delete_data_keluarga/<?php echo $r->id_keluarga?>/<?php echo $r->id_pegawai?>">
							<i class="icon-remove"></i> Hapus
						</a>
					</td>
			</tr>
		<?php
				}
			}
			else
				echo "<td colspan='8' align='center'>Tidak Ada Data</td>"
		?>
	</tbody>
	
</table>
</div>
<script>
	$(document).ready(function(){
		$('#tambah_jiwa').click(function(){
			window.location = '<?php echo base_url();?>perubahan_keluarga/penambahan_jiwa/'+$('#id_pegawai').val();
		});
		
		// $('#unduh_surat').click(function(){
			// window.location = '<?php echo base_url();?>perubahan_keluarga/pilih_surat_terbaru/'+$('#id_pegawai').val();
		// });
		
		$('#riwayat_surat').click(function(){
			window.location = '<?php echo base_url();?>perubahan_keluarga/riwayat_surat/'+$('#id_pegawai').val();
		});
		
		$('#berkas_dasar').click(function(){
			window.location = '<?php echo base_url();?>perubahan_keluarga/berkas_dasar/'+$('#id_pegawai').val();
		});
		
		  $("#unduh_surat").on('click', function(){
                            $.Dialog({
                                overlay: true,
                                shadow: true,
                                flat: true,
                                draggable: true,
                                title: 'Coba CEK',
                                content: '',
								width:250,
                                padding: 10,
                                onShow: function(_dialog){
                                    var content = '<div><button class="button info large" id="tambah">Surat Penambahan Keluarga</button></div><br/>'+
														'<button class="button info large" id="kurang"></i> Surat Pengurangan Keluarga</button>'+
												  '</form>';

                                    $.Dialog.title("Pilih Jenis Surat Terbaru");
                                    $.Dialog.content(content);
                                }
								
                            });
							
							$('#tambah').click(function(){
								window.location = '<?php echo base_url();?>perubahan_keluarga/surat_penambahan/'+ $('#id_pegawai').val();
							});
	
							$('#kurang').click(function(){
								window.location = '<?php echo base_url()?>perubahan_keluarga/surat_pengurangan/'+$('#id_pegawai').val();
							});
                        });
				
				 $("#surat_pengajuan").on('click', function(){
                            $.Dialog({
                                overlay: true,
                                shadow: true,
                                flat: true,
                                draggable: true,
                                title: 'Coba CEK',
                                content: '',
								width:250,
                                padding: 10,
                                onShow: function(_dialog){
                                    var content = '<div><button class="button info large" id="tambah">Surat pengajuan Penambahan</button></div><br/>'+
														'<button class="button info large" id="kurang"></i> Surat Pengajuan Pengurangan</button>'+
												  '</form>';

                                    $.Dialog.title("Pilih Jenis Surat Terbaru");
                                    $.Dialog.content(content);
                                }
								
                            });
							
							$('#tambah').click(function(){
								window.location = '<?php echo base_url();?>perubahan_keluarga/surat_pengajuan/'+ $('#id_pegawai').val()+'/1';
							});
	
							$('#kurang').click(function(){
								window.location = '<?php echo base_url()?>perubahan_keluarga/surat_pengajuan/'+$('#id_pegawai').val()+'/-1';
							});
                        });
	});
</script>