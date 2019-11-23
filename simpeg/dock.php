	<link rel="stylesheet" type="text/css" href="tcal.css" />
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
if($id2!=NULL)
{
mysql_query("update pegawai set nama='$n',nip_lama='$nl' where id_pegawai=$id2");
echo("<div align=center> data sudah disimpan! </div> ");
}
?>
<form action="dock.php" method="post" name="form1" class="hurup" id="form1">
<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab style2" tabindex="0">Biodata</li>
    <li class="TabbedPanelsTab style2" tabindex="0">Keluarga</li>
    <li class="TabbedPanelsTab style2" tabindex="0">Pendidikan</li>
        <li class="TabbedPanelsTab style2" tabindex="0">Berkas Pegawai</li>
   <div align="right">0 
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
            <td width="21%" align="left" valign="top">Nama</td>
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
			  $qp=mysql_query("SELECT pangkat_gol FROM `pegawai` where flag_pensiun=0 group by pangkat_gol ");
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
			  $qot=mysql_query("SELECT status_aktif FROM `pegawai` where flag_pensiun=0 group by status_aktif ");
                while($ot=mysql_fetch_array($qot))
				{
					if($ata['status_aktif']==$ot[0])
				echo("<option value=$ot[0] selected>$ot[0]</option>");
				else
				echo("<option value=$ot[0]>$ot[0]</option>");
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
			$tgl=substr($ata['tgl_pensiun_dini'],8,2);
			$bln=substr($ata['tgl_pensiun_dini'],5,2);
			$thn=substr($ata['tgl_pensiun_dini'],0,4);
			echo("$tgl-$bln-$thn");
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
				echo("<option value=$oto[0] selected>$oto[0]</option>");
				else
				echo("<option value=$oto[0]>$oto[0]</option>");
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
            $ab=$ata['jabatan'];
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
        </table>
 
    </div>
	
	<!-- tab keluarga -->
	
	<?php 
		
		$istri = mysql_fetch_object(mysql_query('select 8 from keluarga where id_status = 9 and id_pegawai = '.$ata['id_pegawai']));
		
	
	
	?>
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
				$t1=substr($acoy[4],8,2);
			$b1=substr($acoy[4],5,2);
			$th1=substr($acoy[4],0,4);
				echo("<tr>
				<td> $i</td>
              <td><input type=text nama=a$i id=a$i value='$acoy[2]' size=35 /> </td>
			  <td><input type=text nama=la$i id=la$i value='$acoy[3]' /> </td>
              <td><input type=text nama=tg$i id=tg$i value=$t1-$b1-$th1 class=tcal  /> </td>
           </tr>");
				$i++;
			}
			?>
            </table></td>
          </tr>
        <tr>
          <td>Nama istri / Suami</td>
          <td>:</td>
          <td><label for="win"></label>
            <input name="win" type="text" id="win" value="<? echo($ata['nama_istri']); ?>" size="35" /></td>
          </tr>
        <tr>
          <td nowrap="nowrap">Tempat lahir istri/suami</td>
          <td>:</td>
          <td><input name="twin" type="text" id="twin" value="<? echo 'hehe'; ?>" size="35" /></td>
          </tr>
        <tr>
          <td nowrap="nowrap">Tanggal Lahir istri/suami</td>
          <td>:</td>
          <td><input name="tglwin" type="text" class="tcal"  id="tglwin" value="<? 
			$tgl=substr($ata['tgl_lahir'],8,2);
			$bln=substr($ata['tgl_lahir'],5,2);
			$thn=substr($ata['tgl_lahir'],0,4);
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
			  $qjo2=mysql_query("SELECT tingkat_pendidikan FROM `pendidikan`   group by tingkat_pendidikan ");
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
          <td><input type=text nama=lem$i id=lem$i value='$pen[2]' /></td>
          <td><input type=text nama=jur$i id=jur$i value='$pen[4]' /></td>
          <td><input type=text nama=lus$i id=lus$i value='$pen[5]' /></td>
        </tr>");
		
			$j++;
		}
		
		?>
      </table>
    </div>
        <div class="TabbedPanelsContent">
          <table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
            <tr>
              <td>No</td>
              <td>Jenis SK</td>
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
              <td nowrap> <input type=text nama=nosk$k id=nosk$k value=$cu[3] size=20 class=hurup /> </td>
              <td><input type=text nama=tgsk$k id=tgsk$k value=$tsk1-$bsk1-$thsk1 class=tcal size=8 /></td>
              <td><input type=text nama=tmsk$k id=tmsk$k value=$tsk2-$bsk2-$thsk2 class=tcal size=8 /></td>
			    <td nowrap> <input type=text nama=sah$k id=sah$k value='$cu[6]' size=27 class=hurup /> </td>
				  <td nowrap> <input type=text nama=beri$k id=beri$k value='$cu[5]' size=27 class=hurup /> </td>
              <td>");
			  $qcek=mysql_query("select count(*) from berkas where id_pegawai=$cu[1] and id_kat=$cu[2] and tgl_berkas='$cu[4]'");
			  $cok=mysql_fetch_array($qcek);
			  if($cok[0]==1)
			  echo("<a href=berkas.php target=_blank>Preview </a></td>");
			  else
			  echo("select count(*) from berkas where id_pegawai=$cu[1] and id_kat=$cu[2] and tgl_berkas='$cu[4]'</td>");
			  
            echo("</tr>");
				$k++;
				}
			
			?>
          </table>
        
        </div>
  </div>
</div>
     </form>
<script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>
