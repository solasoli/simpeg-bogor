<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url()?>assets/jquery/dist/jquery.validate.js"></script>
<style>
    .error {
        color: red;
    };
</style>
<div class="container-fluid">
    <?php if($tx_result == 'true' and $tx_result!=''): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Selamat</strong> Data sukses tersimpan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php elseif($tx_result == 'false' and $tx_result!=''): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Maaf</strong> Data tidak tersimpan.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <h4>Penambahan Akses Methode Aplikasi</h4>
    <p>Menambah data akses methode untuk aplikasi yang ter-register.</p>
    <form action="" method="post" id="frmTambahAksesMethode" novalidate="novalidate" enctype="multipart/form-data">
        <input id="submitok" name="submitok" type="hidden" value="1">
        <div class="row">
            <div class="col-sm-5">
                <div class="row">
                    <div class="col-sm-3">Entitas</div>
                    <div class="col-sm-9">
                        <?php if (isset($entitas_list)): ?>
                            <select id="ddEntitas" name="ddEntitas" class="custom-select" style="font-weight: bold;">
                                <option value="All" selected>-- Semua Entitas --</option>
                                <?php foreach ($entitas_list as $ls): ?>
                                    <option value="<?php echo $ls->entitas; ?>"><?php echo $ls->entitas.' ('.$ls->keterangan.')'; ?></option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                </div><br>
                <div class="row">
                    <div class="col-sm-3">Kata Kunci</div>
                    <div class="col-sm-9"><input type="text" class="form-control" id="txtKeyWord" name="txtKeyWord" value=""></div>
                </div><br>
                <div class="row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-7">
                        <button onclick="daftar_akses_methode()" type="button" class="btn btn-primary btn-sm"><span data-feather="arrow-left-circle"></span> Daftar Akses</button>
                        <button id="btn_tampilkan" class="btn btn-primary btn-sm" type="button"
                                onclick="filterCariMethode();" style="width: 100px;">
                            <span data-feather="search"></span> <strong>Cari</strong></button>
                    </div>
                    <div class="col-sm-2">
                        <img id="imgLoading1" src="<?php echo base_url('assets/images/preload-crop.gif'); ?>" height="28" width="27">
                    </div>
                </div><br>

                <div class="row">
                    <div class="col-sm-3">Methode yang tersedia</div>
                    <div class="col-sm-9">
                        <div id="dvMethodeList" style="border:1px solid #c0c2bb; overflow:scroll;height: 365px;width: 100%;"></div>
                        <button style="margin-top: 5px;" id="btn_pilih" class="btn btn-warning btn-sm" type="button"
                                onclick="" style="width: 100px;"><strong>Pilih</strong> <span data-feather="arrow-right-circle"></span></button>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-3">Aplikasi</div>
                    <div class="col-sm-7">
                        <?php if (isset($apps_list)): ?>
                            <select id="ddApps" name="ddApps" class="custom-select" style="font-weight: bold;" onchange="filterCariApps();">
                                <?php foreach ($apps_list as $ls): ?>
                                    <?php if ($ls->idrest_apps == $apps_id): ?>
                                        <option value="<?php echo $ls->idrest_apps; ?>" selected><?php echo $ls->nama_apps; ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $ls->idrest_apps; ?>"><?php echo $ls->nama_apps; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>
                    <div class="col-sm-2">
                        <img id="imgLoading2" src="<?php echo base_url('assets/images/preload-crop.gif'); ?>" height="28" width="27">
                    </div>
                </div><br>
                <div id="dvInfoApps"></div>
            </div>
        </div>
    </form>
</div>

<script>
    var arrPilih = [];
    var img = document.getElementById("imgLoading1");
    img.style.visibility = 'hidden';
    var img2 = document.getElementById("imgLoading2");
    img2.style.visibility = 'hidden';

    $(function(){
        filterCariMethode();
        filterCariApps();
    });

    function daftar_akses_methode(){
        location.href = "<?php echo base_url()."Administrator/methode_access_list" ?>";
    }

    function filterCariMethode(){
        var entitas = $('#ddEntitas').val();
        var keyword = $('#txtKeyWord').val();
        img.style.visibility = 'visible';
        $("#dvMethodeList").css("pointer-events", "none");
        $("#dvMethodeList").css("opacity", "0.4");
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>/administrator/list_methode_available",
            data: { entitas: entitas, keyword: keyword},
            dataType: "html"
        }).done(function( data ){
            $("#dvMethodeList").html(data);
            $("#dvMethodeList").find("script").each(function(i) {
                eval($(this).text());
            });
            $("#dvMethodeList").css("pointer-events", "auto");
            $("#dvMethodeList").css("opacity", "1");
            img.style.visibility = 'hidden';
        });
    }

    function filterCariApps(){
        var idapps = $('#ddApps').val();
        img2.style.visibility = 'visible';
        $("#dvInfoApps").css("pointer-events", "none");
        $("#dvInfoApps").css("opacity", "0.4");
        $.ajax({
            method: "POST",
            url: "<?php echo base_url()?>/administrator/keterangan_apps",
            data: { idapps: idapps},
            dataType: "html"
        }).done(function( data ) {
            $("#dvInfoApps").html(data);
            $("#dvInfoApps").find("script").each(function(i) {
                eval($(this).text());
            });
            $("#dvInfoApps").css("pointer-events", "auto");
            $("#dvInfoApps").css("opacity", "1");
            img2.style.visibility = 'hidden';
        });
    }

    $("#btn_pilih").click(function () {
        var checkboxes = $("#dvMethodeList input:checkbox");
        var idMethode = 0;
        for (var i = 1; i < checkboxes.length; i++) {
            if(checkboxes[i].checked == true){
                var str = checkboxes[i].value;
                var res = str.split("#");
                idMethode = res[0].trim();
                var a = arrPilih.indexOf(idMethode);
                if(a==-1){
                    document.getElementById("jmlMethodePlih").innerHTML = parseInt(document.getElementById('jmlMethodePlih').innerHTML)+1;
                    arrPilih.push(idMethode);
                    $('#tbl_methode_list_apps tr:last').after('<tr id="rowTblPilih'+idMethode+'"><td><input type="checkbox" value="'+idMethode+'" id="chkIdMethodePilih[]" name="chkIdMethodePilih[]" checked></td><td><a href="<?php echo base_url('Docs/detail_methode_by_id/') ?>'+idMethode+'" target="_blank">'+res[1]+' (ID: '+res[0]+')</a> | '+res[3]+'</td><td>'+res[2]+'</td></tr>');
                }
            }
        }
    });

</script>