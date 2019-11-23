<div class="hidden-print">
 <?php //echo "PERIODE :". $format->date_dmY($theProper->periode_awal)." s.d. ".$format->date_dmY($theProper->periode_akhir)
      $peserta = $obj_pegawai->get_obj($theProper->id_pegawai);
 ?>


</div>
<div class="panel panel-default">
	<div class="panel-heading hidden-print">
		<div class="panel-title">
			<h5>Mentor Monitoring Proyek Perubahan</h5>
		</div>
	</div>
	<div class="visible-print">
		<h5 class="text-center"><strong>PROYEK PERUBAHAN</strong></h5>
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
        <td ><?php echo $peserta->nip_baru ?></td>
				<td>2.</td>
				<td>NIP</td>
        <td><?php echo ($mentor->flag_pensiun == '0' || $mentor->flag_pensiun == '1') ? $mentor->nip_baru : "-" ?></td>

			</tr>
			<?php
				$sql = "select count(*) as jumlah from sk where id_pegawai = ".$_SESSION['id_pegawai']." AND id_kategori_sk IN (5,7)";
				$q = mysql_query($sql);
				while($row = mysql_fetch_array($q)){
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

    <div class="panel panel-default">
			<div class="panel-heading">
				<h5><strong>Tujuan Jangka Pendek</strong></h5>
			</div>
			<div class="panel-body">
        <?php
          $query_status = "select * from proper_status where id_proper = ".$_GET['idp']." and jangka = 'pendek'";
          if($hasil = mysql_query($query_status)){
            $status = mysql_fetch_object($hasil);
            echo "<b>Status Proper : </b>".($status->status ? $status->status : " -- tidak diketahui --");
            echo "<br />";
            echo "<b>Alasan : </b>".($status->alasan ? $status->alasan : " ");
            echo "<br />";
              echo "<b>Persetujuan Mentor :</b>".($status->approvement_mentor == 1 ? " disetujui" : " belum disetujui" );
            echo "<br/>";
          }
        ?>
        <table class="table table-bordered">

          <tr class="active">
            <th></th>
            <th>Tujuan</th>
            <th>Tanggal Capaian</th>
            <th>Status</th>
            <th>Alasan</th>
            <th>Aksi</th>
          </tr>
          <?php

            $sql = "select * from proper_tujuan where id_proper = '".$_GET['idp']."' and jenis_jangka = 'pendek'";

            $result = mysql_query($sql);
            $a=1;
            while($tujuan = mysql_fetch_object($result)){
              ?>
              <tr>
                <td><?php echo $a++ ?></td>
                <td><?php echo $tujuan->tujuan_jangka ?></td>
                <td><?php echo $format->date_dmY($tujuan->tanggal_capaian) ?></td>
                <td><?php echo $tujuan->status ?></td>
                <td><?php echo $tujuan->alasan ?></td>
                <td><a onclick="hapus_tujuan(<?php echo $tujuan->id_proper_tujuan ?>)" class="danger">
                  <span class='glyphicon glyphicon-remove warning'></span></a></td>

              </tr>
          <?php
            }
          ?>
          <tr>
            <td colspan="6"><a onclick="setStatus('pendek')" class="btn btn-warning hidden-print" id="btnBatalAjukanSkp">Setujui</a></td>
          </tr>
        </table>
      </div>
    </div>
    <br/>



    <div class="panel panel-default">
			<div class="panel-heading">
				  <h5><strong>Jangka Menengah</strong></h5>
			</div>
			<div class="panel-body">
    <?php
      $query_status = "select * from proper_status where id_proper = ".$_GET['idp']." and jangka = 'menengah'";
      if($hasil = mysql_query($query_status)){
        $status = mysql_fetch_object($hasil);
        echo "Status Proper : ".$status->status;
        echo "<br />";
        echo "Alasan : ".$status->alasan;
        echo "<br />";
        echo "<b>Persetujuan Mentor :</b>".($status->approvement_mentor == 1 ? " disetujui" : " belum disetujui" );
        echo "<br/>";

      }
    ?>
    <table class="table table-bordered">
      <tr class="active">
        <th></th>
        <th>Tujuan</th>
        <th>Tanggal Capaian</th>
        <th>Status</th>
        <th>Alasan</th>
        <th>Aksi</th>
      </tr>
      <?php

        $sql = "select * from proper_tujuan where id_proper = '".$_GET['idp']."' and jenis_jangka = 'menengah'";

        $result = mysql_query($sql);
        $b=1;
        while($tujuan = mysql_fetch_object($result)){
          ?>
          <tr>
            <td><?php echo $b++ ?></td>
            <td><?php echo $tujuan->tujuan_jangka ?></td>
            <td><?php echo $format->date_dmY($tujuan->tanggal_capaian) ?></td>
            <td><?php echo $tujuan->status ?></td>
            <td><?php echo $tujuan->alasan ?></td>
            <td><a onclick="hapus_tujuan(<?php echo $tujuan->id_proper_tujuan ?>)" class="danger"><span class='glyphicon glyphicon-remove warning'></span></a></td>

          </tr>
      <?php
        }
      ?>
      <tr>
      <td colspan="6"><a onclick="setStatus('menengah')" class="btn btn-warning hidden-print" id="btnBatalAjukanSkp">Setujui</a></td>
    </tr>
    </table>
  </div>
</div>

    <div class="panel panel-default">
			<div class="panel-heading">
				<h5><strong>  <h5><strong>Jangka Panjang</strong></h5></strong></h5>
			</div>
			<div class="panel-body">
    <?php
      $query_status = "select * from proper_status where id_proper = ".$_GET['idp']." and jangka = 'panjang'";
      if($hasil = mysql_query($query_status)){
        $status = mysql_fetch_object($hasil);
        echo "<b>Status Proper : </b>".($status->status ? $status->status : " -- tidak diketahui --");
        echo "<br />";
        echo "<b>Alasan : </b>".($status->alasan ? $status->alasan : " ");
        echo "<br />";
          echo "<b>Persetujuan Mentor :</b>".($status->approvement_mentor == 1 ? " disetujui" : " belum disetujui" );
        echo "<br/>";

      }
    ?>
    <table class="table table-bordered">
      <tr class="active">
        <th></th>
        <th>Tujuan</th>
        <th>Tanggal Capaian</th>
        <th>Status</th>
        <th>Alasan</th>
        <th>Aksi</th>
      </tr>
      <?php

        $sql = "select * from proper_tujuan where id_proper = '".$_GET['idp']."' and jenis_jangka = 'panjang'";

        $result = mysql_query($sql);
        $c=1;
        while($tujuan = mysql_fetch_object($result)){
          ?>
          <tr>
            <td><?php echo $c++ ?></td>
            <td><?php echo $tujuan->tujuan_jangka ?></td>
            <td><?php echo $format->date_dmY($tujuan->tanggal_capaian) ?></td>
            <td><?php echo $tujuan->status ?></td>
            <td><?php echo $tujuan->alasan ?></td>
            <td><a onclick="hapus_tujuan('<?php echo $tujuan->id_proper_tujuan ?>')" class="danger"><span class='glyphicon glyphicon-remove warning'></span></a></td>

          </tr>
      <?php
        }
      ?>
      <tr>
      <td colspan="6"><a onclick="setStatus('panjang')" class="btn btn-info hidden-print" id="btnBatalAjukanSkp">Setujui</a></td>
    </tr>
    </table>
  </div>
</div>
	</div>

	<div class="panel-footer hidden-print">
		<?php if($peserta->skp_block == 0){ ?>
		<a id="btnSkpAddForm" class="btn btn-primary btn-skp">Tambah Tujuan</a>
		s<?php } ?>

		<a class="btn btn-primary" id="btnCetak" type="button" onclick="window.print()">
			<span class="glyphicon glyphicon-print"></span>
		</a>
		<a href="#" id="hapus" idskp="<?php echo $_GET['idskp'] ?>" class="btn btn-danger">hapus</a>
		<span class="pull-right">
		</span>
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
/*
  function setStatus(status){
    $("#jangka").val(status);
    $("#status_form").modal("show");
  }
*/
  function setStatus(jangka){
    acc = confirm("Anda akan menyetujui tujuan jangka "+status+" ini ?");
		if(acc == true){
      $.post("class.proper.php", {aksi : "setujuiMentor", idp : "<?php echo $_GET['idp'] ?>", jangka : jangka})
       .done(function(data){
         if(data ==1){
           window.location.reload();
         }else{
           console.log(data);
           alert("gagal menyimpan "+ data);
         }
       });


      //

		}

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
