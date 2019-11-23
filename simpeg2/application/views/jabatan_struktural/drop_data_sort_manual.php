<script type="text/javascript" src="../../../js/jquery/tipped.js"></script>
<script type='text/javascript'>
    $(document).ready(function() {
        Tipped.create('.boxes .box',{
            maxWidth: 200
        });
    });
</script>
<link rel="stylesheet" type="text/css" href="../../../css/tipped.css" />
<?php if(isset($pgDisplay)): ?>
    <?php if($numpage > 0): ?>
        Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $jmlData; ?> | <?php echo $jumppage; ?><br>
        <?php echo $pgDisplay; ?>
    <?php endif; ?>
<?php endif; ?>

<?php if(isset($drop_other_data_rekomendasi)): ?>

    <table class="table bordered" id="daftar_calon_pejabat">
        <thead style="border-bottom: solid #a4c400 2px;">
        <tr>
            <th width="5%">NO.</th>
            <th width="7%">PHOTO</th>
            <th width="20%">NIP</th>
            <th width="20%">NAMA</th>
            <th width="5%">GOL.</th>
            <th width=43%">UNIT KERJA</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($drop_other_data_rekomendasi as $rp) { ?>
            <tr>
                <td rowspan="2"><?php echo $rp->no_urut ?></td>
                <td rowspan="2"><img src='http://103.14.229.15/simpeg/foto/<?php echo $rp->id_pegawai?>.jpg' width='50px' />
                    <div id="btn_up_emp" class="button" onclick="up_informasi_pegawai('<?php echo $rp->nip_baru; ?>', <?php echo $id_draft ?>)" style="width: 50px;">
                        <span class=icon-arrow-up style="color: red;"></span></div>
                </td>
                <td><span style="color: #0000cc"><?php echo $rp->nip_baru ?></span></td>
                <td><strong><?php echo $rp->nama ?></strong></td>
                <td><?php echo $rp->pangkat_gol ?></td>
                <td>
                    <?php echo $rp->unit ?> <?php echo $rp->hukuman==''?'':"<span class='boxes'><span class='box' title=\"$rp->hukuman\" data-tipped-options=\"position: 'bottom'\"><img id='iconHukDis$rp->no_urut' src='../../../images/flag.png' width='20px' height='20px' /></span></span>"; ?>
                </td>
            </tr>
            <tr style="border-bottom: 2px solid rgba(192, 192, 192, 0.8)">
                <td colspan="5">
                    Jabatan : <?php echo $rp->jabatan ?> <br>
                    Eselon: <?php echo $rp->eselon ?> (Lamanya <?php echo $rp->pengalaman_eselon_current ?> Thn) | Umur: <?php echo $rp->umur ?> Thn |
                    Masa Kerja Keseluruhan: <?php echo $rp->masa_kerja ?> Thn <br>
                    Pendidikan : <?php echo $rp->tk_pendidikan ?> (<?php echo $rp->jurusan_pendidikan ?>)<br>
                    Pengalaman pada unit kerja tujuan : <?php echo $rp->pengalaman_uk ?> Thn |
                    PIM II : <?php echo $rp->jml_diklat_pim_2 ?> | PIM III : <?php echo $rp->jml_diklat_pim_3 ?> | PIM IV : <?php echo $rp->jml_diklat_pim_4 ?> |
                    BUP : <?php echo $rp->tmt_bup ?><br>
                    Sertifikasi Barang dan Jasa : <?php echo ($rp->tgl_diklat_barjas==''?'-':$rp->tgl_diklat_barjas) ?><br>
                    <span style="font-weight: bold;">SKP 2 Tahun Terakhir</span> : <?php echo ($rp->skp==''?'-':'<br>'.$rp->skp) ?><br>
                    Alamat : <?php echo $rp->alamat.' '.$rp->kota; ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <div style="margin-top: -18px; margin-bottom: 10px;">
        <?php if(isset($pgDisplay)): ?>
            <?php if($numpage > 0): ?>
                Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $jmlData; ?> | <?php echo $jumppage; ?><br>
                <?php echo $pgDisplay; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
<?php else: ?>
    Data tidak ditemukan.
<?php endif; ?>