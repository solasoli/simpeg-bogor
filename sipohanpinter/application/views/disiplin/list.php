<div data-role="panel">
<table class="table compact row-border" id="tableHukuman">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama</th>
      <th>NIP</th>
      <th>Pangkat/Gol</th>
      <th>Unit Kerja</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $x=0; foreach($pelanggaran as $p) : ?>
    <tr>
      <td><?php echo ++$x ?></td>
      <td><?php echo $p->nama ?></td>
      <td><?php echo $p->nip_baru ?></td>
      <td><?php echo $p->pangkat_gol ?></td>
      <td><?php echo $p->nama_baru ?></td>
      <td><a href="<?php echo base_url('disiplin/detail') ?>" class="button info mini">Detail</a></td>
    </tr>

  <?php endforeach; ?>
</tbody>
</table>
</div>
<script>
  $(document).ready(function(){
    $("#tableHukuman").DataTable();
  })
</script>
