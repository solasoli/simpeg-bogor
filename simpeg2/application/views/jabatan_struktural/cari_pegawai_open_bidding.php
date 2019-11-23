<?php if(isset($pgDisplay)): ?>
    <?php if($numpage > 0): ?>
        Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $jmlData; ?> | <?php echo $jumppage; ?><br>
        <?php echo $pgDisplay; ?>
    <?php endif; ?>
<?php endif; ?>

<?php if (is_array($cari_pegawai) && sizeof($cari_pegawai) > 0): ?>
    <table class="table bordered striped" id="daftar_pejabat" style="margin-bottom: 0px;">
        <thead style="border-bottom: solid #a4c400 2px;">
        <tr>
            <th width="5%">NO.</th>
            <th width="7%">PHOTO</th>
            <th width="20%">NIP</th>
            <th width="20%">NAMA</th>
            <th width="5%">GOL.</th>
            <th width="43%">JABATAN</th>
        </tr>
        </thead>
        <tbody>
        <?php $i = 1; ?>
            <?php if ($cari_pegawai != ''): ?>
                <?php foreach ($cari_pegawai as $pegawai): ?>
                <tr>
                    <td><?php echo $pegawai->no_urut ?></td>
                    <td><img src='http://103.14.229.15/simpeg/foto/<?php echo $pegawai->id_pegawai?>.jpg' width='50' /></td>
                    <td><?php echo $pegawai->nip_baru ?><br>
                        <label class="input-control checkbox small-check"
                               style="margin-top: 0px;">
                            <input type="checkbox" value="<?php echo $pegawai->id_pegawai.'#'.$pegawai->nip_baru.'#'.$pegawai->nama_gelar.'#'.$pegawai->pangkat_gol.'#'.$pegawai->jabatan.'#'.$pegawai->jenjab.'#'.$pegawai->kode_jabatan.'#'.$pegawai->id_unit_kerja.'#'.$pegawai->eselon; ?>"
                                   id="chkOpbPeg<?php echo $pegawai->id_pegawai; ?>" name="chkOpbPeg<?php echo $pegawai->id_pegawai; ?>">
                            <span class="check"></span>
                        </label>
                    </td>
                    <td><?php echo $pegawai->nama_gelar; ?></td>
                    <td><?php echo $pegawai->pangkat_gol; ?></td>
                    <td><?php echo $pegawai->jabatan; ?><br>Unit: <?php echo $pegawai->unit; ?></td>
                </tr>
                <?php
                    $i++;
                    endforeach; ?>
            <?php else: ?>
                <tr class="error">
                    <td colspan="6"><i>Tidak ada data</i></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
<?php else: ?>
    Data tidak ditemukan.
<?php endif; ?>

<?php if(isset($pgDisplay)): ?>
    <?php if($numpage > 0): ?>
        <?php echo $pgDisplay; ?><br>
        Halaman ke <?php echo $curpage; ?> dari <?php echo $numpage; ?> | Jumlah Data : <?php echo $jmlData; ?> | <?php echo $jumppage; ?><br>
    <?php endif; ?>
<?php endif; ?>

