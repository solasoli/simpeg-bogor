<style>

</style>
<?php

//echo "keluarga";



include('class/keluarga_class.php');

$keluarga = new Keluarga_class;


//tambah anak
	
if(isset($anak) and isset($ttl)){

	$keluarga_anak = ("insert into keluarga (id_pegawai, id_status, nama,tempat_lahir,tgl_lahir,pekerjaan, jk, dapat_tunjangan) values ('$id','10','$anak','$ttl','$th2-$b2-$t2','$pekerjaananak','$jkanak','$tun_anak')");
	mysqli_query($mysqli,$keluarga_anak);

}


if(isset($del) =='true' && isset($idk)){

//$keluarga->hapus_keluarga($idk);
//$keluarga->hapus_perubahan_keluarga($idk);
	if($keluarga->hapus_keluarga($idk))
	{
		
		echo "Hapus keluarga berhasil";
	}
	else
	{
		echo "Hapus keluarga gagal";
	}
	
}


if(isset($pengurangan)==true)
{
?>
	<br/>
	<div class="alert alert-warning">
			<button type="button" class="close" data-dismiss="alert">&times;</button>
			<p align="center"><strong>Pengurangan Jiwa Berhasil</strong>
			<a class="btn btn-warning btn-sm" href="index3.php?x=box.php&od=<?php echo $od?>">segarkan</a></p>
		</div>
<?php
	}
?>

<br/>
<div style="margin-left:55%;">
<!--div class="btn-group">
  <a class="btn dropdown-toggle btn-info" data-toggle="dropdown" href="#">
    Surat Pengajuan Terbaru
    <span class="caret"></span>
  </a-->
  <!--ul class="dropdown-menu">
    <!-- dropdown menu links >
	<a class="btn btn-sm" id="surat_pengajuan_t">Surat Pengajuan Penambahan Keluarga</a><br/>
	<a class="btn btn-sm" id="surat_pengajuan_k">Surat Pengajuan Pengurangan Keluarga</a>
  </ul>
</div-->
<!--a class="btn btn-primary btn-sm" href="index3.php?x=modul/daftar_pengajuan.php&od=<?php //echo $od?>">Daftar Pengajuan</a>
<a class="btn btn-info btn-sm" href="index3.php?x=modul/upload_berkas_dasar_v.php&od=<?php //echo $od;?>">Unggah Berkas Dasar </a-->
</div>	

<!--Input type hidden-->
<input type="hidden" value="<?php echo $od?>" name="id_pegawai" id="id_pegawai"/>

<h4>Data Istri/Suami</h4>
	<table class="table table-bordered">
		<thead> 
			<th>No</th>
			<th>Nama <br> Tempat, Tgl Lahir</th>
			<th>NIK</th>			
			<th>Tanggal Menikah</th>
			<th>Pekerjaan</th>				
			<th>Status Tunjangan</th>
			<th>Keterangan</th>
			<th>status</th>
			<th>Aksi</th>
		</thead>
		<tbody>
			<?php 
				$istris = $keluarga->get_keluarga($od,9);
				$i=1;
			if(mysqli_num_rows($istris) > 0)
			{
				while($istri=mysqli_fetch_object($istris))
					{
			?>	
			<tr>
				<td><?php echo $i++ ?>
				<td><?php echo "<strong>".$istri->nama."</strong><br>".$istri->tempat_lahir.", ".$istri->tgl_lahir ?> </td>
				<td><?php echo $istri->nik ?></td>
				<td><?php echo $istri->tgl_menikah ?></td>
				<td><?php echo $istri->pekerjaan ?></td> 				
				<td><?php if($istri->dapat_tunjangan == 1 OR $istri->dapat_tunjangan == -2 )
							echo "Dapat tunjangan";
						 else if($istri->dapat_tunjangan == 0 OR $istri->dapat_tunjangan == -1)
							echo "Tidak dapat tunjangan";
					?>
				</td> 
				<td><?php echo $istri->keterangan?></td>
				<td><?php echo $istri->status?></td>
				<td>
					<div class="btn-group">
						<a href='index3.php?x=modul/edit_keluarga.php&od=<?php echo $od?>&idk=<?php echo $istri->id_keluarga ?>&tj=<?php echo $istri->dapat_tunjangan?>' class="btn btn-primary btn-xs">Ubah</a>
						<?php if($_SESSION['id_pegawai'] == 11301){ ?>
						<a onclick="ubah(<?php echo $istri->id_keluarga ?>)" class="btn btn-success btn-xs">Ubah2</a>
						<?php } ?>
						<a class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingim menghapus data?');" href='index3.php?x=box.php&od=<?php echo $od ?>&idk=<?php echo $istri->id_keluarga ?>&del=true'>Hapus</a>
					</div>
				</td>
			</tr>
			<?php
				}
			}
			else
			{
			?>
				<tr>
					<td colspan="10"><p align="center"><b>Tidak Ada Data</b></p></td>
				</tr>
			<?php
			}
			?>
		</tbody>
	</table>
				
				
	<?php
		$id_peg = $od;
		
		//mengambil data anak
		//$keluarga_anak 		 = $keluarga->get_anak_by_id_pegawai($id_peg);
		$keluarga_anak 		 = $keluarga->get_keluarga($id_peg,10);
		//deklarasi
		$status_ak 	= array();
		$index_anak	= 0;
		$id_ak 		= array();
		
				
		$qa=mysqli_query($mysqli,"select count(*) from pegawai where id_pegawai=$od");
		$anak=mysqli_fetch_array($qa);
		if($anak[0]>0){
	?>
				
    <h4>Data Anak</h4>
	<table width="400" border="0" align="left" cellpadding="3" cellspacing="0" class="table table-bordered">
		<thead>
		<tr>
			<th>No</th>
			<th>Nama / Tempat, Tgl Lahir </th>
			<th>NIK</th>						
			<th>Pekerjaan</th>
			<th>Jenis Kelamin</th>
			<th>Status Tunjangan</th>
			<th>Keterangan</th>
			<th>Aksi</th>
		</tr>
		</thead>
		<tbody>
                  <?php
			
			$qpr = $keluarga->get_keluarga($od,10);
			$i=1;
			if(mysqli_num_rows($qpr) > 0)
			{
				while($acoy=mysqli_fetch_array($qpr))
				{			
					
			?>
				<tr>
					<td><?php echo $i ?></td>
					<td><?php echo "<strong>".$acoy['nama']."</strong><br>".$acoy['tempat_lahir'].", ".$format->date_dmY($acoy['tgl_lahir']) ?></td>
					<td><?php echo $acoy['nik'] ?></td>
					<td><?php echo $acoy['pekerjaan'] ?></td>
					<td>
						<?php $jk = $acoy['jk'];
							if($jk == 1)
								echo 'Laki-laki';
							else if($jk==2)
								echo 'Perempuan';
						?>
					</td>
					<td><?php $tun = $acoy['dapat_tunjangan']; 
							if($tun == -1 OR $tun == 0)
								echo "Tidak Dapat tunjangan";
							else if($tun == 1 OR $tun == -2)
								echo "Dapat Tunjangan";
						?>
					</td>
					<td>
					 <?php echo $acoy['keterangan']; ?>
					<?php /**
					$qpre=mysqli_query($mysqli,"select prestasi from prestasi_keluarga where id_keluarga=$acoy[id_keluarga]");
					echo("<ul>");
					while($pre=mysqli_fetch_array($qpre))
					echo("<li>$pre[0] </li>");
					echo("</ul>"); */
					?>
					</td>
					<td>					
						<div class="btn-group">
							<a href='index3.php?x=modul/edit_keluarga.php&od=<?php echo $od ?>&idk=<?php echo $acoy['id_keluarga'] ?>&tj=<?php echo $acoy['dapat_tunjangan']?>' class='btn btn-primary btn-xs'>Ubah</a>
							<a href='index3.php?x=modul/addprestasi.php&od=<?php echo $od ?>&idk=<?php echo $acoy['id_keluarga'] ?>' class='btn btn-success btn-xs'>[+] Prestasi</a>
							<a class="btn btn-danger btn-xs" onclick="return confirm('Apakah Anda yakin ingim menghapus data?');" href='index3.php?x=box.php&od=<?php echo $od ?>&idk=<?php echo $acoy['id_keluarga'] ?>&del=true'>Hapus</a>
						</div>
					</td>
				</tr>
				
			<?php
				$i++;
				}
			}
			else
			{
			?>
				<tr>
					<td colspan="9"><p align="center"><b>Tidak Ada Data</b></p></td>
				</tr>
			<?php
			}
			$totanak=$i-1;
			
			?>
                </tbody>
              </table>
			  
	
              
				<a href="index3.php?x=modul/tambah_keluarga.php&od=<?php echo $od ?>" class="btn btn-primary">Tambah Keluarga</a>&nbsp;&nbsp;
			<a href="../simpeg2/pdf/skum_pdf/index/<?php echo $od ?>" class="btn btn-info" target="_blank">Cetak SKUM-PTK</a>
			<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal">Cetak SKUM-PTK (Tgl Cetak Update)</button>

            <!-- Modal -->
            <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog modal-sm">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Ubah Tanggal Cetak</h4>
                        </div>
                        <div class="modal-body">
                            <p>
                            <div class="input-group date">
                                <input type="text" class="form-control" value="01-01-2016" id="datepicker">
                                <div class="input-group-addon">
                                    <span class="glyphicon glyphicon-th"></span>
                                </div>
                            </div>
                            </p>
                        </div>
                        <div class="modal-footer">
                            <button id="btnCetakSkum" onclick="openCetakSKUM();" type="button" class="btn btn-info">Cetak</button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        </div>
                    </div>

                </div>
            </div>

<?php // include('riwayat_keluarga_modal.php'); ?>

			<script type="text/javascript">
				$(function () {
					$('.tanggalan').datetimepicker({
						format: 'L'
					});
				});
				function openCetakSKUM(){
					var tgl = $('#datepicker').val();
					window.open('../simpeg2/pdf/skum_pdf/index/<?php echo $od; ?>/'+tgl,'_blank');
				}
			</script>
          
          <?php
		  $qn=mysqli_query($mysqli,"select id_berkas from berkas where id_pegawai=$kuta[0] and id_kat=14");
			$n=mysqli_fetch_array($qn);
			if($n[0]!=null)
			echo(" <a href=lihat_berkas.php?id=$n[0] class='btn btn-info'  target=_blank> Unduh KK </a>");
		  }
		  ?>
 <br/> <br/> <br/>
 <script>
	
	function ubah(id_keluarga){
		//alert(id_keluarga)
		$.ajax({
			type: 'POST',
			url: 'riwayat_keluarga_get.php',
			data: { id_keluarga: id_keluarga},
			dataType: 'json',
			success: function (data) {
				$("#txtKgbNext").html('');
				
				$.each(data, function(k, v){
					
					console.log(data);
				});*/
				//$("#txtKgbNext").html(status);
			}
		});

		//$("#myModal").modal("show");
	}
 
 $(document).ready(function(){
	 $('#surat_pengajuan_t').click(function(){
		window.location = 'perubahan_keluarga/surat_pengajuan_perubahan_keluarga.php?od='+ $('#id_pegawai').val()+'&id_status=1'; 
	 });
	 $('#surat_pengajuan_k').click(function(){
		window.location = 'perubahan_keluarga/surat_pengajuan_perubahan_keluarga.php?od='+ $('#id_pegawai').val()+'&id_status=-1'; 
	 });
	 
 });
 </script>

