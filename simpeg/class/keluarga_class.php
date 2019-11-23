<?php

//include('./konek.php');

class Keluarga_class{


	public $id_keluarga;
	public $id_pegawai;
	public $id_status;
	public $nama;
	public $tempat_lahir;
	public $tgl_lahir;
	public $nik;
	public $tgl_menikah;
	public $akte_menikah;
	public $tgl_meninggal;
	public $akte_meninggal;
	public $tgl_cerai;
	public $akte_cerai;
	public $no_karsus;
	public $pekerjaan;
	public $jk; // jenis kelamin
	public $dapat_tunjangan;
	public $keterangan;
	public $status;
	public $mysqli;
	private $timestamp;

	public function __construct(){
			$this->mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
	}

	public function get_keluarga($id_pegawai, $id_status=NULL){

		if(isset($id_status)){
			$query = "select * from keluarga where id_pegawai=$id_pegawai and id_status=$id_status order by tgl_lahir ";
		}else{
			$query = "select * from keluarga where id_pegawai=$id_pegawai order by tgl_lahir ";
		}

		if($result = $this->mysqli->query($query)){
			//var_dump($query);
			return $result;

		}else{
			return FALSE;
		}

	}

	public function get_anggota($id_keluarga){

		$query = "select * from keluarga where id_keluarga = $id_keluarga";
		$obj = mysqli_fetch_object( $this->mysqli->query($query));
		return $obj;
	}

	public function update_keluarga(){

		$format = new Format;

		$this->id_keluarga = $_POST['id_keluarga'];
		$this->nama = $_POST['nama'];
		$this->tempat_lahir = $_POST['tempat_lahir'];
		$this->tgl_lahir = $_POST['tgl_lahir'];
		$this->nik = $_POST['nik'];

		$this->akte_menikah = $_POST['akte_menikah'];

		$this->pekerjaan = $_POST['pekerjaan'];
		$this->jk = $_POST['jk'];
		$this->dapat_tunjangan = $_POST['dapat_tunjangan'];
		$this->keterangan = $_POST['keterangan'];
		$this->status = $_POST['status_kawin'];
		$query = 	"update keluarga set
					nama = '$this->nama',
					tempat_lahir = '$this->tempat_lahir',
					tgl_lahir = '$this->tgl_lahir',
					nik = '$this->nik',";


		if(!empty($_POST['tgl_menikah'])){
			$query	.=	"tgl_menikah = '".$_POST['tgl_menikah']."', akte_menikah = '".$_POST['akte_menikah']."',";
		}

		if(!empty($_POST['tgl_cerai'])){
			$query .= "tgl_cerai =  '".$_POST['tgl_cerai']."',
						akte_cerai = '".$_POST['akte_cerai']."',
						tgl_akte_cerai = '".$_POST['tgl_akte_cerai']."',";
		}

		if(!empty($_POST['tgl_meninggal']) && $_POST['id_status'] == 9){
			$query .= "tgl_meninggal =  '".$_POST['tgl_meninggal']."',
						akte_meninggal = '".$_POST['akte_meninggal']."',
						tgl_akte_meninggal = '".$_POST['tgl_akte_meninggal']."',";
		}

		if($_POST['kuliah']){
			$query .= "kuliah = '".$_POST['kuliah']."',
						nama_sekolah = '".$_POST['nama_sekolah']."',";
		}
		if($_POST['kuliah'] == '0'){
			$query .= "kuliah = 0,
						nama_sekolah = NULL,
						tgl_lulus = NULL,
						no_ijazah = NULL, ";
		}

		if(!empty($_POST['tgl_kuliah']) || $_POST['tgl_kuliah'] != NULL || $_POST['tgl_kuliah'] != ""){
			$query .= "tgl_lulus = '".$_POST['tgl_lulus']."',
						no_ijazah = '".$_POST['no_ijazah']."',";
		}else{
			$query .= " tgl_lulus = NULL,
						no_ijazah = NULL , ";
		}

		if($_POST['status_meninggal_anak'] && $_POST['id_status'] == 10){
			//$query .= " status = 'Meninggal',";
			$this->status = 'Meninggal';
			$query .= "tgl_meninggal =  '".$_POST['tgl_meninggal']."',
						akte_meninggal = '".$_POST['akte_meninggal']."',
						tgl_akte_meninggal = '".$_POST['tgl_akte_meninggal']."',";
		}else if(!$_POST['status_meninggal_anak'] && $_POST['id_status'] == 10){
			//$query .= " status = NULL, ";
			$this->status = NULL;
			$query .= "tgl_meninggal =  NULL,
						akte_meninggal = NULL,
						tgl_akte_meninggal = NULL,";
		}

		$query	.=	" pekerjaan = '$this->pekerjaan',
					jk = '$this->jk',
					dapat_tunjangan ='$this->dapat_tunjangan',
					status = '$this->status',
					keterangan = '$this->keterangan'
					where id_keluarga = '$this->id_keluarga' ";

		//echo "<pre>";
		//print_r($_POST);
		//echo "</pre>";
		//echo "<br><br><br>";
		//echo $query;
		//exit;
		if($this->mysqli->query($query)){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	public function tambah_keluarga(){

		$format = new Format;

		$this->id_pegawai = $_POST['id_pegawai'];
		$this->id_status = $_POST['id_status'];
		$this->nama = mysqli_escape_string($_POST['nama']);
		$this->tempat_lahir = $_POST['tempat_lahir'];
		$this->tgl_lahir = $format->date_Ymd($_POST['tgl_lahir']);
		if(!empty($_POST['tgl_menikah'])){
			$this->tgl_menikah = $format->date_Ymd($_POST['tgl_menikah']);
			$this->akte_menikah = $_POST['akte_menikah'];
			$this->no_karsus = $_POST['no_karsus'];
		}else{
			$this->tgl_menikah = NULL;
		}

		$this->pekerjaan = $_POST['pekerjaan'];
		$this->jk = $_POST['jk'];
		$this->dapat_tunjangan = $_POST['dapat_tunjangan'];
		$this->keterangan = $_POST['keterangan'];

		switch ($this->id_status){

			// istri / suami
			case 9 :
				$query = 	"insert into keluarga (
					id_pegawai,
					id_status,
					nama,
					tempat_lahir,
					tgl_lahir,
					tgl_menikah,
					akte_menikah,
					no_karsus,
					pekerjaan,
					jk,
					dapat_tunjangan,
					keterangan
					)
					VALUES(
					'$this->id_pegawai',
					'$this->id_status',
					'$this->nama',
					'$this->tempat_lahir',
					'$this->tgl_lahir',
					'$this->tgl_menikah',
					'$this->akte_menikah',
					'$this->no_karsus',
					'$this->pekerjaan',
					'$this->jk',
					'$this->dapat_tunjangan',
					'$this->keterangan'
					)
					";
				break;
			//anak
			case 10 :
				$query = 	"insert into keluarga (
					id_pegawai,
					id_status,
					nama,
					tempat_lahir,
					tgl_lahir,
					pekerjaan,
					jk,
					dapat_tunjangan,
					keterangan
					)
					VALUES(
					'$this->id_pegawai',
					'$this->id_status',
					'$this->nama',
					'$this->tempat_lahir',
					'$this->tgl_lahir',
					'$this->pekerjaan',
					'$this->jk',
					'$this->dapat_tunjangan',
					'$this->keterangan'
					)
					";
				break;
			default :
				echo "status hubungan keluarga undefined";
		}


		//var_dump($query);

		if($this->mysqli->query($query)){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	public function hapus_keluarga($idk){

		$query = "DELETE from keluarga where id_keluarga = $idk";

		if($this->mysqli->query($query)){
			//var_dump($sql);
			return TRUE;
		}else{
			return FALSE;
		}

	}

	public function get_list_hubungan(){

		$sql = "select * from status_kel";
		if($result = $this->mysqli->query($sql)){
			return $result;
		}else{
			return FALSE;
		}
	}

	public function insert_keluarga($id_pegawai,$id_status,$nama,$tempat_lahir,$tgl_lahir,$tgl_menikah=NULL,
									$akte_menikah,$no_karsus,$pekerjaan,$jk,$dapat_tunjangan,$keterangan){

		$sql = "insert into keluarga (
					id_pegawai,
					id_status,
					nama,
					tempat_lahir,
					tgl_lahir,
					tgl_menikah,
					akte_menikah,
					no_karsus,
					pekerjaan,
					jk,
					dapat_tunjangan,
					keterangan
					)
					VALUES(
					'$id_pegawai',
					'$id_status',
					'$nama',
					'$tempat_lahir',
					'$tgl_lahir',
					'$tgl_menikah',
					'$akte_menikah',
					'$no_karsus',
					'$pekerjaan',
					'$jk',
					'$dapat_tunjangan',
					'$keterangan')";

		//echo $sql;exit;
		if($this->mysqli->query($sql)){
			return TRUE;
		}else{
			return FALSE;
		}

	}

	public function insert_anak($id_pegawai,$id_status,$nama,$tempat_lahir,$tgl_lahir,$pekerjaan,$jk,$dapat_tunjangan,$keterangan){

		$sql = "insert into keluarga (
					id_pegawai,
					id_status,
					nama,
					tempat_lahir,
					tgl_lahir,
					pekerjaan,
					jk,
					dapat_tunjangan,
					keterangan
					)
					VALUES(
					'$id_pegawai',
					'$id_status',
					'$nama',
					'$tempat_lahir',
					'$tgl_lahir',
					'$pekerjaan',
					'$jk',
					'$dapat_tunjangan',
					'$keterangan')";


		if($this->mysqli->query($sql)){
			return TRUE;
		}else{
			return FALSE;
		}

	}

}
