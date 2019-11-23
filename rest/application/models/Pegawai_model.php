<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai_model extends CI_Model{


	//var $DBSIMPEG;
	//$DBAPI;

	public $nip;
	public $id_pegawai;

	public function __Construct(){

		parent::__Construct();

	}

    public function get_key_apps($api_key){
        $sql = "SELECT CONCAT(ra.rsa_modulo, ra.rsa_private_key, ra.rsa_public_key) as key_apps
                FROM rest_apps ra
                WHERE ra.api_key = '$api_key'";
        $key_apps = $this->db->query($sql);
        $rowcount = $key_apps->num_rows();
        if($rowcount>0){
            foreach ($key_apps->result() as $data) {
                $keyApps = $data->key_apps;
            }
        }else{
            $keyApps = '';
        }
        return $keyApps;
    }

    public function get_stat_usia(){
        $query = "select t.range as 'usia', count(*) as 'jumlah'
					from (
					  select case
						when FLOOR(DATEDIFF(CURDATE(), tgl_lahir)/365)  between 0 and 25 then ' 0 - 25'
						when FLOOR(DATEDIFF(CURDATE(), tgl_lahir)/365)  between 26 and 30 then ' 26 - 30'
						when FLOOR(DATEDIFF(CURDATE(), tgl_lahir)/365)  between 31 and 35 then ' 31 - 35'
						when FLOOR(DATEDIFF(CURDATE(), tgl_lahir)/365)  between 36 and 40 then ' 36 - 40'
						when FLOOR(DATEDIFF(CURDATE(), tgl_lahir)/365)  between 41 and 45 then ' 41 - 45'
						when FLOOR(DATEDIFF(CURDATE(), tgl_lahir)/365)  between 46 and 50 then ' 46 - 50'
						when FLOOR(DATEDIFF(CURDATE(), tgl_lahir)/365)  between 51 and 55 then ' 51 - 55'
						when FLOOR(DATEDIFF(CURDATE(), tgl_lahir)/365)  between 56 and 60 then ' 56 - 60'
						else 'Data Error/out of range'
						 end as `range`
					  from pegawai
					  where pegawai.flag_pensiun = 0
					  ) t
					group by t.range
					order by t.range	";
        return $this->db->query($query);
    }

    public function get_stat_usia_per_opd(){

        $query = "CALL 	PRC_REPORT_BY_AGE() ";
        return $this->db->query($query);
    }

    public function get_stat_jk(){

        $query = "SELECT a.value as jumlah, CASE WHEN a.attribute = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS id_jk FROM
		        (SELECT count(*)  as value, jenis_kelamin as attribute
				FROM pegawai where flag_pensiun=0
				GROUP BY jenis_kelamin) a";
        return $this->db->query($query);
    }

    public function getRekapBySmartphone(){
        $sql = "SELECT b.os, SUM(b.jumlah) AS jumlah FROM
				(SELECT IF((a.os IS NULL OR a.os = '-' OR a.os = ''), 'Tidak Diketahui',
				IF(a.os = 'BB', 'Blackberry', a.os)) AS os, jumlah FROM
				(SELECT p.os, COUNT(p.id_pegawai) AS jumlah
				FROM pegawai p WHERE p.flag_pensiun = 0
				GROUP BY p.os) a) b GROUP BY b.os";
        return $this->db->query($sql);
    }

    public function getRekapBySmartphonePerOPD($opd){
        $sql = "SELECT b.os, b.id_unit_kerja, b.nama_baru, b.jumlah FROM (
				SELECT IF((a.os IS NULL OR a.os = '-' OR a.os = ''), 'Tidak Diketahui',
				IF(a.os = 'BB', 'Blackberry', a.os)) AS os, a.id_unit_kerja, a.nama_baru, a.jumlah FROM
				(SELECT p.os, uk.id_unit_kerja, uk.nama_baru, COUNT(p.id_pegawai) AS jumlah
				FROM pegawai p, current_lokasi_kerja clk, unit_kerja uk
				WHERE p.flag_pensiun = 0 AND p.id_pegawai = clk.id_pegawai AND
				clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = $opd
				GROUP BY p.os, uk.id_unit_kerja, uk.nama_baru) a) b
				ORDER BY b.nama_baru, b.os";
        return $this->db->query($sql);
    }

    public function getRekapDiklatPIM(){
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
        return $this->db->query($sql);
    }

    public function getRekapDiklatPIMPerOPD($opd){
        $sql = "SELECT f.id_unit_kerja, f.unit_kerja, f.status_diklat, COUNT(f.id_pegawai) AS jumlah FROM
				(SELECT e.*,
				CASE WHEN (e.eselon = 'IIA' OR e.eselon = 'IIB')
				THEN IF(e.PIM_II=0,'Belum Diklat PIM II','Sudah Diklat PIM II')
				ELSE (CASE WHEN (e.eselon = 'IIIA' OR e.eselon = 'IIIB') THEN IF(e.PIM_III=0,'Belum Diklat PIM III','Sudah Diklat PIM III')
				ELSE (CASE WHEN (e.eselon = 'IVA' OR e.eselon = 'IVB') THEN IF(e.PIM_IV=0,'Belum Diklat PIM IV','Sudah Diklat PIM IV') END) END)
				END AS status_diklat FROM
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
				FROM unit_kerja uk, jabatan j
				WHERE uk.tahun = 2017 and uk.id_unit_kerja = j.id_unit_kerja AND
				j.jabatan != 'Walikota Bogor' AND j.jabatan != 'Wakil Walikota Bogor' AND uk.id_skpd = $opd
				ORDER BY uk.nama_baru ASC) a LEFT JOIN pegawai p ON a.id_j = p.id_j AND (p.flag_pensiun = 0 OR p.flag_pensiun = 2)
				INNER JOIN unit_kerja uk ON a.id_skpd = uk.id_unit_kerja AND uk.id_unit_kerja = $opd
				LEFT JOIN diklat d ON p.id_pegawai = d.id_pegawai AND d.id_jenis_diklat = 2
				GROUP BY p.id_pegawai
				ORDER BY a.id_unit_kerja ASC, a.eselon ASC) e
				WHERE e.nip_baru IS NOT NULL AND e.pangkat_gol IS NOT NULL) f
				GROUP BY f.id_unit_kerja, f.unit_kerja, f.status_diklat";
        return $this->db->query($sql);
    }

    public function getRekapNonPNS(){
        $sql = "select tkk2.id_unit_kerja, uk.nama_baru, count(*) as jumlah
                from tkk2
                  inner join unit_kerja uk on uk.id_unit_kerja = tkk2.id_unit_kerja
                group by tkk2.id_unit_kerja
                order by count(*) desc";
        return $this->db->query($sql);
    }

    public function getRekapNonPNSByStatus($status){
        $sql = "select c.id_skpd, uk.nama_baru as opd, c.jumlah from
                  (select b.id_skpd, sum(b.jumlah) as jumlah from
                    (select a.*, uk.id_skpd from
                      (select id_unit_kerja, count(id_tkk) as jumlah
                       from tkk where status = $status
                       group by id_unit_kerja) a inner join unit_kerja uk on a.id_unit_kerja = uk.id_unit_kerja) b
                  group by b.id_skpd) c inner join unit_kerja uk on c.id_skpd = uk.id_unit_kerja
                order by c.jumlah desc";
        return $this->db->query($sql);
    }

    public function getRekapAbsensi_UntukSemuaOPD($bln, $thn){
        $sql = "CALL PRCD_ABSENSI_CETAK_ALL_OPD($bln,$thn);";
        return $this->db->query($sql);
    }

    public function getRekapAbsensi_UntukPerOPD($bln, $thn, $idskpd){
        $sql = "CALL PRCD_ABSENSI_HARIAN_PROFIL1($bln,$thn,$idskpd);";
        return $this->db->query($sql);
    }

    public function getListDetailPegawai_Absensi_ByStatus($bln, $thn, $idskpd, $status){
        if($status=='All'){
            $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
                    CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                    (SELECT jm.nama_jfu AS jabatan
                     FROM jfu_pegawai jp, jfu_master jm
                     WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                    ELSE j.jabatan END END AS jabatan, a.jml_hari, a.hist_absensi,
                    a.C, a.DL, a.DI, a.I, a.S, a.TK, a.unit
                    FROM
                    (SELECT ra.id_pegawai, uk.nama_baru as unit, COUNT(ra.id) AS jml_hari,
                    GROUP_CONCAT(DATE_FORMAT(ra.tgl,  '%d/%m/%Y'),' (',ra.status,')' ORDER BY ra.tgl ASC SEPARATOR ', ') AS hist_absensi,
                    SUM(IF(ra.status = 'C', 1, 0)) AS 'C',
                    SUM(IF(ra.status = 'DL', 1, 0)) AS 'DL',
                    SUM(IF(ra.status = 'DI', 1, 0)) AS 'DI',
                    SUM(IF(ra.status = 'I', 1, 0)) AS 'I',
                    SUM(IF(ra.status = 'S', 1, 0)) AS 'S',
                    SUM(IF(ra.status = 'TK', 1, 0)) AS 'TK'
                    FROM report_absensi ra, unit_kerja uk, ref_status_absensi rsa
                    WHERE MONTH(ra.tgl) = ".$bln." AND YEAR(ra.tgl) = ".$thn." AND uk.id_skpd = ".$idskpd." AND ra.status <> 'TA' AND
                    ra.id_unit_kerja = uk.id_unit_kerja AND ra.status = rsa.idstatus
                    GROUP BY ra.id_pegawai) a, pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                    WHERE p.id_pegawai = a.id_pegawai AND p.flag_pensiun = 0 AND p.flag_mpp IS NULL ORDER BY a.jml_hari DESC, p.pangkat_gol DESC;";
        }else{
            $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
                    CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                    (SELECT jm.nama_jfu AS jabatan
                     FROM jfu_pegawai jp, jfu_master jm
                     WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                    ELSE j.jabatan END END AS jabatan, a.jml_hari, a.hist_absensi, a.unit
                    FROM
                    (SELECT ra.id_pegawai, uk.nama_baru as unit, COUNT(ra.id) AS jml_hari,
                    GROUP_CONCAT(DISTINCT DATE_FORMAT(ra.tgl,  '%d/%m/%Y') ORDER BY ra.tgl ASC SEPARATOR ', ') AS hist_absensi
                    FROM report_absensi ra, unit_kerja uk, ref_status_absensi rsa
                    WHERE MONTH(ra.tgl) = ".$bln." AND YEAR(ra.tgl) = ".$thn." AND uk.id_skpd = ".$idskpd." /*AND ra.status <> 'TA'*/ AND
                    ra.id_unit_kerja = uk.id_unit_kerja AND rsa.idstatus = '".$status."' AND ra.status = rsa.idstatus
                    GROUP BY ra.id_pegawai) a, pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                    WHERE p.id_pegawai = a.id_pegawai AND p.flag_pensiun = 0 AND p.flag_mpp IS NULL ORDER BY a.jml_hari DESC, p.pangkat_gol DESC;";
        }
        return $this->db->query($sql);
    }

    public function getRekapWaktu_Kehadiran_Absensi($idopd,$bln,$thn){
        $sql = $this->getSQLRekapitulasiAbsensi($idopd,$bln,$thn);
        return $this->db->query((string)$sql);
        //echo $sql;
        //if($this->db->query((string)$sql)){
        //echo "OK";
        //}
        //$error = $this->db->error();
        // If an error occurred, $error will now have 'code' and 'message' keys...
        //if (isset($error['message'])) {
        //echo $error['message'];
        //}
    }

    private function getSQLRekapitulasiAbsensi($idopd,$bln,$thn){
        $sql = "CALL PRCD_ABSEN_REPORT('opd',$idopd, '$thn-$bln');";
        $qryAbsensi = $this->db->query($sql);
        $recAbs = $qryAbsensi->result();
        foreach ($recAbs as $lsdata){
            $sql = $lsdata->sqlAbsen;
        }

        mysqli_next_result( $this->db->conn_id );
        return $sql;
    }

    public function get($param){
        if(!$param){
            echo json_encode(112);
            exit;
        }
        $query = "select
					IF(LENGTH(p.gelar_belakang) > 1,
						IF(LENGTH(p.gelar_depan) > 0, concat(p.gelar_depan,' ',p.nama,', ',p.gelar_belakang),
								concat(p.nama,', ',p.gelar_belakang) ),
						IF(LENGTH(p.gelar_depan) > 0, concat(p.gelar_depan,' ',p.nama), p.nama) ) as nama,
					p.nip_baru as nip,
					md5(p.password) as password,
					p.pangkat_gol as gol,
					IF(p.id_j is not null, j.id_j,
						IF(p.jenjab = 'Fungsional', NULL,
							IF(jp.kode_jabatan is not NULL, jm.kode_jabatan, NULL))) as id_jabatan,
					IF(p.id_j is not null, j.jabatan,
						IF(p.jenjab = 'Fungsional', p.jabatan,
							IF(jp.kode_jabatan is not NULL, jm.nama_jfu, p.jabatan))) as jabatan,

					IF(p.id_j is NULL, 'NS', j.eselon) as eselonering,
					uk.id_unit_kerja as id_unit_kerja,
					uk.nama_baru as unit_kerja,
					'100' as request_status
				from pegawai p
				inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
				inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
				left join jabatan j on j.id_j = p.id_j
				left join jfu_pegawai jp on jp.id_pegawai = p.id_pegawai
				left join jfu_master jm on jm.kode_jabatan = jp.kode_jabatan
				where p.flag_pensiun = 0
				and (
					p.nip_baru = '".$param."'
					OR p.nama like '%".$param."%'
					OR clk.id_unit_kerja = '".$param."'
					OR uk.nama_baru like '%".$param."%'
					)
				ORDER BY ISNULL(j.eselon), j.eselon, p.pangkat_gol DESC, p.nip_baru ASC	";
        return $this->db->query($query);
    }

    public function get_profil($nip){
    $query = "select
					nip_baru as nip,
					gelar_depan,
					gelar_belakang,
					tempat_lahir,
					tgl_lahir,
					agama,
					jenis_kelamin,
					alamat,
					pangkat_gol,
					password,
					imei
					from pegawai where nip_baru = '".$nip."'";
    return $this->db->query($query);
}

    public function get_riwayat_golongan($nip){
        $this->set_nip($nip);
        $query = "select
					id_sk,
					no_sk,
					SPLIT_STR(keterangan,',',1) as golongan,
					SPLIT_STR(keterangan,',',2) as masa_kerja_tahun,
					SPLIT_STR(keterangan,',',3) as masa_kerja_bulan,
					tgl_sk,
					tmt,
					IF(id_kategori_sk = 5, 'PNS',
						IF(id_kategori_sk = 6, 'CPNS',
							IF(id_kategori_sk = 7, 'KP', 'UNDEFINED'))) as keterangan
					 from sk where id_pegawai = ".$this->id_pegawai."
					and (id_kategori_sk in (5,6,7)) order by tmt ASC";
        return $this->db->query($query);
    }

    public function get_sync_esurat(){
        $sql = "SELECT b.*, uk.nama_baru as unit_kerja FROM
                (SELECT a.*, uk.id_skpd AS kode_unit_kerja, CASE WHEN a.eselon IS NULL THEN 'NS' ELSE a.eselon END AS eselon2 FROM
                (SELECT p.id_pegawai, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.nip_baru, p.email,
                p.nip_baru as username, md5(p.password) as password, clk.id_unit_kerja,
                CASE WHEN p.jenjab = 'Fungsional' THEN 1 ELSE CASE WHEN p.id_j IS NULL THEN 2 ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN 'Fungsional Umum' ELSE j.jabatan END END AS jabatan,
                p.pangkat_gol, j.eselon
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j, current_lokasi_kerja clk
                WHERE p.id_pegawai = clk.id_pegawai AND p.flag_pensiun = 0) AS a, unit_kerja uk
                WHERE a.id_unit_kerja = uk.id_unit_kerja) AS b, unit_kerja uk
                WHERE b.kode_unit_kerja = uk.id_unit_kerja
                ORDER BY b.eselon2 ASC, b.pangkat_gol DESC";
        return $this->db->query($sql);
    }

    public function find_all(){
        $sql = "SELECT a.*, uk.nama_baru as opd FROM
                (SELECT p.id_pegawai, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.nip_baru,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN 'Fungsional Umum' ELSE j.jabatan END END AS jabatan,
                p.flag_pensiun, c.id_unit_kerja, u.nama_baru as unit_kerja, p.pangkat_gol, j.eselon, u.id_skpd
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                INNER JOIN current_lokasi_kerja as c ON p.id_pegawai = c.id_pegawai
                INNER JOIN unit_kerja as u ON c.id_unit_kerja = u.id_unit_kerja WHERE p.flag_pensiun = 0) a
                LEFT JOIN unit_kerja uk ON a.id_skpd = uk.id_unit_kerja
                ORDER BY CASE WHEN a.eselon IS NULL THEN 'NS' ELSE a.eselon END, a.pangkat_gol DESC";
        return $this->db->query($sql);
    }

    public function esurat_pejabat(){
        $query = "select pegawai.id_pegawai as 'ID Pegawai',CONCAT(CASE WHEN gelar_depan = '' THEN '' ELSE CONCAT(gelar_depan, ' ') END,
                  nama, CASE WHEN gelar_belakang = '' THEN '' ELSE CONCAT(' ',gelar_belakang) END) AS nama,
                  nip_baru as nip ,id_old as 'ID Unit Kerja Lama' ,
                  unit_kerja.id_unit_kerja as 'ID Unit Kerja Baru', id_j_old as 'ID Jabatan Lama' ,jabatan.id_j as 'ID Jabatan Baru'
                  from pegawai inner join jabatan on jabatan.id_j=pegawai.id_j
                  inner join unit_kerja on jabatan.id_unit_kerja = unit_kerja.id_unit_kerja
                  where flag_pensiun=0 and jabatan.Tahun=(select max(jabatan.tahun) from jabatan)";
        return $this->db->query($query);
    }

    public function find_by_nama($nama){
        $sql = "SELECT p.id_pegawai, p.nama, p.nip_baru, p.jabatan, p.flag_pensiun, c.id_unit_kerja, u.nama_baru,
                CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END, ' (', p.nip_baru, ')', ' - ', u.nama_baru) AS nama_gelar,
                HEX(AES_ENCRYPT(p.id_pegawai,SHA2('keyloginekinerja',512))) as id_pegawai_enc 
                FROM (pegawai as p INNER JOIN current_lokasi_kerja as c ON p.id_pegawai = c.id_pegawai)
                INNER JOIN unit_kerja as u ON c.id_unit_kerja = u.id_unit_kerja
                WHERE p.flag_pensiun = 0 AND (nama like '%$nama%' OR nip_baru like '%$nama%')";
        return $this->db->query($sql);
    }

    public function find_by_nama_and_opd($nama, $idopd){
        $sql = "SELECT p.id_pegawai, p.nama, p.nip_baru, p.jabatan, p.flag_pensiun, c.id_unit_kerja, u.nama_baru,
                CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END, ' (', p.nip_baru, ')', ' - ', u.nama_baru) AS nama_gelar,
                HEX(AES_ENCRYPT(p.id_pegawai,SHA2('keyloginekinerja',512))) as id_pegawai_enc 
                FROM (pegawai as p INNER JOIN current_lokasi_kerja as c ON p.id_pegawai = c.id_pegawai)
                INNER JOIN unit_kerja as u ON c.id_unit_kerja = u.id_unit_kerja
                WHERE p.flag_pensiun = 0 AND (nama like '%$nama%' OR nip_baru like '%$nama%') AND u.id_skpd = $idopd";
        return $this->db->query($sql);
    }

    public function find_by_nip($nip){
        $sql = "SELECT p.id_pegawai, p.nama, p.nip_baru, p.jabatan, p.flag_pensiun, c.id_unit_kerja, u.nama_baru,
                CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END, ' (', p.nip_baru, ')') AS nama_gelar
                FROM (pegawai as p INNER JOIN current_lokasi_kerja as c ON p.id_pegawai = c.id_pegawai)
                INNER JOIN unit_kerja as u ON c.id_unit_kerja = u.id_unit_kerja
                WHERE p.flag_pensiun = 0 AND nip_baru like '%$nip%'";
        return $this->db->query($sql);
    }

    public function find_by_unit_kerja($unit){
        $sql = "SELECT p.id_pegawai, p.nama, p.nip_baru, p.jabatan, p.flag_pensiun, c.id_unit_kerja, u.nama_baru
                FROM (pegawai as p INNER JOIN current_lokasi_kerja as c ON p.id_pegawai = c.id_pegawai)
                INNER JOIN unit_kerja as u ON c.id_unit_kerja = u.id_unit_kerja
                WHERE p.flag_pensiun = 0 AND u.nama_baru like '%$unit%'";
        return $this->db->query($sql);
    }

    public function getListPerPangkat($gol){
        $sql = "SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
				nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
				ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia,
				uk.nama_baru as unit_kerja FROM pegawai p, current_lokasi_kerja clk, unit_kerja uk
				WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
				AND p.flag_pensiun = 0 AND p.pangkat_gol = '".$gol."' ORDER BY uk.nama_baru, p.nama";
        return $this->db->query($sql);
    }

    public function getListPerStruktural($eselon){
        if($eselon=='Staf'){
            $eselon = 'Z';
        }
        $sql = "SELECT a.id_pegawai, CONCAT(\"'\",a.nip_baru) AS nip, a.nama, a.tempat_lahir, a.tgl_lahir, a.usia, a.jenjab, a.pangkat_gol, a.jabatan,
				CASE WHEN a.eselon = 'Z' THEN 'Staf' ELSE a.eselon END AS eselon, a.unit, a.id_skpd, uk.nama_baru as skpd/*, a.Alamat, a.alamat_rumah*/
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
				AND p.flag_pensiun = 0 AND p.jenjab = 'Struktural'
				ORDER BY eselon ASC, p.pangkat_gol DESC, p.nama) a, unit_kerja uk
				WHERE a.id_skpd = uk.id_unit_kerja AND a.eselon = '".$eselon."'";
        return $this->db->query($sql);
    }

    public function getListPerBidangPendidikan($idbidang){
        $sql = "SELECT peg.nip_baru, peg.nama, kp.nama_pendidikan, c.lembaga_pendidikan,
				c.jurusan_pendidikan, c.tahun_lulus, bp.bidang, uk.nama_baru
				FROM pegawai peg,
				(SELECT p.* FROM pendidikan p INNER JOIN
				(SELECT p.id_pegawai, MAX(p.id_pendidikan) AS id_pendidikan FROM pendidikan p,
				(SELECT p.id_pegawai, MIN(pend.level_p) AS level_p
				FROM pegawai p INNER JOIN pendidikan pend ON p.id_pegawai = pend.id_pegawai
				WHERE p.flag_pensiun = 0 AND pend.level_p < 7
				GROUP BY p.id_pegawai) a WHERE p.id_pegawai = a.id_pegawai AND p.level_p = a.level_p
				GROUP BY p.id_pegawai) b ON p.id_pendidikan = b.id_pendidikan) c
				LEFT JOIN kategori_pendidikan kp ON c.level_p = kp.level_p
				LEFT JOIN bidang_pendidikan bp ON c.id_bidang = bp.id,
				current_lokasi_kerja clk, unit_kerja uk
				WHERE peg.id_pegawai = c.id_pegawai AND peg.id_pegawai = clk.id_pegawai
				AND clk.id_unit_kerja = uk.id_unit_kerja AND c.id_bidang = ".$idbidang;
        return $this->db->query($sql);
    }

    public function getListPerLevelPendidikan($level){
        $sql = "SELECT peg.nip_baru, peg.nama, kp.nama_pendidikan, c.lembaga_pendidikan,
				c.jurusan_pendidikan, c.tahun_lulus, bp.bidang, uk.nama_baru
				FROM pegawai peg,
				(SELECT p.* FROM pendidikan p INNER JOIN
				(SELECT p.id_pegawai, MAX(p.id_pendidikan) AS id_pendidikan FROM pendidikan p,
				(SELECT p.id_pegawai, MIN(pend.level_p) AS level_p
				FROM pegawai p INNER JOIN pendidikan pend ON p.id_pegawai = pend.id_pegawai
				WHERE p.flag_pensiun = 0
				GROUP BY p.id_pegawai) a WHERE p.id_pegawai = a.id_pegawai AND p.level_p = a.level_p
				GROUP BY p.id_pegawai) b ON p.id_pendidikan = b.id_pendidikan) c
				LEFT JOIN kategori_pendidikan kp ON c.level_p = kp.level_p
				LEFT JOIN bidang_pendidikan bp ON c.id_bidang = bp.id,
				current_lokasi_kerja clk, unit_kerja uk
				WHERE peg.id_pegawai = c.id_pegawai AND peg.id_pegawai = clk.id_pegawai
				AND clk.id_unit_kerja = uk.id_unit_kerja AND c.level_p = ".$level;
        return $this->db->query($sql);
    }

    public function getListPegawaiOPD($opd){
        $sql = "SELECT b.*, p.id_pegawai AS id_pegawai_atasan FROM
(SELECT a.id_pegawai, a.nip_baru AS nip, a.nama, a.tempat_lahir, a.tgl_lahir, a.usia, a.jenjab, a.pangkat_gol, a.jabatan,
			CASE WHEN a.eselon = 'Z' THEN '' ELSE a.eselon END AS eselon,
      a.id_unit_kerja, a.unit, uk.id_unit_kerja AS id_skpd, uk.nama_baru as skpd, a.id_bos_atsl
			FROM
			(SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
			nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.tempat_lahir, p.tgl_lahir,
			  ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia ,
			  p.jenjab, p.pangkat_gol,
			CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
			(SELECT jm.nama_jfu AS jabatan
			 FROM jfu_pegawai jp, jfu_master jm
			 WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
			ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon, uk.id_unit_kerja, uk.nama_baru as unit,
			uk.id_skpd, p.flag_provinsi,
      CASE WHEN j.id_bos IS NULL = 1 THEN (
        (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
             (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                 (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                     (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                         (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                             (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                                 (SELECT CASE WHEN ( (id_j_bos IS NULL) OR (COUNT(id_j_bos)=0)) THEN
                                     0
                                 ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                                 (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                                 FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                                 WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 5
                                 GROUP BY riwayat_mutasi_kerja.id_pegawai
                                 ORDER BY tmt DESC LIMIT 1))
                             ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                             (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                             FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                             WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 9
                             GROUP BY riwayat_mutasi_kerja.id_pegawai
                             ORDER BY tmt DESC LIMIT 1))
                         ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                         (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                         FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                         WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 12
                         GROUP BY riwayat_mutasi_kerja.id_pegawai
                         ORDER BY tmt DESC LIMIT 1))
                     ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                     (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                     FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                     WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 10
                     GROUP BY riwayat_mutasi_kerja.id_pegawai
                     ORDER BY tmt DESC LIMIT 1))
                 ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
                 (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
                 FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
                 WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 7
                 GROUP BY riwayat_mutasi_kerja.id_pegawai
                 ORDER BY tmt DESC LIMIT 1))
             ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
             (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
             FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
             WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 6
             GROUP BY riwayat_mutasi_kerja.id_pegawai
             ORDER BY tmt DESC LIMIT 1))
         ELSE  id_j_bos END AS id_j_bos FROM riwayat_mutasi_kerja rmk WHERE rmk.id_riwayat =
         (SELECT MAX(riwayat_mutasi_kerja.id_riwayat) AS idriwayat
         FROM riwayat_mutasi_kerja INNER JOIN sk ON sk.id_sk = riwayat_mutasi_kerja.id_sk
         WHERE sk.id_pegawai = p.id_pegawai AND sk.id_kategori_sk = 1
         GROUP BY riwayat_mutasi_kerja.id_pegawai
         ORDER BY tmt DESC LIMIT 1))
      ) ELSE j.id_bos END AS id_bos_atsl
			FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j, current_lokasi_kerja clk, unit_kerja uk
			WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja AND uk.id_skpd = $opd
			AND p.flag_pensiun = 0 /*AND YEAR(p.tgl_pensiun_dini) = 2016*/
			ORDER BY eselon ASC, p.pangkat_gol DESC, p.nama) a, unit_kerja uk
			WHERE a.id_skpd = uk.id_unit_kerja) b LEFT JOIN pegawai p ON b.id_bos_atsl = p.id_j";
        return $this->db->query($sql);
    }


	function set_nip($nip){
		$this->nip = $nip;
		$query = "select id_pegawai from pegawai where nip_baru = ".$this->nip;
		$id_pegawai = $this->db->query($query)->row()->id_pegawai;
		$this->id_pegawai = $id_pegawai;
	}

	function getGolongan(){
	    $sql = "SELECT * FROM golongan";
        return $this->db->query($sql);
    }

    function getJumlahPegawai(){
        $sql = "SELECT COUNT(id_pegawai) as jumlah_pns
                FROM pegawai WHERE flag_pensiun = 0";
        return $this->db->query($sql);
    }

    function listPegawaiAppsBisa($limit_awal, $limit_akhir, $keyApps){
        $sql = "SELECT b.nip_baru, b.nama, b.ponsel, b.email, b.password, b.foto, b.nip_enc, b.id_unit, b.unit,
                b.id_opd, uk.nama_baru as opd FROM (SELECT a.*,
                uk.id_unit_kerja as id_unit, uk.nama_baru as unit, uk.id_skpd as id_opd FROM
                (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.pangkat_gol,
                p.ponsel, p.email, CONCAT(DATE_FORMAT(p.tgl_lahir, '%d%m'), SUBSTRING(YEAR(p.tgl_lahir),3,2)) as password,
                CONCAT("."'https://arsipsimpeg.kotabogor.go.id/simpeg/foto/'".", p.id_pegawai, '.jpg') as foto,
                HEX(AES_ENCRYPT(p.nip_baru, SHA2($keyApps,512))) as nip_enc
                FROM pegawai p 
                WHERE p.flag_pensiun = 0
                LIMIT $limit_awal, $limit_akhir) a
                LEFT JOIN current_lokasi_kerja clk ON a.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja) b
                LEFT JOIN unit_kerja uk ON b.id_opd = uk.id_unit_kerja
                ORDER BY b.pangkat_gol DESC, b.nama ASC";
        //echo $sql;
        return $this->db->query($sql);
	}

	function updatePonselEmailPegawai($data, $keyApps){
        $this->db->trans_begin();
        $ponsel = $data['ponsel'];
        $email = $data['email'];
        $nip = $data['nip'];
        $sql = "UPDATE pegawai SET ponsel = '$ponsel', email = '$email'
                WHERE nip_baru = AES_DECRYPT(UNHEX('$nip'),SHA2($keyApps,512))";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return 0;
        }else{
            $this->db->trans_commit();
            return 1;
        }
    }

    public function daftar_pegawai_spesifik_kominfo(){
	    $sql = "SELECT a.nip_baru AS nip, a.nama, a.pangkat, a.pangkat_gol, a.jenjab,
                CASE WHEN a.eselon = 'Z' THEN 'Staf' ELSE a.eselon END AS eselon,
                a.jabatan, a.unit, a.tempat_lahir, a.tgl_lahir, a.status_nikah
                FROM
                (SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama, g.pangkat, p.pangkat_gol, p.jenjab,
                p.tempat_lahir, p.tgl_lahir,
                ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia ,
                CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kode_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kode_jabatan_jfu) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kelas_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kelas_jabatan_jfu) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.nilai_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nilai_jabatan_jfu) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan,
                p.status_kawin as status_nikah,
                uk.id_unit_kerja, uk.nama_baru as unit,
                uk.id_skpd, p.flag_provinsi
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN golongan g ON p.pangkat_gol = g.golongan
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
                INNER JOIN jafung jm ON b.id_jafung = jm.id_jafung) jafung ON jafung.id_pegawai = p.id_pegawai,
                current_lokasi_kerja clk, unit_kerja uk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja /*AND uk.id_skpd = 5296*/
                AND p.flag_pensiun = 0 /*AND YEAR(p.tgl_pensiun_dini) = 2016*/
                ORDER BY eselon ASC, p.pangkat_gol DESC, p.nama) a, unit_kerja uk
                WHERE a.id_skpd = uk.id_unit_kerja
                ORDER BY eselon ASC, pangkat_gol DESC, nama";
        return $this->db->query($sql);
    }

		public function get_cpns($id_pegawai){

			$this->db->where('id_kategori_sk',6);
			$this->db->where('id_pegawai',$id_pegawai);

			return $this->db->get('sk')->row();
		}

		public function get_pns($id_pegawai){

			$this->db->where('id_kategori_sk',7);
			$this->db->where('id_pegawai',$id_pegawai);

			return $this->db->get('sk')->row();
		}

		public function daftar_pegawai_spesifik_organisasi(){
	        $sql = "SELECT a.nip_baru AS nip, a.nama, a.pangkat, a.pangkat_gol, a.eselon, a.jabatan, a.unit 
                FROM
                (SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama, g.pangkat, p.pangkat_gol, p.jenjab,
                p.tempat_lahir, p.tgl_lahir,
                ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia ,
                CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kode_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kode_jabatan_jfu) ELSE j.id_j END END AS kode_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.kelas_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.kelas_jabatan_jfu) ELSE j.kelas_jabatan END END AS kelas_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (jafung.nilai_jabatan_jafung) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nilai_jabatan_jfu) ELSE j.nilai_jabatan END END AS nilai_jabatan,
                CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan,
                p.status_kawin as status_nikah,
                uk.id_unit_kerja, uk.nama_baru as unit,
                uk.id_skpd, p.flag_provinsi
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
                LEFT JOIN golongan g ON p.pangkat_gol = g.golongan
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
                INNER JOIN jafung jm ON b.id_jafung = jm.id_jafung) jafung ON jafung.id_pegawai = p.id_pegawai,
                current_lokasi_kerja clk, unit_kerja uk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja /*AND uk.id_skpd = 5296*/
                AND p.flag_pensiun = 0 /*AND YEAR(p.tgl_pensiun_dini) = 2016*/
                ORDER BY eselon ASC, p.pangkat_gol DESC, p.nama) a, unit_kerja uk
                WHERE a.id_skpd = uk.id_unit_kerja
                ORDER BY eselon ASC, pangkat_gol DESC, nama";
            return $this->db->query($sql);
        }

	/*public function find_pegawai(){
		$sql = "SELECT p.id_pegawai, p.nama, p.nip_baru, p.jabatan, p.flag_pensiun, c.id_unit_kerja, u.nama_baru FROM (pegawai as p INNER JOIN current_lokasi_kerja as c ON p.id_pegawai = c.id_pegawai) INNER JOIN unit_kerja as u ON c.id_unit_kerja = u.id_unit_kerja WHERE p.flag_pensiun = 0";
		return $this->db->query($sql);
	}*/



}
