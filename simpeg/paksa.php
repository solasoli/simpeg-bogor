<?

include("konek.php");

$q=mysqli_query($mysqli,"SELECT pendidikan.id_pegawai,nama,pegawai.id_pegawai

FROM `pegawai`

left JOIN pendidikan ON pegawai.id_pegawai = pendidikan.id_pegawai

WHERE flag_pensiun =0 and pendidikan.id_pegawai is NULL 

");

$i=1;

while($data=mysqli_fetch_array($q))

{

/*

if(substr($data[1],-4)==', Se')

mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','S1','Ekonomi',0,3)");



elseif(substr($data[1],-3)==',SP' or substr($data[1],-4)==', Sp')

mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','S1','Pertanian',0,3)");



elseif(substr($data[1],-4)=='.Sos')

mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','S1','Sosial',0,3)");

/*

elseif(substr($data[1],-4)==' Skm' or substr($data[1],-4)==' SKM')

mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','S1','Kesehatan Masyarakat',0,3)");



elseif(substr($data[1],-3)=='.Pdi' or substr($data[1],-4)=='Pd.i' )

mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','S1','Pendidikan Islam',0,3)");



elseif(substr($data[1],-4)=='.Kom' or substr($data[1],-4)=='.KOM')

mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','S1','Komputer',0,3)");



elseif(substr($data[1],-4)=='.Psi' )

mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','S1','Psikologi',0,3)");



elseif(substr($data[1],-3)==',SH' or substr($data[1],-4)==', Sh')

mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','S1','Hukum',0,3)");



/*elseif(substr($data[1],-4)=='S.Ag' or substr($data[1],-5)=='S. Ag')

mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','S1','Pendidikan Agama',0,3)")



if(substr($data[1],-5)=='S.Pdi'  )

mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','S1','Pendidikan Islam',0,3)");

;

*/

/*

//cara 2

$qk=mysqli_query($mysqli,"select keterangan from sk where id_pegawai=$data[2] and ( id_kategori_sk=7 or id_kategori_sk=6)");



$sk=mysqli_fetch_array($qk);



if(substr($sk[0],0,5)=='III/a')

mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','S1','-',0,3)");

elseif(substr($sk[0],0,4)=='II/a')

mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','SMU/SMK/MA/SEDERAJAT','-',0,7)");

elseif(substr($sk[0],0,4)=='II/c')

mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','D3','-',0,4)");



*/



//cara 3

$qn=mysqli_query($mysqli,"select nip_baru,pangkat_gol from pegawai where id_pegawai=$data[2] and jenjab like 'struktural'");

$nip=mysqli_fetch_array($qn);



$qo=mysqli_query($mysqli,"select * from temp where gol = '$nip[1]' ");

$on=mysqli_fetch_array($qo);



$tm=substr($nip[0],8,4);

$th=2010-$tm;

$ne=$th%4;



$idt=$on[0]-$ne;

if($idt<=0)

$idt=1;



$qo2=mysqli_query($mysqli,"select * from temp where id=$idt ");

$ok=mysqli_fetch_array($qo2);



if($ok[3]!=NULL)

{



mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','$ok[2]','-',0,$ok[3])");









}



/*if($nip[1]=='III/b')

mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','S1','-',0,3)");



if($nip[1]=='II/b')

mysqli_query($mysqli,"insert into pendidikan (id_pegawai,lembaga_pendidikan,tingkat_pendidikan,jurusan_pendidikan,tahun_lulus,level_p)

values ($data[2],'-','SMU/SMK/MA/SEDERAJAT','-',0,7)");

*/











}

echo("$i rows affected");



?>