<?php
define('APP_DIR', str_replace("\\", "/", getcwd()));
define('SYSTEM_DIR', APP_DIR . '/');
include(SYSTEM_DIR . "class/cls_koncil.php");

class Absensi
{
    private $db;
    public $mysqli;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->mysqli = $this->db->getConnection();
    }

    public function monthName($bln){
        switch ($bln) {
            case '01':
                $namabln = 'Januari';
                break;
            case '02':
                $namabln = 'Februari';
                break;
            case '03':
                $namabln = 'Maret';
                break;
            case '04':
                $namabln = 'April';
                break;
            case '05':
                $namabln = 'Mei';
                break;
            case '06':
                $namabln = 'Juni';
                break;
            case '07':
                $namabln = 'Juli';
                break;
            case '08':
                $namabln = 'Agustus';
                break;
            case '09':
                $namabln = 'September';
                break;
            case '10':
                $namabln = 'Oktober';
                break;
            case '11':
                $namabln = 'November';
                break;
            case '12':
                $namabln = 'Desember';
                break;
        }
        return $namabln;
    }
}

?>