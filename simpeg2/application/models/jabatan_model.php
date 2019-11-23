<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jabatan_model extends CI_model{

	public $id_j;
	public function __construct(){

		parent::__construct();

	}

	function set_id_j($id_j){
		$this->id_j = $id_j;
	}

	function get_jabatan($id_j){
	    $sql = "select j.id_j, j.jabatan, j.eselon, e.gol_minimal, uk.nama_baru as nama_baru_skpd
			from jabatan  j, golongan_eselon e, unit_kerja uk
			where e.eselon = j.eselon and uk.id_unit_kerja = j.id_unit_kerja and j.id_j = $id_j
			order by j.eselon";

        $query = $this->db->query($sql);

		$data = null;
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return null;
	}

	public function get_jabatan_pegawai($id_pegawai){
		$sql = 'select p.id_pegawai,
		IF(p.id_j is not NULL, j.jabatan,
							IF(p.jenjab like "Struktural", jfu_master.nama_jfu,  jafung_pegawai.jabatan)
						) as jabatan
		from pegawai p
        left join jabatan j on j.id_j = p.id_j
				left join  (
					select distinct jfu_pegawai.id_pegawai, id_jfu, kode_jabatan, id_sk, jabatan, jfu_pegawai.tmt from jfu_pegawai
					inner join
							(select distinct j.id_pegawai, max(j.tmt) as tmt from jfu_pegawai j group by j.id_pegawai) jfu_tmt
							on jfu_tmt.id_pegawai = jfu_pegawai.id_pegawai and jfu_pegawai.tmt = jfu_tmt.tmt
						) jfu_pegawai on jfu_pegawai.id_pegawai = p.id_pegawai and p.id_j is null
				left join jfu_master on jfu_master.id_jfu = jfu_pegawai.id_jfu
				left join ( select distinct jafung_pegawai.id_pegawai, jafung_pegawai.tmt, concat(jafung.nama_jafung, " ",jafung.tingkat," ",jafung.jenjang_jabatan) as jabatan from jafung_pegawai
							inner join (select j.id_pegawai, max(j.tmt) as tmt from jafung_pegawai j group by j.id_pegawai)jafung_tmt on jafung_tmt.id_pegawai = jafung_pegawai.id_pegawai
                and jafung_pegawai.tmt = jafung_tmt.tmt
                inner join jafung on jafung.id_jafung = jafung_pegawai.id_jafung ) jafung_pegawai on jafung_pegawai.id_pegawai = p.id_pegawai  where p.id_pegawai = '.$id_pegawai;

				$qjo=$this->db->query($sql);

				if($jab = $qjo->row()){
					$jabatan=$jab->jabatan;
				}else{
					$jabatan = "jabatan tidak ditemukan";
				}

				return $jabatan;
	}
	public function get_jabatan_pegawai_old($id_pegawai){

		$pegawai = $this->db->get_where('pegawai',array('id_pegawai'=>$id_pegawai))->row();
		//echo $this->db->last_query();exit;
		if($pegawai->id_j != NULL && $pegawai->jenjab == 'Struktural'){

			$qjo=$this->db->query("select jabatan from jabatan where id_j=".$pegawai->id_j);

			if($jab = $qjo->row()){
				$jabatan = $jab->jabatan;
			}else{
				$jabatan = "jabatan tidak ditemukan";
			}

		}elseif($pegawai->id_j == NULL && $pegawai->jenjab == 'Struktural'){

			/*$sql = "select jfu_pegawai.*, jfu_master.*
					from jfu_pegawai, jfu_master
					where jfu_pegawai.id_pegawai = '".$pegawai->id_pegawai."'
					and jfu_master.kode_jabatan = jfu_pegawai.kode_jabatan";*/

			$sql = "select distinct jfu_pegawai.id_pegawai, jfu_pegawai.id_jfu, jfu_pegawai.kode_jabatan, jfu_pegawai.id_sk,
                    jfu_pegawai.jabatan, jfu_pegawai.tmt, jm.nama_jfu from jfu_pegawai
                    inner join
                    (select distinct j.id_pegawai, max(j.tmt) as tmt from jfu_pegawai j where j.id_pegawai = ".$pegawai->id_pegawai." group by j.id_pegawai) jfu_tmt
                    on jfu_tmt.id_pegawai = jfu_pegawai.id_pegawai and jfu_pegawai.tmt = jfu_tmt.tmt
                    inner join jfu_master jm on jfu_pegawai.id_jfu = jm.id_jfu";

			$qjo=$this->db->query($sql);

			if($jab = $qjo->row()){
				$jabatan=$jab->nama_jfu;
			}else{
				$jabatan = "jabatan tidak ditemukan";
			}
			//$jabatan=mysql_fetch_object($qjo)->nama_jfu;
		}else{ // jabatan fungsional

			$jabatan = $pegawai->jabatan;

		}


		return $jabatan;
	}

	function get_jabatan_struktural_kosong(){
		/*$query = $this->db->query("select j.jabatan, j.eselon, p.nama, nama_baru
					from jabatan j
					inner join unit_kerja u on u.id_unit_kerja = j.id_unit_kerja
					left  join pegawai p on p.id_j = j.id_j
					where j.tahun = (select max(tahun) from jabatan) and p.nama is null and j.eselon not like '(walikota)' and eselon not like 'ns'
					and eselon NOT LIKE '-'
				  	ORDER BY j.eselon ASC");*/

        $sql = "SELECT e.* FROM
              (SELECT p.id_pegawai,
                 a.jabatan, a.eselon, a.nama_baru, uk.nama_baru as skpd
               FROM
                 (SELECT uk.id_unit_kerja, uk.nama_baru, j.jabatan, j.eselon, j.id_j, j.id_bos, j.Tahun, uk.id_skpd
                  from unit_kerja uk LEFT JOIN jabatan j ON uk.id_unit_kerja = j.id_unit_kerja
                  where uk.tahun = 2017 and j.Tahun > 0  AND j.jabatan != 'Walikota Bogor' AND j.jabatan != 'Wakil Walikota Bogor'
                  order by uk.nama_baru ASC) a LEFT JOIN pegawai p ON a.id_j = p.id_j AND (p.flag_pensiun = 0)
                 LEFT JOIN unit_kerja uk ON a.id_skpd = uk.id_unit_kerja
               ORDER BY a.id_unit_kerja ASC, a.eselon ASC) e
            WHERE e.id_pegawai IS NULL /*AND e.jabatan LIKE 'Camat%' /*AND (e.eselon = 'IIIA' OR e.eselon = 'IIIB')*/
            /*AND e.unit_kerja LIKE '%Kepegawaian%'*/
            ORDER BY e.eselon DESC";
        $query = $this->db->query($sql);
		$data = null;
		foreach ($query->result() as $row){
			$data[] = $row;
		}
		return $data;
	}

	function get_jabatan_struktural_potensi_kosong(){

	}

	function get_bos_jabatan($id_j, $id_draft = null){

		if(isset($id_draft)){
			$sql = "SELECT d.*, s.tmt as tmt_pangkat FROM
				(SELECT c.*, s.tmt as tmt_jabatan FROM
				(SELECT b.*, p.nama, p.pangkat_gol, p.nip_baru, p.id_pegawai AS id_pegawai_bos FROM
				(SELECT a.*, j.id_j AS id_j_bos, j.jabatan AS jabatan_bos, j.eselon AS eselon_bos FROM
				(SELECT * FROM jabatan j
				WHERE j.id_j = $id_j) a, jabatan j
				WHERE a.id_bos = j.id_j) b, draft_pelantikan_detail dpd, pegawai p
				WHERE b.id_j_bos = dpd.id_j and dpd.id_pegawai = p.id_pegawai and dpd.id_draft = $id_draft) c INNER JOIN sk s ON c.id_j_bos = s.id_j) d
				LEFT JOIN sk s ON d.pangkat_gol = s.gol AND s.id_kategori_sk = 5 AND d.id_pegawai_bos = s.id_pegawai
				ORDER BY s.tmt DESC";
		}else{
			$sql = "SELECT d.*, s.tmt as tmt_pangkat FROM
				(SELECT c.*, s.tmt as tmt_jabatan FROM
				(SELECT b.*, p.nama, p.pangkat_gol, p.nip_baru, p.id_pegawai AS id_pegawai_bos FROM
				(SELECT a.*, j.id_j AS id_j_bos, j.jabatan AS jabatan_bos, j.eselon AS eselon_bos FROM
				(SELECT * FROM jabatan j
				WHERE j.id_j = $id_j) a, jabatan j
				WHERE a.id_bos = j.id_j) b,  pegawai p
				WHERE b.id_j_bos = p.id_j) c INNER JOIN sk s ON c.id_j_bos = s.id_j) d
				LEFT JOIN sk s ON d.pangkat_gol = s.gol AND s.id_kategori_sk = 5 AND d.id_pegawai_bos = s.id_pegawai
				ORDER BY s.tmt DESC";
		}
		$query = $this->db->query($sql);
		$data = null;
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return null;
	}

	function get_jabatan_bawahan($id_j, $id_draft = null){

	    $sql = "SELECT * FROM draft_pelantikan_detail
                WHERE id_draft = $id_draft AND id_j = $id_j";

        $query = $this->db->query($sql);
        foreach ($query->result() as $row){
            $idp_awal = $row->id_pegawai_awal;
            $idp_akhir = $row->id_pegawai;
        }

        if($idp_awal==$idp_akhir){
            $sql = "SELECT a.*, pt.level_p FROM (SELECT d.*, s.tmt as tmt_pangkat FROM
				(SELECT c.*, MAX(s.tmt) as tmt_jabatan FROM
				(SELECT b.*, p.nama, p.pangkat_gol, p.jenjab, p.nip_baru, p.id_pegawai AS id_pegawai_bawahan FROM
				(SELECT a.*, j.id_j AS id_j_bawahan, j.jabatan AS jabatan_bawahan, j.eselon AS eselon_bawahan FROM
				(SELECT j.* FROM jabatan j
				WHERE j.id_j = $id_j) a, jabatan j
				WHERE j.id_bos = a.id_j) b, pegawai p
				WHERE b.id_j_bawahan = p.id_j AND p.flag_pensiun = 0) c INNER JOIN sk s ON c.id_j_bawahan = s.id_j GROUP BY c.id_j_bawahan) d
				LEFT JOIN sk s ON (d.pangkat_gol = s.gol AND s.id_kategori_sk = 5 AND d.id_pegawai_bawahan = s.id_pegawai)
				GROUP BY d.id_j, d.jabatan, d.id_unit_kerja, d.id_bos, d.eselon, d.level, d.tunjangan, d.Tahun, d.id_pegawai,
				d.id_j_old, d.id_j_bawahan, d.jabatan_bawahan, d.eselon_bawahan, d.nama, d.pangkat_gol, d.nip_baru,
				d.id_pegawai_bawahan, d.tmt_jabatan
				ORDER BY s.tmt DESC) a LEFT JOIN pendidikan_terakhir pt ON a.id_pegawai_bawahan = pt.id_pegawai";
        }else{
            if($idp_akhir==''){
                $sel = "p.nama as nama, p.pangkat_gol as pangkat_gol, p.nip_baru as nip_baru, p.id_pegawai as id_pegawai_bawahan, p.jenjab";
            }else{
                $sel = "IF(dpd.id_pegawai is not null, p.nama, null) as nama,
					IF(dpd.id_pegawai is not null, p.pangkat_gol, null) as pangkat_gol,
					IF(dpd.id_pegawai is not null, p.nip_baru, null) as nip_baru,
					IF(dpd.id_pegawai is not null, p.id_pegawai, null) as id_pegawai_bawahan,  
                    IF(dpd.id_pegawai is not null, p.jenjab, null) as jenjab";
            }
            $sql = " SELECT a.*, pt.level_p FROM (SELECT d.*, s.tmt as tmt_pangkat FROM
				(SELECT c.*, MAX(s.tmt) as tmt_jabatan FROM
				(SELECT b.*, $sel FROM
				(SELECT a.*, j.id_j AS id_j_bawahan, j.jabatan AS jabatan_bawahan, j.eselon AS eselon_bawahan FROM
				(SELECT j.* FROM jabatan j
				WHERE j.id_j = $id_j) a, jabatan j
				WHERE j.id_bos = a.id_j) b
                left join pegawai p on p.id_j = b.id_j_bawahan AND p.flag_pensiun = 0
                LEFT JOIN draft_pelantikan_detail dpd on dpd.id_j = id_j_bawahan and dpd.id_draft = $id_draft
				WHERE b.id_j_bawahan = p.id_j) c INNER JOIN sk s ON c.id_j_bawahan = s.id_j GROUP BY c.id_j_bawahan) d
				LEFT JOIN sk s ON (d.pangkat_gol = s.gol AND s.id_kategori_sk = 5 AND d.id_pegawai_bawahan = s.id_pegawai)
				GROUP BY d.id_j, d.jabatan, d.id_unit_kerja, d.id_bos, d.eselon, d.level, d.tunjangan, d.Tahun, d.id_pegawai,
				d.id_j_old, d.id_j_bawahan, d.jabatan_bawahan, d.eselon_bawahan, d.nama, d.pangkat_gol, d.nip_baru,
				d.id_pegawai_bawahan, d.tmt_jabatan
				ORDER BY s.tmt DESC) a LEFT JOIN pendidikan_terakhir pt ON a.id_pegawai_bawahan = pt.id_pegawai";
        }

		$query = $this->db->query($sql);
		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}

    function get_jabatan_bawahan_staf($id_j){
        $sql = "SELECT b.*, pt.level_p FROM (SELECT a.*, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama, p.jenjab, 
                CASE WHEN s.tmt IS NOT NULL THEN s.tmt ELSE (SELECT tmt FROM sk WHERE sk.id_pegawai = a.id_pegawai_bawahan AND sk.id_kategori_sk = 7 LIMIT 1) END AS tmt_pangkat
                FROM (SELECT
                CASE WHEN (MAX(rmk.pangkat_gol) IS NOT NULL AND MAX(rmk.pangkat_gol) <> '') THEN MAX(rmk.pangkat_gol)
                ELSE (SELECT pangkat_gol FROM pegawai WHERE id_pegawai = rmk.id_pegawai)
                END AS pangkat_gol, rmk.id_pegawai as id_pegawai_bawahan
                FROM riwayat_mutasi_kerja rmk
                WHERE rmk.id_j_bos = $id_j
                GROUP BY rmk.id_pegawai) a
                INNER JOIN pegawai p ON a.id_pegawai_bawahan = p.id_pegawai AND p.id_j IS NULL AND p.flag_pensiun = 0 
                LEFT JOIN sk s ON s.gol = a.pangkat_gol AND s.id_pegawai = a.id_pegawai_bawahan AND s.id_kategori_sk = 5
                ) b LEFT JOIN pendidikan_terakhir pt ON b.id_pegawai_bawahan = pt.id_pegawai";

        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

	function cek_in_draft_by_idp($id_draft,$idp,$idp_bawahan_indraft){
        $sql = "SELECT COUNT(*) AS jumlah FROM draft_pelantikan_detail dpd
                WHERE dpd.id_draft = ".$id_draft." AND dpd.id_pegawai_awal = ".$idp_bawahan_indraft.
                " AND dpd.id_pegawai IS NULL";
        $query = $this->db->query($sql);
        foreach($query->result() as $jumlah){
            $jmla = $jumlah->jumlah;
        }
        if((int)$jmla > 0){
            return $query->result();
        }else{
            $sql = "SELECT COUNT(*) AS jumlah FROM draft_pelantikan_detail dpd
				WHERE dpd.id_draft = ".$id_draft." AND dpd.id_pegawai_awal = ".$idp." AND
				dpd.id_pegawai_awal <> dpd.id_pegawai";
            $query = $this->db->query($sql);
            return $query->result();
        }
	}

	function rekap_jabatan_struktural(){
		/*$query = $this->db->query("select
					eselon,
					sum(if(ada > 0, jumlah, 0)) as 'ada',
					sum(if(ada is NULL, jumlah, 0)) as 'kosong',
					sum(jumlah) as total
				from
				(
					select j.eselon, length(p.nama)/length(p.nama) as ada, count(*) as jumlah
					from jabatan j
					left  join pegawai p on p.id_j = j.id_j
					where j.tahun = 2017 and j.eselon not like '(walikota)' and eselon not like 'ns'
					group by j.eselon, length(p.nama)/length(p.nama)
					ORDER BY j.eselon ASC
				) as t
				group by eselon with rollup");*/

		$sql = "SELECT e.eselon, COUNT(e.eselon) as total, COUNT(e.id_pegawai) as ada,
                  (COUNT(e.eselon)-COUNT(e.id_pegawai)) as kosong
                FROM
                (SELECT a.eselon, p.id_pegawai
                 FROM
                (SELECT uk.id_unit_kerja, uk.nama_baru, j.jabatan, j.eselon, j.id_j, j.id_bos, j.Tahun, uk.id_skpd
                from unit_kerja uk LEFT JOIN jabatan j ON uk.id_unit_kerja = j.id_unit_kerja
                where uk.tahun = 2017 and j.Tahun > 0  AND j.jabatan != 'Walikota Bogor' AND j.jabatan != 'Wakil Walikota Bogor'
                order by uk.nama_baru ASC) a LEFT JOIN pegawai p ON a.id_j = p.id_j AND (p.flag_pensiun = 0)
                LEFT JOIN unit_kerja uk ON a.id_skpd = uk.id_unit_kerja
                ORDER BY a.id_unit_kerja ASC, a.eselon ASC) e
                GROUP BY e.eselon WITH ROLLUP";
        $query = $this->db->query($sql);
		$data = null;
		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}

	function get_jfu($id_pegawai){

		$this->db->distinct();
		$this->db->where('id_pegawai',$id_pegawai);
		$jab = $this->db->get('jfu_pegawai')->row();
		if($jab){
			return $this->get_jfu_name($jab->kode_jabatan);
		}else{
			return false;
		}
	}

	function get_jfu_name($kode_jabatan){

		$this->db->distinct();
		$this->db->where('kode_jabatan',$kode_jabatan);
		return $this->db->get('jfu_master')->row();
	}

	function get_list_jfu(){
		return $this->db->get('jfu_master')->result();
	}

	function get_list_jfu_existing(){

		$this->db->distinct();
		$this->db->group_by('kode_jabatan');
		return $this->db->get('jfu_pegawai')->result();
	}

	function get_list_pegawai_by_jfu($kode_jfu=NULL){
		if($kode_jfu){
			$this->db->where('kode_jabatan',$kode_jfu);
		}
		return $this->db->get('jfu_pegawai')->result();
	}

	function jfu_search($term){
		$this->db->like('nama_jfu',$term,'both');
		$this->db->or_like('kode_jabatan',$term,'right');
		return $this->db->get('jfu_master')->result();

	}

	function insert_jfu_pegawai($id_pegawai,$kode_jabatan, $keterangan=''){
		return $this->db->insert('jfu_pegawai',array('id_pegawai'=>$id_pegawai,'kode_jabatan'=>$kode_jabatan,'keterangan'=>$keterangan));
	}

	function update_jfu_pegawai($id_pegawai, $kode_jabatan){

		$this->db->where('id_pegawai',$id_pegawai);
		return $this->db->update('jfu_pegawai',array('kode_jabatan'=>$kode_jabatan));
	}

	function add_jfu($kode_jfu, $nama_jfu){

		return $this->db->insert('jfu_master',array('kode_jabatan'=>$kode_jfu,'nama_jfu'=>$nama_jfu));
	}

	function count_jfu($kode_jfu){

		//$this->db->where('kode_jabatan',$kode_jfu);
		//return $this->db->count_all('jfu_pegawai');

		$sql = 'SELECT COUNT( * ) AS jumlah
				FROM jfu_pegawai
				WHERE kode_jabatan =  "'.$kode_jfu.'"';
		return $this->db->query($sql)->row();
	}

	// Mendapatkan seluruh nominatif riwayat jabatan struktural
	function get_nominatif_riwayat_js(){
		$q = $this->db->query("select p.id_pegawai,nama, j.eselon,  concat('\'', nip_baru) as nip, pangkat_gol, r.jabatan, r.unit_kerja, r.tgl_masuk, r.tgl_keluar
								from pegawai p
								left join jabatan j on j.id_j = p.id_j
								left join riwayat_kerja r on r.id_pegawai = p.id_pegawai
								where p.flag_pensiun = 0
								and p.id_j is not null and r.jabatan not like 'pelaksana'
								ORDER BY j.eselon, p.nama, r.tgl_masuk desc");
		return $q->result();
	}

	function get_ipasn($idj){

		$query = $this->db->query("select flag_pendidikan,flag_pelatihan,flag_pengalaman,flag_administrasi,skor from ipasn_kompetensi where id_j=$idj");
		return $query->row();
	}

    public function drh_jabatan($id_pegawai){
        $sql = "SELECT a.jenis, a.kode_jabatan, a.nama_jabatan,
                CASE WHEN a.no_sk IS NULL = 1 THEN '-' ELSE a.no_sk END AS no_sk,
                CASE WHEN a.tmt IS NULL = 1 THEN '-' ELSE a.tmt END AS tmt,
                CASE WHEN a.tgl_sk IS NULL = 1 THEN '-' ELSE a.tgl_sk END AS tgl_sk,
                CASE WHEN a.kelas_jabatan IS NULL = 1 THEN '-' ELSE a.kelas_jabatan END AS kelas_jabatan,
                CASE WHEN a.nilai_jabatan IS NULL = 1 THEN '-' ELSE a.nilai_jabatan END AS nilai_jabatan
                FROM (SELECT 'Fungsional Umum' AS jenis, jfu.id_jfu as kode_jabatan, jfu.nama_jfu as nama_jabatan, s.no_sk, j.tmt, s.tgl_sk, jfu.kelas_jabatan, jfu.nilai_jabatan
                FROM jfu_pegawai j
                LEFT JOIN jfu_master jfu ON j.id_jfu = jfu.id_jfu
                LEFT JOIN sk s ON j.id_sk = s.id_sk
                WHERE j.id_pegawai = $id_pegawai 
                UNION ALL
                SELECT 'Fungsional Tertentu' AS jenis, jf.id_jafung as kode_jabatan, jf.nama_jafung as nama_jabatan, s.no_sk, j.tmt, s.tgl_sk, jf.kelas_jabatan, jf.nilai_jabatan
                FROM jafung_pegawai j
                LEFT JOIN jafung jf ON j.id_jafung = jf.id_jafung
                LEFT JOIN sk s ON j.id_sk = s.id_sk
                WHERE j.id_pegawai = $id_pegawai
                UNION ALL
                SELECT 'Struktural' AS jenis, j.id_j as kode_jabatan, j.jabatan as nama_jabatan, s.no_sk, s.tmt, s.tgl_sk, j.kelas_jabatan, j.nilai_jabatan
                FROM sk s LEFT JOIN kategori_sk k ON s.id_kategori_sk = k.id_kategori_sk
                LEFT JOIN jabatan j ON s.id_j = j.id_j 
                LEFT JOIN golongan g ON s.gol = g.golongan 
                WHERE k.id_kategori_sk = 10 AND s.id_pegawai = $id_pegawai) a 
                ORDER BY a.tmt";
        return $this->db->query($sql)->result();
    }

    public function get_jabatan_plt($row_number_start,$limit,$sts_aktif,$eselon,$keywordCari){
        $whereKlause = '';

        if($sts_aktif!='0'){
            if($sts_aktif==2){
                $whereKlause .= " AND jpt.status_aktif = 0";
            }else{
                $whereKlause .= " AND jpt.status_aktif = ".$sts_aktif;
            }
        }

        if($eselon!='0'){
            $whereKlause .= " AND j.eselon = '".$eselon."'";
        }

        if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")){
            $whereKlause .= " AND (p.nip_baru LIKE '%" . $keywordCari . "%' 
                                OR p.nama LIKE '%" . $keywordCari . "%' 
								OR j.jabatan LIKE '%" . $keywordCari . "%') ";
        }

	    $this->db->query("SET @row_number := $row_number_start");
	    $sql = "SELECT FCN_ROW_NUMBER() as no_urut, a.*, 
                (CASE WHEN a.last_jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN j2.jabatan ELSE jafung.nama_jafung END) ELSE
                (CASE WHEN a.last_id_j_cur IS NULL THEN (jp.nama_jfu) ELSE j2.jabatan END) END) AS jabatan_asli_saat_plt, 
                p2.nip_baru as nip_inputer, p2.nama as nama_inputer FROM
                (SELECT jpt.id_jabatan_plt, jpt.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_gelar, p.nama as nama_ori, p.status_aktif as status_aktif_pegawai, p.id_j, p.pangkat_gol, p.jenjab, jpt.last_id_j_cur, jpt.last_id_jfu_jafung_cur,
                jpt.last_jenjab, jpt.last_gol, j.jabatan as jabatan_plt, j.eselon as eselon_plt, 
                jpt.no_sk, jpt.tgl_sk, jpt.tmt, jpt.tmt_selesai, jpt.status_aktif, jpt.id_berkas_sk_plt, jpt.inputer, jpt.tgl_input, jpt.tgl_update  
                FROM jabatan_plt jpt 
                LEFT JOIN jabatan j ON jpt.id_j = j.id_j 
                LEFT JOIN pegawai p ON jpt.id_pegawai = p.id_pegawai
                WHERE jpt.id_jabatan_plt IS NOT NULL = 1 $whereKlause
                ORDER BY p.nama LIMIT $row_number_start, $limit) a 
                LEFT JOIN jabatan j2 ON a.last_id_j_cur = j2.id_j
                LEFT JOIN pegawai p2 ON a.inputer = p2.id_pegawai
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jp ON jp.kode_jabatan_jfu = a.last_id_jfu_jafung_cur AND jp.id_pegawai = a.id_pegawai
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jafung as kode_jabatan_jafung, jm.kelas_jabatan as kelas_jabatan_jafung,
                jm.nilai_jabatan as nilai_jabatan_jafung, jm.nama_jafung
                FROM (SELECT a.*, jp.id_jafung FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jafung_pegawai FROM jafung_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jafung_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jafung_pegawai jp ON a.id_jafung_pegawai = jp.id) b
                INNER JOIN jafung jm ON b.id_jafung = jm.id_jafung) jafung ON jafung.kode_jabatan_jafung = a.last_id_jfu_jafung_cur AND jafung.id_pegawai = a.id_pegawai 
                ORDER BY a.eselon_plt, a.nama_ori ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_count_jabatan_plt($sts_aktif,$eselon,$keywordCari){
        $whereKlause = '';

        if($sts_aktif!='0'){
            if($sts_aktif==2){
                $whereKlause .= " AND jpt.status_aktif = 0";
            }else{
                $whereKlause .= " AND jpt.status_aktif = ".$sts_aktif;
            }
        }

        if($eselon!='0'){
            $whereKlause .= " AND j.eselon = '".$eselon."'";
        }

        if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")){
            $whereKlause .= " AND (p.nip_baru LIKE '%" . $keywordCari . "%' 
                              OR p.nama LIKE '%" . $keywordCari . "%' 
							  OR j.jabatan LIKE '%" . $keywordCari . "%') ";
        }

        $sql = "SELECT COUNT(*) AS jumlah FROM 
                (SELECT jpt.id_jabatan_plt, jpt.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_gelar, p.nama as nama_ori, p.status_aktif as status_aktif_pegawai, p.id_j, p.pangkat_gol, p.jenjab, jpt.last_id_j_cur, jpt.last_id_jfu_jafung_cur,
                jpt.last_jenjab, jpt.last_gol, j.jabatan as jabatan_plt, j.eselon as eselon_plt, 
                jpt.no_sk, jpt.tgl_sk, jpt.tmt, jpt.tmt_selesai, jpt.status_aktif, jpt.id_berkas_sk_plt, jpt.inputer, jpt.tgl_input, jpt.tgl_update  
                FROM jabatan_plt jpt 
                LEFT JOIN jabatan j ON jpt.id_j = j.id_j 
                LEFT JOIN pegawai p ON jpt.id_pegawai = p.id_pegawai
                WHERE jpt.id_jabatan_plt IS NOT NULL = 1 $whereKlause) a ";
        $query = $this->db->query($sql);
        $jml = $query->row()->jumlah;
        return $jml;
    }

    public function get_jabatan_plh($row_number_start,$limit,$sts_aktif,$eselon,$keywordCari){
        $whereKlause = '';

        if($sts_aktif!='0'){
            if($sts_aktif==2){
                $whereKlause .= " AND plh.status_aktif = 0";
            }else{
                $whereKlause .= " AND plh.status_aktif = ".$sts_aktif;
            }
        }

        if($eselon!='0'){
            $whereKlause .= " AND j.eselon = '".$eselon."'";
        }

        if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")){
            $whereKlause .= " AND (p.nip_baru LIKE '%" . $keywordCari . "%' 
                                OR p.nama LIKE '%" . $keywordCari . "%' 
								OR j.jabatan LIKE '%" . $keywordCari . "%') ";
        }

        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT FCN_ROW_NUMBER() as no_urut, a.*, 
                (CASE WHEN a.last_jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN j2.jabatan ELSE jafung.nama_jafung END) ELSE
                (CASE WHEN a.last_id_j_cur IS NULL THEN (jp.nama_jfu) ELSE j2.jabatan END) END) AS jabatan_asli_saat_plh, 
                p2.nip_baru as nip_inputer, p2.nama as nama_inputer FROM 
                (SELECT plh.id_jabatan_plh, plh.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_gelar, p.nama as nama_ori, p.status_aktif as status_aktif_pegawai, p.id_j, p.pangkat_gol, p.jenjab, plh.last_id_j_cur, plh.last_id_jfu_jafung_cur,
                plh.last_jenjab, plh.last_gol, j.jabatan as jabatan_plh, j.eselon as eselon_plh, 
                plh.no_sk, plh.tgl_sk, plh.tmt, plh.tmt_selesai, plh.status_aktif, plh.id_berkas_sk_plh,
                plh.inputer, plh.tgl_input, plh.tgl_update 
                FROM jabatan_plh plh 
                LEFT JOIN jabatan j ON plh.id_j = j.id_j 
                LEFT JOIN pegawai p ON plh.id_pegawai = p.id_pegawai 
                WHERE plh.id_jabatan_plh IS NOT NULL = 1 $whereKlause 
                ORDER BY p.nama LIMIT $row_number_start, $limit) a 
                LEFT JOIN jabatan j2 ON a.last_id_j_cur = j2.id_j 
                LEFT JOIN pegawai p2 ON a.inputer = p2.id_pegawai
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jp ON jp.kode_jabatan_jfu = a.last_id_jfu_jafung_cur AND jp.id_pegawai = a.id_pegawai
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jafung as kode_jabatan_jafung, jm.kelas_jabatan as kelas_jabatan_jafung,
                jm.nilai_jabatan as nilai_jabatan_jafung, jm.nama_jafung
                FROM (SELECT a.*, jp.id_jafung FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jafung_pegawai FROM jafung_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jafung_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jafung_pegawai jp ON a.id_jafung_pegawai = jp.id) b
                INNER JOIN jafung jm ON b.id_jafung = jm.id_jafung) jafung ON jafung.kode_jabatan_jafung = a.last_id_jfu_jafung_cur AND jafung.id_pegawai = a.id_pegawai 
                ORDER BY a.eselon_plh, a.nama_ori ASC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_count_jabatan_plh($sts_aktif,$eselon,$keywordCari){
        $whereKlause = '';

        if($sts_aktif!='0'){
            if($sts_aktif==2){
                $whereKlause .= " AND plh.status_aktif = 0";
            }else{
                $whereKlause .= " AND plh.status_aktif = ".$sts_aktif;
            }
        }

        if($eselon!='0'){
            $whereKlause .= " AND j.eselon = '".$eselon."'";
        }

        if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")){
            $whereKlause .= " AND (p.nip_baru LIKE '%" . $keywordCari . "%' 
                                OR p.nama LIKE '%" . $keywordCari . "%' 
								OR j.jabatan LIKE '%" . $keywordCari . "%') ";
        }

        $sql = "SELECT COUNT(*) AS jumlah FROM 
	            (SELECT plh.id_jabatan_plh, plh.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_gelar, p.nama as nama_ori, p.status_aktif as status_aktif_pegawai, p.id_j, p.pangkat_gol, p.jenjab, plh.last_id_j_cur, plh.last_id_jfu_jafung_cur,
                plh.last_jenjab, plh.last_gol, j.jabatan as jabatan_plh, j.eselon as eselon_plh, 
                plh.no_sk, plh.tgl_sk, plh.tmt, plh.tmt_selesai, plh.status_aktif, plh.id_berkas_sk_plh,
                plh.inputer, plh.tgl_input, plh.tgl_update 
                FROM jabatan_plh plh 
                LEFT JOIN jabatan j ON plh.id_j = j.id_j 
                LEFT JOIN pegawai p ON plh.id_pegawai = p.id_pegawai 
                WHERE plh.id_jabatan_plh IS NOT NULL = 1 $whereKlause 
                ORDER BY p.nama) a";
        $query = $this->db->query($sql);
        $jml = $query->row()->jumlah;
        return $jml;
    }

    public function get_jabatan_plt_by_id($idj_plt){
	    $sql = "SELECT * FROM jabatan_plt WHERE id_jabatan_plt = $idj_plt";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function hapus_data_jabatan_plt(){

    }

    public function get_open_bidding($id_open_bidding=null){
        $andklausa = '';
        if (!($id_open_bidding=="0") && !($id_open_bidding=="")){
            $andklausa = " AND dpob.id_open_bidding = ".$id_open_bidding;
        }

        $sql = "SELECT dpob.id_open_bidding, dpob.keterangan, 
                DATE_FORMAT(dpob.tgl_input,  '%d/%m/%Y %H:%i:%s') AS tgl_input, 
                DATE_FORMAT(dpob.tgl_update,  '%d/%m/%Y %H:%i:%s') AS tgl_update,  
                DATE_FORMAT(dpob.tmt_open_bidding,  '%d/%m/%Y') AS tmt_open_bidding,  dpob.status_aktif,
                p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_gelar, a.jumlah as jml_pegawai,
                dpob.berkas 
                FROM draft_pelantikan_open_bidding dpob 
                LEFT JOIN pegawai p ON dpob.id_pegawai_input = p.id_pegawai
                LEFT JOIN
                (SELECT dpobd.id_open_bidding, COUNT(dpobd.id_open_bidding_detail) AS jumlah
                FROM draft_pelantikan_open_bidding_detail dpobd
                GROUP BY dpobd.id_open_bidding) a ON a.id_open_bidding = dpob.id_open_bidding
                WHERE dpob.id_open_bidding IS NOT NULL $andklausa";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_detail_open_bidding($id_open_bidding){
        $sql = "SELECT a.id_open_bidding_detail, a.id_pegawai, a.last_gol, a.last_jenjab, a.nip_baru, a.nama_gelar, a.status_aktif_pegawai, 
                (CASE WHEN a.last_jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN a.jabatan ELSE jafung.nama_jafung END) ELSE
                (CASE WHEN a.last_id_j_cur IS NULL THEN (jp.nama_jfu) ELSE a.jabatan END) END) AS jabatan_asli_saat_opbid, 
                a.eselon, uk.nama_baru as unit_saat_opbid
                FROM 
                (SELECT  dpobd.*, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_gelar, p.status_aktif as status_aktif_pegawai, j.jabatan, j.eselon  
                FROM draft_pelantikan_open_bidding_detail dpobd 
                INNER JOIN draft_pelantikan_open_bidding dpob ON dpobd.id_open_bidding = dpob.id_open_bidding 
                LEFT JOIN jabatan j ON dpobd.last_id_j_cur = j.id_j 
                LEFT JOIN pegawai p ON dpobd.id_pegawai = p.id_pegawai
                WHERE dpobd.id_open_bidding = $id_open_bidding AND dpob.status_aktif = 1 ORDER BY dpob.tmt_open_bidding DESC, p.nama) a 
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jp ON jp.kode_jabatan_jfu = a.last_id_jfu_jafung_cur AND jp.id_pegawai = a.id_pegawai
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jafung as kode_jabatan_jafung, jm.kelas_jabatan as kelas_jabatan_jafung,
                jm.nilai_jabatan as nilai_jabatan_jafung, jm.nama_jafung
                FROM (SELECT a.*, jp.id_jafung FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jafung_pegawai FROM jafung_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jafung_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jafung_pegawai jp ON a.id_jafung_pegawai = jp.id) b
                INNER JOIN jafung jm ON b.id_jafung = jm.id_jafung) jafung ON jafung.kode_jabatan_jafung = a.last_id_jfu_jafung_cur AND jafung.id_pegawai = a.id_pegawai
                LEFT JOIN unit_kerja uk ON uk.id_unit_kerja = a.last_id_unit_kerja";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function count_list_pegawai_for_open_bidding($cboJenjab, $cboGol, $txtKeyword){
        $andklausa = '';
        if (!($cboJenjab=="0") && !($cboJenjab=="")){
            $andklausa = " AND (p.jenjab = '".$cboJenjab."')".$andklausa;
        }

        if (!($cboGol=="0") && !($cboGol=="")){
            $andklausa = " AND (p.pangkat_gol = '".$cboGol."')".$andklausa;
        }

        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andklausa = " AND (p.nip_baru LIKE '%".$txtKeyword."%'
								OR p.nama LIKE '%".$txtKeyword."%'
								OR uk.nama_baru LIKE '%".$txtKeyword."%'
								OR j.jabatan LIKE '%".$txtKeyword."%')".$andklausa;
        }

        $sql = "SELECT COUNT(*) AS jumlah_all
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j 
                LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai 
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja   
                WHERE p.flag_pensiun = 0 AND (j.eselon = 'IIIA' OR (p.jenjab = 'Fungsional' AND 
                (p.pangkat_gol = 'IV/a' OR p.pangkat_gol = 'IV/b' OR p.pangkat_gol = 'IV/c' OR p.pangkat_gol = 'IV/d' OR p.pangkat_gol = 'IV/e')))  
                $andklausa";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row){
            $count = $row->jumlah_all;
        }
        return $count;
    }

    public function list_pegawai_for_open_bidding($row_number_start, $cboJenjab, $cboGol, $txtKeyword, $limit){
        $andklausa = '';
        if (!($cboJenjab=="0") && !($cboJenjab=="")){
            $andklausa = " AND (p.jenjab = '".$cboJenjab."')".$andklausa;
        }

        if (!($cboGol=="0") && !($cboGol=="")){
            $andklausa = " AND (p.pangkat_gol = '".$cboGol."')".$andklausa;
        }

        if (!(trim($txtKeyword)== "") && !(trim($txtKeyword)== "0")){
            $andklausa = " AND (p.nip_baru LIKE '%".$txtKeyword."%'
								OR p.nama LIKE '%".$txtKeyword."%'
								OR uk.nama_baru LIKE '%".$txtKeyword."%'
								OR j.jabatan LIKE '%".$txtKeyword."%')".$andklausa;
        }

        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT FCN_ROW_NUMBER() as no_urut, a.id_pegawai, a.nip_baru, a.nama_gelar, a.tgl_lahir, a.usia, a.jenjab, a.pangkat_gol, 
                (CASE WHEN a.eselon IS NULL = 1 THEN 'Staf' ELSE a.eselon END) AS eselon, 
                (CASE WHEN a.jenjab = 'Fungsional' THEN (CASE WHEN jafung.kode_jabatan_jafung IS NULL THEN a.id_j ELSE jafung.kode_jabatan_jafung END) ELSE
                (CASE WHEN a.id_j IS NULL THEN (jp.kode_jabatan_jfu) ELSE a.id_j END) END) AS kode_jabatan, 
                (CASE WHEN a.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN a.jabatan ELSE jafung.nama_jafung END) ELSE
                (CASE WHEN a.id_j IS NULL THEN (jp.nama_jfu) ELSE a.jabatan END) END) AS jabatan, 
                a.id_unit_kerja, a.unit FROM 
                (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_gelar, p.nama, p.tgl_lahir, 
                ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(p.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia, p.jenjab, p.pangkat_gol, p.id_j, 
                j.eselon, j.jabatan, uk.id_unit_kerja, uk.nama_baru as unit 
                FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j 
                LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai 
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja   
                WHERE p.flag_pensiun = 0 AND (j.eselon = 'IIIA' OR (p.jenjab = 'Fungsional' AND 
                (p.pangkat_gol = 'IV/a' OR p.pangkat_gol = 'IV/b' OR p.pangkat_gol = 'IV/c' OR p.pangkat_gol = 'IV/d' OR p.pangkat_gol = 'IV/e')))  
                $andklausa 
                ORDER BY p.jenjab DESC, j.eselon ASC, p.pangkat_gol DESC, p.nama ASC $limit) a
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jp ON jp.id_pegawai = a.id_pegawai
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jafung as kode_jabatan_jafung, jm.kelas_jabatan as kelas_jabatan_jafung,
                jm.nilai_jabatan as nilai_jabatan_jafung, jm.nama_jafung
                FROM (SELECT a.*, jp.id_jafung FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jafung_pegawai FROM jafung_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jafung_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jafung_pegawai jp ON a.id_jafung_pegawai = jp.id) b
                INNER JOIN jafung jm ON b.id_jafung = jm.id_jafung) jafung ON jafung.id_pegawai = a.id_pegawai 
                ORDER BY a.jenjab DESC, a.eselon ASC, a.pangkat_gol DESC, a.nama ASC";
        $query = $this->db->query($sql);
        return $query->result();
	}

	public function tambah_open_bidding($data){
	    //print_r($data);
        $this->db->trans_begin();
        $tmt_berlaku = explode(".", $data['tmt_berlaku']);
        $sql = "INSERT INTO draft_pelantikan_open_bidding(tmt_open_bidding,id_pegawai_input,status_aktif,keterangan)
                VALUES ('".$tmt_berlaku[2].'-'.$tmt_berlaku[1].'-'.$tmt_berlaku[0]."',".$this->session->userdata('user')->id_pegawai.
                ",".$data['ddStatusAktif'].",'".$data['keterangan']."')";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = false;
            $idopenbd = 0;
        }else{
            $idopenbd = $this->db->insert_id();
            foreach( $data['chkIdPegawaiPilih'] as $key => $n ) {
                $chkValue = explode("#", $data['chkIdPegawaiPilih'][$key]);
                $idPegawai = $chkValue[0];
                $pangkat_gol = $chkValue[1];
                $jenjab = $chkValue[2];
                $kode_jabatan = $chkValue[3];
                $id_unit_kerja = $chkValue[4];
                $eselon = $chkValue[5];
                //echo "$idPegawai#$pangkat_gol#$jenjab#$kode_jabatan#$id_unit_kerja";

                $sql = "insert into draft_pelantikan_open_bidding_detail(id_pegawai, last_gol, last_jenjab, last_id_j_cur, last_id_jfu_jafung_cur, last_id_unit_kerja, id_open_bidding)
                        values (".$idPegawai.",'".$pangkat_gol."','".$jenjab."',".($eselon=='Staf'?'NULL':$kode_jabatan).",".($eselon=='Staf'?$kode_jabatan:'NULL').",".$id_unit_kerja.",".$idopenbd.")";
                $this->db->query($sql);
            }
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $query = false;
                $idopenbd = 0;
            }else{
                $this->db->trans_commit();
                $query = true;
            }
        }
        return array(
            'query' => $query,
            'idopenbd' => $idopenbd
        );
    }

    public function hapus_detail_open_bidding($id_open_bidding_detail){
        $this->db->trans_begin();
        $sql = "delete from draft_pelantikan_open_bidding_detail where id_open_bidding_detail = $id_open_bidding_detail";
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

    public function hapus_open_bidding($id_open_bidding){
        $this->db->trans_begin();
        $sql = "delete from draft_pelantikan_open_bidding where id_open_bidding = $id_open_bidding";
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = false;
        }else{
            $sql = "delete from draft_pelantikan_open_bidding_detail where id_open_bidding = $id_open_bidding";
            $this->db->query($sql);
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $query = false;
            }else {
                $this->db->trans_commit();
                $query = true;
            }
        }
        return $query;
    }

    public function get_by_nama_pegawai($nama){
	    $sql = "SELECT a.*,
                (CASE WHEN a.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN a.jabatan ELSE jafung.nama_jafung END) ELSE
                (CASE WHEN a.id_j IS NULL THEN (jp.nama_jfu) ELSE a.jabatan END) END) AS jabatan_peg 
                FROM (SELECT p.id_pegawai, p.nip_baru, 
                CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END, p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_gelar, 
                p.pangkat_gol, p.jenjab, p.id_j, uk.nama_baru as unit, j.jabatan 
                FROM pegawai p 
                LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                LEFT JOIN jabatan j ON p.id_j = j.id_j 
                WHERE (p.nip_baru LIKE '%$nama%' OR p.nama LIKE '%$nama%') AND p.flag_pensiun = 0) a
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jfu as kode_jabatan_jfu, jm.kelas_jabatan as kelas_jabatan_jfu,
                jm.nilai_jabatan as nilai_jabatan_jfu, jm.nama_jfu
                FROM (SELECT a.*, jp.id_jfu FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jfu_pegawai FROM jfu_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jfu_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jfu_pegawai jp ON a.id_jfu_pegawai = jp.id) b
                INNER JOIN jfu_master jm ON b.id_jfu = jm.id_jfu) jp ON jp.id_pegawai = a.id_pegawai
                LEFT JOIN (
                SELECT b.id_pegawai, jm.id_jafung as kode_jabatan_jafung, jm.kelas_jabatan as kelas_jabatan_jafung,
                jm.nilai_jabatan as nilai_jabatan_jafung, jm.nama_jafung
                FROM (SELECT a.*, jp.id_jafung FROM
                (SELECT jp.id_pegawai, MAX(jp.id) as id_jafung_pegawai FROM jafung_pegawai jp,
                (SELECT id_pegawai, MAX(tmt) as max_tmt FROM jafung_pegawai WHERE tmt IS NOT NULL GROUP BY id_pegawai) x
                WHERE jp.id_pegawai = x.id_pegawai AND jp.tmt = x.max_tmt
                GROUP BY jp.id_pegawai) a
                INNER JOIN jafung_pegawai jp ON a.id_jafung_pegawai = jp.id) b
                INNER JOIN jafung jm ON b.id_jafung = jm.id_jafung) jafung ON jafung.id_pegawai = a.id_pegawai";
        $data = null;
        $query = $this->db->query($sql);
        foreach ($query->result() as $row){
            $data[] = $row;
        }
        return $data;
    }

}
