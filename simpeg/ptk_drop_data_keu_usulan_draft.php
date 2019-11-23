<head>
    <style>
        .loading-progress2 {
            width: 100%;
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
$statusNIP = $_POST['statusNIP'];
$statusDraft = $_POST['statusDraft'];
$tbl = $_POST['tbl'];
$andKlausa = "";

if ($statusNIP != '0') {
    if ($statusNIP == 1) {
        $statusNIP = 'TRUE';
    } else {
        $statusNIP = 'FALSE';
    }
    $andKlausa .= " AND ghj.is_find_simgaji = $statusNIP";
}
if ($statusDraft != '0') {
    if ($statusDraft == 1) {
        $statusDraft = 'TRUE';
    } else {
        $statusDraft = 'FALSE';
    }
    $andKlausa .= " AND ghj.sts_execute = $statusDraft";
}
if (!(trim($txtKeyword) == "") && !(trim($txtKeyword) == "0")) {
    $andKlausa .= " AND (ghj.NIP LIKE '%" . $txtKeyword . "%'
                                        OR p.nama LIKE '%" . $txtKeyword . "%'
                                        OR p.jabatan LIKE '%" . $txtKeyword . "%'
                                        OR j.jabatan LIKE '%" . $txtKeyword . "%'
                                        OR uk.nama_baru LIKE '%" . $txtKeyword . "%')";
}

$sqlCountAll = "SELECT COUNT(*) AS jml FROM
                (SELECT ghj.NIP, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol, p.jenjab,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, uk.nama_baru as unit,
                ghj.JISTRI, ghj.JANAK, ghj.KETERANGAN, ghj.TGLUPDATE, ghj.kdstawin, ghj.id_ptk_simpeg, ghj.idpegawai_drafter,
                ghj.is_find_simgaji, ghj.sts_execute, ghj.tgl_execute, ghj.idpegawai_execute, ghj.keterangan_execute
                FROM gaji_historis_jiwa ghj
                LEFT JOIN pegawai p ON ghj.NIP = p.nip_baru
                LEFT JOIN jabatan j ON p.id_j = j.id_j,
                current_lokasi_kerja clk, unit_kerja uk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
                AND MONTH(ghj.TMTGAJI) = $blnGaji AND YEAR(ghj.TMTGAJI) = $thnGaji $andKlausa) a
                LEFT JOIN pegawai p1 ON p1.id_pegawai = a.idpegawai_drafter
                LEFT JOIN pegawai p2 ON p2.id_pegawai = a.idpegawai_execute
                ORDER BY a.eselon ASC";

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

$sqlData = "SELECT a.*, p1.nama AS nm_drafter, p2.nama AS nm_eksekutor FROM
            (SELECT ghj.NIP, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol, p.jenjab,
            CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
            (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
            WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
            ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, uk.nama_baru as unit,
            ghj.TMTGAJI, ghj.JISTRI, ghj.JANAK, ghj.KETERANGAN, ghj.TGLUPDATE, ghj.kdstawin, ghj.id_ptk_simpeg, ghj.idpegawai_drafter,
            ghj.is_find_simgaji, ghj.sts_execute, ghj.tgl_execute, ghj.idpegawai_execute, ghj.keterangan_execute
            FROM gaji_historis_jiwa ghj
            LEFT JOIN pegawai p ON ghj.NIP = p.nip_baru
            LEFT JOIN jabatan j ON p.id_j = j.id_j,
            current_lokasi_kerja clk, unit_kerja uk
            WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
            AND MONTH(ghj.TMTGAJI) = $blnGaji AND YEAR(ghj.TMTGAJI) = $thnGaji $andKlausa) a
            LEFT JOIN pegawai p1 ON p1.id_pegawai = a.idpegawai_drafter
            LEFT JOIN pegawai p2 ON p2.id_pegawai = a.idpegawai_execute
            ORDER BY a.eselon ASC" . $pages->limit;
//echo $sqlData;
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
              enctype="multipart/form-data" name="frmEksekusiDraftPtk" id="frmEksekusiDraftPtk">
            <div style="font-weight: bold;margin-top: 10px;margin-bottom: 10px;">
                Silahkan Pilih data tertentu di bawah ini untuk memasukkan ulang ke Historis Jiwa di SIMGAJI jika
                belum / gagal tereksekusi :<br>
                <div class="col-sm-5" style="margin-bottom: 10px;margin-top: 5px;">
                    <input type="submit" onclick="return confirm('Anda yakin akan mengeksekusi ulang ke SIMGAJI?');" name="btnSubmitExecSIMGAJIPtk"
                           id="btnSubmitExecSIMGAJIPtk" class="btn btn-danger btn-sm" value="Eksekusi Ulang ke SIMGAJI" style="font-weight: bold;"/>
                    <input type="submit" onclick="return confirm('Anda yakin akan menghapus yang dipilih?');" name="btnDeleteExecSIMGAJIPtk"
                           id="btnDeleteExecSIMGAJIPtk" class="btn btn-default btn-sm" value="Hapus yang dipilih" style="color: darkred;font-weight: bold;"/>
                </div>
                <div class="col-sm-1" style="text-align: left; margin-top: 5px;">
                    <img id="imgLoading3" src="images/preload-crop.gif" height="28" width="27">
                </div>
                <div class="col-sm-4" style="margin-top: 10px;">
                    <div id="notes2" class="loading-progress2" style="margin-bottom: -10px;"></div>
                </div>
            </div>
            <div id="divChkEksekusiPtk"
                 style="border:1px solid #c0c2bb; overflow-y: scroll;height: 700px; width: 100%;padding: 0px;">
                <table class='table' style="margin-top: 0px;">
                    <tr style='border-bottom: solid 2px #2cc256;border-top: solid 2px #000'>
                        <td>
                            <div class="checkbox checkbox-success" style="margin-top: -16px;">
                                <input id="chkAllDataPtkExec" type="checkbox" value="" checked>
                                <label for="chkAllDataPtkExec"></label></div>
                        </td>
                        <td style="width: 15%;">NIP</td>
                        <td style="width: 20%;">Nama</td>
                        <td style="width: 8%;">Gol / Es</td>
                        <td>Jabatan</td>
                        <td>Unit Kerja</td>
                    </tr>
                    <?php while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                        $i++;
                        if ($konekGaji) {
                            if ($oPtk->isServerStillALive()) {
                                $res = $oPtk->checkHistorisJiwa($blnGaji, $thnGaji, $oto[0]);
                                while ($oto2 = $res->fetch_array(MYSQLI_NUM)) {
                                    $jmlHist = $oto2[0];
                                }
                                $res = $oPtk->checkNIP($oto[0]);
                                while ($oto2 = $res->fetch_array(MYSQLI_NUM)) {
                                    $jmlNip = $oto2[0];
                                }
                                if ($jmlHist > 0) {
                                    $stsRealGaji = '<span class="label label-success"> Aktual Jiwa (Sesuai TMT) : Ada</span>';
                                } else {
                                    $stsRealGaji = '<span class="label label-warning">Aktual Jiwa (Sesuai TMT) : Belum Ada</span>';
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
                            <td><?php echo $oto[0]; ?></td>
                            <td><strong><?php echo $oto[1]; ?></strong></td>
                            <td><?php echo $oto[2].' / '.($oto[5]=='Z'?'-':$oto[5]); ?></td>
                            <td><?php echo $oto[4]; ?></td>
                            <td><?php echo $oto[6]; ?></td>
                        </tr>
                        <tr>
                            <td style="border-bottom: 1px solid #747571;">
                                <div class="checkbox checkbox-success" style="margin-top: -10px;">
                                    <input id="chkSkExec<?php echo $oto[0].$blnGaji.$thnGaji; ?>" type="checkbox"
                                           value="<?php echo $oto[0].'#'.$oto[8].'#'.$oto[9].'#'.$oto[13]; ?>" checked>
                                    <label for="chkSkExec<?php echo $oto[0].$blnGaji.$thnGaji; ?>"></label>
                                </div>
                            </td>
                            <td colspan="3" style="border-bottom: 1px solid #747571;">
                                TMT.Jiwa : <?php echo $oto[7]; ?><br>
                                Jumlah Pasangan : <?php echo $oto[8]; ?> Org <strong>|</strong>
                                Jumlah Anak : <?php echo $oto[9]; ?> Org<br>
                                Tgl.Register : <?php echo $oto[11]; ?>, Oleh : <?php echo $oto[20]; ?><br>
                                (<?php echo($oto[15] == true ? '<span style="color:yellowgreen;font-weight: bold;">NIP Ada di SIMGAJI</span>' :
                                    '<span style="color:red;font-weight: bold;">NIP Tidak Ada di SIMGAJI</span>'); ?>)
                            </td>
                            <td colspan="2" style="border-bottom: 1px solid #747571;">
                                Hasil Eksekusi ke SIMGAJI: <?php echo($oto[16] == false ? ($oto[17] == '' ? 'Belum Pernah <span class="glyphicon glyphicon-info-sign" style="color: orangered"></span>' : 'Gagal <span class="glyphicon glyphicon-info-sign" style="color: orangered"></span><br><span style="font-size: small;color: dimgrey;">(' . $oto[17] . ' oleh ' . $oto[21] . ' - ' . $oto[19] . ')</span>') : 'Sukses <span class="glyphicon glyphicon-ok-sign" style="color:royalblue;"></span><br><span style="font-size: small;color: dimgrey;">(' . $oto[17] . ' oleh ' . $oto[21] . ')</span>'); ?>
                                <br>
                                <?php echo $stsRealNIP . ' ' . $stsRealGaji; ?>
                            </td>
                        </tr>
                    <?php }
                    if ($konekGaji) {
                        $oPtk->closeKonekGaji();
                    }
                    ?>
                </table>
            </div>
            <script>
                $("#chkAllDataPtkExec").change(function () {
                    $("#divChkEksekusiPtk input:checkbox").prop('checked', $(this).prop("checked"));
                });
            </script>
        </form>
        <script>
            var img3 = document.getElementById("imgLoading3");
            img3.style.visibility = 'hidden';
            $(function () {
                $("#frmEksekusiDraftPtk").bootstrapValidator({
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
                    var blnGajiEx = $("#ddBlnTMTGajiPTKDraft").val();
                    var thnGajiEx = $('#ddThnTMTGajiPTKDraft').val();
                    var checkboxesExec = $("#divChkEksekusiPtk input:checkbox");
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
                            case 'btnSubmitExecSIMGAJIPtk':
                                statusEditEx = 're_excute';
                                break;
                            case 'btnDeleteExecSIMGAJIPtk':
                                statusEditEx = 'sts_delete';
                                break;
                            default:
                                break;
                        }

                        strSKStoreExec = strSKStoreExec.substring(0, ((strSKStoreExec.length)-1));
                        var dataPtkBpkadExec = new FormData();
                        dataPtkBpkadExec.append('blnGaji', blnGajiEx);
                        dataPtkBpkadExec.append('thnGaji', thnGajiEx);
                        dataPtkBpkadExec.append('strPTKStore', strSKStoreExec);
                        dataPtkBpkadExec.append('statusEdit', statusEditEx);
                        dataPtkBpkadExec.append('data_change', 'addReExecuteMutasiPTK');
                        var progress2 = $(".loading-progress2").progressTimer({
                            timeLimit: 10,
                            onFinish: function () {
                                $("#notes2").fadeOut();
                                //alert('completed!');
                            }
                        });
                        $("#notes2").fadeIn();
                        img3.style.visibility = 'visible';
                        $.ajax({
                            url: "ptk_data_change.php",
                            data: dataPtkBpkadExec,
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
                            img3.style.visibility = 'hidden';
                            pagingViewListLoad(<?php echo $curpage;?>, <?php echo $ipp;?>, 'jiwa_draft');
                        });
                    }
                    $formExec.bootstrapValidator('disableSubmitButtons', false);
                });
            });
        </script>
        <br>
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
