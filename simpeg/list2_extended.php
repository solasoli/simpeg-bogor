
<h1>DAFTAR PEGAWAI</h1>

<?php
$qu=mysqli_query($mysqli,"select id_unit_kerja from current_lokasi_kerja where id_pegawai=$ata[id_pegawai]");
$unit = mysqli_fetch_array($qu);

$es = mysqli_query($mysqli,"select j.eselon from pegawai p 
			 inner join jabatan j on j.id_j = p.id_j
			 where p.id_pegawai = $ata[id_pegawai]");
$es = mysqli_fetch_array($es);

if($es[0] == "V")
{
	$qo=mysqli_query($mysqli,"select p.nama, p.nip_baru, p.pangkat_gol, u.nama_baru, k.* \n"
    . "from pegawai p \n"
    . "inner join buffer_kelengkapan_berkas k on k.id_pegawai = p.id_pegawai \n"
    . "inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai\n"
    . "inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja\n"
    . "where flag_pensiun = 0 \n"
	. "order by p.pangkat_gol desc, p.tgl_lahir");
}	
else
{
$qo=mysqli_query($mysqli,"select 
		p.id_pegawai, 
		p.jenjab, 
		p.gelar_depan, 
		p.nama, 
		p.gelar_belakang, 
		p.nip_baru, 
		p.pangkat_gol, 
		p.id_j, 
		p.jabatan, u.nama_baru \n"
    . "from pegawai p \n"   
    . "left join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai\n"
    . "inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja\n"
    . "where flag_pensiun = 0 \n"
	. "order by p.pangkat_gol desc, p.tgl_lahir");
}
?>
<table id="list_pegawai" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>NIP</th>
			<th>Golongan</th>
			<th>New Gol</th>
			<th>TMT</th>
			<th>Jabatan</th>
			<th>Unit Kerja</th>
		</tr>
	</thead>
	<tbody>
		<?php
			$r=1;
			$jabatan = '';
			while($bata=mysqli_fetch_array($qo)){
			
				if($bata[id_j]!=NULL && $bata[jenjab] == 'Struktural'){ 
						
					$qjo=mysqli_query($mysqli,"select jabatan from jabatan where id_j=$bata[id_j]");
					
					$ahab=mysqli_fetch_array($qjo)[0];
				
				}elseif($bata[id_j] == NULL && $bata[jenjab] == 'Struktural'){
				
					$sql = "select jfu_pegawai.*, jfu_master.* 
							from jfu_pegawai, jfu_master
							where jfu_pegawai.id_pegawai = '".$bata['id_pegawai']."'
							and jfu_master.kode_jabatan = jfu_pegawai.kode_jabatan";
										
					$qjo=mysqli_query($mysqli,$sql);
						
					$ahab=mysqli_fetch_array($qjo)['nama_jfu'];
				}else{
				
					$ahab = $bata[jabatan];	
						
				}
						
				$nama_full = $bata[gelar_depan] ? $bata[gelar_depan].' '.$bata[nama] : $bata[nama];
				$nama_full .= $bata[gelar_belakang] ? ', '.$bata[gelar_belakang] : '' ;
				
				
				$last_gol_query = "select *
									from sk
									where id_pegawai = '".$bata['id_pegawai']."'
									and id_kategori_sk in ('5','6')
									and tmt = (select max(tmt) from sk where id_kategori_sk in ('5','6') and id_pegawai = '".$bata['id_pegawai']."' )";
				//var_dump($last_gol_query);
				//echo "</br>";
				$row = mysqli_fetch_array(mysqli_query($mysqli,$last_gol_query));
		
				list($last_gol, $mk_tahun, $mk_bulan) = explode(',',$row['keterangan']);
				
				if($last_gol != $bata["pangkat_gol"]){
		?>
		<tr>
			<td><?php echo $r ?></td>
			<td><a href='index3.php?x=box.php&od=<?php echo $bata[id_pegawai] ?>' id='<?php echo $bata[id_pegawai]?>'><?php echo $nama_full ?></a></td>
			<td><?php echo $bata["nip_baru"] ?></td>
			<td><?php echo $bata["pangkat_gol"] ?></td>
			<td><?php echo $last_gol ?></td>
			<td><?php echo $row['tmt'] ?></td>
			<td><?php echo $ahab ?></td>	
			<td><?php echo $bata["nama_baru"] ?></td>					
		</tr>
		<?php $r++; } }?>
	</tbody>
</table>
<script>
$(document).ready(function() {
	$('#list_pegawai').dataTable({
       "dom": 'T<"clear">lfrtip',
        "tableTools": {
            "sSwfPath": "assets/DataTables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
        }
    });
} );
</script>
