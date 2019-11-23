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
    <div>LAPORAN HASIL PEMERIKSAAN</div>
    <div>NOMOR : </div>
    <div>TENTANG</div>

    <p>
      Dugaan adanya pelanggaran disiplin Sdr. <?php echo $pemeriksaan->nama_pegawai ?> NIP. <?php echo $pemeriksaan->nip_pegawai ?>
      pegawai pada <?php echo $pemeriksaan->unit_kerja_pegawai ?> karena ....... melakukan perbuatan ..... sehingga melanggar Pasal .... huruf ...
      Peraturan Pemerintah Nomor 53 Tahun 2010 tentang Disiplin PNS.
    </p>
    <ol type="I">
      <li>
        PENDAHULUAN
        <ol type="1">
          <li>Dasar Pemeriksaan</li>
          <li>waktu pemeriksaan</li>
          <li>Sumber Pemeriksaan</li>
          <li>Tim Pemeriksa
            <?php $no=1;foreach($tim_pemeriksa as $tim) :?>
              <table border=0>
                <tr>
                  <td rowspan="4" style="vertical-align:top;"><?php echo $no++."." ?></td>
                  <td>Nama</td>
                  <td>: <?php echo $tim->nama ?></td>
                </tr>
                <tr>
                  <td>NIP</td>
                  <td>: <?php echo $tim->nip ?> </td>
                </tr>
                <tr>
                  <td>Golongan</td>
                  <td>: <?php echo $tim->golongan ?></td>
                </tr>
                <tr>
                  <td>Jabatan</td>
                  <td>: <?php echo $tim->jabatan ?></td>
                </tr>
              </table>
            <?php endforeach; ?>
          </li>
        </ol>
      </li>
      <li>HASIL PEMERIKSAAN / FAKTA YANG DITEMUKAN</li>
      <li>ANALISA</li>
      <li>KESIMPULAN</li>
      <li>YANG MERINGANKAN</li>
      <li>YANG MEMBERATKAN</li>
      <li>SARAN</li>
      <li>
        ALTERNATIF HUKUMAN DISIPLIN
        <ol type="1">
          <li>...</li>
          <li>...</li>
          <li>...</li>
        </ol>
      </li>
    </ol>
    <p>
      Demikian Berita Acara Pemeriksaan ini dibuat untuk dapat digunakan sebagaimana mestinya.
    </p>
    <table border="0" width="100%">
      <tr>
        <td width="50%"></td>
        <td>Pejabat pemeriksa/Tim pemeriksa</td>
      </tr>
      <tr>
      <tr>
        <td style="vertical-align:top;">
        </td>
        <td>
          <?php $no=1;foreach ($tim_pemeriksa as $tim) : ?>
          <table>
            <tr>
              <td rowspan="3" style="vertical-align:top"><?php echo $no++."."; ?></td>
              <td>Nama</td>
              <td>: <?php echo $tim->nama ?></td>
            </tr>
            <tr>
              <td >NIP</td>
              <td>: <?php echo $tim->nip ?></td>
            </tr>
            <tr>
              <td style="vertical-align:top">Tandatangan</td>
              <td>: <br/><br/><br/></td>
            </tr>
          </table>
        <?php endforeach; ?>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>
