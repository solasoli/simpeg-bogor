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
    <table border="0" cellspacing="0" cellpadding="0" style="width: 95%;">
        <tr>
            <td style="width: 10%; padding-bottom: 150px;"> <!-- border-bottom: double 2px black;  -->
                <!--<img src="images/logokotabogor_gray.gif" style="width: 70px;">-->
            </td>
            <td style="width: 90%; text-align: center; vertical-align: middle;
                padding-bottom: 150px;"> <!-- border-bottom: double 2px black;  -->
                <!--<span style="font-size: 120%;">PEMERINTAH KOTA BOGOR</span><br>
                <span style="font-weight: bold;font-size:135%;padding-bottom: 20px;">BADAN KEPEGAWAIAN DAN PENGEMBANGAN <br>SUMBER DAYA APARATUR</span><br>
                <span>Jl. Ir. H. Juanda No. 10 Telp. (0251) 8358942 Fax. (0251) 8356170</span><br>B O G O R - 16121-->
            </td>
        </tr>
        <?php foreach($dataRow as $data): ?>
            <?php
                $idp = $data->id_pegawai;
                $id_ptk = $data->id_ptk;
                $nipp = $data->nip_baru;
                $namap = $data->nama;
                $unit = $data->unit_kerja;
                $nomor = $data->nomor;
                $tglpengajuan = $data->tgl_pengajuan;
                $jmlPasangan = $data->last_jml_pasangan;
                $jmlAnak = $data->last_jml_anak;
                $nmPengesah = $data->nama_pengesah;
                $nipPengesah = $data->nip_pengesah;
                $pktPengesah = $data->pangkat_pengesah;
                $flagAn = $data->flag_atas_nama;
                $jabPengesah = $data->jabatan;
                $jk = $data->jenis_kelamin;
                $opd = $data->opd;
                $idp_Pengesah = $data->id_pegawai_pengesah;
                $eselonP = $data->eselon;
                $gol = $data->last_gol;
                $id_pegawai_plt = $data->id_pegawai_plt;
                $id_pegawai_plh = $data->id_pegawai_plh;
            ?>
        <tr>
            <td colspan="2" style="text-align: right">
                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 25px;">
                    <tr>
                        <td style="width: 60%"></td>
                        <td style="width: 10%;vertical-align: top;" align="left"><span style="text-decoration: underline;">Bogor, &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
                        <td style="width: 30%;text-align: left;" align="left"><span style="text-decoration: underline;"><?php echo $this->umum_model->monthName(date("m")).' '.date("Y"); ?> M</span>
                        <br><?php echo $this->umum_model->getTglCurHijriyah(); ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 20px;">
                    <tr>
                        <td style="width: 60%; vertical-align: top;">
                            <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;">
                                <tr>
                                    <td style="width: 18%">Nomor</td>
                                    <td style="width: 2%">:</td>
                                    <td style="width: 60%">841.6/&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-<?php echo($jabPengesah=='Sekretaris Daerah Kota Bogor'?' BKPSDA':' FDP');?><?php //echo $data->nomor_sk_ptk; ?></td>
                                </tr>
                                <tr>
                                    <td>Sifat</td><td>:</td><td><?php echo $data->sifat_sk_ptk; ?></td>
                                </tr>
                                <tr>
                                    <td>Lampiran</td><td>:</td><td><?php echo $data->lampiran_sk_ptk; ?></td>
                                </tr>
                                <tr>
                                    <td>Hal</td><td>:</td><td style="width:60%">
                                        <span style="font-weight: bold;">Perubahan Tunjangan Keluarga</span></td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 40%;text-align: left;">
                            Kepada <br>
                            Yth. Kepala Badan Pengelolaan Keuangan<br>
                            dan Aset Daerah Kota Bogor<br>
                            di<br><strong>B O G O R</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 20px;padding-left: 90px;">
                            Dengan ini diberitahukan bahwa Pegawai Negeri Sipil yang namanya tersebut di bawah ini :<br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 20px;">
                                <tr>
                                    <td style="width: 15%;" rowspan="7"></td>
                                    <td style="width: 25%; text-align: left;vertical-align: top;">Nama</td>
                                    <td style="width: 2%;vertical-align: top;">:</td>
                                    <td style="width: 55%;text-align: left;"><strong><?php echo $data->nama; ?></strong></td>
                                </tr>
                                <tr>
                                    <td style="width: 25%; text-align: left;">NIP</td>
                                    <td style="width: 2%;vertical-align: top;">:</td>
                                    <td style="width: 55%;text-align: left;"><?php echo $data->nip_baru; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 25%; text-align: left;">Pangkat/Gol. Ruang</td>
                                    <td style="width: 2%;vertical-align: top;">:</td>
                                    <td style="width: 55%;text-align: left;"><?php echo "$data->pangkat - $data->last_gol"; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 25%; text-align: left;vertical-align: top;">Jabatan</td>
                                    <td style="width: 2%;vertical-align: top;">:</td>
                                    <td style="width: 55%;text-align: left;"><?php echo $data->last_jabatan; ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 25%; text-align: left;vertical-align: top;">Unit Kerja</td>
                                    <td style="width: 2%;vertical-align: top;">:</td>
                                    <td style="width: 55%;text-align: left;"><?php echo $data->unit_kerja; ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 20px;padding-left: 90px;">
                            Telah diadakan perubahan tunjangan keluarga dengan jenis perubahan sebagai berikut :
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td></td>
            <td style="padding-left: 20px;">
                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 0px;">
            <?php foreach($dataRowKeluarga as $data): ?>
                    <tr>
                        <td style="width: 5%; vertical-align: top;">
                            <?php echo '<p>'.$data->no_urut.'.</p>'; ?>
                        </td>
                        <td style="width: 89%;text-align: left;vertical-align: top;">
                            <?php echo '<p align="justify"><strong>'.$data->kategori_pengubahan.'</strong> : '.$data->jumlah.' ('.$this->umum_model->kekata($data->jumlah).' ) orang '.
                                $data->status_keluarga.' bernama : '.$data->uraian.', '.
                                ($data->no_urut==$jmlRowKeluarga?'serta berdasarkan Surat Pengantar dari '.($opd=='Sekretariat Daerah Kota Bogor'?'Sekretaris Daerah kota Bogor':'Kepala '.$opd).
                                    ' Nomor : '.$nomor.', tanggal '.$tglpengajuan.', perihal Perubahan Tunjangan Keluarga sehingga menjadi : ':'').'</p>'; ?>
                        </td>
                    </tr>
            <?php endforeach; ?>
                    <tr>
                        <td></td>
                        <td>
                            <table border="0" cellspacing="5" cellpadding="0" style="width: 100%;margin-top: 5px;">
                                <tr>
                                    <td style="width: 40%"></td>
                                    <td>1 Orang Pegawai</td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td><?php echo $jmlPasangan; ?> Orang <?php echo($jk==1?'Istri':'Suami'); ?></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td style="border-bottom: 1px solid #0f0f0e;"><?php echo $jmlAnak; ?> Orang Anak</td>
                                </tr>
                                <tr>
                                    <td style="text-align: right;padding-top: 5px;">Jumlah : </td>
                                    <td style="padding-top: 5px;"><?php echo (Int)$jmlAnak+(Int)$jmlPasangan+1; ?> Orang</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-top: 15px;padding-left: 0px;">Demikian surat pemberitahuan ini dibuat sebagai bahan pertimbangan lebih lanjut.</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%;margin-top: 60px;">
                    <tr>
                        <td style="width:60%"></td>
                        <td style="width:40%">
                            <?php
                                $ketPlt = '';
                                $ketPlh = '';
                                if($id_pegawai_plt!=''){
                                    $ketPlt = 'Plt. ';
                                }

                                if($id_pegawai_plh!=''){
                                    $ketPlh = 'Plh. ';
                                }
                            ?>
                            <?php if($flagAn==0): ?>
                                <strong>Kepala</strong>, <br><br><br><br><br>
                                <span style="text-decoration: none;font-weight: bold;"><?php echo $nmPengesah;?></span><br>
                                <?php echo $pktPengesah; ?><br>
                                NIP. <?php echo $nipPengesah; ?>
                            <?php elseif($flagAn==1):?>
                                <span >a.n.&nbsp;&nbsp;</span><strong>Kepala</strong><br>
                                <strong><?php echo $ketPlt.$ketPlh; ?>Sekretaris</strong>, <br><br><br><br><br>
                                <span style="text-decoration: none;font-weight: bold;"><?php echo $nmPengesah;?></span><br>
                                <?php echo $pktPengesah; ?><br>
                                NIP. <?php echo $nipPengesah; ?>
                            <?php elseif($flagAn==2):?>
                                <span >a.n.&nbsp;&nbsp;</span><strong>Kepala</strong><br>
                                <strong><?php echo $ketPlt.$ketPlh; ?>Sekretaris</strong>,<br>
                                <span style="margin-left: 20px;">u.b.</span><br>
                                <strong><?php echo ucfirst(substr($jabPengesah,0,strpos($jabPengesah,' pada')));?></strong>, <br><br><br><br><br>
                                <span style="text-decoration: none;font-weight: bold;"><?php echo $nmPengesah;?></span><br>
                                <?php echo $pktPengesah; ?><br>
                                NIP. <?php echo $nipPengesah; ?>
                            <?php elseif($flagAn==4):?>
                                <?php
                                    if($eselonP=='IIIA'){
                                        $sql = "SELECT COUNT(id_jabatan_plt) as jumlah_all FROM jabatan_plt WHERE id_pegawai = $idp_Pengesah AND id_j = 3082";
                                        $query = $this->db->query($sql);
                                        foreach ($query->result() as $row){
                                            $jmlPlhKaban = $row->jumlah_all;
                                        }
                                        if($jmlPlhKaban>0){
                                            $isPlhKaban = true;
                                        }else{
                                            $isPlhKaban = false;
                                        }
                                    }else{
                                        if($gol >= 'IV/a'){
                                            $sql = "SELECT COUNT(id_jabatan_plt) as jumlah_all FROM jabatan_plt WHERE id_pegawai = $idp_Pengesah AND id_j = 3082";
                                            $query = $this->db->query($sql);
                                            foreach ($query->result() as $row){
                                                $jmlPlhKaban = $row->jumlah_all;
                                            }
                                            if($jmlPlhKaban>0){
                                                $isPlhKaban = true;
                                            }else{
                                                $isPlhKaban = false;
                                            }
                                        }else{
                                            $isPlhKaban = false;
                                        }
                                    }
                                if($isPlhKaban==true){
                                    echo '<strong>Plt. Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Aparatur</strong>,<br>';
                                    echo "<span style=\"margin-left: 20px;\">u.b.</span><br>";
                                }else{
                                    echo '<strong>Sekretaris Daerah</strong>,';
                                }
                                ?>
                                <br><br><br><br><br>
                                <span style="text-decoration: none;font-weight: bold;"><?php echo $nmPengesah;?></span><br>
                                <?php echo $pktPengesah; ?><br>
                                NIP. <?php echo $nipPengesah; ?>
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
                                <?php if($eselonP=='IIB'): ?>
                                <?php else: ?>
                                    <?php if (strpos($unit, 'Sekretariat Daerah') !== false): ?>
                                    <?php else: ?>
                                        <li>Inspektur Kota Bogor;</li>
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
                                    <?php if($eselonP=='IIIA'): ?>
                                        <li>Asisten <?php echo substr($unit, strpos($unit, 'Bagian')+7,strlen($unit)) ?>;</li>
                                    <?php else: ?>
                                        <li>Kepala Bagian <?php echo substr($unit, strpos($unit, 'Bagian')+7,strlen($unit)) ?>;</li>
                                    <?php endif ?>
                                <?php else: ?>
                                    <?php if($eselonP=='IIB'): ?>
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
                                $qrCode = new QrCode($idp.'-'.$id_ptk.'-'.$nipp.'-'.$namap);
                                $qrCode->setSize(100);
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
    </table>
</page>
<?php
    $content = ob_get_clean();
    try {
        $html2pdf = new HTML2PDF('P', 'Legal', 'en', true, 'UTF-8', 0);
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        $html2pdf->Output('surat_ptk_bpkad.pdf');
    }catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>
