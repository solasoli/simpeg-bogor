<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url()?>js/jquery/jquery.validate.js"></script>
<script>
    $(function(){
        var fileSkOpenBidAdd = 0;
        $('#fileSkOpenBid').bind('change', function() {
            fileSkOpenBidAdd = this.files[0].size;
        });

        jQuery.validator.addMethod(
            "selectComboStsAktif",
            function (value, element)
            {
                if (element.value === "0") {
                    return false;
                }else {
                    return true;
                }
            },
            "Tentukan Status Aktif"
        );

        $("#frmTambahOpenBidding").validate({
            ignore: "",
            rules: {
                txtKeterangan:{
                    required: true
                },
                tmt_berlaku: {
                    required: true
                }
            },
            messages: {
                txtKeterangan:{
                    required: "Anda belum mengisi keterangan"
                },
                tmt_berlaku: {
                    required: "Anda belum menentukan TMT.Berlaku"
                }
            },
            errorPlacement: function(error, element) {
                switch (element.attr("name")) {
                    case 'ddStatusAktif':
                        error.insertAfter($("#jqv_msg"));
                        break;
                    default:
                        error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                var checkboxes = $("#divListGetPeg input:checkbox");
                var jmlCheck = 0;
                for (var i = 1; i < checkboxes.length; i++) {
                    if(checkboxes[i].checked == true){
                        jmlCheck++;
                    }
                }
                if(jmlCheck <= 0){
                    alert('Pegawai harus dipilih dari Daftar Nominatif Pegawai dan diceklis');
                }else{
                    if( document.getElementById("fileSkOpenBid").files.length == 0 ){
                        alert("Tentukan dahulu berkas Open Bidding");
                    }else{
                        if (parseFloat(fileSkOpenBidAdd) > 2138471) {
                            alert('Ukuran file terlalu besar');
                        }else{
                            form.submit();
                        }
                    }
                }
            }
        });
    });
</script>

<div class="container">
    <div class="grid">
        <?php if($tx_result == 1): ?>
            <div class="row">
                <div class="span12">
                    <div class="notice" style="background-color: #00a300;">
                        <div class="fg-white">Data sukses tersimpan</div>
                    </div>
                </div>
            </div>
        <?php elseif($tx_result == 2): ?>
            <div class="row">
                <div class="span12">
                    <div class="notice" style="background-color: #9a1616;">
                        <div class="fg-white">Data tidak tersimpan</div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <span style="margin-top: 50px;"><strong>TAMBAH DATA OPEN BIDDING</strong></span>
        </div>
        <div class="row">
            <form action="" method="post" id="frmTambahOpenBidding" novalidate="novalidate" enctype="multipart/form-data">
                <input id="submitok" name="submitok" type="hidden" value="1">
                <div class="span4">
                    <div class="panel">
                        <div class="panel-header">Registrasi</div>
                        <div class="panel-content" style="margin-bottom: 10px;">
                            <div class="input-control text" style="margin-top: 20px;">
                                <label>Keterangan</label>
                                <input id="txtKeterangan" name="txtKeterangan" type="text" value="" required>
                            </div>
                            <div class="input-control text" id="datepicTglTmtBerlaku" data-week-start="1" style="margin-top: 20px;">
                                <label>TMT Berlaku</label>
                                <input type="text" id="tmt_berlaku" name="tmt_berlaku" value="">
                            </div>
                            <div class="input-control text" style="margin-top: 20px;">
                                <label>Status Aktif</label>
                                <div class="input-control select" style="width: 100%;">
                                    <select id="ddStatusAktif" name="ddStatusAktif">
                                        <option value="0">Pilih Status</option>
                                        <option value="1">Masih berlaku</option>
                                        <option value="2">Tidak berlaku</option>
                                    </select> <span id="jqv_msg"></span>
                                </div>
                            </div>
                            <div class="input-control text" style="margin-top: 20px;">
                                <label>Berkas Open Bidding</label>
                                <input type="file" id="fileSkOpenBid" name="fileSkOpenBid" />
                            </div>
                            <button id="btnregister" name="btnregister" type="submit" class="button success" style="height: 34px; margin-top: 30px;">
                                <span class="icon-floppy on-left"></span><strong>Simpan</strong></button>
                        </div>
                    </div>
                </div>
                <div class="span10">
                    <div class="panel">
                        <div class="panel-header">Daftar Nominatif Pegawai</div>
                        <div class="panel-content">
                            Eselon IIIA dan Fungsional Minimal Golongan IV/a
                            <div class="row" style="margin-top: 5px;">
                                <span class="span2">
                                    <div class="input-control select" style="width: 100%;">
                                        <select id="ddFilterJenjab" name="ddFilterJenjab">
                                            <option value="0">Semua Jenjang</option>
                                            <option value="Struktural">Struktural</option>
                                            <option value="Fungsional">Fungsional</option>
                                        </select>
                                    </div>
                                </span>
                                <span class="span2">
                                    <div class="input-control select" style="width: 100%;">
                                        <select id="ddFilterGol" name="ddFilterGol">
                                            <option value="0">Semua Gol.</option>
                                            <option value="IV/e">IV/e</option>
                                            <option value="IV/d">IV/d</option>
                                            <option value="IV/c">IV/c</option>
                                            <option value="IV/b">IV/b</option>
                                            <option value="IV/a">IV/a</option>
                                            <option value="III/d">III/d</option>
                                            <option value="III/c">III/c</option>
                                            <option value="III/b">III/b</option>
                                            <option value="III/a">III/a</option>
                                        </select>
                                    </div>
                                </span>
                                <span class="span3" style="margin-left: 5px;">
                                    <div class="input-control text">
                                        <input id="keywordCari"type="text" value="" placeholder="Kata kunci" />
                                    </div>
                                </span>
                                <span class="span1" style="margin-left: 5px;">
                                    <button id="btnFilter" class="button primary" style="height: 33px; width: 120%;" type="button">
                                        <!--<span class="icon-search on-left"></span>--><strong>Cari</strong></button>
                                </span>
                                <span class="span1">
                                    <button id="btnPilih" class="button warning" style="height: 33px; width: 130%;" type="button">
                                        <span class="icon-arrow-down on-left"></span><strong>Pilih</strong></button>
                                </span>
                                <span class="span1">
                                    <img id="imgLoadingOpb" src="../images/preload-crop.gif" height="28" width="27">
                                </span>
                            </div>
                            <div>
                                <div style="color: blue;background-color: #EEEEEE;border: 1px solid #747571;
                                width: 100%;font-size: small;padding: 3px;margin-bottom: -20px;text-align: center;">
                                    Daftar Pegawai Calon Peserta Open Bidding</div><br>
                                <div id="divListDropPeg" style="border:1px solid #c0c2bb; overflow:scroll;height: 365px;width: 100%;padding: 5px;"></div>
                            </div>
                            <div>
                                <div style="color: blue;background-color: #EEEEEE;border: 1px solid #747571;
                                width: 100%;font-size: small;padding: 3px;margin-bottom: 0px;text-align: center;">
                                    Daftar Pegawai yang dipilih</div>
                                <div id="divListGetPeg" style="border:1px solid #c0c2bb; overflow: scroll;height: 365px;
                                width: 100%;padding: 5px;margin-bottom: 10px;">
                                    <table class="table bordered" id="tbl_pegawai_select" width="100%">
                                        <thead style="border-bottom: solid darkred 3px;">
                                        <tr>
                                            <td style="width: 5%;">
                                                <label class="input-control checkbox small-check" style="margin-bottom: -20px;vertical-align: middle;">
                                                    <input type="checkbox" id="checkAllPilih">
                                                    <span class="check"></span><span class="caption"></span>
                                                </label>
                                            </td>
                                            <th>NIP</th><th>Nama</th><th>Jabatan</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>

                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                Pegawai yang dipilih berjumlah :
                                <span id="jmlPegawaiPilih" style="font-weight: bold">0</span> Pegawai
                                <button id="btnHapus" class="button danger" style="height: 33px;" type="button">
                                    <span class="icon-remove on-left"></span><strong>Hapus yang diceklis</strong></button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    var arrPilih = [];
    var img = document.getElementById("imgLoadingOpb");
    img.style.visibility = 'hidden';

    $(function(){
        $("#datepicTglTmtBerlaku").datepicker();
        loadDefaultCalonOpenBidding();
        $( "#ddStatusAktif" ).addClass( "selectComboStsAktif" );
    });

    function loadDefaultCalonOpenBidding(){
        $("select#ddFilterJenjab option").each(function() { this.selected = (this.text == 0); });
        $("select#ddFilterGol option").each(function() { this.selected = (this.text == 0); });
        $('#keywordCari').val("");
        loadDataCalonOpenBidding('0','0','','','');
    }

    function loadDataCalonOpenBidding(ddJenjab,ddGol,keywordCari,page,ipp){
        $("#btnFilter").css("pointer-events", "none");
        $("#btnFilter").css("opacity", "0.4");
        $("#divListDropPeg").css("pointer-events", "none");
        $("#divListDropPeg").css("opacity", "0.4");
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/jabatan_struktural/cari_pegawai_calon_open_bidding",
            data: { page: page, ipp: ipp, jenjab: ddJenjab, gol: ddGol,keyword: keywordCari},
            dataType: "html"
        }).done(function (data) {
            $("#divListDropPeg").html(data);
            $("#btnFilter").css("pointer-events", "auto");
            $("#btnFilter").css("opacity", "1");
            $("#divListDropPeg").css("pointer-events", "auto");
            $("#divListDropPeg").css("opacity", "1");
            $("#divListDropPeg").find("script").each(function(i) {
                eval($(this).text());
            });
        }).fail(function(){
            $("#divListDropPeg").html('Error...telah terjadi kesalahan');
        });
    }

    $("#btnFilter").click(function(){
        var ddJenjab = $('#ddFilterJenjab').val();
        var ddFilterGol = $('#ddFilterGol').val();
        var keywordCari = $("#keywordCari").val();
        loadDataCalonOpenBidding(ddJenjab,ddFilterGol,keywordCari,'','');
    });

    function pagingViewListLoad(parm,parm2){
        var ddJenjab = $('#ddFilterJenjab').val();
        var ddFilterGol = $('#ddFilterGol').val();
        var keywordCari = $("#keywordCari").val();
        loadDataCalonOpenBidding(ddJenjab,ddFilterGol,keywordCari,parm,parm2);
    }

    $("#btnPilih").click(function () {
        var checkboxes = $("#divListDropPeg input:checkbox");
        var idPegawai = 0;
        var pangkat_gol;
        var jenjab;
        var kode_jabatan;
        var id_unit_kerja;
        var eselon;

        for (var i = 0; i < checkboxes.length; i++) {
            if(checkboxes[i].checked == true){
                var str = checkboxes[i].value;
                var res = str.split("#");
                idPegawai = res[0].trim();
                pangkat_gol = res[3].trim();
                jenjab = res[5].trim();
                kode_jabatan = res[6].trim();
                id_unit_kerja = res[7].trim();
                eselon = res[8].trim();
                var a = arrPilih.indexOf(idPegawai);
                if(a==-1){
                    document.getElementById("jmlPegawaiPilih").innerHTML = parseInt(document.getElementById('jmlPegawaiPilih').innerHTML)+1;
                    arrPilih.push(idPegawai);
                    $('#tbl_pegawai_select tr:last').after('<tr id="rowTblPilih'+idPegawai+'"><td><label class="input-control checkbox small-check" style="margin-top: -2px;margin-bottom: -50px;vertical-align: top;"><input type="checkbox" value="'+idPegawai+'#'+pangkat_gol+'#'+jenjab+'#'+kode_jabatan+'#'+id_unit_kerja+'#'+eselon+'" id="chkIdPegawaiPilih[]" name="chkIdPegawaiPilih[]" checked><span class="check"></span><span class="caption"></span></label></td><td>'+res[1]+'</td><td>'+res[2]+'</td><td>'+res[4]+'</td></tr>');
                }
            }
        }
        $(document).scrollTop($(document).height());
    });

    $("#checkAllPilih").change(function () {
        $("#divListGetPeg input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $("#btnHapus").click(function () {
        var checkboxes = $("#divListGetPeg input:checkbox");
        var idPegawai = 0;
        for (var i = 1; i < checkboxes.length; i++) {
            if(checkboxes[i].checked == true){
                var str = checkboxes[i].value;
                var res = str.split("#");
                idPegawai = res[0].trim();
                var a = arrPilih.indexOf(idPegawai);
                arrPilih.splice(a, 1);
                document.getElementById("jmlPegawaiPilih").innerHTML = parseInt(document.getElementById('jmlPegawaiPilih').innerHTML)-1;
                $('#rowTblPilih'+idPegawai).remove();
                $( "#checkAllPilih" ).prop( "checked", false );
            }
        }
    });

</script>