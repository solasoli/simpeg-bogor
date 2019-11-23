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
<h3>Data Kekeluargaan Pegawai</h3>
<div role="tabpanel">
    <ul class="nav nav-tabs" role="tablist" id="myTab_PTK">
        <li role="presentation" class="active"><a href="#list_pegawai" aria-controls="list_pegawai" role="tab" data-toggle="tab">Daftar Pegawai</a></li>
        <li role="presentation"><a href="#list_family" aria-controls="list_family" role="tab" data-toggle="tab">Daftar Keluarga</a></li>
    </ul>
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="list_pegawai">
            <div class="row" style="margin-top: 20px;">
                <div class="col-md-2">
                    <input type="text" class="form-control" id="txtKataKunci" name="txtKataKunci" placeholder="Kata Kunci"></div>
                <div class="col-md-3" style="margin-left: -15px;">
                    <select class="form-control" id="ddEselon">
                        <option value="0">Semua Eselon</option>
                        <option value="IIA">Eselon IIA</option>
                        <option value="IIB">Eselon IIB</option>
                        <option value="IIIA">Eselon IIIA</option>
                        <option value="IIIB">Eselon IIIB</option>
                        <option value="IVA">Eselon IVA</option>
                        <option value="IVB">Eselon IVB</option>
                        <option value="Z">Staf / Fungsional</option>
                    </select>
                </div>
                <div class="col-md-3" style="margin-left: -15px;">
                    <select class="form-control" id="ddStatusVerif">
                        <option value="0">Semua Status</option>
                        <option value="1">Sesuai</option>
                        <option value="2">Kemungkinan Tunjangan Ikut Pasangan</option>
                        <option value="3">Perlu disesuaikan</option>
                    </select>
                </div>
                <div class="col-md-2" style="margin-left: -15px;">
                    <button type="button" class="btn btn-primary" id="btn_tampilkan_peg" name="btn_tampilkan_peg">Tampilkan</button>
                </div>
            </div><br>
            <div style="margin-top: -10px;">
                <span style="font-size: small;">Kata Kunci NIP, Nama Pegawai atau Jabatan</span> <strong>|</strong>
                Keterangan :  <span class="label label-success">&nbsp;&nbsp;&nbsp;</span> Sesuai
                <span class="label label-warning">&nbsp;&nbsp;&nbsp;</span> Kemungkinan tunjangan ikut pasangan
                <span class="label label-danger">&nbsp;&nbsp;&nbsp;</span> Perlu disesuaikan
            </div>
            <div class="row">
                <div id="loader" class="loader"></div>
                <div id="divListPegawai"></div>
            </div>
        </div>
        <div role="tabpanel" class="tab-pane" id="list_family">
            <div class="row" style="margin-top: 20px;">
                <div class="col-md-2">
                    <input type="text" class="form-control" id="txtKeyword" name="txtKeyword" placeholder="Kata Kunci"></div>
                <div class="col-md-3" style="margin-left: -15px;">
                    <select class="form-control" id="ddStsTunjSkum">
                        <option value="0">Semua Status SKUM</option>
                        <option value="Dapat">Dapat</option>
                        <option value="Tidak Dapat">Tidak Dapat</option>
                    </select>
                </div>
                <div class="col-md-3" style="margin-left: -15px;">
                    <select class="form-control" id="ddStsValidasi">
                        <option value="0">Semua Status Validasi</option>
                        <option value="Valid">Valid</option>
                        <option value="Belum Valid / Tunjangan di Pasangan">Belum Valid / Tunjangan di Pasangan</option>
                    </select>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="col-md-3">
                    <select class="form-control" id="ddStsKeluarga">
                        <option value="0">Semua Status Keluarga</option>
                        <?php
                        $sql = "SELECT * FROM status_kel";
                        $query = $mysqli->query($sql);
                        while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                            echo("<option value=$oto[0]>$oto[1]</option>");
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-2" style="margin-left: -15px;">
                    <select id="ddOperator" class="form-control" >
                        <option value="0">Semua Umur</option>
                        <option value="<=">Umur <= </option>
                        <option value=">=">Umur >=</option>
                    </select>
                </div>
                <div class="col-md-1" style="margin-left: -15px;">
                    <input type="text" class="form-control" id="txtUmur" name="txtUmur" placeholder="" >
                </div>
                <div class="col-md-2" style="margin-left: -15px;">
                    <button type="button" class="btn btn-primary" id="btn_tampilkan" name="btn_tampilkan">
                        Tampilkan</button>
                </div>
            </div><br>
            <div style="font-size: small;margin-top: -10px;">Kata Kunci NIP, Nama Pegawai atau Nama Keluarga</div>
            <div class="row">
                <div id="loader2" class="loader"></div>
                <div id="divListKeluarga"></div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        document.getElementById("loader").style.display = "none";
        document.getElementById("loader2").style.display = "none";
        loadDefaultListPegawai();
        loadDefaultListKeluarga();
    });

    $("#btn_tampilkan_peg").click(function(){
        var keywordCari = $("#txtKataKunci").val();
        var eselon = $('#ddEselon').val();
        var stsVerif = $('#ddStatusVerif').val();
        loadDataListPegawai(<?php echo $_SESSION['id_skpd']; ?>, keywordCari, eselon, stsVerif, '', '', 'ptk_pegawai');
    });

    function loadDefaultListPegawai(){
        loadDataListPegawai(<?php echo $_SESSION['id_skpd']; ?>,'','0','0','','','ptk_pegawai');
    }

    function loadDataListPegawai(idskpd, keywordCari, eselon, stsVerif, page, ipp, tbl){
        $("#btn_tampilkan_peg").css("pointer-events", "none");
        $("#btn_tampilkan_peg").css("opacity", "0.4");
        $("#divListPegawai").css("pointer-events", "none");
        $("#divListPegawai").css("opacity", "0.4");
        document.getElementById("loader").style.display = "block";
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "ptk_drop_data_list_pegawai.php",
            data: { idskpd: idskpd,
                txtKeyword: keywordCari,
                eselon: eselon,
                stsVerif: stsVerif,
                page: page,
                ipp: ipp,
                tbl: tbl}
        }).done(function(data){
            $("#divListPegawai").html(data);
            $("#btn_tampilkan_peg").css("pointer-events", "auto");
            $("#btn_tampilkan_peg").css("opacity", "1");
            $("#divListPegawai").css("pointer-events", "auto");
            $("#divListPegawai").css("opacity", "1");
            document.getElementById("loader").style.display = "none";
        });
    }

    $("#btn_tampilkan").click(function(){
        var keywordCari = $("#txtKeyword").val();
        var stsSkum = $('#ddStsTunjSkum').val();
        var stsValidasi = $('#ddStsValidasi').val();
        var ddStsKeluarga = $('#ddStsKeluarga').val();
        var operator = $('#ddOperator').val();
        var umur = $('#txtUmur').val();
        loadDataListKeluarga(<?php echo $_SESSION['id_skpd']; ?>, keywordCari, stsSkum, stsValidasi, ddStsKeluarga, operator, umur, '', '', 'ptk_keluarga');
    });

    function loadDefaultListKeluarga(){
        loadDataListKeluarga(<?php echo $_SESSION['id_skpd']; ?>,'','0','0','0','0','',1,10,'ptk_keluarga');
    }

    function loadDataListKeluarga(idskpd, keywordCari, stsSkum, stsValidasi, ddStsKeluarga, operator, umur, page, ipp, tbl){
        $("#btn_tampilkan").css("pointer-events", "none");
        $("#btn_tampilkan").css("opacity", "0.4");
        $("#divListKeluarga").css("pointer-events", "none");
        $("#divListKeluarga").css("opacity", "0.4");
        document.getElementById("loader2").style.display = "block";
        $.ajax({
            type: "POST",
            dataType: "html",
            url: "drop_data_list_keluarga.php",
            data: { idskpd: idskpd,
                txtKeyword: keywordCari,
                stsSkum: stsSkum,
                stsValidasi: stsValidasi,
                stskeluarga: ddStsKeluarga,
                operator: operator,
                umur: umur,
                page: page,
                ipp: ipp,
                tbl: tbl}
        }).done(function(data){
            $("#divListKeluarga").html(data);
            $("#btn_tampilkan").css("pointer-events", "auto");
            $("#btn_tampilkan").css("opacity", "1");
            $("#divListKeluarga").css("pointer-events", "auto");
            $("#divListKeluarga").css("opacity", "1");
            document.getElementById("loader2").style.display = "none";
        });
    }

    function pagingViewListLoad(parm,parm2,parm3){
        if(parm3=='ptk_keluarga'){
            var keywordCari = $("#txtKeyword").val();
            var stsSkum = $('#ddStsTunjSkum').val();
            var stsValidasi = $('#ddStsValidasi').val();
            var ddStsKeluarga = $('#ddStsKeluarga').val();
            var operator = $('#ddOperator').val();
            var umur = $('#txtUmur').val();
            loadDataListKeluarga(<?php echo $_SESSION['id_skpd']; ?>, keywordCari, stsSkum, stsValidasi, ddStsKeluarga, operator, umur, parm, parm2, parm3);
        }else if(parm3=='ptk_pegawai'){
            var keywordCari = $("#txtKataKunci").val();
            var eselon = $('#ddEselon').val();
            var stsVerif = $('#ddStatusVerif').val();
            loadDataListPegawai(<?php echo $_SESSION['id_skpd']; ?>, keywordCari, eselon, stsVerif, parm, parm2, parm3);
        }
    }

</script>