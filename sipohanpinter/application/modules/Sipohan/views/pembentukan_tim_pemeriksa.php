<html lang="en" style="height:100% ">
<head>
  <meta charset="UTF-8" />
  <link href="<?php //echo base_url('assets/metro/css/metro-all.css?ver=@@b-version') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/sheets-of-paper-f4-kop.css') ?>" rel="stylesheet" >


</head>
<body class="document">
  <div class="page" contenteditable="true">
<h3 style="text-align:center">PEMBENTUKAN TIM PEMERIKSA</h3>
<h4 style="text-align:center">Nomor : ....... </h4>

<ol type="1">
<li>
  Berdasarkan dugaan disiplin yang dilakukan oleh
  Sdr. <strong><?php echo $pegawai->nama ?></strong>
  NIP <?php echo $pegawai->nip ?>
  Jabatan <?php echo $pegawai->jabatan ?>
  maka perlu dilakukan pemeriksaan.
</li>
<li>
  Mengingat ancaman hukumannya berupa hukuman disiplin <?php echo $ancaman ?>,
  maka perlu membentuk Tim Pemeriksa Yang terdiri dari :
  <ol type="a">
    <li>Atasan Langsung<br/>
      <table class="table compact">
        <tr>
          <td>Nama</td>
          <td>:</td>
          <td><?php echo $atasan->nama ?></td>
        </tr>
        <tr>
          <td>NIP</td>
          <td>:</td>
          <td><?php echo $atasan->nip ?></td>
        </tr>
        <tr>
          <td>Pangkat</td>
          <td>:</td>
          <td><?php echo $atasan->pangkat ?></td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td>:</td>
          <td style="vertical-align:top"><?php echo $atasan->jabatan ?></td>
        </tr>
      </table>
    </li>
    <li>Unsur Pengawasan<br/>
      <table class="table compact">
        <?php foreach($tim_pengawasan as $tp) : ?>
          <?php $tim = json_decode($tp->data_tim); ?>
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
          <td><?php echo $tim->pangkat ?></td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td>:</td>
          <td><?php echo $tim->jabatan ?></td>
        </tr>

      <?php endforeach; ?>
      </table>
    </li>
    <li>Unsur Kepegawaian<br/>
      <table class="table compact">
        <?php foreach($tim_kepegawaian as $tk): ?>
            <?php $tim = json_decode($tk->data_tim); ?>
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
              <td><?php echo $tim->pangkat ?></td>
            </tr>
            <tr>
              <td>Jabatan</td>
              <td>:</td>
              <td><?php echo $tim->jabatan ?></td>
            </tr>
      <?php endforeach; ?>
      </table>
    </li>
    <li>Pejabat Lain yang ditunjuk<br/>
      <table class="table compact">
        <?php

            foreach($tim_pejabat as $tp): ?>
            <?php $tim = json_decode($tp->data_tim); ?>
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
              <td><?php echo $tim->pangkat ?></td>
            </tr>
            <tr>
              <td>Jabatan</td>
              <td>:</td>
              <td><?php echo $tim->jabatan ?></td>
            </tr>
      <?php endforeach ?>
      </table>
    </li>
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
      Bogor, <?php echo $this->format->tanggal_indo($pemeriksaan->tanggal_surat_pemeriksaan) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <br/>
      <?php $pjb = $this->sipohan->get_pegawai($pemeriksaan->id_penandatangan) ?>
      <?php echo $pjb->jabatan ?>
      <br/><br/><br/>
      <span style="text-decoration:underline">
        <strong><?php echo $pjb->nama ?></strong></span><br/>
      NIP. <?php echo $pjb->nip ?>

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
