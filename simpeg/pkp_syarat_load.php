<?php
extract($_GET);
include("konek.php");

$idp = $_GET['idpegawai'];
$idjenis_kp = $_GET['idJnsKP'];

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

mysqli_query($mysqli,"START TRANSACTION");
$queryIdentifiedBerkas = mysqli_query($mysqli,$sqlIdentifiedBerkas);
if($queryIdentifiedBerkas){
    mysqli_query($mysqli,"COMMIT");
    $jml_noberkas = 0;
    $array_identity_berkas = array();
    while($row = mysqli_fetch_array($queryIdentifiedBerkas)){
        $array_identity_berkas[] = $row;
    }
    $arrIdenBerkas_length = count($array_identity_berkas);
}else{
    mysqli_query($mysqli,"ROLLBACK");
}
?>

<script type="text/javascript">
    var b = $.get("//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js").pipe(
        $.get("assets/js/vendor/jquery.ui.widget.js")).pipe(
        $.get("assets/js/jquery.iframe-transport.js")).pipe(
        $.get("assets/js/jquery.fileupload.js"));
    b.pipe(function (a) {
        return a.success ? a : $.Deferred().reject(a)
    }, function (a) {
        return {success: !1, data: null, errors: ["Unexpected error: " + a.status + " " + a.statusText]}
    });
</script>

<table width="95%" border="0" align="center" style="border-radius:5px;"
       class="table table-bordered table-hover table-striped">
    <tr>
        <td align="center" style="width: 5%;">No.</td>
        <td align="left" style="width: 45%;">Uraian</td>
        <td align="left" style="width: 50%;">Berkas</td>
    </tr>

    <?php for($x = 0; $x < $arrIdenBerkas_length; $x++) { ?>
        <tr>
            <td><?php echo $array_identity_berkas[$x]['no_urut'] ?></td>
            <td><?php echo $array_identity_berkas[$x]['nama_syarat'] ?></td>
            <td>
                <?php
                        if($array_identity_berkas[$x]['is_can_reupload'] == 1){
                            if ($array_identity_berkas[$x]['id_berkas'] == 0){
                                $jml_noberkas = $jml_noberkas + 1;
                        ?>
                                <span class="btn btn-primary btn-sm fileinput-button">
                                                        <i class="glyphicon glyphicon-plus"></i>
                                                        <span>Upload Baru</span>
                                                        <!-- The file input field used as target for the file upload widget -->
                                                        <input id="<?php echo 'file_kp_'.$array_identity_berkas[$x]['idjenis_kp_syarat'] ?>" type="file" name="files[]" multiple/>
                                                        <input type="hidden" name="<?php echo 'syarat_'.$array_identity_berkas[$x]['idjenis_kp_syarat'] ?>" id="<?php echo 'syarat_'.$array_identity_berkas[$x]['idjenis_kp_syarat'] ?>"/>  </span>
                                <div id="<?php echo 'progress_'.$array_identity_berkas[$x]['idjenis_kp_syarat'] ?>" class="progress primary">
                                    <div class="progress-bar progress-bar-primary">
                                <?php
                            }else{
                                $sqlCekPenggunaanBerkas = "SELECT count(id_kp_usulan) as jml
                                FROM kenaikan_pangkat_usulan_detail WHERE id_berkas = ".$array_identity_berkas[$x]['id_berkas'];
                     
                                $queryCek = mysqli_query($mysqli,$sqlCekPenggunaanBerkas);
                                $data = mysqli_fetch_array($queryCek);
                                if($data[0] > 0){ //Jika ada yg menggunakan ini berkas

                                }else{
                                    $fname = pathinfo($array_identity_berkas[$x]['file_name']);
                                    //echo $fname['basename'].'-'.$fname['extension'];
                                    if($fname['extension'] == 'pdf'){
                                        echo("<a href='/Simpeg/berkas/" . $array_identity_berkas[$x]['file_name'] . "' target='_blank' >Sudah tersedia</a>");
                                    }else{
                                        echo("<a href='/Simpeg/berkas.php?idb=" . $array_identity_berkas[$x]['id_berkas'] . "' target='_blank' >Sudah tersedia</a>");
                                    }
                                ?>
                                        <br>
                                        <span class="btn btn-primary btn-sm fileinput-button">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Upload Ulang</span>
                                        <!-- The file input field used as target for the file upload widget -->
                                        <input id="<?php echo 'file_kp_' . $array_identity_berkas[$x]['idjenis_kp_syarat'] ?>" type="file" name="files[]" multiple/>
                                        <input type="hidden" name="<?php echo 'syarat_' . $array_identity_berkas[$x]['idjenis_kp_syarat'] ?>"
                                        id="<?php echo 'syarat_' . $array_identity_berkas[$x]['idjenis_kp_syarat'] ?>"/>  </span>
                                        <div id="<?php echo 'progress_' . $array_identity_berkas[$x]['idjenis_kp_syarat'] ?>" class="progress primary">
                                        <div class="progress-bar progress-bar-primary">

                                <?php } ?>
                            <?php }
                        }else{
                            if ($array_identity_berkas[$x]['id_berkas'] == 0){
                                $jml_noberkas = $jml_noberkas + 1;
                                echo ("Syarat belum tersedia, silahkan hubungi pengelola SIMPEG");
                            }else{
                                $fname = pathinfo($array_identity_berkas[$x]['file_name']);
                                //echo $fname['basename'].'-'.$fname['extension'];
                                if($fname['extension'] == 'pdf'){
                                    echo("<a href='/Simpeg/berkas/" . $array_identity_berkas[$x]['file_name'] . "' target='_blank' >Sudah tersedia</a>");
                                }else{
                                    echo("<a href='/Simpeg/berkas.php?idb=" . $array_identity_berkas[$x]['id_berkas'] . "' target='_blank' >Sudah tersedia</a>");
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
        <td colspan="2"><input type="submit" name="btnSimpanKP" id="btnSimpanKP" class="btn btn-primary" value="Ajukan" <?php if($jml_noberkas > 0) echo 'disabled' ?> />
            <?php if($jml_noberkas > 0) echo "<span id='spnInfo' style='color: red'>Anda belum dapat mengusulkan, lengkapi dahulu syarat </span>" ?>
            <?php if($jml_noberkas == 0) echo "<span id='spnInfo' style='color: #008000'>Anda sudah dapat mengusulkan kenaikan pangkat </span>" ?>
        </td>
    </tr>
</table>

<script type="text/javascript">
    setTimeout(function () {
        b.then(function (a) {
                $(function () {
                    <?php for($x = 0; $x < $arrIdenBerkas_length; $x++) {
                        if($array_identity_berkas[$x]['id_berkas']==0){
                            $upload_ulang = 0; ?>
                    <?php
                        }else{
                            $upload_ulang = 1;
                        }
                    ?>
                    var <?php echo 'url_'.$array_identity_berkas[$x]['idjenis_kp_syarat'] ?> = window.location.hostname === 'blueimp.github.io' ?
                        '//jquery-file-upload.appspot.com/' : 'uploaderkp.php?idkat=<?php echo $array_identity_berkas[$x]['id_kat_berkas']; ?>&nm_berkas=<?php echo $array_identity_berkas[$x]['nama_berkas']; ?>&idp=<?php echo($idp); ?>&upload_ulang=<?php echo($upload_ulang); ?>&id_berkas=<?php echo $array_identity_berkas[$x]['id_berkas']; ?>';
                    $('#<?php echo 'file_kp_'.$array_identity_berkas[$x]['idjenis_kp_syarat'] ?>').fileupload({
                        url: <?php echo 'url_'.$array_identity_berkas[$x]['idjenis_kp_syarat'] ?>,
                        dataType: 'json',
                        paramName: 'files[]',
                        done: function (e, data) {
                            $.each(data.result.files, function (index, file) {
                                $('<p/>').text(file.name).appendTo('#files');
                                <?php if($array_identity_berkas[$x]['id_berkas']==0){ ?>
                                    jml_noberkas = jml_noberkas - 1;
                                <? } ?>
                                if (jml_noberkas == 0) {
                                    $("#btnSimpanKP").attr("disabled", false);
                                    $("#spnInfo").html('Anda sudah dapat mengusulkan kenaikan pangkat');
                                    $("#spnInfo").css('color', '#008000');
                                }
                            });
                        },
                        progressall: function (e, data) {
                            var progress = parseInt(data.loaded / data.total * 100, 10);
                            $('#<?php echo 'progress_'.$array_identity_berkas[$x]['idjenis_kp_syarat'] ?> .progress-bar').css(
                                'width',
                                progress + '%'
                            );
                        }
                    })

                    <?php } ?>

                });
            }, function (a) {
        });
    }, 200);
</script>