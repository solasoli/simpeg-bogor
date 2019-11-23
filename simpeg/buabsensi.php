<?php $unit_kerja = new Unit_kerja;
if(!isset($bln))
$bln=date("m");

if(substr($bln,0,1)==0)
$urut=substr($bln,1,1);
else
$urut=$bln;

$bulan=array("bulan","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
 ?>


<h2>DAFTAR ABSENSI PEGAWAI BULAN <?php echo strtoupper($bulan[$urut]); echo " <br>".$unit_kerja->get_unit_kerja($unit['id_skpd'])->nama_baru ?><a href="#" class="btn btn-primary  hidden-print pull-right" onclick="window.print()">cetak</a></h2>

<?php

$maxday=array(0,30,28,31,30,31,30,31,31,30,31,30,31);

$q=mysqli_query($mysqli,"select concat(gelar_depan,' ',nama,' ',gelar_belakang),nip_baru,pegawai.id_pegawai from pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where id_unit_kerja=$unit[0] and flag_pensiun=0 order by pangkat_gol desc,mid(nip_baru,8,2) desc");

?>
     
<table align="center" width="95%" border="1" cellspacing="0" cellpadding="15">
  <tr>
    <td rowspan="2" align="center" valign="top" style="padding:5px; padding-bottom:10px;">No</td>
    <td rowspan="2" valign="top" align="center">Nama / NIP</td>
   
    <td style="padding-left:10px" colspan="<?php echo $maxday[$urut]; ?>">Absensi</td>
  </tr>
  <tr>
   <?php
   for($i=1;$i<=$maxday[$urut];$i++)
   echo("<td style=padding:5px width=25 >$i</td>");
   ?>
  </tr>
  <?php
  $no=1;
  while($data=mysqli_fetch_array($q))
  {
  ?>
  <tr>
    <td valign="top" align="center" ><?php echo $no; ?></td>
    <td  valign="top" nowrap="nowrap" style="padding:5px;"><?php echo $data[0]; echo("<br>"); echo $data[1]; ?></td>

    <?php

	for($i=1;$i<=$maxday[$urut];$i++)
   {
   if($i<10)
   $tgl="0$i";
   else
   $tgl=$i;
   $tanggal=date("Y")."-$bln-"."$tgl";
   $qln=mysqli_query($mysqli,"select count(*) from libur_nasional where tanggal='$tanggal'");
   $ln=mysqli_fetch_array($qln);
   $hari=date("D",strtotime($tanggal));
   
   if(!isset($ket))
   $ket="";
   
    if($hari=="Sun" or $hari=="Sat" or $ln[0]>0)
	$latar=" bgcolor=red ";
	else
	$latar=" ";
	
	//$qr=mysqli_query($mysqli,"select * from oasys_att_report where date_time like '".substr($tanggal,0,7)."%'");
	//$report=mysqli_fetch_array($qr);
	
   echo("<td $latar  width=25 > $ket </td>");
   

   }
	?>
  </tr>
  <?php
  $no++;
  }
  ?>
</table>
