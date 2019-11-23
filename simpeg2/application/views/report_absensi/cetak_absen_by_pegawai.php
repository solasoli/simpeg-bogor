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
                            <td style="text-align: left; width: 95%;">
                                <span style="font-size: 130%; font-weight: bold;">LAPORAN KEHADIRAN PEGAWAI</span><br>
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
                <td style="text-align: center;">
                <?php if (is_array($infoPegawai) && sizeof($infoPegawai) > 0): ?>
                    <?php foreach ($infoPegawai as $lsinfo): ?>
                    <table border="0" cellspacing="10" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td style="width: 20%;" rowspan="7">
                                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
                                    <td style="width:40%; text-align: left; vertical-align: top;">
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
                                </table>
                            </td>
                            <td style="width: 15%; text-align: left;vertical-align: top;">Nama</td>
                            <td style="width: 5%;vertical-align: top;">:</td>
                            <td style="width: 45%;text-align: left;"><strong><?php echo $lsinfo->nama; ?></strong></td>
                        </tr>
                        <tr>
                            <td style="width: 15%; text-align: left;">NIP</td>
                            <td style="width: 5%;vertical-align: top;">:</td>
                            <td style="width: 55%;text-align: left;"><?php echo $lsinfo->nip_baru; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 15%; text-align: left;">Gol. Ruang</td>
                            <td style="width: 5%;vertical-align: top;">:</td>
                            <td style="width: 55%;text-align: left;"><?php echo $lsinfo->pangkat_gol; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 15%; text-align: left;vertical-align: top;">Jenjang</td>
                            <td style="width: 5%;vertical-align: top;">:</td>
                            <td style="width: 55%;text-align: left;"><?php echo $lsinfo->jenjab; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 15%; text-align: left;vertical-align: top;">Jabatan</td>
                            <td style="width: 5%;vertical-align: top;">:</td>
                            <td style="width: 55%;text-align: left;"><?php echo $lsinfo->jabatan; ?></td>
                        </tr>
                        <?php if($lsinfo->eselon!='Staf'): ?>
                            <tr>
                                <td style="width: 15%; text-align: left;vertical-align: top;">Eselon</td>
                                <td style="width: 5%;vertical-align: top;">:</td>
                                <td style="width: 55%;text-align: left;"><?php echo $lsinfo->eselon; ?></td>
                            </tr>
                        <?php endif; ?>
                        <tr>
                            <td style="width: 15%; text-align: left;vertical-align: top;">Periode</td>
                            <td style="width: 5%;vertical-align: top;">:</td>
                            <td style="width: 55%;text-align: left;"><?php echo $this->umum->monthName($bln) . ' ', $thn;?></td>
                        </tr>
                    </table>
                    <?php endforeach; ?>
                <?php endif; ?>
                </td>
            </tr>
        </table>

        <table cellspacing="0" cellpadding="0" style="width: 100%; border: 1px solid rgba(0,0,0,0.35); margin-left: 170px;">
            <tr>
                <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Tanggal</td>
                <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Hari</td>
                <td style="vertical-align: middle;text-align:center;border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;width: 35%;">Status Kehadiran</td>
            </tr>
            <?php foreach ($rekap_list as $lsdata): ?>
            <?php for ($x = 1; $x <= $maxday; $x++): ?>
            <tr>
                <?php
                    $date = "$thn-$bln-$x";
                    $nameOfDay = date('N', strtotime($date));
                    $varmin = "min_$x";
                    $varmax = "max_$x";
                ?>
                <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $x;?></td>
                <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $this->umum->dayName($nameOfDay);?></td>
                <td style="text-align: center;padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);">
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
                        }
                        echo (($lsdata->$varmin=='LSA' or $lsdata->$varmin=='LMI' or $lsdata->$varmin=='CB' or $lsdata->$varmin=='LN')?"<span style='color: darkred'>".$lsdata->$varmin."</span>":(strlen($lsdata->$varmin)==8?substr($lsdata->$varmin,0,strlen($lsdata->$varmin)-3):$lsdata->$varmin)).(strlen($lsdata->$varmax)<8?'':' - '.(strlen($lsdata->$varmax)==8?substr($lsdata->$varmax,0,strlen($lsdata->$varmax)-3):$lsdata->$varmax));
                    ?>
            </td>
            </tr>
            <?php endfor; ?>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
    </page>

<?php
$content = ob_get_clean();
try {
    $html2pdf = new HTML2PDF('P', 'Legal', 'en', true, 'UTF-8', 0);
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('absensi_by_pegawai.pdf');
}catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>