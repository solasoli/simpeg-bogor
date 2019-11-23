<?php


  $sql = "select * from hukuman_pemeriksaan";
  $query = mysqli_query($mysqli,$sql);


?>

<a class="btn btn-primary" type="button" onclick="add_data()" id="btnAdd">Tambah data</a>

<table class="table table-bordered ">
  <thead>
    <tr>
      <th>NO</th>
      <th>Nama Pegawai</th>
      <th>Tanggal</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $x=0;
      while($panggilans =  mysqli_fetch_object($query)){
        $pegawai = json_decode($panggilans->data_pegawai);

    ?>
    <tr>
      <td><?php echo ++$x ?></td>
      <td><?php echo $pegawai->id_pegawai ?></td>
      <td><?php //echo $panggilan->tanggal_pemeriksaan ?></td>
      <td>
        <a class="button alert outline" onclick="hapusPanggilan('<?php //echo $panggilan->id ?>')">Hapus</a>
        <a class="button info outline" href="<?php //echo site_url('Sipohan/panggilan_cetak/'.$panggilan->id) ?>"><span class="mif-download"></span></a>
        <a class="button" href="<?php // echo site_url('Sipohan/tim_pemeriksa_add') ?>">Buat Tim Pemeriksa</a>
      </td>
    </tr>
  <?php }  ?>
  </tbody>
</table>

<div class="modal fade" id="addformdialog" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header text-primary">
                <h5><span class="glyphicon glyphicon-calendar"></span> PERIODE PENILAIAN <span id="tahunnya2"></span></h5>
            </div>
            <div class="modal-body">
                <form role="form" class="form" id="tgl_laporan2">
                    <input type="hidden" id="tahun_penilaian2" name="tahun_penilaian2"/>
                    <div class="form-group">
                        <label for="inputUraian2" class="control-label">Tanggal dibuat pejabat penilai :</label>
                        <input type="text" class="form-control datepicker" id="tgl_dibuat" />

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a  onclick="save_tgl_pembuatan()" data-toggle="modal" class="btn btn-primary">SIMPAN</a>
                <a class="btn btn-danger" data-dismiss="modal">Batal</a>
            </div>
        </div>
    </div>
</div>
<script>

  function add_data(){

    alert("test");
  }

    function hapusPanggilan(id){
      Metro.dialog.create({
            title: "PERINGATAN",
            content: "<div>Apakah anda yakin untuk menghapus ?</div>",
            actions: [
                {
                    caption: "Hapus ",
                    cls: "js-dialog-close alert",
                    onclick: function(){
                        //alert("You clicked Agree action " + id);
                        $.post("<?php echo site_url('Sipohan/panggilan_delete') ?>",{id:id})
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
