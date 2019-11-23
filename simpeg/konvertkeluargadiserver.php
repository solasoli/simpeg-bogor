<?php
//langkah3 disimpan di server
//konek ke database
mysqli_connect('192.168.1.2','simpeg_root',' 51mp36');//sesuaikan dengan diserver bkpp

$_SESSION['dbase'] = 'simpeg'; //database name
$_SESSION['table'] ='temp_keluarga'; //table name buat dulu tablenya di server dengan segala atributnya
$_SESSION['csvname']='./backupkeluargadarihosting/keluarga.csv';//tempat penyimpanan hasil bakupan dari hosting

//proses convert 
mysqli_select_db($_SESSION['dbase']);
$show = mysqli_query($mysqli,"SHOW FIELDS FROM ".$_SESSION['table']."");
$feildsnum = 0;
while($do = mysqli_fetch_array($show)) {
									  $feild[$do['Field']] = $do['Field'];
									  $feildsnum++;
									  }

$numSQL = 1;
$sqlKey = null;
foreach ($feild as $key ) {
						  if ($numSQL == $feildsnum) {
													 $sqlKey .= $key;
	                                                 } else {
	                                                         $sqlKey .= $key.", ";
	                                                        }
	                      $numSQL++;
                          }
$fp = fopen($_SESSION['csvname'],"r");
$contents = fread($fp, filesize($_SESSION['csvname']));
$contents = str_replace("'", "\'", "$contents");
$newLine = explode("\n",$contents);
$rows = 1;
foreach ($newLine as $key => $value) {
									 $rows++;
                                     if (empty($value)) {
	
                                                        } else {
	                                                           $feilds = explode("~",$value);
                                                               $num = count($feilds);
	                                 if ($num > $feildsnum+1) {
		                                                       die ('<b>Error:</b> There are too many feilds in the CSV File.'.$num);
		                                                       break;
	                                                          } else {
		                                                              if ($num < $feildsnum) {
																							  $values = null;
		                                                                                      $i = 1;
		                                                                                      foreach ($feilds as $key => $v) {
			                                                                                                                  if ($i == $num) {
			                                                                                                                                   $values .= "'".$v."'";
			                                                                                                                                  } else {
			                                                                                                                                          $values .= "'".$v."',";
																																					 }
																													          $i++;
																															  }
		  
		                                                                                      mysqli_query($mysqli,"INSERT INTO ".$_SESSION['table']."
					                                                                          ($sqlKey)
					                                                                          VALUES($values)
					                                                                          ")or die(mysqli_error() ."<br>".$rows." ".__LINE__);

		                                                                                       } else {
																									   $values = null;
		                                                                                               $i = 1;
		                                                                                               foreach ($feilds as $key => $v) {
			                                                                                                                            if ($i == $num) {
			                                                                                                                                            $values .= "'".$v."'";
			                                                                                                                                            } else {
																																								$values .= "'".$v."',";
																																							   }
																																		$i++;
																																		}
		  
		                                                                                      mysqli_query($mysqli,"INSERT INTO ".$_SESSION['table']."
																							  ($sqlKey)
																							  VALUES($values)
																							  ")or die(mysqli_error() ."<br>".$rows." ".__LINE__);

																										}
	                                                                   }
																}
									}

echo 'All '.($rows-2).'Records Added to '.$_SESSION['table'];
unset($_SESSION['table']);
unset($_SESSION['dbase']);
?>