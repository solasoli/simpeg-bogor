<!-- Tab Content of Riwayat Jabatan -->

				<table class="hurup table table-bordered" width="90%">
					<thead>
					<tr>
					  <th>No </th>
						<th>Jenjang</th>
					  <th>Jabatan</th>
					  <th>No. Surat Keputusan</th>
					  <th>TMT</td>
					  <th>Berkas Digital</th>
						<?php //if($is_tim){ ?>
								<th></th>
						<?php //} ?>

					</tr>
				</thead>
					<?php

						//$qRiwayatJabatan = "select jabatan,nama_baru,no_sk,tmt,id_berkas from sk inner join jabatan on sk.id_j=jabatan.id_j inner join unit_kerja on unit_kerja.id_unit_kerja=jabatan.id_unit_kerja  where sk.id_pegawai=$od and id_kategori_sk=10 order by sk.tmt desc";
						$qRiwayatJabatan_old = "SELECT s.id_sk, s.id_pegawai, s.no_sk, s.tmt, s.gol, s.mk_tahun, s.mk_bulan,
						p.nip_baru, p.nama, rmk.id_riwayat, rmk.id_j, j.jabatan, uk.nama_baru, s.id_berkas
						FROM sk s, pegawai p, riwayat_mutasi_kerja rmk, unit_kerja uk, jabatan j
						WHERE s.id_pegawai = p.id_pegawai AND p.id_pegawai = $od
						AND s.id_sk = rmk.id_sk AND rmk.id_unit_kerja = uk.id_unit_kerja AND rmk.id_j = j.id_j AND s.id_kategori_sk = 10
						ORDER BY s.tmt DESC";

						$qRiwayatJabatan = "
							select * from
							(select 'Struktural' as jenjang, sk.id_sk as id, rmk.jabatan, sk.tmt as tmt_jabatan, sk.*
							from riwayat_mutasi_kerja rmk
							left join sk on sk.id_sk =  rmk.id_sk
							where rmk.id_pegawai = ".$od." and sk.id_kategori_sk = 10
							union all
							select 'Fungsional' as jenjang, jp.id as id, jp.jabatan, sk.tmt as tmt_jabatan, sk.*
							from jafung_pegawai jp
							left join sk on sk.id_sk = jp.id_sk
							where jp.id_pegawai = ".$od."
							union all
							select 'Pelaksana' as jenjang, jfu.id as id, jfu.jabatan, jfu.tmt as tmt_jabatan, sk.* from jfu_pegawai jfu
							left join sk on sk.id_sk = jfu.id_sk
							where jfu.id_pegawai = ".$od.") a
							order by tmt_jabatan ASC
							";
							//echo $qRiwayatJabatan;
						$rsRiwayatJabatan = mysqli_query($mysqli,$qRiwayatJabatan);
						$no = 1;
					?>
					<tbody>
					<?php while($jab = mysqli_fetch_array($rsRiwayatJabatan)): ?>

					<tr>

						<td><?php echo $no++; ?> </td>
						<td><?php echo $jab['jenjang'] ?>
						<td >
							<?php echo $jab['jabatan']; ?>
						</td>
						<td nowrap="nowrap">
							<?php echo $jab['no_sk']; ?>
						</td>

						<td nowrap="nowrap">
						<?php

								echo $format->date_dmY($jab['tmt_jabatan']);
						 ?>
						</td>
						<td>
              <?php
								if($jab['id_berkas'] != '' || $jab['id_berkas'] != NULL){
									echo "<a href=https://arsipsimpeg.kotabogor.go.id/simpeg/berkas.php?idb=".$jab['id_berkas']." target='_blank'>view</a>";
								//echo $jab['id_berkas'];
							}
											//	echo "<pre>";
											//	print_r($jab);
											// echo "</pre>";
					//
						/****** == UPLOAD SK JABATAN == */



						?>
                        </td>
												<td>
													<?php // if($is_tim && $jab['jenjang'] == 'Pelaksana'){ ?>
												<a onclick="hapusrj('<?php echo $jab['jenjang']."',".$jab['id'] ?>)"><span class="glyphicon glyphicon-remove" style="color:red!important;"></span></a>
											<?php // } ?>
										</td>
											</tr>
					<?php endwhile; ?>
				</tbody>
				</table>
				<script>

						function hapusrj(jenjang, id){

							swal({
								  title: "Anda Yakin untuk menghapus?" + jenjang,
								  text: "Data tidak bisa di kembalikan!",
								  type: "warning",
								  showCancelButton: true,
								  confirmButtonColor: "#DD6B55",
								  confirmButtonText: "Hapus!",
								  closeOnConfirm: false
								},
								function(){

								  $.post("../simpeg2/index.php/pegawai/delete_riwayat_jabatan", {"jenjang": jenjang, "id": id}, function (data) {
						            if(data == '1'){
													//swal("Deleted!", "Berhasil menghapus Riwayat Jabatan.", "success");
													window.location.reload();
												}else{
													swal("GAGAL!", " Gagal menghapus Riwayat Jabatan "+ data, "warning");

												}
						        });
								});
							//swal("Underconstruction!", " Gagal menghapus Riwayat Jabatan.", "warning");

						}

				</script>

		<!-- End of Tab Content of Riwayat Jabatan Struktural-->
		<?php //if($is_tim){ ?>
		<!--<a class="btn btn-primary" type="button" onclick="addJafung()">tambah riwayat Jabatan</a>-->
	<?php  //} ?>
		<?php if($_SESSION['id_pegawai'] == '11301' || $_SESSION['id_pegawai'] == '9819'|| $_SESSION['id_pegawai'] == '1697'/* $is_tim == 1 */){ ?>
		<a class="btn btn-primary" type="button" onclick="addJafung()">tambah riwayat jafung</a>
	<?php } ?>
		<div class="modal fade" id="jafungForm" role="dialog">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header text-primary">
						<h5><span class="glyphicon glyphicon-plus"></span> Tambah Riwayat Jabatan</h5>
					</div>
					<div class="modal-body">
						<form role="form" class="form-horizontal" name="riwayat_jabatan_form" id="riwayat_jabatan_form">
							<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-8 ">
								<?php
										$qJafung = mysqli_query($mysqli,"select nama_jafung from jafung group by nama_jafung");

								?>

								<div class="form-group">
									<label for="jenjang">Jenjang</label>
									<select name='jenjang' id='jenjang' class="form-control" onchange="change_jenjang()">
										<option></option>
										<option value="1">Pelaksana</option>
										<option value="2">Fungsional</option>
									</select>
									<input type="hidden" name="id_pegawai" id="id_pegawai" value="<?php echo $od ?>" />
								</div>
								<div  class="form-group hide" id="pilihan_jafung">
									<label for="nama_penilai">Jabatan Fungsional</label>
									<select name='nama_jafung' id='nama_jafung' class="form-control">
										<option></option>
										<?php while($rj = mysqli_fetch_object($qJafung)){ ?>
											<option><?php echo $rj->nama_jafung ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group hide " id="pilihan_jafung2">
									<label for="jenjang_jafung">Jenjang Fungsional</label>
									<select name='jenjang_jafung' id='jenjang_jafung' class="form-control">
										<option>--PILIH JABATAN FUNGSIONAL--</option>
									</select>
								</div>

								<?php
									$qPelaksana = mysqli_query($mysqli,"select * from jfu_master order by nama_jfu");
								?>
								<div id="pilihan_pelaksana" class="form-group hide ">
									<label for="nama_pelaksana">Jabatan Pelaksana</label>
									<input id="nama_pelaksana" name="nama_pelaksana" type="text" size="50" class="form-control"  />
									<input id="id_jfu" name="id_jfu" type="hidden"/>
									<input id="kode_jabatan" name="kode_jabatan" type="hidden"/>
									<div id="container"></div>
									<!--select name='nama_pelaksana' id='nama_pelaksana' class="form-control">
										<option></option>
										<?php // while($rj = mysqli_fetch_object($qPelaksana)){ ?>
											<option><?php // echo $rj->nama_jfu ?></option>
										<?php // } ?>
									</select -->
								</div>
								<script>
									function change_jenjang(){

										//alert($("#jenjang").val());
										j = $("#jenjang").val();

										if(j == 1){
											$("#pilihan_pelaksana").removeClass("hide");
											$("#pilihan_jafung").addClass("hide");
											$("#pilihan_jafung2").addClass("hide");
										}else{
											$("#pilihan_jafung").removeClass("hide");
											$("#pilihan_jafung2").removeClass("hide");
											$("#pilihan_pelaksana").addClass("hide");
										}
									}

									$( "#nama_pelaksana" ).autocomplete({
										source: function( request, response ) {
													$.ajax({
														  url: "prosesjfu.php",
														  dataType: "json",
														  data: {
														    q: request.term
														  },
														  success: function( data ) {
														    response($.map(data, function(item) {

									                                return {
									                                    label: item.nama_jfu,
									                                    value: item.nama_jfu,
																											kode_jabatan: item.kode_jabatan,
																											id_jfu: item.id_jfu
									                                    };
									                            }));//response
														  }
													});
												},
										appendTo: "#container",
										select: function(event, ui) {
											console.log("id jfu" + ui.item.id_jfu);

									        $('#kode_jabatan').val(ui.item.kode_jabatan);
													$('#id_jfu').val(ui.item.id_jfu);
													//alert($('#id_jfu').val());
									    }


									});
								</script>
								<div id="no_sk" class="form-group">
									<label for="no_sk">Nomer SK</label>
									<input type="text" name='no_sk_' id='no_sk_' class="form-control">

								</div>



							</div>
							<div class="col-md-1 "></div>

							</div>

							<div class="row">
								<div class="col-md-1"></div>
								<div class="form-group col-md-4">
									<label for="periode_awal">Tanggal SK</label>
									<div class="form-inline">
										<input type='text' name='tgl_sk' id='tgl_sk' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='form-control tanggal'>
									</div>
								</div>
								<div class="col-md-2"></div>
								<div class="form-group col-md-4">
									<label for="periode_akhir">Terhitung Mulai Tanggal</label>
									<div class="form-inline">
											<input type='text' name='tmt_jfu' id='tmt_jfu' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='form-control tanggal' >
									</div>
								</div>
							</div>

						</form>
					</div>
					<div class="modal-footer">
						<a id="simpan_jabatan" data-toggle="modal" class="btn btn-primary">Simpan</a>
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
			})

			function addJafung(){
				$("#jafungForm").modal('show');
			}

			$("#nama_jafung").on("change",function(){
				$.post("find_jenjang_jafung.php",{nama_jafung: $("#nama_jafung").val()}, function(data){
					$("select[name='jenjang_jafung']").find("option").remove();
					var jenjang = jQuery.parseJSON(data);
					$.each(jenjang, function(key, value){
						$("select[name='jenjang_jafung']").append("<option value='" + value.id_jafung + "'>" + value.nama_jafung +" "+ value.jenjang_jabatan + " ("+ value.pangkat_gol +")</option>");
					});
				})

			});

			$("#simpan_jabatan").on("click", function(){
					//alert("ini " + $("#riwayat_jabatan_form").serializeArray());
					//alert($("#id_jfu").val());
					//console.log($("#riwayat_jabatan_form").serialize());
				//$.post("modul/profil/simpan_riwayat_jabatan.php", $("#riwayat_jabatan_form").serialize(), function (data){
				$.post("modul/profil/simpan_riwayat_jabatan.php", {id_jfu:$("#id_jfu").val(),
																														jenjang:$("#jenjang").val(),
																														id_pegawai:$("#id_pegawai").val(),
																														nama_pelaksana:$("#nama_pelaksana").val(),
																														kode_jabatan:$("#kode_jabatan").val(),
																														no_sk:$("#no_sk_").val(),
																														tgl_sk:$("#tgl_sk").val(),
																														tmt_jfu:$("#tmt_jfu").val()
																													}, function (data){

					//alert($("input[id_jfu]").val());

					if(data == 1){
						//alert("berhasil");
						//alert(data);
						window.location.reload();
					}else{
						//console.log(data);
						swal("GAGAL!", " Gagal Menyimpan Riwayat Jabatan!! "+  data, "warning");
					}
				});



			});

		</script>
