<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH.'/third_party/html2pdf.class.php';
?>
    <page backtop="14mm" backbottom="10mm" backleft="10mm" backright="14mm" style="font-size: 11pt">
        <h4 style="text-align: center; line-height: 1.3;">Panduan Teknis Penggunaan <br>WebService SIMPEG Kota Bogor</h4>
        <?php
        if (isset($apps_list) and sizeof($apps_list) > 0){
            if ($apps_list != '') { ?>
                <table border="0" cellspacing="0" cellpadding="0" style="width: 100%; ">
                    <tr>
                        <td colspan="2" style="border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; padding: 10px;">
                            <strong>Informasi Aplikasi</strong>
                        </td>
                    </tr>
                    <?php foreach ($apps_list as $lsdata) { ?>
                        <tr>
                            <td style="width: 20%; border-left: 1px solid black;padding-left: 10px; padding-top: 5px;">Nama Aplikasi</td>
                            <td style="width: 80%; border-right: 1px solid black;"> : &nbsp; <?php echo $lsdata->nama_apps; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%; border-left: 1px solid black;padding-left: 10px; padding-top: 5px;">Platform</td>
                            <td style="width: 80%; border-right: 1px solid black;"> : &nbsp; <?php echo $lsdata->platform; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%; border-left: 1px solid black;padding-left: 10px; padding-top: 5px;">Owner</td>
                            <td style="width: 80%; border-right: 1px solid black;"> : &nbsp; <?php echo $lsdata->owner; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%; border-left: 1px solid black;padding-left: 10px; padding-top: 5px;">API Key</td>
                            <td style="width: 80%; border-right: 1px solid black;"> : &nbsp; <?php echo $lsdata->api_key; ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%; border-left: 1px solid black; border-bottom: 1px solid black; padding-left: 10px;
                            padding-top: 5px; padding-bottom: 10px;">Available URL</td>
                            <td style="width: 80%; border-right: 1px solid black; border-bottom: 1px solid black; padding-bottom: 10px;"> : &nbsp;
                                <?php echo $lsdata->available_url; ?></td>
                        </tr>
                    <?php } ?>
                </table>
            <?php }else{
                echo 'Tidak ada informasi aplikasi';
            }
        }else{
            echo 'Tidak ada informasi aplikasi';
        } ?> <br><br>
        <strong>Fungsi-fungsi yang didaftarkan adalah sebagai berikut : </strong><br>
        <ol style="margin-top: -10px; margin-left: -20px;">
            <?php foreach ($dataManual as $lsdata2): ?>
                <li style="font-size: 10pt;">
                    <span><?php echo 'ID Methode: '.$lsdata2->id_methode.' - '.$lsdata2->judul; ?> (<?php echo $lsdata2->status_aktif; ?>)</span>
                </li>
                <?php
            endforeach;
            ?>
        </ol>
        <!--<table border="0" cellspacing="0" cellpadding="0" style="width: 100%; ">
            <tr>
                <td style="border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; padding: 10px;">
                    <strong>Informasi Method</strong>
                </td>
            </tr>
            <tr>
                <td style="width: 100%; border-left: 1px solid black;padding-left: 10px; padding-top: 5px;border-right: 1px solid black; border-bottom: 1px solid black; padding-bottom: 0px;">

                </td>
            </tr>
        </table>--><br>
        <div style="text-align: center; font-weight: bold;"><span style="text-decoration: underline;">Keterangan Methode</span></div><br>
        <?php $i = 1; ?>
        <?php foreach ($dataManual as $lsdata2) { ?>
            <div style="width: 98%;font-size: 10pt;line-height: 1.5; margin-top: 10px;">
                <span style="font-weight: bold; color: blue;"><?php echo $i.') ID Methode: '.$lsdata2->id_methode.' - '.$lsdata2->judul; ?> (<?php echo $lsdata2->status_aktif; ?>)</span><br>
                Keterangan : <?php echo $lsdata2->uraian; ?><br>
                Methode : <?php echo $lsdata2->methode; ?>
                <?php if($lsdata2->methode=='GET'): ?>
                    <br><strong>URL : </strong><small><?php echo smart_wordwrap('http://simpeg.kotabogor.go.id/rest/'.$lsdata2->entitas.'/exec_running_methode/'.$lsdata2->id_methode.'/{API Key}/{Param1}/{Param2}',140);?></small>
                    <br><br>
                <?php else: ?>
                    <br><strong>URL : </strong><small><?php echo smart_wordwrap('http://simpeg.kotabogor.go.id/rest/'.$lsdata2->entitas.'/exec_running_methode/'.$lsdata2->id_methode, 140);?></small>
                    <br>
                <?php endif; ?><br>
                <span style="margin-top: -35px;">Parameter :</span><br>
                <span style="margin-top: -30px;">
                <?php $params = $this->api->get_params_methode_by_id($lsdata2->id_methode)->result(); ?>
                    <?php if (isset($params) and sizeof($params) > 0): ?>
                        <?php $a = 1; ?>
                        <?php if ($params != ''): ?>
                            <ul style="margin-top: -20px;">
                        <?php foreach ($params as $lsdata3): ?>
                            <li style="font-size: 8pt;"><?php echo $lsdata3->params_name.' = '.$lsdata3->values.
                                    '. Tipe: '.$lsdata3->params_type.' ('.($lsdata3->is_required==1?'Required':'Optional').')';?>
                            </li>
                            <?php
                            $a++;
                        endforeach; ?>
                        </ul>
                        <?php else: ?>
                            <ul style="margin-top: -20px;"><li style="font-size: 8pt;">Belum Ada Data </li></ul>
                        <?php endif; ?>
                    <?php else: ?>
                        <ul style="margin-top: -20px;"><li style="font-size: 8pt;">Belum Ada Data </li></ul>
                    <?php endif; ?>
            </span><br>
                <?php $response = $this->api->get_response_methode_by_id($lsdata2->id_methode)->result(); ?>
                <span style="margin-top: -30px;">Hasil Respon :</span><br>
                <span style="margin-top: -30px;font-size: 8pt;">
                    <?php if (isset($response) and sizeof($response) > 0): ?>
                        <?php if ($response != ''): ?>
                            <ul style="margin-top: -10px;">
                                <?php foreach ($response as $lsdata3): ?>
                                    <li>Status Code : <?php echo $lsdata3->status_code;?><br>
                                        <?php echo smart_wordwrap('Content : '.$lsdata3->content,140);?></li>
                                <?php endforeach; ?>
                                </ul>
                        <?php else: ?>
                            Belum Ada Data
                        <?php endif; ?>
                    <?php else: ?>
                        Belum Ada Data
                    <?php endif; ?>
                </span>
            </div>
            <div style="border-bottom: 1px dashed #000; width: 100%; margin-top: 0px;">&nbsp;</div>
            <?php $i++; } ?>
    </page>
<?php
function smart_wordwrap($string, $width = 75, $break = "<br>") {
// split on problem words over the line length
    $pattern = sprintf('/([^ ]{%d,})/', $width);
    $output = '';
    $words = preg_split($pattern, $string, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

    foreach ($words as $word) {
        // normal behaviour, rebuild the string
        if (false !== strpos($word, ' ')) {
            $output .= $word;
        } else {
            // work out how many characters would be on the current line
            $wrapped = explode($break, wordwrap($output, $width, $break));
            $count = $width - (strlen(end($wrapped)) % $width);

            // fill the current line and add a break
            $output .= substr($word, 0, $count) . $break;

            // wrap any remaining characters from the problem word
            $output .= wordwrap(substr($word, $count), $width, $break, true);
        }
    }

    // wrap the final output
    return wordwrap($output, $width, $break);
}
$content = ob_get_clean();
try
{
    $html2pdf = new HTML2PDF('P', 'Legal', 'en', true, 'UTF-8', 0);
    $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
    $html2pdf->Output('manual_rest_simpeg.pdf');
}catch(HTML2PDF_exception $e) {
    echo $e;
    exit;
}
?>