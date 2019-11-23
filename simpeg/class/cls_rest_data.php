<?php


class RestData
{
    var $api_key = 'f8f8a698281433cf7ea88ee191d8a91e';
    private $db;
    public $mysqli;
    var $url_data_dasar;
    var $url_masa_kerja_pegawai;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->mysqli = $this->db->getConnection();
        $this->url_data_dasar = 'http://simpeg.kotabogor.go.id/rest/E_kinerja/exec_running_methode/85/'.$this->api_key;
        $this->url_masa_kerja_pegawai = 'http://simpeg.kotabogor.go.id/rest/Pegawai/exec_running_methode/191/'.$this->api_key;
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
        }
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
                echo ' - Syntax error, malformed JSON';
                $data_ref = self::clean($data_ref);
                $data_ref = json_decode($data_ref, TRUE, 512, JSON_BIGINT_AS_STRING);
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
        return $data_ref;
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

    public function masa_kerja_pegawai($id_pegawai){
        $data_ref = $this->CallAPI('GET', $this->url_masa_kerja_pegawai, array("id_pegawai" => $id_pegawai));
        $data_ref = self::safeDecode($data_ref);
        return $data_ref;
    }

    function data_ref_data_dasar($id_pegawai){
        $data_ref = $this->CallAPI('GET', $this->url_data_dasar, array("id_pegawai" => $id_pegawai));
        $data_ref = $this->safeDecode($data_ref);
        $data_ref = $data_ref->data;
        return $data_ref;
    }

}
?>
