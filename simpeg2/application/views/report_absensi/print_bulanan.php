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


<div class="container">
    <div class="grid">
        <div class="row"> 
            <div class="span12">
                <div class="span2">
                    <div class="input-control select" style="width: 100%;">
                        <?php 
						$bulan=array('','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
						
						 ?>
                    </div>
                </div>
                <div class="span2">
                <br />
                    <div class="input-control select" style="width: 100%;" align="center">
                    Rekapitulasi Absensi Bulan <?php echo $bulan[$bln]; echo (" Tahun $thn $uk"); 
					
					
					 ?>
                    </div>
                </div>
                <span class="span4">
                    <?php if (isset($list_skpd)): ?>
                        <div class="input-control select" style="width: 100%;">
                            <select id="ddFilterOpd" style="background-color: #e3c800;">
                                <?php foreach ($list_skpd as $ls): ?>
                                    <?php if($ls->id_unit_kerja == $idskpd): ?>
                                        <option value="<?php echo $ls->id_unit_kerja; ?>" selected><?php echo $ls->nama_baru; ?></option>
                                    <?php else: ?>
                                        <option value="<?php echo $ls->id_unit_kerja; ?>"><?php echo $ls->nama_baru; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>
                </span>
              
            </div>
        </div>
    </div>
    <div class="panel">
      
        <div class="panel-content">
            <table class="table bordered striped" id="lst_data" align="center" border="1" bordercolor="#000"  cellspacing="0">
                <thead style="border-bottom: solid #a4c400 2px;">
                <tr>
                    <th rowspan="2" style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79);border-left: 1px solid rgba(111, 111, 111, 0.79); padding:5;" >Tgl</th>
                    <th colspan="7" style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79);padding:5;">Ketidakhadiran</th>
                    <th rowspan="2" style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-top: 1px solid rgba(111, 111, 111, 0.79);padding:5;">Tidak Apel</th>
                    <th colspan="2" style="border-top: 1px solid rgba(111, 111, 111, 0.79);border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: 1px solid rgba(111, 111, 111, 0.79);padding:5;">Persentase</th>
                </tr>
                <tr>
                    <th style="padding:5;">Cuti</th>
                    <th style="padding:5;">Dinas Luar</th>
                    <th style="padding:5;">Dispensasi</th>
                    <th style="padding:5;">Ijin</th>
                    <th style="padding:5;">Sakit</th>
                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);padding:5;">Tanpa Keterangan</th>
                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);padding:5;">Total</th>
                    <th style="padding:5;">Kehadiran</th>
                    <th style="border-right: 1px solid rgba(111, 111, 111, 0.79);padding:5;">Apel</th>
                </tr>
                </thead>
                <?php if (sizeof($rekap1) > 0): ?>
                    <?php if($rekap1!=''): ?>
                        <?php foreach ($rekap1 as $lsdata): ?>
                            <tr>
                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->TANGGAL ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->C ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->DL ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->DI ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->I ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->S ?></td>
                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->TK ?></td>
                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->TDK_HADIR ?></td>
                                <td style="border-right: 1px solid rgba(111, 111, 111, 0.79);border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->TDK_APEL ?></td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->PERSEN_KEHADIRAN?>%</td>
                                <td style="border-bottom: solid #666666 1px;text-align: center"><?php echo $lsdata->PERSEN_APEL?> %</td>
                            </tr>
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
        </div>
    </div>
</div>
<div>
<?php 
echo("<br>");echo("<br>");
echo ("<div align=center>$jabatan</div>");
echo("<br>");echo("<br>");echo("<br>");echo("<br>");echo("<br>");
echo ("<div align=center>$bos</div>");
echo ("<div align=center>$nip</div>");;
?>

</div>
<?php
    $content = ob_get_clean();
    try
    {
        $html2pdf = new HTML2PDF('P', 'Letter', 'fr', true, 'UTF-8', 0);
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
       
        $html2pdf->Output('laporan.pdf');
    }catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>