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

<link href="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<script src="js/moment.js"></script>
<script src="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>

<h3>Mutasi Tunjangan Jiwa (Keluarga)</h3>
<h5>Sumber : Usulan pengubahan tunjangan keluarga dari pegawai</h5>
<div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist" id="myTab">
        <li role="presentation" class="active"><a href="#daftar_usulan_ptk" aria-controls="daftar_usulan_ptk" role="tab" data-toggle="tab" style="color: darkolivegreen;font-weight: bold;">Daftar Permohonan Pengubahan Tunjangan Keluarga</a></li>
        <li role="presentation"><a href="#draft_pengubahan_jiwa" aria-controls="draft_pengubahan_jiwa" role="tab" data-toggle="tab" style="color: darkolivegreen;font-weight: bold;">Draft Pengubahan Tunjangan Jiwa untuk SIM GAJI</a></li>
        <!--<li role="presentation"><a href="#rekap_pengubahan_ptk" aria-controls="rekap_pengubahan_ptk" role="tab" data-toggle="tab" style="color: darkolivegreen;font-weight: bold;">Rekapitulasi Data</a></li>-->
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="daftar_usulan_ptk">
            <div class="row" style="margin-top: 20px;">
                <div class="col-md-2">
                    <input type="text" class="form-control" id="txtKataKunci" name="txtKataKunci" placeholder="Kata Kunci"></div>
                <div class="col-md-3" style="margin-left: -15px;">
                    <select class="form-control" id="ddJenisPengajuan">
                        <option value="0">Semua Jenis Pengajuan</option>
                        <?php
                        $sql = "SELECT * FROM ptk_jenis_pengajuan pjp";
                        $query = $mysqli->query($sql);
                        while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                            echo("<option value='$oto[1]'>$oto[1]</option>");
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3" style="margin-left: -15px;">
                    <select class="form-control" id="ddStatusPTK">
                        <option value="0">Semua Status Pengajuan</option>
                        <?php
                        $sql = "SELECT * FROM ref_status_ptk rsp WHERE rsp.id_status_ptk IN (8,9,10,11)";
                        $query = $mysqli->query($sql);
                        while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                            echo("<option value=$oto[0]>$oto[1]</option>");
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2" style="margin-left: -15px;">
                    <button type="button" class="btn btn-primary" id="btn_tampilkan_usulan" name="btn_tampilkan_usulan">Tampilkan</button>
                </div>
            </div><br>
            <div class="row" style="margin-top: -10px;">
                <div class="col-md-1" style="margin-top: 8px;">Tgl.Awal</div>
                <div class="col-md-2">
                    <div class='input-group date' id='datetimepicker1'>
                        <input type="text" class="form-control" id="tglAwal" name="tglAwal" value="<?php echo date("d-m-Y"); ?>" readonly="readonly">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
                <div class="col-md-1" style="margin-top: 8px;">Tgl.Akhir</div>
                <div class="col-md-2">
                    <div class='input-group date' id='datetimepicker2'>
                        <input type="text" class="form-control" id="tglAkhir" name="tglAkhir" value="<?php echo date("d-m-Y"); ?>" readonly="readonly">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                    </div>
                </div>
                <div class="col-md-1">
                    <div class="checkbox checkbox-success">
                        <input id="chkFilterWkt" type="checkbox" value="">
                        <label for="chkFilterWkt">Filter Waktu</label></div>
                </div>
                <div class="col-md-3">
                    <div class="checkbox checkbox-success">
                        <input id="chkViewSyaratProsesHist" type="checkbox" checked>
                        <label for="chkViewSyaratProsesHist">Tampilkan Peninjauan Syarat dan Riwayat Pemrosesan</label></div>
                </div>
            </div><br>
            <div style="margin-top: -20px;margin-bottom: 5px;">
                <span style="font-size: small;">Kata Kunci : Nomor Usulan, Nama, NIP, Jabatan, Unit</span>
            </div>
            <div class="row">
                <div id="loader" class="loader"></div>
                <div id="divListUsulan"></div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="draft_pengubahan_jiwa">
            <div class="row" style="margin-top: 20px;">
                <div class="col-md-2">
                    <input type="text" class="form-control" id="txtKataKunciDraftPtk" name="txtKataKunciDraftPtk" placeholder="Kata Kunci">
                </div>
                <div class="col-md-2" style="margin-top: 8px;margin-left: -15px;">TMT. Gaji</div>
                <div class="col-md-2" style="margin-left: -95px;">
                    <select class="form-control" id="ddBlnTMTGajiPTKDraft" style="width: 101%">
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
                    <select class="form-control" id="ddThnTMTGajiPTKDraft">
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
                <div class="col-md-3">
                    <select class="form-control" id="ddStatusNIPPtk">
                        <option value="0">Semua Status NIP</option>
                        <option value="1">NIP ditemukan di SIMGAJI</option>
                        <option value="2">NIP tidak ditemukan di SIMGAJI</option>
                    </select>
                </div>
                <div class="col-md-3" style="margin-left: -15px;">
                    <select class="form-control" id="ddStatusDraftPtk">
                        <option value="0">Semua Status Draft</option>
                        <option value="1">Sudah dieksekusi ke SIMGAJI</option>
                        <option value="2">Belum / Gagal dieksekusi ke SIMGAJI</option>
                    </select>
                </div>
                <div class="col-md-2" style="margin-left: -15px;">
                    <button type="button" class="btn btn-primary" id="btn_tampilkan_ptk_draft" name="btn_tampilkan_ptk_draft">Tampilkan</button>
                </div>
            </div>
            <br>
            <div class="row">
                <div id="loader2" class="loader"></div>
                <div id="divListPtkDraft"></div>
            </div>
        </div>
        <!--<div role="tabpanel" class="tab-pane" id="rekap_pengubahan_ptk">

        </div>-->
    </div>
</div>

<script src="js/bootstrapValidator.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        document.getElementById("loader").style.display = "none";
        document.getElementById("loader2").style.display = "none";
        loadDefaultDataUsulanPTK();
        loadDefaultDataDraftPTK();

        $(function (){
            $('#datetimepicker1').datetimepicker({
                format: 'DD-MM-YYYY',
                ignoreReadonly: true
            }).on('dp.change', function(e) {
            });
        });

        $(function (){
            $('#datetimepicker2').datetimepicker({
                format: 'DD-MM-YYYY',
                ignoreReadonly: true
            }).on('dp.change', function(e) {
            });
        });

    });

    function loadDefaultDataUsulanPTK(){
        loadDataUsulanPTK('',0,0,false,true,'','','jiwa_usulan');
    }

    function loadDataUsulanPTK(keywordCari, jenis, status, chkWaktu, chkViewSyaratProsesHist, page, ipp, tbl){
        $("#btn_tampilkan_usulan").css("pointer-events", "none");
        $("#btn_tampilkan_usulan").css("opacity", "0.4");
        $("#divListUsulan").css("pointer-events", "none");
        $("#divListUsulan").css("opacity", "0.4");
        document.getElementById("loader").style.display = "block";
        if(chkWaktu==true){
            var tglAwal = $("#tglAwal").val();
            var tglAkhir = $("#tglAkhir").val();
        }else{
            var tglAwal = '';
            var tglAkhir = '';
        }
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "ptk_drop_data_keu_usulan.php",
            data: {
                txtKeyword: keywordCari,
                jenis: jenis,
                status: status,
                chkwaktu: chkWaktu,
                chkViewSyaratProsesHist: chkViewSyaratProsesHist,
                tglAwal: tglAwal,
                tglAkhir: tglAkhir,
                page: page,
                ipp: ipp,
                tbl: tbl}
        }).done(function(data){
            $("#divListUsulan").html(data);
            $("#btn_tampilkan_usulan").css("pointer-events", "auto");
            $("#btn_tampilkan_usulan").css("opacity", "1");
            $("#divListUsulan").css("pointer-events", "auto");
            $("#divListUsulan").css("opacity", "1");
            document.getElementById("loader").style.display = "none";
        });
    };

    $("#btn_tampilkan_usulan").click(function(){
        var keywordCari = $("#txtKataKunci").val();
        var jenis = $('#ddJenisPengajuan').val();
        var status = $('#ddStatusPTK').val();
        var chkWaktu = document.getElementById('chkFilterWkt').checked;
        var chkViewSyaratProsesHist = document.getElementById('chkViewSyaratProsesHist').checked;
        loadDataUsulanPTK(keywordCari, jenis, status, chkWaktu, chkViewSyaratProsesHist, '', '','jiwa_usulan');
    });

    function loadDefaultDataDraftPTK(){
        loadDataDraftPTK('',<?php echo date("m"); ?>,<?php echo date("Y"); ?>,0,0,'','','jiwa_draft');
    }

    function loadDataDraftPTK(keywordCari, blnGaji, thnGaji, statusNIP, statusDraft, page, ipp, tbl){
        $("#btn_tampilkan_ptk_draft").css("pointer-events", "none");
        $("#btn_tampilkan_ptk_draft").css("opacity", "0.4");
        $("#divListPtkDraft").css("pointer-events", "none");
        $("#divListPtkDraft").css("opacity", "0.4");
        document.getElementById("loader2").style.display = "block";
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "ptk_drop_data_keu_usulan_draft.php",
            data: {
                txtKeyword: keywordCari,
                blnGaji: blnGaji,
                thnGaji: thnGaji,
                statusNIP: statusNIP,
                statusDraft: statusDraft,
                page: page,
                ipp: ipp,
                tbl: tbl}
        }).done(function(data){
            $("#divListPtkDraft").html(data);
            $("#btn_tampilkan_ptk_draft").css("pointer-events", "auto");
            $("#btn_tampilkan_ptk_draft").css("opacity", "1");
            $("#divListPtkDraft").css("pointer-events", "auto");
            $("#divListPtkDraft").css("opacity", "1");
            document.getElementById("loader2").style.display = "none";
        });
    }

    $("#btn_tampilkan_ptk_draft").click(function(){
        var keywordCari = $("#txtKataKunciDraftPtk").val();
        var blnGaji = $('#ddBlnTMTGajiPTKDraft').val();
        var thnGaji = $('#ddThnTMTGajiPTKDraft').val();
        var statusNIP = $('#ddStatusNIPPtk').val();
        var statusDraft = $('#ddStatusDraftPtk').val();
        loadDataDraftPTK(keywordCari, blnGaji, thnGaji, statusNIP, statusDraft, '', '','jiwa_draft');
    });

    function pagingViewListLoad(parm,parm2,parm3){
        if(parm3=='jiwa_usulan'){
            var keywordCari = $("#txtKataKunciDraftPtk").val();
            var jenis = $('#ddJenisPengajuan').val();
            var status = $('#ddStatusPTK').val();
            var chkWaktu = document.getElementById('chkFilterWkt').checked;
            var chkViewSyaratProsesHist = document.getElementById('chkViewSyaratProsesHist').checked;
            loadDataUsulanPTK(keywordCari, jenis, status, chkWaktu, chkViewSyaratProsesHist, parm, parm2, parm3);
        }else if(parm3=='jiwa_draft'){
            var keywordCari = $("#txtKataKunciDraftPtk").val();
            var blnGaji = $('#ddBlnTMTGajiPTKDraft').val();
            var thnGaji = $('#ddThnTMTGajiPTKDraft').val();
            var statusNIP = $('#ddStatusNIPPtk').val();
            var statusDraft = $('#ddStatusDraftPtk').val();
            loadDataDraftPTK(keywordCari, blnGaji, thnGaji, statusNIP, statusDraft, parm, parm2, parm3);
        }
    }

</script>