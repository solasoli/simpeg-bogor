<!-- EasyAutoComplete -->
<link rel="stylesheet" href="<?php echo base_url('assets/EasyAutocomplete-1.3.5/easy-autocomplete.css'); ?>" >
<script type="text/javascript" src="<?php echo base_url('assets/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js'); ?>"></script>

<style>
    .eac-round{
        width: 100%!important;
    }

    .eac-square input, .eac-round input {
        background-image: url("<?php echo base_url('assets/images/if_icon-111-search_314478-32.png'); ?>");
        background-repeat: no-repeat;
        background-position: right 10px center;
    }
</style>

<div class="panel-content" data-role="panel"
     data-title-caption="Laporan Kinerja OPD"
     data-title-icon=""
     data-cls-title=" fg-black">

    <ul class="tabs-expand-md" data-role="tabs" style="font-size: small;font-weight: bold;">
        <li id="tbList"><a href="#tab1">Pencarian Informasi</a></li>
        <li id="tbPrint"><a href="#tab2">Download PDF</a></li>
    </ul>

    <div class="border bd-default no-border-top p-2">
        <div id="tab1">
            <div class="row">
                <div class="cell-sm-6">
                    <select id="ddStatusLaporan" name="ddStatusLaporan" data-role="select" class="cell-sm-12">
                        <option value="0">Semua Status Laporan</option>
                        <option value="2">Proses Pengisian Kegiatan dan Disiplin Kinerja</option>
                        <option value="3">Pengisian Laporan Kinerja Selesai</option>
                    </select>
                </div>
                <div class="cell-sm-3">
                    <select id="ddJenjab" name="ddJenjab" data-role="select" class="cell-sm-12">
                        <option value="0">Semua Jenjab</option>
                        <option value="Struktural">Struktural</option>
                        <option value="Fungsional">Fungsional</option>
                    </select>
                </div>
                <div class="cell-sm-3">
                    <select id="ddEselon" name="ddEselon" data-role="select" class="cell-sm-12">
                        <option value="0">Semua Eselon</option>
                        <option value="IIA">IIA</option>
                        <option value="IIB">IIB</option>
                        <option value="IIIA">IIIA</option>
                        <option value="IIIB">IIIB</option>
                        <option value="IVA">IVA</option>
                        <option value="IVB">IVB</option>
                    </select>
                </div>
            </div>

            <div class="row" style="margin-top: 10px;">
                <div class="cell-sm-6">
                    <input type="text" id="keywordCari" name="keywordCari" class="cell-sm-12" placeholder="Kata Kunci NIP / Nama / Jabatan">
                </div>
                <div class="cell-sm-3">
                    <select id="ddBln" name="ddBln" data-role="select" class="cell-sm-12">
                        <option value="0">Semua Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">Nopember</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="cell-sm-3">
                    <select id="ddTahun" name="ddTahun" data-role="select" class="cell-sm-12">
                        <option value="0">Semua Tahun</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                    </select>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="cell-sm-12">
                    <button id="btnFilter" name="btnFilter" onclick="" type="button" class="button primary bg-grayBlue">
                        <span class="mif-search icon"></span> Tampilkan</button>
                </div>
            </div>
        </div>
        <div id="tab2">
            <div class="row">
                <div class="cell-sm-3">
                    Periode :<br>
                    <select id="ddBlnPrint" name="ddBln" data-role="select" class="cell-sm-12">
                        <option value="0">Pilih Bulan</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">Nopember</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="cell-sm-3">
                    &nbsp;<br>
                    <select id="ddTahunPrint" name="ddTahun" data-role="select" class="cell-sm-12">
                        <option value="0">Pilih Tahun</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                    </select>
                </div>
            </div>
            <div class="row mb-2" style="margin-top: 10px;">
                <div class="cell-sm-6">
                    Penandatangan Laporan eKinerja :<br>
                    <input id="txtKepala" name="txtKepala" type="text" placeholder="Ketik Nama/NIP Kepala OPD" style="width:100%;" onkeypress="clearKepala();" value="">
                    <input id="idKepala" name="idKepala" type="hidden" value="">
                    <small class="text-muted">Sebagai Kepala OPD</small><br>
                </div>
                <div class="cell-sm-4">&nbsp;<br>
                    <select id="ddIsWakilKepala" name="ddIsWakilKepala" data-role="select" class="cell-sm-12">
                        <option value="0">Bukan yang mewakili</option>
                        <option value="1">Sebagai yang mewakili</option>
                    </select>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="cell-sm-6">
                    <input id="txtBendahara" name="txtBendahara" type="text" placeholder="Ketik Nama/NIP Bendahara" style="width:100%;" onkeypress="clearBendahara();" value="">
                    <input id="idBendahara" name="idBendahara" type="hidden" value="">
                    <small class="text-muted">Sebagai Bendahara</small><br>
                </div>
                <div class="cell-sm-4">
                    <select id="ddIsWakilBendahara" name="ddIsWakilBendahara" data-role="select" class="cell-sm-12">
                        <option value="0">Bukan yang mewakili</option>
                        <option value="1">Sebagai yang mewakili</option>
                    </select>
                </div>
            </div>
            <div class="row" style="margin-top: 10px;">
                <div class="cell-sm-12">
                    <button id="btnCetakLaporan" type="button" class="button primary bg-darkBlue">
                        <span class="mif-file-pdf icon"></span> Download Rekap Per Periode</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="cell-sm-12">
            <div id="dvListData"></div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready( function () {
        var options = {
            url: function(phrase) {
                return "<?php echo base_url('adminopd/cari_pegawai_by_nama'); ?>";
            },
            getValue: function(element) {
                return element.nama_gelar;
            },
            list: {
                onClickEvent: function() {
                    var selectedItemValue = $("#txtKepala").getSelectedItemData().id_pegawai_enc;
                    $("#idKepala").val(selectedItemValue);
                }
            },
            ajaxSettings: {
                dataType: "json",
                method: "POST",
                data: {
                    dataType: "json"
                }
            },
            preparePostData: function(data) {
                data.phrase = $("#txtKepala").val();
                return data;
            },
            requestDelay: 400,
            theme: "round"
        };
        $("#txtKepala").easyAutocomplete(options);

        var options2 = {
            url: function(phrase) {
                return "<?php echo base_url('adminopd/cari_pegawai_by_nama'); ?>";
            },
            getValue: function(element) {
                return element.nama_gelar;
            },
            list: {
                onClickEvent: function() {
                    var selectedItemValue = $("#txtBendahara").getSelectedItemData().id_pegawai_enc;
                    $("#idBendahara").val(selectedItemValue);
                }
            },
            ajaxSettings: {
                dataType: "json",
                method: "POST",
                data: {
                    dataType: "json"
                }
            },
            preparePostData: function(data) {
                data.phrase = $("#txtBendahara").val();
                return data;
            },
            requestDelay: 400,
            theme: "round"
        };
        $("#txtBendahara").easyAutocomplete(options2);

    });

    loadDefaultDaftarKinerjaOPD();

    function loadDefaultDaftarKinerjaOPD(){
        $("select#ddStatusLaporan option").each(function() { this.selected = (this.text == 0); });
        $("select#ddJenjab option").each(function() { this.selected = (this.text == 0); });
        $("select#ddEselon option").each(function() { this.selected = (this.text == 0); });
        $("select#ddBln option").each(function() { this.selected = (this.text == 0); });
        $("select#ddTahun option").each(function() { this.selected = (this.text == 0); });
        $('#keywordCari').val("");
        loadDataDaftarKinerjaOPD(0,0,0,'',0,0,'','');
    }

    function loadDataDaftarKinerjaOPD(ddStatusLaporan,ddJenjab,ddEselon,keywordCari,ddBln,ddTahun,page,ipp){
        $("#btnFilter").css("pointer-events", "none");
        $("#btnFilter").css("opacity", "0.4");
        $("#dvListData").css("pointer-events", "none");
        $("#dvListData").css("opacity", "0.4");
        var jc = $.confirm({
            title: '',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            boxWidth: '200px',
            useBootstrap: false,
            content: function () {
                var data = new FormData();
                data.append('ddStatusLaporan', ddStatusLaporan);
                data.append('ddJenjab', ddJenjab);
                data.append('ddEselon', ddEselon);
                data.append('keywordCari', keywordCari);
                data.append('ddBln', ddBln);
                data.append('ddTahun', ddTahun);
                data.append('page', page);
                data.append('ipp', ipp);
                return $.ajax({
                    url: "<?php echo base_url('adminopd')."/drop_data_laporan_kinerja_pegawai_opd/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    $("#dvListData").html(data);
                    $("#btnFilter").css("pointer-events", "auto");
                    $("#btnFilter").css("opacity", "1");
                    $("#dvListData").css("pointer-events", "auto");
                    $("#dvListData").css("opacity", "1");
                    $("#dvListData").find("script").each(function(i) {
                        eval($(this).text());
                    });
                }).fail(function(){
                    $("#dvListData").html('Error...telah terjadi kesalahan');
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
        var ddStatusLaporan = $('#ddStatusLaporan').val();
        var ddJenjab = $('#ddJenjab').val();
        var ddEselon = $('#ddEselon').val();
        var ddBln = $('#ddBln').val();
        var ddTahun = $('#ddTahun').val();
        var keywordCari = $("#keywordCari").val();
        loadDataDaftarKinerjaOPD(ddStatusLaporan,ddJenjab,ddEselon,keywordCari,ddBln,ddTahun,'','');
    });

    function pagingViewListLoad(parm,parm2){
        var ddStatusLaporan = $('#ddStatusLaporan').val();
        var ddJenjab = $('#ddJenjab').val();
        var ddEselon = $('#ddEselon').val();
        var ddBln = $('#ddBln').val();
        var ddTahun = $('#ddTahun').val();
        var keywordCari = $("#keywordCari").val();
        loadDataDaftarKinerjaOPD(ddStatusLaporan,ddJenjab,ddEselon,keywordCari,ddBln,ddTahun,parm,parm2);
    }

    $("#btnCetakLaporan").click(function(){
        var ddBln = $('#ddBlnPrint').val();
        var ddTahun = $('#ddTahunPrint').val();
        var idPegKepala = $('#idKepala').val();
        var idPegBendahara = $('#idBendahara').val();
        var ddIsWakilKepala = $('#ddIsWakilKepala').val();
        var ddIsWakilBendahara = $('#ddIsWakilBendahara').val();

        if(ddBln==0 || ddTahun==0 || idPegKepala==0 || idPegBendahara==0){
            alert('Tentukan dahulu bulan dan tahun serta nama kepala OPD dan bendahara');
        }else{
            window.open('/ekinerja2/<?php echo $usr;?>/cetak_laporan_nominatif_opd/' + ddBln + '/' + ddTahun + '/' + idPegKepala + '/' + ddIsWakilKepala + '/' + idPegBendahara + '/' + ddIsWakilBendahara, '_blank');
        }
    });

    function clearKepala(){
        $("#idKepala").val('');
    }

    function clearBendahara(){
        $("#idBendahara").val('');
    }

</script>