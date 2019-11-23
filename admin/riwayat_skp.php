<?php

  $skp = new Skp;
?>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
  <tr>
    <td rowspan="2">No</td>
    <td rowspan="2">Tahun Penilaian</td>
    <td rowspan="2">Jumlah SKP</td>
    <td rowspan="2">SKP</td>
    <td colspan="8">Perilaku</td>
    <td rowspan="2">SKP * 60%</td>
    <td rowspan="2">Perilaku * 40%</td>
    <td rowspan="2>">Nilai Prestasi Kerja</td>
</tr>
<tr>
    <td>Orientasi Pelayanan</td>
    <td>Integritas</td>
    <td>Komitmen</td>
    <td>Disiplin</td>
    <td>Kerjasama</td>
    <td>Kepemimpinan</td>
    <td>Jumlah Perilaku</td>
    <td>Rata-rata Perilaku</td>
  </tr>

<?php
  $tahun_penilaian_sql = "select YEAR(periode_awal) as tahun, count(*) as jumlah_skp from skp_header where id_pegawai = ".$id." group by YEAR(periode_awal) order by YEAR(periode_awal) DESC;";
  $tahun_penilaian_query = mysqli_query($con,$tahun_penilaian_sql);
  $x=1;
  while($data_tahun = mysqli_fetch_array($tahun_penilaian_query)):

    $lastSkp = $skp->get_akhir_periode($id, $data_tahun['tahun']);

?>
  <tr>
    <td><?php echo $x++; ?></td>
    <td><?php echo $data_tahun['tahun'] ?></td>
    <td><?php echo $data_tahun['jumlah_skp'] ?></td>
    <td><?php echo round($skp->get_nilai_capaian_rata2($id, $data_tahun['tahun']),2) ?></td>


    <td><?php echo $lastSkp->orientasi_pelayanan ?></td>
    <td><?php echo $lastSkp->integritas ?></td>
    <td><?php echo $lastSkp->komitmen ?></td>
    <td><?php echo $lastSkp->disiplin ?></td>
    <td><?php echo $lastSkp->kerjasama ?></td>
    <td><?php echo $lastSkp->kepemimpinan ?></td>
    <td><?php echo $lastSkp->jumlah_perilaku ?></td>
    <td><?php echo $lastSkp->rata2_perilaku ?></td>
    <td><?php echo $nilai_skp = round($skp->get_nilai_capaian_rata2($id, $data_tahun['tahun']) * 0.6 , 2) ?></td>
    <td><?php echo $nilai_perilaku = number_format(($lastSkp->rata2_perilaku * 0.4),2) ?></td>
    <td><?php echo number_format(($nilai_skp + $nilai_perilaku),2) ?></td>
  </tr>

<?php endwhile; ?>


</table>

<?php

class Skp{

	var $id_pegawai	;
	public $mysqli;

	public function __construct(){
		$this->mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
		//$this->mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg")
	}
	public function update_header(){


		switch ($_POST['x']){

			case 'PENILAI' :
				$sql = "UPDATE skp_header set id_penilai = '".$_POST['id_penilai']."',
						gol_penilai='".$_POST['gol_penilai']."',
						jabatan_penilai = '".$_POST['jabatan_penilai']."',
						id_unit_kerja_penilai = '".$_POST['id_unit_kerja_penilai']."'
						where id_skp = ".$_POST['id_skp'];
				break;
			case 'ATASAN_PENILAI' :
				$sql = "UPDATE skp_header set id_atasan_penilai = '".$_POST['id_atasan_penilai']."',
						gol_atasan_penilai='".$_POST['gol_atasan_penilai']."',
						jabatan_atasan_penilai = '".$_POST['jabatan_atasan_penilai']."',
						id_unit_kerja_atasan_penilai = '".$_POST['id_unit_kerja_atasan_penilai']."'
						where id_skp = ".$_POST['id_skp'];
				break;
			case 'PENILAI_REALISASI' :
				$sql = "UPDATE skp_header set id_penilai_realisasi = '".$_POST['id_penilai_realisasi']."',
						gol_penilai_realisasi='".$_POST['gol_penilai_realisasi']."',
						jabatan_penilai_realisasi = '".$_POST['jabatan_penilai_realisasi']."' where id_skp = ".$_POST['id_skp'];
				break;
			case 'ATASAN_PENILAI_REALISASI' :
				$sql = "UPDATE skp_header set id_atasan_penilai_realisasi = '".$_POST['id_atasan_penilai_realisasi']."',
						gol_atasan_penilai_realisasi ='".$_POST['gol_atasan_penilai_realisasi']."',
						jabatan_atasan_penilai_realisasi = '".$_POST['jabatan_atasan_penilai_realisasi']."' where id_skp = ".$_POST['id_skp'];
				break;
			default:
				echo "";
		}
			//echo $_POST['id_skp']." - ".$_POST['id_atasan_penilai'];
		//echo $sql;
		//exit;
		if($this->mysqli->query($sql)){
			echo "BERHASIL";
		}else{
			echo $this->mysqli->error;
		}


	}

	public function update_periode_penilaian(){

		$format = new Format();

		$id_skp = $_POST['id_skp'];

		$sql = "UPDATE skp_header set periode_awal = '".$format->date_Ymd($_POST['periode_awal'])."',
				gol_pegawai = '".$_POST['gol_pegawai']."',
				jabatan_pegawai = '".$_POST['jabatan_pegawai']."',
				id_unit_kerja_pegawai = '".$_POST['id_unit_kerja_pegawai']."',
				periode_akhir = '".$format->date_Ymd($_POST['periode_akhir'])."'
				where id_skp = ".$_POST['id_skp'];


		if($this->mysqli->query($sql)){
			echo "BERHASIL";
		}else{
			echo $this->mysqli->error;
		}

	}


	public function set_id_pegawai($id_pegawai){

		$this->id_pegawai = $id_pegawai;
	}

	public function get_skp($id_pegawai = NULL, $last = NULL){

		if(!isset($id_pegawai)) $id_pegawai = $this->id_pegawai;

		$query = "select * from skp_header where id_pegawai = ".$id_pegawai;
		if(isset($last) == TRUE){
			$query .= " and periode_awal = (select MAX(periode_awal) from skp_header where id_pegawai=".$id_pegawai." )";


		}

		$query .= " ORDER BY periode_awal ASC";

		return $this->mysqli->query($query);

	}

	public function get_skp_dinilai($id_pegawai = NULL, $last = NULL){

		if(!isset($id_pegawai)) $id_pegawai = $this->id_pegawai;

		$query = "select * from skp_header where id_pegawai = ".$id_pegawai;
		if(isset($last) == TRUE){
			$query .= " and periode_awal = (select MAX(periode_awal) from skp_header
			where id_pegawai=".$id_pegawai." )";
			//return $query;
		}

		$query .= " and (id_penilai = ".$_SESSION['id_pegawai']." or id_penilai_realisasi = ".$_SESSION['id_pegawai'].") ORDER BY periode_awal DESC";

		return $this->mysqli->query($query);

	}

	public function get_skp_by_tahun($id_pegawai, $tahun){

		$query = "select * from skp_header where id_pegawai = ".$id_pegawai." and periode_awal like '".$tahun."%' order by periode_awal ASC";

		return $this->mysqli->query($query);

	}

	// return tahun periode skp untuk skp gabungan
	public function get_tahun_skp($id_pegawai){


		$query = "select DISTINCT YEAR(periode_awal) as tahun from skp_header where id_pegawai = '".$id_pegawai."' ORDER BY tahun DESC";

		return $this->mysqli->query($query);

	}

	public function get_awal_periode($id_pegawai, $tahun){

		$query = "select MIN(periode_awal) as awal from skp_header where id_pegawai = ".$id_pegawai." and periode_awal like '".$tahun."%'";
		$result = $this->mysqli->query($query);
		return $result->fetch_object();

	}

	public function get_akhir_periode($id_pegawai, $tahun){

		/*$query = "select MAX(periode_akhir) as akhir
				from skp_header where id_pegawai =".$id_pegawai."
				and periode_akhir like '".$tahun."%'";
		*/
		$query = "select s.*,
						s.periode_akhir as akhir,
						(COALESCE(s.orientasi_pelayanan,0)
						+ COALESCE(s.integritas,0)
						+ COALESCE(s.komitmen,0)
						+ COALESCE(s.disiplin,0)
						+ COALESCE(s.kerjasama,0)
						+ COALESCE(s.kepemimpinan,0))

						as jumlah_perilaku,

						(COALESCE(s.orientasi_pelayanan,0)
						+ COALESCE(s.integritas,0)
						+ COALESCE(s.komitmen,0)
						+ COALESCE(s.disiplin,0)
						+ COALESCE(s.kerjasama,0)
						+ COALESCE(s.kepemimpinan	,0))
						/
						(6 -
						(COALESCE(s.orientasi_pelayanan - s.orientasi_pelayanan,1)
						+ COALESCE(s.integritas - s.integritas,1)
						+ COALESCE(s.komitmen - s.komitmen,1)
						+ COALESCE(s.disiplin - s.disiplin,1)
						+ COALESCE(s.kerjasama - s.kerjasama,1)
						+ COALESCE(s.kepemimpinan	- s.kepemimpinan,1))
						)
						as rata2_perilaku,
						s.tgl_pembuatan_penilaian
				from skp_header s
				where id_pegawai = ".$id_pegawai."
				and periode_akhir =
					(select MAX(periode_akhir)
					from skp_header
					where id_pegawai = ".$id_pegawai."
					and periode_akhir like '".$tahun."%')";
		$result = $this->mysqli->query($query);
		return $result->fetch_object();

	}

	public function get_skp_by_id($idskp, $json = NULL){

			$query = "select *,
						(COALESCE(s.orientasi_pelayanan,0)
						+ COALESCE(s.integritas,0)
						+ COALESCE(s.komitmen,0)
						+ COALESCE(s.disiplin,0)
						+ COALESCE(s.kerjasama,0)
						+ COALESCE(s.kepemimpinan,0))

						as jumlah_perilaku,

						(COALESCE(s.orientasi_pelayanan,0)
						+ COALESCE(s.integritas,0)
						+ COALESCE(s.komitmen,0)
						+ COALESCE(s.disiplin,0)
						+ COALESCE(s.kerjasama,0)
						+ COALESCE(s.kepemimpinan	,0))
						/
						(6 -
						(COALESCE(s.orientasi_pelayanan - s.orientasi_pelayanan,1)
						+ COALESCE(s.integritas - s.integritas,1)
						+ COALESCE(s.komitmen - s.komitmen,1)
						+ COALESCE(s.disiplin - s.disiplin,1)
						+ COALESCE(s.kerjasama - s.kerjasama,1)
						+ COALESCE(s.kepemimpinan	- s.kepemimpinan,1))
						)
					as rata2_perilaku
					FROM skp_header s
					where id_skp = ".$idskp;

			$result = $this->mysqli->query($query);
			if(isset($json) == 'TRUE'){
				echo json_encode($result->fetch_array());
			}else{
				return $result->fetch_object();
			}

	}
	// untuk pengecekan status disabled button
	public function get_status_skp(){

		if(! isset($_POST['idskp'])) die ;
		$query = "select status_pengajuan from skp_header where id_skp = '".$_POST['idskp']."'";
		$result = $this->mysqli->query($query);
		echo $result->fetch_object()->status_pengajuan;

	}

	public function get_target($idskp, $unsur=NULL){


		if(isset($unsur)){
			$query = "select * from skp_target where id_skp = ".$idskp." and unsur = '".$unsur."' order by urutan ASC, id_skp_target ASC";
		}else{
			$query = "select * from skp_target where id_skp = ".$idskp." order by urutan ASC, id_skp_target ASC";
		}
		//echo $query;
		return $this->mysqli->query($query);

	}



	public function get_target_history($id_target){

			$query = "select * from skp_target_history where id_skp_target = ".$id_target;
			if($result = $this->mysqli->query($query)){
				return $result;
			}else{
				return FALSE;
			}

	}

	public function get_uraian_target($idtarget = NULL){

		if(isset($idtarget)){
			$query = "select * from skp_target where id_skp_target = ".$idtarget;
			$result = $this->mysqli->query($query);
			return $result->fetch_object();
		}else{
			$query = "select * from skp_target where id_skp_target = ".$_POST['idtarget'];
			$result = $this->mysqli->query($query);
			echo json_encode($result->fetch_array());
		}

		//return $query
	}

	public function get_tambahan_kreatifitas($idskp, $jenistambahan){

		$query = "select * from skp_tambahan_kreatifitas t where id_skp = '".$idskp."' and jenis = '".$jenistambahan."'";
		return $this->mysqli->query($query);

		//return $query;
	}

	public function get_nilai_tambahan($idskp,$jenistambahan){

		$query = "select count(*) as jumlah from skp_tambahan_kreatifitas where id_skp = '".$idskp."' and jenis = '".$jenistambahan."'";
		$result = $this->mysqli->query($query);
		$jumlah = $result->fetch_object()->jumlah;

		if($jumlah < 1){
			return 0;
		}elseif($jumlah >=1 && $jumlah <=3){
			return 1;
		}elseif($jumlah >=4 && $jumlah <=6){
			return 2;
		}elseif($jumlah >=7 ){
			return 3;
		}

	}

	public function get_nilai_capaian($idskp){

		$tambahan = $this->get_nilai_tambahan($idskp,'TAMBAHAN');

		$query = "select round(sum(nilai_capaian),2) as nilai_skp,
				round(avg(nilai_capaian),2) + ".$tambahan." as rata2_nilai_skp
				from skp_target where id_skp = ".$idskp ;
		//echo $query;
		$result = $this->mysqli->query($query);
		return $result->fetch_object();

	}

	public function get_nilai_capaian_rata2($id_pegawai, $tahun){

		$skps = $this->mysqli->query("select id_skp from skp_header
				where periode_awal like '".$tahun."%' and id_pegawai = '".$id_pegawai."'");

		$nilai_capaian = array();
		$rata2_nilai_skp = 0;

		while($skp = $skps->fetch_object()){

			$nilai_capaian[] = $this->get_nilai_capaian($skp->id_skp)->rata2_nilai_skp;
		}

		if(count($nilai_capaian) == 0){
			return 0;
		}else{
			return array_sum($nilai_capaian) / count($nilai_capaian);
		}

	}


	public function update_target(){

		if(isset($_POST['unsur'])){
			$unsur = "'".$_POST['unsur']."'";
		}else{
			$unsur = "NULL";
		}
		$query = "update skp_target set
					uraian_tugas= '".$_POST['inputUraian']."',
					angka_kredit= '".$_POST['inputAK']."',
					kuantitas= '".$_POST['inputKuantitas']."',
					kuantitas_satuan= '".$_POST['inputKuantitasSatuan']."',
					kualitas= '".$_POST['inputKualitas']."',
					waktu= '".$_POST['inputWaktu']."',
					waktu_satuan= '".$_POST['inputWaktuSatuan']."',
					biaya= '".$_POST['inputBiaya']."',
					urutan= '".$_POST['inputUrutan']."',
					unsur=  ".$unsur."
					where id_skp_target = '".$_POST['idtarget']."'";


		try{
			if($this->mysqli->query($query)){
				echo "1";
			}else{
				echo "gagal menyimpan	".$query;
			}
		}catch(Exception $e){
			echo "Error mas bro".$e->getMessage();
		}

		//return $query;
	}

	public function ubah_tanggal_penerimaan(){

		$query = "update skp_header set
					tgl_diterima ='".$_POST['tgl_diterima']."',
					tgl_diterima_atasan ='".$_POST['tgl_diterima_atasan']."'
					where id_pegawai = '".$_POST['id_pegawai']."'
					and periode_akhir like '".$_POST['periode_akhir']."%'
					";

		try{
			if($this->mysqli->query($query)){
				echo $query;
			}else{
				echo "gagal menyimpan	".$query;
			}
		}catch(Exception $e){
			echo "Error mas bro".$e->getMessage();
		}

	}

	public function ubah_tanggal_pembuatan(){

        $query = "update skp_header set
					tgl_pembuatan_penilaian ='".$_POST['tgl_pembuatan']."'
					where id_pegawai = '".$_POST['id_pegawai']."'
					and periode_akhir like '".$_POST['periode_akhir']."%'
					";

        try{
            if($this->mysqli->query($query)){
                echo $query;
            }else{
                echo "gagal menyimpan	".$query;
            }
        }catch(Exception $e){
            echo "Error mas bro".$e->getMessage();
        }

    }

	public function revisi_target(){


		$query1 = "select id_skp_target from skp_target_history where id_skp_target = '".$_POST['idtarget']."'";
		$result = $this->mysqli->query($query1);
		if($result->num_rows < 1){
			$target_lama =  $this->get_uraian_target($_POST['idtarget']);
			$query2 = "insert into skp_target_history (
						id_skp_target,
						uraian_tugas,
						angka_kredit,
						kuantitas,
						kuantitas_satuan,
						kualitas,
						waktu,
						waktu_satuan,
						biaya
						)
						VALUES(
						'".$_POST['idtarget']."',
						'".$target_lama->uraian_tugas."',
						'".$target_lama->angka_kredit."',
						'".$target_lama->kuantitas."',
						'".$target_lama->kuantitas_satuan."',
						'".$target_lama->kualitas."',
						'".$target_lama->waktu."',
						'".$target_lama->waktu_satuan."',
						'".$target_lama->biaya."'
						)";
			if($this->mysqli->query($query2)){
				$this->update_target();
			}else{
				echo "gagal dump ke history";
			}
		}else{
			$this->update_target();
		}

	}

	public function add_skp(){


		$kopi_skp = 0;
		//echo isset($_POST['kopi_skp']) ? $_POST['kopi_skp'] : "not set";
		$last_id_skp;

		$query = "insert INTO skp_header(
					id_pegawai,
					gol_pegawai,
					jabatan_pegawai,
					id_unit_kerja_pegawai,
					id_penilai,
					gol_penilai,
					jabatan_penilai,
					id_unit_kerja_penilai,
					id_atasan_penilai,
					gol_atasan_penilai,
					jabatan_atasan_penilai,
					id_unit_kerja_atasan_penilai,
					periode_awal,
					periode_akhir
				)
				VALUES(
					'".$_POST['id_pegawai']."',
					'".$_POST['gol_pegawai']."',
					'".$_POST['jabatan_pegawai']."',
					'".$_POST['id_unit_kerja_pegawai']."',
					'".$_POST['id_penilai']."',
					'".$_POST['gol_penilai']."',
					'".$_POST['jabatan_penilai']."',
					'".$_POST['id_unit_kerja_penilai']."',
					'".$_POST['id_atasan_penilai']."',
					'".$_POST['gol_atasan_penilai']."',
					'".$_POST['jabatan_atasan_penilai']."',
					'".$_POST['id_unit_kerja_atasan_penilai']."',
					'".$_POST['periode_awal']."',
					'".$_POST['periode_akhir']."'
				)";

			//echo $query;
			//exit;
			if(isset($_POST['kopi_skp']) == 1){

				$kopi_skp = $_POST['kopi_skp'];
				//get the last skp by period

				$query_skp = "select id_skp
							from skp_header
							where id_pegawai = '".$_POST['id_pegawai']."'
							and periode_akhir = (select max(periode_akhir) from skp_header where id_pegawai = '".$_POST['id_pegawai']."')";

				$last_id_skp = $this->mysqli->query($query_skp)->fetch_object()->id_skp;
				//echo $last_id_skp; exit();
			}

		if($this->mysqli->query($query)){

			/*
			 * $this->mysqli->query("lock tables skp_header WRITE");
			$id_skp = $this->mysqli->fetch_object($this->mysqli->query("select MAX(id_skp) as id_skp from skp_header"))->id_skp;
			$this->mysqli->query("unlock tables");
			* */
			$id_skp = $this->mysqli->insert_id;

			if($kopi_skp == 1){
				$query_copy = "insert into skp_target (id_skp,
									uraian_tugas,
									angka_kredit,
									kuantitas,
									kuantitas_satuan,
									kualitas,
									waktu, waktu_satuan,
									biaya,
									status_pengajuan,
									unsur
									)
								(select ".$id_skp.", uraian_tugas,
									angka_kredit, kuantitas,
									kuantitas_satuan, kualitas,
									waktu, waktu_satuan,
									biaya, 0, unsur
						from skp_target
						where id_skp = ".$last_id_skp.")";

				$this->mysqli->query($query_copy);

			}

			echo $id_skp;
		}else{
			echo "gagal menyimpan : ".$this->mysqli->error;
		}

	}

	public function update_periode(){

		$query = "update skp_header set periode_akhir ='".$_POST['revPeriodeAkhir']."' where id_skp = '".$_POST['idskp']."'";
		if($this->mysqli->query($query)){
			echo "Berhasil";
		}else{
			echo "gagal update periode akhir skp : ".$this->mysqli->error;
		}

	}

	public function add_target(){

		if(isset($_POST['unsur'])){
			$unsur = "'".$_POST['unsur']."'";
		}else{
			$unsur = "NULL";
		}
		$query = "insert INTO skp_target(
					id_skp,
					uraian_tugas,
					angka_kredit,
					kuantitas,
					kuantitas_satuan,
					kualitas,
					waktu,
					waktu_satuan,
					biaya,
					status_pengajuan,
					urutan,
					unsur
				)VALUES(
						'".$_POST['idskp']."',
						'".$_POST['inputUraian']."',
						'".$_POST['inputAK']."',
						'".$_POST['inputKuantitas']."',
						'".$_POST['inputKuantitasSatuan']."',
						'".$_POST['inputKualitas']."',
						'".$_POST['inputWaktu']."',
						'".$_POST['inputWaktuSatuan']."',
						'".$_POST['inputBiaya']."',
						'0',
						'".$_POST['inputUrutan']."',
						".$unsur."
					)";
		//echo "$query";
		try{
			if($this->mysqli->query($query)){
				//echo "1";
				echo $this->mysqli->insert_id;

			}else{
				echo "gagal menyimpan \n".$this->mysqli->error;
			}
		}catch(Exception $e){
			echo "Error mas bro".$e->getMessage();
		}

		//return $query;
	}



	public function save_realisasi_target(){

		$nilai = $this->hitung_nilai();


		$query = "update skp_target set
					real_angka_kredit	= '".$_POST['realAngkaKredit']."',
					real_kuantitas		= '".$_POST['realKuantitas']."',
					real_kualitas		= '".$_POST['realKualitas']."',
					real_waktu			= '".$_POST['realWaktu']."',";

		if($_POST['realBiaya'] == 0 or $_POST['realBiaya'] == NULL ){

			$query .= "real_biaya = NULL,";
		}else{
			$query .= "real_biaya= ".$_POST['realBiaya'].",";
		}

		$query	.="
					hitung_nilai		= ".$nilai['hitung_nilai'].",
					nilai_capaian		= ".$nilai['nilai_capaian']."
				 where id_skp_target = '".$_POST['idtarget']."'";
		//echo $query;
		if($this->mysqli->query($query)){
			echo $query;
		}else{
			echo "gagal menyimpan update :".$query;
		}

	}

	public function save_review_skp(){


		$query = "update skp_header set review = '".$_POST['review']."' where id_skp = '".$_POST['idskp']."'";

		if($this->mysqli->query($query)){
			echo "Berhasil";
			//echo $query ;
		}else{
			echo "gagal menyimpan update "+$this->mysqli->error;
		}

	}


	public function save_review_target(){

		$query = "update skp_target set review = '".$_POST['review']."' where id_skp_target = ".$_POST['idtarget'];
	}

	public function del_target(){

		$query = "delete from skp_target where id_skp_target = ".$_POST['idtarget'];
		if($this->mysqli->query($query)){
			echo "1";
		}else{
			echo "gagal hapus "+$this->mysqli->error;
		}

	}

	public function del_skp(){

		$query = "delete from skp_header where id_skp = ".$_POST['idskp'];
		if($this->mysqli->query($query)){
			echo "1";
		}else{
			echo "gagal hapus "+$this->mysqli->error;
		}

	}

	public function save_tugas_tambahan(){

		$query = "insert into skp_tambahan_kreatifitas(
					id_skp,
					tugas_tambahan,
					jenis
				) VALUES(
					'".$_POST['idskp']."',
					'".$_POST['tugastambahan']."',
					'".$_POST['jenis']."'
				)";
		try{
			if($this->mysqli->query($query)){
				//echo "1";
				echo $this->mysqli->insert_id;
			}else{
				echo "gagal menyimpan	".$this->mysqli->error;
			}
		}catch(Exception $e){
			echo "Error mas bro".$e->getMessage();
		}

	}

	function reset_penilaian(){

		$query = "update skp_target set real_angka_kredit = NULL,
											real_kuantitas = NULL,
											real_kualitas = NULL,
											real_waktu = NULL,
											real_biaya = NULL,
											hitung_nilai = NULL, nilai_capaian = NULL where id_skp_target = '".$_POST['idtarget']."'";

		if($this->mysqli->query($query)){
			echo "1";
		}else{
			echo "gagal reset ".$this->mysqli->error;
		}

	}

	public function del_tambahan(){


		$query = "delete from skp_tambahan_kreatifitas where id_tambahan_kreatifitas = ".$_POST['idtambahan'];
		if($this->mysqli->query($query)){
			echo "1";
		}else{
			echo "gagal hapus ".$this->mysqli->error;
		}

	}

	public function save_perilaku(){


		$query = "update skp_header set
					orientasi_pelayanan='".$_POST['orientasipelayanan']."',
					integritas		='".$_POST['integritas']."',
					komitmen		='".$_POST['komitmen']."',
					disiplin		='".$_POST['disiplin']."',
					kerjasama		='".$_POST['kerjasama']."',";


		if($_POST['kepemimpinan'] == '0' || $_POST['kepemimpinan'] == NULL){
			//$kepemimpinan = NULL;
			$query .= "kepemimpinan = NULL ";
		}else{
			$query .= "kepemimpinan = '".$_POST['kepemimpinan']."'";
		}

		$query 		.=	"where id_skp	= '".$_POST['idskp']."'";


		if($this->mysqli->query($query)){
			echo "1";
		}else{
			echo "gagal menyimpan	".$query."<br>".$this->mysqli->error;
		}

		// echo $query;
	}

	public function sebutan_capaian($nilai){

		if($nilai < 51){
			return "Buruk";
		}elseif($nilai >= 51 && $nilai < 61){
			return "Kurang";
		}elseif($nilai >= 61 && $nilai < 76){
			return "Cukup";
		}elseif($nilai >= 76 && $nilai < 91){
			return "Baik";
		}elseif($nilai >= 91 ){
			return "Sangat Baik";
		}else{
			return "Nilai tidak terdefinisi";
		}

	}


	public function update_status_pengajuan(){

		$query = "update skp_header set status_pengajuan = '".$_POST['statusPengajuan']."' where id_skp = '".$_POST['idskp']."'";

		if($this->mysqli->query($query)){
			echo "1";
		}else{
			echo "gagal update "+$this->mysqli->error;
		}

	}

	public function get_dinilai_old($pegawai){

		//kalo pegawai bukan pejabat struktural
		if($pegawai->id_j == NULL) {
			//cek kalo dia kepala sekolah
			if($pegawai->kepsek_di != NULL){
				//ambil guru guru yang ada di sekolah dengan id_unit kerja $pegawai->kepsek_di
				$query = "select * from pegawai
							inner join current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai
							where clk.id_unit_kerja = ".$pegawai->kepsek_di."
							and pegawai.jabatan = 'guru'

							and flag_pensiun <> 1";

				return $this->mysqli->query($query);
			}else{
				return false;
			}

		}

		$query = "select * from jabatan
					inner join pegawai on pegawai.id_j = jabatan.id_j
					where jabatan.id_bos = '".$pegawai->id_j."'";
		$result = $this->mysqli->query($query);
		if($result->num_rows > 0){
			return $result;
		}else{
			$query = "SELECT rmk.id_j_bos, p.*, rmk.id_pegawai
						FROM riwayat_mutasi_kerja rmk
						INNER JOIN pegawai p on p.id_pegawai = rmk.id_pegawai
						INNER JOIN
						(
							SELECT s.id_sk, tmt
							FROM sk s
							INNER JOIN
							(
								SELECT rmk.id_pegawai, MAX(s.tmt) as max_tmt, s.id_sk
								FROM riwayat_mutasi_kerja rmk
								INNER JOIN sk s ON s.id_sk = rmk.id_sk
								GROUP BY rmk.id_pegawai
							) AS t ON t.id_pegawai = s.id_pegawai AND s.tmt = t.max_tmt
						) AS t ON t.id_sk = rmk.id_sk
					   WHERE rmk.id_j_bos = '".$pegawai->id_j."' AND p.flag_pensiun <> 1";
			return $this->mysqli->query($query);
		}

	}


	public function get_dinilai($pegawai){

		//print_r($pegawai);
		if($pegawai->id_pegawai == NULL){
			$pegawai->id_pegawai = $_SESSION['id_pegawai'];
		}
		$query = "select distinct skp_header.id_pegawai, p.*
					from skp_header
					inner join pegawai p on p.id_pegawai = skp_header.id_pegawai
					where id_penilai = ".$pegawai->id_pegawai."
					order by p.nip_baru ASC
					";
		//return $query;
		return $this->mysqli->query($query);

	}

	public function get_dinilai2($pegawai){

		if($pegawai->id_pegawai == NULL){
			$pegawai->id_pegawai = $_SESSION['id_pegawai'];
		}

		$query = "select distinct skp_header.id_pegawai, p.*
					from skp_header
					inner join pegawai p on p.id_pegawai = skp_header.id_pegawai
					where id_penilai = ".$_SESSION['id_pegawai']." OR id_penilai_realisasi = ".$_SESSION['id_pegawai']."
					order by p.nip_baru ASC
					";

		return $this->mysqli->query($query);

	}

	public function get_penilai($pegawai){

		/*echo "<pre>";
		print_r($pegawai);
		echo "</pre>";
		die;
		*/


		$obj_pegawai = new Pegawai;

		/**
		 * kalo id_j pegawainya walikota, atasannya walikota
		 * id_j walikota adalah 1960
		 *
		 */
		 //echo 'A '.$pegawai->id_j.'<br>';
		 if(isset($pegawai->id_j)){
		if($pegawai->id_j == '4375' || $pegawai->id_j == '3222'){

			//return $pegawai;
			$nonpns = $pegawai;
			$nonpns->nama_baru	= "Pemerintah Kota Bogor";
			return $nonpns;

			die;
		}
	}

	//	echo "<pre>";
		//print_r($pegawai);
		//echo "</pre>";

	//echo $pegawai->jenjab ." ". $pegawai->id_j;
		if(isset($pegawai->id_j) != NULL && $pegawai->jenjab == "Struktural"){


			$sql = "select * from pegawai
							where  id_j =
							(select id_bos from jabatan where id_j = ".$pegawai->id_j.")
							and flag_pensiun != 1
							";
			//echo "bla....".$sql;exit;

			//$result = $this->mysqli->fetch_object($this->mysqli->query($sql));
			if($query_atasan = $this->mysqli->query($sql)){
				$result = $query_atasan->fetch_object();
			}else{

				$sql = "  select * from jabatan_plt plt
    							inner join pegawai p on p.id_pegawai = plt.id_pegawai where plt.id_j =
									(select id_bos from jabatan where id_j = ".$pegawai->id_j."
										and p.flag_pensiun != 1)";
				$result = $this->mysqli->query($sql)->fetch_object();
			}


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

			/*
			 * kalo dia punya atasan walikota
			 * penilainya adalah sekda
			 *
			 *
			if($result->id_j == '2004'){
				$sekda = "select id_pegawai from pegawai where id_j = '2004'";
				$sekda = $this->mysqli->fetch_object($this->mysqli->query($sekda));
				return $obj_pegawai->get_obj($sekda->id_pegawai);
				die;
			}
			*/

			if(! $result){
				// kalo bos nya gak ada, ambil lagi bos diatasnya.
				// pengembangan berikutnya kalo jabatan tersebut ada pltnya
				$bos_g_ada = $this->mysqli->query("select id_bos from jabatan where id_j = ".$pegawai->id_j)->fetch_object();

				$sql = "select * from pegawai
							where  id_j =
							(select id_bos from jabatan where id_j = ".$bos_g_ada->id_bos.")
							and (flag_pensiun != 1)
							";
				$result = $this->mysqli->query($sql)->fetch_object();

			}

			if($result){
				return $obj_pegawai->get_obj($result->id_pegawai);
			}else{
				//echo "penilai dari ".$pegawai->nama." ".$pegawai->id_j." tidak ditemukan";
			}



		}elseif(isset($pegawai->id_j) == NULL && isset($pegawai->jenjab) == 'Struktural'){
			//jfu
			$query = "select * from riwayat_mutasi_kerja where id_pegawai = '".$pegawai->id_pegawai."'";
			$query .= "and id_riwayat = (select MAX(id_riwayat) from riwayat_mutasi_kerja where id_pegawai = '".$pegawai->id_pegawai."') ";
			//echo $query;exit;
			$r		= $this->mysqli->query($query)->fetch_object()->id_j_bos;

			$bos = "select id_pegawai from pegawai where id_j = '".$r."'";
			$bos = $this->mysqli->query($bos)->fetch_object();
			//echo
			return @$obj_pegawai->get_obj($bos->id_pegawai);

		}else{ // jabatan fungsional

			//return $obj_pegawai->get_obj($pegawai->id_pegawai);
			return $this->get_penilai_jft($pegawai);

		}

	}

	public function get_penilai_jft($pegawai){

		$id_j_kadisdik = "2015";
		$id_j_sekretaris_disdik = "2053";
		$id_j_kabid_dikdas = "3140"; //sekolah dasar
		$id_j_kabid_dikmen = "3141";
		$id_j_kabid_dikinformal = "2089";
		$id_j_ka_uptd_skb = "2490";

		$obj_pegawai = new Pegawai;
		//$jft = isset()$obj_pegawai->get_obj($pegawai->id_pegawai);
		$jft = $pegawai;


		//cek fungsional dia apakah jabatan fungsional dia guru
		if(isset($jft->jabatan) == "Guru"){
			//cek lagi apakah dia kepala sekolah

			//echo $jft->is_kepsek;
			if($jft->is_kepsek != '0'){
			/* penilai kepala sekolah disini */

				/*if(strpos($jft->nama_baru,"TK") !== FALSE ||
					strpos($jft->nama_baru,"SD") !== FALSE ||
					strpos($jft->nama_baru,"SMP") !== FALSE){

					if(strpos($jft->nama_baru,"TK") !== FALSE ||
					strpos($jft->nama_baru,"SD") !== FALSE){
						$id_j = $id_j_kabid_dikdas;
					}else{
						$id_j = $id_j_kabid_dikmen;
					}

					if($obj_pegawai->get_by_id_j($id_j)){
						return $obj_pegawai->get_obj($obj_pegawai->get_by_id_j($id_j)->id_pegawai);
					}else{
						//hack ngacoooo...... ambil kadisdik
						return $obj_pegawai->get_obj($obj_pegawai->get_by_id_j($id_j_kadisdik)->id_pegawai);

					}

				}else{
					if($obj_pegawai->get_by_id_j($id_j_kabid_dikmen)){
						return $obj_pegawai->get_obj($obj_pegawai->get_by_id_j($id_j_kabid_dikmen)->id_pegawai);
					}else{
						return $obj_pegawai->get_obj($obj_pegawai->get_by_id_j($id_j_kadisdik)->id_pegawai);
					}

				}*/

				if(strpos($jft->nama_baru,"TK") !== FALSE || strpos($jft->nama_baru,"SD") !== FALSE || strpos($jft->nama_baru,"SMP") !== FALSE){
					$id_j = $id_j_kabid_dikdas;
				}else{
					$id_j = $id_j_kabid_dikmen;
				}
				return $obj_pegawai->get_obj($obj_pegawai->get_by_id_j($id_j)->id_pegawai);
			}else{
			/*penilai guru disini (Kepala sekolah) */

				if($kepsek = $obj_pegawai->get_by_kepsek_di($jft->id_unit_kerja)){
					//echo "!".$obj_pegawai->get_obj($kepsek->id_pegawai)->nama;
					return $obj_pegawai->get_obj($kepsek->id_pegawai);
				}else{

					//echo $jft->id_unit_kerja;
					return $obj_pegawai->get_obj($pegawai->id_pegawai);

					echo "Kepala Sekolah tidak ditemukan";
				}
			}
		}else{
			//jft yang lainnya
			if(strpos(isset($jft->jabatan),"Pengawas Sekolah") !== FALSE ||
				strpos(isset($jft->jabatan),"Penilik") !== FALSE){

				return $obj_pegawai->get_obj($obj_pegawai->get_by_id_j($id_j_sekretaris_disdik)->id_pegawai);

			}elseif(strpos(isset($jft->jabatan),"Pamong Belajar") !== FALSE){

				return $obj_pegawai->get_obj($obj_pegawai->get_by_id_j($id_j_ka_uptd_skb)->id_pegawai);
			}else{

				//jft yang belum ditentukan pejabat penilainya
				$query = "select * from riwayat_mutasi_kerja where id_pegawai = '".isset($pegawai->id_pegawai)."'";
				$query .= "and id_riwayat = (select MAX(id_riwayat) from riwayat_mutasi_kerja where id_pegawai = '".isset($pegawai->id_pegawai)."') ";


				$r		= $this->mysqli->query($query)->fetch_object()->id_j_bos;

				$bos_query = "select id_pegawai from pegawai where id_j = '".$r."'";
				//echo $bos_query;exit;
				$bos = $this->mysqli->query($bos_query)->fetch_object();

				if(!$bos){
					return $pegawai;
				}else{
					return $obj_pegawai->get_obj($bos->id_pegawai);
				}

			}


		}

	}

	/**
	 * parameternya id unit kerja sekolah
	 * return pegawai
	 * cari sampai dapat, kalo penilainya kosong cari lagi ke atasnya.
	 * */
	function get_penilai_kepsek($id_unit_kerja){

		$uk = new Unit_kerja();

		$id_j_kadisdik = "1000";
		$id_j_sekretaris_disdik = "1001";
		$id_j_kabid_dikdas = "1002";
		$id_j_kabid_dikmen = "1003";
		$id_j_kabid_dikinformal = "1005";
		$id_j_ka_uptd_skb = "1020";

		$nama_sekolah = $uk->get_unit_kerja($id_unit_kerja)->nama_baru;

		if(strpos($nama_sekolah,"TK") !== FALSE ||
			strpos($nama_sekolah,"SD") !== FALSE ||
			strpos($nama_sekolah,"SMP") !== FALSE){


			if($obj_pegawai->get_by_id_j($id_j_kabid_dikdas)){
				return $obj_pegawai->get_obj($obj_pegawai->get_by_id_j($id_j_kabid_dikdas)->id_pegawai);
			}else{
				//hack ngacoooo...... ambil kadisdik
				return $obj_pegawai->get_obj($obj_pegawai->get_by_id_j($id_j_kadisdik)->id_pegawai);

			}

		}else{
			if($obj_pegawai->get_by_id_j($id_j_kabid_dikmen)){
				return $obj_pegawai->get_obj($obj_pegawai->get_by_id_j($id_j_kabid_dikmen)->id_pegawai);
			}else{
				return $obj_pegawai->get_obj($obj_pegawai->get_by_id_j($id_j_kadisdik)->id_pegawai);
			}

		}

	}

	/**
	 * menghitung nilai capaian skp
	 * @param int idtarget
	 * @retur array nilai hitung, dan nilai capaian
	 * */
	public function hitung_nilai(){

		$id_target 	= $_POST['idtarget'];

		$query = "select * from skp_target where id_skp_target = '".$_POST['idtarget']."'";
		$target = $this->mysqli->query($query)->fetch_object();

		$aspek_kuantitas	= ($_POST['realKuantitas']/ $target->kuantitas)*100;
		$aspek_kualitas		= ($_POST['realKualitas'] / $target->kualitas)*100;

		/**
		 * hitung aspek biaya
		 * pertama hitung dulu efisiensi waktu
		 * */
		$efisiensi_waktu = 100 - ($_POST['realWaktu'] / $target->waktu * 100);

		/**
		 * kalo kegiatan tidak dilakukan berarti realisasinya o
		 * */

		if($target->waktu > 0 && $_POST['realWaktu'] <= 0){
			$aspek_waktu = ((1.76 * $target->waktu - $target->real_waktu) / $target_waktu) * 0 * 100;

		/**
		 * kalo dilakukan kegiatannya
		 * */
		}else{
			/**
			 * kalo persentase efisiensi waktu kurang dari 24%
			 * */
			if($efisiensi_waktu <= 24 ){
				$aspek_waktu = ((1.76 * $target->waktu - $_POST['realWaktu']) / $target->waktu) * 100;
			/**
			 * kalo efisiensi waktu lebih dari 24%
			 * nilainya ke cukup sampe buruk
			 * */
			}elseif($efisiensi_waktu > 24 ){
				$aspek_waktu = 76 - ((((1.76 * $target->waktu - $_POST['realWaktu']) / $target->waktu) * 100) - 100);

			}
		}

			/**
		 * dalam hal kegiatan tidak dilakukan maka realisasi biaya nol
		 * pertama yang dilakukan adalah hitung efisiensi biaya dulu
		 * */
		if($target->biaya > 0){
			$efisiensi_biaya = 100 - ($_POST['realBiaya'] / $target->biaya * 100);
		}



		if($target->biaya > 0 && $_POST['realBiaya'] <= 0){

			$aspek_biaya = ((1.76 * $target->biaya - $_POST['realBiaya'] ) / $target->biaya) * 0 * 100;
		}elseif($target->biaya > 0){


			if($efisiensi_biaya <= 24){
				$aspek_biaya = ((1.76 * $target->biaya - $_POST['realBiaya']) / $target->biaya) * 100;

			}elseif($efisiensi_biaya > 24){
				$aspek_biaya = 76 - ((((1.76 * $target->biaya - $_POST['realBiaya']) / $target->biaya) * 100) - 100);
			}
		}

		//jumlahkan semua aspek
		$penghitungan_aspek = $aspek_kuantitas + $aspek_kualitas + $aspek_waktu;

		if($target->biaya > 0) {
				$penghitungan_aspek += $aspek_biaya;
		}


		if($target->biaya > 0 ){
			$nilai_capaian = $penghitungan_aspek / 4;
		}else{
			$nilai_capaian = $penghitungan_aspek / 3;
		}


		$penghitungan_aspek = number_format($penghitungan_aspek,2);
		$nilai_capaian = number_format($nilai_capaian,2);
		return $nilai = array('hitung_nilai'=>$penghitungan_aspek, 'nilai_capaian'=>$nilai_capaian) ;


	}

	public function get_status($kode_status){


			return $this->mysqli->query("select * from skp_status where kode_status = '".$kode_status."'")->fetch_object();

	}

	public function set_status(){

			$query = ("update skp_header set status_pengajuan = '".$_POST['kodeStatus']."' where id_skp = '".$_POST['idskp']."'");

			if($this->mysqli->query($query)){
				echo "berhasil ".$_POST['kodeStatus'];
			}else{
				echo "gagal update "+$this->mysqli->error;
			}


	}

	public function get_faq(){

		$faq = array();

		$query = "select * from faq where faq_for = 'skp'";
		$results = $this->mysqli->query($query);

		while($result =  $results->fetch_object()){
			$faq[] = $result;
		}

		return $faq;

	}

	public function get_stk($id,$jenjang,$id_unit_kerja){





		switch ($jenjang) {
			case 'STRUKTURAL':
				$q = "select * from stk_skp where id_j = ".$id." and id_unit_kerja = ".$id_unit_kerja;
				break;
			case 'PELAKSANA':
				$q = "select * from stk_skp where id_jfu = ".$id." and id_unit_kerja = ".$id_unit_kerja;
				break;
			case 'FUNGSIONAL':
				$q = "select * from stk_skp where id_jft = ".$id." and id_unit_kerja = ".$id_unit_kerja;
				break;
			default:
				$q = "select * from stk_skp";
				break;

		}


		$results = $this->mysqli->query($q);

		while($result =  $results->fetch_object()){
			$stk[] = $result;
		}



		return $stk;

	}

}
