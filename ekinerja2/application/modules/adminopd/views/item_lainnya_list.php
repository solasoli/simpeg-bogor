<!-- jQuery UI -->
<link href="<?php echo base_url('assets/jquery/dist/jquery-ui.css'); ?>" rel="stylesheet">
<script src="<?php echo base_url('assets/jquery/dist/jquery-ui.min.js'); ?>"></script>

<!-- MultipleDatesPicker -->
<script type="text/javascript" src="<?php echo base_url('assets/fullcalendar/moment.min.js'); ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/Multiple-Dates-Picker-for-jQuery-UI-latest/jquery-ui.multidatespicker.css'); ?>" >
<script type="text/javascript" src="<?php echo base_url('assets/Multiple-Dates-Picker-for-jQuery-UI-latest/jquery-ui.multidatespicker.js'); ?>"></script>


<div class="row">
    <div class="cell-sm-3">
        <select id="ddItemLainnya" name="ddItemLainnya" class="cell-sm-12">
            <option value="0">Pilih Jenis</option>
            <?php if (isset($ref_jenis_item_lain) and sizeof($ref_jenis_item_lain) > 0 and $ref_jenis_item_lain != ''):  ?>
                <?php foreach ($ref_jenis_item_lain as $ls): ?>
                    <option value="<?php echo $ls->id_jenis_item; ?>"><?php echo $ls->jenis_item_lainnya; ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
    <div class="cell-sm-3">
        <select id="ddStsItemLainnya" name="ddStsItemLainnya" class="cell-sm-12">
            <option value="0">Pilih Status</option>
            <?php if (isset($ref_status_item_lain) and sizeof($ref_status_item_lain) > 0 and $ref_status_item_lain != ''):  ?>
                <?php foreach ($ref_status_item_lain as $ls): ?>
                    <option value="<?php echo $ls->id_status_usulan_item_lainnya; ?>"><?php echo $ls->status_usulan_item_lainnya; ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
    <div class="cell-sm-3">
        <input type="text" id="keywordCari" name="keywordCari" class="cell-sm-12" placeholder="Kata Kunci">
    </div>
    <div class="cell-sm-3">
        <button id="btnFilter" name="btnFilter" onclick="" type="button" class="button primary bg-grayBlue">
            <span class="mif-search icon"></span> Tampilkan</button>
    </div>
</div>

<div id="divListItemLainnya"></div>

<script>

    loadDefaultListItemLainnya();

    function loadDefaultListItemLainnya(){
        $("select#ddItemLainnya option").each(function() { this.selected = (this.text == 0); });
        $("select#ddStsItemLainnya option").each(function() { this.selected = (this.text == 0); });
        $('#keywordCari').val("");
        loadDataListItemLainnya('0','0','','','');
    }

    function loadDataListItemLainnya(ddItemLainnya,ddStsItemLainnya,keywordCari,page,ipp){
        $("#btnFilter").css("pointer-events", "none");
        $("#btnFilter").css("opacity", "0.4");
        $("#divListItemLainnya").css("pointer-events", "none");
        $("#divListItemLainnya").css("opacity", "0.4");

        var jc = $.confirm({
            title: '',
            closeIconClass: 'fa fa-close',
            closeIcon: null,
            closeIconClass: false,
            boxWidth: '200px',
            useBootstrap: false,
            content: function () {
                var data = new FormData();
                data.append('user_level', '<?php echo $this->session->userdata('user_level');?>');
                data.append('id_pegawai', '<?php echo $this->session->userdata('id_pegawai_enc');?>');
                data.append('id_skpd', '<?php echo $this->session->userdata('id_skpd_enc');?>');
                data.append('ddItemLainnya', ddItemLainnya);
                data.append('ddStsItemLainnya', ddStsItemLainnya);
                data.append('keyword', keywordCari);
                data.append('page', page);
                data.append('ipp', ipp);
                return $.ajax({
                    url: "<?php echo base_url('adminopd')."/drop_data_list_item_lainnya/";?>",
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    method: 'POST',
                }).done(function (data) {
                    $("#divListItemLainnya").html(data);
                    $("#btnFilter").css("pointer-events", "auto");
                    $("#btnFilter").css("opacity", "1");
                    $("#divListItemLainnya").css("pointer-events", "auto");
                    $("#divListItemLainnya").css("opacity", "1");
                    $("#divListItemLainnya").find("script").each(function(i) {
                        eval($(this).text());
                    });
                }).fail(function(){
                    $("#divListItemLainnya").html('Error...telah terjadi kesalahan');
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
        var ddItemLainnya = $('#ddItemLainnya').val();
        var ddStsItemLainnya = $('#ddStsItemLainnya').val();
        var keywordCari = $("#keywordCari").val();
        loadDataListItemLainnya(ddItemLainnya,ddStsItemLainnya,keywordCari,'','');
    });

    function pagingViewListLoad(parm,parm2){
        var ddItemLainnya = $('#ddItemLainnya').val();
        var ddStsItemLainnya = $('#ddStsItemLainnya').val();
        var keywordCari = $("#keywordCari").val();
        loadDataListItemLainnya(ddItemLainnya,ddStsItemLainnya,keywordCari,parm,parm2);
    }
</script>
