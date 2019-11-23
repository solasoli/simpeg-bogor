<head>
    <style>
        .loading-progress2{
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

if ($oPtk->connectSimGaji()) {
    $konekGaji = true;
} else {
    $konekGaji = false;
}

$pages = new Paginator;
$pagePaging = $_POST['page'];
if ($pagePaging == 0 or $pagePaging == "") {
    $pagePaging = 1;
}

$ipp = $_POST['ipp'];
if ($ipp == "") {
    $ipp = 10;
}

$txtKeyword = $_POST['txtKeyword'];
$blnGaji = $_POST['blnGaji'];
$thnGaji = $_POST['thnGaji'];
$blnSk = $_POST['blnSk'];
$thnSk = $_POST['thnSk'];
$jnsSk = $_POST['jnsSk'];
$statusNIP = $_POST['statusNIP'];
$statusDraft = $_POST['statusDraft'];
$tbl = $_POST['tbl'];

$andKlausa = "";
if ($blnSk != '0') {
    $andKlausa .= " AND MONTH(ghg.tmt) = $blnSk ";
}
if ($thnSk != '0') {
    $andKlausa .= " AND YEAR(ghg.tmt) = $thnSk ";
}
if ($jnsSk != '0') {
    $andKlausa .= " AND ghg.KETERANGAN = '" . $jnsSk . "' ";
} else {
    $andKlausa .= "";
}
if ($statusNIP != '0') {
    if ($statusNIP == 1) {
        $statusNIP = 'TRUE';
    } else {
        $statusNIP = 'FALSE';
    }
    $andKlausa .= " AND ghg.is_find_simgaji = $statusNIP";
}
if ($statusDraft != '0') {
    if ($statusDraft == 1) {
        $statusDraft = 'TRUE';
    } else {
        $statusDraft = 'FALSE';
    }
    $andKlausa .= " AND ghg.sts_execute = $statusDraft";
}
if (!(trim($txtKeyword) == "") && !(trim($txtKeyword) == "0")) {
    $andKlausa .= " AND (ghg.NIP LIKE '%" . $txtKeyword . "%'
                                        OR p.nama LIKE '%" . $txtKeyword . "%'
                                        OR p.jabatan LIKE '%" . $txtKeyword . "%'
                                        OR j.jabatan LIKE '%" . $txtKeyword . "%'
                                        OR uk.nama_baru LIKE '%" . $txtKeyword . "%')";
}

$sqlCountAll = "SELECT COUNT(*) AS jml FROM
            (SELECT ghg.NIP, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.jenjab,
            CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
            (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
            WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
            ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, uk.nama_baru as unit,
            gst.NMSTAPEG, gpt.NMGOL, ghg.GAPOK, ghg.TMTTABEL, ghg.MASKER, ghg.BLGOLT, ghg.PRSNGAPOK, ghg.TGLSKEP,
            ghg.NOMORSKEP, ghg.tmt, ghg.TGLUPDATE, ghg.INPUTER, ghg.id_sk_simpeg, ghg.idpegawai_drafter,
            ghg.is_find_simgaji, ghg.sts_execute, ghg.tgl_execute, ghg.idpegawai_execute, ghg.keterangan_execute
            FROM gaji_historis_gapok ghg
            LEFT JOIN pegawai p ON ghg.NIP = p.nip_baru
            LEFT JOIN jabatan j ON p.id_j = j.id_j
            LEFT JOIN gaji_stapeg_tbl gst ON ghg.kdstapeg = gst.KDSTAPEG
            LEFT JOIN gaji_pangkat_tbl gpt ON ghg.KDPANGKAT = gpt.KDPANGKAT,
            current_lokasi_kerja clk, unit_kerja uk
            WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
            AND MONTH(ghg.TMTGAJI) = $blnGaji AND YEAR(ghg.TMTGAJI) = $thnGaji $andKlausa) a
            LEFT JOIN pegawai p ON a.INPUTER = p.nip_baru
            LEFT JOIN pegawai p1 ON p1.id_pegawai = a.idpegawai_drafter
            LEFT JOIN pegawai p2 ON p2.id_pegawai = a.idpegawai_execute
            ORDER BY a.eselon ASC, a.NMGOL DESC";

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

$sqlData = "SELECT a.*, p.nama AS nm_inputer, p1.nama AS nm_drafter, p2.nama AS nm_eksekutor FROM
            (SELECT ghg.NIP, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.jenjab,
            CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
            (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
            WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
            ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, uk.nama_baru as unit,
            gst.NMSTAPEG, gpt.NMGOL, ghg.GAPOK, ghg.TMTTABEL, ghg.MASKER, ghg.BLGOLT, ghg.PRSNGAPOK, ghg.TGLSKEP,
            ghg.NOMORSKEP, ghg.tmt, ghg.KETERANGAN, ghg.TGLUPDATE, ghg.INPUTER, ghg.id_sk_simpeg, ghg.idpegawai_drafter,
            ghg.is_find_simgaji, ghg.sts_execute, ghg.tgl_execute, ghg.idpegawai_execute, ghg.keterangan_execute,
            ghg.kdstapeg, ghg.KDPANGKAT, ghg.PENERBITSKEP
            FROM gaji_historis_gapok ghg
            LEFT JOIN pegawai p ON ghg.NIP = p.nip_baru
            LEFT JOIN jabatan j ON p.id_j = j.id_j
            LEFT JOIN gaji_stapeg_tbl gst ON ghg.kdstapeg = gst.KDSTAPEG
            LEFT JOIN gaji_pangkat_tbl gpt ON ghg.KDPANGKAT = gpt.KDPANGKAT,
            current_lokasi_kerja clk, unit_kerja uk
            WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
            AND MONTH(ghg.TMTGAJI) = $blnGaji AND YEAR(ghg.TMTGAJI) = $thnGaji $andKlausa) a
            LEFT JOIN pegawai p ON a.INPUTER = p.nip_baru
            LEFT JOIN pegawai p1 ON p1.id_pegawai = a.idpegawai_drafter
            LEFT JOIN pegawai p2 ON p2.id_pegawai = a.idpegawai_execute
            ORDER BY a.eselon ASC, a.NMGOL DESC" . $pages->limit;

$firstNum = explode(' ', $pages->limit);
$firstNum = explode(',', $firstNum[2]);
$query = $mysqli->query($sqlData);

if ($query->num_rows > 0) {
    ?>
    <div class="row" style="margin: 10px;margin-top: -5px;">
        <?php
        if ($numpage > 0) {
            echo "Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage | $rowperpage<br>";
            echo $pgDisplay;
        }
        $i = (int)$firstNum[0];
        ?>
        <form role="form" class="form-horizontal" action="" novalidate="novalidate"
              enctype="multipart/form-data" name="frmEksekusiDraftGaji" id="frmEksekusiDraftGaji">

            <div style="font-weight: bold;margin-top: 10px;margin-bottom: 10px;">
                Silahkan Pilih data tertentu di bawah ini untuk memasukkan ulang ke Historis Gaji Pokok di SIMGAJI jika
                belum / gagal tereksekusi :<br>
                <div class="col-sm-5" style="margin-bottom: 10px;margin-top: 5px;">
                    <input type="submit" onclick="return confirm('Anda yakin akan mengeksekusi ulang ke SIMGAJI?');" name="btnSubmitExecSIMGAJI"
                           id="btnSubmitExecSIMGAJI" class="btn btn-danger btn-sm" value="Eksekusi Ulang ke SIMGAJI" style="font-weight: bold;"/>
                    <input type="submit" onclick="return confirm('Anda yakin akan menghapus yang dipilih?');" name="btnDeleteExecSIMGAJI"
                           id="btnDeleteExecSIMGAJI" class="btn btn-default btn-sm" value="Hapus yang dipilih" style="color: darkred;font-weight: bold;"/>
                </div>
                <div class="col-sm-1" style="text-align: left; margin-top: 5px;">
                    <img id="imgLoading2" src="images/preload-crop.gif" height="28" width="27">
                </div>
                <div class="col-sm-4" style="margin-top: 10px;">
                    <div id="notes2" class="loading-progress2" style="margin-bottom: -10px;"></div>
                </div>
            </div>
            <div id="divChkEksekusiGaji"
                 style="border:1px solid #c0c2bb; overflow-y: scroll;height: 1250px; width: 100%;padding: 0px;">
                <table class='table' style="margin-top: 0px;">
                    <tr style='border-bottom: solid 2px #2cc256;border-top: solid 2px #000'>
                        <td>
                            <div class="checkbox checkbox-success" style="margin-top: -16px;">
                                <input id="chkAllDataExec" type="checkbox" value="" checked>
                                <label for="chkAllDataExec"></label></div>
                        </td>
                        <td>Jenis SK</td>
                        <td>Gol</td>
                        <td>Nomor</td>
                        <td>TMT</td>
                        <td style="width: 10%;">Masa Kerja</td>
                        <td>Tgl.SK</td>
                        <td>Gaji Pokok</td>
                        <td>Tabel Gaji</td>
                    </tr>
                    <?php while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                        $i++;
                        if ($konekGaji) {
                            if ($oPtk->isServerStillALive()) {
                                $res = $oPtk->checkHistorisGapok($blnGaji, $thnGaji, $oto[0]);
                                while ($oto2 = $res->fetch_array(MYSQLI_NUM)) {
                                    $jmlHist = $oto2[0];
                                }
                                $res = $oPtk->checkNIP($oto[0]);
                                while ($oto2 = $res->fetch_array(MYSQLI_NUM)) {
                                    $jmlNip = $oto2[0];
                                }
                                if ($jmlHist > 0) {
                                    $stsRealGaji = '<span class="label label-success"> Aktual Gaji (Sesuai TMT Gaji) : Ada</span>';
                                } else {
                                    $stsRealGaji = '<span class="label label-warning">Aktual Gaji (Sesuai TMT Gaji) : Belum Ada</span>';
                                }
                                if ($jmlNip > 0) {
                                    $stsRealNIP = '<span class="label label-success"> Aktual NIP : Ada</span>';
                                } else {
                                    $stsRealNIP = '<span class="label label-warning">Aktual NIP : Belum Ada</span>';
                                }
                            } else {
                                $stsRealNIP = '';
                                $stsRealGaji = '<span class="label label-info">Tidak terkoneksi dgn SIMGAJI</span>';
                            }
                        } else {
                            $stsRealNIP = '';
                            $stsRealGaji = '<span class="label label-info">Tidak terkoneksi dgn SIMGAJI</span>';
                        }
                        ?>
                        <tr>
                            <td><?php echo $i; ?>.</td>
                            <td><?php echo $oto[16] ?></td>
                            <td><?php echo $oto[7] ?></td>
                            <td><?php echo $oto[14] ?></td>
                            <td><?php echo $oto[15] ?></td>
                            <td><?php echo $oto[10] . ' Thn ' . $oto[11] . ' Bln' ?></td>
                            <td><?php echo $oto[13] ?></td>
                            <td><?php echo number_format($oto[8]) ?></td>
                            <td><?php echo $oto[9] ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid #747571;">
                                <div class="checkbox checkbox-success">
                                    <input id="chkSkExec<?php echo $oto[0].$blnGaji.$thnGaji; ?>" type="checkbox"
                                           value="<?php echo $oto[0] . '#' . $oto[26] . '#' . $oto[27] . '#' . $oto[8] . '#' . $oto[10] . '#' .
                                               $oto[12] . '#' . $oto[9] . '#' . $oto[13] . '#' . $oto[14] . '#' . $oto[28] . '#' . $oto[15] . '#' .
                                               $oto[16] . '#' . $oto[11]; ?>" checked>
                                    <label for="chkSkExec<?php echo $oto[0].$blnGaji.$thnGaji; ?>"></label>
                                </div>
                            </td>
                            <td colspan="8" style="border-bottom: 1px solid #747571;">
                                <div class="row">
                                    <div class="col-sm-6">
                                    <span
                                        style="font-size: large; font-weight: bold;"><?php echo $oto[1]; ?></span>
                                    <span style="font-size: medium">| NIP : <?php echo $oto[0]; ?>
                                        | Eselon : <?php echo($oto[4] == 'Z' ? '-' : $oto[4]); ?></span> <br>
                                        Jabatan : <?php echo $oto[3]; ?><br>
                                        Unit Kerja : <?php echo $oto[5]; ?>
                                    </div>
                                    <div class="col-sm-6">
                                        Tgl.Register : <?php echo $oto[17]; ?> oleh <?php echo $oto[30]; ?><br>
                                        Status Register : <?php echo($oto[6] == '' ? '' : $oto[6]); ?>
                                        (<?php echo($oto[21] == true ? '<span style="color:yellowgreen;font-weight: bold;">NIP Ada di SIMGAJI</span>' : '<span style="color:red;font-weight: bold;">NIP Tidak Ada di SIMGAJI</span>'); ?>
                                        )<br>
                                        Hasil Eksekusi ke
                                        SIMGAJI: <?php echo($oto[22] == false ? ($oto[23] == '' ? 'Belum Pernah <span class="glyphicon glyphicon-info-sign" style="color: orangered"></span>' : 'Gagal <span class="glyphicon glyphicon-info-sign" style="color: orangered"></span><br><span style="font-size: small;color: dimgrey;">(' . $oto[23] . ' oleh ' . $oto[31] . ' - ' . $oto[25] . ')</span>') : 'Sukses <span class="glyphicon glyphicon-ok-sign" style="color:royalblue;"></span><br><span style="font-size: small;color: dimgrey;">(' . $oto[23] . ' oleh ' . $oto[31] . ')</span>'); ?>
                                        <br>
                                        <?php echo $stsRealNIP . ' ' . $stsRealGaji; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    if ($konekGaji) {
                        $oPtk->closeKonekGaji();
                    }
                    ?>
                </table>
            </div>
            <script>
                $("#chkAllDataExec").change(function () {
                    $("#divChkEksekusiGaji input:checkbox").prop('checked', $(this).prop("checked"));
                });
            </script>
        </form>
        <script>
            var img2 = document.getElementById("imgLoading2");
            img2.style.visibility = 'hidden';
            $(function () {
                $("#frmEksekusiDraftGaji").bootstrapValidator({
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
                    var $formExec = $(e.target);
                    var $buttonExec = $formExec.data('bootstrapValidator').getSubmitButton();
                    var blnGajiEx = $("#ddBlnTMTGajiDraft").val();
                    var thnGajiEx = $('#ddThnTMTGajiDraft').val();
                    var checkboxesExec = $("#divChkEksekusiGaji input:checkbox");
                    var jmlCheckExec = 0;
                    var strSKStoreExec = "";
                    for (var i = 1; i < checkboxesExec.length; i++) {
                        if (checkboxesExec[i].checked == true) {
                            strSKStoreExec += checkboxesExec[i].value + "@";
                            jmlCheckExec++;
                        }
                    }
                    var statusEditEx = '';
                    if(jmlCheckExec <= 0){
                        alert('Belum ada data yang dipilih');
                    }else{
                        switch ($buttonExec.attr('id')) {
                            case 'btnSubmitExecSIMGAJI':
                                statusEditEx = 're_excute';
                                break;
                            case 'btnDeleteExecSIMGAJI':
                                statusEditEx = 'sts_delete';
                                break;
                            default:
                                break;
                        }
                        strSKStoreExec = strSKStoreExec.substring(0, ((strSKStoreExec.length)-1));
                        var dataGajiBpkadExec = new FormData();
                        dataGajiBpkadExec.append('blnGaji', blnGajiEx);
                        dataGajiBpkadExec.append('thnGaji', thnGajiEx);
                        dataGajiBpkadExec.append('strSKStore', strSKStoreExec);
                        dataGajiBpkadExec.append('statusEdit', statusEditEx);
                        dataGajiBpkadExec.append('data_change', 'addReExecuteMutasiGapok');
                        var progress2 = $(".loading-progress2").progressTimer({
                            timeLimit: 10,
                            onFinish: function () {
                                $("#notes2").fadeOut();
                                //alert('completed!');
                            }
                        });
                        $("#notes2").fadeIn();
                        img2.style.visibility = 'visible';
                        $.ajax({
                            url: "ptk_data_change.php",
                            data: dataGajiBpkadExec,
                            cache: false,
                            contentType: false,
                            processData: false,
                            type: 'POST',
                        }).done(function (data) {
                            progress2.progressTimer('complete');
                            if (data == 1) {
                                alert('Data sukses tereksekusi semua');
                            }else if (data == 2) {
                                alert('Data tidak semua tereksekusi');
                            }else if(data == 'notconnect_simgaji') {
                                alert('Tidak terkoneksi ke SIMGAJI');
                            }else if(data == 'rollback_notconnect_sim_gaji'){
                                alert('Proses input dibatalkan, koneksi ke SIM Gaji terputus. Data tidak tereksekusi');
                            } else {
                                alert('Data tidak tereksekusi');
                            }
                            img2.style.visibility = 'hidden';
                            pagingViewListLoad(<?php echo $curpage;?>, <?php echo $ipp;?>, 'gapok_draft');
                        });
                    }
                    $formExec.bootstrapValidator('disableSubmitButtons', false);
                });
            });
        </script>
        <?php
        if ($numpage > 0) {
            echo "Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage | $rowperpage<br>";
            echo $pgDisplay;
        }
        ?>
    </div>
    <?php
} else {
    echo '<div style="padding: 10px;">Tidak ada data</div>';
}
?>