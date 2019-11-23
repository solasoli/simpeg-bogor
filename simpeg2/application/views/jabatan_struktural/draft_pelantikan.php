<div class="container">
<h2>Draft Pelantikan Jabatan</h2>
<?php if($draft_pelantikan): ?>

    <table class="table hovered" id="tblListDraft">
        <thead>
        <tr>
            <th class="text-left">No</th>
            <th class="text-left">Nama Draft</th>
            <th class="text-left">Tgl. Pembuatan</th>
            <th class="text-left">Dibuat Oleh</th>
            <th class="text-left">Tgl. Pelantikan</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($draft_pelantikan as $d): ?>
        <tr>
            <td><?php echo $d->no_urut ?>.</td>
            <td class="right"><?php echo anchor('jabatan_struktural/draft_pelantikan/'.$d->id_draft, $d->nama); ?></td>
            <td class="right"><?php echo $d->created_time ?></td>
            <td class="right"><?php echo $d->nama_pembuat.' ('.$d->nip_baru.')'; ?></td>
            <td class="right"><?php echo ($d->tgl_pelantikan==''?'-':$d->tgl_pelantikan); ?></td>
        </tr>
        <?php endforeach; ?>
        </tbody>

        <tfoot></tfoot>
    </table>
<?php else: ?>
	<p>Belum ada draft pelantikan yang telah dibuat. <?php echo anchor('jabatan_struktural/draft_pelantikan_baru', 'Buat draft baru sekarang') ?>.</p>
<?php endif; ?>
</div>

<script type="text/javascript">
$("a[flag=confirm]").click(function(){
	if(!confirm('Lanjutkan menghapus draft?'))
		return false;
});
</script>

<script>
    $('#tblListDraft').dataTable({
        "paging": true,
        "ordering": false,
        "info": true
    });
</script>