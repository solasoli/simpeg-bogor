<?php 
require_once("../../konek.php");
require_once("../../class/pegawai.php");
require_once "../../class/unit_kerja.php";

if($_POST){
	
	$skp = new SKP;
	switch($_POST['aksi']){
				
		case 'tambahSkp' :
			$skp->add_skp();
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
		default:
			//echo "error : undefined post";
	}
}


class Skp{
		
	var $id_pegawai	;
	
			
	
	
	public function set_id_pegawai($id_pegawai){
		
		$this->id_pegawai = $id_pegawai;
	}
	
	public function get_skp($id_pegawai = NULL, $last = NULL){
		
		if(!isset($id_pegawai)) $id_pegawai = $this->id_pegawai;
		
		$query = "select * from skp_header where id_pegawai = ".$id_pegawai;
		if(isset($last) == TRUE){ 
			$query .= " and periode_awal = (select MAX(periode_awal) from skp_header where id_pegawai=".$id_pegawai." )";
			//return $query;
		}
		
		$query .= " ORDER BY periode_awal ASC";
		
		return mysql_query($query);
	}
	
	public function get_tahun_skp($id_pegawai){
		
		$query = "select DISTINCT YEAR(periode_awal) as tahun from skp_header where id_pegawai = ".$id_pegawai." ORDER BY tahun DESC";
		return mysql_query($query);
	}
	
	public function get_awal_periode($id_pegawai, $tahun){
		
		$query = "select MIN(periode_awal) as awal from skp_header where id_pegawai = ".$id_pegawai." and periode_awal like '".$tahun."%'";
		return mysql_fetch_object(mysql_query($query));
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
						as rata2_perilaku 
				from skp_header s
				where id_pegawai = ".$id_pegawai."
				and periode_akhir = 
					(select MAX(periode_akhir) 
					from skp_header 
					where id_pegawai = ".$id_pegawai."
					and periode_akhir like '".$tahun."%')";
		return mysql_fetch_object(mysql_query($query));
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
			if(isset($json) == 'TRUE'){
				echo json_encode(mysql_fetch_array(mysql_query($query)));		
			}else{
				return mysql_fetch_object(mysql_query($query));
			}
			
	}
	// untuk pengecekan status disabled button
	public function get_status_skp(){
	
		if(! isset($_POST['idskp'])) die ;
		$query = "select status_pengajuan from skp_header where id_skp = '".$_POST['idskp']."'";
		echo mysql_fetch_object(mysql_query($query))->status_pengajuan;		
	}
	
	public function get_target($idskp){
		
		$query = "select * from skp_target where id_skp = ".$idskp." order by urutan ASC, id_skp_target ASC";	
		return mysql_query($query);		
	}
	
	
	
	public function get_target_history($id_target){
	
			$query = "select * from skp_target_history where id_skp_target = ".$id_target;
			if($result = mysql_query($query)){
				return $result;
			}else{
				return FALSE;
			}
	}
	
	public function get_uraian_target($idtarget = NULL){
		
		if(isset($idtarget)){
			$query = "select * from skp_target where id_skp_target = ".$idtarget;
			return mysql_fetch_object(mysql_query($query));
		}else{
			$query = "select * from skp_target where id_skp_target = ".$_POST['idtarget'];
			echo json_encode(mysql_fetch_array(mysql_query($query)));
		}
		
		//return $query
	}
	
	public function get_tambahan_kreatifitas($idskp, $jenistambahan){
		
		$query = "select * from skp_tambahan_kreatifitas t where id_skp = '".$idskp."' and jenis = '".$jenistambahan."'";
		return mysql_query($query);
		//return $query;
	}
	
	public function get_nilai_tambahan($idskp,$jenistambahan){
		$query = "select count(*) as jumlah from skp_tambahan_kreatifitas where id_skp = '".$idskp."' and jenis = '".$jenistambahan."'";
		$jumlah =mysql_fetch_object(mysql_query($query))->jumlah;
		
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
		return mysql_fetch_object(mysql_query($query));
	}
	
	public function get_nilai_capaian_rata2($id_pegawai, $tahun){
		
		$skps = mysql_query("select id_skp from skp_header 
				where periode_awal like '".$tahun."%' and id_pegawai = '".$id_pegawai."'");
		
		$nilai_capaian = array();
		$rata2_nilai_skp = 0;
		
		while($skp = mysql_fetch_object($skps)){
		
			$nilai_capaian[] = $this->get_nilai_capaian($skp->id_skp)->rata2_nilai_skp;
		}		
		
		return array_sum($nilai_capaian) / count($nilai_capaian);
	}
	
		
	public function update_target(){
		$query = "update skp_target set					
					uraian_tugas= '".$_POST['inputUraian']."',
					angka_kredit= '".$_POST['inputAK']."',
					kuantitas= '".$_POST['inputKuantitas']."',
					kuantitas_satuan= '".$_POST['inputKuantitasSatuan']."',
					kualitas= '".$_POST['inputKualitas']."',
					waktu= '".$_POST['inputWaktu']."',
					waktu_satuan= '".$_POST['inputWaktuSatuan']."',
					biaya= '".$_POST['inputBiaya']."',
					urutan= '".$_POST['inputUrutan']."'
					where id_skp_target = '".$_POST['idtarget']."'";
				
		
		try{
			if(mysql_query($query)){
				echo "1";
			}else{
				echo "gagal menyimpan	".$query;
			}
		}catch(Exception $e){
			echo "Error mas bro".$e->getMessage();
		}
		
		//return $query;
	}
	
	public function revisi_target(){
		
				
		$query1 = "select id_skp_target from skp_target_history where id_skp_target = '".$_POST['idtarget']."'";
		
		if(mysql_num_rows(mysql_query($query1)) < 1){
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
			if(mysql_query($query2)){				
				$this->update_target();
			}else{
				echo "gagal dump ke history";
			}
		}else{
			$this->update_target();
		}
	}
	
	public function add_skp(){
		
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
				
		
		if(mysql_query($query)){
			/*
			 * mysql_query("lock tables skp_header WRITE");
			$id_skp = mysql_fetch_object(mysql_query("select MAX(id_skp) as id_skp from skp_header"))->id_skp;
			mysql_query("unlock tables");
			* */
			echo mysql_insert_id();
		}else{
			echo "gagal menyimpan	".mysql_error();
		}		
	}
	
	public function update_periode(){
		$query = "update skp_header set periode_akhir ='".$_POST['revPeriodeAkhir']."' where id_skp = '".$_POST['idskp']."'";
		if(mysql_query($query)){
			echo "Berhasil";
		}else{
			echo "gagal update periode akhir skp : ".mysql_error();
		}
	}
	
	public function add_target(){
		
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
					urutan
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
						'".$_POST['inputUrutan']."'							
					)";
		
		try{
			if(mysql_query($query)){
				//echo "1";
				echo mysql_insert_id();
			}else{
				echo "gagal menyimpan	".mysql_error();
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
		if(mysql_query($query)){
			echo $query;
		}else{
			echo "gagal menyimpan update :".$query;
		}
					
	}
	
	public function save_review_skp(){
		
		$query = "update skp_header set review = '".$_POST['review']."' where id_skp = '".$_POST['idskp']."'";
		
		if(mysql_query($query)){
			echo "Berhasil";
			//echo $query ;
		}else{
			echo "gagal menyimpan update "+mysql_error();
		}
	}
	
	
	public function save_review_target(){
		
		$query = "update skp_target set review = '".$_POST['review']."' where id_skp_target = ".$_POST['idtarget'];
	}
	
	public function del_target(){
		
		$query = "delete from skp_target where id_skp_target = ".$_POST['idtarget'];
		if(mysql_query($query)){
			echo "1";
		}else{
			echo "gagal hapus "+mysql_error();
		}
	}
	
	public function del_skp(){
		
		$query = "delete from skp_header where id_skp = ".$_POST['idskp'];
		if(mysql_query($query)){
			echo "1";
		}else{
			echo "gagal hapus "+mysql_error();
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
			if(mysql_query($query)){
				//echo "1";
				echo mysql_insert_id();
			}else{
				echo "gagal menyimpan	".mysql_error();
			}
		}catch(Exception $e){
			echo "Error mas bro".$e->getMessage();
		}
	}
	
	public function del_tambahan(){
		
		$query = "delete from skp_tambahan_kreatifitas where id_tambahan_kreatifitas = ".$_POST['idtambahan'];
		if(mysql_query($query)){
			echo "1";
		}else{
			echo "gagal hapus "+mysql_error();
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
					
		
		if(mysql_query($query)){				
			echo "1";
		}else{
			echo "gagal menyimpan	".$query."<br>".mysql_error();
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
		
		if(mysql_query($query)){
			echo "1";
		}else{
			echo "gagal update "+mysql_error();
		}
	}
	
	public function get_dinilai($pegawai){
		
		//kalo pegawai bukan pejabat struktural
		if($pegawai->id_j == NULL) {			
			//cek kalo dia kepala sekolah
			if($pegawai->kepsek_di != NULL){
				//ambil guru guru yang ada di sekolah dengan id_unit kerja $pegawai->kepsek_di
				$query = "select * from pegawai 
							inner join current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai 
							where clk.id_unit_kerja = ".$pegawai->kepsek_di."
							and pegawai.jabatan = 'guru'
							
							and flag_pensiun = 0";
				
				return mysql_query($query);
			}else{
				return false;
			}
			
		}
		
		$query = "select * from jabatan 
					inner join pegawai on pegawai.id_j = jabatan.id_j
					where jabatan.id_bos = '".$pegawai->id_j."'";
		$result = mysql_query($query);
		if(mysql_num_rows($result) > 0){
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
					   WHERE rmk.id_j_bos = '".$pegawai->id_j."' AND p.flag_pensiun = 0";			
			return mysql_query($query);
		}				
		
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
		if($pegawai->id_j == '2003'){
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
			
			
			$result = mysql_fetch_object(mysql_query($sql));
						
						
			
			/**
			 * kalo id_j sekda (1978) atasannya walikota
			 * */
			if($pegawai->id_j == 2004){
				 
				//echo "sekda".$pegawai->id_j;
				return $obj_pegawai->get_obj($result->id_pegawai);								 
				//die;
			}
			
			/**
			 * kalo dia punya atasan walikota
			 * penilainya adalah sekda
			 * 
			 * */
			if($result->id_j == '2003'){
				$sekda = "select id_pegawai from pegawai where id_j = '2004'";
				$sekda = mysql_fetch_object(mysql_query($sekda));
				return $obj_pegawai->get_obj($sekda->id_pegawai);
				die;
			}
			
			
			if(! $result){
				// kalo bos nya gak ada, ambil lagi bos diatasnya.
				// pengembangan berikutnya kalo jabatan tersebut ada pltnya
				$bos_g_ada = mysql_fetch_object(mysql_query("select id_bos from jabatan where id_j = ".$pegawai->id_j));
				
				$sql = "select * from pegawai 
							where  id_j =
							(select id_bos from jabatan where id_j = ".$bos_g_ada->id_bos.")
							and (flag_pensiun != 1)
							";
				$result = mysql_fetch_object(mysql_query($sql));
				
			}
			
			if($result){
				return $obj_pegawai->get_obj($result->id_pegawai);
			}else{
				echo "penilai dari ".$pegawai->nama." ".$pegawai->id_j." tidak ditemukan";
			}
			
						
		
		}elseif($pegawai->id_j == NULL && $pegawai->jenjab == 'Struktural'){
			//jfu
			$query = "select * from riwayat_mutasi_kerja where id_pegawai = '".$pegawai->id_pegawai."'";
			$query .= "and id_riwayat = (select MAX(id_riwayat) from riwayat_mutasi_kerja where id_pegawai = '".$pegawai->id_pegawai."') ";
			//echo $query;
			$r		= mysql_fetch_object(mysql_query($query))->id_j_bos;
			
			$bos = "select id_pegawai from pegawai where id_j = '".$r."'";
			$bos = mysql_fetch_object(mysql_query($bos));
			//echo 
			return $obj_pegawai->get_obj($bos->id_pegawai);
			
		}else{ // jabatan fungsional
						
			//return $obj_pegawai->get_obj($pegawai->id_pegawai);
			return $this->get_penilai_jft($pegawai);
				
		}
	}
	
	public function get_penilai_jft($pegawai){
		$id_j_kadisdik = "2015";
		$id_j_sekretaris_disdik = "2053";
		$id_j_kabid_dikdas = "2087";
		$id_j_kabid_dikmen = "2088";
		$id_j_kabid_dikinformal = "2089";
		$id_j_ka_uptd_skb = "2490";
		
		$obj_pegawai = new Pegawai;
		$jft = $obj_pegawai->get_obj($pegawai->id_pegawai);
		
		
		
		//cek fungsional dia apakah jabatan fungsional dia guru				
		if($jft->jabatan == "Guru"){
			//cek lagi apakah dia kepala sekolah
			
			if(isset($jft->kepsek_di) != NULL){
			/* penilai kepala sekolah disini */	
				
				if(strpos($jft->nama_baru,"TK") !== FALSE || 
					strpos($jft->nama_baru,"SD") !== FALSE || 
					strpos($jft->nama_baru,"SMP") !== FALSE){
					
					
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
			}else{
			/*penilai guru disini (Kepala sekolah) */
				if($kepsek = $obj_pegawai->get_by_kepsek_di($jft->id_unit_kerja)){
					//echo $kepsek->nama;
					return $obj_pegawai->get_obj($kepsek->id_pegawai);
				}else{
					
					//echo $jft->id_unit_kerja;
					return $obj_pegawai->get_obj($pegawai->id_pegawai);
					
					echo "Kepala Sekolah tidak ditemukan";
				}
			}
		}else{
			//jft yang lainnya
			if(strpos($jft->jabatan,"Pengawas Sekolah") !== FALSE ||
				strpos($jft->jabatan,"Penilik") !== FALSE){
					
				return $obj_pegawai->get_obj($obj_pegawai->get_by_id_j($id_j_sekretaris_disdik)->id_pegawai);
				
			}elseif(strpos($jft->jabatan,"Pamong Belajar") !== FALSE){
				
				return $obj_pegawai->get_obj($obj_pegawai->get_by_id_j($id_j_ka_uptd_skb)->id_pegawai);
			}else{
						
				//jft yang belum ditentukan pejabat penilainya
				$query = "select * from riwayat_mutasi_kerja where id_pegawai = '".$pegawai->id_pegawai."'";
				$query .= "and id_riwayat = (select MAX(id_riwayat) from riwayat_mutasi_kerja where id_pegawai = '".$pegawai->id_pegawai."') ";
				$r		= mysql_fetch_object(mysql_query($query))->id_j_bos;
				
				$bos = "select id_pegawai from pegawai where id_j = '".$r."'";
				$bos = mysql_fetch_object(mysql_query($bos));
				return $obj_pegawai->get_obj($bos->id_pegawai);
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
		$target = mysql_fetch_object(mysql_query($query));
		
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
		
			return mysql_fetch_object(mysql_query("select * from skp_status where kode_status = '".$kode_status."'"));
	}
	
	public function set_status(){
		
			$query = ("update skp_header set status_pengajuan = '".$_POST['kodeStatus']."' where id_skp = '".$_POST['idskp']."'");
			
			if(mysql_query($query)){
				echo "berhasil ".$_POST['kodeStatus'];
			}else{
				echo "gagal update "+mysql_error();
			}
					
			
	}
	
	public function get_faq(){
		
		$faq = array();
		
		$query = "select * from faq where faq_for = 'skp'";
		$results = mysql_query($query);
		
		while($result =  mysql_fetch_object($results)){
			$faq[] = $result;	
		}
		
		return $faq;
	}
	
}
