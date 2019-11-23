
<link rel="stylesheet" type="text/css" href="tcal.css" />
<script type="text/javascript" src="tcal.js"></script> 


<?php
include("konek.php");
include('library/format.php');
include('class/pegawai.php');

$format = new Format;

//$pegawai = new Pegawai;
$obj_pegawai = new Pegawai;
$pegawai = $obj_pegawai->get_obj($od);

// Turn off all error reporting
//error_reporting(0);
extract($_POST);
extract($_GET);

$q1=mysqli_query($mysqli,"select unit_kerja.id_unit_kerja, nama, id_skpd 
				from current_lokasi_kerja 
				inner join pegawai on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai 
				inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja
				where current_lokasi_kerja.id_pegawai=$_SESSION[id_pegawai]");				

$_SESSION['selected_id_pegawai'] = $_REQUEST['od'];

$p1=mysqli_fetch_array($q1);

$q2=mysqli_query($mysqli,"select id_skpd from current_lokasi_kerja inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where id_pegawai=$od");
$p2=mysqli_fetch_array($q2);


if($p1[0]==$p2[0] || $p1[2] == $p2[0] )
{
if(isset($id2))
{
	$t0=substr($tglwin,0,2);
	$b0=substr($tglwin,3,2);
	$th0=substr($tglwin,6,4);
	$t_menikah=substr($tgl_menikah,0,2);
	$b_menikah=substr($tgl_menikah,3,2);
	$th_menikah=substr($tgl_menikah,6,4);
	$skr=date("Y-m-d H:i:s");
$update_pegawai = "update pegawai set 
			nama='$n',
			gelar_depan='$gelar_depan',
			gelar_belakang='$gelar_belakang',
			nip_lama='$nl',
			email='$email',
			alamat='$al',
			agama='$a',
			tempat_lahir='$tl',
			no_karpeg='$karpeg',
			NPWP='$npwp',
			pangkat_gol='$gol',
			ponsel='$hp',telepon='$telp',
			jenjab='$jenjab',
			kota='$kota',
			gol_darah='$darah',
			timestamp='$skr',keterangan='updated by $p1[1]',
			status_kawin='$kawin',jenis_kelamin='$jk'
			where id_pegawai=$id2";


$update_pegawai2 = "update pegawai set
					email='$email',
					alamat='$al',
					NPWP='$npwp',
					ponsel='$hp',telepon='$telp',
					gol_darah='$darah',
					kota='$kota',
					timestamp='$skr',keterangan='updated by $p1[1]',					
					password='$password' where id_pegawai=$id2
					";


if($is_tim){
	if(mysqli_query($mysqli,$update_pegawai)){		
		$pegawai = $obj_pegawai->get_obj($od);
	}	
}else{
	if(mysqli_query($mysqli,$update_pegawai2)){
		$pegawai = $obj_pegawai->get_obj($od);
	}
	
}



//update atasan
mysqli_query($mysqli,"update riwayat_mutasi_kerja set id_j_bos=$jx where id_riwayat=$rmk");
//echo("update riwayat_mutasi_kerja set id_j_bos=$jx where id_riwayat_rmk=$rmk");

//update anak
for($g=1;$g<=$ja;$g++)
{
$ngaran=$_POST["anak"."$g"];	
$dmn=$_POST["la"."$g"];	
$ta=$_POST["tg"."$g"];	
$budak=$_POST["king"."$g"];	
$tunj_budak=$_POST["tun_anak".$g];
$t6=substr($ta,0,2);
			$b6=substr($ta,3,2);
			$th6=substr($ta,6,4);
mysqli_query($mysqli,"update keluarga set nama='$ngaran',
		tempat_lahir='$dmn',tgl_lahir='$th6-$b6-$t6', dpt_tunjangan='$tunj_budak' 
		where id_pegawai=$od and id_keluarga=$budak and id_status='10'");

}
/* insert riwayat jabatan */

	if($_POST['nama_jabatan'] !=NULL )
{
	$jabatan = $_POST['nama_jabatan'];
	$unit_kerja = $_POST['unit_kerja'];
	$no_sk = $_POST['no_sk'];
	$tahun_masuk = $format->date_Ymd($_POST['tahun_masuk']);
	$tahun_keluar = $_POST['tahun_keluar'] ? $format->date_Ymd($_POST['tahun_keluar']) : '0000-00-00';
	//echo "tahun masuk : ".$_POST['tahun_masuk'];
	$sql =  "INSERT INTO riwayat_kerja(id_pegawai,Jabatan, unit_kerja, no_sk, tgl_masuk, tgl_keluar )
					VALUES('$id','$jabatan','$unit_kerja', '$no_sk', '$tahun_masuk','$tahun_keluar')";
	//echo $sql;
	if(mysqli_query($mysqli,$sql)){
		echo("<div align='center' class='alert alert-success'>riwayat jabatan sudah disimpan! </div> ");
	}else{
		echo("<div align='center' class='alert alert-danger'>riwayat jabatan GAGAL disimpan! </div> ");
	} 
}
/* EO insert riwayat jabatan*/
//update riwayat jabatan
$sqlcountrj = "select count(*) from riwayat_kerja where id_pegawai = '$id'";
$jum = mysqli_fetch_array(mysqli_query($mysqli,$sqlcountrj));
//echo "jumlah=>".$jum[0];
for($z=1; $z<=$jum[0] ; $z++){
	
	$id_riwayat_kerja = $_POST['id_riwayat_kerja'.'$z'];
	
	if($_POST['id_riwayat_kerja'.'$z']){
		echo "haloooo ".$id_riwayat_kerja;
	}
		
	$sqlupdaterj = "update riwayat_kerja SET
				jabatan = '".$_POST['nama_jabatan'.$z]."',
				unit_kerja = '".$_POST['unit_kerja'.$z]."',
				no_sk = '".$_POST['no_sk'.$z]."',
				tgl_masuk = '".$format->date_Ymd($_POST['tahun_masuk'.$z])."',
				tgl_keluar = '".$format->date_Ymd($_POST['tahun_keluar'.$z])."'
			WHERE id_riwayat_kerja = '".$_POST['id_riwayat_kerja'.$z]."'";
	

	mysqli_query($mysqli,$sqlupdaterj);
	
}

//end of update riwayat jabatan
//update sk

for($z=1;$z<=$jsk;$z++)
{
$nona=$_POST["nosk"."$z"];	
$tmtna=$_POST["tmsk"."$z"];	
$golna = $_POST["ket".$z];
$tglna=$_POST["tgsk"."$z"];
$sahna=$_POST["sah"."$z"];	
$idna=$_POST["idsk"."$z"];	
$berina=$_POST["beri"."$z"];
$iks=$_POST["a"."$z"];

	
$t8=substr($tglna,0,2);
			$b8=substr($tglna,3,2);
			$th8=substr($tglna,6,4);

$t9=substr($tmtna,0,2);
			$b9=substr($tmtna,3,2);
			$th9=substr($tmtna,6,4);			
			
mysqli_query($mysqli,"update sk set 
			no_sk='$nona',
			keterangan='$golna',
			tgl_sk='$th8-$b8-$t8',
			tmt='$th9-$b9-$t9',
			pengesah_sk='$sahna',
			pemberi_sk='$berina',id_kategori_sk=$iks where id_pegawai=$id and id_sk=$idna");

}

$t1=substr($pensiun,3,2);
			$b1=substr($pensiun,0,2);
			$th1=substr($pensiun,6,4);
		
for($v=1;$v<=$totalpen;$v++)
{

$tingpen=$_POST["tp"."$v"];
$lempen=$_POST["lem"."$v"];
$jurpen=$_POST["jur"."$v"];
$luspen=$_POST["lus"."$v"];
$idna=$_POST["idpen"."$v"];

$qlp=mysqli_query($mysqli,"select level_p from pendidikan where tingkat_pendidikan='$tingpen'");
	$lepel=mysqli_fetch_array($qlp);
	
	
	mysqli_query($mysqli,"update pendidikan set lembaga_pendidikan='$lempen',tingkat_pendidikan='$tingpen',jurusan_pendidikan='$jurpen',tahun_lulus=$luspen,level_p=$lepel[0] where id_pendidikan=$idna");
	
	
}			
			
if($aktif=='Mengundurkan Diri' or $aktif=='Pensiun Dini' or $aktif=='Pensiun Meninggal Dunia' or $aktif=='Pensiun Reguler' or $aktif=='Pindah Ke Instansi Lain')
mysqli_query($mysqli,"update pegawai set flag_pensiun=1,status_aktif='$aktif',tgl_pensiun_dini='$th1-$b1-$t1' where id_pegawai=$id2 ");


$t2=substr($tlanak,0,2);
			$b2=substr($tlanak,3,2);
			$th2=substr($tlanak,6,4);


//tambah sk
if($jnk!=NULL and $nsk!=NULL and $tmsk!=NULL and $tsk!=NULL)
{
if($pbsk==NULL)
$pbsk='-';

if($pgsk==NULL)
$pgsk='-';


$t10=substr($tsk,0,2);
			$b10=substr($tsk,3,2);
			$th10=substr($tsk,6,4);
			
$t11=substr($tmsk,0,2);
			$b11=substr($tmsk,3,2);
			$th11=substr($tmsk,6,4);
			
mysqli_query($mysqli,"insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,tmt,pemberi_sk,pengesah_sk) values ($id,$jnk,'$nsk','$th10-$b10-$t10','$th11-$b11-$t11','$pbsk','$pgsk')");

//echo("insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,tmt,pemberi_sk,pengesah_sk) values ($id,$jnk,'$nsk','$th10-$b10-$t10','$th11-$b11-$t11','$pbsk','$pgsk')");
}


	if($lembaga!=NULL and $jurusan!=NULL and $lulusan!=NULL)
	{
		
		$qlp=mysqli_query($mysqli,"select level_p from pendidikan where tingkat_pendidikan='$tingkat'");
		$lepel=mysqli_fetch_array($qlp);
		
		mysqli_query($mysqli,"insert into pendidikan (tingkat_pendidikan,lembaga_pendidikan,jurusan_pendidikan,id_pegawai,tahun_lulus,level_p) values ('$tingkat','$lembaga','$jurusan',$id2,$lulusan,$lepel[0])");
	}
	echo("<div align='center' class='alert alert-success'> data sudah disimpan! </div> ");
}
?>
<div id="reset_pasword" class="row">
	<?php
	
		if($reset_password=='true'){
			$obj_pegawai->reset_password($pegawai->id_pegawai);
		}
	?>
</div>
<form action="index3.php" method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" role="form" id="form1">
<div class="row">
	<div class="col-md-12">
		
		<div align="right">
			<?php if($is_tim){ ?>
				<a href="index3.php?x=box.php&od=<?php echo $od ?>&reset_password=true" onclick="return confirm('yakin akan mereset password pegawai ?');" class="btn btn-danger">reset password</a>
				<a href="index3.php?x=list2.php" class="btn btn-warning">kembali ke daftar pegawai</a>
			<?php } ?>
			<input type="submit" name="button" id="button" class="btn btn-primary" value="Simpan" />
		</div>
		<h4><?php echo $pegawai->nama ? $pegawai->nama : "" ?></h4>
	</div>
</div>
<div  class="row">
	<div class="col-md-12">
  <ul class="nav nav-tabs" role="tablist">   
	<li><a href="#biodata" role="tab" data-toggle="tab">Biodata</a></li>
	<li><a href="#biodata2" role="tab" data-toggle="tab">Biodata2</a></li>	
	<li><a href="#pendidikan" role="tab" data-toggle="tab">Pendidikan</a></li>
	<li><a href="#riwayat_keluarga" role="tab" data-toggle="tab">Keluarga</a></li>
	<li><a href="#riwayat_pangkat" role="tab" data-toggle="tab">Riwayat Pangkat</a></li>	
	<li><a href="#riwayat_diklat" role="tab" data-toggle="tab">Riwayat Diklat</a></li>
	<li><a href="#riwayat_jabatan" role="tab" data-toggle="tab">Riwayat Jabatan</a></li>
	<li><a href="#berkas_pegawai" role="tab" data-toggle="tab">Berkas Pegawai</a></li>
  </ul>
	
    <?php

		extract($_GET);
		$q=mysqli_query($mysqli,"select * from pegawai where id_pegawai=$od");
		$kuta=mysqli_fetch_array($q);

	?>
   <div class="tab-content">
    <div class="tab-pane <?php echo $od == 11301 ? '' : 'active'?>" id="biodata">
        <table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup table">
          <tr>
            <td align="left" valign="top"><?
            
			if(file_exists("../simpeg/foto/$od.jpg"))
					{
						echo "
							<div align=left>
								<img src='./foto/$od.jpg' width='100px' />
							</div>";
					}
			?></td>
            <td align="left" valign="top">&nbsp;</td>
            <td>&nbsp;</td>
            <td width="42" colspan="3" rowspan="22" align="left" valign="bottom">&nbsp;</td>
          </tr>
          <tr>
            <td width="21%" align="left" valign="top">Nama </td>
            <td width="3%" align="left" valign="top">:</td>
            <td width="28%"><label for="n"></label>
          
			<input name="n" type="text" id="n" <?php echo $is_tim ? '': 'disabled="disabled"'?> value="<?php echo($kuta[1]); ?>" size="35" /></td>
			
		 </tr>
		   <tr>
			<td align="left" valign="top">Gelar Depan</td>
            <td align="left" valign="top">:</td>
            <td><input name="gelar_depan" type="text" id="gelar_depan" value="<?php echo($kuta['gelar_depan']); ?>" <?php echo $is_tim ? '': 'disabled="disabled"'?>/></td>
		  </tr>
		  <tr>
			<td align="left" valign="top">Gelar Belakang</td>
            <td align="left" valign="top">:</td>
            <td><input name="gelar_belakang" type="text" id="gelar_belakang" value="<?php echo($kuta['gelar_belakang']); ?>" <?php echo $is_tim ? '': 'disabled="disabled"'?>/></td>
		  </tr>
          <tr>
            <td align="left" valign="top">NIP Lama</td>
            <td align="left" valign="top">:</td>
            <td><input name="nl" type="text" id="nl" value="<?php echo($kuta['nip_lama']); ?>" <?php echo $is_tim ? '': 'disabled="disabled"'?> /></td>
          </tr>
		  <tr>
            <td align="left" valign="top" nowrap="nowrap" disabled class="selected">NIP Baru</td>
            <td align="left" valign="top">:</td>
            <td><input name="nb" type="text" id="nb" value="<?php echo($kuta['nip_baru']); ?>" size="22" <?php echo $is_tim ? '': 'disabled="disabled"'?> /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Agama</td>
            <td align="left" valign="top">:</td>
            <td><select name="a" id="a" <?php echo $is_tim ? '': 'disabled="disabled"'?> >
              <?php
			  $qjo=mysqli_query($mysqli,"SELECT agama FROM `pegawai` where flag_pensiun=0 group by agama ");
                while($otoi=mysqli_fetch_array($qjo))
				{
					if($kuta['agama']==$otoi[0])
				echo("<option value=$otoi[0] selected>$otoi[0]</option>");
				else
				echo("<option value=$otoi[0]>$otoi[0]</option>");
				}
				
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Jenis Kelamin</td>
            <td align="left" valign="top">:</td>
            <td><select name="jk" id="jk" <?php echo $is_tim ? '': 'disabled="disabled"'?> >
              <?php
			  $qp=mysqli_query($mysqli,"SELECT jenis_kelamin FROM `pegawai` where flag_pensiun=0 group by jenis_kelamin ");
                while($oto=mysqli_fetch_array($qp))
				{
					if($kuta['jenis_kelamin']==$oto[0])
				echo("<option value=$oto[0] selected>$oto[0]</option>");
				else
				echo("<option value=$oto[0]>$oto[0]</option>");
				}
				
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Tempat Lahir</td>
            <td align="left" valign="top">:</td>
            <td><input name="tl" type="text" id="tl" value="<?php echo($kuta['tempat_lahir']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Tanggal Lahir</td>
            <td align="left" valign="top">:</td>
            <td><label for="tgl"></label>
            <input name="tgl" type="text" class="tcal"  id="tgl" value="<?php 
			$tgl=substr($kuta['tgl_lahir'],8,2);
			$bln=substr($kuta['tgl_lahir'],5,2);
			$thn=substr($kuta['tgl_lahir'],0,4);
			echo("$tgl-$bln-$thn");
			 ?>" /></td>
          </tr>
          
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Kartu Pegawai</td>
            <td align="left" valign="top">:</td>
            <td>
				<input name="karpeg" type="text" id="karpeg" value="<?php echo($kuta['no_karpeg']); ?>" />				
			</td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">NPWP</td>
            <td align="left" valign="top">:</td>
            <td><input name="npwp" type="text" id="npwp" value="<?php echo($kuta['NPWP']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Gol / Ruang</td>
            <td align="left" valign="top">:</td>
            <td><select  name="gol" id="gol" <?php echo $is_tim ? '': 'disabled="disabled"'?> >
              <?php
			  $qp=mysqli_query($mysqli,"SELECT pangkat_gol FROM `pegawai` where flag_pensiun=0 group by pangkat_gol ");
                while($oto=mysqli_fetch_array($qp))
				{
					if($kuta['pangkat_gol']==$oto[0])
				echo("<option value=$oto[0] selected>$oto[0]</option>");
				else
				echo("<option value=$oto[0]>$oto[0]</option>");
				}
				
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Unit Kerja</td>
            <td align="left" valign="top">:</td>
            <td><?php
            $qu=mysqli_query($mysqli,"select nama_baru,unit_kerja.id_unit_kerja from unit_kerja inner join current_lokasi_kerja on current_lokasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja where id_pegawai=$kuta[0]");
			$unit=mysqli_fetch_array($qu);
			echo($unit[0]);
			?></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Jenjang Jabatan</td>
            <td align="left" valign="top">:</td>
            <td><label for="jenjab"></label>
              <select name="jenjab" id="jenjab">
              <?php
			  $qjo=mysqli_query($mysqli,"SELECT jenjab FROM `pegawai` where flag_pensiun=0 group by jenjab ");
                while($oto=mysqli_fetch_array($qjo))
				{
					if($kuta['jenjab']==$oto[0])
				echo("<option value=$oto[0] selected>$oto[0]</option>");
				else
				echo("<option value=$oto[0]>$oto[0]</option>");
				}				
				?>
            </select></td>
          </tr>
          <tr>
          	<td align="left" valign="top" nowrap="nowrap">Jabatan Atasan</td>
            <td align="left" valign="top">:</td>
            <td><label for="jenjab"></label>
            <select name="jx" id="jx">            
            <?php
			$qrk=mysqli_query($mysqli,"select id_j_bos,id_riwayat from riwayat_mutasi_kerja inner join sk on sk.id_sk=riwayat_mutasi_kerja.id_sk where sk.id_pegawai=$od order by tmt desc");
			$rk=mysqli_fetch_array($qrk);
			$qbener=mysqli_query($mysqli,"select id_skpd from unit_kerja where id_unit_kerja=$unit[1]");
			$bener=mysqli_fetch_array($qbener);
			$qjob=mysqli_query($mysqli,"select id_j,jabatan from jabatan inner join unit_kerja on unit_kerja.id_unit_kerja=jabatan.id_unit_kerja where id_skpd=$bener[0]");
			while($job=mysqli_fetch_array($qjob))
			{
			if($rk[0]==$job[0])	
			echo("<option value=$job[0] selected>$job[1]</option>");
			else
			echo("<option value=$job[0]> $job[1]</option>");
			}
			?>
            </select>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Telepon</td>
            <td align="left" valign="top">:</td>
            <td><input name="telp" type="text" id="telp" value="<? echo($kuta['telepon']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Ponsel</td>
            <td align="left" valign="top">:</td>
            <td><input name="hp" type="text" id="hp" value="<? echo($kuta['ponsel']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Email</td>
            <td align="left" valign="top">:</td>
            <td><input name="email" type="text" id="email" value="<?php echo($kuta['email']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Alamat
            <input name="id2" type="hidden" id="id2" value="<?php echo($od);  ?>" />
            <input name="id" type="hidden" id="id" value="<?php echo($od);  ?>" />
            <input name="x" type="hidden" id="x" value="box.php" />
            <input name="od" type="hidden" id="od" value="<?php echo("$od");  ?>" />
            <input name="rmk" type="hidden" id="rmk" value="<?php echo("$rk[1]");  ?>" /></td>
            <td align="left" valign="top">:</td>
            <td><textarea class="hurup" name="al" id="al" cols="45" rows="3"><?php echo($kuta['alamat']); ?></textarea></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Kota</td>
            <td align="left" valign="top">:</td>
            <td><input name="kota" type="text" id="kota" value="<?php echo($kuta['kota']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Golongan Darah</td>
            <td align="left" valign="top">:</td>
            <td><select name="darah" id="darah">
              <?php
			  $qd=mysqli_query($mysqli,"SELECT gol_darah FROM `pegawai` where flag_pensiun=0 group by gol_darah order by gol_darah ");
                //echo "<option>-PILIH-</option>";
				while($da=mysqli_fetch_array($qd))
				{
					if($kuta['gol_darah']==$da[0])
						echo("<option value=$da[0] selected>$da[0]</option>");
					else
						echo("<option value=$da[0]>$da[0]</option>");
				}
				
				?>
            </select></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Jabatan</td>
            <td align="left" valign="top">:</td>
            <td><?php
			if($kuta['id_j']>0)
			{
			$qj=mysqli_query($mysqli,"select * from jabatan where id_j=$kuta[id_j]");
			$jab=mysqli_fetch_array($qj);
			$ab=$jab[1];
			$es=$jab[4];
			}
			else
			{
            $ab=$kuta['jabatan'];
			$es="-";
			}
			echo("$ab");
			?></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Tgl Pensiun Reguler</td>
            <td align="left" valign="top">:</td>
            <td><input name="pensiun" type="text" class="tcal"  id="pensiun" value="<? 
			$tgl=substr($kuta['tgl_pensiun_dini'],8,2);     
			$bln=substr($kuta['tgl_pensiun_dini'],5,2);
			$thn=substr($kuta['tgl_pensiun_dini'],0,4);
			echo("$tgl-$bln-$thn");
			 ?>" <?php echo $is_tim ? '': 'disabled="disabled"'?> /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Eselonering</td>
            <td align="left" valign="top">:</td>
            <td><? echo("$es"); ?></td>
          </tr>		 
        </table>
 
    </div>
	<div class="tab-pane active" id="biodata2">
		<?php include 'modul/biodata.php'; ?>
	</div>
	
	<div class="tab-pane" id="pendidikan">
      <table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup table">
        <tr>
          <td>No</td>
          <td>Tingkat Pendidikan</td>
          <td>Lembaga Pendidikan</td>
          <td>Jurusan</td>
          <td>Tahun Lulus</td>
      
        <?php
		$j=1;
		$qp=mysqli_query($mysqli,"select * from pendidikan where id_pegawai=$od order by level_p");
		while($pen=mysqli_fetch_array($qp))
		{
			echo("<tr>
          <td>$j</td>
          <td>"); ?>
          <select name="tp<? echo($j); ?>" id="tp<? echo($j); ?>">
            <?php
			  $qjo2=mysqli_query($mysqli,"SELECT tingkat_pendidikan FROM `pendidikan` where tingkat_pendidikan!=' '   group by tingkat_pendidikan ");
                while($otoi2=mysqli_fetch_array($qjo2))
				{
				if(trim($pen[3])==trim($otoi2[0]))
				echo("<option value=$otoi2[0] selected>$otoi2[0]</option>");
				else
				echo("<option value=$otoi2[0]>$otoi2[0]</option>");
				}
				
				?>
          </select>
          
		  <?php
	
		 echo("</td>
          <td><input type=text name=lem$j id=lem$j value='$pen[2]' /></td>
          <td><input type=text name=jur$j id=jur$j value='$pen[4]' /></td>
          <td><input type=text name=lus$j id=lus$j value='$pen[5]' /> <input type=hidden name=idpen$j id=idpen$j value=$pen[0] /></td>
        </tr>");
		
			$j++;
		}
		$totpen=$j-1;
		
		?>
          </tr>
        <tr>
          <td>+</td>
          <td><select name="tingkat" id="tingkat">
            <?php
			  $qjo2=mysqli_query($mysqli,"SELECT tingkat_pendidikan FROM `pendidikan` where tingkat_pendidikan!=' '   group by tingkat_pendidikan ");
                while($otoi2=mysqli_fetch_array($qjo2))
				echo("<option value=$otoi2[0]>$otoi2[0]</option>");
							
				?>
          </select>
            <input name="totalpen" type="hidden" id="totalpen" value="<? echo($totpen); ?>" /></td>
          <td><label for="lembaga"></label>
            <input type="text" name="lembaga" id="lembaga" /></td>
          <td><input type="text" name="jurusan" id="jurusan" /></td>
          <td><input type="text" name="lulusan" id="lulusan" /></td>
          </tr>
      </table>
    </div>
		<!-- tab riwayat keluarga -->
    <div class="tab-pane" id="riwayat_keluarga" <?php echo $t == 2 ? 'active' : ''?>>
			<?php include('riwayat_keluarga.php') ?>
		</div>		
		<!-- end tab riwayat keluarga -->
		
		<!--tab riwayat pangkat -->
		<div class="tab-pane" id="riwayat_pangkat">
			<?php include('riwayat_pangkat.php'); ?>
		</div>
		<!--end riwayat pangkat-->
        <!-- tab berkas pegawai -->
         <div class="tab-pane" id="berkas_pegawai">
          <table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup table">
            <tr>
              <td>No</td>
              <td>Jenis SK</td>
              <td nowrap="nowrap">No SK</td>
			  <td>Gol,MK_thn,MK_bln</td>
              <td>Tanggal SK</td>
              <td>TMT SK</td>
              <td>Pengesah SK</td>
              <td>Pemberi SK</td>
              <td>Berkas Digital</td>
            </tr>
           
            <?php
			$k=1;
			$qsk=mysqli_query($mysqli,"select * from sk where id_pegawai=$od order by tmt desc, id_kategori_sk");
			while($cu=mysqli_fetch_array($qsk))
			{
				$qt=mysqli_query($mysqli,"select nama_sk from kategori_sk where id_kategori_sk=$cu[2]");
				$tipe=mysqli_fetch_array($qt);
				echo("  <tr>
              <td>$k</td>
              <td>"); ?> 
			  <select name="a<? echo($k); ?>" id="a<? echo($k); ?>" style="width:160px;" >
              <?php
			  $nama_berkas = "";
			  
			  $qks=mysqli_query($mysqli,"SELECT * FROM `kategori_sk`");
                while($da=mysqli_fetch_array($qks))
				{
					if($cu[2]==$da[0])
					{
						echo("<option value=$da[0] selected>$da[1]</option>");
						$nama_berkas = $da[1];
					}
					else
						echo("<option value=$da[0]>$da[1]</option>");
				}
				
				?>
            </select>
			  <?php 
			  
			  $tsk1=substr($cu[4],8,2);
			  $bsk1=substr($cu[4],5,2);
			  $thsk1=substr($cu[4],0,4);
			  
			  $tsk2=substr($cu[8],8,2);
			  $bsk2=substr($cu[8],5,2);
			  $thsk2=substr($cu[8],0,4);
			  
			  echo("</td>
              <td nowrap> <input type=text name=nosk$k id=nosk$k value='$cu[3]' style=width:180px; class=hurup /> </td>
              <td><input type=text name=ket$k id=ket$k value='$cu[keterangan]'  style=width:90px; /></td>
			  <td><input type=text name=tgsk$k id=tgsk$k value=$tsk1-$bsk1-$thsk1 class=tcal style=width:90px; /></td>              
			  <td><input type=text name=tmsk$k id=tmsk$k value=$tsk2-$bsk2-$thsk2 class=tcal style=width:90px; /></td>
			   <td nowrap> <input type=text name=sah$k id=sah$k value='$cu[6]' style=width:100px;class=hurup /> </td>
				<td nowrap> <input type=text name=beri$k id=beri$k value='$cu[5]' style=width:100px; class=hurup />
				  
				  <input type=hidden name=idsk$k id=idsk$k value=$cu[0] />
				   </td>
              <td>");
			if($cu[10]==NULL or $cu[10]==0)
			{
			  echo("<a href='index3.php?x=uploader_berkas.php&id_sk=$cu[id_sk]&nama_berkas=$nama_berkas&tgl_berkas=$tsk1-$bsk1-$thsk1&od=$_REQUEST[od]' target=''>UPLOAD</a> </td>");
			}
			else
			  //echo("<a href=file.php?idb=$cu[10] target=_blank>Lihat</a></td>");
			  echo("<a href='index3.php?x=uploader_berkas.php&id_b=$cu[10]&nama_berkas=$nama_berkas&tgl_berkas=$tsk1-$bsk1-$thsk1&od=$_REQUEST[od]' target=''>View</a> </td>");
			  
            echo("</tr>");
				$k++;
				}
			
			?>
            <input type="hidden" name="jsk" value="<? $jambleh=$k-1; echo($jambleh); ?>" id="jsk" />
             <tr>
              <td>+</td>
              <td><label for="select"></label>
                <select name="jnk" id="jnk" style="width:160px;">
                <?php
				
				 $qks2=mysqli_query($mysqli,"SELECT * FROM `kategori_sk`");
                while($da=mysqli_fetch_array($qks2))
				echo("<option value=$da[0]>$da[1]</option>");
				?>
               </select></td>
              <td nowrap="nowrap"><label for="textfield"></label>
               <input type="text" name="nsk" id="nsk" style="width:160px;" /></td>
              <td><label for="select"></label>
                <input type="text" name="tsk" id="tsk" class="tcal" style="width:100px;" /></td>
              <td><input type="text" name="tmsk" id="tmsk" class="tcal" style="width:100px;" /></td>
              <td>
              <input type="text" name="pgsk" id="pgsk"  style="width:100px;" />
              </td>
              <td><input type="text" name="pbsk" id="pbsk"  style="width:100px;" /></td>
              <td>
              </td>
            </tr>
          </table>
        
        </div>
		<!-- Tab Riwayat Diklat -->
			<div class="tab-pane" id="riwayat_diklat">
				<fieldset>
					<legend> Riwayat Diklat </legend>
					<?php $id = $od; ?>
					<?php  include("riwayat_diklat.php"); ?> 
				</fieldset>
			</div>
		<!-- end of Riwayat Diklat -->
        <!-- Tab Riwayat Jabatan2 -->
			<div class="tab-pane" id="riwayat_jabatan">
				<fieldset>
					<legend> Riwayat Jabatan </legend>
					
					<?php  include("riwayat_jabatan2.php"); ?> 
				</fieldset>
			</div>
		<!-- end of Riwayat jabatan2 -->
  </div>

     </form>
	</div>
</div>

<?php
}
else
	echo("<div align='center' class='alert alert-danger'> Restricted Access </div>");	

?>

