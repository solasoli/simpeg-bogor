<?php $unit_kerja = new Unit_kerja; ?>


<h2>DAFTAR TELEPON PEGAWAI <br><?php echo $unit_kerja->get_unit_kerja($unit['id_skpd'])->nama_baru ?><a href="#" class="btn btn-primary  hidden-print pull-right" onclick="window.print()">cetak</a></h2>

<?php

$es = mysqli_query($mysqli,"select j.eselon from pegawai p 
			 inner join jabatan j on j.id_j = p.id_j
			 where p.id_pegawai = $ata[id_pegawai]");
$es = mysqli_fetch_array($es);

//extract($_POST);
//if(isset($os) and isset($hp))
//mysqli_query($mysqli,"update pegawai set os='$os',ponsel='$hp' where id_pegawai=$idp");


if($es[0] == "V")
{
	$qo=mysqli_query($mysqli,"select p.nama, p.nip_baru, p.pangkat_gol, u.nama_baru,p.ponsel,p.os, k.* \n"
    . "from pegawai p \n"
    . "inner join buffer_kelengkapan_berkas k on k.id_pegawai = p.id_pegawai \n"
    . "inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai\n"
    . "inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja\n"
    . "where flag_pensiun = 0 and u.id_unit_kerja = $unit[0]\n"
	. "order by p.pangkat_gol desc, p.tgl_lahir");
}
else
{
$qo=mysqli_query($mysqli,"select p.id_pegawai, p.jenjab, p.gelar_depan, p.nama, p.gelar_belakang, p.nip_baru, p.pangkat_gol, p.id_j, p.jabatan, u.nama_baru,p.ponsel,p.os \n"
    . "from pegawai p \n"   
    . "left join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai\n"
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
			<th>No Ponsel</th>
			<th class="hidden-print">Sistem Operasi</th>
			
			<th class="hidden-print">Aksi</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$r=1;
			$jabatan = '';
			while($bata=mysqli_fetch_array($qo)){
			
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
		<form name="formos<?php echo $r; ?>" id="formos<?php echo $r; ?>" >
			<input type="hidden" name="x" id="x" value="listos.php" />
			<input type="hidden" name="idp" id="idp" value="<?php echo($bata["id_pegawai"]); ?>" />
			<tr>
			<td><?php echo $r ?></td>
			<td><?php echo $nama_full ?></td>
			<td><?php echo $bata["nip_baru"] ?></td>
			<td><input type="text" value="<?php echo $bata["ponsel"] ?>" name="hp" id="hp"></td>
		
			<td>
				<input type="radio" name="os" id="os" value="Android" <?php  if ($bata["os"]=="Android") echo "checked=checked"; ?> /> Android &nbsp;
				<input type="radio" name="os" id="os" value="BB" <?php  if ($bata["os"]=="BB") echo "checked=checked"; ?>/> Blackberry &nbsp;
				<input type="radio" name="os" id="os" value="Ios" <?php  if ($bata["os"]=="Ios") echo "checked=checked"; ?> /> Ios &nbsp;
				<input type="radio" name="os" id="os" value="Lainnya" <?php  if ($bata["os"]=="Lainnya") echo "checked=checked"; ?> /> Lainnya &nbsp;
			</td>
			
			
			<td class="hidden-print">
				<!--input type="submit" class="btn btn-primary btn-md" value="simpan" /-->
				<a onclick="simpan('<?php echo $r ?>')" class="btn btn-primary btn-md">simpan</a>
			</td>						
		</tr>
		</form>	
		<?php $r++; } ?>
	</tbody>
</table>
<script type="text/javascript">
	
function simpan(x){
		
		//alert(x);		
		$.post("listos_update.php",$("#formos"+x).serialize())	
		.done(function(data){
			
			if(data == "1"){
				alert("berhasil");				
			}else{
				alert("gagal");
			}
		});
		
		
}


</script>
     
