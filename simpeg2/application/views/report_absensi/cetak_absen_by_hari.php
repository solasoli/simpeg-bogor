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

?>
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="14mm" style="font-size: 10pt">
<?php if (is_array($rekap_list) && sizeof($rekap_list) > 0): ?>
    <?php
    $x=1;
    $jmlHdr=0;
    $jmlDl=0;
    $jmlC=0;
    $jmlS=0;
    $jmlTK=0;
    $jmlLpsP=0;
    $jmlL=0;
    $jmlTB=0;
    $jmlMPP=0;
    $jmlCLTN=0;
    ?>

    <table border="0" cellspacing="5" cellpadding="0" style="width: 98%;">
        <tr>
            <td style="text-align: center; padding-bottom: 5px;">
                <table border="0" cellspacing="5" cellpadding="0" style="width: 100%;">
                    <tr>
                        <td style="width: 10%;text-align: left;">
                            <img src="<?php echo base_url('images/logokotabogor.gif'); ?>"
                                 style="width: 60px;">
                        </td>
                        <td style="text-align: left; width: 90%;">
                            <span style="font-size: 130%; font-weight: bold;">LAPORAN REKAPITULASI KEHADIRAN</span><br>
                            <span style="font-size: small;line-height: 20px;">Berdasarkan Nama Pegawai dan Tanggal Tertentu</span><br>
                            <?php
                                foreach ($unit_kerja as $lsunit){
                                    $unit = $lsunit->unit;
                                }
                                echo strtoupper($unit);
                            ?><br>
                            PEMERINTAH KOTA BOGOR
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td style="border-top: 1px solid rgba(0,0,0,1); padding-bottom: 10px;"></td>
        </tr>
        <tr>
            <td style="text-align: center;"><span style="font-weight: bold;">Hari/Tanggal :
                    <?php
                    $date = "$thn-$bln-$hari";
                    $nameOfDay = date('N', strtotime($date));
                    echo $this->umum->dayName($nameOfDay).', '.$hari.' '.$this->umum->monthName($bln) . ' ', $thn;
                    ?>
                </span>
            </td>
        </tr>
    </table>

    <table cellspacing="0" cellpadding="0" style="width: 100%; border: 1px solid rgba(0,0,0,0.35);margin-left: 60px;margin-top: 10px;">
        <thead style="display:table-header-group;">
        <tr>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">No</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Nama</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Eselon</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Golongan</td>
            <td style="vertical-align: middle;text-align:center;border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal; width: 30%;">Status</td>
        </tr>
        </thead>
        <?php foreach ($rekap_list as $lsdata): ?>
        <?php
            $varmin = "min_$hari";
            $varmax = "max_$hari";
        ?>
        <tr>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $x;?></td>
            <td style="text-align: left;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->nama.'<br><span style="font-size: 8pt;">'.$lsdata->nip_baru.'</span>'; ?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo ($lsdata->eselon=='Z'?'Staf':$lsdata->eselon);?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->pangkat_gol;?></td>
            <td style="text-align: center;border-top: 1px solid rgba(0,0,0,0.35);">
                <?php
                    if($lsdata->$varmin=='DL'){
                        $lsdata->$varmin = 'Dinas Luar';
                    }elseif($lsdata->$varmin=='C'){
                        $lsdata->$varmin = 'Cuti';
                    }elseif($lsdata->$varmin=='S'){
                        $lsdata->$varmin = 'Sakit';
                    }elseif($lsdata->$varmin=='LP'){
                        $lsdata->$varmin = 'Lepas Piket';
                    }elseif($lsdata->$varmin=='LSA'){
                        $lsdata->$varmin = 'Libur';
                    }elseif($lsdata->$varmin=='LMI'){
                        $lsdata->$varmin = 'Libur';
                    }elseif($lsdata->$varmin=='-MPP-' or $lsdata->$varmin=='-CLTN-'){
                        $lsdata->$varmin = str_replace('-','',$lsdata->$varmin);
                    }elseif($lsdata->$varmin=='-TB-'){
                        $lsdata->$varmin = 'Tugas Belajar';
                    }
                    echo $lsdata->$varmin.(strlen($lsdata->$varmax)<8?'':' - '.$lsdata->$varmax);
                ?>
            </td>
        </tr>
            <?php
            if(strlen($lsdata->$varmax)==8){
                $jmlHdr = $jmlHdr+1;
            }else{
                if($lsdata->$varmax=='DL'){
                    $jmlDl = $jmlDl+1;
                }elseif($lsdata->$varmax=='C'){
                    $jmlC = $jmlC+1;
                }elseif($lsdata->$varmax=='S'){
                    $jmlS = $jmlS+1;
                }elseif($lsdata->$varmax=='-'){
                    $jmlTK = $jmlTK+1;
                }elseif($lsdata->$varmax=='LP'){
                    $jmlLpsP = $jmlLpsP+1;
                }elseif($lsdata->$varmax=='Libur'){
                    $jmlL = $jmlL+1;
                }elseif($lsdata->$varmax=='-TB-'){
                    $jmlTB = $jmlTB+1;
                }elseif($lsdata->$varmax=='-MPP-'){
                    $jmlMPP = $jmlMPP+1;
                }elseif($lsdata->$varmax=='-CLTN-'){
                    $jmlCLTN = $jmlCLTN+1;
                }
            }
            ?>
        <?php $x++;?>
        <?php endforeach; ?>
    </table>
<?php endif; ?>
</page>
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="14mm" style="font-size: 10pt">
    <table cellspacing="0" cellpadding="0" style="width: 85%; border: 1px solid rgba(0,0,0,0.35); margin-left: 30px;">
        <thead style="display:table-header-group;">
        <tr>
            <td colspan="5" style="border-bottom: 1px solid rgba(0,0,0,0.35)">
                <div style="margin-left: 5px; margin-top: 5px; margin-bottom: 5px; font-weight: bold; font-size: 10pt;">
                    Rekapitulasi Absensi Hari/Tanggal: <?php echo $this->umum->dayName($nameOfDay).', '.$hari.' '.$this->umum->monthName($bln) . ' ', $thn; ?><br>
                    <?php echo strtoupper($unit); ?></div>
            </td>
        </tr>
        </thead>
        <tr>
            <td style="width: 10%;padding: 5px;">Hadir</td>
            <td style="width: 3%;padding: 5px;">:</td>
            <td style="width: 6%;padding: 5px;"><?php echo $jmlHdr; ?></td>
            <td style="width: 20%;padding: 5px;"><?php echo round($jmlHdr/($x-1)*100,2).'%'; ?></td>
            <td rowspan="10" style="width: 61%;text-align: right; padding-right: 20px;border-bottom: 1px solid black;">
                <!-- QR Code -->
                <?php
                $qrCode = new QrCode($idskpd.'-'.$bln.'-'.$thn);
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
                <img src="images/qrcode.png" width="100" height="100">
            </td>
        </tr>
        <tr>
            <td style="padding: 5px;">Dinas Luar</td>
            <td style="padding: 5px;">:</td>
            <td style="padding: 5px;"><?php echo $jmlDl; ?></td>
            <td style="width: 20%;padding: 5px;"><?php echo round($jmlDl/($x-1)*100,2).'%'; ?></td>
        </tr>
        <tr>
            <td style="padding: 5px;">Cuti</td>
            <td style="padding: 5px;">:</td>
            <td style="padding: 5px;"><?php echo $jmlC; ?></td>
            <td style="width: 20%;padding: 5px;"><?php echo round($jmlC/($x-1)*100,2).'%'; ?></td>
        </tr>
        <tr>
            <td style="padding: 5px;">Sakit</td>
            <td style="padding: 5px;">:</td>
            <td style="padding: 5px;"><?php echo $jmlS; ?></td>
            <td style="width: 20%;padding: 5px;"><?php echo round($jmlS/($x-1)*100,2).'%'; ?></td>
        </tr>
        <tr>
            <td style="padding: 5px;">Lepas Piket</td>
            <td style="padding: 5px;">:</td>
            <td style="padding: 5px;"><?php echo $jmlLpsP; ?></td>
            <td style="width: 20%;padding: 5px;"><?php echo round($jmlLpsP/($x-1)*100,2).'%'; ?></td>
        </tr>
        <tr>
            <td style="padding: 5px;">Libur</td>
            <td style="padding: 5px;">:</td>
            <td style="padding: 5px;"><?php echo $jmlL; ?></td>
            <td style="width: 20%;padding: 5px;"><?php echo round($jmlL/($x-1)*100,2).'%'; ?></td>
        </tr>
        <tr>
            <td style="padding: 5px;">Tanpa Keterangan</td>
            <td style="padding: 5px;">:</td>
            <td style="padding: 5px;"><?php echo $jmlTK; ?></td>
            <td style="width: 20%;padding: 5px;"><?php echo round($jmlTK/($x-1)*100,2).'%'; ?></td>
        </tr>
        <tr>
            <td style="padding: 5px;">Tugas Belajar</td>
            <td style="padding: 5px;">:</td>
            <td style="padding: 5px;"><?php echo $jmlTB; ?></td>
            <td style="width: 20%;padding: 5px;"><?php echo round($jmlTB/($x-1)*100,2).'%'; ?></td>
        </tr>
        <tr>
            <td style="padding: 5px;">MPP</td>
            <td style="padding: 5px;">:</td>
            <td style="padding: 5px;"><?php echo $jmlMPP; ?></td>
            <td style="width: 20%;padding: 5px;"><?php echo round($jmlMPP/($x-1)*100,2).'%'; ?></td>
        </tr>
        <tr>
            <td style="padding: 5px;"> CLTN</td>
            <td style="padding: 5px;">:</td>
            <td style="padding: 5px;"><?php echo $jmlCLTN; ?></td>
            <td style="width: 20%;padding: 5px;"><?php echo round($jmlCLTN/($x-1)*100,2).'%'; ?></td>
        </tr>
        <tr>
            <td style="padding: 5px;border-top: 1px solid black;">Jumlah</td>
            <td style="padding: 5px;border-top: 1px solid black;">:</td>
            <td style="padding: 5px;border-top: 1px solid black;"><?php echo $x-1; ?> Orang</td>
            <td style="padding: 5px;border-top: 1px solid black;"></td>
        </tr>
    </table>

    <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 20px; margin-left: 30px;">
        <td style="width:40%; text-align: left; vertical-align: top;">

        </td>
    </table>
</page>

<?php
$content = ob_get_clean();
try {
    $html2pdf = new HTML2PDF('P', 'Legal', 'en', true, 'UTF-8', 0);
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('absensi_by_hari.pdf');
}catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>