<?php
extract($_GET);
$q=mysqli_query($link,"select * from pengaduan where id=$id");
$data=mysqli_fetch_array($q);

$qpro=mysqli_query($link,"select nama,nama_baru from pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai = pegawai.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja where  pegawai.id_pegawai=$data[1]");

//echo"select nama,nama_baru from pegawai inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai = pengaduan.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja where  pegawai.id_pegawai=$data[1]";
$pro=mysqli_fetch_array($qpro);

$qaset=mysqli_query($link,"select barang from kode_barang where id=$data[2]");
				$aset=mysqli_fetch_array($qaset);
				
					$t1=substr($data[3],8,2);
				$b1=substr($data[3],5,2);
				$th1=substr($data[3],0,4);
?>
<form action="menu.php" method="post" enctype="multipart/form-data" name="form1">
  <table align="center" width="90%" border="0" cellspacing="0" cellpadding="5">
    <tr>
      <td width="5%">Aset</td>
      <td width="2%">:</td>
      <td width="93%"><?php echo $aset[0]; ?></td>
    </tr>
    <tr>
      <td>Foto</td>
      <td>:</td>
      <td><img src="./gambar/<?php echo("$data[0].jpg"); ?>" width="50%" /></td>
    </tr>
    <tr>
      <td>Keluhan</td>
      <td>:</td>
      <td><?php echo $data[4]; ?></td>
    </tr>
    <tr>
      <td>Laporan Dari</td>
      <td>:</td>
      <td><?php echo "$pro[0] <br> $pro[1]"; ?></td>
    </tr>
    <tr>
      <td>Tanggal</td>
      <td>:</td>
      <td><?php echo "$t1-$b1-$th1"; ?></td>
    </tr>
    <tr>
      <td>Respon</td>
      <td>:</td>
      <td><label>
        <textarea name="respon" id="respon" cols="45" rows="5"></textarea>
      </label></td>
    </tr>
    <tr>
      <td>Foto</td>
      <td>:</td>
      <td><label>
        <input type="file" name="poto" id="poto">
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
      <input type="hidden" name="x" id="x" value="insertrespond.php">      </td>
      <td><label>
        <input type="submit" name="button" id="button" value="Respond">
      </label></td>
    </tr>
  </table>
</form>
<?php
extract($_GET);



?>
