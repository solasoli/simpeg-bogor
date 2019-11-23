
<table width="50%" border="1" cellspacing="0" cellpadding="5">

  <tr>
    <td>No.</td>
    <td>Periode Tahun</td>
    <td>Periode Bulan</td>
    <td>Tanggal Kalkulasi</td>
    <td>Aksi</td>
  </tr>

<?php
//echo "select * from knj_kinerja_master where id_pegawai_pelapor = '.$id.'";
  $master_query = mysqli_query($con,"select * from knj_kinerja_master where id_pegawai_pelapor = ".$id." order by tgl_input_kinerja DESC");

  while($master = mysqli_fetch_array($master_query)):

?>
  <tr>
    <td></td>
    <td><?php echo $master['periode_thn'] ?></td>
    <td><?php echo $master['periode_bln'] ?></td>
    <td><?php echo $master['tgl_update_kalkulasi'] ?></td>
    <td><div id="<?php echo $master['id_knj_master']?>"></div><a href="#" onclick="kalkulasi(<?php echo $master['periode_thn'].",".$master['periode_bln'].",".$id.",".$master['id_knj_master'] ?>)" class="btnKalkulasi">[Kalkulasi Nilai]</a></td>
  </tr>

<?php
endwhile;
?>
</table>
<script type="text/javascript">

  function kalkulasi(tahun, bulan, id_pegawai,id_knj_master){
    $("#"+id_knj_master).html("lagi kalkulasi sabaaaar...");
    $(".btnKalkulasi").hide();
    $.post("riwayat_ekinerja_run_kalkulasi.php", {"tahun":tahun, "bulan":bulan, "id_pegawai": id_pegawai}, function (data) {
      if(data == 'CALCULATION_SUCCESS'){

        $("#"+id_knj_master).html("kalkulasi berhasil");
      }else{
        $("#"+id_knj_master).html("kalkulasi gagal");
      }
        });

    $(".btnKalkulasi").show();
  }
</script>
