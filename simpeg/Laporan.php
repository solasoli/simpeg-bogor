

<table width="100%" border="1" cellspacing="0" cellpadding="3">
  <tr><center>
  Laporan Per <?php echo date('F Y');?>
  </tr></center>
  <tr>
    <td>Jumlah Pegawai</td>
  </tr>
  <?
include("konek.php");
$query = mysqli_query($mysqli,"SELECT nama FROM pegawai WHERE flag_pensiun = 0");
$jumlah = mysqli_num_rows($query);
echo(" <tr>
    <td nowrap>$jumlah orang</td>
  </tr>");
?>
</table>