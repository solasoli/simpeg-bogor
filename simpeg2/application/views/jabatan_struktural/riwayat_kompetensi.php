<?php if(isset($riwayat_kompetensi)): ?>
    <table class="table striped hovered cell-hovered border bordered">
        <thead>
        <tr>
            <th class="sortable-column">Sumber</th>
            <th class="sortable-column">Bidang</th>
            <th class="sortable-column">Tahun</th>
            <th class="sortable-column">Durasi</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($riwayat_kompetensi as $r): ?>
            <tr>
                <td><?php echo $r->sumber ?></td>
                <td><?php echo $r->bidang ?></td>
                <td><?php echo $r->tahun ?></td>
                <td><?php echo $r->durasi ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>


<?php else: ?>
    Tidak ada data riwayat kompetensi.
<?php endif;