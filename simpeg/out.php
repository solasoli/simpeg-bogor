<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
include("konek.php");
extract($_GET);
extract($_POST);
if(isset($idm))
{
if($jenis=='md'){
	$eksekusi = mysqli_query($mysqli,"update pegawai set flag_pensiun=1,tgl_pensiun_dini='$tahun-$bulan-$tanggal',status_aktif='Pensiun Meninggal Dunia' where id_pegawai=$idm");
}else{
	$eksekusi = mysqli_query($mysqli,"update pegawai set flag_pensiun=1,tgl_pensiun_dini='$tahun-$bulan-$tanggal',status_aktif='Pensiun Dini' where id_pegawai=$idm");
	
}
if($eksekusi){
	$query = "insert into log_pensiun(id_yang_pensiun,id_admin,tgl_pensiun,tgl_dipensiunkan) 
	values($idm,".$_SESSION['id_pegawai'].",'$tahun-$bulan-$tanggal',curdate())";
	mysqli_query($mysqli,$query);
}


if($_FILES['fm']['size']>0)
{
mysqli_query($mysqli,"insert into sk(id_pegawai,tgl_sk,tmt,id_kategori_sk) values ($idm,'$tahun-$bulan-$tanggal','$tahun-$bulan-$tanggal',8)");
$idsk=mysqli_insert_id();
$now=date("Y-m-d");
$qp=mysqli_query($mysqli,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama, nip_baru from pegawai where id_pegawai=$idm");
$peg=mysqli_fetch_array(qp);

if($jenis=='md')
{
 mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas,ket_berkas) values ($idm,2,'$now',1,'$tu','$now','PENSIUN','MENINGGAL DUNIA')");
 }
 else
 {
 mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,tgl_upload,byk_hal,tgl_berkas,created_date,nm_berkas,ket_berkas) values ($idm,2,'$now',1,'$tu','$now','PENSIUN','PENSIUN DINI')");
 
 
 }           $idarsip = mysqli_insert_id();
            mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke,file_name) values ($idarsip,1,'')");
            $idisi = mysqli_insert_id();
            $namafile = "$peg[1]-$idarsip-$idisi.jpg";
            mysqli_query($mysqli,"update isi_berkas set file_name='$namafile' where id_isi_berkas=$idisi");
			$tmp=$_FILES['fm']['tmp_name'];
            move_uploaded_file($tmp, "./Berkas/$namafile");

}

echo("<div align=center>Data Pegawai Sudah Dinonaktifkan </div>");
include("list2.php");
}
else
{
$qp=mysqli_query($mysqli,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama, nip_baru from pegawai where id_pegawai=$od");
$peg=mysqli_fetch_array($qp);
?>
<?php 
  
if($act==2)
{
?>
<form action="index3.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <table width="80%" border="0" align="center" cellpadding="10" cellspacing="0" class="table">
    <tr>
      <td>Nama 
      <input name="idm" type="hidden" id="idm" value="<?php echo $od; ?>" />
      <input name="x" type="hidden" id="x" value="out.php" />
      <input name="jenis" type="hidden" id="jenis" value="md" /></td>
      <td>:</td>
      <td><?php echo $peg[0]; ?></td>
    </tr>
    <tr>
      <td>Nip</td>
      <td>:</td>
      <td><?php echo $peg[1]; ?></td>
    </tr>
    <tr>
      <td>Tanggal Meninggal Dunia</td>
      <td>:</td>
      <td><label>
        tgl
        <select name="tanggal" id="tanggal">
        <?php
		for($i=1;$i<=31;$i++)
		{
		if($i<10)
		$tgl="0".$i;
		else
		$tgl=$i;
		echo("<option value=$tgl>$tgl </option>");
		}
		
		?>
        </select> 
        bln
        <select name="bulan" id="bulan">
        <?php
		
		$bolan=array('x','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
		for($j=1;$j<=12;$j++)
		{
		if($j<10)
		$bln="0".$j;
		else
		$bln=$j;
		echo("<option value=$bln>$bolan[$j]</option>");
		}
		?>
        </select> 
        thn
        <select name="tahun" id="tahun">
        <?php
		for($k=date("Y");$k>=2009;$k--)
		echo("<option value=$k> $k</option>");
		?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>SK Pensiun Meninggal Dunia</td>
      <td>:</td>
      <td><label>
        <input type="file" name="fm" id="fm" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="button" id="button" value="Simpan" />
      </label></td>
    </tr>
  </table>
</form>
<p>
  <?php
}
elseif($act==1)
{
?>
<form id="form2" name="form2" method="post" action="index3.php">
  <table width="80%" border="0" align="center" cellpadding="10" cellspacing="0" class="table">
    <tr>
      <td>Nama
        <input name="idm" type="hidden" id="idm" value="<?php echo $od; ?>" />
        <input name="x" type="hidden" id="x" value="out.php" />
          <input name="jenis" type="hidden" id="jenis" value="pd" /></td>
      <td>:</td>
      <td><?php echo $peg[0]; ?></td>
    </tr>
    <tr>
      <td>Nip</td>
      <td>:</td>
      <td><?php echo $peg[1]; ?></td>
    </tr>
    <tr>
      <td>Tanggal Pensiun Dini</td>
      <td>:</td>
      <td><label> tgl
        <select name="tanggal" id="tanggal">
              <?php
		for($i=1;$i<=31;$i++)
		{
		if($i<10)
		$tgl="0".$i;
		else
		$tgl=$i;
		echo("<option value=$tgl>$tgl </option>");
		}
		
		?>
            </select>
        bln
        <select name="bulan" id="bulan">
          <?php
		
		$bolan=array('x','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
		for($j=1;$j<=12;$j++)
		{
		if($j<10)
		$bln="0".$j;
		else
		$bln=$j;
		echo("<option value=$bln>$bolan[$j]</option>");
		}
		?>
        </select>
        thn
        <select name="tahun" id="tahun">
          <?php
		for($k=date("Y");$k>=2009;$k--)
		echo("<option value=$k> $k</option>");
		?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>SK Pensiun Dini</td>
      <td>:</td>
      <td><label>
        <input type="file" name="fm" id="fm" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="button2" id="button2" value="Simpan" />
      </label></td>
    </tr>
  </table>
</form>
<?php
}
}
?>
</p>

<p>&nbsp;</p>
</body>
</html>
