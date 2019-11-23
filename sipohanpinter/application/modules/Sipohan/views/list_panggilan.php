<?php

  foreach($panggilans as $panggilan) :
    $pegawai = json_decode($panggilan->data_pegawai);
?>
<div data-role="panel"
    data-title-caption="<strong>
      <?php echo $pegawai->nama ?></strong>"
    data-collapsible="true">
    <div class="row">
      <div class="cell-10">
        <table class="table compact">
          <tr>
            <td style="width:15%">Nama</td>
            <td style="width:1%">:</td>
            <td style="text-align:left"><?php echo $pegawai->nama ?></td>
          </tr>
          <tr>
            <td style="width:15%">NIP</td>
            <td style="width:1%">:</td>
            <td style="text-align:left"><?php echo $pegawai->nip ?></td>
          </tr>
          <tr>
            <td style="width:15%">Jabatan</td>
            <td style="width:1%">:</td>
            <td style="text-align:left"><?php echo $pegawai->jabatan ?></td>
          </tr>
          <tr>
            <td style="width:15%">Unit Kerja</td>
            <td style="width:1%">:</td>
            <td style="text-align:left"><?php echo $pegawai->unit_kerja ?></td>
          </tr>
        </table>
      </div>
      <div class="2">
        <div class="img-container  text-center">
          <img style="width:100px" src="http://simpeg.kotabogor.go.id/simpeg/foto/<?php echo $panggilan->id_pegawai.'.jpg' ?>">
        </div>
    </div>
  </div>
  <hr />
<div class="row">

  <div class="cell-6">
    <table class="table compact">
      <form name="formPanggilan_<?php echo $panggilan->id ?>"
        id="formPanggilan_<?php echo $panggilan->id ?>">

      <?php $pelanggaran = json_decode($panggilan->data_pelanggaran) ; ?>
      <div class="form-group">
        <a class="button info outline" href="<?php echo site_url('Sipohan/detail/'.$panggilan->id) ?>">Detail</a>
        <a class="button alert outline" onclick="hapusPanggilan('<?php echo $panggilan->id ?>')">Hapus</a>
      </div>
    </form>
    </table>
  </div>
  <div class="cell-6">


  </div>
</div>


</div><!-- end panel -->
<br/>
<?php endforeach; ?>

<script type="text/javascript">

    function ubahPanggilan(id){

      dugaan = $("#dugaan_" + id).val();
      ancaman = $("#ancaman_hukuman_" + id).val();
      status_pemeriksaan = $("#status_pemeriksaan_"+id).val();

      hari = $("#hari_"+id).val();
      tanggal = $("#tanggal_"+id).val();
      waktu = $("#waktu_"+id).val();
      tempat = $("#tempat_"+id).val();
      $.post("<?php echo site_url('Sipohan/panggilan_update') ?>",{
        "id_pemeriksaan":id,
        "dugaan":dugaan,
        "ancaman":ancaman,
        "status_pemeriksaan":status_pemeriksaan,
        "hari":hari,
        "tanggal":tanggal,
        "waktu":waktu,
        "tempat":tempat
      })
      .done(function(obj){
        //alert(obj);
        data = JSON.parse(obj);
        if(data.status == 'SUCCESS'){
          Metro.notify.create("Data Tersimpan", "Informasi", {cls:"success"});
        }else{
          Metro.notify.create("Gagal Menyimpan", "Peringatan", {cls:"alert"});
        }
      })
      .fail(function() {
        alert( "error" );
      })
    }


    function step1(){
      tingkat = $("#selecttingkat").val();
      var jenis =
      "    <select class='' name='selecttingkat' id='selecttingkat'>" +
      "<option value='Ringan'>Bla bla</option>" +
      "<option value='Sedang'>Bla Bla</option>" +
      "<option value='Berat'>Berat</option>" +
      "</select> ";
      $("#jenis").html(jenis);
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
                        //  alert(obj);

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

    function hapusPemeriksa(id){

      Metro.dialog.create({
            title: "PERINGATAN",
            content: "<div>Apakah anda yakin untuk menghapus ?</div>",
            actions: [
                {
                    caption: "Hapus ",
                    cls: "js-dialog-close alert",
                    onclick: function(){
                        //alert("You clicked Agree action " + id);
                        $.post("<?php echo site_url('Sipohan/pemeriksa_delete') ?>",{id:id})
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
