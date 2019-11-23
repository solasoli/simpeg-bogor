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

        .loading-progress {
            width: 100%;
        }
    </style>
    <script src="js/jquery-progressTimer/js/jquery.progresstimer.js"></script>
</head>
<div class="row" style="margin: 10px;">
    <?php
    session_start();
    include "konek.php";
    include "paginator.class.php";
    include 'class/cls_ptk.php';
    $oPtk = new Ptk();
    $listBln = $oPtk->listBulan();
    $listThn = $oPtk->listTahun();
    $txtKeyword = $_POST['txtKeyword'];
    $jenis = $_POST['jenis'];
    $status = $_POST['status'];
    $chkwaktu = $_POST['chkwaktu'];
    $chkViewSyaratProsesHist = $_POST['chkViewSyaratProsesHist'];
    $tglAwal = $_POST['tglAwal'];
    $tglAkhir = $_POST['tglAkhir'];

    $pages = new Paginator;
    $pagePaging = $_POST['page'];
    if ($pagePaging == 0 or $pagePaging == "") {
        $pagePaging = 1;
    }
    if ($chkViewSyaratProsesHist == 'true') {
        $pages->setCustomeDefaultIpp(2);
    }
    $ipp = $_POST['ipp'];
    if ($ipp == "") {
        $ipp = 10;
    }
    $ipp = $pages->items_per_page;
    $whereKlause = "";
    if ($jenis != '0') {
        $whereKlause .= " AND pjp.jenis_pengajuan = '" . $jenis . "'";
    }
    if ($status == '0') {
        $whereKlause .= " AND pm.idstatus_ptk IN (8,9,10,11) ";
    } else {
        $whereKlause .= " AND pm.idstatus_ptk = " . $status;
    }
    if ($chkwaktu == 'true') {
        $tglAwal = explode('-', $tglAwal);
        $tglAwal = $tglAwal[2] . '-' . $tglAwal[1] . '-' . $tglAwal[0];
        $tglAkhir = explode('-', $tglAkhir);
        $tglAkhir = $tglAkhir[2] . '-' . $tglAkhir[1] . '-' . $tglAkhir[0];
        $whereKlause .= " AND pm.tgl_input_pengajuan BETWEEN '" . $tglAwal . " 00:00:00.000' AND '" . $tglAkhir . " 23:59:59.997' ";
    }
    if (!(trim($txtKeyword) == "") && !(trim($txtKeyword) == "0")) {
        $whereKlause .= " AND (pm.nomor LIKE '%" . $txtKeyword . "%'
                           OR p.nama LIKE '%" . $txtKeyword . "%' OR p.nip_baru LIKE '%" . $txtKeyword . "%'
                           OR pm.last_jabatan LIKE '%" . $txtKeyword . "%'
                           OR uk.nama_baru LIKE '%" . $txtKeyword . "%')";
    }

    $sqlCountAll = "SELECT COUNT(*) as jumlah FROM
                (SELECT pm.id_ptk, pm.tgl_input_pengajuan, pm.nomor, pm.sifat, pm.lampiran, pjp.jenis_pengajuan, pm.last_jml_pasangan,
                pm.last_jml_anak, p.id_pegawai, p.nama, p.nip_baru, pm.last_gol, pm.last_jabatan, uk.nama_baru AS unit, rsp.status_ptk,
                pm.id_berkas_pengajuan, pm.id_berkas_skum, pm.id_berkas_sk_pangkat_last, pm.id_berkas_daftar_gaji_last,
                pm.idstatus_ptk, pm.tgl_approve, pm.approved_note, pm.approved_by, pm.id_berkas_ptk, pm.id_berkas_kk_last
                FROM ptk_master pm, ptk_jenis_pengajuan pjp, pegawai p, unit_kerja uk, ref_status_ptk rsp
                WHERE pm.id_jenis_pengajuan = pjp.id_jenis_pengajuan AND pm.id_pegawai_pemohon = p.id_pegawai AND
                pm.last_id_unit_kerja = uk.id_unit_kerja AND pm.idstatus_ptk = rsp.id_status_ptk $whereKlause) a
                LEFT JOIN pegawai p ON a.approved_by = p.id_pegawai ORDER BY a.tgl_input_pengajuan DESC";

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

    $linkBerkasUsulan = '';
    $tglUpload = '';
    $linkBerkasUsulan1 = '';
    $linkBerkasUsulan2 = '';
    $linkBerkasUsulan3 = '';
    $linkBerkasUsulan4 = '';
    $linkBerkasUsulan5 = '';
    $tglUpload1 = '';
    $tglUpload2 = '';
    $tglUpload3 = '';
    $tglUpload4 = '';
    $tglUpload5 = '';

    $sqlData = "SELECT a.*, p.nama as approve_by, p.nip_baru AS nip_approver FROM
                (SELECT pm.id_ptk, pm.tgl_input_pengajuan, pm.nomor, pm.sifat, pm.lampiran, pjp.jenis_pengajuan, pm.last_jml_pasangan,
                pm.last_jml_anak, p.id_pegawai, p.nama, p.nip_baru, pm.last_gol, pm.last_jabatan, uk.nama_baru AS unit, rsp.status_ptk,
                pm.id_berkas_pengajuan, pm.id_berkas_skum, pm.id_berkas_sk_pangkat_last, pm.id_berkas_daftar_gaji_last,
                pm.idstatus_ptk, pm.tgl_approve, pm.approved_note, pm.approved_by, pm.id_berkas_ptk, pm.id_berkas_kk_last
                FROM ptk_master pm, ptk_jenis_pengajuan pjp, pegawai p, unit_kerja uk, ref_status_ptk rsp
                WHERE pm.id_jenis_pengajuan = pjp.id_jenis_pengajuan AND pm.id_pegawai_pemohon = p.id_pegawai AND
                pm.last_id_unit_kerja = uk.id_unit_kerja AND pm.idstatus_ptk = rsp.id_status_ptk $whereKlause) a
                LEFT JOIN pegawai p ON a.approved_by = p.id_pegawai ORDER BY a.tgl_input_pengajuan DESC " . $pages->limit;
    //echo $sqlData.'<br>';
    $firstNum = explode(' ', $pages->limit);
    $firstNum = explode(',', $firstNum[2]);
    $query = $mysqli->query($sqlData);

    if ($query->num_rows > 0) {
        if ($numpage > 0) {
            echo "Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage";
            if ($chkViewSyaratProsesHist == 'false') {
                echo " | " . $rowperpage . "<br>";
            } else {
                echo "<br>";
            }
            echo $pgDisplay;
        }
        $i = (int)$firstNum[0];
        ?>
        <ul class="nav nav-tabs" role="tablist" id="myTabPtk" style="margin-top: 10px;">
            <li role="presentation" class="active">
                <a href="#proses_manual" aria-controls="proses_manual" role="tab" data-toggle="tab"
                   style="color: steelblue;font-weight: bold;">
                    Proses Usulan</a></li>
            <li role="presentation">
                <a href="#proses_otomatis" aria-controls="proses_otomatis" role="tab" data-toggle="tab"
                   style="color: steelblue;font-weight: bold;">
                    Form Registrasi Draft SIMGAJI</a></li>
        </ul>
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="proses_manual">
                <form role="form" class="form-horizontal" action="" novalidate="novalidate"
                      enctype="multipart/form-data" name="frmReqPTKAjukanBPKAD" id="frmReqPTKAjukanBPKAD">
                    <div class="row" style="margin-bottom: 10px;margin-top: 10px;">
                        <div class="col-sm-3">
                            <input id="txtCatatanBpkad" name="txtCatatanBpkad" type="text" value="" style="width: 100%;"
                                   class="form-control" placeholder="Keterangan">
                        </div>
                        <input type="submit" onclick="return confirm('Anda yakin akan memproses usulan-usulan ini?');"
                               name="btnProsesBpkad"
                               id="btnProsesBpkad" class="btn btn-warning btn-sm" value="Dalam Proses"
                               style="font-weight: bold;"/>
                        <input type="submit" onclick="return confirm('Anda yakin akan menolak usulan-usulan ini?');"
                               name="btnDitolakBpkad"
                               id="btnDitolakBpkad" class="btn btn-danger btn-sm" value="Ditolak"
                               style="font-weight: bold;"/>
                        <input type="submit"
                               onclick="return confirm('Anda yakin usulan-usulan ini tunjangan jiwanya sudah diubah?');"
                               name="btnGajiTerupdate"
                               id="btnGajiTerupdate" class="btn btn-success btn-sm" value="Tunjangan Sudah diubah"
                               style="font-weight: bold;"/>
                    </div>
                </form>
            </div>
            <div role="tabpanel" class="tab-pane" id="proses_otomatis">
                <form role="form" class="form-horizontal" action="" novalidate="novalidate"
                      enctype="multipart/form-data" name="frmEntryDraftPtk" id="frmEntryDraftPtk">
                    <div class="row" style="margin-bottom: 10px;margin-top: 10px;">
                        <div style="margin-left: 15px;">
                            Form ini digunakan untuk memasukkan data PTK ke dalam Nominatif Draft Penyusunan Pengubahan
                            Tunjangan Jiwa. <br>
                            Sesuai dengan data PTK yang dipilih (Ceklist) pada halaman tertentu.
                        </div>
                        <div class="col-sm-12" style="margin-left: 15px;margin-top: 10px;">
                            <div class="row">
                                <div class="col-sm-2" style="margin-top: 5px;margin-left: -15px;">Tgl. Pembuatan :</div>
                                <div class="col-sm-2" style="margin-left: -50px;">
                                    <input type="text" class="form-control" id="tglPembuatanDraft"
                                           name="tglPembuatanDraft"
                                           value="<?php echo date("d-m-Y"); ?>" readonly="readonly">
                                </div>
                                <div class="col-sm-2" style="margin-top: 5px;margin-left: -15px;">TMT. Gaji :</div>
                                <div class="col-sm-2" style="margin-left: -80px;">
                                    <select class="form-control" id="ddBlnGajiAddPtk">
                                        <?php
                                        $i2 = 0;
                                        for ($x = 0; $x <= 11; $x++) {
                                            if ($listBln[$i][0] == date("m")) {
                                                echo "<option value=" . $listBln[$i2][0] . " selected>" . $listBln[$i2][1] . "</option>";
                                            } else {
                                                echo "<option value=" . $listBln[$i2][0] . ">" . $listBln[$i2][1] . "</option>";
                                            }
                                            $i2++;
                                        }
                                        ?>
                                    </select></div>
                                <div class="col-sm-2" style="margin-left: -10px;">
                                    <select class="form-control" id="ddThnGajiAddPtk">
                                        <?php
                                        $i2 = 0;
                                        for ($x = 0; $x < sizeof($listThn); $x++) {
                                            if ($listThn[$i2] == date("Y")) {
                                                echo "<option value=" . $listThn[$i2] . " selected>" . $listThn[$i2] . "</option>";
                                            } else {
                                                echo "<option value=" . $listThn[$i2] . ">" . $listThn[$i2] . "</option>";
                                            }
                                            $i2++;
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-2" style="margin-left: -10px;">
                                    <input id="issubmit" name="issubmit" type="hidden" value="true"/>
                                    <button id="isSubmitDraftPtk" type="submit" class="btn btn-success btn-sm"
                                            style="font-weight: bold;">Simpan Draft dan Eksekusi ke SIMGAJI
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7"><strong>Silahkan Pilih Pengajuan PTK di bawah ini untuk pemrosesan pengajuan
                    :</strong></div>
            <div class="col-md-2">
                <div class="checkbox checkbox-success" style="margin-top: 0px;margin-bottom: 0px; margin-left: -70px;">
                    <input id="chkAllPtk" type="checkbox" value="" checked>
                    <label for="chkAllPtk">Pilih Semua PTK</label></div>
            </div>
            <div class="col-sm-1" style="text-align: left;margin-left: -80px;">
                <img id="imgLoadingPtk" src="images/preload-crop.gif" height="28" width="27">
            </div>
            <div class="col-sm-2" style="margin-top: 0px;">
                <div id="notesPtk" class="loading-progress"></div>
            </div>
        </div>
        <div id="divChkStorePtk">
            <table class='table' style="margin-top: 0px;">
                <?php
                while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                    $i++;
                    $idptk = $oto[0];
                    $idstatus_ptk = $oto[19];
                    $idberkas1 = $oto[15]; //Usulan
                    $idberkas2 = $oto[16]; //SKUM
                    $idberkas3 = $oto[17]; //SK Pangkat
                    $idberkas4 = $oto[18]; //Daftar Gaji
                    $idberkas5 = $oto[24]; //KK
                    $nip = $oto[10]; //NIP
                    $idp = $oto[8]; //ID Pegawai
                    $nama = $oto[9]; //Nama
                    ?>
                    <tr style='border-bottom: solid 2px #2cc256;border-top: solid 2px #000'>
                        <td>No</td>
                        <td style="width: 18%;">Waktu Permohonan</td>
                        <td>Nomor</td>
                        <td>Sifat</td>
                        <td>Lampiran</td>
                        <td style="width: 25%;">Jenis Pengajuan</td>
                        <td style="width: 15%;">Jml. Pasangan</td>
                        <td style="width: 15%;">Jml. Anak</td>
                    </tr>
                    <tr>
                        <td><?php echo $i; ?>.</td>
                        <td><?php echo $oto[1]; ?></td>
                        <td><?php echo $oto[2]; ?></td>
                        <td><?php echo $oto[3]; ?></td>
                        <td><?php echo $oto[4]; ?></td>
                        <td><?php echo $oto[5]; ?></td>
                        <td><?php echo $oto[6]; ?> orang</td>
                        <td><?php echo $oto[7]; ?> orang</td>
                    </tr>
                    <tr>
                        <td>
                            <div class="checkbox checkbox-success" style="margin-top: -5px;">
                                <input id="chkPtk<?php echo $oto[0]; ?>" type="checkbox"
                                       value="<?php echo $oto[0] . '#' . $oto[10] . '#' . $oto[6] . '#' . $oto[7]; ?>"
                                       checked>
                                <label for="chkPtk<?php echo $oto[0]; ?>"></label>
                            </div>
                        </td>
                        <td colspan="7">
                            <span style="font-size: large; font-weight: bold;"><?php echo $oto[9]; ?></span>
                            <span style="font-size: medium">| NIP : <?php echo $oto[10]; ?></span> <br>
                            Jabatan : <?php echo $oto[12]; ?><br>
                            Unit Kerja : <?php echo $oto[13]; ?><br>
                            Status Pengajuan : <span style="font-size: medium; color: #0c199c;">
                                <?php
                                echo $oto[14];

                                if ($oto[23] <> "" and $oto[23] <> "0") {

                                    $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = $oto[23]";
                                    $query2 = $mysqli->query($sqlCekBerkas);
                                    if (isset($query)) {
                                        if ($query2->num_rows > 0) {
                                            while ($otof = $query2->fetch_array(MYSQLI_NUM)) {
                                                $asli = basename($otof[0]);
                                                if (file_exists(str_replace("\\", "/", getcwd()) . '/Berkas/' . trim($asli))) {
                                                    $ext[] = explode(".", $asli);
                                                    $linkBerkasUsulan = "<a href='./Berkas/$asli' target='_blank' class=\"btn-sm btn-default\" style='border: 1px solid #747571'><strong>Download Berkas Pengajuan PTK ke BPKAD</strong></a>";
                                                    $tglUpload = $otof[2] . ' oleh ' . $otof[4] . ' (' . $otof[3] . ')';
                                                    unset($ext);
                                                }
                                            }
                                        }
                                        echo "<br>$linkBerkasUsulan";
                                        echo "<small class=\"form-text text-muted\">";
                                        echo " Tgl.Upload : " . $tglUpload . "</small>";
                                    }
                                }
                                ?></span><br>

                            <div style="margin-top: 10px;margin-bottom: 0px;">
                                <a href="javascript:void(0);" onclick="lihatDaftarGaji('<?php echo $nip; ?>');"
                                   style="font-weight: bold; color: darkorange;"><strong>Lihat
                                        Daftar Gaji & Tunjangan</strong></a> |
                                <a href="javascript:void(0);"
                                   onclick="cekLebihLanjutSimGaji('<?php echo $nip; ?>','<?php echo $nama; ?>',<?php echo $idp; ?>);"><strong>Detail
                                        Informasi Pegawai</strong></a> |
                                <a href="javascript:void(0);"
                                   onclick="lihatKeluargaSimpegGaji(<?php echo $idp; ?>,'<?php echo $nip; ?>');">
                                    <strong>Informasi Keluarga SIMPEG - SIMGAJI</strong></a>
                            </div>
                            <?php
                            if ($oto[20] <> '' and ($oto[23] == "" or $oto[23] == "0")) {
                                echo "<br>Tanggal Status: $oto[20] Oleh : $oto[25] ($oto[26]). Catatan: $oto[21]";
                            }
                            ?>
                            <?php if ($chkViewSyaratProsesHist == 'true'): ?>
                                <br><br>
                                <ul class="nav nav-tabs" role="tablist" id="myTab_PTKKeu<?php echo $idptk; ?>"
                                    style="margin-top: -20px;">
                                    <li role="presentation" class="active"><a href="#revSyarat<?php echo $idptk; ?>"
                                                                              aria-controls="revSyarat<?php echo $idptk; ?>"
                                                                              role="tab" data-toggle="tab"
                                                                              style="color: brown;font-weight: bold;">Peninjauan Persyaratan</a></li>
                                    <li role="presentation"><a href="#histProses<?php echo $idptk; ?>"
                                                               aria-controls="histProses<?php echo $idptk; ?>"
                                                               role="tab"
                                                               data-toggle="tab"
                                                               style="color: brown;font-weight: bold;">Riwayat Status Usulan</a></li>
                                    <li role="presentation"><a href="#histEksekusi<?php echo $idptk; ?>"
                                                               aria-controls="histEksekusi<?php echo $idptk; ?>"
                                                               role="tab"
                                                               data-toggle="tab"
                                                               style="color: brown;font-weight: bold;">Riwayat Eksekusi ke SIMGAJI</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="revSyarat<?php echo $idptk; ?>">
                                        <?php
                                        $sql = "SELECT pk.id_ptk_keluarga, ptp.id_tipe_pengubahan_tunjangan, ptp.kategori_pengubahan, ptp.tipe_pengubahan_tunjangan,
                                        sk.status_keluarga, pk.last_nama, pk.last_tempat_lahir, pk.last_tgl_lahir, pk.last_pekerjaan,
                                        CASE WHEN pk.last_jk = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS last_jk,
                                        CASE WHEN pk.last_status_tunjangan = 0 THEN 'Tidak Dapat' ELSE 'Dapat' END AS last_status_tunjangan,
                                        ps.last_tgl_references, ps.last_keterangan_reference, ps.id_berkas_syarat, ptp.nama_berkas_syarat, ps.id_syarat
                                        FROM ptk_keluarga pk, ptk_tipe_pengubahan ptp, status_kel sk, ptk_syarat ps
                                        WHERE pk.id_ptk = $oto[0] AND pk.id_tipe_pengubahan_tunjangan = ptp.id_tipe_pengubahan_tunjangan AND
                                        pk.last_id_status_keluarga = sk.id_status AND pk.id_ptk_keluarga = ps.id_ptk_keluarga
                                        ORDER BY pk.last_id_status_keluarga, pk.last_nama";
                                        $query3 = $mysqli->query($sql);
                                        if ($query3->num_rows > 0) {
                                            ?>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <table class="table">
                                                        <tr style='border-bottom: solid 2px #d29d4e'>
                                                            <td>No</td>
                                                            <td>Pengubahan Keluarga</td>
                                                            <td>Status Tunjangan</td>
                                                        </tr>
                                                        <?php
                                                        $x = 1;
                                                        while ($oto2 = $query3->fetch_array(MYSQLI_NUM)) {
                                                            ?>
                                                            <tr>
                                                                <td><?php echo $x; ?>)</td>
                                                                <td><?php echo $oto2[2] . ' krn ' . $oto2[3]; ?></td>
                                                                <td><?php echo $oto2[10] ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td>
                                                                    <?php echo "$oto2[4] : <strong>$oto2[5]</strong> <br> Jenis Kelamin : $oto2[9]<br>Kelahiran : $oto2[6], $oto2[7]<br>Pekerjaan : $oto2[8]"; ?>
                                                                </td>
                                                                <td>
                                                                    <?php
                                                                    if ($oto2[13] <> '' and $oto2[13] <> '0') {
                                                                        $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                                         FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                                         WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = " . $oto2[13];
                                                                        $query4 = $mysqli->query($sqlCekBerkas);
                                                                        if (isset($query4)) {
                                                                            if ($query4->num_rows > 0) {
                                                                                while ($oto = $query4->fetch_array(MYSQLI_NUM)) {
                                                                                    $asli = basename($oto[0]);
                                                                                    if (file_exists(str_replace("\\", "/", getcwd()) . '/Berkas/' . trim($asli))) {
                                                                                        $ext[] = explode(".", $asli);
                                                                                        $linkBerkasUsulan = "<a href='./Berkas/$asli' target='_blank'>Berkas Syarat</a>";
                                                                                        $tglUpload = $oto[2] . "<br>$oto2[14]<br>$oto2[11]" . ($oto2[12] == '' ? '' : ' ' . $oto2[12]);
                                                                                        $pengUpload = $oto[4] . ' (' . $oto[3] . ')';
                                                                                        $idkat_berkas = $oto[5];
                                                                                        unset($ext);
                                                                                    }
                                                                                }
                                                                            }
                                                                            if ($linkBerkasUsulan <> "") {
                                                                                echo "$linkBerkasUsulan";
                                                                                echo "<small class=\"form-text text-muted\">";
                                                                                echo "<br>Tgl.Upload : " . $tglUpload . "</small>";
                                                                            }
                                                                        }
                                                                    }
                                                                    ?>
                                                                </td>
                                                            </tr>
                                                            <?php $x++;
                                                        } ?>
                                                        <!--<tr>
                                                            <td colspan="3" style="text-align: center;">
                                                                <button type="button" class="btn btn-primary btn-sm"
                                                                        id="btnKeluargaSimpeg" name="btnKeluargaSimpeg"
                                                                        onclick="lihatKeluargaSimpegGaji(<?php //echo $idp; ?>,'<?php //echo $nip; ?>')"
                                                                        style="font-weight: bold;">Informasi Keluarga
                                                                    SIMPEG
                                                                    - SIMGAJI
                                                                </button>
                                                            </td>
                                                        </tr>-->
                                                    </table>
                                                </div>
                                                <div class="col-lg-6">
                                                    <table class="table">
                                                        <tr style='border-bottom: solid 2px #d25e52'>
                                                            <td>No</td>
                                                            <td>Persyaratan Lainnya</td>
                                                            <td></td>
                                                        </tr>
                                                        <?php
                                                        // LOAD BERKAS
                                                        if ($idberkas1 == '') {
                                                            $idberkas1 = -1;
                                                        }
                                                        if ($idberkas2 == '') {
                                                            $idberkas2 = -1;
                                                        }
                                                        if ($idberkas3 == '') {
                                                            $idberkas3 = -1;
                                                        }
                                                        if ($idberkas4 == '') {
                                                            $idberkas4 = -1;
                                                        }
                                                        if ($idberkas5 == '') {
                                                            $idberkas5 = -1;
                                                        }
                                                        $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                                                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas IN ($idberkas1,$idberkas2,$idberkas3,$idberkas4,$idberkas5)";

                                                        $query5 = $mysqli->query($sqlCekBerkas);
                                                        if (isset($query5)) {
                                                            if ($query5->num_rows > 0) {
                                                                while ($oto3 = $query5->fetch_array(MYSQLI_NUM)) {
                                                                    $asli = basename($oto3[0]);
                                                                    if (file_exists(str_replace("\\", "/", getcwd()) . '/Berkas/' . trim($asli))) {
                                                                        $ext[] = explode(".", $asli);
                                                                        switch ($oto3[5]) {
                                                                            case 40: //Surat Pengantar dari OPD
                                                                                $linkBerkasUsulan1 = "<a href='./Berkas/$asli' target='_blank'>Berkas Syarat</a>";
                                                                                $tglUpload1 = $oto3[2];
                                                                                break;
                                                                            case 45: //SKUM
                                                                                $linkBerkasUsulan2 = "<a href='./Berkas/$asli' target='_blank'>Berkas Syarat</a>";
                                                                                $tglUpload2 = $oto3[2];
                                                                                break;
                                                                            case 2: //SK Pangkat Terakhir
                                                                                $linkBerkasUsulan3 = "<a href='./Berkas/$asli' target='_blank'>Berkas Syarat</a>";
                                                                                $tglUpload3 = $oto3[2];
                                                                                break;
                                                                            case 46: //Daftar Gaji
                                                                                $linkBerkasUsulan4 = "<a href='./Berkas/$asli' target='_blank'>Berkas Syarat</a>";
                                                                                $tglUpload4 = $oto3[2];
                                                                                break;
                                                                            case 14: //Kartu Keluarga
                                                                                $linkBerkasUsulan5 = "<a href='./Berkas/$asli' target='_blank'>Berkas Syarat</a>";
                                                                                $tglUpload5 = $oto3[2];
                                                                                break;
                                                                        }
                                                                        unset($ext);
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td>1)</td>
                                                            <td>Usulan / Pengantar OPD</td>
                                                            <td>
                                                                <?php if ($idberkas1 <> "" and $idberkas1 <> "0" and $idberkas1 <> -1) {
                                                                    echo "$linkBerkasUsulan1";
                                                                    echo "<small class=\"form-text text-muted\">";
                                                                    echo "<br>Tgl.Upload : " . $tglUpload1 . "</small>";
                                                                } else {
                                                                    echo "Belum ada berkas";
                                                                } ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>2)</td>
                                                            <td>SKUM</td>
                                                            <td>
                                                                <?php if ($idberkas2 <> "" and $idberkas2 <> "0" and $idberkas2 <> -1) {
                                                                    echo "$linkBerkasUsulan2";
                                                                    echo "<small class=\"form-text text-muted\">";
                                                                    echo "<br>Tgl.Upload : " . $tglUpload2 . "</small>";
                                                                } else {
                                                                    echo "Belum ada berkas";
                                                                } ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>3)</td>
                                                            <td>SK. Kenaikan Pangkat Terakhir</td>
                                                            <td>
                                                                <?php if ($idberkas3 <> "" and $idberkas3 <> "0" and $idberkas3 <> -1) {
                                                                    echo "$linkBerkasUsulan3";
                                                                    echo "<small class=\"form-text text-muted\">";
                                                                    echo "<br>Tgl.Upload : " . $tglUpload3 . "</small>";
                                                                } else {
                                                                    echo "Belum ada berkas";
                                                                } ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>4)</td>
                                                            <td>Daftar Gaji</td>
                                                            <td>
                                                                <?php if ($idberkas4 <> "" and $idberkas4 <> "0" and $idberkas4 <> -1) {
                                                                    echo "$linkBerkasUsulan4";
                                                                    echo "<small class=\"form-text text-muted\">";
                                                                    echo "<br>Tgl.Upload : " . $tglUpload4 . "</small>";
                                                                } else {
                                                                    echo "Belum ada berkas";
                                                                } ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>5)</td>
                                                            <td>Kartu Keluarga</td>
                                                            <td>
                                                                <?php if ($idberkas5 <> "" and $idberkas5 <> "0" and $idberkas5 <> -1) {
                                                                    echo "$linkBerkasUsulan5";
                                                                    echo "<small class=\"form-text text-muted\">";
                                                                    echo "<br>Tgl.Upload : " . $tglUpload5 . "</small>";
                                                                } else {
                                                                    echo "Belum ada berkas";
                                                                } ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="histProses<?php echo $idptk; ?>">
                                        <br><span style="text-decoration: underline;">Riwayat Status Pengajuan</span>:
                                        <br>
                                        <?php
                                        $sql = "select nama, DATE_FORMAT(tgl_approve_hist,  '%d/%m/%Y %H:%i:%s') AS tgl_approve_hist , approved_note_hist,status_ptk
                                            from ptk_historis_approve inner join pegawai on ptk_historis_approve.approved_by_hist=pegawai.id_pegawai
                                            inner join ref_status_ptk on ref_status_ptk.id_status_ptk = ptk_historis_approve.id_status_ptk
                                            where id_ptk=$idptk";
                                        $query6 = $mysqli->query($sql);
                                        if (isset($query6)) {
                                            if ($query6->num_rows > 0) {
                                                echo("<ul style='font-size: 10pt; margin-top: 0px;'>");
                                                while ($oto6 = $query6->fetch_array(MYSQLI_NUM)) {
                                                    echo("<li>Status : $oto6[3] Diproses oleh $oto6[0] tanggal $oto6[1] catatan: $oto6[2] </li>");
                                                }
                                                echo("</ul>");
                                            } else {
                                                echo "<i>Tidak ada data</i>";
                                            }
                                        }
                                        ?>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="histEksekusi<?php echo $idptk; ?>">
                                        <br>
                                    <span
                                        style="text-decoration: underline;">Riwayat Draft Pengubahan Tunjangan Jiwa ke SIMGAJI via SIMPEG</span>:
                                        <br>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <script>
            var img = document.getElementById("imgLoadingPtk");
            img.style.visibility = 'hidden';

            $(function () {
                $("#frmReqPTKAjukanBPKAD").bootstrapValidator({
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
                    var $button = $form.data('bootstrapValidator').getSubmitButton();
                    var checkboxes = $("#divChkStorePtk input:checkbox");
                    var jmlCheck = 0;
                    var strPTKStore = "";
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].checked == true) {
                            strPTKStore += checkboxes[i].value + "@";
                            jmlCheck++;
                        }
                    }
                    var statusEdit = '';
                    var idpApprover = '<?php echo $_SESSION['id_pegawai'] ?>';
                    if (jmlCheck <= 0) {
                        alert('Belum ada data yang dipilih');
                    } else {
                        strPTKStore = strPTKStore.substring(0, ((strPTKStore.length) - 1));
                        var dataPtkBpkad = new FormData();
                        var txtCatatanBpkad = $("#txtCatatanBpkad").val();
                        dataPtkBpkad.append('strPTKStore', strPTKStore);
                        dataPtkBpkad.append('data_change', 'ubahStatusPtkBpkad');
                        dataPtkBpkad.append('txtCatatanBpkad', txtCatatanBpkad);
                        switch ($button.attr('id')) {
                            case 'btnProsesBpkad':
                                statusEdit = 'proses';
                                break;
                            case 'btnDitolakBpkad':
                                statusEdit = 'tolak';
                                break;
                            case 'btnGajiTerupdate':
                                statusEdit = 'gajiupdate';
                                break;
                            default:
                                break;
                        }
                        dataPtkBpkad.append('statusEdit', statusEdit);
                        dataPtkBpkad.append('idpApprover', idpApprover);
                        var progress = $(".loading-progress").progressTimer({
                            timeLimit: 10,
                            onFinish: function () {
                                $("#notesPtk").fadeOut();
                            }
                        });
                        $("#notesPtk").fadeIn();
                        img.style.visibility = 'visible';
                        $.ajax({
                            url: "ptk_data_change.php",
                            data: dataPtkBpkad,
                            cache: false,
                            contentType: false,
                            processData: false,
                            method: 'POST',
                        }).done(function (data) {
                            progress.progressTimer('complete');
                            if (data == 1) {
                                alert('Data sukses tersimpan semua');
                            } else {
                                alert('Proses update dibatalkan. Data tidak sukses tersimpan semua');
                            }
                            img.style.visibility = 'hidden';
                            pagingViewListLoad(<?php echo $curpage;?>, <?php echo $ipp;?>);
                        });
                    }
                    $form.bootstrapValidator('disableSubmitButtons', false);
                });

                $("#frmEntryDraftPtk").bootstrapValidator({
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
                    var blnGaji = $("#ddBlnGajiAddPtk").val();
                    var thnGaji = $('#ddThnGajiAddPtk').val();
                    var checkboxes = $("#divChkStorePtk input:checkbox");
                    var jmlCheck = 0;
                    var strPTKStore = "";
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].checked == true) {
                            strPTKStore += checkboxes[i].value + "@";
                            jmlCheck++;
                        }
                    }
                    if (jmlCheck <= 0) {
                        alert('Belum ada data yang dipilih');
                    } else {
                        strPTKStore = strPTKStore.substring(0, ((strPTKStore.length) - 1));
                        var dataPtkBpkad = new FormData();
                        dataPtkBpkad.append('blnGaji', blnGaji);
                        dataPtkBpkad.append('thnGaji', thnGaji);
                        dataPtkBpkad.append('strPTKStore', strPTKStore);
                        dataPtkBpkad.append('data_change', 'addDraftPenyesuaianTunjanganJiwa');
                        var progress = $(".loading-progress").progressTimer({
                            timeLimit: 10,
                            onFinish: function () {
                                $("#notesPtk").fadeOut();
                            }
                        });
                        $("#notesPtk").fadeIn();
                        img.style.visibility = 'visible';
                        $.ajax({
                            url: "ptk_data_change.php",
                            data: dataPtkBpkad,
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
                            pagingViewListLoad(<?php echo $curpage;?>, <?php echo $ipp;?>);
                        });
                    }
                    $form.bootstrapValidator('disableSubmitButtons', false);
                });

            });
            $("#chkAllPtk").change(function () {
                $("#divChkStorePtk input:checkbox").prop('checked', $(this).prop("checked"));
            });
        </script>
        <?php
        if ($numpage > 0) {
            echo "Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage";
            if ($chkViewSyaratProsesHist == 'false') {
                echo " | " . $rowperpage . "<br>";
            } else {
                echo "<br>";
            }
            echo $pgDisplay;
        }
    } else {
        echo '<div style="padding: 10px;">Tidak ada data</div>';
    }
    ?>
</div>

<div class="modal fade" id="modalInfoKeuangan" role="dialog">
    <div class="modal-dialog modal-lg" style="max-height: 420px;">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 2px solid darkolivegreen;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="jdlTabel" class="modal-title" style="border: 0px;">Informasi Keuangan Pegawai</h4>
            </div>
            <div class="modal-body" style="height: 420px; width: 100%;">
                <div id="winInfoKeuangan" style="margin-top: -10px;"></div>
            </div>
            <div class="modal-footer">
                <button id="btnClose" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalInfoKeluarga" role="dialog">
    <div class="modal-dialog modal-lg" style="max-height: 550px;">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 2px solid darkolivegreen;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="jdlTabel" class="modal-title" style="border: 0px;">Informasi Keluarga Pegawai</h4>
            </div>
            <div class="modal-body" style="height: 550px; width: 100%;">
                <div id="winInfoKeluarga" style="margin-top: -10px;"></div>
            </div>
            <!--<div class="modal-footer">
                <button id="btnClose" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
        </div>
    </div>
</div>

<div class="modal fade" id="modalInfoLanjut" role="dialog">
    <div class="modal-dialog modal-lg" style="max-height: 450px;">
        <div class="modal-content">
            <div class="modal-header" style="border-bottom: 2px solid darkolivegreen;">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 id="jdlTabel" class="modal-title" style="border: 0px;">Detail Informasi Pegawai</h4>
            </div>
            <div class="modal-body" style="height: 450px; width: 100%;">
                <div id="winInfoLanjut" style="margin-top: -10px;"></div>
            </div>
            <div class="modal-footer">
                <button id="btnClose" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    function lihatDaftarGaji(nip) {
        $("#winInfoKeuangan").html("Loading...");
        var request = $.get("ptk_info_keuangan.php?nip=" + nip);
        request.pipe(
            function (response) {
                if (response.success) {
                    return ( response );
                } else {
                    return (
                        $.Deferred().reject(response)
                    );
                }
            },
            function (response) {
                return ({
                    success: false,
                    data: null,
                    errors: ["Unexpected error: " + response.status + " " + response.statusText]
                });
            }
        );
        request.then(
            function (response) {
                $("#winInfoKeuangan").html(response);
            }
        );
        $("#modalInfoKeuangan").modal('show');
    }

    function lihatKeluargaSimpegGaji(idpegawai, nip) {
        $("#winInfoKeluarga").html("Loading...");
        var request = $.get("ptk_info_keluarga.php?idpegawai=" + idpegawai + "&nip=" + nip);

        request.pipe(
            function (response) {
                if (response.success) {
                    return ( response );
                } else {
                    return (
                        $.Deferred().reject(response)
                    );
                }
            },
            function (response) {
                return ({
                    success: false,
                    data: null,
                    errors: ["Unexpected error: " + response.status + " " + response.statusText]
                });
            }
        );
        request.then(
            function (response) {
                $("#winInfoKeluarga").html(response);
            }
        );
        $("#modalInfoKeluarga").modal('show');
    }

    function cekLebihLanjutSimGaji(nip, nama, idp) {
        $("#winInfoLanjut").html("Loading...");
        var request = $.get("ptk_info_detail_pegawai.php?idpegawai=" + idp + "&nip=" + nip + "&nama_gaji=" + nama);

        request.pipe(
            function( response ){
                if (response.success){
                    return( response );
                }else{
                    return(
                        $.Deferred().reject( response )
                    );
                }
            },
            function( response ){
                return({
                    success: false,
                    data: null,
                    errors: [ "Unexpected error: " + response.status + " " + response.statusText ]
                });
            }
        );
        request.then(
            function( response ){
                $("#winInfoLanjut").html(response);
            }
        );
        $("#modalInfoLanjut").modal('show');
    }


</script>