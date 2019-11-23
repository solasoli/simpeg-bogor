	<link rel="stylesheet" type="text/css" href="tcal.css" />
	<script type="text/javascript" src="jquery.js"></script>
	<script type="text/javascript" src="tcal.js"></script> 

<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.style2 {font-size: 10pt}
.style4 {font-size: 10px}
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
}
-->
</style>
<?
include("koncil.php");
extract($_POST);
extract($_GET);
if($ha==1)
{

mysql_query("delete from pegawai where id_pegawai=$id");
mysql_query("delete from pendidikan where id_pegawai=$id");
mysql_query("delete from sk where id_pegawai=$id");
mysql_query("delete from riwayat_mutasi_kerja where id_pegawai=$id");
mysql_query("delete from anak where id_pegawai=$id");
echo("<div align=center> data pegawai sudah dihapus!</div>");
}
if($id2!=NULL)
{
	$skr=date("d-m-Y H:i:s");
	$t0=substr($tglwin,0,2);
			$b0=substr($tglwin,3,2);
			$th0=substr($tglwin,6,4);
			
				$tx=substr($tgl,0,2);
			$bx=substr($tgl,3,2);
			$thx=substr($tgl,6,4);
			

			// Check if tgl lahir istri is not defined
			if($th0 && $b0 && $t0)
				$tgl_lhr_istri = "$th0-$b0-$t0";
			else
				$tgl_lhr_istri = '1900-01-01';

			
mysql_query("update pegawai set nama='$n',nip_lama='$nl',nip_baru='$nb',pangkat_gol='$gol',email='$email',alamat='$al',agama='$a',tempat_lahir='$tl',no_karpeg='$karpeg',NPWP='$npwp',pangkat_gol='$gol',ponsel='$hp',telepon='$telp',jenjab='$jenjab',kota='$kota',gol_darah='$darah',status_kawin='$kawin',jenis_kelamin='$jk',nama_istri='$win',tempat_lahir_istri='$twin',tgl_lahir_istri='$tgl_lhr_istri',keterangan='updated by TIM SIMPEG',tgl_lahir='$thx-$bx-$tx' where id_pegawai=$id2");

if($aktif=='Aktif' or $aktif=='Aktif Bekerja')
{
$t1=substr($pensiun,0,2);
			$b1=substr($pensiun,3,2);
			$th1=substr($pensiun,6,4);	
			if ($aktif=="Pindah Ke Instansi Lain")
			$flag=",flag_pensiun=1 ";
			elseif ($aktif=="Aktif" or $aktif=="Aktif Bekerja")
			$flag=",flag_pensiun=0 ";
			else
			$flag=" ";
mysql_query("update pegawai set status_aktif='$aktif',tgl_pensiun_dini='$th1-$b1-$t1' $flag where id_pegawai=$id2");
//echo("update pegawai set status_aktif='$aktif',tgl_pensiun_dini='$th1-$b1-$t1' $flag where id_pegawai=$id2");


}


for($g=1;$g<=$ja;$g++)
{
$ngaran=$_POST["anak"."$g"];	
$dmn=$_POST["la"."$g"];	
$ta=$_POST["tg"."$g"];	
$budak=$_POST["king"."$g"];	

$t6=substr($ta,0,2);
			$b6=substr($ta,3,2);
			$th6=substr($ta,6,4);
mysql_query("update anak set nama_anak='$ngaran',tempat_lahir='$dmn',tgl_lahir='$th6-$b6-$t6' where id_pegawai=$id and id_anak=$budak");
}

// UPDATE DIKLAT
for($z=1;$z<=$total_diklat;$z++)
{			
	$jenis_diklat 			= $_POST["jenis_diklat"."$z"];
	$tgl_diklat				= explode('-',$_POST["tgl_diklat"."$z"]);
	$tgl_diklat 			= $tgl_diklat[2].'-'.$tgl_diklat[1].'-'.$tgl_diklat[0];	 
	$jml_jam_diklat			= $_POST["jml_jam_diklat"."$z"];
	$nama_diklat			= $_POST["nama_diklat"."$z"];
	$penyelenggara_diklat	= $_POST["penyelenggara_diklat"."$z"];
	$id_diklat				= $_POST["id_diklat"."$z"];
							
	$qUpdateDiklat = "UPDATE diklat SET
						jenis_diklat 			= '$jenis_diklat',
						tgl_diklat	 			= '$tgl_diklat',
						jml_jam_diklat 			= '$jml_jam_diklat',
						nama_diklat				= '$nama_diklat',
						penyelenggara_diklat	= '$penyelenggara_diklat'
					 WHERE id_diklat = '$id_diklat'";			 
	mysql_query($qUpdateDiklat);
}
// END OF UPDATE DIKLAT

//update sk
for($z=1;$z<=$jsk;$z++)
{
$nona=$_POST["nosk"."$z"];	
$tmtna=$_POST["tmsk"."$z"];	
$tglna=$_POST["tgsk"."$z"];
$sahna=$_POST["sah"."$z"];	
$idna=$_POST["idsk"."$z"];	
$berina=$_POST["beri"."$z"];
$keke=$_POST["keket"."$z"];
	
$t8=substr($tglna,0,2);
			$b8=substr($tglna,3,2);
			$th8=substr($tglna,6,4);

$t9=substr($tmtna,0,2);
			$b9=substr($tmtna,3,2);
			$th9=substr($tmtna,6,4);			
			
mysql_query("update sk set no_sk='$nona',tgl_sk='$th8-$b8-$t8',tmt='$th9-$b9-$t9',pengesah_sk='$sahna',pemberi_sk='$berina',keterangan='$keke' where id_pegawai=$id and id_sk=$idna");

//echo("update sk set no_sk='$nona',tgl_sk='$th8-$b8-$t8',tmt='$th9-$b9-$t9',pengesah_sk='$sahna',pemberi_sk='$berina' where id_pegawai=$id and id_sk=$idna<br>");

}

for($v=1;$v<=$totalpen;$v++)
{
$tingpen=$_POST["tp"."$v"];
$lempen=$_POST["lem"."$v"];
$jurpen=$_POST["jur"."$v"];
$luspen=$_POST["lus"."$v"];
$idna=$_POST["pendi"."$v"];

$qlp=mysql_query("select level_p from pendidikan where tingkat_pendidikan='$tingpen'");
	$lepel=mysql_fetch_array($qlp);
	
	
	mysql_query("update pendidikan set lembaga_pendidikan='$lempen',tingkat_pendidikan='$tingpen',jurusan_pendidikan='$jurpen',tahun_lulus=$luspen,level_p=$lepel[0] where id_pendidikan=$idna");
	

	
}

$t2=substr($tlanak,0,2);
			$b2=substr($tlanak,3,2);
			$th2=substr($tlanak,6,4);
$t1=substr($pensiun,0,2);
			$b1=substr($pensiun,3,2);
			$th1=substr($pensiun,6,4);			
			
if($aktif=='Mengundurkan Diri' or $aktif=='Pensiun Dini' or $aktif=='Pensiun Meninggal Dunia' or $aktif=='Pensiun Reguler' or $aktif=='Pindah Ke Instansi Lain')
mysql_query("update pegawai set flag_pensiun=1,status_aktif='$aktif',tgl_pensiun_dini='$th1-$b1-$t1' where id_pegawai=$id2 ");

if($anak!=NULL and $ttl!=NULL)
mysql_query("insert into anak (nama_anak,tempat_lahir,tgl_lahir,id_pegawai) values ('$anak','$ttl','$th2-$b2-$t2',$id)");

if($lembaga!=NULL and $jurusan!=NULL and $lulusan!=NULL)
{
	
	$qlp=mysql_query("select level_p from pendidikan where tingkat_pendidikan='$tingkat'");
	$lepel=mysql_fetch_array($qlp);
	
mysql_query("insert into pendidikan (tingkat_pendidikan,lembaga_pendidikan,jurusan_pendidikan,id_pegawai,tahun_lulus,level_p) values ('$tingkat','$lembaga','$jurusan',$id,$lulusan,$lepel[0])");
}

// INSERT NEW DIKLAT

if($_POST['nama_diklat']!='-' )
{
	$tgl_diklat = explode('-', $_POST['tgl_diklat']);
	$tgl_diklat = $tgl_diklat[2].'-'.$tgl_diklat[1].'-'.$tgl_diklat[0];
	$qInsertDiklat = "INSERT INTO diklat(id_pegawai, jenis_diklat, tgl_diklat, jml_jam_diklat, nama_diklat, penyelenggara_diklat)
					  VALUES('$id', '$_POST[jenis_diklat]', '$tgl_diklat', '$_POST[jml_jam_diklat]', '$_POST[nama_diklat]', '$_POST[penyelenggara_diklat]')";
	mysql_query($qInsertDiklat);
}
// END OF INSERT NEW DIKLAT

echo("<div align=center> data sudah disimpan! </div> ");
}
?>
<form action="dock2.php" method="post" name="form1" class="hurup" id="form1">
<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab style2" tabindex="0">Biodata</li>
    <li class="TabbedPanelsTab style2" tabindex="0">Keluarga</li>
    <li class="TabbedPanelsTab style2" tabindex="0">Pendidikan</li>
    <li class="TabbedPanelsTab style2" tabindex="0">Berkas Pegawai</li>
	<li class="TabbedPanelsTab style2" tabindex="0">Diklat</li>
   <div align="right"><? // <a href="dock2.php?id=<? echo($id); &ha=1">[ hapus pegawai ]</a> || ?> <a href="tambah.php">[ Tambah pegawai ]</a>
     <input type="submit" name="button" id="button" value="Simpan" /> </div>
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent">
    <?

extract($_GET);
$q=mysql_query("select * from pegawai where id_pegawai=$id");
$ata=mysql_fetch_array($q);

?>
      
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
          <tr>
            <td width="21%" align="left" valign="top">Nama </td>
            <td width="3%" align="left" valign="top">:</td>
            <td width="28%"><label for="n"></label>
            <input name="n" type="text" id="n" value="<? echo($ata[1]); ?>" size="35" /></td>
            <td width="42" colspan="3" rowspan="4" align="left" valign="bottom"><?
            
			if(file_exists("../simpeg/foto/$id.jpg"))
					{
						echo "
							<div align=left>
								<img src='../simpeg/foto/$id.jpg' width='100px' />
							</div>";
					}
			?></td>
          </tr>
          <tr>
            <td align="left" valign="top">NIP Lama</td>
            <td align="left" valign="top">:</td>
            <td><input name="nl" type="text" id="nl" value="<? echo($ata['nip_lama']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Agama</td>
            <td align="left" valign="top">:</td>
            <td><select name="a" id="a">
              <?
			  $qjo=mysql_query("SELECT agama FROM `pegawai` where flag_pensiun=0 group by agama ");
                while($otoi=mysql_fetch_array($qjo))
				{
					if($ata['agama']==$otoi[0])
				echo("<option value=$otoi[0] selected>$otoi[0]</option>");
				else
				echo("<option value=$otoi[0]>$otoi[0]</option>");
				}
				
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Tempat Lahir</td>
            <td align="left" valign="top">:</td>
            <td><input name="tl" type="text" id="tl" value="<? echo($ata['tempat_lahir']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Tanggal Lahir</td>
            <td align="left" valign="top">:</td>
            <td><label for="tgl"></label>
            <input name="tgl" type="text" class="tcal"  id="tgl" value="<? 
			$tgl=substr($ata['tgl_lahir'],8,2);
			$bln=substr($ata['tgl_lahir'],5,2);
			$thn=substr($ata['tgl_lahir'],0,4);
			echo("$tgl-$bln-$thn");
			 ?>" /></td>
            <td width="11" rowspan="2" align="left" valign="top">Alamat</td>
            <td width="10" rowspan="2" align="left" valign="top">:</td>
            <td width="21" rowspan="2" align="left" valign="top"><textarea class="hurup" name="al" id="al" cols="45" rows="3"><? echo($ata['alamat']); ?></textarea></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap" class="selected">NIP Baru</td>
            <td align="left" valign="top">:</td>
            <td><input name="nb" type="text" id="nb" value="<? echo($ata['nip_baru']); ?>" size="22" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Jenis Kelamin</td>
            <td align="left" valign="top">:</td>
            <td><select name="jk" id="jk">
              <?
			  $qp=mysql_query("SELECT jenis_kelamin FROM `pegawai` where flag_pensiun=0 group by jenis_kelamin ");
                while($oto=mysql_fetch_array($qp))
				{
					if($ata['jenis_kelamin']==$oto[0])
				echo("<option value=$oto[0] selected>$oto[0]</option>");
				else
				echo("<option value=$oto[0]>$oto[0]</option>");
				}
				
				?>
            </select></td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
            <td align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Kartu Pegawai</td>
            <td align="left" valign="top">:</td>
            <td><input name="karpeg" type="text" id="karpeg" value="<? echo($ata['no_karpeg']); ?>" /></td>
            <td align="left" valign="top">Kota</td>
            <td width="10" align="left" valign="top">:</td>
            <td width="21" align="left" valign="top"><input name="kota" type="text" id="kota" value="<? echo($ata['kota']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">NPWP</td>
            <td align="left" valign="top">:</td>
            <td><input name="npwp" type="text" id="npwp" value="<? echo($ata['NPWP']); ?>" /></td>
            <td width="11" align="left" valign="bottom">Golongan Darah</td>
            <td width="10" align="left" valign="bottom">:</td>
            <td width="21" align="left" valign="bottom"><select name="darah" id="darah">
              <?
			  $qd=mysql_query("SELECT gol_darah FROM `pegawai` where flag_pensiun=0 group by gol_darah order by gol_darah ");
                while($da=mysql_fetch_array($qd))
				{
					if($ata['gol_darah']==$da[0])
				echo("<option value=$da[0] selected>$da[0]</option>");
				else
				echo("<option value=$da[0]>$da[0]</option>");
				}
				
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Gol / Ruang</td>
            <td align="left" valign="top">:</td>
            <td><select name="gol" id="gol">
              <?
			  $qp=mysql_query("SELECT golongan as pangkat_gol FROM simpeg.golongan ");
                while($oto=mysql_fetch_array($qp))
				{
					if($ata['pangkat_gol']==$oto[0])
				echo("<option value=$oto[0] selected>$oto[0]</option>");
				else
				echo("<option value=$oto[0]>$oto[0]</option>");
				}
				
				?>
            </select></td>
            <td align="left" valign="top">Status Aktif</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><select name="aktif" id="aktif">
              <?
			  $qot=mysql_query("SELECT status_aktif FROM `pegawai`  group by status_aktif ");
                while($ot=mysql_fetch_array($qot))
				{
					if($ata['status_aktif']==$ot[0])
				echo("<option value='$ot[0]' selected>$ot[0]</option>");
				else
				echo("<option value='$ot[0]' >$ot[0]</option>");
				}
				
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Unit Kerja</td>
            <td align="left" valign="top">:</td>
            <td><?
            $qu=mysql_query("select nama_baru from unit_kerja inner join current_lokasi_kerja on current_lokasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where id_pegawai=$ata[0]");
			$unit=mysql_fetch_array($qu);
			echo($unit[0]);
			?></td>
            <td align="left" valign="top">Tgl Pensiun Reguler</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><input name="pensiun" type="text" class="tcal"  id="pensiun" value="<? 
			$tgl88=substr($ata['tgl_pensiun_dini'],8,2);
			$bln88=substr($ata['tgl_pensiun_dini'],5,2);
			$thn88=substr($ata['tgl_pensiun_dini'],0,4);
			echo("$tgl88-$bln88-$thn88");
			 ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Jenjang Jabatan</td>
            <td align="left" valign="top">:</td>
            <td><label for="jenjab"></label>
              <select name="jenjab" id="jenjab">
              <?
			  $qjo=mysql_query("SELECT jenjab FROM `pegawai` where flag_pensiun=0 group by jenjab ");
                while($oto=mysql_fetch_array($qjo))
				{
					if($ata['jenjab']==$oto[0])
				echo("<option value='$oto[0]' selected>$oto[0]</option>");
				else
				echo("<option value='$oto[0]'>$oto[0]</option>");
				}
				
				?>
            </select></td>
            <td align="left" valign="top">Password
            <input name="id2" type="hidden" id="id2" value="<? echo($id);  ?>" />
            <input name="id" type="hidden" id="id" value="<? echo($id);  ?>" /></td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><? echo($ata['password']);  ?></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Telepon</td>
            <td align="left" valign="top">:</td>
            <td><input name="telp" type="text" id="telp" value="<? echo($ata['telepon']); ?>" /></td>
            <td align="left" valign="top">Jabatan</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><?
			if($ata['id_j']>0)
			{
			$qj=mysql_query("select * from jabatan where id_j=$ata[id_j]");
			$jab=mysql_fetch_array($qj);
			$ab=$jab[1];
			$es=$jab[4];
			}
			else
			{
            $ab=$ata['jenjab'];
			$es="-";
			}
			echo("$ab");
			?></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Ponsel</td>
            <td align="left" valign="top">:</td>
            <td><input name="hp" type="text" id="hp" value="<? echo($ata['ponsel']); ?>" /></td>
            <td align="left" valign="top">Eselonering</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><? echo("$es"); ?></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Email</td>
            <td align="left" valign="top">:</td>
            <td><input name="email" type="text" id="email" value="<? echo($ata['email']); ?>" /></td>
            <td align="left" valign="top">id pegawai</td>
            <td align="left" valign="top">:</td>
            <td align="left" valign="top"><input name="hp3" type="text" id="hp3" value="<? echo($ata['id_pegawai']); ?>" readonly="readonly" /></td>
          </tr>
        </table>
 
    </div>
    <div class="TabbedPanelsContent">
      <table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
        <tr>
          <td>Status Nikah</td>
          <td>:</td>
          <td><select name="kawin" id="kawin">
            <?
			  $qjo=mysql_query("SELECT status_kawin FROM `pegawai` where flag_pensiun=0 group by status_kawin ");
                while($otoi=mysql_fetch_array($qjo))
				{
					if($ata['status_kawin']==$otoi[0])
				echo("<option value=$otoi[0] selected>$otoi[0]</option>");
				else
				echo("<option value=$otoi[0]>$otoi[0]</option>");
				}
				
				?>
          </select></td>
          <td colspan="3" rowspan="4" align="center" valign="top"><?
          
		  $qa=mysql_query("select count(*) from pegawai where id_pegawai=$id");
		  $anak=mysql_fetch_array($qa);
		  if($anak[0]>0)
		  {
		  ?><table width="400" border="0" align="center" cellpadding="3" cellspacing="0" class="hurup">
            <tr>
              <td colspan="4" align="left">Data Anak</td>
              </tr>
            <tr>
              <td>No</td>
              <td>Nama</td>
              <td>Tempat Lahir</td>
              <td>Tanggal Lahir</td>
            </tr>
          
            <?
			$qpr=mysql_query("select * from anak where id_pegawai=$id order by tgl_lahir ");
			$i=1;
			while($acoy=mysql_fetch_array($qpr))
			{
				$t5=substr($acoy[4],8,2);
			$b5=substr($acoy[4],5,2);
			$th5=substr($acoy[4],0,4);
				echo("<tr>
				<td> $i</td>
              <td><input type=text name=anak$i id=anak$i value='$acoy[2]' size=25 /> </td>
			  <td><input type=text name=la$i id=la$i value='$acoy[3]' size=15 /> </td>
              <td><input type=text name=tg$i id=tg$i value=$t5-$b5-$th5 class=tcal  /> <input type=hidden name=king$i id=king$i value=$acoy[0]   /> </td>
           </tr>");
				$i++;
			}
			$totanak=$i-1;
			?>
            
              <tr>
              <td><input name="ja" type="hidden" id="ja" value="<? echo($totanak);  ?>" />
                +</td>
              <td><label for="anak"></label>
                <input type="text" name="anak" id="anak" size="25"/></td>
              <td><label for="ttl"></label>
                <input type="text" name="ttl" id="ttl"  size="15"/></td>
              <td><input name="tlanak" type="text" class="tcal"  id="tlanak"  size="20"/></td>
            </tr>
            </table></td>
          </tr>
        <tr>
          <td>Nama istri / Suami</td>
          <td>:</td>
          <td><label for="win"></label>
            <input name="win" type="text" id="win" value="<? echo($ata['nama_istri']); ?>" size="30" /></td>
          </tr>
        <tr>
          <td nowrap="nowrap">Tempat lahir istri/suami</td>
          <td>:</td>
          <td><input name="twin" type="text" id="twin" value="<? echo($ata['tempat_lahir_istri']); ?>" size="30" /></td>
          </tr>
        <tr>
          <td nowrap="nowrap">Tanggal Lahir istri/suami</td>
          <td>:</td>
          <td><input name="tglwin" type="text" class="tcal"  id="tglwin" value="<? 
			$tgl=substr($ata['tgl_lahir_istri'],8,2);
			$bln=substr($ata['tgl_lahir_istri'],5,2);
			$thn=substr($ata['tgl_lahir_istri'],0,4);
			echo("$tgl-$bln-$thn");
			 ?>" /></td>
          </tr>
         
      </table>
      <?
	  
		  }
		  ?>
    </div>
    <div class="TabbedPanelsContent">
      <table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
        <tr>
          <td>No</td>
          <td>Tingkat Pendidikan</td>
          <td>Lembaga Pendidikan</td>
          <td>Jurusan</td>
          <td>Tahun Lulus</td>
        </tr>
        
        <?
		$j=1;
		$qp=mysql_query("select * from pendidikan where id_pegawai=$id order by level_p");
		while($pen=mysql_fetch_array($qp))
		{
			echo("<tr>
          <td>$j</td>
          <td>"); ?>
          <select name="tp<? echo($j); ?>" id="tp<? echo($j); ?>">
            <?
			  $qjo2=mysql_query("SELECT tingkat_pendidikan FROM `pendidikan` where tingkat_pendidikan!=' '    group by tingkat_pendidikan");
                while($otoi2=mysql_fetch_array($qjo2))
				{
				if(trim($pen[3])==trim($otoi2[0]))
				echo("<option value=$otoi2[0] selected>$otoi2[0]</option>");
				else
				echo("<option value=$otoi2[0]>$otoi2[0]</option>");
				}
				
				?>
          </select>
          
		  <?
	
		 echo("</td>
          <td><input type=text name=lem$j id=lem$j value='$pen[2]' /></td>
          <td><input type=text name=jur$j id=jur$j value='$pen[4]' /></td>
          <td><input type=text name=lus$j id=lus$j value='$pen[5]' /><input type=hidden name=pendi$j id=pendi$j value='$pen[0]' /></td>
        </tr>");
		
			$j++;
		}
		$totpen=$j-1;
		?>
        <tr>
          <td>+</td>
          <td> <select name="tingkat" id="tingkat">
            <?
			  $qjo2=mysql_query("SELECT tingkat_pendidikan FROM `pendidikan` where tingkat_pendidikan!=' '   group by tingkat_pendidikan ");
                while($otoi2=mysql_fetch_array($qjo2))
				echo("<option value=$otoi2[0]>$otoi2[0]</option>");
							
				?>
          </select>
            <input name="totalpen" type="hidden" id="totalpen" value="<? echo($totpen); ?>" /></td>
          <td><label for="lembaga"></label>
            <input type="text" name="lembaga" id="lembaga" /></td>
          <td><input type="text" name="jurusan" id="jurusan" /></td>
          <td><input type="text" name="lulusan" id="lulusan" /></td>
        </tr>
      </table>
  </div>
        <div class="TabbedPanelsContent">
          <table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
            <tr>
              <td>No</td>
              <td>Jenis SK</td>
			  <td>Golongan,Masa Kerja</td>
              <td nowrap="nowrap">No SK</td>
              <td>Tanggal SK</td>
              <td>TMT SK</td>
              <td>Pegesah SK</td>
              <td>Pemberi SK</td>
              <td>Berkas Digital</td>
            </tr>
            <?
			$k=1;
			$qsk=mysql_query("select * from sk where id_pegawai=$id");
			while($cu=mysql_fetch_array($qsk))
			{
				$qt=mysql_query("select nama_sk from kategori_sk where id_kategori_sk=$cu[2]");
				$tipe=mysql_fetch_array($qt);
				echo("  <tr>
              <td>$k</td>
              <td>"); ?> 
			  <select name="a<? echo($k); ?>" id="a<? echo($k); ?>" style="width:160px;" >
              <?
			  
			  $qks=mysql_query("SELECT * FROM `kategori_sk`");
                while($da=mysql_fetch_array($qks))
				{
					if($cu[2]==$da[0])
				echo("<option value=$da[0] selected>$da[1]</option>");
				else
				echo("<option value=$da[0]>$da[1]</option>");
				}
				
				?>
            </select>
			  <? 
			  
			  $tsk1=substr($cu[4],8,2);
			  $bsk1=substr($cu[4],5,2);
			  $thsk1=substr($cu[4],0,4);
			  
			   $tsk2=substr($cu[8],8,2);
			  $bsk2=substr($cu[8],5,2);
			  $thsk2=substr($cu[8],0,4);
			  echo("</td>
			  <td><input type=text name=keket$k id=keket$k value='$cu[keterangan]' /></td>
              <td nowrap> <input type=text name=nosk$k id=nosk$k value='$cu[3]' size=30 class=hurup /> </td>
              <td><input type=text name=tgsk$k id=tgsk$k value=$tsk1-$bsk1-$thsk1 class=tcal size=8 /></td>
              <td><input type=text name=tmsk$k id=tmsk$k value=$tsk2-$bsk2-$thsk2 class=tcal size=8 /></td>
			    <td nowrap> <input type=text name=sah$k id=sah$k value='$cu[6]' size=27 class=hurup /> </td>
				  <td nowrap> <input type=text name=beri$k id=beri$k value='$cu[5]' size=27 class=hurup /> </td>
				    <input type=hidden name=idsk$k id=idsk$k value=$cu[0] />
              <td>");
			if($cu[10]==NULL or $cu[10]==0)
			  echo("Belum Ada </td>");
			  else
			  echo("<a href=berkas.php?idb=$cu[10] target=_blank>Preview </a></td>");
			  
            echo("</tr>");
				$k++;
				}
			
			?>
              <input type="hidden" name="jsk" value="<? $jambleh=$k-1; echo($jambleh); ?>" id="jsk" />
          </table>
        
        </div>
		
		<!-- Tab Content of DIKLAT -->
		<div class="TabbedPanelsContent">
		<fieldset>
		<legend>Diklat Struktural</legend>
		<table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
        <tr>
          <td>No</td>
          <td>Jenis Diklat</td>
		  <td>Nama Diklat</td>
          <td>Tanggal Diklat</td>
          <td>Jumlah Jam</td>
          <td>Penyelenggara</td>
        </tr>
        
        <?
		$j=1;
		$qp=mysql_query("select * from diklat where id_pegawai=$id order by nama_diklat");
		while($pen=mysql_fetch_array($qp))
		{
			
			$tgl_diklat = new DateTime($pen['tgl_diklat']);
			echo("<tr>
          <td>$j</td>
          <td>"); ?>
          <select name="jenis_diklat<? echo($j); ?>" id="jenis_diklat<? echo($j); ?>">
            <option value="Struktural">Struktural</option>
          </select>
          <input type="hidden" name="id_diklat<?php echo $j;?>" value="<?php echo $pen['id_diklat']; ?>" />
		  <?
		 echo("</td>
          <td><input type=text name=nama_diklat$j id=lem$j value='$pen[nama_diklat]' /></td>
          <td><input type=text name=tgl_diklat$j id=tgl_diklat$j value=".$tgl_diklat->format('d-m-Y')." class=tcal size=8 /></td>
          <td><input type=text name=jml_jam_diklat$j id=lus$j value='$pen[jml_jam_diklat]' /><input type=hidden name=idpen$j id=idpen$j value='$pen[0]' /></td>
		  <td><input type=text name=penyelenggara_diklat$j id=penyelenggara_diklat$j value='$pen[penyelenggara_diklat]' /></td>
	   </tr>");
		
			$j++;
		}
		$total_diklat=$j-1;
		?>
        <tr>
          <td>+</td>
          <td> 
		  <select name="jenis_diklat" id="jenis_diklat">
			<option value="Struktural">Struktural</option>
		  </select>
          <input name="total_diklat" type="hidden" id="total_diklat" value="<? echo($total_diklat); ?>" /></td>
          <td><label for="lembaga"></label>
			<select name="nama_diklat" id="nama_diklat">
				<option value="-">- PILIH -</option>
				<option value="Diklat Prajabatan Gol I">Diklat Prajabatan Gol I</option>
				<option value="Diklat Prajabatan Gol II">Diklat Prajabatan Gol II</option>
				<option value="Diklat Prajabatan Gol III">Diklat Prajabatan Gol III</option>
				<option value="Diklat Kepemimpinan Tk.II">Diklat Kepemimpinan Tk.II</option>
				<option value="Diklat Kepemimpinan Tk.III">Diklat Kepemimpinan Tk.III</option>
				<option value="Diklat Kepemimpinan Tk.IV">Diklat Kepemimpinan Tk.IV</option>
          </select>
		  </td>
          <td><input type=text name="tgl_diklat" id="tgl_diklat" value="<?php echo date('d-m-Y'); ?>" class=tcal size=8 /></td>
          <td><input type="text" name="jml_jam_diklat" id="jml_jam_diklat" value="" /></td>
		  <td><input type="text" name="penyelenggara_diklat" id="penyelenggara_diklat" /></td>
        </tr>
      </table>		
		</fieldset>
		</div>
		<!-- End fo Tab Content of DIKLAT -->
		
  </div>
</div>
     </form>
<script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");

$(document).ready(function()
{
	$("#nama_diklat").change(function(){		
		switch($(this).val()){
			case "Diklat Prajabatan Gol I": 
				$("#jml_jam_diklat").val('174');
				break;
			case "Diklat Prajabatan Gol II": 
				$("#jml_jam_diklat").val('174');
				break;
			case "Diklat Prajabatan Gol III": 
				$("#jml_jam_diklat").val('216');
				break;
			case "Diklat Kepemimpinan Tk.II": 
				$("#jml_jam_diklat").val('405');
				break;
			case "Diklat Kepemimpinan Tk.III": 
				$("#jml_jam_diklat").val('360');
				break;
			case "Diklat Kepemimpinan Tk.IV": 
				$("#jml_jam_diklat").val('285');
				break;
		}		
	});
});
</script>
