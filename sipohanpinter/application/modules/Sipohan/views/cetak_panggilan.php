<html lang="en" style="height:100% ">
<head>
  <meta charset="UTF-8" />
  <link href="<?php echo base_url('assets/css/sheets-of-paper-f4-kop.css') ?>" rel="stylesheet" >
</head>
<body class="document">
  <div class="page" contenteditable="true">
<h3 style="text-align:center; padding-bottom:0">SURAT PANGGILAN <?php echo $panggilan->status_pemeriksaan == 'PANGGILAN_1' ? 'I' : 'II' ?></h3>
<h4 style="text-align:center">Nomor : ....... </h5>

<ol type="1">
  <li>
    <p>Bersama ini diminta dengan hormat kehadiran Saudara :</p>
    <?php $pegawai = json_decode($panggilan->data_pegawai);

      ?>
    <table>
      <tr>
        <td style="width:20%">Nama</td>
        <td>:</td>
        <td><?php echo $pegawai->nama ?></td>
      </tr>
      <tr>
        <td>NIP</td>
        <td>:</td>
        <td><?php echo $pegawai->nip ?></td>
      </tr>
      <tr>
        <td>Pangkat</td>
        <td>:</td>
        <td><?php echo $pegawai->pangkat ? $this->db->get_where('golongan',array('golongan'=>$pegawai->pangkat))->row()->pangkat." - ".$pegawai->pangkat : "-" ?></td>
      </tr>
      <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td><?php echo $pegawai->jabatan ?></td>
      </tr>
      <tr>
        <td>Unit Kerja</td>
        <td>:&nbsp;</td>
        <td><?php echo $pegawai->unit_kerja ?></td>
      </tr>
    </table>
    <p>Untuk Menghadap Kepada </p>

    <table>
      <tr>
        <td style="width:20%">Nama</td>
        <td>:</td>
        <td><?php echo $pemanggil->nama ?></td>
      </tr>
      <tr>
        <td>NIP</td>
        <td>:</td>
        <td><?php echo $pemanggil->nip ?></td>
      </tr>
      <tr>
        <td>Pangkat</td>
        <td>:</td>
        <td><?php  echo $pemanggil->pangkat." - ".$pemanggil->golongan  ?></td>
      </tr>
      <tr>
        <td>Jabatan</td>
        <td>:</td>
        <td><?php echo $pemanggil->jabatan ?></td>
      </tr>
    </table>
    <p>Pada</p>
    <?php $pelanggaran = json_decode($panggilan->data_pelanggaran); ?>
    <table width="100%" >
      <tr>
        <td style="width:20%">Hari</td>
        <td>:</td>
        <td><?php  echo $data_panggilan->hari_panggilan ?></td>
      </tr>
      <tr>
        <td>Tanggal</td>
        <td>:</td>
        <td><?php echo $this->format->date_dmY($data_panggilan->tanggal_panggilan) ?></td>
      </tr>
      <tr>
        <td>Jam</td>
        <td>:</td>
        <td><?php echo $data_panggilan->waktu_panggilan ?></td>
      </tr>
      <tr>
        <td>Tempat</td>
        <td>:</td>
        <td><?php echo $data_panggilan->tempat_panggilan ?></td>
      </tr>

    </table>

    <p>Untuk diperiksa/dimintai keterangan sehubungan dengan dugaan pelanggaran disiplin terhadap <?php echo $pelanggaran->pelanggaran ?>
  </li>
  <li><p>Demikian untuk dilaksanakan</p></li>
  <br/>
  <table class="table" style="width:100%;">
    <tr>
      <td width="50%"></td>
      <td style="text-align: center">
        Bogor, <?php echo $this->format->tanggal_indo($data_panggilan->tanggal_surat) ?> <br/>
        <?php echo $penandatangan->jabatan ?><br/><br/><br/><br/>
        <u><strong><?php echo $penandatangan->nama ?></strong></u><br/>
        NIP.<?php echo $penandatangan->nip ?>
      </td>
    </tr>
  </table>
</ol>
</div>
</body>
</html>
<?php echo "&nbsp;&copy;BKPSDA Kota Bogor" ?>
