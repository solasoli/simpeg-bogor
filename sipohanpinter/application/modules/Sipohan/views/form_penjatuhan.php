<div class="grid">
  <form name="formData" id="formData" data-role="validator" data-on-before-submit"no_submit" a>
  <div class="row">
    <div class="cell-12">
      <div class="row">
        <div class="cell-12">
        <h5>Penjatuhan Hukuman Disiplin</h5>
        <table>
          <tr>
            <td>

              Nama: <?php echo $pegawai->nama ?><br/>
              NIP: <?php echo $pegawai->nip ?><br/>
              Jabatan: <?php echo $pegawai->jabatan ?><br/>
              Unit Kerja: <?php echo $pegawai->unit_kerja ?><br/>
            </td>
          </tr>
        </table>
      <div class="form-group">
        <input type="hidden" name="id_pegawai" id="id_pegawai" value="<?php echo $id_pegawai ?>"/>
        <input type="hidden" name="id_hukuman_pemeriksaan" id="id_hukuman_pemeriksaan" value="<?php echo $this->uri->segment(3) ?>" />

        <label>Jenis Hukuman Disiplin</label>
        <select data-role="select" data-validate="required not=-1" id="jenis_hukdis" name="jenis_hukdis">
          <option value="-1" class="d-none"></option>
          <?php foreach($jenis_hukdis as $jenis) : ?>
            <option  value="<?php echo $jenis->id_jenis_hukuman ?>"><?php echo $jenis->deskripsi ?></option>
          <?php endforeach; ?>
      </select>
      <input type="hidden" name="nama_hukuman" id="nama_hukuman"/>
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
          <textarea rows="5" cols="5"  id="pelanggaran" name="pelanggaran" placeholder="pasal"></textarea>
        </div>


    <h5>Pejabat yang berwenang</h5>
    <hr />
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
      value="<?php echo $berwenang->nip_baru ?>"
          data-role="input"
          id="nip_pegawai"
          name="nip_pegawai"
          data-clear-button="false"
          data-custom-buttons="customButtons">
      </div>
      <div class="form-group">
        <label>Nama</label>
        <input type="text" name="nama_pejabat" id="nama_pejabat" value="<?php echo $berwenang->nama ?>"/>
      </div>
    <div class="form-group">
      <label>Pangkat/Gol</label>
      <input type="text" name="pangkat_pejabat" id="pangkat_pejabat" value="<?php echo $berwenang->pangkat ?>" />
    </div>
    <div class="form-group">
      <label>Jabatan</label>
      <input type="text" name="jabatan_pejabat" id="jabatan_pejabat" value="<?php echo $berwenang->jabatan ?>"/>
      <input type="hidden" value="<?php echo $berwenang->id_pegawai ?>" name="id_pemberi_hukuman" id="id_pemberi_hukuman" />
    </div>

  </div>

    </div>
    <!-- tanggal pemeriksaan baris -->
    <div class="item-separator"></div>



  <div class="form-actions ">
    <button class="button primary" ><span class="mif-floppy-disk"></span> Simpan</button>
    <a href="<?php echo site_url('Sipohan/panggilan') ?>" class="button secondary"><span class="mif-cancel"></span> Kembali</a>
  </div>
  </div>


  </form>
</div>
<script>

  $(document).ready(function(){



    $("#formData").submit(function(e){
      e.preventDefault();

      if($("#jenis_hukdis").val() != "-1"){

        $.post("<?php echo site_url('Sipohan/penjatuhan_simpan') ?>",$('#formData').serialize())
        .done(function(obj){
          //alert(obj);
          data = JSON.parse(obj);
          if(data.status == 'SUCCESS'){
            Metro.notify.create("Data Tersimpan", "Informasi", {cls:"success"});
            window.open('<?php echo site_url('Sipohan/penjatuhan/') ?>'+ data.data, '_blank');
          }else{
            Metro.notify.create("Gagal Menyimpan", "Peringatan", {cls:"alert"});
          }
        })
      }
    })
    return false;
  });

  function search_nip(nip, peran){

    $.post("<?php echo site_url('Sipohan/search_nip'); ?>",{nip:nip})
    .done(function(obj){
      data = JSON.parse(obj);
      if(data.status == 'SUCCESS'){
        console.log(data.data);
        pegawai = data.data;
        $("#id_pejabat").val(pegawai.id_pegawai);
        $("#nama_pejabat").val(pegawai.nama);
        $("#pangkat_pejabat").val(pegawai.pangkat);
        $("#jabatan_pejabat").val(pegawai.jabatan);
        $("#unit_kerja_pejabat").val(pegawai.unit_kerja);


      }else{
        alert("Pegawai tidak ditemukan");
      }

    });

  }


  function simpan(){

    //console.log($('#formData').serializeArray());

  }

</script>
