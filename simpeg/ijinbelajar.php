<?php
extract($_GET);
require_once('class/pegawai.php');
require_once("library/format.php");

$format = new Format;
$obj_pegawai = new Pegawai;
$pegawai = $obj_pegawai->get_obj($_SESSION['id_pegawai']);	

if(isset($hapus))
    mysqli_query($mysqli,"delete from ijin_belajar where id=$hapus");
if(@$edit>0)
{
    $qedit1=mysqli_query($mysqli,"select * from ijin_belajar where id=$edit");
    $edit1=mysqli_fetch_array($qedit1);

    $qtmt=mysqli_query($mysqli,"select max(tmt) from sk where id_pegawai=$edit1[1] and id_kategori_sk=5");
    $tmt=mysqli_fetch_array($qtmt);

    $t2=substr($tmt[0],8,2);
    $b2=substr($tmt[0],5,2);
    $th2=substr($tmt[0],0,4);

    $qbel=mysqli_query($mysqli,"select * from pendidikan_terakhir where id_pegawai=$edit1[1]");
    $bel=mysqli_fetch_array($qbel);


    $qedit2=mysqli_query($mysqli,"select nama,nip_baru,pangkat_gol,nama_baru,id_j from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where pegawai.id_pegawai=$edit1[1]");
    $edit2=mysqli_fetch_array($qedit2);

    if(is_numeric($edit2[id_j]))
    {
        $qjab=mysqli_query($mysqli,"select jabatan from jabatan where id_j=$edit2[id_j]");
        $jab=mysqli_fetch_array($qjab);
        $jabatan=$jab[0];
    }
    else
    {
        $qjab=mysqli_query($mysqli,"select nama_jfu from jfu_pegawai inner join jfu_master on jfu_pegawai.kode_jabatan=jfu_master.kode_jabatan where id_pegawai=$edit1[1]");
        $jab=mysqli_fetch_array($qjab);
        $jabatan=$jab[0];
    }
}

$q=mysqli_query($mysqli,"select nama,
					nip_baru,	
					pangkat_gol,
					jabatan,
					nama_baru,
					tingkat_pendidikan,
					jurusan,akreditasi,pegawai.id_pegawai,approve,ijin_belajar.keterangan as ket,ijin_belajar.id from ijin_belajar inner join pegawai on pegawai.id_pegawai =  ijin_belajar.id_pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai =  ijin_belajar.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where unit_kerja.id_skpd=$_SESSION[id_unit]  ");

?>

<div class="page-header">
	<h2>Pengajuan Ijin Belajar
		<span class="pull-right hidden-print">            
          
            <a id="btnPengajuanBaru" class="btn btn-primary">Pengajuan Baru</a>
            <a id="btnBatal" class="btn btn-primary">Batal</a>           
            
        </span>
	</h2>
</div>
<div>
	<div class="row" id="tabelib">
		<div class="col-md-12">
			<table class="table table-bordered" id="listib">
				<thead>
				<tr>
					<th rowspan="2" style="padding:5px;">No</th>
					<th rowspan="2" style="padding:5px;">Nama</th>
					<th rowspan="2" style="padding:5px;">NIP/Gol/TMT Gol.</th>					
					<th colspan="2" rowspan="2" align="center" style="padding:5px;">Jabatan</th>
					<th colspan="2" align="center" style="padding:5px;">Pendidikan Terkahir</th>
					<th colspan="2" align="center" style="padding:5px;">Pendidikan Lanjutan</th>
					<th rowspan="2" align="center" style="padding:5px;">Akreditasi</th>
					<th rowspan="2" align="center" style="padding:5px;" nowrap="nowrap">Status</th>
					<th rowspan="2" align="center" style="padding:5px;" nowrap="nowrap">Aksi</th>					
				</tr>
				<tr>
					<th style="padding:5px;">Program</th>
					<th style="padding:5px;">Jurusan</th>
					<th style="padding:5px;">Program</th>
					<th style="padding:5px;">Jurusan</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$i=1;
				while($data=mysqli_fetch_array($q))
				{
					?>
					<tr>
						<td style="padding:5px;"><?php echo($i); ?></td>
						<td style="padding:5px;"><?php echo($data[0]); ?><br><?php echo($data[1]); ?></td>
						<td style="padding:5px;">
							<?php
								//ambil pangkat
								$qsk=mysqli_query($mysqli,"select tmt from sk where id_pegawai=$data[8] and id_kategori_sk=5 order by tmt desc ");
								$tmt=mysqli_fetch_array($qsk);
								echo $data[2]."<br>".$format->date_dmY($tmt[0]); 
							?>
						</td>
						<td colspan="2" style="padding:5px;"> <?php

							$qjab=mysqli_query($mysqli,"select nama_jfu  from jfu_master inner join jfu_pegawai on jfu_pegawai.kode_jabatan=jfu_master.kode_jabatan where jfu_pegawai.id_pegawai=$data[8]");

							$jab=mysqli_fetch_array($qjab);
							echo("$jab[0]");

							?></td>
						<td align="center" style="padding:5px;"><?php
							$qpen=mysqli_query($mysqli,"select tingkat_pendidikan,jurusan_pendidikan from pendidikan where id_pegawai=$data[8] order by level_p ");
							$pen=mysqli_fetch_array($qpen);
							echo($pen[0]);
							?></td>
						<td style="padding:5px;"><?php echo($pen[1]); ?></td>
						<td align="center" style="padding:5px;"><?php
							$tp=array('tp',"S3","S2","S1","D3","D2","D1","SMA","SMP");
							echo($tp[$data[5]]); ?></td>
						<td style="padding:5px;"><?php echo($data[6]); ?></td>
						<td align="center" style="padding:5px;"><?php echo($data[7]); ?></td>
						<td style="padding:5px;" align="center" nowrap="nowrap"><?php
							if($data[9]==5)
								echo("Diajukan");
							else  if($data[9]==1)
								echo("Disetujui"); //<br> <a href=index3.php?x=uploadlib.php&idp=$data[8]>[ Upload ] </a>
							else  if($data[9]==2)
								echo("Diproses");
							else  if($data[9]==6)
								echo("");//Sudah Upload <br> <a href=index3.php?x=uploadlib.php&idp=$data[8]>[ Lihat Berkas ] </a>
							else  if($data[9]==4)
								echo("Selesai <br> Silakan diambil di BKPP");
							else  if($data[9]==7)
								echo("Perbaiki"); //<br> <a href=index3.php?x=uploadlib.php&idp=$data[8]>[ Upload ] </a>
							else  if($data[9]==3)
								echo("Ditolak:<br> $data[ket]");					

							?></td>
							<td align=center> 
								<div class="btn-group">
									<?php if($data[9]==1){ ?>
										<a onclick="setStatus(5,<?php echo $data['id']?>)" class="btn btn-primary">Ajukan</a>
									<?php } ?>
									<a href="index3.php?x=ijinbelajar.php&edit=<?php echo $data[id]?>" class="btn btn-warning"> Edit </a>
									<a href="index3.php?x=ijinbelajar.php&hapus=<?php echo $data[id]?>" class="btn btn-danger"> Hapus </a> 									
								</div>							
							</td>
							<td align=center>  </td>

					</tr>
					<?php
					$i++;
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="row" id="formib">
		<div class="col-md-10">
			<h4>Form Pengajuan Ijin Belajar <?php echo ("$_SESSION[nama_skpd]");?></h4>
			<form id="form1" name="form1" method="post" class="form-horizontal" action="index3.php">
				<div class="form-group">
					<label for="nama" class="col-sm-4 control-label">Nama</label>
					<div class="col-sm-8">
						<input name="nama" type="text" class="form-control" id="nama" size="50" <?php if(isset($edit)) echo("value='$edit2[0]'"); ?> />
					</div>
				</div>
				<div class="form-group">
					<label for="nip" class="col-sm-4 control-label">NIP</label>
					<div class="col-sm-8">
						<input name="nip" type="text" class="form-control" id="nip" size="30" <?php if($edit>0) echo("value='$edit2[1]'"); ?> />
					</div>
				</div>
				<div class="form-group">
					<label for="nip" class="col-sm-4 control-label">Pangkat-Gol / Ruang</label>
					<div class="col-sm-8">
						<input name="pg" class="form-control" type="text" id="pg" size="8" <?php if($edit>0) echo("value='$edit2[2]'"); ?> />
						<input type="hidden" name="idp" id="idp" <?php if($edit>0) echo("value='$edit1[1]'"); ?>  />
					</div>
				</div>
				<div class="form-group">
					<label for="nip" class="col-sm-4 control-label">TMT Pangkat</label>
					<div class="col-sm-8">
						<input name="tmt" class="form-control" type="text" id="tmt" size="20" <?php if($edit>0) echo("value='$t2-$b2-$th2'"); ?> />
						<input name="x" type="hidden" id="x" value="insertib.php"  />						
					</div>
				</div>
				<div class="form-group">
					<label for="nip" class="col-sm-4 control-label">Jabatan</label>
					<div class="col-sm-8">
						<input name="jabatan" type="text" id="jabatan" class="form-control" size="50" <?php if($edit>0) { echo ("value='$jabatan'"); } ?> />
					</div>
				</div>
				<div class="form-group">
					<label for="nip" class="col-sm-4 control-label">OPD</label>
					<div class="col-sm-8">
						<input class="form-control" name="opd" type="text" id="opd" size="50"  <?php if($edit>0) echo("value='$edit2[nama_baru]'"); ?> />
					</div>
				</div>
				<div class="form-group">
					<label for="nip" class="col-sm-4 control-label">Pendidikan Terakhir</label>
					<div class="col-sm-8">
						<input name="pt" class="form-control" type="text" id="pt" size="50" <?php if($edit>0) echo("value='$bel[tingkat_pendidikan]'"); ?>  />
						<span id="helpBlock" class="help-block">Perbaiki Jika Salah</span>
					</div>
				</div>
				<div class="form-group">
					<label for="nip" class="col-sm-4 control-label">Jurusan</label>
					<div class="col-sm-8">
						<input name="jurusan" class="form-control" type="text" class="Perbaiki Jika Salah" id="jurusan" size="50" <?php if($edit>0) echo("value='$bel[jurusan_pendidikan]'"); ?>  />
						<span id="helpBlock" class="help-block">Perbaiki Jika Salah</span>
					</div>
				</div>
				<div class="form-group">
					<label for="nip" class="col-sm-4 control-label">Institusi</label>
					<div class="col-sm-8">
						<input name="institusi" class="form-control" type="text" id="institusi" size="50" <?php if($edit>0) echo("value='$bel[lembaga_pendidikan]'"); ?> />
					</div>
				</div>
				<div class="form-group">
					<label for="nip" class="col-sm-4 control-label">Pendidikan Lanjutan</label>
					<div class="col-sm-8">
						<select name="pl" id="pl" class="form-control">
							<option value="8" <?php if($edit1[4]==8) echo("selected=selected"); ?>>SMP</option>
							<option value="7" <?php if($edit1[4]==7) echo("selected=selected"); ?>>SMA</option>
							<option value="6" <?php if($edit1[4]==6) echo("selected=selected"); ?>>D1</option>
							<option value="5" <?php if($edit1[4]==5) echo("selected=selected"); ?>>D2</option>
							<option value="4" <?php if($edit1[4]==4) echo("selected=selected"); ?>>D3</option>
							<option value="3" <?php if($edit1[4]==3) echo("selected=selected"); ?>>S1</option>
							<option value="2" <?php if($edit1[4]==2) echo("selected=selected"); ?>>Sekolah Profesi</option>
							<option value="2" <?php if($edit1[4]==2) echo("selected=selected"); ?>>S2</option>
							<option value="1" <?php if($edit1[4]==1) echo("selected=selected"); ?>>S3</option>
						</select></td>
					</div>
				</div>
				<div class="form-group">
					<label for="nip" class="col-sm-4 control-label">Institusi Lanjutan</label>
					<div class="col-sm-8">
						<input name="ilanjutan" class="form-control" type="text" id="ilanjutan" size="50" <?php if($edit>0) echo("value='$edit1[institusi_lanjutan]'"); ?>  />
					</div>
				</div>
				<div class="form-group">
					<label for="nip" class="col-sm-4 control-label">Jurusan Lanjutan</label>
					<div class="col-sm-8">
						<input name="jlanjutan" class="form-control" type="text" id="jlanjutan" size="50" <?php if($edit>0) echo("value='$edit1[jurusan]'"); ?>  />
					</div>
				</div>
				<div class="form-group">
					<label for="nip" class="col-sm-4 control-label">Akreditasi Jurusan PT</label>
					<div class="col-sm-8">
						 <input name="akr" class="form-control" type="text" id="akr" size="5"  <?php if($edit>0) echo("value='$edit1[akreditasi]'"); ?> />
						untuk mengetahui akreditasi jurusan klik link berikut <a href="http://ban-pt.kemdiknas.go.id/direktori.php" target="_blank">[akreditasi]</a>
					</div>
				</div>
				<div class="form-group pull-right">
					<input class="btn btn-primary" type="submit" name="button" id="button" value="ajukan" />
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal fade" id="formpengajuan" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">TEST</div>
			<div class="modal-body">ini body</div>
			<div class="modal-footer">
				<a class="btn btn-danger" data-dismiss="modal">batal</a>
			</div>
		</div>
	</div>
</div>

</body>
</html>
<script type="text/javascript">
	
	
	
	function setStatus(status, id){
		
		//alert(status+" "+id);		
		$.post('ijinbelajar_update_status.php',{status:status,id:id})
		 .done(function(obj){
			alert(obj);			
		});
			
	}

	$(document).ready(function(){
		
		jQuery.curCSS = function(element, prop, val) {
			return jQuery(element).css(prop, val);
		};
		
		$("#btnAjukan").on('click',function(){
			$("#formpengajuan").modal('show');
		});
				
		$("#formib").hide();
		$("#btnBatal").hide();
		
		$("#btnPengajuanBaru").click(function(){
			$("#tabelib").hide("slow");
			$("#btnPengajuanBaru").hide("slow");
			$("#formib").show("slow");
			$("#btnBatal").show("slow");
		});
		
		$("#btnBatal").click(function(){
			$("#formib").hide("slow");
			$("#btnBatal").hide("slow");
			$("#tabelib").show("slow");
			$("#btnPengajuanBaru").show("slow");
			
		});
		
		
		
		
		$( "#nama" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "proses.php",
					dataType: "json",
					data: {
						q: request.term,
						skpd: '<?php echo $_SESSION['id_skpd']; ?>',
						kategori: $("#nama").val()
					},
					success: function( data ) {
						response( data );

					}
				});
			},

			minLength: 1,
			select: function(event, ui) {
				var origEvent = event;
				while (origEvent.originalEvent !== undefined)
					origEvent = origEvent.originalEvent;
				if (origEvent.type == 'keydown' || origEvent.type == 'click')
				{ $("#nama").click();
					$("#nip").val(ui.item.nip);
					$("#pg").val(ui.item.pg);
					$("#jabatan").val(ui.item.jab);
					$("#opd").val(ui.item.opd);
					$("#tmt").val(ui.item.tmt);
					$("#pt").val(ui.item.pen);
					$("#jurusan").val(ui.item.jur);
					$("#institusi").val(ui.item.ip);
					$("#idp").val(ui.item.idp);

					if(ui.item.pen=='S1')
						$("#pl").val(2);
					else if(ui.item.pen=='S2')
						$("#pl").val(1);
					else if(ui.item.pen=='D3' || ui.item.pen=='D2' || ui.item.pen=='D1' || ui.item.pen=='SMA/SEDERAJAT')
						$("#pl").val(3);

				}
			}

		});

		
		$( "#jlanjutan" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "prosesj.php",
					dataType: "json",
					data: {
						q: request.term,
						ins: document.getElementById('ilanjutan').value,
						kategori: $("#jlanjutan").val()
					},
					success: function( data,ui ) {
						response( data );

					}
				});
			},

			minLength: 1,
			select: function(event, ui) {
				var origEvent = event;
				while (origEvent.originalEvent !== undefined)
					origEvent = origEvent.originalEvent;
				if (origEvent.type == 'keydown')
				{ $("#jlanjutan").click();
					$("#akr").val(ui.item.akre);


				}
			}

		});


		$( "#ilanjutan" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					url: "prosesi.php",
					dataType: "json",
					data: {
						q: request.term,
						kategori: $("#ilanjutan").val()
					},
					success: function( data ) {
						response( data );
					}
				});
			},

			minLength: 1,
			select: function(event, ui) {
				var origEvent = event;
				while (origEvent.originalEvent !== undefined)
					origEvent = origEvent.originalEvent;
				if (origEvent.type == 'keydown')
				{ $("#ilanjutan").click();


				}
			}

		});

	});
</script>