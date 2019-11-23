<?php if(isset($drop_data_list)): ?>
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
    <div style="overflow-x: auto; border: 1px solid rgba(71,71,72,0.35); margin-top: 5px;">
    <table id="tblTipeLokasiPegawai" class="table row-hover row-border compact">
        <tr style="border-bottom: 3px solid yellowgreen">
            <th>Personil</th>
            <th>Jabatan & Unit Utama</th>
            <th>Multi Lokasi Kerja</th>
        </tr>
        <tbody>
            <?php
                $i = 1;
                $halaman = $start_number;
                foreach($drop_data_list as $lsdata) {
                    ?>
                <tr>
                    <td style="vertical-align: top">
                        <strong><?php echo $halaman+$i.') '.$lsdata->nama; ?></strong><br>
                        <?php echo $lsdata->nip_baru; ?><br>
                        Golongan : <?php echo $lsdata->pangkat_gol; ?>
                    </td>
                    <td style="vertical-align: top">
                        <?php echo substr($lsdata->jabatan,0,(strpos($lsdata->jabatan,'pada')==0?strlen($lsdata->jabatan):strpos($lsdata->jabatan,'pada'))).' ('.$lsdata->kode_jabatan.')'; ?><br>
                        <?php echo $lsdata->jenjab.($lsdata->eselon!='Staf'?' ('.$lsdata->eselon.')':''); ?> Kelas : <?php echo $lsdata->kelas_jabatan.' - '.$lsdata->nilai_jabatan; ?><br>
                        <small><?php echo $lsdata->unit_primer; ?></small>
                    </td>
                    <td style="vertical-align: top">
                        <span style="color: blue;"><?php echo ($lsdata->flag_lokasi_multiple==0?'Tidak (Jml Unit Sekunder: '.$lsdata->jumlah_unit_sekunder.')':'Ya (Jml Unit Sekunder: '.$lsdata->jumlah_unit_sekunder.')'); ?></span><br>Oleh
                        <?php echo $lsdata->nama_updater.' ('.$lsdata->nip_updater.') <br>'.$lsdata->last_tgl_update_flag_lokasi; ?><br>
                        <button id="btnUbahTipeLokasiKerja" name="btnUbahTipeLokasiKerja" onclick="ubah_tipe_lokasi_kerja('<?php echo $lsdata->id_pegawai_enc; ?>')" type="button" class="button primary bg-green small drop-shadow rounded">
                            <span class="mif-pencil icon"></span> Ubah Tipe Lokasi Kerja</button>
                    </td>
                </tr>
            <?php
                    $i++;
                } ?>
        </tbody>
    </table>
    </div>
<?php else: ?>
    Data tidak ditemukan.
<?php endif; ?>

<script>
    function ubah_tipe_lokasi_kerja(id_pegawai_enc){
        location.href = '<?php echo base_url($usr);?>/input_tipe_lokasi_kerja?idp=' + id_pegawai_enc;
    }
</script>