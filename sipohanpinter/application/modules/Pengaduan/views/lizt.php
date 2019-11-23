
<table class="table compact table-border row-border cell-border" id="tablePengaduan">
  <thead>
    <tr>
    <th rowspan="2">No</th>
    <th rowspan="2">Nama Pelapor*</th>
    <th rowspan="2">No Telp</th>
    <th rowspan="2">Email</th>
    <th rowspan="2">Uraian Pengaduan</th>
    <th colspan="3" class="text-center">Terlapor</th>
    <th rowspan="2">Aksi</th>
  </tr>
  <tr>
    <th>Nama Terlapor</th>
    <th>Jabatan Terlapor</th>
    <th>Unit Kerja</th>
  </tr>
  </thead>
  <tbody>
  <?php $x=0; foreach($pengaduan as $pengaduan): ?>
  <tr>
    <td><?php echo ++$x ?></td>
    <td><?php echo $pengaduan->nama_pelapor ?></td>
    <td><?php echo $pengaduan->telp_pelapor ?></td>
    <td><?php echo $pengaduan->email_pelapor ?></td>
    <td><?php echo $pengaduan->uraian_pengaduan ?></td>
      <td><?php echo $pengaduan->nama_terlapor ?> </td>
    <td><?php echo $pengaduan->jabatan_terlapor ?> </td>
    <td><?php echo $pengaduan->unit_kerja_terlapor ?></td>
    <td><a class="button alert" onclick="hapus(<?php echo $pengaduan->id ?>)"><span class="mif-cross "></span><a></td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>
<script>

  function hapus(id){
    Metro.dialog.create({
          title: "PERINGATAN",
          content: "<div>Apakah anda yakin untuk menghapus ?</div>",
          actions: [
              {
                  caption: "Hapus ",
                  cls: "js-dialog-close alert",
                  onclick: function(){
                      $.post("<?php echo site_url('Pengaduan/hapus') ?>",{id:id})
                      .done(function(obj){
                        data = JSON.parse(obj);
                        if(data.status == 'SUCCESS'){
                          Metro.notify.create("Berhasil", "Informasi", {cls:"success"});
                          window.location.reload();
                        }else{
                          Metro.notify.create("GAGAL "+data.data, "Peringatan", {cls:"alert"});
                        }
                      })
                  }
              },
              {
                  caption: "Batal",
                  cls: "js-dialog-close",

              }
          ]
      });
  }

</script>
