<?php
include("konek.php");
extract($_GET);
$bulan=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
$qunit=mysqli_query($mysqli,"select nama_baru from unit_kerja where id_unit_kerja=$idunit");
$unit=mysqli_fetch_array($qunit);
$qbos=mysqli_query($mysqli,"select concat(gelar_depan,' ',nama,' ',gelar_belakang),nip_baru,jabatan.jabatan from jabatan inner join pegawai on pegawai.id_j=jabatan.id_j where id_unit_kerja=$idunit order by jabatan.eselon limit 0,1");
$bos=mysqli_fetch_array($qbos);
$q=mysqli_query($mysqli,"CALL PRCD_ABSENSI_HARIAN_PEGAWAI_UNIT($bln, $thn, $idunit)");
ob_start();
?>
<br />
<div align="center">Rekapitulasi Absensi Pegawai <?php echo $unit[0]; ?> Bulan <?php echo ("$bulan[$bln] ".date("Y")); ?> </div>
<table width="88%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#000">
    <tr>
        <td rowspan="2">No</td>
        <td rowspan="2">Nama</td>
        <td colspan="31" align="center">Tanggal</td>
        <td colspan="8" style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)">&nbsp;Rekap Per Status</td>
    </tr>
    <tr>
        <td style="padding:5;">1</td>
        <td style="padding:5;">2</td>
        <td style="padding:5;">3</td>
        <td style="padding:5;">4</td>
        <td style="padding:5;">5</td>
        <td style="padding:5;">6</td>
        <td style="padding:5;">7</td>
        <td style="padding:5;">8</td>
        <td style="padding:5;">9</td>
        <td style="padding:5;">10</td>
        <td style="padding:5;">11</td>
        <td style="padding:5;">12</td>
        <td style="padding:5;">13</td>
        <td style="padding:5;">14</td>
        <td style="padding:5;">15</td>
        <td style="padding:5;">16</td>
        <td style="padding:5;">17</td>
        <td style="padding:5;">18</td>
        <td style="padding:5;">19</td>
        <td style="padding:5;">20</td>
        <td style="padding:5;">21</td>
        <td style="padding:5;">22</td>
        <td style="padding:5;">23</td>
        <td style="padding:5;">24</td>
        <td style="padding:5;">25</td>
        <td style="padding:5;">26</td>
        <td style="padding:5;">27</td>
        <td style="padding:5;">28</td>
        <td style="padding:5;">29</td>
        <td style="padding:5;">30</td>
        <td style="padding:5;">31</td>
        <td>&nbsp;JML&nbsp;</td><td>&nbsp;&nbsp;C&nbsp;&nbsp;</td><td>&nbsp;DL&nbsp;</td>
        <td>&nbsp;DI&nbsp;</td><td>&nbsp;&nbsp;I&nbsp;&nbsp;</td><td>&nbsp;S&nbsp;</td><td>&nbsp;TK&nbsp;</td><td>&nbsp;TA&nbsp;</td>
    </tr>

    <?php
    $i=1;
    while($data=mysqli_fetch_array($q))
    {

        echo("<tr>
<td>$i</td>
<td>$data[1]</td>");
        for($j=3;$j<42;$j++)
            echo("<td>$data[$j]</td>");
        echo("</tr>");

        $i++;
    }

    ?>
</table>
<table  width="100%" border="0" align="center" cellpadding="5" cellspacing="0" bordercolor="#000">
    <tr>
        <td>
            <?php for($i=0;$i<120;$i++){
                echo "&nbsp;";
            }
            ?>
        </td>
        <td align="center"><br><br>
            <?php
            $kepala = explode(",",$bos[2]);
            echo $kepala[0]."<br>".$kepala[1] ?>
            <br><br><br><br><br><br><br><br><br>
            <?php echo "<u>".$bos[0]."</u><br>".$bos[1] ?>

        </td>
    </tr>
</table>

<?php
$content = ob_get_clean();
require_once('html2pdf.class.php');
try
{
    $html2pdf = new HTML2PDF('L', 'Legal', 'fr', true, 'UTF-8',10);
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    //attachment
    //$html2pdf->Output('bookmark.pdf',F);
    //inline
    $html2pdf->Output('laporanabsensi.pdf');
}
catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>
