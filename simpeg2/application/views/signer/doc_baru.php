<div class="container">
<h1>Upload Dokumen Baru</h1>
<form class="user-input span6" action="<?php echo base_url('signer/upload_doc')?>" method="post" enctype="multipart/form-data" >
  <input type="hidden" name="idp_pengolah" value="<?php echo $this->session->userdata('user')->id_pegawai ?>" />

  <div class="input-control select">
    <label>Kategori Berkas :</label>
    <select name="kat_berkas" id="kat_berkas">
      <option></option>
      <?php foreach($kat_berkas as $kb){ echo "<option value=".$kb->id_kat_berkas.">".$kb->nm_kat."</option>"; } ?>
    </select>
  </div>
  <div class="input-control textarea" id="div_uraian" name="div_uraian">
    <label>Uraian :</label>
    <textarea class="text"  name="uraian" id="uraian"></textarea>
  </div>
  <div class="input-control text" id="div_nomor" name="div_nomor">
    <label>Nomer Surat :</label>
    <input type="text" class="text"  name="nomor" id="nomor" />
  </div>
  <div class="input-control text" id="div_tgl" name="div_tgl">
    <label>Tgl Surat :</label>
    <input type="text" class="text"  name="tanggal" id="tanggal" />
  </div>
  <label>Upload Dokumen :</label>
  <div class="input-control file">
    <input type="file" name="upload_dok" id="upload_dok" accept=".pdf"/>
    <button class="btn-file"></button>
  </div>
  <div class="input-control select">
    <label>Pemaraf 1</label>
    <select name="pemaraf1" id="pemaraf1">
      <option></option>
      <?php foreach($penandatangan as $paraf1){
          echo "<option value='".$paraf1->id_j."'>".$paraf1->jabatan."</option>"; }
      ?>
    </select>
  </div>
  <div class="input-control select">
    <label>Pemaraf 2</label>
    <select name="pemaraf2" id="pemaraf2">
      <option></option>
      <?php foreach($penandatangan as $paraf2){ echo "<option value='".$paraf2->id_j."'>".$paraf2->jabatan."</option>"; } ?>
    </select>
  </div>
  <div class="input-control select">
    <label>Pemaraf 3</label>
    <select name="pemaraf3" id="pemaraf3">
      <option></option>
      <?php foreach($penandatangan as $paraf3){ echo "<option value=".$paraf3->id_j.">".$paraf3->jabatan."</option>"; } ?>
    </select>
  </div>
  <div class="input-control select">
    <label>Pemaraf 4</label>
    <select name="pemaraf4" id="pemaraf3">
      <option></option>
      <?php foreach($penandatangan as $paraf4){ echo "<option value=".$paraf3->id_j.">".$paraf4->jabatan."</option>"; } ?>
    </select>
  </div>
  <div class="input-control select">
    <label>Penandatangan</label>
    <select name="penandatangan" id="penandatangan">
      <option></option>
      <?php foreach($penandatangan as $pen){ echo "<option value=".$pen->id_j.">".$pen->jabatan."</option>"; } ?>
    </select>
  </div>
  <div class="form-action">
    <input type="submit" name="SIMPAN" class="button button-info" />
  </div>
</form>
</div>
