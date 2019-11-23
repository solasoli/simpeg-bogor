
    <div class="row">

      <div class="cell-6">
          <form name="formData" id="formData">
    <h5>Tambah Tim Pemeriksa</h5>
      <div class="form-group">
        <input type="hidden" name="id_hukuman_pemeriksaan" id="id_hukuman_pemeriksaan" value="<?php echo $this->uri->segment(3) ?>" />

        <label>Unsur</label>
        <select data-role="select" id="unsur_pemeriksa" name="unsur_pemeriksa">
          <option></option>
          <option  value="PENGAWASAN">Unsur Pengawasan</option>
          <option  value="KEPEGAWAIAN">Unsur Kepegawaian</option>
          <option  value="PEJABATLAIN">Pejabat Lain</option>
      </select>
      </div>
      <div class="form-group">
        <label>NIP</label>
        <script>
            var customButtons = [
                {
                    html: "<span class='mif-search'></span>",
                    cls: "default",
                    onclick: "search_nip($('#nip_pegawai').val())"
                }
            ]
        </script>
        <input type="number"
            data-role="input"
            id="nip_pegawai"
            name="nip_pegawai"
            data-clear-button="false"
            data-custom-buttons="customButtons">
        </div>
    <input type="hidden" name="id_pegawai" id="id_pegawai" />
    <div class="form-group">
      <label>Nama</label>
      <input type="text" name="nama_pegawai" id="nama_pegawai"/>
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
    </div>



    <!-- tanggal pemeriksaan baris -->
    <div class="item-separator"></div>
  <div class="form-group">
      <a href="#" class="button primary" name="simpan" id="simpan" onclick="simpan()"><span class="mif-floppy-disk"></span> Simpan </a>
    </div>
    </form>
  </div>


  <div class="cell-6">
    <form id="formPemeriksaan" >
    <h4>Tim Pemeriksa</h4>
          <table class="table compact table-border cell-border">
          <thead>
            <tr >
              <th>#</th>
              <th>Nama</th>
              <th>NIP</th>
              <th>Jabatan</th>
              <th>Unsur</th>
              <th>Aksi</th>
            </tr>
              <?php
                $this->db->select('id');
                $this->db->select('data_tim');
                $this->db->select('unsur');
                $hasil = $this->db->get_where('hukuman_tim',array('id_hukuman_pemeriksaan'=>$panggilan->id));
                $hasil = $hasil->result();

              ?>

          </thead>
          <tbody>
            <?php $no=1; foreach($hasil as $h) {
              $tim = json_decode($h->data_tim);
              $unsur = $h->unsur;
            ?>
            <tr>
              <td><?php echo $no++ ?></td>
              <td><?php echo $tim->nama ?></td>
              <td><?php echo $tim->nip ?></td>
              <td><?php echo $tim->jabatan ?></td>
              <td><?php echo $unsur ?></td>
              <td>

                <a class="button warning"
                  data-role="hint"
                    data-hint-text="Hapus"
                    onclick="hapusPemeriksa(<?php echo $h->id ?>)">
                    <span class="mif-cross"></span>
                </a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
        <h4>Penandatangan dan Pemeriksaan</h4>
        <table class="table compact table-border">
          <tr>
            <td style="width:15%">NIP</td>
            <td style="width:1%">:</td>
            <td style="text-align:left">
              <div class="form-group">
                  <script>
                    var penandatanganSprint = [
                        {
                            html: "<span class='mif-search'></span>",
                            cls: "default",
                            onclick: "search_by_nip($('#nip_sprint').val(),'sprint')"
                        }
                    ]
                </script>
                <input type="number"
                    data-role="input"
                    id="nip_sprint"
                    name="nip_sprint"
                    data-clear-button="false"
                    data-custom-buttons="penandatanganSprint"
                    value="<?php echo isset($pemeriksaan->id_penandatangan) ? $penandatangan->nip :'' ?>">

                </div>
            </td>
          </tr>
          <tr>
              <td></td><td></td>
              <td>
                  <input type="hidden" name="id_sprint" id="id_sprint" value="<?php echo isset($penandatangan)  ? $penandatangan->id_pegawai : '' ?>"/>
                  <div id="nama_sprint"><?php echo isset($pemeriksaan->id_penandatangan) ? $penandatangan->nama :'' ?></div>
                  <div id="pangkat_sprint"><?php echo isset($pemeriksaan->id_penandatangan) ? $penandatangan->golongan :'' ?></div>
                  <div id="jabatan_sprint"><?php echo isset($pemeriksaan->id_penandatangan) ? $penandatangan->jabatan :'' ?></div>
              </td>
          </tr>
          <tr>
            <td style="width:15%">Tanggal</td>
            <td style="width:1%">:</td>
            <td style="text-align:left">
              <input data-role="calendarpicker"
                  name="tanggal_sprint"
                  id="tanggal_sprint"
                  data-locale="id-ID"
                  data-format="%Y-%m-%d"
                  value="<?php echo isset($pemeriksaan->tanggal_pemeriksaan) ? $pemeriksaan->tanggal_pemeriksaan :'' ?>"/>
            </td>
          </tr>
          <tr>
            <td style="width:15%">Waktu</td>
            <td style="width:1%">:</td>
            <td style="text-align:left">
              <input data-role="timepicker" name="waktu_sprint"
                  data-seconds="false"
                  id="waktu_sprint" data-locale="id-ID" data-value="<?php echo isset($pemeriksaan->waktu_pemeriksaan) ? $pemeriksaan->waktu_pemeriksaan : '' ?>"/>
            </td>
          </tr>
          <tr>
            <td style="width:15%">Tempat</td>
            <td style="width:1%">:</td>
            <td style="text-align:left">

              <input type="text" name="tempat_sprint" id="tempat_sprint" value="<?php echo isset($pemeriksaan->tempat_pemeriksaan) ? $pemeriksaan->tempat_pemeriksaan : '' ?>"/>
            </td>
          </tr>
          <tr>
            <td style="width:15%">Tanggal Surat</td>
            <td style="width:1%">:</td>
            <td style="text-align:left">
              <input data-role="calendarpicker" name="tanggal_surat_sprint" id="tanggal_surat_sprint" data-locale="id-ID" data-format="%Y-%m-%d" value="<?php echo isset($pemeriksaan->tanggal_surat_pemeriksaan) ? $pemeriksaan->tanggal_surat_pemeriksaan : '' ?>"/>
            </td>
          </tr>
          <tr>
            <td colspan="3">
              <a id="buttonSimpanPemeriksaan"
                onclick="simpan_pemeriksaan()"
                name="buttonSimpanPemeriksaan"
                class="button success">SIMPAN</a>
            </td>
          </tr>
        </table>
        </form>
  </div>

</div>
<hr/>
<div class="row">
  <div class="cell-12 text-center" >
  <a class="button info ani-hover-heartbeat" target="_blank" href="<?php echo site_url('Sipohan/tim_pemeriksa_cetak/'.$panggilan->id) ?>">Cetak Pembentukan Tim Pemeriksa</a>
  <a class="button success ani-hover-heartbeat" target="_blank" href="<?php echo site_url('Sipohan/sprint_pemeriksa_cetak/'.$panggilan->id) ?>">Cetak Sprint Tim Pemeriksa</a>
  </div>
</div>


<script>

  function simpan_pemeriksaan(){
    //alert("test");
    console.log($('#formPemeriksaan').serializeArray());

    $.post("<?php echo site_url('Sipohan/pemeriksaan_update') ?>",$('#formPemeriksaan').serialize()+"&id=<?php echo $panggilan->id ?>")
    .done(function(obj){
      console.log(obj);
      //data = JSON.parse(obj);
      if(data.status == 'SUCCESS'){
        Metro.notify.create("Data Pemeriksaan Tersimpan", "Informasi", {cls:"success"});
      //  window.location.reload();
      }else{
        Metro.notify.create("Gagal Menyimpan Data Pemeriksaan", "Peringatan", {cls:"alert"});
      }
    })
  }



  function search_nip(nip, peran){

    $.post("<?php echo site_url('Sipohan/search_nip'); ?>",{nip:nip})
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


      }else{
        alert("Pegawai tidak ditemukan");
      }

    });

  }

  function search_pemeriksa(nip){


    $.post("<?php echo site_url('Sipohan/search_nip'); ?>",{nip:nip})
    .done(function(obj){
      data = JSON.parse(obj);
      if(data.status == 'SUCCESS'){
        console.log(data.data);
        pegawai = data.data;
          $("#id_pemeriksa").val(pegawai.id_pegawai);
          $("#nama_pemeriksa").val(pegawai.nama);
          $("#pangkat_pemeriksa").val(pegawai.pangkat);
          $("#jabatan_pemeriksa").val(pegawai.jabatan);
          $("#unit_kerja_pemeriksa").val(pegawai.unit_kerja);


      }else{
        alert("Pegawai tidak ditemukan");
      }

    });
  }

  function simpan(){
    //console.log($('#formData').serializeArray());
    $.post("<?php echo site_url('Sipohan/tim_pemeriksa_simpan') ?>",$('#formData').serialize())
    .done(function(obj){
      //alert(obj);
      //data = JSON.parse(obj);
      if(data.status == 'SUCCESS'){
        Metro.notify.create("Data Tersimpan", "Informasi", {cls:"success"});
        window.location.reload();
      }else{
        Metro.notify.create("Gagal Menyimpan", "Peringatan", {cls:"alert"});
      }
    })
  }

</script>
