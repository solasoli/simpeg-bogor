<?php if(isset($riwayat_hukuman)): ?>
    <table class="table striped hovered cell-hovered border bordered">
        <thead>
        <tr>
            <th class="sortable-column">Tingkat</th>
            <th class="sortable-column">Jenis</th>
            <th class="sortable-column">TMT</th>
            <th class="sortable-column">Keterangan</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($riwayat_hukuman as $r): ?>
        <tr>
            <td><?php echo $r->tingkat_hukuman ?></td>
            <td><?php echo $r->deskripsi ?></td>
            <td><?php echo $r->tmt ?></td>
            <td><?php echo $r->keterangan ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>
    </table>


<?php else: ?>
    Tidak ada data riwayat hukuman.
<?php endif;