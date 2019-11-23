<table class="table compact row-border" id="tableHukuman">
  <thead>
    <tr>
      <th>No.</th>
      <th>Nama</th>
      <th>Jenis Hukuman</th>
      <th>No. SK</th>
      <th>TMT</th>
      <th>Berkas</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $x=0; foreach($pelanggaran as $p) : ?>
    <tr>
      <td><?php echo ++$x ?></td>
      <td><?php echo $this->sipohan->get_pegawai($p->id_pegawai)->nama ?></td>
      <td><?php echo $this->sipohan->get_jenis($p->id_jenis_hukuman)->deskripsi ?></td>
      <td><?php echo $p->no_keputusan ?></td>
      <td><?php echo $p->tmt ?></td>
      <td>
        <!--a class="button info"><span class="mif-download"></span></a-->
      </td>
      <td><a href="#" class="button info mini">Detail</a>
          <a href="#" class="button alert mini">Hapus</a>
        </td>
    </tr>
    <tr>
      <td colspan="7">
          <?php
            $sk = $this->sipohan->get_sk_hukdis($p->id_pegawai);

            foreach($sk as $s){
              echo $s->tgl_sk." - ".$s->id_kategori_sk."<a target='_blank' href='http://simpeg.kotabogor.go.id/admin/berkas.php?idb=".$s->id_berkas."'>
                <span class='mif-download'></span>
              </a><br/>";

            }
          ?>
      </td>
    </tr>
  <?php endforeach; ?>
</tbody>
</table>
<script>
  $(document).ready(function(){
    $("#tableHukuman").DataTable();
  })
</script>
