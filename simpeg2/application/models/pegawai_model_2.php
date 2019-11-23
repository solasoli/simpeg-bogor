<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pegawai_model extends CI_Model{
		
	public $id_pegawai;
	public $nip;
	protected $masakerja;
	protected $masakerja_golongan;
	
	public function __construct(){
	
		parent::__construct(); //vicky
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
	
	function get_pegawai(){
	
		return $this->get_by_id($this->id_pegawai);
	}
	
	public function get_jabatan($id_j){
		$this->load->model('jabatan_model');
		
		//return $this->get_pegawai()->id_j;
		return $this->jabatan_model->get_jabatan($id_j);		
		
	}
	
	function get_tmt_cpns($id_pegawai){
	
		$this->db->where('id_kategori_sk',6);
		$this->db->where('id_pegawai',$id_pegawai);
		return $this->db->get('sk')->row()->tmt;
	}
	
	function hitung_masakerja($tmt_cpns, $mk_awal_thn, $mk_awal_bln){
        $this->load->library('format');
        //$obj = $this->get_pegawai();
        $tmt_cpns = explode("-",$tmt_cpns);
		$tmt_thn = $tmt_cpns[0];
		$tmt_bln = $tmt_cpns[1];
		$tmt_tgl = $tmt_cpns[2];
		
		$timestamp = mktime(0,0,0,$tmt_bln - $mk_awal_bln,$tmt_tgl,$tmt_thn - $mk_awal_thn);
		$tgl = $this->format->datediff(date('Y-m-d'),date('Y-m-d',$timestamp));
        $this->masakerja['tahun'] = $tgl['years'];
        $this->masakerja['bulan'] = $tgl['months'];
        return $this->masakerja;
        
    }
		       
    function hitung_masakerja_golongan($masakerja,$gol_awal, $gol_sekarang){
              
        if($gol_awal < 30 && $gol_sekarang > 30 ){
            $tahun = $masakerja['tahun'] - 5;
        }elseif($gol_awal < 20 && $gol_sekarang > 30 ){
            $tahun = $masakerja['tahun'] - 11;
        }elseif($gol_awal < 20 && $gol_sekarang > 20 && $gol_sekarang < 30){
            $tahun = $masakerja['tahun'] - 6;
        }else{
            $tahun = $masakerja['tahun'];
        }
        
		$this->masakerja_golongan['tahun'] = $tahun;
        $this->masakerja_golongan['bulan'] = $masakerja['bulan'];		
        return $this->masakerja_golongan;
    }
	
	function get_gaji_pokok($tahun,$gol_ruang, $mk){
		
		$this->db->where('pangkat_gol',$gol_ruang);
		$this->db->where('tahun',$tahun);
		$this->db->where('masa_kerja',$mk);
		return $this->db->get('gaji_pokok')->row();
		//return '20 juta tahun : '.$tahun;
	}   
	
	function get_list_id_pegawai_by_opd($opd){
		
		$this->db->where('id_unit_kerja',$opd);
		return $this->db->get('current_lokasi_kerja')->result();
	}
	
	/********end added**************/

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
		$query = $this->db->query("select *
                                   from pegawai p
								   inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
								   inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
                                   inner join golongan g on g.golongan = p.pangkat_gol
								   where p.id_pegawai = $id_pegawai");

		return $query->row(); /*change by vicky*/
		/*
		foreach ($query->result() as $row)
		{
			return $row;
		}
		return null;
		*/
	}
	
	public function get_by_jabatan($id_j){
		$query = $this->db->query("select *
                                   from pegawai p
                                   inner join jabatan j on j.id_j = p.id_j								   
								   where p.id_j = $id_j");

		return $query->row();
		/*foreach ($query->result() as $row)
		{
			return $row;
		}*/
		//return null;
	}
	
	public function get_login($nip, $password){
		$query = $this->db->query("select *
                                   from pegawai p
								   inner join current_lokasi_kerja c on c.id_pegawai = p.id_pegawai
								   inner join unit_kerja u on u.id_unit_kerja = c.id_unit_kerja
                                   inner join golongan g on g.golongan = p.pangkat_gol
								   where (p.nip_baru = '$nip' or p.nip_lama = '$nip') and password = '$password'");

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
}
/* End of file pegawai_model.php */
/* Location: ./application/models/pegawai_model.php */
?>
