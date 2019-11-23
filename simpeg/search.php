<?php
//$s=$_REQUEST['s'];
extract($_GET);

if(@$lim == NULL)
$lim=0;

$qts=mysqli_query($mysqli,"select count(*) from unit_kerja where nama_baru like '%$s%'");
$tipe=mysqli_fetch_array($qts);



if($tipe[0]==0)
{

 $qp=mysqli_query($mysqli,"select count(*) from pendidikan where jurusan_pendidikan like '%$s%' ");
 
// echo("select count(*) from pendidikan where jurusan_pendidikan like '%$s%' ");
			  $pen=mysqli_fetch_array($qp);
			  if($pen[0]>0){
			
  $q0=mysqli_query($mysqli,"select IF(LENGTH(pegawai.gelar_belakang) > 1,
							CONCAT(pegawai.gelar_depan,
									' ',
									pegawai.nama,
									CONCAT(', ', pegawai.gelar_belakang)),
							CONCAT(pegawai.gelar_depan, ' ', pegawai.nama)) AS nama,
						nama_baru,pegawai.id_pegawai as id_pegawai,nip_lama,nip_baru,tgl_lahir,jenis_kelamin,pegawai.pangkat_gol  from pegawai inner join pendidikan on pendidikan.id_pegawai=pegawai.id_pegawai inner join riwayat_mutasi_kerja on pegawai.id_pegawai=riwayat_mutasi_kerja.id_pegawai  inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where jurusan_pendidikan  like '%$s%' order by level_p ");
						
			  $q=mysqli_query($mysqli,"select nama,nama_baru,pegawai.id_pegawai as id_pegawai,nip_lama,nip_baru,tgl_lahir,jenis_kelamin,pegawai.pangkat_gol  from pegawai inner join pendidikan on pendidikan.id_pegawai=pegawai.id_pegawai inner join riwayat_mutasi_kerja on pegawai.id_pegawai=riwayat_mutasi_kerja.id_pegawai  inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where jurusan_pendidikan  like '%$s%' order by level_p limit $lim,20");
			  
			 // echo("select nama,nama_baru,pegawai.id_pegawai,nip_lama,nip_baru,tgl_lahir,jenis_kelamin,pangkat_gol  from pegawai inner join pendidikan on pendidikan.id_pegawai=pegawai.id_pegawai inner join riwayat_mutasi_kerja on pegawai.id_pegawai=riwayat_mutasi_kerja.id_pegawai  inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where jurusan_pendidikan  like '%$s%' order by level_p");
			   
  }else{
	$q0=mysqli_query($mysqli,"select concat(pegawai.gelar_depan,' ',pegawai.nama,' ',pegawai.gelar_belakang) as nama,
					nama_baru,pegawai.id_pegawai as id_pegawai,nip_lama,nip_baru,tgl_lahir,jenis_kelamin,pegawai.pangkat_gol from pegawai inner join riwayat_mutasi_kerja on pegawai.id_pegawai=riwayat_mutasi_kerja.id_pegawai inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where status_aktif not like '%pensiun%' and flag_pensiun=0 and  (nama like '%$s%' or nama_baru like '%$s%') group by id_pegawai,nip_lama,nip_baru  order by nama  ");

	$q=mysqli_query($mysqli,"select IF(LENGTH(pegawai.gelar_belakang) > 1,
							CONCAT(pegawai.gelar_depan,
									' ',
									pegawai.nama,
									CONCAT(', ', pegawai.gelar_belakang)),
							CONCAT(pegawai.gelar_depan, ' ', pegawai.nama)) AS nama,
							nama_baru,
							pegawai.id_pegawai as id_pegawai,
							nip_lama,
							nip_baru,
							tgl_lahir,
							jenis_kelamin,
							concat(g.pangkat,' - ',vpt.golongan) as pangkat_gol 
							from pegawai 
					inner join view_pangkat_terakhir vpt on vpt.id_pegawai = pegawai.id_pegawai
					inner join golongan g on g.golongan = vpt.golongan
					inner join riwayat_mutasi_kerja on pegawai.id_pegawai=riwayat_mutasi_kerja.id_pegawai 
					inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja 
					
							where status_aktif not like '%pensiun%' and flag_pensiun=0 and  (nama like '%$s%' or nama_baru like '%$s%') group by id_pegawai,nip_lama,nip_baru  order by nama limit $lim,20 ");
							
						
							
	}


}
else
{


$qcek=mysqli_query($mysqli,"select count(*) from current_lokasi_kerja inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where nama_baru like '%$s%'");

$cek=mysqli_fetch_array($qcek);

if($cek[0]>0 and strlen($s)>7)
{
$anam=mysqli_query($mysqli,"select id_unit_kerja from unit_kerja where nama_baru like '%$s%' order by tahun desc");
$ana=mysqli_fetch_array($anam);
//print_r($ana);
$q0=mysqli_query($mysqli,"SELECT * FROM 
(
  SELECT * FROM 
  (
    SELECT pegawai.id_pegawai AS 'id_pegawai',
             pegawai.nip_lama AS 'nip_lama',
             pegawai.nip_baru AS 'nip_baru',
             IF(LENGTH(pegawai.gelar_belakang) > 1,
				CONCAT(pegawai.gelar_depan,
						' ',
						pegawai.nama,
						CONCAT(', ', pegawai.gelar_belakang)),
				CONCAT(pegawai.gelar_depan, ' ', pegawai.nama)) AS nama,
             pegawai.nama_pendek AS 'nama_pendek',
             pegawai.Jenis_kelamin AS 'jenis_kelamin',
             pegawai.npwp AS 'npwp',
             pegawai.agama AS 'agama',
             pegawai.tempat_lahir AS 'tempat_lahir',
             pegawai.tgl_lahir AS 'tgl_lahir',
             pegawai.status_pegawai AS 'status_pegawai',
             pegawai.pangkat_gol AS 'pangkat_gol',
             pegawai.status_aktif AS 'status_aktif',
             pegawai.flag_pensiun AS 'flag_pensiun',
             unit_kerja.id_unit_kerja AS 'id_unit_kerja' 
    FROM pegawai 
    INNER JOIN current_lokasi_kerja c ON pegawai.id_pegawai = c.id_pegawai 
    INNER JOIN unit_kerja ON c.id_unit_kerja = unit_kerja.id_unit_kerja         
  ) AS x 
  GROUP BY id_pegawai
) AS y WHERE flag_pensiun = 0 and id_unit_kerja = $ana[0]
ORDER BY pangkat_gol DESC, nama 
 ");


$q=mysqli_query($mysqli,"SELECT * FROM 
(
  SELECT * FROM 
  (
    SELECT pegawai.id_pegawai AS 'id_pegawai',
             pegawai.nip_lama AS 'nip_lama',
             pegawai.nip_baru AS 'nip_baru',
             IF(LENGTH(pegawai.gelar_belakang) > 1,
				CONCAT(pegawai.gelar_depan,
						' ',
						pegawai.nama,
						CONCAT(', ', pegawai.gelar_belakang)),
				CONCAT(pegawai.gelar_depan, ' ', pegawai.nama)) AS nama,
             pegawai.nama_pendek AS 'nama_pendek',
             pegawai.Jenis_kelamin AS 'jenis_kelamin',
             pegawai.npwp AS 'npwp',
             pegawai.agama AS 'agama',
             pegawai.tempat_lahir AS 'tempat_lahir',
             pegawai.tgl_lahir AS 'tgl_lahir',
             pegawai.status_pegawai AS 'status_pegawai',
             concat(g.pangkat,' - ',vpt.golongan)  AS 'pangkat_gol',
             pegawai.status_aktif AS 'status_aktif',
             pegawai.flag_pensiun AS 'flag_pensiun',
             unit_kerja.id_unit_kerja AS 'id_unit_kerja' 
    FROM pegawai 
    INNER JOIN current_lokasi_kerja c ON pegawai.id_pegawai = c.id_pegawai 
    INNER JOIN unit_kerja ON c.id_unit_kerja = unit_kerja.id_unit_kerja 
	INNER JOIN view_pangkat_terakhir vpt on vpt.id_pegawai = pegawai.id_pegawai
	INNER JOIN golongan g on g.golongan = vpt.golongan
  ) AS x 
  GROUP BY id_pegawai
) AS y WHERE flag_pensiun = 0 and id_unit_kerja = $ana[0]
ORDER BY pangkat_gol DESC, nama limit $lim,20
 ");
}
else
{
$q0=mysqli_query($mysqli,"select IF(LENGTH(p.gelar_belakang) > 1,
						CONCAT(pegawai.gelar_depan,
								' ',
								pegawai.nama,
								CONCAT(', ', pegawai.gelar_belakang)),
						CONCAT(pegawai.gelar_depan, ' ', pegawai.nama)) AS nama,
						nama_baru,
						pegawai.id_pegawai as id_pegawai,
						nip_lama,nip_baru,tgl_lahir,jenis_kelamin,pegawai.pangkat_gol from pegawai inner join riwayat_mutasi_kerja on pegawai.id_pegawai=riwayat_mutasi_kerja.id_pegawai inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where status_aktif not like '%pensiun%' and flag_pensiun=0 and  (nama like '%$s%' or nama_baru like '%$s%') group by id_pegawai,nip_lama,nip_baru  order by nama  ");


$q=mysqli_query($mysqli,"select IF(LENGTH(pegawai.gelar_belakang) > 1,
						CONCAT(pegawai.gelar_depan,
								' ',
								pegawai.nama,
								CONCAT(', ', pegawai.gelar_belakang)),
						CONCAT(pegawai.gelar_depan, ' ', pegawai.nama)) AS nama,
							nama_baru,
							pegawai.id_pegawai as id_pegawai,
							nip_lama,
							nip_baru,
							tgl_lahir,
							jenis_kelamin,
							concat(g.pangkat,' - ',vpt.golongan) as pangkat_gol 
							from pegawai 
					inner join view_pangkat_terakhir vpt on vpt.id_pegawai = pegawai.id_pegawai
					inner join golongan g on g.golongan = vpt.golongan
					inner join riwayat_mutasi_kerja on pegawai.id_pegawai=riwayat_mutasi_kerja.id_pegawai 
					inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja 
					
							where status_aktif not like '%pensiun%' and flag_pensiun=0 and  (nama like '%$s%' or nama_baru like '%$s%') group by id_pegawai,nip_lama,nip_baru  order by nama limit $lim,20 ");
							
}


}



?>

<div align="center" id="txtHint" >

<?php
$i=1;
$qm=$q0;
$jum=mysqli_num_rows($qm);
$hal=ceil($jum/20);
echo("halaman  :");
for($z=1;$z<=$hal;$z++)
{
$s=str_replace(" ", "%20", "$s");
$nex=($z-1)*20;

$page=($lim+20)/20;
if($z==$page)
echo(" [$z] ");
else
echo(" <a href=index3.php?x=search.php&lim=$nex&s=$s> $z </a>");
//print_r($q);
}
while($data=mysqli_fetch_array($q))
{
$no=$lim+$i;
echo("
<div align='left'>
<table border=0 class='table'>
<td rowspan=7 style='max-width: 20px; min-width:20px;' align=right>$no
</td>
<td rowspan=7 width=75 >");
if (file_exists("./foto/$data[id_pegawai].jpg")) 
	$gambar="<img src=./foto/$data[id_pegawai].jpg width=75 />";
else if (file_exists("./foto/$data[id_pegawai].JPG")) 
	$gambar="<img src=./foto/$data[id_pegawai].JPG width=75 />";
else
{
if($data['jenis_kelamin']=='1')
	$gambar="<img src=./images/male.jpg width=75 />";
else
	$gambar="<img src=./images/female.jpg width=75 />";
}
echo $gambar;
echo ("</td> ");
$k=mysqli_query($mysqli,"select nama_baru 
			from riwayat_mutasi_kerja 
			inner join pegawai on riwayat_mutasi_kerja.id_pegawai=pegawai.id_pegawai 
			inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja 
			inner join sk on riwayat_mutasi_kerja.id_sk=sk.id_sk where riwayat_mutasi_kerja.id_pegawai=$data[id_pegawai] 
			order by tgl_sk desc");
$k2 = mysqli_query($mysqli,"select * from current_lokasi_kerja clk
					inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
					where clk.id_pegawai =$data[id_pegawai]
					");				
$unit=mysqli_fetch_array($k2);
	
	
	if($data[3]=='-')
		$nip=$data[4];
	else
		$nip=$data[3];
	
$tgl = substr($data['tgl_lahir'],8,2);
$bln = substr($data['tgl_lahir'],5,2);
$thn = substr($data['tgl_lahir'],0,4);

$coba="$tgl/$bln/$thn";
//nama

// User Role Validating
$qRole = "SELECT u.id_pegawai, u.role_id, r.role 
		  FROM user u INNER JOIN roles r ON r.role_id = u.role_id
		  WHERE u.id_pegawai = $_SESSION[id_pegawai]";
//echo $qRole;
$rsRole = mysqli_query($mysqli,$qRole);

if(mysqli_num_rows($rsRole) > 0)
{
	$role = mysqli_fetch_array($rsRole);
	if($role[role] == 'Super User' || $role[role] == 'BKPP')
	{	
		echo("<tr><td width=75> Nama</td>
		<td width=5>:</td><td nowrap><a href=index3.php?x=pegawai_detail.php&&id=$data[id_pegawai]&&s=$s>$data[nama]</a> </td></tr>");
	}
	else
	{
		echo("<tr><td width=75> Nama</td><td width=5>:</td><td nowrap>
		<a href=index3.php?x=home3.php&&id=$data[id_pegawai]&&s=$s>$data[nama]</a> </td></tr>");
	}
}
else
{
	echo("<tr><td width=75> Nama</td><td width=5>:</td><td nowrap><a href=index3.php?x=home3.php&&id=$data[id_pegawai]&&s=$s>$data[nama]</a> </td></tr>");
}
// End Of User Role Validating
//ttl
echo("<tr><td> Tgl Lahir</td><td>:</td><td>$coba </td></tr>");
//nip
echo("<tr><td> NIP lama</td><td>:</td><td>$data[nip_lama] </td></tr>");
//nip baru
echo("<tr><td> NIP Baru</td><td>:</td><td>$data[nip_baru]</td></tr>");
//unit kerja
echo("<tr><td nowrap> Unit Kerja</td><td>:</td><td nowrap>$unit[nama_baru]</td></tr>");
//golongan
//unit kerja
echo("<tr><td nowrap> Golongan</td><td>:</td><td nowrap>$data[pangkat_gol]</td></tr>");

$qp=mysqli_query($mysqli,"select tingkat_pendidikan from pendidikan inner join pegawai on pegawai.id_pegawai=pendidikan.id_pegawai where pegawai.id_pegawai=$data[id_pegawai] order by level_p");
	$pend=mysqli_fetch_array($qp);
	if($pend[0]!=NULL)
//echo("<tr><td nowrap> Pendidikan Terakhir</td><td>:</td><td nowrap>$pend[0]</td></tr>");
	
echo("</table></div></td></tr>");
  $i++;
				
}
echo("halaman  :");
for($z2=1;$z2<=$hal;$z2++)
{

$nex=($z2-1)*20;
echo(" <a href=index3.php?x=search.php&s=$s&lim=$nex> $z2 </a>");

}

?>



  
</table>
</div>

