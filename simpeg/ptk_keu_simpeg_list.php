<div class="row" style="margin: 10px;">
<?php
    include "konek.php";
    include "paginator.class.php";
    $pages = new Paginator;
    $pagePaging = $_POST['page'];
    if($pagePaging==0 or $pagePaging==""){
        $pagePaging = 1;
    }
    $ipp = $pages->items_per_page;
    $txtKeyword = $_POST['txtKeyword'];
    $flagPensiun = $_POST['flagPensiun'];
    $jenjab = $_POST['jenjab'];
    $eselon = $_POST['eselon'];
    $stsgol = $_POST['stsgol'];
    $stsnip = $_POST['stsnip'];
    $stspegsimg = $_POST['stspegsimg'];

    $whereKlause1 = "";
    $whereKlause2 = "";
    $whereKlause3 = "";

    if($flagPensiun==0){
        $whereKlause1 .= " WHERE p.flag_pensiun = 0";
    }else{
        $whereKlause1 .= " WHERE p.flag_pensiun = 1";
    }
    if($jenjab=='Struktural'){
        $whereKlause1 .= " AND p.jenjab = 'Struktural' ";
    }else{
        $whereKlause1 .= " AND p.jenjab = 'Fungsional' ";
    }
    if($eselon!='0'){
        if($eselon=='Z'){
            $whereKlause1 .= " AND j.eselon IS NULL ";
        }else{
            $whereKlause1 .= " AND j.eselon = '".$eselon."' ";
        }
    }
    if($stsnip==0){
        if($stsgol==0){
            $whereKlause2 = "WHERE a.pangkat_gol = gpt.NMGOL";
        }elseif($stsgol==1){
            $whereKlause2 = "WHERE a.pangkat_gol > gpt.NMGOL";
        }else{
            $whereKlause2 = "WHERE a.pangkat_gol < gpt.NMGOL";
        }
        $whereKlause2 .= " AND gm.KDSTAPEG = ".$stspegsimg;
    }else{
        $whereKlause3 = "WHERE b.NIP IS NULL";
    }

    if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")) {
        $whereKlause1 .= " AND (p.nip_baru LIKE '%" . $txtKeyword . "%'
                                            OR p.nama LIKE '%" . $txtKeyword . "%'
                                            OR j.jabatan LIKE '%" . $txtKeyword . "%')";
    }

    $sqlCountAll = "SELECT COUNT(*) AS jumlah FROM
            (SELECT a.*, gm.NIP, gpt.NMGOL, gst.NMSTAPEG FROM
            (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
            CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
            (SELECT jm.nama_jfu AS jabatan
            FROM jfu_pegawai jp, jfu_master jm
            WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
            ELSE j.jabatan END END AS jabatan, j.eselon, uk.nama_baru as unit, p.flag_pensiun,
            p.status_aktif, p.tgl_pensiun_dini
            FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
            LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
            LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
            $whereKlause1) a
            LEFT JOIN gaji_mstpegawai gm ON a.nip_baru = gm.NIP
            LEFT JOIN gaji_pangkat_tbl gpt ON gm.KDPANGKAT = gpt.KDPANGKAT
            LEFT JOIN gaji_stapeg_tbl gst ON gm.KDSTAPEG = gst.KDSTAPEG
            $whereKlause2) b $whereKlause3";

    $query = $mysqli->query($sqlCountAll);
    if ($query->num_rows > 0) {
        while ($data = $query->fetch_array(MYSQLI_NUM)) {
            $jmlData = $data[0];
        }
    }

    if ($jmlData > 0) {
        $pages->items_total = $jmlData;
        $pages->paginate();
        $pgDisplay = $pages->display_pages();
        $itemPerPage = $pages->display_items_per_page();
        $curpage = $pages->current_page;
        $numpage = $pages->num_pages;
        $jumppage = $pages->display_jump_menu();
        $rowperpage = $pages->display_items_per_page();
    }else{
        $pgDisplay = '';
        $itemPerPage = '';
        $curpage = '';
        $numpage = '';
        $jumppage = '';
        $rowperpage = '';
    }

    if($pagePaging == 1){
        $start_number = 0;
    }else{
        $start_number = ($pagePaging * $ipp) - $ipp;
    }

    $sqlData = "SELECT b.* FROM
            (SELECT a.*, gm.NIP, gpt.NMGOL, gst.NMSTAPEG FROM
            (SELECT x.* FROM(SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, DATE_FORMAT(p.tgl_lahir, '%d-%m-%Y') AS tgl_lahir,
            p.pangkat_gol, CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
            (SELECT jm.nama_jfu AS jabatan
            FROM jfu_pegawai jp, jfu_master jm
            WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
            ELSE j.jabatan END END AS jabatan, j.eselon, uk.nama_baru as unit, p.flag_pensiun,
            p.status_aktif, DATE_FORMAT(p.tgl_pensiun_dini, '%d-%m-%Y') AS tgl_pensiun_dini, p.nama AS nama_asli, uk.id_skpd, DATE_FORMAT(s.tmt, '%d-%m-%Y') AS tmt
            FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
            LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
            LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
            LEFT JOIN sk s ON s.gol = p.pangkat_gol AND s.id_pegawai = p.id_pegawai AND s.id_kategori_sk = 5
            $whereKlause1) x GROUP BY x.id_pegawai) a
            LEFT JOIN gaji_mstpegawai gm ON a.nip_baru = gm.NIP
            LEFT JOIN gaji_pangkat_tbl gpt ON gm.KDPANGKAT = gpt.KDPANGKAT
            LEFT JOIN gaji_stapeg_tbl gst ON gm.KDSTAPEG = gst.KDSTAPEG
            $whereKlause2) b $whereKlause3".$pages->limit;

    $query = $mysqli->query($sqlData);

    if ($query->num_rows > 0) {
        if ($numpage > 0) {
            echo "Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage | $rowperpage<br>";
            echo $pgDisplay;
        }
    $i = 0;
?>
    <table id="list_pegawai" cellspacing="0" width="100%" class="table" style="margin-top: 10px;">
        <thead>
        <tr style='border-bottom: solid 2px #2cc256;border-top: solid 2px #000000;'>
            <td>No</td>
            <td style="text-align: center;">NIP</td>
            <td>Nama</td>
            <td>Tgl.Lahir</td>
            <td>Eselon</td>
            <td style="text-align: center;">Jabatan</td>
            <td>Unit Kerja</td>
        </tr>
        </thead>
        <tbody>
        <?php
            while ($oto = $query->fetch_array(MYSQLI_BOTH)) {
                $i++;
                echo "<tr ".(($i%2)==0?"style='background-color:#FFFFFF'":"style='background-color: #F9F9F9'").">";
                echo "<td>".((int)$start_number+$i)."</td><td><strong>$oto[1]</strong></td><td>$oto[2]</td>";
                echo "<td>$oto[3]</td><td>$oto[6]</td><td>$oto[5]</td><td>$oto[7]</td>";
                echo "</tr>";
                echo "<tr ".(($i%2)==0?"style='background-color:#FFFFFF'":"style='background-color: #F9F9F9'")."><td style='border-top: 0px;'></td>";
                echo "<td colspan='7' style='border-top: 0px;text-align: left;font-size: small;'>
                <div class=\"row\" style='border: solid 1px #c0c2bb; background: #eff0e7;padding: 2px;width: 100%;'>
                <div class=\"col-md-6\" style='font-style: normal;'><span style='color: saddlebrown;font-weight: bold;'>SIMPEG</span> :
                Gol : <span style='color: red;font-weight: bold;'>$oto[pangkat_gol]</span> ($oto[tmt]), Status : $oto[status_aktif], <br>Tgl. Pensiun : $oto[tgl_pensiun_dini]</div>
                <div class=\"col-md-5\" style='font-style: normal;'><span style='color: darkblue;font-weight: bold;'>SIMGAJI</span> :
                Gol : <span style='color: red;font-weight: bold;'>".($oto['NMGOL']==''?'-':$oto['NMGOL'])."</span>, Status : ".($oto['NMSTAPEG']==''?'-':$oto['NMSTAPEG'])."
                </div>
                </div></td></tr>";
            }
        ?>
        </tbody>
    </table>
<?php
        if($numpage > 0){
            echo "Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage | $rowperpage<br>";
            echo $pgDisplay;
        }
    }else{
        echo '<div style="padding: 10px;">Tidak ada data</div>';
    }
?>
</div>

