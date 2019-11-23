<?php
require_once("../../konek.php");
require_once("../../class/pegawai.php");
require_once "../../class/unit_kerja.php";
require_once("../../library/format.php");



if($_POST){

	$proper = new Proper;
	switch($_POST['aksi']){

		case 'tambahTujuan' :
			$proper->add_tujuan();
			break;
		case 'delTujuan' :
			$proper->hapus_tujuan();
			break;
		case 'tambahProper' :
			$proper->add_proper();
			break;
		case 'setStatusProper':
			$proper->set_status_proper();
			break;
		case 'setujuiMentor':
			$proper->setujui_mentor();
			break;
		case 'tambahTarget' :
			$skp->add_target();
			break;
		case 'editTarget' :
			echo "edit target";
			break;
		case 'updateTarget':
			$skp->update_target();
			break;
		case 'getSkpById' :
			$skp->get_skp_by_id($_POST['idskp'],$_POST['json']);
			break;
		case 'getUraianTarget' :
			$skp->get_uraian_target();
			break;
		case 'saveRealisasi' :
			$skp->save_realisasi_target();
			break;
		case 'delTarget' :
			$skp->del_target();
			break;
		case 'getNilai' :
			$skp->hitung_nilai();
			break;
		case 'delSkp' :
			$skp->del_skp();
			break;
		case 'cekStatus' :
			echo $skp->get_status_skp();
			break;
		case 'saveReviewSkp':
			$skp->save_review_skp();
			break;
		case 'updateStatusPengajuan' :
			$skp->update_status_pengajuan();
			break;
		case 'updatePeriode' :
			$skp->update_periode();
			break;
		case 'setStatus' :
			$skp->set_status();
			break;
		case 'saveTambahan' :
			$skp->save_tugas_tambahan();
			break;
		case 'delTambahan':
			$skp->del_tambahan();
			break;
		case 'savePerilaku' :
			$skp->save_perilaku();
			break;
		case 'revisiTarget' :
			$skp->revisi_target();
			break;
		case 'ubahTanggalPenerimaan':
			$skp->ubah_tanggal_penerimaan();
			break;
		case 'UPDATE_PERIODE_PENILAIAN':
			$skp->update_periode_penilaian();
			break;
		case 'UPDATE_HEADER' :
			$skp->update_header();
			break;
		case 'resetPenilaian' :
			$skp->reset_penilaian();
			break;
        case 'ubahTanggalPembuatan':
            $skp->ubah_tanggal_pembuatan();
		default:

			echo "error : undefined post";
	}
}


class Proper{

	var $id_pegawai	;

	public function get_proper_by_id($idp){
	
$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$sql = "select * from proper where id_proper = ".$idp;
		return mysqli_fetch_object(mysqli_query($mysqli,$sql));
	}

	public function setujui_mentor(){
	$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$sql = "update proper_status set approvement_mentor = '1' where id_proper = ".$_POST['idp']." and jangka = '".$_POST['jangka']."'";
		if(mysqli_query($mysqli,$sql)){
			echo "1";
		}else{
			echo "Gagal menyimpan keterangan :".$sql;
		}
	}

	public function set_status_proper(){
$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$sql = mysqli_query($mysqli,"select count(*) baris from proper_status where id_proper = ".$_POST['idp']." and jangka = '".$_POST['jangka']."'");
		$ha = mysqli_fetch_object($sql);
		if($ha->baris > 0 ){
			$query = "update proper_status setstatus = '".$_POST['status']."',
							alasan = '".$_POST['alasan']."' where id_proper = ".$_POST['idp']." and jangka = ''".$_POST['jangka']."'";
			if(mysqli_query($mysqli,$query)){
				echo "1";
			}else{
				echo "Gagal menyimpan keterangan :".$query;
			}

		}else{
			$query = "insert into proper_status (id_proper, jangka, status, alasan)
							values(".$_POST['idp'].", '".$_POST['jangka']."','".$_POST['status']."' , '".$_POST['alasan']."')";
			if(mysqli_query($mysqli,$query)){
				echo "1";
			}else{
				echo "Gagal menyimpan keterangan :".$query;
			}
		}
	}

	public function add_tujuan(){
	$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$format = new Format();
		$insert = ("insert into proper_tujuan (id_proper,jenis_jangka,tujuan_jangka,tanggal_capaian,status,alasan)
										values (".$_POST['idp'].",'".$_POST['jangka']."','".$_POST['tujuan']."','".$format->date_Ymd($_POST['tanggal_capaian'])."','','')");

		if(mysqli_query($mysqli,$insert)){
			echo "1";

		}else{
			echo $insert;
		}
	}

	public function hapus_tujuan(){
$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$hapus = "delete from proper_tujuan where id_proper_tujuan = ".$_POST['idTujuan'];

		if(mysqli_query($mysqli,$hapus)){
			echo $hapus;
		}else {
			echo "GAGAL";
		}
	}

	public function update_periode_penilaian(){
$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$format = new Format();

		$id_skp = $_POST['id_skp'];

		$sql = "UPDATE skp_header set periode_awal = '".$format->date_Ymd($_POST['periode_awal'])."',
				gol_pegawai = '".$_POST['gol_pegawai']."',
				jabatan_pegawai = '".$_POST['jabatan_pegawai']."',
				id_unit_kerja_pegawai = '".$_POST['id_unit_kerja_pegawai']."',
				periode_akhir = '".$format->date_Ymd($_POST['periode_akhir'])."'
				where id_skp = ".$_POST['id_skp'];


		if(mysqli_query($mysqli,$sql)){
			echo "BERHASIL";
		}else{
			echo mysqli_error();
		}
	}


	public function set_id_pegawai($id_pegawai){
$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$this->id_pegawai = $id_pegawai;
	}

	public function get_skp($id_pegawai = NULL, $last = NULL){
$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		if(!isset($id_pegawai)) $id_pegawai = $this->id_pegawai;

		$query = "select * from skp_header where id_pegawai = ".$id_pegawai;
		if(isset($last) == TRUE){
			$query .= " and periode_awal = (select MAX(periode_awal) from skp_header where id_pegawai=".$id_pegawai." )";


		}

		$query .= " ORDER BY periode_awal ASC";

		return mysqli_query($mysqli,$query);
	}

	public function get_skp_dinilai($id_pegawai = NULL, $last = NULL){
$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		if(!isset($id_pegawai)) $id_pegawai = $this->id_pegawai;

		$query = "select * from skp_header where id_pegawai = ".$id_pegawai;
		if(isset($last) == TRUE){
			$query .= " and periode_awal = (select MAX(periode_awal) from skp_header
			where id_pegawai=".$id_pegawai." )";
			
		}

		$query .= " and (id_penilai = ".$_SESSION['id_pegawai']." or id_penilai_realisasi = ".$_SESSION['id_pegawai'].") ORDER BY periode_awal ASC";

		return mysqli_query($mysqli,$query);
	}

	public function get_skp_by_tahun($id_pegawai, $tahun){
$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$query = "select * from skp_header where id_pegawai = ".$id_pegawai." and periode_awal like '".$tahun."%' order by periode_awal ASC";

		return mysqli_query($mysqli,$query);
	}

	public function get_proper($id_pegawai){
$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$query = "select count(*) from proper where id_pegawai=$id_pegawai";
		return mysqli_query($mysqli,$query);
	}




	public function add_proper(){

$qjab=mysqli_query($mysqli,"select jabatan from jabatan inner join pegawai on jabatan.id_j=pegawai.id_j where pegawai.id_pegawai=$_POST[id_pegawai]");

		$jab=mysqli_fetch_array($qjab);

		$query = "insert INTO proper(
					id_pegawai,
					jabatan,
					judul,
					deskripsi,
					id_mentor,
					jabatan_mentor
				)
				VALUES(
					'".$_POST['id_pegawai']."',
					'".$jab[0]."',
					'".$_POST['judul']."',
					'".$_POST['desc']."',
					'".$_POST['id_penilai']."',
					'".$_POST['jabatan_penilai']."',
					)";



		if(mysqli_query($mysqli,$query)){

			$id_proper = mysqli_insert_id();
			mysqli_query($mysqli,"insert into proper_tujuan (id_proper) values ($id_proper)");



		}else{
			echo "gagal menyimpan : ".mysqli_error();
		}
	}

	

	public function get_penilai($pegawai){

$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");

		$obj_pegawai = new Pegawai;

	
		if($pegawai->id_j == '4375'){

			//return $pegawai;
			$walikota = $pegawai;
			$walikota->nama_baru	= "Pemerintah Kota Bogor";
			return $walikota;

			die;
		}


		if($pegawai->id_j !=NULL && $pegawai->jenjab == 'Struktural'){


			$sql = "select * from pegawai
							where  id_j =
							(select id_bos from jabatan where id_j = ".$pegawai->id_j.")
							and flag_pensiun != 1
							";
			
			$result = mysqli_fetch_object(mysqli_query($mysqli,$sql));



			/**
			 * kalo id_j sekda (1978) atasannya walikota
			 * */
			if($pegawai->id_j == 4376){

				//echo "sekda".$pegawai->id_j;
				//echo $result->id_pegawai;
				$walikota =  $obj_pegawai->get_obj($result->id_pegawai);
				$walikota->id_pegawai = $result->id_pegawai;
				//print_r($walikota);
				return $walikota;
				//die;
			}

			

			if(! $result){
			
				$bos_g_ada = mysqli_fetch_object(mysqli_query($mysqli,"select id_bos from jabatan where id_j = ".$pegawai->id_j));

				$sql = "select * from pegawai
							where  id_j =
							(select id_bos from jabatan where id_j = ".$bos_g_ada->id_bos.")
							and (flag_pensiun != 1)
							";
				$result = mysqli_fetch_object(mysqli_query($mysqli,$sql));

			}

			if($result){
				return $obj_pegawai->get_obj($result->id_pegawai);
			}else{
				//echo "penilai dari ".$pegawai->nama." ".$pegawai->id_j." tidak ditemukan";
			}



		}elseif($pegawai->id_j == NULL && $pegawai->jenjab == 'Struktural'){
			//jfu
			$query = "select * from riwayat_mutasi_kerja where id_pegawai = '".$pegawai->id_pegawai."'";
			$query .= "and id_riwayat = (select MAX(id_riwayat) from riwayat_mutasi_kerja where id_pegawai = '".$pegawai->id_pegawai."') ";
			//echo $query;exit;
			$r		= mysqli_fetch_object(mysqli_query($mysqli,$query))->id_j_bos;

			$bos = "select id_pegawai from pegawai where id_j = '".$r."'";
			$bos = mysqli_fetch_object(mysqli_query($mysqli,$bos));
			//echo
			return $obj_pegawai->get_obj($bos->id_pegawai);

		}else{ // jabatan fungsional

			//return $obj_pegawai->get_obj($pegawai->id_pegawai);
			return $this->get_penilai_jft($pegawai);

		}
	}

	

	public function get_status($kode_status){

			return mysqli_fetch_object(mysqli_query($mysqli,"select * from skp_status where kode_status = '".$kode_status."'"));
	}

	public function set_status(){

			$query = ("update skp_header set status_pengajuan = '".$_POST['kodeStatus']."' where id_skp = '".$_POST['idskp']."'");

			if(mysqli_query($mysqli,$query)){
				echo "berhasil ".$_POST['kodeStatus'];
			}else{
				echo "gagal update "+mysqli_error();
			}


	}

	
	public function get_stk($id,$jenjang){


		switch ($jenjang) {
			case 'STRUKTURAL':
				$q = "select * from stk_skp where id_j = ".$id;
				break;
			case 'PELAKSANA':
				$q = "select * from stk_skp where id_jfu = ".$id;
				break;
			case 'FUNGSIONAL':
				$q = "select * from stk_skp where id_jft = ".$id;
				break;
			default:
				$q = "select * from stk_skp";
				break;

		}

		echo $q;
		$results = mysqli_query($mysqli,$q);
		while($result =  mysqli_fetch_object($results)){
			$stk[] = $result;
		}

		return $stk;

	}

}
