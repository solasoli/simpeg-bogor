<?php
session_start();
include "konek.php";
include "paginator.class.php";
include 'class/cls_cuti.php';
$tim_opd = $mysqli->query("select * from user_roles where role_id = 2");
$idpAdmin = '';
while($row = $tim_opd->fetch_array(MYSQLI_NUM)){
    $tim[] = $row[0];
    if($row[0] == $_SESSION['id_pegawai']){
        $idpAdmin = $row[0];
    }
}
if(in_array($_SESSION['id_pegawai'],$tim)){
    $is_tim = 'TRUE';
}else{
    $is_tim = 'FALSE';
}
?><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
    <script src="js/moment.js"></script>
    <script src="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.0/jquery-confirm.min.js"></script>

    <style>
        table#tbl_form {
            margin-top: 5px;
            width: 100%;
            /*border: 2px solid black;
            background-color: #f1f1c1;*/
        }
        table#tbl_form tr {
            background-color: #fff;
            text-align: left;
            /*border: 1px solid black;*/
        }
        table#tbl_form td {
            padding: 5px;
        }

        .fileUpload {
            position: relative;
            overflow: hidden;
            margin: 10px;
        }

        .fileUpload input.upload {
            position: absolute;
            top: 0;
            right: 0;
            margin: 0;
            padding: 0;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            filter: alpha(opacity=0);
        }
    </style>
    <script>
        function addTanggalBaru(x, x2, idcm){
            if(x2==1){
                var txtElemen = 'txtTmtMulaiPenangguhanAtsl'+idcm;
                var txtElemen2 = 'txtTmtSelesaiPenangguhanAtsl'+idcm;
            }else{
                var txtElemen = 'txtTmtMulaiPenangguhanPjbt'+idcm;
                var txtElemen2 = 'txtTmtSelesaiPenangguhanPjbt'+idcm;
            }
            var awal = document.getElementById(txtElemen).value;
            //console.log(txtElemen);
            var startDate = new Date(awal.substr(3,2)+"/"+awal.substr(0,2)+"/"+awal.substr(6,4));
            Date.prototype.addDays = function(days) {
                var jmlHari = parseInt(days);
                if(jmlHari>0){
                    for (i = 1; i <= jmlHari; i++) {
                        var tomorrow = new Date(startDate);
                        tomorrow.setDate(startDate.getDate()+parseInt(i)-1);
                    }
                    var day = tomorrow.getDate();
                    var monthIndex = tomorrow.getMonth()+1;
                    var year = tomorrow.getFullYear();
                    var tgl = day.toString();
                    var bln = monthIndex.toString();
                    if(tgl.length==1){
                        tgl = "0" + tgl;
                    }
                    if(bln.length==1){
                        bln = "0" + bln;
                    }
                    var tomorrow_new = tgl+"-"+bln+"-"+year.toString();
                    //console.log(tomorrow_new);
                    $('#'+txtElemen2).val(tomorrow_new);
                }
            }
            var curDate = startDate;
            curDate.addDays(x);
        }

        function incDate(x,idcm){
            if(x==1){
                var lama_penangguhan = document.getElementById('txtLamaPenangguhanAtsl'+idcm).value;
            }else{
                var lama_penangguhan = document.getElementById('txtLamaPenangguhanPjbt'+idcm).value;
            }
            if(isNaN(parseInt(lama_penangguhan)) == true){
                var lama_penangguhan = 1;
            }else{
                addTanggalBaru(lama_penangguhan, x, idcm);
            }
        }

        function checkOption(textOption, divOption, idcm, x, ddSts, flag_uk){
            if(ddSts==0){
                var status = $("#"+textOption).val();
                if(status==3){
                    if(x==1){
                        $("#txtTmtMulaiPenangguhanAtsl"+idcm).prop('disabled',true); //false
                        $("#txtLamaPenangguhanAtsl"+idcm).prop('disabled',false);
                        $("#txtTmtSelesaiPenangguhanAtsl"+idcm).prop('disabled',false);
                        if(status==1){
                            $("#ddKepPjbt"+idcm).prop('disabled',false);
                            $("#cttn_keputusan"+idcm).prop('disabled',false);
                        }else{
                            $("#ddKepPjbt"+idcm).prop('disabled',true);
                            $("#cttn_keputusan"+idcm).prop('disabled',true);
                            $("#ddKepPjbt"+idcm).val("0");
                            $("#cttn_keputusan"+idcm).val("-");
                            $("#divStsPenangguhanPjbt"+idcm).hide();
                        }
                    }else{
                        $("#txtTmtMulaiPenangguhanPjbt"+idcm).prop('disabled',true); //false
                        $("#txtLamaPenangguhanPjbt"+idcm).prop('disabled',false);
                        $("#txtTmtSelesaiPenangguhanPjbt"+idcm).prop('disabled',false);
                    }
                    $("#"+divOption).show();
                }else{
                    if(x==1){
                        $("#txtLamaPenangguhanAtsl"+idcm).val("1");
                        $("#txtTmtMulaiPenangguhanAtsl"+idcm).prop('disabled',true);
                        $("#txtLamaPenangguhanAtsl"+idcm).prop('disabled',true);
                        $("#txtTmtSelesaiPenangguhanAtsl"+idcm).prop('disabled',true);
                        if(flag_uk==1){
                            if(status==1){
                                $("#ddKepPjbt"+idcm).prop('disabled',false);
                                $("#cttn_keputusan"+idcm).prop('disabled',false);
                            }else{
                                $("#ddKepPjbt"+idcm).prop('disabled',true);
                                $("#cttn_keputusan"+idcm).prop('disabled',true);
                                $("#ddKepPjbt"+idcm).val("0");
                                $("#cttn_keputusan"+idcm).val("-");
                                $("#divStsPenangguhanPjbt"+idcm).hide();
                            }
                        }
                    }else{
                        $("#txtLamaPenangguhanPjbt"+idcm).val("1");
                        $("#txtTmtMulaiPenangguhanPjbt"+idcm).prop('disabled',true);
                        $("#txtLamaPenangguhanPjbt"+idcm).prop('disabled',true);
                        $("#txtTmtSelesaiPenangguhanPjbt"+idcm).prop('disabled',true);
                    }
                    incDate(x,idcm);
                    $("#"+divOption).hide();
                }
            }else{
                if(ddSts==3){
                    $("#"+divOption).show();
                }else{
                    $("#"+divOption).hide();
                }
            }
        }

        function printSuratCutiTim(idcm, idp){
            window.open('/simpeg/cuti_surat_format_baru.php?idcm='+idcm+'&idp='+idp,'_blank');
        }

        function printSuratCuti(idcm){
            window.open('/simpeg/cuti_surat_format_baru.php?idcm='+idcm,'_blank');
        }

        function changeComboAtsl(idcm, flag_uk){
            checkOption('ddKepAtsl'+idcm,'divStsPenangguhanAtsl'+idcm,idcm,1,0,flag_uk);
        }

        function changeComboPjbt(idcm){
            checkOption('ddKepPjbt'+idcm,'divStsPenangguhanPjbt'+idcm,idcm,2,0,0);
        }

        function initTanggal(x,idcm){
            if(x==1){
                $('#datetimepicker'+idcm).datetimepicker({
                    format: 'DD-MM-YYYY',
                    ignoreReadonly: true
                }).on('dp.change', function(e) {
                    revalidasi('txtTmtMulaiPenangguhanAtsl', idcm);
                    incDate(x,idcm);
                });
            }else{
                $('#datetimepicker2'+idcm).datetimepicker({
                    format: 'DD-MM-YYYY',
                    ignoreReadonly: true
                }).on('dp.change', function(e) {
                    revalidasi('txtTmtMulaiPenangguhanPjbt', idcm);
                    incDate(x,idcm);
                });
            }

        }

        function revalidasi(textInput, idcm){
            $('#frmAjukanCuti'+idcm).data('bootstrapValidator').revalidateField(textInput);
        }

        function initValidasi(idp_pemohon, nip, flag_uk_atasan_sama, idcm, curpage, ipp){
            $("#frmAjukanCuti"+idcm).bootstrapValidator({
                message: "This value is not valid",
                excluded: ':disabled',
                feedbackIcons: {
                    valid: 'glyphicon glyphicon-ok',
                    invalid: 'glyphicon glyphicon-remove',
                    validating: 'glyphicon glyphicon-refresh'
                },
                fields: {
                    ddKepAtsl:{
                        selector: '#ddKepAtsl'+idcm,
                        feedbackIcons: "false",
                        validators: {
                            callback: {
                                message: '',
                                callback: function () {
                                    $("div.formdiv"+idcm).find(".help-block[data-bv-for=txtLamaPenangguhanAtsl]").hide();
                                    return true;
                                }
                            }
                        }
                    },
                    cttn_pertimbangan: {
                        selector: '#cttn_pertimbangan'+idcm,
                        feedbackIcons: "true",
                        validators: {notEmpty: {message: "Alasan atasan tidak boleh kosong"}}
                    },
                    txtTmtMulaiPenangguhanAtsl: {
                        selector: '#txtTmtMulaiPenangguhanAtsl'+idcm,
                        feedbackIcons: "false",
                        validators: {
                            notEmpty: {message: "TMT.Mulai penangguhan atasan langsung tidak boleh kosong"},
                            date: {
                                format: 'DD-MM-YYYY',
                                message: 'Salah format tanggal mulai penangguhan atasan langsung'
                            },
                            callback: {
                                message: 'TMT.Mulai penangguhan atasan langsung harus lebih dari tanggal hari ini',
                                callback: function(){
                                    var awal = document.getElementById('txtTmtMulaiPenangguhanAtsl'+idcm).value;
                                    var startDateN = new Date(awal.substr(3, 2) + "/" + awal.substr(0, 2) + "/" + awal.substr(6, 4));
                                    Date.prototype.addDays = function (days) {
                                        var dat = new Date(this.valueOf());
                                        dat.setDate(dat.getDate() + days);
                                        return dat;
                                    }
                                    var now = new Date();
                                    if (startDateN <= now.addDays(0)) {
                                        return false;
                                    }else{
                                        return true;
                                    }
                                }
                            }
                        }
                    },
                    txtLamaPenangguhanAtsl: {
                        selector: "#txtLamaPenangguhanAtsl"+idcm,
                        feedbackIcons: "false",
                        validators: {
                            integer: {
                                message: 'Lama penangguhan atasan langsung harus angka'
                            },
                            between: {
                                min: 1,
                                max: 1095,
                                message: 'Lama penangguhan atasan langsung antara 1 s.d. 1095'
                            },
                            notEmpty: {
                                message: "Lama penangguhan atasan langsung tidak boleh kosong"
                            }
                        }
                    },
                    ddKepPjbt:{
                        selector: '#ddKepPjbt'+idcm,
                        feedbackIcons: "false",
                        validators: {
                            callback: {
                                message: '',
                                callback: function () {
                                    $("div.formdiv"+idcm).find(".help-block[data-bv-for=txtLamaPenangguhanPjbt]").hide();
                                    return true;
                                }
                            }
                        }
                    },
                    cttn_keputusan: {
                        selector: '#cttn_keputusan'+idcm,
                        feedbackIcons: "true",
                        validators: {notEmpty: {message: "Alasan pejabat tidak boleh kosong"}}
                    },
                    txtTmtMulaiPenangguhanPjbt: {
                        selector: '#txtTmtMulaiPenangguhanPjbt'+idcm,
                        feedbackIcons: "false",
                        validators: {
                            notEmpty: {message: "TMT.Mulai penangguhan pejabat tidak boleh kosong"},
                            date: {
                                format: 'DD-MM-YYYY',
                                message: 'Salah format tanggal mulai penangguhan pejabat'
                            },
                            callback: {
                                message: 'TMT.Mulai penangguhan pejabat harus lebih dari tanggal hari ini',
                                callback: function(){
                                    var awal = document.getElementById('txtTmtMulaiPenangguhanPjbt'+idcm).value;
                                    var startDateN = new Date(awal.substr(3, 2) + "/" + awal.substr(0, 2) + "/" + awal.substr(6, 4));
                                    Date.prototype.addDays = function (days) {
                                        var dat = new Date(this.valueOf());
                                        dat.setDate(dat.getDate() + days);
                                        return dat;
                                    }
                                    var now = new Date();
                                    if (startDateN <= now.addDays(0)) {
                                        return false;
                                    }else{
                                        return true;
                                    }
                                }
                            }
                        }
                    },
                    txtLamaPenangguhanPjbt: {
                        selector: "#txtLamaPenangguhanPjbt"+idcm,
                        feedbackIcons: "false",
                        validators: {
                            integer: {
                                message: 'Lama penangguhan pejabat harus angka'
                            },
                            between: {
                                min: 1,
                                max: 1095,
                                message: 'Lama penangguhan pejabat antara 1 s.d. 1095'
                            },
                            notEmpty: {
                                message: "Lama penangguhan pejabat tidak boleh kosong"
                            }
                        }
                    },
                    txtKeterangan: {
                        selector: '#txtKeterangan'+idcm,
                        feedbackIcons: "true",
                        validators: {notEmpty: {message: "Keterangan tidak boleh kosong"}}
                    }
                }
            }).on('change', '[name="ddKepAtsl'+idcm+'"]', function() {
                $("#frmAjukanCuti"+idcm).bootstrapValidator('revalidateField', 'txtTmtMulaiPenangguhanAtsl');
                $("#frmAjukanCuti"+idcm).bootstrapValidator('revalidateField', 'txtLamaPenangguhanAtsl');
                $("#frmAjukanCuti"+idcm).bootstrapValidator('disableSubmitButtons', false);
            }).on('change', '[name="ddKepPjbt'+idcm+'"]', function() {
                $("#frmAjukanCuti"+idcm).bootstrapValidator('revalidateField', 'txtTmtMulaiPenangguhanPjbt');
                $("#frmAjukanCuti"+idcm).bootstrapValidator('revalidateField', 'txtLamaPenangguhanPjbt');
                $("#frmAjukanCuti"+idcm).bootstrapValidator('disableSubmitButtons', false);
            }).on("error.field.bv", function (b, a) {
                a.element.data("bv.messages").find('.help-block[data-bv-for="' + a.field + '"]').css("color", "red")
            }).on('status.field.bv', function(e, data) {
                //data.bv.disableSubmitButtons(false);
            }).on('success.form.bv', function(e) {
                e.preventDefault();
                if($('#uploadFileSuratCuti'+idcm).val().length==0){
                    alert('Harap lampirkan file surat permohonan cuti');
                    $("#frmAjukanCuti"+idcm).bootstrapValidator('disableSubmitButtons', false);
                }else{
                    var istim = '<?php echo $is_tim; ?>';
                    var data = new FormData();
                    var idKepAtsl = $('#ddKepAtsl'+idcm).val();
                    data.append('idKepAtsl', idKepAtsl);
                    var cttn_atsl = $('#cttn_pertimbangan'+idcm).val();
                    data.append('cttn_atsl', cttn_atsl);
                    if(idKepAtsl==3){
                        var tmtMulaiPenangguhanAtsl = $('#txtTmtMulaiPenangguhanAtsl'+idcm).val();
                        var lamaPengguhanAtsl = $('#txtLamaPenangguhanAtsl'+idcm).val();
                        var tmtSelesaiPenangguhanAtsl = $('#txtTmtSelesaiPenangguhanAtsl'+idcm).val();
                        data.append('tmtMulaiPenangguhanAtsl', tmtMulaiPenangguhanAtsl);
                        data.append('lamaPengguhanAtsl', lamaPengguhanAtsl);
                        data.append('tmtSelesaiPenangguhanAtsl', tmtSelesaiPenangguhanAtsl);
                    }
                    var idKepPjbt = $('#ddKepPjbt'+idcm).val();
                    data.append('idKepPjbt', idKepPjbt);
                    var cttn_pjbt = $('#cttn_keputusan'+idcm).val();
                    data.append('cttn_pjbt', cttn_pjbt);
                    if(idKepPjbt==3){
                        var tmtMulaiPenangguhanPjbt = $("#txtTmtMulaiPenangguhanPjbt"+idcm).val();
                        var lamaPengguhanPjbt = $('#txtLamaPenangguhanPjbt'+idcm).val();
                        var tmtSelesaiPenangguhanPjbt = $('#txtTmtSelesaiPenangguhanPjbt'+idcm).val();
                        data.append('tmtMulaiPenangguhanPjbt', tmtMulaiPenangguhanPjbt);
                        data.append('lamaPengguhanPjbt', lamaPengguhanPjbt);
                        data.append('tmtSelesaiPenangguhanPjbt', tmtSelesaiPenangguhanPjbt);
                    }
                    var txtKeterangan = $("#txtKeterangan"+idcm).val();
                    data.append('txtKeterangan', txtKeterangan);
                    jQuery.each(jQuery('#uploadFileSuratCuti'+idcm)[0].files, function (i, file) {
                        data.append('uploadFileSuratCuti', file);
                    });

                    if($('#uploadFileLainnya'+idcm).length>0){
                        if($('#uploadFileLainnya'+idcm).val().length==0) {
                            var cekLampiranLainnya = false;
                        }else{
                            var cekLampiranLainnya = true;
                            jQuery.each(jQuery('#uploadFileLainnya'+idcm)[0].files, function (i, file) {
                                data.append('uploadFileLainnya', file);
                                data.append('isLampiranLainnya', 1);
                            });
                        }
                    }else{
                        data.append('isLampiranLainnya', 0);
                        var cekLampiranLainnya = true;
                    }

                    if(flag_uk_atasan_sama==1){
                        if(idKepAtsl==1){
                            if(idKepAtsl==0 || idKepPjbt==0){
                                alert('Harap Tentukan Pertimbangan Atasan Langsung dan Keputusan Pejabat Berwenang');
                                var cekKepAtasan = false;
                            }else{
                                var cekKepAtasan = true;
                            }
                        }else{
                            if(idKepAtsl==0){
                                alert('Harap Tentukan Pertimbangan Atasan Langsung');
                                var cekKepAtasan = false;
                            }else{
                                var cekKepAtasan = true;
                            }
                        }
                    }else{
                        if(idKepAtsl==0){
                            alert('Harap Tentukan Pertimbangan Atasan Langsung');
                            var cekKepAtasan = false;
                        }else{
                            if(istim=='TRUE'){
                                if(idKepPjbt==0){
                                    var idpAdmin = "<?php echo $idpAdmin; ?>";
                                    if(idpAdmin==idp_pemohon){
                                        var cekKepAtasan = true;
                                    }else{
                                        var cekKepAtasan = false;
                                        alert('Harap Tentukan Keputusan Pejabat Berwenang');
                                    }
                                }else{
                                    var cekKepAtasan = true;
                                }
                            }else{
                                var cekKepAtasan = true;
                            }
                        }
                    }

                    if(cekKepAtasan){
                        if(cekLampiranLainnya){
                            $.confirm({
                                title: 'Informasi',
                                content: 'Anda yakin akan mengirim permohonan cuti ini?',
                                buttons: {
                                    cancel: {
                                        text: 'Tidak',
                                        action: function () {
                                            $("#frmAjukanCuti"+idcm).bootstrapValidator('disableSubmitButtons', false);
                                            return true;
                                        }
                                    },
                                    somethingElse: {
                                        text: 'Ya',
                                        btnClass: 'btn-blue',
                                        keys: ['enter', 'shift'],
                                        action: function(){
                                            $.alert({
                                                title: 'Informasi',
                                                content: function () {
                                                    var self = this;
                                                    data.append('idcm', idcm);
                                                    data.append('data_change', 'kirimCuti');
                                                    data.append('idpApprover', '<?php echo $_SESSION['id_pegawai'] ?>');
                                                    data.append('idp_pemohon', idp_pemohon);
                                                    data.append('idpAdmin', idpAdmin);
                                                    data.append('nip', nip);
                                                    data.append('flag_uk_atasan_sama', flag_uk_atasan_sama);
                                                    data.append('istim', istim);
                                                    return $.ajax({
                                                        url: "cuti_data_change.php",
                                                        data: data,
                                                        cache: false,
                                                        contentType: false,
                                                        processData: false,
                                                        method: 'POST',
                                                    }).done(function (response) {
                                                        self.setTitle('Informasi');
                                                        if(response == '1') {
                                                            self.setContent('Tipe file bukan PDF');
                                                        }else if(response == '2'){
                                                            self.setContent('Gagal Upload' + '<br>' +
                                                                'File tidak terupload. Ada permasalahan ketika mengakses jaringan');
                                                        }else if(response == '3'){
                                                            self.setContent('Data berkas tidak sukses tersimpan');
                                                        }else if(response == '4'){
                                                            self.setContent('Data tidak sukses tersimpan' + '<br>' +
                                                                'Pengubahan status data permohonan cuti tidak sukses tersimpan');
                                                        }else if(response == '5'){
                                                            self.setContent('Data sukses tersimpan' + '<br>' +
                                                                'Pengubahan status data permohonan cuti sukses tersimpan dan file terkirim');
                                                        }else if(response == '6'){
                                                            self.setContent('Lengkapi dahulu berkas persyaratan');
                                                        }else if(response == '7'){
                                                            self.setContent('Terdapat data yang tidak tersimpan atau ada persyaratan yang tidak terupload');
                                                        }else{
                                                            self.setContent("Gagal mengubah data <br> "+response);
                                                        }
                                                    }).fail(function(){
                                                        self.setContent('Error...telah terjadi kesalahan');
                                                    });
                                                },
                                                onContentReady: function () {},
                                                //columnClass: 'medium',
                                                buttons: {
                                                    refreshList: {
                                                        text: 'OK',
                                                        btnClass: 'btn-blue',
                                                        action: function () {
                                                            pagingViewListLoad(curpage, ipp);
                                                        }
                                                    },
                                                }
                                            });
                                        }
                                    }
                                }
                            });
                        }else{
                            alert('Harap lampirkan file persyaratan cuti lainnya');
                            $("#frmAjukanCuti" + idcm).bootstrapValidator('disableSubmitButtons', false);
                        }
                    }else{
                        $("#frmAjukanCuti"+idcm).bootstrapValidator('disableSubmitButtons', false);
                    }
                }
            });
        }

        function update(cm) {
            location.href="index3.php?x=cuti_format_baru.php&aktif=2&idcm="+cm;
        }

        function prosesHapus(idcm,curpage,ipp){
            $.confirm({
                title: 'Informasi',
                content: 'Anda yakin akan menghapus permohonan ini?',
                buttons: {
                    cancel: {
                        text: 'Tidak',
                        action: function () {}
                    },
                    somethingElse: {
                        text: 'Ya',
                        btnClass: 'btn-blue',
                        keys: ['enter', 'shift'],
                        action: function(){
                            //$.alert('Something else?');
                            $.alert({
                                title: 'Informasi',
                                content: function () {
                                    var self = this;
                                    var dataCuti = new FormData();
                                    dataCuti.append('idcm', idcm);
                                    dataCuti.append('data_change', 'hapusCuti');
                                    return $.ajax({
                                        url: "cuti_data_change.php",
                                        data: dataCuti,
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        method: 'POST',
                                    }).done(function (response) {
                                        self.setTitle('Informasi');
                                        console.log(response);
                                        if(response==1){
                                            self.setContent('Data sukses terhapus');
                                        }else{
                                            self.setContent('Data belum terhapus');
                                        }
                                        /*self.setContentAppend('<br>Version: ');*/
                                    }).fail(function(){
                                        self.setContent('Error...telah terjadi kesalahan');
                                    });
                                },
                                onContentReady: function () {},
                                //columnClass: 'medium',
                                buttons: {
                                    refreshList: {
                                        text: 'OK',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            pagingViewListLoad(curpage, ipp);
                                        }
                                    },
                                }
                            });
                        }
                    }
                }
            });
        }

        function prosesBatal(idcm,curpage,ipp){
            $.confirm({
                title: 'Informasi',
                content: 'Anda yakin akan membatalkan permohonan ini?',
                buttons: {
                    cancel: {
                        text: 'Tidak',
                        action: function () {}
                    },
                    somethingElse: {
                        text: 'Ya',
                        btnClass: 'btn-blue',
                        keys: ['enter', 'shift'],
                        action: function(){
                            $.alert({
                                title: 'Informasi',
                                content: function () {
                                    var self = this;
                                    var dataCuti = new FormData();
                                    var ket = $("#txtKeterangan"+idcm).val();
                                    dataCuti.append('idcm', idcm);
                                    dataCuti.append('data_change', 'batalCuti');
                                    dataCuti.append('keterangan', ket);
                                    dataCuti.append('idpApprover', '<?php echo $_SESSION['id_pegawai'] ?>');
                                    return $.ajax({
                                        url: "cuti_data_change.php",
                                        data: dataCuti,
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        method: 'POST',
                                    }).done(function (response) {
                                        self.setTitle('Informasi');
                                        console.log(response);
                                        if(response==1){
                                            self.setContent('Permohonan sukses dibatalkan');
                                        }else{
                                            self.setContent('Permohonan belum dibatalkan');
                                        }
                                        /*self.setContentAppend('<br>Version: ');*/
                                    }).fail(function(){
                                        self.setContent('Error...telah terjadi kesalahan');
                                    });
                                },
                                onContentReady: function () {},
                                //columnClass: 'medium',
                                buttons: {
                                    refreshList: {
                                        text: 'OK',
                                        btnClass: 'btn-blue',
                                        action: function () {
                                            pagingViewListLoad(curpage, ipp);
                                        }
                                    },
                                }
                            });
                        }
                    }
                }
            });
        }

    </script>
</head>



<div class="row" style="margin: 10px;">
    <?php
    $oCuti = new Cuti();
    $idp = $_POST['idp'];
    $txtKeyword = $_POST['txtKeyword'];
    $jenis = $_POST['jenis'];
    $status = $_POST['status'];

    $pages = new Paginator;
    $pagePaging = @$_POST['page'];
    if ($pagePaging == 0 or $pagePaging == "") {
        $pagePaging = 1;
    }

    $pages->setCustomeDefaultIpp(2);

    $ipp = @$_POST['ipp'];
    if ($ipp == "") {
        $ipp = 10;
    }
    $ipp = $pages->items_per_page;
    $jmlData = $oCuti->count_list_cuti($idp,$jenis,$status,$txtKeyword,$is_tim);

    if ($jmlData > 0) {
        $pages->items_total = $jmlData;
        $pages->paginate();
        $pgDisplay = $pages->display_pages();
        $itemPerPage = $pages->display_items_per_page();
        $curpage = $pages->current_page;
        $numpage = $pages->num_pages;
        $jumppage = $pages->display_jump_menu();
        $rowperpage = $pages->display_items_per_page();
    }else{
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
    //echo " ".$pages->limit;
    $query = $oCuti->view_list_cuti($idp,$jenis,$status,$txtKeyword,$is_tim,$pages->limit);
    $firstNum = explode(' ', $pages->limit);
    $firstNum = explode(',', @$firstNum[2]);

    if ($query->num_rows > 0) {
    if ($numpage > 0) {
        echo "<div class='row'><div class='col-sm-8'>Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage";
        echo '<br>';
        echo $pgDisplay.'</div><div class=\'col-sm-4\' style="text-align: right;padding-right: 20px; font-weight: bold;">'.($is_tim=='TRUE'?'Status: Administrator Pengelola pada OPD':'').'</div></div>';
    }
    $i = (int)$firstNum[0];
    ?>
    <?php while ($row_cuti = $query->fetch_array(MYSQLI_BOTH)) {
    $i++;
    $idcm = $row_cuti['id_cuti_master'];
    $idp_pemohon = $row_cuti['id_pegawai'];
    $flag_uk = $row_cuti['flag_uk_atasan_sama'];
    $idstatus = $row_cuti['id_status_cuti'];
    $id_sts_keputusan_atsl = (($row_cuti['id_sts_keputusan_atsl']=='' or $row_cuti['id_sts_keputusan_atsl']==0)?0:$row_cuti['id_sts_keputusan_atsl']);
    $alasanAtsl = ($row_cuti['alasan_pertimbangan_atsl']==''?'-':$row_cuti['alasan_pertimbangan_atsl']);
    $id_sts_keputusan_pjbt = (($row_cuti['id_sts_keputusan_pjbt']=='' or $row_cuti['id_sts_keputusan_pjbt']==0)?0:$row_cuti['id_sts_keputusan_pjbt']);
    $alasanPjbt = ($row_cuti['alasan_keputusan_pjbt']==''?'-':$row_cuti['alasan_keputusan_pjbt']);
    $txtKeterangan = ($row_cuti['approved_note']==''?'-':$row_cuti['approved_note']);
    if($id_sts_keputusan_atsl==3 or $id_sts_keputusan_pjbt==3){
        $sqlGetPenangguhan = "select cp.id_cuti_penangguhan, DATE_FORMAT(cp.tgl_mulai_penangguhan, '%d-%m-%Y') AS tgl_mulai_penangguhan,
            DATE_FORMAT(cp.tgl_akhir_penangguhan, '%d-%m-%Y') AS tgl_akhir_penangguhan, lama_penangguhan
            from cuti_penangguhan cp where cp.id_cuti_master = $idcm";
        $qGetP = $mysqli->query($sqlGetPenangguhan);
        while ($oto = $qGetP->fetch_array(MYSQLI_NUM)) {
            $tglMulaiPenangguhan = $oto[1];
            $tglSelesaiPenangguhan = $oto[2];
            $lamaPenangguhan = $oto[3];
        }
    }
    ?>
    <table width="95%" border="0" align="center" style="border-radius:5px;"
           class="table table-bordered table-hover table-striped">
        <tr style="border-bottom: 2px solid #95c764">
            <td style="width: 5%;">No.</td>
            <td style="width: 5%;">Tahun</td>
            <td style="width: 10%;">Tgl. Pengajuan</td>
            <td style="width: 12%;">Waktu Cuti</td>
            <td style="width: 10%;">Lama Cuti</td>
            <td style="width: 25%;">Alamat Selama Cuti</td>
            <td style="width: 20%;">Status</td>
        </tr>
        <tr>
            <td><?php echo $i; ?>.</td>
            <td><?php echo $row_cuti['periode_thn']; ?></td>
            <td><?php echo $row_cuti['tgl_usulan_cuti2']; ?></td>
            <td>
                <?php echo $row_cuti['tmt_awal_cuti']; ?> s.d.<br>
                <?php echo $row_cuti['tmt_akhir_cuti']; ?>
            </td>
            <td><?php echo (int)($row_cuti['lama_cuti'])+(int)($row_cuti['lama_cuti_n1']).' Hari '.((int)($row_cuti['lama_cuti_n1'])>0?'('.(int)$row_cuti['periode_thn'].': '.$row_cuti['lama_cuti'].', '.((int)$row_cuti['periode_thn']+1).': '.(int)$row_cuti['lama_cuti_n1'].')':''); ?></td>
            <td><?php echo $row_cuti['keterangan']; ?></td>
            <td><?php echo $row_cuti['status_cuti']; ?></td>
        </tr>
        <tr>
            <td style="background-color: white;"></td>
            <td colspan="7" style="background-color: white;">
                <div class="row">
                    <div class="col-lg-6">
                        <ul class="nav nav-tabs" role="tablist" id="myTabCuti" style="margin-top: 10px;">
                            <li role="presentation" class="active">
                                <a href="#main<?php echo $idcm; ?>" aria-controls="main<?php echo $idcm; ?>" role="tab" data-toggle="tab">Info Utama</a></li>
                            <li role="presentation">
                                <a href="#runut<?php echo $idcm; ?>" aria-controls="runut<?php echo $idcm; ?>" role="tab" data-toggle="tab">Riwayat Pemrosesan</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="main<?php echo $idcm; ?>">
                                    <span style="color: #002a80;font-weight: bold;font-size: large;">
                                        <?php echo $row_cuti['deskripsi']; ?>
                                        <?php
                                            if($row_cuti['id_jenis_cuti']=='C_ALASAN_PENTING' and $row_cuti['sub_jenis_cuti']=='cut_penting_mendesak'){
                                                echo ' (Keperluan Mendesak)';
                                            }
                                        ?>
                                    </span><span style="font-weight: bold; color: darkorange;"><?php echo($row_cuti['is_cuti_mundur']==1?' (Cuti Mundur)':'');?></span><br>
                                <?php if($is_tim=='TRUE'): ?>
                                    <span style="font-size: medium;font-weight: bold;color: saddlebrown;">
                                            <?php echo $row_cuti['nama'].' ['.$row_cuti['nip_baru'].']'; ?>
                                        </span><br>
                                <?php endif; ?>
                                Unit Kerja : <?php echo $row_cuti['last_unit_kerja']; ?> <br>
                                <?php
                                if($flag_uk==1){
                                    echo 'Keterangan : Lokasi Unit Kerja Atasan Langsung dan Pejabat Berwenang Sama<br>';
                                }else{
                                    echo 'Keterangan : Lokasi Unit Kerja Atasan Langsung dan Pejabat Berwenang Berbeda <br>(Keputusan Pejabat Berwenang ada di Admin OPD Pejabat Berwenang) <br>';
                                }
                                ?>
                                <strong>Alasan Cuti : </strong><br>
                                <?php
                                if($row_cuti['is_kunjungan_luar_negeri']==1){
                                    echo "Kunjungan ke Luar Negeri. ";
                                }
                                ?>
                                <?php echo ($row_cuti['alasan_cuti']==''?'Tidak ada informasi':$row_cuti['alasan_cuti']); ?><br>
                                <strong>Atasan  Langsung : </strong><br>
                                <?php echo $row_cuti['last_atsl_nama']." (".$row_cuti['last_atsl_nip'].")"; ?> <br>
                                Gol. <?php echo $row_cuti['last_atsl_gol']; ?>. Jabatan : <?php echo $row_cuti['last_atsl_jabatan']; ?> <br>
                                <strong>Pejabat Berwenang : </strong><br>
                                <?php echo $row_cuti['last_pjbt_nama']." (".$row_cuti['last_pjbt_nip'].")"; ?> <br>
                                Gol. <?php echo $row_cuti['last_pjbt_gol']; ?>. Jabatan : <?php echo $row_cuti['last_pjbt_jabatan']; ?> <br>
                                <strong>Tgl. Update Status : </strong><?php echo $row_cuti['tgl_approve_status2']; ?>
                                Oleh : <?php echo $row_cuti['nama_approved']." (".$row_cuti['nip_baru_approved'].")"; ?>
                                Catatan Akhir : <?php echo ($row_cuti['approved_note']==""?"-":$row_cuti['approved_note']); ?>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="runut<?php echo $idcm; ?>">
                                Runut Status Pengajuan :
                                <?php
                                $qrun = $oCuti->get_list_runut_proses_cuti($idcm);
                                if($qrun->num_rows > 0) {
                                    echo("<ul style='margin-left: -20px;'>");
                                    while ($otoy = $qrun->fetch_array(MYSQLI_NUM)) {
                                        echo("<li>Status : $otoy[3] Diproses oleh $otoy[0] tanggal $otoy[1] catatan: $otoy[2] </li>");
                                    }
                                    echo("</ul>");
                                }else{
                                    echo '<br>Belum ada pemrosesan usulan';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 formdiv<?php echo $idcm; ?>"" style="border-left: 1px solid lightgrey;">
                    <table style="width: 100%;">
                        <tr>
                            <td style="border-bottom: 1px solid lightgrey; padding-bottom: 5px;">
                                <table>
                                    <?php
                                    if ($row_cuti['idberkas_surat_cuti'] == 0) {
                                        echo '<tr><td colspan="2">';
                                        echo "<div id='spnInfo' style='color: red; font-weight: bold; padding: 3px; width: 100%; padding-left:0px;text-align: left;'>
                                            Belum ada surat permohonan cuti yang diupload</div>";
                                        echo '</td></tr>';
                                    }else {
                                        if ($row_cuti['id_status_cuti'] == 6) {
                                            echo "<div id='spnInfo' style='color: red; font-weight: bold; padding: 3px; width: 100%; padding-left:0px;text-align: left;'>
                                                SK Cuti belum diterbitkan</div>";
                                        }

                                    if ($row_cuti['id_status_cuti'] == 10) {
                                    if ($row_cuti['idberkas_sk_cuti'] == 0) {
                                        echo "<div id='spnInfo' style='color: red; font-weight: bold; padding: 3px; width: 100%; padding-left:0px;text-align: left;'>
                                                    Belum ada SK Cuti yang diupload</div>";
                                    }else {
                                        $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%m:%s') as created_date, p.nip_baru, p.nama
                                                            FROM berkas b, isi_berkas ib, pegawai p
                                                            WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = " . $row_cuti['idberkas_sk_cuti'] .
                                            " AND b.created_by = p.id_pegawai";
                                        $queryCek = mysqli_query($mysqli, $sqlCekBerkas);
                                        $data = mysqli_fetch_array($queryCek);
                                        $fname = pathinfo($data['file_name']);
                                        ?>
                                        <?php echo '<tr><td style="width: 40%;">' ?>
                                        <button type="button" name="btnCetakSKCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>"
                                                id="btnCetakSKCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>" class="btn btn-sm"
                                                style="width: 100%;color: blue;text-align: left;" ><span class="glyphicon glyphicon-download"></span> Download SK Cuti</button><br>
                                        <script type="text/javascript">
                                            $("#btnCetakSKCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>").click(function () {
                                                window.open('http://103.14.229.15/simpeg2/Berkas/<?php echo $data['file_name'] ?>','_blank');
                                            });
                                        </script>
                                        <?php echo '</td><td style="width: 60%;padding-left: 5px;">'?><small>
                                            Tgl.Upload: <?php echo $data['created_date']; ?> <br>
                                            Oleh : <?php echo $data['nama']; ?></small>
                                    <?php
                                    echo '</td></tr>';
                                    }
                                    }

                                    $sqlCekBerkas = "SELECT ib.file_name, b.created_by,
                                                DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%m:%s') as created_date,
                                                p.nip_baru, p.nama
                                                FROM berkas b, isi_berkas ib, pegawai p
                                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = " . $row_cuti['idberkas_surat_cuti'] .
                                        " AND b.created_by = p.id_pegawai";
                                    $queryCek = mysqli_query($mysqli, $sqlCekBerkas);
                                    $data = mysqli_fetch_array($queryCek);
                                    $fname = pathinfo($data['file_name']);
                                    ?>
                                    <?php echo '<tr><td style="width: 40%;">' ?>
                                        <button type="button" name="btnCetakSuratCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>"
                                                id="btnCetakSuratCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>" class="btn btn-sm"
                                                style="width: 100%;color: blue;text-align: left;"><span class="glyphicon glyphicon-download"></span> Download Surat Cuti Terupload</button>
                                        <script type="text/javascript">
                                            $("#btnCetakSuratCutiUploaded<?php echo $row_cuti['id_cuti_master']; ?>").click(function () {
                                                window.open('http://103.14.229.15/simpeg/berkas/<?php echo $data['file_name'] ?>','_blank');
                                            });
                                        </script>
                                        <?php echo '</td><td style="width: 60%;padding-left: 5px;">'?><small>
                                            Tgl.Upload: <?php echo $data['created_date']; ?><br>
                                            Oleh : <?php echo $data['nama']; ?></small>
                                        <?php echo '</td></tr>';
                                    }
                                    if(($row_cuti['id_jenis_cuti']=='C_SAKIT') or
                                        ($row_cuti['id_jenis_cuti']=='C_BESAR' and
                                            $row_cuti['sub_jenis_cuti']=='cut_besar_agama') or
                                        ($row_cuti['id_jenis_cuti']=='C_ALASAN_PENTING' and
                                            ($row_cuti['sub_jenis_cuti']=='cut_penting_keluarga' or
                                                $row_cuti['sub_jenis_cuti']=='cut_penting_kelahiran' or
                                                $row_cuti['sub_jenis_cuti']=='cut_penting_musibah' or
                                                $row_cuti['sub_jenis_cuti']=='cut_penting_rawan')) or
                                        ($row_cuti['id_jenis_cuti']=='CLTN')) {

                                        if ($row_cuti['id_berkas_lampiran'] == 0) {
                                            echo '<tr><td colspan="2">';
                                            echo "<div id='spnInfo' style='color: red; font-weight: bold; padding: 3px; width: 100%; padding-left:0px;text-align: left;'>
                                                Belum ada surat lampiran lainnya yang diupload</div>";
                                            echo '</td></tr>';
                                        }else{
                                            $sqlCekBerkas = "SELECT ib.file_name, b.created_by,
                                                DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%m:%s') as created_date,
                                                p.nip_baru, p.nama
                                                FROM berkas b, isi_berkas ib, pegawai p
                                                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = " . $row_cuti['id_berkas_lampiran'] .
                                                " AND b.created_by = p.id_pegawai";
                                            $queryCek = mysqli_query($mysqli, $sqlCekBerkas);
                                            $data = mysqli_fetch_array($queryCek);
                                            $fname = pathinfo($data['file_name']);
                                            ?>
                                            <?php echo '<tr><td style="width: 40%;">' ?>
                                            <button type="button" name="btnCetakSKCutiLampiran<?php echo $row_cuti['id_cuti_master']; ?>"
                                                    id="btnCetakSKCutiLampiran<?php echo $row_cuti['id_cuti_master']; ?>" class="btn btn-sm"
                                                    style="width: 100%;color: blue;text-align: left;"><span class="glyphicon glyphicon-download"></span> Download Lampiran Lainnya</button><br>
                                            <script type="text/javascript">
                                                $("#btnCetakSKCutiLampiran<?php echo $row_cuti['id_cuti_master']; ?>").click(function () {
                                                    window.open('http://103.14.229.15/simpeg/berkas/<?php echo $data['file_name'] ?>','_blank');
                                                });
                                            </script>
                                            <?php echo '</td><td style="width: 60%;padding-left: 5px;">'?><small>
                                                Tgl.Upload: <?php echo $data['created_date']; ?> <br>
                                                Oleh : <?php echo $data['nama']; ?></small>
                                            <?php
                                            echo '</td></tr>';
                                        }
                                    }
                                    ?>


                                    <tr>
                                        <td style="width: 50%">
                                            <?php if($is_tim=='TRUE'): ?>
                                                <button type="button" name="btnCetakSuratCuti<?php echo $idcm; ?>"
                                                        id="btnCetakSuratCuti<?php echo $idcm; ?>" class="btn btn-sm"
                                                        onclick="printSuratCutiTim(<?php echo $idcm; ?>, <?php echo $idp_pemohon; ?>)"
                                                        style="width: 100%;margin-top: 3px;color: blue;text-align: left;"><span class="glyphicon glyphicon-download"></span> Download Surat Permohonan Baru</button>
                                            <?php else: ?>
                                                <button type="button" name="btnCetakSuratCuti<?php echo $idcm; ?>"
                                                        id="btnCetakSuratCuti<?php echo $idcm; ?>" class="btn btn-sm"
                                                        onclick="printSuratCuti(<?php echo $idcm; ?>)"
                                                        style="width: 100%;margin-top: 3px;color: blue;text-align: left;"><span class="glyphicon glyphicon-download"></span> Download Surat Permohonan Baru</button>
                                            <?php endif; ?>
                                        </td>
                                        <td style="width: 60%;padding-left: 5px;">
                                            <small>Mencetak Surat Baru Usulan Cuti</small>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <form role="form" class="form-horizontal action="" enctype="multipart/form-data" novalidate="novalidate"
                                name="frmAjukanCuti<?php echo $idcm; ?>" id="frmAjukanCuti<?php echo $idcm; ?>" style="margin-top: 5px;">
                                <strong>Form Pengiriman ke BKPSDA</strong>
                                <table id="tbl_form">
                                    <tr>
                                        <td>
                                            Pertimbangan Atasan Langsung: <br>
                                            <select <?php echo (($idstatus==1 or $idstatus==4)?'':'disabled'); ?>
                                                    class="form-control" id="ddKepAtsl<?php echo $idcm; ?>"
                                                    name="ddKepAtsl<?php echo $idcm; ?>"
                                                    onchange="changeComboAtsl(<?php echo $idcm; ?>, <?php echo $flag_uk ?>)">
                                                <option value="0">Belum Ada</option>
                                                <?php
                                                $sql = "SELECT * FROM cuti_keputusan_atasan";
                                                $query2 = $mysqli->query($sql);
                                                while ($oto = $query2->fetch_array(MYSQLI_NUM)) {
                                                    if($oto[0]==$id_sts_keputusan_atsl){
                                                        echo("<option value='$oto[0]' selected>$oto[1]</option>");
                                                    }else{
                                                        echo("<option value='$oto[0]'>$oto[1]</option>");
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            Alasan : <br>
                                            <input <?php echo (($idstatus==1 or $idstatus==4)?'':'disabled'); ?>
                                                    id="cttn_pertimbangan<?php echo $idcm; ?>"
                                                    name="cttn_pertimbangan<?php echo $idcm; ?>"
                                                    type="text" value="<?php echo $alasanAtsl;?>" style="width: 100%;"
                                                    class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div id="divStsPenangguhanAtsl<?php echo $idcm; ?>">
                                                <table id="tbl_form">
                                                    <tr>
                                                        <td>
                                                            TMT. Mulai :<br>
                                                            <div class='input-group date' id="datetimepicker<?php echo $idcm; ?>">
                                                                <input <?php echo (($idstatus==1 or $idstatus==4)?'':'disabled'); ?>
                                                                        name="txtTmtMulaiPenangguhanAtsl<?php echo $idcm; ?>" id="txtTmtMulaiPenangguhanAtsl<?php echo $idcm; ?>"
                                                                        type="text" class="form-control" value="<?php echo ($id_sts_keputusan_atsl==3?$tglMulaiPenangguhan:date("d-m-Y", strtotime(date("d-m-Y") . "+1 days"))) ;?>"
                                                                        readonly="readonly" /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            Lama (Hari) :<br>
                                                            <input <?php echo (($idstatus==1 or $idstatus==4)?'':'disabled'); ?>
                                                                    name="txtLamaPenangguhanAtsl<?php echo $idcm; ?>" id="txtLamaPenangguhanAtsl<?php echo $idcm; ?>"
                                                                    type="text" class="form-control" value="<?php echo ($id_sts_keputusan_atsl==3?$lamaPenangguhan:1);?>"
                                                                    onkeyup="incDate(1,<?php echo $idcm; ?>)"/>
                                                        </td>
                                                        <td>
                                                            TMT.Selesai :<br>
                                                            <input <?php echo (($idstatus==1 or $idstatus==4)?'':'disabled'); ?>
                                                                    name="txtTmtSelesaiPenangguhanAtsl<?php echo $idcm; ?>" id="txtTmtSelesaiPenangguhanAtsl<?php echo $idcm; ?>"
                                                                    type="text" class="form-control" value="<?php echo ($id_sts_keputusan_atsl==3?$tglSelesaiPenangguhan:'') ?>"
                                                                    readonly="readonly" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Keputusan Pejabat Berwenang: <br>
                                            <select <?php echo (($idstatus==1 or $idstatus==4)?($flag_uk==0?'disabled':'disabled'):($flag_uk==0?($idstatus==14?($is_tim=='TRUE'?($idpAdmin==$idp_pemohon?'disabled':''):'disabled'):'disabled'):'disabled')); ?>
                                                    class="form-control" id="ddKepPjbt<?php echo $idcm; ?>"
                                                    onchange="changeComboPjbt(<?php echo $idcm; ?>)">
                                                <option value="0">Belum Ada</option>
                                                <?php
                                                $sql = "SELECT * FROM cuti_keputusan_atasan";
                                                $query2 = $mysqli->query($sql);
                                                while ($oto = $query2->fetch_array(MYSQLI_NUM)) {
                                                    if($oto[0]==$id_sts_keputusan_pjbt){
                                                        echo("<option value='$oto[0]' selected>$oto[1]</option>");
                                                    }else{
                                                        echo("<option value='$oto[0]'>$oto[1]</option>");
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            Alasan : <br>
                                            <input <?php echo (($idstatus==1 or $idstatus==4)?($flag_uk==0?'disabled':'disabled'):($flag_uk==0?($idstatus==14?($is_tim=='TRUE'?($idpAdmin==$idp_pemohon?'disabled':''):'disabled'):'disabled'):'disabled')); ?>
                                                    name="cttn_keputusan<?php echo $idcm; ?>"
                                                    id="cttn_keputusan<?php echo $idcm; ?>" type="text"
                                                    value="<?php echo $alasanPjbt; ?>" style="width: 100%;" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <div id="divStsPenangguhanPjbt<?php echo $idcm; ?>">
                                                <table id="tbl_form">
                                                    <tr>
                                                        <td>
                                                            TMT. Mulai :<br>
                                                            <div class='input-group date' id="datetimepicker2<?php echo $idcm; ?>">
                                                                <input name="txtTmtMulaiPenangguhanPjbt<?php echo $idcm; ?>" id="txtTmtMulaiPenangguhanPjbt<?php echo $idcm; ?>"
                                                                       type="text" class="form-control" value="<?php echo date("d-m-Y", strtotime(date("d-m-Y") . "+1 days"));?>"
                                                                       readonly="readonly" /><span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            Lama (Hari) :<br>
                                                            <input name="txtLamaPenangguhanPjbt<?php echo $idcm; ?>" id="txtLamaPenangguhanPjbt<?php echo $idcm; ?>"
                                                                   type="text" class="form-control" value="1" onkeyup="incDate(2,<?php echo $idcm; ?>)"/>
                                                        </td>
                                                        <td>
                                                            TMT.Selesai :<br>
                                                            <input name="txtTmtSelesaiPenangguhanPjbt<?php echo $idcm; ?>" id="txtTmtSelesaiPenangguhanPjbt<?php echo $idcm; ?>"
                                                                   type="text" class="form-control" value="" readonly="readonly" />
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            Keterangan : <br>
                                            <input <?php echo (($idstatus==1 or $idstatus==4)?'':($flag_uk==0?($idstatus==14?($is_tim=='TRUE'?($idpAdmin==$idp_pemohon?'disabled':''):'disabled'):'disabled'):'disabled')); ?>
                                                    name="txtKeterangan<?php echo $idcm; ?>"
                                                    id="txtKeterangan<?php echo $idcm; ?>" type="text"
                                                    value="<?php echo (($idstatus==1 or $idstatus==4 or $idstatus==14)?'-':$txtKeterangan); ?>"
                                                    style="width: 100%;" class="form-control">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Upload Surat Permohonan Cuti : <br>
                                            <div <?php echo (($idstatus==1 or $idstatus==4)?'':($flag_uk==0?($idstatus==14?($is_tim=='TRUE'?($idpAdmin==$idp_pemohon?'disabled':''):'disabled'):'disabled'):'disabled')); ?>
                                                    id='divBtnFile<?php echo $i; ?>' class="fileUpload btn btn-default" style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                                                <span id='judulFile<?php echo $idcm; ?>'>Browse</span>
                                                <input id="uploadFileSuratCuti<?php echo $idcm; ?>" name='uploadFileSuratCuti<?php echo $idcm; ?>'
                                                       type="file" class="upload uploadFileSuratCuti<?php echo $idcm; ?>" accept=".pdf"/>
                                            </div>
                                            <script>
                                                $('#uploadFileSuratCuti<?php echo $idcm; ?>').bind('change', function () {
                                                    var fileUsulanSize1<?php echo $idcm;?> = 0;
                                                    fileUsulanSize1<?php echo $idcm;?> = this.files[0].size;
                                                    if (parseFloat(fileUsulanSize1<?php echo $idcm;?>) > 2138471) {
                                                        alert('Ukuran file terlalu besar');
                                                        $("#judulFile<?php echo $idcm;?>").text('Browse');
                                                        $("#uploadFileSuratCuti<?php echo $idcm; ?>").val("");
                                                    } else {
                                                        $("#judulFile<?php echo $idcm;?>").text('Satu File');
                                                    }
                                                });
                                            </script>
                                        </td>
                                        <td>
                                            <?php
                                            if(($row_cuti['id_jenis_cuti']=='C_SAKIT') or
                                                ($row_cuti['id_jenis_cuti']=='C_BESAR' and
                                                    $row_cuti['sub_jenis_cuti']=='cut_besar_agama') or
                                                ($row_cuti['id_jenis_cuti']=='C_ALASAN_PENTING' and
                                                    ($row_cuti['sub_jenis_cuti']=='cut_penting_keluarga' or
                                                        $row_cuti['sub_jenis_cuti']=='cut_penting_kelahiran' or
                                                        $row_cuti['sub_jenis_cuti']=='cut_penting_musibah' or
                                                        $row_cuti['sub_jenis_cuti']=='cut_penting_rawan')) or
                                                ($row_cuti['id_jenis_cuti']=='CLTN')){
                                                ?>
                                                Upload Surat Lampiran Lainnya : <br>
                                                <div <?php echo (($idstatus==1 or $idstatus==4)?'':($flag_uk==0?($idstatus==14?($is_tim=='TRUE'?'':'disabled'):'disabled'):'disabled')); ?>
                                                        id='divBtnFileLainnya<?php echo $i; ?>' class="fileUpload btn btn-default" style='margin-top: 0px;text-align: center; margin-bottom: -3px; margin-left: -1px;'>
                                                    <span id='judulFileLainnya<?php echo $idcm; ?>'>Browse</span>
                                                    <input id="uploadFileLainnya<?php echo $idcm; ?>" name='uploadFileLainnya<?php echo $idcm; ?>'
                                                           type="file" class="upload uploadFileLainnya<?php echo $idcm; ?>" accept=".pdf"/>
                                                </div>
                                                <script>
                                                    $('#uploadFileLainnya<?php echo $idcm; ?>').bind('change', function () {
                                                        var fileUsulanSize2<?php echo $idcm;?> = 0;
                                                        fileUsulanSize2<?php echo $idcm;?> = this.files[0].size;
                                                        if (parseFloat(fileUsulanSize2<?php echo $idcm;?>) > 2138471) {
                                                            alert('Ukuran file terlalu besar');
                                                            $("#judulFileLainnya<?php echo $idcm;?>").text('Browse');
                                                            $("#uploadFileLainnya<?php echo $idcm; ?>").val("");
                                                        } else {
                                                            $("#judulFileLainnya<?php echo $idcm;?>").text('Satu File');
                                                        }
                                                    });
                                                </script>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <input type="button" onclick="prosesHapus(<?php echo $idcm; ?>,<?php echo $curpage;?>,<?php echo $ipp;?>);"
                                                   name="btnHapusCuti_<?php echo $idcm; ?>"
                                                   id="btnHapusCuti_<?php echo $idcm; ?>" class="btn btn-danger"
                                                   value="Hapus" <?php if($row_cuti['id_status_cuti'] != 1) echo 'disabled' ?>  />

                                            <input type="button" onclick="prosesBatal(<?php echo $idcm; ?>,<?php echo $curpage;?>,<?php echo $ipp;?>);"
                                                   name="btnBatalkanCuti_<?php echo $idcm; ?>"
                                                   id="btnBatalkanCuti_<?php echo $idcm; ?>" class="btn btn-warning"
                                                   value="Batalkan" <?php echo(($row_cuti['id_status_cuti']!=1 and
                                                $row_cuti['id_status_cuti']!=4 and $row_cuti['id_status_cuti']!=12 and
                                                $row_cuti['id_status_cuti'] != 13 and $row_cuti['id_status_cuti'] != 14)?"disabled":
                                                ($flag_uk==0?(($is_tim=='TRUE'?($idp_pemohon==$_SESSION['id_pegawai']?($row_cuti['id_status_cuti']==13?'disabled':''):'disabled'):
                                                    (($row_cuti['id_status_cuti']==13 or $row_cuti['id_status_cuti']==14)?'disabled':''))):($row_cuti['id_status_cuti']==13?'disabled':''))); ?> />
                                            <?php //echo $flag_uk?>
                                            <input type="button" onclick="update(<?php echo $idcm; ?>)"
                                                   name="btnUbahCuti_<?php echo $idcm; ?>"
                                                   id="btnUbahCuti_<?php echo $idcm; ?>" class="btn btn-primary"
                                                   value="Ubah" <?php if($row_cuti['id_status_cuti'] != 1) echo 'disabled' ?>/>

                                            <input type="submit"
                                                   name="btnAjukanCuti_<?php echo $idcm; ?>"
                                                   id="btnAjukanCuti_<?php echo $idcm; ?>" class="btn btn-success"
                                                   value="Kirim Usulan" <?php echo(($row_cuti['id_status_cuti']!=1 and
                                                $row_cuti['id_status_cuti']!=4 and $row_cuti['id_status_cuti']!=14)?"disabled":
                                                ($flag_uk==0?($is_tim=='TRUE'?($row_cuti['id_status_cuti']==14?($idpAdmin==$idp_pemohon?'disabled':''):'disabled'):($row_cuti['id_status_cuti']==14?'disabled':'')):'')); ?> />
                                        </td>
                                    </tr>
                                </table>
                                </form>
                            </td>
                        </tr>
                    </table>
                </div>
</div>
    </td>
    </tr>
    </table>
    <script>
        $(function () {
            checkOption('ddKepAtsl<?php echo $idcm; ?>','divStsPenangguhanAtsl<?php echo $idcm; ?>',<?php echo $idcm; ?>,1, <?php echo $id_sts_keputusan_atsl;?>, <?php echo $flag_uk; ?>);
            checkOption('ddKepPjbt<?php echo $idcm; ?>','divStsPenangguhanPjbt<?php echo $idcm; ?>',<?php echo $idcm; ?>,2, <?php echo $id_sts_keputusan_pjbt;?>, <?php echo $flag_uk; ?>);
            incDate(1,<?php echo $idcm; ?>);
            incDate(2,<?php echo $idcm; ?>);
            initTanggal(1,<?php echo $idcm; ?>);
            initTanggal(2,<?php echo $idcm; ?>);
            initValidasi(<?php echo $idp_pemohon;?>, '<?php echo $row_cuti['nip_baru']; ?>', <?php echo $flag_uk; ?>,<?php echo $idcm; ?>, <?php echo $curpage;?>, <?php echo $ipp;?>);

        });
    </script>
<?php } ?>

<?php
if ($numpage > 0) {
    echo "Halaman ke $curpage dari $numpage | Jumlah Data : $jmlData | $jumppage";
    echo $pgDisplay;
}
} else {
    echo '<div style="padding: 10px;">Tidak ada data</div>';
}
?>
</div>
