<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . '/third_party/html2pdf.class.php';

include APPPATH . "/third_party/QrCode/src/Exception/QrCodeException.php";
include APPPATH . "/third_party/QrCode/src/Exception/InvalidPathException.php";
include APPPATH . "/third_party/QrCode/src/QrCodeInterface.php";
include APPPATH . "/third_party/QrCode/src/QrCode.php";
include APPPATH . "/third_party/QrCode/php-enum-master/src/Enum.php";
include APPPATH . "/third_party/QrCode/src/ErrorCorrectionLevel.php";
include APPPATH . "/third_party/QrCode/src/LabelAlignment.php";
include APPPATH . "/third_party/QrCode/src/Writer/WriterInterface.php";
include APPPATH . "/third_party/QrCode/src/Writer/AbstractWriter.php";
include APPPATH . "/third_party/QrCode/src/Writer/BinaryWriter.php";
include APPPATH . "/third_party/QrCode/src/Writer/DebugWriter.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Renderer/Color/ColorInterface.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Renderer/Color/Rgb.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Common/AbstractEnum.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Common/ErrorCorrectionLevel.php";
include APPPATH . "/third_party/QrCode/src/Traits/BaconConversionTrait.php";
include APPPATH . "/third_party/QrCode/src/Writer/EpsWriter.php";
include APPPATH . "/third_party/QrCode/src/WriterRegistryInterface.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Renderer/RendererInterface.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Renderer/Image/RendererInterface.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Renderer/Image/AbstractRenderer.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Renderer/Image/Png.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Common/Mode.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Common/BitArray.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Common/CharacterSetEci.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Common/EcBlock.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Common/EcBlocks.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Common/Version.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Common/ReedSolomonCodec.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Encoder/BlockPair.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Encoder/QrCode.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Encoder/ByteMatrix.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Encoder/MatrixUtil.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Common/BitUtils.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Encoder/MaskUtil.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Encoder/Encoder.php";
include APPPATH . "/third_party/QrCode/BaconQrCode/Writer.php";
include APPPATH . "/third_party/QrCode/src/Writer/PngWriter.php";
include APPPATH . "/third_party/QrCode/src/Writer/SvgWriter.php";
include APPPATH . "/third_party/QrCode/src/WriterRegistry.php";

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\Factory\QrCodeFactory;
use Endroid\QrCode\QrCode;

?>

    <style>
        table.print-friendly tr td, table.print-friendly tr td {
            page-break-inside: avoid;
        }

    </style>

<?php if (isset($knjmaster) and sizeof($knjmaster) > 0 and $knjmaster != '') { ?>
    <?php foreach ($knjmaster as $lsdata): ?>
        <?php
        $id_knj_master_enc = $lsdata->id_knj_master_enc;
        $id_pegawai_enc = $lsdata->id_pegawai_enc;
        $bln = $lsdata->periode_bln;
        $thn = $lsdata->periode_thn;
        $id_status_knj = $lsdata->id_status_knj;
        $namap = $lsdata->nama;
        $jabp = $lsdata->last_jabatan;
        $nip = $lsdata->nip_baru;
        $atsl_nm = $lsdata->last_atsl_nama;
        $atsl_jab = $lsdata->last_atsl_jabatan;
        $atsl_nip = (is_numeric($lsdata->last_atsl_nip) ? $lsdata->last_atsl_nip : '-');
        $jumlah_penambahan_item_lain = $lsdata->jumlah_penambahan_item_lain;
        $jumlah_pengurangan_item_lain = $lsdata->jumlah_pengurangan_item_lain;
        $jumlah_pengurangan_item_lain_maks = $lsdata->jumlah_pengurangan_item_lain_maks;
        $jumlah_bawahan_aktual = $lsdata->jml_bawahan_aktual;
        $last_eselon = $lsdata->last_eselon;
        $jml_bawahan_aktual = $lsdata->jml_bawahan_aktual;
        $jml_bawahan_kinerja = $lsdata->jml_bawahan_kinerja;
        $persen_kinerja_accu_bawahan = $lsdata->persen_kinerja_accu_bawahan;
        $persen_kinerja_bawahan_aktual = $lsdata->persen_kinerja_bawahan_aktual;
        $persen_kinerja_aktual = $lsdata->persen_kinerja_aktual;
        $tunjangan_kinerja_aktual = number_format($lsdata->rupiah_kinerja_aktual, 0, ",", ".");
        $last_rupiah_kinerja_final = number_format($lsdata->last_rupiah_kinerja_final, 0, ",", ".");
        $status_pegawai = $lsdata->status_pegawai;
        ?>
        <page backtop="14mm" backbottom="14mm" backleft="14mm" backright="10mm"
        <?php if ($id_status_knj != 3): ?>
            backimg="<?php echo base_url('assets/images/draft_grey_transparent.png'); ?>"
            backimgx="center" backimgy="middle" backimgw="60%"
        <?php endif; ?>
        style="font-size: 10pt">
        <table border="0" cellspacing="5" cellpadding="0" style="width: 98%;">
            <tr>
                <td colspan="3" style="text-align: center; padding-bottom: 5px;">
                    <table border="0" cellspacing="5" cellpadding="0" style="width: 100%;">
                        <tr>
                            <td style="width: 10%;text-align: left;">
                                <img src="<?php echo base_url('assets/images/logokotabogor.gif'); ?>"
                                     style="width: 60px;">
                            </td>
                            <td style="text-align: left">
                                <span style="font-size: 130%; font-weight: bold;">LAPORAN E-KINERJA</span><br>
                                APARATUR SIPIL NEGARA<br>PEMERINTAH KOTA BOGOR
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
                <td style="width: 72%"><?php echo $this->umum->monthName($lsdata->periode_bln) . ' ', $lsdata->periode_thn; ?></td>
            </tr>
            <tr>
                <td>Waktu Pembuatan</td>
                <td>:</td>
                <td><?php echo $lsdata->tgl_input_kinerja; ?></td>
            </tr>
            <tr>
                <td>Status Laporan</td>
                <td>:</td>
                <td><?php echo $lsdata->status_knj; ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?php echo $lsdata->nama; ?></td>
            </tr>
            <tr>
                <td>NIP</td>
                <td>:</td>
                <td><?php echo $lsdata->nip_baru; ?></td>
            </tr>
            <tr>
                <td>Jenjang Jabatan</td>
                <td>:</td>
                <td><?php echo $lsdata->last_jenjab; ?></td>
            </tr>
            <tr>
                <td>Status Pegawai</td>
                <td>:</td>
                <td><?php echo $lsdata->status_pegawai; ?></td>
            </tr>
            <tr>
                <td style="vertical-align: top">Jabatan</td>
                <td style="vertical-align: top">:</td>
                <td><?php echo '(' . $lsdata->last_kode_jabatan . ') ' . smart_wordwrap($lsdata->last_jabatan, 70) . ($lsdata->last_eselon == '' ? '' : '. <br>Eselon : ' . $lsdata->last_eselon); ?></td>
            </tr>
            <tr>
                <td>Golongan</td>
                <td>:</td>
                <td><?php echo $lsdata->last_gol; ?></td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td>:</td>
                <td><?php echo $lsdata->last_unit_kerja; ?></td>
            </tr>
            <tr>
                <td style="vertical-align: top">Atasan Langsung</td>
                <td style="vertical-align: top">:</td>
                <td>
                    <?php echo $lsdata->last_atsl_nama . ' ' . (is_numeric($lsdata->last_atsl_nip) ? $lsdata->last_atsl_nip : ''); ?>
                    <br>
                    <?php echo smart_wordwrap($lsdata->last_atsl_jabatan . (is_numeric($lsdata->last_atsl_nip) ? ' (' . $lsdata->last_atsl_gol : '') . ')', 70); ?>
                </td>
            </tr>
            <tr>
                <td style="vertical-align: top">Pejabat Berwenang</td>
                <td style="vertical-align: top">:</td>
                <td style="vertical-align: top">
                    <?php if (is_numeric($lsdata->last_atsl_nip)): ?>
                        <?php echo $lsdata->last_pjbt_nama . ' ' . $lsdata->last_pjbt_nip; ?><br>
                        <?php echo smart_wordwrap($lsdata->last_pjbt_jabatan . ' (' . $lsdata->last_pjbt_gol . ')', 70); ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td colspan="3"><span>Riwayat Atasan Langsung :</span></td>
            </tr>
            <tr>
                <td colspan="3">
                    <?php
                    $data_at = $this->ekinerja->data_ref_list_hist_alih_tugas_by_idknj($lsdata->id_knj_master_enc);
                    if (isset($data_at) and sizeof($data_at) > 0 and $data_at != '') {
                        $b = 1;
                        foreach ($data_at as $lsdata2) {
                            echo '<ul style="margin-top: -10px;">';
                            echo '<li>';
                            echo 'Jabatan: (' . $lsdata2->kode_jabatan . ') ' . $lsdata2->jabatan . ($lsdata2->eselon == '' ? '' : '. Eselon : ' . $lsdata2->eselon);
                            echo '<br>Kelas: ' . $lsdata2->kelas_jabatan . ' (' . $lsdata2->nilai_jabatan . '). Tunjangan ' . ($status_pegawai == 'CPNS' ? '80%' : '') . ' : Rp. ' . number_format($lsdata2->rupiah_awal_tkd, 0, ",", ".") . ',-';
                            echo '<br>Atasan: ' . $lsdata2->atsl_nama . ' (' . $lsdata2->atsl_jabatan.')';
                            if($lsdata2->atsl_nama_plh <> ''){
                                echo '<br>Plh. Atasan Langsung : '.$lsdata2->atsl_nama_plh.' ('.$lsdata2->atsl_jabatan_plh.')';
                            }
                            echo '<br>Unit Kerja: ' . $lsdata2->unit_kerja . '<br>TMT. Kinerja: ' . $lsdata2->tmt;
                            echo '</li>';
                            echo '</ul>';
                        }
                    } else {
                        echo "Belum ada data";
                    }
                    ?>
                </td>
            </tr>
        </table>
        <table border="0" cellspacing="5" cellpadding="0" style="width: 80%;font-size: 10pt;">
            <tr>
                <td colspan="3" align="center"><strong>Tunjangan Kinerja Daerah (TKD)</strong></td>
            </tr>
            <tr>
                <td colspan="3"><span style="text-decoration: underline;font-weight: bold">Target Awal Tunjangan</span>
                </td>
            </tr>
            <tr>
                <td style="width: 25%">Kinerja (60%)</td>
                <td style="width: 3%">:</td>
                <td style="width: 72%">Rp. <?php echo number_format($lsdata->rupiah_awal_kinerja, 0, ",", "."); ?>,-
                </td>
            </tr>
            <tr>
                <td>Kedisiplinan (40%)</td>
                <td>:</td>
                <td>Rp. <?php echo number_format($lsdata->rupiah_awal_disiplin, 0, ",", "."); ?>,-</td>
            </tr>
            <tr>
                <td colspan="3"><span style="text-decoration: underline; font-weight: bold;">Aktivitas Kegiatan</span>
                </td>
            </tr>
            <tr>
                <td>Jumlah Menit Efektif Kerja</td>
                <td>:</td>
                <td><?php echo $lsdata->jml_menit_efektif_kerja; ?> menit</td>
            </tr>
            <tr>
                <td>Jumlah Waktu Kinerja</td>
                <td>:</td>
                <td><?php echo $lsdata->jml_waktu_kinerja_accu; ?> menit</td>
            </tr>
            <tr>
                <td>Persentase Kinerja</td>
                <td>:</td>
                <td><?php echo $lsdata->persen_kinerja_accu; ?> %</td>
            </tr>
            <tr>
                <td>Tunjangan Hasil Kinerja <?php echo($lsdata->last_eselon == '' ? '(A)' : ''); ?></td>
                <td>:</td>
                <td>Rp. <?php echo number_format($lsdata->rupiah_kinerja, 0, ",", "."); ?>,-</td>
            </tr>
            <?php if ($lsdata->last_eselon != '' or $lsdata->jml_bawahan_aktual > 0): ?>
                <tr>
                    <td colspan="3"><span style="text-decoration: underline; font-weight: bold;">Kinerja Staf</span>
                    </td>
                </tr>
                <tr>
                    <td>Jumlah Staf Aktual</td>
                    <td>:</td>
                    <td><?php echo $lsdata->jml_bawahan_aktual; ?> orang</td>
                </tr>
                <tr>
                    <td>Jumlah Staf eKinerja</td>
                    <td>:</td>
                    <td><?php echo $lsdata->jml_bawahan_kinerja; ?> orang</td>
                </tr>
                <tr>
                    <td>Jumlah Waktu Kinerja Staf</td>
                    <td>:</td>
                    <td><?php echo $lsdata->jml_waktu_kinerja_accu_bawahan; ?> menit</td>
                </tr>
                <tr>
                    <td>Persentase Kinerja Staf</td>
                    <td>:</td>
                    <td><?php echo $lsdata->persen_kinerja_accu_bawahan; ?> %</td>
                </tr>
                <tr>
                    <td>Persentase Kinerja Staf Aktual</td>
                    <td>:</td>
                    <td><?php echo $lsdata->persen_kinerja_bawahan_aktual; ?> %</td>
                </tr>
                <tr>
                    <td>Persentase Kinerja Aktual</td>
                    <td>:</td>
                    <td><?php echo $lsdata->persen_kinerja_aktual; ?> %</td>
                </tr>
                <tr>
                    <td>Tunjangan Hasil Kinerja (A)</td>
                    <td>:</td>
                    <td>Rp. <?php echo number_format($lsdata->rupiah_kinerja_aktual, 0, ",", "."); ?>,-</td>
                </tr>
            <?php endif; ?>
            <tr>
                <td colspan="3"><span style="text-decoration: underline; font-weight: bold;">Absensi Kehadiran</span>
                </td>
            </tr>
            <tr>
                <td>Jumlah Hari Efektif Kerja</td>
                <td>:</td>
                <td><?php echo $lsdata->jml_hari_efektif_kerja; ?></td>
            </tr>
            <tr>
                <td>Jumlah Kehadiran</td>
                <td>:</td>
                <td><?php echo $lsdata->jml_kehadiran_accu; ?></td>
            </tr>
            <tr>
                <td>Persentase Kehadiran</td>
                <td>:</td>
                <td><?php echo $lsdata->persen_kehadiran_accu; ?> %</td>
            </tr>
            <tr>
                <td>Jumlah Ketidakhadiran</td>
                <td>:</td>
                <td><?php echo $lsdata->jml_tidak_hadir_accu; ?></td>
            </tr>
            <tr>
                <td>Persentase Ketidakhadiran</td>
                <td>:</td>
                <td><?php echo $lsdata->persen_minus_tidak_hadir_accu; ?> %</td>
            </tr>
            <tr>
                <td>Persentase Terlambat / Pulang lebih cepat</td>
                <td style="vertical-align: top">:</td>
                <td style="vertical-align: top"><?php echo $lsdata->persen_minus_terlambat_plg_cpt_accu; ?> %</td>
            </tr>
            <tr>
                <td>Persentase Kedisiplinan</td>
                <td style="vertical-align: top">:</td>
                <td style="vertical-align: top"><?php echo $lsdata->persen_disiplin_final; ?> %</td>
            </tr>
            <tr>
                <td>Tunjangan Kedisiplinan (B)</td>
                <td>:</td>
                <td>Rp. <?php echo number_format($lsdata->rupiah_disiplin, 0, ",", "."); ?>,-</td>
            </tr>
            <tr>
                <td colspan="3"><span style="text-decoration: underline; font-weight: bold;">Absensi Apel</span></td>
            </tr>
            <tr>
                <td>Jumlah Hari Efektif Apel</td>
                <td>:</td>
                <td><?php echo $lsdata->jml_hari_efektif_apel; ?></td>
            </tr>
            <tr>
                <td>Jumlah Hari Tidak Apel</td>
                <td>:</td>
                <td><?php echo $lsdata->jml_tidak_apel_accu; ?></td>
            </tr>
            <tr>
                <td>Persentase Tidak Apel</td>
                <td>:</td>
                <td><?php echo $lsdata->persen_minus_tidak_apel_accu; ?> %</td>
            </tr>
            <tr>
                <td colspan="3"><span
                            style="text-decoration: underline;font-weight: bold;">Item Kinerja Unsur Lainnya</span></td>
            </tr>
            <tr>
                <td colspan="3"><span style="font-style: italic;">Penambahan Prestasi</span></td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td>:</td>
                <td><?php echo $lsdata->jumlah_penambahan_item_lain; ?></td>
            </tr>
            <tr>
                <td>Persentase</td>
                <td>:</td>
                <td><?php echo $lsdata->persen_penambahan_item_lain; ?> %</td>
            </tr>
            <tr>
                <td colspan="3"><span style="font-style: italic;">Pengurangan Unsur Disiplin</span></td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td>:</td>
                <td><?php echo $lsdata->jumlah_pengurangan_item_lain; ?></td>
            </tr>
            <tr>
                <td>Persentase</td>
                <td>:</td>
                <td><?php echo $lsdata->persen_pengurangan_item_lain; ?> %</td>
            </tr>
            <tr>
                <td>Rupiah</td>
                <td>:</td>
                <td>
                    Rp. <?php echo number_format((($lsdata->persen_pengurangan_item_lain / 100) * $lsdata->last_rupiah_disiplin), 0, ",", "."); ?>
                    ,-
                </td>
            </tr>
            <tr>
                <td colspan="3"><span style="font-style: italic;">Pengurangan Hasil Akhir</span></td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td>:</td>
                <td><?php echo $lsdata->jumlah_pengurangan_item_lain_maks; ?></td>
            </tr>
            <tr>
                <td>Persentase</td>
                <td>:</td>
                <td><?php echo $lsdata->persen_pengurangan_item_lain_maks; ?> %</td>
            </tr>
            <tr>
                <td colspan="3"><span style="text-decoration: underline;font-weight: bold;">Hasil Akhir Kinerja</span>
                </td>
            </tr>
            <tr>
                <td>Total Tunjangan (A+B)</td>
                <td>:</td>
                <td>
                    Rp. <?php echo number_format(($lsdata->rupiah_kinerja_aktual + $lsdata->rupiah_disiplin), 0, ",", "."); ?>
                    ,-
                </td>
            </tr>
            <tr>
                <td colspan="3"><span style="font-style: italic;">Penyesuaian Unsur Lainnya</span></td>
            </tr>
            <tr>
                <td>Persentase Kedisiplinan</td>
                <td style="vertical-align: top">:</td>
                <td style="vertical-align: top"><?php echo $lsdata->last_persen_disiplin; ?> %</td>
            </tr>
            <tr>
                <td>Tunjangan Kedisiplinan</td>
                <td>:</td>
                <td>Rp. <?php echo number_format($lsdata->last_rupiah_disiplin, 0, ",", "."); ?>,-</td>
            </tr>
            <tr>
                <td>Tunjangan Perolehan</td>
                <td>:</td>
                <td>Rp. <?php echo number_format($lsdata->rupiah_kinerja_final, 0, ",", "."); ?>,-</td>
            </tr>
            <tr>
                <td>Pengurangan Akhir <?php echo number_format($lsdata->persen_pengurangan_item_lain_maks, 0); ?>%</td>
                <td>:</td>
                <td>
                    Rp. <?php echo number_format((($lsdata->persen_pengurangan_item_lain_maks / 100) * $lsdata->rupiah_kinerja_final), 0, ",", "."); ?>
                    ,-
                </td>
            </tr>
            <tr>
                <td><strong>Tunjangan Akhir</strong></td>
                <td>:</td>
                <td>
                    <strong>Rp. <?php echo number_format($lsdata->last_rupiah_kinerja_final, 0, ",", "."); ?>,-</strong>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="border-top: 1px solid rgba(0,0,0,1);"></td>
            </tr>
            <tr>
                <td>Status Kalkulasi Nilai</td>
                <td>:</td>
                <td><?php echo($lsdata->flag_kalkulasi == 0 ? 'Belum pernah dikalkulasi' : 'Terakhir dikalkulasi pada ' . $lsdata->tgl_update_kalkulasi); ?></td>
            </tr>
            <tr>
                <td style="vertical-align: top">Pemrosesan Laporan</td>
                <td style="vertical-align: top">:</td>
                <td><?php echo($lsdata->tgl_approved == '' ? 'Belum pernah diproses' : 'Terakhir diproses pada ' . $lsdata->tgl_approved . '<br>oleh ' . $lsdata->nama_approver/*.'<br>'.$lsdata->nip_approver*/); ?></td>
            </tr>
        </table>
        <?php if ($jumlah_penambahan_item_lain > 0 or $jumlah_pengurangan_item_lain > 0 or $jumlah_pengurangan_item_lain_maks): ?>
            Catatan Unsur Lain:
            <?php $data_unsur_lain = $this->ekinerja->daftar_item_lainnya_by_idpegawai($id_pegawai_enc, $bln, $thn); ?>
            <?php if (isset($data_unsur_lain) and sizeof($data_unsur_lain) > 0 and $data_unsur_lain != '') { ?>
                <?php foreach ($data_unsur_lain as $uldata): ?>
                    <ul>
                        <li>
                            <?php echo $uldata->jenis_item_lainnya; ?><br><?php echo $uldata->ket_unsur_lain; ?>.
                            No.Surat: <?php echo $uldata->no_sk; ?>. TMT: <?php echo $uldata->tmt_mulai; ?>
                            s.d. <?php echo $uldata->tmt_selesai; ?><br>
                            <?php echo $uldata->kategori_item; ?> tunjangan
                            sebesar <?php echo $uldata->persen_tunjangan; ?>
                            % <?php echo strtolower($uldata->keterangan); ?>
                        </li>
                    </ul>
                <?php endforeach; ?>
            <?php } else { ?>
                Data tidak ditemukan
            <?php } ?>
        <?php endif; ?>
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
                    <?php echo ucwords(strtolower($atsl_jab)); ?><br>NIP. <?php echo $atsl_nip; ?>
                </td>
                <td style="width: 30%;text-align: left;vertical-align: top;">

                </td>
                <td style="width: 30%;text-align: left;vertical-align: top;">
                    Bogor,&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $this->umum->monthName(date('m')) . ' ' . date('Y'); ?>
                    <br>
                    ASN yang dinilai,<br><br><br><br><br><br><br><br>
                    <span style="font-weight: bold; text-decoration: underline;"><?php echo $namap; ?></span><br>
                    <?php echo ucwords(strtolower($jabp)); ?><br>NIP. <?php echo $nip; ?>
                </td>
            </tr>
        </table>
    <?php endforeach; ?>
    </page>

        <?php if (isset($nilai_hist_alih_tugas) and sizeof($nilai_hist_alih_tugas) > 0 and $nilai_hist_alih_tugas != ''): ?>
            <?php //if(sizeof($nilai_hist_alih_tugas)==1):
                $atsl_plh = '';
                $atsl_jabatan_plh = '';
            ?>
            <?php foreach ($nilai_hist_alih_tugas as $lsdata): ?>
                <?php
                $jabatan = $lsdata->jabatan . ' (' . $lsdata->kode_jabatan . ')';
                $kelas = $lsdata->kelas_jabatan . ' (' . $lsdata->nilai_jabatan . ')';
                $nilai_tunj = 'Rp ' . number_format($lsdata->rupiah_awal_tkd, 0, ",", ".") .
                    '<br>Komposisi : <br>Kinerja (60%): Rp. ' . number_format($lsdata->rupiah_awal_kinerja, 0, ",", ".") .
                    '<br>Kedisiplinan (40%): Rp. ' . number_format($lsdata->rupiah_awal_disiplin, 0, ",", ".");
                $kinerja = 'Kinerja : ' . $lsdata->persen_kinerja_final . '% (Rp. ' . number_format($lsdata->rupiah_kinerja, 0, ",", ".") . ')';
                $kedisiplinan = 'Kedisiplinan : ' . $lsdata->persen_disiplin_final . '% (Rp. ' . number_format($lsdata->rupiah_disiplin, 0, ",", ".") . ')';
                $jml_akhir = 'Rp. ' . number_format($lsdata->rupiah_kinerja_final, 0, ",", ".");
                $atsl = $lsdata->atsl_nama;
                $atsl_jabatan = $lsdata->atsl_jabatan;
                if($lsdata->atsl_nama_plh <> ''){
                    $atsl_plh = $lsdata->atsl_nama_plh;
                    $atsl_jabatan_plh = $lsdata->atsl_jabatan_plh;
                }
                $pjbt = $lsdata->pjbt_nama;
                $pjbt_jabatan = $lsdata->pjbt_jabatan;
                $uk = $lsdata->unit_kerja;
                ?>
                <?php $detail_tunjangan = $this->ekinerja->data_ref_detail_nilai_tunjangan_by_hist_alih_tugas($lsdata->idknj_hist_alih_tugas_enc); ?>
                <?php if (isset($detail_tunjangan) and sizeof($detail_tunjangan) > 0 and $detail_tunjangan != ''): ?>
                <page orientation="L" backtop="10mm" backbottom="10mm" backleft="25mm" backright="10mm"
                <?php if ($id_status_knj != 3): ?>
                    backimg="<?php echo base_url('assets/images/draft_grey_transparent.png'); ?>"
                    backimgx="center" backimgy="center" backimgw="60%"
                <?php endif; ?>
                style="font-size: 8pt">
                    <table cellspacing="0" cellpadding="0" style="width: 100%; border: 1px solid rgba(0,0,0,0.35)">
                        <thead style="display:table-header-group;">
                        <tr>
                            <td colspan="15" style="border-bottom: 1px solid rgba(0,0,0,0.35)">
                                <div style="margin-left: 5px; margin-top: 5px; margin-bottom: 5px; font-weight: bold; font-size: 10pt;">
                                    Rincian Nilai Laporan E-Kinerja
                                    Periode <?php echo $this->umum->monthName($bln) . ' ', $thn; ?>
                                    - <?php echo $namap; ?></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">
                                Uraian
                            </td>
                            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">
                                Tgl
                            </td>
                            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">
                                Tugas <br>Utama
                            </td>
                            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">
                                Tugas <br>Tambahan
                            </td>
                            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">
                                Tugas <br>Khusus
                            </td>
                            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">
                                Penyesuaian<br>Target Baru
                            </td>
                            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">
                                IKP
                            </td>
                            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold; font-weight: bold;">
                                Total Durasi <br>Kinerja
                            </td>
                            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">
                                Persen <br>Kinerja (%)
                            </td>
                            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">
                                Jam<br>Masuk
                            </td>
                            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">
                                Jam<br>Pulang
                            </td>
                            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">
                                Status<br>Hari
                            </td>
                            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">
                                Tidak<br>Hadir (%)
                            </td>
                            <td style="vertical-align: middle;text-align:center;border-right: 1px solid rgba(0,0,0,0.35); border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">
                                Terlambat Masuk,<br>Pulang Cepat, (%)
                            </td>
                            <td style="vertical-align: middle;text-align:center;border-bottom: 1px solid rgba(0,0,0,0.35); padding: 5px; font-weight: bold;">
                                Tidak<br>Apel (%)
                            </td>
                        </tr>
                        </thead>
                        <?php $x = 1; ?>

                        <?php foreach ($detail_tunjangan as $lsdata2): ?>
                            <?php if ($x == 1): ?>
                                <tr>
                                    <td rowspan="<?php echo sizeof($detail_tunjangan); ?>"
                                        style="text-align: left;border-right: 1px solid rgba(0,0,0,0.35);padding: 5px; vertical-align: top;">
                                        <?php
                                        echo '<strong>' . smart_wordwrap($jabatan, 30) . '</strong><br><br>Kelas: ' . $kelas . ' ' . $nilai_tunj .
                                            '<br>Pencapaian :<br>' . $kinerja . '<br>' . $kedisiplinan . '<br>Jumlah Akhir: ' . $jml_akhir;
                                        if ($last_eselon != '' or $jml_bawahan_aktual > 0) {
                                            echo '<br><br>Jumlah Staf Aktual: ' . $jml_bawahan_aktual . ' orang';
                                            echo '<br>Jumlah Staf eKinerja: ' . $jml_bawahan_kinerja . ' orang';
                                            echo '<br>Persentase Kinerja Staf: ' . $persen_kinerja_accu_bawahan . '%';
                                            echo '<br>Persentase Kinerja Staf Aktual: ' . $persen_kinerja_bawahan_aktual . '%';
                                            echo '<br>Persentase Kinerja Aktual: ' . $persen_kinerja_aktual . '%';
                                            echo '<br>Tunjangan Kinerja Aktual: Rp. ' . $tunjangan_kinerja_aktual . ',-';
                                            echo '<br>Tunjangan Hasil Akhir Kinerja: Rp. ' . $last_rupiah_kinerja_final . ',-';
                                        }
                                        echo '<br><br>Unit Kerja: <br>' . smart_wordwrap($uk, 30) .
                                            '<br><br>Atasan Langsung: <br>' . $atsl . '<br>';
                                        ?>
                                        <?php echo smart_wordwrap($atsl_jabatan, 30); ?>
                                        <?php
                                            if($atsl_plh!=''){
                                                echo '<br>Plh. Atasan Langsung:<br>'.$atsl_plh.' <br>'.smart_wordwrap($atsl_jabatan_plh, 30);
                                            }
                                        ?>
                                        <br><br>
                                        Pejabat Berwenang:<br><?php echo $pjbt; ?><br>
                                        <?php echo smart_wordwrap($pjbt_jabatan, 30); ?>
                                    </td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->tanggal; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->jumlah_waktu_tugas_utama; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->jumlah_waktu_tugas_tambahan; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->jumlah_waktu_tugas_tambahan_khusus; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->jumlah_waktu_penyesuaian_target; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->jumlah_waktu_ikp; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->jml_waktu_kinerja; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);">
                                        <?php echo $lsdata2->persen_kinerja; ?>
                                        <?php
                                        if ($lsdata2->persen_kinerja_penyesuaian != '') {
                                            echo ' (' . $lsdata2->persen_kinerja_penyesuaian . ')';
                                        }
                                        ?>
                                    </td>
                                    <td style="border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;"><?php echo($lsdata2->jam_masuk == '' ? '-' : $lsdata2->jam_masuk); ?></td>
                                    <td style="border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;"><?php echo($lsdata2->jam_pulang == '' ? '-' : $lsdata2->jam_pulang); ?></td>
                                    <td style="border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;">
                                        <?php
                                        if (strpos($lsdata2->status_hari, 'Jam Kerja Beda') !== false) {
                                            echo smart_wordwrap('JK. Jam Kerja Beda', 20);
                                        } elseif (strpos($lsdata2->status_hari, 'Cuti Disetujui BKPSDA') !== false) {
                                            echo smart_wordwrap('Cuti Disetujui', 20);
                                        } else {
                                            echo smart_wordwrap($lsdata2->status_hari, 20);
                                        }
                                        ?>
                                    </td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->persen_minus_tidak_hadir; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->menit_terlambat_masuk; ?>
                                        ,
                                        <?php echo $lsdata2->menit_pulang_lebih_cepat; ?>,
                                        (<?php echo $lsdata2->persen_minus_terlambat_plg_cpt; ?>)
                                    </td>
                                    <td style="text-align: center;"><?php echo $lsdata2->persen_minus_tidak_apel; ?></td>
                                </tr>
                            <?php else: ?>
                                <tr>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->tanggal; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->jumlah_waktu_tugas_utama; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->jumlah_waktu_tugas_tambahan; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->jumlah_waktu_tugas_tambahan_khusus; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->jumlah_waktu_penyesuaian_target; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->jumlah_waktu_ikp; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->jml_waktu_kinerja; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);">
                                        <?php echo $lsdata2->persen_kinerja; ?>
                                        <?php
                                        if ($lsdata2->persen_kinerja_penyesuaian != '') {
                                            echo ' (' . $lsdata2->persen_kinerja_penyesuaian . ')';
                                        }
                                        ?>
                                    </td>
                                    <td style="border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;text-align: center;"><?php echo($lsdata2->jam_masuk == '' ? '-' : $lsdata2->jam_masuk); ?></td>
                                    <td style="border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;text-align: center;"><?php echo($lsdata2->jam_pulang == '' ? '-' : $lsdata2->jam_pulang); ?></td>
                                    <td style="border-right: 1px solid rgba(0,0,0,0.35);padding: 5px;">
                                        <?php
                                        if (strpos($lsdata2->status_hari, 'Jam Kerja Beda') !== false) {
                                            echo smart_wordwrap('JK. Jam Kerja Beda', 20);
                                        } elseif (strpos($lsdata2->status_hari, 'Cuti Disetujui BKPSDA') !== false) {
                                            echo smart_wordwrap('Cuti Disetujui', 20);
                                        } else {
                                            echo smart_wordwrap($lsdata2->status_hari, 20);
                                        }
                                        ?>
                                    </td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->persen_minus_tidak_hadir; ?></td>
                                    <td style="text-align: center;border-right: 1px solid rgba(0,0,0,0.35);"><?php echo $lsdata2->menit_terlambat_masuk; ?>
                                        ,
                                        <?php echo $lsdata2->menit_pulang_lebih_cepat; ?>,
                                        (<?php echo $lsdata2->persen_minus_terlambat_plg_cpt; ?>)
                                    </td>
                                    <td style="text-align: center;"><?php echo $lsdata2->persen_minus_tidak_apel; ?></td>
                                </tr>
                            <?php endif; ?>
                            <?php $x++; ?>
                        <?php endforeach; ?>
                    </table>
                </page>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php //else: ?>

            <?php //endif; ?>
        <?php endif; ?>


<?php } else {
    echo '';
} ?>
<?php

function smart_wordwrap($string, $width = 75, $break = "<br>")
{
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
    $html2pdf = new HTML2PDF('P', 'Legal', 'en', true, 'UTF-8', 0);
    $html2pdf->pdf->setTitle('Cetak Laporan Kinerja');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('Cetak_Laporan_Kinerja.pdf');
} catch (HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>