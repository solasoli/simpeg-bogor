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

<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<br>
<div class="container">
    <strong>Daftar Penelusuran Pengembangan Kompetensi</strong>
    <div class="grid">
        <div class="row" style="margin-bottom: -10px;">
            <div class="span13">
                <span class="span4">
                    <?php if (isset($list_skpd)): ?>
                        <div class="input-control select" style="width: 100%;">
                            <select id="ddFilterOpd" style="background-color: #e3c800;">
                                <option value="0">Semua OPD</option>
                                <?php foreach ($list_skpd as $ls): ?>
                                    <?php if ($ls->id_unit_kerja == $id_skpd): ?>
                                        <option value="<?php echo $ls->id_unit_kerja; ?>"
                                                selected><?php echo $ls->nama_baru; ?></option>
                                    <?php else: ?>
                                        <option
                                                value="<?php echo $ls->id_unit_kerja; ?>"><?php echo $ls->nama_baru; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </span>
            </div>
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
            <span class="span1">
                    <button id="btn_tampilkan" class="button primary" style="height: 35px;">
                        <strong>Tampilkan</strong></button>
                </span>
        </div>
    </div>

    <div class="grid">
        <div class="row" style="margin-top: -30px;">
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

    <table class="table bordered striped" id="lst_kompetensi">
        <thead style="border-bottom: solid #a4c400 2px;">
        <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Nama</th>
            <th>Gol</th>
            <th>Jenjab</th>
            <th>Jabatan</th>
            <th>Pendidikan</th>
            <th>Riwayat Pengembangan Kompetensi</th>
            <th>Usulan Pengembangan Kompetensi</th>
        </tr>
        </thead>
        <?php if (sizeof($list_data) > 0): ?>
            <?php if($list_data!=''): ?>
            <?php $i=$start;?>
                <?php foreach ($list_data as $lsdata): ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $lsdata->nip_baru?></td>
                        <td><?php echo $lsdata->nama?></td>
                        <td><?php echo $lsdata->pangkat_gol?></td>
                        <td><?php echo $lsdata->jenjab?></td>
                        <td><?php echo $lsdata->jabatan?><br><?php echo ($lsdata->eselon2 == 'Staf'?'':'Eselon: '.$lsdata->eselon2)?></td>
                        <td><?php echo $lsdata->pendidikan?></td>
                        <td><?php echo $lsdata->diklat?></td>
                        <td><?php echo ($lsdata->kebutuhan==''?'Belum Ada':$lsdata->kebutuhan)?></td>
                    </tr>
                <?php $i++;?>
                <?php endforeach; ?>
            <?php else: ?>
                <tr class="error">
                    <td colspan="9"><i>Tidak ada data</i></td>
                </tr>
            <?php endif; ?>
        <?php else: ?>
            <tr class="error">
                <td colspan="9"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>
    </table>

    <div class="grid">
        <div class="row" style="margin-top: -30px;">
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

<script>
    $("#btn_tampilkan").click(function(){
        var id_skpd = $('#ddFilterOpd').val();
        var jenjab = $('#ddFilterJenjab').val();
        var keywordCari = $("#keywordCari").val();
        loadDataListKompetensi(id_skpd,jenjab,keywordCari,'<?php echo isset($_GET['page'])?1:1; ?>');//$_GET['page']
    });

    function loadDataListKompetensi(id_skpd,jenjab,keywordCari,page){
        var ipp = $("#selIpp").val();
        location.href="<?php echo base_url()."diklat/penyusunan_kompetensi/" ?>"+"?page="+page+"&ipp="+ipp+"&id_skpd="+id_skpd+"&jenjab="+jenjab+"&keywordCari="+keywordCari;
    }
</script>