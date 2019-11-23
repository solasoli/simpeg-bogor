<?php
require_once ('konek.php');
require_once ('class/pegawai.php');
require_once ('class/unit_kerja.php');
$obj_uk = new Unit_kerja();

$pns = new Pegawai();
if(isset($id_unit_kerja))
{
session_start();
$_SESSION['idunit']="$id_unit_kerja";
}
else
{
$id_unit_kerja=$_SESSION[id_unit];
$_SESSION['idunit']="$id_unit_kerja";
}

$kepala = mysql_fetch_array(mysql_query("select * from jabatan where id_unit_kerja = ".$id_unit_kerja." and level = 1 "));


$sekretaris = mysql_fetch_array(mysql_query("select * from jabatan where id_unit_kerja = ".$id_unit_kerja." and level = 2 "));

?>

<!--script type='text/javascript' src="jquery-1.9.1.js"></script-->
<script type="text/javascript" src="assets/lib_gg_orgchart/jspdf-ggorgchart.js" ></script>
<script type="text/javascript" src="assets/lib_gg_orgchart/rgbcolor.js"></script> 
<script type="text/javascript" src="assets/lib_gg_orgchart/StackBlur.js"></script>
<script type="text/javascript" src="assets/lib_gg_orgchart/canvg.js"></script> 
<script type="text/javascript" src="assets/lib_gg_orgchart/raphael-ggorgchart.js"></script>  
<script type="text/javascript" src="assets/lib_gg_orgchart/lib_gg_orgchart_v100b1.js"></script>
<script type="text/javascript" src="assets/lib_gg_orgchart/drag-on.js"></script>
<script type="text/javascript" src="assets/lib_gg_orgchart/jsrender.js"></script>
<script type="text/javascript" src="assets/lib_gg_orgchart/jsrender.js"></script>
<script type="text/javascript" src="assets/printarea/jquery.PrintArea.js"></script>
<script type="text/javascript">

    // these values define only a subset of options for the organizational chart look & feel
    // look into the library code for the default values for each parameter, that are used if not defined here
    // "box_click_handler" will not work if we set "box_html_template", so we assigns it the null value
    //
    var oc_options_1 = {
        data_id           : 1,                    // identifies the ID of the "data" JSON object that is paired with these options
        container         : 'oc_container_1',     // name of the DIV where the chart will be drawn
         inner_padding    : 5,  
        box_color         : '#fff',//'#aaf',               // fill color of boxes
        box_color_hover   : '#faa',               // fill color of boxes when mouse is over them
        box_border_color  : '#000',               // stroke color of boxes
        box_html_template : null,                 // id of element with template; don't use if you are using the box_click_handler
        box_fix_width     : 225,
        box_border_radius : 0, 
        line_color        : '#000',               // color of connectors
        title_color       : '#000',               // color of titles
        subtitle_color    : '#00f',               // color of subtitles
        title_font_size   : 13,
        subtitle_font_size: 12,
        max_text_width    : 30,                   // max width (in chars) of each line of text ('0' for no limit)
        text_font         : 'Courier',            // font family to use (should be monospaced)
        use_images        : true,                // use images within boxes?
		images_size 	  : [40, 50], // size (x, y) of the images to be embeeded in boxes
        box_click_handler : oc_box_click_handler, // handler (function) called on click on boxes (set to null if no handler)
        //print
        use_zoom_print    : true,                    // wheter to use zoom and print or not (only one graph per web page can do so)
        container_supra   : 'oc_supracontainer_4',   // container of the container (DIV); needed for zoom and print
        initial_zoom      : 0.75,                    // initial zoom
        pdf_canvas        : 'oc_print_canvas_4',     // name of the invisible HTML5 canvas needed for print
        pdf_canvas_width  : 800,                     // size of the container (X axis)
        pdf_canvas_height : 480,                     // size of the container (Y axis)
        pdf_filename      : 'orgChart.pdf',           // default filename for PDF printing
        debug             : false                 // set to true if you want to debug the library
    };

  
    function oc_box_click_handler(event, box) {
        if (box.oc_id !== undefined) {
            alert('clicked on node with ID = ' + box.oc_id + '; type = ' + box.oc_node.type);
        }
    }
    
    var merged_options = false;
    //
    function ggOrgChart_render ()
    {
        var result;
        result = ggOrgChart.render(oc_options_1, "struktur_organisasi.php");
        if (result === false) { alert("INFO: render() failed (bad 'options' or 'data' definition)"); return; }
    }

    // WINDOW.ONLOAD TASKS
    // put here all the task that should be done when the page finish to load
    //
    window.onload = function () {
        ggOrgChart_render();        
    } ;

    // styles used by the chart rendering
    //
    </script>

    <style>
        .body            { margin: 10px; padding: 0; }
        .text            { font-family: sans-serif; color: blue; text-align: left; }
        .chart_container { margin-left: auto; margin-right: auto; position: relative; width: 100%; }
    </style>	
        
		<div align="center">
			<?php
			if(isset($id_unit_kerja)){
				echo "<h2>STRUKTUR ORGANISASI <br>".strtoupper($obj_uk->get_unit_kerja($id_unit_kerja)->nama_baru)."</h2>";
			}else{
				echo "<h2>STRUKTUR ORGANISASI SKPD</h2>	";
			}			
			?>
			
			<?php 
				$q = mysql_query("select jabatan.id_unit_kerja,nama_baru 
								from jabatan inner join unit_kerja on unit_kerja.id_unit_kerja=jabatan.id_unit_kerja 
								where nama_baru not like 'sma%' and  nama_baru not like 'smp%' and  nama_baru not like 'smk%' 
								and nama_baru not like 'bagian%' and nama_baru not like 'UPTD%' 
								and jabatan.tahun=(select max(tahun) tahun from unit_kerja) group by nama_baru");
			?>
			<form action="index3.php" method="get">
				<div class="hidden-print">
				Pilih Unit Kerja				
				<input type="hidden" value="modul/organigram.php" name="x" />
				<select id="skpd" name="id_unit_kerja">				
				<?php 
					if(isset($id_unit_kerja)){
						echo "<option value=".$id_unit_kerja.">".$obj_uk->get_unit_kerja($id_unit_kerja)->nama_baru."</option>";
					}
					while($s = mysql_fetch_array($q)): ?>					
						<option value="<?php echo $s['id_unit_kerja'] ?>"><?php echo $s['nama_baru'] ?></option>
				<?php endwhile; ?>
					<option value="4086">Walikota</option>
				</select>
				<input type="submit" value="Pilih" />
				<!--button id="cetak" class="btn pull-right">Cetak</button-->
				</div>
			</form>
			<hr/>
		</div>
        <div id="oc_container_1" class="chart_container"></div>

        <hr/>
       

    <!--/div-->

	<script>
        (function($) {
            // fungsi dijalankan setelah seluruh dokumen ditampilkan
            $(document).ready(function(e) {
                 
                // aksi ketika tombol cetak ditekan
                $("#cetak").bind("click", function(event) {
                    // cetak data pada area <div id="#data-mahasiswa"></div>
                    
					('#oc_container_1').printArea();
                });
            });
        }) (jQuery);
    </script>
