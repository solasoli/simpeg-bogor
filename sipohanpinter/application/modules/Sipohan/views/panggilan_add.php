<div class="grid">
  <form name="formData" id="formData">
  <div class="row">
    <div class="cell-8">
      <div class="row">
        <div class="cell-6">
        <h5>Pegawai Terduga</h5>

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

    </div>
    <div class="cell-6">
      <h5>Atasan Langsung</h5>

        <div class="form-group">
            <label>NIP</label>
            <script>
                var pemeriksaButtons = [
                    {
                        html: "<span class='mif-search'></span>",
                        cls: "default",
                        onclick: "search_pemeriksa($('#nip_pemeriksa').val())"
                    }
                ]
            </script>
            <input type="number"
                data-role="input"
                id="nip_pemeriksa"
                name="nip_pemeriksa"
                data-clear-button="false"
                data-custom-buttons="pemeriksaButtons">
          <!-- small class="text-muted">We'll never share your email with anyone else.</small -->
        </div>
        <input type="hidden" name="id_pemeriksa" id="id_pemeriksa" />
        <div class="form-group">
          <label>Nama</label>
          <input type="text" name="nama_pemeriksa" id="nama_pemeriksa"/>
        </div>
        <div class="form-group">
          <label>Pangkat/Gol</label>
          <input type="text" name="pangkat_pemeriksa" id="pangkat_pemeriksa"/>
        </div>
        <div class="form-group">
          <label>Jabatan</label>
          <input type="text" name="jabatan_pemeriksa" id="jabatan_pemeriksa" />
        </div>
        <div class="form-group">
          <label>Unit Kerja</label>
          <input type="text" name="unit_kerja_pemeriksa" id="unit_kerja_pemeriksa"/>
        </div>

    </div>
    </div>
    <!-- tanggal pemeriksaan baris -->
    <div class="item-separator"></div>

    <div class="row">
      <div class="cell-6">
        <h5>Pada</h5>
        <div class="form-group">
          <label>Hari</label>
          <input type="text" name="hari" id="hari">
        </div>
        <div class="form-group">
          <label>Tanggal</label>
          <input data-role="datepicker" name="tanggal" id="tanggal">
        </div>
        <div class="form-group">
          <label>Waktu</label>
          <input data-role="timepicker" data-show-labels="false" name="waktu" id="waktu">
        </div>
        <div class="form-group">
          <label>Tempat</label>
          <input type="text" name="tempat" id="tempat">
        </div>
      </div>
      <div class="cell-6">
        <h5>Keterangan</h5>
        <div class="form-group">
          <label>Dugaan Pelanggaran</label>
          <textarea cols="5" rows="5" name="dugaan" id="dugaan"></textarea>
        </div>
        <input type="hidden" name="id_pembuat" id="id_pembuat" value="<?php echo $this->session->userdata('user_id') ?>"/>
    </div>
  </div>
</div>
  <div class="cell-4">
    <a href="#" class="button primary" name="simpan" id="simpan" onclick="simpan()"><span class="mif-floppy-disk"></span> Simpan</a>
    <a href="<?php echo site_url('Sipohan/panggilan') ?>" class="button secondary"><span class="mif-cancel"></span> Kembali</a>
  </div>
  </div>


  </form>
</div>
<script>
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
    $.post("<?php echo site_url('Sipohan/panggilan_save') ?>",$('#formData').serialize())
    .done(function(obj){
      data = JSON.parse(obj);
      if(data.status == 'SUCCESS'){
        Metro.notify.create("Data Tersimpan", "Informasi", {cls:"success"});
      }else{
        Metro.notify.create("Gagal Menyimpan", "Peringatan", {cls:"alert"});
      }
    })
  }

</script>
