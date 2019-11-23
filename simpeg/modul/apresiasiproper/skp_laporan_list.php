<?php
	$sub = $obj_pegawai->get_obj($_GET['idp']);
?>
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
					<th class="text-center">Periode Penilaian Prestasi Kerja2</th>
					<th class="hidden-print">Cetak</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$list_skp = $skp->get_tahun_skp($_GET['idp']);
					$x=1;

					if(mysql_num_rows($list_skp) > 0){

					while($each_skp = mysql_fetch_object($list_skp)){
				?>
				<tr>
					<td><?php echo $x++ ;  ?>.</td>
					<td><?php echo $each_skp->tahun
						." (".$format->tanggal_indo($skp->get_awal_periode($_GET['idp'], $each_skp->tahun )->awal)
						." - ".$format->tanggal_indo($skp->get_akhir_periode($_GET['idp'], $each_skp->tahun )->akhir)." )";
						?></td>
					<td class="hidden-print">
						<a href="index.php?page=final2&idp=<?php echo $_GET['idp'] ?>&tahun=<?php echo $each_skp->tahun ?>" class="btn btn-primary btn-xs">Laporan Akhir</a>
						<a href="index.php?page=data_skp&idp=<?php echo $_GET['idp'] ?>&tahun=<?php echo $each_skp->tahun ?>" class="btn btn-primary btn-xs">Data SKP</a>
            <a  onclick="show_tanggal_pembuatan('<?php echo $skp->get_akhir_periode($_GET['idp'], $each_skp->tahun )->akhir ?>')" class="btn btn-primary btn-xs" >Tanggal Pembuatan</a>
            <a  onclick="show_tanggal('<?php echo $skp->get_akhir_periode($_GET['idp'], $each_skp->tahun )->akhir ?>')" class="btn btn-primary btn-xs" >Tanggal Penerimaan</a>
						<a href="index.php?page=gabungan&y=<?php echo $each_skp->tahun ?>" class="btn btn-primary btn-xs">SKP Gabungan</a>
						<a href="index.php?page=cover&idp=<?php echo $_GET['idp'] ?>&tahun=<?php echo $each_skp->tahun ?>" class="btn btn-primary btn-xs" target="_blank">Cover</a>
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

	});

	function save_tgl_laporan(){

		tahun = $("#tahun_penilaian").val();
		//alert($("#tgl_diterima_atasan").val());

		$.post("skp.php", { aksi:	 "ubahTanggalPenerimaan",
							id_pegawai : <?php echo $_GET['idp'] ?>,
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
            id_pegawai : <?php echo $_GET['idp'] ?>,
            periode_akhir : tahun,
            tgl_pembuatan: $("#tgl_dibuat").val()
        })
            .done(function(data){

                $("#tgl_pembuatan").modal("hide");
                alert("berhasil");
        });
    }

</script>
<script src="skp.js"></script>
