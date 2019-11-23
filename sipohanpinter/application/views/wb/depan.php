
  <div class="container">
    <h1>Whistleblowing System</h1>
      <hr class="bg-red"/>
      <p>
        Whistleblowing System adalah sarana pelaporan bagi dugaan pelanggaran disiplin yang dilakukan oleh
        Aparatur Sipil Negara (ASN) di lingkungan Pemerintah Kota Bogor.
      </p>
      <p>
        Kami akan memproses lebih lanjut pengaduan yang memenuhi syarat dan kriteria, dan data diri
        pelapor akan kami rahasiakan
      </p>
      <p>Pelapor sekurangnya harus dapat menjelaskan apa yang terjadi (what),
        pihak yang terlibat (who), waktu kejadian (when),
        lokasi kejadian (where), dan bagaimana terjadinya (how).
      </p>
      <p>
        Kirimkan pengaduan pelanggaran disiplin ASN Kota Bogor melalui e-form dibawah ini.
    <h1>Formulir Pengaduan ASN</h1>
    <hr class="bg-red"/>
    <form name="formPengaduan" id="formPengaduan" >
      <div class="form-group">
        <label>Nama Pelapor</label>
        <input type="text" name="nama_pelapor" placeholder=""/>
        <small class="text-muted">Opsional.</small>
      </div>
      <div class="form-group">
          <label>No. Telp Pelapor<span class="fg-red">*</span></label>
          <input type="number" name="telp_pelapor" placeholder=""/>
      </div>
      <div class="form-group">
        <label>Alamat Email Pelapor<span class="fg-red">*</span></label>
        <input type="email" name="email_pelapor" placeholder=""/>
      </div>
      <div class="form-group">
        <label>Uraian Pengaduan <span class="fg-red">*</span></label>
        <textarea data-role="textarea" name="uraian" data-auto-size="true" data-max-height="200"></textarea>
        <small class="text-muted">Jelaskan dugaan pelanggaran disiplin secara rinci.</small>
    </div>
    <div class="form-group">
      <label>Nama Terlapor<span class="fg-red">*</span></label>
      <input type="text" name="nama_terlapor" placeholder=""/>
    </div>
    <div class="form-group">
      <label>Jabatan Terlapor<span class="fg-red">*</span></label>
      <input type="text" name="jabatan_terlapor" placeholder=""/>
    </div>
    <div class="form-group">
      <label>Unit Kerja Terlapor<span class="fg-red">*</span></label>
      <input type="text" name="unit_kerja_terlapor" placeholder=""/>
    </div>
    <div class="form-group">
      <label>Lampiran<span class="fg-red">*</span></label>
      <input type="file" data-role="file" data-button-title="Choose file">
    </div>

      <div class="form-group">
          <a class="button success" onclick="simpan()">Kirim Pengaduan</a>
          <input type="button" class="button" value="Cancel">
      </div>
    </form>
  </div>
  <br/>
  <br/><br/>

<script>
  function simpan(){
  

    $.post("<?php echo base_url('wb/simpan') ?>", $('#formPengaduan').serialize())
    .done(function(obj){
      alert(obj);
      data = JSON.parse(obj);
      if(data.status == 'SUCCESS'){
        Metro.notify.create("Berhasil", "Informasi", {cls:"success"});
        window.location.reload();
      }else{
        Metro.notify.create("GAGAL "+data.data, "Peringatan", {cls:"alert"});
      }
    });

  }
  </script>
