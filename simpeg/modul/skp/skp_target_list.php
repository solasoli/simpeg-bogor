<?php //print_r($atasan_penilai) ?>
<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Daftar Penilaian Prestasi Kerja PNS</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">Daftar Penilaian Prestasi Kerja <br> PEGAWAI NEGERI SIPIL</h5>
	</div>
	<div class="panel-body">
		<table class="clearfix table table-bordered" id="listskp">
			<thead>
				<tr>
					<th>No.</th>
					<th>Periode</th>
					<th>Status</th>
					<th>Berkas</th>
					<th class="hidden-print">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php
				//echo "test..".$_SESSION['id_pegawai'];exit;
					$list_skp = $skp->get_skp($_SESSION['id_pegawai']);
					//print_r($list_skp);
					//echo "pegawai..".$pegawai->id_pegawai;exit;
					$x=1;
					if(mysqli_num_rows($list_skp) > 0){
					while($each_skp = mysqli_fetch_object($list_skp)){
				?>
				<tr>
					<td><?php echo $x++; ?>.</td>
					<td><?php echo $periode = $format->tanggal_indo($each_skp->periode_awal)." s.d ".$format->tanggal_indo($each_skp->periode_akhir) ?></td>

					<!--
						status pengajuan 0 belum mengajukan
					-->
					<td><span class="text-danger"><?php echo $skp->get_status($each_skp->status_pengajuan)->status ?></span></td>
					<td>
						 <span class="btn btn-primary btn-sm fileinput-button" <?php //if($row_cuti['id_status_cuti'] == 9) echo 'disabled' ?>>
							<i class="glyphicon glyphicon-plus"></i>
							<span>Upload PPK(format file harus pdf)</span>
							<!-- The file input field used as target for the file upload widget -->
							<input id="file_ppk_<?php echo $each_skp->id_skp ; ?>"
								   type="file" name="files[]" multiple/>
							<input type="hidden"
							   name="ppk_<?php echo $each_skp->id_skp; ?>"
							   id="ppk_<?php echo $each_skp->id_skp; ?>"/>
						</span>
					</td>
					<td class="hidden-print">
						<!--a href="index.php?page=formulir&idskp=<?php //echo $each_skp->id_skp ?>" class="btn btn-primary btn-xs">lihat</a-->

							<a href="index.php?page=ubah_data&idskp=<?php echo $each_skp->id_skp ?>" class="btn btn-primary btn-xs">LIHAT</a>


						<?php if($pegawai->skp_block == 0){ ?>
						<a href="#" id="hapus" idskp="<?php echo $each_skp->id_skp ?>"  periode="<?php echo $periode ?>"
						<?php } ?>
					</td>
				</tr>
				<?php
					}}else{
						echo "<tr class='text-center danger'><td colspan=6>tidak ada skp yang ditemukan</td></tr>";
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="panel-footer hidden-print">
		<!--a href="#skp_add_form" data-toggle="modal" class="btn btn-primary" type="button" >SKP Baru</a-->
		<?php if($pegawai->skp_block == 0){ ?>
		<a class="btn btn-primary" type="button" onclick="skpbaru(<?php echo $penilai->id_pegawai ?>)">SKP Baru</a>
		<?php } ?>
		<a href="#" class="btn btn-info" type="button" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></a>
	</div>
</div>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->


<div class="modal fade" id="skp_add_form" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Buat Sasaran Kerja Pegawai</h5>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal" id="newskpform">
					<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-4 ">
						<div class="form-group">
							<label for="penilai">NIP Penilai</label>
							<div class="form-inline">
								<input type='text' name='nip_penilai' id='nip_penilai' class='form-control' value='<?php echo $penilai->nip_baru ?>'>
								<a id="cari_penilai" class="btn btn-info">CARI</a>
								<input type="hidden" name="id_penilai" id="id_penilai" value="<?php echo $penilai->id_pegawai ?>"/>
							</div>
						</div>
						<div class="form-group">
							<label for="nama_penilai">Nama Penilai</label>
							<input type='text' name='nama_penilai' id='nama_penilai' class='form-control' readonly value='<?php echo $penilai->nama_lengkap ?>'>
						</div>
						<div class="form-group">
							<label for="pangkat_gol">Pangkat/Gol</label>
							<input type="text" name="gol_penilai" id="gol_penilai" class="form-control" value="<?php echo $penilai->pangkat." - ".$penilai->pangkat_gol ?>">
						</div>
						<div class="form-group">
							<label for="jabatan_penilai">Jabatan</label>
							<input type="text" name="jabatan_penilai" id="jabatan_penilai" class="form-control" value="<?php echo $obj_pegawai->get_jabatan($penilai) ?>">
						</div>
						<div class="form-group">
							<label for="unit_kerja_penilai">Unit Kerja</label>
							<input type='text' name='unit_kerja_penilai' id='unit_kerja_penilai' class='form-control' value='<?php echo $penilai->nama_baru ?>'>
							<input type="hidden" name="id_unit_kerja_penilai" id="id_unit_kerja_penilai" value="<?php echo $penilai->id_unit_kerja ?>"/>

						</div>
					</div>
					<div class="col-md-1 "></div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="penilai">NIP Pejabat Banding</label>
							<div class="form-inline">
								<input type='text' name='nip_atasan_penilai' id='nip_atasan_penilai' class='form-control' value='<?php echo $atasan_penilai->nip_baru ?>'>
								<a id="cari_atasan_penilai" class="btn btn-info">CARI</a>
								<input type="hidden" name="id_atasan_penilai" id="id_atasan_penilai" value="<?php echo $atasan_penilai->id_pegawai ?>"/>
							</div>
						</div>
						<div class="form-group">
							<label for="nama_atasan_penilai">Nama Pejabat Banding</label>
							<input type='text' name='nama_atasan_penilai' id='nama_atasan_penilai' class='form-control' readonly value='<?php echo $atasan_penilai->nama_lengkap ?>'>
						</div>
						<div class="form-group">
							<label for="pangkat_gol">Pangkat/Gol Pejabat Banding</label>
							<input type="text" name="gol_atasan_penilai" id="gol_atasan_penilai" class="form-control" value="<?php echo $atasan_penilai->golongan ?>">
						</div>
						<div class="form-group">
							<label for="jabatan_penilai">Jabatan Pejabat Banding</label>
							<input type="text" name="jabatan_atasan_penilai" id="jabatan_atasan_penilai" class="form-control" value="<?php echo $obj_pegawai->get_jabatan($atasan_penilai) ?>">
						</div>
						<div class="form-group">
							<label for="unit_kerja_penilai">Unit Kerja Pejabat Banding</label>
							<input type='text' name='unit_kerja_atasan_penilai' id='unit_kerja_atasan_penilai' class='form-control' value='<?php echo $atasan_penilai->nama_baru ?>'>
							<input type="hidden" name="id_unit_kerja_atasan_penilai" id="id_unit_kerja_atasan_penilai" value="<?php echo $atasan_penilai->id_unit_kerja ?>"/>

						</div>
					</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="form-group col-md-4">
							<label for="periode_awal">Periode Awal</label>
							<div class="form-inline">
								<input type='text' name='periodeAwal' id='periodeAwal' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='form-control tanggal' value='<?php echo $format->date_dmY($theSkp->periode_awal)?>'>
							</div>
						</div>
						<div class="col-md-2"></div>
						<div class="form-group col-md-4">
							<label for="periode_akhir">Periode Akhir</label>
							<div class="form-inline">
									<input type='text' name='periodeAkhir' id='periodeAkhir' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='form-control tanggal' value='<?php echo $format->date_dmY($theSkp->periode_akhir)?>'>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="checkbox-inline col-sm-offset-1">
						<input type="checkbox" value="1" name="kopiskp" id="kopiskp">Salin uraian tugas SKP periode sebelumnya</label>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<a  onclick="berikutnya()" data-toggle="modal" class="btn btn-primary">Berikutnya</a>
				<a class="btn btn-danger" data-dismiss="modal">batal</a>
			</div>
		</div>
	</div>
</div>

<script>

	$(document).ready(function(){

		$(".tanggal").combodate({
			minYear: 2010,
			maxYear: <?php echo date('Y'); ?>
		});
		$(".day").addClass("form-control");
		$(".month").addClass("form-control");
		$(".year").addClass("form-control");

		$('.datepicker').datepicker({
			 format: 'yyyy-mm-dd',
			 autoclose: true
		});
		$(".in").removeClass("in");
		$("#collapseOne").addClass("in");

		$("a#hapus").on("click", function(){

			idskp = $(this).attr('idskp');
			periode = $(this).attr('periode');
			del = confirm("apakah anda yakin akan menghapus SKP Periode : "+periode);
			if(del == true){
				$(this).closest('tr').remove();
				$.post("skp.php",{aksi:"delSkp", idskp: idskp});

			}else{
				//alert("kela kela, can yakin yeuh tong waka di apus");
				return false;
			}
		});

		$("#cari_penilai").on('click',function(){
			$.post('find_atasan.php',{nip:$("#nip_penilai").val()})
			 .done(function(obj){
				data = JSON.parse(obj);

				if(data.id == 0){
					alert("Pegawai Tidak Ditemukan");
				}else{
					$("#id_penilai").val(data.id);
					$("#nama_penilai").val(data.nama);
					$("#gol_penilai").val(data.golongan);
					$("#jabatan_penilai").val(data.jabatan);
					$("#unit_kerja_penilai").val(data.nama_unit_kerja);
					$("#id_unit_kerja_penilai").val(data.id_unit_kerja);
				}

			});
		});

		$("#cari_atasan_penilai").on('click',function(){

			$.post('find_atasan.php',{nip:$("#nip_atasan_penilai").val()})
			 .done(function(obj){
				data = JSON.parse(obj);
				if(data.id == 0){
					alert("Pegawai Tidak Ditemukan");
				}else{
					//alert(data.id);
					$("#id_atasan_penilai").val(data.id);
					$("#nama_atasan_penilai").val(data.nama);
					$("#gol_atasan_penilai").val(data.golongan);
					$("#jabatan_atasan_penilai").val(data.jabatan);
					$("#unit_kerja_atasan_penilai").val(data.nama_unit_kerja);
					$("#id_unit_kerja_atasan_penilai").val(data.id_unit_kerja);
				}
			});
		});
	});

	function skpbaru(idpenilai){

		if(!idpenilai){
			alert("penilai tidak ditemukan");
			//window.location.replace("<?php echo BASE_URL ?>index3.php?x=box.php&od=<?php echo $pegawai->id_pegawai ?>");
			$('#skp_add_form').modal('show');
		}else{
			$('#skp_add_form').modal('show');
		}
	}


	function berikutnya(){

		var tglAwal = $("#periodeAwal").val().split('-');
		tglAwal.reverse();
		var periode_awal = tglAwal.join('-');

		var tglAkhir = $("#periodeAkhir").val().split('-');
		tglAkhir.reverse();
		var periode_akhir = tglAkhir.join('-');



		var id_pegawai 						= "<?php echo $pegawai->id_pegawai ?>";
		var gol_pegawai						= "<?php echo $pegawai->pangkat." - ".$pegawai->pangkat_gol ?>";
		var jabatan_pegawai					= "<?php echo $obj_pegawai->get_jabatan($pegawai)?>";
		var id_unit_kerja_pegawai			= "<?php echo $pegawai->id_unit_kerja ?>";
		var id_penilai						= $("#id_penilai").val();
		var gol_penilai						= $("#gol_penilai").val();
		var jabatan_penilai					= $("#jabatan_penilai").val();
		var id_unit_kerja_penilai			= $("#id_unit_kerja_penilai").val();
		var id_atasan_penilai				= $("#id_atasan_penilai").val();
		var gol_atasan_penilai				= $("#gol_atasan_penilai").val();
		var jabatan_atasan_penilai			= $("#jabatan_atasan_penilai").val();
		var id_unit_kerja_atasan_penilai	= $("#id_unit_kerja_atasan_penilai").val();


		if ($("#kopiskp").is(":checked")) {
			var kopi_skp = 1;
		} else {
			var kopi_skp = 0;
		}
		var dua = "<tr><td>2.</td><td>"+periode_awal+" - "+periode_akhir+"</td><td><?php echo $penilai->nama ?></td><td><?php echo $atasan_penilai->nama ?></td><td></td><td></td></tr>";




		if(periode_awal.length <= 6 || periode_akhir.length <= 6 || id_penilai.length <= 1 || id_atasan_penilai <= 1){
			alert("Harap mengisi periode penilaian, pejabat Penilai dan Pejabat Banding");
			$("#periodeAwal").focus();

		}else{


			$.post("skp.php", { aksi:	 "tambahSkp",
								id_pegawai: id_pegawai ,
								gol_pegawai: gol_pegawai,
								jabatan_pegawai: jabatan_pegawai,
								id_unit_kerja_pegawai: id_unit_kerja_pegawai,
								id_penilai : id_penilai,
								gol_penilai : gol_penilai,
								jabatan_penilai: jabatan_penilai,
								id_unit_kerja_penilai : id_unit_kerja_penilai,
								id_atasan_penilai : id_atasan_penilai,
								gol_atasan_penilai : gol_atasan_penilai,
								jabatan_atasan_penilai : jabatan_atasan_penilai,
								id_unit_kerja_atasan_penilai : id_unit_kerja_atasan_penilai,
								id_unit_kerja_atasan_penilai : id_unit_kerja_atasan_penilai,
								periode_awal : periode_awal,
								periode_akhir : periode_akhir,
								kopi_skp : kopi_skp
								})
			.done(function(data){

				if(data.search("gagal") == true){
					alert(data);
				}else{
					$("#skp_add_form").modal("hide");
					$("#listskp tr:last").after(dua);
					window.location.replace("index.php?page=formulir&idskp="+data);
				}


			  });
		}
	}




</script>
<script src="skp.js"></script>
