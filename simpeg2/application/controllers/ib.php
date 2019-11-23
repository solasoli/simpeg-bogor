	<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ib extends CI_Controller {

	public function __construct(){
	
		parent::__construct();
				
		//authenticate($this->session->userdata('user'), "PEGAWAI_VIEW");	
		$this->load->model('pegawai_model','pegawai');
		$this->load->model('ijinbelajar_model','ibe');
		$this->load->model('jabatan_model','jabatan');
		$this->ijin_belajar = 'ibe';
	}
	
	public function index($status = 5)
	{	
		if(is_null($status)){			
			$data['daftar'] = $this->ibe->daftarib();
		}else{			
			$data['daftar'] = $this->ibe->daftarib($status);
		}
		$i = 0;
		
        foreach ($data['daftar']  as $p)
		{
			$data['daftar'][$i]->jp = $this->ibe->pen_akhir($p->idp)->jp; 	
			$data['daftar'][$i]->tp = $this->ibe->pen_akhir($p->idp)->tp; 	
			$data['daftar'][$i]->jp2 = $this->ibe->pen_lanjut($p->idp)->jurusan; 
			$data['daftar'][$i]->akre = $this->ibe->pen_lanjut($p->idp)->akreditasi; 	
			$data['daftar'][$i]->ip2 = $this->ibe->pen_lanjut($p->idp)->institusi_lanjutan;
			$data['daftar'][$i]->jfu = $this->jabatan->get_jabatan_pegawai($p->idp);
			$data['daftar'][$i]->nosurat =$this->ibe->pen_lanjut($p->idp)->no_surat_skpd;
			
			if($this->ibe->pen_lanjut($p->idp)->approve==5){
				$status="Diajukan";
				$data['daftar'][$i]->kelas = "bg-olive fg-white";
			}else if($this->ibe->pen_lanjut($p->idp)->approve==1){
				$status="Disetujui";
				$data['daftar'][$i]->kelas = "bg-cyan";
			}else if($this->ibe->pen_lanjut($p->idp)->approve==2){
				$status="Diproses";
				$data['daftar'][$i]->kelas = "bg-lime";
			}else if($this->ibe->pen_lanjut($p->idp)->approve==3){
				$status="Ditolak";
				$data['daftar'][$i]->kelas = "bg-crimson";
			}else if($this->ibe->pen_lanjut($p->idp)->approve==4) {
                $status = "Selesai";
                $data['daftar'][$i]->kelas = "";
            }elseif($this->ibe->pen_lanjut($p->idp)->approve==6){
                $status="Sudah Upload";
                $data['daftar'][$i]->kelas = "bg-violet";
            }elseif($this->ibe->pen_lanjut($p->idp)->approve==7){
                $status="Perbaiki";
                $data['daftar'][$i]->kelas = "bg-olive fg-yellow";
			}
			
			
			$data['daftar'][$i]->status = $status;
			$tp = $this->ibe->pen_lanjut($p->idp)->tingkat_pendidikan; 	
			$tingkat = array("tingkat","S3","S2","S1","D3","D2","D1","SMA","SMP");
			$data['daftar'][$i]->tp2 = $tingkat[$tp];
            $data['daftar'][$i]->tmt = $this->ibe->tmtsk($p->idp,$p->pangkat_gol);
            $data['daftar'][$i]->tgl_pengajuan = $this->ibe->pen_lanjut($p->idp)->tgl_pengajuan;
			$i++;
			}
							
	
		$this->load->view('layout/header');	
		$this->load->view('ijinbelajar/list',$data);
		$this->load->view('layout/footer');
	}	
	
	
	
	public function daftar()
	{
		$data['dari']=$this->input->post('txtTmtAwal');
		$data['sampai']=$this->input->post('txtTmtSelesai');
		
		if(strlen($data['dari'])>5 and strlen($data['sampai'])>5)
		{
		$data['list'] = $this->ibe->list_pengajuan($data['dari'],$data['sampai']);
	  $i = 0;
            foreach ($data['list']  as $p)
			{
			$data['list'][$i]->jp2 = $this->ibe->pen_lanjut($p->idp)->jurusan; 	
			$data['list'][$i]->ip2 = $this->ibe->pen_lanjut($p->idp)->institusi_lanjutan;
			$tp = $this->ibe->pen_lanjut($p->idp)->tingkat_pendidikan; 	
			$tingkat = array("tingkat","S3","S2","S1","D3","D2","D1","SMA","SMP");
			$program = array("tingkat","Doktor","Pasca Sarjana","Sarjana","Diploma","Diploma","Diploma","SMA","SMP");
			$data['list'][$i]->tp2 = $tingkat[$tp];
			$data['list'][$i]->program = $program[$tp];
    		$i++;
			}
				
		}
		
		$this->load->view('layout/header');
		$this->load->view('ijinbelajar/daftar',$data);	
		$this->load->view('layout/footer');
	}
	
	
	public function setuju()
	{
		$data['dari']=$this->input->post('txtTmtAwal');
		$data['sampai']=$this->input->post('txtTmtSelesai');
		
		if(strlen($data['dari'])>5 and strlen($data['sampai'])>5)
		{
			$data['daftar'] = $this->ibe->list_new_disetujui($data['dari'],$data['sampai']);
			$i = 0;
            foreach ($data['daftar']  as $p)
			{
			$data['daftar'][$i]->jp = $this->ibe->pen_akhir($p->idp)->jp; 	
			$data['daftar'][$i]->tp = $this->ibe->pen_akhir($p->idp)->tp; 	
			$data['daftar'][$i]->jp2 = $this->ibe->pen_lanjut($p->idp)->jurusan; 
			$data['daftar'][$i]->akre = $this->ibe->pen_lanjut($p->idp)->akreditasi; 	
			$data['daftar'][$i]->ip2 = $this->ibe->pen_lanjut($p->idp)->institusi_lanjutan;
			$data['daftar'][$i]->jfu = $this->jabatan->get_jabatan_pegawai($p->idp);
			$data['daftar'][$i]->nosurat =$this->ibe->pen_lanjut($p->idp)->no_surat_skpd;
	
			$tp = $this->ibe->pen_lanjut($p->idp)->tingkat_pendidikan; 	
			$tingkat = array("tingkat","S3","S2","S1","D3","D2","D1","SMA","SMP");
			$data['daftar'][$i]->tp2 = $tingkat[$tp];
            $data['daftar'][$i]->tmt = $this->ibe->tmtsk($p->idp,$p->pangkat_gol);
			$i++;
    		
			}
				
		}
		
		$this->load->view('layout/header');
		$this->load->view('ijinbelajar/daftar_setuju',$data);	
		$this->load->view('layout/footer');
	}
	
	public function cetak_setuju()
	{
		$data['dari']=$this->input->post('dari');
		$data['sampai']=$this->input->post('sampai');
		
		if(strlen($data['dari'])>5 and strlen($data['sampai'])>5)
		{
		$data['daftar'] = $this->ibe->list_new_disetujui($data['dari'],$data['sampai']);
	  $i = 0;
            foreach ($data['daftar']  as $p)
			{
			$data['daftar'][$i]->jp = $this->ibe->pen_akhir($p->idp)->jp; 	
			$data['daftar'][$i]->tp = $this->ibe->pen_akhir($p->idp)->tp; 	
			$data['daftar'][$i]->jp2 = $this->ibe->pen_lanjut($p->idp)->jurusan; 
			$data['daftar'][$i]->akre = $this->ibe->pen_lanjut($p->idp)->akreditasi; 	
			$data['daftar'][$i]->ip2 = $this->ibe->pen_lanjut($p->idp)->institusi_lanjutan;
			$data['daftar'][$i]->jfu = $this->jabatan->get_jabatan_pegawai($p->idp);
			$data['daftar'][$i]->nosurat =$this->ibe->pen_lanjut($p->idp)->no_surat_skpd;
			if($this->ibe->pen_lanjut($p->idp)->approve==5)
			$status="Diajukan";
			else if($this->ibe->pen_lanjut($p->idp)->approve==1)
			$status="Disetujui";
			else if($this->ibe->pen_lanjut($p->idp)->approve==2)
			$status="Diproses";
			$data['daftar'][$i]->status = $status;
			$tp = $this->ibe->pen_lanjut($p->idp)->tingkat_pendidikan; 	
			$tingkat = array("tingkat","S3","S2","S1","D3","D2","D1","SMA","SMP");
			$data['daftar'][$i]->tp2 = $tingkat[$tp];
            $data['daftar'][$i]->tmt = $this->ibe->tmtsk($p->idp,$p->pangkat_gol);
			$i++;
			}
				
		}
		$data['kabid']=$this->ibe->kabid_mutasi();
		$this->load->view('ijinbelajar/cetak_pengajuan',$data);	
	}
	
	public function pengajuan()
	{
		$data['dari']=$this->input->post('txtTmtAwal');
		$data['sampai']=$this->input->post('txtTmtSelesai');
		
		if(strlen($data['dari'])>5 and strlen($data['sampai'])>5)
		{
		$data['daftar'] = $this->ibe->list_new_ajuan($data['dari'],$data['sampai']);
	  $i = 0;
            foreach ($data['daftar']  as $p)
			{
			$data['daftar'][$i]->jp = $this->ibe->pen_akhir($p->idp)->jp; 	
			$data['daftar'][$i]->tp = $this->ibe->pen_akhir($p->idp)->tp; 	
			$data['daftar'][$i]->jp2 = $this->ibe->pen_lanjut($p->idp)->jurusan; 
			$data['daftar'][$i]->akre = $this->ibe->pen_lanjut($p->idp)->akreditasi; 	
			$data['daftar'][$i]->ta = $this->ibe->pen_lanjut($p->idp)->tgl_approve; 	
			$data['daftar'][$i]->ip2 = $this->ibe->pen_lanjut($p->idp)->institusi_lanjutan;
			$data['daftar'][$i]->jfu = $this->jabatan->get_jabatan_pegawai($p->idp);
			$data['daftar'][$i]->nosurat =$this->ibe->pen_lanjut($p->idp)->no_surat_skpd;
			if($this->ibe->pen_lanjut($p->idp)->approve==5)
			$status="Diajukan";
			else if($this->ibe->pen_lanjut($p->idp)->approve==1)
			$status="Disetujui";
			else if($this->ibe->pen_lanjut($p->idp)->approve==2)
			$status="Diproses";
			
		
			
			$data['daftar'][$i]->status = $status;
			$tp = $this->ibe->pen_lanjut($p->idp)->tingkat_pendidikan; 	
			$tingkat = array("tingkat","S3","S2","S1","D3","D2","D1","SMA","SMP");
			$data['daftar'][$i]->tp2 = $tingkat[$tp];
            $data['daftar'][$i]->tmt = $this->ibe->tmtsk($p->idp,$p->pangkat_gol);
			$i++;
    		
			}
				
		}
		
		$this->load->view('layout/header');
		$this->load->view('ijinbelajar/daftar_ajuan',$data);	
		$this->load->view('layout/footer');
	}
	
	
	public function cetak_pengajuan()
	{
		$data['dari']=$this->input->post('dari');
		$data['sampai']=$this->input->post('sampai');
		
		if(strlen($data['dari'])>5 and strlen($data['sampai'])>5)
		{
		$data['daftar'] = $this->ibe->list_new_ajuan($data['dari'],$data['sampai']);
	  $i = 0;
            foreach ($data['daftar']  as $p)
			{
			$data['daftar'][$i]->jp = $this->ibe->pen_akhir($p->idp)->jp; 	
			$data['daftar'][$i]->tp = $this->ibe->pen_akhir($p->idp)->tp; 	
			$data['daftar'][$i]->jp2 = $this->ibe->pen_lanjut($p->idp)->jurusan; 
			$data['daftar'][$i]->akre = $this->ibe->pen_lanjut($p->idp)->akreditasi; 	
			$data['daftar'][$i]->ip2 = $this->ibe->pen_lanjut($p->idp)->institusi_lanjutan;
			$data['daftar'][$i]->jfu = $this->jabatan->get_jabatan_pegawai($p->idp);
			$data['daftar'][$i]->nosurat =$this->ibe->pen_lanjut($p->idp)->no_surat_skpd;
			if($this->ibe->pen_lanjut($p->idp)->approve==5)
			$status="Diajukan";
			else if($this->ibe->pen_lanjut($p->idp)->approve==1)
			$status="Disetujui";
			else if($this->ibe->pen_lanjut($p->idp)->approve==2)
			$status="Diproses";
			$data['daftar'][$i]->status = $status;
			$tp = $this->ibe->pen_lanjut($p->idp)->tingkat_pendidikan; 	
			$tingkat = array("tingkat","S3","S2","S1","D3","D2","D1","SMA","SMP");
			$data['daftar'][$i]->tp2 = $tingkat[$tp];
            $data['daftar'][$i]->tmt = $this->ibe->tmtsk($p->idp,$p->pangkat_gol);
			$i++;
			}
				
		}
		$data['kabid']=$this->ibe->kabid_mutasi();
		$this->load->view('ijinbelajar/cetak_pengajuan',$data);	
	}
	
	public function cetak_daftar()
	{
		$data['dari']=$this->input->post('dari');
		$data['sampai']=$this->input->post('sampai');
		
		if(strlen($data['dari'])>5 and strlen($data['sampai'])>5)
		{
		$data['list'] = $this->ibe->list_pengajuan($data['dari'],$data['sampai']);
	  $i = 0;
            foreach ($data['list']  as $p)
			{
			$data['list'][$i]->jp2 = $this->ibe->pen_lanjut($p->idp)->jurusan; 	
			$data['list'][$i]->ip2 = $this->ibe->pen_lanjut($p->idp)->institusi_lanjutan;
			$tp = $this->ibe->pen_lanjut($p->idp)->tingkat_pendidikan; 	
			$tingkat = array("tingkat","S3","S2","S1","D3","D2","D1","SMA","SMP");
			$program = array("tingkat","Doktor","Pasca Sarjana","Sarjana","Diploma","Diploma","Diploma","SMA","SMP");
			$data['list'][$i]->tp2 = $tingkat[$tp];
			$data['list'][$i]->program = $program[$tp];
    		$i++;
			}
				
		}
		$data['kabid']=$this->ibe->kabid_mutasi();
		$this->load->view('ijinbelajar/cetak_daftar',$data);	
	}
	
	public function tutorial()
	{
		
		$this->load->view('layout/header');	
		$this->load->view('ijinbelajar/tutorial');
		$this->load->view('layout/footer');
	}
	
	public function alur()
	{
		
		$this->load->view('layout/header');	
		$this->load->view('ijinbelajar/alur');
		$this->load->view('layout/footer');
	}
	
	public function pegawai_search()
	{
		$term = $this->input->get('query',TRUE);
		$names = $this->pegawai->nama_nip($term);
		echo json_encode($names);
		
		
	}
	
	public function tolak()
	{
		$idp= $this->input->post('idp');
		$ket= $this->input->post('ket');
		$tp = $this->get_ib($idp)-1;
		$this->ibe->tolak_ib($idp,$ket,$tp);	
		redirect(base_url()."ib");
	}
	
	public function proses()
	{
		$idp= $this->input->post('idp');
		$tp = $this->get_ib($idp)-1;
		$this->ibe->apr($idp,$tp);	
		redirect(base_url()."ib");
	}
	
	public function jadi($idp)
	{
		$tp = $this->get_ib($idp)-1;
		$this->ibe->ambil($idp,$tp);	
		redirect(base_url()."ib");
	}

    public function proses_kembali($idp)
    {
        $tp = $this->get_ib($idp)-1;
        $this->ibe->proses_kembali($idp,$tp);
        redirect(base_url()."ib");
    }

    public function perbaiki($idp)
    {
        $tp = $this->get_ib($idp)-1;
        $this->ibe->perbaiki($idp,$tp);
        redirect(base_url()."ib");
    }
	
	public function bos($skpd)
	{
	return $this->ibe->get_bos($skpd); 	
	}
	
	public function cetak()
	{
			$idp = $this->input->post('idp');
			$data['no'] = $this->input->post('nosurat');
			$data['detail'] = $this->ibe->get_detail($idp);
			
			
			if(is_null($data['detail']->id_j) && $data['detail']->jenjab == 'Struktural'){
				if($data['detail']->nama_jfu == '' ){
					
					$data['detail']->nama_jfu = 'Fungsional Umum pada '.$data['detail']->nama_skpd;
				}else{
					$data['detail']->nama_jfu = $data['detail']->nama_jfu.' pada '.$data['detail']->nama_skpd;
				} 
			}elseif(is_null($data['detail']->id_j) && $data['detail']->jenjab == 'Fungsional'){
				
				$data['detail']->nama_jfu = $data['detail']->jabatan2.' '.$data['detail']->nama_skpd;
			}
			
			$data['bos'] = $this->bos($this->ibe->get_detail($idp)->skpd)->jabatan;
			$this->ibe->no_surat_skpd( $this->input->post('nosurat'),$this->ibe->get_ibe($idp)->id);
			
			
			$this->load->view('ijinbelajar/surat',$data);
	}
	
	
		public function acc($idp)
	{
		$tp = $this->get_ib($idp)-1;
		$this->ibe->acc($idp,$tp);	
		redirect(base_url()."ib");
	}
	
	
	public function get_pangkat($idp)
	{
		return $this->ibe->get_pangkat($idp)->pangkat_gol;		
	}
	
	public function get_ib($idp)
	{
		$tp = $this->ibe->get_ibe($idp)->tingkat_pendidikan;
		$tp++;
		return $tp;		
	}
	
	
	public function cekspuk()
	{
		
		$idp= $this->input->post('idp');
		
		$ket = $this->get_ib($idp);
		$ket--;
		$tp=array('tp',"S3","S2","S1","D3","D2","D1","SMA","SMP");
		
		if($this->ibe->cekantar($idp,$tp[$ket]))
		echo basename($this->ibe->cekantar($idp,$tp[$ket]));
		else
		echo "none";
				
	}
	
		public function cekspal()
	{
		
		$idp= $this->input->post('idp');
		
		$ket = $this->get_ib($idp);
		$ket--;
		$tp=array('tp',"S3","S2","S1","D3","D2","D1","SMA","SMP");
		
		if($this->ibe->cekspal($idp,$tp[$ket]))
		echo basename($this->ibe->cekspal($idp,$tp[$ket]));
		else
		echo "none";
				
	}
	
	public function cekdp3()
	{
		
		$idp= $this->input->post('idp');
		
		$ket = $this->get_ib($idp);
		$ket--;
		$tp=array('tp',"S3","S2","S1","D3","D2","D1","SMA","SMP");
		
		if($this->ibe->cekdp3($idp,$tp[$ket]))
		echo basename($this->ibe->cekdp3($idp,$tp[$ket]));
		else
		echo "none";
				
	}
	
	
	public function cekmpt()
	{
		
		$idp= $this->input->post('idp');
		
		$ket = $this->get_ib($idp);
		$ket--;
		$tp=array('tp',"S3","S2","S1","D3","D2","D1","SMA","SMP");
		
		if($this->ibe->cekmpt($idp,$tp[$ket]))
		echo basename($this->ibe->cekmpt($idp,$tp[$ket]));
		else
		echo "none";
				
	}
	
		public function cekjk()
	{
		
		$idp= $this->input->post('idp');
		
		$ket = $this->get_ib($idp);
		$ket--;
		$tp=array('tp',"S3","S2","S1","D3","D2","D1","SMA","SMP");
		
		if($this->ibe->cekjk($idp,$tp[$ket]))
		echo basename($this->ibe->cekjk($idp,$tp[$ket]));
		else
		echo "none";
				
	}
	
		public function cekajar()
	{
		
		$idp= $this->input->post('idp');
		
		$ket = $this->get_ib($idp);
		$ket--;
		$tp=array('tp',"S3","S2","S1","D3","D2","D1","SMA","SMP");
		
		if($this->ibe->cekajar($idp,$tp[$ket]))
		echo basename($this->ibe->cekajar($idp,$tp[$ket]));
		else
		echo "none";
				
	}

	
	public function cekij()
	{
		$idp= $this->input->post('idp');
		
		if($this->ibe->cekib($idp,$this->get_ib($idp)))
		echo basename($this->ibe->cekib($idp,$this->get_ib($idp)));
		else
		echo "none";
				
	}
	
	public function ceksk()
	{
		$idp= $this->input->post('idp');
		
		if($this->ibe->ceksk($idp,$this->get_pangkat($idp)))
		echo basename($this->ibe->ceksk($idp,$this->get_pangkat($idp)));
		else
		echo "none";
				
	}

}

/* End of file kgb.php */
/* Location: ./application/controllers/kgb.php */
