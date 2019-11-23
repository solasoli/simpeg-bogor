
<!DOCTYPE html>
<html lan="eng">
<?php


?>
<head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <link href="<?php echo base_url('/css/sheets-of-paper-f4.css') ?>" rel="stylesheet" >
    <!--script src="https://code.jquery.com/jquery-2.2.1.js" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script-->
</head>
<body class="document">
<div class="page" contenteditable="true">
    <table width="100%">
        <tr>
            <td align="center"><span class="text-center"><h1>PROFIL PNS</h1></span></td>
        </tr>
    </table>
    <div align='center'>
        <img  style="max-height:300px" src="../../../../simpeg/foto/<?php echo $pegawai->id_pegawai ?>.jpg?<?php echo time(); ?>" alt="No Photo"/>
    </div>
    <h4>I. KETERANGAN PERORANGAN</h4>
    <table class="table table-bordered">
        <tr>
            <td>1.</td>
            <td style="width: 30%">Nama Lengkap</td>
            <td>:</td>
            <td><?php echo $pegawai->nama_lengkap?></td>

        </tr>
        <tr>
            <td>2.</td>
            <td>NIP</td>
            <td>:</td>
            <td><?php echo $pegawai->nip_baru?></td>
        </tr>
        <tr>
            <td>3.</td>
            <td>Pangkat/Gol</td>
            <td>:</td>
            <td><?php echo $pegawai->pangkat." - ".$pegawai->pangkat_gol ?></td>
        </tr>
        <tr>
            <td>4.</td>
            <td>Tempat / Tgl. Lahir</td>
            <td>:</td>
            <td><?php echo $pegawai->tempat_lahir.'/ '.$this->format->tanggal_indo($pegawai->tgl_lahir,"dmY")  ?></td>
        </tr>
        <tr>
            <td>5.</td>
            <td>Jenis Kelamin</td>
            <td>:</td>
            <td><?php echo $pegawai->jenis_kelamin == '1' ? 'Laki-laki' : 'Perempuan' ?></td>
        </tr>
        <tr>
            <td>6.</td>
            <td>A g a m a</td>
            <td>:</td>
            <td><?php echo $pegawai->agama ?></td>
        </tr>
        <tr>
            <td>7.</td>
            <td>Alamat Rumah</td>
            <td>:</td>
            <td><?php echo $pegawai->alamat ?></td>
        </tr>
        <tr>
            <td>8.</td>
            <td>Kabupaten/Kota</td>
            <td>:</td>
            <td><?php echo $pegawai->kota ?></td>
        </tr>
        <tr>
            <td>9.</td>
            <td>Rumpun Jabatan</td>
            <td>:</td>
            <td><?php echo $pegawai->jenjab; ?></td>
        </tr>
        <tr>
            <td>10.</td>
            <td>Jabatan</td>
            <td>:</td>
            <td><?php echo $this->jabatan->get_jabatan_pegawai($pegawai->id_pegawai); ?></td>
        </tr>
        <tr>
            <td>11.</td>
            <td>Eselonering</td>
            <td>:</td>
            <td><?php echo ($pegawai->id_j == ''?'-':($this->jabatan->get_jabatan($pegawai->id_j)->eselon)); ?></td>
        </tr>
        <tr>
            <td>12.</td>
            <td>Jabatan Atasan</td>
            <td>:</td>
            <td><?php
                if (isset($atasan) and $atasan!=NULL and sizeof($atasan) > 0 and $atasan != '') {
                    foreach ($atasan as $lsdata) {
                        $nip_baru_atsl = $lsdata->nip_baru_atsl;
                        $nama_atsl = $lsdata->nama_atsl;
                        $gol_atsl = $lsdata->gol_atsl;
                        $jabatan_atsl = $lsdata->jabatan_atsl;
                    }
                    echo $jabatan_atsl.' (<strong>'.$nama_atsl.'</strong> NIP: '.$nip_baru_atsl.')';
                }else{
                    echo 'Atasan tidak ditemukan';
                }
                ?></td>
        </tr>
        <tr>
            <td>13.</td>
            <td>Unit Kerja</td>
            <td>:</td>
            <td><?php echo ($this->skpd->get_by_id($pegawai->id_unit_kerja)->nama_baru==$this->skpd->get_by_id($pegawai->id_skpd)->nama_baru?$this->skpd->get_by_id($pegawai->id_skpd)->nama_baru:$this->skpd->get_by_id($pegawai->id_unit_kerja)->nama_baru.' - '.$this->skpd->get_by_id($pegawai->id_skpd)->nama_baru); ?></td>
        </tr>
    </table>
</div>

<div class="page">
    <table class="table table-bordered">
        <thead>
        <tr>
            <td colspan="5">
                <h4>II. PENDIDIKAN </h4>
                <h5>1. Pendidikan di Dalam dan di Luar Negeri</h5>
            </td>
        </tr>
        <tr>
            <th>No.</th>
            <th>Tingkat</th>
            <th>Nama Sekolah</th>
            <th>Jurusan</th>
            <th>STTB/Tanda Lulus/Ijasah Tahun</th>
        </tr>
        </thead>
        <?php $x=1;foreach($pendidikan as $pend) { ?>

            <tr>
                <td><?php echo $x++ ?></td>
                <td><?php echo $pend->tingkat_pendidikan ?></td>
                <td><?php echo $pend->lembaga_pendidikan ?></td>
                <td><?php echo $pend->jurusan_pendidikan ?></td>
                <td><?php echo $pend->no_ijazah." ".$pend->tgl_ijazah." ".$pend->tahun_lulus ?></td>
            </tr>
        <?php } ?>
    </table>

    <table class="table table-bordered">
        <thead>
        <tr>
            <td colspan="6"><h5>2. Kursus/Latihan di Dalam dan di Luar Negeri</h5></td>
        </tr>
        <tr>
            <th>No.</th>
            <th>Nama/Kursus/Latihan</th>
            <th>Tanggal</th>
            <th>Jumlah Jam</th>
            <th>Ijasah/Tanda Lulus/Surat Keterangan Tahun</th>
            <th>Penyelenggara</th>
        </tr>
        </thead>
        <?php $x=1;foreach($diklat as $dik) { ?>
            <tr>
                <td><?php echo $x++; ?></td>
                <td><?php echo $dik->nama_diklat ?></td>
                <td><?php echo $this->format->tanggal_indo($dik->tgl_diklat) ?></td>
                <td><?php echo $dik->jml_jam_diklat ?></td>
                <td><?php echo $dik->no_sttpl ?></td>
                <td><?php echo $dik->penyelenggara_diklat ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

<div class="page">
    <table class="table table-bordered" >
        <thead>
        <tr>
            <td colspan="7">
                <h4>III. RIWAYAT PEKERJAAN </h4>
                <h5>1. Riwayat Kepangkatan golongan ruang penggajian</h5>
            </td>
        </tr>
        <tr align="center">
            <th rowspan='2'>No.</th>
            <th rowspan='2'>Pangkat</th>
            <th rowspan='2'>Gol. ruang Penggajian</th>
            <th rowspan='2'>TMT.</th>
            <th colspan='3'>Surat Keputusan</th>
        </tr>
        <tr>
            <th>Pejabat</th>
            <th>Nomor</th>
            <th>Tanggal</th>
        </tr>
        </thead>

        <?php $x=1; foreach($riwayat_pangkat as $rp) { ?>
            <tr>
                <td><?php echo $x++ ; ?></td>
                <td><?php echo $rp->pangkat ?></td>
                <td><?php echo $rp->gol;//.' '.$rp->nama_sk; ?></td>
                <td><?php echo $this->format->tanggal_indo($rp->tmt,"dmY") ?></td>
                <td><?php echo ($rp->pemberi_sk==''?'-':$rp->pemberi_sk) ?></td>
                <td><?php echo $rp->no_sk ?></td>
                <td><?php echo $this->format->tanggal_indo($rp->tgl_sk,"dmY") ?></td>
            </tr>
        <?php } ?>
    </table>

    <table class="table table-bordered">
        <thead>
        <tr>
            <td colspan="5">
                <h5>2. Pengalaman Jabatan / Pekerjaan</h5>
            </td>
        </tr>
        <tr>
            <th rowspan='2'>No.</th>
            <th rowspan='2'>Jabatan / Pekerjaan</th>
            <th rowspan='2'>TMT</th>
            <th colspan='2'>Surat Keputusan</th>
        </tr>
        <tr>
            <th>Nomor</th>
            <th>Tanggal</th>
        </tr>
        </thead>
        <tbody>
        <?php $x=1; foreach($riwayat_mutasi as $mutasi) { ?>
            <tr>
                <td><?php echo $x++ ?></td>
                <td><?php echo $mutasi->nama_jabatan.' ('.$mutasi->jenis.')'; ?></td>
                <td><?php echo $this->format->tanggal_indo($mutasi->tmt,"dmY") ?></td>
                <td><?php echo $mutasi->no_sk ?></td>
                <td><?php echo ($mutasi->tgl_sk=='-'?'-':$this->format->tanggal_indo($mutasi->tgl_sk,"dmY")) ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<div class="page">
    <table class="table table-bordered">
        <tr>
            <td colspan="7">
                <h4>IV. KETERANGAN KELUARGA</h4>
                <h5>1. Istri/Suami</h5></td>
        </tr>
        <tr>
            <th>No.</th>
            <th>Nama</th>
            <th>Tempat Lahir</th>
            <th>Tgl. Lahir</th>
            <th>tgl. Menikah</th>
            <th>Pekerjaan</th>

        </tr>
        <?php foreach($istri_suami as $is){ ?>

            <tr>
                <td>1</td>
                <td><?php echo $is->nama ?></td>
                <td><?php echo $is->tempat_lahir ?></td>
                <td><?php echo $this->format->tanggal_indo($is->tgl_lahir,"dmY") ?></td>
                <td><?php echo $this->format->tanggal_indo($is->tgl_menikah,"dmY") ?></td>
                <td><?php echo $is->pekerjaan ?></td>

            </tr>
        <?php } ?>


        <tr>
            <td colspan="7"><h5>2. Anak</h5></td>
        </tr>
        <tr>
            <th>NO.</th>
            <th>Nama</th>
            <th>Jenis Kelamin</th>
            <th>Tempat Lahir</th>
            <th>Tgl. Lahir</th>
            <th>Pekerjaan</th>
        </tr>
        <?php $x=1; foreach($anak as $anak){ ?>
            <tr>
                <td><?php echo $x++; ?></td>
                <td><?php echo $anak->nama ?></td>
                <td><?php echo $anak->jk == 1 ? "Laki-laki" : "Perempuan" ?></td>
                <td><?php echo $anak->tempat_lahir ?></td>
                <td><?php echo $this->format->tanggal_indo($anak->tgl_lahir,"dmY") ?> </td>
                <td><?php echo $anak->pekerjaan ?></td>
            </tr>
        <?php } ?>
    </table>

    <table class="table table-bordered">
        <tr>
            <td colspan="5">
                <h4>V. RIWAYAT SKP</h4>
            </td>
        </tr>
        <tr>
            <th>No.</th>
            <th>Tahun</th>
            <th>Periode</th>
            <th>Jabatan</th>
            <th>Unit Kerja</th>
        </tr>
        <?php $x=0; $thn=0; $capaian=array(); foreach($skp as $skp){ ?>
            <?php
            if($thn==$skp->tahun){
                $x = $x;
                $view = false;
            }else{
                $thn=$skp->tahun;
                $x = $x+1;
                $view = true;
            }
            ?>
            <tr>
                <td rowspan="2"><?php echo ($view==true?$x:''); ?></td>
                <td rowspan="2"><?php echo ($view==true?$skp->tahun:''); ?></td>
                <td><?php echo $skp->periode_awal.' s/d '.$skp->periode_akhir; ?></td>
                <td><?php echo $skp->jabatan_pegawai; ?></td>
                <td><?php echo $skp->unit_kerja ?></td>
            </tr>
            <tr>
                <td colspan="3" style="font-size: small;">
                    Capaian: <?php echo $skp->jml_rata2_pencapaian ?> |
                    Perilaku: <?php echo $skp->avg_perilaku; ?>
                    (Orientasi Pelayanan: <?php echo $skp->orientasi_pelayanan ?>, Integritas: <?php echo $skp->integritas ?>,
                    Komitmen: <?php echo $skp->komitmen ?>, Disiplin: <?php echo $skp->disiplin ?>,
                    Kerjasama: <?php echo $skp->kerjasama ?><?php echo($skp->kepemimpinan==''?'':', Kepemimpinan: '.$skp->kepemimpinan); ?>)<br>
                    <?php
                    if($view==false){
                        $capaian[] = $skp->jml_rata2_pencapaian;
                        $nilaiSkp = round(array_sum($capaian)/count($capaian),2);
                        //echo "SKP Gabungan Thn. $thn Rata-rata Capaian: " . $nilaiSkp.'<br>';
                        echo '60% Capaian Rata-rata: '.round(0.6*$nilaiSkp,2).', 40% Perilaku: '.round(0.4*$skp->avg_perilaku,2);
                        echo ' | NPK: '.round((0.6*$nilaiSkp)+(0.4*$skp->avg_perilaku), 2);
                        echo ' ('.$this->pegawai->sebutan_capaian((0.6*$skp->jml_rata2_pencapaian)+(0.4*$skp->avg_perilaku)).')';
                    }else{
                        $capaian = array();
                        $capaian[] = $skp->jml_rata2_pencapaian;

                        echo '60% Capaian:'.round(0.6*$skp->jml_rata2_pencapaian,2).', 40% Perilaku:'.round(0.4*$skp->avg_perilaku,2);
                        echo ' | NPK: '.round((0.6*$skp->jml_rata2_pencapaian)+(0.4*$skp->avg_perilaku), 2);
                        echo ' ('.$this->pegawai->sebutan_capaian((0.6*$skp->jml_rata2_pencapaian)+(0.4*$skp->avg_perilaku)).')';
                    }
                    ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="page">
    <h4>VI. STANDAR KOMPETENSI</h4>
    <h5><?php echo strtoupper($kat_jabatan); ?></h5>
    <?php
    if (is_array($std_kompetensi) and sizeof($std_kompetensi) > 0 and $std_kompetensi != ''){
        foreach($lvl_kompetensi as $lsdata_lvl){
            echo '<strong>Level '.$lsdata_lvl->id_kmp_level.' - '.$lsdata_lvl->nama_level.'</strong><br>';
            echo 'Kriteria : '.$lsdata_lvl->kriteria_level;
        }
    }
    ?>

    <?php if (is_array($std_kompetensi) and sizeof($std_kompetensi) > 0 and $std_kompetensi != ''){
        $x=1;
        $nama_kmp = '';
        $nama_kmp2 = '';
        echo 'Kompetensi :'.'<br>';
        foreach($std_kompetensi as $lsdata){
            if ($nama_kmp == '') {
                $nama_kmp = $lsdata->nama_kmp;
                $nama_kmp2 = $lsdata->nama_kmp;
            } else {
                if ($nama_kmp == $lsdata->nama_kmp) {
                    $nama_kmp2 = '';
                } else {
                    $nama_kmp2 = $lsdata->nama_kmp;
                }
            }

            if($nama_kmp2!=''){
                echo '<br><span style="font-weight: bold; font-size: large;text-decoration: underline;">'.strtoupper($nama_kmp2).'</span><br>';
            }

            if($lsdata->kode_kmp!=''){
                echo '<br><strong>'.$x++.') '.$lsdata->kode_kmp.' '.$lsdata->nama_jenis_kmp.'</strong><br>Definisi: '.$lsdata->definisi_kmp.'<br>';
            }
            if($lsdata->id_kmp_level!='') {
                echo 'Level : ' . $lsdata->id_kmp_level . '<br>';
                echo 'Deskripsi : ' . $lsdata->deskripsi_kmp . '<br>';
                echo 'Indikator : <br>' . $lsdata->indikator_kmp . '<br>';
            }
        }
    }else{
        echo 'Belum ada data';
    } ?>
</div>
</body>
</html>
