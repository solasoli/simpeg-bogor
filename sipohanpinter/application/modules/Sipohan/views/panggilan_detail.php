
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
            <td style="width:15%">Pangkat</td>
            <td style="width:1%">:</td>
            <td style="text-align:left"><?php echo $pegawai->pangkat ?></td>
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
  <!-- tab -->
<div class="row">
  <div class="cell-12">
    <ul class="tabs-expand-md" data-role="tabs">
      <li id="li_panggilan"><a href="#tab_panggilan">Panggilan</a></li>
      <li id="li_panggilan"><a href="#tab_pemeriksaan">Pemeriksaan</a></li>
      <li id="li_panggilan"><a href="#tab_penjatuhan">Penjatuhan</a></li>

    </ul>

    <!-- tab panggilan -->
    <div  id="tab_panggilan" >
      <form name="formPanggilan_<?php echo $panggilan->id ?>"
        id="formPanggilan_<?php echo $panggilan->id ?>">
      <div class="row">

        <div class="cell-6">
          <table class="table compact table-border" >
            <?php $pelanggaran = json_decode($panggilan->data_pelanggaran) ; // print_r($pelanggaran->pelanggaran);exit;?>
            <tr>
              <td style="width:30%">Dugaan Pelanggaran</td>
              <td style="width:1%">:</td>
              <td style="text-align:left">
                <textarea cols="5" rows="3"
                      name="dugaan" id="dugaan_<?php echo $panggilan->id ?>"><?php echo trim($pelanggaran->pelanggaran) ?></textarea>
                      <input type="hidden" name="panggilan_id" value="<?php echo $panggilan->id ?>" />
                  </td>
            </tr>

            <tr>
              <td style="width:15%">Panggilan Ke</td>
              <td style="width:1%">:</td>
              <td style="text-align:left">
                <?php //echo $panggilan->status_pemeriksaan ?>
                <select data-role="select" name='status_pemeriksaan' id='status_pemeriksaan_<?php echo $panggilan->id ?>'>
                  <option></option>
                  <option value="PANGGILAN_1" <?php echo $panggilan->status_pemeriksaan == 'PANGGILAN_1' ? 'selected' : '' ?>>1</option>
                  <option value="PANGGILAN_2" <?php echo $panggilan->status_pemeriksaan == 'PANGGILAN_2' ? 'selected' : '' ?>>2</option>

                </select>
              </td>
            </tr>
            <tr>
              <td style="width:15%">Hari</td>
              <td style="width:1%">:</td>
              <td style="text-align:left">
                <?php $pelanggaran = json_decode($panggilan->data_panggilan);
                //print_r($pelanggaran);exit;

                ?>
                <select data-role="select" name='hari_<?php echo $panggilan->id ?>' id='hari_<?php echo $panggilan->id ?>'>
                  <option></option>
                  <option value="Senin" <?php echo isset($pelanggaran->hari_panggilan) == 'Senin' ? 'selected' : '' ;?>>Senin</option>
                  <option value="Selasa" <?php echo isset($pelanggaran->hari_panggilan) == 'Selasa' ? 'selected' : '' ;?>>Selasa</option>
                  <option value="Rabu" <?php echo isset($pelanggaran->hari_panggilan) == 'Rabu' ? 'selected' : '' ;?>>Rabu</option>
                  <option value="Kamis" <?php echo isset($pelanggaran->hari_panggilan) == 'Kamis' ? 'selected' : '' ;?>>Kamis</option>
                  <option value="Jumat" <?php echo isset($pelanggaran->hari_panggilan) == 'Jumat' ? 'selected' : '' ;?>>Jumat</option>
                  <option value="Sabtu" class="fg-red" <?php echo isset($pelanggaran->hari_panggilan) == 'Sabtu' ? 'selected' : '' ;?>>Sabtu</option>
                  <option value="Minggu" class="fg-red" <?php echo isset($pelanggaran->hari_panggilan) == 'Minggu' ? 'selected' : '' ;?>>Minggu</option>
                </select>
              </td>
            </tr>
            <tr>
              <td style="width:15%">Tanggal Pemeriksaan</td>
              <td style="width:1%">:</td>
              <td style="text-align:left">
                <input data-role="calendarpicker"
                name="tanggal_<?php echo $panggilan->id ?>" id="tanggal_<?php echo $panggilan->id ?>"
                data-locale="id-ID"
                data-format="%Y-%m-%d"
                value="<?php echo isset($pelanggaran->tanggal_panggilan) ? $pelanggaran->tanggal_panggilan : "" ?>"/>
              </td>
            </tr>
            <tr>
              <td style="width:15%">Waktu</td>
              <td style="width:1%">:</td>
              <td style="text-align:left">
                <input data-role="timepicker" name="waktu_<?php echo $panggilan->id ?>"
                    data-seconds="false"
                    id="waktu_<?php echo $panggilan->id ?>" data-locale="id-ID" data-value="<?php echo isset($pelanggaran->waktu_panggilan) ? $pelanggaran->waktu_panggilan : "" ?>"/>
              </td>
            </tr>
            <tr>
              <td style="width:15%">Tempat</td>
              <td style="width:1%">:</td>
              <td style="text-align:left">

                <input type="text" name="tempat_<?php echo $panggilan->id ?>" id="tempat_<?php echo $panggilan->id ?>" value="<?php echo isset($pelanggaran->tempat_panggilan) ? $pelanggaran->tempat_panggilan : "" ?>"/>
              </td>
            </tr>
            <tr>
              <td style="width:15%">Tanggal Surat</td>
              <td style="width:1%">:</td>
              <td style="text-align:left">
                <input data-role="calendarpicker"
                name="tanggal_surat_<?php echo $panggilan->id ?>" id="tanggal_surat_<?php echo $panggilan->id ?>"
                data-locale="id-ID"
                data-format="%Y-%m-%d"
                value="<?php echo isset($pelanggaran->tanggal_surat) ? $pelanggaran->tanggal_surat : "" ?>"/>
              </td>
            </tr>
            </table>
        </div>
        <div class="cell-5">
          <table class="table compact table-border">
            <tr>
              <td colspan="3">Menghadap kepada</td>
            </tr>
            <tr>
              <td style="width:15%">NIP</td>
              <td style="width:1%">:</td>
              <td style="text-align:left">
                <div class="form-group">
                    <script>
                      var pemanggilButtons = [
                          {
                              html: "<span class='mif-search'></span>",
                              cls: "default",
                              onclick: "search_pemanggil($('#nip_pemanggil').val())"
                          }
                      ]
                  </script>
                  <input type="number"
                      data-role="input"
                      id="nip_pemanggil"
                      name="nip_pemanggil"
                      data-clear-button="false"
                      data-custom-buttons="pemanggilButtons">
                  </div>
              </td>
            </tr>
            <tr>
                <td></td><td></td>
                <td>
                  <?php if(isset($pelanggaran->id_pemanggil)) {
                      $pemanggil = $this->sipohan->get_pegawai($pelanggaran->id_pemanggil);

                    ?>
                    <input type="hidden" id="id_pemanggil" name="id_pemanggil" value="<?php echo $pelanggaran->id_pemanggil ?>"/>
                    <div id="nama_pemanggil"><?php echo $pemanggil->nama ?></div>
                    <div id="pangkat_pemanggil"><?php echo $pemanggil->pangkat_gol ?></div>
                    <div id="jabatan_pemanggil"><?php echo $pemanggil->jabatan ?></div>
                <?php }else{

                  ?>
                  <input type="hidden" id="id_pemanggil" name="id_pemanggil" value="<?php echo $atasan->id_pegawai ?>"/>
                  <div id="nama_pemanggil"><?php echo $atasan->nama ?></div>
                  <div id="pangkat_pemanggil"><?php echo $atasan->pangkat ?></div>
                  <div id="jabatan_pemanggil"><?php echo $atasan->jabatan ?></div>
                <?php } ?>
                </td>
            </tr>
            <tr>
              <td colspan="3">Penandatangan Surat</td>
            </tr>
            <tr>
              <td style="width:15%">NIP</td>
              <td style="width:1%">:</td>
              <td style="text-align:left">
                <div class="form-group">
                    <script>
                      var penandatanganButtons = [
                          {
                              html: "<span class='mif-search'></span>",
                              cls: "default",
                              onclick: "search_penandatangan($('#nip_penandatangan').val())"
                          }
                      ]
                  </script>
                  <input type="number"
                      data-role="input"
                      id="nip_penandatangan"
                      name="nip_penandatangan"
                      data-clear-button="false"
                      data-custom-buttons="penandatanganButtons">
                  </div>
              </td>
            </tr>
            <tr>
                <td></td><td></td>
                <td>
                    <?php
                      //$pelanggaran->id_penandatangan;
                      if(isset($pelanggaran->id_penandatangan)):
                        $penandatangan = $this->sipohan->get_pegawai($pelanggaran->id_penandatangan);
                        ?>


                    <input type="hidden" name="id_penandatangan" id="id_penandatangan" value="<?php echo isset($penandatangan)  ? $penandatangan->id_pegawai : '' ?>"/>
                    <div id="nama_penandatangan"><?php echo $penandatangan ? $penandatangan->nama : "" ?></div>
                    <div id="pangkat_penandatangan"><?php echo $penandatangan ? $penandatangan->pangkat_gol : "" ?></div>
                    <div id="jabatan_penandatangan"><?php echo $penandatangan ? $penandatangan->jabatan : "" ?></div>

                  <?php else: ?>

                    <input type="hidden" name="id_penandatangan" id="id_penandatangan"/>
                    <div id="nama_penandatangan"></div>
                    <div id="pangkat_penandatangan"></div>
                    <div id="jabatan_penandatangan"></div>

                  <?php endif; ?>
                </td>
            </tr>
          </table>
        </div>

      </div>
      <div class="row">
        <div class="form-group">
          <a class="button info outline" onclick="ubahPanggilan('<?php echo $panggilan->id ?>')">Simpan Perubahan</a>
          <a class="button alert outline" onclick="hapusPanggilan('<?php echo $panggilan->id ?>')">Hapus</a>
          <a class="button info outline" target="_blank" href="<?php echo site_url('Sipohan/panggilan_cetak/'.$panggilan->id) ?>">
            cetak surat panggilan
          </a>
        </div>
      </div>
      </form>
    </div>
    <!-- end of tab panggilan -->
    <div id="tab_pemeriksaan" >
        <?php  $this->load->view('Sipohan/tim_pemeriksa_add'); ?>
    </div>
    <div id="tab_penjatuhan" >

        <?php $this->load->view('Sipohan/tab_penjatuhan'); ?>
        <?php
            $huk = $this->db->get_where('hukuman',array('id_hukuman_pemeriksaan'=>$panggilan->id));
            if($barisHuk = $huk->row()){ ?>
              <a class="button success ani-hover-heartbeat" href="<?php echo site_url('Sipohan/ubahPenjatuhan/'.$barisHuk->id_hukuman) ?>">Ubah SK Penjatuhan Hukuman</a>
              <a class="button primary ani-hover-heartbeat" target="_blank" href="<?php echo site_url('Sipohan/penjatuhan/'.$barisHuk->id_hukuman) ?>">Cetak SK Penjatuhan Hukuman</a>

            <?php
          }else{ ?>
            <a class="button success ani-hover-heartbeat" href="<?php echo site_url('Sipohan/data_penjatuhan/'.$panggilan->id) ?>">Buat SK Penjatuhan Hukuman</a>
          <?php
          }
          ?>

      </div>
  </div>
</div>




      <!--a class="button text-right ani-hover-heartbeat" href="<?php echo site_url('Sipohan/tim_pemeriksa_add/'.$panggilan->id) ?>">Tambah Tim Pemeriksa</a -->



</div><!-- end panel -->
<br/>


<script type="text/javascript">
function search_by_nip(nip, key){

  $.post("<?php echo site_url('Sipohan/search_nip'); ?>",{nip:nip})
  .done(function(obj){

    data = JSON.parse(obj);
    if(data.status == 'SUCCESS'){
      console.log(data.data);
      pegawai = data.data;

        $("#id_"+key).val(pegawai.id_pegawai);
        $("#nip_"+key).val(pegawai.nip);
        $("#nama_"+key).html(pegawai.nama);
        $("#pangkat_"+key).html(pegawai.pangkat);
        $("#jabatan_"+key).html(pegawai.jabatan);
        //$("#unit_kerja_pememanggil").html(pegawai.unit_kerja);
    }else{
      alert("Pegawai tidak ditemukan");
    }

  });
}

function search_pemanggil(nip){
  $.post("<?php echo site_url('Sipohan/search_nip'); ?>",{nip:nip})
  .done(function(obj){
    data = JSON.parse(obj);
    if(data.status == 'SUCCESS'){
      console.log(data.data);
      pegawai = data.data;
        $("#id_pemanggil").val(pegawai.id_pegawai);
        $("#nama_pemanggil").html(pegawai.nama);
        $("#pangkat_pemanggil").html(pegawai.pangkat);
        $("#jabatan_pemanggil").html(pegawai.jabatan);
        //$("#unit_kerja_pememanggil").html(pegawai.unit_kerja);
    }else{
      alert("Pegawai tidak ditemukan");
    }

  });
}




function search_penandatangan(nip){
  $.post("<?php echo site_url('Sipohan/search_nip'); ?>",{nip:nip})
  .done(function(obj){
    data = JSON.parse(obj);
    if(data.status == 'SUCCESS'){
      console.log(data.data);
      pegawai = data.data;
        $("#id_penandatangan").val(pegawai.id_pegawai);
        $("#nama_penandatangan").html(pegawai.nama);
        $("#pangkat_penandatangan").html(pegawai.pangkat);
        $("#jabatan_penandatangan").html(pegawai.jabatan);
        //$("#unit_kerja_pememanggil").html(pegawai.unit_kerja);
    }else{
      alert("Pegawai tidak ditemukan");
    }

  });
}
    function ubahPanggilan(id){

      dugaan = $("#dugaan_" + id).val();
      ancaman = $("#ancaman_hukuman_" + id).val();
      status_pemeriksaan = $("#status_pemeriksaan_"+id).val();

      hari = $("#hari_"+id).val();
      tanggal = $("#tanggal_"+id).val();
      waktu = $("#waktu_"+id).val();
      tempat = $("#tempat_"+id).val();
      tanggal_surat = $("#tanggal_surat_"+id).val();



      $.post("<?php echo site_url('Sipohan/panggilan_update') ?>",{
        "id_pemeriksaan":id,
        "dugaan":dugaan,
        "ancaman":ancaman,
        "status_pemeriksaan":status_pemeriksaan,
        "hari":hari,
        "tanggal":tanggal,
        "waktu":waktu,
        "tempat":tempat,
        "tanggal_surat":tanggal_surat,
        "id_pemanggil":$("#id_pemanggil").val(),
        "id_penandatangan":$("#id_penandatangan").val()
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
