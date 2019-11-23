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

$sql = "SELECT id_baperjakat, no_sk, DATE_FORMAT(tgl_pengesahan,  '%d/%m/%Y') as tgl_pengesahan,
                wkt_pengesahan, ruang_pengesahan
                FROM draft_pelantikan_pengesahan WHERE id_draft = $id_draft";
$query = $this->db->query($sql);
$dataPengesahan = null;
foreach ($query->result() as $row) {
    $dataPengesahan = $row;
}
if(isset($dataPengesahan->id_baperjakat) == FALSE){
    $message = 'Pengaturan pengesahan masih kosong';
    echo "<script type='text/javascript'>alert('$message');window.close();</script>";
    die();
}

$sql = "select * from baperjakat where id_baperjakat = $dataPengesahan->id_baperjakat";
$query = $this->db->query($sql);
$dataBaperjakat = null;
foreach ($query->result() as $row) {
    $dataBaperjakat = $row;
}
$sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, j.jabatan
                FROM baperjakat_detail bd, pegawai p, jabatan j
                WHERE bd.idpegawai = p.id_pegawai AND bd.id_j = j.id_j AND bd.id_baperjakat = $dataBaperjakat->id_baperjakat
                ORDER BY bd.idstatus_keanggotaan ASC";

$query = $this->db->query($sql);
$dataDetailBaperjakat = null;
$i = 0;
foreach ($query->result() as $row) {
    $dataDetailBaperjakat[$i] = $row;
    $i++;
}

$parseTglPengesahan = explode("/", $dataPengesahan->tgl_pengesahan);
$tglPengesahan = $parseTglPengesahan[0];
$blnPengesahan = $this->terbilang->getNamaBulan($parseTglPengesahan[1]);
$thnPengesahan = $parseTglPengesahan[2];
$hari = $this->terbilang->getNamaHari($parseTglPengesahan[2].'/'.$parseTglPengesahan[1].'/'.$parseTglPengesahan[0]);

$sql = "SELECT
      draft_struktural.nip,
      draft_struktural.gelar_depan, draft_struktural.nama, draft_struktural.gelar_belakang,
      draft_struktural.tgl_lahir, draft_struktural.pangkat_gol, draft_struktural.pangkat,
      draft_struktural.jabatan_baru, draft_struktural.unit_baru, draft_struktural.eselon_baru,
      CASE WHEN draft_struktural.jabatan_lama IS NULL THEN
        CONCAT('Fungsional Umum pada ', draft_struktural.unit_lama)
      ELSE
        (CASE WHEN draft_struktural.eselon_lama IS NULL THEN CONCAT(draft_struktural.jabatan_lama,' pada ',draft_struktural.unit_lama)
        ELSE draft_struktural.jabatan_lama END)
      END AS jabatan_lama,
      draft_struktural.unit_lama, draft_struktural.eselon_lama FROM (SELECT
          jab_baru.id_draft, p.nip_baru AS nip,
             p.gelar_depan,
             p.nama,
             p.gelar_belakang,
             DATE_FORMAT(p.tgl_lahir,  '%d/%m/%Y') AS tgl_lahir,
             p.pangkat_gol,
             g.pangkat,
             jab_baru.jabatan_baru,
             jab_baru.unit_baru,
             jab_baru.eselon_baru,
             CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
            (SELECT jm.nama_jfu AS jabatan
             FROM jfu_pegawai jp, jfu_master jm
             WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
            ELSE j.jabatan END END AS jabatan_lama,
             ukl.nama_baru AS unit_lama,
             j.eselon AS eselon_lama
        FROM (SELECT
                 dpdl.id_draft,
                 dj_baru.idp_baru AS idpegawai,
                 dj_baru.idj_baru,
                 dpdl.id_j AS idj_lama,
                 j.jabatan AS jabatan_baru,
                 uk.nama_baru AS unit_baru,
                 j.eselon AS eselon_baru
               FROM (SELECT
                        dpd.id_j AS idj_baru,
                        dpd.id_pegawai AS idp_baru
                      FROM draft_pelantikan_detail dpd
                      WHERE (dpd.id_pegawai <> dpd.id_pegawai_awal OR (dpd.id_pegawai IS NOT NULL AND dpd.id_pegawai_awal IS NULL))
                        AND dpd.id_draft = ".$id_draft.") AS dj_baru
                        LEFT JOIN draft_pelantikan_detail dpdl ON dj_baru.idp_baru = dpdl.id_pegawai_awal AND dpdl.id_draft = ".$id_draft.",
                        jabatan j,
                        unit_kerja uk
               WHERE
                  dj_baru.idj_baru = j.id_j
                   AND j.id_unit_kerja = uk.id_unit_kerja) AS jab_baru
                   LEFT JOIN jabatan j ON j.id_j = jab_baru.idj_lama
                   INNER JOIN current_lokasi_kerja clk ON jab_baru.idpegawai = clk.id_pegawai
                   INNER JOIN unit_kerja ukl ON clk.id_unit_kerja = ukl.id_unit_kerja,
             pegawai p,
             golongan g
        WHERE p.id_pegawai = jab_baru.idpegawai
        AND p.pangkat_gol = g.golongan AND jab_baru.eselon_baru = '".$eselon."'
        ORDER BY jab_baru.unit_baru ASC) AS draft_struktural";
$query = $this->db->query($sql);
$list_data = $query->result();

?>
<page backtop="14mm" backbottom="10mm" backleft="10mm" backright="14mm" style="font-size: 10pt">
    <?php if (is_array($list_data) && sizeof($list_data) > 0): ?>
        <table border="0" cellspacing="5" cellpadding="0" style="width: 98%;">
            <tr>
                <td style="text-align: center; padding-bottom: 5px;">
                    <table border="0" cellspacing="5" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td style="text-align: center; width: 100%;">
                                <img src="<?php echo base_url('images/logokotabogor.gif'); ?>"
                                     style="width: 60px;margin-bottom: 10px;"><br>
                                <span style="font-size: 130%; font-weight: bold;">PEMERINTAH KOTA BOGOR</span><br>
                                <span style="font-size: small;line-height: 20px;">BADAN PERTIMBANGAN JABATAN DAN KEPANGKATAN</span><br>
                                Nomor : <?php echo $dataPengesahan->no_sk; ?><br>Tanggal : <?php echo $dataPengesahan->tgl_pengesahan; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="border-top: 1px solid rgba(0,0,0,1); padding-bottom: 10px;"></td>
            </tr>
            <tr>
                <td>
                    <?php echo ('Pada hari ini '.$hari.' tanggal '.$this->terbilang->Terbilang((int)$tglPengesahan).' bulan '.$blnPengesahan.' tahun '.$this->terbilang->Terbilang((int)$thnPengesahan).' ('.$dataPengesahan->tgl_pengesahan.'), Kami Badan Pertimbangan Jabatan dan Kepangkatan ( Baperjakat ) Pemerintah Kota Bogor yang dibentuk ');?><br>
                    <?php echo ('dengan Keputusan '.$dataBaperjakat->pengesah_sk.' Nomor '.$dataBaperjakat->no_sk.' yang terdiri dari :'); ?>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="0" cellspacing="5" cellpadding="0" style="width: 98%;" align="center">
                        <tr>
                            <td>1.</td>
                            <td>Ketua: </td>
                            <td style="padding-left: 20px;"><?php echo ucwords(strtolower($dataDetailBaperjakat[0]->jabatan)); ?></td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>Sekretaris: </td>
                            <td style="padding-left: 20px;"><?php echo ucwords(strtolower($dataDetailBaperjakat[1]->jabatan)); ?></td>
                        </tr>
                        <tr>
                            <td style="vertical-align: top">3.</td>
                            <td style="vertical-align: top">Anggota: </td>
                            <td style="padding-left: 20px;vertical-align: top; line-height: 25px;">
                                <?php echo ucwords(strtolower($dataDetailBaperjakat[2]->jabatan)); ?><br>
                                <?php echo ucwords(strtolower($dataDetailBaperjakat[3]->jabatan)); ?><br>
                                <?php echo ucwords(strtolower($dataDetailBaperjakat[4]->jabatan)); ?><br>
                                <?php echo ucwords(strtolower($dataDetailBaperjakat[5]->jabatan)); ?><br>
                                <?php echo ucwords(strtolower($dataDetailBaperjakat[6]->jabatan)); ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <?php echo 'telah melaksanakan rapat untuk memberikan Pertimbangan Kelayakan Pengangkatan dan alih tugas Pegawai Negeri Sipil dalam Jabatan Struktural di lingkungan Pemerintah Kota Bogor, antara lain : '; ?><br>
                </td>
            </tr>
        </table>

        <table cellspacing="0" cellpadding="0" style="width: 100%; border: 1px solid rgba(0,0,0,0.35);margin-top: 8px;">
            <thead style="display:table-header-group;">
            <tr>
                <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">No</td>
                <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">NAMA<br>NIP<br>TGL.LAHIR</td>
                <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">PANGKAT<br>GOL.RUANG</td>
                <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">JABATAN LAMA</td>
                <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">JABATAN BARU</td>
                <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">ESELON</td>
                <td style="vertical-align: middle;text-align:center; border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: normal;">KET</td>
            </tr>
            </thead>
            <?php $x=1; $z=1; ?>
            <?php foreach ($list_data as $lsdata): ?>
                <?php
                $ket = ($lsdata->eselon_baru == $lsdata->eselon_lama ? 'Rotasi' : 'Promosi');
                ?>
                <tr>
                    <td style="vertical-align: top;text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $x;?></td>
                    <td style="text-align: left;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->gelar_depan.' '.$lsdata->nama.' '.$lsdata->gelar_belakang; ?><br>
                        <?php echo $lsdata->nip;?><br><?php echo $lsdata->tgl_lahir;?>
                    </td>
                    <td style="vertical-align: top;text-align: left;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->pangkat_gol."<br>".$lsdata->pangkat;?></td>
                    <td style="vertical-align: top;text-align: left;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo smart_wordwrap(ucwords(strtolower($lsdata->jabatan_lama)),50);?></td>
                    <td style="vertical-align: top;text-align: left;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo smart_wordwrap(ucwords(strtolower($lsdata->jabatan_baru)), 50);?></td>
                    <td style="vertical-align: top;text-align: center;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata->eselon_baru;?></td>
                    <td style="vertical-align: top;text-align: left;padding: 5px;border-top: 1px solid rgba(0,0,0,0.35);"><?php echo $ket;?></td>
                </tr>
                <?php $x++;?>
            <?php endforeach; ?>
        </table>

        <table cellspacing="0" cellpadding="0" style="width: 100%; margin-top: 10px;">
            <tr><td style="vertical-align: top;text-align: left;padding: 5px;">
                    Rapat Demikian Hasil Rapat Badan Pertimbangan Jabatan dan Kepangkatan Pemerintah Kota Tanjungbalai telah ditutup dan ditanda tangani oleh Ketua, Sekretaris dan Anggota pada dan tanggal
                </td></tr>
            <tr><td style="vertical-align: top;text-align: left;padding: 5px;">
                    tersebut diatas pukul <?php echo $dataPengesahan->wkt_pengesahan.' WIB. di '.$dataPengesahan->ruang_pengesahan; ?>
                </td></tr>
        </table>

        <table cellspacing="0" cellpadding="0" style="width: 100%; margin-top: 20px;" align="center">
            <tr>
                <td style="text-align: center;">
                    <strong>Ketua</strong>,<br><?php echo ucwords(strtolower($dataDetailBaperjakat[0]->jabatan)); ?>
                    <br><br><br><br><br><br>
                    <span style="text-decoration: underline"><?php echo $dataDetailBaperjakat[0]->nama; ?></span><br>
                    <?php echo $dataDetailBaperjakat[0]->nip_baru; ?>
                </td>
                <td></td>
                <td style="padding-left: 50px;text-align: center;"><strong>Sekretaris</strong>,<br><?php echo smart_wordwrap(ucwords(strtolower($dataDetailBaperjakat[1]->jabatan)), 50); ?>
                    <br><br><br><br><br><br>
                    <span style="text-decoration: underline"><?php echo $dataDetailBaperjakat[1]->nama; ?></span><br>
                    <?php echo $dataDetailBaperjakat[1]->nip_baru; ?>
                </td>
            </tr>
            <tr>
                <td></td><td style="padding-top: 20px;padding-bottom: 20px;text-align: center;"><strong>Anggota</strong>,</td><td></td>
            </tr>
            <tr>
                <td style="padding-right: 50px;text-align: center;">
                    <?php echo '1. '.smart_wordwrap(ucwords(strtolower($dataDetailBaperjakat[2]->jabatan)),50); ?>
                    <br><br><br><br><br><br>
                    <span style="text-decoration: underline"><?php echo $dataDetailBaperjakat[2]->nama; ?></span><br>
                    <?php echo $dataDetailBaperjakat[2]->nip_baru; ?>
                    <br><br><br>
                    <?php echo '2. '.smart_wordwrap(ucwords(strtolower($dataDetailBaperjakat[3]->jabatan)),50); ?>
                    <br><br><br><br><br><br>
                    <span style="text-decoration: underline"><?php echo $dataDetailBaperjakat[3]->nama; ?></span><br>
                    <?php echo $dataDetailBaperjakat[3]->nip_baru; ?>
                </td>
                <td style="text-align: center;">
                    <?php echo '5. '.smart_wordwrap(ucwords(strtolower($dataDetailBaperjakat[6]->jabatan)),50); ?>
                    <br><br><br><br><br><br>
                    <span style="text-decoration: underline"><?php echo $dataDetailBaperjakat[6]->nama; ?></span><br>
                    <?php echo $dataDetailBaperjakat[6]->nip_baru; ?>
                </td>
                <td style="padding-left: 50px;text-align: center;">
                    <?php echo '3. '.smart_wordwrap(ucwords(strtolower($dataDetailBaperjakat[4]->jabatan)),50); ?>
                    <br><br><br><br><br><br>
                    <span style="text-decoration: underline"><?php echo $dataDetailBaperjakat[4]->nama; ?></span><br>
                    <?php echo $dataDetailBaperjakat[4]->nip_baru; ?>
                    <br><br><br>
                    <?php echo '4. '.smart_wordwrap(ucwords(strtolower($dataDetailBaperjakat[5]->jabatan)),50); ?>
                    <br><br><br><br><br><br>
                    <span style="text-decoration: underline"><?php echo $dataDetailBaperjakat[5]->nama; ?></span><br>
                    <?php echo $dataDetailBaperjakat[5]->nip_baru; ?>
                </td>
            </tr>
        </table>
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
    $html2pdf->Output('cetak_draft_pelantikan.pdf');
}catch(HTML2PDF_exception $e){
    echo $e;
    exit;
}
?>