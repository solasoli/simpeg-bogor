<div class="container">
<div class="row">
  <h1>Daftar Proses Penjatuhan <a class="button primary" onclick="Metro.dialog.open('#addPanggilan')"><span class="mif-add"></span></a></h1>
  <div class="cell-12">
<table class="table compact table-border cell-border" id="tableDaftarProses">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama</th>
      <th>NIP</th>
      <th>Pangkat/Gol</th>
      <th>Jabatan</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $no = 1;
      foreach($panggilans as $pegawai) :

        $jsonPegawai = json_encode($pegawai);
    ?>
    <tr>
      <td><?php echo $no++ ?></td>
      <td><?php echo $pegawai->nama_pegawai ?></td>
      <td><?php echo $pegawai->nip_pegawai ?></td>
      <td><?php echo $pegawai->gol_pegawai ?></td>
      <td><?php echo $pegawai->jabatan_pegawai ?></td>
      <td><!-- button class="button primary"
          onclick="Metro.dialog.open('#detailPegawai')">detail</button -->
          <div class="split-button">
              <button class="button">Aksi</button>
              <button class="split dropdown-toggle"></button>
              <ul class="d-menu" data-role="dropdown">
                  <li><a href="#" onclick='detailPemeriksaan(<?php echo $jsonPegawai ?>)'>Detail</a></li>
                  <li><a href="#">Edit</a></li>
                  <li class="divider"></li>
                  <li><a href="#" onclick="deletePemeriksaan(<?php echo $pegawai->idhukuman_pemeriksaan ?>)">Delete</a></li>

              </ul>
          </div>
      </td>
    </tr>

    <?php endforeach; ?>
  </tbody>
</table>
</div>
</div>
</div>
<div class="dialog" data-role="dialog" id="detailPegawai" data-width="800">
    <div class="dialog-title">
      Detail Pemeriksaan
      <div class="split-button " style="text-align:right">
        <button class="button primary">FILE</button>
        <button class="split dropdown-toggle primary"></button>
        <ul class="d-menu" data-role="dropdown">
            <li><span id="btnSuratPembentukan"><span></li>
            <li><span id="btnSuratPerintah"></span></li>
            <li class="divider"></li>
            <li><span id="btnSuratPanggilan1"></span></li>
            <li><span id="btnSuratPanggilan2"></span></li>
        </ul>
    </div>
    </div>
    <div class="dialog-content">
      <div class="row">
      </div>
      <div class="row">
        <div class="cell-12">
        <table class="table compact table-border cell-border" >
          <tr>
            <th>Data</th>
            <th width="40%">Pegawai</th>
            <th width="40%">Atasan</th>
          </tr>
          <tr>
            <td>Nama</td>
            <td><div id="detailNama"></div></td>
            <td><div id="detailNamaAtasan"></div></td>
          </tr>
          <tr>
            <td>NIP</td>
            <td><div id="detailNIP"></div></td>
            <td><div id="detailNIPAtasan"></div></td>
          </tr>
          <tr>
            <td>Golongan</td>
            <td><div id="detailGol"></div></td>
            <td><div id="detailGolAtasan"></div></td>
          </tr>
          <tr>
            <td>Jabatan</td>
            <td><div id="detailJabatan"></div></td>
            <td><div id="detailJabatanAtasan"></div></td>
          </tr>
        </table>
        <p>Dugaan Pelanggaran : <span id="detailDugaan"></span>
            <br/>Tingkat Pelanggaran : <span id="detailTingkat"></span></p>
        <h5>Tim Pemeriksa <span id="btnAddTim"></span></h5>
        <table class="table compact table-border cell-border" id="daftarTim" >
          <thead>
          <tr>
            <th>Unsur</th>
            <td>Nama/NIP</th>
            <th>Jabatan</th>
            <th>Pangkat/Gol</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="5" style="text-align:center">TIDAK ADA DATA</td>
          </tr>
        </tbody>
        </table>
      </div>
    </div>
    </div>
    <div class="dialog-actions">
        <button class="button js-dialog-close">Tutup</button>
        <button class="button primary js-dialog-close">Simpan</button>
    </div>
</div>

<!-- start dialog panggilan -->
<div class="dialog primary" data-role="dialog" id="dialogPanggilan" data-close-button="true">
    <div class="dialog-title">Data Panggilan <span id="titlePanggilan"></span></div>
    <div class="dialog-content">
      <form id="formPanggilan">
        <div class="row">
          <div class="cell-12">
            <div class="form-group">
              <label>Tanggal Pemeriksaan</label>
              <input type="text" name="tgl_panggilan" id="tgl_panggilan" data-role="calendarpicker" data-dialog-mode="true"/>
              <input type="hidden" name="panggilan_ke" id="panggilan_ke" />
              <input type="hidden" name="idhukuman_pemeriksaan_panggilan" id="idhukuman_pemeriksaan_panggilan" />
            </div>
            <div class="form-group">
              <label>Waktu</label>
              <input type="text" name="waktu_panggilan" id="waktu_panggilan" data-role="timepicker" data-seconds="false" data-locale="id-ID"/>
            </div>
            <div class="form-group">
              <label>Tempat</label>
              <input type="text" name="tempat_panggilan" id="tempat_panggilan"/>
            </div>
            <div class="form-group">
              <label>No Surat</label>
              <input type="text" name="no_surat_panggilan" id="no_surat_panggilan"/>
            </div>
            <div class="form-group">
              <label>Tgl Surat</label>
              <input type="text" name="tgl_surat_panggilan" id="tgl_surat_panggilan" data-role="calendarpicker" data-dialog-mode="true"/>
            </div>
          </div>
        </div>
      </div>
    <div class="dialog-actions">
        <a onclick="panggilanSave()" class="button primary js-dialog-close">Simpan dan cetak</a>
    </div>
  </div>
<!-- end dialog panggilan -->
<script>

  $(document).ready(function(){
    $("#tableDaftarProses").DataTable();
  })

  function detailPemeriksaan(pegawai){
    //console.log(pegawai);
    $("#detailNama").html(pegawai.nama_pegawai);
    $("#detailNIP").html(pegawai.nip_pegawai);
    $("#detailGol").html(pegawai.gol_pegawai);
    $("#detailJabatan").html(pegawai.jabatan_pegawai);
    //$("#detailUK").html(pegawai.id_unit_kerja_pegawai);
    $("#detailNamaAtasan").html(pegawai.nama_atasan);
    $("#detailNIPAtasan").html(pegawai.nip_atasan);
    $("#detailGolAtasan").html(pegawai.gol_atasan);
    $("#detailJabatanAtasan").html(pegawai.jabatan_atasan);
    $("#detailDugaan").html(pegawai.pelanggaran);
    $("#detailTingkat").html(pegawai.tingkat_pelanggaran);
    //$("#detailUKAtasan").html(pegawai.id_unit_kerja_atasan);
    $("#btnAddTim").html('<a class="button mini primary" onclick="dialogAddTim('+pegawai.idhukuman_pemeriksaan+')"><span class="mif-add"></span></a>')
    $("#btnSuratPembentukan").html('<a target="_blank" href="<?php echo site_url('pemeriksaan/cetak_surat_pembentukan_tim/') ?>'+pegawai.idhukuman_pemeriksaan+'">Surat Pembentukan Tim Pemeriksa</a>');
    $("#btnSuratPerintah").html('<a target="_blank" href="<?php echo site_url('pemeriksaan/cetak_sprint_pemeriksaan/') ?>'+pegawai.idhukuman_pemeriksaan+'">Surat Perintah Pemeriksaan</a>');
    $("#btnSuratPanggilan1").html('<a target="_blank" onclick="showPanggilan('+pegawai.idhukuman_pemeriksaan+',1)">Surat Panggilan 1</a>');
    $("#btnSuratPanggilan2").html('<a target="_blank" onclick="showPanggilan('+pegawai.idhukuman_pemeriksaan+',2)">Surat Panggilan 2</a>');
    this.reloadTim(pegawai.idhukuman_pemeriksaan);

    Metro.dialog.open("#detailPegawai");
  }

  function showPanggilan(idhukuman_pemeriksaan,panggilanKe){

    $("#tgl_panggilan").val("");
    $("#waktu_panggilan").removeAttr('data-value');
    $("#tempat_panggilan").val("");
    $.post("<?php echo site_url('pemeriksaan/get_json_hukuman_pemeriksaan') ?>",{idhukuman_pemeriksaan:idhukuman_pemeriksaan,panggilanKe:panggilanKe})
     .done(function(obj){
       dataHukuman = JSON.parse(obj);
       if(panggilanKe==1){
         if(dataHukuman.tgl_panggilan_1 != null){
           tanggalWaktu = dataHukuman.tgl_panggilan_1;
           tanggal = tanggalWaktu.split(" ");
           $("#tgl_panggilan").val(tanggal[0]);
           $("#waktu_panggilan").attr('data-value',tanggal[1]);
           $("#tempat_panggilan").val(dataHukuman.tempat_panggilan_1);
         }
       }else{
         if(dataHukuman.tgl_panggilan_2 != null){
           tanggalWaktu = dataHukuman.tgl_panggilan_1;
           tanggal = tanggalWaktu.split(" ");
           $("#tgl_panggilan").val(tanggal[0]);
           $("#waktu_panggilan").attr('data-value',tanggal[1]);
           $("#tempat_panggilan").val(dataHukuman.tempat_panggilan_2);
         }
       }
     });


    $("#idhukuman_pemeriksaan_panggilan").val(idhukuman_pemeriksaan);
    $("#panggilan_ke").val(panggilanKe);
    $("#titlePanggilan").html(panggilanKe);
    Metro.dialog.open("#dialogPanggilan");
  }

  function panggilanSave(){
    var panggilanKe = $("#panggilan_ke").val();
    //alert(panggilanKe);
    var tgl_panggilan =  $("#tgl_panggilan").val();
    var waktu = tgl_panggilan.concat(' '+$("#waktu_panggilan").val());
    var kolom_tanggal = 'tgl_panggilan_'+panggilanKe;
    var dataPost = {  'panggilanKe':panggilanKe,
                      'kolom_tanggal': waktu,
                      'tempat_panggilan':$("#tempat_panggilan").val(),
                      'idhukuman_pemeriksaan':$("#idhukuman_pemeriksaan_panggilan").val(),
                      'no_surat_panggilan':$("#no_surat_panggilan").val(),
                      'tgl_surat_panggilan':$("#tgl_surat_panggilan").val()
                      };
    $.post("<?php echo site_url('pemeriksaan/simpan_panggilan') ?>",dataPost)
      .done(function(obj){
        //console.log(obj);
        data = JSON.parse(obj);
        if(data.status == 'SUCCESS'){
        window.open("<?php echo site_url('pemeriksaan/cetak_surat_panggilan/') ?>"+$("#idhukuman_pemeriksaan_panggilan").val()+"/"+panggilanKe , "_blank");

          Metro.notify.create("Data Tersimpan", "Informasi", {cls:"success"});
        }else{
          Metro.notify.create("Gagal Menyimpan", "Peringatan", {cls:"alert"});
        }
      })
  }



  function reloadTim(idhukuman_pemeriksaan) {
    //alert(idhukuman_pemeriksaan);
      var table = $('#daftarTim');
      var list;
      table.find("tbody tr").remove();
      $.post("<?php echo site_url('pemeriksaan/get_tim') ?>",{
        'idhukuman_pemeriksaan': idhukuman_pemeriksaan
      },
      function(data, status){
        //alert("Data: " + data + "\nStatus: " + status);
        l = JSON.parse(data);
        //console.log(l.nama);
        l.forEach(function (d) {
            table.append("<tr>KEPEGAWAIAN<td>"+d.unsur+"</td><td>"+d.nama+
            "</td><td>"+d.jabatan+"</td><td>"+d.golongan+
            "</td><td><a onclick='deleteTim("+d.idhukuman_tim+","+idhukuman_pemeriksaan+")' class='button danger mini'><span class='mif-cancel'></span></a></td></tr>");
        });
      });
  };

  function deleteTim(idhukuman_tim,idhukuman_pemeriksaan){
    //alert(idhukuman_tim);
    Metro.dialog.create({
          title: "PERINGATAN",
          content: "<div>Apakah anda yakin untuk menghapus ?</div>",
          actions: [
              {
                  caption: "Hapus ",
                  cls: "js-dialog-close alert",
                  onclick: function(){
                      $.post("<?php echo site_url('pemeriksaan/delete_tim') ?>",{id:idhukuman_tim})
                      .done(function(obj){
                        data = JSON.parse(obj);
                        if(data.status == 'SUCCESS'){
                          Metro.notify.create("Berhasil", "Informasi", {cls:"success"});
                          reloadTim(idhukuman_pemeriksaan);
                          //window.location.reload();
                        }else{
                          Metro.notify.create("GAGAL "+data.data, "Peringatan", {cls:"alert"});
                        }
                      })
                  }
              },
              {
                  caption: "Batal",
                  cls: "js-dialog-close",

              }
          ]
      });
  }

</script>
<div class="dialog primary" data-role="dialog" id="addTim" data-close-button="true">
    <div class="dialog-title">Tambah Tim Pemeriksa</div>
    <div class="dialog-content">
      <form id="formTambahTim">
        <div class="row">
          <div class="cell-12">
            <div class="form-group">
              <label>Unsur</label>
              <select name="unsur_tim" id="unsur_tim">
                <option><option>
                <option value="PENGAWASAN">PENGAWASAN</option>
                <option value="KEPEGAWAIAN">KEPEGAWAIAN</option>
                <option value="PEJABATLAIN">PEJABAT LAIN</option>
              </select>
            </div>
        <div class="form-group">
            <label>NIP</label>
            <script>
                var timButtons = [
                    {
                        html: "<span class='mif-search'></span>",
                        cls: "default",
                        onclick: "search_tim($('#nip_tim').val())"
                    }
                ]
            </script>
            <input type="text"
                data-role="input"
                id="nip_tim"
                name="nip_tim"
                data-clear-button="false"
                data-custom-buttons="timButtons">
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama_tim" id="nama_tim"/>
            <input type="hidden" name="id_tim" id="id_tim" />
            <input type="hidden" name="idhukuman_pemeriksaan" id="idhukuman_pemeriksaan" />
          </div>
          <div class="form-group">
            <label>Pangkat/Gol</label>
            <input type="text" name="pangkat_tim" id="pangkat_tim" />
          </div>
          <div class="form-group">
            <label>Jabatan</label>
            <input type="text" name="jabatan_tim" id="jabatan_tim"/>
          </div>
          <div class="form-group">
            <label>Unit Kerja</label>
            <input type="text" name="unit_kerja_tim" id="unit_kerja_tim"/>
            <input type="hidden" name="id_unit_kerja_tim" id="id_unit_kerja_tim" />
          </div>
        </div>
      </div>
    </div>
    <div class="dialog-actions">

        <a onclick="tim_add()" class="button primary js-dialog-close">Simpan</a>
    </div>
  </div>
<script>

  function dialogAddTim(idhukumanPemeriksaan){
    $("#idhukuman_pemeriksaan").val(idhukumanPemeriksaan);
    Metro.dialog.open('#addTim');
  }

function search_tim(nip){

  $.post("<?php echo site_url('pemeriksaan/search_nip'); ?>",{nip:nip})
  .done(function(obj){
    data = JSON.parse(obj);
    if(data.status == 'SUCCESS'){
      //console.log(data.data);
      pegawai = data.data;
        $("#id_tim").val(pegawai.id_pegawai);
        $("#nama_tim").val(pegawai.nama);
        $("#pangkat_tim").val(pegawai.pangkat);
        $("#jabatan_tim").val(pegawai.jabatan);
        $("#unit_kerja_tim").val(pegawai.unit_kerja);
        $("#id_unit_kerja_tim").val(pegawai.id_unit_kerja);

    }else{
      alert("Pegawai tidak ditemukan");
    }

  });
}

function tim_add(){
  //console.log($("#formTambahTim").serializeArray());
  dataTim = {'unsur_tim':$("#unsur_tim").val(),
              'nip_tim':$("#nip_tim").val(),
              'nama_tim':$("#nama_tim").val(),
              'id_tim':$("#id_tim").val(),
              'idhukuman_pemeriksaan':$("#idhukuman_pemeriksaan").val(),
              'pangkat_tim':$("#pangkat_tim").val(),
              'jabatan_tim':$("#jabatan_tim").val(),
              'unit_kerja_tim':$("#unit_kerja_tim").val(),
              'id_unit_kerja_tim':$("#id_unit_kerja_tim").val()
            };
  $.post("<?php echo site_url('pemeriksaan/simpan_tim') ?>",dataTim)
    .done(function(obj){
      data = JSON.parse(obj);
      if(data.status == 'SUCCESS'){
        reloadTim($("#idhukuman_pemeriksaan").val());
        Metro.notify.create("Data Tersimpan", "Informasi", {cls:"success"});
      }else{
        Metro.notify.create("Gagal Menyimpan", "Peringatan", {cls:"alert"});
      }
    })
}
</script>

<div class="dialog" data-role="dialog" id="addPanggilan" data-width="800">
    <div class="dialog-title">Proses Baru</div>
    <div class="dialog-content">
      <form id="formTambahPemeriksaan" name="formTambahPemeriksaan">
        <div class="row">
          <div class="cell-4">
          <h5>Data Pegawai</h5>
        <div class="form-group">
            <label>NIP</label>
            <script>
                var pegawaiButtons = [
                    {
                        html: "<span class='mif-search'></span>",
                        cls: "default",
                        onclick: "search_pegawai($('#nip_pegawai').val())"
                    }
                ]
            </script>
            <input type="text"
                data-role="input"
                id="nip_pegawai"
                name="nip_pegawai"
                data-clear-button="false"
                data-custom-buttons="pegawaiButtons">
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama_pegawai" id="nama_pegawai"/>
            <input type="hidden" name="id_pegawai" id="id_pegawai" />
          </div>
          <div class="form-group">
            <label>Pangkat/Gol</label>
            <input type="text" name="pangkat_pegawai" id="pangkat_pegawai" />
          </div>
          <div class="form-group">
            <label>Jabatan</label>
            <input type="text" name="jabatan_pegawai" id="jabatan_pegawai"/>
          </div>
          <div class="form-group">
            <label>Unit Kerja</label>
            <input type="text" name="unit_kerja_pegawai" id="unit_kerja_pegawai"/>
            <input type="hidden" name="id_unit_kerja_pegawai" id="id_unit_kerja_pegawai" />
          </div>
        </div>
        <div class="cell-4">
          <h5>Data Atasan</h5>
          <div class="form-group">
              <label>NIP</label>
              <script>
                  var customButtons = [
                      {
                          html: "<span class='mif-search'></span>",
                          cls: "default",
                          onclick: "search_atasan($('#nip_atasan').val())"
                      }
                  ]
              </script>
              <input type="text"
                  data-role="input"
                  id="nip_atasan"
                  name="nip_atasan"
                  data-clear-button="false"
                  data-custom-buttons="customButtons">
            </div>
            <div class="form-group">
              <label>Nama</label>
              <input type="text" name="nama_atasan" id="nama_atasan"/>
              <input type="hidden" name="id_atasan" id="id_atasan" />
            </div>
            <div class="form-group">
              <label>Pangkat/Gol</label>
              <input type="text" name="pangkat_atasan" id="pangkat_atasan" />
            </div>
            <div class="form-group">
              <label>Jabatan</label>
              <input type="text" name="jabatan_atasan" id="jabatan_atasan"/>
            </div>
            <div class="form-group">
              <label>Unit Kerja</label>
              <input type="text" name="unit_kerja_atasan" id="unit_kerja_atasan"/>
              <input type="hidden" name="id_unit_kerja_atasan" id="id_unit_kerja_atasan" />
            </div>
        </div>
        <div class="cell-4">
            <h5>Keterangan</h5>
          <div class="form-group">
            <label>Tingkat Pelanggaran</label>
            <select name="tingkat_pelanggaran" id="tingkat_pelanggaran">
              <option></option>
              <option value="RINGAN">RINGAN</option>
              <option value="SEDANG">SEDANG</option>
              <option value="BERAT">BERAT</option>
            </select>
          </div>
          <div class="form-group">
            <label>Pelanggaran</label>
            <textarea type="text" name="pelanggaran" id="pelanggaran" ></textarea>
          </div>
        </div>
        </form>
    </div>
    <div class="dialog-actions">
        <button class="button js-dialog-close">Batal</button>
        <a href="#" onclick="riksa_add()" class="button primary">Simpan</a>
    </div>
</div>
</div>


<script type="text/javascript">

    function riksa_add(){
      var baru = {'id_pegawai':$("#id_pegawai").val(),
                  'nip_pegawai':$("#nip_pegawai").val(),
                  'nama_pegawai':$("#nama_pegawai").val(),
                  'gol_pegawai':$("#pangkat_pegawai").val(),
                  'id_j_pegawai':$("#id_j_pegawai").val(),
                  'jabatan_pegawai':$("#jabatan_pegawai").val(),
                  'id_unit_kerja_pegawai':$("#id_pegawai").val(),
                  'unit_kerja_pegawai':$("#unit_kerja_pegawai").val(),
                  'idp_atasan':$("#id_atasan").val(),
                  'nip_atasan':$("#nip_atasan").val(),
                  'nama_atasan':$("#nama_atasan").val(),
                  'gol_atasan':$("#pangkat_atasan").val(),
                  'id_j_atasan':$("#id_atasan").val(),
                  'jabatan_atasan':$("#jabatan_atasan").val(),
                  'id_unit_kerja_atasan':$("#id_unit_kerja_atasan").val(),
                  'unit_kerja_atasan':$("#unit_kerja_atasan").val(),
                  'tingkat_pelanggaran':$("#tingkat_pelanggaran").val(),
                  'pelanggaran':$("#pelanggaran").val()
                } ;
      console.log(data);
      $.post('<?php echo site_url('pemeriksaan/simpan_baru') ?>',baru)
        .done(function(obj){
          //console.log(obj);
          data = JSON.parse(obj);
          if(data.status == 'SUCCESS'){
            Metro.notify.create("Data Tersimpan", "Informasi", {cls:"success"});

          }else{
            Metro.notify.create("Gagal Menyimpan", "Peringatan", {cls:"alert"});
          }
        })

    }

    function ubahPanggilan(id){

      dugaan = $("#dugaan_" + id).val();
      ancaman = $("#ancaman_hukuman_" + id).val();
      status_pemeriksaan = $("#status_pemeriksaan_"+id).val();

      hari = $("#hari_"+id).val();
      tanggal = $("#tanggal_"+id).val();
      waktu = $("#waktu_"+id).val();
      tempat = $("#tempat_"+id).val();
      $.post("<?php echo site_url('Sipohan/panggilan_update') ?>",{
        "id_pemeriksaan":id,
        "dugaan":dugaan,
        "ancaman":ancaman,
        "status_pemeriksaan":status_pemeriksaan,
        "hari":hari,
        "tanggal":tanggal,
        "waktu":waktu,
        "tempat":tempat
      })
      .done(function(obj){
        //alert(obj);
        data = JSON.parse(obj);
        if(data.status == 'SUCCESS'){
          Metro.notify.create("Data Tersimpan", "Informasi", {cls:"success"});
        }else{
          Metro.notify.create("Gagal Menyimpan", "Peringatan", {cls:"alert"});
        }
      })
      .fail(function() {
        alert( "error" );
      })
    }


    function step1(){
      tingkat = $("#selecttingkat").val();
      var jenis =
      "    <select class='' name='selecttingkat' id='selecttingkat'>" +
      "<option value='Ringan'>Bla bla</option>" +
      "<option value='Sedang'>Bla Bla</option>" +
      "<option value='Berat'>Berat</option>" +
      "</select> ";
      $("#jenis").html(jenis);
    }
    function hapusPanggilan(id){
      Metro.dialog.create({
            title: "PERINGATAN",
            content: "<div>Apakah anda yakin untuk menghapus ?</div>",
            actions: [
                {
                    caption: "Hapus ",
                    cls: "js-dialog-close alert",
                    onclick: function(){
                        //alert("You clicked Agree action " + id);
                        $.post("<?php echo site_url('Sipohan/panggilan_delete') ?>",{id:id})
                        .done(function(obj){
                        //  alert(obj);

                          data = JSON.parse(obj);
                          if(data.status == 'SUCCESS'){
                            Metro.notify.create("Berhasil", "Informasi", {cls:"success"});
                            window.location.reload();
                          }else{
                            Metro.notify.create("GAGAL "+data.data, "Peringatan", {cls:"alert"});
                          }
                        })
                    }
                },
                {
                    caption: "Batal",
                    cls: "js-dialog-close",

                }
            ]
        });
    }

    function search_pegawai(nip){

      $.post("<?php echo site_url('pemeriksaan/search_nip'); ?>",{nip:nip})
      .done(function(obj){
        data = JSON.parse(obj);
        if(data.status == 'SUCCESS'){
          console.log(data.data);
          pegawai = data.data;
            $("#id_pegawai").val(pegawai.id_pegawai);
            $("#nama_pegawai").val(pegawai.nama);
            $("#pangkat_pegawai").val(pegawai.pangkat);
            $("#jabatan_pegawai").val(pegawai.jabatan);
            $("#unit_kerja_pegawai").val(pegawai.unit_kerja);
            $("#id_unit_kerja_pegawai").val(pegawai.id_unit_kerja);

        }else{
          alert("Pegawai tidak ditemukan");
        }

      });
    }

    function search_atasan(nip){

    //  alert(nip);
      $.post("<?php echo site_url('pemeriksaan/search_nip'); ?>",{nip:nip})
      .done(function(obj){
        data = JSON.parse(obj);
        if(data.status == 'SUCCESS'){
          //console.log(data.data);
          pegawai = data.data;
            $("#id_atasan").val(pegawai.id_pegawai);
            $("#nama_atasan").val(pegawai.nama);
            $("#pangkat_atasan").val(pegawai.pangkat);
            $("#jabatan_atasan").val(pegawai.jabatan);
            $("#unit_kerja_atasan").val(pegawai.unit_kerja);
            $("#id_unit_kerja_atasan").val(pegawai.id_unit_kerja);

        }else{
          alert("Pegawai tidak ditemukan");
        }

      });
    }

    function deletePemeriksaan(id){

      Metro.dialog.create({
            title: "PERINGATAN",
            content: "<div>Apakah anda yakin untuk menghapus ?</div>",
            actions: [
                {
                    caption: "Hapus ",
                    cls: "js-dialog-close alert",
                    onclick: function(){
                        //alert("You clicked Agree action " + id);
                        $.post("<?php echo site_url('pemeriksaan/pemeriksaan_delete') ?>",{id:id})
                        .done(function(obj){
                          data = JSON.parse(obj);
                          if(data.status == 'SUCCESS'){
                            Metro.notify.create("Berhasil", "Informasi", {cls:"success"});
                            window.location.reload();
                          }else{
                            Metro.notify.create("GAGAL "+data.data, "Peringatan", {cls:"alert"});
                          }
                        })
                    }
                },
                {
                    caption: "Batal",
                    cls: "js-dialog-close",

                }
            ]
        });
    }

</script>
