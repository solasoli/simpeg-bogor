<?php
    class Publicpegawai_model extends CI_Model{
        var $api_key = 'edcfb2bc7bd4e16ccb19a40dda2af709';
        var $websimpeg_url = "http://simpeg.kotabogor.go.id";
        var $const_http = 'http';
        var $serverName;
        var $curr_addr;
        var $url_stat_kinerja_bulanan;
        var $url_stat_absensi_bulanan;
        var $url_stat_persen_kinerja_absensi_bulanan;
        var $url_stat_kinerja_harian;
        var $url_stat_absensi_harian;
        var $url_list_pegawai_by_nama_and_opd;

        public function __Construct(){
            parent::__Construct();
            $this->serverName = $_SERVER['SERVER_NAME'];
            $this->curr_addr = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
            $this->url_stat_kinerja_bulanan = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/201/".$this->api_key;
            $this->url_stat_absensi_bulanan = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/202/".$this->api_key;
            $this->url_stat_persen_kinerja_absensi_bulanan = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/203/".$this->api_key;
            $this->url_stat_kinerja_harian = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/204/".$this->api_key;
            $this->url_stat_absensi_harian = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/205/".$this->api_key;
            $this->url_list_pegawai_by_nama_and_opd = "$this->websimpeg_url/rest/Pegawai/exec_running_methode/206/".$this->api_key;
            $this->url_drh_biodata = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/207/".$this->api_key;
            $this->url_drh_pendidikan = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/208/".$this->api_key;
            $this->url_drh_diklat = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/209/".$this->api_key;
            $this->url_drh_golongan = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/210/".$this->api_key;
            $this->url_drh_jabatan = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/211/".$this->api_key;
            $this->url_drh_keluarga_istri_suami = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/212/".$this->api_key;
            $this->url_drh_keluarga_anak = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/213/".$this->api_key;
            $this->url_drh_alih_tugas = "$this->websimpeg_url/rest/E_kinerja/exec_running_methode/214/".$this->api_key;
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

        function multiRequestAPI(array $requests, $opts = array()){
            $chs = array();
            $opts += array(CURLOPT_CONNECTTIMEOUT => 3, CURLOPT_TIMEOUT => 3, CURLOPT_RETURNTRANSFER => 1);
            $responses = array();
            $mh = curl_multi_init();
            $running = null;

            foreach ($requests as $key => $request) {
                $chs[$key] = curl_init();
                $url = $request['url'];
                if (isset($request['post_data']) and sizeof($request['post_data']) > 0 and $request['post_data']!='') {
                    curl_setopt($chs[$key], CURLOPT_POST, 1);
                    curl_setopt($chs[$key], CURLOPT_POSTFIELDS, $request['post_array']);
                }
                if(isset($request['get_data']) and sizeof($request['get_data']) and $request['get_data']!=''){
                    $url = sprintf("%s?%s", $url, http_build_query($request['get_data']['get_array']));
                }
                curl_setopt($chs[$key], CURLOPT_URL, $url);
                curl_setopt_array($chs[$key], (isset($request['opts']) ? $request['opts'] + $opts : $opts));
                curl_multi_add_handle($mh, $chs[$key]);
            }

            do {
                curl_multi_exec($mh, $running);
                curl_multi_select($mh);
            } while($running > 0);

            foreach ($chs as $key => $ch) {
                if (curl_errno($ch)) {
                    $responses[$key] = array('data'=>null, 'info'=>null, 'error'=>curl_error($ch));
                } else {
                    $responses[$key] = array('data'=>curl_multi_getcontent($ch), 'info' => curl_getinfo($ch), 'error' => null);
                }
                curl_multi_remove_handle($mh, $ch);
            }

            curl_multi_close($mh);
            return $responses;
        }

        function CallAPI($method, $url, $data = false){
            $curl = curl_init();
            switch ($method) {
                case "POST":
                    curl_setopt($curl, CURLOPT_POST, 1);
                    if ($data)
                        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
                    break;
                case "PUT":
                    curl_setopt($curl, CURLOPT_PUT, 1);
                    break;
                default:
                    if ($data)
                        $url = sprintf("%s?%s", $url, http_build_query($data));
            }
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT ,0);
            curl_setopt($curl, CURLOPT_TIMEOUT, 400);
            set_time_limit(0);

            try {
                $result = curl_exec($curl);

                if (curl_error($curl)) {
                    $error_msg = curl_error($curl);
                }
                curl_close($curl);
                if (isset($error_msg)) {
                    print_r($error_msg);
                    die;
                }
                //var_dump($result);
                return $result;
            }catch(Exception $e) {
                echo 'Message: ' .$e->getMessage();
            }
        }

        public static function safeDecode($data_ref){
            $data_ref = json_decode($data_ref);
            if ($data_ref === null
                && json_last_error() !== JSON_ERROR_NONE) {
                echo "incorrect data";
                switch (json_last_error()) {
                    case JSON_ERROR_NONE:
                        //echo ' - No errors';
                        break;
                    case JSON_ERROR_DEPTH:
                        echo ' - Maximum stack depth exceeded';
                        die;
                        break;
                    case JSON_ERROR_STATE_MISMATCH:
                        echo ' - Underflow or the modes mismatch';
                        die;
                        break;
                    case JSON_ERROR_CTRL_CHAR:
                        echo ' - Unexpected control character found';
                        die;
                        break;
                    case JSON_ERROR_SYNTAX:
                        $data_ref = self::clean($data_ref);
                        $data_ref = json_decode($data_ref, TRUE, 512, JSON_BIGINT_AS_STRING);
                        if(self::isJSON($data_ref)){
                            $data_ref = $data_ref;
                        }else{
                            echo " - Syntax error, malformed JSON. Can't get data from server";
                            die;
                            break;
                        }
                        break;
                    case JSON_ERROR_UTF8:
                        echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
                        die;
                        break;
                    default:
                        echo ' - Unknown error';
                        die;
                        break;
                }
            }
            return $data_ref;
        }

        public static function isJSON($string){
            return is_string($string) && is_array(json_decode($string, true)) ? true : false;
        }

        public static function clean($jsonString){
            if (!is_string($jsonString) || !$jsonString) return '';

            // Remove unsupported characters
            // Check http://www.php.net/chr for details
            for ($i = 0; $i <= 31; ++$i)
                $jsonString = str_replace(chr($i), "", $jsonString);

            $jsonString = str_replace(chr(127), "", $jsonString);

            // Remove the BOM (Byte Order Mark)
            // It the most common that some file begins with 'efbbbf' to mark the beginning of the file. (binary level)
            // Here we detect it and we remove it, basically it the first 3 characters.
            if (0 === strpos(bin2hex($jsonString), 'efbbbf')) $jsonString = substr($jsonString, 3);

            return $jsonString;
        }

        public function get_data_stat_kinerja_bulanan($id_pegawai, $thn){
            $data_ref = $this->CallAPI('GET', $this->url_stat_kinerja_bulanan, array('id_pegawai_enc' => $id_pegawai, "thn" => $thn));
            $data_ref = self::safeDecode($data_ref);
            $data_ref = $data_ref->data;
            return $data_ref;
        }

        public function get_data_stat_absensi_bulanan($id_pegawai, $thn){
            $data_ref = $this->CallAPI('GET', $this->url_stat_absensi_bulanan, array('id_pegawai_enc' => $id_pegawai, "thn" => $thn));
            $data_ref = self::safeDecode($data_ref);
            $data_ref = $data_ref->data;
            return $data_ref;
        }

        public function get_data_stat_persen_kinerja_absensi_bulanan($id_pegawai, $thn){
            $data_ref = $this->CallAPI('GET', $this->url_stat_persen_kinerja_absensi_bulanan, array('id_pegawai_enc' => $id_pegawai, "thn" => $thn));
            $data_ref = self::safeDecode($data_ref);
            $data_ref = $data_ref->data;
            return $data_ref;
        }

        public function get_data_statistik_harian_kinerja_absen($id_pegawai, $bln, $thn){
            $dataReq = array(
                array('url'=>$this->url_stat_kinerja_harian, 'get_data'=> array('get_array'=>array('id_pegawai_enc'=>$id_pegawai, 'bln'=>$bln, 'thn'=>$thn))),
                array('url'=>$this->url_stat_absensi_harian, 'get_data'=> array('get_array'=>array('id_pegawai_enc'=>$id_pegawai, 'bln'=>$bln, 'thn'=>$thn)))
            );
            $data_ref = $this->multiRequestAPI($dataReq);
            return $data_ref;
            /*echo '<pre>';
            print_r($data_ref[0]['data']);
            echo '</pre>';*/
        }

        public function data_ref_pegawai_by_term_by_opd($q, $idopd){
            $data_ref = $this->CallAPI('GET', $this->url_list_pegawai_by_nama_and_opd, array("nama" => $q, "idopd" => $idopd));
            return $data_ref;
        }

        public function daftar_riwayat_hidup($id_pegawai){
            $dataReq = array(
                array('url'=>$this->url_drh_biodata, 'get_data'=> array('get_array'=>array('id_pegawai_enc'=>$id_pegawai))),
                array('url'=>$this->url_drh_pendidikan, 'get_data'=> array('get_array'=>array('id_pegawai_enc'=>$id_pegawai))),
                array('url'=>$this->url_drh_diklat, 'get_data'=> array('get_array'=>array('id_pegawai_enc'=>$id_pegawai))),
                array('url'=>$this->url_drh_golongan, 'get_data'=> array('get_array'=>array('id_pegawai_enc'=>$id_pegawai))),
                array('url'=>$this->url_drh_jabatan, 'get_data'=> array('get_array'=>array('id_pegawai_enc'=>$id_pegawai))),
                array('url'=>$this->url_drh_keluarga_istri_suami, 'get_data'=> array('get_array'=>array('id_pegawai_enc'=>$id_pegawai))),
                array('url'=>$this->url_drh_keluarga_anak, 'get_data'=> array('get_array'=>array('id_pegawai_enc'=>$id_pegawai))),
                array('url'=>$this->url_drh_alih_tugas, 'get_data'=> array('get_array'=>array('id_pegawai_enc'=>$id_pegawai)))
            );
            $data_ref = $this->multiRequestAPI($dataReq);
            return $data_ref;
            /*echo '<pre>';
            print_r($data_ref[0]['data']);
            echo '</pre>';*/
        }

        public function riwayat_hukuman_disiplin($id_pegawai){

        }

    }
?>
