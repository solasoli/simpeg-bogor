<?php
ob_start();
?>
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" style="font-size: 12pt">

<table  border="1" align="center" cellpadding="5" cellspacing="0">
 
    <?php 
	  include("konek.php");
  extract($_GET);
	$qdet=mysqli_query($mysqli,"select nama,nip_baru from  pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai where id_unit_kerja=4198 order by nama");
	
	
	?>
  
  <tr>
    <td style="padding:5px;">No</td>
    <td style="padding:5px;">Nama</td>
    <td style="padding:5px;">NIP</td>
  
  </tr>
  <?php

	
	$t=1;
	$sob=0;
	while($det=mysqli_fetch_array($qdet))
	{
		
		echo("  <tr >
      <td align=center style=padding-bottom:10px;>$t</td>
      <td nowrap style=padding-right:10px;padding-bottom:10px;>$det[0]</td>
      <td style=padding-bottom:10px;>$det[1]</td>
      
    </tr>");
	$t++;
		}

	?>
 
  </table>
</page>


<?php
    $content = ob_get_clean();

    require_once('html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 0);
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		//attachment
        //$html2pdf->Output('bookmark.pdf',F);
		//inline
		$html2pdf->Output('contoh.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>