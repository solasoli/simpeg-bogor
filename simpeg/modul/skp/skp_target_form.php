<div class="hidden-print">
 <?php //echo "PERIODE :". $format->date_dmY($theSkp->periode_awal)." s.d. ".$format->date_dmY($theSkp->periode_akhir)?>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php?page=list">Daftar PPK</a></li>
		<?php $periode = explode('-', $theSkp->periode_awal); ?>
		<li class="breadcrumb-item"><a href="index.php?page=listtabel&idp=<?php echo $_SESSION['id_pegawai'] ?>&tahun=<?php echo $periode[0] ?>"><?php echo $periode[0] ?></a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php  echo $format->date_dmY($theSkp->periode_awal)." s.d. ".$format->date_dmY($theSkp->periode_akhir)?></li>
	</ol>
</nav>
<nav>
	<ol class="cd-multi-steps text-bottom count">
		<li class="visited"><a href="index.php?page=ubah_data&idskp=<?php echo $idskp ?>">Data</a></li>
		<li class="visited"><strong>Target</strong></li>
		<li class="visited"><a href="index.php?page=realisasi&idskp=<?php echo $idskp ?>">Realisasi</a></li>
		<li class="visited"><a href="index.php?page=myperilaku&idskp=<?php echo $idskp ?>">Perilaku</a></li>

	</ol>
</nav>
</div>
<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>SASARAN KERJA PEGAWAI</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center"><strong>SASARAN KERJA PEGAWAI</strong></h5>
	</div>
	<div id="drafttarget" class="draft visible-print">
		<h1><strong>
			<?php for($i=1;$i<10;$i++) { ?>
			- DRAFT SASARAN KERJA PEGAWAI - <br><br>
			<?php } ?>
			</strong>
		</h1>
	</div>
	<div class="panel-body">
		<table class="clearfix table table-bordered" id="skp_target_table">
			<tr>
				<td width="2%"><strong>NO</strong></td>
				<td colspan="2" width="48%"><strong>I. PEJABAT PENILAI</strong></td>
				<td width="2%"><strong>NO</strong></td>
				<td colspan="5" width="48%"><strong>II. PNS YANG DINILAI</strong></td>
			</tr>
			<tr>
				<td>1.</td>
				<td width="10%">Nama</td>
				<td><?php echo $penilai->nama_lengkap ?></td>
				<td>1.</td>
				<td width="10%">Nama</td>
				<td colspan="4"><?php echo $pegawai->nama_lengkap ?></td>
			</tr>
			<tr>
				<td>2.</td>
				<td>NIP</td>
				<td><?php echo ($penilai->flag_pensiun == '0' || $penilai->flag_pensiun == '1') ? $penilai->nip_baru : "-" ?></td>
				<td>2.</td>
				<td>NIP</td>
				<td colspan="4"><?php echo $pegawai->nip_baru ?></td>
			</tr>
			<?php
				$sql = "select count(*) as jumlah from sk where id_pegawai = ".$_SESSION['id_pegawai']." AND id_kategori_sk IN (5,7)";
				$q = mysqli_query($mysqli, $sql);
				while($row = mysqli_fetch_array($q)){
					$jml = $row['jumlah'];
				}
			?>
			<tr>
				<td>3.</td>
				<td>Pangkat/Gol.Ruang</td>
				<td><?php
					if($penilai->flag_pensiun == 0 || $penilai->flag_pensiun == 1){
						echo isset($theSkp->gol_penilai) ? $theSkp->gol_penilai : $penilai->pangkat." - ".$penilai->pangkat_gol ;
					}else{
						echo "-";
					}

					?>
				</td>
				<td>3.</td>
				<td><?php echo $jml==0?"Gol.Ruang":"Pangkat/Gol.Ruang" ?></td>
				<td colspan="4"><?php echo isset($theSkp->gol_pegawai) ? $theSkp->gol_pegawai : ($jml==0?$pegawai->pangkat_gol:$pegawai->pangkat." - ".$pegawai->pangkat_gol)  ?></td>
			</tr>
			<tr>
				<td>4.</td>
				<td>Jabatan</td>
				<td><?php echo $theSkp->jabatan_penilai; //$obj_pegawai->get_jabatan($penilai) ?></td>
				<td>4.</td>
				<td>Jabatan</td>
				<td colspan="4"><?php echo $skp->get_skp_by_id($_GET['idskp'])->jabatan_pegawai ?></td>
			</tr>
			<tr>
				<td>5.</td>
				<td>Unit Kerja</td>
				<td><?php echo $unit_kerja->get_unit_kerja($theSkp->id_unit_kerja_penilai)->nama_baru ?></td>
				<td>5.</td>
				<td>Unit Kerja</td>
				<td colspan="4"><?php echo $unit_kerja->get_unit_kerja($theSkp->id_unit_kerja_pegawai)->nama_baru ?></td>
			</tr>
			<tr>
				<td rowspan="2" class="text-center"><strong>NO</strong></td>
				<td colspan="2" class="text-center" rowspan="2"><strong>III. KEGIATAN TUGAS JABATAN</strong></td>
				<td rowspan="2" class="text-center"><strong>AK</strong></td>
				<td colspan="5" class="text-center"><strong>TARGET</strong></td>
			</tr>
			<tr>
				<td>KUANT/OUTPUT</td>
				<td>KUAL/MUTU</td>
				<td>WAKTU</td>
				<td>BIAYA</td>
				<?php if($pegawai->skp_block == 0){ ?>
				<td class="hidden-print"><span class="glyphicon glyphicon-cog"></span></td>
				<?php } ?>
			</tr>
			<!-- ini baris uraian tugas -->
			<?php
				$list_target = $skp->get_target($_GET['idskp']);
				$x = 1;
				while($target = mysqli_fetch_object($list_target)){
					//$target_history = $skp->get_target_history($target->id_skp_target);
					if($result = $skp->get_target_history($target->id_skp_target)){
						$history = mysqli_fetch_object($result);
					}else
						$history = "";
			?>
			<tr>
				<td><?php echo $x++ ?></td>
				<td colspan="2"><?php echo $target->uraian_tugas ?></td>
				<td><?php echo $target->angka_kredit ?></td>
				<td>
					<?php
						if($history != "" ){
							echo $history->kuantitas."  ".$history->kuantitas_satuan ;
						}else{
							echo $target->kuantitas."  ".$target->kuantitas_satuan ;
						}
					?>
				</td>
				<td>
					<?php
						if($history != "" ){
							echo $history->kualitas ;
						}else{
							echo $target->kualitas ;
						}


					?>
				</td>
				<td><?php

					if($history != "" ){
						echo $history->waktu."  ".$history->waktu_satuan;
					}else{
						echo $target->waktu."  ".$target->waktu_satuan;
					}

					?></td>
				<td class="text-right"><?php echo $target->biaya ? "Rp".$format->currency($target->biaya) : " - " ?></td>
				<?php if($pegawai->skp_block == 0){ ?>
				<td style="padding-right:0px" class="hidden-print">
					<a onclick="update_uraian(<?php echo $target->id_skp_target ?>)" class="btn btn-info btn-xs btn-skp">edit</a>
					<a id="<?php echo $target->id_skp_target ?>" onclick="hapus_target(<?php echo $target->id_skp_target ?>)" idtarget="<?php echo $target->id_skp_target ?>"  class="btn btn-danger btn-xs removebutton btn-skp">hapus</a>
				</td>
				<?php } ?>
			</tr>
			<?php } ?>
			<tr class="review btn-review hidden-print">
				<td colspan="9"><strong>Catatan Pejabat Penilai :</strong></td>
			</tr>
			<tr class="review btn-review hidden-print">
				<td colspan="9">
					<?php
						echo $skp->get_skp_by_id($_GET['idskp'])->review;
					?>
				</td>
			</tr>
			<!-- akhir uraian tugas -->
		</table>
	</div>
	<div class="penandatangan visible-print">
			<table class="table table-noborder">
				<tr>
					<td width="50%" class="text-center">

						<br>Pejabat Penilai,
						<br><br><br><br><br>
						<span style="text-decoration:underline"><strong><?php echo $penilai->nama_lengkap ?></strong></span>
						<br/><?php echo "NIP. ".$penilai->nip_baru ?>
					</td>
					<td class="text-center">
						Bogor, <?php echo $format->tanggal_indo($skp->get_skp_by_id($_GET['idskp'])->periode_awal); ?>
						<br>PNS Yang Dinilai,
						<br><br><br><br><br>
						<span style="text-decoration:underline"><strong><?php echo $pegawai->nama_lengkap ?></strong></span>
						<br/><?php echo "NIP. ".$pegawai->nip_baru ?>
					</td>
				</tr>
			</table>
		</div>
	<div class="panel-footer hidden-print">
		<?php if($pegawai->skp_block == 0){ ?>
		<a id="btnSkpAddForm" class="btn btn-primary btn-skp">tambah uraian</a>
		<a onclick="setStatus(1)" id="btnAjukanSkp" class="btn btn-success btn-skp" type="button" >ajukan SKP</a>
		<a onclick="setStatus(0)" class="btn btn-warning hide" id="btnBatalAjukanSkp">Batalkan Pengajuan</a>
		<?php } ?>

		<a class="btn btn-primary" id="btnCetak" type="button" onclick="window.print()">
			<span class="glyphicon glyphicon-print"></span>
		</a>
		<a href="#" id="hapus" idskp="<?php echo $_GET['idskp'] ?>" class="btn btn-danger">hapus</a>
		<span class="pull-right">
			status : <span class="danger"><?php echo $skp->get_status($skp->get_skp_by_id($_GET['idskp'])->status_pengajuan)->status ?></span>
		</span>
	</div>
</div>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div class="modal fade" id="skp_add_form" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Tambah Uraian Tugas  <h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-11">
						<form role="form" class="form-horizontal" id="formTambahUraian">
							<?php

							if($pegawai->jabatan == 'Guru' && $pegawai->jenjab == 'Fungsional'){ ?>
								<div class="form-group">
									<label for="unsur" class=" col-sm-3 control-label">Unsur: </label>
									<div class="col-sm-9">
										<select class="form-control" id="unsur" name="unsur" onchange="isi(this.value);" >
											<option value="0" selected="selected">Pilih Unsur</option>
											<option value="utama">Unsur Utama</option>
											<option value="penunjang">Unsur Penunjang</option>
										</select>
									</div>
								</div>
							<?php }elseif ($pegawai->jabatan != 'Guru' && $pegawai->jenjab == 'Fungsional') { ?>
                <div class="form-group">
									<label for="unsur" class=" col-sm-3 control-label">Unsur: </label>
									<div class="col-sm-9">
										<select class="form-control" id="unsur" name="unsur" >
											<option value="0" selected="selected">Pilih Unsur</option>
											<option value="utama">Unsur Utama</option>
											<option value="penunjang">Unsur Penunjang</option>
										</select>
									</div>
								</div>
              <?php } ?>
              <?php if($pegawai->jenjab == 'Struktural' && $pegawai->id_j == NULL) {?>
              <div class="form-group">
                <label for="stk_skp" class="col-sm-3 control-label">STK SKP</label>

                <div class="col-sm-9">
                  <select class="form-control" id="stk_skp">
                    <option></option>
                    <?php

                      $stk = $skp->get_stk($pegawai->id_jfu,'PELAKSANA',$pegawai->id_unit_kerja);

                      if($stk){
                        foreach ($stk as $s) {
                          echo "<option>".$s->kegiatan."</option>";
                        }
                      }


                    ?>
                  </select>
                </div>
              </div>
            <?php } ?>
							<div class="form-group">
								<label for="inputUraian" class="col-sm-3 control-label">Uraian Tugas

									<?php
									if (preg_match('/Guru/',$jabatan) and $pegawai->jenjab == 'Fungsional')
										echo($jabatan);
									?>
								</label>
								<div class="col-sm-9" id="divUraianTugas">
									<textarea class="form-control" id="inputUraian" name="inputUraian" placeholder="Uraian Tugas" rows="5"></textarea>
								</div>
							</div>
							<div class="form-group">
								<label for="inputUraian" class="col-sm-3 control-label">Angka Kredit</label>
								<div class="col-sm-9">
									<input type="txt" class="form-control" id="inputAK" name="inputAK" placeholder="Angka Kredit" value="0">
								</div>
							</div>
							<div class="form-group">
								<label for="inputKuantitas" class="col-sm-3 control-label">Kuantitas</label>
								<div class="col-sm-5">
									<input type="txt" class="form-control" id="inputKuantitas" name="inputKuantitas" placeholder="Kuantitas">
								</div>
								<div class="col-sm-4">
									<input type="text" class="form-control" id="inputKuantitasSatuan" name="inputKuantitasSatuan" placeholder="satuan">
								</div>
							</div>
							<div class="form-group">
								<label for="inputUraian" class="col-sm-3 control-label">Kualitas (%)</label>
								<div class="col-sm-9">
									<input type="txt" class="form-control" id="inputKualitas" name="inputKualitas" placeholder="Kualitas" value="100">
								</div>
							</div>
							<div class="form-group">
								<label for="inputUraian" class="col-sm-3 control-label">Waktu</label>
								<div class="col-sm-5">
									<input type="txt" class="form-control" id="inputWaktu" name="inputWaktu" placeholder="waktu">
								</div>
								<div class="col-sm-4">
									<input type="txt" class="form-control" id="inputWaktuSatuan" name="inputWaktuSatuan" placeholder="waktu" value="Bln" readonly>
								</div>
							</div>
							<div class="form-group">
								<label for="inputBiaya" class="col-sm-3 control-label">Biaya</label>
								<div class="col-sm-9">
									<input type="txt" class="form-control" id="inputBiaya" name="inputBiaya" value="0">
									<input type="hidden" name="aksi" id="aksi">
									<input type="hidden" name="idskp" value="<?php echo $_GET['idskp'] ?>">
									<input type="hidden" name="idtarget" id="idtarget">
								</div>
							</div>
							<div class="form-group">
								<label for="inputBiaya" class="col-sm-3 control-label">Urutan</label>
								<div class="col-sm-9">
									<input type="txt" class="form-control" id="inputUrutan" name="inputUrutan" value="0">
								</div>
							</div>
						</form>
					</div>
					<div class="col-sm-1">
						<div id="divImgPkg"></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button onclick="tambah_uraian(1)" class="btn btn-primary" id="btnSimpanTambah">Simpan dan tambah uraian</button>
				<button onclick="tambah_uraian(0)" class="btn btn-primary" id="btnSimpanSelesai">Simpan dan selesai</button>
				<button onclick="simpan_uraian()" class="btn btn-primary hide" id="btnSimpanUpdate">Simpan</button>
				<button class="btn btn-danger" data-dismiss="modal">batal</button>
			</div>
		</div>
	</div>
</div>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->

<div class="modal fade" id="skp_review_view" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Catatan Pejabat Penilai terhadap Target Kerja<h5>
			</div>
			<div class="modal-body">
				<?php echo $skp->get_skp_by_id($_GET['idskp'])->review ?>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger" data-dismiss="modal">Tutup</button>
			</div>
		</div>
	</div>
</div>
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->


<script>


	$(document).ready(function(){

		$(".in").removeClass("in");
		$("#collapseOne").addClass("in");

		$("#btnSkpAddForm").click(function(){
			$('#formTambahUraian')[0].reset();
			$("#skp_add_form").modal("show");
		});


		$('#skp_add_form').on('hidden.bs.modal', function(e){
			$("#btnSimpanUpdate").hide();
			$("#btnSimpanTambah").show();
			$("#btnSimpanSelesai").show();
			isi(0);
		});

		$("a#hapus").on("click", function(){

			idskp = $(this).attr('idskp');
			del = confirm("yakin akan hapus "+idskp);
			if(del == true){
				$(this).closest('tr').remove();
				$.post("skp.php",{aksi:"delSkp", idskp: idskp});

			}else{
				//alert("kela kela, can yakin yeuh tong waka di apus");
				return false;
			}
		});


    $("#stk_skp").on("change", function(){

        $("#inputUraian").val($("#stk_skp").val());



    })

		$("#formTambahUraian").validate({
			rules: {
				inputUraian: {
							required: true,
							minlength: true
				},
				inputKuantitas: {
						required: true,
						digits : true
				},
				inputKualitas: {
						required: true,
						digits : true
				},
				inputWaktu: {
						required: true,
						digits: true
				}
			},
			messages: {
				inputUraian: {
					required: "Uraian tidak Boleh Kosong",
					minlength: "Tidak Boleh Kosong"
				},
				inputKuantitas: {
					required: "kuantitas tidak boleh kosong",
					digits: "Harus dalam angka"
				},
				inputKualitas: {
					required: "Kualitas tidak boleh kosong",
					digits: "Harus dalam angka"
				},
				inputWaktu: {
					required: "Waktu tidak boleh kosong",
					digits: "Harus dalam angka"
				}
			}
		});


	});

	function hapus_target(id){

		//idtarget = $(this).attr('idtarget')
		idtarget = id;
		del = confirm("yakin akan hapus ");
		if(del == true){
			$("a#"+idtarget+"").closest('tr').remove();
			$.post("skp.php",{aksi: "delTarget", idtarget: idtarget});

		}
	}


	function tambah_uraian(plus){


		$("#aksi").val("tambahTarget");
		var uraian 			= $("#inputUraian").val();
		var ak 				= $("#inputAK").val();
		var kuantitas		= $("#inputKuantitas").val();
		var kuantitas_satuan = $("#inputKuantitasSatuan").val();
		var kualitas 		= $("#inputKualitas").val();
		var waktu 			= $("#inputWaktu").val();
		var waktuSatuan		= $("#inputWaktuSatuan").val();
		var biaya 			= $("#inputBiaya").val();


		$.post("skp.php", $("#formTambahUraian").serialize())
		 .done(function(data){
			if($.isNumeric(data)){
				var tambah = "<tr><td></td><td colspan='2'>"+uraian
					+"</td><td>"+ak+"</td><td>"+kuantitas+" "+kuantitas_satuan
					+"</td><td>"+kualitas+" %</td><td>"+waktu+" "+waktuSatuan
					+"</td><td>"+biaya +"</td>"
					+"<td style='padding-right:0px' class='hidden-print'>"
					+"<a href='#' onclick='update_uraian("+data+")' class='btn btn-info btn-xs btn-skp'>edit</a> "
					+"<a href='#' id='"+data+"' idtarget='"+data+"' onclick='hapus_target("+data+")' class='btn btn-danger btn-xs removebutton btn-skp'>hapus</a>"
					+"</td></tr>";
					$('#skp_target_table tr:last').after(tambah);
				if(plus == 1){
					$('#formTambahUraian')[0].reset();
				}else {
					$("#skp_add_form").modal("hide");
					$('#formTambahUraian')[0].reset();
				}
			}else{
				alert(data);
			}
		});
	}

	function update_uraian(idtarget){

    //alert("test ".idtarget);

		$.post("skp.php",{aksi: "getUraianTarget", idtarget:idtarget})
		 .done(function(data){
			obj = JSON.parse(data);
			$("#aksi").val("updateTarget");
			$("#idtarget").val(idtarget);
			$("#inputUraian").val(obj.uraian_tugas);
			$("#inputAK").val(obj.angka_kredit);
			$("#inputKuantitas").val(obj.kuantitas);
			$("#inputKuantitasSatuan").val(obj.kuantitas_satuan);
			$("#inputKualitas").val(obj.kualitas);
			$("#inputWaktu").val(obj.waktu);
			$("#inputWaktuSatuan").val(obj.waktu_satuan);
			$("#inputBiaya").val(obj.biaya);
			$("#inputUrutan").val(obj.urutan);

			if(obj.unsur == null){
				$("#unsur").val("utama");
			}else{
				$("#unsur").val(obj.unsur);
			}
			$("#btnSimpanTambah").hide();
			$("#btnSimpanSelesai").hide();
			$("#btnSimpanUpdate").removeClass("hide");
			$("#btnSimpanUpdate").show();
			$("#skp_add_form").modal("show");
		});

	}

	function simpan_uraian(){
		$.post("skp.php",$("#formTambahUraian").serialize())
		 .done(function(data){
			//alert("update berhasil");
			//$("#skp_add_form").modal("hide");
			window.location.reload();
		});

	}

	function isi(a)
	{
		if(a==0){
			$( "#divUraianTugas" ).html("<textarea class=\"form-control\" id=\"inputUraian\" name=\"inputUraian\" placeholder=\"Uraian Tugas\" rows=\"5\"></textarea>");
			$("#divImgPkg").empty();
			$("#divImgPkg").css({width:'90%',height:'auto'});
		}else{
			$.post("utama_penunjang.php",{idunsur: a}, function(data){
			$( "#divUraianTugas" ).html(data);
			$("#divUraianTugas").find("script").each(function(i) {
				eval($(this).text());
			});
    	});
		}
	}

</script>
<script src="skp.js"></script>
