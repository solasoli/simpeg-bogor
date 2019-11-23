<?php
ob_start();
include("koneksi.php");
extract($_POST);

?><style type="text/css">
<!--
body,td,th {
	font-family: Arial;
	font-size: 9px;
}
-->
</style>
<page>
 <BR />
<div align=center> PEMERINTAH KOTA BOGOR</div>
<div align=center> KARTU INVENTARIS BARANG</div>
<div align=center> SEKRETARIAT DPRD KOTA BOGOR</div>

<BR />
<BR />
  <?php

extract($_POST);
extract($_GET);

$qir=mysqli_query($link,"select * from aset ");

?>
    <table align="center"  width="100%" cellpadding="15" border="1" cellspacing="0">
            
                <tr >
                  <td >No </td>
                   <td>Kode Barang</td>
                  <td>Nama Barang</td>
                       <td>No Register</td>
                  <td>Merk  Tipe</td>
                  
                  <td>Ukuran / CC</td>
                       <td>Bahan</td>
                  <td>Tahun Pembelian</td>
                  
                   <td>No Pabrik</td>
                    <td>No Rangka</td>
                     <td>No Mesin</td>
                      <td>No Polisi</td>
                       <td>No BPKB</td>
                 
                   <td>Jumlah Barang</td>
                    <td>Harga Total</td>
                        <td>Keterangan</td>
                         
                </tr>
                
            <?php
		  
		  $qir=mysqli_query($link,"select * from aset ");
		  $i=1;
		  $totq=0;
$jum = 0;
		  while($ir=mysqli_fetch_array($qir))
		  {
		  
		  $qb=mysqli_query($link,"select barang,kodebarang from kode_barang where id=$ir[1]");
		  $barang=mysqli_fetch_array($qb);
		  $totq=$totq+$ir[4];
		  $jum=$jum+$ir[5];
		  
		  $harga  = "Rp ".number_format($ir[5],0,',','.');
		  		  $bleh  = "Rp ".number_format($jum,0,',','.');
		 echo("   <tr>
                  <td>$i 
				   </td>
				     <td>$barang[1]</td>
					  
                  <td>$barang[0]</td>
                  <td>$ir[10]</td>
				  <td>$ir[7]</td>
				  
				   <td>$ir[9]</td>
                
                  <td>$ir[8]</td>
                  <td>$ir[3]</td>
                
               
				   
				 
				   <td>$ir[11]</td>
				   <td>$ir[12]</td>
				   <td>$ir[13]</td>
				   <td>$ir[14]</td>
				    <td>$ir[15]</td>
				   
				   
				       <td>$ir[4]</td>
				   
                    <td>$harga</td>
                        <td>$ir[17]</td>
                         
                </tr>");
				
		  $i++;
		  }
	
		  ?>
                <tr><td colspan=13 align="right">  Total : </td><td><?php echo $totq; ?> </td><td><?php echo $bleh; ?> </td><td> </td><td> </td></tr>
                	 
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

</th>
<th align="center">
Bogor , <? echo $tgl; ?>
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
        $html2pdf = new HTML2PDF('L', 'A4', 'fr', true, 'UTF-8', 0);
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