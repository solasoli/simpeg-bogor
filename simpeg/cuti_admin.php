<?php
session_start();
extract($_POST);
include("konek.php");

$sql_list_cuti = "SELECT cuti_pegawai.*, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) as nama, g.pangkat,
                    DATE_FORMAT(cuti_pegawai.tmt_awal,  '%d/%m/%Y') AS tmt_awal_cuti,
                    DATE_FORMAT(cuti_pegawai.tmt_akhir,  '%d/%m/%Y') AS tmt_akhir_cuti,
                    DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti,  '%d/%m/%Y %H:%m:%s') AS tgl_usulan_cuti2,
                    DATE_FORMAT(cuti_pegawai.tgl_approve_status,  '%d/%m/%Y %H:%m:%s') AS tgl_approve_status2
                    FROM
                    (SELECT cuti_pegawai.*, p.nama as nama_approved, p.nip_baru as nip_baru_approved, uk.id_skpd FROM
                    (SELECT cm.*, rs.status_cuti, cj.deskripsi FROM cuti_master cm, ref_status_cuti rs, cuti_jenis cj
                    WHERE cm.id_status_cuti = rs.idstatus_cuti AND cm.id_jenis_cuti = cj.id_jenis_cuti) as cuti_pegawai, pegawai p, unit_kerja uk
                    WHERE cuti_pegawai.approved_by = p.id_pegawai AND cuti_pegawai.last_id_unit_kerja = uk.id_unit_kerja
                    AND uk.id_skpd = ".$_SESSION['id_skpd']."
                    ORDER BY cuti_pegawai.tgl_usulan_cuti DESC) AS cuti_pegawai, pegawai p, golongan g
                    WHERE cuti_pegawai.id_pegawai = p.id_pegawai AND cuti_pegawai.last_gol = g.golongan
                    ORDER BY cuti_pegawai.tgl_usulan_cuti DESC";
$query_row_cuti_master = mysqli_query($mysqli,$sql_list_cuti);
$i = 0;

?>

<h2>Daftar Pengajuan Cuti</h2>

<div style="margin-top: 10px; margin-bottom: 10px; font-style: italic;color: #0A246A;">
    Jika pegawai yang mengajukan cuti memiliki perbedaan lokasi unit kerja antara atasan langsung dengan atasan dari atasan langsung (pejabat berwenang),
    <br>maka pastikan berkas surat cuti yang terupload dikirimkan dengan cara mengklik tombol <strong>Kirim Usulan</strong>,
    untuk pemrosesan administrasi cuti oleh operator pengelola di BKPP.<br>
    Namun jika sebaliknya (sama), maka sudah langsung terkirim ke operator pengelola di BKPP.
</div>
<table width="95%" border="0" align="center" style="border-radius:5px;"
       class="table table-bordered table-hover table-striped">
<tr>
    <td style="width: 5%;">No.</td>
    <td style="width: 5%;">Periode</td>
    <td style="width: 15%;">Tgl. Pengajuan</td>
    <td style="width: 10%;">TMT. Awal</td>
    <td style="width: 10%;">TMT. Akhir</td>
    <td style="width: 5%;">Lama Cuti</td>
    <td style="width: 30%;">Alamat Cuti</td>
    <td style="width: 20%;">Status</td>
</tr>
<?php while($row_cuti = mysqli_fetch_array($query_row_cuti_master)){
    if (isset($btnAjukanCuti[$i])) {
        $idstatus_cuti_hist = 3;
    } else if (isset($btnRevisiCuti[$i])) {
        $idstatus_cuti_hist = 4;
    } else if (isset($btnTolakCuti[$i])){
        $idstatus_cuti_hist = 7;
    }
    if(isset($btnAjukanCuti[$i]) or isset($btnRevisiCuti[$i]) or isset($btnTolakCuti[$i])){
        $sqlInsert_Approved_Hist = "INSERT INTO cuti_historis_approve(tgl_approve_hist, approved_by_hist, idstatus_cuti_hist, approved_note_hist, id_cuti_master)
                            VALUES (NOW(),".$_SESSION[id_pegawai].",$idstatus_cuti_hist,'".$txtCatatan[$i]."',".$row_cuti['id_cuti_master'].")";
        if (mysqli_query($mysqli,$sqlInsert_Approved_Hist) == TRUE) {
            echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Pengajuan Cuti Berhasil Terkirim </div>");
            $sqlUpdateCuti = "UPDATE cuti_master set id_status_cuti=$idstatus_cuti_hist, tgl_approve_status=NOW(),
                                approved_by=".$_SESSION[id_pegawai].",approved_note= '".$txtCatatan[$i]."'
                                where id_cuti_master=".$row_cuti['id_cuti_master'];
            mysqli_query($mysqli,$sqlUpdateCuti);
            $url = "/simpeg/index3.php?x=cuti_admin.php";
            echo("<script type=\"text/javascript\">location.href='/simpeg/index3.php?x=cuti_admin.php';</script>");
        } else {
            echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menyimpan data" . "<br>" . $conn->error . "</div>");
        }
    }
?>
    <tr>
        <td><?php echo $i+1; ?>.</td>
        <td><?php echo $row_cuti['periode_thn']; ?></td>
        <td><?php echo $row_cuti['tgl_usulan_cuti2']; ?></td>
        <td><?php echo $row_cuti['tmt_awal_cuti']; ?></td>
        <td><?php echo $row_cuti['tmt_akhir_cuti']; ?></td>
        <td><?php echo $row_cuti['lama_cuti']; ?></td>
        <td><?php echo $row_cuti['keterangan']; ?></td>
        <td><?php echo $row_cuti['status_cuti']; ?></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="7">
            <h3 style="color: #002a80;"><?php echo $row_cuti['nama']; ?></h3>
            <strong style="color: #1b983e;"><?php echo $row_cuti['deskripsi']; ?></strong><br>
            Pangkat : <?php echo $row_cuti['pangkat'].', '.$row_cuti['last_gol']; ?> <br>
            Unit Kerja : <?php echo $row_cuti['last_unit_kerja']; ?> <br>
            <strong>Atasan  Langsung : </strong><br>
            <?php echo $row_cuti['last_atsl_nama']." (".$row_cuti['last_atsl_nip'].")"; ?> <br>
            Gol. <?php echo $row_cuti['last_atsl_gol']; ?>. Jabatan : <?php echo $row_cuti['last_atsl_jabatan']; ?> <br>
            <strong>Pejabat Berwenang : </strong><br>
            <?php echo $row_cuti['last_pjbt_nama']." (".$row_cuti['last_pjbt_nip'].")"; ?> <br>
            Gol. <?php echo $row_cuti['last_pjbt_gol']; ?>. Jabatan : <?php echo $row_cuti['last_pjbt_jabatan']; ?> <br>
            <strong>Tgl. Update Status : </strong><?php echo $row_cuti['tgl_approve_status2']; ?> | Oleh : <?php echo $row_cuti['nama_approved']." (".$row_cuti['nip_baru_approved'].")"; ?> | Catatan Akhir : <?php echo ($row_cuti['approved_note']==""?"-":$row_cuti['approved_note']); ?><br />
            Runut Status Pengajuan : <br><?php
            echo("<ul>");
            $qrun=mysqli_query($mysqli,"select nama,DATE_FORMAT(tgl_approve_hist,  '%d/%m/%Y %H:%m:%s') as tgl_approve_hist,approved_note_hist,status_cuti from cuti_historis_approve inner join pegawai on cuti_historis_approve.approved_by_hist=pegawai.id_pegawai inner join ref_status_cuti on ref_status_cuti.idstatus_cuti = cuti_historis_approve.idstatus_cuti_hist  where id_cuti_master=$row_cuti[id_cuti_master] ");
            while($otoy=mysqli_fetch_array($qrun))
            {
                echo("<li>Status : $otoy[3] Diproses oleh $otoy[0] tanggal $otoy[1] catatan: $otoy[2] </li>");

            }


            echo("</ul>");
            ?>
            <table width="100%" border="0" align="center" style="border-radius:5px;"
                       class="table table-bordered table-striped">
                    <tr>
                        <td width="20%">
                            <?php
                            if ($row_cuti['idberkas_surat_cuti'] == 0) {
                                $jml_noberkas[$i] = $jml_noberkas[$i] + 1;
                                echo "<div id='spnInfo' style='color: white; background-color: #b12318; font-weight: bold; padding: 3px; width: 100%; text-align: center;'>Belum ada surat permohonan cuti yang diupload</div>";
                            }else {
                                $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%m:%s') as created_date, p.nip_baru, p.nama
                                                FROM berkas b, isi_berkas ib, pegawai p
                                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = " . $row_cuti['idberkas_surat_cuti'] .
                                    " AND b.created_by = p.id_pegawai";
                                $queryCek = mysqli_query($mysqli,$sqlCekBerkas);
                                $data = mysqli_fetch_array($queryCek);
                                $fname = pathinfo($data['file_name']);
                                ?>
                                <input type="button" name="btnCetakSuratCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>" id="btnCetakSuratCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>" class="btn btn-primary btn-sm" value="Lihat Surat Permohonan Terupload" />
                                <script type="text/javascript">
                                    $("#btnCetakSuratCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>").click(function () {
                                        window.open('/simpeg/berkas/<?php echo $data['file_name'] ?>','_blank');
                                    });
                                </script>
                                Tgl.Upload: <?php echo $data['created_date']; ?> <br>
                                Oleh : <?php echo $data['nama']; ?>
                            <?php
                            }
                            ?>
                        </td>
                        <?php if($row_cuti['flag_uk_atasan_sama'] == 0){ ?>
                        <td width="25%">
                            <?php
                            if ($row_cuti['idberkas_surat_cuti'] == 0){
                                    }else{
                                    ?>
                                    <span class="btn btn-primary btn-sm fileinput-button" <?php if($row_cuti['id_status_cuti']!=2) echo 'disabled' ?>>
                                                        <i class="glyphicon glyphicon-plus"></i>
                                                        <span>Upload Ulang</span>
                                                        <span>(format file harus pdf)</span>
                                                        <!-- The file input field used as target for the file upload widget -->
                                                        <input id="<?php echo 'file_cuti_' . $row_cuti['id_cuti_master'] ?>" type="file" name="files[]" multiple/>
                                                        <input type="hidden" name="<?php echo 'surat_permohonan_cuti' . $row_cuti['id_cuti_master'] ?>"
                                                               id="<?php echo 'surat_permohonan_cuti' . $row_cuti['id_cuti_master'] ?>"/>  </span> <br><br>
                                    <div id="<?php echo 'progress_' . $row_cuti['id_cuti_master'] ?>" class="progress primary" style="margin-top: -5px;">
                                        <div class="progress-bar progress-bar-primary">
                                            <script type="text/javascript">
                                                $(function () {
                                                    var <?php echo 'url_'.$row_cuti['id_cuti_master'] ?> =
                                                    window.location.hostname === 'blueimp.github.io' ?
                                                        '//jquery-file-upload.appspot.com/' : 'uploadercuti.php?idkat=37&nm_berkas=Surat Permohonan Cuti&ket_berkas=<?php echo $row_cuti['id_cuti_master']; ?>&idp_uploader=<?php echo($_SESSION[id_pegawai]); ?>&idp_cutier=<?php echo($row_cuti['id_pegawai']); ?>&upload_ulang=1&id_berkas=<?php echo $row_cuti['idberkas_surat_cuti']; ?>';
                                                    $('#<?php echo 'file_cuti_'.$row_cuti['id_cuti_master'] ?>').fileupload({
                                                        url: <?php echo 'url_'.$row_cuti['id_cuti_master'] ?>,
                                                        dataType: 'json',
                                                        paramName: 'files[]',
                                                        done: function (e, data) {
                                                            $.each(data.result.files, function (index, file) {
                                                                $('<p/>').text(file.name).appendTo('#files');
                                                                location.href="/simpeg/index3.php?x=cuti_admin.php";
                                                                /*if (jml_noberkas == 0) {
                                                                 $("#btnAjukanCuti").attr("disabled", false);
                                                                 $("#spnInfo").html('Anda sudah dapat mengajukan cuti');
                                                                 $("#spnInfo").css('color', '#008000');
                                                                 }*/
                                                            });
                                                        },
                                                        progressall: function (e, data) {
                                                            var progress = parseInt(data.loaded / data.total * 100, 10);
                                                            $('#<?php echo 'progress_'.$row_cuti['id_cuti_master'] ?> .progress-bar').css(
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
                        </td>
                        <td width="25%">
                            <?php
                            if ($row_cuti['id_status_cuti'] == 6) {
                                echo "<div id='spnInfo' style='color: white; background-color: #b12318; font-weight: bold; padding: 3px; width: 100%; text-align: center;'>SK Cuti belum diterbitkan</div>";
                            }
                            if ($row_cuti['id_status_cuti'] == 10) {
                                if ($row_cuti['idberkas_sk_cuti'] == 0) {
                                    echo "<div id='spnInfo' style='color: white; background-color: #b12318; font-weight: bold; padding: 3px; width: 100%; text-align: center;'>Belum ada SK Cuti yang diupload</div>";
                                }else {
                                    $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%m:%s') as created_date, p.nip_baru, p.nama
                                                    FROM berkas b, isi_berkas ib, pegawai p
                                                    WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = " . $row_cuti['idberkas_sk_cuti'] .
                                        " AND b.created_by = p.id_pegawai";
                                    $queryCek = mysqli_query($mysqli,$sqlCekBerkas);
                                    $data = mysqli_fetch_array($queryCek);
                                    $fname = pathinfo($data['file_name']);
                                    ?>
                                    <input type="button" name="btnCetakSKCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>" id="btnCetakSKCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>" class="btn btn-danger btn-sm" value="Download SK Cuti" style="width: 100%;" /><br>
                                    <script type="text/javascript">
                                        $("#btnCetakSKCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>").click(function () {
                                            window.open('/simpeg/berkas/<?php echo $data['file_name'] ?>','_blank');
                                        });
                                    </script>
                                    Tgl.Upload: <?php echo $data['created_date']; ?> <br>
                                    Oleh : <?php echo $data['nama']; ?>
                                <?php
                                }
                            }
                            ?>
                        </td>
                        <td width="30%"></td>
                        <?php } ?>
                        <?php if($row_cuti['flag_uk_atasan_sama'] == 1){ ?>
                        <td width="25%">
                            <?php
                            if ($row_cuti['id_status_cuti'] == 6) {
                                echo "<div id='spnInfo' style='color: white; background-color: #b12318; font-weight: bold; padding: 3px; width: 100%; text-align: center;'>SK Cuti belum diterbitkan</div>";
                            }
                            if ($row_cuti['id_status_cuti'] == 10) {
                                if ($row_cuti['idberkas_sk_cuti'] == 0) {
                                    echo "<div id='spnInfo' style='color: white; background-color: #b12318; font-weight: bold; padding: 3px; width: 100%; text-align: center;'>Belum ada SK Cuti yang diupload</div>";
                                }else {
                                    $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%m:%s') as created_date, p.nip_baru, p.nama
                                                    FROM berkas b, isi_berkas ib, pegawai p
                                                    WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = " . $row_cuti['idberkas_sk_cuti'] .
                                        " AND b.created_by = p.id_pegawai";
                                    $queryCek = mysqli_query($mysqli,$sqlCekBerkas);
                                    $data = mysqli_fetch_array($queryCek);
                                    $fname = pathinfo($data['file_name']);
                                    ?>
                                    <input type="button" name="btnCetakSKCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>" id="btnCetakSKCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>" class="btn btn-danger btn-sm" value="Download SK Cuti" style="width: 100%;" /><br>
                                    <script type="text/javascript">
                                        $("#btnCetakSKCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>").click(function () {
                                            window.open('/simpeg/berkas/<?php echo $data['file_name'] ?>','_blank');
                                        });
                                    </script>
                                    Tgl.Upload: <?php echo $data['created_date']; ?> <br>
                                    Oleh : <?php echo $data['nama']; ?>
                                <?php
                                }
                            }
                            ?>
                        </td>
                        <td width="55%"></td>
                        <?php } ?>
                    </tr>
                    <?php
                    if($row_cuti['flag_uk_atasan_sama'] == 0){
                    ?>
                    <tr style="background-color: #c6c6c6;">
                        <td colspan="4">
                            <form action="index3.php?x=cuti_admin.php" method="post" enctype="multipart/form-data" name="frmAjukanCuti" id="frmAjukanCuti">
                            Catatan <input name="txtCatatan[<?php echo $i; ?>]" id="txtCatatan[<?php echo $i; ?>]" type="text" style="width: 50%;" value="" <?php echo(($row_cuti['id_status_cuti']!=2)?"disabled":(($jml_noberkas[$i] > 0)?"":"")); ?>/>
                            <input type="submit" name="btnAjukanCuti[<?php echo $i; ?>]" id="btnAjukanCuti[<?php echo $i; ?>]" class="btn btn-success" value="Kirim Usulan" <?php echo(($row_cuti['id_status_cuti']!=2)?"disabled":(($jml_noberkas[$i] > 0)?"disabled":"")); ?> />
                            <input type="submit" name="btnRevisiCuti[<?php echo $i; ?>]" id="btnRevisiCuti[<?php echo $i; ?>]" class="btn btn-warning" value="Revisi" <?php echo(($row_cuti['id_status_cuti']!=2)?"disabled":(($jml_noberkas[$i] > 0)?"":"")); ?> />
                            <input type="submit" name="btnTolakCuti[<?php echo $i; ?>]" id="btnTolakCuti[<?php echo $i; ?>]" class="btn btn-danger" value="Tolak" <?php if($row_cuti['id_status_cuti']!=2) echo 'disabled' ?> />
                            </form>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
        </td>
    </tr>
    <?php
    $i++;
}
?>
</table>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="assets/js/vendor/jquery.ui.widget.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="assets/js/jquery.iframe-transport.js"></script>
<!-- The basic File Upload plugin -->
<script src="assets/js/jquery.fileupload.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<!--script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script-->