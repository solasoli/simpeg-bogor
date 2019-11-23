<style>
    .loader {
        position: absolute;
        /*left: 50%;
        top: 50%;*/
        z-index: 1;
        width: 150px;
        height: 150px;
        margin: -75px 0 0 -75px;
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<?php
    //session_start();
    include 'class/cls_ptk.php';
    $oPtk = new Ptk();
    $listBln = $oPtk->listBulan();
    $listThn = $oPtk->listTahun();
?>

<h3>Mutasi Gaji Pokok Pegawai</h3>
<h5>Sumber : SK CPNS, PNS dan Kenaikan Pangkat</h5>
<div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li role="presentation" class="active"><a href="#daftar_usulan" aria-controls="daftar_usulan" role="tab" data-toggle="tab" style="color: darkolivegreen;font-weight: bold;">Daftar Usulan dari SIMPEG</a></li>
        <li role="presentation"><a href="#draft_pengubahan" aria-controls="draft_pengubahan" role="tab" data-toggle="tab" style="color: darkolivegreen;font-weight: bold;">Draft Pengubahan Gaji untuk SIM GAJI</a></li>
        <!--<li role="presentation"><a href="#rekap_pengubahan" aria-controls="rekap_pengubahan" role="tab" data-toggle="tab" style="color: darkolivegreen;font-weight: bold;">Rekapitulasi Data</a></li>-->
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="daftar_usulan">
            <div class="row" style="margin-top: 20px;">
                <div style="font-weight: bold;margin-left: 15px;margin-top: -10px;margin-bottom: 10px;">Pencarian Dokumen SK</div>
                <div class="col-md-1" style="margin-top: 8px;">TMT. SK</div>
                <div class="col-md-2" style="margin-left: -15px;">
                    <select class="form-control" id="ddBlnTMTSk" style="width: 102%">
                        <?php
                        $i = 0;
                        for ($x = 0; $x <= 11; $x++) {
                            if($listBln[$i][0]==date("m")){
                                echo "<option value=".$listBln[$i][0]." selected>".$listBln[$i][1]."</option>";
                            }else{
                                echo "<option value=".$listBln[$i][0].">".$listBln[$i][1]."</option>";
                            }
                            $i++;
                        }
                        ?>
                    </select>

                </div>
                <div class="col-md-2" style="margin-left: -15px;">
                    <select class="form-control" id="ddThnTMTSk">
                        <?php
                        $i = 0;
                        for ($x = 0; $x < sizeof($listThn); $x++) {
                            if($listThn[$i]==date("Y")){
                                echo "<option value=".$listThn[$i]." selected>".$listThn[$i]."</option>";
                            }else{
                                echo "<option value=".$listThn[$i].">".$listThn[$i]."</option>";
                            }
                            $i++;
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3" style="margin-top: 8px;margin-left: -20px;">Check Draft TMT. Gaji</div>
                <div class="col-md-2" style="margin-left: -100px;">
                    <select class="form-control" id="ddBlnTMTGaji" style="width: 101%">
                        <?php
                        $i = 0;
                        for ($x = 0; $x <= 11; $x++) {
                            if($listBln[$i][0]==date("m")){
                                echo "<option value=".$listBln[$i][0]." selected>".$listBln[$i][1]."</option>";
                            }else{
                                echo "<option value=".$listBln[$i][0].">".$listBln[$i][1]."</option>";
                            }
                            $i++;
                        }
                        ?>
                    </select>

                </div>
                <div class="col-md-2" style="margin-left: -15px;">
                    <select class="form-control" id="ddThnTMTGaji">
                        <?php
                        $i = 0;
                        for ($x = 0; $x < sizeof($listThn); $x++) {
                            if($listThn[$i]==date("Y")){
                                echo "<option value=".$listThn[$i]." selected>".$listThn[$i]."</option>";
                            }else{
                                echo "<option value=".$listThn[$i].">".$listThn[$i]."</option>";
                            }
                            $i++;
                        }
                        ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="row" style="margin-top: -10px;">
                <div class="col-md-2">
                    <input type="text" class="form-control" id="txtKataKunciUsulan" name="txtKataKunciUsulan" placeholder="Kata Kunci"></div>
                <div class="col-md-3" style="margin-left: -15px;">
                    <select class="form-control" id="ddJenisSK">
                        <option value="0">Semua Jenis SK</option>
                        <option value="6">SK CPNS</option>
                        <option value="7">SK PNS</option>
                        <option value="5">SK Kenaikan Pangkat</option>
                    </select>
                </div>
                <div class="col-md-3" style="margin-left: -15px;">
                    <select class="form-control" id="ddStatusDataBerkas">
                        <option value="1">Data Berkas SK Ada</option>
                        <option value="0">Data Berkas SK Belum Ada</option>
                    </select>
                </div>
                <div class="col-md-2" style="margin-left: -15px;">
                    <button type="button" class="btn btn-primary" id="btn_tampilkan_usulan" name="btn_tampilkan_usulan">Tampilkan</button>
                </div>
            </div><br>
            <div style="margin-top: -10px;margin-bottom: 5px;">
                <span style="font-size: small;">Kata Kunci : Nama, NIP, Jabatan, Unit</span>
            </div>
            <br>
            <div class="row" style="margin-top: -15px;">
                <div id="loader" class="loader"></div>
                <div id="divListUsulanGaji"></div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="draft_pengubahan">
            <div class="row" style="margin-top: 20px;">
                <div class="col-md-2">
                    <input type="text" class="form-control" id="txtKataKunciDraft" name="txtKataKunciDraft" placeholder="Kata Kunci">
                </div>
                <div class="col-md-2" style="margin-top: 8px;margin-left: -15px;">TMT. Gaji</div>
                <div class="col-md-2" style="margin-left: -95px;">
                    <select class="form-control" id="ddBlnTMTGajiDraft" style="width: 101%">
                        <?php
                        $i = 0;
                        for ($x = 0; $x <= 11; $x++) {
                            if($listBln[$i][0]==date("m")){
                                echo "<option value=".$listBln[$i][0]." selected>".$listBln[$i][1]."</option>";
                            }else{
                                echo "<option value=".$listBln[$i][0].">".$listBln[$i][1]."</option>";
                            }
                            $i++;
                        }
                        ?>
                    </select>

                </div>
                <div class="col-md-2" style="margin-left: -15px;">
                    <select class="form-control" id="ddThnTMTGajiDraft">
                        <?php
                        $i = 0;
                        for ($x = 0; $x < sizeof($listThn); $x++) {
                            if($listThn[$i]==date("Y")){
                                echo "<option value=".$listThn[$i]." selected>".$listThn[$i]."</option>";
                            }else{
                                echo "<option value=".$listThn[$i].">".$listThn[$i]."</option>";
                            }
                            $i++;
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-1" style="margin-top: 8px;margin-left: -20px;"">TMT. SK</div>
                <div class="col-md-2" style="margin-left: -15px;">
                    <select class="form-control" id="ddBlnTMTSkDraft" style="width: 100%">
                        <option value="0">Semua Bulan</option>
                        <?php
                        $i = 0;
                        for ($x = 0; $x <= 11; $x++) {
                            if($listBln[$i][0]==date("m")){
                                echo "<option value=".$listBln[$i][0].">".$listBln[$i][1]."</option>";
                            }else{
                                echo "<option value=".$listBln[$i][0].">".$listBln[$i][1]."</option>";
                            }
                            $i++;
                        }
                        ?>
                    </select>

                </div>
                <div class="col-md-2" style="margin-left: -15px;">
                    <select class="form-control" id="ddThnTMTSkDraft" style="width: 101%;">
                        <option value="0">Semua Tahun</option>
                        <?php


                        $i = 0;
                        for ($x = 0; $x < sizeof($listThn); $x++) {
                            if($listThn[$i]==date("Y")){
                                echo "<option value=".$listThn[$i].">".$listThn[$i]."</option>";
                            }else{
                                echo "<option value=".$listThn[$i].">".$listThn[$i]."</option>";
                            }
                            $i++;
                        }
                        ?>
                    </select>
                </div>
            </div>
            <br>
            <div class="row" style="margin-top: -10px;">
                <div class="col-md-3">
                    <select class="form-control" id="ddJenisSKDraft">
                        <option value="0">Semua Jenis SK</option>
                        <option value="Pengangkatan CPNS">SK CPNS</option>
                        <option value="Pengangkatan PNS">SK PNS</option>
                        <option value="Kenaikan Pangkat">SK Kenaikan Pangkat</option>
                    </select>
                </div>
                <div class="col-md-3" style="margin-left: -15px;">
                    <select class="form-control" id="ddStatusNIP">
                        <option value="0">Semua Status NIP</option>
                        <option value="1">NIP ditemukan di SIMGAJI</option>
                        <option value="2">NIP tidak ditemukan di SIMGAJI</option>
                    </select>
                </div>
                <div class="col-md-3" style="margin-left: -15px;">
                    <select class="form-control" id="ddStatusDraft">
                        <option value="0">Semua Status Draft</option>
                        <option value="1">Sudah dieksekusi ke SIMGAJI</option>
                        <option value="2">Belum / Gagal dieksekusi ke SIMGAJI</option>
                    </select>
                </div>
                <div class="col-md-2" style="margin-left: -15px;">
                    <button type="button" class="btn btn-primary" id="btn_tampilkan_draft" name="btn_tampilkan_draft">Tampilkan</button>
                </div>
            </div>
            <br>
            <div class="row">
                <div id="loader2" class="loader"></div>
                <div id="divListDraftGaji"></div>
            </div>
        </div>
        <!--<div role="tabpanel" class="tab-pane" id="rekap_pengubahan">

        </div>-->
    </div>
</div>

<script src="js/bootstrapValidator.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        document.getElementById("loader").style.display = "none";
        document.getElementById("loader2").style.display = "none";
        loadDefaultListUsulanSimpeg();
        loadDefaultListDraftGapok();
    });

    function loadDefaultListUsulanSimpeg(){
        loadDataListUsulanSimpeg(<?php echo date("m"); ?>,<?php echo date("Y"); ?>,<?php echo date("m"); ?>,<?php echo date("Y"); ?>,0,1,'','','','gapok_usulan');
    }

    function loadDataListUsulanSimpeg(blnSk, thnSk, blnGaji, thnGaji, jnsSk, stsBerkas, keywordCari, page, ipp, tbl){
        $("#btn_tampilkan_usulan").css("pointer-events", "none");
        $("#btn_tampilkan_usulan").css("opacity", "0.4");
        $("#divListUsulanGaji").css("pointer-events", "none");
        $("#divListUsulanGaji").css("opacity", "0.4");
        document.getElementById("loader").style.display = "block";
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "ptk_drop_histgaji_gapok.php",
            data: { blnSk: blnSk,
                thnSk: thnSk,
                blnGaji: blnGaji,
                thnGaji: thnGaji,
                jnsSk: jnsSk,
                stsBerkas: stsBerkas,
                txtKeyword: keywordCari,
                page: page,
                ipp: ipp,
                tbl: tbl}
        }).done(function(data){
            $("#divListUsulanGaji").html(data);
            $("#btn_tampilkan_usulan").css("pointer-events", "auto");
            $("#btn_tampilkan_usulan").css("opacity", "1");
            $("#divListUsulanGaji").css("pointer-events", "auto");
            $("#divListUsulanGaji").css("opacity", "1");
            document.getElementById("loader").style.display = "none";
        });
    }

    $("#btn_tampilkan_usulan").click(function(){
        var keywordCari = $("#txtKataKunciUsulan").val();
        var ddBlnTMTSk = $('#ddBlnTMTSk').val();
        var ddThnTMTSk = $('#ddThnTMTSk').val();
        var ddBlnTMTGaji = $('#ddBlnTMTGaji').val();
        var ddThnTMTGaji = $('#ddThnTMTGaji').val();
        var ddJenisSK = $('#ddJenisSK').val();
        var ddStatusDataBerkas = $('#ddStatusDataBerkas').val();
        loadDataListUsulanSimpeg(ddBlnTMTSk, ddThnTMTSk, ddBlnTMTGaji, ddThnTMTGaji, ddJenisSK, ddStatusDataBerkas, keywordCari,'','','gapok_usulan');
    });

    function loadDefaultListDraftGapok(){
        loadDataListDraftGapok('',<?php echo date("m"); ?>,<?php echo date("Y"); ?>,0,0,0,0,0,'','','gapok_draft');
    }

    function loadDataListDraftGapok(keywordCari, blnGaji, thnGaji, blnSk, thnSk, jnsSk, statusNIP, statusDraft, page, ipp, tbl){
        $("#btn_tampilkan_draft").css("pointer-events", "none");
        $("#btn_tampilkan_draft").css("opacity", "0.4");
        $("#divListDraftGaji").css("pointer-events", "none");
        $("#divListDraftGaji").css("opacity", "0.4");
        document.getElementById("loader2").style.display = "block";
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "ptk_drop_histgaji_gapok_draft.php",
            data: {
                txtKeyword: keywordCari,
                blnGaji: blnGaji,
                thnGaji: thnGaji,
                blnSk: blnSk,
                thnSk: thnSk,
                jnsSk: jnsSk,
                statusNIP: statusNIP,
                statusDraft: statusDraft,
                page: page,
                ipp: ipp,
                tbl: tbl}
        }).done(function(data){
            $("#divListDraftGaji").html(data);
            $("#btn_tampilkan_draft").css("pointer-events", "auto");
            $("#btn_tampilkan_draft").css("opacity", "1");
            $("#divListDraftGaji").css("pointer-events", "auto");
            $("#divListDraftGaji").css("opacity", "1");
            document.getElementById("loader2").style.display = "none";
        });
    }

    $("#btn_tampilkan_draft").click(function(){
        var keywordCari = $("#txtKataKunciDraft").val();
        var ddBlnTMTGaji = $('#ddBlnTMTGajiDraft').val();
        var ddThnTMTGaji = $('#ddThnTMTGajiDraft').val();
        var ddBlnTMTSk = $('#ddBlnTMTSkDraft').val();
        var ddThnTMTSk = $('#ddThnTMTSkDraft').val();
        var ddJenisSK = $('#ddJenisSKDraft').val();
        var statusNIP = $('#ddStatusNIP').val();
        var statusDraft = $('#ddStatusDraft').val();
        loadDataListDraftGapok(keywordCari, ddBlnTMTGaji, ddThnTMTGaji, ddBlnTMTSk, ddThnTMTSk, ddJenisSK, statusNIP, statusDraft, '','','gapok_draft');
    });

    function pagingViewListLoad(parm,parm2,parm3){
        if(parm3=='gapok_usulan'){
            var keywordCari = $("#txtKataKunciUsulan").val();
            var ddBlnTMTSk = $('#ddBlnTMTSk').val();
            var ddThnTMTSk = $('#ddThnTMTSk').val();
            var ddBlnTMTGaji = $('#ddBlnTMTGaji').val();
            var ddThnTMTGaji = $('#ddThnTMTGaji').val();
            var ddJenisSK = $('#ddJenisSK').val();
            var ddStatusDataBerkas = $('#ddStatusDataBerkas').val();
            loadDataListUsulanSimpeg(ddBlnTMTSk, ddThnTMTSk, ddBlnTMTGaji, ddThnTMTGaji, ddJenisSK, ddStatusDataBerkas, keywordCari, parm, parm2, parm3);
        }else if(parm3=='gapok_draft'){
            var keywordCari = $("#txtKataKunciDraft").val();
            var ddBlnTMTGaji = $('#ddBlnTMTGajiDraft').val();
            var ddThnTMTGaji = $('#ddThnTMTGajiDraft').val();
            var ddBlnTMTSk = $('#ddBlnTMTSkDraft').val();
            var ddThnTMTSk = $('#ddThnTMTSkDraft').val();
            var ddJenisSK = $('#ddJenisSKDraft').val();
            var statusNIP = $('#ddStatusNIP').val();
            var statusDraft = $('#ddStatusDraft').val();
            loadDataListDraftGapok(keywordCari, ddBlnTMTGaji, ddThnTMTGaji, ddBlnTMTSk, ddThnTMTSk, ddJenisSK, statusNIP, statusDraft, parm, parm2, parm3);
        }
    }

</script>

