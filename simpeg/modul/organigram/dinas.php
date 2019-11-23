<?php
require_once ('konek.php');
require_once ('class/pegawai.php');


$pns = new Pegawai();
if(isset($id_unit_kerja))
{
session_start();
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

<script type="text/javascript">

	var data_1 = 
	
	{
		"id" : 1,
		"title" : "Struktur Organisasi",
		"root" : {
			"title" : "Kepala",
			"subtitle": "<?php echo $pns->get_by_id_j($kepala['id_j'])->nama.'  - '.$id_unit_kerja   ?>",
			"children" : [			
				{ 	"title" : "Sekretaris", "type" : "staff",
					"subtitle" : "<?php echo $pns->get_by_id_j($sekretaris['id_j'])->nama ?>",
					"children" : [
						{"title" : "Kasubag Umum dan Kepegawaian", "subtitle" : "Endang M."},
						{"title" : "Kasubag Keuangan", "subtitle" : "Sri "},
						{"title" : "Kasubag Perencanaan dan Pelaporan", "subtitle" : "Indri"}
					]
				},
				<?php				
					$kabids = mysql_query("select * from jabatan where id_unit_kerja = ".$id_unit_kerja." and level = 3 ");
					$j = 0 ;
					
					while($kabid = mysql_fetch_object($kabids)){
					
					if($j > 0 ){ echo ","};
					$jabatan = substr($kabid->jabatan, 0, strpos(strtolower($kabid->jabatan), 'pada'));
				?>	
					{
						"title" 	: "<?php echo $jabatan ; ?>",
						"subtitle" 	: "<?php echo $pns->get_by_id_j($kabid->id_j)->nama ?>",
						"children"	: [
							<?php
							$subids = mysql_query("select * from jabatan where id_unit_kerja = ".$id_unit_kerja." and level = 4 and id_bos = $kabid->id_j");
							$k = 0;
							while($subid = mysql_fetch_object($subids)){
								$jab_subid = substr($subid->jabatan, 0, strpos(strtolower($subid->jabatan), 'pada'));
								if($k > 0 ) echo ",";
								echo '{"title" : "'.$jab_subid.'", "subtitle" : "'.$pns->get_by_id_j($subid->id_j)->nama.'"}';
								
								$k++;
							}
							?>
							
						]
					}			
				<?php			
					$j++; };
					
				?>
				
			]
		}	
	}
	
	
	
    // these values define only a subset of options for the organizational chart look & feel
    // look into the library code for the default values for each parameter, that are used if not defined here
    // "box_click_handler" will not work if we set "box_html_template", so we assigns it the null value
    //
    var oc_options_1 = {
        data_id           : 1,                    // identifies the ID of the "data" JSON object that is paired with these options
        container         : 'oc_container_1',     // name of the DIV where the chart will be drawn
        box_color         : '#aaf',               // fill color of boxes
        box_color_hover   : '#faa',               // fill color of boxes when mouse is over them
        box_border_color  : '#008',               // stroke color of boxes
        box_html_template : null,                 // id of element with template; don't use if you are using the box_click_handler
        line_color        : '#f44',               // color of connectors
        title_color       : '#000',               // color of titles
        subtitle_color    : '#707',               // color of subtitles
        max_text_width    : 20,                   // max width (in chars) of each line of text ('0' for no limit)
        text_font         : 'Courier',            // font family to use (should be monospaced)
        use_images        : false,                // use images within boxes?
        box_click_handler : oc_box_click_handler, // handler (function) called on click on boxes (set to null if no handler)
        debug             : false                 // set to true if you want to debug the library
    };

    // handler for clicks on nodes
    // this is completely configurable by you
    //
    function oc_box_click_handler(event, box) {
        if (box.oc_id !== undefined) {
            alert('clicked on node with ID = ' + box.oc_id + '; type = ' + box.oc_node.type);
        }
    }

    // load the JSON that defines the organizational structure from an external file and inmediatelly render the chart
    // this is an important modification to the 0.4 version of the library; now is imperative to load the JSON from an external file
    // inside the JSON, the "type" attribute for nodes can be: "subordinate", "staff" or "collateral"
    // you can also use the "subtype" attribute for "dashed" nodes (use "subtype:dashed")
    // look the examples and get used to the organizational structure representation
    //
    // IMPORTANT NOTE: because the JSON containing the organizational chart hierarchy is loaded using JQuery (that uses AJAX),
    // this library will work only by loading the JSON from an http server (and not by opening a local file in your browser)
    // the advantage are: separating data and logic, and capability of generating a dynamic JSON from a database (ex. with PHP)
    //
    // now render four versions of the same orgchart; the first one will use zoom, drag and print to PDF
    // modify this function as you want; normally there is no need to draw more than one chart in each web page
    //
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
	
		<?php //print_r($_GET) ;
			$id_unit_kerja = $_GET[id_unit_kerja] ;
			//echo "unit kerja : ".$id_unit_kerja; 
		?>
        
		<div align="center">
			<h1>STRUKTUR ORGANISASI SKPD</h1>	
			<?php 
				$q = mysql_query("select jabatan.id_unit_kerja,nama_baru 
								from jabatan inner join unit_kerja on unit_kerja.id_unit_kerja=jabatan.id_unit_kerja 
								where nama_baru not like 'sma%' and  nama_baru not like 'smp%' and  nama_baru not like 'smk%' 
								and nama_baru not like 'bagian%' and nama_baru not like 'UPTD%' 
								and jabatan.tahun=(select max(tahun) tahun from unit_kerja) group by nama_baru");
			?>
			<form action="index3.php" method="get">
			Unit Kerja
			<input type="hidden" value="modul/organigram/dinas.php" name="x" />
			<select id="skpd" name="id_unit_kerja">
			<?php while($s = mysql_fetch_array($q)): ?>
				<option value="<?php echo $s['id_unit_kerja'] ?>"><?php echo $s['nama_baru'] ?></option>
			<?php endwhile; ?>
				<option value="4086">Walikota</option>
			</select>
			<input type="submit" value="Pilih" />
			
			</form>
		<hr/>
			</div>
        <div id="oc_container_1" class="chart_container"></div>

        <hr/>
       

    <!--/div-->

<div id="source">
	<?php







?>

</div>
