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
<page backtop="14mm" backbottom="10mm" backleft="10mm" backright="14mm" style="font-size: 10pt">
<?php if (is_array($rekap_jumlah) && sizeof($rekap_jumlah) > 0): ?>
    <?php $x=1;?>
    <?php foreach ($rekap_jumlah as $lsdata): ?>
    <table border="0" cellspacing="5" cellpadding="0" style="width: 98%;">
        <tr>
            <td colspan="3" style="text-align: center; padding-bottom: 5px;">
                <table border="0" cellspacing="5" cellpadding="0" style="width: 100%;">
                    <tr>
                        <td style="width: 10%;text-align: left;">
                            <img src="<?php echo base_url('images/logokotabogor.gif'); ?>"
                                 style="width: 60px;">
                        </td>
                        <td style="text-align: left;width: 75%;">
                            <span style="font-size: 130%; font-weight: bold;">LAPORAN REKAPITULASI KEHADIRAN</span><br>
                            <span style="font-size: small;line-height: 20px;">Berdasarkan Tanggal dan Status Kehadiran</span><br>
                            <?php echo strtoupper($lsdata->opd==$lsdata->unit?$lsdata->opd:$lsdata->unit); ?><br>
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
            <td colspan="3" style="border-top: 1px solid rgba(0,0,0,1); padding-bottom: 10px;"></td>
        </tr>
        <tr>
            <td style="width: 25%">Periode</td>
            <td style="width: 3%">:</td>
            <td style="width: 72%"><?php echo $this->umum->monthName($bln) . ' ', $thn; ?></td>
        </tr>
        <tr>
            <td style="width: 25%">Jumlah Pegawai</td>
            <td style="width: 3%">:</td>
            <td style="width: 72%"><?php echo $lsdata->jml_pegawai; ?> orang</td>
        </tr>
        <tr>
            <td style="width: 25%">Jumlah Hari Kerja</td>
            <td style="width: 3%">:</td>
            <td style="width: 72%"><?php echo $lsdata->jml_hari_kerja; ?> hari
                (Minggu: <?php echo $lsdata->jml_minggu; ?>, Sabtu: <?php echo $lsdata->jml_sabtu; ?>, CB Sabtu: <?php echo $lsdata->jml_cb_sabtu; ?>,
                CB Hari Kerja: <?php echo $lsdata->jml_cb_harikerja; ?>, LN Sabtu: <?php echo $lsdata->jml_ln_sabtu; ?>,
                LN Hari Kerja: <?php echo $lsdata->jml_ln_harikerja; ?>)
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: center; padding-top: 10px;padding-left: 0px;">
                <table cellspacing="0" cellpadding="0" style="width: 100%; border: 1px solid rgba(0,0,0,0.35)">
                    <tr>
                        <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Tanggal</td>
                        <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Hari</td>
                        <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Hadir</td>
                        <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Dinas Luar</td>
                        <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Cuti</td>
                        <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Sakit</td>
                        <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Tanpa Ket.</td>
                        <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Lepas Piket</td>
                        <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Libur</td>
                        <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">TB</td>
                        <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">MPP</td>
                        <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">CLTN</td>
                        <td style="vertical-align: middle;text-align:center;border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">Jumlah</td>
                    </tr>
                    <?php for ($x = 1; $x <= $maxday; $x++): ?>
                        <?php
                        $varHdr = "jml_hdr_$x";
                        $varDL = "jml_DL_$x";
                        $varC = "jml_C_$x";
                        $varS = "jml_S_$x";
                        $varTK = "jml_TK_$x";
                        $varLP = "jml_LP_$x";
                        $varLbr = "jml_Lbr_$x";
                        $varTb = "jml_Tb_$x";
                        $varMpp = "jml_Mpp_$x";
                        $varCltn = "jml_Cltn_$x";
                        ?>
                        <tr>
                            <?php
                                $date = "$thn-$bln-$x";
                                $nameOfDay = date('N', strtotime($date));
                            ?>
                            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $x;?></td>
                            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $this->umum->dayName($nameOfDay);?></td>
                            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->$varHdr; ?></td>
                            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->$varDL; ?></td>
                            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->$varC; ?></td>
                            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->$varS; ?></td>
                            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->$varTK; ?></td>
                            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->$varLP; ?></td>
                            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->$varLbr; ?></td>
                            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->$varTb; ?></td>
                            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->$varMpp; ?></td>
                            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->$varCltn; ?></td>
                            <td style="text-align: center;padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo($lsdata->$varHdr+$lsdata->$varDL+$lsdata->$varC+$lsdata->$varS+$lsdata->$varTK+$lsdata->$varLP+$lsdata->$varLbr); ?></td>
                        </tr>
                    <?php endfor; ?>
                    <tr>
                        <td colspan="2" style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);">Jumlah</td>
                        <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->jml_hadir; ?></td>
                        <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->jml_dinas_luar; ?></td>
                        <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->jml_cuti; ?></td>
                        <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->jml_sakit; ?></td>
                        <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->jml_tanpa_ket; ?></td>
                        <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->jml_lps_piket; ?></td>
                        <td style="text-align: center;padding: 5px;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->jml_libur; ?></td>
                        <td style="text-align: center;padding: 5px;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->jml_tb; ?></td>
                        <td style="text-align: center;padding: 5px;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->jml_mpp; ?></td>
                        <td style="text-align: center;padding: 5px;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->jml_cltn; ?></td>
                        <td style="text-align: center;padding: 5px;padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);">Persentase</td>
                        <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo round(($lsdata->jml_hadir/$lsdata->jml_hari_kerja)*100,2);?>%</td>
                        <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo round(($lsdata->jml_dinas_luar/$lsdata->jml_hari_kerja)*100,2);?>%</td>
                        <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo round(($lsdata->jml_cuti/$lsdata->jml_hari_kerja)*100,2);?>%</td>
                        <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo round(($lsdata->jml_sakit/$lsdata->jml_hari_kerja)*100,2);?>%</td>
                        <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo round(($lsdata->jml_tanpa_ket/$lsdata->jml_hari_kerja)*100,2);?>%</td>
                        <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo round(($lsdata->jml_lps_piket/$lsdata->jml_hari_kerja)*100,2);?>%</td>
                        <td style="text-align: center;padding: 5px;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo round(($lsdata->jml_libur/$lsdata->jml_hari_kerja)*100,2);?>%</td>
                        <td style="text-align: center;padding: 5px;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo round(($lsdata->jml_tb/$lsdata->jml_hari_kerja)*100,2);?>%</td>
                        <td style="text-align: center;padding: 5px;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo round(($lsdata->jml_mpp/$lsdata->jml_hari_kerja)*100,2);?>%</td>
                        <td style="text-align: center;padding: 5px;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo round(($lsdata->jml_cltn/$lsdata->jml_hari_kerja)*100,2);?>%</td>
                        <td style="text-align: center;padding: 5px;padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"></td>
                    </tr>
                </table>

                <!--<table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 20px;">
                    <td style="width:40%; text-align: left; vertical-align: top;">

                    </td>
                </table>-->
            </td>
        </tr>
    </table>
    <?php endforeach; ?>
<?php endif; ?>
</page>

<?php
$content = ob_get_clean();
try {
    $html2pdf = new HTML2PDF('P', 'Legal', 'en', true, 'UTF-8', 0);
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('absensi_rekap_jumlah.pdf');
}catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>