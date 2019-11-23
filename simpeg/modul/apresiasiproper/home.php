 <div class="hidden-print">
 <nav>
 	<ol class="cd-multi-steps text-bottom count">
 		<li class="visited"><a href="index.php?page=proper&idp=<?php echo $idp; ?>"><strong>Data</strong></a></li>
 		<li class="visited"><a href="index.php?page=unggah&idp=<?php echo $idp; ?>">Upload</a></li>
          <li class="visited"><a href="index.php?page=monitor_proper&idp=<?php echo $idp; ?>">Monitoring</a></li>


 	</ol>
 </nav>
 </div>

<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Proyek Perubahan</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center"><strong>PROYEK PERUBAHAN<br />
    <?php echo strToUpper($theProper->judul) ?></strong>
    </h5>
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
				<td colspan="4"><?php echo @$mentor->nama_lengkap ?></td>
			</tr>
			<tr>
				<td>2.</td>
				<td>NIP</td>
				<td><?php echo @$peserta->nip_baru ?></td>
				<td>2.</td>
				<td>NIP</td>
				<td colspan="4"><?php echo (@$mentor->flag_pensiun == '0' || @$mentor->flag_pensiun == '1') ? @$mentor->nip_baru : "-" ?></td>
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
				<td><?php echo isset($theProper->gol_pegawai) ? $theProper->gol_pegawai : ($jml==0?$peserta->pangkat_gol:$peserta->pangkat." - ".$peserta->pangkat_gol)  ?></td>
				<td>3.</td>
				<td><?php echo $jml==0?"Gol.Ruang":"Pangkat/Gol.Ruang" ?></td>
				<td colspan="4">
          <?php
  					if(@$mentor->flag_pensiun == 0 || @$mentor->flag_pensiun == 1){
  						echo @$mentor->pangkat." - ".@$mentor->pangkat_gol ;
  					}else{
  						echo "-";
  					}

  					?>
          </td>
			</tr>
			<tr>
				<td>4.</td>
				<td>Jabatan</td>
				<td><?php echo @$obj_pegawai->get_jabatan_struktural_by_id(@$theProper->id_jabatan)->jabatan; ?></td>
				<td>4.</td>
				<td>Jabatan</td>
				<td><?php echo @$obj_pegawai->get_jabatan_struktural_by_id(@$theProper->id_jabatan_mentor)->jabatan ?></td>
			</tr>
			<tr>
				<td>5.</td>
				<td>Unit Kerja</td>
				<td><?php echo @$unit_kerja->get_unit_kerja($obj_pegawai->get_jabatan_struktural_by_id($theProper->id_jabatan_mentor)->id_unit_kerja)->nama_baru ?></td>
				<td>5.</td>
				<td>Unit Kerja</td>
				<td colspan="4"><?php echo @$unit_kerja->get_unit_kerja($obj_pegawai->get_jabatan_struktural_by_id(@$theProper->id_jabatan_mentor)->id_unit_kerja)->nama_baru ?></td>
			</tr>
		</table>

    <strong>Jangka Pendek</strong>
    <table class="table table-bordered">
      <tr class="active">
        <th></th>
        <th width="70%">Tujuan</th>
        <th>Tanggal Capaian</th>
        <th class="hidden-print">Aksi</th>
      </tr>
      <?php

        $sql = "select * from proper_tujuan where id_proper = '".$_GET['idp']."' and jenis_jangka = 'pendek'";

        $result = mysqli_query($mysqli,$sql);
        $a=1;
        while($tujuan = mysqli_fetch_object($result)){
          ?>
          <tr>
            <td><?php echo $a++ ?></td>
            <td><?php echo $tujuan->tujuan_jangka ?></td>
            <td><?php echo $format->date_dmY($tujuan->tanggal_capaian) ?></td>
            <td class="hidden-print"><a onclick="hapus_tujuan(<?php echo $tujuan->id_proper_tujuan ?>)" class="danger"><span class='glyphicon glyphicon-remove warning'></span></a></td>

          </tr>
      <?php
        }
      ?>
    </table>
    <strong>Jangka Menengah</strong>
    <table class="table table-bordered">
      <tr class="active">
        <th></th>
        <th width="70%">Tujuan</th>
        <th>Tanggal Capaian</th>
        <th class="hidden-print">Aksi</th>
      </tr>
      <?php

        $sql = "select * from proper_tujuan where id_proper = '".$_GET['idp']."' and jenis_jangka = 'menengah'";

        $result = mysqli_query($mysqli,$sql);
        $b=1;
        while($tujuan = mysqli_fetch_object($result)){
          ?>
          <tr>
            <td><?php echo $b++ ?></td>
            <td><?php echo $tujuan->tujuan_jangka ?></td>
            <td><?php echo $format->date_dmY($tujuan->tanggal_capaian) ?></td>
            <td class="hidden-print"><a onclick="hapus_tujuan(<?php echo $tujuan->id_proper_tujuan ?>)" class="danger"><span class='glyphicon glyphicon-remove warning'></span></a></td>

          </tr>
      <?php
        }
      ?>
    </table>
    <strong>Jangka Panjang</strong>
    <table class="table table-bordered">
      <tr class="active">
        <th></th>
        <th width="70%">Tujuan</th>
        <th>Tanggal Capaian</th>
        <th class="hidden-print">Aksi</th>
      </tr>
      <?php

        $sql = "select * from proper_tujuan where id_proper = '".$_GET['idp']."' and jenis_jangka = 'panjang'";

        $result = mysqli_query($mysqli,$sql);
        $c=1;
        while($tujuan = mysqli_fetch_object($result)){
          ?>
          <tr>
            <td><?php echo $c++ ?></td>
            <td><?php echo $tujuan->tujuan_jangka ?></td>
            <td><?php echo $format->date_dmY($tujuan->tanggal_capaian) ?></td>
            <td class="hidden-print"><a onclick="hapus_tujuan('<?php echo $tujuan->id_proper_tujuan ?>')" class="danger"><span class='glyphicon glyphicon-remove warning'></span></a></td>

          </tr>
      <?php
        }
      ?>
    </table>
	</div>

	<div class="panel-footer hidden-print">
		<?php if($peserta->skp_block == 0){ ?>
		<a id="btnSkpAddForm" class="btn btn-primary btn-skp">Tambah Tujuan</a>
		<a onclick="setStatus(0)" class="btn btn-warning hide" id="btnBatalAjukanSkp">Batalkan Pengajuan</a>
		<?php } ?>

		<a class="btn btn-primary" id="btnCetak" type="button" onclick="window.print()">
			<span class="glyphicon glyphicon-print"></span>
		</a>
		<a href="#" id="hapus" idskp="<?php echo $_GET['idskp'] ?>" class="btn btn-danger">hapus</a>
		<span class="pull-right">
		</span>
	</div>

  <div class="penandatangan visible-print">
			<table class="table table-noborder">
				<tr>
					<td width="50%" class="text-center">

						<br>Mentor,
						<br><br><br><br><br>
						<span style="text-decoration:underline"><strong><?php echo $mentor->nama_lengkap ?></strong></span>
						<br/><?php echo "NIP. ".$mentor->nip_baru ?>
					</td>
					<td class="text-center">
						Bogor,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<br>Peserta,
						<br><br><br><br><br>
						<span style="text-decoration:underline"><strong><?php echo $peserta->nama_lengkap ?></strong></span>
						<br/><?php echo "NIP. ".$peserta->nip_baru ?>
					</td>
				</tr>
			</table>
		</div>


</div>

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div class="modal fade" id="skp_add_form" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Tambah Tujuan Proper<h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-11">
						<form role="form" class="form-horizontal" id="formTambahUraian">


              <div class="form-group">
                <label for="stk_skp" class="col-sm-3 control-label">Jangka</label>
                <div class="col-sm-9">
                  <select class="form-control" id="jangka" name="jangka">
                    <option></option>
                    <option value="pendek">PENDEK</option>
                    <option value="menengah">MENENGAH</option>
                    <option value="panjang">PANJANG</option>
                  </select>
                </div>
              </div>

							<div class="form-group">
								<label for="tujuan" class="col-sm-3 control-label">Tujuan</label>
								<div class="col-sm-9" id="divUraianTugas">
									<textarea class="form-control" id="tujuan" name="tujuan" placeholder="tujuan" rows="5"></textarea>
								</div>
							</div>

							<div class="form-group">
								<label for="inputKuantitas" class="col-sm-3 control-label">Tanggal Capaian</label>
								<div class="form-inline col-sm-9">
                  <input type='text' name='tanggal_capaian' id='tanggal_capaian' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='form-control tanggal' value='<?php echo $format->date_dmY($theSkp->periode_awal)?>'>
                  <input type="hidden" name="aksi" value="tambahTujuan" />
                  <input type="hidden" name="idp" value="<?php echo $_GET['idp'] ?>" />
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
				<button onclick="tambah_tujuan()" class="btn btn-primary" id="btnSimpanTambah">Simpan</button>
				<button class="btn btn-danger" data-dismiss="modal">batal</button>
			</div>
		</div>
	</div>
</div>


<script>


	$(document).ready(function(){

    $(".tanggal").combodate({
			minYear: 2014,
			maxYear: <?php echo date('Y')+1; ?>
		});
		$(".day").addClass("form-control");
		$(".month").addClass("form-control");
		$(".year").addClass("form-control");


		$(".in").removeClass("in");
		$("#collapseOne").addClass("in");

		$("#btnSkpAddForm").click(function(){
			$('#formTambahUraian')[0].reset();
			$("#skp_add_form").modal("show");
		});







	});



  function tambah_tujuan(){
    $.post("class.proper.php", $("#formTambahUraian").serialize())
     .done(function(data){
       if(data ==1){
         window.location.reload();
       }else{
         console.log(data);
         alert("gagal menyimpan "+ data);
       }
     });
  }

  function hapus_tujuan(id){

		//idtarget = $(this).attr('idtarget')
		idtarget = id;
		del = confirm("yakin akan hapus ");
		if(del == true){
			//$("a#"+idtarget+"").closest('tr').remove();
			$.post("class.proper.php",{aksi: "delTujuan", idTujuan: id})
      .done(function(data){
        window.location.reload();
      })


      //

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


		$.post("class.proper.php", $("#formTambahUraian").serialize())
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
			$( "#divUraianTugas" ).html("<textarea class=\"form-control\" id=\"inputUraian\" name=\"inputUraian\" placeholder=\"Tujuan\" rows=\"5\"></textarea>");
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
<!--script src="skp.js"></script-->
