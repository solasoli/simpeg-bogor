<?

include("konek.php");
$q=mysqli_query($mysqli,"select * from mutasi_jabatan");
$i=0;
while($data=mysqli_fetch_array($q))
{

    $q1=mysqli_query($mysqli,"select jabatan,eselon,id_unit_kerja from jabatan where id_j=$data[2]");
    $q2=mysqli_query($mysqli,"select pangkat_gol from pegawai where id_pegawai=$data[1]");
    //echo("select pangkat_gol from pegawai where id_pegawai=$data[1]<br>");
    $ata=mysqli_fetch_array($q1);
    $ta=mysqli_fetch_array($q2);

    /*if($ata[1]=='IIB')
    $sk='821.2-38 Tahun 2017';
    elseif($ata[1]=='IIIA')
    $sk='821.2.45-37 Tahun 2012';
    elseif($ata[1]=='IIIB')
    $sk='821.2.45-38 Tahun 2012';
    elseif($ata[1]=='IVA')
    $sk='821.2.45-39 Tahun 2012';
    elseif($ata[1]=='IVB')
    $sk='821.2.45-40 Tahun 2012';
    elseif($ata[1]=='V')
    $sk='821.2.45-41 Tahun 2012';*/


    $sk = "821.2-38 Tahun 2017";
    mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,keterangan,tmt,id_j) values ($data[1],10,'$sk','2017-04-21','Walikota Bogor','Dr. Bima Arya','$ta[0]','2017-04-21',$data[2])");

    $q4=mysqli_query($mysqli,"select * from sk order by id_sk desc");
    $a=mysqli_fetch_array($q4);

    mysqli_query($mysqli,"insert into riwayat_mutasi_kerja (id_pegawai,id_sk,id_unit_kerja,id_j,jabatan,pangkat_gol,jenjab,eselonering) values ($data[1],$a[0],$ata[2],$data[2],'$ata[0]','$ta[0]','Struktural','$ata[1]')");
    mysqli_query($mysqli,"update current_lokasi_kerja set id_unit_kerja=$ata[2] where id_pegawai=$data[1]");

    $null_kan = ("update pegawai set id_j = NULL, jabatan = 'KOSONG' where id_j=$data[2]");

    if(mysqli_query($mysqli,$null_kan)){
        echo $null_kan." Berhasil";
    }else{

        echo "id j tidak bisa kosong";
        exit;
    }

    mysqli_query($mysqli,"update pegawai set id_j=$data[2],jabatan='$ata[0]' where id_pegawai=$data[1]");
    echo("update pegawai set id_j=$data[2],jabatan='$ata[0]' where id_pegawai=$data[1]<br>");
    $i++;
}
echo("done $i");

//update current lokasi kerjanya
/*mysqli_query($mysqli,"UPDATE  `mutasi_jabatan` m,
					jabatan j,
					current_lokasi_kerja c
					SET c.id_unit_kerja = j.id_unit_kerja WHERE m.id_j = j.id_j AND c.id_pegawai = m.id_pegawai");

	*/
?>
