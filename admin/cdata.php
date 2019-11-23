<?php
/*
 * AUSU jQuery-Ajax Autosuggest v1.0
 * Demo of a simple server-side request handler
 * Note: This is a very cumbersome code and should only be used as an example
 */

# Establish DB Connection
include("konek.php");

# Assign local variables
$id     =   @$_POST['id'];          // The id of the input that submitted the request.
$data   =   @$_POST['data'];        // The value of the textbox.

if ($id && $data)
{
    if ($id=='countries')
    {
	
	if(is_numeric($data))
	$query  = "SELECT id_pegawai,nama,nip_baru
                  FROM pegawai
                  WHERE (nip_baru LIKE '%$data%' or nip_lama LIKE '%$data%') and flag_pensiun=0  
                  order by nama LIMIT 300";
	else
	{
	
//	$cari=explode(" ","$data");
	if (preg_match("/badan/i", $data) or preg_match("/dinas/i", $data) or preg_match("/kantor/i", $data) or preg_match("/bagian/i", $data) or preg_match("/sekretariat/i", $data) or preg_match("/kecamatan/i", $data) or preg_match("/kelurahan/i", $data) or preg_match("/uptd/i", $data)  or preg_match("/satuan/i", $data) or preg_match("/\bsmk/i", $data) or preg_match("/\bsma/i", $data)  or preg_match("/\bsmp/i", $data) or preg_match("/\bsd/i", $data) )
        $query  = "SELECT pegawai.id_pegawai,nama,nip_baru,nama_baru
                  FROM pegawai inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja where Tahun=2011 and nama_baru like '%$data%' and flag_pensiun=0
                  order by nama LIMIT 300";
	
	else
        $query  = "SELECT id_pegawai,nama,nip_baru
                  FROM pegawai
                  WHERE nama LIKE '%$data%' and flag_pensiun=0
                  order by nama LIMIT 300";
				  
				  }

        $result = mysql_query($query);

        $dataList = array();

        while ($row = mysql_fetch_array($result))
        {
			  $qu=mysql_query("select nama_baru from unit_kerja inner join current_lokasi_kerja on current_lokasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where id_pegawai=$row[id_pegawai]");
			$unit=mysql_fetch_array($qu);
			
            $toReturn   = $row['nama'];
            $dataList[] = '<li id="' .$row['id_pegawai'] . '"><a href="#"> <table cellpadding=2 cellspacing=0 border=0 ><tr><td rowspan=4><img src=../simpeg/foto/'.$row[id_pegawai].'.jpg width=35 align=top /> </td></tr><tr><td>' . htmlentities($toReturn) . '</td></tr><tr><td>'.$row[nip_baru].'</td></tr><tr><td>'.$unit[0].'</td></tr></table></a></li>';
        }

        if (count($dataList)>=1)
        {
            $dataOutput = join("\r\n", $dataList);
            echo $dataOutput;
        }
        else
        {
            echo '<li><a href="#">No Results</a></li>';
        }
    }
  

}
else
{
    echo 'Request Error';
}
?>
