<?php
session_start();
include ("BarcodeGenerator.php");
include ("BarcodeGeneratorJPG.php");
include 'class/cls_cuti.php';
$oCuti = new Cuti();

if(isset($_GET['idp']) and $_GET['idp']!=null){
    $idp = $_GET['idp'];
}else{
    $idp = $_SESSION['id_pegawai'];
}
$hijriMonth = array ("Muharram", "Safar", "(Rabi'ul Awal", "Rabi'ul Akhir", "Jumadil Awal", "Jumadil Akhir", "Rajab", "Sya'ban", "Ramadhan", "Syawal", "Dzulqa'dah", "Dzulhijjah");
$query_row_cuti_master = $oCuti->get_surat_cuti($idp, $_GET['idcm']);
$data = $query_row_cuti_master->fetch_array(MYSQLI_BOTH);
$tgl_cuti = $data['tgl_usulan'].' '.$oCuti->monthName($data['bln_usulan']).' '.$data['thn_usulan'];
$hijriDate = $oCuti->Greg2Hijri($data['tgl_usulan'], $data['bln_usulan'], $data['thn_usulan']);
$tgl_cuti_hijriyah = $hijriDate["day"].' '.$hijriMonth[$hijriDate["month"]-1].' '.$hijriDate["year"];

$idp = $data["id_pegawai"];
$nama = $data["nama"];
$nip = $data["nip_baru"];
$jabatan = $data["last_jabatan"];
$mskerja = $data["last_masa_kerja"];
$mskerja_text = $data["last_masa_kerja_text"];
$id_unit = $data["last_id_unit_kerja"];
$unit = $data["last_unit_kerja"];
$jenis_cuti = $data["id_jenis_cuti"];
$lama = (int)($data["lama_cuti"])+(int)($data["lama_cuti_n1"]);
$tmtmulai =  $data["tmt_awal_cuti"];
$tmtselesai =  $data["tmt_akhir_cuti"];
$alamat = $data["keterangan"];
$telp = $data["nokontak"];
$nip_atsl = $data["last_atsl_nip"];
$nama_atsl =  $data["last_atsl_nama"];
$jab_atsl = $data["last_atsl_jabatan"];
$nip_pjbt = $data["last_pjbt_nip"];
$nama_pjbt = $data["last_pjbt_nama"];
$jab_pjbt = $data["last_pjbt_jabatan"];
$alasan = $data["alasan_cuti"];
$sub_jenis_cuti = $data["sub_jenis_cuti"];
$is_cuti_mundur = $data["is_cuti_mundur"];
$is_kunjungan_luar_negeri = $data["is_kunjungan_luar_negeri"];
$last_atsl_id_j = $data["last_atsl_id_j"];
$last_pjbt_id_j = $data["last_pjbt_id_j"];

$call_sp = "CALL PRCD_CUTI_COUNT_HIST_GENERAL(".$_SESSION['id_pegawai'].");";
$res_query_sp = $oCuti->mysqli->query($call_sp);
$rowcount=$res_query_sp->num_rows;
if($rowcount>0) {
    $sisa_cuti_tahunan = 0;
    $cuti_besar = 0;
    $thn = date("Y");
    $res_query_sp->data_seek(0);
    while ($row_hist_general = $res_query_sp->fetch_assoc()) {
        if($row_hist_general["periode_thn"]==($thn-2)){
            if($row_hist_general["jml_cuti_besar"] > 0){
                $cn2 = 0;
            }else{
                $cn2 = $row_hist_general["sisa_kuota_cuti_tahunan"];
            }
            $sisa_cur_min_2 = $row_hist_general["sisa_kuota_cuti_tahunan"];
        }else if($row_hist_general["periode_thn"]==($thn-1)) {
            if($row_hist_general["jml_cuti_besar"] > 0){
                $cn1 = 0;
            }else{
                $cn1 = $row_hist_general["sisa_kuota_cuti_tahunan"];
            }
            $sisa_cur_min_1 = $row_hist_general["sisa_kuota_cuti_tahunan"];
            $sisa_cur_min_1_ori = $row_hist_general["sisa_kuota_cuti_tahunan"];
        }else{
            if($row_hist_general["jml_cuti_besar"] > 0){
                $cn = 0;
            }else{
                $cn = $row_hist_general["sisa_kuota_cuti_tahunan"];
            }
            $sisa_cur = $row_hist_general["sisa_kuota_cuti_tahunan"];
            $cbesar = $row_hist_general["jml_cuti_besar"];
            $csakit = $row_hist_general["jml_akumulasi_cuti_sakit_umum"] +
                $row_hist_general["jml_akumulasi_cuti_keguguran"] +
                $row_hist_general["jml_akumulasi_cuti_kecelakaan"];
            $cbersalin = $row_hist_general["jml_cuti_bersalin"];
            $calasan_penting = $row_hist_general["jml_akumulasi_cuti_alasan_penting"];
            $ccltn = $row_hist_general["jml_cuti_cltn"];
        }
    }
    $res_query_sp->close();
    $oCuti->mysqli->next_result();
}
ob_start();

$cn2_b = ($sisa_cur_min_2<0?0:(($sisa_cur_min_1_ori+$sisa_cur_min_2)<0?0:(($sisa_cur+$sisa_cur_min_2)<0?0:$sisa_cur+$sisa_cur_min_2)));
$cn1_b = ($sisa_cur_min_1_ori<0?0:(($sisa_cur+$sisa_cur_min_2+$sisa_cur_min_1_ori)<0?0:(($sisa_cur+$sisa_cur_min_2+$sisa_cur_min_1)>$sisa_cur_min_1?($sisa_cur_min_1_ori<0?0:$sisa_cur_min_1):(($sisa_cur+$sisa_cur_min_2+$sisa_cur_min_1)<0?0:($sisa_cur+$sisa_cur_min_2+$sisa_cur_min_1)))));
$cn_b = ($sisa_cur<0?0:$sisa_cur);


?>

    <style>
        table#tbl_surat {
            margin-top: 5px;
            width: 100%;
            border-top: 1px solid black;
        }
        table#tbl_surat tr {
            background-color: #fff;
            text-align: left;
        }
        table#tbl_surat td {
            padding: 3px;
            width: 100%;
            border-bottom: 1px solid black;
            border-right: 1px solid black;
        }
    </style>

    <page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" style="font-size: 8pt">
        <table border="0" cellspacing="0" cellpadding="0"
               style="width: 100%;">
            <tr>
                <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td width="500">&nbsp;</td>
                            <td>Bogor,<u> <?php echo @$tgl_cuti; ?></u><br>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;
                                <?php  echo @$tgl_cuti_hijriyah; ?></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>Kepada</td>
                        </tr>
                        <tr>
                            <td align="right">Yth.</td>
                            <td>Kepala BKPSDA Kota Bogor</td>
                        </tr>
                        <tr>
                            <td align="left">&nbsp;</td>
                            <td>&nbsp;&nbsp; di -</td>
                        </tr>
                        <tr>
                            <td align="left">&nbsp;</td>
                            <td>&nbsp;&nbsp; B O G O R</td>
                        </tr>
                    </table></td>
            </tr>
            <tr><td align="center">&nbsp;</td></tr>
            <tr>
                <td align="center" style="padding-left: 100px;"><strong>FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</strong></td>
            </tr>
        </table>
        <table id="tbl_surat" align="left" cellpadding="0" cellspacing="0"
               style="margin-top: 10px;">
            <tr>
                <td colspan="4" style="border-left: 1px solid black;">I. DATA PEGAWAI</td>
            </tr>
            <tr>
                <td style="width: 15%;border-left: 1px solid black;">Nama</td>
                <td style="width: 35%;"><?php echo $nama;?></td>
                <td style="width: 20%;">NIP</td>
                <td style="width: 30%;"><?php echo $nip;?></td>
            </tr>
            <tr>
                <td style="width: 15%;border-left: 1px solid black;">Jabatan</td>
                <td style="width: 35%;"><?php echo $jabatan;?></td>
                <td style="width: 20%;">Masa Kerja Keseluruhan</td>
                <td style="width: 30%;"><?php echo ($mskerja_text==''?$mskerja.' Tahun':$mskerja_text)?></td>
            </tr>
            <tr>
                <td style="width: 15%;border-left: 1px solid black;">Unit Kerja</td>
                <td style="width: 85%;" colspan="3"><?php echo $unit;?></td>
            </tr>
        </table><br>

        <table id="tbl_surat" align="left" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="4" style="border-left: 1px solid black;">II. JENIS CUTI YANG DIAMBIL</td>
            </tr>
            <tr>
                <td style="width: 35%;border-left: 1px solid black;">1. Cuti Tahunan</td>
                <td style="width: 15%;">
                    <?php echo ($jenis_cuti=='C_TAHUNAN'?
                        '<style>span{font-family: dejavusans;}</style>
                    <span style="font-size:large;">&#10004;</span>'.($is_cuti_mundur==1?' (Cuti Mundur)':''):'');
                    ?>
                </td>
                <td style="width: 35%;">2. Cuti Besar</td>
                <td style="width: 15%;">
                    <?php echo ($jenis_cuti=='C_BESAR'?
                        '<style>span{font-family: dejavusans;}</style>
                    <span style="font-size:large;">&#10004;</span>'.($is_cuti_mundur==1?' (Cuti Mundur)':''):'');
                    ?>
                </td>
            </tr>
            <tr>
                <td style="width: 35%;border-left: 1px solid black;">3. Cuti Sakit</td>
                <td style="width: 15%;">
                    <?php echo ($jenis_cuti=='C_SAKIT'?
                        '<style>span{font-family: dejavusans;}</style>
                    <span style="font-size:large;">&#10004;</span>'.($is_cuti_mundur==1?' (Cuti Mundur)':''):'');
                    ?>
                </td>
                <td style="width: 35%;">4. Cuti Melahirkan</td>
                <td style="width: 15%;">
                    <?php echo ($jenis_cuti=='C_BERSALIN'?
                        '<style>span{font-family: dejavusans;}</style>
                    <span style="font-size:large;">&#10004;</span>'.($is_cuti_mundur==1?' (Cuti Mundur)':''):'');
                    ?>
                </td>
            </tr>
            <tr>
                <td style="width: 35%;border-left: 1px solid black;">5. Cuti Karena Alasan Penting</td>
                <td style="width: 15%;">
                    <?php echo ($jenis_cuti=='C_ALASAN_PENTING'?
                        '<style>span{font-family: dejavusans;}</style>
                    <span style="font-size:large;">&#10004;</span>'.($is_cuti_mundur==1?' (Cuti Mundur)':''):'');
                    ?>
                </td>
                <td style="width: 35%;">6. Cuti di Luar Tanggungan Negara</td>
                <td style="width: 15%;">
                    <?php echo ($jenis_cuti=='CLTN'?
                        '<style>span{font-family: dejavusans;}</style>
                    <span style="font-size:large;">&#10004;</span>'.($is_cuti_mundur==1?' (Cuti Mundur)':''):'');
                    ?>
                </td>
            </tr>
        </table><br>

        <table id="tbl_surat" align="left" cellpadding="0" cellspacing="0">
            <tr>
                <td style="border-left: 1px solid black;">
                    III. ALASAN CUTI
                </td>
            </tr>
            <tr>
                <td style="height: 20px;border-left: 1px solid black;">

                    <?php
                    if($is_kunjungan_luar_negeri==1){
                        echo "Kunjungan ke Luar Negeri. ";
                    }
                    if($jenis_cuti=='C_SAKIT'){
                        $sqlSkt = " SELECT cjs.jenis_cuti_sakit, CASE WHEN cs.idjenis_cuti_sakit = 1 
                                    THEN (CASE WHEN cs.flag_sakit_baru = 1 THEN 'Usulan Baru' ELSE 'Usulan Perpanjangan' END) 
                                    ELSE NULL END AS flag
                                    FROM cuti_sakit cs, cuti_jenis_sakit cjs
                                    WHERE cs.id_cuti_master = ".$_GET['idcm']." AND cs.idjenis_cuti_sakit = cjs.idjenis_cuti_sakit";
                        $qSkt = $oCuti->mysqli->query($sqlSkt);
                        while ($row = $qSkt->fetch_assoc()) {
                            $jnsSkt = $row["jenis_cuti_sakit"];
                            $flag = $row["flag"];
                        }
                        echo $jnsSkt.($flag==''?'':' ('.$flag.').').' Keterangan Lain : '.$alasan;
                    }elseif($jenis_cuti=='C_BESAR' or $jenis_cuti=='C_ALASAN_PENTING' or $jenis_cuti=='CLTN') {
                        $sqlNonSkt = "SELECT * FROM simpeg.cuti_jenis_non_sakit 
                                      WHERE kode_sub_jenis_cuti_nonsakit = '" . $sub_jenis_cuti . "'";
                        $qNSkt = $oCuti->mysqli->query($sqlNonSkt);
                        while ($row = $qNSkt->fetch_assoc()) {
                            $jnsNSkt = $row["jenis_cuti_nonsakit"];
                        }
                        echo $jnsNSkt . '.'.' Keterangan Lain : '.$alasan;
                    }else{
                        echo $alasan.'. ';
                    }
                    ?>
                </td>
            </tr>
        </table><br>

        <table id="tbl_surat" align="left" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="4" style="border-left: 1px solid black;">
                    IV. LAMANYA CUTI
                </td>
            </tr>
            <tr>
                <td style="width: 15%;border-left: 1px solid black;">Selama</td>
                <td style="width: 35%;"><?php echo $lama?> (Hari / <span style="text-decoration:line-through">Bulan</span> / <span style="text-decoration:line-through">Tahun</span>)</td>
                <td style="width: 20%;">Mulai Tanggal</td>
                <td style="width: 30%;"><?php echo $tmtmulai.' s/d '.$tmtselesai; ?></td>
            </tr>
        </table><br>

        <table id="tbl_surat" align="left" cellpadding="0" cellspacing="0"
        >
            <tr>
                <td colspan="5" style="border-left: 1px solid black;">
                    V. CATATAN CUTI
                </td>
            </tr>
            <tr>
                <td colspan="3" style="width: 40%;border-left: 1px solid black;">
                    1. CUTI TAHUNAN
                </td>
                <td style="width: 40%;">2. CUTI BESAR</td>
                <td style="width: 20%;"><?php echo $cbesar;?> Hari</td>
            </tr>
            <tr>
                <td style="width: 10%;border-left: 1px solid black;">Tahun</td>
                <td style="width: 10%;text-align: center;">Sisa</td>
                <td style="width: 20%;text-align: center;">Keterangan</td>
                <td style="width: 40%;">3. CUTI SAKIT</td>
                <td style="width: 20%;"><?php echo $csakit;?> Hari</td>
            </tr>
            <tr>
                <td style="width: 10%;border-left: 1px solid black;">N-2</td>
                <td style="width: 10%;"><?php echo $cn2." ($cn2_b)";?> Hari</td>
                <td style="width: 20%;"></td>
                <td style="width: 40%;">4. CUTI MELAHIRKAN</td>
                <td style="width: 20%;"><?php echo $cbersalin;?> Hari</td>
            </tr>
            <tr>
                <td style="width: 10%;border-left: 1px solid black;">N-1</td>
                <td style="width: 10%;"><?php echo $cn1." ($cn1_b)";?> Hari</td>
                <td style="width: 20%;"></td>
                <td style="width: 40%;">5. CUTI KARENA ALASAN PENTING</td>
                <td style="width: 20%;"><?php echo $calasan_penting;?> Hari</td>
            </tr>
            <tr>
                <td style="width: 10%;border-left: 1px solid black;">N</td>
                <td style="width: 10%;"><?php echo $cn." ($cn_b)";?> Hari</td>
                <td style="width: 20%;"></td>
                <td style="width: 40%;">6. CUTI DI LUAR TANGGUNGAN NEGARA</td>
                <td style="width: 20%;"><?php echo $ccltn;?> Hari</td>
            </tr>
        </table><br>

        <table id="tbl_surat" align="left" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="3" style="border-left: 1px solid black;width: 100%;">
                    VI. ALAMAT SELAMA MENJALANKAN CUTI
                </td>
            </tr>
            <tr>
                <td style="width:60%;border-left: 1px solid black;"><?php echo $alamat; ?></td>
                <td style="width:10%;">TELP</td>
                <td style="width:30%;"><?php echo $telp?></td>
            </tr>
            <tr>
                <td style="width:60%;border-left: 1px solid black;"></td>
                <td colspan="2" style="text-align: center;width:40%;">
                    Hormat Saya,<br><br><br><br><br>
                    <span style="text-decoration: underline;
                font-weight: bold;">
                    <?php echo $nama;?></span><br>
                    NIP. <?php echo $nip;?>
                </td>
            </tr>
        </table><br>

        <table id="tbl_surat" align="left" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="4" style="width: 100%;border-left: 1px solid black;">
                    VII. PERTIMBANGAN ATASAN LANGSUNG<sup>**</sup>
                </td>
            </tr>
            <tr>
                <td style="width:25%;border-left: 1px solid black;">DISETUJUI</td>
                <td style="width:25%;">PERUBAHAN</td>
                <td style="width:25%;">DITANGGUHKAN</td>
                <td style="width:25%;">TIDAK DISETUJUI</td>
            </tr>
            <tr>
                <td style="width:25%;border-left: 1px solid black;">&nbsp;</td>
                <td style="width:25%;"></td>
                <td style="width:25%;"></td>
                <td style="width:25%;"></td>
            </tr>
            <tr>
                <td colspan="2" style="width:50%;border-bottom: 0px;border-left: 0px;"></td>
                <td colspan="2" style="width:50%;text-align: center;">
                    <?php
                    $sql = "SELECT pjbt.*, j.jabatan, j.id_unit_kerja FROM
                                (SELECT atsl.*, jp.id_j FROM
                                (SELECT p.id_pegawai as idp_atasan
                                FROM pegawai p WHERE nip_baru = '".$nip_atsl."') atsl
                                LEFT JOIN jabatan_plt jp ON atsl.idp_atasan = jp.id_pegawai) pjbt
                                LEFT JOIN jabatan j ON pjbt.id_j = j.id_j";
                    $query_row_atsl = $oCuti->mysqli->query($sql);
                    $data_atsl = $query_row_atsl->fetch_array(MYSQLI_ASSOC);
                    if($data_atsl['id_j']==''){
                        if(strpos($jab_atsl, 'PLH') !== false){
                            echo($jab_atsl);
                        }else{
                            echo substr($jab_atsl,0,strpos($jab_atsl, 'Kota Bogor')-1);
                        }
                    }else{

                        if($id_unit == $data_atsl['id_unit_kerja']){
                            if($last_atsl_id_j==$data_atsl['id_j']){
                                echo 'Plt. '.substr($data_atsl['jabatan'],0,strpos($data_atsl['jabatan'], 'Kota Bogor')-1);
                            }else{
                                echo substr($jab_atsl,0,strpos($jab_atsl, 'Kota Bogor')-1);
                            }
                        }else{
                            echo substr($jab_atsl,0,strpos($jab_atsl, 'Kota Bogor')-1);
                        }
                    }
                    ?>,
                    <br><br><br><br><br><br>
                    <span style="text-decoration: underline;font-weight: bold;">
                    <?php echo $nama_atsl;?></span><br>
                    NIP. <?php echo $nip_atsl;?>
                </td>
            </tr>
        </table><br>

        <table id="tbl_surat" align="left" cellpadding="0" cellspacing="0">
            <tr>
                <td colspan="4" style="width: 100%;border-left: 1px solid black;">
                    VIII. KEPUTUSAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI<sup>**</sup>
                </td>
            </tr>
            <tr>
                <td style="width:25%;border-left: 1px solid black;">DISETUJUI</td>
                <td style="width:25%;">PERUBAHAN</td>
                <td style="width:25%;">DITANGGUHKAN</td>
                <td style="width:25%;">TIDAK DISETUJUI</td>
            </tr>
            <tr>
                <td style="width:25%;border-left: 1px solid black;">&nbsp;</td>
                <td style="width:25%;"></td>
                <td style="width:25%;"></td>
                <td style="width:25%;"></td>
            </tr>
            <tr>
                <td colspan="2" style="width:50%;border-bottom: 0px;border-left: 0px;vertical-align: bottom;"><br>
                    <?php
                    $generator = new Picqer\Barcode\BarcodeGeneratorJPG();
                    echo '<img src="data:image/jpg;base64,' . base64_encode($generator->getBarcode(@$nip, $generator::TYPE_INTERLEAVED_2_5)) . '">';
                    echo $nip.'-'.$_GET['idcm'];
                    echo '<br><br>Catatan:<br>'.'<sup>**</sup> Pilih salah satu dengan memberi tanda centang ('.
                        '<style>span{font-family: dejavusans;}</style><span style="font-size:large;">&#10004;</span>'.') dan alasannya<br>'.
                        'N &nbsp;&nbsp; = Sisa cuti tahun berjalan<br>
                        N-1 = Sisa cuti 1 tahun sebelumnya<br>
                        N-2 = Sisa cuti 2 tahun sebelumnya';
                    ?>
                </td>
                <td colspan="2" style="width:50%;text-align: center;">
                    <?php
                    $sql = "SELECT pjbt.*, j.jabatan, j.id_unit_kerja FROM
                                    (SELECT atsl.*, jp.id_j FROM
                                    (SELECT p.id_pegawai as idp_atasan
                                    FROM pegawai p WHERE nip_baru = '".$nip_pjbt."') atsl
                                    LEFT JOIN jabatan_plt jp ON atsl.idp_atasan = jp.id_pegawai) pjbt
                                    LEFT JOIN jabatan j ON pjbt.id_j = j.id_j";

                    $query_row_atsl = $oCuti->mysqli->query($sql);
                    $data_atsl = $query_row_atsl->fetch_array(MYSQLI_ASSOC);

                    if($data_atsl['id_j']==''){
                        if($jab_pjbt=='Walikota Bogor'){
                            echo 'Wali Kota Bogor';
                        }else{
                            echo substr($jab_pjbt,0,strpos($jab_pjbt, 'Kota Bogor')-1);
                        }
                    }else{
                        if($id_unit == $data_atsl['id_unit_kerja']){
                            if($last_pjbt_id_j==$data_atsl['id_j']){
                                echo 'Plt. '.substr($data_atsl['jabatan'],0,strpos($data_atsl['jabatan'], 'Kota Bogor')-1);
                            }else{
                                echo substr($jab_pjbt,0,strpos($jab_pjbt, 'Kota Bogor')-1);
                            }
                        }else{
                            if(strpos($jab_pjbt, 'Walikota Bogor')!==false){
                                if(strpos($jab_pjbt, 'Plt')!==false){
                                    echo 'Plh. Wali Kota Bogor';
                                }else{
                                    echo 'Wali Kota Bogor';
                                }
                            }else{
                                echo substr($jab_pjbt,0,strpos($jab_pjbt, 'Kota Bogor')-1);
                            }
                        }
                    }
                    ?>,
                    <br><br><br><br><br><br>
                    <span style="text-decoration: underline;font-weight: bold;">
                    <?php echo $nama_pjbt;?></span><br>
                    <?php
                    if($jab_pjbt=='Walikota Bogor'){

                    }else{
                        echo 'NIP. '.$nip_pjbt;
                    }
                    ?>

                </td>
            </tr>
        </table>
    </page>

<?php
$content = ob_get_clean();

require_once('html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('P', 'Legal', 'fr', true, 'UTF-8', 0);
    $html2pdf->addFont('dejavusans');
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    //attachment
    //$html2pdf->Output('bookmark.pdf',F);
    //inline
    $html2pdf->Output('Surat_Cuti_'.$_GET['idcm'].'.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>