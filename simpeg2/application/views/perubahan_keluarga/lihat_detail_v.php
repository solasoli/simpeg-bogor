<h2>Detail Pengajuan</h2>
<hr/>

<div style="margin-left:3%; margin-right:3%;">
<?php
	//$rw = $detail->row();
?>
<p>Tanggal Pengajuan &nbsp;&nbsp;&nbsp;: <?php echo $this->uri->segment(3)?><br/>
   Jenis Pengajuan 	 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php $tj = $this->uri->segment(5); 
                       if($tj == 1 OR $tj == 2)
							echo "Penambahan";
						else if($tj == -1 OR $tj == -2)
							echo "Pengurangan";
					?><br/>
	<?php 
		//$data 	= $detail->row();
		
		$berkas = $berkas_dasar->row();
	?>
</p>

<br/><br/>
<h4>Berkas Dasar Pegawai</h4>

<table class="table bordered">
	<tr>
		<th align="center">Tanggal Update</th>
		<th align="center">Surat Pengantar Dari Unit Kerja</th>
		<th align="center">SK Terakhir</th>
		<th align="center">SKUM-PTK</th>
		<th align="center">Gaji Bulan Terkahir</th>
	</tr>
	<tr>
		<td align="center"><?php echo $berkas->tgl_update?></td>
		<td align="center"><a class="button info" href="<?php echo base_url();?>perubahan_keluarga/show_data<?php echo $surat_uk;?>" target="_blank"> Lihat</a>
		<td align="center"><a class="button info" href="<?php echo base_url();?>perubahan_keluarga/show_data<?php echo $sk_terakhir;?>" target="_blank">Lihat</a></td>
		<td align="center"><a class="button info"  href="<?php echo base_url();?>perubahan_keluarga/show_data<?php echo $skumptk;?>" target="_blank"> Lihat </a></td>
		<td align="center"><a class="button info"  href="<?php echo base_url();?>perubahan_keluarga/show_data<?php echo $gaji_terakhir;?>" target="_blank"> Lihat </a></td>
	</tr>
</table>

<br/><br/>
<h4>Data Pengajuan Keluarga</h4>
<table class="table table bordered">
	<tr>
		<th align="center">Nama</th>
		<th align="center">Status Hubungan</th>
		<th align="center">Surat Menikah</th>
		<th align="center">Surat Kelahiran Anak</th>
		<th align="center">Surat Keterangan Kuliah</th>
		<th align="center">Surat Keterangan Telah Bekerja</th>
		<th align="center">Surat Kematian</th>
		<th align="center">Surat Cerai</th>
		<th align="center">Keterangan</th>
	</tr>
	<?php
		foreach($detail->result() as $r)
		{
	?>
	<tr>
		<td align="center"><?php echo $r->nama; ?></td>
		<td align="center"><?php $st = $r->id_status;
							if($st == 9)
								echo "ISTRI/SUAMI";
							else if($st==10)
								echo "ANAK";
						?>
		</td>
		<?php if($st == 9 && ($tj == 2 || $tj == 1))
			  {
		?>
				<td align="center">
					<?php
						if($r->fc_surat_nikah != NULL)
						{
					?>
							<a class="button info" target="_blank" href="<?php echo base_url()?>perubahan_keluarga/show_data_penambahan<?php echo $surat_nikah?>">Lihat</a>
					<?php
						}
						else
						{
					?>
						 -
					<?php
						}
					?>
				</td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center"></td>
		<?php
			  }
			  else if($st == 10 && ($tj == 1 || $tj == 2))
			  {
		?>
				<td align="center">-</td>
				<td align="center">
					<?php if($r->fc_kelahiran_anak != NULL)
						  {
					?>
							<a class="button info" target="_blank" href="<?php echo base_url()?>perubahan_keluarga/show_data_penambahan<?php echo $kelahiran_anak?>">Lihat</a>
					<?php
						  }
						  else
							 echo "-";
					?>
				</td>
				<td align="center">
					<?php if($r->fc_keterangan_kuliah != NULL)
						  {
					?>
							<a class="button info" target="_blank" href="<?php echo base_url()?>perubahan_keluarga/show_data_penambahan<?php echo $ket_kuliah?>">Lihat</a>
					<?php
						  }
						  else
							 echo "-";
					?>
				</td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center"><?php echo $r->keterangan;?></td>
		<?php
			  }
			  else if($st == 9 && $tj = -1)
			  {
				  
		?>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center">
				</td>
				<td align="center">
					<?php
						if($r->fc_surat_kematian != NULL)
						{
					?>
						<a class="button info" target="_blank" href="<?php echo base_url()?>perubahan_keluarga/show_data_pengurangan<?php echo $surat_mati_si?>">Lihat</a>
					<?php
						}
						else
						{
							echo "-";
						}
					?>
				</td>
				<td align="center">
					<?php
						if($r->fc_surat_cerai != NULL)
						{
					?>
							<a class="button info" target="_blank" href="<?php echo base_url()?>perubahan_keluarga/show_data_pengurangan<?php echo $surat_cerai?>">Lihat</a>
					<?php
						}
						else
						{
							echo "-";
						}
					?>
				</td>
				<td align="center"><?php echo $r->keterangan;?></td>
		<?php
			  }
			  else if($st == 10 && $tj = -1)
			  {
		?>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center">-</td>
				<td align="center">
					<?php if($r->fc_keterangan_kerja != NULL)
						  {
					?>
						<a class="button info" target="_blank" href="<?php echo base_url()?>perubahan_keluarga/show_data_pengurangan<?php echo $ket_kerja?>">Lihat</a>
					<?php
					}
					else
					{
						echo "-";
					}
					?>
				</td>
				<td align="center">
					<?php
						if($r->fc_surat_kematian != NULL)
						{
					?>
							<a class="button info" target="_blank" href="<?php echo base_url()?>perubahan_keluarga/show_data_pengurangan<?php echo $surat_mati_ak?>">Lihat</a>
					<?php
						}
						else 
							echo "-";
					?>
				</td>
				<td align="center">
					<?php
						if($r->fc_surat_cerai != NULL)
						{
					?>
							<a class="button info" target="_blank" href="<?php echo base_url()?>perubahan_keluarga/show_data_pengurangan<?php echo $surat_cerai?>">Lihat</a>
					<?php
						}
						else
							echo "-"
					?>
				</td>
				<td align="center"><?php echo $r->keterangan;?></td>
		<?php
			  }
		?>
	</tr>	
	<?php
		}
	?>
</table>
<a class="button primary" href="<?php echo base_url()?>perubahan_keluarga/daftar_pengajuan_perubahan">Kembali</a>
</div>