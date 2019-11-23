<html lang="en" style="height:100% ">
<head>
  <meta charset="UTF-8" />
  <link href="<?php //echo base_url('assets/metro/css/metro-all.css?ver=@@b-version') ?>" rel="stylesheet">
  <link href="<?php echo base_url('assets/css/sheets-of-paper-f4-kop.css') ?>" rel="stylesheet" >
  <style>
    .page{
      padding-top: 2cm;

    }
    @page{
      margin-top: 2cm;
    }
    td{
      vertical-align: top;
      padding: 5px;
      padding-top: 3px;
      padding-bottom: 3px;
      text-align: left;
    }
    .kop{
    	margin-top: 3cm;

    }
  </style>
</head>
<body class="document">
<div class="page" contenteditable="true">
  <div class="kop"></div>
<h4 style="text-align:center;padding-bottom:0px;">KEPUTUSAN <?php echo strtoupper($berwenang->jabatan) ?>
<br/><small>Nomor : ....... </small></h4>

<h4 style="text-align:center">
  TENTANG<br/>
  PENJATUHAN HUKUMAN DISIPLIN TINGKAT RINGAN BERUPA
  <?php echo strtoupper($jenis->deskripsi) ?> ATAS NAMA <?php echo strtoupper($pegawai->nama) ?>
  NOMOR INDUK PEGAWAI <?php echo $pegawai->nip ?><br/>
  JABATAN <?php echo strtoupper($pegawai->jabatan) ?><br/>
  DENGAN RAHMAT TUHAN YANG MAHA ESA,
  <br/>
  <small>
  <?php echo strtoupper($berwenang->jabatan) ?>
</small>
  <br/>


</h4>

<table class="table">
  <tr>
    <td rowspan="4">Menimbang</td>
    <td>:</a>
    <td>a.</td>
    <td>bahwa Saudara <?php echo $pegawai->nama ?>,&nbsp;
      NIP. <?php echo $pegawai->nip ?>,&nbsp;
      Pangkat <?php echo modules::run("Sipohan/get_pangkat",$pegawai->pangkat) ?>,&nbsp;
      Golongan/Ruang <?php echo $pegawai->pangkat ?>,&nbsp;
      jabatan <?php echo $pegawai->jabatan ?>,&nbsp;
      pada <?php echo $pegawai->unit_kerja ?>,&nbsp;
      telah melakukan pelanggaran disiplin Pegawai Negeri Sipil
      terhadap <?php echo $hukuman->data_pelanggaran ?>;
    </td>
  </tr>
  <tr>
    <td></a>
    <td>b.</td>
    <td>bahwa perbuatan tersebut merupakan pelanggaran
      terhadap ketentuan Pasal <?php echo $hukuman->pasal." angka ".$hukuman->ayat ?>
      Peraturan Pemerintah Nomor 53 Tahun 2010 tentang Disiplin PNS;
    </td>
  </tr>
  <tr>
    <td></a>
    <td>c.</td>
    <td>
      bahwa untuk menegakkan disiplin, perlu menjatuhkan hukuman disiplin berupa teguran lisan;
    </td>
  </tr>
  <tr>
    <td></a>
    <td>d.</td>
    <td>
      bahwa berdasarkan pertimbangan sebagaimana dimaksud pada huruf a, huruf b, dan huruf c
      perlu menetapkan Keputusan <?php echo $atasan->jabatan ?>;
    </td>
  </tr>

  <!-- mengingat -->
  <tr>
    <td rowspan="4">Mengingat</td>
    <td>:</td>
    <td>1.</td>
    <td>Undang-Undang Nomor 5 Tahun 2014 tentang Aparatur Sipil Negara
      (Lembaran Negara Republik Indonesia   Tahun 2014 Nomor 6,
      Tambahan Lembaran Negara Republik Indonesia 5494);
    </td>
  </tr>
  <tr>
    <td></td>
    <td>2.</td>
    <td>
      Peraturan Pemerintah Nomor 53 tahun 2010 tentang Disiplin Pegawai Negeri Sipil
      (Lembaran Negara Republik Indonesia Tahun 2010 Nomor 74,
      Tambahan Lembaran Negara Republik Indonesia Nomor 5135);
    </td>
  </tr>
  <tr>
    <td></td>
    <td>3.</td>
    <td>
      Peraturan Pemerintah Nomor 11 Tahun 2017 tentang Manajeman Pegawai Negeri Sipil
      (Lembaran Negara Republik IndonesiaTahun 2017 Nomor 73);
    </td>
  </tr>
  <tr>
    <td></td>
    <td>4.</td>
    <td>
      Peraturan Kepala Badan Kepegawaian Negara Nomor 21 Tahun 2010
      tentang ketentuan pelaksanaan Peraturan Pemerintah Nomor 53 Tahun 2010
      tentang Disiplin Pegawai Negeri Sipil;
    </td>
  </tr>
  <tr>
    <td colspan="4" style="text-align:center;padding:10px">MEMUTUSKAN</td>
  </tr>
  <tr>
    <td>Menetapkan</td>
    <td>:</td>
    <td></td>
    <td></td>
  </tr>
</table>

<table>
  <tr>
    <td>KESATU</td>
    <td>:</td>
    <td colspan="2">Menjatuhkan hukuman disiplin berupa Teguran Lisan kepada:<br/>
        <table >
          <tr>
            <td style="padding:0px">Nama</td>
            <td style="padding:0px">:</td>
            <td style="padding:0px"><?php echo $pegawai->nama ?></td>
          </tr>
          <tr>
            <td style="padding:0px" >NIP</td>
            <td style="padding:0px">:</td>
            <td style="padding:0px"><?php echo $pegawai->nip ?></td>
          </tr>
          <tr>
            <td style="padding:0px">Pangkat</td>
            <td style="padding:0px">:</td>
            <td style="padding:0px"><?php echo Modules::run("Sipohan/get_pangkat",$pegawai->pangkat)." - ".$pegawai->pangkat ?></td>
          </tr>
          <tr>
            <td style="padding:0px">Jabatan</td>
            <td style="padding:0px">:</td>
            <td style="padding:0px"><?php echo $pegawai->jabatan ?></td>
          </tr>
          <tr>
            <td style="padding:0px;width:30%">Perangkat Daerah</td>
            <td style="padding:0px">:</td>
            <td style="padding:0px"><?php echo $pegawai->unit_kerja ?></td>
          </tr>
        </table>
      </td>
    </tr>
</table>
</div>
<div class="page" contenteditable="true">
<table>
  <tr>
    <td></td>
    <td></td>
    <td>
      karena yang bersangkutan telah melakukan perbuatan yang melanggar
      ketentuan Pasal <?php echo $hukuman->pasal ?> angka <?php echo $hukuman->ayat ?> Peraturan Pemerintah Nomor 53 Tahun 2010 tentang Disiplin PNS.
    </td>
  </tr>
  <tr>
    <td>KEDUA</td>
    <td>:</td>
    <td colspan="2">
      Keputusan ini mulai berlaku pada tanggal ditetapkan.
    </td>
  </tr>
  <tr>
    <td>KETIGA</td>
    <td>:</td>
    <td colspan="2">
      Keputusan ini disampaikan kepada yang bersangkutan untuk dilaksanakan sebagaimana mestinya.
    </td>
  </tr>
</table>
<table style="width:100%" class="table compact">
  <tr>
    <td style="width:50%"></td>
    <td style="text-align:center">
      Bogor, <?php echo $hukuman->tgl_hukuman ?><br/>
      <?php echo $hukuman->jabatan_pemberi_hukuman ?>
      <br/><br/><br/>
      <span style="text-decoration:underline"><strong><?php echo $hukuman->pejabat_pemberi_hukuman ?></strong></span><br/>
      NIP. <?php echo $berwenang->nip ?> ?>

    </td>
  </tr>
  <tr>
    <td colspan="2">Tembusan Kepada Yth :
      <ol type="1">
        <li>Walikota Bogor;</li>
        <li>Inspektur Kota Bogor;</li>
        <li>Kepala Badan Kepegawaian dan Pengembangan Sumberdaya Aparatur Kota Bogor.</li>
      </td>
    </tr>
  </table>
</div>
</body>
</html>
