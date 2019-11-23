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
		$sql = "select p.id_pegawai
				from pegawai p
				inner join current_lokasi_kerja clk on clk.id_pegawai = p.id_pegawai
				inner join unit_kerja uk on uk.id_unit_kerja = clk.id_unit_kerja
				where p.flag_pensiun = 0
				and uk.id_unit_kerja = $opd
				order by p.nip_baru ASC
				";
			//echo $opd;	
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
		
		//$this->db->where('id_unit_kerja',$opd);
		//return $this->db->get('current_lokasi_kerja')->result();
		$sql = "select tingkat_pendidikan,jurusan_pendidikan from pendidikan where id_pegawai=$idp";
			
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
	
		$this->db->where('golongan',$gol);
		return $this->db->get('golongan')->row()->pangkat;
	}
	
	function get_pangkat_gol($id_pegawai){
		
		$row = $this->get_last_pangkat($id_pegawai);
		list($gol,$mk_tahun,$mk_bulan) = explode(',',$row->keterangan);
		
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
				and id_kategori_sk in ('5','6')
				and tmt = (select max(tmt) 
							from sk 
							where id_kategori_sk in ('5','6') 
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
	
	public function get_login($nip, $password){
		$sql = "select p.id_pegawai, 
					p.nama, p.nama_pendek, p.nip_baru, 
					p.gelar_depan, p.gelar_belakang,
					p.password,
					p.my_status,
					p.pangkat_gol,
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
				and (u.id_unit_kerja = 4789)
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
			return $row;
		}
		return $data;
	}
}
/* End of file pegawai_model.php */
/* Location: ./application/models/pegawai_model.php */
