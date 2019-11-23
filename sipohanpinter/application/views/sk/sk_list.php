<div class="container">
<div class="row">
  <h1>Daftar Penjatuhan Hukuman Disiplin <a class="button primary" onclick="Metro.dialog.open('#addPanggilan')"><span class="mif-add"></span></a></h1>
  <div class="cell-12">
<table class="table compact table-border cell-border" id="tableDaftarProses">
  <thead>
    <tr>
      <th>No</th>
      <th>Nama <?php echo $this->format->hari(date("D")) ?></th>
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
                  <li><a href="#" onclick='openDialogSK(<?php echo $jsonPegawai ?>)'>detail</a></li>

                  <li class="divider"></li>


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

<div class="dialog primary" data-role="dialog" id="dialogBAP" data-close-button="true">
    <div class="dialog-title">Data BAP <span id="titlePanggilan"></span></div>
    <div class="dialog-content">
      <form id="formPanggilan">
        <div class="row">
          <div class="cell-12">
            <div class="form-group">
              <label>Tanggal Pemeriksaan</label>
              <input type="text" name="tgl_panggilan" id="tgl_panggilan" data-role="calendarpicker"/>
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

          </div>
        </div>
      </div>
    <div class="dialog-actions">
        <a onclick="panggilanSave()" class="button primary js-dialog-close">Simpan</a>
        <span id="sk_ringan"></span>

    </div>
  </div>

  <script>

  function openDialogSK(pegawai){
    console.log(pegawai);
    $("#sk_ringan").html("<a href='<?php echo site_url('sk/sk_ringan/') ?>"+pegawai.idhukuman_pemeriksaan+"' target='_blank'>SK Ringan</a>");

  /*  $("#detailNama").html(pegawai.nama_pegawai);
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
*/
    Metro.dialog.open("#dialogBAP");
  }

  </script>
