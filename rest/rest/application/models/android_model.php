<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Android_model extends CI_Model{
	public function __Construct(){
		parent::__Construct();
	}

	public function getRekapBidangPendidikan(){
		$sql = "select count(*) as value, bidang as attribute
				from pendidikan_terakhir inner join pegawai on pegawai.id_pegawai = pendidikan_terakhir.id_pegawai 
				inner join pendidikan on pendidikan.id_pendidikan = pendidikan_terakhir.id_pendidikan 
				inner join bidang_pendidikan on bidang_pendidikan.id=pendidikan.id_bidang 
				where flag_pensiun=0 and pendidikan_terakhir.level_p<7 group by bidang";
		return $this->db->query($sql);
	}
	
	public function getRekapFungsional(){
		$sql = "SELECT count(*) as value, jabatan as attribute 
				FROM pegawai WHERE flag_pensiun=0 and jenjab like 'fungsional'
				GROUP BY jabatan";
		return $this->db->query($sql);
	}
	
	public function getRekapGolongan(){
		$sql = "SELECT count(*) as value, pangkat_gol as attribute
				FROM pegawai 
				WHERE flag_pensiun=0
				GROUP BY pangkat_gol ORDER BY pangkat_gol ASC";
		return $this->db->query($sql);
	}
	
	public function getRekapJenjab(){
		$sql = "SELECT count(*) as value, jenjab as attribute
				FROM pegawai where flag_pensiun=0 
				GROUP BY jenjab";
		return $this->db->query($sql);
	}
	
	public function getRekapJenkel(){
		$sql = "SELECT a.value as value, CASE WHEN a.attribute = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS attribute FROM
		        (SELECT count(*)  as value, jenis_kelamin as attribute
				FROM pegawai where flag_pensiun=0
				GROUP BY jenis_kelamin) a";
		return $this->db->query($sql);
	}

	public function getRekapJenkelPerOPD($opd){
		$sql = "SELECT p.jenis_kelamin as attribute, uk.id_unit_kerja, uk.nama_baru, count(*) as value
		FROM pegawai p, current_lokasi_kerja clk, unit_kerja uk
		WHERE p.flag_pensiun = 0 AND p.id_pegawai = clk.id_pegawai AND
		clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = $opd
		GROUP BY p.jenis_kelamin, uk.id_unit_kerja, uk.nama_baru";
		return $this->db->query($sql);
	}
	
	public function getRekapLulusanPt(){
		$sql = "select count(*) as value, institusi as attribute
				from pendidikan_terakhir
				inner join pegawai on pegawai.id_pegawai = pendidikan_terakhir.id_pegawai
				inner join pendidikan on pendidikan.id_pendidikan = pendidikan_terakhir.id_pendidikan
				inner join institusi_pendidikan on institusi_pendidikan.id=pendidikan.id_institusi
				where flag_pensiun=0 and pendidikan_terakhir.level_p<7 group by institusi";
		return $this->db->query($sql);
	}

	public function getRekapLulusanPtPerOPD($opd){
		$sql = "SELECT IF(ip.id IS NULL, '0', ip.id) AS id_institusi,
				IF(ip.institusi IS NULL, 'Bidang belum diketahui', ip.institusi) AS institusi,
				c.id_unit_kerja, c.nama_baru, c.jumlah FROM
				(SELECT p.id_institusi, b.id_unit_kerja, b.nama_baru,
				COUNT(p.id_pendidikan) AS jumlah FROM pendidikan p INNER JOIN
				(SELECT p.id_pegawai, a.id_unit_kerja, a.nama_baru,
				MAX(p.id_pendidikan) AS id_pendidikan FROM pendidikan p,
				(SELECT p.id_pegawai, uk.id_unit_kerja, uk.nama_baru, MIN(pend.level_p) AS level_p
				FROM pegawai p INNER JOIN pendidikan pend ON p.id_pegawai = pend.id_pegawai,
				current_lokasi_kerja clk, unit_kerja uk
				WHERE p.flag_pensiun = 0 AND pend.level_p < 7 AND
				p.id_pegawai = clk.id_pegawai AND
				clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = $opd
				GROUP BY p.id_pegawai, uk.id_unit_kerja, uk.nama_baru) a
				WHERE p.id_pegawai = a.id_pegawai AND p.level_p = a.level_p
				GROUP BY p.id_pegawai, a.id_unit_kerja, a.nama_baru) b
				ON p.id_pendidikan = b.id_pendidikan
				GROUP BY p.id_institusi, b.id_unit_kerja, b.nama_baru) c LEFT JOIN institusi_pendidikan ip
				ON c.id_institusi = ip.id ORDER BY ip.institusi, c.nama_baru";
		return $this->db->query($sql);
	}
	
	public function getRekapPendidikan(){
		$sql = "SELECT a.value, kp.nama_pendidikan as attribute FROM
                (SELECT count(*) as value, level_p as attribute
                FROM pendidikan_terakhir inner join pegawai on pegawai.id_pegawai=pendidikan_terakhir.id_pegawai
                where flag_pensiun=0
                GROUP BY level_p) a, kategori_pendidikan kp
                WHERE a.attribute = kp.level_p";
		return $this->db->query($sql);
	}
	
	public function getRekapStrukturalEselon(){
		$sql = "SELECT count(*) as value, jabatan.eselon as attribute from pegawai inner join jabatan on jabatan.id_j = pegawai.id_j 
				WHERE flag_pensiun=0 and jenjab like 'struktural' and pegawai.id_j>0
				GROUP BY eselon";
		return $this->db->query($sql);
	}
	
	public function getRekapUmur(){
		$sql = "SELECT count(*) as value, floor(datediff(curdate(),tgl_lahir)/365) as attribute
				FROM pegawai 
				WHERE flag_pensiun=0
				GROUP BY floor(datediff(curdate(),tgl_lahir)/365)";
		return $this->db->query($sql);
	}
	
	public function get_attendance($id_pegawai){
		$sql = "SELECT * FROM `oasys_attendance_log` 
				WHERE month(date_time) = month(now()) 
				AND year(date_time) = year(now())
				AND id_pegawai=$id_pegawai
				ORDER BY date_time DESC";
		return $this->db->query($sql);
	}
	
	public function add_attendance($id_pegawai, $date_time, $status, $latitude, $longitude){
		$sql = "INSERT INTO oasys_attendance_log (id_pegawai, date_time, status, latitude, longitude) 
				VALUES($id_pegawai, NOW(), '$status', '$latitude', '$longitude')";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	
	public function get_today_attendance($id_pegawai){
		$sql = "SELECT * 
				FROM  `oasys_attendance_log` 
				WHERE DATE_FORMAT( date_time,  '%Y-%m-%d' ) = CURDATE( ) 
				AND id_pegawai = $id_pegawai";
		$rs = $this->db->query($sql);
		return $rs->result();
	}
	
	public function get_comments($parent_id){
		$sql = "SELECT post.id_post, post.msg, post.id_pegawai, 
			IF(LENGTH(pegawai.gelar_belakang) > 1,  concat(pegawai.gelar_depan,' ',pegawai.nama,concat(', ',pegawai.gelar_belakang)), concat(pegawai.gelar_depan,' ',pegawai.nama) ) as nama, 
				pegawai.gelar_belakang, 
				UNIX_TIMESTAMP(post.kapan) as kapan, 
				post.parent_id 
				FROM post, pegawai 
				WHERE post.id_pegawai = pegawai.id_pegawai 
				AND post.parent_id = $parent_id
				ORDER BY post.id_post ASC";
		return $this->db->query($sql);
	}
	
	public function get_jumlah_komentar($parent_id){
		$sql = "SELECT count(parent_id) as jumlah_komentar 
				FROM post WHERE parent_id = $parent_id";
		return $this->db->query($sql);
	}
	
		
	public function is_exist_imei($imei, $nip){
		$sql = "select imei from pegawai where password = '$imei' and nip_baru = '$nip'";
		return $this->db->query($sql);
	}
	
	public function do_login($nip, $password){
		$sql = "select * from pegawai where nip_baru = '$nip' and password = '$password'";
		return $this->db->query($sql);
	}
	
	public function set_imei($imei, $nip){
		$sql = "update pegawai set imei = '$imei' where nip_baru = '$nip'";
		return $this->db->query($sql);
	}
	
	public function get_pegawai($nip, $imei){
	
		$sql = "select pegawai.id_pegawai, 
						nama,
						gelar_depan,
						gelar_belakang,
						IF(jenis_kelamin = 1, 'Laki-laki', 'Perempuan') as jenis_kelamin,
						gol_darah,
						agama,
						tempat_lahir,
						tgl_lahir,
						pegawai.alamat,
						nip_baru,
						no_karpeg,
						masa_kerja_pasif,
						vpt.golongan as pangkat_gol,
						jenjab,
						jabatan,
						eselonering,
						tgl_pensiun_dini as tgl_pensiun_dini_old,
						tgl_pensiun_dini,
						imei,
						uk.nama_baru,
						password, 
						uk.nama_baru as unit_kerja,
						'100' as 'request_status'
						
				from pegawai
				left join view_pangkat_terakhir vpt on vpt.id_pegawai = pegawai.id_pegawai
				left join current_lokasi_kerja clk on clk.id_pegawai = pegawai.id_pegawai
				left join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
						
				where nip_baru = '$nip' and imei = '$imei'";
						

		return $this->db->query($sql);
	}
	
	public function postkehadiran(){
		
	}
	
	public function get_location_uk($id_pegawai){
		/*$sql = "SELECT
				unit_kerja.id_unit_kerja,
				in_lat as latitude,
				in_long as longitude,
				out_lat as lat_outer,
				out_long as long_outer,
				unit_kerja.nama_baru as unit_kerja
				FROM unit_kerja
				inner join current_lokasi_kerja clk on clk.id_unit_kerja = unit_kerja.id_unit_kerja
				inner join pegawai on pegawai.id_pegawai = clk.id_pegawai
				WHERE tahun = (SELECT MAX(tahun) FROM unit_kerja)
				and pegawai.id_pegawai = ".$id_pegawai."				
				";*/
		$sql = "SELECT c.id_unit_kerja, uk.in_lat as latitude, uk.in_long as longitude, uk.out_lat as lat_outer, uk.out_long as long_outer,
				  uk.nama_baru as unit_kerja FROM
				(SELECT b.id_pegawai, CASE WHEN (b.id_unit_kerja_lain IS NOT NULL AND b.id_unit_kerja_lain <> '') THEN b.id_unit_kerja_lain
				  ELSE b.id_unit_kerja END AS id_unit_kerja FROM
				(SELECT a.id_pegawai, clk.id_unit_kerja, clkl.id_unit_kerja_lain FROM
				(SELECT ".$id_pegawai." AS id_pegawai) a
				LEFT JOIN current_lokasi_kerja clk ON a.id_pegawai = clk.id_pegawai
				LEFT JOIN current_lokasi_kerja_lain clkl ON a.id_pegawai = clkl.id_pegawai) b) c, unit_kerja uk
				WHERE c.id_unit_kerja = uk.id_unit_kerja AND tahun = (SELECT MAX(tahun) FROM unit_kerja)";
		
		return $this->db->query($sql);
	}
	
	public function get_timeline(){
		$sql = "SELECT post.id_post, post.msg, post.id_pegawai, 
				CONCAT(CASE WHEN gelar_depan = '' THEN '' ELSE CONCAT(gelar_depan, ' ') END,
                nama, CASE WHEN gelar_belakang = '' THEN '' ELSE '' END) AS nama, 
				pegawai.gelar_belakang, post.kapan, post.parent_id, '999' as 'jml_komentar', '100' as request_status
				FROM post, pegawai 
				WHERE post.id_pegawai = pegawai.id_pegawai AND 
				(post.parent_id IS NULL OR post.parent_id = 0)
				ORDER BY post.id_post DESC LIMIT 0,10";
		return $this->db->query($sql);
	}
	
	public function add_comments($msg, $id_pegawai, $parent_id){
		if($parent_id == '')
			$parent_id = 'null';

		$sql = "INSERT INTO post(msg, id_pegawai, parent_id) 
				VALUES ('$msg', $id_pegawai, $parent_id)";
		
		return $this->db->query($sql);
	}

	public function login_archive($nip, $password){
		$sql = "SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
				nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
				uk.nama_baru as unit_kerja FROM pegawai p, current_lokasi_kerja clk, unit_kerja uk
				WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
				AND p.nip_baru = '".$nip."' AND p.password = '".$password."'";
		return $this->db->query($sql);
	}

	public function get_infopegawai_bynip($nip){
		$sql = "SELECT a.id_pegawai, a.nip_baru, a.nama, a.tempat_lahir, a.tgl_lahir, a.usia, a.jenjab, a.pangkat_gol, a.jabatan,
				CASE WHEN a.eselon = 'Z' THEN '' ELSE a.eselon END AS eselon, a.unit, a.id_skpd, uk.nama_baru as skpd/*, a.Alamat, a.alamat_rumah*/
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
				uk.id_skpd, uk.Alamat, p.alamat AS alamat_rumah
				FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j, current_lokasi_kerja clk, unit_kerja uk
				WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
				AND p.flag_pensiun = 0  AND p.nip_baru = '".$nip."'
				ORDER BY eselon ASC, p.pangkat_gol DESC, p.nama) a, unit_kerja uk
				WHERE a.id_skpd = uk.id_unit_kerja;";
		return $this->db->query($sql);
	}

	public function get_infopegawai_bynip_2($nip){
	    $sql = "SELECT a.id_pegawai, a.nip_baru, a.nama, a.alamat, a.ponsel, a.email,
                CASE WHEN a.id_unit_kerja = a.id_skpd THEN a.unit ELSE CONCAT (a.unit, ' pada ', uk2.nama_baru) END AS unit_kerja
                FROM
                (SELECT p.id_pegawai, p.nip_baru, p.nama, CONCAT(p.alamat,' ', p.kota) as alamat, ponsel, email,
                uk.id_unit_kerja, uk.nama_baru as unit, uk.id_skpd
                FROM pegawai p
                INNER JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                INNER JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                WHERE p.nip_baru = '".$nip."') a, unit_kerja uk2
                WHERE a.id_skpd = uk2.id_unit_kerja";
        return $this->db->query($sql);
    }

    public function get_infopegawai_by_email($email){
        $sql = "SELECT a.id_pegawai, a.nip_baru, a.nama, a.alamat, a.ponsel, a.email,
                CASE WHEN a.id_unit_kerja = a.id_skpd THEN a.unit ELSE CONCAT (a.unit, ' pada ', uk2.nama_baru) END AS unit_kerja
                FROM
                (SELECT p.id_pegawai, p.nip_baru, p.nama, CONCAT(p.alamat,' ', p.kota) as alamat, ponsel, email,
                uk.id_unit_kerja, uk.nama_baru as unit, uk.id_skpd
                FROM pegawai p
                INNER JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                INNER JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                WHERE p.email = '".$email."') a, unit_kerja uk2
                WHERE a.id_skpd = uk2.id_unit_kerja";
        return $this->db->query($sql);
    }

    /*public function get_absensi_riwayat_today($id_pegawai){

		$sql = "select * from oasys_attendance_log where id_pegawai = $id_pegawai and DATE(NOW()) like DATE(date_time)";

		return $this->db->query($sql);
	}*/

    /*public function insert_absensi($id_pegawai, $longitude, $latitude){

        $sql = "INSERT INTO oasys_attendance_log (id_pegawai,date_time,status,id,longitude,latitude)
            (SELECT $id_pegawai, NOW(), IF(TIME(NOW()) > '07:45:00','LATE','PRESENT'), NULL, $longitude, $latitude)";
        return $this->db->query($sql);
    }*/

    /*public function add_message($msg, $id_pegawai){
		$sql = "INSERT INTO `post`(`id_post`, `msg`, `id_pegawai`)
				VALUES (null, '$msg', '$id_pegawai')";
		return $this->db->query($sql);
	}*/

    /*public function view_unit_kerja(){
        $sql = "SELECT id_unit_kerja, nama_baru
                FROM unit_kerja
                WHERE tahun = (SELECT MAX(tahun) FROM unit_kerja) and id_unit_kerja = id_skpd order by nama_baru ASC";
        return $this->db->query($sql);
    }*/
	
}
	
