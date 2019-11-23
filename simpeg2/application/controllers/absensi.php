<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Absensi extends CI_Controller {

	public function api_location_checkin(){		
		$nip = $this->input->get('nip');
		$key = $this->input->get('key');
		$lat = $this->input->get('lat');
		$lon = $this->input->get('lon');
		$waktu_kehadiran = new DateTime("now", new DateTimeZone("Asia/Jakarta"));
		
		$this->load->model('pegawai_model');
		$pegawai = $this->pegawai_model->get_by_nip($nip);
		
		$key_pegawai = $this->pegawai_model->get_api_key($pegawai);
		
		
		$batas_waktu_kehadiran = new DateTime("now", new DateTimeZone("Asia/Jakarta"));
		$tmp_masuk = $this->config->item('batas_waktu_kehadiran');
		$tmp_masuk = explode(':',$tmp_masuk);
		$batas_waktu_kehadiran->setTime($tmp_masuk[0], $tmp_masuk[1], $tmp_masuk[2]);	
		
		$selisih_waktu = $waktu_kehadiran->diff($batas_waktu_kehadiran);	
		
		//header('Content-Type: application/json');
		echo json_encode($key_pegawai."-".$key);
		/*if($selisih_waktu->invert == 1)
			echo json_encode("Terlambat");
		else
			echo json_encode("On Time");
		 json_encode(array( 			
			'key' => $key,
			'lat' => $lat,
			'lon' => $lon,
			'waktu_kehadiran' => $waktu_kehadiran,
			'batas_waktu_kehadiran' => $batas_waktu_kehadiran,
			'selisih_waktu' => $selisih_waktu,
		));*/	
	}
	
	public function check_in($pegawai, $data_absen){		
	}
}

/* End of file home.php */
/* Location: ./application/controllers/absensi.php */
