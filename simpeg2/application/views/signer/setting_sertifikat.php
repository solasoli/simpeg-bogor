
<div class="container">
<h3>Pengaturan Tandatangan</h3>
<form class="user-input span6" action="<?php echo base_url('signer/upload_setting')?>" method="post" enctype="multipart/form-data" >
  <?php
      $connection = ssh2_connect('103.14.229.15');
      ssh2_auth_password($connection, 'rommonz', 'mony3Tmony3T');
      $sftp = ssh2_sftp($connection);
      /*
      $statinfo = ssh2_sftp_stat($sftp, '/var/www/html/simpeg/Berkas_dev/11301.p12');
      print_r($statinfo);
      */

      if(file_exists('ssh2.sftp://'.intval($sftp).'/var/www/html/simpeg2/assets/tte/sertifikat/11301.p12')){
        echo "<a target='_blank' href='".site_url()."assets/tte/sertifikat/11301.p12'> download key tersimpan</a>";
      }else{
        echo "tidak ada key yang tersimpan";
      }


  ?>
  <input type="hidden" name="idp_pengolah" value="<?php echo $this->session->userdata('user')->id_pegawai ?>" />



  <label>Upload Sertifikat p12 :</label>
  <div class="input-control file">
    <input type="file" name="upload_sertifikat" id="upload_sertifikat"/>
    <button class="btn-file"></button>
  </div>

  <!--label>Upload Spesimen :</label>
  <div class="input-control file">
    <input type="file" name="upload_spesimen" id="upload_spesimen"/>
    <button class="btn-file"></button>
  </div-->


  <div class="form-action">
    <input type="submit" name="SIMPAN" class="button button-info" />
  </div>
</form>
</div>
