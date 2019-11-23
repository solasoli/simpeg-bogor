<?php
ob_start();
include("koneksi.php");
extract($_POST);
$qrung =mysqli_query($link,"select * from ruangan where id=$ru");
$rung=mysqli_fetch_array($qrung);
?><style type="text/css">
<!--
body,td,th {
	font-family: Arial;
	font-size: 11px;
}
-->
</style>
<page>
 <BR />
<div align=center> PEMERINTAH KOTA BOGOR</div>
<div align=center> KARTU INVENTARIS RUANGAN</div>
<div align=center> HASIL INVENTARISASI TAHUN 2018</div>
<BR />
&nbsp;&nbsp;&nbsp;SKPD : SEKRETARIAT DPRD
<BR />&nbsp;&nbsp;
KABUPATEN / KOTA : KOTA BOGOR
<BR />&nbsp;&nbsp;
PROVINSI : JAWA BARAT
<BR />&nbsp;&nbsp;&nbsp;RUANGAN : <?php echo ("$rung[1] $rung[2]  $rung[3]"); ?> 
<BR />
<BR />
<table width="100%" cellpadding="15" cellspacing="0" border="1" align="center" style="font-size:5px !important; >
<TR>
    <th style="padding:5;">NO <BR /> URUT </th>
                  <th style="padding:10">NAMA BARANG</th>
                  <th style="padding:5">MERK MODEL</th>
                  <th style="padding:5">N0. SERI <BR> PABRIK</th>
                  <th style="padding:5"> UKURAN</th>
                  <th style="padding:5">TAHUN <br> PEMBUATAN<br> PEROLEHAN</th>
                  <th style="padding:5">NO KODE BARANG</th>
                   <th style="padding:5">JUMLAH <BR> BARANG <BR> REGISTER</th>
                    <th style="padding:5">PEROLEHAN <BR> HARGA <BR> BELI</th>
                        <th style="padding:5">KEADAAN <br>BARANG</th>
                        <th style="padding:5">KETERANGAN <br> MUTASI <br> DLL</th>
</TR>
<tbody style="padding:5">
<?php
$qir=mysqli_query($link,"select * from aset where id_ruangan=$ru");

  $i=1;
		  while($ir=mysqli_fetch_array($qir))
		  {
		  
		  $qb=mysqli_query($link,"select barang,kodebarang from kode_barang where id=$ir[1]");
		  $barang=mysqli_fetch_array($qb);
		  
		 $harga  = "Rp ".number_format($ir[5],0,',','.');
		  echo("   <tr style=padding:10 >
                  <td align=center >$i </td>
				  <td style=left-margin:10px !important;	 > &nbsp; $barang[0] &nbsp;  </td>
				    <td style=left-margin:10px !important;	 > &nbsp; $ir[7] &nbsp;  </td>
					 <td align=center	 > -  </td>
					  <td style=left-margin:10px !important;	 > &nbsp; $ir[8] &nbsp;  </td>
					     <td align=center > &nbsp; $ir[3] &nbsp;  </td>
						  <td align=center > &nbsp; $barang[1] &nbsp;  </td>
						    <td align=center > &nbsp; $ir[4] &nbsp;  </td>
							 <td align=left > &nbsp; $harga &nbsp;  </td>
							  <td align=left > &nbsp; $ir[6] &nbsp;  </td>
				  <td > </td> 
				  
                </tr>");
		  
		  $i++;
		  }
		  ?>
          </tbody>
</table>
<br><br><br><br><br>

<table cellpadding="55" align="center" cellspacing="0" border="0"  width="100%">
<tr>
<th align="center"   >
Mengetahui, <br> SEKRETARIS DPRD KOTA BOGOR
<br><br><br><br><br><br><br><br>
<?php

$qpro=mysqli_query($link,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama,nip_baru  from pegawai where id_j=3066");
$pro=mysqli_fetch_array($qpro);
echo("<u>$pro[0]</u><br>NIP $pro[1]")
?>
</th>
<th align="center" style="padding-left:200px;padding-right:200px;" >
KUASA RUANGAN
<br><br><br><br><br><br><br><br><br>
<?php

$qpro2=mysqli_query($link,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama,nip_baru  from ruangan inner join pegawai on pegawai.id_pegawai = ruangan.id_pegawai where ruangan.id=$ru");
$pr=mysqli_fetch_array($qpro2);
echo("<u>$pr[0]</u><br>NIP $pr[1]")
?>
</th>
<th align="center">
Bogor , <?php echo $tgl ?>
<br>
Pengurus Barang Unit, <br> SEKRETARIAT DPRD KOTA BOGOR :
<br><br><br><br><br><br><br><br><br>

<?php

$qpeg=mysqli_query($link,"select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama,nip_baru  from pegawai where id_pegawai=1675");
$peg=mysqli_fetch_array($qpeg);
echo("<u>$peg[0]</u><br>NIP $peg[1]")
?>
</th>

</tr>
</table>

</page>


<?php
    $content = ob_get_clean();

    require_once('html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 5);
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		//attachment
        //$html2pdf->Output('bookmark.pdf',F);
		//inline
		$html2pdf->Output('kir.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>