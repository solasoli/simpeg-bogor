<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Untitled Document</title>

<style type="text/css">

<!--

body,td,th {

	font-family: Verdana, Arial, Helvetica, sans-serif;

	font-size: 11px;

	color: #000066;

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

-->

</style>

</head>



<body>

<?

$u=$_REQUEST['u'];

$td=$_REQUEST['td'];

$tu=$_REQUEST['tu'];

include("tree.php");



include("konek.php");

$qnama=mysqli_query($mysqli,"select nama_baru from unit_kerja where id_unit_kerja=$u");

/// kepaladinas, kepala badan,sekretaris kpu,sekretaris dprd,inspektur kota,sekda,asisten,camat,lurah



$q=mysqli_query($mysqli,"select jabatan,id_j,eselon,level from jabatan where id_unit_kerja=$u and ( jabatan like '%sekretaris daerah%' or jabatan like '%Asisten%' or jabatan like '%sekretaris kpu%' or

jabatan like '%kepala dinas%' or jabatan like '%kepala badan%' or jabatan like '%kepala kantor%' or jabatan like 'sekretaris dprd%' or jabatan like 'inspektur kota%' or jabatan like 'camat%' or jabatan like 'lurah%' or jabatan like 'kepala satuan%' or jabatan like 'sekretaris korpri%' or jabatan like 'walikota%' )order by level");



$dat=mysqli_fetch_array($q);

$q2=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where jabatan ='$dat[0]' and flag_pensiun=0 ");

//echo("select id_pegawai,nama from pegawai where jabatan ='$dat[0]' and flag_pensiun=0 ");

$at=mysqli_fetch_array($q2);



$q5=mysqli_query($mysqli,"select count(*) from pegawai where jabatan ='$dat[0]' and flag_pensiun=0 ");

//echo("select id_pegawai,nama from pegawai where jabatan ='$dat[0]' and flag_pensiun=0 ");

$at5=mysqli_fetch_array($q5);



?>

<form id="form1" name="form1" method="post" action="">

  <table width="990" border="0" align="center" cellpadding="0" cellspacing="0">

    <tr>

      <td colspan="5">&nbsp;</td>

    </tr>

    <tr>

      <td colspan="5"><div align="center"><table width="250" cellpadding="0" cellspacing="0" border="0" ><tr  ><td>&nbsp; </td><td width="250"  ><img src="images/top.gif" /></td><td>&nbsp; </td></tr><tr><td align="right" valign="bottom"><img src="./images/luhurs.gif" /> </td><td width="300" align="center" valign="middle" background="images/middle.gif"><table width="95%"><td></td><tr><td align="center"><? echo("$dat[0]   ");

	 //echo("select id_pegawai,nama from pegawai inner join jabatan on jabatan.jabatan=pegawai.jabatan where eselon = '$dat[2]' and flag_pensiun=0");

	   ?></td></tr></table>

        <label>	

        <select name="b1" id="b1" class="<?  if($at5[0]>0) echo("pendek"); else echo("sebling"); ?>"  >

		<?

		$qj=mysqli_query($mysqli,"select id_pegawai,nama from pegawai inner join jabatan on jabatan.jabatan=pegawai.jabatan where eselon = '$dat[2]' and flag_pensiun=0");

		

			if($at5[0]==0)

		echo("<option value=x selected > Jabatan Ini Masih Kosong  </option>");	

	

		while($ja=mysqli_fetch_array($qj))

		{

	

		

		if($ja[0]==$at[0])

		{

		echo("<option value=$ja[0] selected>$ja[1]</option>");

		mysqli_query($mysqli,"update pegawai set id_j=$dat[1] where id_pegawai=$ja[0]");

		

		}

		else

		echo("<option value=$ja[0]>$ja[1]  </option>");

		 

		 }

		?>

        </select>

        </label>

        <input name="ja1" type="hidden" id="ja1" value="<? echo($data[1]); ?>" />

        <br />

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

	 

	 

	 <img src=./images/gigirki2.gif /></td><td width=250  ><img src=images/top.gif /></td><td width=250 > <img src=images/knaan.gif /></td></tr><tr><td valign=top><img src=./images/tengah2.gif /> </td><td width=300 align=center valign=middle background=images/middle.gif><table width=95%><tr><td align=center> $sek2[0]  </td></tr></table>");

$q4=mysqli_query($mysqli,"select count(*) from pegawai where jabatan ='$sek2[0]' and flag_pensiun=0");



$a4=mysqli_fetch_array($q4);

if($a4[0]==0)

	 echo("<select name=sek id=sek class=sebling>");

	 else

echo("<select name=sek id=sek class=pendek>");





$q3=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where jabatan ='$sek2[0]' and flag_pensiun=0");



$a2=mysqli_fetch_array($q3);





	if($a4[0]==0)

		echo("<option value=0 selected> Jabatan Ini Masih Kosong </option>");



$q4=mysqli_query($mysqli,"select id_pegawai,nama from pegawai inner join jabatan on jabatan.jabatan=pegawai.jabatan where eselon = '$sek2[1]'");



while($jb=mysqli_fetch_array($q4))

		{

		if($jb[0]==$a2[0])

		{

		echo("<option value=$jb[0] selected>$jb[1]</option>");

		mysqli_query($mysqli,"update pegawai set id_j=$sek2[2] where id_pegawai=$a2[0]");

		}

		else

		echo("<option value=$jb[0]>$jb[1]   </option>");

		 

		 }





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



echo("<tr><td align=left  valign=top    ><img src=images/gigirki3.gif /></td><td align=left valign=top><table width=50 cellpadding=0 cellspacing=0 border=0 ><tr  ><td width=250  ><img src=images/top.gif /></td><td valign=top> <img src=./images/pinggir.gif /></td><td valign=top> <img src=./images/knaan2.gif /></td></tr><tr><td width=300 align=center valign=middle background=images/middle.gif><table width=95%><tr><td align=center> $as[0]   </td></tr>");



// kasubag pada sekretariat



$qasu=mysqli_query($mysqli,"select nama,id_pegawai from pegawai where jabatan like '$as[0]'");

$asu=mysqli_fetch_array($qasu);



$qasu2=mysqli_query($mysqli,"select count(*) from pegawai where jabatan like '$as[0]'");

$asu2=mysqli_fetch_array($qasu2);







$qan=mysqli_query($mysqli,"select nama,id_pegawai from pegawai inner join jabatan on pegawai.jabatan=jabatan.jabatan where eselon='$as[1]'");

if($asu2[0]==0)

echo("<tr><td align=center valign=top><select name=su$t id=su$t class=sebling>");

else

echo("<tr><td align=center valign=top><select name=su$t id=su$t class=pendek>");



if($asu2[0]==0)

echo("<option value =0 selected>Jabatan Ini Masih Kosong</option>");



while($an=mysqli_fetch_array($qan))

{

if($an[1]==$asu[1])

{

echo("<option value =$an[1] selected>$an[0]</option>");

mysqli_query($mysqli,"update pegawai set id_j=$as[2] where id_pegawai=$asu[1]");



}

else

echo("<option value =$an[1] >$an[0] </option>");



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

echo("</select></td></tr></table><td valign=top> <img src=./images/$tiga.gif /> </td></td></tr><tr  ><td width=250 valign=top ><img src=images/bottom.gif /> </td><td valign=top>  $dua </td></tr></table>");

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

$q3=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where jabatan ='$sisa[0]' and flag_pensiun=0");

$a2=mysqli_fetch_array($q3);



$qa=mysqli_query($mysqli,"select count(*) from pegawai where jabatan ='$sisa[0]' and flag_pensiun=0");

$aa=mysqli_fetch_array($qa);





echo("<td align=center valign=top><table width=250 cellpadding=0 cellspacing=0 border=0 >

<tr><td valign=top  $meng </td>  <td align=right>  $sam </td>    </tr>

<tr  ><td width=250  align=left><img src=images/top.gif /></td><td>&nbsp;</td></tr><tr><td width=250 align=center valign=middle class=latar ><table width=95%><tr><td align=center> $sisa[0]    <br> ");





if($aa[0]==0)

echo("   <select name=c$j id=c$j class=sebling>");

else

echo("   <select name=c$j id=c$j class=pendek>");



$q3=mysqli_query($mysqli,"select id_pegawai,nama from pegawai where jabatan ='$sisa[0]' and flag_pensiun=0");

$a2=mysqli_fetch_array($q3);



$q4=mysqli_query($mysqli,"select id_pegawai,nama from pegawai inner join jabatan on jabatan.jabatan=pegawai.jabatan where eselon = '$sisa[1]'");



if($a1[0]==0)

	echo("<option value=0 selected>Jabatan Ini Masih Kosong</option>");



while($jb=mysqli_fetch_array($q4))

		{

		if($jb[0]==$a2[0])

		{

		echo("<option value=$jb[0] selected>$jb[1]</option>");

		mysqli_query($mysqli,"update pegawai set id_j=$sisa[3] where id_pegawai=$a2[0]");

		}

		else

		echo("<option value=$jb[0]>$jb[1] </option>");

		 

		 }



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

echo("</select></td></tr></table></td><td align=left valign=top> </td></tr><tr  ><td width=250 valign=top align=left><img src=images/bottom.gif /> </td><td>  </td></tr><tr><td align=right valign=top> $coi  </td> <td valign=top align=left>$oi  </td>  </tr></table>");

echo("<table width=100% border=0 cellpadding=0 cellspacing=0>");



$qka=mysqli_query($mysqli,"select jabatan,eselon,id_j from jabatan where id_bos=$sisa[3]");

$h=1;

if($sas[0]==3)

$pas="'padding-left: 0px;' ";

else

$pas="'padding-left: 0px;' ";



while($kas=mysqli_fetch_array($qka))

{



echo("<tr><td align=left valign=top><table width=250 cellpadding=0 cellspacing=0 border=0 ><tr  ><td width=250  ><img src=images/top.gif /></td><td valign=bottom align=center> <img src=./images/pinggir.gif hspace=0 /></td></tr><tr><td width=250 align=center valign=middle background=images/middle.gif><table width=95%><tr><td align=center> $kas[0] ");

//echo("select nama,id_pegawai from pegawai where jabatan like '$kas[0]'");





// kasubag

$qisi=mysqli_query($mysqli,"select nama,id_pegawai from pegawai inner join jabatan on jabatan.jabatan=pegawai.jabatan where eselon='$kas[1]' and flag_pensiun=0");

$qpos=mysqli_query($mysqli,"select nama,id_pegawai from pegawai where jabatan like '$kas[0]' and flag_pensiun=0");

$pos=mysqli_fetch_array($qpos);



$qpos2=mysqli_query($mysqli,"select count(*) from pegawai where jabatan like '$kas[0]' and flag_pensiun=0");

$pos2=mysqli_fetch_array($qpos2);



if($pos2[0]==0)

{

echo ("<select name=bah id=ba$h class=sebling>");

echo("<option value=$pos2[0] selected>Jabatan Ini Masih Kosong</option>");

}

else

echo ("<select name=bah id=ba$h class=pendek>");

while($isi=mysqli_fetch_array($qisi))

{



if($isi[1]==$pos[1])

{

echo("<option value=$pos[1] selected>$pos[0] </option>");

mysqli_query($mysqli,"update pegawai set id_j=$kas[2] where id_pegawai=$pos[1]");



}else

echo("<option value=$isi[1] >$isi[0] </option>");







}

echo(" </select></td></tr></table></td><td valign=top>");

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

                      <td><div align="center"><a href="pohon.php?u=<? echo($u); ?>&&td=2" >Kepala Urusan Tata Usaha Sekolah  </a>

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

                      <td><div align="center"><a href="pohon.php?u=<? echo($u); ?>&&td=1" >UPTD pada dinas <?  echo($nama[0]); ?> </a>

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

                          <?  echo("$upet[1] "); 

						  

						   $qkpt2=mysqli_query($mysqli,"select count(*) from pegawai where jabatan like '$upet[1]' and flag_pensiun=0");

						$kpt2=mysqli_fetch_array($qkpt2);

						  

						  ?>

                         <br />

						 

						

                       

						 <?

						 	 $qkpt=mysqli_query($mysqli,"select nama,id_pegawai from pegawai where jabatan like '$upet[1]' and flag_pensiun=0");

						$kpt=mysqli_fetch_array($qkpt);

						

											 

						 

						 

						  if($kpt2[0]==0)

						 echo ("<select name=select name=uptd$z class=sebling>");

						 else

						 echo ("<select name=select name=uptd$z class=pendek>");

						 

					

						 

						 $qcka=mysqli_query($mysqli,"select nama,id_pegawai from pegawai inner join jabatan on jabatan.jabatan=pegawai.jabatan where eselon='$upet[4]' and flag_pensiun=0");

						 

						 if($kpt2[0]==0)

						 echo("<option value=0 selected> Jabatan Ini Masih Kosong</option>");

						 

						while($cka=mysqli_fetch_array($qcka))

						 {

						

					if($kpt[1]==$cka[1])

					{

						echo("<option value=$cka[1] selected> $cka[0] </option>");

						mysqli_query($mysqli,"update pegawai set id_j=$upet[0] where id_pegawai=$cka[1]");

						

						}

						else

					  echo("<option value=$cka[1] > $cka[0] </option>");

						 

						 

						 }

						 

						 echo("    </select>");

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

							echo("$ja[1]<br>");

							

							 $qketu2=mysqli_query($mysqli,"select count(*) from pegawai where jabatan like '$ja[1]' and flag_pensiun=0");

						$ketu2=mysqli_fetch_array($qketu2);

							

							?> 

                              <label>

                              <select class="pendek" name="ktu<? echo($z);

							  

							 

							  

							   ?>">

							  

							  <?

							  

							   $qketu=mysqli_query($mysqli,"select nama,id_pegawai from pegawai where jabatan like '$ja[1]' and flag_pensiun=0");

						$ketu=mysqli_fetch_array($qketu);

						 

							  

							  

							   

						 $qcketu=mysqli_query($mysqli,"select nama,id_pegawai from pegawai inner join jabatan on jabatan.jabatan=pegawai.jabatan where eselon='$ja[4]' and flag_pensiun=0");

							  

							  while($cketu=mysqli_fetch_array($qcketu))

							  {

							  if($ketu[1]==$cketu[1])

							  {

							  

							  echo("<option value=$cketu[1] selected> $cketu[0] </option>");

						mysqli_query($mysqli,"update pegawai set id_j=$ja[0] where id_pegawai=$cketu[1]");

						}

						else

					  echo("<option value=$cketu[1] > $cketu[0]  </option>");

							  

							  

							  }

							  

							  ?>

                              </select>

                              </label>

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

