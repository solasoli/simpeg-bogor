<?php
    session_start();
    include("koncil.php");
    extract($_GET);
    $htmlVar = "";
    //echo("select file_name from isi_berkas where id_berkas=$idb");
    $qb=mysqli_query($con,"select file_name from isi_berkas where id_berkas=$idb");
    $qsk=mysqli_query($con,"select id_kategori_sk from sk where id_berkas=$idb");
    $qc=mysqli_query($con,"select created_date from berkas where id_berkas=$idb");
    $cek=mysqli_fetch_array($qc);
    $sk=mysqli_fetch_array($qsk);
    //echo("<div align=center>di scan pada $cek[0] </div>  ");
    //echo("select file_name from isi_berkas where id_berkas=$idb");

    while($alay=mysqli_fetch_array($qb)){
        $do=strstr($alay[0], 'Berkas');
        $asli=basename($do);
        $nf=basename($alay[0]);
        $pecah = explode(".", $nf);
        if($pecah[1] == 'jpg' || $pecah[1] == 'jpeg'){
            //echo("<table border=0 cellpadding=0 cellspacing=0 width=100%>");
            //echo("<tr class='break'><td align=center> <img src='http://103.14.229.15/simpeg/berkas/$nf'  height=850px /></td></tr>");
            //echo("</table>");
            $htmlVar = "<page backtop=\"14mm\" backbottom=\"14mm\" backleft=\"10mm\" backright=\"10mm\" style=\"font-size: 8pt\">
                           <table border=0 cellpadding=0 cellspacing=0 style='width: 100%'>
                            <tr>
                                <td align=center style='width: 90%'>
                                    <img src='http://103.14.229.15/simpeg/berkas/$nf' width='750px;'/>
                                </td>
                            </tr>
                           </table>
                        </page>";
        }else{
            //echo("<a href='http://103.14.229.15/simpeg/berkas/$nf' >download file</a>");
            if($sk[0]!=5 and $sk[0]!=6 and $sk[0]!=7){
                echo("<a href='http://103.14.229.15/simpeg/berkas/$nf' >download file</a>");
            }else{
                echo("<a href=donlot.php?idb=$idb >download file</a>");
                echo " | ";
                echo("<a href='http://103.14.229.15/simpeg/berkas/$nf' target='_blank'>lihat file</a>");
            }
        }
    }
    ob_start()
;?>

<?php
    if($htmlVar!="") {
        echo $htmlVar;
        $content = ob_get_clean();
        require_once('html2pdf.class.php');
        try {
            $html2pdf = new HTML2PDF('P', 'Legal', 'fr', true, 'UTF-8', 0);
            $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
            $html2pdf->Output('sk.pdf');
        } catch (HTML2PDF_exception $e) {
            echo $e;
            exit;
        }
    }
?>