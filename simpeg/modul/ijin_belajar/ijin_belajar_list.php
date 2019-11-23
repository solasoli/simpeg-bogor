<?php
session_start();

extract($_GET);

include("konek.php");
require_once('class/pegawai.php');
require_once("library/format.php");

$format = new Format;
$obj_pegawai = new Pegawai;
$pegawai = $obj_pegawai->get_obj($_SESSION['id_pegawai']);	

if(isset($hapus))
    mysql_query("delete from ijin_belajar where id=$hapus");
if($edit>0)
{
    $qedit1=mysql_query("select * from ijin_belajar where id=$edit");
    $edit1=mysql_fetch_array($qedit1);

    $qtmt=mysql_query("select max(tmt) from sk where id_pegawai=$edit1[1] and id_kategori_sk=5");
    $tmt=mysql_fetch_array($qtmt);

    $t2=substr($tmt[0],8,2);
    $b2=substr($tmt[0],5,2);
    $th2=substr($tmt[0],0,4);

    $qbel=mysql_query("select * from pendidikan_terakhir where id_pegawai=$edit1[1]");
    $bel=mysql_fetch_array($qbel);


    $qedit2=mysql_query("select nama,nip_baru,pangkat_gol,nama_baru,id_j from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where pegawai.id_pegawai=$edit1[1]");
    $edit2=mysql_fetch_array($qedit2);

    if(is_numeric($edit2[id_j]))
    {
        $qjab=mysql_query("select jabatan from jabatan where id_j=$edit2[id_j]");
        $jab=mysql_fetch_array($qjab);
        $jabatan=$jab[0];
    }
    else
    {
        $qjab=mysql_query("select nama_jfu from jfu_pegawai inner join jfu_master on jfu_pegawai.kode_jabatan=jfu_master.kode_jabatan where id_pegawai=$edit1[1]");
        $jab=mysql_fetch_array($qjab);
        $jabatan=$jab[0];
    }
}

$sqlq=("select nama,
					nip_baru,	
					pangkat_gol,
					jabatan,
					nama_baru,
					tingkat_pendidikan,
					jurusan,akreditasi,
					pegawai.id_pegawai,
					approve,
					ijin_belajar.keterangan as ket,ijin_belajar.id,
					formasi.id_formasi,
					jfm.nama_jfu
				from ijin_belajar 
				inner join pegawai on pegawai.id_pegawai =  ijin_belajar.id_pegawai 
				inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai =  ijin_belajar.id_pegawai 
				inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja
				inner join formasi on formasi.id_formasi = ijin_belajar.id_formasi
				inner join jfu_master jfm on formasi.id_jfu = jfm.id_jfu
				where unit_kerja.id_skpd=$_SESSION[id_unit]  ");

if(!$q = mysql_query($sqlq)){
	echo "query error ;".mysql_error;
}

				
?>

<div>
	<div class="row" id="tabelib">
		<div class="col-md-12">
			<table class="table table-bordered" id="listib">
				<thead>
				<tr>
					<th rowspan="2" style="padding:5px;">No</th>
					<th rowspan="2" style="padding:5px;">Nama/NIP/Gol/TMT</th>								
					<th colspan="2" rowspan="2" align="center" style="padding:5px;">Jabatan</th>
					<th rowspan="2" align="center" style="padding:5px;">Formasi</th>
					<th colspan="2" align="center" style="padding:5px;">Pendidikan Terakhir</th>
					<th rowspan="2" align="center" style="padding:5px;">Pendidikan Lanjutan</th>
					<th rowspan="2" align="center" style="padding:5px;">Akreditasi</th>
					<th rowspan="2" align="center" style="padding:5px;" nowrap="nowrap">Status</th>
					<th rowspan="2" align="center" style="padding:5px;" nowrap="nowrap">Aksi</th>					
				</tr>
				<tr>
					<th style="padding:5px;">Program</th>
					<th style="padding:5px;">Jurusan</th>					
				</tr>
				</thead>
				<tbody>
				<?php
				$i=1;
				if(mysql_num_rows($q) > 0){
				while($data=mysql_fetch_array($q))
				{
					?>
					<tr>
						<td style="padding:5px;"><?php echo($i); ?></td>
						<td style="padding:5px;">
							<?php echo($data[0]); ?><br><?php echo($data[1]); ?>
							<?php
								//ambil pangkat
								$qsk=mysql_query("select tmt from sk where id_pegawai=$data[8] and id_kategori_sk=5 order by tmt desc ");
								$tmt=mysql_fetch_array($qsk);
								echo $data[2]." (".$format->date_dmY($tmt[0]).")"; 
							?>
						</td>
						
						<td colspan="2" style="padding:5px;"> <?php

							$qjab=mysql_query("select nama_jfu  from jfu_master inner join jfu_pegawai on jfu_pegawai.kode_jabatan=jfu_master.kode_jabatan where jfu_pegawai.id_pegawai=$data[8]");

							$jab=mysql_fetch_array($qjab);
							echo("$jab[0]");

							?></td>
						<td><?php echo $data['nama_jfu'] ?></td>
						<td align="center" style="padding:5px;"><?php
							$qpen=mysql_query("select tingkat_pendidikan,jurusan_pendidikan from pendidikan where id_pegawai=$data[8] order by level_p ");
							$pen=mysql_fetch_array($qpen);
							echo($pen[0]);
							?></td>
						<td style="padding:5px;"><?php echo($pen[1]); ?></td>
						<td align="center" style="padding:5px;"><?php
							$tp=array('tp',"S3","S2","S1","D3","D2","D1","SMA","SMP");
							echo($tp[$data[5]]); ?> - <?php echo($data[6]); ?>
						</td>						
						<td align="center" style="padding:5px;"><?php echo($data[7]); ?></td>
						<td style="padding:5px;" align="center" nowrap="nowrap"><?php
							if($data[9]==5)
								echo("Diajukan");
							else  if($data[9]==1)
								echo("Disetujui"); //<br> <a href=index3.php?x=uploadlib.php&idp=$data[8]>[ Upload ] </a>
							else  if($data[9]==2)
								echo("Diproses");
							else  if($data[9]==6)
								echo("Kirim Berkas");//Sudah Upload <br> <a href=index3.php?x=uploadlib.php&idp=$data[8]>[ Lihat Berkas ] </a>
							else  if($data[9]==4)
								echo("Selesai <br> Silakan diambil di BKPP");
							else  if($data[9]==7)
								echo("Perbaiki"); //<br> <a href=index3.php?x=uploadlib.php&idp=$data[8]>[ Upload ] </a>
							else  if($data[9]==3)
								echo("Ditolak:<br> $data[ket]");					

							?></td>
							<td align=center> 
								<div class="btn-group btn-group-sm">
									<?php if($data[9]==1){ ?>
										<a onclick="setStatus(6,<?php echo $data['id']?>)" class="btn btn-primary">Kirim Berkas</a>
										<!--a onclick="ajukan(<?php echo $data['id']?>)" class="btn btn-primary">Ajukan</a-->
									<?php } ?>
									<a href="index3.php?x=ibe.php&y=a&edit=<?php echo $data[id]?>" class="btn btn-small btn-warning"> Edit </a>
									<a href="index3.php?x=ibe.php&y=l&hapus=<?php echo $data[id]?>" class="btn btn-small btn-danger"> Hapus </a> 									
								</div>							
							</td>
							

					</tr>
					<?php
					$i++;
				}
				}else{ ?>
					<tr>
						<td colspan="13" class="danger text-center">TIDAK ADA DATA</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<script>

	function setStatus(status, id){
		
		//alert(status+" "+id);		
		$.post('ijinbelajar_update_status.php',{status:status,id:id})
		 .done(function(obj){
			//alert(obj);
			if(obj == 'Berhasil'){
				window.location.href = "<?php echo BASE_URL.'index3.php?x=ibe.php&y=l' ?>";
			}else{
				alert(obj);
			}
						
		});
			
	}
	
	function ajukan(id){
		$.post("<?php echo BASE_URL.'modul/ijin_belajar/insertib.php' ?>", $("#form_ibe").serialize())
		 .done(function(data){
			 alert(data);
			 window.location.href = "<?php echo BASE_URL.'index3.php?x=ibe.php&y=l' ?>";
		 });
	}
	
	$(document).ready(function(){
		$("#list").addClass("active");
		$("#add").removeClass("active");
		$("#need").removeClass("active");
	});
</script>

