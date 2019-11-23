<?php $unit_kerja = new Unit_kerja;
date_default_timezone_set("Asia/Jakarta");
 ?>


<h2>DAFTAR PEGAWAI YANG BELUM MEMBUAT SKP <?PHP echo date("Y"); ?> PADA <br><?php echo $unit_kerja->get_unit_kerja($unit['id_skpd'])->nama_baru ?><a href="#" class="btn btn-primary  hidden-print pull-right" onclick="window.print()">cetak</a></h2>

<?php

$es = mysqli_query($mysqli,"select j.eselon from pegawai p 
			 inner join jabatan j on j.id_j = p.id_j
			 where p.id_pegawai = $ata[id_pegawai]");
$es = mysqli_fetch_array($es);




if($es[0] == "V")
{
	$qo=mysqli_query($mysqli,"select p.nama, p.nip_baru, p.pangkat_gol, u.nama_baru,p.ponsel,p.os,tingkat_pendidikan,lembaga_pendidikan,jurusan_pendidikan,id_berkas,id_pendidikan k.* \n"
    . "from pegawai p \n"
	. "inner join pendidikan_terakhir on pendidikan_terakhir.id_pegawai=p.id_pegawai \n"
    . "inner join buffer_kelengkapan_berkas k on k.id_pegawai = p.id_pegawai \n"
    . "inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai\n"
    . "inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja\n"
    . "where flag_pensiun = 0 and u.id_unit_kerja = $unit[0]\n"
	. "order by p.pangkat_gol desc, p.tgl_lahir");
}
else
{
$qo=mysqli_query($mysqli,"select p.id_pegawai, p.jenjab, p.gelar_depan, p.nama, p.gelar_belakang, p.nip_baru, p.pangkat_gol, p.id_j, p.jabatan, u.nama_baru,p.ponsel,p.os,tingkat_pendidikan,lembaga_pendidikan,jurusan_pendidikan,id_berkas,id_pendidikan \n"
    . "from pegawai p \n"   
    . "left join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai\n"
	. "inner join pendidikan_terakhir on pendidikan_terakhir.id_pegawai=p.id_pegawai \n"
    . "inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja\n"
    . "where flag_pensiun = 0 and u.id_skpd = $unit[id_skpd]\n"
	. "order by p.pangkat_gol desc, p.tgl_lahir");

}



?>
<table id="list_pegawai" cellspacing="0" width="100%" class="display table table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>NIP</th>
		
			<th class="hidden-print">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$r=1;
			$jabatan = '';
			while($bata=mysqli_fetch_array($qo)){
			
			
			
			$tahun=date("Y");
			$qcek=mysqli_query($mysqli,"select count(*) from  skp_header where id_pegawai=$bata[0] and periode_awal like '$tahun%'");
			$cek=mysqli_fetch_array($qcek);
			
			if($cek[0]==0)
			{
			
				if($bata['id_j']!=NULL && $bata['jenjab'] == 'Struktural'){ 						
					$qjo=mysqli_query($mysqli,"select jabatan from jabatan where id_j=$bata[id_j]");					
					$ahab=mysqli_fetch_array($qjo);				
				}elseif($bata['id_j'] == NULL && $bata['jenjab'] == 'Struktural'){
									
					$sql = "select jfu_pegawai.*, jfu_master.* 
							from jfu_pegawai, jfu_master
							where jfu_pegawai.id_pegawai = '".$bata['id_pegawai']."'
							and jfu_master.kode_jabatan = jfu_pegawai.kode_jabatan";
										
					$qjo=mysqli_query($mysqli,$sql);
						
					$ahab=mysqli_fetch_array($qjo);
				}else{
				
					$ahab = $bata['jabatan'];	
						
				}
						
				$nama_full = $bata['gelar_depan'] ? $bata['gelar_depan'].' '.$bata['nama'] : $bata['nama'];
				$nama_full .= $bata['gelar_belakang'] ? ', '.$bata['gelar_belakang'] : '' ;
				
		
		?>
		<form name="formos<?php echo $r; ?>" id="formos<?php echo $r; ?>" enctype="multipart/form-data" >
			<input type="hidden" name="x" id="x" value="listpen.php" />
			<input type="hidden" name="idp" id="idp<?php echo $r ?>" value="<?php echo($bata["id_pegawai"]); ?>" />
			<tr>
			<td><?php echo $r ?></td>
			<td><?php echo $nama_full ?></td>
			<td><?php echo $bata["nip_baru"] ?></td>
		
			
			<td class="hidden-print">
				<!--input type="submit" class="btn btn-primary btn-md" value="simpan" /-->
				<a href="index3.php?x=box.php&od=<?php echo $bata[0]; ?>" class="btn btn-primary btn-md">Update</a>
			</td>						
		</tr>
		</form>	
		<?php $r++; }  } ?>
	</tbody>
</table>
<script type="text/javascript">
	
function simpan(x){
		
		//alert(x);		
		//$.post("listpen_update.php", $("#formos"+x).serialize(), function(data){
			//var formnya = document.querySelector("#formos" + x);
			var fileInput = document.querySelector("#fija" + x);
			//var fileInput = $("#formos"+x).find("input[name='fija']");
			console.log();
			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'listpen_update.php');

			xhr.upload.onprogress = function(e) 
			{
				/* 
				* values that indicate the progression
				* e.loaded
				* e.total
				*/
			};

			xhr.onload = function()
			{
				alert('upload complete, refresh page to complete task');
			};

			// upload success
			if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0))
			{
				// if your server sends a message on upload sucess, 
				// get it with xhr.responseText
				alert(xhr.responseText);
			}

			var form = new FormData();
			form.append('idpen', $("#idpen"+x).val());
			form.append('idp', $("#idp"+x).val());
			form.append('fija', fileInput.files[0]);

			xhr.send(form);
		//})	
		//.done(function(data){
			/*
			if(data == "1"){
				alert("berhasil");				
			}else{
				alert("gagal");
			}*/
		//	alert();
		//});
}
</script>
     
