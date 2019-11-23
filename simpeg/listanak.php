<?php $unit_kerja = new Unit_kerja;
date_default_timezone_set("Asia/Jakarta");
 ?>


<h2>DAFTAR ANAK PEGAWAI <br><?php echo $unit_kerja->get_unit_kerja($unit['id_skpd'])->nama_baru ?> YANG BERUMUR 21 TAHUN KE ATAS<a href="#" class="btn btn-primary  hidden-print pull-right" onclick="window.print()">cetak</a></h2>

<?php



?>
<table id="list_pegawai" cellspacing="0" width="100%" class="display table table-striped">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Anak Dari</th>
            <th>Tgl Lahir</th>
            <th>Umur</th>
             <th>Dapat Tunjangan</th>
		
			<th class="hidden-print">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$r=1;
	$q=mysqli_query($mysqli,"SELECT keluarga.nama,keluarga.tgl_lahir,pegawai.nama, TIMESTAMPDIFF(YEAR, keluarga.tgl_lahir, curdate()) AS umur,dapat_tunjangan, pegawai.id_pegawai FROM keluarga inner join pegawai on pegawai.id_pegawai=keluarga.id_pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where id_Status=10  and TIMESTAMPDIFF(YEAR, keluarga.tgl_lahir, curdate())>=21 and flag_pensiun=0 and current_lokasi_kerja.id_unit_kerja=$unit[id_skpd] order by TIMESTAMPDIFF(YEAR, keluarga.tgl_lahir, curdate()) desc");
	
	//echo ("SELECT keluarga.nama,keluarga.tgl_lahir,pegawai.nama, TIMESTAMPDIFF(YEAR, keluarga.tgl_lahir, curdate()) AS umur FROM keluarga inner join pegawai on pegawai.id_pegawai=keluarga.id_pegawai inner join current_lokasi_kerja on pegawai.id_peagawai=current_lokasi_kerja.id_pegawai where id_Status=10  and TIMESTAMPDIFF(YEAR, keluarga.tgl_lahir, curdate())>=21 and flag_pensiun=0 and current_lokasi_kerja.id_unit_kerja=$unit[id_skpd] order by TIMESTAMPDIFF(YEAR, keluarga.tgl_lahir, curdate()) desc");
	while($data=mysqli_fetch_array($q))
				{
		
		?>
		
			<tr>
			<td><?php echo $r; ?></td>
			<td><?php echo $data[0]; ?></td>
			<td><?php echo $data[2]; ?></td>
            <td><?php 
			$tgl=substr($data[1],8,2);
			$bln=substr($data[1],5,2);
			$thn=substr($data[1],0,4);
			echo("$tgl-$bln-$thn");
			 ?></td>
             <td>
             <?php echo $data['umur']; ?>
             </td>
		<td align="center">
        
        <?php
		if($data[4]==1)
		echo("Dapat");
		else
		echo("Tidak");
		
		?>
        </td>
			
			<td class="hidden-print">
				<!--input type="submit" class="btn btn-primary btn-md" value="simpan" /-->
                <?php
					if($data[4]==1)
					{
					?>
				<a href="index3.php?x=box.php&od=<?php echo $data[5]; ?>" class="btn btn-primary btn-md">Ajukan Pengurangan</a>
			<?php
			}
			else
			{
			?>
            	<a href="index3.php?x=box.php&od=<?php echo $data[5]; ?>" class="btn btn-primary btn-md">Ajukan Penambahan</a>
            
            <?php
			}
			?>
            </td>						
		</tr>
		
		<?php $r++; } ?>
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
     
