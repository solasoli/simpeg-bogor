<?php
//include_once "index.php";
include_once "../../../konek.php";
function get_id_pegawai($nip){
	$q="SELECT id_pegawai 
		FROM pegawai p		
		WHERE nip_baru LIKE '$nip'";
	$rs = mysql_query($q);
	$r = mysql_fetch_array($rs);
	return $r[0];
}

function cetak($idp, $data)
{
	echo "<br/>";
	//IDP
	echo $idp .";";
	//NAMA
	echo $data[1] .";";
	//NIP
	echo $data[2] .";";
	//NO SK CPNS
	echo $data[3] .";";
	//TMT SK PNS
	echo $data[4] .";";
	//TGL SK PNS
	echo $data[5] .";";
	//GOL saat CPNS
	echo $data[6] .";";
	//Maker Tahun
	echo $data[7] .";";
	//Maker Bulan
	echo $data[8] ."<br/>";
}


if (($_FILES["file"]["type"] == "application/vnd.ms-excel")
//|| ($_FILES["file"]["type"] == "image/jpeg")
//|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 20000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
    echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    /*if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {*/
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
      echo "Stored in: " . "upload/" . $_FILES["file"]["name"]."<br/>";
     //}
	 
	 $row = 1;
	 if (($handle = fopen("upload/" . $_FILES["file"]["name"], "r")) !== FALSE) {
		while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
			$num = count($data);
			
			$row++;
			
			if($idp = get_id_pegawai($data[2]))
			{
				$q="SELECT *
					FROM riwayat_mutasi_kerja r
					WHERE id_pegawai=$idp AND id_unit_kerja=$_POST[id_unit_kerja]";
				$rs = mysql_query($q);
				if(!($r = mysql_fetch_array($rs)))
				{
					echo "Unit Kerja Salah";
					cetak($idp, $data);
					//INSERT SK alih tugas baru
					$rs_uker = mysql_query("SELECT nama_baru FROM unit_kerja WHERE id_unit_kerja = $_POST[id_unit_kerja]");
					$uker = mysql_fetch_array($rs_uker);
					$uker = $uker[0];
					
					mysql_query("INSERT INTO sk(id_pegawai, id_kategori_sk, no_sk, tgl_sk, pemberi_sk, pengesah_sk, tmt) VALUES($idp,'1', 'Alih Tugas $uker', CURDATE(), '-', '-', CURDATE())");									
					
				}
				
				$rs_cpns = mysql_query("SELECT * FROM sk WHERE id_kategori_sk = 6 AND id_pegawai = $idp");
					if($sk_cpns = mysql_fetch_array($rs_cpns))
					{
						echo("UPDATE sk SET keterangan = '".addslashes("$data[6],$data[7],$data[8]")."' WHERE id_kategori_sk = 6 AND id_pegawai = $idp ");
					}
					else
					{
						echo "Menambahkan SK CPNS atas nama $data[1] ($idp)<br/>";
						mysql_query("INSERT INTO sk (id_pegawai, id_kategori_sk, no_sk, tgl_sk, pemberi_sk, pengesah_sk, keterangan, tmt) VALUES($idp, '6', '$data[3]', '$data[5]', '-', '-', ".addslashes("$data[6],$data[7],$data[8]").", '$data[4]')");
					}
			}
			else
			{
				echo "Tidak ditemukan di database: ";
				cetak($idp, $data);
			}

		}
		fclose($handle);
	 }	  
    }
  }
else
  {
  echo "Invalid file";
  }
?> 