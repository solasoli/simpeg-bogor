<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Search extends CI_Controller{
	
		
	
    public function __construct(){

        parent::__construct();

        $this->load->model('proposal_model','proposal');
        $this->load->model('lembaga_kemasyarakatan_model','lemas');
    }
        
    
    public function proposal(){
        
        $data['page'] = "search/proposal_result";
        $data['title'] = "Hasil pencarian ".$this->input->get('id');
        
        $this->proposal->nomor_tanda_terima = $this->input->get('id');
        
        if($this->proposal->get_by_tanda_terima()){
            $data['pemohon'] = $this->proposal->get_by_tanda_terima();
            
            $this->lemas->id = $data['pemohon']->id_lembaga_kemasyarakatan;
            $data['pemohon']->lemas = $this->lemas->get_by_id()->nama;
            $data['pemohon']->status = $this->proposal->get_status_name($data['pemohon']->is_approve);
            
        }else{
            $data['pemohon'] = FALSE;
        }
        
        
        $this->load->view('main',$data);
    }
        
}

