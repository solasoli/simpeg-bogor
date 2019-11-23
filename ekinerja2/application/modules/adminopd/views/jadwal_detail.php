<!-- jQuery UI -->
<link href="<?php echo base_url('assets/jquery/dist/jquery-ui.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('assets/jquery/dist/jquery-ui.min.js'); ?>"></script>

<!-- MultipleDatesPicker -->
<script type="text/javascript" src="<?php echo base_url('assets/fullcalendar/moment.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/Multiple-Dates-Picker-for-jQuery-UI-latest/jquery-ui.multidatespicker.css'); ?>" >
<script type="text/javascript" src="<?php echo base_url('assets/Multiple-Dates-Picker-for-jQuery-UI-latest/jquery-ui.multidatespicker.js'); ?>"></script>


<div class="row">
    <div class="cell-sm-3">
        <select id="ddBln" name="ddBln" data-role="select" class="cell-sm-12">
            <?php
            $i = 0;
            for ($x = 0; $x <= 11; $x++) {
                if($x==(int)date('m')-1){
                    echo "<option value=".$listBln[$i][0]." selected>".$listBln[$i][1]."</option>";
                }else{
                    echo "<option value=".$listBln[$i][0].">".$listBln[$i][1]."</option>";
                }

                $i++;
            }
            ?>
        </select>
    </div>
    <div class="cell-sm-3">
        <select id="ddThn" name="ddThn" data-role="select" class="cell-sm-12">
            <?php
            $i = 0;
            for ($x = 0; $x < sizeof($listThn); $x++) {
                if($listThn[$i]==date('Y')){
                    echo "<option value=".$listThn[$i]." selected>".$listThn[$i]."</option>";
                }else{
                    echo "<option value=".$listThn[$i].">".$listThn[$i]."</option>";
                }
                $i++;
            }
            ?>
        </select>
    </div>
    <div class="cell-sm-4">
        <select id="ddJenisJadwal" name="ddJenisJadwal" data-role="select" class="cell-sm-12">
            <option value="0">Semua Jenis Jadwal</option>
            <?php if (isset($ref_jenis_jadwal) and sizeof($ref_jenis_jadwal) > 0 and $ref_jenis_jadwal != ''):  ?>
                <?php foreach ($ref_jenis_jadwal as $ls): ?>
                    <option value="<?php echo $ls->id_jenis_jadwal; ?>"><?php echo $ls->jenis; ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
</div>

<div class="row" style="margin-top: 5px;">
    <div class="cell-sm-3">
        <div style="margin-top: 10px;margin-left: 5px;">Pilih Pengelola OPD :</div>
    </div>
    <div class="cell-sm-4">
        <select id="ddInputer" name="ddInputer" class="cell-sm-12">
            <option value="0">Semua Pengelola OPD</option>
            <?php if ($list_inputer_jadwal!=NULL and sizeof($list_inputer_jadwal) > 0 and $list_inputer_jadwal != ''): ?>
                <?php foreach ($list_inputer_jadwal as $lsinp): ?>
                    <option value="<?php echo $lsinp->inputer_enc; ?>"><?php echo $lsinp->nama.' ('.$lsinp->nip_baru.') Jumlah: '.$lsinp->jumlah; ?> Jadwal</option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
    <div class="cell-sm-3">
        <input type="text" id="keywordCari" name="keywordCari" class="cell-sm-12" placeholder="Kata Kunci">
    </div>
</div>


<div class="row" style="margin-top: 5px;">
    <div class="cell-sm-2">
        <div style="margin-top: 10px;margin-left: 5px;">Tgl.Mulai :</div>
    </div>
    <div class="cell-sm-3">
        <div class="input cell-sm-12 calendar-picker">
            <input type="text" id="tglMulaiAcara" value="<?php echo date("m/d/Y"); ?>" style="font-size: 11pt;" readonly>
        </div>
    </div>
    <div class="cell-sm-2">
        <div style="margin-top: 10px;margin-left: 5px;">Tgl.Selesai :</div>
    </div>
    <div class="cell-sm-3">
        <div class="input cell-sm-12 calendar-picker">
            <input type="text" id="tglSelesaiAcara" value="<?php echo date("m/d/Y"); ?>" style="font-size: 11pt;" readonly>
        </div>
    </div>
</div>

<div class="row" style="margin-top: 5px;">
    <div class="cell-sm-4">
        <label><input id="chkFilterTgl" name="chkFilterTgl" type="checkbox" data-role="checkbox" data-style="2">Filter berds. tanggal acara</label>
    </div>

    <div class="cell-sm-4">
        <label><input id="chkCekBerkasRil" name="chkCekBerkasRil" type="checkbox" data-role="checkbox" data-style="2">Cek keberadaan berkas</label>
    </div>

    <div class="cell-sm-2">
        <button id="btnFilter" name="btnFilter" onclick="" type="button" class="button primary bg-grayBlue">
            <span class="mif-search icon"></span> Tampilkan</button>
    </div>
</div>


<div id="divListDetailJadwal"></div>

<script>
    var dateToday = new Date();
    var dates = $("#tglMulaiAcara, #tglSelesaiAcara").datepicker({
        showOn: "button",
        buttonImage: "<?php echo base_url('assets/Multiple-Dates-Picker-for-jQuery-UI-latest/mdp-icon.png'); ?>",
        buttonImageOnly: true,
        buttonText: "Pilih tanggal",
        //defaultDate: "+1w",
        //changeMonth: true,
        numberOfMonths: 1,
        /*minDate: dateToday,*/
        onSelect: function(selectedDate) {
            var option = this.id == "tglMulaiAcara" ? "minDate" : "maxDate",
                instance = $(this).data("datepicker"),
                date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
            dates.not(this).datepicker("option", option, date);
        }
    });

    loadDefaultListJadwalDetail();

    function loadDefaultListJadwalDetail(){
        //$("select#ddBln option").each(function() { this.selected = (this.text == 0); });
        //$("select#ddThn option").each(function() { this.selected = (this.text == 0); });
        $("select#ddJenisJadwal option").each(function() { this.selected = (this.text == 0); });
        $("select#ddInputer option").each(function() { this.selected = (this.text == 0); });
        $('#keywordCari').val("");
        loadDataListJadwalDetail('<?php echo date('m'); ?>','<?php echo date('Y'); ?>','0','0',chkCekBerkasRil,'','','');
    }

    function loadDataListJadwalDetail(ddBln,ddThn,ddJadwal,ddInputer,chkCekBerkasRil,keywordCari,page,ipp){
        $("#btnFilter").css("pointer-events", "none");
        $("#btnFilter").css("opacity", "0.4");
        $("#divListDetailJadwal").css("pointer-events", "none");
        $("#divListDetailJadwal").css("opacity", "0.4");

        var jc = $.confirm({
            title: '',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            boxWidth: '200px',
            useBootstrap: false,
            content: function () {
                var data = new FormData();
                data.append('bln', ddBln);
                data.append('thn', ddThn);
                data.append('idjadwal', ddJadwal);
                data.append('idp', ddInputer);
                if ($('#chkFilterTgl').is(":checked") == true){
                    data.append('tglMulaiAcara', $("#tglMulaiAcara").val());
                    data.append('tglSelesaiAcara', $("#tglSelesaiAcara").val());
                }else{
                    data.append('tglMulaiAcara', '');
                    data.append('tglSelesaiAcara', '');
                }
                data.append('keyword', keywordCari);
                data.append('chkCekBerkasRil', chkCekBerkasRil);
                data.append('page', page);
                data.append('ipp', ipp);
                return $.ajax({
                    url: "<?php echo base_url('adminopd')."/drop_data_list_jadwal_khusus_detail/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    $("#divListDetailJadwal").html(data);
                    $("#btnFilter").css("pointer-events", "auto");
                    $("#btnFilter").css("opacity", "1");
                    $("#divListDetailJadwal").css("pointer-events", "auto");
                    $("#divListDetailJadwal").css("opacity", "1");
                    $("#divListDetailJadwal").find("script").each(function(i) {
                        eval($(this).text());
                    });
                }).fail(function(){
                    $("#divListDetailJadwal").html('Error...telah terjadi kesalahan');
                });
            },
            onContentReady: function () {
                jc.close();
            },
            buttons: {
                refreshList: {
                    text: '.',
                    action: function () {}
                }
            }
        });
    }

    $("#btnFilter").click(function(){
        var ddBln = $('#ddBln').val();
        var ddThn = $('#ddThn').val();
        var ddInputer = $('#ddInputer').val();
        var ddJadwal = $('#ddJenisJadwal').val();
        var keywordCari = $("#keywordCari").val();
        var chkCekBerkasRil;
        if ($('#chkCekBerkasRil').is(":checked") == true){
            chkCekBerkasRil = true;
        }else{
            chkCekBerkasRil = false;
        }
        loadDataListJadwalDetail(ddBln,ddThn,ddJadwal,ddInputer,chkCekBerkasRil,keywordCari,'','');
    });

    function pagingViewListLoad(parm,parm2){
        var ddBln = $('#ddBln').val();
        var ddThn = $('#ddThn').val();
        var ddInputer = $('#ddInputer').val();
        var ddJadwal = $('#ddJenisJadwal').val();
        var keywordCari = $("#keywordCari").val();
        if ($('#chkCekBerkasRil').is(":checked") == true){
            chkCekBerkasRil = true;
        }else{
            chkCekBerkasRil = false;
        }
        loadDataListJadwalDetail(ddBln,ddThn,ddJadwal,ddInputer,chkCekBerkasRil,keywordCari,parm,parm2);
    }
</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBUn6I2tqpiL5IKsdP8YNErsUnBeNPn9O0&libraries=places">
</script>