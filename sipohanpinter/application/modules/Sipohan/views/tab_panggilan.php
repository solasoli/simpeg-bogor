

<div class="row">

  <div class="cell-6">
    <table class="table compact">
      <form name="formPanggilan_<?php // echo $panggilan->id ?>"
        id="formPanggilan_<?php // echo $panggilan->id ?>">

      <?php $pelanggaran = json_decode($panggilan->data_pelanggaran) ; ?>
      <tr>
        <td style="width:15%">Dugaan</td>
        <td style="width:1%">:</td>
        <td style="text-align:left">
          <input type="text"
                name="dugaan" id="dugaan_<?php echo $panggilan->id ?>"
                value="<?php echo $pelanggaran->pelanggaran ?>" />
                <input type="hidden" name="panggilan_id" value="<?php echo $panggilan->id ?>" />
            </td>
      </tr>
      <tr>
        <td style="width:15%">Ancaman</td>
        <td style="width:1%">:</td>
        <td style="text-align:left">
          <?php //echo $panggilan->ancaman_hukuman ?>
          <select data-role="select" name='ancaman_hukuman_<?php echo $panggilan->id ?>'
            id='ancaman_hukuman_<?php echo $panggilan->id ?>'>

            <?php foreach($tingkat as $t): ?>
              <option value="<?php echo $t->tingkat_hukuman ?>"
                <?php echo $t->tingkat_hukuman == $panggilan->ancaman_hukuman ? 'selected' : ''?>>
                <?php echo $t->tingkat_hukuman ?></option>
            <?php endforeach; ?>
          </select>
        </td>
      </tr>
      <tr>
        <td style="width:15%">Status</td>
        <td style="width:1%">:</td>
        <td style="text-align:left">
          <?php //echo $panggilan->status_pemeriksaan ?>
          <select data-role="select" name='status_pemeriksaan' id='status_pemeriksaan_<?php echo $panggilan->id ?>'>
            <option value="PANGGILAN_1" <?php echo $panggilan->status_pemeriksaan == 'PANGGILAN_1' ? 'selected' : '' ?>>PANGGILAN 1</option>
            <option value="PANGGILAN_2" <?php echo $panggilan->status_pemeriksaan == 'PANGGILAN_2' ? 'selected' : '' ?>>PANGGILAN 2</option>

          </select>
        </td>
      </tr>
      <tr>
        <td style="width:15%">Hari</td>
        <td style="width:1%">:</td>
        <td style="text-align:left">
          <?php $pelanggaran = json_decode($panggilan->data_pelanggaran);
          //print_r($pelanggaran);exit;
          ?>
          <select data-role="select" name='hari_<?php echo $panggilan->id ?>' id='hari_<?php echo $panggilan->id ?>'>
            <option></option>
            <option value="Senin" <?php echo $pelanggaran->hari_pemeriksaan == 'Senin' ? 'selected' : '' ;?>>Senin</option>
            <option value="Selasa" <?php echo $pelanggaran->hari_pemeriksaan == 'Selasa' ? 'selected' : '' ;?>>Selasa</option>
            <option value="Rabu" <?php echo $pelanggaran->hari_pemeriksaan == 'Rabu' ? 'selected' : '' ;?>>Rabu</option>
            <option value="Kamis" <?php echo $pelanggaran->hari_pemeriksaan == 'Kamis' ? 'selected' : '' ;?>>Kamis</option>
            <option value="Jumat" <?php echo $pelanggaran->hari_pemeriksaan == 'Jumat' ? 'selected' : '' ;?>>Jumat</option>
            <option value="Sabtu" class="fg-red" <?php echo $pelanggaran->hari_pemeriksaan == 'Sabtu' ? 'selected' : '' ;?>>Sabtu</option>
            <option value="Minggu" class="fg-red" <?php echo $pelanggaran->hari_pemeriksaan == 'Minggu' ? 'selected' : '' ;?>>Minggu</option>
          </select>
        </td>
      </tr>
      <tr>
        <td style="width:15%">Tanggal</td>
        <td style="width:1%">:</td>
        <td style="text-align:left">
          <input data-role="datepicker" name="tanggal_<?php echo $panggilan->id ?>" id="tanggal_<?php echo $panggilan->id ?>" data-locale="id-ID" data-value="<?php echo $pelanggaran->tanggal_pemeriksaan ?>"/>
        </td>
      </tr>
      <tr>
        <td style="width:15%">Waktu</td>
        <td style="width:1%">:</td>
        <td style="text-align:left">
          <input data-role="timepicker" name="waktu_<?php echo $panggilan->id ?>"
              data-seconds="false"
              id="waktu_<?php echo $panggilan->id ?>" data-locale="id-ID" data-value="<?php echo $pelanggaran->waktu_pemeriksaan ?>"/>
        </td>
      </tr>
      <tr>
        <td style="width:15%">Tempat</td>
        <td style="width:1%">:</td>
        <td style="text-align:left">

          <input type="text" name="tempat_<?php echo $panggilan->id ?>" id="tempat_<?php echo $panggilan->id ?>" value="<?php echo $pelanggaran->tempat_pemeriksaan ?>"/>
        </td>
      </tr>
      <tr>
        <td colspan="3" style='text-align:left'>
          <a class="button info outline" onclick="ubahPanggilan('<?php echo $panggilan->id ?>')">Ubah</a>
          <a class="button alert outline" onclick="hapusPanggilan('<?php echo $panggilan->id ?>')">Hapus</a>
          <a class="button info outline" target="_blank" href="<?php echo site_url('Sipohan/panggilan_cetak/'.$panggilan->id) ?>">
            cetak surat panggilan
          </a>

        </td>
      </tr>
    </form>
    </table>
  </div>
  <div class="cell-6">


  </div>
</div>
