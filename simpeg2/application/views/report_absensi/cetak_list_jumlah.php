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
    <table border="0" cellspacing="5" cellpadding="0" style="width: 98%;">
        <tr>
            <td style="text-align: center; padding-bottom: 5px;">
                <table border="0" cellspacing="5" cellpadding="0" style="width: 100%;">
                    <tr>
                        <td style="width: 5%;text-align: left;">
                            <img src="<?php echo base_url('images/logokotabogor.gif'); ?>"
                                 style="width: 60px;">
                        </td>
                        <td style="text-align: left; width: 85%;">
                            <span style="font-size: 130%; font-weight: bold;">LAPORAN REKAPITULASI KEHADIRAN</span><br>
                            <span style="font-size: small;line-height: 20px;">Berdasarkan Nama Pegawai dan Status Kehadiran</span><br>
                            <?php
                            foreach ($unit_kerja as $lsunit){
                                $unit = $lsunit->unit;
                            }
                            echo strtoupper($unit);
                            ?><br>
                            PEMERINTAH KOTA BOGOR
                        </td>
                        <td style="text-align: left; width: 10%;">
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
                </table>
            </td>
        </tr>
        <tr>
            <td style="border-top: 1px solid rgba(0,0,0,1); padding-bottom: 10px;"></td>
        </tr>
        <tr>
            <td style="text-align: center;">
                <span style="font-weight: bold;">Periode: <?php echo $this->umum->monthName($bln) . ' ', $thn;?> (Berds. Rekapitulasi Status Kehadiran)</span>
            </td>
        </tr>
    </table>
    <?php $i=1;?>
    <table cellspacing="0" cellpadding="0" style="width: 100%; border: 1px solid rgba(0,0,0,0.35);margin-top: 8px;margin-left: 10px;">
        <thead style="display:table-header-group;">
        <tr>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">No</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Nama</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Esl</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Gol</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Hadir</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Dinas<br>Luar</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Cuti</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Sakit</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Tanpa<br>Keterangan</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Lepas<br>Piket</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Libur</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Tugas<br>Belajar</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">MPP</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">CLTN</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Standar<br>Kerja</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Sabtu</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Minggu</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">CB<br>Sabtu</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">CB<br>Hari Kerja</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">LN<br>Sabtu</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">LN<br>Hari Kerja</td>
            <td style="vertical-align: middle;text-align:center;border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Hari Kerja</td>
        </tr>
        </thead>
        <?php foreach ($rekap_list as $lsdata): ?>
        <tr>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $i;?></td>
            <td style="text-align: left;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo smart_wordwrap($lsdata->nama,50).'<br><span style="font-size: 8pt;">'.$lsdata->nip_baru.'</span>'; ?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo ($lsdata->eselon=='Z'?'Staf':$lsdata->eselon);?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $lsdata->pangkat_gol;?></td>
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
        <?php for ($x = 1; $x <= $maxday; $x++): ?>
            <?php
                $varmin = "min_$x";
                $varmax = "max_$x";
            ?>
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
        <?php endfor; ?>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $jmlHdr;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $jmlDl;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $jmlC;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $jmlS;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $jmlTK;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $jmlLpsP;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $jmlL;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $jmlTB;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $jmlMPP;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $jmlCLTN;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $lsdata->jml_std_kerja;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $lsdata->jml_sabtu;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $lsdata->jml_minggu;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $lsdata->jml_cb_sabtu;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $lsdata->jml_cb_harikerja;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $lsdata->jml_ln_sabtu;?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $lsdata->jml_ln_harikerja;?></td>
            <td style="text-align: center;padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);font-size: 8pt;"><?php echo $lsdata->jml_hari_kerja;?></td>
        </tr>
        <?php $i++;?>
    <?php endforeach; ?>
    </table>
    <!--<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 20px; margin-left: 30px;">
        <td style="width:40%; text-align: left; vertical-align: top;">

        </td>
    </table>-->
<?php endif; ?>
    </page>

<?php
function smart_wordwrap($string, $width = 75, $break = "<br>") {
    // split on problem words over the line length
    $pattern = sprintf('/([^ ]{%d,})/', $width);
    $output = '';
    $words = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    foreach ($words as $word) {
        // normal behaviour, rebuild the string
        if (false !== strpos($word, ' ')) {
            $output .= $word;
        } else {
            // work out how many characters would be on the current line
            $wrapped = explode($break, wordwrap($output, $width, $break));
            $count = $width - (strlen(end($wrapped)) % $width);

            // fill the current line and add a break
            $output .= substr($word, 0, $count) . $break;

            // wrap any remaining characters from the problem word
            $output .= wordwrap(substr($word, $count), $width, $break, true);
        }
    }

    // wrap the final output
    return wordwrap($output, $width, $break);
}

$content = ob_get_clean();
try {
    $html2pdf = new HTML2PDF('L', 'Legal', 'en', true, 'UTF-8', 0);
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('absensi_list_jumlah.pdf');
}catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>