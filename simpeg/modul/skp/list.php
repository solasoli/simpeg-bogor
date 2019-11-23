<?php
	//$sub = $obj_pegawai->get_obj($_GET['idp']);
	$sub = $obj_pegawai->get_obj($_SESSION['id_pegawai']);
//	print_r($_SESSION);
?>
<script type="application/javascript">

	$(document).ready(function(){

		$(".tanggal").combodate({
			minYear: 2010,
			maxYear: <?php echo date('Y')+1; ?>
		});
		$(".day").addClass("form-control");
		$(".month").addClass("form-control");
		$(".year").addClass("form-control");


		$('.datepicker').datepicker({
			 format: 'yyyy-mm-dd',
			 autoclose: true
		});

		$(".in").removeClass("in");
		$("#collapseTwo").addClass("in");

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

	function save_tgl_laporan(){

		tahun = $("#tahun_penilaian").val();
		//alert($("#tgl_diterima_atasan").val());

		$.post("skp.php", { aksi:	 "ubahTanggalPenerimaan",
							id_pegawai : <?php echo $_SESSION['id_pegawai'] ?>,
							periode_akhir : tahun,
							tgl_diterima: $("#tgl_diterima").val() ,
							tgl_diterima_atasan: $("#tgl_diterima_atasan").val()

							})
		.done(function(data){

				$("#tgl_penerimaan").modal("hide");
				alert("berhasil");
				//window.location.replace("index.php?page=formulir&idskp="+data);

	  });

	}

	function show_tanggal(tahun){

		var d = new Date(tahun);
		var n = d.getFullYear();

		$("#tahunnya").html(n);
		$("#tahun_penilaian").val(tahun);
		$("#tgl_penerimaan").modal("show");
	}

	function show_tanggal_pembuatan(tahun){
        var d = new Date(tahun);
        var n = d.getFullYear();
        $("#tahunnya2").html(n);
        $("#tahun_penilaian2").val(tahun);
        $("#tgl_pembuatan").modal("show");
    }

    function save_tgl_pembuatan(){
        tahun = $("#tahun_penilaian2").val();
        //alert($("#tgl_diterima_atasan").val());

        $.post("skp.php", { aksi:	 "ubahTanggalPembuatan",
            id_pegawai : <?php echo $_SESSION['id_pegawai'] ?>,
            periode_akhir : tahun,
            tgl_pembuatan: $("#tgl_dibuat").val()
        })
            .done(function(data){

                $("#tgl_pembuatan").modal("hide");
                alert("berhasil");
        });
    }

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
			var dua = "<tr><td>2.</td><td>"+periode_awal+" - "+periode_akhir+"</td><td><?php echo isset($penilai->nama) ?  $penilai->nama : "" ?></td><td><?php  echo isset($atasan_penilai->nama) ? $atasan_penilai->nama : "" ; ?></td><td></td><td></td></tr>";
			if(periode_awal.length !== 10 || periode_akhir.length !== 10 || id_penilai.length <= 1 || id_atasan_penilai.length <= 1){
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
						//console.log(data);
						window.location.replace("index.php?page=formulir&idskp="+data);
					}


					});
			}
		}
</script>
<script src="skp.js"></script>

<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item active" aria-current="page">Daftar PPK</li>

	</ol>
</nav>
<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Daftar Penilaian Prestasi <?php echo $sub->nama ?></h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">DAFTAR PENILAIAN PRESTASI KERJA<br> PEGAWAI NEGERI SIPIL</h5>
	</div>
	<div class="panel-body table-responsive">
		<table class="clearfix table table-bordered" id="listskp">
			<thead>
				<tr>
					<th class="text-center">No.</th>
					<th class="text-center">Periode Penilaian Prestasi Kerja</th>
					<th class="hidden-print">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php

					$list_skp = $skp->get_tahun_skp($_SESSION['id_pegawai']);
					$x=1;

					if(mysqli_num_rows($list_skp) > 0){

					while($each_skp = mysqli_fetch_object($list_skp)){
				?>
				<tr>
					<td><?php echo $x++ ;  ?>.</td>
					<td><?php echo $each_skp->tahun
						." (".$format->tanggal_indo($skp->get_awal_periode($_SESSION['id_pegawai'], $each_skp->tahun )->awal)
						." - ".$format->tanggal_indo($skp->get_akhir_periode($_SESSION['id_pegawai'], $each_skp->tahun )->akhir)." )";
						?></td>
					<td class="hidden-print">
						<a href="index.php?page=listtabel&idp=<?php echo $_SESSION['id_pegawai'] ?>&tahun=<?php echo $each_skp->tahun ?>" class="btn btn-primary btn-xs">BUKA</a>
					</td>
				</tr>
				<?php
					}}else{
						echo "<tr><td colspan='6' class='danger text-center'>tidak ada skp yang ditemukan</td></tr>";
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="panel-footer hidden-print">
		<a href="#" class="btn btn-info" type="button" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></a>
		<?php if($pegawai->skp_block == 0){ ?>
		<a class="btn btn-primary" type="button" onclick="skpbaru(<?php echo isset($penilai->id_pegawai) ? $penilai->id_pegawai : "" ?>)">SKP Baru</a>
		<?php } ?>
	</div>
</div>

<!-- tanggal diterima -->
<div class="modal fade" id="tgl_penerimaan" role="dialog">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-calendar"></span> PERIODE PENILAIAN <span id="tahunnya"></span></h5>
			</div>
			<div class="modal-body">
				<form role="form" class="form" id="tgl_laporan">
					<input type="hidden" id="tahun_penilaian" name="tahun_penilaian"/>
					<div class="form-group">
						<label for="inputUraian" class="control-label">Tanggal diterima pegawai :</label>
						<input type="text" class="form-control datepicker" id="tgl_diterima" />

					</div>
					<div class="form-group">
						<label for="inputUraian" class="control-label">Tanggal diterima atasan penilai :</label>
						<input type="text" class="form-control datepicker" id="tgl_diterima_atasan" />
					</div>

				</form>
			</div>
			<div class="modal-footer">
				<a  onclick="save_tgl_laporan()" data-toggle="modal" class="btn btn-primary">SIMPAN</a>
				<a class="btn btn-danger" data-dismiss="modal">Batal</a>
			</div>
		</div>
	</div>
</div>

<!-- tanggal diterima -->
<div class="modal fade" id="tgl_pembuatan" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header text-primary">
                <h5><span class="glyphicon glyphicon-calendar"></span> PERIODE PENILAIAN <span id="tahunnya2"></span></h5>
            </div>
            <div class="modal-body">
                <form role="form" class="form" id="tgl_laporan2">
                    <input type="hidden" id="tahun_penilaian2" name="tahun_penilaian2"/>
                    <div class="form-group">
                        <label for="inputUraian2" class="control-label">Tanggal dibuat pejabat penilai :</label>
                        <input type="text" class="form-control datepicker" id="tgl_dibuat" />

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a  onclick="save_tgl_pembuatan()" data-toggle="modal" class="btn btn-primary">SIMPAN</a>
                <a class="btn btn-danger" data-dismiss="modal">Batal</a>
            </div>
        </div>
    </div>
</div>

<!--  tambah skp -->
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
								<input type='text' name='nip_penilai' id='nip_penilai' class='form-control' value='<?php echo isset($penilai->nip_baru) ? $penilai->nip_baru : "" ?>'>
								<a id="cari_penilai" class="btn btn-info">CARI</a>
								<input type="hidden" name="id_penilai" id="id_penilai" value="<?php echo $penilai->id_pegawai ?>"/>
							</div>
						</div>
						<div class="form-group">
							<label for="nama_penilai">Nama Penilai</label>
							<input type='text' name='nama_penilai' id='nama_penilai' class='form-control' readonly value='<?php echo isset($penilai->nama_lengkap) ? $penilai->nama_lengkap : "" ?>'>
						</div>
						<div class="form-group">
							<label for="pangkat_gol">Pangkat/Gol</label>
							<input type="text" name="gol_penilai" id="gol_penilai" class="form-control" value="<?php echo isset($penilai->pangkat) ? $penilai->pangkat." - ".$penilai->pangkat_gol : "" ?>">
						</div>
						<div class="form-group">
							<label for="jabatan_penilai">Jabatan</label>
							<input type="text" name="jabatan_penilai" id="jabatan_penilai" class="form-control" value="<?php echo @$obj_pegawai->get_jabatan($penilai); ?>">
						</div>
						<div class="form-group">
							<label for="unit_kerja_penilai">Unit Kerja</label>
							<input type='text' name='unit_kerja_penilai' id='unit_kerja_penilai' class='form-control' value='<?php echo isset($penilai->nama_baru) ? $penilai->nama_baru : "" ?>'>
							<input type="hidden" name="id_unit_kerja_penilai" id="id_unit_kerja_penilai" value="<?php echo isset($penilai->id_unit_kerja) ? $penilai->id_unit_kerja : "" ?>"/>

						</div>
					</div>
					<div class="col-md-1 "></div>
					<div class="col-md-4">
						<div class="form-group">
							<label for="penilai">NIP Pejabat Banding</label>
							<div class="form-inline">
								<input type='text' name='nip_atasan_penilai' id='nip_atasan_penilai' class='form-control' value='<?php echo isset($atasan_penilai->nip_baru) ? $atasan_penilai->nip_baru : "" ;?>'>
								<a id="cari_atasan_penilai" class="btn btn-info">CARI</a>
								<input type="hidden" name="id_atasan_penilai" id="id_atasan_penilai" value="<?php echo isset($atasan_penilai->id_pegawai) ? $atasan_penilai->id_pegawai : "" ;?>"/>
							</div>
						</div>
						<div class="form-group">
							<label for="nama_atasan_penilai">Nama Pejabat Banding</label>
							<input type='text' name='nama_atasan_penilai' id='nama_atasan_penilai' class='form-control' readonly value='<?php echo isset($atasan_penilai->nama_lengkap) ? $atasan_penilai->nama_lengkap : "" ?>'>
						</div>
						<div class="form-group">
							<label for="pangkat_gol">Pangkat/Gol Pejabat Banding</label>
							<input type="text" name="gol_atasan_penilai" id="gol_atasan_penilai" class="form-control" value="<?php echo isset($atasan_penilai->golongan) ? $atasan_penilai->golongan : "" ; ?>">
						</div>
						<div class="form-group">
							<label for="jabatan_penilai">Jabatan Atasan Banding</label>
							<input type="text" name="jabatan_atasan_penilai" id="jabatan_atasan_penilai" class="form-control" value="<?php echo  @$obj_pegawai->get_jabatan($atasan_penilai) ;?>">
						</div>
						<div class="form-group">
							<label for="unit_kerja_penilai">Unit Kerja Pejabat Banding</label>
							<input type='text' name='unit_kerja_atasan_penilai' id='unit_kerja_atasan_penilai' class='form-control' value='<?php echo @$atasan_penilai->nama_baru ;?>'>
							<input type="hidden" name="id_unit_kerja_atasan_penilai" id="id_unit_kerja_atasan_penilai" value="<?php echo @$atasan_penilai->id_unit_kerja ;?>"/>

						</div>
					</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-md-1"></div>
						<div class="form-group col-md-4">
							<label for="periode_awal">Periode Awal</label>
							<div class="form-inline">
								<input type='text' name='periodeAwal' id='periodeAwal' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='form-control tanggal' value="<?php echo $format->date_dmY($theSkp->periode_awal)?>" />
							</div>
						</div>
						<div class="col-md-2"></div>
						<div class="form-group col-md-4">
							<label for="periode_akhir">Periode Akhir</label>
							<div class="form-inline">
									<input type='text' name='periodeAkhir' id='periodeAkhir' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='form-control tanggal' value="<?php echo $format->date_dmY($theSkp->periode_akhir)?>" />
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
