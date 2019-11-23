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
        <?php //echo $this->session->userdata('id_skpd_enc'); ?>
        <table id="tblListKinerjaPegawai" class="table row-hover row-border compact">
            <tr style="border-bottom: 3px solid yellowgreen">
                <th>Personil</th>
                <th style="width: 50%;">Status Laporan</th>
            </tr>
            <tbody>
                <?php
                $i = 1;
                $halaman = $start_number;
                foreach($drop_data_list as $lsdata) {?>
                    <tr>
                        <td style="vertical-align: top;">
                            <strong><?php echo $halaman+$i.') '.$lsdata->nama; ?></strong><br>
                            <?php echo $lsdata->nip_baru; ?><br>
                            Golongan : <?php echo $lsdata->pangkat_gol; ?><br>
                            <?php echo substr($lsdata->jabatan,0,(strpos($lsdata->jabatan,'pada')==0?strlen($lsdata->jabatan):strpos($lsdata->jabatan,'pada'))).' ('.$lsdata->kode_jabatan.')'; ?><br>
                            <?php echo $lsdata->jenjab.($lsdata->eselon!='Staf'?' ('.$lsdata->eselon.')':''); ?> Kelas : <?php echo $lsdata->kelas_jabatan.' - '.$lsdata->nilai_jabatan; ?>
                        </td>
                        <td style="vertical-align: top;">
                            <?php
                                $thn = substr($lsdata->last_periode, 0, 4);
                                $bln = substr($lsdata->last_periode, 4, 2);
                                if($bln!='') {
                                    echo '<span style="color: blue;">Periode Terakhir: ' . $this->umum->monthName($bln) . ' ' . $thn.'</span>';
                                    echo '<br>Status: '.$lsdata->status_knj;
                                    echo '<br>Kalkulasi nilai: '.($lsdata->flag_kalkulasi==0?'Belum':'Sudah pada '.$lsdata->tgl_update_kalkulasi.
                                            '<br>'.'<span style="color: darkgreen; font-weight: bold;">Kinerja: '.$lsdata->persen_kinerja_final.'%</span>, 
                                            <span style="color: darkred; font-weight: bold;">Disiplin: '.$lsdata->last_persen_disiplin.'%</span>');
                                }else{
                                    echo '<span style="color: darkred">Belum pernah membuat laporan</span>';
                                }
                                echo '<br>Jumlah Laporan: '.($lsdata->jumlah_laporan==''?0:$lsdata->jumlah_laporan);
                            ?>
                            <?php if($lsdata->jumlah_laporan==''): ?>
                            <?php else: ?>
                                <br><button onclick="riwayat_ekinerja_staf('<?php echo $lsdata->id_pegawai_enc; ?>')"
                                            type="button" class="button rounded primary bg-grayBlue small drop-shadow" style="margin-bottom: 5px;">
                                    <span class="mif-file-text icon"></span> Riwayat eKinerja</button>
                            <?php endif; ?>
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
    function riwayat_ekinerja_staf(id_pegawai_enc){
        location.href = "<?php echo base_url().$usr."/riwayat_ekinerja_pegawai?idp=" ?>" + id_pegawai_enc;
    }
</script>
