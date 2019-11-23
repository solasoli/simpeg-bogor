<html lang="en" style="height:100% ">
<head>
  <meta charset="UTF-8" />
  <link href="<?php //echo base_url('assets/metro/css/metro-all.css?ver=@@b-version') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/sheets-of-paper-f4-kop.css') ?>" rel="stylesheet" >
  <style>
  html{
    font-size: 10;
  }
  ol {
    padding: 20px;
  }
  ol li {
    padding: 5px;
    margin-left: 35px;
  }
  </style>

</head>
<body class="document">
  <div class="page" contenteditable="true">
<h3 style="text-align:center">PEMBENTUKAN TIM PEMERIKSA</h3>
<h4 style="text-align:center">Nomor : ....... </h4>

<ol type="1" >
<li>
  Berdasarkan dugaan disiplin yang dilakukan oleh
  Sdr. <strong><?php echo $pegawai->nama_pegawai ?></strong> &nbsp;
  NIP. <?php echo $pegawai->nip_pegawai ?>&nbsp;
  Jabatan <?php echo $pegawai->jabatan_pegawai ?>
  maka perlu dilakukan pemeriksaan.
</li>

<li>
  Mengingat ancaman hukumannya berupa hukuman disiplin <?php echo "sedang atau berat"//$ancaman ?>,
  maka perlu membentuk Tim Pemeriksa Yang terdiri dari :
  <ol type="a">
    <li>Atasan Langsung<br/>
      <table class="table compact">
        <tr>
          <td>Nama</td>
          <td>:</td>
          <td><?php echo $pegawai->nama_atasan ?></td>
        </tr>
        <tr>
          <td>NIP</td>
          <td>:</td>
          <td><?php echo $pegawai->nip_atasan ?></td>
        </tr>
        <tr>
          <td>Pangkat</td>
          <td>:</td>
          <td><?php echo $pegawai->gol_atasan ?></td>
        </tr>
        <tr>
          <td style="vertical-align:top">Jabatan</td>
          <td style="vertical-align:top">:</td>
          <td style="vertical-align:top"><?php echo $pegawai->jabatan_atasan ?></td>
        </tr>
      </table>
    </li>
    <?php foreach($tim_pemeriksa as $tim): ?>
      <li>Unsur <?php echo strtolower($tim->unsur) ?><br/>
        <table class="table compact">
            <tr style="">
              <td>Nama</td>
              <td>:</td>
              <td><?php echo $tim->nama ?></td>
            </tr>
            <tr>
              <td>NIP</td>
              <td>:</td>
              <td><?php echo $tim->nip ?></td>
            </tr>
            <tr>
              <td>Pangkat</td>
              <td>:</td>
              <td><?php echo $tim->golongan ?></td>
            </tr>
            <tr>
              <td>Jabatan</td>
              <td>:</td>
              <td><?php echo $tim->jabatan ?></td>
            </tr>
            </table>
          </li>
        <?php endforeach; ?>

  </ol>
</li>
<li>
  Demikian untuk dilaksanakan sebagaimana mestinya
</li>
</ol>
<table style="width:100%" class="table compact">
  <tr>
    <td style="width:50%"></td>
    <td style="text-align:center">
      <?php  ?>
      Bogor, <?php //echo $this->format->tanggal_indo($pemeriksaan->tanggal_surat_pemeriksaan) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <br/>
      <?php //$pjb = $this->sipohan->get_pegawai($pemeriksaan->id_penandatangan) ?>
      <?php //echo $pjb->jabatan ?>
      <br/><br/><br/>
      <span style="text-decoration:underline">
        <strong><?php //echo $pjb->nama ?></strong></span><br/>
      NIP. <?php //echo $pjb->nip ?>

    </td>
  </tr>
  <tr>
    <!-- td colspan="2">
      Tembusan Kepada Yth :
      <ol type="1">
        <li>....</li>
        <li>....</li>
        <li>....</li>
      </td -->
    </tr>
  </table>
</div>
</body>
</html>
