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
<div>
  <table width="100%">
    <tr>
      <td ></td>
      <td colspan="2">Pejabat yang ditunjuk</td>
    </tr>
    <tr>
      <td></td>
      <td>Nama</td>
      <td>: <?php echo $pemeriksaan->nama_atasan ?></td>
    </tr>
    <tr>
      <td width="50%"></td>
      <td>NIP</td>
      <td>: <?php echo $pemeriksaan->nip_atasan ?></td>
    </tr>
    <tr>
      <td colspan="3">Tembusan Yth</td>
    </tr>
    <tr>
      <td colspan="3">
        <ol>
          <li></li>
          <li></li>
          <li></li>
        </ol>
      </td>
    </tr>
  </table>
</div>
<div style="text-align:center">
<h3>BERITA ACARA PEMERIKSAAN</h3>
</div>
  <p>Pada hari ini ..... tanggal .... bulan ... tahun ... saya/tim pemeriksa
    <?php $no=1; foreach($tim_pemeriksa as $tim): ?>
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
<?php endforeach ?>
    <p>berdasarkan wewenang yang ada pada saya / Surat Perintah Nomor .... tanggal .... telah melakukan pemeriksaan terhadap
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
      </div>
      <div class="page">
        <p>Karena yang bersangkutan diduga telah melakukan pelanggaran terhadap ketentuan Pasal ... angka ... Peraturan Pemerintah Nomor 53 Tahun 2010</p>
        <ol type="1">
          <li>
            <h4>Pertanyaan :</h4>
            <p>Apakah Saudara dalam keadaan sehat dan bersedia untuk diperiksa/diminta keterangannya?
            <h4>Jawaban : </h4>
            <p>.....</p>
          </li>
        </ol>
        <p>
          Setelah selesai kepada yang diperiksa dibacakan kembali atau diminta untuk dibaca sendiri dan telah membenarkan semua keterangan yang disampaikan,
          kemudian yang bersangkutan membubuhkan tanda tangan di bawah ini dan membubuhkan tanda tangan di bawah ini dan membubuhkan parafnya pada halaman depan.
        </p>
        <p>
          Demikian Berita Acara Pemeriksaan ini dibuat untuk dapat digunakan sebagaimana mestinya.
        </p>
        <table border="1" width="100%">
          <tr>
            <td>Yang diperiksa</td>
            <td>Pejabat pemeriksa/Tim pemeriksa</td>
          </tr>
          <tr>
          <tr>
            <td style="vertical-align:top;">
              <table>
                <tr>
                  <td rowspan="3" style="vertical-align:top">1.</td>
                  <td>Nama</td>
                  <td>: <?php echo $pemeriksaan->nama_pegawai ?></td>
                </tr>
                <tr>
                  <td >NIP</td>
                  <td>: <?php echo $pemeriksaan->nip_pegawai ?>td>
                </tr>
                <tr>
                  <td>Tandatangan</td>
                  <td>: td>
                </tr>
              </table>
            </td>
            <td>
              <?php foreach ($tim_pemeriksa as $tim) : ?>

              <table>
                <tr>
                  <td rowspan="3" style="vertical-align:top">1.</td>
                  <td>Nama</td>
                  <td>: <?php echo $tim->nama ?></td>
                </tr>
                <tr>
                  <td >NIP</td>
                  <td>: <?php echo $tim->nip ?></td>
                </tr>
                <tr>
                  <td style="vertical-align:top">Tandatangan</td>
                  <td>: <br/><br/><br/><br/></td>
                </tr>
              </table>
            <?php endforeach; ?>
            </td>
          </tr>


          <!--tr>
            <td colspan="2" style="vertical-align:bottom">Yang diperiksa</td>
            <td colspan="3" style="text-align:center;">
              <p>Bogor,...................</p>
              <p>Pejabat Pemeriksa/Tim Pemeriksa *)</p>
            </td>
          </tr>
          <tr>
            <td>Nama</td>
            <td>: .......</td>
            <td>1.</td>
            <td >Nama</td>
            <td >: .......</td>
          </tr>
          <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>NIP</td>
            <td>: .......</td>
          </tr -->
        </table>
      </div>
    </div>
      </html>
