<?php
session_start();
extract($_GET);
include("konek.php");

$call_sp = "CALL PRCD_CUTI_COUNT_HIST_GENERAL(".$_SESSION['id_pegawai'].");";

$res_query_sp = $mysqli->query($call_sp);
$rowcount=$res_query_sp->num_rows;

if($rowcount>0){
    $sisa_cuti_tahunan = 0;
    $cuti_tahunan = 0;
    $cuti_besar = 0;
    $cuti_sakit_umum = 0;
    $cuti_sakit_keguguran = 0;
    $cuti_sakit_kecelakaan = 0;
    $cuti_bersalin = 0;
    $cuti_alasan_penting = 0;
    $cuti_cltn = 0;

    $res_query_sp->data_seek(0);
    while ($row_hist_general = $res_query_sp->fetch_assoc()) {
        if($row_hist_general["periode_thn"]==date("Y")){
            $cuti_sakit_umum = $row_hist_general["jml_akumulasi_cuti_sakit_umum"];
            $cuti_sakit_keguguran = $row_hist_general["jml_akumulasi_cuti_keguguran"];
            $cuti_sakit_kecelakaan = $row_hist_general["jml_akumulasi_cuti_kecelakaan"];
            $cuti_bersalin = $row_hist_general["jml_cuti_bersalin"];
            $cuti_alasan_penting = $row_hist_general["jml_akumulasi_cuti_alasan_penting"];
            $cuti_cltn = $row_hist_general["jml_cuti_cltn"];
        }
        if($row_hist_general["periode_thn"]==date("Y")){
            $cuti_besar = $row_hist_general["jml_cuti_besar"];
            if($cuti_besar>0){
                $sisa_cuti_tahunan = 0;
            }
            $sisa_cur = $row_hist_general["sisa_kuota_cuti_tahunan"];
        }elseif($row_hist_general["periode_thn"]==date("Y")-1){
            $sisa_cur_min_1 = $row_hist_general["sisa_kuota_cuti_tahunan"];
        }elseif($row_hist_general["periode_thn"]==date("Y")-2){
            $sisa_cur_min_2 = $row_hist_general["sisa_kuota_cuti_tahunan"];
        }
    }

    if($sisa_cur_min_2 <0){
        $sisa_cur_min_2 = 0;
    }else{
        if(($sisa_cur_min_1+$sisa_cur_min_2)<0){
            $sisa_cur_min_2 = 0;
        }else{
            if($sisa_cur_min_1 <0){
                $sisa_cur_min_2 = ($sisa_cur_min_1+$sisa_cur_min_2);
            }
        }
    }

    if($sisa_cur_min_1 <0){
        $sisa_cur_min_1 = 0;
    }

    $sisa_cuti_tahunan = $sisa_cur + $sisa_cur_min_1 + $sisa_cur_min_2;
    if($sisa_cuti_tahunan<0){
        $sisa_cuti_tahunan = 0;
    }
}

$mysqli->next_result();

if($idJnsCuti <> 'C_SAKIT'){
    $sql = "SELECT * FROM cuti_jenis WHERE id_jenis_cuti = '".$idJnsCuti."'";
    $query = mysqli_query($mysqli, $sql);
    $array_data = array();
    while ($row = mysqli_fetch_array($query)) {
        $array_data[] = $row;
    }
    $desk = $array_data[0]['deskripsi'];
    $masa_kerja_min = $array_data[0]['masa_kerja_min'];
    $kuota_min_hari = $array_data[0]['kuota_min_hari'];
    $kuota_max_hari = $array_data[0]['kuota_max_hari'];
    $ket_kuota = $array_data[0]['ket_kuota'];
    $ket_lainnya = $array_data[0]['keterangan_lainnya'];

    switch ($idJnsCuti) {
        case 'C_TAHUNAN':
            $kuota_cuti = $sisa_cuti_tahunan;
            break;
        case 'C_BESAR':
            if($cuti_besar>0){
                $kuota_cuti = 0;
            }else{
                $sql = "SELECT DATE_FORMAT(a.tgl_selesai_cut_besar, '%d-%m-%Y') AS tgl_selesai_cut_besar,
                            DATE_FORMAT(a.tgl_mulai_berlaku_next, '%d-%m-%Y') AS tgl_mulai_berlaku_next, 
                            CASE WHEN a.tgl_selesai_cut_besar IS NULL THEN 1 ELSE
                            (CASE WHEN NOW() < a.tgl_mulai_berlaku_next THEN 0 ELSE 1 END) END AS can_cut_besar_now FROM
                            (SELECT MAX(cm.tmt_akhir) AS tgl_selesai_cut_besar,
                            DATE_ADD(DATE_ADD(cm.tmt_akhir, INTERVAL 5 YEAR), INTERVAL 1 DAY) AS tgl_mulai_berlaku_next
                            FROM cuti_master cm
                            WHERE cm.id_pegawai = 11864 AND cm.id_jenis_cuti = 'C_BESAR') a";
                $query = mysqli_query($mysqli, $sql);
                $arr = array();
                while ($row = mysqli_fetch_array($query)) {
                    $arr[] = $row;
                }
                $can_cut_besar_now = $arr[0]['can_cut_besar_now'];
                if($can_cut_besar_now==0){
                    $kuota_cuti = 0;
                    $tgl_selesai_cut_besar = $arr[0]['tgl_selesai_cut_besar'];
                    $tgl_mulai_berlaku_next = $arr[0]['tgl_mulai_berlaku_next'];
                }else{
                    $kuota_cuti = $kuota_max_hari-$cuti_tahunan;
                }
            }
            $checked_a = '';
            $checked_b = '';
            $checked_c = '';
            if(isset($rdb_cut_besar)=='cut_besar_umum'){
                $checked_a = 'checked';
            }else if(isset($rdb_cut_besar)=='cut_besar_agama') {
                $checked_b = 'checked';
            }else if(isset($rdb_cut_besar)=='_cut_besar_kelahiran') {
                $checked_c = 'checked';
            }else{
                $checked_a = 'checked';
            }
            echo "<fieldset style='margin-bottom: -20px;width: 350px;'><legend style='background-color: #eeeef1;'>Silahkan Pilih:</legend></fieldset><br>";
            echo "<label style='font-weight: normal;'><input type=\"radio\" id=\"rdb_cut_besar_umum\" name=\"rdb_cut_besar\" value=\"cut_besar_umum\" $checked_a> Untuk Kepentingan secara Umum</label> &nbsp;";
            echo "<label style='font-weight: normal;'><input type=\"radio\" id=\"rdb_cut_besar_agama\" name=\"rdb_cut_besar\" value=\"cut_besar_agama\" $checked_b> Untuk Kepentingan Agama</label> &nbsp;";
            echo "<label style='font-weight: normal;margin-bottom: 10px;'><input type=\"radio\" id=\"rdb_cut_besar_kelahiran\" name=\"rdb_cut_besar\" value=\"cut_besar_kelahiran\" $checked_c> Karena Kelahiran Anak ke-4</label><br>";
            break;
        case 'C_BERSALIN':
            $kuota_cuti = $kuota_max_hari;
            $jk = substr($nip,14,1);
            if($jk<>2){
                $kuota_cuti = 0;
            }
            break;
        case 'C_ALASAN_PENTING':
            $kuota_cuti = $kuota_max_hari-$cuti_alasan_penting;
            $checked_a = '';
            $checked_b = '';
            $checked_c = '';
            $checked_d = '';
            $checked_e = '';
            $checked_f = '';
            if(isset($rdb_cut_penting)=='cut_penting_keluarga'){
                $checked_a = 'checked';
            }else if(isset($rdb_cut_penting)=='cut_penting_nikah'){
                $checked_b = 'checked';
            }else if(isset($rdb_cut_penting)=='cut_penting_kelahiran'){
                $checked_c = 'checked';
            }else if(isset($rdb_cut_penting)=='cut_penting_musibah'){
                $checked_d = 'checked';
            }else if(isset($rdb_cut_penting)=='cut_penting_rawan'){
                $checked_e = 'checked';
            }else if(isset($rdb_cut_penting)=='cut_penting_mendesak'){
                $checked_f = 'checked';
            }else{
                $checked_a = 'checked';
            }
            echo "<fieldset style='margin-bottom: -20px;width: 350px;'><legend style='background-color: #eeeef1;'>Silahkan Pilih:</legend></fieldset><br>";
            echo "<label style='font-weight: normal;'><input type=\"radio\" id=\"rdb_cut_penting_keluarga\" name=\"rdb_cut_penting\" value=\"cut_penting_keluarga\" $checked_a> Keluarga Sakit / Meninggal</label> &nbsp;";
            echo "<label style='font-weight: normal;'><input type=\"radio\" id=\"rdb_cut_penting_nikah\" name=\"rdb_cut_penting\" value=\"cut_penting_nikah\" $checked_b> Melangsungkan Pernikahan</label> &nbsp;";
            echo "<label style='font-weight: normal;'><input type=\"radio\" id=\"rdb_cut_penting_kelahiran\" name=\"rdb_cut_penting\" value=\"cut_penting_kelahiran\" $checked_c> Istri Melahirkan / Operasi Caesar</label> &nbsp;";
            echo "<label style='font-weight: normal;'><input type=\"radio\" id=\"rdb_cut_penting_musibah\" name=\"rdb_cut_penting\" value=\"cut_penting_musibah\" $checked_d> Mengalami musibah kebakaran / bencana</label> &nbsp;";
            echo "<label style='font-weight: normal;'><input type=\"radio\" id=\"rdb_cut_penting_rawan\" name=\"rdb_cut_penting\" value=\"cut_penting_rawan\" $checked_e> Ditempatkan pada daerah rawan dan/atau berbahaya</label> &nbsp;";
            echo "<label style='font-weight: normal;margin-bottom: 10px;'><input type=\"radio\" id=\"rdb_cut_penting_mendesak\" name=\"rdb_cut_penting\" value=\"cut_penting_mendesak\" $checked_f> Mendesak segera dan perlu izin sementara</label><br>";
            break;
        case 'CLTN':
            if($cuti_cltn>0){
                $kuota_cuti = 0;
            }else{
                $sql = "SELECT DATE_FORMAT(a.tgl_selesai_cltn, '%d-%m-%Y') AS tgl_selesai_cltn,
                            DATE_FORMAT(a.tgl_mulai_berlaku_next, '%d-%m-%Y') AS tgl_mulai_berlaku_next,
                            CASE WHEN a.tgl_selesai_cltn IS NULL THEN 1 ELSE
                            (CASE WHEN NOW() < a.tgl_mulai_berlaku_next THEN 0 ELSE 1 END) END AS can_cut_cltn_now FROM
                            (SELECT MAX(cm.tmt_akhir) AS tgl_selesai_cltn,
                            DATE_ADD(DATE_ADD(cm.tmt_akhir, INTERVAL 5 YEAR), INTERVAL 1 DAY) AS tgl_mulai_berlaku_next
                            FROM cuti_master cm
                            WHERE cm.id_pegawai = 11864 AND cm.id_jenis_cuti = 'CLTN') a";
                $query = mysqli_query($mysqli, $sql);
                $arr = array();
                while ($row = mysqli_fetch_array($query)) {
                    $arr[] = $row;
                }
                $can_cltn_now = $arr[0]['can_cut_cltn_now'];
                if($can_cltn_now==0){
                    $kuota_cuti = 0;
                    $tgl_selesai_cut_besar = $arr[0]['tgl_selesai_cltn'];
                    $tgl_mulai_berlaku_next = $arr[0]['tgl_mulai_berlaku_next'];
                }else{
                    $kuota_cuti = $kuota_max_hari;
                }
            }
            $checked_a = '';
            $checked_b = '';
            $checked_c = '';
            $checked_d = '';
            $checked_e = '';
            $checked_f = '';
            if(isset($rdb_cut_cltn)=='cut_cltn_keluarga_tugas'){
                $checked_a = 'checked';
            }else if(isset($rdb_cut_cltn)=='cut_cltn_keluarga_bekerja') {
                $checked_b = 'checked';
            }else if(isset($rdb_cut_cltn)=='cut_cltn_program_keturunan') {
                $checked_c = 'checked';
            }else if(isset($rdb_cut_cltn)=='cut_cltn_anak_kebutuhan_khusus') {
                $checked_d = 'checked';
            }else if(isset($rdb_cut_cltn)=='cut_cltn_keluarga_perawatan_khusus') {
                $checked_e = 'checked';
            }else if(isset($rdb_cut_cltn)=='cut_cltn_ortu_sakit') {
                $checked_f = 'checked';
            }else{
                $checked_a = 'checked';
            }

            echo "<fieldset style='margin-bottom: -20px;width: 350px;'><legend style='background-color: #eeeef1;'>Silahkan Pilih:</legend></fieldset><br>";
            echo "<label style='font-weight: normal;'><input type=\"radio\" id=\"rdb_cut_cltn_keluarga_tugas\" name=\"rdb_cut_cltn\" value=\"cut_cltn_keluarga_tugas\" $checked_a> Mendampingi suami/istri tugas negara/tugas belajar di dalam/luar negeri</label> &nbsp;";
            echo "<label style='font-weight: normal;'><input type=\"radio\" id=\"rdb_cut_cltn_keluarga_bekerja\" name=\"rdb_cut_cltn\" value=\"cut_cltn_keluarga_bekerja\" $checked_b> Mendampingi suami/istri bekerja di dalam/luar negeri</label> &nbsp;";
            echo "<label style='font-weight: normal;'><input type=\"radio\" id=\"rdb_cut_cltn_program_keturunan\" name=\"rdb_cut_cltn\" value=\"cut_cltn_program_keturunan\" $checked_c> Menjalani program untuk mendapatkan keturunan</label> &nbsp;";
            echo "<label style='font-weight: normal;'><input type=\"radio\" id=\"rdb_cut_cltn_anak_kebutuhan_khusus\" name=\"rdb_cut_cltn\" value=\"cut_cltn_anak_kebutuhan_khusus\" $checked_d> Mendampingi anak yang berkebutuhan khusus</label> &nbsp;";
            echo "<label style='font-weight: normal;'><input type=\"radio\" id=\"rdb_cut_cltn_keluarga_perawatan_khusus\" name=\"rdb_cut_cltn\" value=\"cut_cltn_keluarga_perawatan_khusus\" $checked_e> Mendampingi suami/istri/anak yang memerlukan perawatan khusus</label> &nbsp;";
            echo "<label style='font-weight: normal;margin-bottom: 10px;'><input type=\"radio\" id=\"rdb_cut_cltn_ortu_sakit\" name=\"rdb_cut_cltn\" value=\"cut_cltn_ortu_sakit\" $checked_f> Mendampingi/merawat orang tua/mertua yang sakit/uzur</label><br>";
            break;
    }

}else{
    if(isset($idJnsCutiSakit)==''){
        $idJnsCutiSakit = 1;
    }
    $sqlJns = "SELECT * FROM cuti_jenis_sakit";
    $query = mysqli_query($mysqli, $sqlJns);
    $array_data = array();
    while ($row = mysqli_fetch_array($query)) {
        $array_data[] = $row;
    }
    $array_data_length = count($array_data);
    $idjenis_cuti = $array_data[0]['idjenis_cuti_sakit'];
    $jenis_cuti = $array_data[0]['jenis_cuti_sakit'];

    echo "<select id=\"cboIdJnsCutiSakit\" name=\"cboIdJnsCutiSakit\" size=\"3\" style=\"width:100%;max-width: 350px;\">";
    for($x = 0; $x < $array_data_length; $x++) {
        echo "<option value='".$array_data[$x]['idjenis_cuti_sakit']."' ";
        if($array_data[$x]['idjenis_cuti_sakit']==$idJnsCutiSakit) echo 'selected';
        echo ">".$array_data[$x]['jenis_cuti_sakit']."</option>";
    }
    echo "</select><br>";
    if($idJnsCutiSakit==1) {
        if (isset($rdb_flag_sakit_umum) == '') {
            $rdb_flag_sakit_umum = 1;
            $checked1 = 'checked';
            $checked2 = '';
        } else {
            if ($rdb_flag_sakit_umum == 1) {
                $checked1 = 'checked';
                $checked2 = '';
            } else {
                $checked1 = '';
                $checked2 = 'checked';
            }
        }
        echo "<fieldset style='margin-bottom: -20px;margin-top: 10px; width: 350px;'><legend style='background-color: #eeeef1;'>Silahkan Pilih:</legend></fieldset><br>";
        echo "<label style='font-weight: normal;margin-top: 0px;'><input type=\"radio\" id=\"rdb_flag_sakit_umum1\" name=\"rdb_flag_sakit_umum\" value=\"1\" $checked1> Usulan Baru</label> &nbsp;";
        echo "<label style='font-weight: normal;margin-bottom: 10px;'><input type=\"radio\" id=\"rdb_flag_sakit_umum2\" name=\"rdb_flag_sakit_umum\" value=\"0\" $checked2> Usulan Perpanjangan</label><br>";
    }else{
        $rdb_flag_sakit_umum = 1;
    }
    $sql = "SELECT * FROM cuti_jenis_sakit WHERE idjenis_cuti_sakit = '".$idJnsCutiSakit."'";
    $query = mysqli_query($mysqli, $sql);
    $array_data = array();
    while ($row = mysqli_fetch_array($query)) {
        $array_data[] = $row;
    }
    $desk = $array_data[0]['jenis_cuti_sakit'];
    $masa_kerja_min = $array_data[0]['masa_kerja_min'];
    $kuota_min_hari = $array_data[0]['kuota_min_hari'];
    $kuota_max_hari = $array_data[0]['kuota_max_hari'];
    $ket_kuota = $array_data[0]['ket_kuota'];
    $ket_lainnya = $array_data[0]['keterangan_lainnya'];

    $kuota_cuti = $kuota_max_hari;
    if($kuota_cuti == -1){
        $kuota_cuti = "~";
    }else{
        $kuota_cuti = $kuota_cuti;
    }
}
?>

<strong><?php echo $desk; ?></strong><br>
Masa Kerja Minimal: <?php echo $masa_kerja_min.' Tahun';?><br>
Kuota Cuti Per Tahun: <?php echo $ket_kuota;?><br> <input id="kuota_min_hari" name="kuota_min_hari" type="hidden" value="<?php echo $kuota_min_hari; ?>" />
Keterangan Lain:<br><div style="margin-left: -25px;"><?php echo $ket_lainnya; ?></div>
Cuti yang dapat diambil: <input id="jml_jatah_cuti" name="jml_jatah_cuti" type="hidden" value="<?php echo "$kuota_cuti"; ?>" />
<?php echo "$kuota_cuti"; ?> Hari
<?php
if($idJnsCuti=='C_BESAR'){
    if($kuota_cuti==0){
        echo "<br><span style='color: red'>Terakhir Cuti Besar berakhir pada : ".$tgl_selesai_cut_besar."</span>";
        echo "<br><span style='color: red'>Cuti Besar berikutnya dapat diambil mulai dari : ".$tgl_mulai_berlaku_next."</span>";
    }
}
?>

<script type="text/javascript">
    $("#cboIdJnsCutiSakit").click(function() {
        var idJnsCutiSakit = ($("#cboIdJnsCutiSakit").val());
        $("#divInformasiCuti").css("pointer-events", "none");
        $("#divInformasiCuti").css("opacity", "0.4");
        $("#btnSimpanCuti").css("pointer-events", "none");
        $("#btnSimpanCuti").css("opacity", "0.4");
        $("#cboIdJnsCuti").css("pointer-events", "none");
        $("#cboIdJnsCuti").css("opacity", "0.4");
        $.ajax({
            type: "GET",
            url: "/simpeg/cuti_get_detail_info.php?idJnsCuti=C_SAKIT"+"&idJnsCutiSakit="+idJnsCutiSakit,
            success: function (data) {
                $("#divInformasiCuti").html(data);
                $("#divInformasiCuti").css("pointer-events", "auto");
                $("#divInformasiCuti").css("opacity", "1");
                $("#btnSimpanCuti").css("pointer-events", "auto");
                $("#btnSimpanCuti").css("opacity", "1");
                $("#cboIdJnsCuti").css("pointer-events", "auto");
                $("#cboIdJnsCuti").css("opacity", "1");
            }
        });
    });
</script>