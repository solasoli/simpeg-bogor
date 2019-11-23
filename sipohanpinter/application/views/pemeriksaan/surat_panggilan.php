<html lang="en" style="height:100% ">
<head>
  <meta charset="UTF-8" />
  <link href="<?php echo base_url('assets/css/sheets-of-paper-f4-kop.css') ?>" rel="stylesheet" />
  <style>
  <style>
    body{
      font-family: "Times New Roman", Times, serif;
    }
  </style>

</head>
<body class="document">
  <div class="page" contenteditable="true">
<h3 style="text-align:center; padding-bottom:0">SURAT PANGGILAN <?php echo $panggilanke == 1 ? 'I' : 'II'?></h3>
<h4 style="text-align:center">Nomor : ....... </h5>

<ol type="1">
  <li>
    <p>Bersama ini diminta dengan hormat kehadiran Saudara :</p>

    <table style="padding:10">
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
        <td><?php echo $pegawai->gol_pegawai ? $this->db->get_where('golongan',array('golongan'=>$pegawai->gol_pegawai))->row()->pangkat." - ".$pegawai->gol_pegawai : "-" ?></td>
      </tr>
      <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td><?php echo $pegawai->jabatan_pegawai ?></td>
      </tr>
      <tr>
        <td>Unit Kerja</td>
        <td>:&nbsp;</td>
        <td><?php echo $pegawai->unit_kerja_pegawai ?></td>
      </tr>
    </table>
    <p style="padding-left:10">Untuk Menghadap Kepada </p>

    <table style="padding:10">
      <tr>
        <td style="width:20%">Nama</td>
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
        <td><?php echo $pegawai->gol_atasan ? $this->db->get_where('golongan',array('golongan'=>$pegawai->gol_atasan))->row()->pangkat." - ".$pegawai->gol_atasan : "-" ?></td>
      </tr>
      <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td><?php echo $pegawai->jabatan_atasan ?></td>
      </tr>
    </table>
      <p style="padding-left:10">Pada</p>
    <?php //$pelanggaran = json_decode($panggilan->data_pelanggaran); ?>
    <table width="100%" style="padding:10">
      <tr>
        <td style="width:20%">Hari</td>
        <td>:</td>
        <?php
          $tgl_panggilan = 'tgl_panggilan_'.$panggilanke;
          $tgl_panggilan = new DateTime($pegawai->$tgl_panggilan);
        ?>
        <td><?php  echo $this->format->hari(date_format($tgl_panggilan,'D')); ?></td>
      </tr>
      <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td><?php echo $this->format->tanggal_indo(date_format($tgl_panggilan,'Y-m-d')) ?></td>
      </tr>
      <tr>
        <td>Jam</td>
        <td>:</td>
        <td><?php echo date_format($tgl_panggilan,'H.m') ?> WIB</td>
      </tr>
      <tr>
        <td>Tempat</td>
        <td>:</td>
        <?php
          $tempat = "tempat_panggilan_".$panggilanke;
        ?>
        <td><?php echo $pegawai->$tempat ?></td>
      </tr>

    </table>

    <p style="padding-left:10">Untuk diperiksa/dimintai keterangan sehubungan dengan dugaan pelanggaran disiplin terhadap <?php echo $pegawai->pelanggaran ?>
  </li>
  <li style="padding:10"><p>Demikian untuk dilaksanakan</p></li>
  <br/>
  <table class="table" style="width:100%;">
    <tr>
      <td width="50%"></td>
      <td style="text-align: center">
        Bogor, <?php //echo $this->format->tanggal_indo($data_panggilan->tanggal_surat) ?> <br/>
        <?php echo $pegawai->jabatan_atasan ?><br/><br/><br/><br/>
        <u><strong><?php echo $pegawai->nama_atasan ?></strong></u><br/>
        NIP.<?php echo $pegawai->nip_atasan ?>
      </td>
    </tr>
  </table>
</ol>
</div>
</body>
</html>
<?php echo "&nbsp;&copy;BKPSDA Kota Bogor" ?>
