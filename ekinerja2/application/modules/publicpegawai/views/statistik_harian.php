<script src="<?php echo base_url('assets/Highcharts/highcharts.js'); ?>"></script>
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

<div class="row" style="margin-bottom: 15px;">
    <div class="cell-sm-2" style="text-align: center;margin-top: 5px;">
        Periode :
    </div>
    <div class="cell-sm-3">
        <select id="ddBlnStat" name="ddBln" data-role="select" class="cell-sm-12">
            <?php
            $i = 0;
            for ($x = 0; $x <= 11; $x++) {
                echo "<option value=".$listBln[$i][0].($listBln[$i][0]==date('m')?' selected':'').">".$listBln[$i][1]."</option>";
                $i++;
            }
            ?>
        </select>
    </div>
    <div class="cell-sm-3">
        <select id="ddTahunStat" name="ddTahun" data-role="select" class="cell-sm-12">
            <?php
            $i = 0;
            for ($x = 0; $x < sizeof($listThn); $x++) {
                echo "<option value=".$listThn[$i].($listThn[$i]==date('Y')?' selected':'').">".$listThn[$i]."</option>";
                $i++;
            }
            ?>
        </select>
    </div>
    <div class="cell-sm-3">
        <button id="btnFilter" name="btnFilter" onclick="" type="button" class="button primary bg-grayBlue">
            <span class="mif-search icon"></span> Tampilkan</button>
    </div>
</div>

<?php if($this->session->userdata('idknj_admin')!=''): ?>
    <div class="row" style="margin-bottom: 15px;">
        <div class="cell-sm-2" style="text-align: center;margin-top: 5px;">
            Pegawai :
        </div>
        <div class="cell-sm-6">
            <input id="txtPegawai" name="txtPegawai" type="text" placeholder="" style="width:100%;" onkeypress="clearKepala();" value="">
            <input id="idPegawai" name="idPegawai" type="hidden" value="">
            <small class="text-muted">Ketik Nama atau NIP Pegawai</small><br>
        </div>
    </div>
<?php endif; ?>

<div id="dvListData"></div>

<script>
    $(document).ready( function () {
        var options = {
            url: function(phrase) {
                return "<?php echo base_url('publicpegawai/Statistikpegawai/cari_pegawai_by_nama_by_opd'); ?>";
            },
            getValue: function(element) {
                return element.nama_gelar;
            },
            list: {
                onClickEvent: function() {
                    var selectedItemValue = $("#txtPegawai").getSelectedItemData().id_pegawai_enc;
                    $("#idPegawai").val(selectedItemValue);
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
                data.phrase = $("#txtPegawai").val();
                return data;
            },
            requestDelay: 400,
            theme: "round"
        };
        $("#txtPegawai").easyAutocomplete(options);
    });

    $("#btnFilter").click(function(){
        if (typeof $('#idPegawai').val() !== 'undefined' && $('#idPegawai').val() !== '' ) {
            var idPegawai = $('#idPegawai').val();
        }else{
            var idPegawai = '<?php echo $this->session->userdata('id_pegawai_enc'); ?>';
        }
        var ddBln = $('#ddBlnStat').val();
        var ddTahun = $('#ddTahunStat').val();
        loadDataStatistikHarian(idPegawai,ddBln,ddTahun);
    });

    loadDefaultDataStatistikHarian();

    function loadDefaultDataStatistikHarian(){
        if (typeof $('#idPegawai').val() !== 'undefined' && $('#idPegawai').val() !== '' ) {
            var idPegawai = $('#idPegawai').val();
        }else{
            var idPegawai = '<?php echo $this->session->userdata('id_pegawai_enc'); ?>';
        }
        loadDataStatistikHarian(idPegawai,<?php echo date('m'); ?>, <?php echo date('Y'); ?>);
    }

    function loadDataStatistikHarian(idPegawai,ddBln,ddTahun){
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
                data.append('idPegawai', idPegawai);
                data.append('ddBln', ddBln);
                data.append('ddTahun', ddTahun);
                return $.ajax({
                    url: "<?php echo base_url('publicpegawai/Statistikpegawai')."/drop_data_statistik_harian/";?>",
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

    function clearKepala(){
        $("#idPegawai").val('');
    }
</script>