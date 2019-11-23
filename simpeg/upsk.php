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
include("konek.php");
extract($_POST);
extract($_GET);

$q1=mysqli_query($mysqli,"select id_unit_kerja,nama from current_lokasi_kerja inner join pegawai on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where current_lokasi_kerja.id_pegawai=$_SESSION[id_pegawai]");

$_SESSION['selected_id_pegawai'] = $_REQUEST['od'];

$p1=mysqli_fetch_array($q1);

$q2=mysqli_query($mysqli,"select id_skpd from current_lokasi_kerja inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where id_pegawai=$od");
$p2=mysqli_fetch_array($q2);
if($p1[0]==$p2[0])
{
if($id2!=NULL)
{
	$t0=substr($tglwin,0,2);
			$b0=substr($tglwin,3,2);
			$th0=substr($tglwin,6,4);
	$skr=date("Y-m-d H:i:s");
mysqli_query($mysqli,"update pegawai set nama='$n',nip_lama='$nl',nip_baru='$nb',pangkat_gol='$gol',email='$email',alamat='$al',agama='$a',tempat_lahir='$tl',no_karpeg='$karpeg',NPWP='$npwp',pangkat_gol='$gol',ponsel='$hp',telepon='$telp',jenjab='$jenjab',kota='$kota',gol_darah='$darah',timestamp='$skr',keterangan='updated by $p1[1]',status_kawin='$kawin',jenis_kelamin='$jk',nama_istri='$win',tempat_lahir_istri='$twin',tgl_lahir_istri='$th0-$b0-$t0' where id_pegawai=$id2");

//update anak
for($g=1;$g<=$ja;$g++)
{
$ngaran=$_POST["anak"."$g"];	
$dmn=$_POST["la"."$g"];	
$ta=$_POST["tg"."$g"];	
$budak=$_POST["king"."$g"];	

$t6=substr($ta,0,2);
			$b6=substr($ta,3,2);
			$th6=substr($ta,6,4);
mysqli_query($mysqli,"update anak set nama_anak='$ngaran',tempat_lahir='$dmn',tgl_lahir='$th6-$b6-$t6' where id_pegawai=$id and id_anak=$budak");

}


//update sk

for($z=1;$z<=$jsk;$z++)
{
$nona=$_POST["nosk"."$z"];	
$tmtna=$_POST["tmsk"."$z"];	
$tglna=$_POST["tgsk"."$z"];
$sahna=$_POST["sah"."$z"];	
$idna=$_POST["idsk"."$z"];	
$berina=$_POST["beri"."$z"];

	
$t8=substr($tglna,0,2);
			$b8=substr($tglna,3,2);
			$th8=substr($tglna,6,4);

$t9=substr($tmtna,0,2);
			$b9=substr($tmtna,3,2);
			$th9=substr($tmtna,6,4);			
			
mysqli_query($mysqli,"update sk set no_sk='$nona',tgl_sk='$th8-$b8-$t8',tmt='$th9-$b9-$t9',pengesah_sk='$sahna',pemberi_sk='$berina' where id_pegawai=$id and id_sk=$idna");

}

$t1=substr($pensiun,3,2);
			$b1=substr($pensiun,0,2);
			$th1=substr($pensiun,6,4);
		
for($v=1;$v<=$totalpen;$v++)
{

$tingpen=$_POST["tp"."$v"];
$lempen=$_POST["lem"."$v"];
$jurpen=$_POST["jur"."$v"];
$luspen=$_POST["lus"."$v"];
$idna=$_POST["idpen"."$v"];

$qlp=mysqli_query($mysqli,"select level_p from pendidikan where tingkat_pendidikan='$tingpen'");
	$lepel=mysqli_fetch_array($qlp);
	
	
	mysqli_query($mysqli,"update pendidikan set lembaga_pendidikan='$lempen',tingkat_pendidikan='$tingpen',jurusan_pendidikan='$jurpen',tahun_lulus=$luspen,level_p=$lepel[0] where id_pendidikan=$idna");
	
	
}			
			
if($aktif=='Mengundurkan Diri' or $aktif=='Pensiun Dini' or $aktif=='Pensiun Meninggal Dunia' or $aktif=='Pensiun Reguler' or $aktif=='Pindah Ke Instansi Lain')
mysqli_query($mysqli,"update pegawai set flag_pensiun=1,status_aktif='$aktif',tgl_pensiun_dini='$th1-$b1-$t1' where id_pegawai=$id2 ");


$t2=substr($tlanak,0,2);
			$b2=substr($tlanak,3,2);
			$th2=substr($tlanak,6,4);
//tambah anak			
if($anak!=NULL and $ttl!=NULL)
mysqli_query($mysqli,"insert into anak (nama_anak,tempat_lahir,tgl_lahir,id_pegawai) values ('$anak','$ttl','$th2-$b2-$t2',$id)");

//tambah sk
if($jnk!=NULL and $nsk!=NULL and $tmsk!=NULL and $tsk!=NULL)
{
if($pbsk==NULL)
$pbsk='-';

if($pgsk==NULL)
$pgsk='-';


$t10=substr($tsk,0,2);
			$b10=substr($tsk,3,2);
			$th10=substr($tsk,6,4);
			
$t11=substr($tmsk,0,2);
			$b11=substr($tmsk,3,2);
			$th11=substr($tmsk,6,4);
			
mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,tmt,pemberi_sk,pengesah_sk) values ($id,$jnk,'$nsk','$th10-$b10-$t10','$th11-$b11-$t11','$pbsk','$pgsk')");

//echo("insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,tmt,pemberi_sk,pengesah_sk) values ($id,$jnk,'$nsk','$th10-$b10-$t10','$th11-$b11-$t11','$pbsk','$pgsk')");
}


if($lembaga!=NULL and $jurusan!=NULL and $lulusan!=NULL)
{
	
	$qlp=mysqli_query($mysqli,"select level_p from pendidikan where tingkat_pendidikan='$tingkat'");
	$lepel=mysqli_fetch_array($qlp);
	
mysqli_query($mysqli,"insert into pendidikan (tingkat_pendidikan,lembaga_pendidikan,jurusan_pendidikan,id_pegawai,tahun_lulus,level_p) values ('$tingkat','$lembaga','$jurusan',$id2,$lulusan,$lepel[0])");
}
echo("<div align=center> data sudah disimpan! </div> ");
}
?>
<form action="index2.php" method="post" enctype="multipart/form-data" name="form1" class="hurup" id="form1">
<div id="TabbedPanels1" class="TabbedPanels">
  <ul class="TabbedPanelsTabGroup">
    <li class="TabbedPanelsTab style2" tabindex="0">Biodata</li>
    <li class="TabbedPanelsTab style2" tabindex="0">Pendidikan</li>
        <li class="TabbedPanelsTab style2" tabindex="0">Keluarga</li>
        <li class="TabbedPanelsTab style2" tabindex="0">Berkas Pegawai</li>
  
   <div align="right"><a href="index2.php?x=list.php">[kembali ke daftar pegawai]</a>
     <input type="submit" name="button" id="button" value="Simpan" />
    </div>
  </ul>
  <div class="TabbedPanelsContentGroup">
    <div class="TabbedPanelsContent">
    <?

extract($_GET);
$q=mysqli_query($mysqli,"select * from pegawai where id_pegawai=$od");
$kuta=mysqli_fetch_array($q);

?>
      
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
          <tr>
            <td align="left" valign="top"><?
            
			if(file_exists("../simpeg/foto/$od.jpg"))
					{
						echo "
							<div align=left>
								<img src='./foto/$od.jpg' width='100px' />
							</div>";
					}
			?></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="42" colspan="3" rowspan="22" align="left" valign="bottom">&nbsp;</td>
          </tr>
          <tr>
            <td width="21%" align="left" valign="top">Nama </td>
            <td width="3%" align="left" valign="top">:</td>
            <td width="28%"><label for="n"></label>
            <input name="n" type="text" id="n" value="<? echo($kuta[1]); ?>" size="35" /></td>
          </tr>
          <tr>
            <td align="left" valign="top">NIP Lama</td>
            <td align="left" valign="top">:</td>
            <td><input name="nl" type="text" id="nl" value="<? echo($kuta['nip_lama']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Agama</td>
            <td align="left" valign="top">:</td>
            <td><select name="a" id="a">
              <?
			  $qjo=mysqli_query($mysqli,"SELECT agama FROM `pegawai` where flag_pensiun=0 group by agama ");
                while($otoi=mysqli_fetch_array($qjo))
				{
					if($kuta['agama']==$otoi[0])
				echo("<option value=$otoi[0] selected>$otoi[0]</option>");
				else
				echo("<option value=$otoi[0]>$otoi[0]</option>");
				}
				
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Jenis Kelamin</td>
            <td align="left" valign="top">:</td>
            <td><select name="jk" id="jk">
              <?
			  $qp=mysqli_query($mysqli,"SELECT jenis_kelamin FROM `pegawai` where flag_pensiun=0 group by jenis_kelamin ");
                while($oto=mysqli_fetch_array($qp))
				{
					if($kuta['jenis_kelamin']==$oto[0])
				echo("<option value=$oto[0] selected>$oto[0]</option>");
				else
				echo("<option value=$oto[0]>$oto[0]</option>");
				}
				
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Tempat Lahir</td>
            <td align="left" valign="top">:</td>
            <td><input name="tl" type="text" id="tl" value="<? echo($kuta['tempat_lahir']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Tanggal Lahir</td>
            <td align="left" valign="top">:</td>
            <td><label for="tgl"></label>
            <input name="tgl" type="text" class="tcal"  id="tgl" value="<? 
			$tgl=substr($kuta['tgl_lahir'],8,2);
			$bln=substr($kuta['tgl_lahir'],5,2);
			$thn=substr($kuta['tgl_lahir'],0,4);
			echo("$tgl-$bln-$thn");
			 ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap" class="selected">NIP Baru</td>
            <td align="left" valign="top">:</td>
            <td><input name="nb" type="text" id="nb" value="<? echo($kuta['nip_baru']); ?>" size="22" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Kartu Pegawai</td>
            <td align="left" valign="top">:</td>
            <td><input name="karpeg" type="text" id="karpeg" value="<? echo($kuta['no_karpeg']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">NPWP</td>
            <td align="left" valign="top">:</td>
            <td><input name="npwp" type="text" id="npwp" value="<? echo($kuta['NPWP']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Gol / Ruang</td>
            <td align="left" valign="top">:</td>
            <td><select name="gol" id="gol">
              <?
			  $qp=mysqli_query($mysqli,"SELECT pangkat_gol FROM `pegawai` where flag_pensiun=0 group by pangkat_gol ");
                while($oto=mysqli_fetch_array($qp))
				{
					if($kuta['pangkat_gol']==$oto[0])
				echo("<option value=$oto[0] selected>$oto[0]</option>");
				else
				echo("<option value=$oto[0]>$oto[0]</option>");
				}
				
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Unit Kerja</td>
            <td align="left" valign="top">:</td>
            <td><?
            $qu=mysqli_query($mysqli,"select nama_baru from unit_kerja inner join current_lokasi_kerja on current_lokasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where id_pegawai=$kuta[0]");
			$unit=mysqli_fetch_array($qu);
			echo($unit[0]);
			?></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Jenjang Jabatan</td>
            <td align="left" valign="top">:</td>
            <td><label for="jenjab"></label>
              <select name="jenjab" id="jenjab">
              <?
			  $qjo=mysqli_query($mysqli,"SELECT jenjab FROM `pegawai` where flag_pensiun=0 group by jenjab ");
                while($oto=mysqli_fetch_array($qjo))
				{
					if($kuta['jenjab']==$oto[0])
				echo("<option value=$oto[0] selected>$oto[0]</option>");
				else
				echo("<option value=$oto[0]>$oto[0]</option>");
				}
				
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Telepon</td>
            <td align="left" valign="top">:</td>
            <td><input name="telp" type="text" id="telp" value="<? echo($kuta['telepon']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Ponsel</td>
            <td align="left" valign="top">:</td>
            <td><input name="hp" type="text" id="hp" value="<? echo($kuta['ponsel']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Email</td>
            <td align="left" valign="top">:</td>
            <td><input name="email" type="text" id="email" value="<? echo($kuta['email']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Alamat
            <input name="id2" type="hidden" id="id2" value="<? echo($od);  ?>" />
            <input name="id" type="hidden" id="id" value="<? echo($od);  ?>" />
            <input name="x" type="hidden" id="x" value="box.php" />
            <input name="od" type="hidden" id="od" value="<? echo("$od");  ?>" /></td>
            <td align="left" valign="top">:</td>
            <td><textarea class="hurup" name="al" id="al" cols="45" rows="3"><? echo($kuta['alamat']); ?></textarea></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Kota</td>
            <td align="left" valign="top">:</td>
            <td><input name="kota" type="text" id="kota" value="<? echo($kuta['kota']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Golongan Darah</td>
            <td align="left" valign="top">:</td>
            <td><select name="darah" id="darah">
              <?
			  $qd=mysqli_query($mysqli,"SELECT gol_darah FROM `pegawai` where flag_pensiun=0 group by gol_darah order by gol_darah ");
                while($da=mysqli_fetch_array($qd))
				{
					if($kuta['gol_darah']==$da[0])
				echo("<option value=$da[0] selected>$da[0]</option>");
				else
				echo("<option value=$da[0]>$da[0]</option>");
				}
				
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Jabatan</td>
            <td align="left" valign="top">:</td>
            <td><?
			if($kuta['id_j']>0)
			{
			$qj=mysqli_query($mysqli,"select * from jabatan where id_j=$kuta[id_j]");
			$jab=mysqli_fetch_array($qj);
			$ab=$jab[1];
			$es=$jab[4];
			}
			else
			{
            $ab=$kuta['jabatan'];
			$es="-";
			}
			echo("$ab");
			?></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Tgl Pensiun Reguler</td>
            <td align="left" valign="top">:</td>
            <td><input name="pensiun" type="text" class="tcal"  id="pensiun" value="<? 
			$tgl=substr($kuta['tgl_pensiun_dini'],8,2);
			$bln=substr($kuta['tgl_pensiun_dini'],5,2);
			$thn=substr($kuta['tgl_pensiun_dini'],0,4);
			echo("$tgl-$bln-$thn");
			 ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Eselonering</td>
            <td align="left" valign="top">:</td>
            <td><? echo("$es"); ?></td>
          </tr>
        </table>
 
    </div>
  <div class="TabbedPanelsContent">
      <table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
        <tr>
          <td>No</td>
          <td>Tingkat Pendidikan</td>
          <td>Lembaga Pendidikan</td>
          <td>Jurusan</td>
          <td>Tahun Lulus</td>
      
        <?
		$j=1;
		$qp=mysqli_query($mysqli,"select * from pendidikan where id_pegawai=$od order by level_p");
		while($pen=mysqli_fetch_array($qp))
		{
			echo("<tr>
          <td>$j</td>
          <td>"); ?>
          <select name="tp<? echo($j); ?>" id="tp<? echo($j); ?>">
            <?
			  $qjo2=mysqli_query($mysqli,"SELECT tingkat_pendidikan FROM `pendidikan` where tingkat_pendidikan!=' '   group by tingkat_pendidikan ");
                while($otoi2=mysqli_fetch_array($qjo2))
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
          <td><input type=text name=lus$j id=lus$j value='$pen[5]' /> <input type=hidden name=idpen$j id=idpen$j value=$pen[0] /></td>
        </tr>");
		
			$j++;
		}
		$totpen=$j-1;
		
		?>
          </tr>
        <tr>
          <td>+</td>
          <td><select name="tingkat" id="tingkat">
            <?
			  $qjo2=mysqli_query($mysqli,"SELECT tingkat_pendidikan FROM `pendidikan` where tingkat_pendidikan!=' '   group by tingkat_pendidikan ");
                while($otoi2=mysqli_fetch_array($qjo2))
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
              <td>Status Nikah</td>
              <td>:</td>
              <td><select name="kawin" id="kawin">
                <?
			  $qjo=mysqli_query($mysqli,"SELECT status_kawin FROM `pegawai` where flag_pensiun=0 group by status_kawin ");
                while($otoi=mysqli_fetch_array($qjo))
				{
					if($kuta['status_kawin']==$otoi[0])
				echo("<option value=$otoi[0] selected>$otoi[0]</option>");
				else
				echo("<option value=$otoi[0]>$otoi[0]</option>");
				}
				
				?>
              </select></td>
              <td colspan="3" rowspan="4" align="center" valign="top">&nbsp;</td>
            </tr>
            <tr>
              <td>Nama istri / Suami</td>
              <td>:</td>
              <td><label for="win"></label>
                <input name="win" type="text" id="win" value="<? echo($kuta['nama_istri']); ?>" size="30" /></td>
            </tr>
            <tr>
              <td nowrap="nowrap">Tempat lahir istri/suami</td>
              <td>:</td>
              <td><input name="twin" type="text" id="twin" value="<? echo($kuta['tempat_lahir_istri']); ?>" size="30" /></td>
            </tr>
            <tr>
              <td nowrap="nowrap">Tanggal Lahir istri/suami</td>
              <td>:</td>
              <td><input name="tglwin" type="text" class="tcal"  id="tglwin" value="<? 
			$tgl=substr($kuta['tgl_lahir_istri'],8,2);
			$bln=substr($kuta['tgl_lahir_istri'],5,2);
			$thn=substr($kuta['tgl_lahir_istri'],0,4);
			echo("$tgl-$bln-$thn");
			 ?>" /></td>
            </tr>
            <tr>
              <td colspan="3" nowrap="nowrap"><?
          
		  $qa=mysqli_query($mysqli,"select count(*) from pegawai where id_pegawai=$od");
		  $anak=mysqli_fetch_array($qa);
		  if($anak[0]>0)
		  {
		  ?>
                <table width="400" border="0" align="left" cellpadding="3" cellspacing="0" class="hurup">
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
			$qpr=mysqli_query($mysqli,"select * from anak where id_pegawai=$od order by tgl_lahir ");
			$i=1;
			while($acoy=mysqli_fetch_array($qpr))
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
              <td colspan="3" align="center" valign="top">&nbsp;</td>
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
              <td>Jenis SK</td>
              <td nowrap="nowrap">No SK</td>
              <td>Tanggal SK</td>
              <td>TMT SK</td>
              <td>Pengesah SK</td>
              <td>Pemberi SK</td>
              <td>Berkas Digital</td>
            </tr>
           
            <?
			$k=1;
			$qsk=mysqli_query($mysqli,"select * from sk where id_pegawai=$od");
			while($cu=mysqli_fetch_array($qsk))
			{
				$qt=mysqli_query($mysqli,"select nama_sk from kategori_sk where id_kategori_sk=$cu[2]");
				$tipe=mysqli_fetch_array($qt);
				echo("  <tr>
              <td>$k</td>
              <td>"); ?> 
			  <select name="a<? echo($k); ?>" id="a<? echo($k); ?>" style="width:160px;" >
              <?
			  $nama_berkas = "";
			  
			  $qks=mysqli_query($mysqli,"SELECT * FROM `kategori_sk`");
                while($da=mysqli_fetch_array($qks))
				{
					if($cu[2]==$da[0])
					{
						echo("<option value=$da[0] selected>$da[1]</option>");
						$nama_berkas = $da[1];
					}
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
              <td nowrap> <input type=text name=nosk$k id=nosk$k value='$cu[3]' style=width:180px; class=hurup /> </td>
              <td><input type=text name=tgsk$k id=tgsk$k value=$tsk1-$bsk1-$thsk1 class=tcal style=width:90px; /></td>
              <td><input type=text name=tmsk$k id=tmsk$k value=$tsk2-$bsk2-$thsk2 class=tcal style=width:90px; /></td>
			    <td nowrap> <input type=text name=sah$k id=sah$k value='$cu[6]' style=width:100px;class=hurup /> </td>
				  <td nowrap> <input type=text name=beri$k id=beri$k value='$cu[5]' style=width:100px; class=hurup />
				  
				  <input type=hidden name=idsk$k id=idsk$k value=$cu[0] />
				   </td>
              <td>");
			if($cu[10]==NULL or $cu[10]==0)
			{
			  echo("<a href='index2.php?x=uploader_berkas.php&id_sk=$cu[id_sk]&nama_berkas=$nama_berkas&tgl_berkas=$tsk1-$bsk1-$thsk1&od=$_REQUEST[od]' target=''>UPLOAD</a> </td>");
			}
			else
			  //echo("<a href=file.php?idb=$cu[10] target=_blank>Lihat</a></td>");
			  echo("<a href='index2.php?x=uploader_berkas.php&id_b=$cu[10]&nama_berkas=$nama_berkas&tgl_berkas=$tsk1-$bsk1-$thsk1&od=$_REQUEST[od]' target=''>View</a> </td>");
			  
            echo("</tr>");
				$k++;
				}
			
			?>
            <input type="hidden" name="jsk" value="<? $jambleh=$k-1; echo($jambleh); ?>" id="jsk" />
             <tr>
              <td>+</td>
              <td><label for="select"></label>
                <select name="jnk" id="jnk" style="width:160px;">
                <?
				
				 $qks2=mysqli_query($mysqli,"SELECT * FROM `kategori_sk`");
                while($da=mysqli_fetch_array($qks2))
				echo("<option value=$da[0]>$da[1]</option>");
				?>
               </select></td>
              <td nowrap="nowrap"><label for="textfield"></label>
               <input type="text" name="nsk" id="nsk" style="width:160px;" /></td>
              <td><label for="select"></label>
                <input type="text" name="tsk" id="tsk" class="tcal" style="width:100px;" /></td>
              <td><input type="text" name="tmsk" id="tmsk" class="tcal" style="width:100px;" /></td>
              <td>
              <input type="text" name="pgsk" id="pgsk"  style="width:100px;" />
              </td>
              <td><input type="text" name="pbsk" id="pbsk"  style="width:100px;" /></td>
              <td>
              </td>
            </tr>
          </table>
        
        </div>
        
  </div>
</div>
     </form>
<script type="text/javascript">
var TabbedPanels1 = new Spry.Widget.TabbedPanels("TabbedPanels1");
</script>

<?
}
else
echo("<div align=center> Restricted Access </div>");

?>

	