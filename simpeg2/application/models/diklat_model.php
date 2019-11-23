<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Diklat_model extends CI_Model{
	
	
	public $id_pegawai;
	
	public function __construct(){
		
		
	}
	
	public function get_by_id_pegawai(){
		
		$query = $this->db->query("select * from diklat where id_pegawai = ".$this->id_pegawai);
		
		return $query->result();
		
	}
	
	public function get_pengajuan($status,$jenis,$bidang){
		$array = array();
		if($status!='0'){
			$array['idstatus_approve'] = $status;
		}
		if($jenis!='0'){
			$array['id_jenis_diklat'] = $jenis;
		}
		if($bidang!='0'){
			$array['id_bidang'] = $bidang;
		}
		if(sizeof($array) > 0){
			$this->db->where($array);
		}
		//$this->db->where('idstatus_approve',$status);
		$this->db->order_by('tgl_permintaan','DESC');
		$query = $this->db->get('kebutuhan_diklat');
		return $query->result();
	}
	
	function get_pengajuan_by_id($id){
		$this->db->where('id',$id);
		return $this->db->get('kebutuhan_diklat')->row();
	}

	function get_kebutuhan_diklat_by_id($id){
		$sql = "SELECT c.*, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
				nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS pemroses,
				uk.nama_baru
				FROM
				(SELECT b.*, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
				nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS pemohon
				FROM
				(SELECT a.id, a.id_unit_kerja, a.tgl_permintaan, dj.jenis_diklat, a.nama_diklat, bp.bidang,
				a.jumlah_peserta, a.tgl_pelaksanaan, a.idpegawai_pemohon, kds.status_keb_diklat,
				a.tgl_approve, a.idpegawai_approve, a.idstatus_approve FROM
				(SELECT * FROM kebutuhan_diklat kd
				WHERE kd.id = $id) a, diklat_jenis dj, bidang_pendidikan bp, kebutuhan_diklat_status kds
				WHERE a.id_jenis_diklat = dj.id_jenis_diklat AND a.id_jenis_diklat = bp.id
				AND a.idstatus_approve = kds.idstatus_keb_diklat) b
				LEFT JOIN pegawai p ON b.idpegawai_pemohon = p.id_pegawai) c
				LEFT JOIN pegawai p ON c.idpegawai_approve = p.id_pegawai, unit_kerja uk
				WHERE c.id_unit_kerja = uk.id_unit_kerja";
		$query = $this->db->query($sql);
		return $query->row();
	}

	function get_rekap_keikutsertaan_peserta($id){
		$sql = "SELECT
				SUM(1) AS jml_total,
				SUM(IF(kdd.status = 1, 1, 0)) as jml_ikut,
				SUM(IF(kdd.status = 0, 1, 0)) as jml_tak_ikut,
				SUM(IF(kdd.is_baru = 1, 1, 0)) as jml_baru
				FROM kebutuhan_diklat_detail kdd
				WHERE kdd.id_keb_diklat = $id;";
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	function hapus($id){
				
		return $this->db->delete('kebutuhan_diklat',array('id'=>$id));
	}
	
	public function get_detail_pengajuan($id_keb_diklat){
		
		//$this->db->where('id_keb_diklat',$id_keb_diklat);
		//$query = $this->db->get('kebutuhan_diklat_detail');
		/*$query = "SELECT
					IF(LENGTH(p.gelar_belakang) > 1,
						CONCAT(p.gelar_depan,
								' ',
								p.nama,
								CONCAT(', ', p.gelar_belakang)),
						CONCAT(p.gelar_depan, ' ', p.nama)) AS nama_lengkap,
					p.nip_baru,
					CASE
						WHEN
							(p.jenjab = 'Struktural'
								AND p.id_j IS NOT NULL)
						THEN
							j.jabatan
						WHEN (p.jenjab = 'Fungsional') THEN p.jabatan
						WHEN
							(p.jenjab = 'Struktural'
								AND p.id_j IS NULL)
						THEN
							jm.nama_jfu
					END AS jabatan,
					uk.nama_baru
				FROM
					kebutuhan_diklat_detail
						INNER JOIN
					pegawai p ON p.id_pegawai = kebutuhan_diklat_detail.id_pegawai
						INNER JOIN
					current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
						INNER JOIN
					unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
						LEFT JOIN
					jabatan j ON j.id_j = p.id_j
						LEFT JOIN
					jfu_pegawai ON jfu_pegawai.id_pegawai = p.id_pegawai
						LEFT JOIN
					jfu_master jm ON jm.kode_jabatan = jfu_pegawai.kode_jabatan
				WHERE
					id_keb_diklat = ".$id_keb_diklat;*/

		$sql = "SELECT b.*, CASE WHEN b.eselon = 'Z' THEN '' ELSE b.eselon END AS eselon_new FROM
				(SELECT a.id_pegawai, a.nip_baru AS nip, a.nama, a.tempat_lahir, a.tgl_lahir, a.usia, a.jenjab, a.pangkat_gol, a.jabatan,
				a.eselon, a.unit, uk.nama_baru as skpd, a.status
				FROM
				(SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
				nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.tempat_lahir, p.tgl_lahir,
				  ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia ,
				  p.jenjab, p.pangkat_gol,
				CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
				(SELECT jm.nama_jfu AS jabatan
				 FROM jfu_pegawai jp, jfu_master jm
				 WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
				ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, uk.nama_baru as unit,
				uk.id_skpd, p.flag_provinsi, peserta.status
				FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j, current_lokasi_kerja clk, unit_kerja uk,
				(SELECT kdd.id_pegawai, kdd.status FROM kebutuhan_diklat_detail kdd
				WHERE kdd.id_keb_diklat = $id_keb_diklat) peserta
				WHERE peserta.id_pegawai = p.id_pegawai AND p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND p.flag_pensiun = 0) a, unit_kerja uk
				WHERE a.id_skpd = uk.id_unit_kerja
				ORDER BY eselon ASC, pangkat_gol DESC, nama) b";
		
		return $this->db->query($sql)->result();
	}
	
	public function ubah_status($id, $status){
		$query = "update kebutuhan_diklat set idstatus_approve = '".$status."', tgl_approve = CURDATE(), idpegawai_approve = '".$this->session->userdata('user')->id_pegawai."' where id = ".$id;
		
		return $this->db->query($query);
	}
	
	public function ubah_tanggal_pelaksanaan($id, $tgl_pelaksanaan){
	
		$tgl = $this->format->date_Ymd($tgl_pelaksanaan);
		$query = "update kebutuhan_diklat set tgl_pelaksanaan = '".$tgl."' where id = ".$id;
		
		return $this->db->query($query);
	}
	
	public function get_bidang($id){
		
		$this->db->where('id',$id);
		return $this->db->get('bidang_pendidikan')->row();
	}

	public function get_list_data_diklat($row_number_start,$limit,$idjenis,$tgldari,$tglsampai,$chkWaktu,$jenjab,$keywordCari,$filter){
		$whereKlause1 = ' ';
		$whereKlause2 = ' ';
		if($idjenis!='0'){
			$whereKlause1 .= " AND d.id_jenis_diklat = ".$idjenis." ";
		}

		if($chkWaktu==1){
			if($tgldari!='0' and $tgldari!='' and $tglsampai!='0' and $tglsampai!=''){
				$whereKlause1 .= " AND d.tgl_diklat BETWEEN '".$tgldari."' AND '".$tglsampai."' ";
			}
		}

		if($jenjab!='0'){
			$whereKlause2 .= " AND p.jenjab = '".$jenjab."' ";
		}

		if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")){
			if($filter=='Diklat') {
				$whereKlause1 .= " AND d.nama_diklat LIKE '%" . $keywordCari . "%'";
			}else {
				$whereKlause2 .= " AND (p.nip_baru LIKE '%" . $keywordCari . "%'
								OR p.nama LIKE '%" . $keywordCari . "%') ";
			}
		}
		$this->db->query("SET @row_number := $row_number_start");
		$sql = "SELECT b.*, FCN_ROW_NUMBER() as no_urut FROM (SELECT a.*, p.nip_baru, p.nama,
				  p.jenjab, p.pangkat_gol, p.flag_pensiun,
				CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
				(SELECT jm.nama_jfu AS jabatan
				 FROM jfu_pegawai jp, jfu_master jm
				 WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
				ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon
				FROM (SELECT d.id_diklat, d.id_pegawai, dj.jenis_diklat, dj.id_jenis_diklat, d.tgl_diklat,
				DATE_FORMAT(d.tgl_diklat,'%d-%m-%Y') as tgl_diklat2, d.jml_jam_diklat, d.nama_diklat, d.penyelenggara_diklat
				FROM diklat d, diklat_jenis dj WHERE d.id_jenis_diklat = dj.id_jenis_diklat".$whereKlause1."
				ORDER BY d.tgl_diklat DESC, d.id_diklat) a
				LEFT JOIN pegawai p ON a.id_pegawai = p.id_pegawai /*AND p.flag_pensiun = 0*/
				LEFT JOIN jabatan j ON p.id_j = j.id_j
				WHERE a.id_diklat IS NOT NULL ".$whereKlause2.") b".
				" ORDER BY b.tgl_diklat DESC, b.id_diklat LIMIT ".$row_number_start.",".$limit;
		//echo $sql.'<br>';
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function get_count_list_data_diklat($idjenis,$tgldari,$tglsampai,$chkWaktu,$jenjab,$keywordCari,$filter){
		$whereKlause1 = ' ';
		$whereKlause2 = ' ';

		if($idjenis!='0'){
			$whereKlause1 .= " AND d.id_jenis_diklat = ".$idjenis." ";
		}

		if($chkWaktu==1){
			if($tgldari!='0' and $tgldari!='' and $tglsampai!='0' and $tglsampai!=''){
				$whereKlause1 .= " AND d.tgl_diklat BETWEEN '".$tgldari."' AND '".$tglsampai."' ";
			}
		}

		if($jenjab!='0'){
			$whereKlause2 .= " AND p.jenjab = '".$jenjab."' ";
		}

		if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")) {
			if($filter=='Diklat') {
				$whereKlause1 .= " AND d.nama_diklat LIKE '%" . $keywordCari . "%'";
			}else {
				$whereKlause2 .= " AND (p.nip_baru LIKE '%" . $keywordCari . "%'
								OR p.nama LIKE '%" . $keywordCari . "%') ";
			}
		}

		$sql = "SELECT COUNT(*) AS jumlah FROM (SELECT a.*, p.nip_baru, p.nama,p.jenjab, p.pangkat_gol
				FROM (SELECT d.id_diklat, d.id_pegawai, dj.jenis_diklat, dj.id_jenis_diklat, d.tgl_diklat, d.jml_jam_diklat, d.nama_diklat, d.penyelenggara_diklat
				FROM diklat d, diklat_jenis dj WHERE d.id_jenis_diklat = dj.id_jenis_diklat".$whereKlause1.") a
				LEFT JOIN pegawai p ON a.id_pegawai = p.id_pegawai  /*AND p.flag_pensiun = 0*/
				WHERE a.id_diklat IS NOT NULL ".$whereKlause2.") b";
		//echo $sql.'<br>';
		$query = $this->db->query($sql);
		$jml = $query->row()->jumlah;
		return $jml;
	}

	public function getReportJenis(){
		$sql = "SELECT dj.jenis_diklat, a.jumlah FROM
				(SELECT d.id_jenis_diklat, COUNT(d.id_diklat) AS jumlah
				FROM diklat d GROUP BY d.id_jenis_diklat ORDER BY jumlah DESC) a, diklat_jenis dj
				WHERE a.id_jenis_diklat = dj.id_jenis_diklat";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getReportPeriode(){
		$sql = "SELECT a.thn_periode, a.bln_periode,
				  SUM(if(id_jenis_diklat = 1, jumlah, 0)) as 'Fungsional',
				  SUM(if(id_jenis_diklat = 2, jumlah, 0)) as 'Kepemimpinan',
				  SUM(if(id_jenis_diklat = 3, jumlah, 0)) as 'Teknis',
				  SUM(if(id_jenis_diklat = 4, jumlah, 0)) as 'Prajabatan',
				  SUM(if(id_jenis_diklat = 5, jumlah, 0)) as 'Bintek',
				  SUM(if(id_jenis_diklat = 6, jumlah, 0)) as 'Workshop',
				  SUM(if(id_jenis_diklat = 7, jumlah, 0)) as 'Sosialisasi',
				  SUM(if(id_jenis_diklat = 8, jumlah, 0)) as 'Lokakarya'
				FROM
				(SELECT YEAR(d.tgl_diklat) AS thn_periode, IF(MONTH(d.tgl_diklat)<=6,'Semester 1','Semester 2') as bln_periode,
				d.id_jenis_diklat, COUNT(d.id_diklat) AS jumlah
				FROM diklat d, current_lokasi_kerja clk, unit_kerja uk
				WHERE d.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
				GROUP BY thn_periode, bln_periode, d.id_jenis_diklat) a
				GROUP BY a.thn_periode, a.bln_periode
				ORDER BY a.thn_periode DESC, a.bln_periode";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getReportPIM(){
		$sql = "SELECT h.eselon, IF(h.eselon IS NULL, 'Total Keseluruhan', h.status_diklat) AS status_diklat, h.jumlah, h.eselon_view FROM
					(SELECT CASE g.eselon WHEN @curEs THEN ''
						ELSE g.eselon END AS eselon, @curEs := g.eselon AS es,
					  CASE WHEN g.status_diklat IS NULL THEN CONCAT('Jumlah ', g.eselon) ELSE g.status_diklat END AS status_diklat,
					  SUM(g.jumlah) AS jumlah, g.eselon AS eselon_view
					  FROM
					(SELECT f.eselon, f.status_diklat, COUNT(f.id_pegawai) AS jumlah FROM
					(SELECT e.*,
					  CASE WHEN (e.eselon = 'IIA' OR e.eselon = 'IIB')
						THEN IF(e.PIM_II=0,'Belum Diklat PIM II','Sudah Diklat PIM II')
						ELSE (CASE WHEN (e.eselon = 'IIIA' OR e.eselon = 'IIIB') THEN IF(e.PIM_III=0,'Belum Diklat PIM III','Sudah Diklat PIM III')
						ELSE (CASE WHEN (e.eselon = 'IVA' OR e.eselon = 'IVB') THEN IF(e.PIM_IV=0,'Belum Diklat PIM IV','Sudah Diklat PIM IV') END) END)
					  END AS status_diklat
					FROM
					(SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
					nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
					a.jabatan, a.eselon, a.nama_baru as unit_kerja, uk.nama_baru as skpd, a.id_j, a.id_bos, a.Tahun,
					a.id_unit_kerja, a.id_skpd,
					  COUNT(CASE WHEN ((LOWER(d.nama_diklat) LIKE '%kepemimpinan%' OR
								  LOWER(d.nama_diklat) LIKE '%pim%') AND
								  LOWER(d.nama_diklat) REGEXP '[a-z][^i]ii$') OR
								  (LOWER(d.nama_diklat) LIKE '%spamen%') THEN p.id_pegawai END) AS PIM_II,
							  COUNT(CASE WHEN ((LOWER(d.nama_diklat) LIKE '%kepemimpinan%' OR
								  LOWER(d.nama_diklat) LIKE '%pim%') AND
								  LOWER(d.nama_diklat) LIKE '%iii%') OR
								  (LOWER(d.nama_diklat) LIKE '%spama%') THEN p.id_pegawai END) AS PIM_III,
							  COUNT(CASE WHEN ((LOWER(d.nama_diklat) LIKE '%kepemimpinan%' OR
								  LOWER(d.nama_diklat) LIKE '%pim%') AND
								  LOWER(d.nama_diklat) LIKE '%iv%') OR
								  (LOWER(d.nama_diklat) LIKE '%adum%') OR
								  (LOWER(d.nama_diklat) LIKE '%adumla%') OR
								  (LOWER(d.nama_diklat) LIKE '%spada%') OR
								  (LOWER(d.nama_diklat) LIKE '%spala%') THEN p.id_pegawai END) AS PIM_IV
					FROM
					(SELECT uk.id_unit_kerja, uk.nama_baru, j.jabatan, j.eselon, j.id_j, j.id_bos, j.Tahun, uk.id_skpd
					from unit_kerja uk, jabatan j
					where uk.tahun = 2017 and uk.id_unit_kerja = j.id_unit_kerja AND
					  j.jabatan != 'Walikota Bogor' AND j.jabatan != 'Wakil Walikota Bogor'
					order by uk.nama_baru ASC) a LEFT JOIN pegawai p ON a.id_j = p.id_j AND (p.flag_pensiun = 0 OR p.flag_pensiun = 2)
					INNER JOIN unit_kerja uk ON a.id_skpd = uk.id_unit_kerja
					LEFT JOIN diklat d ON p.id_pegawai = d.id_pegawai AND d.id_jenis_diklat = 2 GROUP BY p.id_pegawai
					ORDER BY a.id_unit_kerja ASC, a.eselon ASC) e
					WHERE e.nip_baru IS NOT NULL AND e.pangkat_gol IS NOT NULL) f
					GROUP BY f.eselon,  f.status_diklat) g JOIN (SELECT @curEs := '') r
					GROUP BY g.eselon,g.status_diklat WITH ROLLUP) h";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getReportJabatanKosong(){
		$sql = "SELECT uk.nama_baru, e.* FROM
				(SELECT d.id_skpd, COUNT(d.eselon) AS jml,
				SUM(IF(d.eselon = 'IIA' OR d.eselon = 'IIB',1,0)) as eselon_2,
				SUM(IF(d.eselon = 'IIIA' OR d.eselon = 'IIIB',1,0)) as eselon_3,
				SUM(IF(d.eselon = 'IVA' OR d.eselon = 'IVB',1,0)) as eselon_4,
				SUM(IF(d.eselon = 'V',1,0)) as eselon_5
				FROM
				(SELECT c.*, uk.id_skpd FROM
				(SELECT b.* FROM
				(SELECT j.eselon, j.id_unit_kerja, j.id_j, p.id_j as p_idj
				FROM jabatan j LEFT JOIN pegawai p ON j.id_j = p.id_j
				WHERE j.Tahun = DATE_FORMAT(CURRENT_DATE(),'%Y') AND (j.eselon = 'IIA' OR j.eselon = 'IIB'
				OR j.eselon = 'IIIA' OR j.eselon = 'IIIB' OR j.eselon = 'IVA' OR j.eselon = 'IVB' OR j.eselon = 'V')) b
				WHERE b.p_idj IS NULL) c INNER JOIN unit_kerja uk ON c.id_unit_kerja = uk.id_unit_kerja) d
				GROUP BY d.id_skpd) e, unit_kerja uk
				WHERE e.id_skpd = uk.id_unit_kerja;";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getListStatusDiklatPejabat($row_number_start,$limit,$status_diklat,$idskpd,$eselon,$gol,$keywordCari,$operator,$umur,$a,$b,$c,$d,$e){
		$whereKlause  = "";
		$orderbyKlause= "";

		if($status_diklat!='0'){
			$whereKlause .= " AND f.status_diklat = '".$status_diklat."' ";
		}

		if($idskpd!='0'){
			$whereKlause .= " AND f.id_skpd = ".$idskpd." ";
		}

		if($eselon!='0'){
			$whereKlause .= " AND f.eselon = '".$eselon."' ";
		}

		if($gol!='0'){
			$whereKlause .= " AND f.pangkat_gol = '".$gol."' ";
		}

		if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")) {
			$whereKlause .= " AND (f.nip_baru LIKE '%" . $keywordCari . "%'
                                OR f.nama LIKE '%" . $keywordCari . "%'
								OR f.jabatan LIKE '%" . $keywordCari . "%') ";
		}

		if($umur!=0){
			if(is_numeric($umur)){
				$whereKlause .= " AND f.umur ".$operator." ".$umur;
			}
		}

		if($a!='0'){
			$a = explode("-",$a);
			$orderbyKlause .= " ORDER BY h.".$a[0]." ".$a[1];
		}

		if($b!='0'){
			$b = explode("-",$b);
			$orderbyKlause .= ", h.".$b[0]." ".$b[1];
		}

		if($c!='0'){
			$c = explode("-",$c);
			$orderbyKlause .= ", h.".$c[0]." ".$c[1];
		}

		if($d!='0'){
			$d = explode("-",$d);
			$orderbyKlause .= ", h.".$d[0]." ".$d[1];
		}

		if($e!='0'){
			$e = explode("-",$e);
			$orderbyKlause .= ", h.".$e[0]." ".$e[1];
		}

		$this->db->query("SET @row_number := $row_number_start");
		$sql = "SELECT h.*,
				CONCAT(TIMESTAMPDIFF(YEAR, DATE_FORMAT(h.tmt_awal_eselon, '%Y/%m/%d'), CURRENT_DATE),' Thn ',
			  MOD(TIMESTAMPDIFF(MONTH, DATE_FORMAT(h.tmt_awal_eselon, '%Y/%m/%d'), CURRENT_DATE), 12), ' Bln ',
			  (DATEDIFF(NOW(),DATE_FORMAT(h.tmt_awal_eselon, '%Y/%m/%d')) -
			  DATEDIFF(DATE_ADD(h.tmt_awal_eselon, INTERVAL (
			  (TIMESTAMPDIFF(YEAR, DATE_FORMAT(h.tmt_awal_eselon, '%Y/%m/%d'), CURRENT_DATE)*12)+
			  MOD(TIMESTAMPDIFF(MONTH, DATE_FORMAT(h.tmt_awal_eselon, '%Y/%m/%d'), CURRENT_DATE), 12)
			  ) MONTH) - INTERVAL 1 DAY,
			  DATE_FORMAT(h.tmt_awal_eselon, '%Y/%m/%d')))-1, ' hari') AS lama_jabatan,
    			DATE_FORMAT(h.tmt_awal_eselon ,'%d-%m-%Y') AS tmt_awal_eselon2, FCN_ROW_NUMBER() as no_urut
				FROM
				(SELECT f.*,
				CASE WHEN f.eselon = 'IIA' THEN g.tmt_eselon_2 ELSE
				  (CASE WHEN f.eselon = 'IIB' THEN g.tmt_eselon_2 ELSE
				  (CASE WHEN f.eselon = 'IIIA' THEN g.tmt_eselon_3 ELSE
				  (CASE WHEN f.eselon = 'IIIB' THEN g.tmt_eselon_3 ELSE
				  (CASE WHEN f.eselon = 'IVA' THEN g.tmt_eselon_4 ELSE
				  (CASE WHEN f.eselon = 'IVB' THEN g.tmt_eselon_4 END) END) END)END) END) END AS tmt_awal_eselon,
				  ROUND(DATEDIFF(CURRENT_DATE, (
				  CASE WHEN f.eselon = 'IIA' THEN g.tmt_eselon_2 ELSE
				  (CASE WHEN f.eselon = 'IIB' THEN g.tmt_eselon_2 ELSE
				  (CASE WHEN f.eselon = 'IIIA' THEN g.tmt_eselon_3 ELSE
				  (CASE WHEN f.eselon = 'IIIB' THEN g.tmt_eselon_3 ELSE
				  (CASE WHEN f.eselon = 'IVA' THEN g.tmt_eselon_4 ELSE
				  (CASE WHEN f.eselon = 'IVB' THEN g.tmt_eselon_4 END) END) END)END) END) END
				  ))/365,2) AS usia_jabatan
				FROM (SELECT e.*,
				  CASE WHEN (e.eselon = 'IIA' OR e.eselon = 'IIB')
					THEN IF(e.PIM_II=0,'Belum Diklat PIM II','Sudah Diklat PIM II')
					ELSE (CASE WHEN (e.eselon = 'IIIA' OR e.eselon = 'IIIB') THEN IF(e.PIM_III=0,'Belum Diklat PIM III','Sudah Diklat PIM III')
					ELSE (CASE WHEN (e.eselon = 'IVA' OR e.eselon = 'IVB') THEN IF(e.PIM_IV=0,'Belum Diklat PIM IV','Sudah Diklat PIM IV') END) END)
				  END AS status_diklat
				FROM
				(SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
				nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.nama as nama2, p.pangkat_gol,
				a.jabatan, a.eselon, a.nama_baru as unit_kerja, uk.nama_baru as skpd, a.id_j, a.id_bos, a.Tahun,
				a.id_unit_kerja, a.id_skpd,
				  COUNT(CASE WHEN ((LOWER(d.nama_diklat) LIKE '%kepemimpinan%' OR
							  LOWER(d.nama_diklat) LIKE '%pim%') AND
							  LOWER(d.nama_diklat) REGEXP '[a-z][^i]ii$') OR
							  (LOWER(d.nama_diklat) LIKE '%spamen%') THEN p.id_pegawai END) AS PIM_II,
						  COUNT(CASE WHEN ((LOWER(d.nama_diklat) LIKE '%kepemimpinan%' OR
							  LOWER(d.nama_diklat) LIKE '%pim%') AND
							  LOWER(d.nama_diklat) LIKE '%iii%') OR
							  (LOWER(d.nama_diklat) LIKE '%spama%') THEN p.id_pegawai END) AS PIM_III,
						  COUNT(CASE WHEN ((LOWER(d.nama_diklat) LIKE '%kepemimpinan%' OR
							  LOWER(d.nama_diklat) LIKE '%pim%') AND
							  LOWER(d.nama_diklat) LIKE '%iv%') OR
							  (LOWER(d.nama_diklat) LIKE '%adum%') OR
							  (LOWER(d.nama_diklat) LIKE '%adumla%') OR
							  (LOWER(d.nama_diklat) LIKE '%spada%') OR
							  (LOWER(d.nama_diklat) LIKE '%spala%') THEN p.id_pegawai END) AS PIM_IV,
							  ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS umur
				FROM
				(SELECT uk.id_unit_kerja, uk.nama_baru, j.jabatan, j.eselon, j.id_j, j.id_bos, j.Tahun, uk.id_skpd
				from unit_kerja uk, jabatan j
				where uk.tahun = 2017 and uk.id_unit_kerja = j.id_unit_kerja AND
				  j.jabatan != 'Walikota Bogor' AND j.jabatan != 'Wakil Walikota Bogor'
				ORDER BY uk.nama_baru ASC) a LEFT JOIN pegawai p ON a.id_j = p.id_j AND (p.flag_pensiun = 0 OR p.flag_pensiun = 2)
				INNER JOIN unit_kerja uk ON a.id_skpd = uk.id_unit_kerja
				LEFT JOIN diklat d ON p.id_pegawai = d.id_pegawai AND d.id_jenis_diklat = 2 GROUP BY p.id_pegawai
				ORDER BY a.id_unit_kerja ASC, a.eselon ASC, p.pangkat_gol DESC) e
				WHERE e.nip_baru IS NOT NULL AND e.pangkat_gol IS NOT NULL) f
				LEFT JOIN (SELECT b.id_pegawai,
				MIN(CASE WHEN (b.eselonering = 'IIA' OR b.eselonering = 'IIB') THEN b.tmt_terakhir END) AS tmt_eselon_2,
				MIN(CASE WHEN (b.eselonering = 'IIIA' OR b.eselonering = 'IIIB') THEN b.tmt_terakhir END) AS tmt_eselon_3,
				MIN(CASE WHEN (b.eselonering = 'IVA' OR b.eselonering = 'IVB') THEN b.tmt_terakhir END) AS tmt_eselon_4
				FROM
				(SELECT a.id_pegawai, a.eselonering, MIN(a.tmt) AS tmt_terakhir FROM
				(SELECT s.id_sk,s.id_pegawai,s.tmt, rmk.eselonering FROM sk s, riwayat_mutasi_kerja rmk
				WHERE s.id_kategori_sk = 10 AND s.id_sk = rmk.id_sk) a
				GROUP BY a.id_pegawai, a.eselonering) b
				GROUP BY b.id_pegawai) g ON f.id_pegawai = g.id_pegawai
				WHERE f.id_pegawai IS NOT NULL ".$whereKlause.") h $orderbyKlause LIMIT ".$row_number_start.",".$limit;
		//echo $sql;
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getCountListStatusDiklatPejabat($status_diklat,$idskpd,$eselon,$gol,$keywordCari,$operator,$umur){
		$whereKlause  = "";
		if($status_diklat!='0'){
			$whereKlause .= " AND f.status_diklat = '".$status_diklat."' ";
		}

		if($idskpd!='0'){
			$whereKlause .= " AND f.id_skpd = ".$idskpd." ";
		}

		if($eselon!='0'){
			$whereKlause .= " AND f.eselon = '".$eselon."' ";
		}

		if($gol!='0'){
			$whereKlause .= " AND f.pangkat_gol = '".$gol."' ";
		}

		if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")) {
			$whereKlause .= " AND (f.nip_baru LIKE '%" . $keywordCari . "%'
                                OR f.nama LIKE '%" . $keywordCari . "%'
								OR f.jabatan LIKE '%" . $keywordCari . "%') ";
		}

		if($umur!=0){
			if(is_numeric($umur)){
				$whereKlause .= " AND f.umur ".$operator." ".$umur;
			}
		}

		$sql = "SELECT COUNT(*) AS jumlah FROM
				(SELECT e.*,
				  CASE WHEN (e.eselon = 'IIA' OR e.eselon = 'IIB')
					THEN IF(e.PIM_II=0,'Belum Diklat PIM II','Sudah Diklat PIM II')
					ELSE (CASE WHEN (e.eselon = 'IIIA' OR e.eselon = 'IIIB') THEN IF(e.PIM_III=0,'Belum Diklat PIM III','Sudah Diklat PIM III')
					ELSE (CASE WHEN (e.eselon = 'IVA' OR e.eselon = 'IVB') THEN IF(e.PIM_IV=0,'Belum Diklat PIM IV','Sudah Diklat PIM IV') END) END)
				  END AS status_diklat
				FROM
				(SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
				nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
				a.jabatan, a.eselon, a.nama_baru as unit_kerja, uk.nama_baru as skpd, a.id_j, a.id_bos, a.Tahun,
				a.id_unit_kerja, a.id_skpd,
				  COUNT(CASE WHEN ((LOWER(d.nama_diklat) LIKE '%kepemimpinan%' OR
							  LOWER(d.nama_diklat) LIKE '%pim%') AND
							  LOWER(d.nama_diklat) REGEXP '[a-z][^i]ii$') OR
							  (LOWER(d.nama_diklat) LIKE '%spamen%') THEN p.id_pegawai END) AS PIM_II,
						  COUNT(CASE WHEN ((LOWER(d.nama_diklat) LIKE '%kepemimpinan%' OR
							  LOWER(d.nama_diklat) LIKE '%pim%') AND
							  LOWER(d.nama_diklat) LIKE '%iii%') OR
							  (LOWER(d.nama_diklat) LIKE '%spama%') THEN p.id_pegawai END) AS PIM_III,
						  COUNT(CASE WHEN ((LOWER(d.nama_diklat) LIKE '%kepemimpinan%' OR
							  LOWER(d.nama_diklat) LIKE '%pim%') AND
							  LOWER(d.nama_diklat) LIKE '%iv%') OR
							  (LOWER(d.nama_diklat) LIKE '%adum%') OR
							  (LOWER(d.nama_diklat) LIKE '%adumla%') OR
							  (LOWER(d.nama_diklat) LIKE '%spada%') OR
							  (LOWER(d.nama_diklat) LIKE '%spala%') THEN p.id_pegawai END) AS PIM_IV,
							  ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS umur
				FROM
				(SELECT uk.id_unit_kerja, uk.nama_baru, j.jabatan, j.eselon, j.id_j, j.id_bos, j.Tahun, uk.id_skpd
				from unit_kerja uk, jabatan j
				where uk.tahun = 2017 and uk.id_unit_kerja = j.id_unit_kerja AND
				  j.jabatan != 'Walikota Bogor' AND j.jabatan != 'Wakil Walikota Bogor'
				order by uk.nama_baru ASC) a LEFT JOIN pegawai p ON a.id_j = p.id_j AND (p.flag_pensiun = 0 OR p.flag_pensiun = 2)
				INNER JOIN unit_kerja uk ON a.id_skpd = uk.id_unit_kerja
				LEFT JOIN diklat d ON p.id_pegawai = d.id_pegawai AND d.id_jenis_diklat = 2 GROUP BY p.id_pegawai
				ORDER BY a.id_skpd ASC, a.eselon ASC, p.pangkat_gol DESC) e
				WHERE e.nip_baru IS NOT NULL AND e.pangkat_gol IS NOT NULL) f
				WHERE f.id_pegawai IS NOT NULL ".$whereKlause;
		//echo $sql.'<br><br><br>';
		$query = $this->db->query($sql);
		$jml = $query->row()->jumlah;
		return $jml;
	}

	public function getJenisDiklat(){
		$sql = "SELECT * FROM diklat_jenis dj";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getStatusDiklat(){
		$sql = "SELECT 'Belum Diklat PIM II' AS status_diklat
				UNION
				SELECT 'Sudah Diklat PIM II' AS status_diklat
				UNION
				SELECT 'Belum Diklat PIM III' AS status_diklat
				UNION
				SELECT 'Sudah Diklat PIM III' AS status_diklat
				UNION
				SELECT 'Belum Diklat PIM IV' AS status_diklat
				UNION
				SELECT 'Sudah Diklat PIM IV' AS status_diklat;";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getSKPD(){
		$sql = "select id_unit_kerja, nama_baru from unit_kerja
				where tahun = (select max(tahun) from unit_kerja)
				and id_unit_kerja = id_skpd
				order by nama_baru ASC";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getEselon(){
		$sql = "SELECT 'IIA' AS eselon
				UNION
				SELECT 'IIB' AS eselon
				UNION
				SELECT 'IIIA' AS eselon
				UNION
				SELECT 'IIIB' AS eselon
				UNION
				SELECT 'IVA' AS eselon
				UNION
				SELECT 'IVB' AS eselon;";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getGolongan(){
		$sql = "SELECT * FROM golongan g ORDER BY id_golongan DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getBidangPendidikan(){
		$sql = "SELECT * FROM bidang_pendidikan bp ORDER BY bp.bidang ASC";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getDetailDiklatPejabat($idp){
		$sql = "SELECT dj.jenis_diklat, DATE_FORMAT(d.tgl_diklat,'%d-%m-%Y') as tgl_diklat, d.nama_diklat, d.jml_jam_diklat,
				d.penyelenggara_diklat, d.no_sttpl
				FROM diklat d, pegawai p, diklat_jenis dj
				WHERE d.id_pegawai = p.id_pegawai AND d.id_jenis_diklat = dj.id_jenis_diklat AND p.id_pegawai = $idp
				ORDER BY d.tgl_diklat DESC";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getUbahDiklat($id_diklat){
		$sql = "SELECT a.*, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
				nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.jenjab, p.pangkat_gol,
				CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
				(SELECT jm.nama_jfu AS jabatan
				 FROM jfu_pegawai jp, jfu_master jm
				 WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
				ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon,
				  uk.nama_baru, p.flag_pensiun FROM
				(SELECT d.*, DATE_FORMAT(d.tgl_diklat,'%d.%m.%Y') as tgl_diklat2, DATE_FORMAT(d.tgl_diklat,'%Y-%m-%d') as tgl_diklat3
				FROM diklat d WHERE d.id_diklat = ".$id_diklat.") a
				LEFT JOIN pegawai p ON a.id_pegawai = p.id_pegawai
				LEFT JOIN jabatan j ON p.id_j = j.id_j
				LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
				LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getInfoPegawai($nip){
		$sql = "SELECT a.nip_baru, a.nama, a.jenjab, a.pangkat_gol,
		CASE WHEN a.jenjab = 'Fungsional' THEN a.jabatan ELSE CASE WHEN a.id_j IS NULL THEN
		(SELECT jm.nama_jfu AS jabatan
		 FROM jfu_pegawai jp, jfu_master jm
		 WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = a.id_pegawai LIMIT 1)
		ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon,
		  uk.nama_baru, a.flag_pensiun, a.id_pegawai FROM
		(SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
		nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
		p.jenjab, p.pangkat_gol, p.id_j, p.flag_pensiun, p.jabatan,p.id_pegawai
		FROM pegawai p WHERE p.nip_baru = '".$nip."') a
		LEFT JOIN jabatan j ON a.id_j = j.id_j
		LEFT JOIN current_lokasi_kerja clk ON a.id_pegawai = clk.id_pegawai
		LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja;";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function tambah_data_diklat($data){
		$this->db->trans_begin();
		$tglpelaksanaan = explode(".", $data['tglpelaksanaan']);
		$tglpelaksanaan = $tglpelaksanaan[2].'-'.$tglpelaksanaan[1].'-'.$tglpelaksanaan[0];
		$sql = "insert into diklat(id_pegawai, id_jenis_diklat, tgl_diklat, jml_jam_diklat, keterangan_diklat, nama_diklat, nama_diklat2,
				penyelenggara_diklat, no_sttpl, noted, id_berkas, judul_makalah) ".
				"values (".$data['id_pegawai'].','.$data['idjenis'].",'".$tglpelaksanaan.
				"','".$data['jumlah_jam']."','','".$data['judul']."','".$data['judul']."','".$data['penyelenggara'].
				"','".$data['nosttpl']."',1,NULL,".($data['jdl_makalah']==''?'NULL':"'".$data['jdl_makalah']."'").")";

		$this->db->query($sql);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$query = false;
			$iddiklat = 0;
		}else{
			$iddiklat = $this->db->insert_id();
			$this->db->trans_commit();
			$query = true;
		}
		return array(
				'query' => $query,
				'iddiklat' => $iddiklat
		);
	}

	public function hapus_data_diklat($id_diklat){
		return $this->db->delete('diklat',array('id_diklat'=>$id_diklat));

	}

	public function cekBerkas($idberkas){
		$sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama
                         FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                         WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = " . $idberkas;

		$query = $this->db->query($sqlCekBerkas);
		return $query->result();
	}

	public function update_data_diklat($data){
		$this->db->trans_begin();
		$tglpelaksanaan = explode(".", $data['tglpelaksanaan']);
		$tglpelaksanaan = $tglpelaksanaan[2].'-'.$tglpelaksanaan[1].'-'.$tglpelaksanaan[0];
		$sql = "update diklat set id_pegawai = ".$data['id_pegawai'].", id_jenis_diklat = ".$data['idjenis'].", tgl_diklat = '".
				$tglpelaksanaan."', jml_jam_diklat = ".$data['jumlah_jam'].", keterangan_diklat = '', "."nama_diklat = '".$data['judul']."', ".
				"nama_diklat2 = '".$data['judul']."', penyelenggara_diklat = '".$data['penyelenggara']."', no_sttpl = '".
				$data['nosttpl']."', judul_makalah = ".(($data['jdl_makalah']=='' or $data['jdl_makalah']=='undefined')?'NULL':"'".$data['jdl_makalah']."'")." where id_diklat = ".$data['id_diklat'];

		$this->db->query($sql);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$query = false;
		}else{
			$this->db->trans_commit();
			$query = true;
		}
		return $query;
	}

	public function getDetailListPejabat($status, $eselon){
		$whereKlause = "";
		if($status!=='Total Keseluruhan'){
			if (strpos($status, 'Jumlah') !== false) {
				$whereKlause .= "WHERE f.eselon = '".$eselon."'";
			}else{
				$whereKlause .= "WHERE f.status_diklat = '".$status."'";
				$whereKlause .= " AND f.eselon = '".$eselon."'";
			}
		}

		$sql = "SELECT f.* FROM (SELECT e.*,
					  CASE WHEN (e.eselon = 'IIA' OR e.eselon = 'IIB')
						THEN IF(e.PIM_II=0,'Belum Diklat PIM II','Sudah Diklat PIM II')
						ELSE (CASE WHEN (e.eselon = 'IIIA' OR e.eselon = 'IIIB') THEN IF(e.PIM_III=0,'Belum Diklat PIM III','Sudah Diklat PIM III')
						ELSE (CASE WHEN (e.eselon = 'IVA' OR e.eselon = 'IVB') THEN IF(e.PIM_IV=0,'Belum Diklat PIM IV','Sudah Diklat PIM IV') END) END)
					  END AS status_diklat
					FROM
					(SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
					nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.nama as nama2, p.pangkat_gol,
					a.jabatan, a.eselon, a.nama_baru as unit_kerja, uk.nama_baru as skpd, a.id_j, a.id_bos, a.Tahun,
					a.id_unit_kerja, a.id_skpd,
					  COUNT(CASE WHEN ((LOWER(d.nama_diklat) LIKE '%kepemimpinan%' OR
								  LOWER(d.nama_diklat) LIKE '%pim%') AND
								  LOWER(d.nama_diklat) REGEXP '[a-z][^i]ii$') OR
								  (LOWER(d.nama_diklat) LIKE '%spamen%') THEN p.id_pegawai END) AS PIM_II,
							  COUNT(CASE WHEN ((LOWER(d.nama_diklat) LIKE '%kepemimpinan%' OR
								  LOWER(d.nama_diklat) LIKE '%pim%') AND
								  LOWER(d.nama_diklat) LIKE '%iii%') OR
								  (LOWER(d.nama_diklat) LIKE '%spama%') THEN p.id_pegawai END) AS PIM_III,
							  COUNT(CASE WHEN ((LOWER(d.nama_diklat) LIKE '%kepemimpinan%' OR
								  LOWER(d.nama_diklat) LIKE '%pim%') AND
								  LOWER(d.nama_diklat) LIKE '%iv%') OR
								  (LOWER(d.nama_diklat) LIKE '%adum%') OR
								  (LOWER(d.nama_diklat) LIKE '%adumla%') OR
								  (LOWER(d.nama_diklat) LIKE '%spada%') OR
								  (LOWER(d.nama_diklat) LIKE '%spala%') THEN p.id_pegawai END) AS PIM_IV,
					ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS umur
					FROM
					(SELECT uk.id_unit_kerja, uk.nama_baru, j.jabatan, j.eselon, j.id_j, j.id_bos, j.Tahun, uk.id_skpd
					from unit_kerja uk, jabatan j
					where uk.tahun = 2017 and uk.id_unit_kerja = j.id_unit_kerja AND
					  j.jabatan != 'Walikota Bogor' AND j.jabatan != 'Wakil Walikota Bogor'
					order by uk.nama_baru ASC) a LEFT JOIN pegawai p ON a.id_j = p.id_j AND (p.flag_pensiun = 0 OR p.flag_pensiun = 2)
					INNER JOIN unit_kerja uk ON a.id_skpd = uk.id_unit_kerja
					LEFT JOIN diklat d ON p.id_pegawai = d.id_pegawai AND d.id_jenis_diklat = 2 GROUP BY p.id_pegawai
					ORDER BY a.id_skpd ASC, a.eselon ASC, p.pangkat_gol DESC) e
					WHERE e.nip_baru IS NOT NULL AND e.pangkat_gol IS NOT NULL) f ".$whereKlause;

		$query = $this->db->query($sql);
		return $query->result();
	}

    public function get_list_diklat_sprint($row_number_start,$limit,$idjenis,$tgldari,$tglsampai,$chkWaktu,$jenjab,$keywordCari,$filter){
        $sql = "SELECT * from diklat_sprint ds
						inner join diklat_jenis dj on dj.id_jenis_diklat = ds.id_jenis_diklat;
						";
        return $this->db->query($sql)->result();
    }

    public function get_sprint_detail($iddiklat_sprint){
        $sql = "SELECT nama, nip_baru from diklat_sprint_detail dsd
			inner join pegawai p on p.id_pegawai = dsd.id_pegawai
			where dsd.iddiklat_sprint = ".$iddiklat_sprint;
        return $this->db->query($sql);
    }

    public function getproper(){
        $sql = "SELECT concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama,judul,deskripsi,tingkat,tahun,proper.id_proper as id,approvement_pengelola as cek FROM proper inner join proper_status on proper.id_proper=proper_status.id_proper inner join pegawai on pegawai.id_pegawai=proper.id_pegawai where jangka like 'panjang' and  approvement_mentor = 1";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function approval($idproper){
        $sql = "update proper_status set approvement_pengelola=1 where id_proper=$idproper";
        $query = $this->db->query($sql);
    }

    public function jml_pengembangan_kompetensi($id_skpd, $jenjab, $keywordCari){
        $whereKlause = ' ';

        if($id_skpd!='0'){
            $whereKlause .= " AND uk.id_skpd = ".$id_skpd." ";
        }

        if($jenjab!='0'){
            $whereKlause .= " AND p.jenjab = '".$jenjab."' ";
        }

        if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")){
            $whereKlause .= "AND (p.nama LIKE '%$keywordCari%' OR p.nip_baru LIKE '%$keywordCari%'
            OR jfu.nama_jfu LIKE '%$keywordCari%' OR jafung.nama_jafung LIKE '%$keywordCari%' OR j.jabatan LIKE '%$keywordCari%')";
        }

	    $sql = "SELECT COUNT(*) AS jumlah FROM (SELECT p.*
                FROM (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.tempat_lahir, p.tgl_lahir,
                CASE WHEN p.jenis_kelamin = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jenis_kelamin,
                p.jenjab, p.agama, p.alamat, p.kota, p.id_j, p.pangkat_gol,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kode_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kode_jabatan_jfu) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kelas_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kelas_jabatan_jfu) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.nilai_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nilai_jabatan_jfu) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan,
                CASE WHEN j.eselon IS NULL THEN 'Staf' ELSE j.eselon END AS eselon, uk.id_unit_kerja, uk.nama_baru AS unit, uk.id_skpd
                 FROM pegawai p
                LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jfu ON jfu.id_pegawai = p.id_pegawai
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jafung as kode_jabatan_jafung, jm.kelas_jabatan as kelas_jabatan_jafung,
                jm.nilai_jabatan as nilai_jabatan_jafung, jm.nama_jafung
                FROM (SELECT a.*, jp.id_jafung FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jafung_pegawai FROM jafung_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jafung_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jafung_pegawai jp ON a.id_jafung_pegawai = jp.id) b
                INNER JOIN jafung jm ON b.id_jafung = jm.id_jafung) jafung ON jafung.id_pegawai = p.id_pegawai
                INNER JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                INNER JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                WHERE p.flag_pensiun = 0 $whereKlause 
                ORDER BY j.eselon, p.pangkat_gol DESC, p.nama ASC) p
                LEFT JOIN golongan g ON p.pangkat_gol = g.golongan
                LEFT JOIN
                (
                  SELECT univ.id_pegawai, CONCAT(univ.rank,') ',univ.pendidikan) AS pendidikan, univ.level_p FROM
                  (SELECT id_pegawai, CASE id_pegawai WHEN @curIdp THEN @curRow := @curRow + 1
                    ELSE @curRow := 1 END AS rank, pnd.pendidikan, @curIdp := id_pegawai AS idp, pnd.level_p FROM
                    (SELECT pend.id_pegawai, pend.id_pendidikan,
                    CONCAT(CASE WHEN kp.nama_pendidikan IS NULL = 1 THEN '' ELSE kp.nama_pendidikan END, ' ',
                    CASE WHEN pend.jurusan_pendidikan IS NULL = 1 THEN '' ELSE pend.jurusan_pendidikan END,
                    CASE WHEN bp.bidang IS NULL = 1 THEN '' ELSE CONCAT(' Bidang ', bp.bidang) END, ' (',
                    CASE WHEN pend.tahun_lulus IS NULL = 1 THEN '' ELSE pend.tahun_lulus END, ')') AS pendidikan, kp.level_p
                    FROM pendidikan pend
                    LEFT JOIN kategori_pendidikan kp ON pend.level_p = kp.level_p
                    LEFT JOIN bidang_pendidikan bp ON pend.id_bidang = bp.id
                    LEFT JOIN pegawai p ON pend.id_pegawai = p.id_pegawai
                    WHERE p.flag_pensiun = 0
                    ORDER BY pend.id_pegawai, pend.level_p) pnd JOIN (SELECT @curRow := 0, @curIdp := 0) r
                    ORDER BY level_p) univ
                ) sekol ON p.id_pegawai = sekol.id_pegawai
                LEFT JOIN
                (
                  SELECT admin.id_pegawai, CONCAT(admin.rank,') ',admin.nama_diklat) AS nama_diklat, admin.tgl_diklat FROM
                  (SELECT
                  id_pegawai, CASE id_pegawai WHEN @curIdDik2 THEN @curRow5 := @curRow5 + 1 ELSE @curRow5 := 1 END AS rank, dik.nama_diklat,
                  @curIdDik2 := id_pegawai AS idp, dik.tgl_diklat FROM
                  (SELECT id_pegawai, nama_diklat, tgl_diklat FROM diklat /*WHERE id_jenis_diklat = 2*/) dik
                  JOIN (SELECT @curRow5 := 0, @curIdDik2 := 0) r3
                  ORDER BY dik.tgl_diklat DESC) admin
                ) diklat ON p.id_pegawai = diklat.id_pegawai
                LEFT JOIN
                (
                  SELECT keb_dik.id_pegawai, CONCAT(keb_dik.rank,') ',keb_dik.nama_diklat) AS nama_diklat, keb_dik.jenis_diklat, keb_dik.bidang FROM
                  (SELECT
                  id_pegawai, CASE id_pegawai WHEN @curIdKebDik THEN @curRow6 := @curRow6 + 1 ELSE @curRow6 := 1 END AS rank, keb.nama_diklat,
                  @curIdKebDik := id_pegawai AS idp, keb.jenis_diklat, keb.bidang FROM
                  (SELECT kd.nama_diklat, dj.jenis_diklat, bp.bidang, kdd.id_pegawai
                  FROM kebutuhan_diklat kd INNER JOIN kebutuhan_diklat_detail kdd ON kd.id = kdd.id_keb_diklat
                  INNER JOIN diklat_jenis dj ON kd.id_jenis_diklat = dj.id_jenis_diklat
                  INNER JOIN bidang_pendidikan bp ON kd.id_bidang = bp.id) keb
                  JOIN (SELECT @curRow6 := 0, @curIdKebDik := 0) r4
                  ORDER BY keb.nama_diklat ASC) keb_dik
                ) kebutuhan_diklat ON p.id_pegawai = kebutuhan_diklat.id_pegawai
                GROUP BY p.id_pegawai, p.nip_baru, p.nama, g.golongan, p.jabatan, p.eselon) s";
        $query = $this->db->query($sql);
        $jml = $query->row()->jumlah;
        return $jml;
    }

	public function pengembangan_kompetensi($row_number_start, $limit, $id_skpd, $jenjab, $keywordCari){
        $whereKlause = ' ';

        if($id_skpd!='0'){
            $whereKlause .= " AND uk.id_skpd = ".$id_skpd." ";
        }

        if($jenjab!='0'){
            $whereKlause .= " AND p.jenjab = '".$jenjab."' ";
        }

        if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")){
            $whereKlause .= "AND (p.nama LIKE '%$keywordCari%' OR p.nip_baru LIKE '%$keywordCari%'
            OR jfu.nama_jfu LIKE '%$keywordCari%' OR jafung.nama_jafung LIKE '%$keywordCari%' OR j.jabatan LIKE '%$keywordCari%')";
        }

	    $sql = "SELECT p.*,
                GROUP_CONCAT(DISTINCT sekol.pendidikan ORDER BY sekol.level_p ASC SEPARATOR '<br>') as pendidikan /* \r\n */,
                GROUP_CONCAT(DISTINCT diklat.nama_diklat ORDER BY diklat.tgl_diklat DESC SEPARATOR '<br>') as diklat,
                GROUP_CONCAT(DISTINCT kebutuhan_diklat.nama_diklat ORDER BY kebutuhan_diklat.nama_diklat ASC SEPARATOR '<br>') as kebutuhan
                FROM (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.tempat_lahir, p.tgl_lahir,
                CASE WHEN p.jenis_kelamin = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jenis_kelamin,
                p.jenjab, p.agama, p.alamat, p.kota, p.id_j, p.pangkat_gol,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kode_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kode_jabatan_jfu) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kelas_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kelas_jabatan_jfu) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.nilai_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nilai_jabatan_jfu) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan,
                CASE WHEN j.eselon IS NULL THEN 'Staf' ELSE j.eselon END AS eselon2, uk.id_unit_kerja, uk.nama_baru AS unit, uk.id_skpd
                 FROM pegawai p
                LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jfu ON jfu.id_pegawai = p.id_pegawai
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jafung as kode_jabatan_jafung, jm.kelas_jabatan as kelas_jabatan_jafung,
                jm.nilai_jabatan as nilai_jabatan_jafung, jm.nama_jafung
                FROM (SELECT a.*, jp.id_jafung FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jafung_pegawai FROM jafung_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jafung_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jafung_pegawai jp ON a.id_jafung_pegawai = jp.id) b
                INNER JOIN jafung jm ON b.id_jafung = jm.id_jafung) jafung ON jafung.id_pegawai = p.id_pegawai
                INNER JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                INNER JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                WHERE p.flag_pensiun = 0 $whereKlause
                ORDER BY eselon2 ASC, p.pangkat_gol DESC, p.nama ASC LIMIT $row_number_start, $limit) p
                LEFT JOIN
                (
                  SELECT univ.id_pegawai, CONCAT('<b>',univ.rank,')</b> ',univ.pendidikan) AS pendidikan, univ.level_p FROM
                  (SELECT id_pegawai, CASE id_pegawai WHEN @curIdp THEN @curRow := @curRow + 1
                    ELSE @curRow := 1 END AS rank, pnd.pendidikan, @curIdp := id_pegawai AS idp, pnd.level_p FROM
                    (SELECT pend.id_pegawai, pend.id_pendidikan,
                    CONCAT(CASE WHEN kp.nama_pendidikan IS NULL = 1 THEN '' ELSE kp.nama_pendidikan END, ' ',
                    CASE WHEN pend.jurusan_pendidikan IS NULL = 1 THEN '' ELSE pend.jurusan_pendidikan END,
                    CASE WHEN bp.bidang IS NULL = 1 THEN '' ELSE CONCAT(' Bidang ', bp.bidang) END, ' (',
                    CASE WHEN pend.tahun_lulus IS NULL = 1 THEN '' ELSE pend.tahun_lulus END, ')') AS pendidikan, kp.level_p
                    FROM pendidikan pend
                    LEFT JOIN kategori_pendidikan kp ON pend.level_p = kp.level_p
                    LEFT JOIN bidang_pendidikan bp ON pend.id_bidang = bp.id
                    LEFT JOIN pegawai p ON pend.id_pegawai = p.id_pegawai
                    WHERE p.flag_pensiun = 0
                    ORDER BY pend.id_pegawai, pend.level_p) pnd JOIN (SELECT @curRow := 0, @curIdp := 0) r
                    ORDER BY id_pegawai, level_p) univ
                ) sekol ON p.id_pegawai = sekol.id_pegawai
                LEFT JOIN
                (
                  SELECT admin.id_pegawai, CONCAT('<b>',admin.rank,')</b> ',admin.nama_diklat) AS nama_diklat, admin.tgl_diklat FROM
                  (SELECT
                  id_pegawai, CASE id_pegawai WHEN @curIdDik2 THEN @curRow5 := @curRow5 + 1 ELSE @curRow5 := 1 END AS rank, dik.nama_diklat,
                  @curIdDik2 := id_pegawai AS idp, dik.tgl_diklat FROM
                  (SELECT id_pegawai, nama_diklat, tgl_diklat FROM diklat /*WHERE id_jenis_diklat = 2*/) dik
                  JOIN (SELECT @curRow5 := 0, @curIdDik2 := 0) r3
                  ORDER BY dik.id_pegawai, dik.tgl_diklat DESC) admin
                ) diklat ON p.id_pegawai = diklat.id_pegawai
                LEFT JOIN
                (
                  SELECT keb_dik.id_pegawai, CONCAT('<b>',keb_dik.rank,')</b> ',keb_dik.nama_diklat) AS nama_diklat, keb_dik.jenis_diklat, keb_dik.bidang FROM
                  (SELECT
                  id_pegawai, CASE id_pegawai WHEN @curIdKebDik THEN @curRow6 := @curRow6 + 1 ELSE @curRow6 := 1 END AS rank, keb.nama_diklat,
                  @curIdKebDik := id_pegawai AS idp, keb.jenis_diklat, keb.bidang FROM
                  (SELECT kd.nama_diklat, dj.jenis_diklat, bp.bidang, kdd.id_pegawai
                  FROM kebutuhan_diklat kd INNER JOIN kebutuhan_diklat_detail kdd ON kd.id = kdd.id_keb_diklat
                  INNER JOIN diklat_jenis dj ON kd.id_jenis_diklat = dj.id_jenis_diklat
                  INNER JOIN bidang_pendidikan bp ON kd.id_bidang = bp.id) keb
                  JOIN (SELECT @curRow6 := 0, @curIdKebDik := 0) r4
                  ORDER BY id_pegawai, keb.nama_diklat ASC) keb_dik
                ) kebutuhan_diklat ON p.id_pegawai = kebutuhan_diklat.id_pegawai
                GROUP BY p.id_pegawai, p.nip_baru, p.nama, p.pangkat_gol, p.jabatan, p.eselon2
                ORDER BY p.eselon2, p.pangkat_gol DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }
	
}
