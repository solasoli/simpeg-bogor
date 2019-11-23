<?php
include("class/cls_koncil.php");
$unit_kerja = new Unit_kerja;
$sql = "SELECT MAX(uk.id_unit_kerja) AS id_unit_kerja FROM unit_kerja uk
			WHERE uk.nama_baru LIKE '%Sekretariat Daerah%' AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)";
$query = mysqli_query($mysqli, $sql);
$dataSekret = mysqli_fetch_array($query);

if($unit['id_skpd'] == $dataSekret[0]){
    $idunit = $unit['id_skpd'];
}else{
    $idunit = @$_SESSION['id_unit'];
}
$db = Database::getInstance();
$mysqli = $db->getConnection();
$id_skpd = @$_SESSION['id_skpd'];
?>

<h2>Rekapitulasi Waktu Kehadiran<br>
    <?php echo $unit_kerja->get_unit_kerja($idunit)->nama_baru ?>
</h2>

<?php
if($unit['id_skpd'] == $dataSekret[0]){
    $auth = 0;
    $auth = 1;
}else {
    if (in_array(2, $_SESSION['role'])) {
        $sqlCountUnit = "SELECT COUNT(uk.id_unit_kerja) AS jmlUnit
                                FROM unit_kerja uk WHERE uk.id_skpd = " . $id_skpd . " AND uk.id_unit_kerja <> uk.id_skpd AND
                                uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)";
        $query = mysqli_query($mysqli,$sqlCountUnit);
        $data = mysqli_fetch_array($query);
        if ((int)$data[0] > 0) {
            $auth = 1;
        } else {
            $auth = 0;
        }
    }else if (in_array(7, $_SESSION['role'])){
        $auth = 1;
    }else{
        $auth = 0;
    }
}
$bln = @$_GET['bln'];
$thn = @$_GET['thn'];
if(isset($bln) and $bln!='' and $bln!='0'){

}else{
    $bln = date("m");
}

$a_date = "$thn-$bln-01";
$maxday = date("t", strtotime($a_date));

/*if(substr($bln,0,1)==0)
    $urut=substr($bln,1,1);
else
    $urut=$bln;*/

if(isset($thn) and $thn!='' and $thn!='0'){

}else{
    $thn = date("Y");
}

if($auth==1){
    if (in_array(7, $_SESSION['role'])){
        $id_unit_kerja = $_SESSION['id_unit'];
    }else{
        if(isset($_GET['id_unit'])){
            $id_unit_kerja = $_GET['id_unit'];
        }else{
            $id_unit_kerja = $_SESSION['id_unit'];
        }
    }
}else{
    $id_unit_kerja = $_SESSION['id_unit'];
}

?>

<div class="row" style="margin-bottom: 30px;">
    <div class="col-sm-2">
        <select class="form-control" id="ddBulan" name="ddBulan" style="font-size: large;">
            <option value="01" <?php echo $bln=='01'?'selected':''; ?>>Januari</option>
            <option value="02" <?php echo $bln=='02'?'selected':''; ?>>Februari</option>
            <option value="03" <?php echo $bln=='03'?'selected':''; ?>>Maret</option>
            <option value="04" <?php echo $bln=='04'?'selected':''; ?>>April</option>
            <option value="05" <?php echo $bln=='05'?'selected':''; ?>>Mei</option>
            <option value="06" <?php echo $bln=='06'?'selected':''; ?>>Juni</option>
            <option value="07" <?php echo $bln=='07'?'selected':''; ?>>Juli</option>
            <option value="08" <?php echo $bln=='08'?'selected':''; ?>>Agustus</option>
            <option value="09" <?php echo $bln=='09'?'selected':''; ?>>September</option>
            <option value="10" <?php echo $bln=='10'?'selected':''; ?>>Oktober</option>
            <option value="11" <?php echo $bln=='11'?'selected':''; ?>>November</option>
            <option value="12" <?php echo $bln=='12'?'selected':''; ?>>Desember</option>
        </select>
    </div>
    <div class="col-sm-2">
        <select class="form-control" id="ddTahun" name="ddTahun" style="font-size: large;margin-left: -10px;">
            <option value="2016" <?php echo $thn==2016?'selected':''; ?>>2016</option>
            <option value="2017" <?php echo $thn==2017?'selected':''; ?>>2017</option>
            <option value="2018" <?php echo $thn==2018?'selected':''; ?>>2018</option>
            <option value="2019" <?php echo $thn==2019?'selected':''; ?>>2019</option>
            <option value="2020" <?php echo $thn==2020?'selected':''; ?>>2020</option>
            <option value="2021" <?php echo $thn==2021?'selected':''; ?>>2021</option>
        </select>
    </div>
    <?php
    if($auth == 1 and in_array(2, $_SESSION['role'])){
        echo "<div class=\"col-sm-3\">";
        echo "<select class=\"form-control\" id=\"ddUnitKerja\" name=\"ddUnitKerja\" style=\"font-size: 14px;font-weight: bold;\">";
        $sqlUnit = "SELECT uk.id_unit_kerja, uk.nama_baru AS jmlUnit
                        FROM unit_kerja uk WHERE uk.id_skpd = " . $id_skpd . " AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)";
        $qb = mysqli_query($mysqli,$sqlUnit);
        while ($unit = mysqli_fetch_array($qb)) {
            if ($id_unit_kerja == $unit[0]) {
                echo("<option value=$unit[0] selected> $unit[1]</option>");
            } else {
                echo("<option value=$unit[0] > $unit[1]</option>");
            }
        }
        echo "</select>";
        echo "</div>";
    }
    ?>
    <div class="col-md-4"><button id="btnFilterReport" type="button" class="btn btn-primary" style="margin-left: -20px;">
            &nbsp;&nbsp;&nbsp;<span class="glyphicon glyphicon-search"></span> Tampilkan &nbsp;&nbsp;&nbsp;</button>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <button id="btnDownloadReport" type="button" class="btn btn-primary" style="margin-left: -20px;">
            <span class="glyphicon glyphicon-download"></span> Download &nbsp;&nbsp;&nbsp;
        </button></div>
</div>

<script>
    $("#btnFilterReport").click(function(){
        var bln = $('#ddBulan').val();
        var thn = $('#ddTahun').val();
        var id_unit = $('#ddUnitKerja').val();
        location.href="index3.php?x=absensi.php&bln="+bln+"&thn="+thn+"&id_unit="+id_unit;
    });

    $("#btnDownloadReport").click(function(){
        var bln = $('#ddBulan').val();
        var thn = $('#ddTahun').val();
        var id_unit = $('#ddUnitKerja').val();
        window.open("/simpeg/absensi_report.php?bln="+bln+"&thn="+thn+"&id_unit="+id_unit,'_blank');
    });
</script>

<?php
$sql = "SELECT MAX(uk.id_unit_kerja) AS id_unit_kerja FROM unit_kerja uk
                                WHERE uk.nama_baru LIKE '%Sekretariat Daerah Kota Bogor%' AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)";
$result = mysqli_query($mysqli,$sql);

while ($ot = mysqli_fetch_array($result)) {
    $dataSekret = $ot[0];
}

if($id_skpd == 0){//$dataSekret
    //$str = "uk.id_skpd = $id_skpd";
    $sts_daftar = 'opd';
    $unit = $id_skpd;
}else{
    //$str = "uk.id_unit_kerja = ".$id_unit_kerja;
    $sts_daftar = 'unit';
    $unit = $id_unit_kerja;
}
//$maxday=array(0,30,28,31,30,31,30,31,31,30,31,30,31);

$sqlCall = "CALL PRCD_ABSEN_JADWAL_KHUSUS(".$id_skpd.",".$bln.",".$thn.");";
$qrysqlCall = $mysqli->query($sqlCall);

$sqlCall = "CALL PRCD_ABSEN_REPORT('".$sts_daftar."',".$unit.", '".$thn."-$bln"."',".$id_skpd.");";
$qrysqlCall = $mysqli->query($sqlCall);

if (!is_object($qrysqlCall)) {
    print 'object is expected in param1, ' . gettype($qrysqlCall) . ' is given';
    return NULL;
}
$qrysqlCall->data_seek(0);
while ($row = $qrysqlCall->fetch_row()){
    $strSQLAbsen = $row[0];
}
$qrysqlCall->close();
$mysqli->next_result();
$resultData = $mysqli->query($strSQLAbsen);

if ($resultData->num_rows > 0) {
?>
<table align="center" width="95%" border="1" cellspacing="0" cellpadding="15">
    <tr>
        <td rowspan="2" align="center" valign="top" style="padding:5px; padding-bottom:10px;">No</td>
        <td rowspan="2" valign="top" align="center">Nama / NIP</td>

        <td style="padding-left:10px;text-align: center;" colspan="<?php echo $maxday+1; ?>">Absensi</td>
    </tr>
    <tr>
        <td>&nbsp;Hari</td>
        <?php
        for($i=1;$i<=$maxday;$i++) {
            echo("<td style=padding:5px width=25 >$i</td>");
        }
        ?>
    </tr>
    <?php
    $no=1;
    $b=0;
    while ($report = $resultData->fetch_array(MYSQLI_ASSOC)) { ?>
    <tr>
        <td rowspan="2" valign="top" align="center" ><?php echo $no; ?></td>
        <td rowspan="2"  valign="top" nowrap="nowrap" style="padding:5px;">
            <?php
                echo $report['nama']; echo("<br>"); echo $report['nip_baru'];
            ?>
        </td>
        <td>&nbsp;Masuk&nbsp;</td>
        <?php

        for($i=1;$i<=$maxday;$i++)
        {
            $tempDate = "$thn-$bln-$i";
            $dayN = date('D', strtotime( $tempDate));
            $index=$i;
            if($dayN=='Sun' or $dayN=='Sat') { //$rptH[$i]=='H' or $rptH[$i]=='HOLIDAY'
                if($dayN=='Sun'){
                    $latar=" bgcolor=red ";
                    $isi=" ";
                }else{
                    if($auth==1){
                        if ($report['min_'.$index] == '-' or $report['min_'.$index] == '') {
                            $latar = " bgcolor=#c0c0c0 ";
                            $isi = " ";
                        }else{
                            $latar = " bgcolor=green ";
                            if(strlen($report['min_'.$index])<=2){
                                $isi = $report['min_'.$index];
                            }else{
                                $isi = substr($report['min_'.$index],0,strlen($report['min_'.$index])-3);
                            }
                            $color = "style='color: white'";
                        }
                    }else{
                        $latar=" bgcolor=red ";
                        $isi=" ";
                    }
                }

            }else {
                if ($report['min_'.$index] == '-' or $report['min_'.$index] == '') {
                    $latar = " bgcolor=#c0c0c0 ";
                    $isi = " ";
                }else{
                    $latar = " bgcolor=green ";
                    if(strlen($report['min_'.$index])<=2){
                        $isi = $report['min_'.$index];
                    }else{
                        $isi = substr($report['min_'.$index],0,strlen($report['min_'.$index])-3);
                    }
                    $color = "style='color: white'";
                }
            }
            echo("<td $latar align=center>&nbsp<span ".@$color.">".($isi==''?'&nbsp':$isi)."</span>&nbsp</td>");
        }
        ?>
    </tr>
        <tr>
            <td>&nbsp;Pulang&nbsp;</td>
            <?php

            for($i=1;$i<=$maxday;$i++){
                $index=$i;
                $tempDate = "$thn-$bln-$i";
                $dayN = date('D', strtotime( $tempDate));
                if($dayN=='Sun' or $dayN=='Sat') { //$rptH[$i]=='H' or $rptH[$i]=='HOLIDAY'
                    if($dayN=='Sun'){
                        $latar2 = " bgcolor=red ";
                        $isi = "&nbsp";
                    }else{
                        if($auth==1){
                            if ($report['max_'.$index] == '-' or $report['max_'.$index] == '') {
                                $latar2 = " bgcolor=#c0c0c0 ";
                                $isi = " ";
                            }else{
                                if($report['max_'.$index]=='-' or $report['max_'.$index]=='') {
                                    $latar2 = " bgcolor=#c0c0c0 ";
                                    $isi = " ";
                                }else{
                                    $latar2=" bgcolor=orange ";
                                    if(strlen($report['max_'.$index])<=2){
                                        $isi = $report['max_'.$index];
                                    }else{
                                        $isi=substr($report['max_'.$index],0,strlen($report['max_'.$index])-3); //TC
                                    }
                                    $color = '';
                                }
                            }
                        }else{
                            $latar2 = " bgcolor=red ";
                            $isi = "&nbsp";
                        }
                    }

                }else{
                    if($report['max_'.$index]=='-' or $report['max_'.$index]=='') {
                        $latar2 = " bgcolor=#c0c0c0 ";
                        $isi = " ";
                    }else{
                        $latar2=" bgcolor=orange ";
                        if(strlen($report['max_'.$index])<=2){
                            $isi = $report['max_'.$index];
                        }else{
                            $isi=substr($report['max_'.$index],0,strlen($report['max_'.$index])-3); //TC
                        }
                        $color = '';
                    }
                }
                ?>
                <td <?php echo $latar2; ?> align=center>&nbsp<?php echo "<span $color>".$isi."</span>";?>&nbsp</td>
                <?php
            }
            ?>
        </tr>
        <?php
        $b++;
        $no++;
    }
}else{
    echo "Tidak Ada Data";
}
?>
<br>
