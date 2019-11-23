<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Untitled Document</title>



<script type="text/javascript">

function print_page()

{

window.print();

return false;

}

</script>

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

	background-image: url(images/middle.gif);

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



#Layer2 {
	position:absolute;
	left:0px;
	top:0px;
	width:100%;
	height:600px;
	z-index:4;
	background-color: #f0f0f0;
	opacity:0.9;

	visibility:  <?

	$idp=$_REQUEST['idp'];



	$idj=$_REQUEST['idj'];

	if($idj==NULL or $idp!=NULL)

	echo("hidden");

	else

	echo("visible");



	?>;
	visibility: hidden;
}



#Layer2 table{

.opacity=0.99;

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

#Layer1 {
	position:absolute;
	left:313px;
	top:0px;
	width:56px;
	height:104px;
	z-index:5;

	visibility:<?

	



	$idj=$_REQUEST['idj'];

	if($idj==NULL or $idp!=NULL)

	echo("hidden");

	else

	echo("visible");



	?>;
	visibility: hidden;
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

#Layer3 {
	position:absolute;
	left:0px;
	top:0px;
	width:110px;
	height:34px;
	z-index:3;
	visibility: hidden;
}

#Layer4 {
	position:absolute;
	left:111px;
	top:0px;
	width:110px;
	height:31px;
	z-index:2;
	visibility: hidden;
}

#Layer5 {
	position:absolute;
	left:0px;
	top:43px;
	width:100%;
	height:598px;
	z-index:6;

	visibility: <?

	$k=$_REQUEST['k'];

	if($k=="kosong.php")

	echo("visible");

	else

	echo("hidden");

	?>;
	background-color: #FFFFFF;
	visibility: hidden;
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

$u=$_REQUEST['u'];

$td=$_REQUEST['td'];

$tu=$_REQUEST['tu'];

include("trees.php");



include("konek.php");



if($idj!=NULL and $idp!=NULL)

{

//mysqli_query($mysqli,"update pegawai set id_next=0 where id_next=$idj");

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





<div  id="Layer2"  ></div>

<div id="Layer1">

  <form id="form2" name="form2" method="post" action="struktur.php">

    

    <table width="500" border="0" align="center" cellpadding="5" cellspacing="0" bgcolor="#CCCCCC" >

      <tr>

        <td align="right" valign="top"><input name="idj" type="hidden" id="idj" value="<? echo($idj); ?>" />

          <input name="td" type="hidden" id="td" value="<? echo($td); ?>" />

          <label>

          <input name="u" type="hidden" id="u" value="<? echo($u); ?>" />

          

          <div align="center">

                <input name="cari" type="text" id="cari" size="45" />

                <input name="submit" type="submit" id="submit" value="Cari" />

                &nbsp;&nbsp;&nbsp;<a href="struktur.php?u=<? echo($u); ?>">[cancel]</a></div>

            </label>          <label></label></td>

      </tr>

      <tr>

        <td><?

		$cari=$_REQUEST['cari'];

		if($cari!=NULL)

		{

		

		

		?>

            <table width="500" border="0" cellspacing="0" cellpadding="3">

              <?

			  $qp=mysqli_query($mysqli,"select count(*) from pendidikan where jurusan_pendidikan like '%$cari%' ");

			  $pen=mysqli_fetch_array($qp);

			  if($pen[0]>0)

			  {

			  $qcari=mysqli_query($mysqli,"select pegawai.id_pegawai,nip_baru,nip_lama,nama,jabatan,id_j,jenis_kelamin from pegawai inner join pendidikan on pendidikan.id_pegawai=pegawai.id_pegawai where jurusan_pendidikan  like '%$cari%' order by level_p");

  }

else			  			  

		  $qcari=mysqli_query($mysqli,"select id_pegawai,nip_baru,nip_lama,nama,jabatan,id_j,jenis_kelamin from pegawai where nama like '%$cari%' order by id_j desc");

		 

		  while($kuya=mysqli_fetch_array($qcari))

		  {

		  if($kuya[5]==0)

		  		 $jab="Staf Pelaksana";

			else

			{

			$qjab=mysqli_query($mysqli,"select jabatan from jabatan where id_j=$kuya[5]");

			$job=mysqli_fetch_array($qjab);

			$jab="$job[0]";

			}

			

			$qunit=mysqli_query($mysqli,"select nama_baru from riwayat_mutasi_kerja inner join unit_kerja on unit_kerja.id_unit_kerja=riwayat_mutasi_kerja.id_unit_kerja where id_pegawai=$kuya[0] order by id_riwayat desc");

			$unot=mysqli_fetch_array($qunit);

			echo("	 

              <tr>

            <td nowrap valign=top align=right>");

			if (file_exists("./foto/$kuya[0].jpg")) 

			echo("<img src=./foto/$kuya[0].jpg style=opacity:1;filter:alpha(opacity=100) width=60 height=80/>");

			else

			{

			if($kuya[6]=='L')

			$fernando="male";

			else

			$fernando="female";

			echo("<img src=./images/$fernando.jpg style=opacity:1;filter:alpha(opacity=100) width=60 height=80/>");

			

			}

			

			echo("</td>

            <td  valign=top align=left>

			<div class=carol><a href=struktur.php?idp=$kuya[0]&&u=$u&&idj=$idj&&td=$td>

			<table cellpadding=2>

			<tr >

			<td align=left class=please>NIP</td>

			<td class=please>:</td>

			<td class=please><div >$kuya[1]</div></td>

			</tr>

			<tr>

			<td align=left class=please>Nama</td>

			<td class=please>:</td>

			<td class=please>$kuya[3]</td>

			</tr>

					<tr>

			<td align=left class=please>Jabatan</td>

			<td class=please>:</td>

			<td class=please>$jab</td>

			</tr>

					<tr>

			<td align=left class=please >Unit Kerja</td>

			<td class=please>:</td>

			<td class=please >$unot[0]</td>

			</tr>

			

			</table>

			</a>

			</div>

			</td>

                </tr>

          ");

		  }

		  ?>

            </table>

        <?

		

		}

		?></td>

      </tr>

    </table>

  </form>

</div>

<div id="Layer3">

  <table width="110" height="30" border="0" cellpadding="0" cellspacing="0" background="button.png">

    <tr>

      <td><div align="center"><a href="struktur.php?k=kosong.php&&u=<? 

	  

	  $u=$_REQUEST['u'];

	  echo($u); ?>" >Jabatan Kosong </a></div></td>

    </tr>

  </table>

</div>

<div id="Layer4">

  <table width="110" height="30" border="0" cellpadding="0" cellspacing="0">

    <tr>

      <td background="button.png"><div align="center"><a href="rf.php?u=<? echo($u); ?>">Rekap Formasi  </a></div></td>

    </tr>

  </table>

</div>

<div id="Layer5">

  <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">

    <tr>

      <td height="14">

      <div align="center"><? 

	  $k=$_REQUEST['k'];

	  $u=$_REQUEST['u'];

	  include("$k"); ?></div></td>

    </tr>

    <tr>

      <td height="14"><div align="left" onfocus="MM_showHideLayers('Layer5','','hide')">

        <div align="center"><a href="struktur.php?u=<? echo($u); ?>">[close]</a></div>

      </div></td>

    </tr>

  </table>

</div>

<form id="form1" name="form1" method="post" action="">

  <table width="990" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td colspan="5" align="center" valign="top"><br>

	  

	 <? // <a href="ekpor.php?u= echo($u) " onclick=" return print_page()" ><img src="doc.gif" border="0"  /></a> ?>

	  

	  </td>

    </tr>

	<tr>

      <td colspan="5">&nbsp;</td>

    </tr>

    <tr>

      <td colspan="5"><div align="center"><table width="250" cellpadding="0" cellspacing="0" border="0" ><tr  ><td>&nbsp; </td><td width="250"  ><img src="images/top.gif" /></td><td>&nbsp; </td></tr><tr><td align="right" valign="bottom"><img src="./images/luhurs.gif" /> </td><td width="300" align="center" valign="middle" background="images/middle.gif"><table width="95%"><td></td><tr><td align="center"><? echo("$dat[0]   ");



	   ?></td></tr></table><hr /> 

      

		<?

		

			if($at5[0]==0)

		echo("<div align=center> Jabatan Ini Masih Kosong  </div>");	

		else

		{

		$q2=mysqli_query($mysqli,"select id_pegawai,nama,pangkat_gol from pegawai where id_j =$dat[1] and flag_pensiun=0 ");

		$at=mysqli_fetch_array($q2);

		echo("<div align=center class=gede> $at[1] ( $at[2] )  </div>");	

		}

		

	$q3=mysqli_query($mysqli,"select id_pegawai,nama,pangkat_gol from pegawai where id_next =$dat[1] and flag_pensiun=0 ");

		while($ax=mysqli_fetch_array($q3))

	echo("<div align=center class=kedip> $ax[1] ( $ax[2] ) </div>");	

		?>

      

     

		<a  href="struktur.php?idj=<? echo($dat[1]);  ?>&&u=<? echo($u); ?>"  > [ Ganti ]  </a>

            </div> </td></tr> 

			

			

		

			<tr  ><td valign="top" align="<? if($td==NULL)

			echo("right");

			else

			echo("right");

			 ?>"><img src="./images/maneh.gif" /> </td><td width="250" valign="top" align=center><img src="images/bottom.gif" />

				<? if($td==NULL  and $u!=354 and $u!=609 and $u!=36 and $u!=2 and $u!=3 and $u!=4  )

			{

			?>

			<img src="images/tengah.gif" /> 

			<? 

			}

			?>

			</td><td><img src="./images/knaan.gif" /></td></tr>

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

	 

	 

	 <img src=./images/gigirki2.gif /></td><td width=250  ><img src=images/top.gif /></td><td width=250 > <img src=images/knaan.gif /></td></tr><tr><td valign=top><img src=./images/tengah2.gif /> </td><td width=300 align=center valign=middle background=images/middle.gif><table width=95%><tr><td align=center> $sek2[0]  </td></tr></table><hr />");

$q4=mysqli_query($mysqli,"select count(*) from pegawai where id_j ='$sek2[2]' and flag_pensiun=0");



$a4=mysqli_fetch_array($q4);



	if($a4[0]==0)

		 echo("<div align=center> Jabatan Ini Masih Kosong </div>");

		else

		{

		

$q3=mysqli_query($mysqli,"select id_pegawai,nama,pangkat_gol from pegawai where id_j =$sek2[2] and flag_pensiun=0");

		$a2=mysqli_fetch_array($q3);

		echo("<div align=center class =gede> $a2[1] ( $a2[2] )   </div>");

		}

$q3=mysqli_query($mysqli,"select id_pegawai,nama,pangkat_gol from pegawai where id_next =$sek2[2] and flag_pensiun=0 ");

		while($ax=mysqli_fetch_array($q3))

	echo("<div align=center class=kedip> $ax[1] ( $ax[2] )  </div>");	



	echo("<div align=center ><a href=struktur.php?u=$u&&idj=$sek2[2]>[ Ganti ]</a> </div>");

$qasoy=mysqli_query($mysqli,"select count(*) from jabatan where id_bos=$sek2[2]");

$asy=mysqli_fetch_array($qasoy);



if($asy[0]>0)

{$boy=" <img src=./images/menkols.gif />";

$boi=" <img src=./images/mengkol2.gif />";

}

else

{$boy=" &nbsp;";

$boi=" &nbsp;";

}





echo("</select></td><td valign=bottom>  </td><td> </td></tr><tr  ><td valign=top><img src=./images/gigirki2.gif /></td><td width=250 valign=top ><img src=images/bottom.gif /> </td><td valign=bottom></td><td>&nbsp;&nbsp;&nbsp;</td> </tr><tr><td valign=top align=right><img src=./images/gigirki2.gif /><img src=./images/gigirki2.gif /> </td><td align=right valign=top>  $boy </td><td align=left valign=bottom> $boi  </td>  </tr></table></td>     </tr><tr><td  colspan=$kolom[0] align=center valign=top><table cellpadding=0  cellspacing=0 border=0>");





$qas=mysqli_query($mysqli,"select jabatan,eselon,id_j from jabatan where id_bos=$sek2[2]");

$e=1;

while($as=mysqli_fetch_array($qas))

{



echo("<tr><td align=left  valign=top    ><img src=images/gigirki3.gif /></td><td align=left valign=top><table width=50 cellpadding=0 cellspacing=0 border=0 ><tr  ><td width=250  ><img src=images/top.gif /></td><td valign=top> <img src=./images/pinggir.gif /></td><td valign=top> <img src=./images/knaan2.gif /></td></tr><tr><td width=300 align=center valign=middle background=images/middle.gif><table width=95%><tr><td align=center> $as[0]    </td></tr></table><hr />");



// kasubag pada sekretariat





$qasu2=mysqli_query($mysqli,"select count(*) from pegawai where id_j =$as[2]");

$asu2=mysqli_fetch_array($qasu2);



if($asu2[0]==0)

echo("<div align=center>Jabatan Ini Masih Kosong</div>");

else

{

$qasu=mysqli_query($mysqli,"select nama,id_pegawai,pangkat_gol from pegawai where id_j =$as[2]");

$asu=mysqli_fetch_array($qasu);

echo("<div align=center class=gede>$asu[0] ( $asu[2] )  </div>");

}

$q3=mysqli_query($mysqli,"select id_pegawai,nama,pangkat_gol from pegawai where id_next =$as[2] and flag_pensiun=0 ");

		while($ax=mysqli_fetch_array($q3))

	echo("<div align=center class=kedip> $ax[1] ( $ax[2] )   </div>");	







echo("<div align=center ><a href=struktur.php?u=$u&&idj=$as[2]>[ Ganti ]</a> </div>");



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

echo("<td valign=top> <img src=./images/$tiga.gif /> </td></td></tr><tr  ><td width=250 valign=top ><img src=images/bottom.gif /> </td><td valign=top>  $dua  </td></tr></table>");

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

$meng="align=right > <img src=images/luhur1.gif /> ";

$sam="<img src=images/sambungan.png /> ";

}

else if($j==$sas[0])

{

$meng="align=left > <img src=images/luhur2.gif /> ";

$sam="&nbsp;";

}

else

{



if(($u>508 and $u<579) or ($u>30 and $u<35)  )

$meng="align=left > <img src=images/t2.png />";

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

<tr  ><td width=250  align=left><img src=images/top.gif /></td><td>&nbsp;</td></tr><tr><td width=250 align=center valign=middle class=latar ><table width=95%><tr><td align=center> $sisa[0]   </td></tr></table> <hr />  ");







$q3=mysqli_query($mysqli,"select id_pegawai,nama,pangkat_gol from pegawai where id_j =$sisa[3] and flag_pensiun=0");

$a2=mysqli_fetch_array($q3);





if($aa[0]==0)

		echo("<div align=center >Jabatan Ini Masih Kosong</div>");

		else

	echo("<div align=center class=gede> $a2[1] ( $a2[2] )</div>");



$q5=mysqli_query($mysqli,"select id_pegawai,nama,pangkat_gol from pegawai where id_next =$sisa[3] and flag_pensiun=0 ");

		while($ax=mysqli_fetch_array($q5))

	echo("<div align=center class=kedip> $ax[1] ( $ax[2] )  </div>");	



echo("<div align=center ><a href=struktur.php?u=$u&&idj=$sisa[3]>[ Ganti ]</a> </div>");



$qkau=mysqli_query($mysqli,"select count(*) from jabatan where id_bos=$sisa[3]");

$kau=mysqli_fetch_array($qkau);

if($kau[0]>0)

{

$coi="<img src=./images/menkols.gif /> ";

$oi="<img src=./images/mengkol3.gif />";

}

else

{

$coi="&nbsp; ";

$oi="&nbsp; ";



}

echo("<td align=left valign=top> </td></tr><tr  ><td width=250 valign=top align=left><img src=images/bottom.gif /> </td><td>  </td></tr><tr><td align=right valign=top> $coi  </td> <td valign=top align=left>$oi  </td>  </tr></table>");

echo("<table width=100% border=0 cellpadding=0 cellspacing=0>");



$qka=mysqli_query($mysqli,"select jabatan,eselon,id_j from jabatan where id_bos=$sisa[3]");

$h=1;

if($sas[0]==3)

$pas="'padding-left: 0px;' ";

else

$pas="'padding-left: 0px;' ";



while($kas=mysqli_fetch_array($qka))

{



echo("<tr><td align=left valign=top><table width=250 cellpadding=0 cellspacing=0 border=0 ><tr  ><td width=250  ><img src=images/top.gif /></td><td valign=bottom align=center> <img src=./images/pinggir.gif hspace=0 /></td></tr><tr><td width=250 align=center valign=middle background=images/middle.gif><table width=95%><tr><td align=center> $kas[0]</td></tr> </table><hr/> ");

//echo("select nama,id_pegawai from pegawai where jabatan like '$kas[0]'");





// kasubag



$qpos=mysqli_query($mysqli,"select nama,id_pegawai,pangkat_gol from pegawai where id_j =$kas[2] and flag_pensiun=0");

$pos=mysqli_fetch_array($qpos);



$qpos2=mysqli_query($mysqli,"select count(*) from pegawai where id_j=$kas[2] and flag_pensiun=0");

$pos2=mysqli_fetch_array($qpos2);



if($pos2[0]==0)

echo("<div align=center >Jabatan Ini Masih Kosong</div>");

else

echo ("<div align=center class=gede> $pos[0] ( $pos[2] ) </div>");



$q3=mysqli_query($mysqli,"select id_pegawai,nama,pangkat_gol from pegawai where id_next =$kas[2] and flag_pensiun=0 ");

		while($ax=mysqli_fetch_array($q3))

	echo("<div align=center class=kedip> $ax[1] ( $ax[2] )  </div>");	



echo("<div align=center ><a href=struktur.php?u=$u&&idj=$kas[2]>[ Ganti ]</a> </div>");



echo(" </td><td valign=top>");

if($h==$kau[0])

 echo("<img src=./images/tri2.gif />");

 else

 echo("<img src=./images/tri.gif />");

 

 echo("</td></tr><tr  ><td width=250 valign=top ><img src=images/bottom.gif /> </td><td valign=top>");

 if($h==$kau[0])

  echo(" ");

  else

  echo("<img src=./images/pinggir.gif />");

  

  

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

              <td><img src="images/top.gif" /></td>

            </tr>

            <tr>

              <td background="images/middle.gif"><div align center > 

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

              <td><img src="images/bottom.gif" /></td>

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

              <td><img src="images/top.gif" /></td>

            </tr>

            <tr>

              <td background="images/middle.gif"><div align center > 

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

              <td><img src="images/bottom.gif" /></td>

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

              <td colspan="2"><img src="images/top.gif" alt="s" /></td>

              <td width="4">&nbsp;</td>

            </tr>

            <tr>

              <td colspan="2" background="images/middle.gif"><div align="align" center="center" >

                  <div align="center">

                    <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

                      <tr>

                        <td><div align="center">

                          <?  echo("$upet[1] <hr />"); 

						  

						   $qkpt2=mysqli_query($mysqli,"select count(*) from pegawai where id_j =$upet[0] and flag_pensiun=0");

						$kpt2=mysqli_fetch_array($qkpt2);

						  

						  ?>

                        

						 

						

                       

						 <?

						 	 $qkpt=mysqli_query($mysqli,"select nama,id_pegawai,pangkat_gol from pegawai where id_j =$upet[0] and flag_pensiun=0");

						$kpt=mysqli_fetch_array($qkpt);

						

					

						 

						 if($kpt2[0]==0)

						 echo("<div align=center > Jabatan Ini Masih Kosong</div>");

						 else

						 echo("<div align=center > $kpt[0] ( $kpt[2]  ) </div>");

						 $q3=mysqli_query($mysqli,"select id_pegawai,nama,pangkat_gol from pegawai where id_next =$upet[0] and flag_pensiun=0 ");

		while($ax=mysqli_fetch_array($q3))

	echo("<div align=center class=kedip> $ax[1] ( $ax[2] ) </div>");	

						 

				echo("<div align=center ><a href=struktur.php?u=$u&&idj=$upet[0]&&td=$td>[ Ganti ]</a> </div>");

						 						 ?>

						

						

                        </div></td>

                      </tr>

                    </table>

                  </div>

              </div></td>

              <td >&nbsp;</td>

            </tr>

            <tr>

              <td colspan="2"><img src="images/bottom.gif" /></td>

              <td>&nbsp;</td>

            </tr>

			  <?

			  

			  if($td==1)

			  {

			  

			  ?>

            <tr>

              <td width="185" align="right" valign="top"><div align="right"><img src="images/menkols.gif"  /></div></td>

              <td width="65" align="right" valign="top"><div align="left"><img src="images/mengkol3.gif" alt="s" /></div></td>

              <td align="left" valign="bottom"><div align="left"></div></td>

            </tr>

            <tr>

              <td colspan="2" align="right" valign="top">

			  

			

			  <table width="250" border="0" align="right" cellpadding="0" cellspacing="0" >

			  

                <tr>

                  <td><img src="images/top.gif" alt="s" /></td>

                </tr>

                <tr>

                  <td background="images/middle.gif"><div align="align" center="center" >

                      <div align="center">

                        <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">

                          <tr>

                            <td><div align="center"> <? 

							$qja=mysqli_query($mysqli,"select * from jabatan where id_bos=$upet[0] ");

							$ja=mysqli_fetch_array($qja);

							echo("$ja[1] <hr />");

							

							 $qketu2=mysqli_query($mysqli,"select count(*) from pegawai where id_j=$ja[0] and flag_pensiun=0");

						$ketu2=mysqli_fetch_array($qketu2);

					

							  

							   $qketu=mysqli_query($mysqli,"select nama,id_pegawai,pangkat_gol from pegawai where id_j=$ja[0]  and flag_pensiun=0");

						$ketu=mysqli_fetch_array($qketu);

						 

							  

							  

							   

	

							

							  if($ketu2[0]==0)

						echo("<div align=center > Jabatan Ini Masih Kosong  </div>");

						else

					  echo("<div align=center > $ketu[0] ( $ketu[2] )  </div>");

					  

					  $q3=mysqli_query($mysqli,"select id_pegawai,nama,pangkat_gol  from pegawai where id_next =$ja[0] and flag_pensiun=0 ");

		while($ax=mysqli_fetch_array($q3))

		

			echo("<div align=center class=kedip> $ax[1] ( $ax[2] )  </div>");	

							  

							  	echo("<div align=center ><a href=struktur.php?u=$u&&idj=$ja[0]&&td=$td>[ Ganti ]</a> </div>");

				

							  

							  ?>

                       

                         

                            </div></td>

                          </tr>

                        </table>

						

					

                      </div>

                  </div></td>

                </tr>

                <tr>

                  <td><img src="images/bottom.gif" alt="s" /></td>

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

