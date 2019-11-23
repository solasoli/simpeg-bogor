<?php if (isset($drop_data_list) and sizeof($drop_data_list) > 0 and $drop_data_list != ''):?>
    <?php if(isset($pgDisplay)): ?>
        <?php if($numpage > 0): ?>
            <div class="row" style="margin-top: 20px;">
                <div class="cell-sm-12">
                    Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah : <?php echo $jmlData; ?>
                </div>
            </div>
            <?php echo $pgDisplay; ?>
        <?php endif; ?>
    <?php endif; ?>
    <table id="tblUkSekunder" class="table row-hover row-border compact">
        <thead>
            <tr>
                <th>No</th>
                <th>Unit Sekunder</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $i = 1;
        $halaman = $start_number;
        foreach($drop_data_list as $lsdata) { ?>
            <tr>
                <td style="vertical-align: top;"><?php echo $halaman+$i; ?>)</td>
                <td style="vertical-align: top;"><strong><?php echo $lsdata->nama; ?></strong><br>
                    <?php echo $lsdata->alamat; ?><br>Inputer: <?php echo $lsdata->inputer; ?><br>
                    <small>Koordinat:<br>
                        <img src='<?php echo base_url('assets/images/green-dot.png');?>' style="width:16px;height: 16px;"/> Dalam: <?php echo $lsdata->in_lat; ?>, <?php echo $lsdata->in_long; ?>,
                        <img src='<?php echo base_url('assets/images/red-dot.png');?>' style="width:16px;height: 16px;"/>  Luar: <?php echo $lsdata->out_lat; ?>, <?php echo $lsdata->out_long; ?><br>
                        Telp. <?php echo $lsdata->telp; ?>.
                        Email: <?php echo $lsdata->email; ?><br>
                        Wilayah <?php echo $lsdata->tipe_wilayah; ?>. Unit Utama: <?php echo $lsdata->utama; ?>.
                        Induk: <?php echo ($lsdata->induk==''?'-':$lsdata->induk); ?>
                    </small><br>
                    <button id="btnUbahUkSekunder" name="btnUbahUkSekunder" onclick="ubah_unit_sekunder('<?php echo $lsdata->id_uk_sekunder_enc; ?>')"
                            type="button" class="button primary bg-green drop-shadow small rounded" <?php echo($lsdata->idp_inputer==$this->session->userdata('id_pegawai')?'':'disabled'); ?>>
                        <span class="mif-pencil icon"></span> Ubah </button>
                    <button id="btnHapusUkSekunder" name="btnUbahUkSekunder" onclick="hapus_unit_kerja_lokasi('<?php echo $lsdata->id_uk_sekunder_enc; ?>')"
                            type="button" class="button primary bg-darkRed drop-shadow small rounded" <?php echo($lsdata->idp_inputer==$this->session->userdata('id_pegawai')?'':'disabled'); ?>>
                        <span class="mif-bin icon"></span> Hapus </button>
                    <button id="btnLihatPeta" name="btnUbahUkSekunder" onclick="lihatPeta(<?php echo $lsdata->in_lat; ?>, <?php echo $lsdata->in_long; ?>, <?php echo $lsdata->out_lat; ?>, <?php echo $lsdata->out_long; ?>)"
                            type="button" class="button primary bg-darkBlue drop-shadow small rounded">
                        <span class="mif-map2 icon"></span> Lihat Peta </button>
                </td>

            </tr>

            <?php
            $i++;
        } ?>
        </tbody>
    </table>

<?php else: ?>
    <br>Data tidak ditemukan.
<?php endif; ?>