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


<page orientation="L" backtop="14mm" backbottom="14mm" backleft="14mm" backright="10mm" style="font-size: 9pt">
    <?php if (isset($drop_data) and sizeof($drop_data) > 0 and $drop_data != ''){?>

    <table border="0" cellspacing="5" cellpadding="0" style="width: 100%;">
        <tr>
            <td style="width: 5%;text-align: left;">
                <img src="<?php echo base_url('assets/images/logokotabogor.gif'); ?>" style="width: 60px;">
            </td>
            <td style="width: 80%;text-align: left">
                <div style="margin-bottom: 5px; font-weight: bold; font-size: 10pt;">PEMERINTAH KOTA BOGOR</div>
                <div style="margin-bottom: 5px; font-weight: bold; font-size: 10pt;"><?php echo strtoupper($unit_kerja); ?></div>
                <div style="margin-bottom: 5px; font-weight: bold; font-size: 12pt;">Rekapitulasi Laporan E-Kinerja Periode <?php echo $this->umum->monthName($bln).' ',$thn; ?> </div>
            </td>
        </tr>
    </table>

    <table cellspacing="0" cellpadding="0" style="width: 100%; border: 1px solid rgba(0,0,0,0.35);">
        <thead style="display:table-header-group;">
        <tr>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">No</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;max-width: 10%;"">Nama</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold; max-width: 10%;">NIP</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold; max-width: 5%;">Gol.</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold; max-width: 30%;">Jabatan</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">Target<br>Kinerja</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold; font-weight: bold;max-width: 30%;">Target<br>Kedisiplinan</td>
            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold; font-weight: bold;">Detail</td>
            <td style="vertical-align: middle;text-align:center; border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">Tunjangan</td>
        </tr>
        </thead>
        <?php
            $i = 1;
            $total = 0;
        ?>
        <?php foreach ($drop_data as $lsdata): ?>
        <tr>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                <?php echo $i; ?></td>
            <td style="text-align: left;border-right: 1px solid rgba(0,0,0,0.35);border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                <?php echo smart_wordwrap($lsdata->nama, 25); ?></td>
            <td style="text-align: left;border-right: 1px solid rgba(0,0,0,0.35);border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                <?php echo smart_wordwrap($lsdata->nip_baru, 20); ?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                <?php echo $lsdata->pangkat_gol; ?></td>
            <td style="text-align: left;border-right: 1px solid rgba(0,0,0,0.35);border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                <?php echo smart_wordwrap(substr($lsdata->last_jabatan,0,(strpos($lsdata->last_jabatan,'pada')==0?strlen($lsdata->last_jabatan):strpos($lsdata->last_jabatan,'pada'))).' ('.$lsdata->last_kode_jabatan.')', 30); ?><br>
                Jenjang <?php echo $lsdata->last_jenjab.($lsdata->last_eselon!='Staf'?' ('.$lsdata->last_eselon.')':''); ?><br>
                <?php echo $lsdata->kelas_jabatan; ?><br>
                Atasan Langsung : <?php echo $lsdata->last_atsl_nama; ?>
            </td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                <?php echo number_format($lsdata->rupiah_awal_kinerja,0,",","."); ?></td>
            <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                <?php echo number_format($lsdata->rupiah_awal_disiplin,0,",","."); ?></td>
            <td style="text-align: left;border-right: 1px solid rgba(0,0,0,0.35);border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                Waktu efektif kerja : <?php echo $lsdata->jml_menit_efektif_kerja; ?> menit <br>
                Waktu kinerja : <?php echo $lsdata->jml_waktu_kinerja_accu; ?> menit (<?php echo $lsdata->persen_kinerja_accu; ?>%) =
                Rp. <?php echo number_format($lsdata->rupiah_kinerja,0,",","."); ?>
                <?php if($lsdata->last_eselon!='Staf'): ?>
                    <br>Staf aktual : <?php echo $lsdata->jml_bawahan_aktual; ?> orang
                    <br>Staf eKinerja : <?php echo $lsdata->jml_bawahan_kinerja; ?> orang. Kinerja <?php echo number_format($lsdata->persen_kinerja_accu_bawahan, 0,",","."); ?> %
                    <br>Kinerja staf aktual : <?php echo number_format($lsdata->persen_kinerja_bawahan_aktual,0,",","."); ?>%
                    <br>Kinerja aktual : <?php echo number_format($lsdata->persen_kinerja_aktual,0,",","."); ?>% =
                    Rp. <?php echo number_format($lsdata->rupiah_kinerja_aktual,0,",","."); ?>
                <?php endif; ?>
                <br>Hari efektif kerja : <?php echo $lsdata->jml_hari_efektif_kerja; ?> |
                Kehadiran : <?php echo $lsdata->jml_kehadiran_accu; ?> (<?php echo $lsdata->persen_kehadiran_accu; ?>%)
                <br>Tidak hadir : <?php echo $lsdata->jml_tidak_hadir_accu; ?> (<?php echo $lsdata->persen_minus_tidak_hadir_accu; ?>%)
                <br>Terlambat / pulang cepat : <?php echo $lsdata->persen_minus_terlambat_plg_cpt_accu; ?>%
                <br>Hari efektif apel : <?php echo $lsdata->jml_hari_efektif_apel; ?> |
                Tidak apel : <?php echo $lsdata->jml_tidak_apel_accu; ?> (<?php echo $lsdata->persen_minus_tidak_apel_accu; ?>%)
                <br>Nilai Kedisiplinan : <?php echo number_format($lsdata->persen_disiplin_final,2,".","."); ?>% = Rp. <?php echo number_format($lsdata->rupiah_disiplin,0,",","."); ?>
                <br><?php echo smart_wordwrap(
                "Unsur lainnya :".
                " Penambahan : ".$lsdata->jumlah_penambahan_item_lain." (".$lsdata->persen_penambahan_item_lain."%)".
                ", Pengurangan disiplin : ".$lsdata->jumlah_pengurangan_item_lain." (".number_format($lsdata->persen_pengurangan_item_lain,0,".",".")."%) = ".
                "Rp. ".number_format((($lsdata->persen_pengurangan_item_lain/100)*$lsdata->last_rupiah_disiplin),0,",",".").
                ", Pengurangan dari total : ".number_format($lsdata->jumlah_pengurangan_item_lain_maks,0,".",".")." (".number_format($lsdata->persen_pengurangan_item_lain_maks,0,".",".")."%) = ".
                "Rp. ".number_format((($lsdata->persen_pengurangan_item_lain_maks/100)*$lsdata->rupiah_kinerja_final),0,",","."), 50); ?>
            </td>
            <td style="text-align: center;border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                <?php echo number_format($lsdata->last_rupiah_kinerja_final,0,",","."); ?></td>
        </tr>
        <?php
            $i++;
            $total = $total + $lsdata->last_rupiah_kinerja_final;
        ?>
            <?php endforeach; ?>
        <tr>
            <td colspan="9" style="text-align: right; font-weight: bold; padding: 5px;">
                Total : Rp. <?php echo number_format($total,0,",","."); ?>,-
            </td>
        </tr>
    </table>
    <?php }else{
            echo 'Data tidak ditemukan';
        }
        ?><br><br><br><br>
    <table cellspacing="0" cellpadding="0" style="width: 100%; border: 0px solid rgba(0,0,0,0.35);font-size: 10pt;">
        <tr>
            <td style="text-align: center; width: 50%;">
                Mengetahui,<br>
                <?php if (isset($kepala) and sizeof($kepala) > 0 and $kepala != ''){?>
                    <?php foreach ($kepala as $lskepala): ?>
                        <?php
                            if($isWakilKepala==1){
                                echo 'A.n. ';
                            }
                        ?>
                        <?php echo smart_wordwrap(ucwords(strtolower($lskepala->jabatan)), 80); ?><br><br><br><br><br><br>
                        <span style="font-weight: bold; text-decoration: underline"><?php echo $lskepala->nama; ?></span><br>
                        <?php echo $lskepala->pangkat; ?><br>
                        NIP. <?php echo $lskepala->nip_baru; ?>
                    <?php endforeach; ?>
                <?php }else{
                    echo 'Data kepala tidak ditemukan';
                }
                ?>
            </td>
            <td style="text-align: center; width: 50%;">
                Bendahara,<br>
                <?php if (isset($bendahara) and sizeof($bendahara) > 0 and $bendahara != ''){?>
                    <?php foreach ($bendahara as $lsbendahara): ?>
                        <?php
                        if($isWakilBendahara==1){
                            echo 'A.n. ';
                        }
                        ?>
                        <?php echo smart_wordwrap(ucwords(strtolower($lsbendahara->jabatan)), 80); ?><br><br><br><br><br><br>
                        <span style="font-weight: bold; text-decoration: underline"><?php echo $lsbendahara->nama; ?></span><br>
                        <?php echo $lsbendahara->pangkat; ?><br>
                        NIP. <?php echo $lsbendahara->nip_baru; ?>
                    <?php endforeach; ?>
                <?php }else{
                    echo 'Data kepala tidak ditemukan';
                }
                ?>
            </td>
        </tr>
    </table>
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
try
{
    $html2pdf = new HTML2PDF('L', 'Legal', 'en', true, 'UTF-8', 0);
    $html2pdf->pdf->setTitle('Cetak Laporan Nominatif OPD');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('Cetak_Laporan_Nominatif.pdf');
}catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>
