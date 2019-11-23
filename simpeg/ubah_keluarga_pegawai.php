<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <script src="js/moment.js"></script>
    <script src="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
</head>

<body>
<?php
    session_start();
    extract($_POST);
    extract($_GET);
    include("konek.php");
    $isAdd = false;
    if($_GET['idkel'] == -1){
        $isAdd = true;
    }else{
        $isAdd = false;
        $sql = "SELECT k.id_keluarga, k.id_status, k.nama, k.tempat_lahir,
                DATE_FORMAT(k.tgl_lahir, '%d-%m-%Y') AS tgl_lahir, k.akte_kelahiran, DATE_FORMAT(k.tgl_akte_kelahiran, '%d-%m-%Y') AS tgl_akte_kelahiran,
                DATE_FORMAT(k.tgl_menikah, '%d-%m-%Y') AS tgl_menikah, k.akte_menikah, DATE_FORMAT(k.tgl_akte_menikah, '%d-%m-%Y') AS tgl_akte_menikah,
                DATE_FORMAT(k.tgl_meninggal, '%d-%m-%Y') AS tgl_meninggal, k.akte_meninggal, DATE_FORMAT(k.tgl_akte_meninggal, '%d-%m-%Y') AS tgl_akte_meninggal,
                DATE_FORMAT(k.tgl_cerai, '%d-%m-%Y') AS tgl_cerai, k.akte_cerai, DATE_FORMAT(k.tgl_akte_cerai, '%d-%m-%Y') AS tgl_akte_cerai,
                k.no_karsus, k.pekerjaan, k.jk, k.dapat_tunjangan, k.nik, k.kuliah,
                DATE_FORMAT(k.tgl_lulus, '%d-%m-%Y') AS tgl_lulus, k.no_ijazah, k.nama_sekolah, k.sudah_bekerja, k.nama_perusahaan, k.akte_kerja
                FROM keluarga k WHERE k.id_keluarga = ".$_GET['idkel'];
        $query = $mysqli->query($sql);
        if ($query->num_rows > 0) {
            while ($data = $query->fetch_array(MYSQLI_NUM)) {
                $idKel = $data[0];
                $stsKel = $data[1];
                $nama = $data[2];
                $tmptLahir = $data[3];
                $tglLahir = $data[4];
                $akteLahir = $data[5];
                $tglAkteLahir = $data[6];
                $tglNikah = $data[7];
                $akteNikah = $data[8];
                $tglAkteNikah = $data[9];
                $tglMeninggal = $data[10];
                $akteMeninggal = $data[11];
                $tglAkteMeninggal = $data[12];
                $tglCerai = $data[13];
                $akteCerai = $data[14];
                $tglAkteCerai = $data[15];
                $nokarsus = $data[16];
                $pekerjaan = $data[17];
                $jk = ($data[18]==''?1:$data[18]);
                $tunjskum = $data[19];
                $nik = $data[20];
                $kuliah = $data[21];
                $tglLulus = $data[22];
                $noijazah = $data[23];
                $institusipend = $data[24];
                $sudah_kerja = $data[25];
                $nmperusahaan = $data[26];
                $aktekerja = $data[27];
            }
        }else{
            $isAdd = true;
        }
    }

    if($isAdd==true){
        $idKel = -1;
        $stsKel = 9;
        $nama = '';
        $tmptLahir = '';
        $tglLahir = '';
        $akteLahir = '';
        $tglAkteLahir = '';
        $tglNikah = '';
        $akteNikah = '';
        $tglAkteNikah = '';
        $tglMeninggal = '';
        $akteMeninggal = '';
        $tglAkteMeninggal = '';
        $tglCerai = '';
        $akteCerai = '';
        $tglAkteCerai = '';
        $nokarsus = '';
        $pekerjaan = '';
        $jk = 1;
        $tunjskum = 0;
        $nik = '';
        $kuliah = 0;
        $tglLulus = '';
        $noijazah = '';
        $institusipend = '';
        $sudah_kerja = 0;
        $nmperusahaan = '';
        $aktekerja = '';
    }
?>
<form role="form" class="form-horizontal" action="index3.php?x=ptk.php&od=<?php echo $_GET['od']; ?>" method="post"
      enctype="multipart/form-data" name="frmUbahKeluarga" id="frmUbahKeluarga">
    <div class="row" style="margin: 10px;margin-top: -10px;">
        <div role="tabpanel">
            <ul class="nav nav-tabs" role="tablist" id="myTab_PTK">
                <li role="presentation" class="active"><a href="#biodata" aria-controls="biodata" role="tab" data-toggle="tab">Biodata</a></li>
                <li role="presentation"><a href="#kematian" aria-controls="kematian" role="tab" data-toggle="tab">Kelahiran / Kematian</a></li>
                <li role="presentation"><a href="#nikah_cerai" aria-controls="nikah_cerai" role="tab" data-toggle="tab">Pernikahan / Cerai</a></li>
                <li role="presentation"><a href="#sekolah" aria-controls="sekolah" role="tab" data-toggle="tab">Perguruan Tinggi</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="biodata">
                    <div class="row" style="margin: 5px;margin-top: 15px;">
                        <div class="col-lg-3">
                            <input type="hidden" id="idkeluarga" name="idkeluarga" value="<?php echo $idKel; ?>"/>
                            <input type="hidden" id="isAdd" name="isAdd" value="<?php echo $isAdd; ?>"/>
                            <div class="form-group">
                                <label for="optStatusKel">Status Keluarga</label>
                                <select id='optStatusKel' name='optStatusKel' class="form-control">
                                    <?php
                                        $sql = "SELECT * FROM status_kel";
                                        $query = $mysqli->query($sql);
                                        while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                                            echo("<option value=$oto[0]".($oto[0]==$stsKel?' selected':'').">$oto[1]</option>");
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="txtNama">Nama</label>
                                <input type="text" class="form-control" id="txtNama" name="txtNama" value="<?php echo $nama;?>">
                            </div>
                            <div class="form-group">
                                <label for="txtPekerjaan">Pekerjaan</label>
                                <input type="text" class="form-control" id="txtPekerjaan" name="txtPekerjaan" value="<?php echo $pekerjaan;?>">
                            </div>
                            <div class="form-group">
                                <label for="optJk">Jenis Kelamin</label><br>
                                <div class="col-lg-1" style="width: 50%;margin-left: -15px;">
                                    <div class="radio">
                                        <label><input type="radio" name="optJk" value="1" <?php echo($jk==1?' checked':'') ?>>Laki-laki</label>
                                    </div>
                                </div>
                                <div class="col-lg-1">
                                    <div class="radio">
                                        <label><input type="radio" name="optJk" value="2" <?php echo($jk==2?' checked':'') ?>>Perempuan</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="txtNik">NIK</label>
                                <input type="text" class="form-control" id="txtNik" name="txtNik" value="<?php echo $nik;?>">
                            </div>
                            <div class="form-group">
                                <label for="txtNoKarisu">No. Karis/Karsu</label>
                                <input type="text" class="form-control" id="txtNoKarisu" name="txtNoKarisu" value="<?php echo $nokarsus?>">
                            </div>
                            <div class="form-group">
                                <label for="txtNik">Status Tunjangan</label>
                                <select id='optStatusTunj' name='optStatusTunj' class="form-control">
                                    <option value='1' <?php echo($tunjskum==1?' selected':''); ?>>Tunjangan Dapat</option>
                                    <option value='0' <?php echo($tunjskum==0?' selected':''); ?>>Tunjangan Tidak Dapat</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-3">
                            <div id="divStsPenghasilan">
                                <div class="form-group">
                                    <label for="optStatusPenghasilan">Status Penghasilan</label>
                                    <select id='optStatusPenghasilan' name='optStatusPenghasilan' class="form-control">
                                        <option value='0' <?php echo($sudah_kerja==0?' selected':''); ?>>Belum Berpenghasilan</option>
                                        <option value='1' <?php echo($sudah_kerja==1?' selected':''); ?>>Sudah Berpenghasilan</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="txtNamaPerusahaan">Perusahaan Tempat Kerja</label>
                                    <input type="text" class="form-control" id="txtNamaPerusahaan" name="txtNamaPerusahaan"
                                           value="<?php echo $nmperusahaan;?>">
                                </div>
                                <div class="form-group">
                                    <label for="txtNoAkteKerja">Nomor Akte Ket. Kerja</label>
                                    <input type="text" class="form-control" id="txtNoAkteKerja" name="txtNoAkteKerja"
                                           value="<?php echo $aktekerja;?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="nikah_cerai">
                    <div class="row" style="margin: 5px;margin-top: 15px;">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="optStatusNikah">Status Nikah</label>
                                <select id='optStatusNikah' name='optStatusNikah' class="form-control">
                                    <option value='1' <?php echo($tglNikah<>''?' selected':''); ?>>Menikah</option>
                                    <option value='0' <?php echo($tglNikah==''?' selected':''); ?>>Belum Menikah</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tglNikah">Tgl. Menikah</label>
                                <div class='input-group date' id='datetimepicker3'>
                                    <input type="text" class="form-control" id="tglNikah" name="tglNikah" value="<?php echo $tglNikah; ?>" readonly="readonly">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtNoAkteNikah">Nomor Akte Menikah</label>
                                <input type="text" class="form-control" id="txtNoAkteNikah" name="txtNoAkteNikah" value="<?php echo $akteNikah; ?>">
                            </div>
                            <div class="form-group">
                                <label for="tglNikahAkte">Tgl. Akte Menikah</label>
                                <div class='input-group date' id='datetimepicker4'>
                                    <input type="text" class="form-control" id="tglNikahAkte" name="tglNikahAkte" value="<?php echo $tglAkteNikah; ?>" readonly="readonly">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="optStatusCerai">Status Cerai</label>
                                <select id='optStatusCerai' name='optStatusCerai' class="form-control">
                                    <option value='1' <?php echo($tglCerai<>''?' selected':''); ?>>Cerai</option>
                                    <option value='0' <?php echo($tglCerai==''?' selected':''); ?>>Tidak Cerai</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tglCerai">Tgl. Cerai</label>
                                <div class='input-group date' id='datetimepicker5'>
                                    <input type="text" class="form-control" id="tglCerai" name="tglCerai" value="<?php echo $tglCerai; ?>" readonly="readonly">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtNoAkteCerai">Nomor Akte Cerai</label>
                                <input type="text" class="form-control" id="txtNoAkteCerai" name="txtNoAkteCerai" value="<?php echo $akteCerai; ?>">
                            </div>
                            <div class="form-group">
                                <label for="tglCeraiAkte">Tgl. Akte Cerai</label>
                                <div class='input-group date' id='datetimepicker6'>
                                    <input type="text" class="form-control" id="tglCeraiAkte" name="tglCeraiAkte" value="<?php echo $tglAkteCerai; ?>" readonly="readonly">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="sekolah">
                    <div class="row" style="margin: 5px;margin-top: 15px;">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="optStatusKuliah">Status Kuliah</label>
                                <select id='optStatusKuliah' name='optStatusKuliah' class="form-control">
                                    <option value='1' <?php echo($kuliah=='1'?' selected':''); ?>>Kuliah</option>
                                    <option value='0' <?php echo(($kuliah=='0' or $kuliah=='')?' selected':''); ?>>Tidak Kuliah</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tglLulus">Tgl. Lulus</label>
                                <div class='input-group date' id='datetimepicker7'>
                                    <input type="text" class="form-control" id="tglLulus" name="tglLulus" value="<?php echo $tglLulus; ?>" readonly="readonly">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtNoIjazah">Nomor Ijazah</label>
                                <input type="text" class="form-control" id="txtNoIjazah" name="txtNoIjazah" value="<?php echo $noijazah; ?>">
                            </div>
                            <div class="form-group">
                                <label for="txtInstitusi">Institusi Pendidikan</label>
                                <input type="text" class="form-control" id="txtInstitusi" name="txtInstitusi" value="<?php echo $institusipend; ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="kematian">
                    <div class="row" style="margin: 5px;margin-top: 15px;">
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="txtTempatLahir">Tempat Lahir</label>
                                <input type="text" class="form-control" id="txtTempatLahir" name="txtTempatLahir" value="<?php echo $tmptLahir; ?>">
                            </div>
                            <div class="form-group">
                                <label for="tglLahir">Tgl. Lahir</label>
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type="text" class="form-control" id="tglLahir" name="tglLahir" value="<?php echo $tglLahir; ?>" readonly="readonly">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtNoAkteLahir">Nomor Akte Kelahiran</label>
                                <input type="text" class="form-control" id="txtNoAkteLahir" name="txtNoAkteLahir" value="<?php echo $akteLahir; ?>">
                            </div>
                            <div class="form-group">
                                <label for="tglLahirAkte">Tgl. Akte Kelahiran</label>
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type="text" class="form-control" id="tglLahirAkte" name="tglLahirAkte" value="<?php echo $tglAkteLahir; ?>" readonly="readonly">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-1"></div>
                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="optStatusDie">Status Kematian</label>
                                <select id='optStatusDie' name='optStatusDie' class="form-control">
                                    <option value='1' <?php echo($tglMeninggal<>''?' selected':''); ?>>Meninggal</option>
                                    <option value='0' <?php echo($tglMeninggal==''?' selected':''); ?>>Belum Meninggal</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="tglDie">Tgl. Kematian</label>
                                <div class='input-group date' id='datetimepicker8'>
                                    <input type="text" class="form-control" id="tglDie" name="tglDie" value="<?php echo $tglMeninggal; ?>" readonly="readonly">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="txtNoAkteDie">Nomor Akte Kematian</label>
                                <input type="text" class="form-control" id="txtNoAkteDie" name="txtNoAkteDie" value="<?php echo $akteMeninggal; ?>">
                            </div>
                            <div class="form-group">
                                <label for="tglDieAkte">Tgl. Akte Kematian</label>
                                <div class='input-group date' id='datetimepicker9'>
                                    <input type="text" class="form-control" id="tglDieAkte" name="tglDieAkte" value="<?php echo $tglAkteMeninggal; ?>" readonly="readonly">
                                    <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-8" style="margin-left: -10px;">
                <input type="submit" name="btnUbahKeluarga" id="btnUbahKeluarga" class="btn btn-success" value="Simpan" />
                <?php if($isAdd==false): ?>
                    <input type="button" name="btnHapusKeluarga" id="btnHapusKeluarga" class="btn btn-danger" value="Hapus" onclick="hapusDataKeluarga()" />
                <?php endif; ?>
                <button id="btnClose" type="button" class="btn btn-default" data-dismiss="modal">Batal</button><br>
                * <span style="font-style: italic;">Pastikan semua kolom yang diperlukan terisi (Periksa Semua Tab)</span>
            </div>

        </div>
    </div>
</form>
</body>
</html>

<script>
    $(function () {
        checkOption('optStatusKel','');
        checkOption('optStatusNikah','datetimepicker3');
        checkOption('optStatusNikah','datetimepicker4');
        checkOption('optStatusCerai','datetimepicker5');
        checkOption('optStatusCerai','datetimepicker6');
        checkOption('optStatusKuliah','datetimepicker7');
        checkOption('optStatusDie','datetimepicker8');
        checkOption('optStatusDie','datetimepicker9');
    });

    $(function (){
        $('#datetimepicker1').datetimepicker({
            format: 'DD-MM-YYYY',
            ignoreReadonly: true
        }).on('dp.change', function(e) {
            revalidasi('tglLahir');
        });
    });

    $(function (){
        $('#datetimepicker2').datetimepicker({
            format: 'DD-MM-YYYY',
            ignoreReadonly: true
        }).on('dp.change', function(e) {
            revalidasi('tglLahirAkte');
        });
    });

    $(function (){
        $('#datetimepicker3').datetimepicker({
            format: 'DD-MM-YYYY',
            ignoreReadonly: true
        }).on('dp.change', function(e) {
            revalidasi('tglNikah');
        });
    });

    $(function (){
        $('#datetimepicker4').datetimepicker({
            format: 'DD-MM-YYYY',
            ignoreReadonly: true
        }).on('dp.change', function(e) {
            revalidasi('tglNikahAkte');
        });
    });

    $(function (){
        $('#datetimepicker5').datetimepicker({
            format: 'DD-MM-YYYY',
            ignoreReadonly: true
        }).on('dp.change', function(e) {
            revalidasi('tglCerai');
        });
    });

    $(function (){
        $('#datetimepicker6').datetimepicker({
            format: 'DD-MM-YYYY',
            ignoreReadonly: true
        }).on('dp.change', function(e) {
            revalidasi('tglCeraiAkte');
        });
    });

    $(function (){
        $('#datetimepicker7').datetimepicker({
            format: 'DD-MM-YYYY',
            ignoreReadonly: true
        });
    });

    $(function (){
        $('#datetimepicker8').datetimepicker({
            format: 'DD-MM-YYYY',
            ignoreReadonly: true
        }).on('dp.change', function(e) {
            revalidasi('tglDie');
        });
    });

    $(function (){
        $('#datetimepicker9').datetimepicker({
            format: 'DD-MM-YYYY',
            ignoreReadonly: true
        }).on('dp.change', function(e) {
            revalidasi('tglDieAkte');
        });
    });

    function hapusDataKeluarga(){
        var r = confirm("Anda yakin akan menghapus data?");
        if (r == true) {
            var idkel = $("#idkeluarga").val();
            $.ajax({
                method: "POST",
                url: "hapus_keluarga_pegawai.php",
                data: { idkel: idkel },
                dataType: "html"
            }).done(function( data ) {
                $("#divInfo").html(data);
                $("#divInfo").find("script").each(function(i) {
                    //eval($(this).text());
                });
            });
        }
    }

    function revalidasi(textInput){
        $('#frmUbahKeluarga').data('bootstrapValidator').revalidateField(textInput);
    }

    document.getElementById("optStatusKel").onchange = function () {
        checkOption('optStatusKel','');
    };

    document.getElementById("optStatusPenghasilan").onchange = function () {
        checkOption('optStatusPenghasilan','');
    }

    document.getElementById("optStatusNikah").onchange = function () {
        checkOption('optStatusNikah','datetimepicker3');
        checkOption('optStatusNikah','datetimepicker4');
    };

    document.getElementById("optStatusCerai").onchange = function () {
        checkOption('optStatusCerai','datetimepicker5');
        checkOption('optStatusCerai','datetimepicker6');
    };

    document.getElementById("optStatusKuliah").onchange = function () {
        checkOption('optStatusKuliah','datetimepicker7');
    };

    document.getElementById("optStatusDie").onchange = function () {
        checkOption('optStatusDie','datetimepicker8');
        checkOption('optStatusDie','datetimepicker9');
    };

    function checkOption(textOption, datepicker){
        var status = $("#"+textOption).val();
        if(status==0){
            if(textOption=='optStatusNikah'){
                $("#tglNikah").val("");
                $("#txtNoAkteNikah").val("");
                $("#txtNoAkteNikah").prop('disabled',true);
                $("#tglNikahAkte").val("");
            }else if(textOption=='optStatusCerai'){
                $("#tglCerai").val("");
                $("#txtNoAkteCerai").val("");
                $("#txtNoAkteCerai").prop('disabled',true);
                $("#tglCeraiAkte").val("");
            }else if(textOption=='optStatusKuliah'){
                $("#tglLulus").val("");
                $("#txtNoIjazah").val("");
                $("#txtNoIjazah").prop('disabled',true);
                $("#txtInstitusi").val("");
                $("#txtInstitusi").prop('disabled',true);
            }else if(textOption=='optStatusDie'){
                $("#tglDie").val("");
                $("#txtNoAkteDie").val("");
                $("#txtNoAkteDie").prop('disabled',true);
                $("#tglDieAkte").val("");
            }else if(textOption=='optStatusPenghasilan'){
                $("#txtNamaPerusahaan").val("");
                $("#txtNamaPerusahaan").prop('disabled',true);
                $("#txtNoAkteKerja").val("");
                $("#txtNoAkteKerja").prop('disabled',true);
            }
            if(datepicker!=''){
                $('#'+datepicker +' > .form-control').prop('disabled', true);
            }
        }else{
            if(datepicker!=''){
                $('#'+datepicker+' > .form-control').prop('disabled', false);
            }
            if(textOption=='optStatusNikah'){
                $("#txtNoAkteNikah").prop('disabled',false);
            }else if(textOption=='optStatusCerai'){
                $("#txtNoAkteCerai").prop('disabled',false);
            }else if(textOption=='optStatusKuliah'){
                $("#txtNoIjazah").prop('disabled',false);
                $("#txtInstitusi").prop('disabled',false);
            }else if(textOption=='optStatusDie'){
                $("#txtNoAkteDie").prop('disabled',false);
            }else if(textOption=='optStatusKel'){
                if(status==10){
                    $("#divStsPenghasilan").show();
                    if($("#optStatusPenghasilan").val()==1){
                        $("#txtNamaPerusahaan").prop('disabled',false);
                        $("#txtNoAkteKerja").prop('disabled',false);
                    }else{
                        $("#txtNamaPerusahaan").val("");
                        $("#txtNamaPerusahaan").prop('disabled',true);
                        $("#txtNoAkteKerja").val("");
                        $("#txtNoAkteKerja").prop('disabled',true);
                    }
                }else{
                    $("#divStsPenghasilan").hide();
                    $("#txtNamaPerusahaan").val("");
                    $("#txtNamaPerusahaan").prop('disabled',true);
                    $("#txtNoAkteKerja").val("");
                    $("#txtNoAkteKerja").prop('disabled',true);
                }
            }else if(textOption=='optStatusPenghasilan'){
                $("#txtNamaPerusahaan").prop('disabled',false);
                $("#txtNoAkteKerja").prop('disabled',false);
            }
        }
    }

    $("#frmUbahKeluarga").bootstrapValidator({
        message: "This value is not valid",
        excluded: ':disabled',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            txtNama: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            },
            txtPekerjaan: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            },
            txtTempatLahir: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            },
            tglLahir: {
                feedbackIcons: "false",
                validators: {
                    notEmpty: {message: "*"},
                    date: {
                        format: 'DD-MM-YYYY',
                        message: '*'
                    }
                }
            },
            txtNoAkteLahir: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            },
            tglLahirAkte: {
                feedbackIcons: "false",
                validators: {
                    notEmpty: {message: "*"},
                    date: {
                        format: 'DD-MM-YYYY',
                        message: '*'
                    }
                }
            },
            txtNik: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            },
            txtNoKarisu: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            },
            tglNikah: {
                feedbackIcons: "false",
                validators: {
                    notEmpty: {message: "*"},
                    date: {
                        format: 'DD-MM-YYYY',
                        message: '*'
                    }
                }
            },
            txtNoAkteNikah: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            },
            tglNikahAkte: {
                feedbackIcons: "false",
                validators: {
                    notEmpty: {message: "*"},
                    date: {
                        format: 'DD-MM-YYYY',
                        message: '*'
                    }
                }
            },
            tglCerai: {
                feedbackIcons: "false",
                validators: {
                    notEmpty: {message: "*"},
                    date: {
                        format: 'DD-MM-YYYY',
                        message: '*'
                    }
                }
            },
            txtNoAkteCerai: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            },
            tglCeraiAkte: {
                feedbackIcons: "false",
                validators: {
                    notEmpty: {message: "*"},
                    date: {
                        format: 'DD-MM-YYYY',
                        message: '*'
                    }
                }
            },
            txtInstitusi: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            },
            tglDie: {
                feedbackIcons: "false",
                validators: {
                    notEmpty: {message: "*"},
                    date: {
                        format: 'DD-MM-YYYY',
                        message: '*'
                    }
                }
            },
            txtNoAkteDie: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            },
            tglDieAkte: {
                feedbackIcons: "false",
                validators: {
                    notEmpty: {message: "*"},
                    date: {
                        format: 'DD-MM-YYYY',
                        message: '*'
                    }
                }
            },
            txtNamaPerusahaan: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            },
            txtNoAkteKerja: {
                feedbackIcons: "false",
                validators: {notEmpty: {message: "*"}}
            }
        }
    }).on('change', '[name="optStatusNikah"]', function() {
        $('#frmUbahKeluarga').bootstrapValidator('revalidateField', 'tglNikah');
        $('#frmUbahKeluarga').bootstrapValidator('revalidateField', 'txtNoAkteNikah');
        $('#frmUbahKeluarga').bootstrapValidator('revalidateField', 'tglNikahAkte');
        $("#frmUbahKeluarga").bootstrapValidator('disableSubmitButtons', false);
    }).on('change', '[name="optStatusCerai"]', function() {
        $('#frmUbahKeluarga').bootstrapValidator('revalidateField', 'tglCerai');
        $('#frmUbahKeluarga').bootstrapValidator('revalidateField', 'txtNoAkteCerai');
        $('#frmUbahKeluarga').bootstrapValidator('revalidateField', 'tglCeraiAkte');
        $("#frmUbahKeluarga").bootstrapValidator('disableSubmitButtons', false);
    }).on('change', '[name="optStatusKuliah"]', function() {
        $('#frmUbahKeluarga').bootstrapValidator('revalidateField', 'txtInstitusi');
        $("#frmUbahKeluarga").bootstrapValidator('disableSubmitButtons', false);
    }).on('change', '[name="optStatusDie"]', function() {
        $('#frmUbahKeluarga').bootstrapValidator('revalidateField', 'tglDie');
        $('#frmUbahKeluarga').bootstrapValidator('revalidateField', 'txtNoAkteDie');
        $('#frmUbahKeluarga').bootstrapValidator('revalidateField', 'tglDieAkte');
        $("#frmUbahKeluarga").bootstrapValidator('disableSubmitButtons', false);
    }).on('change', '[name="optStatusPenghasilan"]', function() {
        $('#frmUbahKeluarga').bootstrapValidator('revalidateField', 'txtNamaPerusahaan');
        $('#frmUbahKeluarga').bootstrapValidator('revalidateField', 'txtNoAkteKerja');
        $("#frmUbahKeluarga").bootstrapValidator('disableSubmitButtons', false);
    }).on("error.field.bv", function (b, a) {
        a.element.data("bv.messages").find('.help-block[data-bv-for="' + a.field + '"]').hide()
    }).on('success.form.bv', function(e) {

    });

</script>