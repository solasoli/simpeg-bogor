<?php


class Duk{	
	
		
		public function get_duk($id_skpd = NULL, $id_unit_kerja = NULL, $start = 0, $limit = 10){
			
			$query = "SELECT * FROM duk";
						

			if($id_skpd){
				
				$query .= " WHERE tahun = 2017 and id_skpd = ".$id_skpd;
				
				if($id_unit_kerja){
				
					$query .= " and id_unit_kerja = ".$id_unit_kerja;
				}
			}
										
						
			$query .= " ORDER BY 
				gol_akhir DESC ,
				gol_akhir_tmt ASC , 
				eselon ASC , 
				jabatan_tmt ASC , 
				mkt DESC , mkb DESC ,
				level_p ASC , 
				tahun_lulus ASC , 
				usia DESC";
			//echo $query;
			return mysql_query($query);
			
		}
		
		public function get_nominatif($id_skpd = NULL, $id_unit_kerja = NULL, $start = 0, $limit = 10){
		
			$query = "SELECT * FROM duk";
						

			if($id_skpd){
				
				$query .= " WHERE id_skpd = ".$id_skpd;
				
				if($id_unit_kerja){
				
					$query .= " and id_unit_kerja = ".$id_unit_kerja;
				}
			}
										
						
			$query .= " ORDER BY 				 
				eselon ASC , 
				gol_akhir DESC ,
				gol_akhir_tmt ASC ,
				jabatan_tmt ASC , 
				mkt DESC , mkb DESC ,
				level_p ASC , 
				tahun_lulus ASC , 
				usia DESC ";
			
			return mysql_query($query);
		}
		
		function regenerate($id_skpd=NULL, $id_unit_kerja=NULL){
			
			IF(isset($id_skpd)){
				
				IF(isset($id_unit_kerja)){
					$query = "CALL PRC_UPDATE_DUK_UNIT_KERJA(".$id_unit_kerja.")";
				}ELSE{
					$query = "CALL PRC_UPDATE_DUK_SKPD(".$id_skpd.")";
				}
			}ELSE{
				$query = "CALL PRC_INSERT_DUK()";
			}
			
			$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
			
			return $mysqli->query($query);
			//echo $query;
		}
		
		

}
	
