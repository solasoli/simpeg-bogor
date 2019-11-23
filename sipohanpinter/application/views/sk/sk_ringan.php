<html lang="en" style="height:100% ">
<head>
  <meta charset="UTF-8" />
  <link href="<?php echo base_url('assets/css/sheets-of-paper-f4-kop.css') ?>" rel="stylesheet" >
  <style>
    body{
      font-family: Bookman Old Style, "Times New Roman", Times, serif;
    }
  </style>
</head>
<body class="document">
  <div class="page" contenteditable="true">
    <div style="text-align:center;">KEPUTUSAN [JABATAN YANG BERWENANG]</div>
    <div style="text-align:center;">NOMOR : </div>
    <br/>
    <div style="text-align:center;">TENTANG</div>
      <br/>
    <div style="text-align:center;">
      PENJATUHAN HUKUMAN DISIPLIN TINGKAT RINGAN BERUPA [TEGURAN LISAN] ATAS NAMA <?php echo strtoupper($pemeriksaan->nama_pegawai) ?>
      NOMOR INDUK PEGAWAI <?php echo $pemeriksaan->nip_pegawai ?>
      JABATAN <?php echo $pemeriksaan->jabatan_pegawai ?>
      DENGAN RAHMAT TUHAN YANG MAHA ESA,<br/>
      ........................
    </div>
    <div>
      <table border="0" style="padding:10">
        <tr>
          <td style="vertical-align:top;">Menimbang</td>
          <td style="vertical-align:top;">:</td>
          <td>
            <ol type="a" style="padding-left:20;">
              <li style="padding-bottom:10">
                bahwa Saudara ................, NIP. .........., Pangkat ...... Golongan/Ruang ........... jabatan ............ pada .................
                telah melakukan pelanggaran disiplin Pegawai Negeri Sipil terhadap ....................;</li>
              <li style="padding-bottom:10">
                bahwa perbuatan tersebut merupakan pelanggaran terhadap ketentuan Pasal … angka … Peraturan Pemerintah Nomor 53 Tahun 2010 tentang Disiplin PNS;
              </li>
              <li style="padding-bottom:10">
                bahwa untuk menegakkan disiplin, perlu menjatuhkan hukuman disiplin berupa teguran lisan;
              </li>
              <li style="padding-bottom:10">
                bahwa berdasarkan pertimbangan sebagaimana dimaksud pada huruf a, huruf b, dan huruf c perlu menetapkan Keputusan ............*;
              </li>
            </ol>
            <br/>
          </td>
        </tr>
        <tr>
          <td style="vertical-align:top;">Mengingat</td>
          <td style="vertical-align:top;">:</td>
          <td>
            <ol type="1" style="padding-left:20;">
              <li style="padding-bottom:10">
                Undang-Undang Nomor 5 Tahun 2014 tentang Aparatur Sipil Negara (Lembaran Negara Republik Indonesia   Tahun 2014 Nomor 6, Tambahan Lembaran Negara Republik Indonesia 5494);
              </li>
              <li style="padding-bottom:10">
                Peraturan Pemerintah Nomor 53 tahun 2010 tentang Disiplin Pegawai Negeri Sipil (Lembaran Negara Republik Indonesia Tahun 2010 Nomor 74, Tambahan Lembaran Negara Republik Indonesia Nomor 5135);
              </li>
              <li style="padding-bottom:10">
                Peraturan Pemerintah Nomor 11 Tahun 2017 tentang Manajeman Pegawai Negeri Sipil (Lembaran Negara Republik IndonesiaTahun 2017 Nomor 73);
              </li>
              <li style="padding-bottom:10">
                Peraturan Kepala Badan Kepegawaian Negara Nomor 21 Tahun 2010 tentang ketentuan pelaksanaan Peraturan Pemerintah Nomor 53 Tahun 2010 tentang Disiplin Pegawai Negeri Sipil;
              </li>
            </ol>
            <br/>
          </td>
        </tr>
        <tr>
          <td colspan="3" style="text-align:center;">MEMUTUSKAN</td>
        </tr>
        <tr>
          <td>Menetapkan</td>
          <td>:</td>
          <td><br/></td>
        </tr>
        <tr>
          <td style="vertical-align:top;">KESATU</td>
          <td style="vertical-align:top;">:</td>
          <td>
            Menjatuhkan hukuman disiplin berupa Teguran Lisan kepada:
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
            Karena yang bersangkutan telah melakukan perbuatan yang melanggar ketentuan Pasal ... angka ... Peraturan Pemerintah Nomor 53 Tahun 2010 tentang Disiplin PNS.<br/>
          </td>
        </tr>
        <tr>
          <td style="vertical-align:top;">KEDUA</td>
          <td style="vertical-align:top;">:</td>
          <td>
            Keputusan ini mulai berlaku pada tanggal ditetapkan.
          </td>
        </tr>
        <tr>
          <td style="vertical-align:top;">KETIGA</td>
          <td style="vertical-align:top;">:</td>
          <td>
            Keputusan ini disampaikan kepada yang bersangkutan untuk dilaksanakan sebagaimana mestinya.
          </td>
        </tr>
      </table>
    </div>
    <div id="tandatangan">
      <table width="100%">
        <tr>
          <td width="50%"></td>
          <td>Ditetapkan di Bogor</td>
        </tr>
        <tr>
          <td width="50%"></td>
          <td>pada tanggal ......</td>
        </tr>
        <tr>
          <td width="50%"></td>
          <td><br/><br/><br/></td>
        </tr>
        <tr>
          <td width="50%"></td>
          <td>Nama....</td>
        </tr>
        <tr>
          <td width="50%"></td>
          <td>NIP. ......</td>
        </tr>
      </table>
    </div>
  </div>
</body>
</html>
