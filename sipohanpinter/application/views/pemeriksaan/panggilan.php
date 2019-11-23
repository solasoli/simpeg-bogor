<div class="container">

<div class="grid">
  <form name="formData" id="formData">
  <h1>Buat Pemeriksaan</div>
  <div class="row">
    <div class="cell-12">
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
                        onclick: "search_pegawai($('#nip_').val())"
                    }
                ]
            </script>
            <input type="number"
                data-role="input"
                id="nip_"
                name="nip_"
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


    </div>
    </div>
    <!-- tanggal pemeriksaan baris -->
    <div class="item-separator"></div>

    <div class="row">
      <h5>Tim Pemeriksaan <a class="button primary mini" onclick="Metro.dialog.open('#addTimPemeriksa')"><span class="mif-add"></span></a></h5>
      <table class="table">
          <thead>
            <tr>
              <th>Unsur</th>
              <th>NIP</th>
              <th>Nama</th>
              <th>Pangkat/Gol</th>
              <th>Jabatan</th>
          </thead>
          <tbody>
            <tr>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
          </tbody>
      </table>
  </div>

</div>

  <div class="cell-12">
    <a href="#" class="button primary" name="simpan" id="simpan" onclick="simpan()"><span class="mif-floppy-disk"></span> Simpan</a>
    <a href="<?php echo site_url('Sipohan/panggilan') ?>" class="button secondary"><span class="mif-cancel"></span> Kembali</a>
  </div>
  </div>


  </form>
</div>

<div class="dialog" data-role="dialog" id="addTimPemeriksa">
    <div class="dialog-title">Detail Pegawai</div>
    <div class="dialog-content">
        <form id="form_pemeriksa">
        <div class="form-group">
            <label>Unsur</label>
            <select class="select" name="unsur" id="unsur">
                <option></option>
                <option value="PENGAWASAN">PENGAWASAN</option>
                <option value="KEPEGAWAIAN">KEPEGAWAIAN</option>
                <option value="PEJABATLAIN">PEJABAT LAIN</option>
            </select>
            <input type="hidden" name="id_hukuman_pemeriksaan" id="id_hukuman_pemeriksaan" value="" />
        </div>
        <div class="form-group">
            <label>NIP</label>
            <script>
                var customButtons = [
                    {
                        html: "<span class='mif-search'></span>",
                        cls: "default",
                        onclick: "search_pemeriksa($('#nip_tim').val())"
                    }
                ]
            </script>
            <input type="number"
                data-role="input"
                id="nip_tim"
                name="nip_tim"
                data-clear-button="false"
                data-custom-buttons="customButtons">
          </div>
          <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama_pemeriksa" id="nama_pemeriksa"/>
          </div>
          <div class="form-group">
            <label>Pangkat/Gol</label>
            <input type="text" name="pangkat_pemeriksa" id="pangkat_pemeriksa" />
          </div>
          <div class="form-group">
            <label>Jabatan</label>
            <input type="text" name="jabatan_pemeriksa" id="jabatan_pemeriksa"/>
          </div>
          <div class="form-group">
            <label>Unit Kerja</label>
            <input type="text" name="unit_kerja_pemeriksa" id="unit_kerja_pemeriksa"/>
          </div>
        </form>

    </div>
    <div class="dialog-actions">
        <button class="button js-dialog-close">Batal</button>
        <button class="button primary js-dialog-close">Simpan</button>
    </div>
</div>

<script>

  function search_pegawai(nip){
    alert("nip");

  }

  function search_pemeriksa(nip){

  //  alert(nip);
    $.post("<?php echo site_url('pemeriksaan/search_nip'); ?>",{nip:nip})
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
