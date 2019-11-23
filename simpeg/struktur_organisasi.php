<?php
session_start();
require_once ('konek.php');
require_once ('class/pegawai.php');
require_once ('class/unit_kerja.php');

$pns = new Pegawai();
$obj_uk = new Unit_kerja();

if(!$id_unit_kerja){
	$id_unit_kerja = $_SESSION['idunit'] ;
	
}

$kepala = $obj_uk->get_kepala($id_unit_kerja);
$sekretaris = $obj_uk->get_sekretaris();
$kabids = $obj_uk->get_kabid();
?>
{
	"id" : 1,
	"title" : "Struktur Organisasi",
	"root" : {
		"title" : "Kepala",
		"subtitle": "<?php echo $kepala->nama ? $kepala->nama.' '.$kepala->nip.' ' : "KOSONG";?>",
		"image" : "../foto/<?php echo $kepala->id_pegawai.".jpg"; ?>", 
		"image_position" : "below",
		"children" : [			
				<?php
					if($kabids != 0){
						echo "{";
						echo " \"title\" : \"Sekretaris\", \"type\" : \"staff\", \"subtitle\" : \" ";
						echo $sekretaris->nama ? $sekretaris->nama.' '.$sekretaris->nip.' ' : "KOSONG";
						echo '",';
						echo '"image" : "../foto/'.$sekretaris->id_pegawai.'.jpg"';
					}
				?>
				<?php 
				if($kabids != 0){
				echo ", 
				\"children\" : [";
					
						$bawahans = $obj_uk->get_bawahan_sekretaris($sekretaris->id_j);						
						$b = 0;
						while($bawahan = mysqli_fetch_object($bawahans)){
							if($b > 0 ) echo ",";
							$jabatan = substr($bawahan->jabatan, 0, strpos(strtolower($bawahan->jabatan), 'pada'));
							if($jabatan == ''){
								$jabatan = substr($bawahan->jabatan, 0, strpos(strtolower($bawahan->jabatan), 'kecamatan'));
							}
							echo '{"title" : "'.$jabatan.'", "subtitle" : "'.$bawahan->nama.' '.$bawahan->nip.'",';
							echo '"image" : "../foto/'.$bawahan->id_pegawai.'.jpg';
							echo '"}';
							$b++;
						}
						
				echo ']';
				echo "},";
				}
				?>
		<?php			
		if($kabids != 0){
		$j = 0 ;				
		while($kabid = mysqli_fetch_object($kabids)){
			if($j > 0 ) echo ",";
			$jabatan = substr($kabid->jabatan, 0, strpos(strtolower($kabid->jabatan), 'pada'));
			if($jabatan == ''){
				$jabatan = substr($kabid->jabatan, 0, strpos(strtolower($kabid->jabatan), 'badan'));
			}
			if($jabatan == ''){
				$jabatan = substr($kabid->jabatan, 0, strpos(strtolower($kabid->jabatan), 'dinas'));
			}
			if($jabatan == ''){
				$jabatan = substr($kabid->jabatan, 0, strpos(strtolower($kabid->jabatan), 'kecamatan'));
			}
			if($jabatan == ''){
				$jabatan = substr($kabid->jabatan, 0, strpos(strtolower($kabid->jabatan), 'camat'));
			}
			if($jabatan == ''){
				$jabatan = substr($kabid->jabatan, 0, strpos(strtolower($kabid->jabatan), 'kantor'));
			}
		?>	
			{
				"title" 	: "<?php echo $jabatan ; ?>",
				"subtitle" 	: "<?php echo $kabid->nama.' '.$kabid->nip.' '; ?>",
				"image" : "../foto/<?php echo $kabid->id_pegawai.".jpg"; ?>"
				<?php
					$subids = $obj_uk->get_bawahan_kabid($id_unit_kerja, $kabid->id_j);
					if($subids != 0){
						echo ',';
						echo '"children"	: [';
						$k = 0;
						while($subid = mysqli_fetch_object($subids)){
							$jab_subid = substr($subid->jabatan, 0, strpos(strtolower($subid->jabatan), 'pada'));
							if($jab_subid == ''){
								$jab_subid = substr($subid->jabatan, 0, strpos(strtolower($subid->jabatan), 'dinas'));
							}
							if($k > 0 ) echo ",";
							echo '{"title" : "'.$jab_subid.'", "subtitle" : "'.$subid->nama.' '.$subid->nip.'",';
							echo '"image" : "../foto/'.$subid->id_pegawai.'.jpg';
							echo '"}';
							$k++;
						}						
						echo ']';
					}	
				?>
			}			
		<?php			
			$j++; };
		}else{
			$subids = $obj_uk->get_kasi_wilayah($kepala->id_j);
			$k = 0;
			while($subid = mysqli_fetch_object($subids)){
				$jab_subid = substr($subid->jabatan, 0, strpos(strtolower($subid->jabatan), 'kelurahan'));
				if($jab_subid == ''){
					$jab_subid = substr($subid->jabatan, 0, strpos(strtolower($subid->jabatan), 'pada'));
				}
				if($jab_subid == ''){
					$jab_subid = substr($subid->jabatan, 0, strpos(strtolower($subid->jabatan), 'kelurahan'));
				}
				if($jab_subid == ''){
					$jab_subid = substr($subid->jabatan, 0, strpos(strtolower($subid->jabatan), 'kantor'));
				}
				if($k > 0 ) echo ",";
				echo '{"title" : "'.$jab_subid.'", "subtitle" : "'.$subid->nama.' '.$subid->nip.'",';
				echo '"image" : "../foto/'.$subid->id_pegawai.'.jpg';
				echo '"}';
				$k++;
			}			
		}		
		?>
		]
	}	
}