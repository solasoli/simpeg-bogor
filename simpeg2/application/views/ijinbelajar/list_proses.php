<?php $this->load->view('layout/header');	 ?>

<h2>Daftar Ijin Belajar Cetak</h2>
<br>
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" class="table bordered hovered" id="iblist">
  <thead>  
	  <tr>
		<th rowspan="2" align="center">No</th>
		<th rowspan="2">Nama/NIP<br>Golongan(TMT)</th>				
		<th rowspan="2">Jabatan</th>
		<th rowspan="2">OPD</th>
		<th colspan="2" align="center">Pendidikan Terakhir</th>
		<th colspan="3" align="center">Pendidikan Lanjutan</th>		
		<th rowspan="2" align="center">Status</th>
		<th rowspan="2" align="center">Tgl Pengajuan</th>
		<th rowspan="2" align="center">Aksi</th>
	  </tr>
	  <tr>
		<th>Program</th>
		<th>Jurusan</th>
		<th>Program</th>
		<th>Jurusan</th>
		<th align="center">Institusi<br>(Akreditasi)</th>
	</tr>
   </thead>
   <tbody>
  <?php
  $i=1;
  foreach($daftar as $d) { ?>
	  
	<tr class="<?php echo $d->kelas ?>">
		<td><?php echo $i ?></td>
		<td><?php echo $d->nama."<br>".$d->nip_baru."<br>".$d->pangkat_gol." ".($d->tmt) ?></td>	  	  	  
		<td><?php echo $d->jfu ?></td>
		<td><?php echo $d->nama_baru ?></td>
		<td align=center><?php echo $d->tp ?></td>
		<td><?php echo $d->jp ?></td>
		<td align=center><?php echo $d->tp2 ?></td>
		<td><?php echo $d->jp2 ?></td>
		<td align=center><?php echo $d->ip2." ".($d->akre) ?></td>
		<td><?php echo $d->status ?>
			<input type=hidden name=surat$i id=surat$i value='<?php echo $d->nosurat ?>' >	  
		</td>
		<td><?php echo $d->tgl_pengajuan ?></td>
		<td nowrap align=center>	
			
			<button title="Periksa Kelengkapan Persyaratan"  id="zoom<?php echo($i); ?>" class="button inverse" >Lihat berkas</button>
			<br>
			<button  id="beforeprint<?php echo($i); ?>" onclick="cetak(<?php echo($i); ?>)" title="Cetak Ijin Belajar" class="button warning">cetak</button>
			<br>
			<?php  if($d->status=="Diajukan") {?>
				<a href="<?php echo base_url("ib/acc/".$d->idp)?>" title='ACC Pengajuan Ijin Belajar'>ACC</a>	  
			<?php } elseif($d->status=="Diproses") ?>
				<a href="<?php echo base_url("ib/jadi/".$d->idp) ?>" title='Surat Ijin Belajar Sudah Jadi' class="button primary">Selesai</a> 
	  
			
     <input type="hidden" name="idp<?php echo($i); ?>" id="idp<?php echo($i); ?>" value="<?php echo $d->idp; ?>" />
     
      <input type="hidden" name="jab<?php echo($i); ?>" id="jab<?php echo($i); ?>" value="<?php echo $d->jabatan; ?>" />
    
           <br /> 
           
    
    <?php  $i++; } ?>
  </tbody>	
</table>
<script>

	$(document).ready(function(){
		
		$('#iblist').dataTable();
	});
	
	function cetak(j){
				
		$.Dialog({
			overlay: true,
			shadow: true,
			flat: true,
			draggable: true,
			title: 'Flat window',
			content: '',
			padding: 10,
			onShow: function(_dialog){
				var content = '<form method=post class="user-input" action="<?php echo base_url()."ib/cetak"; ?>" target="_blank">' +
					   
						'<div class="input-control text"><textarea name="nosurat" id="nosurat" cols="50" rows="5"></textarea><button class="btn-clear"></button></div>' +
					  
						'<div class="form-actions">' +
						'<br><br><br><br><button class="button primary">Cetak</button>'+
					   '<input type=hidden name="idp" id="idp" value="'+j+'" > '
						'</div>'+
						'</form>';

				$.Dialog.title("No Surat Dari Unit Kerja Pemohon");
				$.Dialog.content(content);
			}
		});
	}
		
		  
</script>
<?php $this->load->view('layout/footer'); ?>
