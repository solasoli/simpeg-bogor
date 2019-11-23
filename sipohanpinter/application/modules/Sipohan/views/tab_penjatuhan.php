<div class="grid">
  <form name="formPenjatuhan" id="formPenjatuhan" data-role="validator" data-on-before-submit"no_submit" a>
  <div class="row">
    <div class="cell-12">
      <div class="row">
        <div class="cell-6">
        <h5>Penjatuhan Hukuman Disiplin</h5>

      <div class="form-group">
        <input type="hidden" name="id_pegawai_penjatuhan" id="id_pegawai_penjatuhan" value="<?php   echo $panggilan->id_pegawai ?>"/>
        <input type="hidden" name="id_hukuman_pemeriksaan" id="id_hukuman_pemeriksaan" value="<?php  echo $this->uri->segment(3) ?>" />

        <label>Jenis Hukuman Disiplin</label>
        <select data-role="select" data-validate="required not=-1" id="jenis_hukdis" name="jenis_hukdis">
          <option value="-1" class="d-none"></option>
          <?php foreach($jenis_hukdis as $jenis) : ?>
            <option  value="<?php echo $jenis->id_jenis_hukuman ?>"><?php echo $jenis->deskripsi ?></option>
          <?php endforeach; ?>
      </select>

      <span class="invalid_feedback">
            You must select a option!
        </span>
      </div>
      <div class="form-group">
        <label>Pasal yang dilanggar di PP 53</label>
          <input type="number" data-role="input" id="pasal" name="pasal" placeholder="pasal">
        </div>
      <div class="form-group">

        <input type="number" data-role="input" id="ayat" name="ayat" placeholder="angka">
      </div>
      <div class="form-group">
        <label>Pelanggaran terhadap</label>
          <input type="text"  data-role="input" id="pelanggaran" name="pelanggaran" placeholder="Pelanggaran" value="<?php echo $pelanggaran->pelanggaran ?>"></input>
        </div>
        <div class="form-group">
          <label>Terhitung Mulai Tanggal</label>
          <input type="text" id="tmt" name="tmt" data-role="calendarpicker" data-format="%Y-%m-%d"/>
        </div>




  </div>
  <div class="cell-6">
    <!-- pejabat berwenang -->
    <h5>Pejabat yang berwenang</h5>
    <hr />
    <div class="form-group">
      <label>NIP</label>
      <script>
          var penjatuhanButtons = [
              {
                  html: "<span class='mif-search'></span>",
                  cls: "default",
                  onclick: "search_by_nip($('#nip_penjatuhan').val(),'penjatuhan')"
              }
          ]
      </script>
      <input type="number"
      value="<?php echo $berwenang->nip_baru ?>"
          data-role="input"
          id="nip_penjatuhan"
          name="nip_penjatuhan"
          data-clear-button="false"
          data-custom-buttons="penjatuhanButtons">
      </div>
      <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama_penjatuhan" id="nama_penjatuhan" value="<?php echo $berwenang->nama ?>"/>
      </div>
    <div class="form-group">
      <label>Pangkat/Gol</label>
      <input type="text" name="pangkat_penjatuhan" id="pangkat_penjatuhan" value="<?php echo $berwenang->pangkat ?>" />
    </div>
    <div class="form-group">
      <label>Jabatan</label>
      <input type="text" name="jabatan_penjatuhan" id="jabatan_penjatuhan" value="<?php echo $berwenang->jabatan ?>"/>
      <input type="hidden" value="<?php echo $berwenang->id_pegawai ?>" name="id_pemberi_hukuman" id="id_pemberi_hukuman" />
    </div>
  </div>
  </div>
    <!-- tanggal pemeriksaan baris -->
    <div class="item-separator"></div>



  <div class="form-actions ">
    <a class="button primary" onclick="simpan_penjatuhan()"><span class="mif-floppy-disk"></span> Simpan Perubahan</a>
  </div>
  </div>


  </form>
</div>
<script>


    function simpan_penjatuhan(){

      if($("#jenis_hukdis").val() != "-1"){

        $.post("<?php echo site_url('Sipohan/penjatuhan_simpan') ?>",$('#formPenjatuhan').serialize())
        .done(function(obj){
          alert(obj);
          data = JSON.parse(obj);
          if(data.status == 'SUCCESS'){
            Metro.notify.create("Data Tersimpan", "Informasi", {cls:"success"});
            //window.open('<?php //echo site_url('Sipohan/penjatuhan/') ?>'+ data.data, '_blank');
          }else{
            Metro.notify.create("Gagal Menyimpan", "Peringatan", {cls:"alert"});
          }
        })
      }
    }



  
</script>
