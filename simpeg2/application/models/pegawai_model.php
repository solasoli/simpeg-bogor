<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai_model extends CI_Model{

	public $id_pegawai;
	public $nip;
	protected $masakerja;
	protected $masakerja_golongan;
	public $nip_baru;
	public $imei;
	public $password;

	public function __construct(){

		parent::__construct();
	}

	/*********added by vicky*********/

	function set_id_pegawai($id_pegawai){
		$this->id_pegawai = $id_pegawai;

	}

	/* jika yang diketahui adalah nip */
	function set_nip($nip){
		$this->nip = $nip;
		$this->db->where('nip_baru',$this->nip);
		$id = $this->db->get('pegawai')->row()->id_pegawai;
		$this->set_id_pegawai($id);
	}

	function get_api_key($pegawai = null){
		if(is_null($pegawai)){
			$challange_key = $this->nip_baru . $this->password . $this->imei . $this->config->item('api_key');
		}
		else{
			$challange_key = $pegawai->nip_baru . $pegawai->password . $pegawai->imei . $this->config->item('api_key');
		}

		$result = $this->db->query("SELECT SHA2('$challange_key', '256') as api_key");
		$row = $result->row();
		return $row->api_key;
	}

	function get_pegawai(){

		return $this->get_by_id($this->id_pegawai);
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

	function get_jabatan($id_j,$id_pegawai=NULL){
		$this->load->model('jabatan_model');

		if($id_j == NULL && $id_pegawai !== NULL){
			$jfu = $this->jabatan_model->get_jfu($id_pegawai);
			if($jfu){
				return $jfu->nama_jfu;
			}else{
				return "";
			}
		}else{
			//return $this->get_pegawai()->id_j;
			return $this->jabatan_model->get_jabatan($id_j);
		}
	}

	public function get_fullname($id_pegawai=NULL){

		if(isset($id_pegawai)){

			$id = $id_pegawai;
		}else{
			$id = $this->id_pegawai;
		}
		$this->fullname = $this->get_by_id($id)->nama;

		if($this->get_by_id($id)->gelar_depan != NULL or $this->get_by_id($id)->gelar_depan != ''){
			$this->fullname = $this->get_by_id($id)->gelar_depan.' '.$this->fullname;
		}

		if($this->get_by_id($id)->gelar_belakang != NULL or $this->get_by_id($id)->gelar_belakang != ''){
			$this->fullname = $this->fullname.', '.$this->get_by_id($id)->gelar_belakang;
		}

		return $this->fullname;
	}

	function get_tmt_cpns($id_pegawai){

		$this->db->where('id_kategori_sk',6);
		$this->db->where('id_pegawai',$id_pegawai);

		return $this->db->get('sk')->row()->tmt;


	}


	function hitung_masakerja($tmt_cpns, $mk_awal_thn, $mk_awal_bln){
         $this->load->library('format');

		list($tmt_thn,$tmt_bln,$tmt_tgl) = explode("-",$tmt_cpns);

		$timestamp = mktime(0,0,0,$tmt_bln - $mk_awal_bln,$tmt_tgl,$tmt_thn - $mk_awal_thn);
		$tgl = $this->format->datediff(date('Y-m-d'),date('Y-m-d',$timestamp));
        $this->masakerja['tahun'] = $tgl['years'];
        $this->masakerja['bulan'] = $tgl['months'];
        return $this->masakerja;

    }

	function hitung_masakerja_pegawai($id_pegawai){

		$this->db->where(array('id_pegawai'=>$id_pegawai,'id_kategori_sk'=>'6'));
		$sk_cpns = $this->db->get('sk')->row();

		$this->db->where(array('id_pegawai'=>$id_pegawai,'id_kategori_sk'=>'26'));
		if( $this->db->get('sk')){
			$sk_pmk = $this->db->get('sk')->row();
			print_r($sk_pmk);
		}else{
			echo "test";
		}
		//echo $this->db->last_query();


	}

    function hitung_masakerja_golongan($masakerja,$gol_cpns, $gol_sekarang){


       if(! preg_match("*/*",$gol_cpns)){
			echo "Gagal menghitung masa kerja golongan, harap periksa riwayat golongan cpns";
			exit;
		}

       list($gol_awal,$ruang_awal) = explode('/',$gol_cpns);

		list($gol,$ruang) = explode('/',$gol_sekarang);

		if($gol_awal == 'II' && $gol == 'IV'){
			$tahun = $masakerja['tahun'] - 5;
		}elseif($gol_awal == 'II' && $gol == 'III'){
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

	public function get_gaji_pokok($tahun,$gol_ruang, $mk){

		$this->db->where('pangkat_gol',$gol_ruang);
		$this->db->where('tahun',$tahun);
		$this->db->where('masa_kerja',$mk);
		return $this->db->get('gaji_pokok')->row();
		//return '20 juta tahun : '.$tahun;
	}

	public function get_list_id_pegawai_by_opd($opd){

		//$this->db->where('id_unit_kerja',$opd);
		//return $this->db->get('current_lokasi_kerja')->result();
		$sql = "select p.id_pegawai
				from pegawai p
				inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
				inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
				where p.flag_pensiun = 0
				and uk.id_skpd = $opd
				";
			//echo $opd;
		return $this->db->query($sql)->result();
	}

	public function get_list_id_pegawai_by_unitkerja($opd){

		//$this->db->where('id_unit_kerja',$opd);
		//return $this->db->get('current_lokasi_kerja')->result();
		/*$sql = "select a.* from (select p.id_pegawai,
						trim(IF(LENGTH(p.gelar_belakang) > 1,
							CONCAT(p.gelar_depan,
									' ',
									p.nama,
									CONCAT(', ', p.gelar_belakang)),
							CONCAT(p.gelar_depan, ' ', p.nama))) AS nama_lengkap, p.tempat_lahir, p.tgl_lahir,
						p.nip_baru,p.pangkat_gol,
						IF(p.id_j is not NULL, j.jabatan,
							IF(p.jenjab like 'Struktural', jfu_master.nama_jfu, p.jabatan)
						) as jabatan
				from pegawai p
				inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
				inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
				left join jabatan j on j.id_j = p.id_j
				left join jfu_pegawai on jfu_pegawai.id_pegawai = p.id_pegawai
				left join jfu_master on jfu_master.kode_jabatan= jfu_pegawai.kode_jabatan
				where p.flag_pensiun = 0
				and uk.id_unit_kerja = $opd
				order by j.eselon ASC) a group by a.id_pegawai
				";
			//echo $opd;*/
		$sql = "SELECT f.*, ROUND((f.nilai_rata2_capaian_skp * 0.6),2) AS '_60_capaian',
                ROUND((f.avg_perilaku * 0.4),2) AS '_40_perilaku',
                ROUND(ROUND((f.nilai_rata2_capaian_skp * 0.6),2) + ROUND((f.avg_perilaku * 0.4),2),2) AS 'nilai_skp'
                FROM
                (SELECT e.*, ROUND(((sh.orientasi_pelayanan + sh.integritas + sh.komitmen + sh.disiplin +
                sh.kerjasama + (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END))/(CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 5 ELSE 6 END)),2) as avg_perilaku,
                sh.orientasi_pelayanan, sh.integritas, sh.komitmen, sh.disiplin, sh.kerjasama,sh.kepemimpinan
                FROM
                (SELECT d.*, MAX(d.periode_akhir) AS per_akhir_skp,
                ROUND(AVG(d.jml_rata2_pencapaian),2) AS nilai_rata2_capaian_skp FROM
                (SELECT c.*, (c.rata_rata_pencapaian_skp + c.nilai_keg_tambahan) AS jml_rata2_pencapaian FROM
                (SELECT b.id_pegawai, b.nama_lengkap, b.tempat_lahir, b.tgl_lahir, b.nip_baru, b.pangkat_gol as golongan, b.pangkat, b.jabatan, (CASE WHEN b.eselon='Z' THEN 'Staf' ELSE b.eselon END) AS eselon,
                b.id_skp, b.periode_akhir, b.rata_rata_pencapaian_skp, b.jml_keg_tambahan,
                IF(b.jml_keg_tambahan > 0 AND b.jml_keg_tambahan <= 3,1,
                IF(b.jml_keg_tambahan > 3 AND b.jml_keg_tambahan <= 6,2,
                IF(b.jml_keg_tambahan > 6,3,0))) AS nilai_keg_tambahan, b.jml_keg_kreatifitas
                FROM (SELECT a.*, SUM(IF(stk.jenis = 'TAMBAHAN', 1, 0)) AS jml_keg_tambahan,
                SUM(IF(stk.jenis = 'KREATIFITAS', 1, 0)) AS jml_keg_kreatifitas FROM
                (SELECT
                 p.id_pegawai, trim(IF(LENGTH(p.gelar_belakang) > 1, CONCAT(p.gelar_depan, ' ', p.nama, CONCAT(', ', p.gelar_belakang)), CONCAT(p.gelar_depan, ' ', p.nama))) AS nama_lengkap, p.tempat_lahir, p.tgl_lahir,
                p.nip_baru, p.pangkat_gol, g.pangkat, CASE WHEN p.jenjab = 'Fungsional' THEN (CASE WHEN jafung.nama_jafung IS NULL THEN p.jabatan ELSE jafung.nama_jafung END) ELSE
                CASE WHEN p.id_j IS NULL THEN (jfu.nama_jfu) ELSE j.jabatan END END AS jabatan,
                CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon,
                sh.periode_akhir, st.id_skp, ROUND(AVG(st.nilai_capaian),2) AS rata_rata_pencapaian_skp
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
                LEFT JOIN golongan g ON p.pangkat_gol = g.golongan
                INNER JOIN skp_header sh ON p.id_pegawai = sh.id_pegawai, skp_target st
                WHERE p.flag_pensiun = 0 AND clk.id_unit_kerja = $opd AND YEAR(sh.periode_awal) =
                (SELECT YEAR(periode_awal) as tahun FROM skp_header where id_pegawai = p.id_pegawai AND orientasi_pelayanan > 0  and integritas > 0
                GROUP BY YEAR(periode_awal) ORDER BY YEAR(periode_awal) DESC LIMIT 1)
                AND YEAR(sh.periode_akhir) = (SELECT YEAR(periode_awal) as tahun FROM skp_header where id_pegawai = p.id_pegawai AND orientasi_pelayanan > 0  and integritas > 0
                GROUP BY YEAR(periode_awal) ORDER BY YEAR(periode_awal) DESC LIMIT 1)
                AND sh.id_skp = st.id_skp
                GROUP BY sh.id_pegawai, st.id_skp) a LEFT JOIN skp_tambahan_kreatifitas stk
                ON a.id_skp = stk.id_skp
                GROUP BY a.id_pegawai, a.id_skp) b) c) d
                GROUP BY d.id_pegawai) e, skp_header sh
                WHERE e.id_pegawai = sh.id_pegawai AND sh.periode_akhir = e.per_akhir_skp) f
                ORDER BY f.eselon, f.golongan DESC";

		return $this->db->query($sql)->result();
	}

	public function get_list_id_pejabat_by_unitkerja($opd){

		//$this->db->where('id_unit_kerja',$opd);
		//return $this->db->get('current_lokasi_kerja')->result();
		$sql = "select pegawai.id_pegawai,jabatan.id_j,jabatan.jabatan
				from jabatan left join pegawai on pegawai.id_j=jabatan.id_j where id_unit_kerja=$opd and tahun=2017 order by jabatan.eselon
				";
			//echo $opd;
		return $this->db->query($sql)->result();
	}

		public function get_pendidikan($idp){


		$sql = "select tingkat_pendidikan,jurusan_pendidikan from pendidikan where id_pegawai=$idp order by level_p";

			//echo $opd;
		return $this->db->query($sql)->result();
	}


	public function get_diklat($idp){


		$sql = "select nama_diklat from diklat where id_pegawai=$idp ";

			//echo $opd;
		return $this->db->query($sql)->result();
	}


	public function get_jab($idp){


		$sql = "select jabatan.jabatan from  pegawai inner join sk on sk.id_pegawai=pegawai.id_pegawai inner join jabatan on sk.id_j=jabatan.id_j where pegawai.id_pegawai=$idp and id_kategori_sk=10 group by jabatan.jabatan order by eselon";

			//echo $opd;
		return $this->db->query($sql)->result();
	}


		public function get_pim($idp){


		$sql = "select nama_diklat from diklat where id_pegawai=$idp and id_jenis_diklat = 2 ";

			//echo $opd;
		return $this->db->query($sql)->result();
	}

		public function get_diklat_list($idp){


		$sql = "select nama_diklat from diklat where id_pegawai=$idp and id_jenis_diklat <> 2 ";

			//echo $opd;
		return $this->db->query($sql)->result();
	}

	public function get_tupoksi_by_idj($idj){

		//$this->db->where('id_unit_kerja',$opd);
		//return $this->db->get('current_lokasi_kerja')->result();
		$sql = "select tugas from tupoksi where id_j=$idj
				";
			//echo $opd;
		return $this->db->query($sql)->result();
	}

	public function get_list_id_pegawai_by_opd_staff($opd=NULL){

		$sql = 'select current_lokasi_kerja.id_pegawai, pegawai.nama, pegawai.pangkat_gol
				from current_lokasi_kerja, pegawai
				where current_lokasi_kerja.id_skpd = '.$opd.'
				and pegawai.id_pegawai = current_lokasi_kerja.id_pegawai
				and pegawai.id_j is NULL
				and pegawai.jenjab like "Struktural"
				order by pegawai.pangkat_gol DESC, pegawai.nip_baru ASC
				';
		if($opd){
			$sql2 = 'select unit_kerja.*, current_lokasi_kerja.*, pegawai.id_pegawai, pegawai.nama,
					pegawai.pangkat_gol
					FROM unit_kerja, current_lokasi_kerja, pegawai
					WHERE unit_kerja.id_skpd='.$opd.'
					AND current_lokasi_kerja.id_unit_kerja = unit_kerja.id_unit_kerja
					AND pegawai.id_pegawai = current_lokasi_kerja.id_pegawai
					AND pegawai.id_j is NULL
					AND pegawai.flag_pensiun = 0
					AND pegawai.jenjab like "Struktural"
					order by unit_kerja.id_unit_kerja, pegawai.pangkat_gol DESC, pegawai.nip_baru ASC
			'; //
		}else{
			$sql2 =
				'select unit_kerja.*, current_lokasi_kerja.*, pegawai.id_pegawai, pegawai.nama,
				pegawai.pangkat_gol
				FROM unit_kerja, current_lokasi_kerja, pegawai
				WHERE current_lokasi_kerja.id_unit_kerja = unit_kerja.id_unit_kerja
				AND pegawai.id_pegawai = current_lokasi_kerja.id_pegawai
				AND pegawai.id_j is NULL
				AND pegawai.flag_pensiun = 0
				AND pegawai.jenjab like "Struktural"
				order by unit_kerja.id_unit_kerja, pegawai.pangkat_gol DESC, pegawai.nip_baru ASC
			';
		}

		$sql3 = '
				select jfu_pegawai.id_pegawai, unit_kerja.nama_baru, current_lokasi_kerja.id_pegawai, pegawai.nama, pegawai.pangkat_gol
				from jfu_pegawai, unit_kerja, current_lokasi_kerja, pegawai
				where current_lokasi_kerja.id_pegawai = jfu_pegawai.id_pegawai
				and unit_kerja.id_skpd = '.$opd.'
				and current_lokasi_kerja.id_unit_kerja = unit_kerja.id_unit_kerja
				and pegawai.id_pegawai = jfu_pegawai.id_pegawai
				order by pegawai.pangkat_gol DESC

		';
		return $this->db->query($sql2)->result();
	}

	/*
	* @return string pangkat
	* @param string golongan
	*/
	function get_pangkat_by_gol($gol){

		//print_r($gol);
		if($gol){
			$this->db->where('golongan',$gol);
			return $this->db->get('golongan')->row()->pangkat;
		}else{
			return "";
		}
	}

	function get_pangkat_gol($id_pegawai){

		$row = $this->get_last_pangkat($id_pegawai);
        $gol = $row->gol;
		$obj = new stdClass();
		$obj->gol = $gol;
		$obj->pangkat = $this->get_pangkat_by_gol($gol);
		$obj->pangkat_gol = $obj->pangkat." - ".$obj->gol;
		$obj->tmt = $row->tmt;

		return $obj;
	}

	function get_last_pangkat($id_pegawai){

		$sql = "select *
				from sk
				where id_pegawai = '".$id_pegawai."'
				and id_kategori_sk in ('5','6','7')
				and tmt = (select max(tmt)
							from sk
							where id_kategori_sk in ('5','6','7')
							and id_pegawai = '".$id_pegawai."' )";

		return $this->db->query($sql)->row();


	}


	function get_riwayat_pangkat(){

		$this->db->where('id_pegawai',$this->id_pegawai);

		return $this->db->get('view_riwayat_pangkat')->result();
	}

	/********end added**************/


	public function get_all(){
		$r = $this->db->query("SELECT *
			FROM pegawai p
			INNER JOIN current_lokasi_kerja c ON c.id_pegawai = p.id_pegawai
			INNER JOIN unit_kerja u ON u.id_unit_kerja = c.id_unit_kerja
			WHERE flag_pensiun = 0
			ORDER BY u.id_skpd, p.nama");
		return $r->result();
	}

	public function insert(){
		$this->kode_lamaran 			= $this->input->post('txtKodeLamaran');
		$this->tahun 					= $this->input->post('txtTahun');
		$this->jenis_jabatan_id			= $this->input->post('cboJenjab');
		$this->nama_jabatan 			= $this->input->post('txtNamaJabatan');
		$this->kualifikasi_pendidikan 	= $this->input->post('cboKualifikasiPendidikan')." ".$this->input->post('txtJurusan');
		$this->jumlah					= $this->input->post('txtJumlah');

		$this->db->insert('formasi', $this);
	}

	public function instan_search($keyword){
		$query = $this->db->query("select *
                                   from pegawai p
								   inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
								   inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
								   where flag_pensiun = 0 and
									(p.nama like '%$keyword%'
										or p.nip_baru = '$keyword'
									) ");

		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}

	public function get_by_id($id_pegawai){
		$query = $this->db->query("select *,
									IF(LENGTH(p.gelar_belakang) > 1,  concat(p.gelar_depan,' ',p.nama,concat(', ',p.gelar_belakang)), concat(p.gelar_depan,' ',p.nama) ) as nama_lengkap
                                   from pegawai p
								   inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
								   inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
								   left join view_pangkat_terakhir pt on pt.id_pegawai = p.id_pegawai
                                   left join golongan g on g.golongan = pt.golongan
								   where p.id_pegawai = $id_pegawai");

		foreach ($query->result() as $row)
		{
			return $row;
		}
		return null;
	}

	public function get_profil_by_id($id_pegawai){

				$sql = "select distinct p.id_pegawai,
				TRIM(IF(LENGTH(p.gelar_belakang) > 1,
						CONCAT(p.gelar_depan,
								' ',
								p.nama,
								CONCAT(', ', p.gelar_belakang)),
						CONCAT(p.gelar_depan, ' ', p.nama))) AS nama,
						concat(p.tempat_lahir,', ',date_format(p.tgl_lahir,'%d-%m-%Y')) as ttl,
						p.nip_baru as nip,
						g.pangkat,
						vpt.golongan,
						vpt.tmt as tmt_golongan,
						IF(p.id_j is not NULL, j.jabatan,
							IF(p.jenjab like 'Struktural', jfu_master.nama_jfu,  jafung_pegawai.jabatan)
						) as jabatan,
                        IF(p.id_j is not NULL, j.kelas_jabatan,
							IF(p.jenjab like 'Struktural', jfu_master.kelas_jabatan,  '')
						) as kelas_jabatan,
                        IF( j.eselon is NULL, 'NS', j.eselon) as eselonering,
                        IF(p.jenjab like 'Fungsional', 'Fungsional',  IF(p.id_j is null, 'Pelaksana', 'Struktural' )) as jenis_kepegawaian,
                        uk.nama_baru as opd
				from pegawai p
				inner join view_pangkat_terakhir vpt on p.id_pegawai = vpt.id_pegawai
				inner join golongan g on vpt.golongan = g.golongan
				inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
				inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
				left join jabatan j on j.id_j = p.id_j
				left join  (
					select distinct jfu_pegawai.id_pegawai, id_jfu, kode_jabatan, id_sk, jabatan, jfu_pegawai.tmt from jfu_pegawai
					inner join
							(select distinct j.id_pegawai, max(j.tmt) as tmt from jfu_pegawai j group by j.id_pegawai) jfu_tmt
							on jfu_tmt.id_pegawai = jfu_pegawai.id_pegawai and jfu_pegawai.tmt = jfu_tmt.tmt
						) jfu_pegawai on jfu_pegawai.id_pegawai = p.id_pegawai
				left join jfu_master on jfu_master.id_jfu= jfu_pegawai.id_jfu
				left join jafung_pegawai on jafung_pegawai.id_pegawai = p.id_pegawai

                where p.flag_pensiun = 0
				and p.id_pegawai = ".$id_pegawai;
				$query = $this->db->query($sql);

				return $query->row();


	}

	public function get_by_jabatan($id_j){
		$query = $this->db->query("select *
                                   from pegawai p
                                   inner join jabatan j on j.id_j = p.id_j
                                   inner join golongan g on g.golongan = p.pangkat_gol
								   where p.id_j = $id_j");

		foreach ($query->result() as $row)
		{
			return $row;
		}
		return null;
	}
	
	
	public function get_by_jabatan2($id_j){
		$query = $this->db->query("select p.id_pegawai,p.ponsel
                                   from pegawai p
                                   inner join jabatan j on j.id_j = p.id_j
                                   inner join golongan g on g.golongan = p.pangkat_gol
								   where p.id_j = $id_j");

		foreach ($query->result() as $row)
		{
			return $row;
		}
		return null;
	}

	public function get_login($nip, $password){
		$sql = "select p.id_pegawai,
					p.nama, p.nama_pendek, p.nip_baru,
					p.gelar_depan, p.gelar_belakang,
					p.password,
					p.my_status,
					p.pangkat_gol,
					p.id_j,
					u.id_unit_kerja,
					u.nama_baru,
					g.pangkat,
					u.id_skpd

			   from pegawai p
			   inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
			   inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
			   inner join golongan g on g.golongan = p.pangkat_gol
			   where
				(p.nip_baru = '$nip' or p.nip_lama = '$nip')
				and password = '$password'
				and (u.id_unit_kerja = 4789 or u.id_unit_kerja = 5298)
				";

		//print_r( $sql);
		//die;
		$query = $this->db->query($sql);


		foreach ($query->result() as $row)
		{
			return $row;
		}
		return null;
	}

	public function fetch_all(){
		$query = $this->db->query("select *
                                   from formasi f
                                   inner join ref_jabatan j on j.kode = f.kode_jabatan");

		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}

	public function summary(){
		$query = $this->db->query("select kode_formasi, kualifikasi_pendidikan, kuota,
			SUM(IF( memenuhi_syarat = 1 ,jumlah,0)) AS 'ms',
			SUM(IF( memenuhi_syarat = 0 ,jumlah,0)) AS 'tms',

			SUM( jumlah ) AS jumlah
			from(
				select kode_formasi, kualifikasi_pendidikan, f.jumlah as kuota, memenuhi_syarat, count(*) as jumlah
				from pelamar p
				inner join formasi f on f.kode_lamaran = p.kode_formasi
				group by kode_formasi, memenuhi_syarat
			) as p
			group by kode_formasi");

		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}


	public function get_by_nama($nama){
		$query = $this->db->query("select *
			from pegawai p
			inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
			inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
			left join pendidikan_terakhir pend on pend.id_pegawai = p.id_pegawai
			left join jabatan j on j.id_j = p.id_j
			left join (
				SELECT s.id_pegawai, date_format(s.tmt, '%d-%m-%Y') as tmt_jabatan
				FROM pegawai p
				INNER JOIN sk s ON s.id_pegawai = p.id_pegawai
				WHERE id_kategori_sk = 10
				AND s.id_j = p.id_j
				GROUP BY s.id_pegawai
				ORDER BY s.tmt DESC
			) as s_jab on s_jab.id_pegawai = p.id_pegawai
			left join(
				SELECT s.id_pegawai, date_format(s.tmt, '%d-%m-%Y') as tmt
				FROM pegawai p
				INNER JOIN sk s ON s.id_pegawai = p.id_pegawai
				WHERE id_kategori_sk =5
				AND LEFT( s.keterangan, LOCATE(  '/', s.keterangan ) +1 ) = p.pangkat_gol
				GROUP BY s.id_pegawai
			) as s on s.id_pegawai = p.id_pegawai
			where nama like '%$nama%' and flag_pensiun = 0
			order by nama asc");

		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}

	public function get_nama_nip($nama){
		$query = $this->db->query("select nama,nip_baru
			from pegawai where nama like '%$nama%' and flag_pensiun = 0
			order by nama asc");

		foreach ($query->result() as $row)
		{
			$data[] = $row;
		}
		return $data;
	}

	public function get_by_nip($nip){
		$query = $this->db->query("select
			p.nama, p.nip_baru, p.pangkat_gol, u.nama_baru as unit_kerja, p.jabatan, p.ponsel, p.password, p.imei
			from pegawai p
			inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
			inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
			where nip_baru like '$nip' and flag_pensiun = 0
			order by nama asc");

		foreach ($query->result() as $row)
		{
            $data[] = $row;
		}
		return $data;
	}

	public function get_last_skp($id_pegawai){
        $tahun_penilaian_sql = "select YEAR(periode_awal) as tahun, count(*) as jumlah_skp
        from skp_header where id_pegawai = ".$id_pegawai." AND
        orientasi_pelayanan > 0  and integritas > 0
        group by YEAR(periode_awal) order by YEAR(periode_awal) DESC LIMIT 1;";
        $query = $this->db->query($tahun_penilaian_sql);
        $rowcount = $query->num_rows();
        if($rowcount > 0) {
            foreach ($query->result() as $data) {
                $tahun = $data->tahun;
            }
        }else{
            $tahun = 0;
        }
        $sql = "select s.*, YEAR(s.periode_awal) AS thn_skp,
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
        $query = $this->db->query($sql);
        return $query;
    }

    public function get_nilai_capaian_rata2($id_pegawai, $tahun){

		$skps = $this->db->query("select id_skp from skp_header
				where periode_awal like '".$tahun."%' and id_pegawai = '".$id_pegawai."'");

		$nilai_capaian = array();
        foreach ($skps->result() as $skp) {
            $nilai_capaian[] = $this->get_nilai_capaian($skp->id_skp);
        }

		if(count($nilai_capaian) == 0){
			return 0;
		}else{
			return array_sum($nilai_capaian) / count($nilai_capaian);
		}

	}

    public function get_nilai_capaian($idskp){

        $tambahan = $this->get_nilai_tambahan($idskp,'TAMBAHAN');

        $query = "select round(sum(nilai_capaian),2) as nilai_skp,
				round(avg(nilai_capaian),2) + ".$tambahan." as rata2_nilai_skp
				from skp_target where id_skp = ".$idskp ;
        //echo $query;
        $result = $this->db->query($query);
        foreach ($result->result() as $data) {
            $a = $data->rata2_nilai_skp;
        }
        return $a;

    }

    public function get_nilai_tambahan($idskp,$jenistambahan){

        $query = "select count(*) as jumlah from skp_tambahan_kreatifitas where id_skp = '".$idskp."' and jenis = '".$jenistambahan."'";
        $result = $this->db->query($query);

        foreach ($result->result() as $data) {
            $jumlah = $data->jumlah;
        }

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

    public function skp_pegawai($id_pegawai){
	    $sql = "
                SELECT f.*, ROUND((f.nilai_rata2_capaian_skp * 0.6),2) AS '60%_capaian',
                ROUND((f.avg_perilaku * 0.4),2) AS '40%_perilaku',
                ROUND(ROUND((f.nilai_rata2_capaian_skp * 0.6),2) + ROUND((f.avg_perilaku * 0.4),2),2) AS 'nilai_skp'
                FROM
                (SELECT e.*, ROUND(((sh.orientasi_pelayanan + sh.integritas + sh.komitmen + sh.disiplin +
                sh.kerjasama + (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END))/6),2) as avg_perilaku,
                sh.orientasi_pelayanan, sh.integritas, sh.komitmen, sh.disiplin, sh.kerjasama,sh.kepemimpinan
                FROM
                (SELECT d.id_pegawai, MAX(d.periode_akhir) AS per_akhir_skp,
                AVG(d.jml_rata2_pencapaian) AS nilai_rata2_capaian_skp FROM
                (SELECT c.*, (c.rata_rata_pencapaian_skp + c.nilai_keg_tambahan) AS jml_rata2_pencapaian FROM
                (SELECT b.id_pegawai, b.id_skp, b.periode_akhir, b.rata_rata_pencapaian_skp, b.jml_keg_tambahan,
                IF(b.jml_keg_tambahan > 0 AND b.jml_keg_tambahan <= 3,1,
                IF(b.jml_keg_tambahan > 3 AND b.jml_keg_tambahan <= 6,2,
                IF(b.jml_keg_tambahan > 6,3,0))) AS nilai_keg_tambahan, b.jml_keg_kreatifitas
                FROM (SELECT a.*, SUM(IF(stk.jenis = 'TAMBAHAN', 1, 0)) AS jml_keg_tambahan,
                SUM(IF(stk.jenis = 'KREATIFITAS', 1, 0)) AS jml_keg_kreatifitas FROM
                (SELECT sh.id_pegawai, sh.periode_akhir, st.id_skp, ROUND(AVG(st.nilai_capaian),2) AS rata_rata_pencapaian_skp
                FROM skp_header sh, skp_target st WHERE sh.id_pegawai = $id_pegawai /*AND YEAR(sh.periode_awal) = 2018
                /*AND YEAR(sh.periode_akhir) = 2018 AND sh.status_pengajuan = 6*/ AND sh.id_skp = st.id_skp AND
                sh.orientasi_pelayanan > 0 AND sh.integritas > 0
                GROUP BY sh.id_pegawai, st.id_skp) a LEFT JOIN skp_tambahan_kreatifitas stk
                ON a.id_skp = stk.id_skp
                GROUP BY a.id_pegawai, a.id_skp) b) c) d
                GROUP BY d.id_pegawai) e, skp_header sh
                WHERE e.id_pegawai = sh.id_pegawai AND sh.periode_akhir = e.per_akhir_skp) f";
        $query = $this->db->query($sql);
        return $query;

    }

    public function drh_diklat($id_pegawai){
        $sql = "SELECT dj.jenis_diklat, d.tgl_diklat, d.nama_diklat, d.jml_jam_diklat, d.penyelenggara_diklat, d.no_sttpl
                FROM diklat d LEFT JOIN diklat_jenis dj ON d.id_jenis_diklat = dj.id_jenis_diklat
                WHERE id_pegawai = $id_pegawai";
        return $this->db->query($sql)->result();
    }

    public function riwayat_skp($id_pegawai){
	    $sql = "SELECT d.*,
                ROUND((d.jml_rata2_pencapaian * 0.6),2) AS '60%_capaian',
                ROUND((d.avg_perilaku * 0.4),2) AS '40%_perilaku',
                ROUND(ROUND((d.jml_rata2_pencapaian * 0.6),2) + ROUND((d.avg_perilaku * 0.4),2),2) AS 'nilai_skp'
                FROM
                (SELECT c.*, (c.rata_rata_pencapaian_skp + c.nilai_keg_tambahan) AS jml_rata2_pencapaian,
                ROUND(((sh.orientasi_pelayanan + sh.integritas + sh.komitmen + sh.disiplin +
                sh.kerjasama + (CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 0 ELSE sh.kepemimpinan END))/(CASE WHEN sh.kepemimpinan IS NULL = 1 THEN 5 ELSE 6 END)),2) as avg_perilaku,
                sh.orientasi_pelayanan, sh.integritas, sh.komitmen, sh.disiplin, sh.kerjasama,sh.kepemimpinan
                FROM
                (SELECT b.id_pegawai, b.id_skp, b.tahun, b.periode_awal_ori, b.periode_awal, b.periode_akhir, b.jabatan_pegawai, b.unit_kerja, b.status,
                b.rata_rata_pencapaian_skp, b.jml_keg_tambahan,
                IF(b.jml_keg_tambahan > 0 AND b.jml_keg_tambahan <= 3,1,
                IF(b.jml_keg_tambahan > 3 AND b.jml_keg_tambahan <= 6,2,
                IF(b.jml_keg_tambahan > 6,3,0))) AS nilai_keg_tambahan, b.jml_keg_kreatifitas
                FROM (SELECT a.*, SUM(IF(stk.jenis = 'TAMBAHAN', 1, 0)) AS jml_keg_tambahan,
                SUM(IF(stk.jenis = 'KREATIFITAS', 1, 0)) AS jml_keg_kreatifitas FROM
                (SELECT sh.id_pegawai, st.id_skp, sh.periode_awal AS periode_awal_ori,
                YEAR(sh.periode_awal) as tahun, DATE_FORMAT(sh.periode_awal, '%d-%m-%Y') AS periode_awal,
                DATE_FORMAT(sh.periode_akhir, '%d-%m-%Y') AS periode_akhir, sh.jabatan_pegawai,
                uk.nama_baru as unit_kerja, sst.status,
                ROUND(AVG(st.nilai_capaian),2) AS rata_rata_pencapaian_skp
                FROM skp_header sh
                INNER JOIN skp_status sst ON sh.status_pengajuan = sst.kode_status
                LEFT JOIN unit_kerja uk ON sh.id_unit_kerja_pegawai = uk.id_unit_kerja, skp_target st
                WHERE sh.id_pegawai = $id_pegawai AND sh.id_skp = st.id_skp
                GROUP BY sh.id_pegawai, st.id_skp) a LEFT JOIN skp_tambahan_kreatifitas stk
                ON a.id_skp = stk.id_skp
                GROUP BY a.id_pegawai, a.id_skp) b) c, skp_header sh
                WHERE c.id_pegawai = sh.id_pegawai AND sh.id_skp = c.id_skp) d
                ORDER BY d.periode_awal_ori";
        return $this->db->query($sql)->result();
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

    public function std_kompetensi_by_level($level){
	    $sql = "SELECT kd.*, kj.id_kmp_jenis, kj.kode_kmp, kj.nama_jenis_kmp, kj.definisi_kmp, km.id_kmp_level, km.deskripsi_kmp,
                GROUP_CONCAT(km.id_kmp_level,'.',ki.indikator_kmp ORDER BY ki.indikator_kmp ASC SEPARATOR '<br>') AS indikator_kmp
                FROM kmp_dasar kd LEFT JOIN kmp_jenis kj ON kd.id_kmp = kj.id_kmp
                LEFT JOIN kmp_master km ON kj.id_kmp_jenis = km.id_kmp_jenis
                LEFT JOIN
                (
                    SELECT kmp_indikator.id_kmp_master, CONCAT(kmp_indikator.rank,') ',kmp_indikator.indikator_kmp) AS indikator_kmp FROM
                    (SELECT
                    id_kmp_master, CASE id_kmp_master WHEN @curIdKmpI THEN @curRow := @curRow + 1 ELSE @curRow := 1 END AS rank, kmpi.indikator_kmp,
                    @curIdKmpI := id_kmp_master AS idkmpm FROM
                    (SELECT ki.id_kmp_indikator, ki.indikator_kmp, ki.id_kmp_master
                    FROM kmp_indikator ki) kmpi
                    JOIN (SELECT @curRow := 0, @curIdKmpI := 0) r
                    ORDER BY id_kmp_master, kmpi.id_kmp_indikator ASC) kmp_indikator
                ) ki ON km.id_kmp_master = ki.id_kmp_master
                WHERE km.id_kmp_level = $level OR km.id_kmp_level IS NULL
                GROUP BY kd.id_kmp, kj.id_kmp_jenis";
        return $this->db->query($sql)->result();
    }

    public function level_kompetensi($level){
	    $sql = "SELECT kl.*, CONCAT('<ol>', GROUP_CONCAT('<li>', klk.kriteria_level ORDER BY klk.kriteria_level ASC SEPARATOR '</li>'), '</ol>') AS kriteria_level
                FROM kmp_level kl INNER JOIN
                (
                    SELECT kmp_level_k.id_kmp_level, CONCAT(/*kmp_level_k.rank,') ',*/ kmp_level_k.kriteria_level) AS kriteria_level FROM
                    (SELECT
                    id_kmp_level, CASE id_kmp_level WHEN @curIdKmpI THEN @curRow := @curRow + 1 ELSE @curRow := 1 END AS rank, klk.kriteria_level,
                    @curIdKmpI := id_kmp_level AS idkmpm FROM
                    (SELECT klk.id_kmp_level, klk.kriteria_level, klk.id_kriteria_level
                    FROM kmp_level_kriteria klk) klk
                    JOIN (SELECT @curRow := 0, @curIdKmpI := 0) r
                    ORDER BY id_kmp_level, klk.id_kriteria_level ASC) kmp_level_k
                ) klk ON kl.id_kmp_level = klk.id_kmp_level
                WHERE kl.id_kmp_level = $level
                GROUP BY kl.id_kmp_level";
        return $this->db->query($sql)->result();
    }

}
/* End of file pegawai_model.php */
/* Location: ./application/models/pegawai_model.php */
