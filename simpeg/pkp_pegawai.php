<?php
extract($_GET);
include("konek.php");
$sql = "SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
        FCN_PARSE_KETERANGAN_SK(s.keterangan,1) AS pangkat_gol, s.tmt, p.jenjab,
        CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN 'Fungsional Umum' ELSE j.jabatan END END AS jabatan,
        p.id_j, NOW() AS wkt_skrg,
        IF(DATE_FORMAT(NOW(),  '%Y-%m-%d') < CONCAT(YEAR(NOW()),'-04-01'), 4, IF(DATE_FORMAT(NOW(),  '%Y-%m-%d') BETWEEN CONCAT(YEAR(NOW()),'-04-01') AND CONCAT(YEAR(NOW()),'-08-01'),8, 4)) AS periode_bln,
        IF(DATE_FORMAT(NOW(),  '%Y-%m-%d') < CONCAT(YEAR(NOW()),'-04-01'), YEAR(NOW()), IF(DATE_FORMAT(NOW(),  '%Y-%m-%d') BETWEEN CONCAT(YEAR(NOW()),'-04-01') AND CONCAT(YEAR(NOW()),'-08-01'),YEAR(NOW()), YEAR(NOW())+1)) AS periode_thn,
        kp.id_kp, kp.last_id_kp_usulan, kpu.idstatus_kp_usulan, kps.status_kp, kp.idberkas_sk_kp
        FROM pegawai p
        LEFT JOIN jabatan j ON p.id_j = j.id_j
        LEFT JOIN kenaikan_pangkat kp ON p.id_pegawai = kp.id_pegawai AND kp.periode_bln = IF(DATE_FORMAT(NOW(),  '%Y-%m-%d') < CONCAT(YEAR(NOW()),'-04-01'), 4, IF(DATE_FORMAT(NOW(),  '%Y-%m-%d') BETWEEN CONCAT(YEAR(NOW()),'-04-01') AND CONCAT(YEAR(NOW()),'-08-01'),8, 4))
        AND kp.periode_thn = IF(DATE_FORMAT(NOW(),  '%Y-%m-%d') < CONCAT(YEAR(NOW()),'-04-01'), YEAR(NOW()), IF(DATE_FORMAT(NOW(),  '%Y-%m-%d') BETWEEN CONCAT(YEAR(NOW()),'-04-01') AND CONCAT(YEAR(NOW()),'-08-01'),YEAR(NOW()), YEAR(NOW())+1))
        LEFT JOIN kenaikan_pangkat_usulan kpu ON kp.last_id_kp_usulan = kpu.id_kp_usulan
        LEFT JOIN kenaikan_pangkat_status kps ON kpu.idstatus_kp_usulan = kps.idstatus_kp_usulan, sk s
        WHERE p.id_pegawai = s.id_pegawai AND p.id_pegawai = $idp
        AND (s.id_kategori_sk = 5 OR s.id_kategori_sk = 6 OR s.id_kategori_sk = 7) AND s.tmt = (
        SELECT MAX(tmt) FROM sk WHERE sk.id_pegawai = $idp AND (sk.id_kategori_sk = 5 OR
        s.id_kategori_sk = 6 OR s.id_kategori_sk = 7))
        ORDER BY kp.id_kp DESC
        LIMIT 0,1;";

$query = mysqli_query($mysqli,$sql);
$data = mysqli_fetch_array($query);

$d1=date("Y-m-d");
$d2=$data[4];
$date_diff=strtotime($d1)-strtotime($d2);
$selisih=($date_diff)/(60*60*24*365);

switch($data[5]){
    case 'Struktural':
        if($data[6]=='Fungsional Umum'){
            $whereKlause = 'is_fungsional_umum = 1';
        }else{
            $whereKlause = 'is_struktural = 1';
        }
        if($selisih > 4){
            echo("<div align='center' class='alert alert-danger'>Anda belum waktunya mengusulkan kenaikan pangkat</div> ");
        }
        break;
    case 'Fungsional':
        $whereKlause = 'is_fungsional_tertentu = 1';
        if($selisih > 2){
            echo("<div align='center' class='alert alert-danger'>Anda belum waktunya mengusulkan kenaikan pangkat</div> ");
        }
        break;
}

if(($data[5]=="Struktural" and $selisih < 4) or ($data[5]=="Fungsional" and $selisih < 2)) {
    $sqlJenisKP = "SELECT kpj.* FROM kenaikan_pangkat_jenis kpj WHERE $whereKlause and is_show = 1";
    $queryJnsKP = mysqli_query($mysqli,$sqlJenisKP);
    $array_jns_kp = array();
    while ($row = mysqli_fetch_array($queryJnsKP)) {
        $array_jns_kp[] = $row;
    }
    $arrJnsKP_length = count($array_jns_kp);
    $idjenis_kp = $array_jns_kp[0]['idjenis_kp'];
    $jenis_kp = $array_jns_kp[0]['jenis_kp' ];
    if($data[9]==4){
        $bln_penutupan = $array_jns_kp[0]['bln_penutupan_periode_apr'];
    }else{
        $bln_penutupan = $array_jns_kp[0]['bln_penutupan_periode_okt'];
    }

    $dateString = $data[10].'-'.$data[9].'-'.'1';
    $dt = date_create($dateString);
    $date_close = date("d-m-Y", strtotime( date( "Y-m-d", strtotime( $dt->format('Y-m-d')))."-$bln_penutupan month"));
    if(date("Y-m-d") < $date_close){
        echo("<div align='center' class='alert alert-danger'>Anda tidak bisa mengajukan usulan kenaikan pangkat karena sudah ditutup</div> ");
    }else {
        mysqli_query($mysqli,"SET @row_number := 0");
        $sqlIdentifiedBerkas = "SELECT
                        FCN_ROW_NUMBER() as no_urut,
                        kepang_js.idjenis_kp_syarat,
                        kepang_js.nama_syarat, kepang_js.id_kat_berkas, kepang_js.nama_berkas,
                        berkas_kp.id_berkas, berkas_kp.file_name, kepang_js.is_can_reupload, kepang_js.is_show
                        FROM
                        kenaikan_pangkat_jenis_syarat kepang_js LEFT JOIN
                        (SELECT
                        berkas_kp_cur.*, ib.file_name
                        FROM
                        (SELECT
                          kpjs.idjenis_kp_syarat,
                          IFNULL(
                          CASE WHEN kpjs.idjenis_kp_syarat = 2 /* SK Jabatan lama (Eselon sebelumnya) */
                          THEN
                            (SELECT sk.id_berkas FROM sk, pegawai p
                            WHERE p.id_pegawai = sk.id_pegawai AND sk.id_pegawai = $idp AND sk.id_kategori_sk = 10
                            ORDER BY sk.tmt DESC LIMIT 1,1)
                          ELSE
                            CASE WHEN kpjs.idjenis_kp_syarat = 3 /* SK Jabatan baru (Eselonnya Naik/Promosi) */
                            THEN
                              (SELECT sk.id_berkas FROM sk, pegawai p
                              WHERE p.id_pegawai = sk.id_pegawai AND sk.id_pegawai = $idp AND sk.id_kategori_sk = 10
                              ORDER BY sk.tmt DESC LIMIT 0,1)
                            ELSE
                              CASE WHEN kpjs.id_kat_berkas = 2 /* SELAIN syarat 2 dan 3 CEK kategori berkas 2 (SK)*/
                              THEN
                                (SELECT sk.id_berkas
                                FROM sk, kategori_sk ks WHERE sk.id_kategori_sk = ks.id_kategori_sk AND ks.nama_sk LIKE CONCAT('%',kpjs.nama_berkas,'%')
                                AND sk.id_pegawai = $idp AND sk.tmt = (
                                SELECT MAX(tmt) FROM sk s, kategori_sk ksk WHERE s.id_pegawai = $idp AND
                                s.id_kategori_sk = ksk.id_kategori_sk AND ksk.nama_sk LIKE CONCAT('%',kpjs.nama_berkas,'%')))
                              ELSE
                                CASE WHEN kpjs.id_kat_berkas = 3 /* CEK kategori berkas 3 */
                                THEN
                                  (SELECT p.id_berkas FROM pendidikan p WHERE p.id_pegawai = $idp ORDER BY p.level_p LIMIT 0,1)
                                ELSE   /* CEK kategori berkas selain 2 dan 3 */
                                  (SELECT b.id_berkas FROM berkas b WHERE b.id_pegawai = $idp AND b.id_kat = kpjs.id_kat_berkas AND b.nm_berkas LIKE CONCAT('%',kpjs.nama_berkas,'%')
                                  ORDER BY b.id_berkas DESC LIMIT 0,1)
                                END
                              END
                            END
                          END,0) AS id_berkas
                        FROM kenaikan_pangkat_jenis_syarat kpjs
                        WHERE kpjs.idjenis_kp = $idjenis_kp and kpjs.is_show = 1
                        ORDER BY kpjs.idjenis_kp_syarat) AS berkas_kp_cur
                        INNER JOIN isi_berkas ib ON berkas_kp_cur.id_berkas = ib.id_berkas
                        GROUP BY berkas_kp_cur.idjenis_kp_syarat, berkas_kp_cur.id_berkas) AS berkas_kp
                        ON kepang_js.idjenis_kp_syarat = berkas_kp.idjenis_kp_syarat
                        WHERE kepang_js.idjenis_kp = $idjenis_kp and kepang_js.is_show = 1";
        $queryIdentifiedBerkas = mysqli_query($mysqli,$sqlIdentifiedBerkas);
        $jml_noberkas = 0;
    }
    echo "<div style='padding: 10px; text-align: center; font-size: large;'>
        <strong>PENGAJUAN USULAN KENAIKAN PANGKAT PEGAWAI</strong></div>";
    echo "<div style='border: lightgrey 1px solid; padding: 5px; background-color: #eaeaea; color: saddlebrown; font-weight: bold;'>
        Tanggal Penutupan : ".$date_close."</div>";
}
?>

<form action="index3.php?x=pkp_pegawai.php&idp=<?php echo $idp; ?>" method="post" enctype="multipart/form-data" name="form1" id="frmKP">
    <table width="95%" border="0" align="center" style="border-radius:5px;"
           class="table table-bordered table-hover table-striped">
        <tr>
            <td style="width: 5%;">a.</td>
            <td style="width: 20%;">NIP</td>
            <td style="width: 75%;"><?php echo $data[1] ?></td>
        </tr>
        <tr>
            <td>b.</td>
            <td>Nama</td>
            <td><?php echo $data[2] ?></td>
        </tr>
        <tr>
            <td>c.</td>
            <td>Golongan Saat Ini</td>
            <td><?php echo $data[3] ?>. TMT: <?php echo $data[4] ?></td>
        </tr>
        <tr>
            <td>d.</td>
            <td>Jenis Jabatan</td>
            <td><?php echo $data[5] ?></td>
        </tr>
        <tr>
            <td>e.</td>
            <td>Jabatan</td>
            <td><?php echo $data[6] ?></td>
        </tr>
        <tr>
            <td>f.</td>
            <td>Periode Kenaikan Pangkat</td>
            <td><?php echo $data[9].' - '.$data[10] ?></td>
        </tr>
        <tr>
            <td>g.</td>
            <td>Pilih Jenis Kenaikan Pangkat</td>
            <td>
                <select id="slctIdJenisKP" name="slctIdJenisKP" size="5" style="width: 50%;">
                    <?php
                    for($x = 0; $x < $arrJnsKP_length; $x++) {
                        echo "<option value='".$array_jns_kp[$x][idjenis_kp]."' ";
                        if($array_jns_kp[$x][idjenis_kp]==$idjenis_kp) echo 'selected';
                        echo ">".$array_jns_kp[$x][jenis_kp]."</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <?php if(($data[5]=="Struktural" and $selisih < 4 and (date("Y-m-d") > $date_close)) or ($data[5]=="Fungsional" and $selisih < 2 and (date("Y-m-d") > $date_close))){ ?>
        <tr>
            <td></td>
            <td colspan="2">
                <!-- <strong>Kelengkapan Syarat Administrasi Kenaikan Pangkat : </strong> -->
                <div id="list_syarat">
                    <table width="95%" border="0" align="center" style="border-radius:5px;"
                           class="table table-bordered table-hover table-striped">
                        <tr>
                            <td align="center" style="width: 5%;">No.</td>
                            <td align="left"style="width: 45%;">Uraian</td>
                            <td align="left"style="width: 50%;">Berkas</td>
                        </tr>
                        <?php while($rowIdenBerkas = mysqli_fetch_array($queryIdentifiedBerkas)){ ?>
                        <tr>
                            <td><?php echo $rowIdenBerkas['no_urut'] ?></td>
                            <td><?php echo $rowIdenBerkas['nama_syarat'] ?> </td>
                            <td>
                                <?php
                                    if($rowIdenBerkas['is_can_reupload'] == 1){
                                        if ($rowIdenBerkas['id_berkas'] == 0){
                                            $jml_noberkas = $jml_noberkas + 1;
                                        ?>
                                        <span class="btn btn-primary btn-sm fileinput-button">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>Upload Baru</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input id="<?php echo 'file_kp_' . $rowIdenBerkas['idjenis_kp_syarat'] ?>"
                                                       type="file" name="files[]" multiple/>
                                                <input type="hidden"
                                                       name="<?php echo 'syarat_' . $rowIdenBerkas['idjenis_kp_syarat'] ?>"
                                                       id="<?php echo 'syarat_' . $rowIdenBerkas['idjenis_kp_syarat'] ?>"/>  </span>

                                        <div id="<?php echo 'progress_' . $rowIdenBerkas['idjenis_kp_syarat'] ?>"
                                             class="progress primary">
                                            <div class="progress-bar progress-bar-primary">
                                                <script type="text/javascript">
                                                    $(function () {
                                                        var <?php echo 'url_'.$rowIdenBerkas[idjenis_kp_syarat] ?> =
                                                        window.location.hostname === 'blueimp.github.io' ?
                                                            '//jquery-file-upload.appspot.com/' : 'uploaderkp.php?idkat=<?php echo $rowIdenBerkas['id_kat_berkas']; ?>&nm_berkas=<?php echo $rowIdenBerkas['nama_berkas']; ?>&idp=<?php echo($idp); ?>';
                                                        $('#<?php echo 'file_kp_'.$rowIdenBerkas['idjenis_kp_syarat'] ?>').fileupload({
                                                            url: <?php echo 'url_'.$rowIdenBerkas['idjenis_kp_syarat'] ?>,
                                                            dataType: 'json',
                                                            paramName: 'files[]',
                                                            done: function (e, data) {
                                                                $.each(data.result.files, function (index, file) {
                                                                    $('<p/>').text(file.name).appendTo('#files');
                                                                    jml_noberkas = jml_noberkas - 1;
                                                                    if (jml_noberkas == 0) {
                                                                        $("#btnSimpanKP").attr("disabled", false);
                                                                        $("#spnInfo").html('Anda sudah dapat mengusulkan kenaikan pangkat');
                                                                        $("#spnInfo").css('color', '#008000');
                                                                    }
                                                                });
                                                            },
                                                            progressall: function (e, data) {
                                                                var progress = parseInt(data.loaded / data.total * 100, 10);
                                                                $('#<?php echo 'progress_'.$rowIdenBerkas['idjenis_kp_syarat'] ?> .progress-bar').css(
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
                                                } else {
                                                    $sqlCekPenggunaanBerkas = "SELECT count(id_kp_usulan) as jml
                                                    FROM kenaikan_pangkat_usulan_detail WHERE id_berkas = $rowIdenBerkas[id_berkas]";
                                                    $queryCek = mysqli_query($mysqli,$sqlCekPenggunaanBerkas);
                                                    $data = mysqli_fetch_array($queryCek);
                                                    if($data[0] > 0){ //Jika ada yg menggunakan ini berkas
                                                        echo "Upload Baru";
                                                    }else{
                                                        $fname = pathinfo($rowIdenBerkas['file_name']);
                                                        //echo $fname['basename'].'-'.$fname['extension'];
                                                        if($fname['extension'] == 'pdf'){
                                                            echo("<a href='/Simpeg/berkas/" . $rowIdenBerkas['file_name'] . "' target='_blank' >Sudah tersedia</a>");
                                                        }else{
                                                            echo("<a href='/Simpeg/berkas.php?idb=" . $rowIdenBerkas['id_berkas'] . "' target='_blank' >Sudah tersedia</a>");
                                                        }
                                                    ?>
                                                        <br>
                                                        <span class="btn btn-primary btn-sm fileinput-button">
                                                        <i class="glyphicon glyphicon-plus"></i>
                                                        <span>Upload Ulang</span>
                                                        <!-- The file input field used as target for the file upload widget -->
                                                        <input id="<?php echo 'file_kp_' . $rowIdenBerkas['idjenis_kp_syarat'] ?>" type="file" name="files[]" multiple/>
                                                        <input type="hidden" name="<?php echo 'syarat_' . $rowIdenBerkas['idjenis_kp_syarat'] ?>"
                                                        id="<?php echo 'syarat_' . $rowIdenBerkas['idjenis_kp_syarat'] ?>"/>  </span>
                                                        <div id="<?php echo 'progress_' . $rowIdenBerkas['idjenis_kp_syarat'] ?>" class="progress primary">
                                                        <div class="progress-bar progress-bar-primary">

                                                            <script type="text/javascript">
                                                                $(function () {
                                                                    var <?php echo 'url_'.$rowIdenBerkas[idjenis_kp_syarat] ?> =
                                                                    window.location.hostname === 'blueimp.github.io' ?
                                                                        '//jquery-file-upload.appspot.com/' : 'uploaderkp.php?idkat=<?php echo $rowIdenBerkas['id_kat_berkas']; ?>&nm_berkas=<?php echo $rowIdenBerkas['nama_berkas']; ?>&idp=<?php echo($idp); ?>&upload_ulang=1&id_berkas=<?php echo $rowIdenBerkas['id_berkas']; ?>';
                                                                    $('#<?php echo 'file_kp_'.$rowIdenBerkas['idjenis_kp_syarat'] ?>').fileupload({
                                                                        url: <?php echo 'url_'.$rowIdenBerkas['idjenis_kp_syarat'] ?>,
                                                                        dataType: 'json',
                                                                        paramName: 'files[]',
                                                                        done: function (e, data) {
                                                                            $.each(data.result.files, function (index, file) {
                                                                                $('<p/>').text(file.name).appendTo('#files');
                                                                                if (jml_noberkas == 0) {
                                                                                    $("#btnSimpanKP").attr("disabled", false);
                                                                                    $("#spnInfo").html('Anda sudah dapat mengusulkan kenaikan pangkat');
                                                                                    $("#spnInfo").css('color', '#008000');
                                                                                }
                                                                            });
                                                                        },
                                                                        progressall: function (e, data) {
                                                                            var progress = parseInt(data.loaded / data.total * 100, 10);
                                                                            $('#<?php echo 'progress_'.$rowIdenBerkas['idjenis_kp_syarat'] ?> .progress-bar').css(
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
                                                <?php }
                                        }else{
                                            if ($rowIdenBerkas['id_berkas'] == 0){
                                                $jml_noberkas = $jml_noberkas + 1;
                                                echo ("Syarat belum tersedia, silahkan hubungi pengelola SIMPEG");
                                            }else{
                                                $fname = pathinfo($rowIdenBerkas['file_name']);
                                                //echo $fname['basename'].'-'.$fname['extension'];
                                                if($fname['extension'] == 'pdf'){
                                                    echo("<a href='/Simpeg/berkas/" . $rowIdenBerkas['file_name'] . "' target='_blank' >Sudah tersedia</a>");
                                                }else{
                                                    echo("<a href='/Simpeg/berkas.php?idb=" . $rowIdenBerkas['id_berkas'] . "' target='_blank' >Sudah tersedia</a>");
                                                }
                                            }
                                        }
                                ?>
                            </td>
                        </tr>
                        <?php } ?>
                        <script type="text/javascript">
                            var jml_noberkas = <?php echo $jml_noberkas ?>;
                        </script>
                        <tr>
                            <td></td>
                            <td colspan="2"><input type="submit" name="btnSimpanKP" id="btnSimpanKP" class="btn btn-primary" value="Ajukan"  <?php if($jml_noberkas > 0) echo 'disabled' ?> />
                                <?php if($jml_noberkas > 0) echo "<span id='spnInfo' style='color: red'>Anda belum dapat mengusulkan, lengkapi dahulu syarat </span>" ?>
                                <?php if($jml_noberkas == 0) echo "<span id='spnInfo' style='color: #008000'>Anda sudah dapat mengusulkan kenaikan pangkat </span>" ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2">Keterangan : <br> Untuk pengubahan berkas berjenis SK dan Ijazah harap hubungi pengelola SIMPEG di SKPD masing-masing atau BKPP</td>
        </tr>
        <?php } ?>
    </table>
</form>


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="assets/js/vendor/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="assets/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="assets/js/jquery.fileupload.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!--script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script-->

<script type="text/javascript">

    $("#slctIdJenisKP").click(function() {
        var idJnsKP = ($("#slctIdJenisKP").val());
        $("#list_syarat").css("pointer-events", "none");
        $("#list_syarat").css("opacity", "0.4");
        $("#btnSimpanKP").css("pointer-events", "none");
        $("#btnSimpanKP").css("opacity", "0.4");
        $("#slctIdJenisKP").css("pointer-events", "none");
        $("#slctIdJenisKP").css("opacity", "0.4");
        $.ajax({
            type: "GET",
            url: "/simpeg/pkp_syarat_load.php?idJnsKP="+idJnsKP+"&idpegawai=<?php echo $idp ?>",
            success: function (data) {
                $("#list_syarat").html(data);
                $("#list_syarat").css("pointer-events", "auto");
                $("#list_syarat").css("opacity", "1");
                $("#btnSimpanKP").css("pointer-events", "auto");
                $("#btnSimpanKP").css("opacity", "1");
                $("#slctIdJenisKP").css("pointer-events", "auto");
                $("#slctIdJenisKP").css("opacity", "1");
            }
        });
    });

</script>