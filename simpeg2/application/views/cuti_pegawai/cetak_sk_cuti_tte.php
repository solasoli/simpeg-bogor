<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'/third_party/html2pdf.class.php';

include APPPATH."/third_party/QrCode/src/Exception/QrCodeException.php";
include APPPATH."/third_party/QrCode/src/Exception/InvalidPathException.php";
include APPPATH."/third_party/QrCode/src/QrCodeInterface.php";
include APPPATH."/third_party/QrCode/src/QrCode.php";
include APPPATH."/third_party/QrCode/php-enum-master/src/Enum.php";
include APPPATH."/third_party/QrCode/src/ErrorCorrectionLevel.php";
include APPPATH."/third_party/QrCode/src/LabelAlignment.php";
include APPPATH."/third_party/QrCode/src/Writer/WriterInterface.php";
include APPPATH."/third_party/QrCode/src/Writer/AbstractWriter.php";
include APPPATH."/third_party/QrCode/src/Writer/BinaryWriter.php";
include APPPATH."/third_party/QrCode/src/Writer/DebugWriter.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Renderer/Color/ColorInterface.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Renderer/Color/Rgb.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Common/AbstractEnum.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Common/ErrorCorrectionLevel.php";
include APPPATH."/third_party/QrCode/src/Traits/BaconConversionTrait.php";
include APPPATH."/third_party/QrCode/src/Writer/EpsWriter.php";
include APPPATH."/third_party/QrCode/src/WriterRegistryInterface.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Renderer/RendererInterface.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Renderer/Image/RendererInterface.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Renderer/Image/AbstractRenderer.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Renderer/Image/Png.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Common/Mode.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Common/BitArray.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Common/CharacterSetEci.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Common/EcBlock.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Common/EcBlocks.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Common/Version.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Common/ReedSolomonCodec.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Encoder/BlockPair.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Encoder/QrCode.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Encoder/ByteMatrix.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Encoder/MatrixUtil.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Common/BitUtils.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Encoder/MaskUtil.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Encoder/Encoder.php";
include APPPATH."/third_party/QrCode/BaconQrCode/Writer.php";
include APPPATH."/third_party/QrCode/src/Writer/PngWriter.php";
include APPPATH."/third_party/QrCode/src/Writer/SvgWriter.php";
include APPPATH."/third_party/QrCode/src/WriterRegistry.php";

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\Factory\QrCodeFactory;
use Endroid\QrCode\QrCode;


foreach($dataRow as $data) {
    $idp = $data->id_pegawai;
    $idcuti = $data->id_cuti_master;
    $jcuti = $data->deskripsi;
    $nama = $data->nama;
    $namap = $data->nama;
    $nip = $data->nip_baru;
    $nipp = $data->nip_baru;
    $last_gol = $data->last_gol;
    $gol = $data->pangkat_p." (".$data->last_gol.")";
    $jabatan = $data->last_jabatan;
    $jabatan_p = $jabatan;
    $eselon_p = $data->eselon;
    $id_pegawai_pengesah = $data->id_pegawai_pengesah;

    if($jabatan=='Sekretaris Daerah Kota Bogor' or $data->last_atsl_jabatan=='Sekretaris Daerah Kota Bogor'){
        $nmrlabel = 'BKPSDA';
    }else{
        $nmrlabel = 'FDP';
    }
    $unit = $data->last_unit_kerja;
    $lamacuti = $data->lama_cuti+$data->lama_cuti_n1;
    $tglmulai = $data->tmt_awal_cuti;
    $tglselesai = $data->tmt_akhir_cuti;
    $idj_cuti = $data->id_jenis_cuti;
    $keterangan = $data->keterangan;

    /*if($idj_cuti=='C_BESAR' or $idj_cuti=='C_ALASAN_PENTING'){
        if(strpos($keterangan,'Dengan Alasan')>0){
            $alamat = substr($keterangan,0,strpos($keterangan,'Dengan Alasan'));
            $alasan = substr($keterangan,strpos($keterangan,'Dengan Alasan')+14,strlen($keterangan));
        }else{
            $alamat = $keterangan;
            $alasan = $data->alasan_cuti;
            if($alasan==''){
                $alasan = '-';
            }

        }
    }else{
        $alamat = $keterangan;
    }*/
    $alasan = $data->alasan_cuti;
    $alamat = $keterangan;
    $is_kunjungan_luar_negeri = $data->is_kunjungan_luar_negeri;
    $sub_jenis_cuti = $data->sub_jenis_cuti;
    if($is_kunjungan_luar_negeri==1){
        $alasan = "Kunjungan ke Luar Negeri. ".$alasan;
        $nmrlabel = 'BKPSDA';
    }
    if($idj_cuti=='C_SAKIT'){
        $sqlSkt = " SELECT cjs.jenis_cuti_sakit, CASE WHEN cs.idjenis_cuti_sakit = 1
                        THEN (CASE WHEN cs.flag_sakit_baru = 1 THEN 'Usulan Baru' ELSE 'Usulan Perpanjangan' END)
                        ELSE NULL END AS flag
                        FROM cuti_sakit cs, cuti_jenis_sakit cjs
                        WHERE cs.id_cuti_master = ".$idcuti." AND cs.idjenis_cuti_sakit = cjs.idjenis_cuti_sakit";

        $qSkt = $this->db->query($sqlSkt);
        foreach ($qSkt->result() as $row){
            $jnsSkt = $row->jenis_cuti_sakit;
            $flag = $row->flag;
        }
        $alasan = $jnsSkt.($flag==''?'':' ('.$flag.').').' '.$alasan;
    }elseif($idj_cuti=='C_BESAR' or $idj_cuti=='C_ALASAN_PENTING' or $idj_cuti=='CLTN') {
        $sqlNonSkt = "SELECT * FROM simpeg.cuti_jenis_non_sakit
                          WHERE kode_sub_jenis_cuti_nonsakit = '" . $sub_jenis_cuti . "'";
        $qNSkt = $this->db->query($sqlNonSkt);
        foreach ($qNSkt->result() as $row){
            $jnsNSkt = $row->jenis_cuti_nonsakit;
        }
        $alasan = $jnsNSkt . '.'.' '.$alasan;
    }else{
        $alasan = $alasan.'. ';
    }

    switch ($idj_cuti){
        case 'C_TAHUNAN':
            $j_cuti = 864; //851
            break;
        case 'C_BESAR':
            $j_cuti = 866; //852
            break;
        case 'C_SAKIT':
            $j_cuti = 862; //853
            break;
        case 'C_BERSALIN':
            $j_cuti = 863; //854
            break;
        case 'C_ALASAN_PENTING':
            $j_cuti = 865; //857
            break;
        default: //CLTN
            $j_cuti = 866;
            break;
    }
}
?>
<page backtop="14mm" backbottom="10mm" backleft="10mm" backright="14mm" style="font-size: 11pt">
    <table border="0" cellspacing="0" cellpadding="0" style="width: 98%; ">
        <tr>
            <td style="width: 10%; padding-bottom: 150px;"> <!-- border-bottom: double 2px black;  -->
                <!--<img src="images/logokotabogor_gray.gif" style="width: 85px;">-->
            </td>
            <td style="width: 90%; text-align: center; vertical-align: middle; padding-bottom: 150px;"> <!-- border-bottom: double 2px black;  -->
                <!--<span style="font-size: 120%;">PEMERINTAH KOTA BOGOR</span><br>
                <span style="font-weight: bold;font-size:130%;padding-bottom: 20px;">BADAN KEPEGAWAIAN DAN PENGEMBANGAN <br>SUMBER DAYA APARATUR</span><br>
                <span>Jl. Ir. H. Juanda No. 10 Telp. (0251) 8358942 Fax. (0251) 8356170</span><br>B O G O R - 16121-->
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right; padding-right: 50px;">
            <span style="text-align: right;margin-top: 5px;text-decoration: underline;">
                <?php
                $tmtawal = explode("/",$tglmulai);
                $mon = $tmtawal[1];
                $mon = date("m");
                ?>
                Bogor, <?php echo /*date("d").*/'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; '.$this->umum_model->monthName($mon).' '.date("Y"); ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: right;padding-top: -15px;padding-right: 50px;">
            <span style="text-align: right;margin-top: 15px;">
                <?php echo $this->umum_model->getTglCurHijriyah(); ?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center"><span style="margin-top: 15px;font-size: 120%;">
                <b><U>SURAT IZIN <?php echo strtoupper($jcuti); ?></U></b></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center">
                <span>Nomor : <?php echo $j_cuti; ?>/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    - <?php echo $nmrlabel?></span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left: 30px;padding-top: 30px;">
                <span>
                    Diberikan <?php echo $jcuti; ?> kepada Pegawai Negeri Sipil di bawah ini :
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 10px;">
                <table border="0" cellspacing="10" cellpadding="0" style="width: 100%;">
                    <tr>
                        <td style="width: 15%;" rowspan="7"></td>
                        <td style="width: 25%; text-align: left;vertical-align: top;">Nama</td>
                        <td style="width: 2%;vertical-align: top;">:</td>
                        <td style="width: 55%;text-align: left;"><strong><?php echo $nama; ?></strong></td>
                    </tr>
                    <tr>
                        <td style="width: 25%; text-align: left;">NIP</td>
                        <td style="width: 2%;vertical-align: top;">:</td>
                        <td style="width: 55%;text-align: left;"><?php echo $nip; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 25%; text-align: left;">Pangkat/Gol. Ruang</td>
                        <td style="width: 2%;vertical-align: top;">:</td>
                        <td style="width: 55%;text-align: left;"><?php echo $gol; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 25%; text-align: left;vertical-align: top;">Jabatan</td>
                        <td style="width: 2%;vertical-align: top;">:</td>
                        <td style="width: 55%;text-align: left;"><?php echo $jabatan; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 25%; text-align: left;vertical-align: top;">Unit Kerja</td>
                        <td style="width: 2%;vertical-align: top;">:</td>
                        <td style="width: 55%;text-align: left;"><?php echo $unit; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 25%; text-align: left;vertical-align: top;">Alamat</td>
                        <td style="width: 2%;vertical-align: top;">:</td>
                        <td style="width: 55%;text-align: left;"><?php echo $alamat; ?></td>
                    </tr>
                    <?php //if($idj_cuti=='C_BESAR' or $idj_cuti=='C_ALASAN_PENTING'): ?>
                    <tr>
                        <td style="width: 25%; text-align: left;vertical-align: top;">Keterangan</td>
                        <td style="width: 2%;vertical-align: top;">:</td>
                        <td style="width: 55%;text-align: left;"><?php echo $alasan; ?></td>
                    </tr>
                    <?php //endif; ?>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left: 30px;padding-top: 10px;">
                <span>Selama <?php echo $lamacuti. " (".$this->umum_model->kekata($lamacuti).")" ?> hari kerja terhitung mulai tanggal
                    <?php echo $tglmulai; ?> s.d. <?php echo $tglselesai; ?> dengan ketentuan sebagai berikut :
                </span>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left: 30px;">
                <ol style="margin-left: -15px;">
                    <li style="line-height:1.5;padding-bottom: 10px;">
                        Sebelum menjalankan  <?php echo strtolower($jcuti); ?>, wajib menyerahkan pekerjaan kepada atasan langsungnya;
                    </li>
                    <li style="line-height:1.5;padding-bottom: 10px;">
                        Setelah selesai menjalankan <?php echo strtolower($jcuti); ?>, wajib melaporkan diri kepada atasan langsungnya dan bekerja kembali sebagaimana biasa.
                    </li>
                </ol>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-left: 30px;">
                Demikian Surat Izin Cuti ini dibuat untuk dapat digunakan sebagaimana mestinya.
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 60px;">
                    <tr>
                        <td style="width:60%; text-align: center;">

                        </td>
                        <td style="width:40%">
                            <?php
                            //print_r($dataRowPengesah);
                            //echo '<br>';
                            foreach($dataRowPengesah as $data) {
                                $nip = $data->nip_baru;
                                $nama = $data->nama;
                                $eselon = $data->eselon;
                                $pangkat = $data->pangkat;
                                $jabatan = $data->jabatan;
                                $is_plt = (isset($data->id_pegawai_plt)==''?0:1);
                            }
                            ?>
                            <?php if($is_kunjungan_luar_negeri==1): ?>
                                <?php
                                $sql = "SELECT c.*, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                                            p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) as nama_plt FROM
                                            (SELECT b.*, jp.id_pegawai FROM
                                            (SELECT p.id_j, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                                            p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) as nama_asli, p.nama, a.jabatan
                                            FROM pegawai p INNER JOIN
                                            (SELECT j.id_j, j.jabatan FROM jabatan j
                                            WHERE j.jabatan LIKE 'Walikota Bogor%' AND j.tahun = (SELECT MAX(tahun) FROM jabatan)) a ON p.id_j = a.id_j) b
                                            LEFT JOIN jabatan_plt jp ON b.id_j = jp.id_j) c LEFT JOIN pegawai p ON p.id_pegawai = c.id_pegawai";
                                $wali = $this->db->query($sql);
                                foreach ($wali->result() as $row){
                                    if($row->nama_plt==""){?>
                                        <strong><?php echo 'Wali Kota Bogor'//$row->jabatan; ?></strong>, <br><br><br><br><br>
                                        <span style="text-decoration: none;font-weight: bold;"><?php echo $row->nama;?></span><br>
                                    <?php }else{ ?>
                                        <strong>Plt. <?php echo $row->jabatan; ?></strong>, <br><br><br><br><br>
                                        <span style="text-decoration: none;font-weight: bold;"><?php echo $row->nama_plt;?></span><br>
                                    <?php }
                                }
                                ?>
                            <?php else: ?>
                                <?php if($eselon=='IIB'): ?>
                                    <strong>Kepala</strong>, <br><br><br><br><br>
                                    <span style="text-decoration: none;font-weight: bold;"><?php echo $nama;?></span><br>
                                    <?php echo $pangkat; ?><br>
                                    NIP. <?php echo $nip; ?>
                                <?php elseif($eselon=='IIIA'):?>
                                    <span style="margin-left: -30px;">a.n. </span><strong>Kepala</strong><br>
                                    <strong>Sekretaris</strong>, <br><br><br><br><br>
                                    <span style="text-decoration: none;font-weight: bold;"><?php echo $nama;?></span><br>
                                    <?php echo $pangkat; ?><br>
                                    NIP. <?php echo $nip; ?>
                                <?php elseif($eselon=='IIIB'):?>

                                    <?php
                                        if($last_gol >= 'III/a' and $last_gol <= 'IV/a'){
                                            if($is_plt==0) {?>
                                                <span style="margin-left: -30px;">a.n. </span><strong>Kepala</strong><br>
                                                <?php echo "<strong>Sekretaris,</strong>";
                                                echo "<br><br><br><br><br>"; ?>
                                                <span style="text-decoration: none;font-weight: bold;"><?php echo $nama;?></span><br>
                                                <?php echo $pangkat; ?><br>
                                                NIP. <?php echo $nip; ?>
                                            <?php }else{
                                                echo "<span style=\"margin-left: -30px;\">a.n. </span><strong>Sekretaris</strong><br>";
                                                echo "<span style=\"margin-left: 20px;\">u.b.</span><br>";
                                                echo '<strong>'.ucfirst(substr($jabatan,0,strpos($jabatan,' pada'))).'</strong>,';
                                            }
                                        }elseif($last_gol >= 'I/a' and $last_gol < 'III/a') {
                                            if($is_plt==0) {?>
                                                <span style="margin-left: -30px;">a.n. </span><strong>Kepala</strong><br>
                                                <strong><?php echo ($is_plt==1?'Plt. ':''); ?>Sekretaris</strong>,<br>
                                                <?php echo "<span style=\"margin-left: 20px;\">u.b.</span><br>"; ?>
                                                <?php echo '<strong>'.ucfirst(substr($jabatan,0,strpos($jabatan,' pada'))).'</strong>,';
                                                echo "<br><br><br><br><br>"; ?>
                                                <span style="text-decoration: none;font-weight: bold;"><?php echo $nama;?></span><br>
                                                <?php echo $pangkat; ?><br>
                                                NIP. <?php echo $nip; ?>
                                            <?php }else{
                                                echo "<span style=\"margin-left: -30px;\">a.n. </span><strong>Kepala Bidang Formasi, Data, dan Penatausahaan Pegawai</strong><br>";
                                                echo "<span style=\"margin-left: 20px;\">u.b.</span><br>";
                                                echo '<strong>'.ucfirst(substr($jabatan,0,strpos($jabatan,' pada'))).'</strong>,';
                                            }
                                        }else{?>
                                            <strong>Sekretaris Daerah</strong>, <br><br><br><br><br>
                                            <span style="text-decoration: none;font-weight: bold;"><?php echo $nama;?></span><br>
                                            <?php echo $pangkat; ?><br>
                                            NIP. <?php echo $nip; ?>
                                        <?php }
                                    ?>

                                    <!--<span style="margin-left: -30px;">a.n. </span><strong>Kepala</strong><br>
                                    <strong><?php //echo ($is_plt==1?'Plt. ':''); ?>Sekretaris</strong>,<br>
                                    <?php if($is_plt==0): ?>
                                        <span style="margin-left: 20px;">u.b.</span><br>
                                        <strong><?php //echo ucfirst(substr($jabatan,0,strpos($jabatan,' pada')));?></strong>,
                                    <?php endif; ?>
                                    <br><br><br><br><br>
                                    <span style="text-decoration: none;font-weight: bold;"><?php //echo $nama;?></span><br>
                                    <?php //echo $pangkat; ?><br>
                                    NIP. <?php //echo $nip; ?> -->

                                <?php else: ?>
                                    <?php
                                    $sql = "SELECT COUNT(id_jabatan_plt) as jumlah_all FROM jabatan_plt WHERE id_pegawai = $id_pegawai_pengesah AND id_j = 3082";
                                    $query = $this->db->query($sql);
                                    foreach ($query->result() as $row){
                                        $jmlPlhKaban = $row->jumlah_all;
                                    }

                                    if($eselon_p == 'IIIA' or $eselon_p == 'IIIB'){
                                        if($jmlPlhKaban>0){
                                            $isPlhKaban = true;
                                        }else{
                                            $isPlhKaban = false;
                                        }
                                    }else{
                                        if($last_gol >= 'IV/a') {
                                            if($jmlPlhKaban>0){
                                                if($eselon_p == 'IIB' or $eselon_p == 'IIA'){
                                                    $isPlhKaban = false;
                                                }else{
                                                    $isPlhKaban = true;
                                                }
                                            }else{
                                                $isPlhKaban = false;
                                            }
                                        }else{
                                            $isPlhKaban = false;
                                        }
                                    }
                                    if($isPlhKaban==true){
                                        echo '<strong>Plt. Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Aparatur</strong>,<br>';
                                        //echo "<span style=\"margin-left: 20px;\">u.b.</span><br>";
                                    }else{
                                        if($last_gol >= 'III/a' and $last_gol <= 'IV/a'){
                                            if($is_plt==0) {
                                                echo "<strong>Sekretaris,</strong>";
                                                echo "<br><br><br><br><br>"; ?>
                                                <span style="text-decoration: none;font-weight: bold;"><?php echo $nama;?></span><br>
                                                <?php echo $pangkat; ?><br>
                                                NIP. <?php echo $nip; ?>
                                            <?php }else{
                                                echo "<span style=\"margin-left: -30px;\">a.n. </span><strong>Sekretaris</strong><br>";
                                                echo "<span style=\"margin-left: 20px;\">u.b.</span><br>";
                                                echo '<strong>'.ucfirst(substr($jabatan,0,strpos($jabatan,' pada'))).'</strong>,';
                                            }
                                        }elseif($last_gol >= 'I/a' and $last_gol < 'III/a') {
                                            if($is_plt==0) {
                                                echo '<strong>'.ucfirst(substr($jabatan,0,strpos($jabatan,' pada'))).'</strong>,';
                                                echo "<br><br><br><br><br>"; ?>
                                                <span style="text-decoration: none;font-weight: bold;"><?php echo $nama;?></span><br>
                                                <?php echo $pangkat; ?><br>
                                                NIP. <?php echo $nip; ?>
                                            <?php }else{
                                                echo "<span style=\"margin-left: -30px;\">a.n. </span><strong>Kepala Bidang Formasi, Data, dan Penatausahaan Pegawai</strong><br>";
                                                echo "<span style=\"margin-left: 20px;\">u.b.</span><br>";
                                                echo '<strong>'.ucfirst(substr($jabatan,0,strpos($jabatan,' pada'))).'</strong>,';
                                            }
                                        }else{
                                            echo '<strong>Sekretaris Daerah</strong>,';
                                        }
                                    }
                                    ?>
                                    <br><br><br><br><br>
                                    <span style="text-decoration: none;font-weight: bold;"><?php echo $nama;?></span><br>
                                    <?php echo $pangkat; ?><br>
                                    NIP. <?php echo $nip; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="padding-top: 10px;">
                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 0px;">
                    <tr>
                        <td style="width:60%; text-align: left; vertical-align: top;">
                            <span style="text-decoration: underline; font-weight: bold; margin-bottom: 5px;">Tembusan disampaikan kepada : </span><br>
                            <ol style="margin-left: -20px;margin-top: -10px;">
                                <?php if($eselon_p=='IIB'): ?>
                                <?php else: ?>
                                    <?php if (strpos($jabatan_p, 'Sekretariat Daerah') !== false or strpos($unit, 'Sekretariat Daerah') !== false): ?>
                                    <?php else: ?>
                                        <?php if(strpos($unit, 'Bagian') !== false and $eselon_p=='IIIA'): ?>
                                        <?php else: ?>
                                        <li>Inspektur Kota Bogor;</li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php if($unit=='Inspektorat Kota Bogor'): ?>
                                <?php elseif (strpos($unit, 'Kelurahan') !== false): ?>
                                    <li>Lurah <?php echo substr($unit, strpos($unit, 'Kelurahan')+10,strlen($unit)) ?>;</li>
                                <?php elseif (strpos($unit, 'Kecamatan') !== false): ?>
                                    <li>Camat <?php echo substr($unit, strpos($unit, 'Kecamatan')+10,strlen($unit)) ?>;</li>
                                <?php elseif (strpos($unit, 'Sekretariat Daerah') !== false): ?>
                                    <li>Sekretaris Daerah Kota Bogor;</li>
                                    <li>Inspektur Kota Bogor;</li>
                                <?php elseif (strpos($unit, 'Sekretariat DPRD') !== false): ?>
                                    <li>Sekretaris DPRD Kota Bogor;</li>
                                <?php elseif (strpos($unit, 'Sekretariat KPU') !== false): ?>
                                    <li>Sekretaris KPU Kota Bogor;</li>
                                <?php elseif (strpos($unit, 'RSUD') !== false): ?>
                                    <li>Direktur RSUD Kota Bogor;</li>
                                <?php elseif (strpos($unit, 'UPTD') !== false): ?>
                                    <li>Kepala <?php echo substr($unit, strpos($unit, 'pada')+5,strlen($unit)) ?>;</li>
                                <?php elseif (strpos($unit, 'Bagian') !== false): ?>
                                    <?php if($eselon_p=='IIIA'): ?>
                                        <!--<li>Asisten <?php //echo substr($unit, strpos($unit, 'Bagian')+7,strlen($unit)) ?>;</li>-->
                                        <li>Sekretaris Daerah Kota Bogor</li>
                                        <li>Inspektur Kota Bogor;</li>
                                    <?php else: ?>
                                        <li>Kepala Bagian <?php echo substr($unit, strpos($unit, 'Bagian')+7,strlen($unit)) ?>;</li>
                                    <?php endif ?>
                                <?php else: ?>
                                    <?php if($eselon_p=='IIB'): ?>
                                        <li>Sekretaris Daerah Kota Bogor;</li>
                                        <li>Inspektur Kota Bogor;</li>
                                    <?php else: ?>
                                        <li>Kepala <?php echo $unit ?>;</li>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <li>Pegawai Negeri Sipil yang bersangkutan.</li>
                            </ol>
                        </td>
                        <td style="width:40%; text-align: left; vertical-align: top;">
                            <!-- QR Code -->
                            <?php
                            $qrCode = new QrCode($idp.'-'.$idcuti.'-'.$nipp.'-'.$namap);
                            $qrCode->setSize(110);
                            $qrCode->setWriterByName('png');
                            $qrCode->setMargin(10);
                            $qrCode->setEncoding('UTF-8');
                            $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH);
                            $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0]);
                            $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255]);
                            $qrCode->setLabel('Pindai Kode QR', 6, getcwd().'/images/noto_sans.otf', LabelAlignment::CENTER);
                            $qrCode->setLogoPath(getcwd().'/images/bkpsda.png');
                            $qrCode->setLogoWidth(50);
                            $qrCode->setValidateResult(false);
                            $qrCode->writeFile(getcwd().'/images/qrcode.png');
                            ?>
                            <img src="images/qrcode.png" width="110" height="110">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!--<tr>
            <td colspan="2" style="padding-top: 0px;">

            </td>
        </tr>-->
    </table>

</page>
<?php
$content = ob_get_clean();
try
{
    $html2pdf = new HTML2PDF('P', 'Folio', 'en', true, 'UTF-8', 0);
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('surat_cuti_bkpsda.pdf','F');

    ssh2
}catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>
