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
<?php if (isset($knjmaster) and sizeof($knjmaster) > 0 and $knjmaster != ''){?>
    <?php
        foreach ($knjmaster as $lsdata) {
            $bln = $lsdata->periode_bln;
            $thn = $lsdata->periode_thn;
            $namap = $lsdata->nama;
            $jabp = $lsdata->last_jabatan;
            $nip = $lsdata->nip_baru;
            $atsl_nm = $lsdata->last_atsl_nama;
            $atsl_jab = $lsdata->last_atsl_jabatan;
            $atsl_nip = (is_numeric($lsdata->last_atsl_nip)?$lsdata->last_atsl_nip:'-');
        }
    ?>
    <?php if (isset($list_kegiatan) and sizeof($list_kegiatan) > 0 and $list_kegiatan != ''){?>
        <div style="margin-bottom: 10px; font-weight: bold; font-size: 11pt;">Daftar Aktifitas Laporan E-Kinerja Periode <?php echo $this->umum->monthName($bln).' ',$thn; ?> - <?php echo $namap; ?></div>
        <table cellspacing="0" cellpadding="0" style="width: 100%; border: 1px solid rgba(0,0,0,0.35);">
            <thead style="display:table-header-group;">
            <tr>
                <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">No</td>
                <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">Tanggal</td>
                <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold; max-width: 25%;">Kategori Kegiatan</td>
                <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold; max-width: 45%;">Rincian</td>
                <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">Waktu</td>
                <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">Durasi<br>(Menit)</td>
                <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold; font-weight: bold;">Kuantitas</td>
                <td style="vertical-align: middle;text-align:center; border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold; max-width: 7%">Satuan</td>
            </tr>
            </thead>
            <?php $i = 1; ?>
            <?php foreach ($list_kegiatan as $lsdata2): ?>
                <?php
                    $tgl_kegiatan = explode(' ', $lsdata2->kegiatan_tanggal2);
                ?>
                <tr>
                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                        <?php echo $i; ?></td>
                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                        <?php echo $tgl_kegiatan[0]; ?></td>
                    <td style="text-align: left;border-right: 1px solid rgba(0,0,0,0.35);border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                        <?php echo smart_wordwrap(addslashes($lsdata2->kegiatan), 50); ?></td>
                    <td style="text-align: left;border-right: 1px solid rgba(0,0,0,0.35);border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                        <?php echo smart_wordwrap(addslashes($lsdata2->kegiatan_rincian2), 90); ?>
                        <?php if($lsdata2->kegiatan_keterangan!='' and $lsdata2->kegiatan_keterangan!='-'):?>
                            <br><?php echo smart_wordwrap(addslashes($lsdata2->kegiatan_keterangan), 90); ?>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                        <?php echo $tgl_kegiatan[1]; ?></td>
                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                        <?php echo $lsdata2->durasi_menit; ?></td>
                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                        <?php echo $lsdata2->kuantitas; ?></td>
                    <td style="text-align: center;border-bottom: 1px solid rgba(0,0,0,0.35);padding: 5px;vertical-align: top;">
                        <?php echo $lsdata2->satuan; ?></td>
                </tr>
                <?php $i++; ?>
            <?php endforeach; ?>
        </table>

        <?php
        $is_plh = false;
        if (isset($ttd) and sizeof($ttd) > 0 and $ttd != '') {
            foreach ($ttd as $ttd2){
                if($ttd2->atsl_nama_plh<>''){
                    $atsl_nm = $ttd2->atsl_nama_plh;
                    $atsl_nip = $ttd2->atsl_nip_plh;
                    $atsl_jab = $ttd2->atsl_jabatan_plh;
                    $is_plh = true;
                }
            }
        }
        ?>

        <table border="0" cellspacing="5" cellpadding="0" style="width: 98%;margin-top: 70px;">
            <tr>
                <td style="width: 40%;text-align: left;vertical-align: top;">
                    Menyetujui,<br><?php echo ($is_plh==true?'PLH. ':''); ?>Atasan Langsung,<br><br><br><br><br><br><br><br>
                    <span style="font-weight: bold; text-decoration: underline;"><?php echo $atsl_nm; ?></span><br>
                    <?php echo smart_wordwrap(ucwords(strtolower($atsl_jab)), 50); ?><br>NIP. <?php echo $atsl_nip; ?>
                </td>
                <td style="width: 30%;text-align: left;vertical-align: top;">

                </td>
                <td style="width: 30%;text-align: left;vertical-align: top;">
                    Bogor,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->umum->monthName(date('m')).' '.date('Y'); ?><br>
                    ASN yang dinilai,<br><br><br><br><br><br><br><br>
                    <span style="font-weight: bold; text-decoration: underline;"><?php echo $namap; ?></span><br>
                    <?php echo ucwords(strtolower($jabp)); ?><br>NIP. <?php echo $nip; ?>
                </td>
            </tr>
        </table>
        <?php }else{
            echo 'Data tidak ditemukan';
        }
}else{
    echo 'Data tidak ditemukan';
} ?>
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
        $html2pdf = new HTML2PDF('P', 'Legal', 'en', true, 'UTF-8', 0);
        $html2pdf->pdf->setTitle('Cetak Laporan Aktifitas Kinerja');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('Cetak_Laporan_Kinerja.pdf');
    }catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
