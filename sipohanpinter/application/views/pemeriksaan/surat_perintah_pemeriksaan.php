<html lang="en" style="height:100% ">
<head>
  <meta charset="UTF-8" />
  <link href="<?php //echo base_url('assets/metro/css/metro-all.css?ver=@@b-version') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/sheets-of-paper-f4-kop.css') ?>" rel="stylesheet" >

  <style>
  body{
    font-family: "Times New Roman", Times, serif;
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
<h3 style="text-align:center">SURAT PERINTAH UNTUK MELAKUKAN PEMERIKSAAN</h3>
<h4 style="text-align:center">Nomor : ....... </h4>

<ol type="1">
<li>
  Diperintahkan kepada:
    <table class="table compact">
    <?php $x="a"; foreach($tim_pemeriksa as $tim) : ?>

        <tr style="">
          <td><?php echo $x++."."; ?></td>
          <td style="width:20%" >Nama</td>
          <td>:</td>
          <td><?php echo $tim->nama ?></td>
        </tr>
        <tr>
          <td></td>
          <td>NIP</td>
          <td>:</td>
          <td><?php echo $tim->nip ?></td>
        </tr>
        <tr>
          <td></td>
          <td>Pangkat</td>
          <td>:</td>
          <td><?php echo $tim->golongan ?></td>
        </tr>
        <tr>
          <td></td>
          <td style="vertical-align:text-top">Jabatan</td>
          <td style="vertical-align:text-top">:</td>
          <td style="vertical-align:text-top"><?php echo $tim->jabatan ?></td>
        </tr>
        <tr>
          <td></td>
          <td style="vertical-align:text-top">Unit Kerja</td>
          <td style="vertical-align:text-top">:</td>
          <td style="vertical-align:text-top"><?php echo $tim->nama_unit_kerja ?></td>
        </tr>

    <?php endforeach; ?>
    <tr>
      <td colspan="4">
        Untuk melakukan pemeriksaan terhadap :
      </td>
    </tr>
    <tr>
      <table>
        <tr>
          <td style="width:20%">Nama</td>
          <td>:</td>
          <td><?php echo $pegawai->nama_pegawai ?></td>
        </tr>
        <tr>
          <td>NIP</td>
          <td>:</td>
          <td><?php echo $pegawai->nip_pegawai ?></td>
        </tr>
        <tr>
          <td>Pangkat</td>
          <td>:</td>
          <td><?php echo $pegawai->gol_pegawai ?></td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td>:</td>
          <td><?php echo $pegawai->jabatan_pegawai ?></td>
        </tr>
        <tr>
          <td style="vertical-align:text-top">Unit Kerja</td>
          <td style="vertical-align:text-top">:</td>
          <td style="vertical-align:text-top"><?php echo $pegawai->id_unit_kerja_pegawai ?></td>
        </tr>
        <tr>
          <td colspan="3" style="padding:10px;">pada</td>
        </tr>

        <!--tr>
          <td>Hari</td>
          <td>:</td>
          <td></td>
        </tr -->
        <tr>
          <td>Tanggal</td>
          <td>:</td>
          <td><?php //echo $this->format->tanggal_indo($pemeriksaan->tanggal_pemeriksaan) ?></td>
        </tr>
        <tr>
          <td>Jam</td>
          <td>:</td>
          <td><?php //echo $pemeriksaan->waktu_pemeriksaan ?></td>
        </tr>
        <tr>
          <td>Tempat</td>
          <td>:</td>
          <td><?php //echo $pemeriksaan->tempat_pemeriksaan ?></td>
        </tr>
      </table>
    </tr>
  </table>
<p>
  karena yang bersangkutan diduga melakukan pelanggaran disiplin <?php //echo $pelanggaran->pelanggaran ?>
</p>
<br/>
</li>

<li>
  Demikian agar Surat Perintah ini dilaksanakan sebaik-sebaiknya.
</li>
</ol>
<table style="width:100%" class="table compact">
  <tr>
    <td style="width:50%"></td>
    <td style="text-align:center">
      <?php // $pjb = json_decode($tim[0]->data_tim); ?>
      Bogor, <?php //echo $this->format->tanggal_indo($pemeriksaan->tanggal_surat_pemeriksaan) ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <?php //$pjb = $this->sipohan->get_pegawai($pemeriksaan->id_penandatangan) ?>
      <br/>
      <?php //echo $pjb->jabatan ?>
      <br/><br/><br/><br/><br/>
      <span style="text-decoration:underline">

        <strong><?php //echo strtoupper($pjb->nama) ?></strong></span><br/>
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
