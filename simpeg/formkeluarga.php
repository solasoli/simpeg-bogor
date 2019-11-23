<?
extract($_POST);
$h=$_REQUEST['h'];
$ha=$_REQUEST['ha'];
$e=$_REQUEST['e'];
if($h!=NULL)
mysqli_query($mysqli,"delete from keluarga where id_keluarga=$h");

if($ha!=NULL)
mysqli_query($mysqli,"delete from anak where id_anak=$ha");


if($e!=NULL)
{
$gi=mysqli_query($mysqli,"Select * from keluarga where id_keluarga=$e");
$co=mysqli_fetch_array($gi);

 $tgl=substr($co[5],8,2);
  $bln=substr($co[5],5,2);
  $thn=substr($co[5],0,4);
}

if($stat!=NULL)
{

if($stat==1 or $stat==5)
$jk='Pria';
elseif($stat==2 or $stat==6)
$jk='Wanita';

if($co!=NULL)
mysqli_query($mysqli,"update keluarga set id_status=$stat,tempatlahir='$tmpt',tgl_lahir='$thn-$bln-$tgl',nama='$nama',pekerjaan='$pkr',jk='$jk', keterangan='$keterangan' where id_keluarga=$co");
else
{

if($stat==9)
{
mysqli_query($mysqli,"update pegawai set nama_istri='$nama',tempat_lahir_istri='$tmpt',tgl_lahir_istri='$thn-$bln-$tgl',status_kawin='Menikah' where id_pegawai=$ata[0]");
//echo("update pegawai set nama_istri='$nama',tempat_lahir_istri='$tmpt',tgl_lahir_istri='$thn-$bln-$tgl' where id_pegawai=$ata[0]");
}
elseif($stat==10)
{
mysqli_query($mysqli,"insert into anak (id_pegawai,nama_anak,tempat_lahir,tgl_lahir) values ($ata[0],'$nama','$tmpt','$thn-$bln-$tgl')");
//echo("insert into anak (id_pegawai,nama_anak,tempat_lahir,tgl_lahir) values ($ata[0],'$nama','$tmpt','$thn-$bln-$tgl')");
}
else
{
mysqli_query($mysqli,"insert into keluarga (id_pegawai,id_status,tempatlahir,tgl_lahir,nama,pekerjaan,jk,keterangan) values ($ata[0],$stat,'$tmpt','$thn-$bln-$tgl','$nama','$pkr','$jk','$keterangan')");

}
}

}
include("keluarga.php");

?>
</br>
</br>
<b><font size= "3px" >---FORM ISIAN DATA KELUARGA-- </font></b>
</br>
</br>
<form id="form1" name="form1" method="post" action="index2.php">
  <table width="400" border="1" align="Left" cellpadding="5" cellspacing="0">
    <tr>
      <td>Status</td>
      <td>:</td>
      <td><label>
        <select name="stat" id="stat">
		<?
		$q1=mysqli_query($mysqli,"select * from status_kel");
		while($data=mysqli_fetch_array($q1))
		{
		if($co[2]==$data[0])
		echo("<option value=$data[0] selected>$data[1]</option>");
		else
		echo("<option value=$data[0] >$data[1]</option>");
		}
		?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Nama</td>
      <td>:</td>
      <td><label>
        <input name="nama" type="text" id="nama" value="<?
		
		if($e!=NULL)
		echo($co[3]);
		
		  ?>" size="40" />
      </label></td>
    </tr>
    <tr>
      <td>Jenis Kelamin </td>
      <td>:</td>
      <td><label>
        <select name="jk" id="jk">
          <option value="Pria">Pria</option>
          <option value="Wanita">Wanita</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Tempat Lahir </td>
      <td>:</td>
      <td><input name="tmpt" type="text" id="tmpt" value="<?
		
		if($e!=NULL)
		echo($co[4]);
		
		  ?>" size="40" /></td>
    </tr>
    <tr>
      <td>Pekerjaan</td>
      <td>:</td>
      <td nowrap="nowrap"><input name="pkr" type="text" id="pkr" value="<?
		
		if($e!=NULL)
		echo($co[6]);
		
		  ?>" size="40" /></td>
    </tr>
    <tr>
      <td>Tanggal Lahir 
      <input name="x" type="hidden" id="x" value="formkeluarga.php" />
      <input name="co" type="hidden" id="co" value="<? echo($e); ?>" /></td>
      <td>:</td>
      <td nowrap="nowrap"><label>
        tgl</label>
        <select name="tgl" id="tgl">
		
		<?
		echo("<option value=00 >Pilih</option>");
		for($i=1;$i<=31;$i++)
		{
		if($i<10)
		{
		if($tgl=="0$i")
		echo("<option value=0$i selected>$i</option>");
		else
		echo("<option value=0$i >$i</option>");
		
		}
		else
		{
		if($tgl==$i)
		echo("<option value=$i selected>$i</option>");
		else
		echo("<option value=$i>$i</option>");
		}
		}
		
		?>
        </select>
     <label> bln</label>
      <select name="bln" id="bln">
	 <? 	
	 echo("<option value=00 >Pilih</option>");
	 for($i=1;$i<=12;$i++)
		{
		if($i<10)
		{
		if($bln=="0$i")
		echo("<option value=0$i selected >$i</option>");
		else
		echo("<option value=0$i>$i</option>");
		}
		else
		{
		if($bln==$i)
		echo("<option value=$i selected>$i</option>");
		else
		echo("<option value=$i>$i</option>");
		
		}
		}
		?>
        </select>
      <label>  thn</label>
      <select name="thn" id="thn">
	  	<?
		$taon=date("Y");
		echo("<option value=0000 >Pilih</option>");
		for($i=$taon;$i>=1900;$i--)
		{
			if($thn==$i)
			echo("<option value=$i selected>$i</option>");
			else
			echo("<option value=$i >$i</option>");
		}
		?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td>Keterangan</td>
      <td>:</td>
      <td nowrap="nowrap"><label>
        <input name="keterangan" type="text" id="keterangan" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td nowrap="nowrap"><label>
        <input type="submit" name="Submit" value="Tambahkan" />
      </label></td>
    </tr>
  </table>
</form>
