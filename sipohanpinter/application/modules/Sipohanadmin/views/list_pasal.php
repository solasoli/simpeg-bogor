
<table class="table compact table-border row-border cell-border" id="tablePasal">
  <thead>
    <tr>
    <th >No</th>
    <th>Pasal</th>

    <th >Deskripsi</th>
    <th >Aksi</th>
  </tr>
  </thead>
  <tbody>
  <?php $x=0; foreach($pasal as $pas): ?>
  <tr>
    <td><?php echo ++$x ?></td>
    <td><?php echo $pas->pasal.".".$pas->angka ?></td>

    <td><?php echo $pas->deskripsi ?></td>
    <td><a class="button alert" onclick="hapus(<?php echo $pas->id ?>)"><span class="mif-cross "></span><a></td>
  </tr>
<?php endforeach; ?>
</tbody>
</table>
<script>
  $(document).ready(function(){
    $("#tablePasal").DataTable();

  });

  function hapus(id){
    Metro.dialog.create({
          title: "PERINGATAN",
          content: "<div>Apakah anda yakin untuk menghapus ?</div>",
          actions: [
              {
                  caption: "Hapus ",
                  cls: "js-dialog-close alert",
                  onclick: function(){
                      $.post("<?php echo site_url('Sipohanadmin/hapus') ?>",{id:id})
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
