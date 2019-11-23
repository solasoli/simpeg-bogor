
 <script>
	$(function(){
	
	<?php 
	$url = explode(base_url(),"/");
	$tot=count($daftar); 
	for($j=1;$j<=$tot;$j++)
	{
	?>
	
	var idp<?php echo($j); ?> = $("#idp<?php echo($j); ?>").val();
	var jab<?php echo($j); ?> = $("#jab<?php echo($j); ?>").val();
	
		$("#beforeprint<?php echo($j); ?>").on('click', function(){
		   qw =  $("#surat<?php echo($j); ?>").val();
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
						   
							'<div class="input-control text"><textarea name="nosurat" id="nosurat" cols="50" rows="5">'+ qw +'</textarea><button class="btn-clear"></button></div>' +
						  
							'<div class="form-actions">' +
							'<br><br><br><br><button class="button primary">Cetak</button>'+
						   '<input type=hidden name="idp" id="idp" value="'+idp<?php echo($j); ?>+'" > '
							'</div>'+
							'</form>';

					$.Dialog.title("No Surat Dari Unit Kerja Pemohon");
					$.Dialog.content(content);
				}
			});
		});
		
		// cetak 
		$("#createFlatWindow<?php echo($j); ?>").on('click', function(){
			$.Dialog({
				overlay: true,
				shadow: true,
				flat: true,
				draggable: true,
				title: 'Flat window',
				content: '',
				padding: 10,
				onShow: function(_dialog){
					var content = '<form method=post class="user-input" action="<?php echo base_url()."ib/tolak"; ?>">' +
						   
							'<div class="input-control text"><textarea name="ket" id="ket" cols="50" rows="5"> </textarea><button class="btn-clear"></button></div>' +
						  
							'<div class="form-actions">' +
							'<br><br><br><br><button class="button primary">Tolak</button>'+
						   '<input type=hidden name="idp" id="idp" value="'+idp<?php echo($j); ?>+'" > '
							'</div>'+
							'</form>';

					$.Dialog.title("Alasan Penolakan");
					$.Dialog.content(content);
				}
			});
		});
		
		
		
		
		 $("#zoom<?php echo($j); ?>").on('click', function(){
			$.Dialog({
				overlay: true,
				shadow: true,
				flat: true,
				draggable: true,
				title: 'Flat window',
				content: '',
				padding: 10,
				onShow: function(_dialog){
					
					$.post('<?php echo base_url()."ib/cekspuk"; ?>', { idp: idp<?php echo($j); ?> }, function(data){
					
						if(data!="none")
						$("#syarat").append("<br><a href='/Simpeg/Berkas/"+ data +"' target='_blank' > Surat Pengantar dari Unit Kerja  </a>" );
						else
						$("#syarat").append("<br>Surat Pengantar dari Unit Kerja (belum diupoad) ");
					
					});
					
					$.post('<?php echo base_url()."ib/cekspal"; ?>', { idp: idp<?php echo($j); ?> }, function(data){
					
						if(data!="none")
						$("#syarat").append("<br><a href='/Simpeg/Berkas/"+ data +"' target='_blank' > Surat Pernyataan yang Ditandatangani oleh Atasan Langsung  </a>" );
						else
						$("#syarat").append("<br>Surat Pernyataan yang Ditandatangani oleh Atasan Langsung (belum diupoad) ");
					
					});
					
					$.post('<?php echo base_url()."ib/cekdp3"; ?>', { idp: idp<?php echo($j); ?> }, function(data){
					
						if(data!="none")
						$("#syarat").append("<br><a href='/Simpeg/Berkas/"+ data +"' target='_blank' > DP3 / Penilaian Prestasi Kerja Tahun Terakhir   </a>" );
						else
						$("#syarat").append("<br>DP3 / Penilaian Prestasi Kerja Tahun Terakhir (Belum Diupload)  ");
					
					});
					
					$.post('<?php echo base_url()."ib/cekmpt"; ?>', { idp: idp<?php echo($j); ?> }, function(data){
					
						if(data!="none")
						$("#syarat").append("<br><a href='/Simpeg/Berkas/"+ data +"' target='_blank' > Surat Keterangan Diterima / Masih Kuliah dari Perguruan Tinggi  </a>" );
						else
						$("#syarat").append("<br>Surat Keterangan Diterima / Masih Kuliah dari Perguruan Tinggi (Belum Diupload)  ");
					
					});
					
					$.post('<?php echo base_url()."ib/cekjk"; ?>', { idp: idp<?php echo($j); ?> }, function(data){
					
						if(data!="none")
						$("#syarat").append("<br><a href='/Simpeg/Berkas/"+ data +"' target='_blank' > Jadwal Perkuliahan Yang Masih Berlakui  </a>" );
						else
						$("#syarat").append("<br>Jadwal Perkuliahan Yang Masih Berlaku (Belum Diupload)  ");
					
					});
					
					
					
					$.post('<?php echo base_url()."ib/ceksk"; ?>', { idp: idp<?php echo($j); ?> }, function(data){
					
						if(data!="none")
						$("#syarat").append("<br><a href='/Simpeg/Berkas/"+ data +"' target='_blank' > SK Kenaikan Pangkat Terakhir  </a>" );
						else
						$("#syarat").append("<br>SK Kenaikan Pangkat Terakhir (belum diupoad) ");
					
					});
					
					$.post('<?php echo base_url()."ib/cekij"; ?>', { idp: idp<?php echo($j); ?> }, function(data){
					
						if(data!="none")
						$("#syarat").append("<br><a href='/Simpeg/Berkas/"+ data +"' target='_blank' > Ijazah  </a>" );
						else
						$("#syarat").append("<br>Ijazah (belum diupoad) ");
					
					});
					
					
					if (jab<?php echo($j); ?>=="Guru")
					{
							$.post('<?php echo base_url()."ib/cekajar"; ?>', { idp: idp<?php echo($j); ?> }, function(data){
					
						if(data!="none")
						$("#syarat").append("<br><a href='/Simpeg/Berkas/"+ data +"' target='_blank' > Jadwal Mengajar di Sekolah yang Bersangkutan  </a>" );
						else
						$("#syarat").append("<br>Jadwal Mengajar di Sekolah yang Bersangkutan (belum diupoad) ");
					
					});
					
					$.post('<?php echo base_url()."ib/cekajian"; ?>', { idp: idp<?php echo($j); ?> }, function(data){
					
						if(data!="none")
						$("#syarat").append("<br><a href='/Simpeg/Berkas/"+ data +"' target='_blank' > Kajian Kebutuhan Guru (untuk Guru S1 atau S2)  </a>" );
						else
						$("#syarat").append("<br>Kajian Kebutuhan Guru (untuk Guru S1 atau S2) (belum diupoad) ");
					
					});
						
						
					}
					
					var content = '<form method=post class="user-input span7" action="<?php echo base_url()."ib/proses"; ?>" style="height:230px !important">' +
						   
							'<div id=syarat class="input-control text">'+
							
							  
							'</div>' +
							
						
							'<div class="form-actions">' +
							'<br><br><button class="button primary">Proses</button>'+
							
							'&nbsp;<button class="button" type="button" onclick="$.Dialog.close()">Batal</button> '+
						   '<input type=hidden name="idp" id="idp" value="'+idp<?php echo($j); ?>+'" > '
							'</div>'+
							
							
							'</form>';

					$.Dialog.title("Persyaratan Ijin Belajar ");
					$.Dialog.content(content);
				}
			});
		});
		<?php
	}
	
	?>
  
	})
</script>
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-family: "Segoe UI Light_","Open Sans Light",Verdana,Arial,Helvetica,sans-serif;
font-size: 14px;
}
</style>
<h2>Daftar Pengajuan Ijin Belajar</h2>
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
		<th rowspan="2" align="center">EDIT</th>
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
	  
	<tr class="<?php echo $d->kelas ?> ">
<?php	  
echo(" 
		<td> $i</td>
	  <td> $d->nama<br>$d->nip_baru<br>$d->pangkat_gol ($d->tmt)</td>	  	  	  
	  <td> $d->jfu</td>
	  <td> $d->nama_baru</td>
	  <td align=center> $d->tp</td>
	  <td> $d->jp</td>
	  <td align=center> $d->tp2</td>
	  <td> $d->jp2</td>
	  <td align=center> $d->ip2 ($d->akre)</td>
	  <td> $d->status
	  <input type=hidden name=surat$i id=surat$i value='$d->nosurat' >
	  
	  </td>
	  <td>$d->tgl_pengajuan</td>
	  <td nowrap align=center>"); 
	  
	  if($d->status=="Disetujui")
	  {
	 ?>
      <button title="Periksa Kelengkapan Persyaratan"  id="zoom<?php echo($i); ?>" style="background-color: Transparent;
            background-repeat:no-repeat;" ><img src="<?php base_url() ?>images/zoom.png" width="20px" /> </button>
     <?php
	  }
	  elseif($d->status=="Diajukan")
	  echo("<a href=".base_url()."ib/acc/$d->idp title='ACC Pengajuan Ijin Belajar'><img src=".base_url()."images/cek.png width=20px /></a>");
	  
	   elseif($d->status=="Diproses")
	  echo("<a href=".base_url()."ib/jadi/$d->idp title='Surat Ijin Belajar Sudah Jadi'><img src=".base_url()."images/fin.png width=20px /></a>");
	  
	 ?>
     <input type="hidden" name="idp<?php echo($i); ?>" id="idp<?php echo($i); ?>" value="<?php echo $d->idp; ?>" />
     
      <input type="hidden" name="jab<?php echo($i); ?>" id="jab<?php echo($i); ?>" value="<?php echo $d->jabatan; ?>" />
      <?php
       if($d->status!="Diproses")
       {
		   ?>
    <br /> <button  id="createFlatWindow<?php echo($i); ?>" style="background-color: Transparent;
            background-repeat:no-repeat;" title="Tolak Ijin Belajar" ><img src="<?php base_url() ?>images/del.png" width="20px" /> </button>
            
     <?php
	   }
	   else
	   {
		   
		   ?>
           <br /> <button  id="beforeprint<?php echo($i); ?>" style="background-color: Transparent;
            background-repeat:no-repeat;" title="Cetak Ijin Belajar" ><img src="<?php base_url() ?>images/prin.png" width="20px" /> </button>`
           <?php
	  
		 
	   }
	  $i++;
	  
  }
  ?>
  </tbody>	
</table>
<script>

	$(document).ready(function(){
		
		$('#iblist').dataTable();
	});
</script>
