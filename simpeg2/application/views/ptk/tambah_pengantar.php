<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url()?>js/jquery/jquery.validate.js"></script>
<script>
    jQuery.validator.addMethod(
        "selectComboBln",
        function (value, element)
        {
            if (element.value === "0") {
                return false;
            }else {
                return true;
            }
        },
        "Tentukan Bulan"
    );

    jQuery.validator.addMethod(
        "selectComboThn",
        function (value, element)
        {
            if (element.value === "0") {
                return false;
            }else {
                return true;
            }
        },
        "Tentukan Tahun"
    );

    $(function(){
        $("#frmTambahPengantar").validate({
            ignore: "",
            rules: {
                txtIdPegawaiPengesah: {
                    required: true
                },
                nomor: {
                    required: true
                }
            },
            messages: {
                txtIdPegawaiPengesah: {
                    required: "Anda belum menentukan Data Pengesah"
                },
                nomor: {
                    required: "Anda belum mengisi Nomor"
                }
            },
            errorPlacement: function(error, element) {
                switch (element.attr("name")) {
                    case 'ddBln':
                        error.insertAfter($("#jqv_msg_bln"));
                        break;
                    case 'ddThn':
                        error.insertAfter($("#jqv_msg_thn"));
                        break;
                    default:
                        error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                var checkboxes = $("#divListGet input:checkbox");
                var jmlCheck = 0;
                for (var i = 1; i < checkboxes.length; i++) {
                    if(checkboxes[i].checked == true){
                        jmlCheck++;
                    }
                }
                if(jmlCheck <= 0){
                    alert('Pengajuan PTK yang akan dibuat nominatifnya harus dipilih dari Daftar Pengajuan PTK dan diceklis');
                }else{
                    form.submit();
                }
            }
        });
    });
</script>
<div class="container">
    <div class="grid">
        <div class="row">
            <span style="font-weight: bold; margin-top: 50px;">TAMBAH DATA BARU PENGANTAR PTK KE BPKAD</span>
        </div>
        <div class="row">
            <form action="<?php echo base_url()?>ptk" method="post" id="frmTambahPengantar" novalidate="novalidate" enctype="multipart/form-data">
                <input id="submitok" name="submitok" type="hidden" value="1">
                <div class="span4">
                    <div class="panel" style="padding-bottom: 10px;">
                        <div class="panel-header">Registrasi</div>
                        <div class="panel-content">
                            <div class="input-control text" style="margin-top: 0px;">
                                <label>Jenis</label>
                                <strong>Rekapitulasi Perubahan Tunjangan Keluarga</strong>
                            </div>

                            <div class="input-control text" style="margin-top: 20px;margin-bottom: 25px;">
                                <label>Periode Pengantar Usulan</label>
                                <?php if (isset($listBln)): ?>
                                    <span class="span1" style="margin-left: 0px;">
                                    <div class="input-control select" style="width: 200%;">
                                        <select id="ddBln" name="ddBln">
                                            <option value="0">Pilih Bulan</option>
                                            <?php
                                            $i = 0;
                                            for ($x = 0; $x <= 11; $x++) {
                                                if($listBln[$i][0] == date("m")){
                                                    echo "<option value=".$listBln[$i][0]." selected>".$listBln[$i][1]."</option>";
                                                }else{
                                                    echo "<option value=".$listBln[$i][0].">".$listBln[$i][1]."</option>";
                                                }
                                                $i++;
                                            }
                                            ?>
                                        </select> <span id="jqv_msg_bln"></span>
                                    </div></span>
                                <?php endif; ?>
                                <?php if (isset($listThn)): ?>
                                    <span class="span1" style="margin-left: 80px;">
                                    <div class="input-control select" style="width: 200%;">
                                        <select id="ddThn" name="ddThn">
                                            <option value="0">Pilih Tahun</option>
                                            <?php
                                            $i = 0;
                                            for ($x = 0; $x < sizeof($listThn); $x++) {
                                                if($listThn[$i] == date("Y")){
                                                    echo "<option value=".$listThn[$i]." selected>".$listThn[$i]."</option>";
                                                }else{
                                                    echo "<option value=".$listThn[$i].">".$listThn[$i]."</option>";
                                                }
                                                $i++;
                                            }
                                            ?>
                                        </select> <span id="jqv_msg_thn"></span>
                                    </div></span>
                                <?php endif; ?>
                            </div>

                            <div class="input-control text" style="margin-top: 30px;">
                                <label>Nomor</label>
                                <input id="nomor" name="nomor" type="text" value="" required>
                            </div>

                            <div class="input-control text" style="margin-top: 25px;">
                                <label>Pengesah</label>
                                <table style="width: 100%; background-color: white;">
                                    <tr>
                                        <td><input id="nipPengesah" name="nipPengesah"
                                                   type="text" value="" placeholder="Masukkan NIP"></td>
                                        <td><button id="btnCariNip" name="btnCariNip" type="button" class="button info" style="height: 33px; width: 100%"
                                                    onclick="getInfoPegawai();">
                                                <strong>Cari</strong></button></td>
                                    </tr>
                                </table>
                            </div>
                            <div id="divInfoPegawai" style="font-size: small;margin-top: 10px;">
                                <?php if (sizeof($listdata) > 0): ?>
                                    <?php if($listdata!=''): ?>
                                        <?php foreach ($listdata as $lsdata): ?>
                                            <?php if($lsdata->nip_pengesah!=''): ?><br>
                                                <?php echo $lsdata->nama_pengesah; ?><br>
                                                <?php echo $lsdata->nip_pengesah; ?><br>
                                                <?php echo $lsdata->jabatan; ?><br>
                                                Status : <?php echo $lsdata->flag_pensiun==0?'Aktif Bekerja':'Pensiun/Pindah'; ?>
                                            <?php else: ?><br>
                                                <i>Belum ada data pengesah</i>
                                            <?php endif; ?>
                                            <input type="hidden" id="txtIdPegawaiPengesah"
                                                   name="txtIdPegawaiPengesah" value="<?php echo (isset($lsdata->id_pegawai_pengesah)?$lsdata->id_pegawai_pengesah:''); ?>">
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <button id="btnregister" name="btnregister" type="submit" class="button success" style="height: 34px; margin-top: 20px;">
                                <span class="icon-floppy on-left"></span><strong>Simpan</strong></button>
                        </div>
                    </div>
                </div>
                <div class="span10">
                    <div class="panel">
                        <div class="panel-header">
                            Daftar Nominatif
                        </div>
                        <div class="panel-content">
                            <div class="row">
                                <?php if (isset($listBln)): ?>
                                    <span class="span1" style="margin-left: 0px;margin-top: 5px;">Periode</span>
                                    <span class="span2" style="margin-left: 0px;">
                                        <div class="input-control select" style="width: 100%;">
                                            <select id="ddFilterBln" name="ddFilterBln">
                                                <option value="0">Pilih Bulan</option>
                                                <?php
                                                $i = 0;
                                                for ($x = 0; $x <= 11; $x++) {
                                                    if($listBln[$i][0] == date("m")){
                                                        echo "<option value=".$listBln[$i][0]." selected>".$listBln[$i][1]."</option>";
                                                    }else{
                                                        echo "<option value=".$listBln[$i][0].">".$listBln[$i][1]."</option>";
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                            </select>
                                        </div></span>
                                <?php endif; ?>
                                <?php if (isset($listThn)): ?>
                                    <span class="span2" style="margin-left: 10px;">
                                        <div class="input-control select" style="width: 100%;">
                                            <select id="ddFilterThn" name="ddFilterThn">
                                                <option value="0">Pilih Tahun</option>
                                                <?php
                                                $i = 0;
                                                for ($x = 0; $x < sizeof($listThn); $x++) {
                                                    if($listThn[$i] == date("Y")){
                                                        echo "<option value=".$listThn[$i]." selected>".$listThn[$i]."</option>";
                                                    }else{
                                                        echo "<option value=".$listThn[$i].">".$listThn[$i]."</option>";
                                                    }
                                                    $i++;
                                                }
                                                ?>
                                            </select>
                                        </div></span>
                                <?php endif; ?>
                                <span class="span2" style="margin-left: 5px;">
                                    <div class="input-control text">
                                        <input id="keywordCari"type="text" value="" placeholder="Kata kunci" />
                                    </div>
                                </span>
                                <span class="span1" style="margin-left: 5px;">
                                    <button id="btn_tampilkan" class="button primary" style="height: 33px; width: 120%;" type="button"
                                            onclick="filterCariNominatif();">
                                        <!--<span class="icon-search on-left"></span>--><strong>Cari</strong></button>
                                </span>
                                <span class="span1">
                                    <button id="btnPilih" class="button warning" style="height: 33px; width: 130%;" type="button">
                                        <span class="icon-arrow-down on-left"></span><strong>Pilih</strong></button>
                                </span>
                                <span class="span1">
                                    <img id="imgLoadingPtk" src="../images/preload-crop.gif" height="28" width="27">
                                </span>
                            </div>
                            <div>
                                <div style="color: blue;background-color: #EEEEEE;border: 1px solid #747571;
                                width: 100%;font-size: small;padding: 3px;margin-bottom: -20px;text-align: center;">
                                    Daftar Pengajuan PTK (Sesuai Penerbitan Surat ke BPKAD)</div><br>
                                <div id="divListDrop" style="border:1px solid #c0c2bb; overflow:scroll;height: 365px;width: 100%;padding: 5px;"></div>
                            </div>
                            <div>
                                <div style="color: blue;background-color: #EEEEEE;border: 1px solid #747571;
                                width: 100%;font-size: small;padding: 3px;margin-bottom: 0px;text-align: center;">
                                    Daftar Pengajuan PTK yang dipilih</div>
                                <div id="divListGet" style="border:1px solid #c0c2bb; overflow: scroll;height: 365px;
                                width: 100%;padding: 5px;margin-bottom: 10px;">
                                    <table class="table bordered" id="tbl_nomin_ptk_select" width="100%">
                                        <thead style="border-bottom: solid darkred 3px;">
                                            <tr>
                                                <td style="width: 5%;">
                                                    <label class="input-control checkbox small-check" style="margin-bottom: -20px;vertical-align: middle;">
                                                        <input type="checkbox" id="checkAllPilih">
                                                        <span class="check"></span><span class="caption"></span>
                                                    </label>
                                                </td>
                                                <th>Tgl.Usulan</th><th>NIP</th><th>Nama</th><th>Uraian</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                Pengajuan PTK yang dipilih berjumlah :
                                <span id="jmlPTKPlih" style="font-weight: bold">0</span> Usulan
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
    var img = document.getElementById("imgLoadingPtk");
    img.style.visibility = 'hidden';

    $(function(){
        filterCariNominatif();
    });

    function getInfoPegawai(){
        var nipCari = $("#nipPengesah").val();
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/ptk/info_pegawai",
            data: { nipCari: nipCari, id_ptk: ''},
            dataType: "html"
        }).done(function( data ) {
            $("#divInfoPegawai").html(data);
            $("#divInfoPegawai").find("script").each(function(i) {
                //eval($(this).text());
            });
        });
    }

    $( "#ddBln" ).addClass( "selectComboBln" );
    $( "#ddThn" ).addClass( "selectComboThn" );

    function filterCariNominatif(){
        var bln = $('#ddFilterBln').val();
        var thn = $('#ddFilterThn').val();
        var keyword = $('#keywordCari').val();
        img.style.visibility = 'visible';
        $("#divListDrop").css("pointer-events", "none");
        $("#divListDrop").css("opacity", "0.4");
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>index.php/ptk/nominatif_ptk_pengantar",
            data: { bln: bln, thn: thn, keyword: keyword},
            dataType: "html"
        }).done(function( data ) {
            $("#divListDrop").html(data);
            $("#divListDrop").find("script").each(function(i) {
                eval($(this).text());
            });
            $("#divListDrop").css("pointer-events", "auto");
            $("#divListDrop").css("opacity", "1");
            img.style.visibility = 'hidden';
        });
    }

    $("#btnPilih").click(function () {
        var checkboxes = $("#divListDrop input:checkbox");
        var idPtk = 0;
        for (var i = 1; i < checkboxes.length; i++) {
            if(checkboxes[i].checked == true){
                var str = checkboxes[i].value;
                var res = str.split("#");
                idPtk = res[0].trim();
                var a = arrPilih.indexOf(idPtk);
                if(a==-1){
                    document.getElementById("jmlPTKPlih").innerHTML = parseInt(document.getElementById('jmlPTKPlih').innerHTML)+1;
                    arrPilih.push(idPtk);
                    $('#tbl_nomin_ptk_select tr:last').after('<tr id="rowTblPilih'+idPtk+'"><td><label class="input-control checkbox small-check" style="margin-top: -2px;margin-bottom: -50px;vertical-align: top;"><input type="checkbox" value="'+idPtk+'" id="chkIdPTKPilih[]" name="chkIdPTKPilih[]" checked><span class="check"></span><span class="caption"></span></label></td><td>'+res[4]+'</td><td>'+res[1]+'</td><td><span style="color: #002a80;font-weight: bold;">'+res[2]+'</span></td><td>'+res[3]+'</td></tr>');
                }
            }
        }
        $(document).scrollTop($(document).height());
    });

    $("#checkAllPilih").change(function () {
        $("#divListGet input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $("#btnHapus").click(function () {
        var checkboxes = $("#divListGet input:checkbox");
        var idPtk = 0;
        for (var i = 1; i < checkboxes.length; i++) {
            if(checkboxes[i].checked == true){
                var str = checkboxes[i].value;
                var res = str.split("#");
                idPtk = res[0].trim();
                var a = arrPilih.indexOf(idPtk);
                arrPilih.splice(a, 1);
                document.getElementById("jmlPTKPlih").innerHTML = parseInt(document.getElementById('jmlPTKPlih').innerHTML)-1;
                $('#rowTblPilih'+idPtk).remove();
                $( "#checkAllPilih" ).prop( "checked", false );
            }
        }
    });

</script>