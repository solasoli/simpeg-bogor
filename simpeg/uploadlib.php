<?php
extract($_GET);
extract($_POST);

include("konek.php");
$sql = "SELECT ib.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol, p.jenjab,
        CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN 'Fungsional Umum' ELSE j.jabatan END END AS jabatan,
        ib.institusi_lanjutan, kp.nama_pendidikan, ib.jurusan, ib.akreditasi, DATE_FORMAT(ib.tgl_pengajuan,  '%d/%m/%Y') AS tgl_pengajuan,
        sib.status_ib, CASE WHEN ib.tgl_approve IS NULL THEN '-' ELSE ib.tgl_approve END AS tgl_approve,
        CASE WHEN ib.approved_by IS NULL THEN '-' ELSE ib.approved_by END AS approved_by,
        ib.spuk, ib.spal, ib.skt, ib.dp3, ib.ijazah, ib.kmpt, ib.jk, ib.jm, ib.kkg, kp2.nama_pendidikan AS pendidikan_terakhir,
        pend.jurusan_pendidikan, pend.lembaga_pendidikan, pend.tahun_lulus, pend.level_p, ib.id AS idib
        FROM ijin_belajar ib, kategori_pendidikan kp, ref_status_ijin_belajar sib, pegawai p
        LEFT JOIN jabatan j ON p.id_j = j.id_j, pendidikan pend, kategori_pendidikan kp2
        WHERE ib.id_pegawai = $idp AND ib.tingkat_pendidikan = kp.level_p AND ib.approve = sib.idstatus_ib
        AND ib.id_pegawai = p.id_pegawai AND pend.id_pegawai = p.id_pegawai AND pend.level_p = (
        SELECT MIN(pn.level_p) FROM pendidikan pn WHERE pn.id_pegawai = p.id_pegawai) AND pend.level_p = kp2.level_p;";
$query = mysqli_query($mysqli,$sql);
$data = mysqli_fetch_array($query);

if($issubmit==1){
    if(!isset($jm)){
        $jm = 0;;
    }
    if(!isset($kkg)){
        $kkg = 0;;
    }
    $sqlUpdateIb = "UPDATE ijin_belajar
    SET approve = 6, spuk = $spuk, spal = $spal, skt = $skt, dp3 = $dp3, ijazah = $ijazah,
    kmpt = $kmpt, jk = $jk, jm = $jm, kkg = $kkg, tgl_approve = DATE_FORMAT(NOW(),  '%Y-%m-%d'), approved_by = '".$data[2]."' ".
    "WHERE id = ".$data[28];
    mysqli_query($mysqli,$sqlUpdateIb);
    echo("<script type=\"text/javascript\">location.href='/simpeg/index3.php?x=uploadlib.php&idp=$idp';</script>");
}
?>
<div style='padding: 10px; text-align: center; font-size: large;'>
    <strong>FORM PENGAJUAN BERKAS PERSYARATAN SURAT IZIN BELAJAR</strong></div>
<form action="index3.php?x=uploadlib.php&idp=<?php echo $idp; ?>" method="post" enctype="multipart/form-data" name="form1" id="frmIjinBelajar">
<table width="95%" border="0" align="center" style="border-radius:5px;"
       class="table table-bordered table-hover table-striped">
<tr>
    <td style="width: 5%;">a.</td>
    <td style="width: 20%;">NIP <input type="hidden" id="issubmit" name="issubmit" value="1" /></td>
    <td style="width: 75%;"><?php echo $data[1] ?></td>
</tr>
<tr>
    <td>b.</td>
    <td>Nama</td>
    <td><?php echo $data[2] ?></td>
</tr>
<tr>
    <td>c.</td>
    <td>Golongan</td>
    <td><?php echo $data[3] ?></td>
</tr>
<tr>
    <td>d.</td>
    <td>Jenis Jabatan</td>
    <td><?php echo $data[4] ?></td>
</tr>
<tr>
    <td>e.</td>
    <td>Jabatan</td>
    <td><?php echo $data[5] ?></td>
</tr>
<tr>
    <td>f.</td>
    <td>Pendidikan Terakhir</td>
    <td><?php echo $data[23].' '.$data[24].' ('.$data[25].') Thn. Lulus '.$data[26] ?></td>
</tr>
<tr>
    <td>g.</td>
    <td>Pendidikan Lanjutan</td>
    <td><?php echo $data[7].' '.$data[8].' ('.$data[6].')' ?></td>
</tr>
<tr>
    <td>h.</td>
    <td>Tanggal Pengajuan</td>
    <td><?php echo $data[10] ?></td>
</tr>
<tr>
    <td>i.</td>
    <td>Status Pengajuan</td>
    <td><?php echo $data[11] ?></td>
</tr>
<tr>
    <td>j.</td>
    <td>Tanggal Proses</td>
    <td><?php echo $data[12] ?></td>
</tr>
<tr>
    <td>k.</td>
    <td>Diproses Oleh</td>
    <td><?php echo $data[13] ?></td>
</tr>
<tr>
<td></td>
<td colspan="2">
<strong>Kelengkapan Syarat Administrasi Usulan Ijin Belajar (Format PDF): </strong>
<?php
if($data[5] == 'Guru'){
    mysqli_query($mysqli,"SET @inisial_berkas := 'spuk,spal,skt,dp3,ijazah,kmpt,jk,jm,kkg';");
}else{
    mysqli_query($mysqli,"SET @inisial_berkas := 'spuk,spal,skt,dp3,ijazah,kmpt,jk';");
}
$sqlIdentifiedBerkas = "SELECT * FROM
                            (SELECT 'Surat Pengantar dari Unit Kerja' AS nama_syarat, a.*, ib.file_name FROM
                            (SELECT 21 AS id_kat_berkas, 'spuk' AS inisial_berkas, COUNT(*) AS jumlah, CASE WHEN id_berkas IS NULL THEN 0 ELSE MAX(id_berkas) END as id_berkas
                            FROM berkas WHERE id_pegawai=$idp AND id_kat=21 AND ket_berkas LIKE '%$data[7]%' ORDER BY id_berkas DESC LIMIT 0,1) as a
                            LEFT JOIN isi_berkas ib ON ib.id_berkas = a.id_berkas AND ib.id_berkas > 0
                              UNION
                            SELECT 'Surat Pernyataan yang Ditandatangani oleh Atasan Langsung', b.*, ib.file_name FROM
                            (SELECT 22, 'spal', COUNT(*) AS jumlah, CASE WHEN id_berkas IS NULL THEN 0 ELSE MAX(id_berkas) END as id_berkas
                            FROM berkas WHERE id_pegawai=$idp AND id_kat=22 AND ket_berkas LIKE '%$data[7]%' ORDER BY id_berkas DESC LIMIT 0,1) as b
                            LEFT JOIN isi_berkas ib ON ib.id_berkas = b.id_berkas AND ib.id_berkas > 0
                              UNION
                            SELECT 'SK Pangkat Terakhir', c.*, ib.file_name FROM
                            (SELECT 2, 'skt', COUNT(*) AS jumlah, CASE WHEN id_berkas IS NULL THEN 0 ELSE MAX(id_berkas) END as id_berkas
                            FROM sk WHERE id_pegawai=$idp AND id_kategori_sk=5 AND keterangan LIKE '$data[3]%' ORDER BY id_berkas DESC LIMIT 0,1) as c
                            LEFT JOIN isi_berkas ib ON ib.id_berkas = c.id_berkas AND ib.id_berkas > 0
                              UNION
                            SELECT 'Penilaian Prestasi Kerja Tahun Terakhir', d.*, ib.file_name FROM
                            (SELECT 20, 'dp3', COUNT(*) AS jumlah, CASE WHEN berkas.id_berkas IS NULL THEN 0 ELSE MAX(berkas.id_berkas) END as id_berkas
                            FROM berkas inner join isi_berkas on isi_berkas.id_berkas=berkas.id_berkas
                            WHERE id_pegawai=$idp AND id_kat=20 AND ket_berkas
                            LIKE '%$data[7]%' AND file_name LIKE '%.pdf' ORDER BY id_berkas DESC LIMIT 0,1) as d
                            LEFT JOIN isi_berkas ib ON ib.id_berkas = d.id_berkas AND ib.id_berkas > 0

                              UNION
                            SELECT 'Ijazah Pendidikan Terakhir', e.*, ib.file_name FROM
                            (SELECT 3, 'ijazah', COUNT(*) AS jumlah, CASE WHEN id_berkas IS NULL THEN 0 ELSE MAX(id_berkas) END as id_berkas
                            FROM pendidikan WHERE id_pegawai=$idp AND level_p=$data[27] ORDER BY level_p LIMIT 0,1) as e
                            LEFT JOIN isi_berkas ib ON ib.id_berkas = e.id_berkas AND ib.id_berkas > 0
                              UNION
                            SELECT 'Surat Keterangan Diterima / Masih Kuliah dari Perguruan Tinggi', f.*, ib.file_name FROM
                            (SELECT 23, 'kmpt', COUNT(*) AS jumlah, CASE WHEN id_berkas IS NULL THEN 0 ELSE id_berkas END as id_berkas
                            FROM berkas WHERE id_pegawai=$idp AND id_kat=23 AND ket_berkas LIKE '%$data[7]%' ORDER BY id_berkas DESC LIMIT 0,1) as f
                            LEFT JOIN isi_berkas ib ON ib.id_berkas = f.id_berkas AND ib.id_berkas > 0
                              UNION
                            SELECT 'Jadwal Perkuliahan Yang Masih Berlaku', g.*, ib.file_name FROM
                            (SELECT 24, 'jk', COUNT(*) AS jumlah, CASE WHEN id_berkas IS NULL THEN 0 ELSE MAX(id_berkas) END as id_berkas
                            FROM berkas WHERE id_pegawai=$idp AND id_kat=24 AND ket_berkas LIKE '%$data[7]%' ORDER BY id_berkas DESC LIMIT 0,1) as g
                            LEFT JOIN isi_berkas ib ON ib.id_berkas = g.id_berkas AND ib.id_berkas > 0
                              UNION
                            SELECT 'Jadwal Mengajar di Sekolah yang Bersangkutan (Khusus Guru)', h.*, ib.file_name FROM
                            (SELECT 25, 'jm', COUNT(*) AS jumlah, CASE WHEN id_berkas IS NULL THEN 0 ELSE MAX(id_berkas) END as id_berkas
                            FROM berkas WHERE id_pegawai=$idp AND id_kat=25 AND ket_berkas LIKE '%$data[7]%' ORDER BY id_berkas DESC LIMIT 0,1) as h
                            LEFT JOIN isi_berkas ib ON ib.id_berkas = h.id_berkas AND ib.id_berkas > 0
                              UNION
                            SELECT 'Kajian Kebutuhan Guru (untuk Guru S1 atau S2)', i.*, ib.file_name FROM
                            (SELECT 26, 'kkg', COUNT(*) AS jumlah, CASE WHEN id_berkas IS NULL THEN 0 ELSE MAX(id_berkas) END as id_berkas
                            FROM berkas WHERE id_pegawai=$idp AND id_kat=26 AND ket_berkas LIKE '%$data[7]%' ORDER BY id_berkas DESC LIMIT 0,1) as i
                            LEFT JOIN isi_berkas ib ON ib.id_berkas = i.id_berkas AND ib.id_berkas > 0) AS list_syarat_ib
                            WHERE FIND_IN_SET(list_syarat_ib.inisial_berkas, @inisial_berkas);";
//echo $sqlIdentifiedBerkas;
$queryIdentifiedBerkas = mysqli_query($mysqli,$sqlIdentifiedBerkas);
$i = 1;
$jml_noberkas = 0;
?>
<table width="95%" border="0" align="center" style="border-radius:5px;"
       class="table table-bordered table-hover table-striped">
    <tr>
        <td align="center" style="width: 5%;">No.</td>
        <td align="left"style="width: 45%;">Uraian</td>
        <td align="left"style="width: 50%;">Berkas</td>
    </tr>
    <?php while($rowIdenBerkas = mysqli_fetch_array($queryIdentifiedBerkas)){ ?>
        <tr>
            <td><?php echo $i.'.'; ?></td>
            <td><?php echo $rowIdenBerkas['nama_syarat'] ?>
                <input type="hidden" id="<?php echo $rowIdenBerkas['inisial_berkas']; ?>"
                       name="<?php echo $rowIdenBerkas['inisial_berkas']; ?>"
                       value="<?php echo $rowIdenBerkas['id_berkas']; ?>" />
            </td>
            <td>
                <?php
                if ($rowIdenBerkas['id_berkas'] == 0){
                $jml_noberkas = $jml_noberkas + 1;
                if($rowIdenBerkas['id_kat_berkas']==2 || $rowIdenBerkas['id_kat_berkas']==3){
                    echo ("Syarat belum tersedia<br>Silahkan hubungi pengelola SIMPEG atau Akses Menu Edit Data");
                }else{
                ?>
                <span class="btn btn-primary btn-sm fileinput-button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>Upload Baru</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input id="<?php echo 'file_ib_' . $rowIdenBerkas['inisial_berkas'] ?>"
                                                       type="file" name="files[]" multiple/>
                                                <input type="hidden"
                                                       name="<?php echo 'syarat_' . $rowIdenBerkas['inisial_berkas'] ?>"
                                                       id="<?php echo 'syarat_' . $rowIdenBerkas['inisial_berkas'] ?>"/>  </span>

                <div id="<?php echo 'progress_' . $rowIdenBerkas['inisial_berkas'] ?>"
                     class="progress primary">
                    <div class="progress-bar progress-bar-primary">
                        <script type="text/javascript">
                            $(function () {
                                var <?php echo 'url_'.$rowIdenBerkas['inisial_berkas'] ?> =
                                window.location.hostname === 'blueimp.github.io' ?
                                    '//jquery-file-upload.appspot.com/' : 'uploaderib.php?idkat=<?php echo $rowIdenBerkas['id_kat_berkas']; ?>&nm_berkas=<?php echo $data[7]; ?>&idp=<?php echo($idp); ?>&inisial_berkas=<?php echo($rowIdenBerkas['inisial_berkas']); ?>&idib=<?php echo($data[28]); ?>';
                                $('#<?php echo 'file_ib_'.$rowIdenBerkas['inisial_berkas'] ?>').fileupload({
                                    url: <?php echo 'url_'.$rowIdenBerkas['inisial_berkas'] ?>,
                                    dataType: 'json',
                                    paramName: 'files[]',
                                    done: function (e, data) {
                                        $.each(data.result.files, function (index, file) {
                                            $('<p/>').text(file.name).appendTo('#files');
                                            jml_noberkas = jml_noberkas - 1;
                                            if (jml_noberkas == 0) {
                                                $("#btnSimpanIB").attr("disabled", false);
                                                $("#spnInfo").html('Anda sudah dapat mengusulkan permohonan ijin belajar');
                                                $("#spnInfo").css('color', '#008000');
                                            }
                                        });
                                    },
                                    progressall: function (e, data) {
                                        var progress = parseInt(data.loaded / data.total * 100, 10);
                                        $('#<?php echo 'progress_'.$rowIdenBerkas['inisial_berkas'] ?> .progress-bar').css(
                                            'width',
                                            progress + '%'
                                        );
                                    }
                                })
                                    .prop('disabled', !$.support.fileInput)
                                    .parent().addClass($.support.fileInput ? undefined : 'disabled');
                            });
                        </script>
                        <?php
                        }} else {
                        $fname = pathinfo($rowIdenBerkas['file_name']);
                        //echo $fname['basename'].'-'.$fname['extension'];
                        if($fname['extension'] == 'pdf'){
                            echo("<a href='/Simpeg/berkas/" . $rowIdenBerkas['file_name'] . "' target='_blank' >Sudah tersedia</a>");
                        }else{
                            echo("<a href='/Simpeg/berkas.php?idb=" . $rowIdenBerkas['id_berkas'] . "' target='_blank' >Sudah tersedia</a>");
                        }
                        /*if($rowIdenBerkas['id_kat_berkas']==2 || $rowIdenBerkas['id_kat_berkas']==3){

                        }else{*/
                        ?>
                        <?php if ($data[11] == 'Disetujui' or $data[11] == 'Perbaiki') { ?>
                        <br>
                                 <span class="btn btn-primary btn-sm fileinput-button">
                                 <i class="glyphicon glyphicon-plus"></i>
                                 <span>Upload Ulang</span>
                                 <!-- The file input field used as target for the file upload widget -->
                                 <input id="<?php echo 'file_ib_' . $rowIdenBerkas['inisial_berkas'] ?>" type="file" name="files[]" multiple/>
                                 <input type="hidden" name="<?php echo 'syarat_' . $rowIdenBerkas['inisial_berkas'] ?>"
                                        id="<?php echo 'syarat_' . $rowIdenBerkas['inisial_berkas'] ?>"/>  </span>
                        <div id="<?php echo 'progress_' . $rowIdenBerkas['inisial_berkas'] ?>" class="progress primary">
                            <div class="progress-bar progress-bar-primary">
                                <script type="text/javascript">
                                    $(function () {
                                        var <?php echo 'url_'.$rowIdenBerkas['inisial_berkas'] ?> =
                                        window.location.hostname === 'blueimp.github.io' ?
                                            '//jquery-file-upload.appspot.com/' : 'uploaderib.php?idkat=<?php echo $rowIdenBerkas['id_kat_berkas']; ?>&nm_berkas=<?php echo $data[7]; ?>&idp=<?php echo($idp); ?>&upload_ulang=1&id_berkas=<?php echo $rowIdenBerkas['id_berkas']; ?>&inisial_berkas=<?php echo($rowIdenBerkas['inisial_berkas']); ?>&idib=<?php echo($data[28]); ?>';
                                        $('#<?php echo 'file_ib_'.$rowIdenBerkas['inisial_berkas'] ?>').fileupload({
                                            url: <?php echo 'url_'.$rowIdenBerkas['inisial_berkas'] ?>,
                                            dataType: 'json',
                                            paramName: 'files[]',
                                            done: function (e, data) {
                                                $.each(data.result.files, function (index, file) {
                                                    $('<p/>').text(file.name).appendTo('#files');
                                                    if (jml_noberkas == 0) {
                                                        $("#btnSimpanIB").attr("disabled", false);
                                                        $("#spnInfo").html('Anda sudah dapat mengusulkan permohonan ijin belajar');
                                                        $("#spnInfo").css('color', '#008000');
                                                    }
                                                });
                                            },
                                            progressall: function (e, data) {
                                                var progress = parseInt(data.loaded / data.total * 100, 10);
                                                $('#<?php echo 'progress_'.$rowIdenBerkas['inisial_berkas'] ?> .progress-bar').css(
                                                    'width',
                                                    progress + '%'
                                                );
                                            }
                                        })
                                            .prop('disabled', !$.support.fileInput)
                                            .parent().addClass($.support.fileInput ? undefined : 'disabled');
                                    });
                                </script>
                                <?php } ?>
                                <?php /*}*/} ?>
            </td>
        </tr>
        <?php $i++; } ?>
    <script type="text/javascript">
        var jml_noberkas = <?php echo $jml_noberkas ?>;
    </script>
    <tr>
        <td></td>
        <td colspan="2">
            <?php if ($data[11] == 'Disetujui' or $data[11] == 'Perbaiki') { ?>
            <input type="submit" name="btnSimpanIB" id="btnSimpanIB" class="btn btn-primary" value="Ajukan"  <?php if($jml_noberkas > 0) echo 'disabled' ?> />
            <?php if($jml_noberkas > 0) echo "<span id='spnInfo' style='color: red'>Anda belum dapat mengusulkan, lengkapi dahulu syarat </span>"; ?>
            <?php if($jml_noberkas == 0) echo "<span id='spnInfo' style='color: #008000'>Anda sudah dapat mengusulkan permohonan ijin belajar </span>"; ?>
            <?php } ?>
        </td>
    </tr>
</table>
</td>
</tr>
</table>
</form>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="assets/js/vendor/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="assets/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="assets/js/jquery.fileupload.js"></script>