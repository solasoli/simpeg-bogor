<?php


class Pegawai{


	public $id_pegawai;
	public $nip;
	public $nama;
	public $id_j;
	public $jabatan;
	public $id_pegawai_atasan = NULL;
	public $id_pegawai_bawahan = NULL;
	public $pangkat_gol;
	public $nama_baru;
	public $id_jfu_p;
	public $kode_jab;

	public function set_nip($nip){

		$this->nip = $nip;
	}

	public function get_nip(){

		return $this->nip;
	}



	/*
	 * concat(concat(concat(gelar_depan,' '),nama),concat(', ',gelar_belakang)) as nama,
	*/
	public function get_obj($id_pegawai){

	$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		if(!$id_pegawai){
			return "-";
		}

		$this->id_pegawai = $id_pegawai;
		$sql = "select
					pegawai.*,
					view_pangkat_terakhir.*,
					IF(LENGTH(pegawai.gelar_belakang) > 1,
					CONCAT(pegawai.gelar_depan,
							' ',
							pegawai.nama,
							CONCAT(', ', pegawai.gelar_belakang)),
					CONCAT(pegawai.gelar_depan, ' ', pegawai.nama)) AS nama_lengkap,
					golongan.pangkat, uk.*, uk2.nama_baru as skpd,
					jfu_pegawai.id_jfu, jfu_pegawai.kode_jabatan, jfu_pegawai.tmt as tmt_jfu
				from pegawai
				left join view_pangkat_terakhir on view_pangkat_terakhir.id_pegawai = pegawai.id_pegawai
				left join
				(
					select * from jfu_pegawai where id_pegawai = ".$id_pegawai." and tmt =
					(select max(tmt) from jfu_pegawai where id_pegawai = ".$id_pegawai.")
					) jfu_pegawai on jfu_pegawai.id_pegawai = pegawai.id_pegawai
				left join golongan on golongan.golongan = view_pangkat_terakhir.golongan
				left join current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai
				left join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
				left join unit_kerja uk2 on uk2.id_unit_kerja = uk.id_skpd

				where pegawai.id_pegawai = ".$id_pegawai;

		//echo $sql."<br><br><br><br>";

		if($r = mysqli_fetch_object(mysqli_query($mysqli,$sql))){
			return $r;
			exit;
		}else{
			echo "kesalahan : ".mysqli_error()." : ".$id_pegawai." saat eksekusi: ".$sql;
			die;
		}

		//echo $sql;
	}

	public function get_by_id_j($id_j){
$mysqli = new mysqli("simpeg.db.kotabogor.net","root","koplak123!bkpsd4","simpeg");
		$query = mysqli_query($mysqli,"select * from pegawai where id_j = $id_j and flag_pensiun = 0 ");
		return mysqli_fetch_object($query);
	}

	public function get_by_kepsek_di($id_unit_kerja){
	$mysqli = new mysqli("simpeg.db.kotabogor.net","root","koplak123!bkpsd4","simpeg");
		$query = mysqli_query($mysqli,"select *
					from current_lokasi_kerja clk
					inner join pegawai p on p.id_pegawai = clk.id_pegawai
					where p.is_kepsek = 1
					and clk.id_unit_kerja = ".$id_unit_kerja);
		return mysqli_fetch_object($query);
	}

	public function get_atasan_penilai_kepsek($id_j){
	$mysqli = new mysqli("simpeg.db.kotabogor.net","root","koplak123!bkpsd4","simpeg");
		$query = mysqli_query($mysqli,"SELECT p.id_pegawai, j.jabatan FROM pegawai p, jabatan j WHERE p.id_j = j.id_j AND j.id_j ='".$id_j."'");
		return mysqli_fetch_object($query);
	}

	public function pangkat($gol){
$mysqli = new mysqli("simpeg.db.kotabogor.net","root","koplak123!bkpsd4","simpeg");
		return mysqli_fetch_object(mysqli_query($mysqli,'select pangkat from golongan where golongan = "'.$gol.'"'))->pangkat;
	}

	public function get_unit_kerja($id_pegawai){
$mysqli = new mysqli("simpeg.db.kotabogor.net","root","koplak123!bkpsd4","simpeg");
		$sql = "select current_lokasi_kerja.id_unit_kerja, unit_kerja.nama_baru as nama_unit_kerja, unit_kerja.nama_baru
				from current_lokasi_kerja
				inner join unit_kerja on unit_kerja.id_unit_kerja = current_lokasi_kerja.id_unit_kerja
				where id_pegawai=".$id_pegawai;

		return mysqli_fetch_object(mysqli_query($mysqli,$sql));

	}

	public function get_cpns($id_pegawai){
$mysqli = new mysqli("simpeg.db.kotabogor.net","root","koplak123!bkpsd4","simpeg");
		$cpns = mysqli_fetch_object(mysqli_query($mysqli,"select * from sk where id_kategori_sk = 6 and id_pegawai = ".$id_pegawai));
		return $cpns;

	}

	public function hitung_masakerja($tmt_cpns, $mk_awal_thn, $mk_awal_bln){
$mysqli = new mysqli("simpeg.db.kotabogor.net","root","koplak123!bkpsd4","simpeg");
       if (class_exists('Format')) {
			$format = new Format;
		}else{
			include "./library/format.php";
			$format = new Format;
		}


		list($tmt_thn,$tmt_bln,$tmt_tgl) = explode("-",$tmt_cpns);

		$timestamp = mktime(0,0,0,$tmt_bln - $mk_awal_bln,$tmt_tgl,$tmt_thn - $mk_awal_thn);
		$tgl = $format->datediff(date('Y-m-d'),date('Y-m-d',$timestamp));
        $this->masakerja['tahun'] = $tgl['years'];
        $this->masakerja['bulan'] = $tgl['months'];
        return $this->masakerja;

    }

    public function hitung_masakerja_golongan($masakerja, $gol_cpns, $gol_sekarang){
$mysqli = new mysqli("simpeg.db.kotabogor.net","root","koplak123!bkpsd4","simpeg");
		list($gol_awal,$ruang_awal) = explode('/',$gol_cpns);
		list($gol,$ruang) = explode('/',$gol_sekarang);

		if($gol_awal == 'II' && $gol == 'III'){
			$tahun = $masakerja['tahun'] - 5;
		}elseif($gol_awal == 'I' && $gol == 'III'){
			$tahun = $masakerja['tahun'] - 11;
		}elseif($gol_awal == 'I' && $gol == 'II'){
			$tahun = $masakerja['tahun'] - 6;
		}else{
			$tahun = $masakerja['tahun'];
		}


		$this->masakerja_golongan['tahun'] = $tahun;
        $this->masakerja_golongan['bulan'] = $masakerja['bulan'];
        return $this->masakerja_golongan;
    }

    /**
     * param obj $pegawai
     *
     *
     */
    public function get_jabatan($pegawai){

        //$mysqli = new mysqli("127.0.0.1:3307","kominfo-simpeg","Madangkara2017","simpeg");
        $mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		if($pegawai->id_j !=NULL && $pegawai->jenjab == 'Struktural'){

			$qjo=mysqli_query($mysqli,"select jabatan from jabatan where id_j=".$pegawai->id_j);

			$jabatan=mysqli_fetch_object($qjo)->jabatan;

		}elseif($pegawai->id_j == NULL && $pegawai->jenjab == 'Struktural'){

			$sql = "select jfu_pegawai.*, jfu_master.*, jfu_pegawai.id_jfu as id_jfu_p
					from jfu_pegawai, jfu_master
					where jfu_pegawai.id_pegawai = '".$pegawai->id_pegawai."'
					and jfu_master.kode_jabatan = jfu_pegawai.kode_jabatan";

			$qjo=mysqli_query($mysqli,$sql);

			while ($row = mysqli_fetch_object($qjo)) {
				$jabatan = $row->nama_jfu;
				$this->id_jfu_p = $row->id_jfu_p;
				$this->kode_jab = $row->kode_jabatan;
			}
		}else{ // jabatan fungsional

			if($pegawai->jabatan == 'Guru' && $pegawai->kepsek_di != NULL){

				$jabatan = "Kepala Sekolah";
			}else{
				$jabatan = $pegawai->jabatan;
			}

		}

		return @$jabatan;

	}

	public function get_jabatan_struktural_by_id($id_j){
$mysqli = new mysqli("simpeg.db.kotabogor.net","root","koplak123!bkpsd4","simpeg");
			$sql = "select * from jabatan where id_j = ".$id_j;

			return mysqli_fetch_object(mysqli_query($mysqli,$sql));

	}

	public function get_idjfu(){
		return $this->id_jfu_p;
	}

	public function get_kode_jab(){
		return $this->kode_jab;
	}

	public function get_pensiun($pegawai){
$mysqli = new mysqli("simpeg.db.kotabogor.net","root","koplak123!bkpsd4","simpeg");
		try{
			$bup = 58;
			if(strtolower($pegawai->jenjab) == 'struktural'){
				//return "58";
				if($pegawai->id_j == NULL){
					//fungsional umum bup 58 tahun
					$bup = 58;

				}else{
					//cek eselon ybs
					$query_eselon = "select eselon from jabatan where id_j = ".$pegawai->id_j;
					$result_eselon = mysqli_fetch_object(mysqli_query($mysqli,$query_eselon))->eselon;

					if($result_eselon == 'IIA' || $result_eselon == 'IIB'){
						$bup = 60; //eselon II bup 60 tahun, assik ye..
					}else{
						$bup = 58; //eselon lain bup 58 tahun
					}
				}
			}elseif(strtolower($pegawai->jenjab) == 'fungsional'){
				//cek ke tabel fungsional dong bup nya
				$query_jafung = "select *
								from jafung
								where nama_jafung like '".strtolower($pegawai->jabatan)."'
								AND pangkat_gol = '".$pegawai->pangkat_gol."'";

				$result_jafung = mysqli_fetch_object(mysqli_query($mysqli,$query_jafung))->bup;
				$bup = $result_jafung;
			}else{
				echo "<span class='alert alert-danger'>Jabatan tidak terdefinisi</span>";

			}

			$query_pensiun = "select DATE_FORMAT( CONCAT( LEFT( ADDDATE( ADDDATE( pegawai.tgl_lahir, INTERVAL $bup YEAR ) , INTERVAL 1
				MONTH ) , 7 ) ,  '-01' ) ,  '%Y-%m-%d' ) AS tgl_pensiun
				from pegawai
				where id_pegawai = '".$pegawai->id_pegawai."'";
			$result_pensiun = mysqli_fetch_object(mysqli_query($mysqli,$query_pensiun))->tgl_pensiun;
			return $result_pensiun;


		}catch(Exception $e){
			return "error cuy :".$e;
		}
	}

	public function reset_password($id_pegawai){
$mysqli = new mysqli("simpeg.db.kotabogor.net","root","Madangkara2017","simpeg");
		try{
			$sql = "update pegawai set password = left(nip_baru,4) where id_pegawai = ".$id_pegawai;
			mysqli_query($mysqli,$sql);
			echo "<span class='alert alert-success'>reset password berhasil, password kembali ke tahun lahir</span>";
		}catch(Exception $e){
			echo "<span class='alert alert-danger'>Reset password gagal ".$e."</span>";
		}
	}

	public function get_atasan($pegawai){
$mysqli = new mysqli("simpeg.db.kotabogor.net","root","koplak123!bkpsd4","simpeg");
		if($pegawai->id_j !=NULL && $pegawai->jenjab == 'Struktural'){

			$sql = "select * from pegawai where id_j =
							(select id_bos from jabatan where id_j = ".$pegawai->id_j.")";
			$result = mysqli_fetch_object(mysqli_query($mysqli,$sql));


			return $this->get_obj($result->id_pegawai);

		}elseif($pegawai->id_j == NULL && $pegawai->jenjab == 'Struktural'){
			//jfu
			return $this->get_obj($pegawai->id_pegawai);
		}else{ // jabatan fungsional

			return $this->get_obj($pegawai->id_pegawai);

		}

	}

	public function get_bawahan($pegawai){
$mysqli = new mysqli("simpeg.db.kotabogor.net","root","koplak123!bkpsd4","simpeg");
		if($pegawai->id_j !=NULL && $pegawai->jenjab == 'Struktural'){

			$sql = "select * from pegawai where id_j =
							(select id_bos from jabatan where id_j = ".$pegawai->id_j.")";
			$result = mysqli_fetch_object(mysqli_query($mysqli,$sql));

			return $this->get_obj($result->id_pegawai);

		}else{

			return FALSE;

		}
	}

	public function get_total_pegawai(){
$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		$query = "select count(*) as total from pegawai
					where flag_pensiun = 0";

		$result = mysqli_fetch_object(mysqli_query($mysqli,$query));

		return $result->total;
	}
}
