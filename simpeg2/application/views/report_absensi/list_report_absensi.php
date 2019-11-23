<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
    .paginate {
        font-family: Arial, Helvetica, sans-serif;
        font-size: .7em;
    }

    a.paginate {
        border: 1px solid #000080;
        padding: 2px 6px 2px 6px;
        text-decoration: none;
        color: #000080;
    }

    a.paginate:hover {
        background-color: #000080;
        color: #FFF;
        text-decoration: underline;
    }

    a.current {
        border: 1px solid #000080;
        font: bold .7em Arial,Helvetica,sans-serif;
        padding: 2px 6px 2px 6px;
        cursor: default;
        background:#000080;
        color: #FFF;
        text-decoration: none;
    }

    span.inactive {
        border: 1px solid #999;
        font-family: Arial, Helvetica, sans-serif;
        font-size: .7em;
        padding: 2px 6px 2px 6px;
        color: #999;
        cursor: default;
    }
</style>

<div class="container">
    <div class="grid">
        <div class="row" style="margin-bottom: -20px;">
            <div class="span13">
                <span class="span4">
                    <?php if (isset($list_skpd)): ?>
                        <div class="input-control select" style="width: 100%;">
                            <select id="ddFilterOpd" style="background-color: #e3c800;">
                                <?php foreach ($list_skpd as $ls): ?>
                                    <?php if($ls->id_unit_kerja == $idskpd): ?>
                                        <option value="<?php echo $ls->id_unit_kerja; ?>" selected><?php echo $ls->nama_baru; ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $ls->id_unit_kerja; ?>"><?php echo $ls->nama_baru; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </span>
                <span class="span3">
                    <div class="input-control select" style="width: 100%;">
                        <select id="ddFilterStatus" style="background-color: #e3c800;">
                            <option value="0">Semua Status</option>
                            <?php foreach ($list_status as $ls): ?>
                                <?php if($ls->idstatus == $idstatus): ?>
                                    <option value="<?php echo $ls->idstatus; ?>" selected><?php echo $ls->nama_status; ?></option>
                                <?php else: ?>
                                    <option value="<?php echo $ls->idstatus; ?>"><?php echo $ls->nama_status; ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </span>
                <span class="span2">
                    <div class="grid">
                        <div class="row">
                            <span class="span2" style="margin-top: -30px;">
                                <div class="input-control text" data-role="datepicker" data-week-start="1" style="margin-top: 10px;">
                                    <input type="text" id="tanggal" name="tanggal" value="<?php echo date("d.m.Y"); ?>" style="font-size: large;background-color: #e3c800;">
                                </div>
                            </span>
                        </div>
                    </div>
                </span>
                <span class="span3">
                    <div class="grid">
                        <div class="row">
                            <span class="span3" style="margin-top: -20px;">
                                <label class="input-control checkbox small-check">
                                    <input type="checkbox" <?php echo $tgl==""?'checked':'' ?> id="chkTanggal" name="chkTanggal">
                                    <span class="check"></span>
                                    <span class="caption" style="font-size: large;">Semua Tanggal</span>
                                </label>
                            </span>
                        </div>
                    </div>
                </span>
            </div>
        </div>
    </div>

    <div class="grid">
        <div class="row" style="margin-top: -100px;">
            <div class="span13">
                <span class="span3">
                    <div class="input-control select" style="width: 100%;">
                        <select id="ddFilterJenjab" style="background-color: #e3c800;">
                            <option value="0">Semua Jenjang</option>
                            <option value="Struktural" <?php echo $jenjab=='Struktural'?'selected':''?>>Struktural</option>
                            <option value="Fungsional" <?php echo $jenjab=='Fungsional'?'selected':''?>>Fungsional</option>
                        </select>
                    </div>
                </span>
                <span class="span3">
                    <div class="input-control text">
                        <input id="keywordCari" type="text" value="<?php echo $keywordCari; ?>" placeholder="Kata kunci"
                               style="background-color: #e3c800;"/>
                    </div>
                </span>
                <span class="span1"">
                    <button id="btn_tampilkan" class="button primary" style="height: 35px; width: 130px;">
                        <span class="icon-zoom-in"></span><strong>Tampilkan</strong></button>
                </span>
            </div>
        </div>
    </div>

    <div class="grid">
        <div class="row" style="margin-top: 0px;">
            <div class="span12">
                <?php if(isset($pgDisplay)): ?>
                    <?php if($numpage > 0): ?>
                        Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $total_items; ?> | <?php echo $jumppage; ?> | <?php echo $item_perpage; ?>
                        | <span style="font-family: Arial, Helvetica, sans-serif;font-size: .7em;">*Kata Kunci: NIP, Nama, Jabatan</span><br><?php echo $pgDisplay; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <table class="table bordered striped" id="lst_data">
        <thead style="border-bottom: solid #a4c400 2px;">
        <tr>
            <th style="width: 70px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79)">No</th>
            <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Tanggal</th>
            <th style="width: 100px;border-top: 1px solid rgba(111, 111, 111, 0.79)">Status</th>
            <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">NIP</th>
            <th style="border-top: 1px solid rgba(111, 111, 111, 0.79)">Nama</th>
            <th style="width: 75px;border-top: 1px solid rgba(111, 111, 111, 0.79)">Gol.</th>
            <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79)">Jabatan</th>
        </tr>
        </thead>
        <?php if (is_array($list_data) && sizeof($list_data) > 0): ?>
        <?php if($list_data!=''): ?>
                <?php $i=$start;?>
        <?php foreach ($list_data as $lsdata): ?>
        <tr>
            <td style="border-bottom: solid #666666 1px;"><?php echo $i; ?></td>
            <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->tgl ?></td>
            <td style="border-bottom: solid #666666 1px;text-align: center; font-weight: bold; color: saddlebrown">
                <?php echo $lsdata->status ?>
            </td>
            <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->nip_baru ?></td>
            <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->nama ?></td>
            <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->pangkat_gol ?></td>
            <td style="border-bottom: solid #666666 1px;"><?php echo $lsdata->jabatan ?></td>
        </tr>
            <?php $i++; ?>
            <?php endforeach; ?>
            <?php else: ?>
                <tr class="error">
                    <td colspan="7"><i>Tidak ada data</i></td>
                </tr>
            <?php endif; ?>
        <?php else: ?>
            <tr class="error">
                <td colspan="7"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>
    </table>
    <div class="grid">
        <div class="row" style="margin-top: 0px;">
            <div class="span12">
                <?php if(isset($pgDisplay)): ?>
                    <?php if($numpage > 0): ?>
                        Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $total_items; ?> | <?php echo $jumppage; ?> | <?php echo $item_perpage; ?>
                        | <span style="font-family: Arial, Helvetica, sans-serif;font-size: .7em;">*Kata Kunci: NIP, Nama, Jabatan</span><br><?php echo $pgDisplay; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $("#btn_tampilkan").click(function(){
        var tanggal;
        var status = $('#ddFilterStatus').val();
        var idskpd = $('#ddFilterOpd').val();
        var jenjab = $('#ddFilterJenjab').val();
        var keywordCari = $("#keywordCari").val();
        if ($('#chkTanggal').is(":checked"))
        {
            tanggal = "";
        }else{
            tanggal = $('#tanggal').val();
        }
        location.href="<?php echo base_url()."report_absensi/list_report_absensi" ?>"+"?status="+status+"&tgl="+tanggal+"&idskpd="+idskpd+"&jenjab="+jenjab+"&keywordCari="+keywordCari;
    });
</script>