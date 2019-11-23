<link href="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />
<script src="js/moment.js"></script>
<script src="assets/js/moment_langs.js"></script>
	<script src="assets/js/combodate.js"></script>
<script src="js/bootstrap-datetimepicker-master/bootstrap-datetimepicker.min.js"></script>
<style>
#container {
    display: block;
    position:relative;
		width: 100%;
}

.ui-autocomplete {
	position: absolute !important;
    margin-top: 0px !important;
    top: 0px !important;
	left: 0;
    z-index: 1000;
    float: left;
    display: none;
    min-width: 160px;
    width: 400px;
    max-height: 300px;
	overflow-y: auto;
	/* prevent horizontal scrollbar */
	overflow-x: auto;
}

.ui-menu-item > a.ui-corner-all {
        display: inline;
        padding: 3px 15px;
        clear: both;
        font-weight: normal;
        line-height: 18px;
        color: #555555;
        white-space: nowrap;
}
</style>
<script type="text/javascript">



function reset_imei(id_pegawai){

	swal({
		  title: "Anda Yakin untuk menghapus?",
		  text: "Data tidak bisa di kembalikan!",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "Hapus!",
		  closeOnConfirm: false
		},
		function(){
		  //swal("Deleted!", "Your imaginary file has been deleted.", "success");
		  $.post("reset_imei.php", {"id_pegawai": id_pegawai}, function (data) {
            if(data == '1'){
				//$("#divreset").html("-");
				swal("Deleted!", "Berhasil menghapus IMEI.", "success");
			}else{
				swal("GAGAL!", " Gagal menghapus IMEI.", "warning");
			}
        });
		});

}

$( "#nama_jfu_auto" ).autocomplete({
	source: function( request, response ) {
				$.ajax({
					  url: "prosesjfu.php",
					  dataType: "json",
					  data: {
					    q: request.term
					  },
					  success: function( data ) {
					    response($.map(data, function(item) {
                                return {
                                    label: item.nama_jfu,
                                    value: item.nama_jfu,
									kode_jabatan: item.kode_jabatan,
									id_jfu: item.id_jfu
                                    };
                            }));//response
					  }
				});
			},
	appendTo: "#container",
	select: function(event, ui) {

        $('#kode_jabatan').val(ui.item.kode_jabatan);
				$('#id_jfu').val(ui.item.id_jfu);
    }


});
</script>
<?php
include('library/format.php');
include('class/pegawai.php');
date_default_timezone_set("Asia/Jakarta");
$format = new Format;

//$pegawai = new Pegawai;
$obj_pegawai = new Pegawai;
$pegawai = $obj_pegawai->get_obj($od);

// Turn off all error reporting
//error_reporting(0);
extract($_POST);
extract($_GET);

$q1=mysqli_query($mysqli,"select unit_kerja.id_unit_kerja, nama, id_skpd,flag_jadwal_dinamis
				from current_lokasi_kerja
				inner join pegawai on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai
				inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja
				where current_lokasi_kerja.id_pegawai=$_SESSION[id_pegawai]");

$_SESSION['selected_id_pegawai'] = $_REQUEST['od'];

$p1=mysqli_fetch_array($q1);

$q2=mysqli_query($mysqli,"select id_skpd from current_lokasi_kerja inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja where id_pegawai=$od");
$p2=mysqli_fetch_array($q2);


if(isset($id2))
{

	$t0=substr(@$tglwin,0,2);
	$b0=substr(@$tglwin,3,2);
	$th0=substr(@$tglwin,6,4);
	$t_menikah=substr(@$tgl_menikah,0,2);
	$b_menikah=substr(@$tgl_menikah,3,2);
	$th_menikah=substr(@$tgl_menikah,6,4);
	$skr=date("Y-m-d H:i:s");
	$update_pegawai = "update pegawai set
			nama='".@$n."',
			gelar_depan='".@$gelar_depan."',
			gelar_belakang='".@$gelar_belakang."',
			nip_lama='".@$nl."',
			email='".@$email."',
			alamat='".@$al."',
			agama='".@$a."',
			tempat_lahir='".@$tl."',
			tgl_lahir='".@$format->date_Ymd(@$tgl_lahir_pns)."',
			no_karpeg='".@$karpeg."',
			no_karisu='".@$karisu."',
			no_ktp='".@$ktp."',
			NPWP='".@$npwp."',
			ponsel='".@$hp."',telepon='".@$telp."',
			jenjab='".@$jenjab."',
			kota='".@$kota."',
			gol_darah='".@$darah."',
			jumlah_transit=$toefl,
			timestamp='".@$skr."',keterangan='updated by ".@$p1[1]."',
			status_kawin='".@$kawin."',
			jenis_kelamin='".@$jk_pns."'
			where id_pegawai=".@$id2;


$update_pegawai2 = "update pegawai set
					tempat_lahir='$tl',
					tgl_lahir='".$format->date_Ymd($tgl_lahir_pns)."',
					email='$email',
					alamat='$al',
					NPWP='$npwp',
					no_ktp='$ktp',
					jumlah_transit=$toefl,
					ponsel='$hp',telepon='$telp',
					gol_darah='$darah',
					kota='$kota',
					jenis_kelamin='$jk_pns',
					timestamp='$skr',keterangan='updated by $p1[1]'
					where id_pegawai=$id2
					";

if($is_tim == TRUE){

	if(mysqli_query($mysqli,$update_pegawai)){
		$pegawai = $obj_pegawai->get_obj($od);


	}
	//echo "true";
}else{
	if(mysqli_query($mysqli,$update_pegawai2)){
		$pegawai = $obj_pegawai->get_obj($od);
		//echo $update_pegawai2;
	}
	//echo "false";

}

//insert jadwal
if(@$jam1!=0 and @$jam2!=0 and @$menit1!=0 and @$menit2!=0)
{





$t1=substr($tanggal1,0,2);
$b1=substr($tanggal1,3,2);
$th1=substr($tanggal1,6,4);


$t2=substr($tanggal2,0,2);
$b2=substr($tanggal2,3,2);
$th2=substr($tanggal2,6,4);

mysqli_query($mysqli,"insert into jadwal_transaksi (id_pegawai,id_jadwal,id_unit_kerja,tgl_masuk,tgl_keluar,tgl_insert,id_pegawai_input) values ($id2,$jenisab,$p1[0],'$th1-$b1-$t1 $jam1:$menit1:00','$th2-$b2-$t2 $jam2:$menit2:00',CURDATE(),$_SESSION[id_pegawai])");







}
else
//echo("insert into jadwal_transaksi (id_pegawai,id_jadwal,id_unit_kerja,tgl_masuk,tgl_keluar,tgl_insert,id_pegawai_input) values ($id2,$jenisab,$p1[0],'$th1-$b1-$t1 $jam1:$menit1:00','$th2-$b2-$t2 $jam2:$menit2:00',CURDATE(),$_SESSION[id_pegawai])");

//update jabatan
$qryjml = mysqli_query($mysqli,"select count(*) from jfu_pegawai where id_pegawai = @$id2");
$get=mysqli_fetch_array($qryjml);
mysqli_query($mysqli,"insert into jfu_pegawai(id_pegawai, id_jfu, kode_jabatan, jabatan, tmt, keterangan) values (@$id2, ".@$id_jfu.",'".@$kode_jabatan."', '".@$nama_jfu_auto."','".@$format->date_Ymd(@$tmt_jfu)."','')");
/*
if($get[0] > 0){
	mysqli_query($mysqli,"update jfu_pegawai set kode_jabatan = '$nama_jfu' where id_jfu = '$id_jfu_p' or id_pegawai = $id2");
	//echo ("update jfu_pegawai set kode_jabatan = '$nama_jfu' where id_jfu = '$id_jfu_p' or id_pegawai = $id2");
}else{
	mysqli_query($mysqli,"insert into jfu_pegawai(id_pegawai, kode_jabatan, keterangan) values ($id2, '$nama_jfu', '')");
}
*/

//update atasan
mysqli_query($mysqli,"update riwayat_mutasi_kerja set id_j_bos=$jx where id_riwayat=$rmk");




//update anak
for($g=1;$g<=@$ja;$g++)
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

//update absen dinamis

mysqli_query($mysqli,"update current_lokasi_kerja set flag_jadwal_dinamis=".@$absen." where id_pegawai = $id2");

//update hobby
for($y=1;$y<=@$th;$y++)
{
$ho=@$_POST["c"."$y"];
if($ho!=NULL)
{
$qcek1=mysqli_query($mysqli,"select count(*) from hobby_pegawai where id_pegawai=$_SESSION[id_pegawai] and id_hobby=$ho");
$cek1=mysqli_fetch_array($qcek1);

if($cek1[0]==0)
mysqli_query($mysqli,"insert into hobby_pegawai (id_pegawai,id_hobby) values ($_SESSION[id_pegawai],$ho)");

}
else
{
$qcek1=mysqli_query($mysqli,"select count(*) from hobby_pegawai where id_pegawai=$_SESSION[id_pegawai] and id_hobby=$y");
$cek1=mysqli_fetch_array($qcek1);

if($cek1[0]>0)
mysqli_query($mysqli,"delete from hobby_pegawai where id_pegawai=$_SESSION[id_pegawai] and id_hobby=$y");


}
}

/* insert riwayat jabatan */

	if(@$_POST['nama_jabatan'] !=NULL )
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

/* EO insert riwayat jabatan*/
//update riwayat jabatan

$sqlcountrj = "select count(*) from riwayat_kerja where id_pegawai = '$id'";
$jum = mysqli_fetch_array(mysqli_query($mysqli,$sqlcountrj));
//echo "jumlah=>".$jum[0];
for($z=1; $z<=$jum[0] ; $z++){
	$id_riwayat_kerja = $_POST['id_riwayat_kerja'.'$z'];
	if($_POST['id_riwayat_kerja'.'$z']){
		//echo "haloooo ".$id_riwayat_kerja;
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
}
/* Start Riwayat Diklat */
    if(@$_POST['jns_diklat'] !=NULL and @$_POST['nama_diklat'] !=NULL)
    {
        $jns_diklat = $_POST['jns_diklat'];
        $nama_diklat = $_POST['nama_diklat'];
        $tgl_diklat = $_POST['tgl_diklat'];
		$tgl_diklat = substr($tgl_diklat,6,4).'-'.substr($tgl_diklat,3,2).'-'.substr($tgl_diklat,0,2);
        $jumlah_jam = $_POST['jumlah_jam'];
        $penyelenggara = $_POST['penyelenggara'];
        $no_sttpl	= $_POST['no_sttpl'];
        $sql =  "INSERT INTO diklat(id_pegawai,id_jenis_diklat, tgl_diklat, jml_jam_diklat, keterangan_diklat, nama_diklat, nama_diklat2, penyelenggara_diklat, no_sttpl )
					VALUES($id,'$jns_diklat','$tgl_diklat', $jumlah_jam, '-', '$nama_diklat', '$nama_diklat', '$penyelenggara', '$no_sttpl')";
        if(mysqli_query($mysqli,$sql)){
			$iddiklat=mysqli_insert_id();
            echo("<div align='center' class='alert alert-success'>riwayat diklat sudah disimpan! </div> ");
			if(@$_FILES["filediklat"]['name'] <> "" ){
				if(@$_FILES["filediklat"]['type']=='binary/octet-stream' or @$_FILES["filediklat"]['type'] == "application/pdf" or @$_FILES["filediklat"]['type'] == "image/jpeg" or @$_FILES["filediklat"]['type'] == "image/jpg" or @$_FILES["filediklat"]['type'] == "image/png" ){
					if(@$_FILES["filediklat"]['size'] > 20097152) {
						echo "<span style='color: #3c3f41'>Ukuran file maksimum 2 MB</span>";
					}else{
						$uploaddir = dirname($_SERVER['SCRIPT_FILENAME']).'/berkas/';
						$uploadfile = $uploaddir . basename(@$_FILES["filediklat"]['name']);
						if (move_uploaded_file(@$_FILES["filediklat"]['tmp_name'], $uploadfile)) {
							$sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) ".
									"values ($id, 6,'Sertifikat', DATE(NOW()), '$pegawai->nama', NOW(), '')";
							mysqli_query($mysqli,$sqlInsert);
							$idberkas=mysqli_insert_id();
							$sqlUpdate = "update diklat set id_berkas = $idberkas where id_diklat=$iddiklat";
							mysqli_query($mysqli,$sqlUpdate);
							$sqlInsert = "insert into isi_berkas (id_berkas, ket) values ($idberkas, 'Sertifikat')";
							mysqli_query($mysqli,$sqlInsert);
							$idisi=mysqli_insert_id();
							if(@$_FILES["filediklat"]['type'] == "application/pdf")
								$ext=".pdf";
							elseif(@$_FILES["filediklat"]['type'] == "image/jpeg" or @$_FILES["filediklat"]['type'] == "image/jpg")
								$ext=".jpg";
							elseif(@$_FILES["filediklat"]['type'] == "image/png")
								$ext=".png";

							$nf=$pegawai->nip_baru."-".$idberkas."-".$idisi."$ext";
							$sqlUpdate = "update isi_berkas set file_name='$nf' where id_isi_berkas=$idisi";
							mysqli_query($mysqli,$sqlUpdate);
							rename($uploadfile,"./berkas/".$nf);
						} else {
							echo "<span style='color: #3c3f41'>Upload sertifikat tidak berhasil</span>";
						}
					}
				}else{
					echo "<span style='color: #3c3f41'>File tidak terupload. Tipe file belum sesuai</span>";
				}
			}
        }else{
            echo("<div align='center' class='alert alert-danger'>riwayat diklat GAGAL disimpan! </div> ");
        }
    }
    $sqlcountrd = "select count(*) from diklat where id_pegawai = $id";
    $jum_diklat = mysqli_fetch_array(mysqli_query($mysqli,$sqlcountrd));

    for($z=1; $z<=$jum_diklat[0] ; $z++){
		$sttpl=@$_POST['no_sttpl'.$z];
        $id_diklat = @$_POST['id_ri'.'$z'];
		$tgl_diklat =@ $_POST['tgl_diklat'.$z];
		$tgl_diklat = substr($tgl_diklat,6,4).'-'.substr($tgl_diklat,3,2).'-'.substr($tgl_diklat,0,2);
        $sqlupdaterd = "update diklat SET
				id_jenis_diklat = '".@$_POST['jenis_diklat'.$z]."',
				tgl_diklat = '".$tgl_diklat."',
				jml_jam_diklat = '".@$_POST['jumlah_jam'.$z]."',
				keterangan_diklat = '-',
				nama_diklat = '".@$_POST['nama_diklat'.$z]."',
				nama_diklat2 = '".@$_POST['nama_diklat'.$z]."',
				penyelenggara_diklat = '".@$_POST['penyelenggara'.$z]."',
				no_sttpl = '$sttpl'
			WHERE id_diklat = ".@$_POST['id_ri'.$z]."";
        mysqli_query($mysqli,$sqlupdaterd);

		if(@$_FILES["filediklat".$z]['name'] <> "" ){
			if(@$_FILES["filediklat".$z]['type']=='binary/octet-stream' or @$_FILES["filediklat".$z]['type'] == "application/pdf" or @$_FILES["filediklat".$z]['type'] == "image/jpeg" or @$_FILES["filediklat".$z]['type'] == "image/jpg" or @$_FILES["filediklat".$z]['type'] == "image/png" ){
				if(@$_FILES["filediklat".$z]['size'] > 20097152) {
					echo "<span style='color: #3c3f41'>Ukuran file maksimum 2 MB</span>";
				}else{
					$uploaddir = dirname($_SERVER['SCRIPT_FILENAME']).'/berkas/';
					$uploadfile = $uploaddir . basename(@$_FILES["filediklat".$z]['name']);
					if (move_uploaded_file(@$_FILES["filediklat".$z]['tmp_name'], $uploadfile)) {
						$sqlDiklat = "SELECT id_berkas FROM diklat WHERE id_diklat = ".$_POST['id_ri'.$z];
						$idberkas_diklat = mysqli_fetch_array(mysqli_query($mysqli,$sqlDiklat));

						if($idberkas_diklat[0]<>"" and $idberkas_diklat[0]<>"0"){
							mysqli_query($mysqli,"delete from berkas where id_berkas = ".$idberkas_diklat[0]);
							mysqli_query($mysqli,"delete from isi_berkas where id_berkas = ".$idberkas_diklat[0]);
						}
						$sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) ".
								"values ($id, 6,'Sertifikat', DATE(NOW()), '$pegawai->nama', NOW(), '')";
						mysqli_query($mysqli,$sqlInsert);
						$idberkas=mysqli_insert_id();
						$sqlUpdate = "update diklat set id_berkas = $idberkas where id_diklat=".$_POST['id_ri'.$z];
						mysqli_query($mysqli,$sqlUpdate);
						$sqlInsert = "insert into isi_berkas (id_berkas, ket) values ($idberkas, '$tingpen')";
						mysqli_query($mysqli,$sqlInsert);
						$idisi=mysqli_insert_id();
						if(@$_FILES["filediklat".$z]['type'] == "application/pdf")
							$ext=".pdf";
						elseif(@$_FILES["filediklat".$z]['type'] == "image/jpeg" or @$_FILES["filediklat".$z]['type'] == "image/jpg")
							$ext=".jpg";
						elseif(@$_FILES["filediklat".$z]['type'] == "image/png")
							$ext=".png";

						$nf=$pegawai->nip_baru."-".$idberkas."-".$idisi."$ext";
						$sqlUpdate = "update isi_berkas set file_name='$nf' where id_isi_berkas=$idisi";
						mysqli_query($mysqli,$sqlUpdate);
						rename($uploadfile,"./berkas/".$nf);
					} else {
						echo "<span style='color: #3c3f41'>Upload sertifikat tidak berhasil</span>";
					}
				}
			}else{
				echo "<span style='color: #3c3f41'>File tidak terupload. Tipe file belum sesuai</span>";
			}
		}


    }

/* End Riwayat Diklat */

$jsk=@$_POST["jsk"];

//update sk
for($z=1;$z<=$jsk;$z++)
{


$nona=@$_POST["nosk"."$z"];
$tmtna=@$_POST["tmsk"."$z"];
//$golna = $_POST["ket".$z];
$tglna=@$_POST["tgsk"."$z"];
$sahna=@$_POST["sah"."$z"];
$idna=@$_POST["idsk"."$z"];
$berina=@$_POST["beri"."$z"];
$iks=@$_POST["a"."$z"];

$cboGol = @$_POST["gol_sk"."$z"];
$thnMkg = @$_POST["thn_mkg"."$z"];
$blnMkg = @$_POST["bln_mkg"."$z"];
if($thnMkg==""){
    $thnMkg = 0;
}
if($blnMkg==""){
    $blnMkg = 0;
}

$golna = $cboGol.','.$thnMkg.','.$blnMkg;



$t8=substr($tglna,0,2);
			$b8=substr($tglna,3,2);
			$th8=substr($tglna,6,4);

$t9=substr($tmtna,0,2);
			$b9=substr($tmtna,3,2);
			$th9=substr($tmtna,6,4);

$query_update_sk = ("update sk set
			no_sk='$nona',
			keterangan='$golna',
			catatan='$golna',
			gol='$cboGol',
			mk_tahun='$thnMkg',
			mk_bulan='$blnMkg',
			tgl_sk='$th8-$b8-$t8',
			tmt='$th9-$b9-$t9',
			pengesah_sk='$sahna',
			pemberi_sk='$berina',id_kategori_sk=$iks where id_pegawai=$id and id_sk=$idna");

//echo $query_update_sk;
 //mysqli_query($mysqli,$query_update_sk);



}

$t1=substr(@$pensiun,3,2);
			$b1=substr(@$pensiun,0,2);
			$th1=substr(@$pensiun,6,4);

//update pendidikan +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
for($v=1;$v<=@$totalpen;$v++)
{

$tingpen=@$_POST["tp"."$v"];
$lempen=@$_POST["lem"."$v"];
$jurpen=@$_POST["jur"."$v"];
$luspen=@$_POST["lus"."$v"];
$tglijazah=@$_POST["tgl_ijazah"."$v"];
$noijazah=@$_POST["no_ijazah"."$v"];
$idna=@$_POST["idpen"."$v"];

$qlp=mysqli_query($mysqli,"select level_p from pendidikan where tingkat_pendidikan='$tingpen'");
$lepel=mysqli_fetch_array($qlp);

	mysqli_query($mysqli,"update pendidikan
				set lembaga_pendidikan='$lempen',
				tingkat_pendidikan='$tingpen',
				jurusan_pendidikan='$jurpen',
				tahun_lulus='$luspen',
				tgl_ijazah='$tglijazah',
				no_ijazah='$noijazah',
				level_p=$lepel[0] where id_pendidikan=$idna");

    if(@$_FILES["fipen"."$v"]['name'] <> "" ){
        if(@$_FILES["fipen"."$v"]['type']=='binary/octet-stream' or @$_FILES["fipen"."$v"]['type'] == "application/pdf" or @$_FILES["fipen"."$v"]['type'] == "image/jpeg" or @$_FILES["fipen"."$v"]['type'] == "image/jpg" or @$_FILES["fipen"."$v"]['type'] == "image/png" ){
            if(@$_FILES["fipen"."$v"]['size'] > 20097152) {
                echo "<span style='color: #3c3f41'>Ukuran file maksimum 2 MB</span>";
            }else{
                $uploaddir = dirname($_SERVER['SCRIPT_FILENAME']).'/berkas/';
                $uploadfile = $uploaddir . basename(@$_FILES["fipen"."$v"]['name']);
                if (move_uploaded_file(@$_FILES["fipen"."$v"]['tmp_name'], $uploadfile)) {
                    $sqlInsert = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) ".
                        "values ($id, 3,'Ijazah', DATE(NOW()), '$pegawai->nama', NOW(), '$tingpen')";
                    mysqli_query($mysqli,$sqlInsert);
                    $idberkas=mysqli_insert_id();
                    $sqlUpdate = "update pendidikan set id_berkas = $idberkas where id_pendidikan=$idna";
                    mysqli_query($mysqli,$sqlUpdate);
                    $sqlInsert = "insert into isi_berkas (id_berkas, ket) values ($idberkas, '$tingpen')";
                    mysqli_query($mysqli,$sqlInsert);
                    $idisi=mysqli_insert_id();

					if(@$_FILES["fipen"."$v"]['type'] == "application/pdf")
					$ext=".pdf";
					elseif(@$_FILES["fipen"."$v"]['type'] == "image/jpeg" or @$_FILES["fipen"."$v"]['type'] == "image/jpg")
					$ext=".jpg";
					elseif(@$_FILES["fipen"."$v"]['type'] == "image/png")
					$ext=".png";
                    $nf=$pegawai->nip_baru."-".$idberkas."-".$idisi."$ext";
                    $sqlUpdate = "update isi_berkas set file_name='$nf' where id_isi_berkas=$idisi";
                    mysqli_query($mysqli,$sqlUpdate);
                    rename($uploadfile,"./berkas/".$nf);
                    //echo "Upload ijazah berhasil!\n";
                } else {
                    echo "<span style='color: #3c3f41'>Upload ijazah tidak berhasil</span>";
                }
            }
        }else{
            echo "<span style='color: #3c3f41'>File tidak terupload, Tipe file ijazah harus pdf ".@$_FILES["fipen"."$v"]['type']."</span>";
        }
    }

}

if(@$aktif=='Mengundurkan Diri' or @$aktif=='Pensiun Dini' or @$aktif=='Pensiun Meninggal Dunia' or @$aktif=='Pensiun Reguler' or @$aktif=='Pindah Ke Instansi Lain')
mysqli_query($mysqli,"update pegawai set flag_pensiun=1,status_aktif='$aktif',tgl_pensiun_dini='$th1-$b1-$t1' where id_pegawai=$id2 ");


$t2=substr(@$tlanak,0,2);
			$b2=substr(@$tlanak,3,2);
			$th2=substr(@$tlanak,6,4);



if(@$jnk!=NULL and @$nsk!=NULL and @$tmsk!=NULL and @$tsk!=NULL)
{
if($pbsk==NULL)
$pbsk='-';

if($pgsk==NULL)
$pgsk='-';

$cboGol = @$_POST["gol_sk"];
$thnMkg = @$_POST["thn_mkg"];
$blnMkg = @$_POST["bln_mkg"];
if($thnMkg==""){
    $thnMkg = 0;
}
if($blnMkg==""){
    $blnMkg = 0;
}

$kete = $cboGol.','.$thnMkg.','.$blnMkg;

$t10=substr($tsk,0,2);
			$b10=substr($tsk,3,2);
			$th10=substr($tsk,6,4);

$t11=substr($tmsk,0,2);
			$b11=substr($tmsk,3,2);
			$th11=substr($tmsk,6,4);


$query_insert_sk = mysqli_query($mysqli,"insert into sk
		(id_pegawai,id_kategori_sk,no_sk,tgl_sk,tmt,pemberi_sk,pengesah_sk,keterangan,catatan,gol,mk_tahun,mk_bulan)
		values ($id,$jnk,'$nsk','$th10-$b10-$t10','$th11-$b11-$t11','$pbsk','$pgsk','$kete','$kete','$cboGol','$thnMkg','$blnMkg')");


}


	if(@$lembaga!=NULL and @$jurusan!=NULL and @$lulusan!=NULL)
	{

		$qlp=mysqli_query($mysqli,"select level_p from pendidikan where tingkat_pendidikan='$tingkat'");
		$lepel=mysqli_fetch_array($qlp);

		$query = ("insert into pendidikan (tingkat_pendidikan,lembaga_pendidikan,jurusan_pendidikan,id_pegawai,tahun_lulus,level_p, tgl_ijazah, no_ijazah)
				values ('$tingkat','$lembaga','$jurusan',$id2,$lulusan,$lepel[0],'$tgl_ijazah', '$no_ijazah')");

		if(mysqli_query($mysqli,$query)){
			echo("<div align='center' class='alert alert-success'> data sudah disimpan! </div> ");
		}else{
			echo("<div align='center' class='alert alert-danger'> Data tidak tersimpan ! </div> ");
		}
	}

}
//update ktp,npwp,karpeg
//npwp
if(@@$_FILES['fnpwp']['size']>0 and (@@$_FILES['fnpwp']['type']=='image/jpeg' or @@$_FILES['fnpwp']['type']=='image/jpg' or @@$_FILES['fnpwp']['type']=='image/png'))
{

	$qcek=mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$id2 and id_kat=13");
	$cek=mysqli_fetch_array($qcek);

	if($cek[0]>0)
	{
	$qhb=mysqli_query($mysqli,"select id_berkas from berkas where id_pegawai=$id2 and id_kat=13");
	$hb=mysqli_fetch_array($qhb);
	mysqli_query($mysqli,"delete from berkas where id_pegawai=$id2 and id_kat=13");

	}

	mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,ket_berkas,tgl_upload,byk_hal,created_by,created_date) values ($id2,13,'NPWP','$npwp',CURDATE(),1,$id2,NOW())");
	$idber=mysqli_insert_id();
					if(@$_FILES["fnpwp"]['type'] =='image/jpeg' or @$_FILES["fnpwp"]['type'] == 'image/jpg')
					$ext2=".jpg";
					elseif(@$_FILES["fnpwp"]['type'] == "image/png")
					$ext2=".png";

	$uploaddir2 = dirname($_SERVER['SCRIPT_FILENAME']).'/berkas/';
    $uploadfile2 = $uploaddir2.basename(@$_FILES["fnpwp"]['name']);
	move_uploaded_file(@$_FILES["fnpwp"]['tmp_name'], $uploadfile2);
	mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke) values ($idber,1)");
	$idisi2=mysqli_insert_id();
	$nf2=$pegawai->nip_baru."-".$idber."-".$idisi2."$ext2";

	    rename($uploadfile2,"./berkas/".$nf2);
     mysqli_query($mysqli,"update isi_berkas set file_name='$nf2' where id_isi_berkas=$idisi2");



}

//toefl
if(@@$_FILES['ftoefl']['size']>0 and @@$_FILES['ftoefl']['type']=='application/pdf' )
{

	$qcek=mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$id2 and id_kat=55");
	$cek=mysqli_fetch_array($qcek);

	if($cek[0]>0)
	{
	$qhb=mysqli_query($mysqli,"select id_berkas from berkas where id_pegawai=$id2 and id_kat=55");
	$hb=mysqli_fetch_array($qhb);
	mysqli_query($mysqli,"delete from berkas where id_pegawai=$id2 and id_kat=55");

	}

	mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,ket_berkas,tgl_upload,byk_hal,created_by,created_date) values ($id2,55,'TOEFL','$toefl',CURDATE(),1,$id2,NOW())");
	$idber=mysqli_insert_id($mysqli);
					$ext2=".pdf";

	$uploaddir2 = dirname($_SERVER['SCRIPT_FILENAME']).'/berkas/';
    $uploadfile2 = $uploaddir2.basename(@$_FILES["fnpwp"]['name']);
	move_uploaded_file(@$_FILES["fnpwp"]['tmp_name'], $uploadfile2);
	mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke) values ($idber,1)");
	$idisi2=mysqli_insert_id($mysqli);
	$nf2=$pegawai->nip_baru."-".$idber."-".$idisi2."$ext2";

	    rename($uploadfile2,"./berkas/".$nf2);
     mysqli_query($mysqli,"update isi_berkas set file_name='$nf2' where id_isi_berkas=$idisi2");



}


//karpeg
if(@@$_FILES['fkarpeg']['size']>0 and (@@$_FILES['fkarpeg']['type']=='image/jpeg' or @@$_FILES['fkarpeg']['type']=='image/jpg' or @@$_FILES['fkarpeg']['type']=='image/png'))
{
	$qcek=mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$id2 and id_kat=10");
	$cek=mysqli_fetch_array($qcek);

	if($cek[0]>0)
	{
	$qhb=mysqli_query($mysqli,"select id_berkas from berkas where id_pegawai=$id2 and id_kat=10");
	$hb=mysqli_fetch_array($qhb);
	mysqli_query($mysqli,"delete from berkas where id_pegawai=$id2 and id_kat=10");

	}


	mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,ket_berkas,tgl_upload,byk_hal,created_by,created_date) values ($id2,10,'Kartu Pegawai','$karpeg',CURDATE(),1,$id2,NOW())");
	$idber2=mysqli_insert_id();
					if(@$_FILES["fkarpeg"]['type'] =='image/jpeg' or @$_FILES["fkarpeg"]['type'] == 'image/jpg')
					$ext3=".jpg";
					elseif(@$_FILES["fkarpeg"]['type'] == "image/png")
					$ext3=".png";

	$uploaddir3 = dirname($_SERVER['SCRIPT_FILENAME']).'/berkas/';
    $uploadfile3 = $uploaddir2.basename(@$_FILES["fkarpeg"]['name']);
	move_uploaded_file(@$_FILES["fkarpeg"]['tmp_name'], $uploadfile3);
	mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke) values ($idber2,1)");
	$idisi3=mysqli_insert_id();
	$nf3=$pegawai->nip_baru."-".$idber2."-".$idisi3."$ext3";

	    rename($uploadfile3,"./berkas/".$nf3);
     mysqli_query($mysqli,"update isi_berkas set file_name='$nf3' where id_isi_berkas=$idisi3");


}

//ktp
if(@@$_FILES['fktp']['size']>0 and (@@$_FILES['fktp']['type']=='image/jpeg' or @@$_FILES['fktp']['type']=='image/jpg' or @@$_FILES['fktp']['type']=='image/png'))
{
	$qcek=mysqli_query($mysqli,"select count(*) from berkas where id_pegawai=$id2 and id_kat=1");
	$cek=mysqli_fetch_array($qcek);

	if($cek[0]>0)
	{
	$qhb=mysqli_query($mysqli,"select id_berkas from berkas where id_pegawai=$id2 and id_kat=1");
	$hb=mysqli_fetch_array($qhb);
	mysqli_query($mysqli,"delete from berkas where id_pegawai=$id2 and id_kat=1");

	}


	mysqli_query($mysqli,"insert into berkas (id_pegawai,id_kat,nm_berkas,ket_berkas,tgl_upload,byk_hal,created_by,created_date) values ($id2,1,'KTP','$ktp',CURDATE(),1,$id2,NOW())");
	$idber2=mysqli_insert_id();
					if(@$_FILES["fktp"]['type'] =='image/jpeg' or @$_FILES["fktp"]['type'] == 'image/jpg')
					$ext3=".jpg";
					elseif(@$_FILES["fktp"]['type'] == "image/png")
					$ext3=".png";

	$uploaddir3 = dirname($_SERVER['SCRIPT_FILENAME']).'/berkas/';
    $uploadfile3 = $uploaddir2.basename(@$_FILES["fktp"]['name']);
	move_uploaded_file(@$_FILES["fktp"]['tmp_name'], $uploadfile3);
	mysqli_query($mysqli,"insert into isi_berkas (id_berkas,hal_ke) values ($idber2,1)");
	$idisi3=mysqli_insert_id();
	$nf3=$pegawai->nip_baru."-".$idber2."-".$idisi3."$ext3";

	    rename($uploadfile3,"./berkas/".$nf3);
     mysqli_query($mysqli,"update isi_berkas set file_name='$nf3' where id_isi_berkas=$idisi3");


}
?>
<div id="reset_pasword" class="row">
	<?php

		if(@$reset_password=='true'){
			$obj_pegawai->reset_password($pegawai->id_pegawai);
		}
	?>
</div>

<?php
    if(@$is_submit_file_skp=='true'){
        if(isset($btnUploadSkp)){
            $mysqli->autocommit(FALSE);
            $qryBerkasSKP = 1;
            $upBerkasSKP = 1;
            if (@$_FILES['uploadFileSkp']) {
                $uploaddir = 'Berkas/';
                $file_ary = @$_FILES['uploadFileSkp'];
                foreach ($file_ary['name'] as $key => $n) {
                    if ($file_ary['name'][$key] <> "") {
                        if ($file_ary['type'][$key] == 'binary/octet-stream' or $file_ary['type'][$key] == "application/pdf") {
                            $uploadfile = $uploaddir . basename($file_ary['name'][$key]);
                            if (move_uploaded_file($file_ary['tmp_name'][$key], $uploadfile)) {
                                $sqlInsertBerkas = "insert into berkas (id_pegawai,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                                    "values (" . $idp_skp . ",53,'SKP',DATE(NOW()),'" . $idp_skp . "',NOW()," . $key . ")";
                                if ($mysqli->query($sqlInsertBerkas)) {
                                    $last_id_berkas = $mysqli->insert_id;
                                    $sqlUpdateBerkas = "update skp_header set idberkas_ppk = $last_id_berkas where id_skp=" . $key;
                                    if ($mysqli->query($sqlUpdateBerkas)) {
                                        $sqlInsertIsi = "insert into isi_berkas (id_berkas, ket) values ($last_id_berkas, 'SKP')";
                                        if ($mysqli->query($sqlInsertIsi)) {
                                            $last_idisi = $mysqli->insert_id;
                                            $nf = $_SESSION['nip_baru'] . "-" . $last_id_berkas . "-" . $last_idisi . ".pdf";
                                            $sqlUpdateIsi = "update isi_berkas set file_name='$nf' where id_isi_berkas=$last_idisi";
                                            if ($mysqli->query($sqlUpdateIsi)) {
                                                rename($uploadfile, "Berkas/" . $nf);
                                                $qryBerkasSKP = 1;
                                                $upBerkasSKP = 1;
                                            } else {
                                                $qryBerkasSKP = 0;
                                                $upBerkasSKP = 0;
                                                break;
                                            }
                                        } else {
                                            $qryBerkasSKP = 0;
                                            $upBerkasSKP = 0;
                                            break;
                                        }
                                    } else {
                                        $qryBerkasSKP = 0;
                                        $upBerkasSKP = 0;
                                        break;
                                    }
                                } else {
                                    $qryBerkasSKP = 0;
                                    $upBerkasSKP = 0;
                                    break;
                                }
                            } else {
                                $qryBerkasSKP = 0;
                                $upBerkasSKP = 0;
                                break;
                            }
                        } else {
                            $qryBerkasSKP = 0;
                            $upBerkasSKP = 0;
                            break;
                        }
                    }
                }
            }

            if($upBerkasSKP==1 and $qryBerkasSKP==1){
                $mysqli->commit();
                echo("<div align=center style='background-color: #83c868;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'> Upload File Berhasil </div>");
            }else{
                $mysqli->rollback();
                echo("<div align=center style='background-color:#c8271b;font-weight: bold;color: #ffffff; padding-top: 5px;padding-bottom: 5px;'>Terdapat data yang tidak tersimpan atau ada file yang tidak terupload. Silahkan coba lagi.</div>");
            }
        }
    }

?>

<form action="index3.php" method="post" enctype="multipart/form-data" name="form1" class="form-horizontal" role="form" id="form1">
<div class="row">
	<div class="col-md-12">

		<div align="right">
			<?php if($is_tim){ ?>

				<a class="btn btn-success" onclick="reset_imei(<?php echo $pegawai->id_pegawai ?>)">reset IMEI</a>
				<a href="index3.php?x=box.php&od=<?php echo $od ?>&reset_password=true" onclick="return confirm('yakin akan mereset password pegawai ?');" class="btn btn-danger">reset password</a>
				<a href="index3.php?x=list2.php" class="btn btn-warning">kembali ke daftar pegawai</a>
			<?php } ?>
			<input type="submit" name="button" id="button" class="btn btn-primary" value="Simpan" />
		</div>
		<h4><?php echo $pegawai->nama ? strtoupper($pegawai->nama_lengkap) : "" ?></h4>
	</div>
</div>
<div class="panel panel-default">
	<div class="panel-body">
<div  class="row">
	<div class="col-md-12">
  <ul class="nav nav-tabs" role="tablist">
	<li><a href="#biodata" role="tab" data-toggle="tab">Biodata</a></li>
	<!--li><a href="#biodata2" role="tab" data-toggle="tab">Biodata2</a></li-->
	<li><a href="#pendidikan" role="tab" data-toggle="tab">Riwayat Pendidikan</a></li>
	<li><a href="#riwayat_keluarga" role="tab" data-toggle="tab">Keluarga</a></li>
	<!--li><a href="#riwayat_pangkat" role="tab" data-toggle="tab">Riwayat Pangkat</a></li-->
	<li><a href="#riwayat_diklat" role="tab" data-toggle="tab">Riwayat Diklat</a></li>
	<li><a href="#riwayat_jabatan" role="tab" data-toggle="tab">Riwayat Jabatan</a></li>
	<li><a href="#berkas_pegawai" role="tab" data-toggle="tab">Riwayat Pangkat</a></li>
    <li><a href="#berkas_kgb" role="tab" data-toggle="tab">Berkas KGB</a></li>
      <li><a href="#berkas_skp" role="tab" data-toggle="tab">Berkas SKP</a></li>
       <li><a href="#lainnya" role="tab" data-toggle="tab">Berkas Lainnya</a></li>
    <li><a href="#Hobi" role="tab" data-toggle="tab">Hobi</a></li>
  </ul>

    <?php

		extract($_GET);
		$q=mysqli_query($mysqli,"select * from pegawai where id_pegawai=$od");
		$kuta=mysqli_fetch_array($q);

	?>
   <div class="tab-content">
    <div class="tab-pane active" id="biodata">
        <?php
			if($pegawai->id_pegawai == '0') {

				include ('modul/profil/biodata.php');
			}else{
		?>
		<table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup table">

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
            <td><select name="jk_pns" id="jk_pns" <?php //echo $is_tim ? '': 'disabled="disabled"'?> >
              <?php
			  $qp=mysqli_query($mysqli,"SELECT jenis_kelamin FROM `pegawai` where flag_pensiun=0 group by jenis_kelamin ");
                while($oto=mysqli_fetch_array($qp))
				{
					if($kuta['jenis_kelamin']==$oto[0]){
						echo("<option value=$oto[0] selected>");
						if($oto[0]==1){
							echo('Laki-laki');
						}else if($oto[0]==2){
							echo('Perempuan');
						}else{
							echo($oto[0]);
						}
						echo("</option>");
					}else{
						echo("<option value=$oto[0]>");
						if($oto[0]==1){
							echo('Laki-laki');
						}else if($oto[0]==2){
							echo('Perempuan');
						}else{
							echo($oto[0]);
						}
						echo("</option>");
					}
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
            <input name="tgl_lahir_pns" type="text" class="tcal"  id="tgl_lahir_pns" value="<?php
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

                 <?php
			$qn=mysqli_query($mysqli,"select id_berkas from berkas where id_pegawai=$kuta[0] and id_kat=10");
			$n=mysqli_fetch_array($qn);
			if($n[0]!=null)
			echo(" <a href=lihat_berkas.php?id=$n[0] target=_blank> Lihat </a>");
			?>

			    <label> <input type="file" name="fkarpeg" id="fkarpeg" /> </label>	       </td>
          </tr>
		  <tr>
            <td align="left" valign="top" nowrap="nowrap">Karis/Karsu</td>
            <td align="left" valign="top">:</td>
            <td>
				<input name="karisu" type="text" id="karisu" value="<?php echo($kuta['no_karisu']); ?>" />

                 <?php
			$qn=mysqli_query($mysqli,"select id_berkas from berkas where id_pegawai=$kuta[0] and id_kat=11");
			$n=mysqli_fetch_array($qn);
			if($n[0]!=null)
			echo(" <a href=lihat_berkas.php?id=$n[0] target=_blank> Lihat </a>");
			?>

			    <label> <input type="file" name="fkarisu" id="fkarisu" /> </label>	       </td>
          </tr>

          <tr>
            <td align="left" valign="top" nowrap="nowrap">NPWP			</td>
            <td align="left" valign="top">:</td>
            <td nowrap="nowrap"><input name="npwp" type="text" id="npwp" value="<?php echo($kuta['NPWP']); ?>" />
            <?php
			$qn=mysqli_query($mysqli,"select id_berkas from berkas where id_pegawai=$kuta[0] and id_kat=13");
			$n=mysqli_fetch_array($qn);
			if($n[0]!=null)
			echo(" <a href=lihat_berkas.php?id=$n[0] target=_blank> Lihat </a>");
			?>
          			    <label>  <input type="file" name="fnpwp" id="fnpwp" />			    </label></td></tr>

            <tr>
            <td align="left" valign="top" nowrap="nowrap">TOEFL			</td>
            <td align="left" valign="top">:</td>
            <td nowrap="nowrap"><input name="toefl" type="text" id="toefl" value="<?php echo($kuta['jumlah_transit']); ?>" />
            <?php
			$qn=mysqli_query($mysqli,"select id_berkas from berkas where id_pegawai=$kuta[0] and id_kat=55");
			$n=mysqli_fetch_array($qn);
			if($n[0]!=null)
			echo(" <a href=lihat_berkas.php?id=$n[0] target=_blank> Lihat </a>");
			?>
          			    <label>  <input type="file" name="ftoefl" id="ftoefl" />			    </label></td></tr>


            <tr>
            <td align="left" valign="top" nowrap="nowrap">No KTP</td>
            <td align="left" valign="top">:</td>

            <td nowrap="nowrap">

            <?php
			$qn=mysqli_query($mysqli,"select id_berkas,ket_berkas from berkas where id_pegawai=$kuta[0] and id_kat=1 and nm_berkas='KTP'");

			$n=mysqli_fetch_array($qn);//$kuta['no_ktp']
			 ?>
            <input name="ktp" type="text" id="ktp" value="<?php echo($kuta['no_ktp']==''?$n[1]:$kuta['no_ktp']); ?>" />  	  <?php

			if($n[0]!=null)
			echo(" <a href=lihat_berkas.php?id=$n[0] target=_blank> Lihat </a>");
			?>       		    <label><input type="file" name="fktp" id="fktp" />			    </label>               </td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Pangkat, Gol / Ruang</td>
            <td align="left" valign="top">:</td>
            <td><?php echo $pegawai->pangkat.", ".$pegawai->golongan ?></td>
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
            <td><!--<label for="jenjab"></label> -->
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
            <td nowrap="nowrap" style="padding-bottom:10px !important;">Jabatan</td>
            <td align="left" valign="top">:</td>
            <td><span id="jab_on_box"></span></td>
						<script>
								$(document).ready(function(){
									$.post("../simpeg2/index.php/pegawai/json_profil", { idpegawai: <?php echo $pegawai->id_pegawai;?>}, function (data){
										//alert(data);
											p = JSON.parse(data);

											$("#jab_on_box").html(p.jabatan);

									});
								});
						</script>
				</tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Status Pegawai</td>
            <td align="left" valign="top">:</td>
            <td><?php	echo $pegawai->status_pegawai; ?></td>
          </tr>
          <tr>
          	<td align="left" valign="top" nowrap="nowrap">Jabatan Atasan <?php echo $unit[1] ?></td>
            <td align="left" valign="top">:</td>
            <td><!--<label for="jenjab"></label> -->
            <?php
			$qrk=("select id_j_bos,
					id_riwayat from riwayat_mutasi_kerja
					inner join sk on sk.id_sk=riwayat_mutasi_kerja.id_sk where sk.id_pegawai=$od order by tmt desc");

			$qrk = mysqli_query($mysqli,$qrk);
			$rk=mysqli_fetch_array($qrk);
			$qbener=mysqli_query($mysqli,"select id_skpd,nama_baru from unit_kerja where id_unit_kerja=$unit[1]");
			$bener=mysqli_fetch_array($qbener);
			$qjob=mysqli_query($mysqli,"select id_j,jabatan from jabatan left join unit_kerja on unit_kerja.id_unit_kerja=jabatan.id_unit_kerja
							where id_skpd=$bener[0] and unit_kerja.tahun = 2017 and jabatan.tahun = 2017");

			//echo "id_unit : ". $unit[1];//"id_skpd :".$bener[0];
			?>
			<select name="jx" id="jx" style="width: 100%">
				<option>pilih</option>
			<?php
			if($kuta['jenjab']=='Fungsional' and $kuta['jabatan'] == 'Guru' and (strpos($bener[1],'SMA') !== false or strpos($bener[1],'SMP') !== false or strpos($bener[1],'SD') !== false or strpos($bener[1],'TK') !== false))
			{

			if(strpos($bener[1],'SMP') !== false)
			$tingkat="SMP";
			elseif(strpos($bener[1],'SMA') !== false)
			$tingkat="SMA";
			elseif(strpos($bener[1],'SD') !== false)
			$tingkat="SD";
			elseif(strpos($bener[1],'TK') !== false)
			$tingkat="TK";

			$qbos=mysqli_query($mysqli,"select nama,
							nama_baru,pegawai.id_pegawai
							from pegawai
							inner join current_lokasi_kerja on current_lokasi_kerja.id_pegawai=pegawai.id_pegawai
							inner join unit_kerja on unit_kerja.id_unit_kerja =current_lokasi_kerja.id_unit_kerja
							where nama_baru like '%$tingkat%'
							and unit_kerja.tahun=(select max(tahun) from unit_kerja) and is_kepsek=1 order by nama_baru ASC");

			while($bos=mysqli_fetch_array($qbos))
			{
			if($rk[0]==$bos[2])
			echo("<option value=$bos[2] selected=selected>Kepala Sekolah $bos[1] | $bos[0] </option>");
			else
			echo("<option value=$bos[2] >Kepala Sekolah $bos[1] | $bos[0] </option>");

			}
			}
			else
			{

			while($job=mysqli_fetch_array($qjob))
			{
			if($rk[0]==$job[0])
			echo("<option value=$job[0] selected>$job[1]</option>");
			else
			echo("<option value=$job[0]> $job[1]</option>");
			}
			}
			?>
            </select>            </td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Telepon</td>
            <td align="left" valign="top">:</td>
            <td><input name="telp" type="text" id="telp" value="<?php echo($kuta['telepon']); ?>" /></td>
          </tr>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Ponsel</td>
            <td align="left" valign="top">:</td>
            <td><input name="hp" type="text" id="hp" value="<?php echo($kuta['ponsel']); ?>" /></td>
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
            <!-- riwayat_mutasi_kerja-->
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
            <td align="left" valign="top" nowrap="nowrap">Tgl Pensiun Reguler</td>
            <td align="left" valign="top">:</td>
            <td><input name="pensiun" type="text" class="tcal"  id="pensiun" value="<?php
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
          <?php if($is_tim == TRUE) {
		  ?>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Tipe Absensi</td>
            <td align="left" valign="top">:</td>
            <td><label>
              <select name="absen" id="absen">
                <option value="0" <?php if($p1[3]==0) echo (" selected=selected "); ?>>Statis</option>
                <option value="1" <?php if($p1[3]==1) echo (" selected=selected "); ?>>Dinamis</option>
              </select>
            </label></td>
          </tr>
          <?php  if($p1[3]==1) {
		  ?>
          <tr>
            <td align="left" valign="top" nowrap="nowrap">Jenis Absensi</td>
            <td align="left" valign="top">:</td>
            <td><label>
              <select name="jenisab" id="jenisab"><?php
			  $qjaba=mysqli_query($mysqli,"select * from jadwal");
			  while($jaba=mysqli_fetch_array($qjaba))
			  {

			  echo("<option value=$jaba[0]> $jaba[1]</option>");

			  }

			  ?>
              </select>
            </label></td>
          </tr>

          <tr>
            <td align="left" valign="top" nowrap="nowrap">Tanggal</td>
            <td align="left" valign="top">:</td>
            <td>
             <span class="input-control text">
                                             dari   <input name="tanggal1" id="tanggal1" type="text" class="tcal"   /> s/d
                                             <input name="tanggal2" id="tanggal2" type="text" class="tcal"   />
                                            </span>            </td>
            </tr>

              <tr>
            <td align="left" valign="top" nowrap="nowrap">Tanggal</td>
            <td align="left" valign="top">:</td>
            <td>
             <span class="input-control text">
                                             dari jam <select name="jam1" id="jam1">
											 <option value="0">Pilih Jam </option>
											 <?php for($i=1;$i<=24;$i++)
											 {
											 if($i<10)
											 echo("<option value=0$i>$i </option>");
											 else
											 echo("<option value=$i>$i </option>");

											 }
											  ?> </select> <select name="menit1" id="menti1">
                                               <option value="0">Pilih Menit </option>
                                              <?php for($j=1;$j<=60;$j++)
											 {
											 if($j<10)
											 echo("<option value=0$j>$j </option>");
											 else
											 echo("<option value=$j>$j </option>");

											 }
											  ?>
                                              </select>    s/d  jam <select name="jam2" id="jam2">
                                               <option value="0">Pilih Jam </option>

                                              <?php for($k=1;$k<=24;$k++)
											 {
											 if($k<10)
											 echo("<option value=0$k>$k </option>");
											 else
											 echo("<option value=$k>$k </option>");

											 }
											  ?>
                                              </select> <select name="menit2" id="menti2">
                                               <option value="0">Pilih Menit</option>

                                                <?php for($l=1;$l<=60;$l++)
											 {
											 if($l<10)
											 echo("<option value=0$l>$l </option>");
											 else
											 echo("<option value=$l>$l </option>");

											 }
											  ?>
                                               </select>
                                            </span>            </td>

            <?php /*
			$qcek5=mysqli_query($mysqli,"select count(*) from jadwal_transaksi where id_pegawai=$od and id_unit_kerja=$p1[0]");
			echo"select count(*) from jadwal_transaksi where id_pegawai=$od and id_unit_kerja=$p1[0]";
			$cek5=mysqli_fetch_array($qcek5);
			if($cek5[0]>0)
			{
			*/
			?>
            </tr>
              <tr>
                <td align="left" valign="top" nowrap="nowrap">&nbsp;</td>
                <td align="left" valign="top">&nbsp;</td>
                <td><a href="jadwal.php?id=<?php echo $od;  ?>" target="_blank" > Lihat Jadwal </a></td>
              </tr>
<?php //}  ?>
          <?php
		  }
		  }
		  ?>
        </table>
			<?php } ?>
    </div>
	<!--div class="tab-pane active" id="biodata2"-->
		<?php //include 'modul/biodata.php'; ?>
	<!--/div-->

	<div class="tab-pane" id="pendidikan">

	  <?php

		include("modul/profil/pendidikan.php");


	  ?>

    </div>
		<!-- tab riwayat keluarga -->
    <div class="tab-pane" id="riwayat_keluarga" <?php // echo $t == 2 ? "active" : ""?> >
			<?php include('riwayat_keluarga.php') ?>
		</div>
		<!-- end tab riwayat keluarga -->

		<!--tab riwayat pangkat -->
		<!--div class="tab-pane" id="riwayat_pangkat">
			<?php //include('riwayat_pangkat.php'); ?>
		</div-->
		<!--end riwayat pangkat-->
        <!-- tab berkas pegawai -->
         <div class="tab-pane" id="berkas_pegawai">

          <?php
			if($_SESSION['id_pegawai'] == 0){
				include("modul/profil/berkas_pegawai_development.php");
			}else{
				include("modul/profil/berkas_pegawai.php");
			} ?>
        </div>

         <div class="tab-pane" id="berkas_kgb">
			<?php include("modul/profil/riwayat_kgb.php") ?>

        </div>

       <div class="tab-pane" id="berkas_skp">
           <?php include("modul/profil/riwayat_skp.php"); ?>
       </div>

        <div class="tab-pane" id="lainnya">
           <?php include("modul/profil/riwayat_lainnya.php"); ?>
       </div>

        <div class="tab-pane" id="Hobi">
        <?php
		$qho=mysqli_query($mysqli,"select * from hobby");
		$t=1;
		while($ho=mysqli_fetch_array($qho))
		{
		$qli=mysqli_query($mysqli,"select count(*) from hobby_pegawai where id_pegawai=$_SESSION[id_pegawai] and id_hobby=$ho[0]");
		$li=mysqli_fetch_array($qli);
		?>


         <input name="c<?php echo $t;?>" type="checkbox" value="<?php echo $ho[0]; ?>" id="c<?php echo $t;?>" <?php
		 if($li[0]>0)
		 echo(" checked=checked");

		 ?>  /> <?php echo ("$ho[1]<br>"); ?>
        <?php
		$t++;

		}
		$total=$t-1;

		?>
        <input type="hidden" name="th" id="th" value="<?php echo $total; ?>" />

        </div>

		<!-- Tab Riwayat Diklat -->
			<div class="tab-pane" id="riwayat_diklat">
				<fieldset>
					<legend> Riwayat Diklat </legend>
					<?php $id = $od; ?>
					<?php  include("modul/profil/riwayat_diklat.php"); ?>
				</fieldset>
			</div>
		<!-- end of Riwayat Diklat -->
        <!-- Tab Riwayat Jabatan2 -->
			<div class="tab-pane" id="riwayat_jabatan">
				<fieldset>
					<!--legend> Riwayat Jabatan </legend-->

					<?php  include("riwayat_jabatan2.php"); ?>
				</fieldset>
			</div>
		<!-- end of Riwayat jabatan2 -->
  </div>

     </form>
	</div>
</div>
</div>
</div>

<?php
//}
//else
	//echo("<div align='center' class='alert alert-danger'> Restricted Access </div>");

?>
