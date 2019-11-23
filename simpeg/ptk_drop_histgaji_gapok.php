<head>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css">
<style>
    .checkbox {
        padding-left: 20px;
    }

    .checkbox label {
        display: inline-block;
        position: relative;
        padding-left: 5px;
    }

    .checkbox label::before {
        content: "";
        display: inline-block;
        position: absolute;
        width: 17px;
        height: 17px;
        left: 0;
        margin-left: -20px;
        border: 1px solid #cccccc;
        border-radius: 3px;
        background-color: #fff;
        -webkit-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
        -o-transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
        transition: border 0.15s ease-in-out, color 0.15s ease-in-out;
    }

    .checkbox label::after {
        display: inline-block;
        position: absolute;
        width: 16px;
        height: 16px;
        left: 0;
        top: 0;
        margin-left: -20px;
        padding-left: 3px;
        padding-top: 1px;
        font-size: 11px;
        color: #555555;
    }

    .checkbox input[type="checkbox"] {
        opacity: 0;
    }

    .checkbox input[type="checkbox"]:focus + label::before {
        outline: thin dotted;
        outline: 5px auto -webkit-focus-ring-color;
        outline-offset: -2px;
    }

    .checkbox input[type="checkbox"]:checked + label::after {
        font-family: 'FontAwesome';
        content: "\f00c";
    }

    .checkbox input[type="checkbox"]:disabled + label {
        opacity: 0.65;
    }

    .checkbox input[type="checkbox"]:disabled + label::before {
        background-color: #eeeeee;
        cursor: not-allowed;
    }

    .checkbox.checkbox-circle label::before {
        border-radius: 50%;
    }

    .checkbox.checkbox-inline {
        margin-top: 0;
    }

    .checkbox-primary input[type="checkbox"]:checked + label::before {
        background-color: #428bca;
        border-color: #428bca;
    }

    .checkbox-primary input[type="checkbox"]:checked + label::after {
        color: #fff;
    }

    .checkbox-danger input[type="checkbox"]:checked + label::before {
        background-color: #d9534f;
        border-color: #d9534f;
    }

    .checkbox-danger input[type="checkbox"]:checked + label::after {
        color: #fff;
    }

    .checkbox-info input[type="checkbox"]:checked + label::before {
        background-color: #5bc0de;
        border-color: #5bc0de;
    }

    .checkbox-info input[type="checkbox"]:checked + label::after {
        color: #fff;
    }

    .checkbox-warning input[type="checkbox"]:checked + label::before {
        background-color: #f0ad4e;
        border-color: #f0ad4e;
    }

    .checkbox-warning input[type="checkbox"]:checked + label::after {
        color: #fff;
    }

    .checkbox-success input[type="checkbox"]:checked + label::before {
        background-color: #5cb85c;
        border-color: #5cb85c;
    }

    .checkbox-success input[type="checkbox"]:checked + label::after {
        color: #fff;
    }

    .loading-progress{
        width:100%;
    }
</style>
    <script src="js/jquery-progressTimer/js/jquery.progresstimer.js"></script>
</head>

<?php
session_start();
include "konek.php";
include "paginator.class.php";
include 'class/cls_ptk.php';
$oPtk = new Ptk();
$listBln = $oPtk->listBulan();
$listThn = $oPtk->listTahun();

$pages = new Paginator;
$pagePaging = $_POST['page'];
if ($pagePaging == 0 or $pagePaging == "") {
    $pagePaging = 1;
}

$ipp = $_POST['ipp'];
if ($ipp == "") {
    $ipp = 10;
}

$blnSk = $_POST['blnSk'];
$thnSk = $_POST['thnSk'];
$blnGaji = $_POST['blnGaji'];
$thnGaji = $_POST['thnGaji'];
$jnsSk = $_POST['jnsSk'];
$stsBerkas = $_POST['stsBerkas'];
$txtKeyword = $_POST['txtKeyword'];
$tbl = $_POST['tbl'];

$whereKlausa = "";
if ($jnsSk == 0) {
    $jnsSk = "5,6,7";
}
$whereKlause = '';
if (!(trim($txtKeyword) == "") && !(trim($txtKeyword) == "0")) {
    $whereKlause .= " WHERE (b.nip_baru LIKE '%" . $txtKeyword . "%'
                                        OR b.nama LIKE '%" . $txtKeyword . "%'
                                        OR b.jabatan LIKE '%" . $txtKeyword . "%'
                                        OR b.unit LIKE '%" . $txtKeyword . "%')";
}

if ($stsBerkas == 1) {
    $sqlCountAll = "SELECT COUNT(*) AS jumlah_all FROM
                (SELECT c.*, gp.gaji FROM
                (SELECT b.*, ib.file_name FROM
                (SELECT a.*, p.nip_baru,CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.jenjab,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, uk.nama_baru as unit
                FROM (
                SELECT ks.nama_sk, s.id_pegawai, s.id_sk, s.no_sk, s.tgl_sk, s.tmt, s.gol, s.mk_tahun, s.mk_bulan, s.id_berkas
                FROM sk s, kategori_sk ks
                WHERE s.id_kategori_sk = ks.id_kategori_sk AND
                  (s.id_kategori_sk IN (" . $jnsSk . ")) AND MONTH(s.tmt) = " . $blnSk . " AND YEAR(s.tmt) = " . $thnSk . "
                ) a, pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j,
                current_lokasi_kerja clk, unit_kerja uk
                WHERE a.id_pegawai = p.id_pegawai AND p.id_pegawai = clk.id_pegawai AND
                clk.id_unit_kerja = uk.id_unit_kerja AND p.flag_pensiun = 0) b
                LEFT JOIN berkas be ON b.id_berkas = be.id_berkas
                INNER JOIN isi_berkas ib ON be.id_berkas = ib.id_berkas $whereKlause) c
                LEFT JOIN gaji_pokok gp ON c.mk_tahun = gp.masa_kerja AND c.gol = gp.pangkat_gol AND
                gp.tahun = (SELECT MAX(gp2.tahun) AS tahun FROM gaji_pokok gp2)
                ORDER BY c.eselon, c.gol DESC, c.mk_tahun DESC, c.mk_bulan DESC) d
                LEFT JOIN gaji_historis_gapok ghg ON d.nip_baru = ghg.NIP AND ghg.TMTGAJI = '$thnGaji-$blnGaji-01'";
} else {
    $sqlCountAll = "SELECT COUNT(*) AS jumlah_all FROM
                (SELECT b.*, gp.gaji FROM
                (SELECT a.*, p.nip_baru,CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.jenjab,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, uk.nama_baru as unit
                FROM (
                SELECT ks.nama_sk, s.id_pegawai, s.id_sk, s.no_sk, s.tgl_sk, s.tmt, s.gol, s.mk_tahun, s.mk_bulan, s.id_berkas
                FROM sk s, kategori_sk ks
                WHERE s.id_kategori_sk = ks.id_kategori_sk AND
                s.id_berkas = 0 AND (s.id_kategori_sk IN (5,6,7)) AND MONTH(s.tmt) = 10 AND YEAR(s.tmt) = 2017
                ) a, pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j,
                current_lokasi_kerja clk, unit_kerja uk
                WHERE a.id_pegawai = p.id_pegawai AND p.id_pegawai = clk.id_pegawai AND
                clk.id_unit_kerja = uk.id_unit_kerja AND p.flag_pensiun = 0) b
                LEFT JOIN gaji_pokok gp ON b.mk_tahun = gp.masa_kerja AND b.gol = gp.pangkat_gol AND
                gp.tahun = (SELECT MAX(gp2.tahun) AS tahun FROM gaji_pokok gp2)
                ORDER BY b.eselon, b.gol DESC, b.mk_tahun DESC, b.mk_bulan DESC) c
                LEFT JOIN gaji_historis_gapok ghg ON c.nip_baru = ghg.NIP AND ghg.TMTGAJI = '2017-10-01'";
}

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
} else {
    $pgDisplay = '';
    $itemPerPage = '';
    $curpage = '';
    $numpage = '';
    $jumppage = '';
    $rowperpage = '';
}

if ($pagePaging == 1) {
    $start_number = 0;
} else {
    $start_number = ($pagePaging * $ipp) - $ipp;
}

if ($stsBerkas == 1) {
    $sqlData = "SELECT d.*, ghg.TMTGAJI FROM
                (SELECT c.*, gp.gaji FROM
                (SELECT b.*, ib.file_name FROM
                (SELECT a.*, p.nip_baru,CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.jenjab,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, uk.nama_baru as unit
                FROM (
                SELECT ks.id_kategori_sk, ks.nama_sk, s.id_pegawai, s.id_sk, s.no_sk, s.tgl_sk, s.tmt, s.gol, s.mk_tahun, s.mk_bulan, s.id_berkas
                FROM sk s, kategori_sk ks
                WHERE s.id_kategori_sk = ks.id_kategori_sk AND
                  (s.id_kategori_sk IN (" . $jnsSk . ")) AND MONTH(s.tmt) = " . $blnSk . " AND YEAR(s.tmt) = " . $thnSk . "
                ) a, pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j,
                current_lokasi_kerja clk, unit_kerja uk
                WHERE a.id_pegawai = p.id_pegawai AND p.id_pegawai = clk.id_pegawai AND
                clk.id_unit_kerja = uk.id_unit_kerja AND p.flag_pensiun = 0) b
                LEFT JOIN berkas be ON b.id_berkas = be.id_berkas
                INNER JOIN isi_berkas ib ON be.id_berkas = ib.id_berkas $whereKlause) c
                LEFT JOIN gaji_pokok gp ON c.mk_tahun = gp.masa_kerja AND c.gol = gp.pangkat_gol AND
                gp.tahun = (SELECT MAX(gp2.tahun) AS tahun FROM gaji_pokok gp2)
                ORDER BY c.eselon, c.gol DESC, c.mk_tahun DESC, c.mk_bulan DESC) d
                LEFT JOIN gaji_historis_gapok ghg ON d.nip_baru = ghg.NIP AND ghg.TMTGAJI = '$thnGaji-$blnGaji-01' " . $pages->limit;
} else {
    $sqlData = "SELECT c.*, ghg.TMTGAJI FROM
                (SELECT b.*, gp.gaji FROM
                (SELECT a.*, p.nip_baru,CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.jenjab,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, uk.nama_baru as unit
                FROM (
                SELECT ks.nama_sk, s.id_pegawai, s.id_sk, s.no_sk, s.tgl_sk, s.tmt, s.gol, s.mk_tahun, s.mk_bulan, s.id_berkas
                FROM sk s, kategori_sk ks
                WHERE s.id_kategori_sk = ks.id_kategori_sk AND
                s.id_berkas = 0 AND (s.id_kategori_sk IN (" . $jnsSk . ")) AND MONTH(s.tmt) = " . $blnSk . " AND YEAR(s.tmt) = " . $thnSk . "
                ) a, pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j,
                current_lokasi_kerja clk, unit_kerja uk
                WHERE a.id_pegawai = p.id_pegawai AND p.id_pegawai = clk.id_pegawai AND
                clk.id_unit_kerja = uk.id_unit_kerja AND p.flag_pensiun = 0) b
                LEFT JOIN gaji_pokok gp ON b.mk_tahun = gp.masa_kerja AND b.gol = gp.pangkat_gol AND
                gp.tahun = (SELECT MAX(gp2.tahun) AS tahun FROM gaji_pokok gp2)
                ORDER BY b.eselon, b.gol DESC, b.mk_tahun DESC, b.mk_bulan DESC) c
                LEFT JOIN gaji_historis_gapok ghg ON c.nip_baru = ghg.NIP AND ghg.TMTGAJI = '$thnGaji-$blnGaji-01' " . $pages->limit;
}

if(is_array($pages->limit) && sizeof($pages->limit) > 0){
    $firstNum = explode(' ', $pages->limit);
    $firstNum = explode(',', $firstNum[2]);
}

$query = $mysqli->query($sqlData);

if ($query->num_rows > 0) {
    ?>

    <div role="tabpanel" style="margin: 10px;">
        <ul class="nav nav-tabs" role="tablist" id="myTabGapok">
            <li role="presentation" class="active">
                <a href="#pilih_dokumen" aria-controls="pilih_dokumen" role="tab" data-toggle="tab"
                   style="color: brown;font-weight: bold;">
                    Pemilihan Data SK</a></li>
            <li role="presentation">
                <a href="#form_draft_gaji" aria-controls="form_draft_gaji" role="tab" data-toggle="tab"
                   style="color: brown;font-weight: bold;">
                    Form Registrasi Draft</a></li>
        </ul>
        <br>
        <?php
        if ($numpage > 0) {
            echo "Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage | $rowperpage<br>";
            echo $pgDisplay;
        }
        $i = (int)$firstNum[0];
        ?>
        <form role="form" class="form-horizontal" action="" novalidate="novalidate"
              enctype="multipart/form-data" name="frmEntryDraftGaji" id="frmEntryDraftGaji">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="pilih_dokumen">
                    <div class="row" style="margin: 10px;">
                        <div style="font-weight: bold;margin-top: 0px;margin-bottom: 10px;">
                            Silahkan Pilih Dokumen di bawah ini untuk membuat Draft Pengubahan Gaji :
                        </div>
                        <div id="divChkStoreGaji"
                             style="border:1px solid #c0c2bb; overflow-y: scroll;height: 1250px; width: 100%;padding: 0px;">
                            <table class='table' style="margin-top: 0px;">
                                <tr style='border-bottom: solid 2px #2cc256;border-top: solid 2px #000'>
                                    <td><?php if($stsBerkas == 1): ?>
                                        <div class="checkbox checkbox-success" style="margin-top: -16px;">
                                            <input id="chkAllSk" type="checkbox" value="" checked>
                                            <label for="chkAllSk"></label></div>
                                            <?php else: ?>
                                            No
                                        <?php endif; ?>
                                    </td>
                                    <td>Jenis Dokumen</td>
                                    <td>Nomor</td>
                                    <td>Tgl.SK</td>
                                    <td>TMT</td>
                                    <td>Gol</td>
                                    <td>Masa Kerja</td>
                                    <td>Gaji Pokok</td>
                                    <td>Draft TMT. Gaji</td>
                                </tr>
                                <?php while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                                    $i++;
                                    ?>
                                    <tr>
                                        <td><?php echo $i; ?>.</td>
                                        <td>
                                            <?php
                                            if($stsBerkas==1) {
                                                $asli = basename($oto[17]);
                                                $getcwd = substr(getcwd(), 0, strlen(getcwd()));
                                                if (file_exists(str_replace("\\", "/", $getcwd) . '/Berkas/' . trim($asli))) {
                                                    $ext[] = explode(".", $asli);
                                                    $linkBerkasSk = "<a href='/simpeg/Berkas/$asli' target='_blank' style='font-weight: bold;'>" . $oto[1] . "</a>";
                                                    unset($ext);
                                                    echo "$linkBerkasSk";
                                                } else {
                                                    echo $oto[1] . ' (Blm ada berkas)';
                                                }
                                            }else{
                                                echo 'Blm ada berkas';
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo ($stsBerkas==1?$oto[4]:$oto[3]); ?></td>
                                        <td><?php echo ($stsBerkas==1?$oto[5]:$oto[4]); ?></td>
                                        <td><?php echo ($stsBerkas==1?$oto[6]:$oto[5]); ?></td>
                                        <td><?php echo ($stsBerkas==1?$oto[7]:$oto[6]); ?></td>
                                        <td><?php echo ($stsBerkas==1?$oto[8] . ' Thn ' . $oto[9] . ' Bln':$oto[7] . ' Thn ' . $oto[8] . ' Bln'); ?></td>
                                        <td><?php echo ($stsBerkas==1?number_format($oto[18]):number_format($oto[16])); ?></td>
                                        <td><?php echo($stsBerkas==1?($oto[19] == '' ? 'Blm ada' : $oto[19]):($oto[17] == '' ? 'Blm ada' : $oto[17])); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="border-bottom: 1px solid #747571;"><?php if($stsBerkas == 1): ?>
                                            <div class="checkbox checkbox-success">
                                                <input id="chkSk<?php echo $oto[3]; ?>" type="checkbox"
                                                       value="<?php echo $oto[1] . '#' . $oto[3] . '#' . $oto[4] . '#' . $oto[5] . '#' . $oto[6] . '#' .
                                                           $oto[7] . '#' . $oto[8] . '#' . $oto[9] . '#' . $oto[10] . '#' . $oto[11] . '#' . $oto[18] . '#' .
                                                           ($oto[0] == 6 ? '80' : '100'); ?>" checked>
                                                <label for="chkSk<?php echo $oto[3]; ?>"></label>
                                                </div><?php endif; ?>
                                        </td>
                                        <td colspan="8" style="border-bottom: 1px solid #747571;">
                                            <span
                                                style="font-size: large; font-weight: bold;"><?php echo ($stsBerkas==1?$oto[12]:$oto[11]); ?></span>
                            <span style="font-size: medium">| NIP : <?php echo ($stsBerkas==1?$oto[11]:$oto[10]); ?>
                                | Eselon : <?php echo($stsBerkas==1?($oto[15] == 'Z' ? '-' : $oto[15]):($oto[14] == 'Z' ? '-' : $oto[14])); ?></span> <br>
                                            Jabatan : <?php echo ($stsBerkas==1?$oto[14]:$oto[13]); ?><br>
                                            Unit Kerja : <?php echo ($stsBerkas==1?$oto[16]:$oto[15]); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                        <script>
                            $("#chkAllSk").change(function () {
                                $("#divChkStoreGaji input:checkbox").prop('checked', $(this).prop("checked"));
                            });
                        </script>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="form_draft_gaji">
                    <div class="row" style="margin-top: 10px;">
                        <div class="form-group">
                            <div style="margin-left: 30px;margin-bottom: -10px;">Form ini digunakan untuk memasukkan data SK ke dalam Nominatif Draft Penyusunan Pengubahan Gaji. <br>
                                Sesuai dengan data SK yang dipilih (Ceklist) pada halaman tertentu.
                            </div>
                            <br>
                            <label class="control-label col-sm-12" style="text-align: left;margin-left: 15px;">
                                <?php
                                $sql = "SELECT uk.nama_baru as opd, uk.tahun FROM unit_kerja uk
                                WHERE uk.nama_baru LIKE '%Kepegawaian%' AND uk.tahun = 2017";
                                $query = $mysqli->query($sql);
                                while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                                    $opdPenerbit = $oto[0];
                                }
                                $sql = "SELECT gp.peraturan, gp.tahun, gp.perubahan FROM gaji_pokok gp
                                WHERE gp.tahun = (SELECT MAX(tahun) FROM gaji_pokok gp1) LIMIT 1";
                                $query = $mysqli->query($sql);
                                while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                                    $aturan = $oto[0];
                                    $thnAturanGaji = $oto[1];
                                    $perubahan = $oto[2];
                                }
                                ?>
                                Penerbit SK : <?php echo $opdPenerbit; ?> <br>
                                Peraturan Gaji : <?php echo $aturan . ' Tahun ' . $thnAturanGaji . '. Perubahan ' . $perubahan; ?>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="tglPermintaan">Tgl. Pembuatan :</label>

                            <div class="col-sm-2">
                                <input type="text" class="form-control" id="tglPembuatan" name="tglPembuatan"
                                       value="<?php echo date("d-m-Y"); ?>" readonly="readonly">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="tmtGaji">TMT. Gaji :</label>

                            <div class="col-sm-8">
                                <div class="row">
                                    <div class="col-sm-3"><select class="form-control" id="ddBlnGajiAdd">
                                            <?php
                                            $i = 0;
                                            for ($x = 0; $x <= 11; $x++) {
                                                if ($listBln[$i][0] == date("m")) {
                                                    echo "<option value=" . $listBln[$i][0] . " selected>" . $listBln[$i][1] . "</option>";
                                                } else {
                                                    echo "<option value=" . $listBln[$i][0] . ">" . $listBln[$i][1] . "</option>";
                                                }
                                                $i++;
                                            }
                                            ?>
                                        </select></div>
                                    <div class="col-sm-3">
                                        <select class="form-control" id="ddThnGajiAdd">
                                            <?php
                                            $i = 0;
                                            for ($x = 0; $x < sizeof($listThn); $x++) {
                                                if ($listThn[$i] == date("Y")) {
                                                    echo "<option value=" . $listThn[$i] . " selected>" . $listThn[$i] . "</option>";
                                                } else {
                                                    echo "<option value=" . $listThn[$i] . ">" . $listThn[$i] . "</option>";
                                                }
                                                $i++;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="btnSubmit">&nbsp;</label>
                            <div class="col-sm-3">
                                <input id="issubmit" name="issubmit" type="hidden" value="true"/>
                                <button id="isSubmitDraft" type="submit" class="btn btn-success btn-sm" style="font-weight: bold;">Simpan Draft dan Eksekusi ke SIMGAJI</button>
                            </div>
                            <div class="col-sm-1" style="text-align: left">
                                <img id="imgLoading" src="images/preload-crop.gif" height="28" width="27">
                            </div>
                            <div class="col-sm-4" style="margin-top: 0px;">
                                <div id="notes" class="loading-progress" style="margin-bottom: -10px;margin-top: 5px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php
        if ($numpage > 0) {
            echo "Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage | $rowperpage<br>";
            echo $pgDisplay;
        }
        ?>
        <br><br>
        <script>
            var img = document.getElementById("imgLoading");
            img.style.visibility = 'hidden';
            $(function () {
                $("#frmEntryDraftGaji").bootstrapValidator({
                    message: "This value is not valid",
                    excluded: ':disabled',
                    feedbackIcons: {
                        valid: 'glyphicon glyphicon-ok',
                        invalid: 'glyphicon glyphicon-remove',
                        validating: 'glyphicon glyphicon-refresh'
                    }
                }).on("error.field.bv", function (b, a) {
                    a.element.data("bv.messages").find('.help-block[data-bv-for="' + a.field + '"]').hide()
                }).on('success.form.bv', function (e) {
                    e.preventDefault();
                    var $form = $(e.target);
                    var blnGaji = $("#ddBlnGajiAdd").val();
                    var thnGaji = $('#ddThnGajiAdd').val();
                    var checkboxes = $("#divChkStoreGaji input:checkbox");
                    var jmlCheck = 0;
                    var strSKStore = "";
                    for (var i = 1; i < checkboxes.length; i++) {
                        if (checkboxes[i].checked == true) {
                            strSKStore += checkboxes[i].value + "@";
                            jmlCheck++;
                        }
                    }
                    if(jmlCheck <= 0){
                        alert('Belum ada data yang dipilih');
                    }else{
                        strSKStore = strSKStore.substring(0, ((strSKStore.length)-1));
                        var dataGajiBpkad = new FormData();
                        dataGajiBpkad.append('penerbitSk', '<?php echo $opdPenerbit; ?>');
                        dataGajiBpkad.append('thnPeraturanGaji', '<?php echo $thnAturanGaji; ?>');
                        dataGajiBpkad.append('blnGaji', blnGaji);
                        dataGajiBpkad.append('thnGaji', thnGaji);
                        dataGajiBpkad.append('strSKStore', strSKStore);
                        dataGajiBpkad.append('data_change', 'addDraftPenyesuaianGapok');
                        var progress = $(".loading-progress").progressTimer({
                            timeLimit: 10,
                            onFinish: function () {
                                $("#notes").fadeOut();
                            }
                        });
                        $("#notes").fadeIn();
                        img.style.visibility = 'visible';
                        $.ajax({
                            url: "ptk_data_change.php",
                            data: dataGajiBpkad,
                            cache: false,
                            contentType: false,
                            processData: false,
                            method: 'POST',
                        }).done(function (data) {
                            progress.progressTimer('complete');
                            if (data == 1) {
                                alert('Data sukses tersimpan dan tereksekusi semua ke SIMGAJI');
                            }else if (data == 2) {
                                alert('Data sukses tersimpan semua tapi tidak semua tereksekusi ke SIMGAJI');
                            }else if(data == 3){
                                alert('Tidak semuanya data sukses tersimpan. Ada kemungkinan tersimpan/tereksekusi sebagian');
                            }else if(data == 4) {
                                alert('Tidak terkoneksi ke SIMGAJI');
                            }else if(data == 5){
                                alert('Proses input dibatalkan, koneksi ke SIM Gaji terputus. Data tidak tersimpan');
                            } else {
                                alert('Data tidak tersimpan');
                            }
                            img.style.visibility = 'hidden';
                            pagingViewListLoad(<?php echo $curpage;?>, <?php echo $ipp;?>, 'gapok_usulan');
                        });
                    }
                    $form.bootstrapValidator('disableSubmitButtons', false);
                });
            });
        </script>
    </div>
    <?php
} else {
    echo '<div style="padding: 10px;">Tidak ada data</div>';
}
?>
