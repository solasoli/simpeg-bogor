<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<script type="text/javascript" src="<?php echo base_url()?>js/jquery/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        jQuery.extend(jQuery.validator.messages, {
            required: "Harap diisi dahulu"
        });
        $('#txtTim1').val('');
        $('#txtTim2').val('');
        $('#txtTim3').val('');
        $('#txtTim4').val('');
        $('#txtTim5').val('');
        $('#txtTim6').val('');
        $('#txtTim7').val('');
        $('form').each(function () {
            $(this).validate({
                ignore: "",
                errorPlacement: function(error, element) {
                    switch (element.attr("name")) {
                        default:
                            error.insertAfter(element);
                    }
                },
                submitHandler: function (form) { // for demo
                    form.submit();
                }
            });
        });
    });

</script>
<div class="container">
    <p><h2>Pengaturan</h2></p>
    <div class="grid">
        <?php if($tx_result <> ""): ?>
            <div class="row">
                <div class="span13">
                    <div class="notice" style="background-color: #00a300;">
                        <div class="fg-white">Data sukses <?php echo $tx_result ?></div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="span13">
                <div class="panel">
                    <div class="panel-header">Badan Pertimbangan Jabatan dan Kepangkatan</div>
                    <div class="panel-content">
                        <div class="tab-control" data-role="tab-control">
                            <ul class="tabs">
                                <li class="active"><a href="#_page_1"><i class="icon-list"></i> List Data</a></li>
                                <li><a href="#_page_2"><i class="icon-plus"></i> Tambah Data</a></li>
                            </ul>
                            <div class="frames">
                                <div class="frame" id="_page_1">
                                    <table class="table bordered" id="tbl_list">
                                        <thead style="border-bottom: solid #a4c400 2px;">
                                        <tr style="background-color: #c6c6c6">
                                            <th width="5%">NO.</th>
                                            <th width="30%">NO. SK. TIM</th>
                                            <th width="20%">PENGESAH</th>
                                            <th width="20%">PEJABAT</th>
                                            <th width="25%">AKSI</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach($baperjakat_list as $baperjakat_list) { ?>
                                            <tr>
                                                <td colspan="5">
                                                    <form action="" method="post" id="frmEditBaperjakat_<?php echo $baperjakat_list->id_baperjakat ?>" novalidate="novalidate">
                                                        <table class="table bordered" id="daftar_baperjakat">
                                                            <tr style=" background-color: lightblue">
                                                                <td width="4%" style="text-align: center;">
                                                                    <h5 style="color: #002a80"><?php echo $baperjakat_list->no_urut ?>.</h5>
                                                                    <input type="hidden" name="formNameEdit" value="submitok_edit_<?php echo $baperjakat_list->id_baperjakat ?>"/>
                                                                </td>
                                                                <td width="27%">
                                                                    <input style="color: #002a80; width: 100%;background-color: lightblue;font-weight: bold;height: 35px;"
                                                                           type="text" id="no_sk_<?php echo $baperjakat_list->id_baperjakat ?>"
                                                                           name="no_sk_<?php echo $baperjakat_list->id_baperjakat ?>"
                                                                           value="<?php echo $baperjakat_list->no_sk ?>" required="required">
                                                                </td>
                                                                <td width="17%">
                                                                    <input style="color: #002a80; width: 100%;background-color: lightblue;font-weight: bold;height: 35px;"
                                                                           type="text" id="pengesah_<?php echo $baperjakat_list->id_baperjakat ?>"
                                                                           name="pengesah_<?php echo $baperjakat_list->id_baperjakat ?>"
                                                                           value="<?php echo $baperjakat_list->pengesah_sk ?>" required="required">
                                                                </td>
                                                                <td width="20%">
                                                                    <input style="color: #002a80; width: 100%;background-color: lightblue;font-weight: bold;height: 35px;"
                                                                           type="text" id="pejabat_<?php echo $baperjakat_list->id_baperjakat ?>"
                                                                           name="pejabat_<?php echo $baperjakat_list->id_baperjakat ?>"
                                                                           value="<?php echo $baperjakat_list->nama_pengesah_sk ?>" required="required">
                                                                </td>
                                                                <td width="20%">
                                                                    <button id="btnsave_update" name="save_update" class="button success" style="height: 34px;" type="submit"><span class="icon-floppy on-left"></span><strong>Simpan</strong></button>
                                                                    <button id="btndelete" name="delete" class="button danger cancel" style="height: 34px;" type="submit"><span class="icon-remove on-left"></span><strong>Hapus</strong></button>
                                                                </td>
                                                            </tr>
                                                            <tr style="background-color: #ffffff">
                                                                <td></td>
                                                                <td colspan="4">
                                                                    <table class="table bordered" id="daftar_detail_baperjakat">
                                                                        <thead style="border-bottom: solid #a4c400 2px;">
                                                                        <tr style="background-color: #ffffff">
                                                                            <th width="5%">NO.</th>
                                                                            <th width="15%">STATUS ANGGOTA</th>
                                                                            <th width="30%" colspan="2">PEJABAT</th>
                                                                            <th width="45%">JABATAN</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <?php $detail_baperjakat = $this->Baperjakat_model->get_baperjakat_detail($baperjakat_list->id_baperjakat);
                                                                        foreach($detail_baperjakat as $detail_baperjakat) { ?>
                                                                            <tr style="background-color: #ffffff">
                                                                                <td style="text-align: center;">
                                                                                    <?php echo $detail_baperjakat->no_urut ?>.
                                                                                </td>
                                                                                <td><?php echo $detail_baperjakat->status_keanggotaan ?>
                                                                                    <input id="txtIdDetBaper_<?php echo $detail_baperjakat->idstatus_keanggotaan ?>_<?php echo $detail_baperjakat->id_baperjakat ?>"
                                                                                           name="txtIdDetBaper_<?php echo $detail_baperjakat->idstatus_keanggotaan ?>_<?php echo $detail_baperjakat->id_baperjakat ?>"
                                                                                           type="hidden" value="<?php echo $detail_baperjakat->iddetail_baperjakat ?>" required="required">
                                                                                </td>
                                                                                <td>
                                                                                    <div id="lblTim_<?php echo $detail_baperjakat->idstatus_keanggotaan ?>_<?php echo $detail_baperjakat->id_baperjakat ?>" style="border: solid 1px darkgray; width: 100%; padding: 3px">
                                                                                        <?php if($detail_baperjakat->idpegawai <> "") { ?>
                                                                                            <table>
                                                                                                <tr>
                                                                                                    <td>
                                                                                                        <?php echo("<img src='http://103.14.229.15/simpeg/foto/" . $detail_baperjakat->idpegawai . ".jpg' width='50' /><br>"); ?>
                                                                                                    </td>
                                                                                                    <td>
                                                                                                        <?php echo '<strong>' . $detail_baperjakat->gelar_depan . ' ' .
                                                                                                            $detail_baperjakat->nama . ' ' . $detail_baperjakat->gelar_belakang . '</strong><br>' ?>
                                                                                                        <?php echo "<span style=\"color: #00356a; font-weight: bold;\">" . $detail_baperjakat->nip_baru . '</span><br>' ?>
                                                                                                        <?php echo $detail_baperjakat->pangkat_gol ?>
                                                                                                    </td>
                                                                                                </tr>
                                                                                            </table>
                                                                                        <?php
                                                                                        }else{
                                                                                        echo $detail_baperjakat->nama; ?>
                                                                                            <script type="text/javascript">
                                                                                                $(function(){
                                                                                                    $('#txtTim_<?php echo $detail_baperjakat->idstatus_keanggotaan ?>_<?php echo $detail_baperjakat->id_baperjakat ?>').val('');
                                                                                                    $('#txtIdj_<?php echo $detail_baperjakat->idstatus_keanggotaan ?>_<?php echo $detail_baperjakat->id_baperjakat ?>').val('');
                                                                                                });
                                                                                            </script>
                                                                                        <?php } ?>
                                                                                    </div>
                                                                                    <input id="txtTim_<?php echo $detail_baperjakat->idstatus_keanggotaan ?>_<?php echo $detail_baperjakat->id_baperjakat ?>"
                                                                                           name="txtTim_<?php echo $detail_baperjakat->idstatus_keanggotaan ?>_<?php echo $detail_baperjakat->id_baperjakat ?>"
                                                                                           type="hidden" value="<?php echo $detail_baperjakat->idpegawai ?>" required="required">
                                                                                </td>
                                                                                <td style="width:4%; border-left: none">
                                                                                    <button id="btnCari_<?php echo $detail_baperjakat->idstatus_keanggotaan ?>_<?php echo $detail_baperjakat->id_baperjakat ?>"
                                                                                            class="button" type="button" value="_<?php echo $detail_baperjakat->idstatus_keanggotaan ?>_<?php echo $detail_baperjakat->id_baperjakat ?>"
                                                                                            onclick="winSearchPegawai(this)"><span class="icon-user"></span>
                                                                                    </button>
                                                                                </td>
                                                                                <td>
                                                                                    <div id="lblJab_<?php echo $detail_baperjakat->idstatus_keanggotaan ?>_<?php echo $detail_baperjakat->id_baperjakat ?>"
                                                                                         style="border: solid 1px darkgray; width: 100%; padding: 3px">
                                                                                        <?php echo $detail_baperjakat->jabatan ?>
                                                                                    </div>
                                                                                    <input id="txtIdj_<?php echo $detail_baperjakat->idstatus_keanggotaan ?>_<?php echo $detail_baperjakat->id_baperjakat ?>"
                                                                                           name="txtIdj_<?php echo $detail_baperjakat->idstatus_keanggotaan ?>_<?php echo $detail_baperjakat->id_baperjakat ?>"
                                                                                           type="hidden" value="<?php echo $detail_baperjakat->id_j ?>">
                                                                                </td>
                                                                            </tr>
                                                                        <?php } ?>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </form>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="frame" id="_page_2">
                                    <div class="row">
                                        <form action="" method="post" id="frmAddBaperjakat" novalidate="novalidate">
                                            <div class="span6">
                                                <div class="panel">
                                                    <div class="panel-header">Formulir Pengesahan</div>
                                                    <div class="panel-content">
                                                        <div class="input-control text">
                                                            <label>Nomor SK. Tim Baperjakat</label>
                                                            <input id="nosk_tim" name="nosk_tim" type="text" value="" required="required">
                                                        </div>
                                                        <div class="input-control text" style="margin-top: 10px;">
                                                            <label>Pengesah</label>
                                                            <input id="pengesah" name="pengesah" type="text" value="" required="required">
                                                        </div>
                                                        <div class="input-control text" style="margin-top: 10px;">
                                                            <label>Pejabat</label>
                                                            <input id="pejabat" name="pejabat" type="text" value="" required="required">
                                                        </div>
                                                        <!-- <div class="button" style="margin-top: 20px;"> -->
                                                        <!-- <input id="btnRegister" name="btnRegister" type="submit" value="Register" class="submit"> -->
                                                        <button id="btnregister" name="new_register" type="submit" class="button success" style="height: 34px; margin-top: 20px;"><span class="icon-floppy on-left"></span><strong>Register</strong></button>
                                                        <!-- </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="span7">
                                                <div class="panel">
                                                    <div class="panel-header">Tim Baperjakat</div>
                                                    <div class="panel-content">
                                                        <table class="table bordered" id="daftar_detail_baperjakat">
                                                            <thead style="border-bottom: solid #a4c400 2px;">
                                                            <tr style="background-color: #ffffff">
                                                                <th width="5%">NO.</th>
                                                                <th width="25%">STATUS</th>
                                                                <th width="70%" colspan="2">PEJABAT</th>
                                                            </tr>
                                                            </thead>
                                                            <tr>
                                                                <td>1.</td>
                                                                <td>Ketua</td>
                                                                <td>
                                                                    <div id="lblTim1" style="border: solid 1px darkgray; width: 100%; padding: 3px">&nbsp; -- Silahkan pilih --</div>
                                                                    <input id="txtTim1" name="txtTim1" type="hidden" value="" required="required">
                                                                    <input id="txtIdj1" name="txtIdj1" type="hidden" value="">
                                                                </td>
                                                                <td style="width: 10%; border-left: none;">
                                                                    <button id="btn1" class="button" type="button" value="1" onclick="winSearchPegawai(this)"><span class="icon-user"></span></button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2.</td>
                                                                <td>Sekretaris</td>
                                                                <td>
                                                                    <div id="lblTim2" style="border: solid 1px darkgray; width: 100%; padding: 3px">&nbsp; -- Silahkan pilih --</div>
                                                                    <input id="txtTim2" name="txtTim2" type="hidden" value="" required="required">
                                                                    <input id="txtIdj2" name="txtIdj2" type="hidden" value="">
                                                                </td>
                                                                <td style="width: 10%; border-left: none;">
                                                                    <button id="btn2"  class="button" type="button" value="2" onclick="winSearchPegawai(this)"><span class="icon-user"></span></button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3.</td>
                                                                <td>Anggota ke-1</td>
                                                                <td>
                                                                    <div id="lblTim3" style="border: solid 1px darkgray; width: 100%; padding: 3px">&nbsp; -- Silahkan pilih --</div>
                                                                    <input id="txtTim3" name="txtTim3" type="hidden" value="" required="required">
                                                                    <input id="txtIdj3" name="txtIdj3" type="hidden" value="">
                                                                </td>
                                                                <td style="width: 10%; border-left: none;">
                                                                    <button id="btn3" class="button" type="button" value="3" onclick="winSearchPegawai(this)"><span class="icon-user"></span></button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>4.</td>
                                                                <td>Anggota ke-2</td>
                                                                <td>
                                                                    <div id="lblTim4" style="border: solid 1px darkgray; width: 100%; padding: 3px">&nbsp; -- Silahkan pilih --</div>
                                                                    <input id="txtTim4" name="txtTim4" type="hidden" value="" required="required">
                                                                    <input id="txtIdj4" name="txtIdj4" type="hidden" value="">
                                                                </td>
                                                                <td style="width: 10%; border-left: none;">
                                                                    <button id="btn4" class="button" type="button" value="4" onclick="winSearchPegawai(this)"><span class="icon-user"></span></button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>5.</td>
                                                                <td>Anggota ke-3</td>
                                                                <td>
                                                                    <div id="lblTim5" style="border: solid 1px darkgray; width: 100%; padding: 3px">&nbsp; -- Silahkan pilih --</div>
                                                                    <input id="txtTim5" name="txtTim5" type="hidden" value="" required="required">
                                                                    <input id="txtIdj5" name="txtIdj5" type="hidden" value="">
                                                                </td>
                                                                <td style="width: 10%; border-left: none;">
                                                                    <button id="btn5" class="button" type="button" value="5" onclick="winSearchPegawai(this)"><span class="icon-user"></span></button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>6.</td>
                                                                <td>Anggota ke-4</td>
                                                                <td>
                                                                    <div id="lblTim6" style="border: solid 1px darkgray; width: 100%; padding: 3px">&nbsp; -- Silahkan pilih --</div>
                                                                    <input id="txtTim6" name="txtTim6" type="hidden" value="" required="required">
                                                                    <input id="txtIdj6" name="txtIdj6" type="hidden" value="">
                                                                </td>
                                                                <td style="width: 10%; border-left: none;">
                                                                    <button id="btn6" class="button" type="button" value="6" onclick="winSearchPegawai(this)"><span class="icon-user"></span></button>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>7.</td>
                                                                <td>Anggota ke-5</td>
                                                                <td>
                                                                    <div id="lblTim7" style="border: solid 1px darkgray; width: 100%; padding: 3px">&nbsp; -- Silahkan pilih --</div>
                                                                    <input id="txtTim7" name="txtTim7" type="hidden" value="" required="required">
                                                                    <input id="txtIdj7" name="txtIdj7" type="hidden" value="">
                                                                </td>
                                                                <td style="width: 10%; border-left: none;">
                                                                    <button id="btn7" class="button" type="button" value="7" onclick="winSearchPegawai(this)"><span class="icon-user"></span></button>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function winSearchPegawai(e){
        var num = document.getElementById(e.id).value;
        var lblInfo = 'lblTim' + num;
        var idelement = 'txtTim' + num;
        var idjab = 'txtIdj' + num;
        var lblJab = 'lblJab' + num;

        $.post('<?php echo base_url()."index.php/jabatan_struktural/cari_pegawai"; ?>',
            {
                page: '',
                ipp: '',
                cboPangkat: '0',
                cboJabatan: '0',
                cboUnit: '0',
                txtKeyword: ''
            },
            function(data){
                $("#cari_pegawai").html(data);
            });

        $.Dialog({
            shadow: true,
            overlay: false,
            icon: '<span class="icon-rocket"></span>',
            title: 'Pencarian Pegawai',
            width: 200,
            height: 350,
            padding: 10,
            content: "<div style='width: 1000px;'>" +
            '<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 1px 0;"></span>' +
            'Silahkan gunakan form ini untuk pencarian data pejabat.' +
            '<div class="grid"><div class="row cells5" style="margin-top: 0px; padding-bottom: 25px; border-bottom: solid 1px #808080;">' +
            '<div class="cell span2"><div class="input-control text"><label>Kata Kunci : </label><input type="text" name="txtKeyword" id="txtKeyword" /></div></div>' +
            '<div class="cell span2"><div class="input-control text"><label>Pangkat : </label>' +
            '<div class="input-control select">' +
            '<select name="idpangkat" id="idpangkat">' +
            '<option value="0">Semua Data</option>' +
            <?php foreach($listPangkat as $a): ?>
            '<option value="<?php echo $a->golongan ?>"><?php echo $a->gol_pangkat ?></option>' +
            <?php endforeach; ?>
            '</select>' +
            '</div></div></div>' +
            '<div class="cell span3"><div class="input-control text"><label>Jabatan : </label>' +
            '<div class="input-control select">' +
            '<select name="idjabatan" id="idjabatan" class="chosen-select">' +
            '<option value="0">Semua Data</option>' +
            <?php foreach($listJabatan as $b): ?>
            '<option value="<?php echo $b->id_j ?>"><?php echo $b->jabatan ?></option>' +
            <?php endforeach; ?>
            '</select>' +
            '</div></div></div>' +
            '<div class="cell span3"><div class="input-control text"><label>Unit Kerja : </label>' +
            '<div class="input-control select">' +
            '<select name="idunit" id="idunit" class="chosen-select">' +
            '<option value="0">Semua Data</option>' +
            <?php foreach($listUnit as $c): ?>
            '<option value="<?php echo $c->id_unit_kerja ?>"><?php echo $c->nama_baru ?></option>' +
            <?php endforeach; ?>
            '</select>' +
            '</div></div></div>' +
            '<div class="cell span2"><div class="input-control text"><label>&nbsp;</label>' +
            '<button id="btnCariPegawai" onclick="filterPegawai();" class="button default" style="height: 30px;"><span class="icon-search on-left"></span>Cari</button>' +
            '</div></div>' +
            '</div></div>' +
            "</div><div id='cari_pegawai' style='height:350px; overflow:auto; margin-top: -10px;'></div>" +
            '<div style="text-align: right; margin-right: 0px; background-color: #d3d3d3;"><button id="btnPilihPegawai" onclick="pilihPegawai(\'' + lblInfo + '\', \'' + idelement + '\', \'' + idjab +'\', \'' + lblJab +'\');" class="button default" style="height: 30px;"><span class="icon-checkmark on-left"></span>Pilih</button></div>'
        });

    }
</script>
<!--  End of file index.php -->
<!--  Location: ./application/views/jabatan_struktural/pengaturan.php  -->