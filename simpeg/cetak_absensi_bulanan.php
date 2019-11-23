<?php
include("konek.php");
extract($_GET);
$bulan=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
$qunit=mysqli_query($mysqli,"select nama_baru from unit_kerja where id_unit_kerja=$skpd");
$unit=mysqli_fetch_array($qunit);
$qbos=mysqli_query($mysqli,"select concat(gelar_depan,' ',nama,' ',gelar_belakang),nip_baru,jabatan.jabatan from jabatan inner join pegawai on pegawai.id_j=jabatan.id_j where id_unit_kerja=$skpd order by jabatan.eselon limit 0,1");
$bos=mysqli_fetch_array($qbos);
$q=mysqli_query($mysqli,"CALL PRCD_ABSENSI_HARIAN_REKAP_HARI( $bln, $thn, $skpd )");
ob_start();
?>
<p align="center"><br /><br /><br />Rekapitulasi Absensi <?php echo $unit[0]; ?> Bulan <?php echo (" $bulan[$bln] ".date("Y")); ?>  Berdasarkan Hari </p>
<table width="90%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#000">
  <tr>
    <td rowspan="2" align="center" style="padding:5;">Tanggal</td>
    <td colspan="7" align="center" style="padding:5;">Ketidakhadiran</td>
    <td rowspan="2" align="center" style="padding:5;">Tidak Apel</td>
    <td colspan="2" align="center" style="padding:5;">Persentase</td>
  </tr>
  <tr>
    <td align="center" style="padding:5;">Cuti</td>
    <td align="center" style="padding:5;">Dinas Luar</td>
    <td align="center" style="padding:5;">Dispensasi</td>
    <td align="center" style="padding:5;">Ijin</td>
    <td align="center" style="padding:5;">Sakit</td>
    <td align="center" nowrap="nowrap" style="padding:5;">Tanpa Keterangan</td>
    <td align="center" style="padding:5;">Total</td>
    <td align="center" style="padding:5;">Kehadiran</td>
    <td align="center" style="padding:5;">Apel</td>
  </tr>
  <?php
  while($data=mysqli_fetch_array($q))
  {
	  
	  echo(" <tr>
	  <td align=center>$data[0]</td>
	 
    <td align=center>$data[C]</td>
    <td align=center>$data[DL]</td>
    <td align=center>$data[DI]</td>
    <td align=center>$data[I]</td>
    <td align=center>$data[S]</td>
	 <td align=center>$data[TK]</td>
    <td align=center nowrap=nowrap>$data[TDK_HADIR]</td>
    <td align=center>$data[TDK_APEL]</td>
    <td align=center>$data[PERSEN_KEHADIRAN]</td>
    <td align=center>$data[PERSEN_APEL]</td>
  </tr>");
	  
	  
  }
  
  
  ?>
</table>
<br><br>
<table  width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="#000">
	<tr>
		<td>
			<?php for($i=0;$i<120;$i++){ 
				echo "&nbsp;";
			}
			?>
		</td>
		<td align="center">	
		<?php	
			$kepala = explode(",",$bos[2]);
			echo $kepala[0]."<br>".$kepala[1] ?>
			<br><br><br><br><br><br><br><br><br>
		<?php echo "<u>".$bos[0]."</u><br>".$bos[1] ?>
		
		</td>
	</tr>
</table>


<?php
$content = ob_get_clean();
require_once('html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('P', 'Legal', 'fr', true, 'UTF-8', 0);
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    //attachment
    //$html2pdf->Output('bookmark.pdf',F);
    //inline
    $html2pdf->Output('laporanabsensi.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>