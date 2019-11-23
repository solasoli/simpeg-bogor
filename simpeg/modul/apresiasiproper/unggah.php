<?php

if(isset($_POST)){
	extract($_POST);
}




$qpendek=mysqli_query($mysqli,"select * from proper where id_proper= $idp ");
$pendek=mysqli_fetch_array($qpendek);

$pail=@$_FILES['pdf'];

if($pail['size']>0 and $pail['type']=='application/pdf')
{
$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/simpeg/proper/';
$uploadfile = $uploaddir."$idp".".pdf";
move_uploaded_file($pail['tmp_name'], $uploadfile);

}
else
echo("<div align=center>File Proyek Perubahan harus dalam format PDF </div>");

?>

<div class="hidden-print">


<nav>
	<ol class="cd-multi-steps text-bottom count">
		<li class="visited"><a href="index.php?page=proper&idp=<?php echo $idp; ?>">Data</a></li>
		<li class="visited"><a href="index.php?page=unggah&idp=<?php echo $idp; ?>"><strong>Upload</strong></a></li>
         <li class="visited"><a href="index.php?page=monitor_proper&idp=<?php echo $idp; ?>">Monitoring</a></li>


	</ol>
</nav>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h5>Upload File PDF Proyek Perubahan : <strong><?php echo $pendek[3]; ?></strong></h5>
			</div>
			<div class="panel-body">

				<table class="clearfix table table-bordered" id="skp_target_table">
					<tr>
						<td width="2%"><strong>NO</strong></td>
						<td colspan="2" width="48%"><strong>Data Peserta</strong></td>
						<td width="2%"><strong>NO</strong></td>
						<td colspan="5" width="48%"><strong>Mentor</strong></td>
					</tr>
					<tr>
						<td>1.</td>
						<td width="10%">Nama</td>
						<td><?php echo $peserta->nama_lengkap ?></td>
						<td>1.</td>
						<td width="10%">Nama</td>
						<td colspan="4"><?php echo $mentor->nama_lengkap ?></td>
					</tr>
					<tr>
						<td>2.</td>
						<td>NIP</td>
						<td><?php echo ($mentor->flag_pensiun == '0' || $mentor->flag_pensiun == '1') ? $mentor->nip_baru : "-" ?></td>
						<td>2.</td>
						<td>NIP</td>
						<td colspan="4"><?php echo $peserta->nip_baru ?></td>
					</tr>
					<?php
						$sql = "select count(*) as jumlah from sk where id_pegawai = ".$_SESSION['id_pegawai']." AND id_kategori_sk IN (5,7)";
						$q = mysqli_query($mysqli,$sql);
						while($row = mysqli_fetch_array($q)){
							$jml = $row['jumlah'];
						}
					?>
					<tr>
						<td>3.</td>
						<td>Pangkat/Gol.Ruang</td>
						<td><?php
							if($mentor->flag_pensiun == 0 || $mentor->flag_pensiun == 1){
								echo isset($theProper->gol_penilai) ? $theProper->gol_penilai : $mentor->pangkat." - ".$mentor->pangkat_gol ;
							}else{
								echo "-";
							}

							?>
						</td>
						<td>3.</td>
						<td><?php echo $jml==0?"Gol.Ruang":"Pangkat/Gol.Ruang" ?></td>
						<td colspan="4"><?php echo isset($theProper->gol_pegawai) ? $theProper->gol_pegawai : ($jml==0?$peserta->pangkat_gol:$peserta->pangkat." - ".$peserta->pangkat_gol)  ?></td>
					</tr>
					<tr>
						<td>4.</td>
						<td>Jabatan</td>
						<td><?php echo $obj_pegawai->get_jabatan_struktural_by_id($theProper->id_jabatan)->jabatan; ?></td>
						<td>4.</td>
						<td>Jabatan</td>
						<td colspan="4"><?php echo $obj_pegawai->get_jabatan_struktural_by_id($theProper->id_jabatan_mentor)->jabatan ?></td>
					</tr>
					<tr>
						<td>5.</td>
						<td>Unit Kerja</td>
						<td><?php echo $unit_kerja->get_unit_kerja($obj_pegawai->get_jabatan_struktural_by_id($theProper->id_jabatan_mentor)->id_unit_kerja)->nama_baru ?></td>
						<td>5.</td>
						<td>Unit Kerja</td>
						<td colspan="4"><?php echo $unit_kerja->get_unit_kerja($obj_pegawai->get_jabatan_struktural_by_id($theProper->id_jabatan_mentor)->id_unit_kerja)->nama_baru ?></td>
					</tr>
				</table>

            <?php
			if(file_exists($_SERVER['DOCUMENT_ROOT'].'/simpeg/proper/'.$idp.'.pdf'))
			{

			?>
            <a href="../../proper/<?php echo "$idp".'.pdf'; ?>" target="_blank">Download PDF</a>
            <?php
			}
			?>
				<form class="form" role="form" name="form1" id="form1" action="index.php?page=unggah&idp=<?php echo $_GET['idp'] ?>" method="post" enctype="multipart/form-data">

					<div class="form-group">
						<label for="jabatan_pegawai">File PDF Proyek Perubahan </label>
						<input name="pdf" type="file" />
					max (5MB)</div>
                    <input type="hidden" name="jangka" id="jangka" value="pendek" />
                      <input type="hidden" name="page" id="page" value="unggah" />
                        <input type="hidden" name="idp" id="idp" value="<?php echo $idp; ?>" />
<button id="btnPeriode" class="btn btn-primary" onclick="submit1();">UPLOAD</button>
				</form>

			</div>
		</div>
	</div>
	<!-- target -->
	<div class="row">
<div class="row">
<!-- realisasi -->

<script>

function submit1()
{
document.getElementById("form1").submit();
}




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
