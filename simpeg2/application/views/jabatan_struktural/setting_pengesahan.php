<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script src="<?php echo base_url()?>js/jquery/jquery.validate.js"></script>

<script>
    $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" }); //select
    jQuery.validator.addMethod(
        "selectComboboxCheck",
        function (value, element)
        {
            if (element.value === "0") {
                return false;
            }else {
                return true;
            }
        },
        "Anda belum memilih Nomor SK Tim Baperjakat"
    );

    $.validator.addMethod("time24", function(value, element) {
        if (!/^\d{2}:\d{2}:\d{2}$/.test(value)) return false;
        var parts = value.split(':');
        if (parts[0] > 23 || parts[1] > 59 || parts[2] > 59) return false;
        return true;
    }, "Format waktu salah (hh:mm:ss).");

    $(function(){
        $("#frmSettingPengesahan").validate({
            rules: {
                nosk: {
                    required: true
                },
                tglpengesahan:{
                    required: true
                },
                wktpengesahan:{
                    required: true
                },
                ruang_pengesahan:{
                    required: true
                }
            },
            messages: {
                nosk: {
                    required: "Anda belum mengisi Nomor SK Pengesahan"
                },
                tglpengesahan: {
                    required: "Tanggal pengesahan harus diisi"
                },
                wktpengesahan: {
                    required: "Waktu pengesahan harus diisi"
                },
                ruang_pengesahan: {
                    required: "Ruang pengesahan harus diisi"
                }
            },
            errorPlacement: function(error, element) {
                switch (element.attr("name")) {
                    case 'idbaperjakat':
                        error.insertAfter($("#jqv_msg"));
                        break;
                    default:
                        error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                form.submit();
            }

        });
    });
</script>

<div class="panel">
    <div class="panel-header bg-cyan fg-white"><strong>Pengaturan Pengesahan</strong></div>
</div>

<div class="grid">
    <?php if($tx_result == 1): ?>
    <div class="row">
        <div class="span12">
            <div class="notice" style="background-color: #00a300;">
                <div class="fg-white">Data sukses tersimpan</div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <div class="row">
        <div class="span6">
            <div class="panel">
                <div class="panel-header">Formulir Pengesahan</div>
                <div class="panel-content">
                    <form action="" method="post" id="frmSettingPengesahan" novalidate="novalidate">
                        <input id="submitok" name="submitok" type="hidden" value="1">
                    <?php  //echo form_open('jabatan_struktural/setting_pengesahan/'.$this->uri->segment(3), array('id'=>'frmSettingPengesahan')); ?>
                    <div class="input-control text">
                        <label>Nomor SK. Tim Baperjakat</label>
                        <div class="input-control select" tabindex="1" >
                            <select name="idbaperjakat" class="chosen-select" id="idbaperjakat" data-placeholder="Cari Baperjakat">
                                <?php if((isset($dp_pengesahan->id_baperjakat) ? $dp_pengesahan->id_baperjakat : 0) > 0){
                                    echo "<option value='0'> Silahkan Pilih</option>";
                                }else{
                                    echo "<option value='0' selected> Silahkan Pilih</option>";
                                }
                                ?>
                                <?php foreach($baperjakat as $b): ?>
                                    <option <?php if((isset($dp_pengesahan->id_baperjakat) ? $dp_pengesahan->id_baperjakat : 0)==$b->id_baperjakat) echo 'selected' ?> value="<?php echo $b->id_baperjakat ?>"><?php echo $b->no_sk ?></option>
                                <?php endforeach; ?>
                            </select><span id="jqv_msg"></span>
                        </div>
                    </div>
                    <div class="input-control text" style="margin-top: 10px;">
                        <label>Nomor SK. Pengesahan</label>
                        <input id="nosk" name="nosk" type="text" value="<?php if(isset($dp_pengesahan->no_sk)) echo $dp_pengesahan->no_sk ?>">
                    </div>
                    <div class="input-control text" id="datepicTglpengesahan" data-week-start="1" style="margin-top: 10px;">
                        <label>Tanggal Pengesahan</label>
                        <input type="text" id="tglpengesahan" name="tglpengesahan" value="<?php if(isset($dp_pengesahan->tgl_pengesahan)) echo $dp_pengesahan->tgl_pengesahan ?>">
                    </div>
                    <div class="input-control text" style="margin-top: 10px;">
                        <label>Waktu Pengesahan</label>
                        <input type="text" id="wktpengesahan" name="wktpengesahan" class="time24" value="<?php if(isset($dp_pengesahan->wkt_pengesahan)) echo $dp_pengesahan->wkt_pengesahan ?>">
                    </div>
                    <div class="input-control text" style="margin-top: 10px;">
                        <label>Ruangan Pengesahan</label>
                        <input type="text" id="ruang_pengesahan" name="ruang_pengesahan" value="<?php if(isset($dp_pengesahan->ruang_pengesahan)) echo $dp_pengesahan->ruang_pengesahan ?>">
                    </div>
                    <div class="button" style="margin-top: 20px;">
                        <?php //echo form_submit('btnSimpan', 'Simpan'); ?>
                        <input id="btnRegister" name="btnRegister" type="submit" value="Register" class="submit">
                    </div>
                    <?php  //echo form_close(); ?>
                    </form>
                </div>
            </div>
        </div>
        <div class="span6">
            <div class="panel">
                <div class="panel-header">Info Baperjakat</div>
                <div class="panel-content">
                    Silahkan pilih Nomor SK. Tim terlebih dahulu<br>
                    Untuk mengubah data tentang Baperjakat
                    <?php echo anchor(base_url('index.php/jabatan_struktural/pengaturan'),'Klik disini'); ?>
                    <div id="infoBaperjakat" style="margin-top: 20px;">
                        <?php if(isset($info_baperjakat)): ?>
                            <?php foreach($info_baperjakat as $inba): ?>
                                <?php echo '<strong>No. SK. '. $inba->no_sk.'</strong>' ?>
                                <?php echo '<br> Disahkan Oleh '. $inba->pengesah_sk.' ('.$inba->nama_pengesah_sk.')' ?>
                            <?php endforeach; ?>
                            <?php echo '<br> Terdiri dari : <br>' ?>
                            <?php if(isset($detail_baperjakat)): ?>
                                <table>
                                <?php foreach($detail_baperjakat as $deba): ?>
                                        <tr>
                                            <td style="vertical-align: top;"><?php echo $deba->status_keanggotaan ?></td>
                                            <td style="width: 20px; text-align: center; vertical-align: top;">:</td>
                                            <td><?php echo $deba->gelar_depan.' '.$deba->nama.' '.$deba->gelar_belakang.'<br>'.$deba->nip_baru.'<br>'.$deba->jabatan ?></td>
                                        </tr>
                                <?php endforeach; ?>
                                </table>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url()?>js/jquery/chosen.jquery.js"></script>
<script>
    $('.chosen-select').chosen();
    $('#idbaperjakat').on('change',function(){
        idbaperjakat = $('#idbaperjakat').val();
        if(idbaperjakat>0){
            $("#btnRegister").css("pointer-events", "none");
            $("#btnRegister").css("opacity", "0.4");
            $.post('<?php echo base_url()."index.php/jabatan_struktural/informasi_baperjakat"; ?>',
                { idbaperjakat : idbaperjakat}, function(data){
                    $("#infoBaperjakat").html(data);
                    $("#btnRegister").css("pointer-events", "auto");
                    $("#btnRegister").css("opacity", "1");
                });
        }
    });
    $( "#idbaperjakat" ).addClass( "selectComboboxCheck" );
    $(function(){
        $("#datepicTglpengesahan").datepicker();
    });
</script>

