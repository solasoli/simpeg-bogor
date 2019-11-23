<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    require_once APPPATH.'/third_party/html2pdf.class.php';
    ob_start();
	?>
<link rel="stylesheet" href="<?php echo base_url()?>assets/metro/css/metro-bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url()?>assets/metro/css/metro-bootstrap-responsive.css" >
    <link rel="stylesheet" href="<?php echo base_url()?>css/chosen.css">
	<link rel="stylesheet" href="<?php echo base_url()?>css/chosen-bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url()?>css/main.css">
  
   <br />
                     <div align="center">Rekapitulasi Absensi <?php echo $uk; ?> Per Pegawai Bulan <?php
					 
					 $bulan=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
					  echo $bulan[$bln]; echo (" Tahun $thn <br>"); ?></div><br />
                    

            <table border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#000" class="table bordered striped" id="lst_data">
                <thead style="border-bottom: solid #a4c400 2px;">
                <tr>
                    <th rowspan="2" style="width: 20px;border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79); padding:5;">No</th>
                    <th rowspan="2" style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79);padding:5;">NAMA</th>
                    <th colspan="31" style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79);padding:5;">Tanggal</th>
                    <th colspan="8" style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79)">&nbsp;Rekap Per Status</th>
                </tr>
                <tr>
                    <th style="padding:5">1</th><th style="padding:5">2</th><th style="padding:5">3</th><th style="padding:5">4</th><th style="padding:5">5</th><th style="padding:5">6</th>
                    <th style="padding:5">7</th><th style="padding:5">8</th><th style="padding:5">9</th><th style="padding:5">10</th><th style="padding:5">11</th><th style="padding:5">12</th>
                    <th style="padding:5">13</th><th style="padding:5">14</th><th style="padding:5">15</th><th style="padding:5">16</th><th style="padding:5">17</th><th style="padding:5">18</th>
                    <th style="padding:5">19</th><th style="padding:5">20</th><th style="padding:5">21</th><th style="padding:5">22</th><th style="padding:5">23</th><th style="padding:5">24</th>
                    <th style="padding:5">25</th><th style="padding:5">26</th><th style="padding:5">27</th><th style="padding:5">28</th><th style="padding:5">29</th><th style="padding:5">30</th>
                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);padding:3">31</th><th>&nbsp;JML&nbsp;</th><th>&nbsp;&nbsp;C&nbsp;&nbsp;</th><th>&nbsp;DL&nbsp;</th>
                    <th>&nbsp;DI&nbsp;</th><th>&nbsp;&nbsp;I&nbsp;&nbsp;</th><th>&nbsp;S&nbsp;</th><th>&nbsp;TK&nbsp;</th><th>&nbsp;TA&nbsp;</th>
                </tr>
                </thead>
                <?php if (sizeof($rekap2) > 0): ?>
                    <?php $i = 1; ?>
                    <?php if($rekap2!=''): ?>
                        <?php foreach ($rekap2 as $lsdata): ?>
                            <tr>
                                <td style="border-bottom: solid #666666 1px;" align="center"><?php echo $i; ?></td>
                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;"><?php echo $lsdata->nama ?><br><?php echo $lsdata->nip_baru ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_1 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_2 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_3 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_4 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_5 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_6 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_7 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_8 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_9 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_10 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_11 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_12 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_13 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_14 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_15 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_16 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_17 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_18 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_19 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_20 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_21 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_22 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_23 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_24 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_25 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_26 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_27 ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->_28 ?></td>
                            <?php if(isset($lsdata->_29)): ?>
                                <td style="border-bottom: solid #666666 1px;text-align: center">
                                    <?php echo $lsdata->_29 ?>
                                </td>
                            <?php endif; ?>
                            <?php if(isset($lsdata->_30)): ?>
                                <td style="border-bottom: solid #666666 1px;text-align: center">
                                    <?php echo $lsdata->_30 ?>
                                </td>
                            <?php endif; ?>
                            <?php if(isset($lsdata->_31)): ?>
                                <td style="border-bottom: solid #666666 1px;text-align: center">
                                     <?php echo $lsdata->_31 ?>
                                </td>
                            <?php endif; ?>
                                <td style="border-bottom: solid #666666 1px;text-align: center;border-left: 1px solid rgba(111, 111, 111, 0.79);"><?php echo $lsdata->jml_hari ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->C ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->DL ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->DI ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->I ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->S ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->TK ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->TA ?></td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="error">
                            <td colspan="9"><i>Tidak ada data</i></td>
                        </tr>
                    <?php endif; ?>
                <?php else: ?>
                    <tr class="error">
                        <td colspan="9"><i>Tidak ada data</i></td>
                    </tr>
                <?php endif; ?>
            </table>
    <?php 
echo("<br>");echo("<br>");
echo("<br>");
echo ("<div align=center>$jabatan</div>");
echo("<br>");echo("<br>");echo("<br>");echo("<br>");echo("<br>");
echo ("<div align=center>$bos</div>");
echo ("<div align=center>$nip</div>");;
?>

<?php
    $content = ob_get_clean();
    try
    {
        $html2pdf = new HTML2PDF('L', 'Legal', 'fr', true, 'UTF-8', 10);
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
       
        $html2pdf->Output('laporan3.pdf');
    }catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>