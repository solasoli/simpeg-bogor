<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'/third_party/html2pdf.class.php';
$html2pdf = new HTML2PDF('P', 'Legal', 'en', true, 'UTF-8', 0);
?>

<page backtop="14mm" backbottom="14mm" backleft="15mm" backright="10mm" style="font-size: 10pt">

    <table border="0" cellspacing="0" cellpadding="0" style="width: 95%;">
        <tr>
            <td style="width: 10%; border-bottom: double 2px black; padding-bottom: 10px;">
                <img src="images/logokotabogor_gray.gif" style="width: 70px;">
            </td>
            <td style="width: 90%; text-align: center; vertical-align: middle; border-bottom: double 2px black; padding-bottom: 10px;">
                <span style="font-size: 120%;">PEMERINTAH KOTA BOGOR</span><br>
                <span style="font-weight: bold;font-size:135%;padding-bottom: 20px;">BADAN KEPEGAWAIAN DAN PENGEMBANGAN <br>SUMBER DAYA APARATUR</span><br>
                <span>Jalan Julang I No. 7 Telp. (0251) 8382027 Fax. (0251) 8356170</span><br>B O G O R - 16161
            </td>
        </tr>
        <tr>
            <td colspan="2" >
                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 15px;">
                    <tr>
                        <td style="width: 65%"></td>
                        <td style="width: 15%;vertical-align: top; text-align: right"><span style="text-decoration: underline;">Bogor, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                        <td style="width: 20%;text-align: left;"><span style="text-decoration: underline;"><?php echo $this->umum_model->monthName(date("m")).' '.date("Y"); ?> M</span>
                            <br><?php echo $this->umum_model->getTglCurHijriyah(); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php foreach($dataRow as $data): ?>
            <?php
                $bln = $this->umum_model->monthName($data->bln);
                $thn = $data->thn;
                $id_kepala = $data->id_pegawai;
                $nama_kepala = $data->nama_kepala;
                $pangkat = $data->pangkat;
                $nip_baru = $data->nip_baru;
            ?>
        <tr>
            <td colspan="2">
                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 20px;">
                    <tr>
                        <td style="width: 70%; vertical-align: top;">
                        </td>
                        <td style="width: 30%;text-align: left;">
                            Kepada Yth.<br>
                            Kepala Badan Pengelolaan Keuangan dan Aset Daerah Kota Bogor<br>
                            di<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>B O G O R</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 80px;text-align: center;">
                            <span style="font-size: 16px;;font-weight: bold;text-decoration: underline">SURAT PENGANTAR</span><br>
                            <span>NOMOR : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                / &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - FDP</span>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-left: 0px;">
                            <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 50px;">
                                <tr>
                                    <td style="width: 5%;vertical-align: top;text-align: center;padding: 5px;">NO</td>
                                    <td style="width: 50%;vertical-align: top;text-align: center;padding: 5px;">JENIS YANG DIKIRIM</td>
                                    <td style="width: 20%;vertical-align: top;text-align: center;padding: 5px;">BANYAKNYA</td>
                                    <td style="width: 25%;vertical-align: top;text-align: center;padding: 5px;">KETERANGAN</td>
                                </tr>
                                <tr>
                                    <td style="width: 5%;vertical-align: top;text-align: center;padding: 5px;">1.</td>
                                    <td style="width: 50%;vertical-align: top;text-align: left;padding: 5px;">
                                        Penyampaian Daftar Rekapitulasi Perubahan Tunjangan Keluarga untuk usulan dengan penyetujuan di bulan
                                    <?php
                                        $bln = '';
                                        foreach($dataRowBlnDataP as $data2){
                                            $bln .= $this->umum_model->monthName($data2->bln_approve).' '.$data2->thn_approve.', ';
                                        }
                                        $bln = substr($bln,0,strlen($bln)-2);
                                        echo $bln;
                                    ?> di lingkungan Pemerintah Kota Bogor</td>
                                    <td style="width: 20%;vertical-align: top;text-align: center;padding: 5px;"><?php echo $data->jumlah_usulan; ?> (<?php echo $this->umum_model->kekata($data->jumlah_usulan);?>) Orang (data terlampir)</td>
                                    <td style="width: 25%;vertical-align: top;text-align: left;padding: 5px;">Disampaikan dengan hormat sebagai bahan lebih lanjut</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 80px;">
                    <tr>
                        <td style="width:60%;"></td>
                        <td style="width:40%;padding-left: 50px;">
                            <?php
                                $sql = "SELECT COUNT(id_jabatan_plt) as jumlah_all FROM jabatan_plt WHERE id_pegawai = $id_kepala AND id_j = 3082";
                                $query = $this->db->query($sql);
                                foreach ($query->result() as $row){
                                    $jmlPlhKaban = $row->jumlah_all;
                                }
                                if($jmlPlhKaban==true){
                                    $plt = 'Plt. ';
                                }else{
                                    $plt = '';
                                }
                            ?>
                            <strong><?php echo $plt; ?>Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Aparatur</strong>, <br><br><br><br><br>
                            <span style="text-decoration: none;font-weight: bold;"><?php echo $nama_kepala;?></span><br>
                            <?php echo $pangkat; ?><br>
                            NIP. <?php echo $nip_baru; ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</page>
    <page orientation="L" backtop="10mm" backbottom="10mm" backleft="25mm" backright="10mm" style="font-size: 9pt">
        <!--<page_footer>
            [[page_cu]]/[[page_nb]]
        </page_footer>-->
        <?php
            $pengantarNominatif = $this->ptk->nominatifRekapPTK_ByPengantar($idptr);
            $i = 1;
        ?>
        <div style="font-size: 14px;font-weight: bold;">
            DAFTAR NOMINATIF PENGAJUAN PENGUBAHAN TUNJANGAN KELUARGA (PENYETUJUAN DI BULAN <?php echo strtoupper($bln);?>)
        </div>
        <table border="1" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 10px;">
            <thead style="display:table-header-group;">
            <tr>
                <th style="vertical-align: middle;text-align:center;width: 3%;height: 30px;">No</th>
                <th style="vertical-align: middle;text-align:center;width: 15%;">Nama</th>
                <th style="vertical-align: middle;text-align:center;width: 12%;">NIP</th>
                <th style="vertical-align: middle;text-align:center;width: 5%;">Pangkat/Gol</th>
                <th style="vertical-align: middle;text-align:center;width: 15%;">Jabatan</th>
                <th style="vertical-align: middle;text-align:center;width: 15%;">OPD</th>
                <th style="vertical-align: middle;text-align:center;width: 10%;">Uraian Pengubahan</th>
                <th style="vertical-align: middle;text-align:center;width: 15%;" colspan="3">Menjadi</th>
                <th style="vertical-align: middle;text-align:center;width: 5%;">Jumlah</th>
            </tr>
            <tr>
                <th style="vertical-align: middle;text-align:center;width: 3%;height: 10px;">1</th>
                <th style="vertical-align: middle;text-align:center;width: 15%;">2</th>
                <th style="vertical-align: middle;text-align:center;width: 12%;">3</th>
                <th style="vertical-align: middle;text-align:center;width: 5%;">4</th>
                <th style="vertical-align: middle;text-align:center;width: 15%;">5</th>
                <th style="vertical-align: middle;text-align:center;width: 15%;">6</th>
                <th style="vertical-align: middle;text-align:center;width: 10%;">7</th>
                <th style="vertical-align: middle;text-align:center;width: 15%;" colspan="3">8</th>
                <th style="vertical-align: middle;text-align:center;width: 5%;">9</th>
            </tr></thead>
            <?php
                $dataRowNom = $this->ptk->nominatifRekapPTK_ByPengantar($idptr);
                $i = 1;
                $jmlData = sizeof($dataRowNom);
            ?>
            <?php foreach($dataRowNom as $rp): ?>
                <?php if($jmlData==$i): ?>
                    <tr>
                        <td style="width: 3%;padding: 3px;text-align: center;"><?php echo $i;?></td>
                        <td style="width: 15%;padding: 3px;"><?php echo $rp->nama;?></td>
                        <td style="width: 12%;padding: 3px;"><?php echo $rp->nip_baru;?></td>
                        <td style="width: 10%;padding: 3px;"><?php echo $rp->pangkat.' - '.$rp->last_gol;?></td>
                        <td style="width: 15%;padding: 3px;"><?php echo $rp->last_jabatan.' pada '.$rp->unit_kerja;?></td>
                        <td style="width: 15%;padding: 3px;"><?php echo $rp->opd;?></td>
                        <td style="width: 10%;padding: 3px;">
                            <?php echo (($rp->istri_nambah>0 OR $rp->suami_nambah>0)?' Penambahan':(($rp->istri_ngurang>0 OR $rp->suami_ngurang>0)?' Pengurangan':''))?><!--</td>-->
                            <!--<td>--><?php echo ($rp->istri_nambah>0?$rp->istri_nambah.' Orang Istri':($rp->suami_nambah>0?$rp->suami_nambah.' Orang Suami':
                                ($rp->istri_ngurang>0?$rp->istri_ngurang.' Orang Istri':($rp->suami_ngurang>0?$rp->suami_ngurang.' Orang Suami':'')))) ?>
                            <!--</td>-->
                            <!--<td>--><?php echo ($rp->anak_nambah>0?' Penambahan':($rp->anak_ngurang>0?' Pengurangan':''))?><!--</td>-->
                            <!--<td>--><?php echo ($rp->anak_nambah>0?$rp->anak_nambah.' Orang Anak':($rp->anak_ngurang>0?$rp->anak_ngurang.' Orang Anak':''))?>
                        </td>
                        <td style="width: 5%;padding: 3px;"><?php echo $rp->jml_pegawai_tertunjang;?> Orang Pegawai</td>
                        <td style="width: 5%;padding: 3px;"><?php echo $rp->last_jml_pasangan.' Orang'.($rp->jk==1?' Istri':' Suami');?></td>
                        <td style="width: 5%;padding: 3px;"><?php echo $rp->last_jml_anak;?> Orang Anak</td>
                        <td style="width: 5%;padding: 3px;"><?php echo $rp->jumlah_total_tertunjang;?> Orang</td>
                    </tr>
                <?php else: ?>
                <tr>
                    <td style="width: 3%;padding: 3px;text-align: center;"><?php echo $i;?></td>
                    <td style="width: 15%;padding: 3px;"><?php echo $rp->nama;?></td>
                    <td style="width: 12%;padding: 3px;"><?php echo $rp->nip_baru;?></td>
                    <td style="width: 10%;padding: 3px;"><?php echo $rp->pangkat.' - '.$rp->last_gol;?></td>
                    <td style="width: 15%;padding: 3px;"><?php echo $rp->last_jabatan.' pada '.$rp->unit_kerja;?></td>
                    <td style="width: 15%;padding: 3px;"><?php echo $rp->opd;?></td>
                    <td style="width: 10%;padding: 3px;">
                        <?php echo (($rp->istri_nambah>0 OR $rp->suami_nambah>0)?' Penambahan':(($rp->istri_ngurang>0 OR $rp->suami_ngurang>0)?' Pengurangan':''))?><!--</td>-->
                        <!--<td>--><?php echo ($rp->istri_nambah>0?$rp->istri_nambah.' Orang Istri':($rp->suami_nambah>0?$rp->suami_nambah.' Orang Suami':
                            ($rp->istri_ngurang>0?$rp->istri_ngurang.' Orang Istri':($rp->suami_ngurang>0?$rp->suami_ngurang.' Orang Suami':'')))) ?>
                        <!--</td>-->
                        <!--<td>--><?php echo ($rp->anak_nambah>0?' Penambahan':($rp->anak_ngurang>0?' Pengurangan':''))?><!--</td>-->
                        <!--<td>--><?php echo ($rp->anak_nambah>0?$rp->anak_nambah.' Orang Anak':($rp->anak_ngurang>0?$rp->anak_ngurang.' Orang Anak':''))?>
                    </td>
                    <td style="width: 5%;padding: 3px;"><?php echo $rp->jml_pegawai_tertunjang;?> Orang Pegawai</td>
                    <td style="width: 5%;padding: 3px;"><?php echo $rp->last_jml_pasangan.' Orang'.($rp->jk==1?' Istri':' Suami');?></td>
                    <td style="width: 5%;padding: 3px;"><?php echo $rp->last_jml_anak;?> Orang Anak</td>
                    <td style="width: 5%;padding: 3px;"><?php echo $rp->jumlah_total_tertunjang;?> Orang</td>
                </tr>
                <?php endif; ?>
            <?php $i++; ?>
            <?php endforeach; ?>
        </table>
        <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 40px;">
            <tr>
                <td style="width: 60%;"></td>
                <td style="width: 40%;text-align: center;">
                    <strong><?php echo $plt; ?>Kepala Badan Kepegawaian dan <br>Pengembangan Sumber Daya Aparatur</strong>, <br><br><br><br><br><br>
                    <span style="text-decoration: none;font-weight: bold;"><?php echo $nama_kepala;?></span><br>
                    <?php echo $pangkat; ?><br>
                    NIP. <?php echo $nip_baru; ?>
                </td>
            </tr>
        </table>
    </page>
<?php
$content = ob_get_clean();
try
{
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('surat_pengantar_ptk_bpkad.pdf');
}catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>
