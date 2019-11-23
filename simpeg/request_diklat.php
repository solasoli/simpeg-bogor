<link href="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<script src="js/moment.js"></script>
<script src="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
<script src="js/bootstrapValidator.js"></script>
<?php
    extract($_POST);
    extract($_GET);

    if(@$update==1)
    {
        $qup=mysqli_query($mysqli,"select * from kebutuhan_diklat where id=$idkebd");
        $up=mysqli_fetch_array($qup);
        $t3=substr($up['tgl_permintaan'],8,2);
        $b3=substr($up['tgl_permintaan'],5,2);
        $th3=substr($up['tgl_permintaan'],0,4);
        $tglPerm =  $t3.'-'.$b3.'-'.$th3;
        $jenis = $up['id_jenis_diklat'];
        $namaDiklat = $up['nama_diklat'];
        $bidang = $up['id_bidang'];
        $jmlP = $up['jumlah_peserta'];
        $linkBerkasUsulan = "";
        $tglUpload = "";
        $pengUpload = "";
        if ($up['id_berkas_usulan'] <> '' and $up['id_berkas_usulan'] <> '0') {
            $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama
                         FROM berkas b, isi_berkas ib, pegawai p
                         WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = " . $up['id_berkas_usulan'] .
                " AND b.created_by = p.id_pegawai";
            $query = $mysqli->query($sqlCekBerkas);
            if (isset($query)) {
                if ($query->num_rows > 0) {
                    while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                        $asli = basename($oto[0]);
                        if(file_exists(str_replace("\\","/",getcwd()).'/Berkas/'.trim($asli))){
                            $ext[] = explode(".",$asli);
                            $linkBerkasUsulan = "<a href='./Berkas/$asli' target='_blank'>Lihat</a>";
                            $tglUpload = $oto[2];
                            $pengUpload = $oto[4].' ('.$oto[3].')';
                            unset($ext);
                        }
                    }
                }
            }
        }
    }else{
        $tglPerm = date("d-m-Y");
        $jenis = '';
        $namaDiklat = '';
        $bidang = '';
        $jmlP = '';
        $tglPelaksanaan = 'NULL';
    }

    if(@$issubmit=='true'){
        if(isset($idup)) {
            $all_query_ok=true;
            $sqlUpdate = "update kebutuhan_diklat set nama_diklat = '$nmDiklat', id_jenis_diklat = '$selectJenDiklat',id_bidang = '$selectBidDiklat',
            jumlah_peserta = '$jmlPeserta' where id = $idup";
            $mysqli->autocommit(FALSE);
            if ($mysqli->query($sqlUpdate) == TRUE) {
                $sqlDelete = "delete from kebutuhan_diklat_detail where id_keb_diklat = $idup";
                if ($mysqli->query($sqlDelete) == TRUE) {
                    foreach( $chkIdPegPilih as $key => $n ) {
                        $sqlIns = "insert into kebutuhan_diklat_detail (id_pegawai, id_keb_diklat, status, is_baru) values (".$chkIdPegPilih[$key].", $idup, 1, 0)";
                        if ($mysqli->query($sqlIns)){
                            null;
                        }else{
                            $all_query_ok=false;
                        }
                    }
                }
            }else{
                $all_query_ok=false;
            }
            if($all_query_ok){
                $mysqli->commit();
                echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Data Permohonan Diklat Berhasil Diubah </div>");
            }else{
                $mysqli->rollback();
                echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menyimpan data" . "<br>" . $conn->error . "</div>");
            }

            $all_query_ok=true;
            if(isset($_FILES["fileUsulan"])) {
                if ($_FILES["fileUsulan"]['name'] <> "") {
                    if ($_FILES["fileUsulan"]['type'] == 'binary/octet-stream' or $_FILES["fileUsulan"]['type'] == "application/pdf"){
                        if ($_FILES["fileUsulan"]['size'] > 20097152) {
                            echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'>File tidak terupload. Ukuran file terlalu besar</div>");
                        }else{
                            $uploaddir = 'Berkas/';
                            $uploadfile = $uploaddir . basename($_FILES["fileUsulan"]['name']);
                            if (move_uploaded_file($_FILES["fileUsulan"]['tmp_name'], $uploadfile)) {
                                $mysqli->autocommit(FALSE);
                                $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) ".
                                    "values (".$_SESSION[id_pegawai].", 40,'Surat Usulan', DATE(NOW()), '".$_SESSION[id_pegawai]."', NOW(), $idup)";
                                //echo $sqlInsert.'<br>';
                                if ($mysqli->query($sqlInsert)){
                                    $last_id_berkas = $mysqli->insert_id;
                                    $sqlUpdate = "update kebutuhan_diklat set id_berkas_usulan = $last_id_berkas where id=".$idup;
                                    //echo $sqlUpdate.'<br>';
                                    if ($mysqli->query($sqlUpdate)){
                                        $sqlInsert = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas, 'Berkas Usulan')";
                                        //echo $sqlInsert.'<br>';
                                        if ($mysqli->query($sqlInsert)){
                                            $last_idisi = $mysqli->insert_id;
                                            $nf=$_SESSION['nip_baru']."-".$last_id_berkas."-".$last_idisi.".pdf";
                                            $sqlUpdate = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                            //echo $sqlUpdate.'<br>';
                                            if ($mysqli->query($sqlUpdate)){
                                                null;
                                            }else{
                                                $all_query_ok=false;
                                            }
                                        }else{
                                            $all_query_ok=false;
                                        }
                                    }else{
                                        $all_query_ok=false;
                                    }
                                }else{
                                    $all_query_ok=false;
                                }
                                if($all_query_ok) {
                                    $mysqli->commit();
                                    rename($uploadfile,"Berkas/".$nf);
                                }else{
                                    echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'>Data berkas tidak tersimpan</div>");
                                }
                            }
                        }
                    }else{
                        echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'>File tidak terupload. Tipe file belum sesuai</div>");
                    }
                }
            }

        }else{
            $all_query_ok=true;
            $tglPermintaan = explode("-", $tglPermintaan);
            $tglPermintaan = $tglPermintaan[2] . '-' . $tglPermintaan[1] . '-' . $tglPermintaan[0];
            $sql_insert = "insert into kebutuhan_diklat (id_unit_kerja,tgl_permintaan,id_jenis_diklat,nama_diklat,id_bidang,jumlah_peserta,
                    tgl_pelaksanaan,idpegawai_pemohon,idstatus_approve) values (".$_SESSION['id_skpd'].",'$tglPermintaan','$selectJenDiklat',
                    '$nmDiklat',$selectBidDiklat,$jmlPeserta,$tglPelaksanaan,".$_SESSION['id_pegawai'].",1)";
            $mysqli->autocommit(FALSE);
            if ($mysqli->query($sql_insert) === TRUE) {
                $last_id = $mysqli->insert_id;
                foreach( $chkIdPegPilih as $key => $n ) {
                    $sqlIns = "insert into kebutuhan_diklat_detail (id_pegawai, id_keb_diklat, status, is_baru) values (".$chkIdPegPilih[$key].", $last_id, 1, 0)";
                    //echo $sqlIns.'<br>';
                    if ($mysqli->query($sqlIns)){
                        null;
                    }else{
                        $all_query_ok=false;
                    }
                }
            }else{
                $all_query_ok=false;
            }

            if($all_query_ok){
                $mysqli->commit();
                echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Data Permohonan Diklat Berhasil disimpan </div>");
            }else{
                $mysqli->rollback();
                echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menyimpan data" . "<br>" . $conn->error . "</div>");
            }

            $all_query_ok=true;
            if(isset($_FILES["fileUsulan"])) {
                if ($_FILES["fileUsulan"]['name'] <> "") {
                    if ($_FILES["fileUsulan"]['type'] == 'binary/octet-stream' or $_FILES["fileUsulan"]['type'] == "application/pdf"){
                        if ($_FILES["fileUsulan"]['size'] > 20097152) {
                            echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'>File tidak terupload. Ukuran file terlalu besar</div>");
                        }else{
                            $uploaddir = 'Berkas/';
                            $uploadfile = $uploaddir . basename($_FILES["fileUsulan"]['name']);
                            if (move_uploaded_file($_FILES["fileUsulan"]['tmp_name'], $uploadfile)) {
                                $mysqli->autocommit(FALSE);
                                $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) ".
                                    "values (".$_SESSION[id_pegawai].", 40,'Surat Usulan', DATE(NOW()), '".$_SESSION[id_pegawai]."', NOW(), $last_id)";
                                //echo $sqlInsert.'<br>';
                                if ($mysqli->query($sqlInsert)){
                                    $last_id_berkas = $mysqli->insert_id;
                                    $sqlUpdate = "update kebutuhan_diklat set id_berkas_usulan = $last_id_berkas where id=".$last_id;
                                    //echo $sqlUpdate.'<br>';
                                    if ($mysqli->query($sqlUpdate)){
                                        $sqlInsert = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas, 'Berkas Usulan')";
                                        //echo $sqlInsert.'<br>';
                                        if ($mysqli->query($sqlInsert)){
                                            $last_idisi = $mysqli->insert_id;
                                            $nf=$_SESSION['nip_baru']."-".$last_id_berkas."-".$last_idisi.".pdf";
                                            $sqlUpdate = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                            //echo $sqlUpdate.'<br>';
                                            if ($mysqli->query($sqlUpdate)){
                                                null;
                                            }else{
                                                $all_query_ok=false;
                                            }
                                        }else{
                                            $all_query_ok=false;
                                        }
                                    }else{
                                        $all_query_ok=false;
                                    }
                                }else{
                                    $all_query_ok=false;
                                }
                                if($all_query_ok) {
                                    $mysqli->commit();
                                    rename($uploadfile,"Berkas/".$nf);
                                }else{
                                    echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'>Data berkas tidak tersimpan</div>");
                                }
                            }
                        }
                    }else{
                        echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'>File tidak terupload. Tipe file belum sesuai</div>");
                    }
                }
            }
        }
    }
?>

<h3>Administrasi Permohonan Diklat</h3>
<div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li role="presentation" class="active"><a href="#form_keb_diklat" aria-controls="form_keb_diklat" role="tab" data-toggle="tab">Form Registrasi</a></li>
        <li role="presentation"><a href="#list_keb_diklat" aria-controls="list_keb_diklat" role="tab" data-toggle="tab">Status Permohonan Diklat</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="form_keb_diklat">
            <form role="form" class="form-horizontal" action="index3.php?x=request_diklat.php" method="post"
                  enctype="multipart/form-data" name="frmReqDiklat" id="frmReqDiklat" style="margin-top: 20px;">
                <?php
                    if(@$update==1) {
                        echo("<input type=hidden id=idup name=idup value=$idkebd >");
                    }
                ?>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="tglPermintaan">Tgl. Permintaan :</label>
                    <div class="col-sm-3"><input type="text" class="form-control" id="tglPermintaan" name="tglPermintaan" value="<?php echo $tglPerm;?>" readonly="readonly"></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="selectJenDiklat">Jenis Diklat :</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="selectJenDiklat" name="selectJenDiklat">
                            <?php
                            $qdj=mysqli_query($mysqli,"SELECT * FROM diklat_jenis");
                            while($data=mysqli_fetch_array($qdj))
                            {
                                if(trim($jenis)==trim($data[0]))
                                    echo("<option value=$data[0] selected>$data[1]</option>");
                                else
                                    echo("<option value=$data[0]>$data[1]</option>");
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="nmDiklat">Nama Diklat :</label>
                    <div class="col-sm-5"><textarea type="text" class="form-control" id="nmDiklat" name="nmDiklat" rows="3"><?php echo $namaDiklat; ?></textarea></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="selectBidDiklat">Bidang :</label>
                    <div class="col-sm-3">
                        <select class="form-control" id="selectBidDiklat" name="selectBidDiklat">
                            <?php
                            $qb = mysqli_query($mysqli,"select * from bidang_pendidikan order by bidang ASC");
                            while ($bida = mysqli_fetch_array($qb)) {
                                if($bida[0]==$bidang){
                                    $sel = 'selected';
                                }else{
                                    $sel = '';
                                }
                                echo("<option value=$bida[0] $sel> $bida[1]</option>");
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="jmlPeserta">Jumlah Usulan :</label>
                    <div class="col-sm-2"><select name="jmlPeserta" id="jmlPeserta" class="form-control">
                            <?php
                            for($t=1;$t<=200;$t++)
                            {
                                if($t==$jmlP)
                                    echo("<option value=$t selected> $t</option>");
                                else
                                    echo("<option value=$t> $t Orang</option>");
                            }
                            ?>
                        </select></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Daftar Pegawai :</label>
                    <div class="row">
                        <div class="col-sm-8">
                            <?php
                                $sql = "SELECT uk.id_unit_kerja, uk.nama_baru FROM unit_kerja uk
                                        WHERE uk.tahun = (SELECT MAX(tahun) FROM unit_kerja) AND uk.id_unit_kerja = uk.id_skpd
                                        ORDER BY uk.nama_baru ASC;";
                                $query_row = mysqli_query($mysqli,$sql);
                                $i = 1;
                            ?>
                            <div class="row">
                                <div class="col-sm-7" style="margin-bottom: 15px;">
                                    <select class="form-control" id="selectUnitKerja" name="selectUnitKerja">
                                        <option value="0">-- Semua OPD --</option>
                                        <?php while($row = mysqli_fetch_array($query_row)){
                                            if($row['id_unit_kerja']==$_SESSION['id_skpd']){ ?>
                                                <option value="<?php echo $row['id_unit_kerja']; ?>" selected><?php echo $i.'. '.$row['nama_baru']; ?></option>
                                                <?php
                                            }else{ ?>
                                                <option value="<?php echo $row['id_unit_kerja']; ?>"><?php echo $i.'. '.$row['nama_baru']; ?></option>
                                            <?php }
                                            $i++;
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div id="div1">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" id="txtFilter" name="txtFilter" value="" placeholder="Ketik NIP / Nama / Jabatan">
                                    </div>
                                    <div class="col-sm-4" style="margin-left: -20px;">
                                        <input type="button" id="btnCari" class="btn btn-success" value="Tampilkan" />
                                        <input type="button" id="btnPilih" class="btn btn-danger" value="Pilih" />
                                    </div>
                                    <script>
                                        function getCalonPeserta(idskpd, txtkeyword){
                                            $("#divListData").css("pointer-events", "none");
                                            $("#divListData").css("opacity", "0.4");
                                            $.ajax({
                                                type: "GET",
                                                url: "request_diklat_peserta.php?idskpd=" + idskpd + "&txtkeyword=" + txtkeyword,
                                                success: function (data) {
                                                    $("#divListData").html(data);
                                                    $("#divListData").css("pointer-events", "auto");
                                                    $("#divListData").css("opacity", "1");
                                                }
                                            }).done(function(){
                                                $("#checkAllList").change(function () {
                                                    $("#div1 input:checkbox").prop('checked', $(this).prop("checked"));
                                                });
                                            });
                                        }

                                        function viewDetailPegawai(idpegawai){
                                            $("#winInfo"+idpegawai).html("Loading...");
                                            var request = $.get("request_diklat_info.php?idpegawai="+idpegawai);
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
                                                    $("#winInfo"+idpegawai).html(response);
                                                }
                                            );
                                            $("#modal"+idpegawai).modal('show');
                                        }

                                        $("#btnPilih").click(function () {
                                            $jmlPeserta = $( "#jmlPeserta option:selected" ).val();
                                            var checkboxes = $("#div1 input:checkbox");
                                            for (var i = 1; i < checkboxes.length; i++) {
                                                if(checkboxes[i].checked == true){
                                                    var str = checkboxes[i].value;
                                                    var res = str.split(":");
                                                    var a = arrPilih.indexOf(res[0]);
                                                    if(a==-1){
                                                        if(parseInt($jmlPeserta) > arrPilih.length){
                                                            document.getElementById("jmlPesertaPlih").innerHTML = parseInt(document.getElementById('jmlPesertaPlih').innerHTML)+1;
                                                            arrPilih.push(res[0]);
                                                            $('#tblPilih tr:last').after('<tr id="rowTblPilih'+res[0]+'"><td><input type="checkbox" value="'+res[0]+'" id="chkIdPegPilih[]" name="chkIdPegPilih[]" checked></td><td>'+res[1]+'</td><td>'+res[2]+'</td></tr>');
                                                        }
                                                    }
                                                }
                                            }

                                        });

                                        $("#btnCari").click(function () {
                                            $idskpd = $( "#selectUnitKerja option:selected" ).val();
                                            $keyword  = $("#txtFilter").val();
                                            if($idskpd==0){
                                                if($keyword==''){
                                                    alert('Tentukan dahulu kata kunci pencarian');
                                                }else{
                                                    getCalonPeserta($idskpd,$keyword);
                                                }
                                            }else{
                                                getCalonPeserta($idskpd,$keyword);
                                            }
                                        });

                                        var arrPilih = [];

                                        $("#btnPilih").click(function () {
                                            $jmlPeserta = $( "#jmlPeserta option:selected" ).val();
                                            var checkboxes = $("#div1 input:checkbox");
                                            for (var i = 1; i < checkboxes.length; i++) {
                                                if(checkboxes[i].checked == true){
                                                    var str = checkboxes[i].value;
                                                    var res = str.split(":");
                                                    var a = arrPilih.indexOf(res[0]);
                                                    if(a==-1){
                                                        if(parseInt($jmlPeserta) > arrPilih.length){
                                                            document.getElementById("jmlPesertaPlih").innerHTML = parseInt(document.getElementById('jmlPesertaPlih').innerHTML)+1;
                                                            arrPilih.push(res[0]);
                                                            $('#tblPilih tr:last').after('<tr id="rowTblPilih'+res[0]+'"><td><input type="checkbox" value="'+res[0]+'" id="chkIdPegPilih[]" name="chkIdPegPilih[]" checked></td><td>'+res[1]+'</td><td>'+res[2]+'</td></tr>');
                                                        }
                                                    }
                                                }
                                            }
                                        });
                                    </script>

                                    <?php
                                        $sql = "SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                                        nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
                                        CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                                        (SELECT jm.nama_jfu AS jabatan
                                         FROM jfu_pegawai jp, jfu_master jm
                                         WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                                        ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon
                                        FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j, current_lokasi_kerja clk, unit_kerja uk
                                        WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = ".$_SESSION['id_skpd']." AND p.flag_pensiun = 0
                                        ORDER BY eselon ASC, p.pangkat_gol DESC, p.nama";

                                    $query_row = mysqli_query($mysqli,$sql);
                                        $i = 1;
                                    ?>
                                </div>
                                <div id="divListData" style="height: 300px; overflow: auto; border: 1px solid rgba(111, 111, 111, 0.53); margin-top: 15px;">
                                    <table width="100%" border="0" align="center" style="border-radius:5px;"
                                           class="table table-bordered table-hover table-striped" id="tblList">
                                        <thead>
                                        <tr>
                                            <th width="5%"><input type="checkbox" id="checkAllList"></th>
                                            <th width="30%">NIP</th>
                                            <th width="65%">Nama</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php while($row = mysqli_fetch_array($query_row)){ ?>
                                            <tr>
                                                <td>
                                                    <input type="checkbox" value="<?php echo $row['id_pegawai'].':'.$row['nip_baru'].':'.$row['nama']; ?>" id="chkUnit<?php echo $row['id_pegawai']; ?>" name="chkUnit<?php echo $row['id_pegawai']; ?>">
                                                    <div class="modal fade" id="modal<?php echo $row['id_pegawai']; ?>" role="dialog">
                                                        <div class="modal-dialog modal-lg" style="max-height: 350px;">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title" style="border: 0px;">Informasi Pegawai</h4>
                                                                </div>
                                                                <div class="modal-body" style="height: 350px; width: 100%; overflow-y: scroll;">
                                                                    <div id="winInfo<?php echo $row['id_pegawai']; ?>" style="margin-top: -10px;"></div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button id="btnClose<?php echo $row['id_pegawai']; ?>" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span style="font-size: small;"><a href="javascript:void(0);" onclick="viewDetailPegawai(<?php echo $row['id_pegawai']; ?>);" style="text-decoration: none" ><?php echo $row['nip_baru']; ?></a></span></td>
                                                <td><span style="font-size: small;"><?php echo $row['nama']; ?></span></td>
                                            </tr>
                                            <?php
                                            $i++;
                                        } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <script>
                                $("#checkAllList").change(function () {
                                    $("#div1 input:checkbox").prop('checked', $(this).prop("checked"));
                                });

                            </script>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Daftar Peserta yang diusulkan:</label>
                    <div class="row">
                        <div class="col-sm-8">
                            <div id="div2">
                                <div id="divListDataPilih" style="height: 300px; overflow: auto; border: 1px solid rgba(111, 111, 111, 0.53)">
                                    <table width="98%" border="0" align="center" style="border-radius:5px;"
                                           class="table table-bordered table-hover table-striped" id="tblPilih">
                                        <thead>
                                        <tr>
                                            <th width="5%"><input id="checkAllPilih" type="checkbox"></th>
                                            <th width="30%">NIP</th>
                                            <th width="65%">Nama</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if(@$update==1)
                                        {
                                            $query_row = mysqli_query($mysqli,"SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                                                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama
                                                    FROM pegawai p, kebutuhan_diklat_detail kdd
                                                    WHERE kdd.id_keb_diklat = $idkebd AND p.id_pegawai = kdd.id_pegawai");
                                            $i = 1;
                                            while($row = mysqli_fetch_array($query_row)){ ?>
                                                <tr id="rowTblPilih<?php echo $row['id_pegawai']; ?>"><td><input type="checkbox" value="<?php echo $row['id_pegawai']; ?>" id="chkIdPegPilih[]" name="chkIdPegPilih[]" checked></td><td><?php echo $row['nip_baru']; ?></td><td><?php echo $row['nama']; ?></td></tr>
                                                <?php
                                                $i++;
                                            }
                                        } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row" style="margin-top: 15px;">
                                <div class="col-sm-12">
                                    Pegawai yang akan diusulkan berjumlah :
                                    <span id="jmlPesertaPlih" style="font-weight: bold"><?php echo @$update==1?$jmlP:'0'?></span> orang
                                    <input type="button" id="btnHapus" class="btn btn-danger" value="Hapus yang diceklis" />
                                </div>
                                <script>
                                    $("#checkAllPilih").change(function () {
                                        $("#div2 input:checkbox").prop('checked', $(this).prop("checked"));
                                    });
                                    $("#btnHapus").click(function () {
                                        var checkboxes = $("#div2 input:checkbox");
                                        for (var i = 1; i < checkboxes.length; i++) {
                                            if(checkboxes[i].checked == true){
                                                var str = checkboxes[i].value;
                                                var res = str.split(":");
                                                var a = arrPilih.indexOf(res[0]);
                                                arrPilih.splice(a, 1);
                                                document.getElementById("jmlPesertaPlih").innerHTML = parseInt(document.getElementById('jmlPesertaPlih').innerHTML)-1;
                                                $('#rowTblPilih'+res[0]).remove();
                                                $( "#checkAllPilih" ).prop( "checked", false );
                                            }
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2">Upload Baru Berkas Usulan:</label>
                    <div class="row">
                        <div class="col-sm-4">
                            <input type="file" class="form-control-file" id="fileUsulan"
                                   name="fileUsulan" aria-describedby="fileHelp" accept=".pdf">
                            <small id="fileHelp" class="form-text text-muted">
                                Format file yang sudah ditandatangani harus bertipe pdf dengan ukuran maksimal 2 MB.
                            </small>
                        </div>
                        <div class="col-sm-5" style="border-left: 2px solid #268ac2">
                            <?php
                                if(@$linkBerkasUsulan <> ""){
                                    echo "Berkas usulan yang sudah masuk : $linkBerkasUsulan";
                                    echo "<small class=\"form-text text-muted\">";
                                    echo "<br>Tgl.Upload : ".$tglUpload." <br>Oleh : ".$pengUpload."</small>";
                                }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-sm-2" for="btnSubmit">&nbsp;</label>
                    <div class="col-sm-5">
                        <input id="issubmit" name="issubmit" type="hidden" value="true" />
                        <button id="btnSubmit" type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
        <?php
            $sql = "SELECT a.*, p.nip_baru AS nip_approve, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                        p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_approve
                        FROM
                        (SELECT kd.id, DATE_FORMAT(kd.tgl_permintaan, '%d/%m/%Y') AS tgl_permintaan, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                        nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, dj.jenis_diklat,
                        kd.nama_diklat, bp.bidang, kd.jumlah_peserta, CASE WHEN DATE_FORMAT(kd.tgl_pelaksanaan, '%d/%m/%Y') IS NULL THEN '-' ELSE DATE_FORMAT(kd.tgl_pelaksanaan, '%d/%m/%Y') END AS tgl_pelaksanaan,
                        kd.idstatus_approve, kds.status_keb_diklat, DATE_FORMAT(kd.tgl_approve, '%d/%m/%Y %H:%m:%s') AS tgl_approve, kd.idpegawai_approve
                        FROM kebutuhan_diklat kd, bidang_pendidikan bp, pegawai p, kebutuhan_diklat_status kds, diklat_jenis dj
                        WHERE kd.idpegawai_pemohon = p.id_pegawai AND kd.id_bidang = bp.id AND kd.idstatus_approve = kds.idstatus_keb_diklat AND kd.id_unit_kerja = ".$_SESSION['id_skpd']." AND kd.id_jenis_diklat = dj.id_jenis_diklat) a
                        LEFT JOIN pegawai p ON a.idpegawai_approve = p.id_pegawai ORDER BY a.tgl_permintaan DESC, a.id DESC";
            $query_row = mysqli_query($mysqli,$sql);
            $i = 0;
        ?>
        <div role="tabpanel" class="tab-pane" id="list_keb_diklat">
            <table width="95%" border="0" align="center" style="border-radius:5px;"
                   class="table table-bordered table-hover table-striped">
                <thead>
                <tr>
                    <th width="5%">No.</th>
                    <th width="15%">Tgl.Permohonan</th>
                    <th width="30%">Nama Diklat</th>
                    <th width="10%">Jenis/Bidang</th>
                    <th width="5%">Jumlah</th>
                    <th width="10%">Tgl.Pelaksanaan</th>
                    <th width="25%">Status/Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php while($row = mysqli_fetch_array($query_row)){
                    if (isset($txtHapusKebDik_[$i]) and $txtHapusKebDik_[$i] = "Hapus") {
                        $sqlDelete = "delete from kebutuhan_diklat where id=".$row['id'];
                        if (mysqli_query($mysqli,$sqlDelete) == TRUE) {
                            $sqlDelete = "delete from kebutuhan_diklat_detail where id_keb_diklat=".$row['id'];
                            if (mysqli_query($mysqli,$sqlDelete) == TRUE) {
                                echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Permohonan Diklat Berhasil Dihapus </div>");
                                $url = "/simpeg/index3.php?x=request_diklat.php";
                                echo("<script type=\"text/javascript\">location.href='/simpeg/index3.php?x=request_diklat.php';</script>");
                            }else{
                                echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menghapus data" . "<br>" . $conn->error . "</div>");
                            }

                        }else{
                            echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Error: Tidak dapat menghapus data" . "<br>" . $conn->error . "</div>");
                        }
                    }
                    ?>
                    <tr>
                        <td><?php echo $i+1; ?>.</td>
                        <td><?php echo $row['tgl_permintaan']; ?><br><i>Oleh: <?php echo $row['nama']; ?></i></td>
                        <td><span style="color: #66512c; font-weight: bold;"><?php echo $row['nama_diklat']; ?></span></td>
                        <td><?php echo $row['jenis_diklat']." / ".$row['bidang']; ?></td>
                        <td><?php echo $row['jumlah_peserta']; ?> org</td>
                        <td><?php echo $row['tgl_pelaksanaan']; ?></td>
                        <?php
                        if($row['idstatus_approve']==1) {
                            $cls = 'class="label label-default"';
                        }elseif($row['idstatus_approve']==2) {
                            $cls = 'class="label label-success"';
                        }else{
                            $cls = 'class="label label-danger"';
                        }
                        ?>
                        <td><span <?php echo $cls?>><?php echo $row['status_keb_diklat']; ?></span><br>
                            <button id="btnCekPeserta<?php echo $row['id']; ?>" type="button" class="btn btn-primary btn-xs"
                                    data-placement="bottom" title="Cek Calon Peserta" style="margin-top: 10px;">
                                <span class="glyphicon glyphicon-zoom-in"></span> Lihat Peserta</button>

                            <script type="text/javascript">
                                $("#btnCekPeserta<?php echo $row['id']; ?>").click(function () {
                                    loadPesertaWindow('modPesertaWindow<?php echo $row['id']; ?>','divPesertaWin<?php echo $row['id']; ?>','<?php echo $row['id']; ?>');
                                });
                            </script>

                            <div class="modal fade" id="modPesertaWindow<?php echo $row['id']; ?>" role="dialog">
                                <div class="modal-dialog modal-lg" style="max-height: 400px; width: 700px;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title" style="border: 0px;">Daftar Calon Peserta Diklat</h4>
                                        </div>
                                        <div class="modal-body" style="height: 400px; width: 100%; overflow-y: scroll;">
                                            <div id="divPesertaWin<?php echo $row['id']; ?>" style="margin-top: -10px;"></div>
                                        </div>
                                        <div class="modal-footer">
                                            <button id="btnClose<?php echo $row['id']; ?>" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            if($row['idstatus_approve'] != 1){ ?>
                                <br><i>Oleh: <?php echo $row['nama_approve']; ?> (<?php echo $row['tgl_approve']; ?> )</i>
                            <?php }else{ ?>
                                <form action="index3.php?x=request_diklat.php" method="post" enctype="multipart/form-data" name="frmHpsDiklat" id="frmHpsDiklat" style="margin-top: 5px;">
                                    <input type="button" name="btnUbahKebDiklat_<?php echo $row['id']; ?>" id="btnUbahKebDiklat_<?php echo $row['id']; ?>" class="btn btn-primary btn-xs" value="Ubah" onclick="update(<?php echo $row['id']; ?>)" />
                                    <input type="hidden" id="txtHapusKebDik_[<?php echo $i; ?>]" name="txtHapusKebDik_[<?php echo $i; ?>]" value="Hapus"/>
                                    <input type="button" name="btnHapusKebDik_[<?php echo $i; ?>]" id="btnHapusKebDik_[<?php echo $i; ?>]" onclick="delete_data()" class="btn btn-warning btn-xs" value="Hapus" />
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function update(cm) {
        //var cm = document.getElementById('cm').value;
        location.href="index3.php?x=request_diklat.php&update=1&idkebd="+cm;
    }

    function delete_data() {
        var del = confirm("Anda yakin ingin menghapus data ini?");
        if(del == true){
            document.getElementById("frmHpsDiklat").submit();
        }else{
            return false;
        }
    }

    $(function () {
        $('#datetimepicker').datetimepicker({
            format: 'DD-MM-YYYY',
            ignoreReadonly: true
        });
    });

    var fileUsulanSize = 0;
    $('#fileUsulan').bind('change', function() {
        fileUsulanSize = this.files[0].size;
    });

    $("#frmReqDiklat").bootstrapValidator({
        message: "This value is not valid",
        excluded: ':disabled',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nmDiklat: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            },
            jmlPeserta: {
                feedbackIcons: "false",
                validators: {
                    notEmpty: {message: "*"},
                    integer: {
                        message: '*'
                    }
                }
            }
        }
    }).on("error.field.bv", function (b, a) {
        a.element.data("bv.messages").find('.help-block[data-bv-for="' + a.field + '"]').hide()
    }).on('success.form.bv', function(e) {
        var checkboxes = $("#div2 input:checkbox");
        var jmlCheck = 0;
        for (var i = 1; i < checkboxes.length; i++) {
            if(checkboxes[i].checked == true){
                jmlCheck++;
            }
        }
        $jmlPeserta = $( "#jmlPeserta option:selected" ).val();

        if(jmlCheck < parseInt($jmlPeserta)){
            alert('Peserta yang akan diusulkan harus dipilih dari daftar pegawai dan diceklis sesuai jumlah peserta');
            var $form = $(e.target);
            $form.bootstrapValidator('disableSubmitButtons', false);
            return false;
        }

        if(parseFloat(fileUsulanSize) > 2138471) {
            //alert(fileUsulanSize);
            alert('Ukuran file terlalu besar');
            var $form = $(e.target);
            $form.bootstrapValidator('disableSubmitButtons', false);
            return false;
        }

    });

    function loadPesertaWindow($modal, $winupload, $id){
        var request = $.get("request_diklat_calon.php?id="+$id);
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
                $("#"+$winupload).html(response);
            }
        );
        $("#"+$modal).modal('show');
    }
</script>