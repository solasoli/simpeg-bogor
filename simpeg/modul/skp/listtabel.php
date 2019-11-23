<?php
	$sub = $obj_pegawai->get_obj($_GET['idp']);
	$lastSkp = $skp->get_akhir_periode($_GET['idp'], $_GET['tahun']);
?>
<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php?page=list">Daftar PPK</a></li>
		<li class="breadcrumb-item active" aria-current="page"><?php echo $_GET['tahun'] ?></li>
	</ol>
</nav>
<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Daftar Penilaian Prestasi <?php echo $sub->nama ?> Tahun <?php echo $_GET['tahun'] ?></h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center">DAFTAR PENILAIAN PRESTASI KERJA<br> PEGAWAI NEGERI SIPIL</h5>
	</div>

	<div class="panel-body table-responsive" >

		<table class="clearfix table table-bordered" id="listskp">
			<thead>
				<tr>
					<th class="text-center" width="5%">No.</th>
					<th class="text-center" width="50%">Uraian</th>
					<th >Aksi</th>
				</tr>
			</thead>

			<tbody>
				<?php
					$list_skp = $skp->get_skp_by_tahun($_GET['idp'], $_GET['tahun']);
					$x=1;

					if(($jum_skp = mysqli_num_rows($list_skp)) > 0){

					while($each_skp = mysqli_fetch_object($list_skp)){
						
				?>
				<tr>
					<td><?php echo $x++ ;  ?>.</td>
					<td><?php echo "SKP Periode : ".$periode = $format->tanggal_indo($each_skp->periode_awal)." s.d ".$format->tanggal_indo($each_skp->periode_akhir) ?></td>
					<td>
            	<a href="index.php?page=ubah_data&idskp=<?php echo $each_skp->id_skp ?>" class="btn btn-primary btn-xs"> <span class="glyphicon glyphicon-folder-open"></span>  BUKA</a>
							<a href="#" id="hapus" idskp="<?php echo $each_skp->id_skp ?>" class="btn btn-danger btn-xs">hapus</a>
						</td>
				</tr>
				<?php
					}}else{
						echo "<tr><td colspan='6' class='danger text-center'>tidak ada skp yang ditemukan</td></tr>";
					}
				?>

        <tr>
          <td><?php echo $x++; ?></td>
          <td>Penilaian Perilaku dengan nilai SKP Gabungan</td>
          <td>
            <?php if($jum_skp > 1 ){ ?>
							<a href="index.php?page=data_skp&idp=<?php echo $_GET['idp'] ?>&tahun=<?php echo $_GET['tahun'] ?>"
		            onclick="window.open('index.php?page=pg&idp=<?php echo $_GET['idp'] ?>&tahun=<?php echo $_GET['tahun'] ?>&act=print',
		                            'newwindow',
		                            'width=800,height=600');
		                 return false;"
		            class="btn btn-primary btn-xs">Penilaian Perilaku</a>
            <?php } ?>
          </td>
        </tr>
        <tr>
          <td><?php echo $x++; ?></td>
          <td>Data SKP</td>
          <td><a href="index.php?page=data_skp&idp=<?php echo $_GET['idp'] ?>&tahun=<?php echo $_GET['tahun'] ?>"
            onclick="window.open('index.php?page=data_skp&idp=<?php echo $_GET['idp'] ?>&tahun=<?php echo $_GET['tahun'] ?>&act=print',
                            'newwindow',
                            'width=800,height=600');
                 return false;"
            class="btn btn-primary btn-xs">Data SKP</a></td>
        </tr>

        <tr>
          <td><?php echo $x++; ?></td>
          <td>Form SKP Gabungan</td>
          <td>

            <?php if($jum_skp > 1 ){ ?>

              <a href="index.php?page=gabungan&y=<?php echo $_GET['tahun'] ?>&act=print"
                      onclick="window.open('index.php?page=gabungan&y=<?php echo $_GET['tahun'] ?>&act=print',
                                      'newwindow',
                                      'width=800,height=600');
                           return false;" class="btn btn-primary btn-xs">SKP Gabungan</a>
            <?php } ?>
          </td>
        </tr>

        <tr>
          <td><?php echo $x++; ?></td>
          <td>Tanggal Pembuatan</td>
          <td><?php echo $format->tanggal_indo($lastSkp->tgl_pembuatan_penilaian) ?>
						<a  onclick="show_tanggal_pembuatan('<?php echo @$skp->get_akhir_periode($_GET['idp'], @$each_skp->tahun )->akhir ?>')" class="btn btn-primary btn-xs" >Tanggal Pembuatan</a>
					</td>
        </tr>

        <tr>
          <td><?php echo $x++; ?></td>
          <td>Tanggal diterima Pegawai</td>
          <td><?php echo $format->tanggal_indo($lastSkp->tgl_diterima) ?>
						<a  onclick="show_tanggal('<?php echo @$skp->get_akhir_periode(@$_GET['idp'], @$each_skp->tahun )->akhir ?>')" class="btn btn-primary btn-xs" >Tanggal Penerimaan</a>
					</td>
        </tr>
        <tr>
          <td><?php echo $x++; ?></td>
          <td>Tanggal diterima atasan penilai</td>
          <td><?php echo $format->tanggal_indo($lastSkp->tgl_diterima_atasan) ?></td>
        </tr>
        <tr>
          <td><?php echo $x++; ?></td>
          <td>Laporan Akhir</td>
          <td><a href="index.php?page=final2&idp=<?php echo $_GET['idp'] ?>&tahun=<?php echo $each_skp->tahun ?>"
            onclick="window.open('index.php?page=final2&idp=<?php echo $_GET['idp'] ?>&tahun=<?php echo $_GET['tahun'] ?>&act=print',
                            'newwindow',
                            'width=800,height=600');
                 return false;"
             class="btn btn-primary btn-xs">Laporan Akhir</a></td>
        </tr>
        <tr>
          <td><?php echo $x++; ?></td>
          <td>Cover</td>
          <td>
						<a href="index.php?page=cover&idp=<?php echo $_GET['idp'] ?>&tahun=<?php echo $each_skp->tahun ?>"
	            onclick="window.open('index.php?page=cover&idp=<?php echo $_GET['idp'] ?>&tahun=<?php echo $_GET['tahun'] ?>&act=print',
	                            'newwindow',
	                            'width=800,height=600');
	                 return false;"
	             class="btn btn-primary btn-xs">Cover</a>
					</td>
        </tr>
			</tbody>
		</table>
	</div>
	<div class="panel-footer hidden-print">
		<a href="#" class="btn btn-info" type="button" onclick="window.print()"><span class="glyphicon glyphicon-print"></span></a>
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

<script>

	$(document).ready(function(){

		$('.datepicker').datepicker({
			 format: 'yyyy-mm-dd',
			 autoclose: true
		});

		$(".in").removeClass("in");
		$("#collapseTwo").addClass("in");

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

	});

	function save_tgl_laporan(){

		tahun = $("#tahun_penilaian").val();
		//alert($("#tgl_diterima_atasan").val());

		$.post("skp.php", { aksi:	 "ubahTanggalPenerimaan",
							id_pegawai : <?php echo $_GET['idp'] ?>,
							periode_akhir : <?php echo $_GET['tahun'] ?>,
							tgl_diterima: $("#tgl_diterima").val() ,
							tgl_diterima_atasan: $("#tgl_diterima_atasan").val()

							})
		.done(function(data){

				$("#tgl_penerimaan").modal("hide");
				//alert("berhasil");
				window.location.reload();
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
            id_pegawai : <?php echo $_GET['idp'] ?>,
            periode_akhir : <?php echo $_GET['tahun'] ?>,
            tgl_pembuatan: $("#tgl_dibuat").val()
        })
            .done(function(data){

                $("#tgl_pembuatan").modal("hide");
								window.location.reload();
								//console.log(data);
								//alert(data);
        });
    }

</script>
<script src="skp.js"></script>
