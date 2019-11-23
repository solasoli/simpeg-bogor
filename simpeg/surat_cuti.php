<?php
    ob_start();
?>

<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" style="font-size: 12pt">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="70%">&nbsp;</td>
        <td>Bogor,<u> <?php echo @$tgl_cuti; ?></u></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>Kepada</td>
      </tr>
      <tr>
        <td align="right">Yth </td>
        <td>&nbsp;&nbsp; Kepala BKPSDA Kota Bogor</td>
      </tr>
      <tr>
        <td align="left">Perihal : Permohonon Cuti <?php echo @$jenis_cuti; ?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td>&nbsp;&nbsp; Di -</td>
      </tr>
      <tr>
        <td align="left">&nbsp;</td>
        <td>&nbsp;&nbsp; Bogor</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center">Yang bertanda tangan di bawah ini:</td>
  </tr>
  <tr>
    <td><table width="80%" border="0" align="center" cellpadding="0" cellspacing="0" >
      <tr >
        <td width="19%" align="left" valign="bottom">Nama</td>
        <td width="1%" align="left" valign="bottom">:</td>
        <td width="80%" align="left" valign="bottom"><?php echo @$nama; ?></td>
      </tr>
      <tr>
        <td align="left" valign="bottom" style="padding-top:10px;">NIP</td>
        <td align="left" valign="bottom">:</td>
        <td align="left" valign="bottom"><?php echo @$nip; ?></td>
      </tr>
      <tr>
        <td align="left" valign="bottom" style="padding-top:10px;">Pangkat / Gol.Ruang</td>
        <td align="left" valign="bottom">:</td>
        <td align="left" valign="bottom"><?php echo @$gol; ?></td>
      </tr>
      <tr>
        <td align="left" valign="bottom" style="padding-top:10px;">Jabatan</td>
        <td align="left" valign="bottom">:</td>
        <td align="left" valign="bottom"><?php echo @$jabatan; ?></td>
      </tr>
      <tr>
        <td align="left" valign="bottom" style="padding-top:10px;">Unit Kerja</td>
        <td align="left" valign="bottom">:</td>
        <td align="left" valign="bottom"><?php echo @$unor; ?></td>
      </tr>
      <tr>
        <td align="left" valign="bottom" style="padding-top:10px;">&nbsp;</td>
        <td align="left" valign="bottom">&nbsp;</td>
        <td align="left" valign="bottom">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="bottom" style="padding-top:10px;">Dengan ini mengajukan permohonan cuti tahunan  selama <?php echo @$hari; ?> hari Kerja terhitung mulai tanggal <?php echo $tmtawal; ?> s.d. <?php echo $tmtakhir; ?>, Selama menjalankan cuti alamat saya di <?php echo $alamat; ?> Nomor telp yang bisa dihubungi <?php echo $telp; ?>.</td>
        </tr>
      <tr>
        <td colspan="3" align="left" valign="bottom" style="padding-top:10px;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="bottom" style="padding-top:10px;">Demikian permohonan ini saya buat untuk dapat dipertimbangkan sebagaimana mestinya.</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="bottom" style="padding-top:10px;">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="bottom" style="padding-top:10px;"><table width="100%" border="1" cellspacing="0" cellpadding="0" bordercolor="#000">
          <tr>
            <td width="62%">Catatan Kepegawaian</td>
            <td width="38%" align="center">Catatan Pertimbangan</td>
          </tr>
          <tr>
            <td>Cuti yang telah diambil dalam tahun yang bersangkutan :<br />
            <ol>
            <li> Cuti Tahunan </li>
<li> Cuti Besar </li>
<li> Cuti Sakit </li>
<li> Cuti Bersalin </li>
<li> Cuti Karena Alasan Penting </li>
<li> Keterangan lain-lain </li>
</ol>
            </td>
            <td align="center" valign="top" style="padding-top:10px;">Atasan Langsung<br />
            <?php echo @$jabatanatasan; ?><br /><br /><br /><br /><br /><br /><u><b><?php echo @$nama_atasan; ?> </b></u><br /><?php echo @$pangkat_atasan ?><br />NIP <?php echo @$nip_atasan; ?></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td align="center"><p>Pejabat yang berwenang memberikan ijin cuti<br />  <?php echo @$jabatanatasan2; ?><br /><br /><br /><br /><br /><br /><u><b><?php echo @$nama_atasan2; ?> </b></u><br /><?php echo @$pangkat_atasan2 ?><br />NIP <?php echo @$nip_atasan2; ?></p>
             </td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</page>


<?php
$content = ob_get_clean();

require_once('html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('P', 'Legal', 'fr', true, 'UTF-8', 0);
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