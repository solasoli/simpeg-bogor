<?php $unit_kerja = new Unit_kerja; ?>
<h4>DATA IJIN BELAJAR DAN TUGAS BELAJAR <?php echo $unit_kerja->get_unit_kerja($unit['id_skpd'])->singkatan ?></h4>
<table class="table table-bordered">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama/NIP</th>
      <th>Pangkat/Gol</th>
      <th>Jenjang Pendidikan</th>
      <th>Nama Sekolah</th>
      <th>Program Studi</th>
      <th>Nomor dan Tanggal Akreditasi Sekolah</th>
      <th>Nomor dan Tanggal Izin Belajar</th>
      <th>Perkiraan Tahun Lulus</th>
      <th>Keterangan</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php


      if($_SESSION['id_pegawai'] == 1751 || $_SESSION['id_pegawai'] == 11301){
        $query = mysqli_query($mysqli,"select  IF(LENGTH(p.gelar_belakang) > 1,
                                    CONCAT(IF(LENGTH(p.gelar_depan) > 1,
                                                CONCAT(p.gelar_depan, ' '),
                                                ''),
                                            p.nama,
                                            CONCAT(', ', p.gelar_belakang)),
                                    CONCAT(IF(LENGTH(p.gelar_depan) > 1,
                                                CONCAT(p.gelar_depan, ' '),
                                                ''),
                                            p.nama)) AS nama,  p.nip_baru, a.*

                            from
                            (select ib.*
                          from ijin_belajar_data ib, current_lokasi_kerja clk, unit_kerja uk
                          where ib.id_pegawai = clk.id_pegawai and clk.id_unit_kerja = uk.id_unit_kerja
                        ) as a
                            inner join pegawai p on a.id_pegawai = p.id_pegawai");
      }else{
      $query = mysqli_query($mysqli,"select  IF(LENGTH(p.gelar_belakang) > 1,
                                  CONCAT(IF(LENGTH(p.gelar_depan) > 1,
                                              CONCAT(p.gelar_depan, ' '),
                                              ''),
                                          p.nama,
                                          CONCAT(', ', p.gelar_belakang)),
                                  CONCAT(IF(LENGTH(p.gelar_depan) > 1,
                                              CONCAT(p.gelar_depan, ' '),
                                              ''),
                                          p.nama)) AS nama,  p.nip_baru, a.*

                          from
                          (select ib.*
                        from ijin_belajar_data ib, current_lokasi_kerja clk, unit_kerja uk
                        where ib.id_pegawai = clk.id_pegawai and clk.id_unit_kerja = uk.id_unit_kerja
                        and uk.id_skpd = ".$_SESSION['id_skpd'].") as a
                          inner join pegawai p on a.id_pegawai = p.id_pegawai");
      }
      if(mysqli_num_rows($query) > 0 ){
        $x = 1;
      while($data = mysqli_fetch_object($query)){
    ?>
    <tr>
        <td><?php echo $x++ ?></td>
        <td><?php echo $data->nama."<br>".$data->nip_baru ?></td>
        <td><?php echo $data->pangkat_gol ?></td>
        <td><?php echo $data->jenjang_pendidikan ?></td>
        <td><?php echo $data->nama_sekolah ?></td>
        <td><?php echo $data->program_studi ?></td>
        <td><?php echo $data->nomor_akreditasi." / ".$data->tgl_akreditasi ?></td>
        <td><?php echo $data->nomor_ijin_belajar." / ".$data->tgl_ijin_belajar ?></td>
        <td><?php echo $data->perkiraan_tahun_lulus ?></td>
        <td><?php echo $data->keterangan ?></td>
        <td>
          <a id="btnEditData" onclick="editData(<?php echo $data->id_ijin_belajar_data ?>)"class="btn btn-sm btn-primary">ubah</a>
          <a id="btnHapusData" onclick="deleteData(<?php echo $data->id_ijin_belajar_data ?>)" class="btn btn-sm btn-danger">hapus</a>
        </td>
    </tr>
  <?php }}else{ ?>
    <tr><td colspan="11" style="text-align:center">TIDAK ADA DATA YANG DITAMPILKAN</td></tr>
  <?php } ?>
  </tbody>
</table>

<!----------------------------- -->
<div class="modal fade" id="addForm" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-primary">
				<h5><span class="glyphicon glyphicon-plus"></span> Tambah Data<h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-sm-12">
						<form role="form" class="form-horizontal" id="formData">

              <div class="form-group">
    						<label for="nip" class="col-sm-3 control-label">NIP</label>
    						<div class="form-inline col-sm-9">
    							<input type='text' name='nip' id='nip' class='form-control' value=''>
    							<a id="cari_pegawai" class="btn btn-info">CARI</a>
    							<input type="hidden" name="idPegawai" id="idPegawai">
                  <input type="hidden" name="id" id="id">
    						</div>
    					</div>
							<div class="form-group">
								<label for="nama" class="col-sm-3 control-label">NAMA</label>
								<div class="col-sm-9">
									<input type="txt" class="form-control" id="nama" name="nama" placeholder="nama">
								</div>
							</div>
							<div class="form-group">
								<label for="inputUraian" class="col-sm-3 control-label">Pangkat / Gol</label>
								<div class="col-sm-9">
									<input type="txt" class="form-control" id="golongan" name="golongan" >
								</div>
							</div>
							<div class="form-group">
								<label for="inputBiaya" class="col-sm-3 control-label">Jenjang Pendidikan</label>
								<div class="col-sm-5">
									<select class="form-control" id="jenjang" name="jenjang">
                    <option> -- pilih jenjang -- </option>
                    <option value="SMP">SMP</option>
                    <option value="SMA/SMK">SMA/SMK</option>
                    <option value="D3">Diploma III</option>
                    <option value="S1">Strata-1/Diploma IV</option>
                    <option value="S2">Strata-2</option>
                    <option value="S3">Strata-3</option>
                  </select>
								</div>
							</div>
							<div class="form-group">
								<label for="inputBiaya" class="col-sm-3 control-label">Nama Sekolah</label>
								<div class="col-sm-9">
									<input type="txt" class="form-control" id="namaSekolah" name="namaSekolah">
								</div>
							</div>
              <div class="form-group">
								<label for="inputBiaya" class="col-sm-3 control-label">Program Studi</label>
								<div class="col-sm-9">
									<input type="txt" class="form-control" id="programStudi" name="programStudi" >
								</div>
							</div>
              <div class="form-group">
								<label for="inputUraian" class="col-sm-3 control-label">No/Tgl Akreditasi Sekolah</label>
								<div class="col-sm-5">
									<input type="txt" class="form-control" id="noAkreditasi" name="noAkreditasi" >
								</div>
								<div class="col-sm-4">
                  <div class="form-inline">
      								<input type='text' name='tglAkreditasi' id='tglAkreditasi' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='form-control tanggal' value=''>
      						</div>

								</div>
							</div>
              <div class="form-group">
								<label for="inputUraian" class="col-sm-3 control-label">No/Tgl Izin Belajar</label>
								<div class="col-sm-5">
									<input type="txt" class="form-control" id="nomorIzinBelajar" name="nomorIzinBelajar">
								</div>
								<div class="col-sm-4">
                  <div class="form-inline">
      								<input type='text' name='tglIzinBelajar' id='tglIzinBelajar' data-format='DD-MM-YYYY' data-template='DD MMM YYYY' class='form-control tanggal' value=''>
      						</div>
								</div>
							</div>
              <div class="form-group">
                <label for="inputBiaya" class="col-sm-3 control-label">Perkiraan Tahun Lulus</label>
                <div class="col-sm-4">
                  <input type="txt" class="form-control" id="tahunLulus" name="tahunLulus">
                </div>
              </div>
              <div class="form-group">
                <label for="inputBiaya" class="col-sm-3 control-label">Keterangan</label>
                <div class="col-sm-9">
                  <input type="txt" class="form-control" id="keterangan" name="keterangan">
                </div>
              </div>
						</form>
					</div>

				</div>
			</div>
			<div class="modal-footer">
        <button class="btn btn-primary hide" id="btnUpdate">Update</button>
				<button class="btn btn-primary" id="btnSimpan">Simpan</button>
				<button class="btn btn-danger" data-dismiss="modal">batal</button>
			</div>
		</div>
	</div>
</div>
<a id="btnAddData" class="btn btn-primary">tambah</a>
<script>
  $(document).ready(function(){

    $(".tanggal").combodate({
			minYear: 2010,
			maxYear: <?php echo date('Y'); ?>
		});
		$(".day").addClass("form-control");
		$(".month").addClass("form-control");
		$(".year").addClass("form-control");


    $("#btnAddData").click(function(){
      $("#btnUpdate").removeClass("hide");
      $("btnSimpan").addClass("hide");
      $('#formData')[0].reset();
      $("#addForm").modal("show");
    })

    $("#cari_pegawai").on('click',function(){
      $.post('class/find_pegawai.php',{nip:$("#nip").val(), id_skpd : <?php echo $unit['id_skpd'] ?>})
			 .done(function(obj){
				data = JSON.parse(obj);
				if(data.id == 0){
					//alert("Pegawai Tidak Ditemukan");
					swal("Peringatan", "Pegawai tidak ditemukan atau berada di OPD lain!", "warning");
				}else{
					//alert(data.id);
					$("#idPegawai").val(data.id);
					$("#nama").val(data.nama);
          $("#golongan").val(data.golongan);

					//$("#gol_penilai").val(data.golongan);
					//$("#jabatan_penilai").val(data.jabatan);
				}

			});
    })

    $("#btnSimpan").on('click',function(){
        $.post('dataijinbelajar_simpan.php',$("#formData").serialize() + "&aksi=INS")
        .done(function(obj){
          if(obj == 1){
            $("#addForm").modal("hide");
            window.location.reload();
          }else{
            swal("Peringatan", "Gagal Menyimpan!", "warning");
          }
        });
    });

    $("#btnUpdate").on('click',function(){
        $.post('dataijinbelajar_simpan.php',$("#formData").serialize() + "&aksi=UPD")
        .done(function(obj){
          if(obj == 1){
            $("#addForm").modal("hide");
            $("#btnSimpan").removeClass("hide");
            $("#btnUpdate").addClass("hide");
            $('#formData')[0].reset();

            window.location.reload();

          }else{
            swal("Peringatan", "Gagal Menyimpan!", "warning");
          }
        });
    });


  })

  function editData(id){
    $.post('dataijinbelajar_simpan.php',{aksi:"GETBYID",id:id})
      .done(function(obj){
        data = JSON.parse(obj);
        //alert(data.nama);
        $("#id").val(data.id_ijin_belajar_data);
        $("#nip").val(data.nip_baru);
        $("#idPegawai").val(data.id_pegawai);
        $("#nama").val(data.nama);
        $("#golongan").val(data.pangkat_gol);
        $("#jenjang").val(data.jenjang_pendidikan);
        $("#namaSekolah").val(data.nama_sekolah);
        $("#programStudi").val(data.program_studi);
        $("#noAkreditasi").val(data.nomor_akreditasi);
        $("#tglAkreditasi").combodate('setValue', data.tgl_akreditasi);
        $("#nomorIzinBelajar").val(data.nomor_ijin_belajar);
        $("#tglIzinBelajar").combodate('setValue', data.tgl_ijin_belajar);
        $("#tahunLulus").val(data.perkiraan_tahun_lulus);
        $("#keterangan").val(data.keterangan);

        $("#btnUpdate").removeClass("hide");
        $("#btnSimpan").addClass("hide");
        $("#addForm").modal("show");
      });
    /*
    $("#idPegawai").val();
    $("#nama").val('vicky');

    $("#addForm").modal("show");
    */
  }

  function deleteData(id){
      swal({
        title: "Apakah anda yakin?",
        text: "Anda tidak dapat mengembalikan data yang telah dihapus!",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Batal",
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yap, Tolong dihapus!",
        closeOnConfirm: false
      },
      function(){
        $.post('dataijinbelajar_simpan.php',{aksi:"DEL",id:id})
         .done(function(obj){
           if(obj == 1){
              window.location.reload();
           }else{
             //swal("Peringatan", "Gagal Menghapus!", "warning");
             alert(obj);
           }
         })
      });

  }

</script>
