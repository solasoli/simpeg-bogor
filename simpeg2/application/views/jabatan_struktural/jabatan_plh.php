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
<script src="<?php echo base_url()?>js/jquery/jquery.validate.js"></script>

<br>
<div class="container">
    <strong>JABATAN PELAKSANA HARIAN (PLH)</strong>
    <div class="grid">
        <div class="row" style="margin-bottom: -10px;">
            <div class="span13">
                <span class="span2">
                    <div class="input-control select" style="width: 100%;">
                        <select id="ddStatusAktif" style="background-color: #e3c800;">
                            <option value="0">Semua Status</option>
                            <option value="1" <?php echo $stsAktif==1?'selected':''?>>PLH masih aktif</option>
                            <option value="2" <?php echo $stsAktif==2?'selected':''?>>PLH sudah non aktif</option>
                        </select>
                    </div>
                </span>
                <span class="span2">
                    <div class="input-control select" style="width: 100%;">
                        <select id="ddEselon" style="background-color: #e3c800;">
                            <option value="0">Semua Eselon</option>
                            <option value="IIA" <?php echo $eselon=='IIA'?'selected':''?>>Eselon IIA</option>
                            <option value="IIB" <?php echo $eselon=='IIB'?'selected':''?>>Eselon IIB</option>
                            <option value="IIIA" <?php echo $eselon=='IIIA'?'selected':''?>>Eselon IIIA</option>
                            <option value="IIIB" <?php echo $eselon=='IIIB'?'selected':''?>>Eselon IIIB</option>
                            <option value="IVA" <?php echo $eselon=='IVA'?'selected':''?>>Eselon IVA</option>
                            <option value="IVB" <?php echo $eselon=='IVB'?'selected':''?>>Eselon IVB</option>
                        </select>
                    </div>
                </span>
                <span class="span3">
                    <div class="input-control text">
                        <input id="keywordCari" type="text" value="<?php echo $keywordCari; ?>" placeholder="NIP/Nama/Jabatan PLH"
                               style="background-color: #e3c800;"/>
                    </div>
                </span>
                <span class="span7">
                    <button id="btn_tampilkan" class="button primary" style="height: 35px;">
                        <span class="icon-file on-left"></span><strong>Tampilkan</strong></button>
                    <button id="btn_tambah_baru" class="button success" style="height: 35px;">
                        <span class="icon-plus on-left"></span><strong>Tambah Baru</strong></button>
                    <button id="btn_cetak_pdf" class="button bg-darkRed fg-white" style="height: 35px;">
                        <span class="icon-file-pdf on-left"></span><strong>Download Format PDF</strong></button>
                </span>
            </div>
        </div>
    </div>

    <div class="grid">
        <div class="row">
            <div class="span10">
                <?php if (isset($pgDisplay)): ?>
                    <?php if ($numpage > 0): ?>
                        Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $total_items; ?> | <?php echo $jumppage; ?> | <?php echo $item_perpage; ?>
                        <br><?php echo $pgDisplay; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <table class="table bordered striped" id="lst_plt">
        <thead style="border-bottom: solid #a4c400 2px;border-top: solid #000000 1px;">
        <tr>
            <th>No</th>
            <th>Jabatan PLH</th>
            <th>Pegawai</th>
            <th>No.SK</th>
            <th>TMT.Mulai</th>
            <th>TMT.Selesai</th>
            <th style="width: 100px;">Status PLH</th>
            <th>Inputer</th>
        </tr>
        </thead>
        <?php if (is_array($list_data) && sizeof($list_data) > 0): ?>
            <?php $i = 1; ?>
            <?php if ($list_data != ''): ?>
                <?php foreach ($list_data as $lsdata): ?>
                    <tr>
                        <td><?php echo $lsdata->no_urut; ?>.</td>
                        <td><div style="margin-bottom: 8px;"><?php echo $lsdata->jabatan_plh; ?> (<?php echo $lsdata->eselon_plh; ?>)</div>
                            <button type="button"
                                    name="btnUbah<?php echo $lsdata->no_urut; ?>"
                                    id="btnUbah<?php echo $lsdata->no_urut; ?>"
                                    class="btn btn-primary btn-sm"
                                    style="font-weight: bold;color: darkslategrey; border: 1px solid darkgray">
                                <span class="icon-pencil on-left"></span> Ubah</button>

                            <button type="button"
                                    name="btnHapus<?php echo $lsdata->no_urut; ?>"
                                    id="btnHapus<?php echo $lsdata->no_urut; ?>"
                                    class="btn btn-primary btn-sm"
                                    style="font-weight: bold;color: darkslategrey; border: 1px solid darkgray">
                                <span class="icon-remove on-left"></span> Hapus</button>
                        </td>
                        <td><?php echo '<strong>'.$lsdata->nama_gelar.'</strong> <br>NIP.'.$lsdata->nip_baru; ?><br>
                            <?php echo $lsdata->jabatan_asli_saat_plh.' ('.$lsdata->jenjab.') Status: '.
                                ' | '.$lsdata->status_aktif_pegawai; ?></td>
                        <td><?php echo $lsdata->no_sk; ?></td>
                        <td><?php echo ($lsdata->tmt==''?'-':$lsdata->tmt); ?></td>
                        <td><?php echo ($lsdata->tmt_selesai==''?'-':$lsdata->tmt_selesai); ?></td>
                        <td><?php echo ($lsdata->status_aktif==1?'Aktif':'Tidak Aktif'); ?></td>
                        <td><?php echo ($lsdata->nama_inputer==''?'-':$lsdata->nama_inputer.'<br>('.$lsdata->tgl_input.')'); ?></td>
                    </tr>
                    <?php
                    $i++;
                endforeach; ?>
            <?php else: ?>
                <tr class="error">
                    <td colspan="8"><i>Tidak ada data</i></td>
                </tr>
            <?php endif; ?>
        <?php else: ?>
            <tr class="error">
                <td colspan="8"><i>Tidak ada data</i></td>
            </tr>
        <?php endif; ?>
    </table>
</div>

<script type="application/javascript">
    $("#btn_tampilkan").click(function () {
        var stsAktif = $('#ddStatusAktif').val();
        var eselon = $('#ddEselon').val();
        var keywordCari = $("#keywordCari").val();
        loadDataListPlh(stsAktif, eselon, keywordCari, '<?php echo isset($_GET['page'])?$_GET['page']:1; ?>');
    });

    function loadDataListPlh(stsAktif, eselon, keywordCari, page) {
        var ipp = $("#selIpp").val();
        location.href = "<?php echo base_url()."jabatan_struktural/list_jabatan_plh/" ?>" + "?page=" + page + "&ipp=" + ipp + "&stsAktif=" + stsAktif + "&eselon=" + eselon + "&keywordCari=" + keywordCari;
    }

    $("#btn_tambah_baru").click(function () {
        location.href = "<?php echo base_url()."jabatan_struktural/tambah_jabatan_plh" ?>";
    });

    $("#btn_cetak_pdf").click(function () {
        var stsAktif = $('#ddStatusAktif').val();
        var eselon = $('#ddEselon').val();
        var keywordCari = $("#keywordCari").val();
        loadDataDownloadPDFPlh(stsAktif, eselon, keywordCari);
    });

    function loadDataDownloadPDFPlh(stsAktif, eselon, keywordCari){
        if(keywordCari==''){
            keywordCari = '-';
        }
        window.open("<?php echo base_url()."jabatan_struktural/cetak_nominatif_jabatan_plh/" ?>" + stsAktif + "/" + eselon + "/" + keywordCari);
    }

</script>