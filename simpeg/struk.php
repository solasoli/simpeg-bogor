<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

</script>
<style type="text/css">

<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #000066;
}
.gede {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	color: #000000;
	font-weight: normal;
}
.kedip {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	text-decoration: blink;
}
.pendek {
	width: 200px;
}
.latar {
	background-image: url(http://simpeg.org/images/middle.gif);
	background-repeat: repeat-y;
}
.sebling {
	color: #FF0000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	width: 200px;
}
a:link {
	color: #666666;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #666666;
}
a:hover {
	text-decoration: none;
	color: #FF0000;
}
a:active {
	text-decoration: none;
	color: #666666;
}
a {
	font-weight: bold;
}


#pret {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 8px;
	opacity: 0.99;
	width: 500px;
}
.please {
	font-family: Tahoma, Verdana;
	font-size: 12px;
	color: #000000;
	opacity:0.99;
}

.carol {
	background-color:#F0f0f0;
}

.carol:hover{
	background-color:#FFFFCC;
}

.carol a{
	font-weight:100;
	color:#0000FF;
}

.carol a:hover {
font-weight:500;
color:#333333;
background-color:#FF0000;
}


-->
</style>

</head>

<body 
<?
$idj=$_REQUEST['idj'];


?>
>
<?
extract($_POST);
extract($_POST);
include("coro.php");


include("konek.php");
if($idj!=NULL and $idp!=NULL)
{
mysqli_query($mysqli,"update pegawai set id_next=0 where id_next=$idj");
mysqli_query($mysqli,"update pegawai set id_next=$idj where id_pegawai=$idp");
}

$qnama=mysqli_query($mysqli,"select nama_baru from unit_kerja where id_unit_kerja=$u");
/// kepaladinas, kepala badan,sekretaris kpu,sekretaris dprd,inspektur kota,sekda,asisten,camat,lurah

$q=mysqli_query($mysqli,"select jabatan,id_j,eselon,level from jabatan where id_unit_kerja=$u and ( jabatan like '%sekretaris daerah%' or jabatan like '%Asisten%' or jabatan like '%sekretaris kpu%' or
jabatan like '%kepala dinas%' or jabatan like '%kepala badan%' or jabatan like '%kepala kantor%' or jabatan like 'sekretaris dprd%' or jabatan like 'inspektur kota%' or jabatan like 'camat%' or jabatan like 'lurah%' or jabatan like 'kepala satuan%' or jabatan like 'sekretaris korpri%' or jabatan like 'walikota%' )order by level");

$dat=mysqli_fetch_array($q);

$q5=mysqli_query($mysqli,"select count(*) from pegawai where id_j=$dat[1] and flag_pensiun=0 ");
$at5=mysqli_fetch_array($q5);

?>
<form id="form1" name="form1" method="post" action="">
  <table width="990" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5"><div align="center"><table width="250" cellpadding="0" cellspacing="0" border="0" ><tr  ><td>&nbsp; </td><td width="250"  ><img src="http://simpeg.org/images/top.gif" /></td><td>&nbsp; </td></tr><tr><td align="right" valign="bottom"><img src="http://simpeg.org/images/luhurs.gif" /> </td><td width="300" align="center" valign="middle" background="http://simpeg.org/images/middle.gif"><table width="95%"><td></td><tr><td align="center"><? echo("$dat[0]   ");

	   ?></td></tr></table><hr /> 
      
		<?
		
			if($at5[0]==0)
		echo("<div align=center> Jabatan Ini Masih Kosong  </div>");	
		else
		{
		$q2=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where id_j =$dat[1] and flag_pensiun=0 ");
		$at=mysqli_fetch_array($q2);
		echo("<div align=center class=gede> $at[1]  </div>");	
		}
		
	$q3=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where id_next =$dat[1] and flag_pensiun=0 ");
		$ax=mysqli_fetch_array($q3);
	echo("<div align=center class=kedip> $ax[1]  </div>");	
		?>
      
     
		
            </div> </td></tr> 
			
			
		
			<tr  ><td valign="top" align="<? if($td==NULL)
			echo("right");
			else
			echo("right");
			 ?>"><img src="http://simpeg.org/images/maneh.gif" /> </td><td width="250" valign="top" align=center><img src="http://simpeg.org/images/bottom.gif" />
				<? if($td==NULL  and $u!=354 and $u!=609 and $u!=36 and $u!=2 and $u!=3 and $u!=4  )
			{
			?>
			<img src="http://simpeg.org/images/tengah.gif" /> 
			<? 
			}
			?>
			</td><td><img src="http://simpeg.org/images/knaan.gif" /></td></tr>
				<? if($td==NULL)
			{
			?>
			<tr  ><td valign="top"></td><td width="250" valign="bottom" align="center" > </td><td></td></tr>
			
			</td>
    </tr>
	
    </table>
     <?


$lev=$dat[3]+1;	 
$lev2=$dat[3]+2;	
$lev3=$dat[3]+3;
$lev4=$dat[3]+4;	

//sekretaris badan,sekretaris dinas,sekretaris camat, seklur, kasubag TU 
//or and ?
	 $qsek=mysqli_query($mysqli,"select count(*) from jabatan where id_unit_kerja=$u and (jabatan like 'sekretaris%' or jabatan like 'Kasubag Tata Usaha%' ) and (level=$lev or level=$lev2) and jabatan not like '%Staf Ahli%'");
	 

	 
	 $sek=mysqli_fetch_array($qsek);

	 	 
	 if($sek[0]>0)
	 {
	 
	 $qn=mysqli_query($mysqli,"select count(*) from jabatan where id_unit_kerja=$u and jabatan not like 'sekretaris%' and jabatan not like 'Kasubag Tata Usaha%' and (level=$lev or level=$lev2) and jabatan like '%Staf Ahli%'");
	 $kolom=mysqli_fetch_array($qn);
	 
	 $qsek2=mysqli_query($mysqli,"select jabatan,eselon,id_j from jabatan where id_unit_kerja=$u and  (jabatan like 'sekretaris%' or jabatan like 'Kasubag Tata Usaha%' ) and (level=$lev or level=$lev2) and jabatan not like '%Staf Ahli%' ");
	
	 $sek2=mysqli_fetch_array($qsek2);
	 
	 echo("<tr><td colspan=$kolom[0] align=center   >
	 
	 <table width=250 cellpadding=0 cellspacing=0 border=0 ><tr  ><td  align=left valign=top>
	 
	 
	 <img src=http://simpeg.org/images/gigirki2.gif /></td><td width=250  ><img src=http://simpeg.org/images/top.gif /></td><td width=250 > <img src=http://simpeg.org/images/knaan.gif /></td></tr><tr><td valign=top><img src=http://simpeg.org/images/tengah2.gif /> </td><td width=300 align=center valign=middle background=http://simpeg.org/images/middle.gif><table width=95%><tr><td align=center> $sek2[0]  </td></tr></table><hr />");
$q4=mysqli_query($mysqli,"select count(*) from pegawai where id_j =$sek2[2] and flag_pensiun=0");



$a4=mysqli_fetch_array($q4);

	if($a4[0]==0)
		echo("<div align=center> Jabatan Ini Masih Kosong </div>");
		else
		{
		
$q3=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where id_j =$sek2[2] and flag_pensiun=0");
$a2=mysqli_fetch_array($q3);
		echo("<div align=center class =gede> $a2[1] </div>");
		}
$q3=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where id_next =$sek2[2] and flag_pensiun=0 ");
		$ax=mysqli_fetch_array($q3);
	echo("<div align=center class=kedip> $ax[1]  </div>");	

	
$qasoy=mysqli_query($mysqli,"select count(*) from jabatan where id_bos=$sek2[2]");
$asy=mysqli_fetch_array($qasoy);

if($asy[0]>0)
{$boy=" <img src=http://simpeg.org/images/menkols.gif />";
$boi=" <img src=http://simpeg.org/images/mengkol2.gif />";
}
else
{$boy=" &nbsp;";
$boi=" &nbsp;";
}


echo("</select></td><td valign=bottom>  </td><td> </td></tr><tr  ><td valign=top><img src=http://simpeg.org//images/gigirki2.gif /></td><td width=250 valign=top ><img src=http://simpeg.org/images/bottom.gif /> </td><td valign=bottom></td><td>&nbsp;&nbsp;&nbsp;</td> </tr><tr><td valign=top align=right><img src=http://simpeg.org/images/gigirki2.gif /><img src=http://simpeg.org/images/gigirki2.gif /> </td><td align=right valign=top>  $boy </td><td align=left valign=bottom> $boi  </td>  </tr></table></td>     </tr><tr><td  colspan=$kolom[0] align=center valign=top><table cellpadding=0  cellspacing=0 border=0>");


$qas=mysqli_query($mysqli,"select jabatan,eselon,id_j from jabatan where id_bos=$sek2[2]");
$e=1;
while($as=mysqli_fetch_array($qas))
{

echo("<tr><td align=left  valign=top    ><img src=http://simpeg.org/images/gigirki3.gif /></td><td align=left valign=top><table width=50 cellpadding=0 cellspacing=0 border=0 ><tr  ><td width=250  ><img src=http://simpeg.org/images/top.gif /></td><td valign=top> <img src=http://simpeg.org/images/pinggir.gif /></td><td valign=top> <img src=http://simpeg.org/images/knaan2.gif /></td></tr><tr><td width=300 align=center valign=middle background=http://simpeg.org/images/middle.gif><table width=95%><tr><td align=center> $as[0]    </td></tr></table><hr />");

// kasubag pada sekretariat


$qasu2=mysqli_query($mysqli,"select count(*) from pegawai where id_j =$as[2]");
$asu2=mysqli_fetch_array($qasu2);

if($asu2[0]==0)
echo("<div align=center>Jabatan Ini Masih Kosong</div>");
else
{
$qasu=mysqli_query($mysqli,"select nama,id_pegawai from pegawai where id_j =$as[2]");
$asu=mysqli_fetch_array($qasu);
echo("<div align=center class=gede>$asu[0]  </div>");

$q3=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where id_next =$as[2] and flag_pensiun=0 ");
		$ax=mysqli_fetch_array($q3);
	echo("<div align=center class=kedip> $ax[1]  </div>");	

}



if($e==$asy[0])
{
$tiga="tri2";
$dua="&nbsp;";
}
else
{
$tiga="tri";
$dua="<image src=./images/pinggir.gif />";
}
echo("<td valign=top> <img src=http://simpeg.org/images/$tiga.gif /> </td></td></tr><tr  ><td width=250 valign=top ><img src=http://simpeg.org/images/bottom.gif /> </td><td valign=top>  $dua  </td></tr></table>");
$e++;
}


echo("</table></td></tr><tr><td valign=top align=left></td></tr>");
	 
	 
	 
	 
	 }

	 echo("<tr>");
	 
	 $qsas=mysqli_query($mysqli,"select count(*) from jabatan where id_unit_kerja=$u and jabatan not like 'sekretaris%' and jabatan not like 'Kasubag Tata Usaha%' and (level=$lev or level=$lev2) ");
	 $sas=mysqli_fetch_array($qsas);
$qsisa=mysqli_query($mysqli,"select jabatan,eselon,level,id_j from jabatan where id_unit_kerja=$u and jabatan not like 'sekretaris%' and jabatan not like 'Kasubag Tata Usaha%' and (level=$lev or level=$lev2)");
$j=1;



while($sisa=mysqli_fetch_array($qsisa))
{

if($j==1)
{
$meng="align=right > <img src=http://simpeg.org/images/luhur1.gif /> ";
$sam="<img src=http://simpeg.org/images/sambungan.png /> ";
}
else if($j==$sas[0])
{
$meng="align=left > <img src=http://simpeg.org/images/luhur2.gif /> ";
$sam="&nbsp;";
}
else
{

if(($u>508 and $u<579) or ($u>30 and $u<35)  )
$meng="align=left > <img src=http://simpeg.org/images/t2.png />";
else

$meng="align=left > <img src=images/t.png />";

$sam="<img src=images/sambungan.png />";
}



//kabag
$q3=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where id_j =$sisa[3] and flag_pensiun=0");
$a2=mysqli_fetch_array($q3);

$qa=mysqli_query($mysqli,"select count(*) from pegawai where id_j =$sisa[3] and flag_pensiun=0");
$aa=mysqli_fetch_array($qa);


echo("<td align=center valign=top><table width=250 cellpadding=0 cellspacing=0 border=0 >
<tr><td valign=top  $meng </td>  <td align=right>  $sam </td>    </tr>
<tr  ><td width=250  align=left><img src=http://simpeg.org/images/top.gif /></td><td>&nbsp;</td></tr><tr><td width=250 align=center valign=middle class=latar ><table width=95%><tr><td align=center> $sisa[0]   </td></tr></table> <hr />  ");



$q3=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where id_j =$sisa[3] and flag_pensiun=0");
$a2=mysqli_fetch_array($q3);


if($aa[0]==0)
	echo("<div align=center >Jabatan Ini Masih Kosong</div>");
	else
	echo("<div align=center class=gede> $a2[1]</div>");

$q5=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where id_next =$sisa[3] and flag_pensiun=0 ");
		$ax=mysqli_fetch_array($q5);
	echo("<div align=center class=kedip> $ax[1]  </div>");	


$qkau=mysqli_query($mysqli,"select count(*) from jabatan where id_bos=$sisa[3]");
$kau=mysqli_fetch_array($qkau);
if($kau[0]>0)
{
$coi="<img src=http://simpeg.org/images/menkols.gif /> ";
$oi="<img src=http://simpeg.org/images/mengkol3.gif />";
}
else
{
$coi="&nbsp; ";
$oi="&nbsp; ";

}
echo("<td align=left valign=top> </td></tr><tr  ><td width=250 valign=top align=left><img src=http://simpeg.org/images/bottom.gif /> </td><td>  </td></tr><tr><td align=right valign=top> $coi  </td> <td valign=top align=left>$oi  </td>  </tr></table>");
echo("<table width=100% border=0 cellpadding=0 cellspacing=0>");

$qka=mysqli_query($mysqli,"select jabatan,eselon,id_j from jabatan where id_bos=$sisa[3]");
$h=1;
if($sas[0]==3)
$pas="'padding-left: 0px;' ";
else
$pas="'padding-left: 0px;' ";

while($kas=mysqli_fetch_array($qka))
{

echo("<tr><td align=left valign=top><table width=250 cellpadding=0 cellspacing=0 border=0 ><tr  ><td width=250  ><img src=http://simpeg.org/images/top.gif /></td><td valign=bottom align=center> <img src=http://simpeg.org/images/pinggir.gif hspace=0 /></td></tr><tr><td width=250 align=center valign=middle background=http://simpeg.org/images/middle.gif><table width=95%><tr><td align=center> $kas[0]</td></tr> </table><hr/> ");
//echo("select nama,id_pegawai from pegawai where jabatan like '$kas[0]'");


// kasubag

$qpos=mysqli_query($mysqli,"select nama,id_pegawai from pegawai where id_j =$kas[2] and flag_pensiun=0");
$pos=mysqli_fetch_array($qpos);

$qpos2=mysqli_query($mysqli,"select count(*) from pegawai where id_j=$kas[2] and flag_pensiun=0");
$pos2=mysqli_fetch_array($qpos2);

if($pos2[0]==0)
echo("<div align=center >  Jabatan Ini Masih Kosong</div>");
else
echo ("<div align=center class=gede> $pos[0] </div>");

$q3=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where id_next =$kas[2] and flag_pensiun=0 ");
		$ax=mysqli_fetch_array($q3);
	echo("<div align=center class=kedip> $ax[1]  </div>");	



echo(" </td><td valign=top>");
if($h==$kau[0])
 echo("<img src=http://simpeg.org/images/tri2.gif />");
 else
 echo("<img src=http://simpeg.org/images/tri.gif />");
 
 echo("</td></tr><tr  ><td width=250 valign=top ><img src=http://simpeg.org/images/bottom.gif /> </td><td valign=top>");
 if($h==$kau[0])
  echo(" ");
  else
  echo("<img src=http://simpeg.org/images/pinggir.gif />");
  
  
  echo("</td></tr></table></td><td valign=top> </td></tr>");
  
  if($h==$kau[0])
  echo("  <tr> <td> &nbsp; </td> </tr>");
  
$h++;
}
echo("</table>");

echo("</td>");

//echo("select id_pegawai,nama from pegawai inner join jabatan on jabatan.jabatan=pegawai.jabatan where eselon = '$sisa[1]'");
$j++;
}
	 echo("    </tr>");
	 
	 
	 	}
// 
	 ?>

    
   
    </tr>
	
	<tr>
	
	
	
	 <td  align="center" valign="top" <? echo("colspan=$kolom[0]"); ?> > 
	 
	 
	 <div align="center"><?
	
	if(($u==1 or $u==19 or  $u==23 or  $u==25 or  $u==27 or  $u==28) and $td==NULL   )
	{
	$nama=mysqli_fetch_array($qnama);
	?>
	<?
				
				if($u==1)
				{
				?>
				 <table width="250" border="0" align="center" cellpadding="0" cellspacing="0" >
            <tr>
              <td><img src="http://simpeg.org/images/top.gif" /></td>
            </tr>
            <tr>
              <td background="http://simpeg.org/images/middle.gif"><div align center > 
                <div align="center">
				 <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td><div align="center"><a href="struktur.php?u=<? echo($u); ?>&&td=2"  >Kepala Urusan Tata Usaha Sekolah  </a>
                      </div>
                       </td>
                    </tr>
                  </table>
			      </div>
              </div></td>
            </tr>
            <tr>
              <td><img src="http://simpeg.org/images/bottom.gif" /></td>
            </tr>
          </table>
		</div>
	  </td>
				
				<?
				
				}
				?>
	
	
	<td>
	      <table width="250" border="0" align="center" cellpadding="0" cellspacing="0" >
            <tr>
              <td><img src="http://simpeg.org/images/top.gif" /></td>
            </tr>
            <tr>
              <td background="http://simpeg.org/images/middle.gif"><div align center > 
                <div align="center">
				
                  <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td><div align="center"><a href="struktur.php?u=<? echo($u); ?>&&td=1" >UPTD pada dinas <?  echo($nama[0]); ?> </a>
                      </div>
                      </td>
                    </tr>
                  </table>
                </div>
              </div></td>
            </tr>
            <tr>
              <td><img src="http://simpeg.org/images/bottom.gif" /></td>
            </tr>
          </table>
	      <?
	}
	else
	{
	
	if($td==1 or  $td==2)
	{
	if($td==1)
	$word="Kepala UPTD";
	else
	$word="Kepala Urusan Tata Usaha";
	
	$qcup=mysqli_query($mysqli,"select count(*) from jabatan where id_unit_kerja=$u and jabatan like '$word%' order by jabatan");
	$ucup=mysqli_fetch_array($qcup);
	
	$qup=mysqli_query($mysqli,"select * from jabatan where id_unit_kerja=$u and jabatan like '$word%' order by jabatan");
	$z=1;
	while($upet=mysqli_fetch_array($qup))
	{
	
	?>
	
	
	      <table width="250" border="0" align="right" cellpadding="0" cellspacing="0" >
            <tr>
              <td colspan="2"><img src="http://simpeg.org/images/top.gif" alt="s" /></td>
              <td width="4">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2" background="http://simpeg.org/images/middle.gif"><div align="align" center="center" >
                  <div align="center">
                    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><div align="center">
                          <?  echo("$upet[1] <hr />"); 
						  
						   $qkpt2=mysqli_query($mysqli,"select count(*) from pegawai where id_j =$upet[0] and flag_pensiun=0");
						$kpt2=mysqli_fetch_array($qkpt2);
						  
						  ?>
                        
						 
						
                       
						 <?
						 	 $qkpt=mysqli_query($mysqli,"select nama,id_pegawai from pegawai where id_j =$upet[0] and flag_pensiun=0");
						$kpt=mysqli_fetch_array($qkpt);
						
					
						 
						 if($kpt2[0]==0)
						 echo("<div align=center > Jabatan Ini Masih Kosong</div>");
						 else
						 echo("<div align=center > $kpt[0]</div>");
						 $q3=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where id_next =$upet[0] and flag_pensiun=0 ");
		$ax=mysqli_fetch_array($q3);
	echo("<div align=center class=kedip> $ax[1]  </div>");	
						 
			
						 						 ?>
						
						
                        </div></td>
                      </tr>
                    </table>
                  </div>
              </div></td>
              <td >&nbsp;</td>
            </tr>
            <tr>
              <td colspan="2"><img src="http://simpeg.org/images/bottom.gif" /></td>
              <td>&nbsp;</td>
            </tr>
			  <?
			  
			  if($td==1)
			  {
			  
			  ?>
            <tr>
              <td width="185" align="right" valign="top"><div align="right"><img src="http://simpeg.org/images/menkols.gif"  /></div></td>
              <td width="65" align="right" valign="top"><div align="left"><img src="http://simpeg.org/images/mengkol3.gif" alt="s" /></div></td>
              <td align="left" valign="bottom"><div align="left"></div></td>
            </tr>
            <tr>
              <td colspan="2" align="right" valign="top">
			  
			
			  <table width="250" border="0" align="right" cellpadding="0" cellspacing="0" >
			  
                <tr>
                  <td><img src="http://simpeg.org/images/top.gif" alt="s" /></td>
                </tr>
                <tr>
                  <td background="http://simpeg.org/images/middle.gif"><div align="align" center="center" >
                      <div align="center">
                        <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
                          <tr>
                            <td><div align="center"> <? 
							$qja=mysqli_query($mysqli,"select * from jabatan where id_bos=$upet[0] ");
							$ja=mysqli_fetch_array($qja);
							echo("$ja[1] <hr />");
							
							 $qketu2=mysqli_query($mysqli,"select count(*) from pegawai where id_j=$ja[0] and flag_pensiun=0");
						$ketu2=mysqli_fetch_array($qketu2);
					
							  
							   $qketu=mysqli_query($mysqli,"select nama,id_pegawai from pegawai where id_j=$ja[0]  and flag_pensiun=0");
						$ketu=mysqli_fetch_array($qketu);
						 
							  
							  
							   
	
							
							  if($ketu2[0]==0)
						echo("<div align=center > Jabatan Ini Masih Kosong  </div>");
						else
					  echo("<div align=center > $ketu[0]  </div>");
					  
					  $q3=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where id_next =$ja[0] and flag_pensiun=0 ");
		$ax=mysqli_fetch_array($q3);
	echo("<div align=center class=kedip> $ax[1]  </div>");	
							  
				
							  
							  ?>
                       
                         
                            </div></td>
                          </tr>
                        </table>
						
					
                      </div>
                  </div></td>
                </tr>
                <tr>
                  <td><img src="http://simpeg.org/images/bottom.gif" alt="s" /></td>
                </tr>
				
                <tr>
                  <td>&nbsp;</td>
                </tr>
              </table>
			  
			  	<?
						}
						
						?>
			  </td>
              <td align="left" valign="bottom">&nbsp;</td>
            </tr>
          </table>
	      <?
	
	$z++;
	}
	}
	

	
	}
	?></div></td></tr>
  </table>
  <label></label>
</form>
</body>
</html>