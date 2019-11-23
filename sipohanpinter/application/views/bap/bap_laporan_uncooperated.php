<html lang="en" style="height:100% ">
<head>
  <meta charset="UTF-8" />
  <link href="<?php echo base_url('assets/css/sheets-of-paper-f4-kop.css') ?>" rel="stylesheet" >
  <style>
    body{
      font-family: "Times New Roman", Times, serif;
    }
  </style>
</head>
<body class="document">
  <div class="page" contenteditable="true">
    <table border="0" width="100%">
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>Bogor, </td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kepada</td>
      </tr>
      <tr>
        <td>Nomor</td>
        <td>:</td>
        <td>.../....</td>
        <td>Yth. Walikota Bogor</td>
      </tr>
      <tr>
        <td>Sifat</td>
        <td>:</td>
        <td>Rahasia</td>
        <td></td>
      </tr>
      <tr>
        <td>Lampiran</td>
        <td>:</td>
        <td>- </td>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;di -</td>
      </tr>
      <tr>
        <td style="vertical-align:top;">Hal</td>
        <td style="vertical-align:top;">:</td>
        <td width="50%" style="vertical-align:top;">Laporan Hasil Pemeriksaan Pegawai <br/> Atas Nama <?php echo $pemeriksaan->nama_pegawai ?></td>
        <td>BOGOR</td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td colspan="2">
          <br/>
          <br/>
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dengan ini dilaporkan dengan hormat, bahwa berdasarkan Surat Perintah ..... Nomor ..... tanggal ....., Pada hari ... tanggal ... kami telah melakukan pemeriksaan terhadap :</p>
          <table>
            <tr>
              <td>Nama</td>
              <td>: <?php echo $pemeriksaan->nama_pegawai ?></td>

            </tr>
            <tr>
              <td>NIP</td>
              <td>: <?php echo $pemeriksaan->nip_pegawai ?></td>

            </tr>
            <tr>
              <td>Golongan</td>
              <td>: <?php echo $pemeriksaan->gol_pegawai ?></td>
            </tr>
            <tr>
              <td>Jabatan</td>
              <td>: <?php echo $pemeriksaan->jabatan_pegawai ?></td>
            </tr>
            <tr>
              <td>Unit Kerja</td>
              <td>: <?php echo $pemeriksaan->unit_kerja_pegawai ?></td>
            </tr>
          </table>
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sewaktu kami melakukan pemeriksaan terhadap PNS tersebut ia mempersulit jalannya pemeriksaan dengan cara memberi jawaba berbelit-belit dan tidak jujur.</p>
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Bersama ini kami lampirkan berkas lengkap Laporan Hasil Pemeriksaan sebagaimana dimaksud.</p>
          <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Demikian laporan ini dibuat dengan sesungguhnya sebagai bahan pertimbangan dalam mengambil keputusan.</p>
        </td>
      </tr>
    </table>
    <br/>
    <br/><br/>
    <table width="100%">
      <td width="50%"></td>
      <td>Kepala Perangkat Daerah
          <br/>
          <br/>
          <br/>
          <br/>
          Ir. Pulan<br/>
          NIP. xxxxxxxxxxxxxxxx
      </td>
  </div>
</body>
</html>
