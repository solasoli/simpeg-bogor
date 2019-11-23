<html>
<head>
<title>Untitled Document</title>
<style type="text/css">
<!--
body,td,th {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 11px;
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
.style2 {color: #000000}
.putih {
	color: #FFFFFF;
}
-->
</style>
</head>

<body>
  <?
include("konek.php");


$q=mysql_query("select nama,nip_baru,nip_lama,tgl_lahir,pangkat_gol,id_next,id_j from pegawai where id_next>0 order by nama");

?>

<p>&nbsp;
</p>
<p> 
<table width="758" border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" nowrap>LAMPIRAN KEPUTUSAN WALIKOTA BOGOR</td>
  </tr>
  <tr>
    <td width="84" align="left" valign="top">&nbsp;</td>
    <td width="56" align="left" valign="top">Nomor</td>
    <td width="588" align="left" valign="top" nowrap>:&nbsp;&nbsp;<? echo($nsk); ?></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">Tanggal</td>
    <td align="left" valign="top">:&nbsp;&nbsp;<? echo($t1); ?></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
    <td align="left" valign="top">Tentang</td>
    <td align="left" valign="top" nowrap>:&nbsp;&nbsp;Pengangkatan dan Alih Tugas dalam Jabatan Struktural di Lingkungan Pemerintah Kota Bogor </td>
  </tr>
</table>
</p>
<br>
<table width="700" border="0" align="center" cellpadding="5" cellspacing="0">
   
  
  <tr>
    <td><table width="900" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
      <tr>
        <td><table width="1000" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#000000">
            <tr>
              <td width="23" rowspan="2" align="center" valign="top" bgcolor="#FFFFFF"><div align="center" class="style2">No</div></td>
              <td width="127" rowspan="2" bgcolor="#FFFFFF"><div align="center"><span class="style2">NAMA<BR>NIP<br>TANGGAL LAHIR</span></div></td>
              <td width="62" rowspan="2" align="center" valign="top" bgcolor="#FFFFFF"><div align="center"><span class="style2">PANGKAT<BR> 
                GOL RUANG</span></div></td>
              <td width="140" rowspan="2" align="center" valign="top" bgcolor="#FFFFFF"><div align="center"><span class="style2">JABATAN LAMA </span></div></td>
			   <td width="139" rowspan="2" align="center" valign="top" bgcolor="#FFFFFF"><div align="center"><span class="style2">JABATAN BARU </span></div></td>
			   <td width="68" rowspan="2" align="center" valign="top" bgcolor="#FFFFFF"><div align="center"><span class="style2">ESELON </span></div></td>
			    <td width="94" rowspan="2" align="center" valign="top" bgcolor="#FFFFFF"><div align="center"><span class="style2">TUNJANGAN<BR> JABATAN </span></div></td>
				<td colspan="2" align="center" valign="top" bgcolor="#FFFFFF"><div align="center"><span class="style2">BAPERJAKAT </span></div></td>
				<td width="110" rowspan="2" align="center" valign="top" bgcolor="#FFFFFF"><div align="center"><span class="style2">KETERANGAN</span></div></td>
            </tr>
            <tr>
              <td width="53" align="center" valign="top" bgcolor="#FFFFFF">Nomor</td>
              <td width="62" align="center" valign="top" bgcolor="#FFFFFF">Tanggal</td>
            </tr>
            <tr>
              <td align="center" valign="top" bgcolor="#FFFFFF">1</td>
              <td bgcolor="#FFFFFF"><div align="center">2</div></td>
              <td align="center" valign="top" bgcolor="#FFFFFF">3</td>
              <td align="center" valign="top" bgcolor="#FFFFFF">4</td>
              <td align="center" valign="top" bgcolor="#FFFFFF">5</td>
              <td align="center" valign="top" bgcolor="#FFFFFF">6</td>
              <td align="center" valign="top" bgcolor="#FFFFFF">7</td>
              <td align="center" valign="top" bgcolor="#FFFFFF">8</td>
              <td align="center" valign="top" bgcolor="#FFFFFF">9</td>
              <td align="center" valign="top" bgcolor="#FFFFFF">10</td>
            </tr>
			
            <?
  $i=1;
  while($data=mysql_fetch_array($q))
  {
  
  $qj=mysql_query("select jabatan from jabatan where id_j=$data[6]");
  $j=mysql_fetch_array($qj);
 
 $qn=mysql_query("select jabatan,eselon,tunjangan from jabatan where id_j=$data[5]");
  $n=mysql_fetch_array($qn);
  
  if($j[0]==NULL)
  $j[0]="Staf Pelaksana";
  
  $tgl=substr($data[3],8,2);
  $bln=substr($data[3],5,2);
  $thn=substr($data[3],0,4);
  
  if($data[4]=='III/a')
  $pangkat="Penata Muda";
  elseif($data[4]=='III/b')
  $pangkat="Penata Muda Tk.I";
  elseif($data[4]=='III/c')
  $pangkat="Penata";
  elseif($data[4]=='III/d')
  $pangkat="Penata Tk.I";
  elseif($data[4]=='IV/a')
  $pangkat="Pembina";
  elseif($data[4]=='IV/b')
  $pangkat="Pembina Tk.I";
  elseif($data[4]=='IV/c')
  $pangkat="Pembina Utama Muda";
  elseif($data[4]=='IV/d')
  $pangkat="Pembina Utama Madya";
 
  
  echo("<tr>
    <td valign=top align=center>$i</td>
    <td valign=top align=left>$data[0]<br> $data[1]&nbsp; <br> $tgl-$bln-$thn&nbsp;</td>
    <td valign=top align=center>$pangkat<br>$data[4]</td>
    <td valign=top align=left><br>$j[0]</td>
	<td valign=top align=left>$n[0]</td>
    <td valign=top align=center>$n[1]</td>
    <td valign=top align=center>$n[2]</td>
    <td valign=top align=left>$nb</td>
	<td valign=top align=left> $t2</td>
    <td valign=top align=left>&nbsp;<br><br><br><br></td>
	
	
  </tr>
  ");	
  $i++;
  
  }
  
  ?>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
