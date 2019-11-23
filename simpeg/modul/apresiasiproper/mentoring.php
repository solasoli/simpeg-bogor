<?php
	$sub = $obj_pegawai->get_obj($_GET['idp']);


	extract($_GET);
extract($_POST);

if(isset($idel))
{
mysql_query("delete from proper where id_proper=$idel");
mysql_query("delete from proper_tujuan where id_proper=$idel");
}

if(isset($judul) and isset($desc))
{
	$qjab=mysql_query("select jabatan.jabatan from jabatan inner join pegawai on jabatan.id_j=pegawai.id_j where pegawai.id_pegawai=$_SESSION[id_pegawai]");
$jab=mysql_fetch_array($qjab);

mysql_query("insert into proper (id_pegawai,id_jabatan,judul,deskripsi,id_mentor,id_jabatan_mentor,tingkat,tahun) values ($_SESSION[id_pegawai],'$peserta->id_j','$judul','$desc',$id_penilai,'$mentor->id_j','$pim',$tahun)");


}

?>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item active" aria-current="page">Daftar Proyek Perubahan</li>

	</ol>
</nav>
<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Daftar Mentoring Proyek Perubahan</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">MENTORING PROYEK PERUBAHAN</h5>
	</div>
	<div class="panel-body table-responsive">




		<table class="clearfix table table-bordered" id="listskp">
			<thead>
				<tr>
					<th class="text-center">No.</th>
					<th class="text-center">Judul Proyek Perubahan</th>
              <th class="text-center">Diklat Pim Tingkat</th>
              <th class="text-center">Tahun</th>
					<th class="hidden-print">Aksi</th>
				</tr>
			</thead>
			<tbody>
				<?php


		//			$qcek=mysql_query("select count(*) from proper where id_pegawai=$_SESSION[id_pegawai]");
		//			$cek=mysql_fetch_array($qcek);

					$qcek2=mysql_query("select count(*) from proper where id_mentor=$_SESSION[id_pegawai]");
					$cek2=mysql_fetch_array($qcek2);

					if($cek[0] > 0 or $cek2[0] > 0 ){
$t=1;

if($cek[0]>0)
{
    $qpro=mysql_query("select * from proper where  id_mentor=$_SESSION[id_pegawai]");
					while($pro=mysql_fetch_array($qpro)){
				?>
				<tr>
					<td><?php echo $t++ ;  ?>.</td>
					<td><?php echo ($pro['judul']);
						?></td>
                        <td align="center"><?php  echo $pro[7]; ?> </td>
                         <td align="center"><?php  echo $pro[8]; ?> </td>
					<td class="hidden-print">
						<a href="index.php?page=proper&idp=<?php echo $pro[0]; ?>" class="btn btn-primary btn-xs">BUKA</a>
                        <a href="index.php?page=list&idel=<?php echo $pro[0]; ?>" class="btn btn-danger btn-xs">HAPUS</a>
					</td>
				</tr>
				<?php
					}
					}
					else
					{

$qpro=mysql_query("select * from proper where  id_mentor=$_SESSION[id_pegawai]");
					while($pro=mysql_fetch_array($qpro)){
				?>
				<tr>
					<td><?php echo $t++ ;  ?>.</td>
					<td><?php echo ($pro['judul']);
						?></td>
                        <td align="center"><?php  echo $pro[7]; ?> </td>
                         <td align="center"><?php  echo $pro[8]; ?> </td>
					<td class="hidden-print">
						<a href="index.php?page=mentor_monitor&idp=<?php echo $pro[0]; ?>" class="btn btn-primary btn-xs">BUKA</a>


					</td>
				</tr>

					<?php
					}


					}
					}
					else{
						echo "<tr><td colspan='6' class='danger text-center'>tidak ada Proyek Perubahan yang ditemukan</td></tr>";
					}
				?>
			</tbody>
		</table>
	</div>
	<div class="panel-footer hidden-print">

		<?php if($pegawai->skp_block == 0){ ?>
		<a class="btn btn-primary" type="button" onclick="properbaru(<?php echo $mentor->id_pegawai ?>)"> + Proyek Perubahan Baru</a>
		<?php } ?>
	</div>
</div>



<!--  tambah skp -->

<div class="modal fade" id="skp_add_form" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Proyek Perubahan Baru </h5>
			</div>
			<div class="modal-body">
				<form role="form" class="form-horizontal" id="proper" name="proper" action="index.php" >
                <input type="hidden" name="page" id="page" value="list" />
					<div class="row">
					<div class="col-md-1"></div>
					<div class="col-md-4 ">
						<div class="form-group">
							<label for="penilai">NIP Mentor</label>
							<div class="form-inline">
								<input type='text' name='nip_penilai' id='nip_penilai' class='form-control' value='<?php echo $mentor->nip_baru ?>'>
								<a id="cari_penilai" class="btn btn-info">CARI</a>
								<input type="hidden" name="id_penilai" id="id_penilai" value="<?php echo $mentor->id_pegawai ?>"/>
							</div>
						</div>
						<div class="form-group">
							<label for="nama_penilai">Nama Mentor</label>
							<input type='text' name='nama_penilai' id='nama_penilai' class='form-control' readonly value='<?php echo $mentor->nama_lengkap ?>'>
						</div>
						<div class="form-group">
							<label for="pangkat_gol">Pangkat/Gol</label>
							<input type="text" name="gol_penilai" id="gol_penilai" class="form-control" value="<?php echo $mentor->pangkat." - ".$mentor->pangkat_gol ?>">
						</div>
						<div class="form-group">
							<label for="jabatan_penilai">Jabatan</label>
							<input type="text" name="jabatan_penilai" id="jabatan_penilai" class="form-control" value="<?php echo $obj_pegawai->get_jabatan($mentor) ?>">
							<input type="hidden" name="id_jabatan" value="<?php echo $mentor-id_j ?>" />
						</div>
						<div class="form-group">
							<label for="unit_kerja_penilai">Unit Kerja</label>
							<input type='text' name='unit_kerja_penilai' id='unit_kerja_penilai' class='form-control' value='<?php echo $mentor->nama_baru ?>'>
							<input type="hidden" name="id_unit_kerja_penilai" id="id_unit_kerja_penilai" value="<?php echo $mentor->id_unit_kerja ?>"/>

						</div>
					</div>
					<div class="col-md-1 "></div>
					<div class="col-md-4">
						  <div class="form-group">
							<label for="pim">Diklat Kepemimpinan Tingkat</label>
							<select name="pim" id="pim" class="form-control">
                            <option value="IV">IV </option>
                            <option value="III">III </option>
                            <option value="II">II </option>
                            </select>
						</div>
						<div class="form-group">
							<label for="judul">Judul Proyek Perubahan</label>
							<textarea name="judul" id="judul" class="form-control" rows="5" ></textarea>
						</div>
                        <div class="form-group">
							<label for="tahun">Tahun</label>
							<select class="form-control" name="tahun" id="tahun"><?php for($t=date("Y");$t>=2014;$t--) echo("<option value=$t>$t</option>"); ?> </select>
						</div>
						<div class="form-group">
							<label for="jabatan_penilai">Deskripsi Proyek Perubahan</label>
							<textarea name="desc" id="desc" class="form-control" rows="5" ></textarea>
                        </div>

					</div>
					</div>
					<hr>

				</form>
			</div>
			<div class="modal-footer">
				<a  onclick="berikutnya()" data-toggle="modal" class="btn btn-primary">Simpan</a>
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

		function properbaru(idpenilai){

			if(!idpenilai){
				alert("penilai tidak ditemukan");
				//window.location.replace("<?php echo BASE_URL ?>index3.php?x=box.php&od=<?php echo $pegawai->id_pegawai ?>");
				$('#skp_add_form').modal('show');
			}else{
				$('#skp_add_form').modal('show');
			}
		}

		function berikutnya(){

			document.getElementById("proper").submit();
		}
</script>
<script src="skp.js"></script>
