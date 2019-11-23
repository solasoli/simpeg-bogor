<div class="hidden-print">
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
		<li class="visited"><strong>Data</strong></li>
		<li class=""><a href="index.php?page=formulir&idskp=<?php echo $idskp ?>">Target</a></li>
		<li class=""><a href="index.php?page=realisasi&idskp=<?php echo $idskp ?>">Realisasi</a></li>
		<li class=""><a href="index.php?page=myperilaku&idskp=<?php echo $idskp ?>">Perilaku</a></li>

	</ol>
</nav>
</div>
<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>Data Periode Penilaian</h5>
			</div>
			<div class="panel-body">
				<form class="form" role="form">
					<div class="form-group">
						<label>Nama Pegawai</label>
						<input type="text" readonly class="form-control" value="<?php echo $obj_pegawai->get_obj($theSkp->id_pegawai)->nama_lengkap ?>" >
					</div>
					<div class="form-group">
						<label for="gol_pegawai">Pangkat/Gol</label>
						<input type="text" name="gol_pegawai" id="gol_pegawai" class="form-control" value="<?php echo $theSkp->gol_pegawai; ?>">
					</div>
					<div class="form-group">
						<label for="jabatan_pegawai">Jabatan</label>
						<input type="text" name="jabatan_pegawai" id="jabatan_pegawai" class="form-control" value="<?php echo $theSkp->jabatan_pegawai; ?>">
					</div>
					<div class="form-group">
						<label for="penilai">Unit Kerja</label>
						<input type='text' name='unit_kerja_pegawai' id='unit_kerja_pegawai' class='form-control' value='<?php echo $unit_kerja->get_unit_kerja($theSkp->id_unit_kerja_pegawai)->nama_baru ;?>'>
						<input type="hidden" name="id_unit_kerja_pegawai" id="id_unit_kerja_pegawai" value="<?php echo $theSkp->id_unit_kerja_pegawai ?>"/>

					</div>
					<div class="form-group">
						<label for="periode_awal">Periode Awal</label>
						<div class="form-inline">
							<input type='text' name='periode_awal' id='periode_awal' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='form-control tanggal' value='<?php echo $format->date_dmY($theSkp->periode_awal)?>'>
						</div>
					</div>
					<div class="form-group">
						<label for="periode_akhir">Periode Akhir</label>
						<div class="form-inline">
								<input type='text' name='periode_akhir' id='periode_akhir' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='form-control tanggal' value='<?php echo $format->date_dmY($theSkp->periode_akhir)?>'>
						</div>
					</div>

				</form>
				<button id="btnPeriode" class="btn btn-primary">SIMPAN</button>
			</div>
		</div>
	</div>
	<!-- target -->
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>Data Penilai Target</h5>
			</div>
			<div class="panel-body">
				<?php $penilai = $obj_pegawai->get_obj($theSkp->id_penilai); ?>
				<form class="form" name="formPenilai">
					<div class="form-group">
						<label for="penilai">NIP Penilai</label>
						<div class="form-inline">
							<input type='text' name='nip_penilai' id='nip_penilai' class='form-control' value='<?php echo $obj_pegawai->get_obj($theSkp->id_penilai)->nip_baru;?>'>
							<a id="cari_penilai" class="btn btn-info">CARI</a>
							<input type="hidden" name="id_penilai" id="id_penilai" value="<?php echo $obj_pegawai->get_obj($theSkp->id_penilai)->id_pegawai?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="nama_penilai">Nama Penilai</label>
						<input type='text' name='nama_penilai' id='nama_penilai' class='form-control' readonly value='<?php echo $obj_pegawai->get_obj($theSkp->id_penilai)->nama_lengkap;?>'>
					</div>
					<div class="form-group">
						<label for="pangkat_gol">Pangkat/Gol</label>
						<input type="text" name="gol_penilai" id="gol_penilai" class="form-control" value="<?php echo $theSkp->gol_penilai; ?>">
					</div>
					<div class="form-group">
						<label for="jabatan_penilai">Jabatan</label>
						<input type="text" name="jabatan_penilai" id="jabatan_penilai" class="form-control" value="<?php echo $theSkp->jabatan_penilai; ?>">
					</div>
					<div class="form-group">
						<label for="unit_kerja_penilai">Unit Kerja</label>
						<input type='text' name='unit_kerja_penilai' id='unit_kerja_penilai' class='form-control' value='<?php echo $unit_kerja->get_unit_kerja($theSkp->id_unit_kerja_penilai)->nama_baru ;?>'>
						<input type="hidden" name="id_unit_kerja_penilai" id="id_unit_kerja_penilai" value="<?php echo $theSkp->id_unit_kerja_penilai ?>"/>

					</div>
				</form>
				<button id="btnPenilai" class="btn btn-primary">SIMPAN</button >
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>Data Atasan Penilai Target</h5>
			</div>
			<div class="panel-body">
				<?php $penilai = $obj_pegawai->get_obj($theSkp->id_atasan_penilai); ?>
				<form class="form" name="formAtasanPenilai">
					<div class="form-group">
						<label for="penilai">NIP Atasan Penilai</label>
						<div class="form-inline">
							<input type='text' name='nip_atasan_penilai' id='nip_atasan_penilai' class='form-control' value='<?php echo $obj_pegawai->get_obj($theSkp->id_atasan_penilai)->nip_baru;?>'>
							<a id="cari_atasan_penilai" class="btn btn-info">CARI</a>
							<input type="hidden" name="id_atasan_penilai" id="id_atasan_penilai" value="<?php echo $obj_pegawai->get_obj($theSkp->id_atasan_penilai)->id_pegawai?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="nama_penilai">Nama Penilai</label>
						<input type='text' name='nama_atasan_penilai' id='nama_atasan_penilai' class='form-control' readonly value='<?php echo $obj_pegawai->get_obj($theSkp->id_atasan_penilai)->nama_lengkap;?>'>
					</div>
					<div class="form-group">
						<label for="pangkat_gol">Pangkat/Gol</label>
						<input type="text" name="gol_atasan_penilai" id="gol_atasan_penilai" class="form-control" value="<?php echo $theSkp->gol_atasan_penilai; ?>">
					</div>
					<div class="form-group">
						<label for="jabatan_atasan_penilai">Jabatan</label>
						<input type="text" name="jabatan_atasan_penilai" id="jabatan_atasan_penilai" class="form-control" value="<?php echo $theSkp->jabatan_atasan_penilai; ?>">
					</div>
					<div class="form-group">
						<label for="unit_kerja_penilai">Unit Kerja</label>
						<input type='text' name='unit_kerja_atasan_penilai' id='unit_kerja_atasan_penilai' class='form-control' value='<?php echo $unit_kerja->get_unit_kerja($theSkp->id_unit_kerja_atasan_penilai)->nama_baru ;?>'>
						<input type="hidden" name="id_unit_kerja_atasan_penilai" id="id_unit_kerja_atasan_penilai" value="<?php echo $theSkp->id_unit_kerja_atasan_penilai ?>"/>

					</div>
				</form>
				<button id="btnAtasanPenilai" class="btn btn-primary">SIMPAN</button>
			</div>
		</div>
	</div>
	<!-- realisasi -->
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>Data Penilai Realisasi</h5>
			</div>
			<div class="panel-body">
				<?php $penilai = $obj_pegawai->get_obj($theSkp->id_penilai); ?>
				<form class="form" name="formPenilaiRealisasi">
					<div class="form-group">
						<label for="penilai">NIP Penilai</label>
						<div class="form-inline">
							<input type='text' name='nip_penilai_realisasi' id='nip_penilai_realisasi' class='form-control' value="<?php echo $theSkp->id_penilai_realisasi ? $obj_pegawai->get_obj($theSkp->id_penilai_realisasi)->nip_baru : '';?>" />
							<a id="cari_penilai_realisasi" class="btn btn-info">CARI</a>
							<input type="hidden" name="id_penilai_realisasi" id="id_penilai_realisasi" value="<?php echo $obj_pegawai->get_obj($theSkp->id_penilai)->id_pegawai?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="nama_penilai">Nama Penilai</label>
						<input type='text' name='nama_penilai_realisasi' id='nama_penilai_realisasi' class='form-control' readonly value="<?php echo $theSkp->id_penilai_realisasi ? $obj_pegawai->get_obj($theSkp->id_penilai_realisasi)->nama_lengkap: ''; ?>" />
					</div>
					<div class="form-group">
						<label for="pangkat_gol">Pangkat/Gol</label>
						<input type="text" name="gol_penilai_realisasi" id="gol_penilai_realisasi" class="form-control" value="<?php echo $theSkp->gol_penilai_realisasi; ?>">
					</div>
					<div class="form-group">
						<label for="jabatan_penilai">Jabatan</label>
						<input type="text" name="jabatan_penilai_realisasi" id="jabatan_penilai_realisasi" class="form-control" value="<?php echo $theSkp->jabatan_penilai_realisasi; ?>">
					</div>
				</form>
				<button id="btnPenilaiRealisasi" class="btn btn-primary">SIMPAN</button>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>Data Atasan Penilai Realisasi</h5>
			</div>
			<div class="panel-body">
				<?php $penilai = $obj_pegawai->get_obj($theSkp->id_atasan_penilai_realisasi); ?>
				<form class="form" name="formAtasanPenilaiRealisasi">
					<div class="form-group">
						<label for="penilai">NIP Atasan Penilai Realisasi</label>
						<div class="form-inline">
							<input type='text' name='nip_atasan_penilai' id='nip_atasan_penilai_realisasi' class='form-control' value="<?php echo $theSkp->id_atasan_penilai_realisasi ? $obj_pegawai->get_obj($theSkp->id_atasan_penilai_realisasi)->nip_baru : "";?>" />
							<a id="cari_atasan_penilai_realisasi" class="btn btn-info">CARI</a>
							<input type="hidden" name="id_atasan_penilai_realisasi" id="id_atasan_penilai_realisasi" value="<?php echo $theSkp->id_atasan_penilai_realisasi ? $obj_pegawai->get_obj($theSkp->id_atasan_penilai_realisasi)->id_pegawai : ""?> "/>
						</div>
					</div>
					<div class="form-group">
						<label for="nama_penilai">Nama Atasan Penilai Realisasi</label>
						<input type='text' name='nama_atasan_penilai_realisasi' id='nama_atasan_penilai_realisasi' class='form-control' readonly value="<?php echo $theSkp->id_atasan_penilai_realisasi ? $obj_pegawai->get_obj($theSkp->id_atasan_penilai_realisasi)->nama_lengkap : "";?>" />
					</div>
					<div class="form-group">
						<label for="pangkat_gol">Pangkat/Gol</label>
						<input type="text" name="gol_atasan_penilai_realisasi" id="gol_atasan_penilai_realisasi" class="form-control" value="<?php echo $theSkp->gol_atasan_penilai_realisasi; ?>">
					</div>
					<div class="form-group">
						<label for="jabatan_penilai">Jabatan</label>
						<input type="text" name="jabatan_atasan_penilai_realisasi" id="jabatan_atasan_penilai_realisasi" class="form-control" value="<?php echo $theSkp->jabatan_atasan_penilai_realisasi; ?>">
					</div>
				</form>
				<button id="btnAtasanPenilaiRealisasi" class="btn btn-primary">SIMPAN</button>
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

		$( "input[name='unit_kerja_pegawai']" ).autocomplete({
			source: "find_opd.php",
			minLength: 3,
			select: function( event, ui ) {
                    console.log ( ui.item ?
                    "Selected: " + ui.item.value + " aka " + ui.item.id :
                    "Nothing selected, input was " + this.value );
					$("#id_unit_kerja_pegawai").val(ui.item.id);
                    //window.location.replace("index.php?page=monitoring&uk="+ui.item.id);

			}
		});

		$( "input[name='unit_kerja_penilai']" ).autocomplete({
			source: "find_opd.php",
			minLength: 3,
			select: function( event, ui ) {
                    console.log ( ui.item ?
                    "Selected: " + ui.item.value + " aka " + ui.item.id :
                    "Nothing selected, input was " + this.value );
					$("#id_unit_kerja_penilai").val(ui.item.id);
                    //window.location.replace("index.php?page=monitoring&uk="+ui.item.id);

			}
		});

		$( "input[name='unit_kerja_atasan_penilai']" ).autocomplete({
			source: "find_opd.php",
			minLength: 3,
			select: function( event, ui ) {
                    console.log ( ui.item ?
                    "Selected: " + ui.item.value + " aka " + ui.item.id :
                    "Nothing selected, input was " + this.value );
					$("#id_unit_kerja_atasan_penilai").val(ui.item.id);

			}
		});

		$("#btnPeriode").on('click',function(){


			awal = $("#periode_awal").val();
			akhir = $("#periode_akhir").val();

			$.post("skp.php", {aksi: "UPDATE_PERIODE_PENILAIAN",
					id_skp:<?php echo $_GET['idskp'] ?>,
					periode_awal: $("#periode_awal").val(),
					periode_akhir: $("#periode_akhir").val(),
					gol_pegawai: $("#gol_pegawai").val(),
					jabatan_pegawai: $("#jabatan_pegawai").val(),
					id_unit_kerja_pegawai: $("#id_unit_kerja_pegawai").val()})
			  .done(function(obj){
				  alert(obj);
			  })
		});

		$("#cari_penilai").on('click',function(){
			$.post('find_atasan.php',{nip:$("#nip_penilai").val()})
			 .done(function(obj){
				data = JSON.parse(obj);
				if(data.id == 0){
					alert("Pegawai Tidak Ditemukan");
					//alert(data);
				}else{
					//alert(data.id);
					$("#id_penilai").val(data.id);
					$("#nama_penilai").val(data.nama);
					$("#gol_penilai").val(data.golongan);
					$("#jabatan_penilai").val(data.jabatan);
				}

			});
		});

		$("#btnPenilai").on("click",function(){

			$.post('skp.php',{aksi:"UPDATE_HEADER",x:"PENILAI",
					id_penilai:$("#id_penilai").val(),
					gol_penilai:$("#gol_penilai").val(),
					jabatan_penilai:$("#jabatan_penilai").val(),
					id_skp : <?php echo $_GET['idskp'] ?>,
					id_unit_kerja_penilai: $("#id_unit_kerja_penilai").val()
					})
			 .done(function(obj){
				 alert(obj);
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
				}
			});
		});

		$("#btnAtasanPenilai").on("click",function(){

			$.post('skp.php',{aksi:"UPDATE_HEADER",x:"ATASAN_PENILAI",
					id_atasan_penilai:$("#id_atasan_penilai").val(),
					gol_atasan_penilai:$("#gol_atasan_penilai").val(),
					jabatan_atasan_penilai:$("#jabatan_atasan_penilai").val(),
					id_skp : <?php echo $_GET['idskp'] ?>,
					id_unit_kerja_atasan_penilai: $("#id_unit_kerja_atasan_penilai").val()
					})
			 .done(function(obj){
				 alert(obj);
			 });
		});

		$("#cari_penilai_realisasi").on('click',function(){
			$.post('find_atasan.php',{nip:$("#nip_penilai_realisasi").val()})
			 .done(function(obj){
				data = JSON.parse(obj);
				if(data.id == 0){
					alert("Pegawai Tidak Ditemukan");
				}else{
					//alert(data.id);
					$("#id_penilai_realisasi").val(data.id);
					$("#nama_penilai_realisasi").val(data.nama);
					$("#gol_penilai_realisasi").val(data.golongan);
					$("#jabatan_penilai_realisasi").val(data.jabatan);
				}

			});
		});

		$("#btnPenilaiRealisasi").on("click",function(){

			$.post('skp.php',{aksi:"UPDATE_HEADER",x:"PENILAI_REALISASI",
					id_penilai_realisasi:$("#id_penilai_realisasi").val(),
					gol_penilai_realisasi:$("#gol_penilai_realisasi").val(),
					jabatan_penilai_realisasi:$("#jabatan_penilai_realisasi").val(),
					id_skp : <?php echo $_GET['idskp'] ?>
					})
			 .done(function(obj){
				 alert(obj);
			 });
		});

		$("#cari_atasan_penilai_realisasi").on('click',function(){

			$.post('find_atasan.php',{nip:$("#nip_atasan_penilai_realisasi").val()})
			 .done(function(obj){
				data = JSON.parse(obj);
				if(data.id == 0){
					alert("Pegawai Tidak Ditemukan");
				}else{
					//alert(data.id);
					$("#id_atasan_penilai_realisasi").val(data.id);
					$("#nama_atasan_penilai_realisasi").val(data.nama);
					$("#gol_atasan_penilai_realisasi").val(data.golongan);
					$("#jabatan_atasan_penilai_realisasi").val(data.jabatan);
				}
			});
		});

		$("#btnAtasanPenilaiRealisasi").on("click",function(){
			$.post('skp.php',{aksi:"UPDATE_HEADER",x:"ATASAN_PENILAI_REALISASI",
					id_atasan_penilai_realisasi:$("#id_atasan_penilai_realisasi").val(),
					gol_atasan_penilai_realisasi:$("#gol_atasan_penilai_realisasi").val(),
					jabatan_atasan_penilai_realisasi:$("#jabatan_atasan_penilai_realisasi").val(),
					id_skp : <?php echo $_GET['idskp'] ?>
					})
			 .done(function(obj){
				 alert(obj);
			 });
		});


	});

</script>
<script src="skp.js"></script>
