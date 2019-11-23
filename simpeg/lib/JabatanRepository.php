<?php
function countJabatanBySkpdAndEselon($id_unit_kerja, $eselon){
  $q = "SELECT COUNT(*)
        FROM jabatan j
        WHERE j.tahun = DATE_FORMAT(CURDATE(), '%Y')
          AND id_unit_kerja = $id_unit_kerja ";
  
  if($eselon == 'I')
  {
    $q = $q." AND j.eselon IN ('IA', 'IB')";
  }
  else if ($eselon == 'II')
  {
    $q = $q." AND j.eselon IN ('IIA', 'IIB')";
  }
                          
  $q = mysql_query($q);
  $q = mysql_fetch_array($q);
  return $q[0];
}
?>
