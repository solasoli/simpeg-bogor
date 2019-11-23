<?php
    session_start();
    extract($_GET);
    include("konek.php");

    if($idJnsCuti <> 'C_SAKIT'){
        $sql = "SELECT * FROM cuti_jenis WHERE id_jenis_cuti = '".$idJnsCuti."'";
        $query = mysqli_query($mysqli,$sql);
        $array_data = array();
        while ($row = mysqli_fetch_array($query)) {
            $array_data[] = $row;
        }
        $desk = $array_data[0]['deskripsi'];
        $masa_kerja_min = $array_data[0]['masa_kerja_min'];
        $kuota_min_hari = $array_data[0]['kuota_min_hari'];
        $kuota_max_hari = $array_data[0]['kuota_max_hari'];
        $ket_kuota = $array_data[0]['ket_kuota'];
    }

    switch ($idJnsCuti) {
        case 'C_TAHUNAN':
            $call_sp = "CALL PRCD_CUTI_COUNT_HIST_TAHUNAN(".$_SESSION[id_pegawai].");";
            break;
        case 'C_SAKIT':
            if($idJnsCutiSakit==''){
                $idJnsCutiSakit = 1;
            }
            $sqlJns = "SELECT * FROM cuti_jenis_sakit";
            $query = mysqli_query($mysqli,$sqlJns);
            $array_data = array();
            while ($row = mysqli_fetch_array($query)) {
                $array_data[] = $row;
            }
            $array_data_length = count($array_data);
            $idjenis_cuti = $array_data[0]['idjenis_cuti_sakit'];
            $jenis_cuti = $array_data[0]['jenis_cuti_sakit'];
?>
            <select id="cboIdJnsCutiSakit" name="cboIdJnsCutiSakit" size="3" style="width:100%; max-width: 350px;">
                <?php
                for($x = 0; $x < $array_data_length; $x++) {
                    echo "<option value='".$array_data[$x]['idjenis_cuti_sakit']."' ";
                    if($array_data[$x]['idjenis_cuti_sakit']==$idJnsCutiSakit) echo 'selected';
                    echo ">".$array_data[$x]['jenis_cuti_sakit']."</option>";
                }
                ?>
            </select><br>
            <?php
                if($idJnsCutiSakit==1) {
                    if($rdb_flag_sakit_umum==''){
                        $rdb_flag_sakit_umum = 1;
                        $checked1 = 'checked';
                        $checked2 = '';
                    }else{
                        if($rdb_flag_sakit_umum==1){
                            $checked1 = 'checked';
                            $checked2 = '';
                        }else{
                            $checked1 = '';
                            $checked2 = 'checked';
                        }
                    }
                    ?>
                    <input type="radio" id="rdb_flag_sakit_umum1" name="rdb_flag_sakit_umum" value="1" <?php echo $checked1; ?>> Usulan Baru
                    &nbsp; &nbsp;
                    <input type="radio" id="rdb_flag_sakit_umum2" name="rdb_flag_sakit_umum" value="0" <?php echo $checked2; ?>> Usulan Perpanjangan <br>
                <?php
                }else{
                    $rdb_flag_sakit_umum = 1;
                }
                    ?>
<?php
            $sql = "SELECT * FROM cuti_jenis_sakit WHERE idjenis_cuti_sakit = '".$idJnsCutiSakit."'";
            $query = mysqli_query($mysqli,$sql);
            $array_data = array();
            while ($row = mysqli_fetch_array($query)) {
                $array_data[] = $row;
            }
            $desk = $array_data[0]['jenis_cuti_sakit'];
            $masa_kerja_min = $array_data[0]['masa_kerja_min'];
            $kuota_min_hari = $array_data[0]['kuota_min_hari'];
            $kuota_max_hari = $array_data[0]['kuota_max_hari'];
            $ket_kuota = $array_data[0]['ket_kuota'];

            $sql = "SELECT jenis_kelamin FROM pegawai WHERE id_pegawai = ".$_SESSION[id_pegawai];
            $query = mysqli_query($mysqli,$sql);
            $array_data = array();
            while ($row = mysqli_fetch_array($query)) {
                $array_data[] = $row;
            }
            $jk = $array_data[0]['jenis_kelamin'];
            $call_sp = "CALL PRCD_CUTI_COUNT_HIST_SAKIT(".$_SESSION[id_pegawai].",".$idJnsCutiSakit.",".$jk.",".$rdb_flag_sakit_umum.");";
            break;
        case 'C_BESAR':
            $call_sp = "CALL PRCD_CUTI_COUNT_HIST_BESAR(".$_SESSION[id_pegawai].");";
            break;
        case 'C_BERSALIN':
            $sql = "SELECT jenis_kelamin FROM pegawai WHERE id_pegawai = ".$_SESSION[id_pegawai];
            $query = mysqli_query($mysqli,$sql);
            $array_data = array();
            while ($row = mysqli_fetch_array($query)) {
                $array_data[] = $row;
            }
            $jk = $array_data[0]['jenis_kelamin'];
            $call_sp = "CALL PRCD_CUTI_COUNT_HIST_BERSALIN(".$_SESSION[id_pegawai].",".$jk." );";
            break;
        case 'C_ALASAN_PENTING':
            $call_sp = "CALL PRCD_CUTI_COUNT_HIST_ALASAN_PENTING(".$_SESSION[id_pegawai].");";
            break;
        case 'CLTN':
            $call_sp = "CALL PRCD_CUTI_COUNT_HIST_CLTN(".$_SESSION[id_pegawai].");";
            break;
    }

        $res_query_sp = $mysqli->query($call_sp);
        $array_data = array();
        $res_query_sp->data_seek(0);
        while ($row = $res_query_sp->fetch_assoc()) {
            $array_data[] = $row;
        }
        $jml_max = $array_data[0]['kuota_max_cuti'];
        $quota_cuti = $array_data[0]['kuota_cuti'];
        $cuti_curr = $array_data[0]['jml_cuti_curr'];
        if($jml_max == -1){
            $jml_max = "~";
        }else{
            $jml_max = $jml_max;
        }
        if($quota_cuti == -1){
            $quota_cuti = "~";
        }else{
            $quota_cuti = $quota_cuti;
        }
?>

    <strong><?php echo $desk; ?></strong><br>
    Masa Kerja Minimal : <?php echo $masa_kerja_min.' Tahun';?><br>
    Kuota Cuti Per Tahun: <?php echo $ket_kuota;?><br> <input id="kuota_min_hari" name="kuota_min_hari" type="hidden" value="<?php echo $kuota_min_hari; ?>" />
    Jumlah Kuota Cuti Per Tahun: <?php echo $jml_max; ?> Hari<br>
    Cuti yang dapat diambil :
    <input id="jml_jatah_cuti" name="jml_jatah_cuti" type="hidden" value="<?php echo $quota_cuti; ?>" />
    <?php
        if($quota_cuti < -1){
            echo 0;
        }else{
            echo $quota_cuti;
        }
    ?> Hari
        <?php
        if($idJnsCuti=='C_TAHUNAN') {
            $sqlcb = "SELECT SUM(cm.lama_cuti) as jumlah FROM cuti_master cm WHERE cm.id_pegawai = " . $_SESSION[id_pegawai] . " AND 
                                                                      cm.id_jenis_cuti = 'C_BESAR' AND cm.periode_thn = YEAR(NOW()) AND 
                                                                      (cm.id_status_cuti = 6 OR cm.id_status_cuti = 10)";
            $rs = mysqli_query($mysqli,$sqlcb);
            while ($row = mysqli_fetch_array($rs)) {
                $jmlcb = $row['jumlah'];
            }
            if ($jmlcb > 0) {
                echo "<span style=\"color: darkred;\"><small>(Tahun ini telah Cuti Besar selama $jmlcb hari)</small></span>";
            }
        }
        ?>
    <br>
    Cuti yang sudah diambil : <?php echo $cuti_curr; ?> Hari
    <?php
        switch ($idJnsCuti) {
            case 'C_BESAR':
                echo '<br><span style="color: #8a6d3b;">Berlaku untuk alasan keagamaan seperti Haji atau Umroh. <br> Cuti Besar yang sudah diambil pada tahun berjalan
                    akan menghapus Cuti Tahunan<br>Cuti Besar untuk keperluan keagamaan yang lamanya kurang dari 12 hari dianjurkan untuk mengambil Cuti Tahunan saja</span>';
                break;
            case 'C_ALASAN_PENTING':
                echo '<br><span style="color: #8a6d3b;">Berlaku untuk alasan Menikah, merawat keluarga yang Sakit atau Meninggal.</span>';
                break;
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
            url: "/simpeg/cuti_get_info_cuti.php?idJnsCuti=C_SAKIT"+"&idJnsCutiSakit="+idJnsCutiSakit,
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

    $("input[name='rdb_flag_sakit_umum']").click(function() {
        var idJnsCutiSakit = ($("#cboIdJnsCutiSakit").val());
        var rdb_flag_sakit_umum = ($("input[name='rdb_flag_sakit_umum']:checked").val());
        $("#divInformasiCuti").css("pointer-events", "none");
        $("#divInformasiCuti").css("opacity", "0.4");
        $("#btnSimpanCuti").css("pointer-events", "none");
        $("#btnSimpanCuti").css("opacity", "0.4");
        $("#cboIdJnsCuti").css("pointer-events", "none");
        $("#cboIdJnsCuti").css("opacity", "0.4");
        $.ajax({
            type: "GET",
            url: "/simpeg/cuti_get_info_cuti.php?idJnsCuti=C_SAKIT"+"&idJnsCutiSakit="+idJnsCutiSakit+"&rdb_flag_sakit_umum="+rdb_flag_sakit_umum,
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