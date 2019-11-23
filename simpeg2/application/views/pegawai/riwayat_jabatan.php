<div class="row">
    <legend>
        <h2>Riwayat Jabatan
            <!--<span class=" place-right"><a href="#" id="addPangkat" class="button primary"><span class="icon-plus"></span> tambah</a></span>-->
        </h2>
    </legend>

    <table class="table">
        <thead>
        <tr>
            <th>No</th>
            <th>Jenis</th>
            <th>Jabatan</th>
            <th>No.SK</th>
            <th>TMT</th>
        </tr>
        </thead>
        <tbody>
        <?php $x=1; foreach($jabatan as $jab){ ?>
            <tr>
                <td><?php echo $x++."."; ?></td>
                <td><?php echo $jab->jenis; ?></td>
                <td><?php echo $jab->nama_jabatan; ?></td>
                <td><?php echo $jab->no_sk; ?></td>
                <td><?php echo $jab->tmt ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>