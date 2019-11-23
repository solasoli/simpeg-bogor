<?php
include("konek.php");
$cekr=0;
$k=0;
$ket=0;
extract($_POST);
extract($_GET);
if($cekr==NULL)
$cekr=0;

if($ket==NULL)
$ket=0;


if($k==NULL)
$k=0;


?>
<html>
<head>
<script type="text/javascript" src="jquery-1.4.js"></script>
<script type='text/javascript' src='jquery.autocomplete.js'></script>
<link rel="stylesheet" type="text/css" href="jquery.autocomplete.css" />
<link rel="stylesheet" href="main.css" type="text/css" />
<script type="text/javascript">
$().ready(function() {
	$("#jab").autocomplete("proses_jab.php", {
		width: 150
  });

	$("#jab").result(function(event, data, formatted) {
				$('#pilihan').html("<p>Anda memilih negara: " + formatted + "</p>");
	});

});
</script>
<script type="text/javascript">
$(document).ready(function() {
	$('#negara').keyup(function(){

	  });


	$("#negara").autocomplete("proses_negara.php", {
		width: 150
  })
   .result(function(evt, data, formated){
                $("#id_pegawai").val(data[1]);
				var negara = $('#id_pegawai').val();
				   $.ajax({
					type:"POST",
					url:"selamat.php",
					data: 'id_pegawai=' + negara,
					success: function (html){
					  $('#tampilkan').html(html);
					}
				   });
        });

function sk(){
        document.printx.action="sk1.php";
}

function baperjakat(){
        document.printx.action="sk4.php";
}

function lampiran(){
        document.printx.action="sk2.php";
}

function pelantikan(){
        document.printx.action="sk3.php";
}

});
</script>
<script language="JavaScript" src="calendar_eu.js"></script>


	<link rel="stylesheet" href="calendar.css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body,td,th {
	font-size: 11px;
}
.style1 {color: #FFFFFF}

#Layer2 {
	height:100%;
			width:100%;
			position:fixed;
			left:0;
			top:0;
			z-index:1 !important;
			background-color:black;

			visibility:<?php

			if($cekr==0)
			echo("hidden");
			else
			echo("visibble");

			 ?>;


filter: alpha(opacity=75); /* internet explorer */
-khtml-opacity: 0.75;      /* khtml, old safari */
-moz-opacity: 0.75;       /* mozilla, netscape */
opacity: 0.75;           /* fx, safari, opera */
}
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: none;
}
a:active {
	text-decoration: none;
}
-->
</style>
</head>
<body>
<?php

$qk=mysqli_query($mysqli,"select jabatan.id_j,jabatan from kosong_jabatan inner join jabatan on jabatan.id_j=kosong_jabatan.id_j");



?>

<div id="Layer2"><form action="sk1.php" method="post" name="printx" target="_blank" id="printx"><?php

$s=0;
extract($_GET);
if($s==NULL)
$s=0;
?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
      <td align="right" valign="top"><table width="75%" border="0" align="center" cellpadding="5" cellspacing="0">
        <tr>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
          <td><span class="style1">Tanggal SK:
            <input name="tsk" type="text" id="tsk">
                <script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'printx',
		// input name
		'controlname': 'tsk'
	});

	      </script>
            &nbsp;&nbsp;&nbsp;&nbsp;</span></td>
          <td><span class="style1"> TMT:
            <input name="tmt" type="text" id="tmt">
                <script language="JavaScript">
	new tcal ({
		// form name
		'formname': 'printx',
		// input name
		'controlname': 'tmt'
	});

	      </script>
            &nbsp;</span></td>
          <td><span class="style1">&nbsp;NO Baperjakat:
              <input name="baper" type="text" id="baper"></span></td>
        </tr>
        <tr >
          <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="5">
            <?php $qc=mysqli_query($mysqli,"select count(*),eselon from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='$s' group by eselon order by eselon");
	while($crut=mysqli_fetch_array($qc))
	{
		if($s==$crut[1])
		{
	?>
            <tr class="style1">
              <td>No Pelantikan</td>
              <td align="left" valign="top">:
                <input name="nolantik" type="text" id="nolantik"></td>
            </tr>
            <tr class="style1">
              <td>Dilantik Oleh</td>
              <td align="left" valign="top">:
                <label for="lantik"></label>
                <select name="lantik" id="lantik">
                  <option value="DIANI BUDIARTO">Walikota Bogor</option>
                  <option value="ACHMAD RUYAT">Wakil Walikota Bogor</option>
                </select></td>
            </tr>
            <tr class="style1">
              <td>Saksi 1</td>
              <td align="left" valign="top">:
                <label for="s1"></label>
                <select name="s1" id="s1">
                  <option value="1978">Sekretaris Daerah</option>
                  <option value="1090">Kepala Badan kepegawaian, Pendidikan dan Pelatihan Kota Bogor</option>
                  <option value="1442">Inspektur Kota Bogor</option>
                </select></td>
            </tr>
            <tr class="style1">
              <td>Saksi 2</td>
              <td align="left" valign="top">:
                <select name="s2" id="s2">
                  <option value="1978">Sekretaris Daerah</option>
                  <option value="1090">Kepala Badan kepegawaian, Pendidikan dan Pelatihan Kota Bogor</option>
                  <option value="1442">Inspektur Kota Bogor</option>
                </select></td>
            </tr>
            <tr class="style1">
              <td>Tempat Dilantik</td>
              <td align="left" valign="top">:
                <input name="tmpt" type="text" id="tmpt" size="40"></td>
            </tr>
            <tr class="style1">
              <td>No SK Eselon <?php echo($crut[1]);

			  if($ket=='Ahli')
			  echo" Staf Ahli";

			  ?>
                <input name="ket" type="hidden" id="ket" value="<?php echo($ket);  ?>"></td>
              <td align="left" valign="top">:
                <input name="sk" type="text" id="sk" size="40"></td>
              </tr>
            <?php }

	}
	?>
            <tr class="style1">
              <td colspan="2" align="center">R O H A N I A W A N</td>
              </tr>
            <tr class="style1">
              <td>Nama</td>
              <td align="left" valign="top">:
                <input name="ro1" type="text" id="ro1" size="40"></td>
            </tr>
            <tr class="style1">
              <td>Pangkat-Gol</td>
              <td align="left" valign="top">:
                <label for="ro3"></label>
                <select name="ro2" id="ro2">
                  <option value="Juru Muda - I/a">I/a</option>
                  <option value="Juru Muda Tingkat I - I/b">I/b</option>
                  <option value="Juru - I/c">I/c</option>
                  <option value="Juru Tingkat I - I/d">I/d</option>
                  <option value="Pengatur Muda - II/a">II/a</option>
                  <option value="Pengatur Muda Tingkat I - II/b">II/b</option>
                  <option value="Pengatur- II/c">II/c</option>
                  <option value="Pengatur Tingkat I - II/d">II/d</option>
                  <option value="Penata Muda - III/a">III/a</option>
                  <option value="Penata Muda Tingkat I - III/b">III/b</option>
                  <option value="Penata - III/c">III/c</option>
                  <option value="Pangkat Penata Tingkat I - III/d">III/d </option>
                </select></td>
            </tr>
            <tr class="style1">
              <td>NIP</td>
              <td align="left" valign="top">:
                <input name="ro3" type="text" id="ro3" size="40"></td>
            </tr>
            <tr class="style1">
              <td>Agama</td>
              <td align="left" valign="top">:
                <label for="ro4"></label>
                <select name="ro4" id="ro4">
                  <option value="ISLAM">ISLAM</option>
                  <option value="KRISTEN">KRISTEN</option>
                  <option value="KATOLIK">KATOLIK</option>
                  <option value="HINDU">HINDU</option>
                  <option value="BUDHA">BUDHA</option>
                  <option value="KONG HU CU">KONG HU CU</option>
                </select></td>
            </tr>
            <tr class="style1">
              <td>Unit Kerja</td>
              <td align="left" valign="top">:
                <input name="ro5" type="text" id="ro5" size="40"></td>
            </tr>
            <tr class="style1">
              <td>&nbsp;</td>
              <td align="left" valign="top">&nbsp;</td>
            </tr>
            <tr class="style1">
              <td><input name="s" type="hidden" id="s" value="<?php echo($s); ?>"></td>
              <td align="left" valign="top" nowrap>&nbsp;&nbsp;&nbsp;
                <input type="submit" name="Submit1" value="Cetak Baperjakat" onClick="baperjakat()">
                <input type="submit" name="Submit2" value="Cetak SK" onClick="sk()">
                <input type="submit" name="Submit3" value="Cetak Lampiran" onClick="lampiran()">
                <input type="submit" name="Submit4" value="Cetak Pernyataan Pelantikan" onClick="pelantikan()"></td>
              </tr>
          </table>            <label></label></td>
          </tr>
        <tr >
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>        l</td>
      <td align="right" valign="top"><a href="pegawai.php?cekr=0"><span class="style1"><strong>cancel&nbsp;&nbsp;&nbsp;</strong></span></a></td>
    </tr>
  </table>
</form></div>
<form name="form1" method="post" action="pegawai.php">
    <div class="demo" style="width: 1000px;">
      <div>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="62%"><table width="600" border="0" cellspacing="0" cellpadding="5">
              <tr>
                <td>Nama Pegawai</td>
                <td><input name="negara" type="text" id="negara"  size="35" <?php
				if(@$peg!=NULL)
				{
				$qso=mysqli_query($mysqli,"select nama,nip_baru from pegawai where id_pegawai=$peg");
				$show=mysqli_fetch_array($qso);

				echo("value='$show[0]'");
				}
				?>>
                <input name="idp" type="hidden" id="idp">
                <input name="id_pegawai" type="hidden" id="id_pegawai"></td>
              </tr>
              <tr>
                <td>Jabatan</td>
                <td align="left" valign="top"><textarea name="jab" cols="70" rows="3" id="jab"><?php
                if($k>0)
				{
				$qyo=mysqli_query($mysqli,"select jabatan from jabatan where id_j=$k");
				$yo=mysqli_fetch_array($qyo);
				echo($yo[0]);

				}

				?></textarea>
                </td>
              </tr>
              <tr>
                <td>Unit Kerja </td>
                <td></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="Submit" value="Tambahkan"></td>
              </tr>
            </table></td>
            <td width="38%" align="left" valign="top"><div id="tampilkan"></div></td>
          </tr>
        </table>
        <p>
          <label></label>
        </p>
      </div>
    </div>
</form><?php
$negara=0;
$jab=0;
$idp=0;
extract($_POST);
if($negara!=NULL and $jab!=NULL)
{
	$taun=date("2017");
//echo("nama=$negara jabatan=$jab idp=$idp");
$qp=mysqli_query($mysqli,"select id_pegawai from pegawai where id_pegawai =$id_pegawai");
//echo("select id_pegawai from pegawai where id_pegawai =$id_pegawai");
$qj=mysqli_query($mysqli,"select id_j from jabatan where jabatan ='$jab' and Tahun=$taun");
//echo("select id_j from jabatan where jabatan ='$jab' and Tahun=$taun");
$p=mysqli_fetch_array($qp);
$j=mysqli_fetch_array($qj);

$qc=mysqli_query($mysqli,"select count(*) from mutasi_jabatan where id_pegawai=$p[0] or id_j=$j[0]");
//echo("select count(*) from mutasi_jabatan where id_pegawai=$p[0] or id_j=$j[0]");

$cek=mysqli_fetch_array($qc);
if($cek[0]==0)
mysqli_query($mysqli,"insert into mutasi_jabatan (id_pegawai,id_j) values ($p[0],$j[0])");
else
{
	$qc=mysqli_query($mysqli,"select count(*) from mutasi_jabatan where id_pegawai=$p[0]");

$cek=mysqli_fetch_array($qc);
if($cek[0]>0)
echo("<div align=center> $negara sudah ada di dalam daftar mutasi di bawah</div>");
else
echo("<div align=center> $jab sudah ada di dalam daftar mutasi di bawah</div>");
}





}





?>
<form name="form2" method="post" action="">

 <table cellpadding="5" cellspacing="0" border="0">
  <tr>
   <td align="left" valign="top">          </td>
 </tr>
 <tr>
   <td align="left" valign="top">
  </td>
 </tr>



  <tr>
   <?php

	$q1a=mysqli_query($mysqli,"Select count(*) from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IIB'");
$b2=mysqli_fetch_array($q1a);
if($b2[0]>0)
{

$q=mysqli_query($mysqli,"Select id_mutjab,mutasi_jabatan.id_pegawai,mutasi_jabatan.id_j,eselon from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IIB' and jabatan like '%ahli%' ");



	?>
 <td align="left" valign="top">
<a href="pegawai.php?cekr=1&s=IIB&ket=Ahli" >Eselon II B Staf Ahli</a> </br></br>
  <table width="1000" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#666666">
      <tr>
        <td>

		<table width="1000" border="0" cellpadding="5" cellspacing="0" bordercolor="#666666">
          <tr>
            <td bgcolor="#666666"><span class="style1">NO</span></td>
            <td bgcolor="#666666"><span class="style1">Nama</span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan Sebelum </span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan</span></td>
			<td bgcolor="#666666"><span class="style1">Eselonering</span></td>
            <td bgcolor="#666666"><span class="style1">Keterangan</span></td>
            <td bgcolor="#666666"><div align="center" class="style1">Batalakan</div></td>
          </tr>
          <?php
	  $z=1;
	  while($data=mysqli_fetch_array($q))
	  {
	  if($z%2==1)
	  echo("<tr>");
	  else
	  echo("<tr bgcolor=#f0f0f0>");


	  $qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] and id_kategori_sk=10 order by tgl_sk desc");


	  $peg=mysqli_fetch_array($qp);


	  $qj=mysqli_query($mysqli,"select jabatan,eselon from jabatan where id_j=$data[2]");
	  $jo=mysqli_fetch_array($qj);

	   if("$peg[2]"=="$jo[1]")
	   {
	   if("$peg[1]"=="$jo[0]")
	   $ket="Tetap";
	   else
	   $ket="Rotasi";

	   }
	   else
	   $ket="Promosi";

	  if($peg[1]=='-')
	  $peg[1]=("Pelaksana");
      echo("
        <td>$z</td>
        <td nowrap>$peg[0]</td>
		<td>$peg[1]</td>
        <td>$jo[0]</td>
		<td>$jo[1]</td>
		<td>$ket</td>
        <td align=center><a href=batal.php?id=$data[0] ><img src=hapus.png border=0 /></a></td>
      </tr>");
	  $z++;
	  }
	  ?>
        </table></td>
      </tr>
  </table>	</td>
	</tr>
	<?php
		}
	?>
  </tr>
  <tr>
  <?php

	$q1a=mysqli_query($mysqli,"Select count(*) from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IIB' and jabatan not like '%ahli%'");
$b2=mysqli_fetch_array($q1a);
if($b2[0]>0)
{

$q=mysqli_query($mysqli,"Select id_mutjab,mutasi_jabatan.id_pegawai,mutasi_jabatan.id_j,eselon from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IIB' and jabatan not like '%ahli%' ");



	?>
 <td align="left" valign="top">
<a href="pegawai.php?cekr=1&s=IIB&ket=0" >Eselon II B</a> </br></br>
  <table width="1000" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#666666">
      <tr>
        <td>

		<table width="1000" border="0" cellpadding="5" cellspacing="0" bordercolor="#666666">
          <tr>
            <td bgcolor="#666666"><span class="style1">NO</span></td>
            <td bgcolor="#666666"><span class="style1">Nama</span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan Sebelum </span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan</span></td>
			<td bgcolor="#666666"><span class="style1">Eselonering</span></td>
            <td bgcolor="#666666"><span class="style1">Keterangan</span></td>
            <td bgcolor="#666666"><div align="center" class="style1">Batalakan</div></td>
          </tr>
          <?php
	  $z=1;
	  while($data=mysqli_fetch_array($q))
	  {
	  if($z%2==1)
	  echo("<tr>");
	  else
	  echo("<tr bgcolor=#f0f0f0>");


	  $qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] and id_kategori_sk=10 order by tgl_sk desc");


	  $peg=mysqli_fetch_array($qp);


	  $qj=mysqli_query($mysqli,"select jabatan,eselon from jabatan where id_j=$data[2]");
	  $jo=mysqli_fetch_array($qj);

	   if("$peg[2]"=="$jo[1]")
	   {
	   if("$peg[1]"=="$jo[0]")
	   $ket="Tetap";
	   else
	   $ket="Rotasi";

	   }
	   else
	   $ket="Promosi";

	  if($peg[1]=='-')
	  $peg[1]=("Pelaksana");
      echo("
        <td>$z</td>
        <td nowrap>$peg[0]</td>
		<td>$peg[1]</td>
        <td>$jo[0]</td>
		<td>$jo[1]</td>
		<td>$ket</td>
        <td align=center><a href=batal.php?id=$data[0] ><img src=hapus.png border=0 /></a></td>
      </tr>");
	  $z++;
	  }
	  ?>
        </table></td>
      </tr>
  </table>	</td>
	</tr>
	<?php
		}
	?>
	<tr>
	<td align="left" valign="top">
	<?php

	$q2a=mysqli_query($mysqli,"Select count(*) from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IIIA'");
$a3=mysqli_fetch_array($q2a);
if($a3[0]>0)
{

$q=mysqli_query($mysqli,"Select id_mutjab,mutasi_jabatan.id_pegawai,mutasi_jabatan.id_j,eselon from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IIIA'  ");
?>

    <a href="pegawai.php?cekr=1&s=IIIA&ket=0">Eselon III A</br></br>
    </a>
    <table width="1000" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#666666">
    <tr>
        <td>

		<table width="1000" border="0" cellpadding="5" cellspacing="0" bordercolor="#666666">
          <tr>
            <td bgcolor="#666666"><span class="style1">NO</span></td>
            <td bgcolor="#666666"><span class="style1">Nama</span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan Sebelum </span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan</span></td>
			<td bgcolor="#666666"><span class="style1">Eselonering</span></td>
            <td bgcolor="#666666"><span class="style1">Keterangan</span></td>
            <td bgcolor="#666666"><div align="center" class="style1">Batalakan</div></td>
          </tr>
          <?php
	  $z=1;
	  while($data=mysqli_fetch_array($q))
	  {
	  if($z%2==1)
	  echo("<tr>");
	  else
	  echo("<tr bgcolor=#f0f0f0>");


	  $qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] and id_kategori_sk=10 order by tgl_sk desc");

	 // echo("select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] order by tgl_sk desc");
	  $peg=mysqli_fetch_array($qp);


	  $qj=mysqli_query($mysqli,"select jabatan,eselon from jabatan where id_j=$data[2]");
	  $jo=mysqli_fetch_array($qj);

	   if("$peg[2]"=="$jo[1]")
	   {
	   if("$peg[1]"=="$jo[0]")
	   $ket="Tetap";
	   else
	   $ket="Rotasi";

	   }
	   else
	   $ket="Promosi";

	  if($peg[1]=='-')
	  $peg[1]=("Pelaksana");
      echo("
        <td>$z</td>
        <td nowrap>$peg[0]</td>
		<td>$peg[1]</td>
        <td>$jo[0]</td>
		<td>$jo[1]</td>
		<td>$ket</td>
        <td align=center><a href=batal.php?id=$data[0] ><img src=hapus.png border=0 /></a></td>
      </tr>");
	  $z++;
	  }
	  ?>
        </table></td>
      </tr>
</table>	</td>
	</tr>

	<?php

	}
	?>
	<tr>
	<td align="left" valign="top">
		<?php

	$q3a=mysqli_query($mysqli,"Select count(*) from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IIIB'");
$b3=mysqli_fetch_array($q3a);
if($b3[0]>0)
{

$q=mysqli_query($mysqli,"Select id_mutjab,mutasi_jabatan.id_pegawai,mutasi_jabatan.id_j,eselon from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IIIB'  ");
?>

        <a href="pegawai.php?cekr=1&s=IIIB&ket=0">Eselon III B</a> </br></br>
        <table width="1000" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#666666">
      <tr>
        <td>

		<table width="1000" border="0" cellpadding="5" cellspacing="0" bordercolor="#666666">
          <tr>
            <td bgcolor="#666666"><span class="style1">NO</span></td>
            <td bgcolor="#666666"><span class="style1">Nama</span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan Sebelum </span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan</span></td>
			<td bgcolor="#666666"><span class="style1">Eselonering</span></td>
            <td bgcolor="#666666"><span class="style1">Keterangan</span></td>
            <td bgcolor="#666666"><div align="center" class="style1">Batalakan</div></td>
          </tr>
          <?php
	  $z=1;
	  while($data=mysqli_fetch_array($q))
	  {
	  if($z%2==1)
	  echo("<tr>");
	  else
	  echo("<tr bgcolor=#f0f0f0>");


	  $qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] and id_kategori_sk=10 order by tgl_sk desc");

	 // echo("select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] order by tgl_sk desc");
	  $peg=mysqli_fetch_array($qp);


	  $qj=mysqli_query($mysqli,"select jabatan,eselon from jabatan where id_j=$data[2]");
	  $jo=mysqli_fetch_array($qj);

	   if("$peg[2]"=="$jo[1]")
	   {
	   if("$peg[1]"=="$jo[0]")
	   $ket="Tetap";
	   else
	   $ket="Rotasi";

	   }
	   else
	   $ket="Promosi";

	  if($peg[1]=='-')
	  $peg[1]=("Pelaksana");
      echo("
        <td>$z</td>
        <td nowrap>$peg[0]</td>
		<td>$peg[1]</td>
        <td>$jo[0]</td>
		<td>$jo[1]</td>
		<td>$ket</td>
        <td align=center><a href=batal.php?id=$data[0] ><img src=hapus.png border=0 /></a></td>
      </tr>");
	  $z++;
	  }
	  ?>
        </table></td>
      </tr>
  </table>	</td>
	</tr>
	<?php

	}
	?>
	<tr>
	<td align="left" valign="top">

	<?php

	//$q4a=mysqli_query($mysqli,"Select count(*) from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IVA' and jabatan not like '%kecamatan%' and jabatan not like '%kelurahan%' and jabatan not like '%UPTD%'  ");
	$q4a=mysqli_query($mysqli,"Select count(*) from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IVA' ");
$a4=mysqli_fetch_array($q4a);
if($a4[0]>0)
{

//$q=mysqli_query($mysqli,"Select id_mutjab,mutasi_jabatan.id_pegawai,mutasi_jabatan.id_j,eselon from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IVA' and jabatan not like '%kecamatan%' and jabatan not like '%kelurahan%' and jabatan not like '%UPTD%'  ");
$q=mysqli_query($mysqli,"Select id_mutjab,mutasi_jabatan.id_pegawai,mutasi_jabatan.id_j,eselon from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IVA'  ");
?>

    <a href="pegawai.php?cekr=1&s=IVA&ket=0">Eselon IV A</a> </br></br>
    <table width="1000" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#666666">
      <tr>
        <td>

		<table width="1000" border="0" cellpadding="5" cellspacing="0" bordercolor="#666666">
          <tr>
            <td bgcolor="#666666"><span class="style1">NO</span></td>
            <td bgcolor="#666666"><span class="style1">Nama</span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan Sebelum </span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan</span></td>
			<td bgcolor="#666666"><span class="style1">Eselonering</span></td>
            <td bgcolor="#666666"><span class="style1">Keterangan</span></td>
            <td bgcolor="#666666"><div align="center" class="style1">Batalakan</div></td>
          </tr>
          <?php
	  $z=1;
	  while($data=mysqli_fetch_array($q))
	  {
	  if($z%2==1)
	  echo("<tr>");
	  else
	  echo("<tr bgcolor=#f0f0f0>");

	  $qcau=mysqli_query($mysqli,"select count(*) from pegawai where id_pegawai=$data[1] and id_j>0");
	  $cau=mysqli_fetch_array($qcau);
	  if($cau[0]>0)
	  $qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] and id_kategori_sk=10 order by tgl_sk desc");
	  else
	  $qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] order by tgl_sk desc");

	 // echo("select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] order by tgl_sk desc");
	  $peg=mysqli_fetch_array($qp);


	  $qj=mysqli_query($mysqli,"select jabatan,eselon from jabatan where id_j=$data[2]");
	  $jo=mysqli_fetch_array($qj);

	   if("$peg[2]"=="$jo[1]")
	   {
	   if("$peg[1]"=="$jo[0]")
	   $ket="Tetap";
	   else
	   $ket="Rotasi";

	   }
	   else
	   $ket="Promosi";

	  if($peg[1]=='-')
	  $peg[1]=("Pelaksana");
      echo("
        <td>$z</td>
        <td nowrap>$peg[0]</td>
		<td>$peg[1]</td>
        <td>$jo[0]</td>
		<td>$jo[1]</td>
		<td>$ket</td>
        <td align=center><a href=batal.php?id=$data[0] ><img src=hapus.png border=0 /></a></td>
      </tr>");
	  $z++;
	  }
	  ?>
        </table></td>
      </tr>
  </table>	</td>
	</tr>
	<?php

	}
	?>
	<tr>
	<td align="left" valign="top">

	<?php

	$q5a=mysqli_query($mysqli,"Select count(*) from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j  where eselon='IIVA' and (jabatan like '%kecamatan%' or jabatan like '%kelurahan%') and jabatan not like '%UPTD%'   ");
$a4w=mysqli_fetch_array($q5a);
if($a4w[0]>0)
{

$q=mysqli_query($mysqli,"Select id_mutjab,mutasi_jabatan.id_pegawai,mutasi_jabatan.id_j,eselon from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IIVA' and (jabatan like '%kecamatan%' or jabatan like '%kelurahan%') and jabatan not like '%UPTD%'  ");
?>

    <a href="pegawai.php?cekr=1&s=IVA&ket=w">Eselon IV A Wilayah</a> </br></br>
    <table width="1000" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#666666">
      <tr>
        <td>

		<table width="1000" border="0" cellpadding="5" cellspacing="0" bordercolor="#666666">
          <tr>
            <td bgcolor="#666666"><span class="style1">NO</span></td>
            <td bgcolor="#666666"><span class="style1">Nama</span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan Sebelum </span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan</span></td>
			<td bgcolor="#666666"><span class="style1">Eselonering</span></td>
            <td bgcolor="#666666"><span class="style1">Keterangan</span></td>
            <td bgcolor="#666666"><div align="center" class="style1">Batalakan</div></td>
          </tr>
          <?php
	  $z=1;
	  while($data=mysqli_fetch_array($q))
	  {
	  if($z%2==1)
	  echo("<tr>");
	  else
	  echo("<tr bgcolor=#f0f0f0>");

	   $qcau=mysqli_query($mysqli,"select count(*) from pegawai where id_pegawai=$data[1] and id_j>0");
	  $cau=mysqli_fetch_array($qcau);
	  if($cau[0]>0)
	  $qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] and id_kategori_sk=10 order by tgl_sk desc");
	  else
	  $qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1]  order by tgl_sk desc");

	 // echo("select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] order by tgl_sk desc");
	  $peg=mysqli_fetch_array($qp);


	  $qj=mysqli_query($mysqli,"select jabatan,eselon from jabatan where id_j=$data[2]");
	  $jo=mysqli_fetch_array($qj);

	   if("$peg[2]"=="$jo[1]")
	   {
	   if("$peg[1]"=="$jo[0]")
	   $ket="Tetap";
	   else
	   $ket="Rotasi";

	   }
	   else
	   $ket="Promosi";

	  if($peg[1]=='-')
	  $peg[1]=("Pelaksana");
      echo("
        <td>$z</td>
        <td nowrap>$peg[0]</td>
		<td>$peg[1]</td>
        <td>$jo[0]</td>
		<td>$jo[1]</td>
		<td>$ket</td>
        <td align=center><a href=batal.php?id=$data[0] ><img src=hapus.png border=0 /></a></td>
      </tr>");
	  $z++;
	  }
	  ?>
        </table></td>
      </tr>
  </table>	</td>
	</tr>
		<?php

	}
	?>
	<tr>
	<TD align="left" valign="top">

	<?php

	//$q6a=mysqli_query($mysqli,"Select count(*) from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IVB' and (jabatan like '%kecamatan%' or jabatan like '%kelurahan%') and jabatan not like '%UPTD%'  ");
	$q6a=mysqli_query($mysqli,"Select count(*) from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IVB'   ");
$b4w=mysqli_fetch_array($q6a);
if($b4w[0]>0)
{

$q=mysqli_query($mysqli,"Select id_mutjab,mutasi_jabatan.id_pegawai,mutasi_jabatan.id_j,eselon from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IVB' and (jabatan like '%kecamatan%' or jabatan like '%kelurahan%') and jabatan not like '%UPTD%'  ");
?>

    <a href="pegawai.php?cekr=1&s=IVB&ket=w">Eselon IV B</a> </br>
  </br>
  <table width="1000" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#666666">
      <tr>
        <td>

		<table width="1000" border="0" cellpadding="5" cellspacing="0" bordercolor="#666666">
          <tr>
            <td bgcolor="#666666"><span class="style1">NO</span></td>
            <td bgcolor="#666666"><span class="style1">Nama</span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan Sebelum </span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan</span></td>
			<td bgcolor="#666666"><span class="style1">Eselonering</span></td>
            <td bgcolor="#666666"><span class="style1">Keterangan</span></td>
            <td bgcolor="#666666"><div align="center" class="style1">Batalakan</div></td>
          </tr>
          <?php
	  $z=1;
	  while($data=mysqli_fetch_array($q))
	  {
	  if($z%2==1)
	  echo("<tr>");
	  else
	  echo("<tr bgcolor=#f0f0f0>");

	  $qcau=mysqli_query($mysqli,"select count(*) from pegawai where id_pegawai=$data[1] and id_j>0");
	  $cau=mysqli_fetch_array($qcau);
	  if($cau[0]>0)
	  $qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] and id_kategori_sk=10 order by tgl_sk desc");
	  else
$qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] order by tgl_sk desc");

	 // echo("select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] order by tgl_sk desc");
	  $peg=mysqli_fetch_array($qp);


	  $qj=mysqli_query($mysqli,"select jabatan,eselon from jabatan where id_j=$data[2]");
	  $jo=mysqli_fetch_array($qj);

	   if("$peg[2]"=="$jo[1]")
	   {
	   if("$peg[1]"=="$jo[0]")
	   $ket="Tetap";
	   else
	   $ket="Rotasi";

	   }
	   else
	   $ket="Promosi";

	  if($peg[1]=='-' or $peg[1]==NULL)
	  $peg[1]=("Pelaksana");
      echo("
        <td>$z</td>
        <td nowrap>$peg[0]</td>
		<td>$peg[1]</td>
        <td>$jo[0]</td>
		<td>$jo[1]</td>
		<td>$ket</td>
        <td align=center><a href=batal.php?id=$data[0] ><img src=hapus.png border=0 /></a></td>
      </tr>");
	  $z++;
	  }
	  ?>
        </table></td>
      </tr>
  </table>  </TD>
  </tr>
  <?php

	}
	?>
<tr>
<td align="left" valign="top">
  <?php

	$q7a=mysqli_query($mysqli,"Select count(*) from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IIVA' and jabatan like '%UPTD%'  ");
$a4u=mysqli_fetch_array($q7a);
if($a4u[0]>0)
{

$q=mysqli_query($mysqli,"Select id_mutjab,mutasi_jabatan.id_pegawai,mutasi_jabatan.id_j,eselon from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IVA' and jabatan like '%UPTD%'  ");
?>

  <a href="pegawai.php?cekr=1&s=IVA&ket=u">Eselon IV A UPTD </a></br>
  </br>
  <table width="1000" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#666666">
      <tr>
        <td>

		<table width="1000" border="0" cellpadding="5" cellspacing="0" bordercolor="#666666">
          <tr>
            <td bgcolor="#666666"><span class="style1">NO</span></td>
            <td bgcolor="#666666"><span class="style1">Nama</span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan Sebelum </span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan</span></td>
			<td bgcolor="#666666"><span class="style1">Eselonering</span></td>
            <td bgcolor="#666666"><span class="style1">Keterangan</span></td>
            <td bgcolor="#666666"><div align="center" class="style1">Batalakan</div></td>
          </tr>
          <?php
	  $z=1;
	  while($data=mysqli_fetch_array($q))
	  {
	  if($z%2==1)
	  echo("<tr>");
	  else
	  echo("<tr bgcolor=#f0f0f0>");

	   $qcau=mysqli_query($mysqli,"select count(*) from pegawai where id_pegawai=$data[1] and id_j>0");
	  $cau=mysqli_fetch_array($qcau);
	  if($cau[0]>0)
	  {
	  $qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] and id_kategori_sk=10 order by tgl_sk desc");

	  }
	  else
	  $qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] order by tgl_sk desc");

	 // echo("select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] order by tgl_sk desc");
	  $peg=mysqli_fetch_array($qp);


	  $qj=mysqli_query($mysqli,"select jabatan,eselon from jabatan where id_j=$data[2]");
	  $jo=mysqli_fetch_array($qj);

	   if("$peg[2]"=="$jo[1]")
	   {
	   if("$peg[1]"=="$jo[0]")
	   $ket="Tetap";
	   else
	   $ket="Rotasi";

	   }
	   else
	   $ket="Promosi";

	  if($peg[1]=='-')
	  $peg[1]=("Pelaksana");
      echo("
        <td>$z</td>
        <td nowrap>$peg[0]</td>
		<td>$peg[1]</td>
        <td>$jo[0]</td>
		<td>$jo[1]</td>
		<td>$ket</td>
        <td align=center><a href=batal.php?id=$data[0] ><img src=hapus.png border=0 /></a></td>
      </tr>");
	  $z++;
	  }
	  ?>
        </table></td>
      </tr>
  </table>  </td>
  </tr>
  <?php

	}
	?>
  <tr>
  <td align="left" valign="top">
  <?php

	$q8a=mysqli_query($mysqli,"Select count(*) from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IIVB' and jabatan like '%UPTD%'  ");
$b4u=mysqli_fetch_array($q8a);
if($b4u[0]>0)
{

$q=mysqli_query($mysqli,"Select id_mutjab,mutasi_jabatan.id_pegawai,mutasi_jabatan.id_j,eselon from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='IIVB' and jabatan like '%UPTD%'  ");
?>

  <a href="pegawai.php?cekr=1&s=IVB&ket=u">Eselon IV B UPTD</a> </br>
  </br>
  <table width="1000" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#666666">
      <tr>
        <td>

		<table width="1000" border="0" cellpadding="5" cellspacing="0" bordercolor="#666666">
          <tr>
            <td bgcolor="#666666"><span class="style1">NO</span></td>
            <td bgcolor="#666666"><span class="style1">Nama</span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan Sebelum </span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan</span></td>
			<td bgcolor="#666666"><span class="style1">Eselonering</span></td>
            <td bgcolor="#666666"><span class="style1">Keterangan</span></td>
            <td bgcolor="#666666"><div align="center" class="style1">Batalakan</div></td>
          </tr>
          <?php
	  $z=1;
	  while($data=mysqli_fetch_array($q))
	  {
	  if($z%2==1)
	  echo("<tr>");
	  else
	  echo("<tr bgcolor=#f0f0f0>");

	   $qcau=mysqli_query($mysqli,"select count(*) from pegawai where id_pegawai=$data[1] and id_j>0");
	  $cau=mysqli_fetch_array($qcau);
	  if($cau[0]>0)
	  $qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] and id_kategori_sk=10 order by tgl_sk desc");
	  else
	  $qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] order by tgl_sk desc");

	 // echo("select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] order by tgl_sk desc");
	  $peg=mysqli_fetch_array($qp);


	  $qj=mysqli_query($mysqli,"select jabatan,eselon from jabatan where id_j=$data[2]");
	  $jo=mysqli_fetch_array($qj);

	   if("$peg[2]"=="$jo[1]")
	   {
	   if("$peg[1]"=="$jo[0]")
	   $ket="Tetap";
	   else
	   $ket="Rotasi";

	   }
	   else
	   $ket="Promosi";

	  if($peg[1]=='-')
	  $peg[1]=("Pelaksana");
      echo("
        <td>$z</td>
        <td nowrap>$peg[0]</td>
		<td>$peg[1]</td>
        <td>$jo[0]</td>
		<td>$jo[1]</td>
		<td>$ket</td>
        <td align=center><a href=batal.php?id=$data[0] ><img src=hapus.png border=0 /></a></td>
      </tr>");
	  $z++;
	  }
	  ?>
        </table></td>
      </tr>
  </table>  </td>
  </tr>
  	<?php

	}
	?>
  <tr>
  <td align="left" valign="top">
   <?php

	$q9a=mysqli_query($mysqli,"Select count(*) from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j where eselon='V'  ");
$e5=mysqli_fetch_array($q9a);
if($e5[0]>0)
{

$q=mysqli_query($mysqli,"Select id_mutjab,mutasi_jabatan.id_pegawai,mutasi_jabatan.id_j,jabatan.eselon,nama from mutasi_jabatan inner join jabatan on jabatan.id_j=mutasi_jabatan.id_j inner join pegawai on pegawai.id_pegawai=mutasi_jabatan.id_pegawai where jabatan.eselon='V' ");
?>

   <a href="pegawai.php?cekr=1&s=V&ket=0">NO SK Eselon V</a> </br>
  </br>
<table width="1000" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#666666">
      <tr>
        <td>

		<table width="1000" border="0" cellpadding="5" cellspacing="0" bordercolor="#666666">
          <tr>
            <td bgcolor="#666666"><span class="style1">NO</span></td>
            <td bgcolor="#666666"><span class="style1">Nama</span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan Sebelum </span></td>
            <td bgcolor="#666666"><span class="style1">Jabatan</span></td>
			<td bgcolor="#666666"><span class="style1">Eselonering</span></td>
            <td bgcolor="#666666"><span class="style1">Keterangan</span></td>
            <td bgcolor="#666666"><div align="center" class="style1">Batalakan</div></td>
          </tr>
          <?php
	  $z=1;
	  while($data=mysqli_fetch_array($q))
	  {
	  if($z%2==1)
	  echo("<tr>");
	  else
	  echo("<tr bgcolor=#f0f0f0>");

	   $qcau=mysqli_query($mysqli,"select count(*) from pegawai where id_pegawai=$data[1] and id_j>0");
	  $cau=mysqli_fetch_array($qcau);
	  if($cau[0]>0)
	  $qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] and id_kategori_sk=10 order by tgl_sk desc");
	  else
	  $qp=mysqli_query($mysqli,"select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] and id_kategori_sk=10 order by tgl_sk desc");

	 // echo("select nama,riwayat_mutasi_kerja.jabatan,riwayat_mutasi_kerja.eselonering from pegawai inner join sk on pegawai.id_pegawai=sk.id_pegawai inner join riwayat_mutasi_kerja on riwayat_mutasi_kerja.id_sk=sk.id_sk where sk.id_pegawai=$data[1] order by tgl_sk desc");
	  $peg=mysqli_fetch_array($qp);


	  $qj=mysqli_query($mysqli,"select jabatan,eselon from jabatan where id_j=$data[2]");
	  $jo=mysqli_fetch_array($qj);

	   if("$peg[2]"=="$jo[1]")
	   {
	   if("$peg[1]"=="$jo[0]")
	   $ket="Tetap";
	   else
	   $ket="Rotasi";

	   }
	   else
	   $ket="Promosi";

	  if($peg[1]=='-')
	  $peg[1]=("Pelaksana");
      echo("
        <td>$z</td>
        <td nowrap>$data[4]</td>
		<td>$peg[1]</td>
        <td>$jo[0]</td>
		<td>$jo[1]</td>
		<td>$ket</td>
        <td align=center><a href=batal.php?id=$data[0] ><img src=hapus.png border=0 /></a></td>
      </tr>");
	  $z++;
	  }
	  ?>
        </table></td>
      </tr>
  </table>  </td>


  </tr>
  <?php

	}
	?>
  </table>

</form>
</body>
</html>
