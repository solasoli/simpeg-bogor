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

extract($_POST);
extract($_GET);


    if($y=='simpeg'){
        $judul = 'SIMPEG';
    }elseif($y=='simgaji'){
        $judul = 'SIMGAJI';
    }else{
        echo 'Halaman tidak ditemukan';
        exit();
    }

?>

<h3>Peninjauan Data Kepegawaian <?php echo $judul; ?></h3>

<div class="row" style="margin-top: 20px;">
    <div class="col-md-3">
        <input type="text" class="form-control" id="txtKataKunci" name="txtKataKunci" placeholder="Keyword (NIP,Nama,Jabatan)">
    </div>
    <?php if($y=='simpeg'): ?>
    <div class="col-md-2" style="margin-left: -15px;">
        <select class="form-control" id="ddFlagPensiun" name="ddFlagPensiun">
            <option value="0">Masih Aktif</option>
            <option value="1">Sudah Pensiun</option>
        </select>
    </div>
    <div class="col-md-2" style="margin-left: -15px;">
        <select class="form-control" id="ddJenjab" name="ddJenjab">
            <option value="Struktural">Struktural</option>
            <option value="Fungsional">Fungsional</option>
        </select>
    </div>
    <div class="col-md-2" style="margin-left: -15px;">
        <select class="form-control" id="ddEselon">
            <option value="0">Semua Jenjang</option>
            <option value="IIA">Eselon IIA</option>
            <option value="IIB" selected>Eselon IIB</option>
            <option value="IIIA">Eselon IIIA</option>
            <option value="IIIB">Eselon IIIB</option>
            <option value="IVA">Eselon IVA</option>
            <option value="IVB">Eselon IVB</option>
            <option value="Z">Staf / Fungsional</option>
        </select>
    </div>
    <div class="col-md-3" style="margin-left: -15px;">
        <select class="form-control" id="ddStsNIP" name="ddStsNIP">
            <option value="0">NIP ditemukan di SIMGAJI</option>
            <option value="1">NIP tidak ditemukan di SIMGAJI</option>
        </select>
    </div>
</div>

<div class="row" style="margin-top: 10px;">
    <div class="col-md-2" style="width: 250px;">
        <select class="form-control" id="ddStsGol" name="ddStsGol">
            <option value="0">Gol.SIMPEG = Gol.SIMGAJI</option>
            <option value="1">Gol.SIMPEG > Gol.SIMGAJI</option>
            <option value="2">Gol.SIMPEG < Gol.SIMGAJI</option>
        </select>
    </div>
    <div class="col-md-2" style="margin-top: 8px;"><strong>Status di SIMGAJI : </strong></div>
    <div class="col-md-3" style="margin-left: -30px;">
        <select class="form-control" id="ddStsPegSimG">
            <?php
            $sql = "SELECT * FROM gaji_stapeg_tbl gst WHERE gst.KDSTAPEG NOT IN (1,2,22,11)";
            $query = $mysqli->query($sql);
            while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                if($oto[0]==4){
                    echo("<option value=$oto[0] selected>$oto[1]</option>");
                }else{
                    echo("<option value=$oto[0]>$oto[1]</option>");
                }
            }
            ?>
        </select>
    </div>
    <div class="col-md-2" style="margin-left: -15px;">
        <button type="button" class="btn btn-primary" id="btn_tampilkan" name="btn_tampilkan">
            Tampilkan</button>
    </div>
    <?php elseif($y=='simgaji'):?>
        <div class="col-md-3" style="margin-left: -20px;">
            <select class="form-control" id="ddStsPegSimG">
                <?php
                $sql = "SELECT * FROM gaji_stapeg_tbl gst WHERE gst.KDSTAPEG NOT IN (1,2,22,11)";
                $query = $mysqli->query($sql);
                while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                    if($oto[0]==4){
                        echo("<option value=$oto[0] selected>$oto[1]</option>");
                    }else{
                        echo("<option value=$oto[0]>$oto[1]</option>");
                    }
                }
                ?>
            </select>
        </div>

        <div class="col-md-2" style="width: 250px;margin-left: -20px;">
            <select class="form-control" id="ddStsGol" name="ddStsGol">
                <option value="0">Gol.SIMGAJI = Gol.SIMPEG</option>
                <option value="1">Gol.SIMGAJI > Gol.SIMPEG</option>
                <option value="2">Gol.SIMGAJI < Gol.SIMPEG</option>
            </select>
        </div>

        <div class="col-md-3" style="margin-left: -15px;">
            <select class="form-control" id="ddStsNIP" name="ddStsNIP">
                <option value="0">NIP ditemukan di SIMPEG</option>
                <option value="1">NIP tidak ditemukan di SIMPEG</option>
            </select>
        </div>

    <div class="row" style="margin-top: 45px;">
        <div class="col-md-2" style="margin-top: 8px;margin-left: 15px;"><strong>Status di SIMPEG : </strong></div>
        <div class="col-md-2" style="margin-left: -35px;">
            <select class="form-control" id="ddFlagPensiun" name="ddFlagPensiun">
                <option value="0">Masih Aktif</option>
                <option value="1">Sudah Pensiun</option>
            </select>
        </div>
        <div class="col-md-2" style="margin-left: -15px;">
            <select class="form-control" id="ddJenjab" name="ddJenjab">
                <option value="Struktural">Struktural</option>
                <option value="Fungsional">Fungsional</option>
            </select>
        </div>
        <div class="col-md-2" style="margin-left: -15px;">
            <select class="form-control" id="ddEselon">
                <option value="0">Semua Jenjang</option>
                <option value="IIA">Eselon IIA</option>
                <option value="IIB" selected>Eselon IIB</option>
                <option value="IIIA">Eselon IIIA</option>
                <option value="IIIB">Eselon IIIB</option>
                <option value="IVA">Eselon IVA</option>
                <option value="IVB">Eselon IVB</option>
                <option value="Z">Staf / Fungsional</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-2" style="margin-top: 15px;margin-left: 15px;"><strong>Status Keluarga : </strong></div>
        <div class="col-md-3" style="margin-left: -35px;margin-top: 8px;">
            <select class="form-control" id="ddStsJmlKeluarga" name="ddStsJmlKeluarga">
                <option value="-1">Semua Status Jml Keluarga</option>
                <option value="1">Jumlah Keluarga Sama</option>
                <option value="0">Jumlah Keluarga Tidak Sama</option>
            </select>
        </div>
        <div class="col-md-3" style="margin-left: -15px;margin-top: 8px;">
            <select class="form-control" id="ddStsJmlPasangan" name="ddStsJmlPasangan">
                <option value="-1">Semua Status Jml Pasangan</option>
                <option value="1">Jumlah Pasangan Sama</option>
                <option value="0">Jumlah Pasangan Tidak Sama</option>
            </select>
        </div>
        <div class="col-md-3" style="margin-left: -15px;margin-top: 8px;">
            <select class="form-control" id="ddStsJmlAnak" name="ddStsJmlAnak">
                <option value="-1">Semua Status Jml Anak</option>
                <option value="1">Jumlah Anak Sama</option>
                <option value="0">Jumlah Anak Tidak Sama</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4" style="margin-left: 15px;margin-top: 8px;">
            <select class="form-control" id="ddStsJmlPasanganDapat" name="ddStsJmlPasanganDapat">
                <option value="-1">Semua Status Jml Pasangan Tertunjang</option>
                <option value="1">Jumlah Pasangan Tertunjang Sama</option>
                <option value="0">Jumlah Pasangan Tertunjang Tidak Sama</option>
            </select>
        </div>
        <div class="col-md-4" style="margin-left: -15px;margin-top: 8px;">
            <select class="form-control" id="ddStsJmlAnakDapat" name="ddStsJmlAnakDapat">
                <option value="-1">Semua Status Jml Anak Tertunjang</option>
                <option value="1">Jumlah Anak Tertunjang Sama</option>
                <option value="0">Jumlah Anak Tertunjang Tidak Sama</option>
            </select>
        </div>
        <div class="col-md-2" style="margin-top: 8px;margin-left: -15px;">
            <button type="button" class="btn btn-primary" id="btn_tampilkan" name="btn_tampilkan">
                Tampilkan</button>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="row">
    <div id="loader" class="loader"></div>
    <div id="divListPegawai"></div>
</div>

<script type="text/javascript">

    <?php if($y=='simpeg'): ?>

        $(document).ready(function(){
            document.getElementById("loader").style.display = "none";
            loadDefaultDataPegawaiSimpeg();
        });

        function loadDefaultDataPegawaiSimpeg(){
            loadDataPegawaiSimpeg('',0,'Struktural','IIB',0,0,4,'','');
        }

        function loadDataPegawaiSimpeg(keywordCari, flagPensiun, jenjab, eselon, stsgol, stsnip, stspegsimg, page, ipp){
            $("#btn_tampilkan").css("pointer-events", "none");
            $("#btn_tampilkan").css("opacity", "0.4");
            $("#divListPegawai").css("pointer-events", "none");
            $("#divListPegawai").css("opacity", "0.4");
            document.getElementById("loader").style.display = "block";
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "ptk_keu_simpeg_list.php",
                data: {
                    txtKeyword: keywordCari,
                    flagPensiun: flagPensiun,
                    jenjab: jenjab,
                    eselon: eselon,
                    stsgol: stsgol,
                    stsnip: stsnip,
                    stspegsimg: stspegsimg,
                    page: page,
                    ipp: ipp}
            }).done(function(data){
                $("#divListPegawai").html(data);
                $("#btn_tampilkan").css("pointer-events", "auto");
                $("#btn_tampilkan").css("opacity", "1");
                $("#divListPegawai").css("pointer-events", "auto");
                $("#divListPegawai").css("opacity", "1");
                document.getElementById("loader").style.display = "none";
            });
        };

        $("#btn_tampilkan").click(function(){
            var keywordCari = $("#txtKataKunci").val();
            var ddFlagPensiun = $('#ddFlagPensiun').val();
            var ddJenjab = $('#ddJenjab').val();
            var ddEselon = $('#ddEselon').val();
            var ddStsGol = $('#ddStsGol').val();
            var ddStsNIP = $('#ddStsNIP').val();
            var ddStsPegSimG = $('#ddStsPegSimG').val();
            loadDataPegawaiSimpeg(keywordCari, ddFlagPensiun, ddJenjab, ddEselon, ddStsGol, ddStsNIP, ddStsPegSimG, '', '');
        });

        function pagingViewListLoad(parm,parm2){
            var keywordCari = $("#txtKataKunci").val();
            var ddFlagPensiun = $('#ddFlagPensiun').val();
            var ddJenjab = $('#ddJenjab').val();
            var ddEselon = $('#ddEselon').val();
            var ddStsGol = $('#ddStsGol').val();
            var ddStsNIP = $('#ddStsNIP').val();
            var ddStsPegSimG = $('#ddStsPegSimG').val();
            loadDataPegawaiSimpeg(keywordCari, ddFlagPensiun, ddJenjab, ddEselon, ddStsGol, ddStsNIP, ddStsPegSimG, parm, parm2);
        }

    <?php elseif($y=='simgaji'):?>

        $(document).ready(function(){
            document.getElementById("loader").style.display = "none";
            loadDefaultDataPegawaiSimgaji();
        });

        function loadDefaultDataPegawaiSimgaji(){
            loadDataPegawaiSimgaji('',4,0,0,0,'Struktural','IIB',-1,-1,-1,-1,-1,'','');
        }

        function loadDataPegawaiSimgaji(keywordCari, stspegsimg, stsgol, stsnip, flagPensiun, jenjab, eselon, ddStsJmlKeluarga, ddStsJmlPasangan, ddStsJmlAnak, ddStsJmlPasanganDapat, ddStsJmlAnakDapat, page, ipp){
            $("#btn_tampilkan").css("pointer-events", "none");
            $("#btn_tampilkan").css("opacity", "0.4");
            $("#divListPegawai").css("pointer-events", "none");
            $("#divListPegawai").css("opacity", "0.4");
            document.getElementById("loader").style.display = "block";
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "ptk_keu_simgaji_list.php",
                data: {
                    txtKeyword: keywordCari,
                    stspegsimg: stspegsimg,
                    stsgol: stsgol,
                    stsnip: stsnip,
                    flagPensiun: flagPensiun,
                    jenjab: jenjab,
                    eselon: eselon,
                    ddStsJmlKeluarga: ddStsJmlKeluarga,
                    ddStsJmlPasangan: ddStsJmlPasangan,
                    ddStsJmlAnak: ddStsJmlAnak,
                    ddStsJmlPasanganDapat: ddStsJmlPasanganDapat,
                    ddStsJmlAnakDapat: ddStsJmlAnakDapat,
                    page: page,
                    ipp: ipp}
            }).done(function(data){
                $("#divListPegawai").html(data);
                $("#btn_tampilkan").css("pointer-events", "auto");
                $("#btn_tampilkan").css("opacity", "1");
                $("#divListPegawai").css("pointer-events", "auto");
                $("#divListPegawai").css("opacity", "1");
                document.getElementById("loader").style.display = "none";
            });
        }

        $("#btn_tampilkan").click(function(){
            var keywordCari = $("#txtKataKunci").val();
            var ddStsPegSimG = $('#ddStsPegSimG').val();
            var ddStsGol = $('#ddStsGol').val();
            var ddStsNIP = $('#ddStsNIP').val();
            var ddFlagPensiun = $('#ddFlagPensiun').val();
            var ddJenjab = $('#ddJenjab').val();
            var ddEselon = $('#ddEselon').val();
            var ddStsJmlKeluarga = $('#ddStsJmlKeluarga').val();
            var ddStsJmlPasangan = $('#ddStsJmlPasangan').val();
            var ddStsJmlAnak = $('#ddStsJmlAnak').val();
            var ddStsJmlPasanganDapat = $('#ddStsJmlPasanganDapat').val();
            var ddStsJmlAnakDapat = $('#ddStsJmlAnakDapat').val();
            loadDataPegawaiSimgaji(keywordCari, ddStsPegSimG, ddStsGol, ddStsNIP, ddFlagPensiun, ddJenjab, ddEselon, ddStsJmlKeluarga, ddStsJmlPasangan, ddStsJmlAnak, ddStsJmlPasanganDapat, ddStsJmlAnakDapat, '', '');
        });

        function pagingViewListLoad(parm,parm2){
            var keywordCari = $("#txtKataKunci").val();
            var ddStsPegSimG = $('#ddStsPegSimG').val();
            var ddStsGol = $('#ddStsGol').val();
            var ddStsNIP = $('#ddStsNIP').val();
            var ddFlagPensiun = $('#ddFlagPensiun').val();
            var ddJenjab = $('#ddJenjab').val();
            var ddEselon = $('#ddEselon').val();
            var ddStsJmlKeluarga = $('#ddStsJmlKeluarga').val();
            var ddStsJmlPasangan = $('#ddStsJmlPasangan').val();
            var ddStsJmlAnak = $('#ddStsJmlAnak').val();
            var ddStsJmlPasanganDapat = $('#ddStsJmlPasanganDapat').val();
            var ddStsJmlAnakDapat = $('#ddStsJmlAnakDapat').val();
            loadDataPegawaiSimgaji(keywordCari, ddStsPegSimG, ddStsGol, ddStsNIP, ddFlagPensiun, ddJenjab, ddEselon, ddStsJmlKeluarga, ddStsJmlPasangan, ddStsJmlAnak, ddStsJmlPasanganDapat, ddStsJmlAnakDapat, parm, parm2);
        }

    <?php endif; ?>
</script>