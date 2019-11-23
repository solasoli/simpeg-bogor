<div class="row">
    <legend>
        <h2>Riwayat Pengembangan Kompetensi
            <!--<span class=" place-right"><a href="#" id="addPangkat" class="button primary"><span class="icon-plus"></span> tambah</a></span>-->
        </h2>
    </legend>

    <table class="table">
        <thead>
        <tr>
            <th>No</th>
            <th>Jenis</th>
            <th>Tgl.Diklat</th>
            <th>Nama Diklat</th>
            <th>Jam</th>
            <th>Penyelenggara</th>
            <th>No.STTPL</th>
        </tr>
        </thead>
        <tbody>
        <?php $x=1; foreach($diklats as $lsdata){ ?>
            <tr>
                <td><?php echo $x++."."; ?></td>
                <td><?php echo $lsdata->jenis_diklat; ?></td>
                <td><?php echo $lsdata->tgl_diklat; ?></td>
                <td><?php echo $lsdata->nama_diklat; ?></td>
                <td><?php echo $lsdata->jml_jam_diklat ?></td>
                <td><?php echo $lsdata->penyelenggara_diklat ?></td>
                <td><?php echo $lsdata->no_sttpl ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>