<?php
define('APP_DIR', str_replace("\\", "/", getcwd()));
define('SYSTEM_DIR', APP_DIR . '/');
include(SYSTEM_DIR . "class/cls_koncil.php");

class Cuti
{
    private $db;
    public $mysqli;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->mysqli = $this->db->getConnection();
    }

    public function count_list_cuti($id_pegawai, $jenis, $status, $txtKeyword, $is_tim){
        $whereKlause = "";
        $whereKlause2 = "";
        if ($jenis != '0') {
            $whereKlause .= " AND cm.id_jenis_cuti = '" . $jenis . "'";
        }
        if ($status != '0') {
            $whereKlause .= " AND cm.id_status_cuti = " . $status;
        }

        if (!(trim($txtKeyword) == "") && !(trim($txtKeyword) == "0")) {
            $whereKlause2 .= " AND (p.nama LIKE '%" . $txtKeyword . "%'
                           OR p.nip_baru LIKE '%" . $txtKeyword . "%' OR cuti_pegawai.last_atsl_nama LIKE '%" . $txtKeyword . "%'
                           OR cuti_pegawai.last_pjbt_nama LIKE '%" . $txtKeyword . "%'
                           OR cuti_pegawai.alasan_cuti LIKE '%" . $txtKeyword . "%') ";
        }

        if($is_tim=='TRUE'){

            if($_SESSION['id_skpd'] == 5266){
                $filterOPD = " (uk.id_skpd = ".$_SESSION['id_skpd']." OR cm.last_pjbt_id_j = 4376)";
            }else{
                $filterOPD = " uk.id_skpd = ".$_SESSION['id_skpd'];
            }

            $sqlCountAll = "SELECT COUNT(*) as jumlah FROM (SELECT cuti_pegawai.*, p.nama as nama_approved, p.nip_baru as nip_baru_approved,
                DATE_FORMAT(cuti_pegawai.tmt_awal,  '%d/%m/%Y') AS tmt_awal_cuti,
                DATE_FORMAT(cuti_pegawai.tmt_akhir,  '%d/%m/%Y') AS tmt_akhir_cuti,
                DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti,  '%d/%m/%Y %H:%m:%s') AS tgl_usulan_cuti2,
                DATE_FORMAT(cuti_pegawai.tgl_approve_status,  '%d/%m/%Y %H:%m:%s') AS tgl_approve_status2
                FROM
                (SELECT cm.*, rs.status_cuti, cj.deskripsi FROM cuti_master cm, ref_status_cuti rs, cuti_jenis cj, unit_kerja uk
                WHERE cm.id_status_cuti = rs.idstatus_cuti ".$whereKlause." AND
                cm.id_jenis_cuti = cj.id_jenis_cuti AND cm.last_id_unit_kerja = uk.id_unit_kerja AND $filterOPD) as cuti_pegawai, pegawai p
                WHERE cuti_pegawai.id_pegawai = p.id_pegawai ".$whereKlause2.
                "ORDER BY cuti_pegawai.tgl_usulan_cuti DESC) a";
        }else{
            $sqlCountAll = "SELECT COUNT(*) as jumlah FROM (SELECT cuti_pegawai.*, p.nama as nama_approved, p.nip_baru as nip_baru_approved,
                DATE_FORMAT(cuti_pegawai.tmt_awal,  '%d/%m/%Y') AS tmt_awal_cuti,
                DATE_FORMAT(cuti_pegawai.tmt_akhir,  '%d/%m/%Y') AS tmt_akhir_cuti,
                DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti,  '%d/%m/%Y %H:%m:%s') AS tgl_usulan_cuti2,
                DATE_FORMAT(cuti_pegawai.tgl_approve_status,  '%d/%m/%Y %H:%m:%s') AS tgl_approve_status2
                FROM
                (SELECT cm.*, rs.status_cuti, cj.deskripsi FROM cuti_master cm, ref_status_cuti rs, cuti_jenis cj
                WHERE cm.id_status_cuti = rs.idstatus_cuti AND cm.id_pegawai = ".$id_pegawai.$whereKlause." AND
                cm.id_jenis_cuti = cj.id_jenis_cuti) as cuti_pegawai, pegawai p
                WHERE cuti_pegawai.id_pegawai = p.id_pegawai ".$whereKlause2.
                "ORDER BY cuti_pegawai.tgl_usulan_cuti DESC) a";
        }

        $query = $this->mysqli->query($sqlCountAll);
        if ($query->num_rows > 0) {
            while ($data = $query->fetch_array(MYSQLI_NUM)) {
                $jmlData = $data[0];
            }
        }
        return $jmlData;
    }

    public function view_list_cuti($id_pegawai, $jenis, $status, $txtKeyword, $is_tim, $limit){
        $whereKlause = "";
        $whereKlause2 = "";
        if ($jenis != '0') {
            $whereKlause .= " AND cm.id_jenis_cuti = '" . $jenis . "'";
        }
        if ($status != '0') {
            $whereKlause .= " AND cm.id_status_cuti = " . $status;
        }

        if (!(trim($txtKeyword) == "") && !(trim($txtKeyword) == "0")) {
            $whereKlause2 .= " AND (p.nama LIKE '%" . $txtKeyword . "%'
                           OR p.nip_baru LIKE '%" . $txtKeyword . "%' OR cuti_pegawai.last_atsl_nama LIKE '%" . $txtKeyword . "%'
                           OR cuti_pegawai.last_pjbt_nama LIKE '%" . $txtKeyword . "%'
                           OR cuti_pegawai.alasan_cuti LIKE '%" . $txtKeyword . "%') ";
        }


        if($is_tim=='TRUE'){
            if($_SESSION['id_skpd'] == 5266){
                $filterOPD = " (uk.id_skpd = ".$_SESSION['id_skpd']." OR cm.last_pjbt_id_j = 4376)";
            }else{
                $filterOPD = " uk.id_skpd = ".$_SESSION['id_skpd'];
            }

            $sql = "SELECT cuti_pegawai.*, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) as nama, g.pangkat  
                FROM (SELECT cuti_pegawai.*, p.nama as nama_approved, p.nip_baru as nip_baru_approved,
                DATE_FORMAT(cuti_pegawai.tmt_awal,  '%d/%m/%Y') AS tmt_awal_cuti,
                DATE_FORMAT(cuti_pegawai.tmt_akhir,  '%d/%m/%Y') AS tmt_akhir_cuti,
                DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti,  '%d/%m/%Y %H:%m:%s') AS tgl_usulan_cuti2,
                DATE_FORMAT(cuti_pegawai.tgl_approve_status,  '%d/%m/%Y %H:%m:%s') AS tgl_approve_status2
                FROM 
                (SELECT cm.*, rs.status_cuti, cj.deskripsi FROM cuti_master cm, ref_status_cuti rs, cuti_jenis cj, unit_kerja uk
                WHERE cm.id_status_cuti = rs.idstatus_cuti ".$whereKlause." AND
                cm.id_jenis_cuti = cj.id_jenis_cuti AND cm.last_id_unit_kerja = uk.id_unit_kerja AND $filterOPD) 
                as cuti_pegawai, pegawai p
                WHERE cuti_pegawai.id_pegawai = p.id_pegawai ".$whereKlause2.
                "ORDER BY cuti_pegawai.tgl_usulan_cuti DESC". $limit.") cuti_pegawai, pegawai p, golongan g 
                WHERE cuti_pegawai.id_pegawai = p.id_pegawai AND cuti_pegawai.last_gol = g.golongan
                ORDER BY cuti_pegawai.tgl_usulan_cuti DESC";

        }else{
            $sql = "SELECT cuti_pegawai.*, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) as nama, g.pangkat  
                FROM (SELECT cuti_pegawai.*, p.nama as nama_approved, p.nip_baru as nip_baru_approved,
                DATE_FORMAT(cuti_pegawai.tmt_awal,  '%d/%m/%Y') AS tmt_awal_cuti,
                DATE_FORMAT(cuti_pegawai.tmt_akhir,  '%d/%m/%Y') AS tmt_akhir_cuti,
                DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti,  '%d/%m/%Y %H:%m:%s') AS tgl_usulan_cuti2,
                DATE_FORMAT(cuti_pegawai.tgl_approve_status,  '%d/%m/%Y %H:%m:%s') AS tgl_approve_status2
                FROM 
                (SELECT cm.*, rs.status_cuti, cj.deskripsi FROM cuti_master cm, ref_status_cuti rs, cuti_jenis cj
                WHERE cm.id_status_cuti = rs.idstatus_cuti AND cm.id_pegawai = ".$id_pegawai.$whereKlause." AND
                cm.id_jenis_cuti = cj.id_jenis_cuti) as cuti_pegawai, pegawai p
                WHERE cuti_pegawai.id_pegawai = p.id_pegawai ".$whereKlause2.
                "ORDER BY cuti_pegawai.tgl_usulan_cuti DESC". $limit.") cuti_pegawai, pegawai p, golongan g 
                WHERE cuti_pegawai.id_pegawai = p.id_pegawai AND cuti_pegawai.last_gol = g.golongan
                ORDER BY cuti_pegawai.tgl_usulan_cuti DESC";
        }
        //echo $sql;
        $result = $this->mysqli->query($sql);
        return $result;
    }

    public function get_list_runut_proses_cuti($idcm){
        $sql = "SELECT nama,DATE_FORMAT(tgl_approve_hist,  '%d/%m/%Y %H:%m:%s') as tgl_approve_hist,approved_note_hist,status_cuti 
        FROM cuti_historis_approve INNER JOIN pegawai ON cuti_historis_approve.approved_by_hist=pegawai.id_pegawai 
        INNER JOIN ref_status_cuti ON ref_status_cuti.idstatus_cuti = cuti_historis_approve.idstatus_cuti_hist 
        WHERE id_cuti_master = $idcm";
        $result = $this->mysqli->query($sql);
        return $result;
    }

    private function intPart($float){
        if ($float < -0.0000001)
            return ceil($float - 0.0000001);
        else
            return floor($float + 0.0000001);
    }

    public function Greg2Hijri($day, $month, $year, $string = false){
        $day   = (int) $day;
        $month = (int) $month;
        $year  = (int) $year;

        if (($year > 1582) or (($year == 1582) and ($month > 10)) or (($year == 1582) and ($month == 10) and ($day > 14)))
        {
            $jd = $this->intPart((1461*($year+4800+$this->intPart(($month-14)/12)))/4)+$this->intPart((367*($month-2-12*($this->intPart(($month-14)/12))))/12)-
                $this->intPart( (3* ($this->intPart(  ($year+4900+    $this->intPart( ($month-14)/12)     )/100)    )   ) /4)+$day-32075;
        }
        else
        {
            $jd = 367*$year-$this->intPart((7*($year+5001+$this->intPart(($month-9)/7)))/4)+$this->intPart((275*$month)/9)+$day+1729777;
        }

        $l = $jd-1948440+10632;
        $n = $this->intPart(($l-1)/10631);
        $l = $l-10631*$n+354;
        $j = ($this->intPart((10985-$l)/5316))*($this->intPart((50*$l)/17719))+($this->intPart($l/5670))*($this->intPart((43*$l)/15238));
        $l = $l-($this->intPart((30-$j)/15))*($this->intPart((17719*$j)/50))-($this->intPart($j/16))*($this->intPart((15238*$j)/43))+29;

        $month = $this->intPart((24*$l)/709);
        $day   = $l-$this->intPart((709*$month)/24);
        $year  = 30*$n+$j-30;

        $date = array();
        $date['year']  = $year;
        $date['month'] = $month;
        $date['day']   = $day;

        if (!$string)
            return $date;
        else
            return "{$year}-{$month}-{$day}";
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

    public function kekata($x) {
        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($x <12) {
            $temp = " ". $angka[$x];
        } else if ($x <20) {
            $temp = kekata($x - 10). " belas";
        } else if ($x <100) {
            $temp = kekata($x/10)." puluh". kekata($x % 10);
        } else if ($x <200) {
            $temp = " seratus" . kekata($x - 100);
        } else if ($x <1000) {
            $temp = kekata($x/100) . " ratus" . kekata($x % 100);
        } else if ($x <2000) {
            $temp = " seribu" . kekata($x - 1000);
        } else if ($x <1000000) {
            $temp = kekata($x/1000) . " ribu" . kekata($x % 1000);
        } else if ($x <1000000000) {
            $temp = kekata($x/1000000) . " juta" . kekata($x % 1000000);
        } else if ($x <1000000000000) {
            $temp = kekata($x/1000000000) . " milyar" . kekata(fmod($x,1000000000));
        } else if ($x <1000000000000000) {
            $temp = kekata($x/1000000000000) . " trilyun" . kekata(fmod($x,1000000000000));
        }
        return $temp;
    }


    public function terbilang($x, $style=4) {
        if($x<0) {
            $hasil = "minus ". trim(kekata($x));
        } else {
            $hasil = trim(kekata($x));
        }
        switch ($style) {
            case 1:
                $hasil = strtoupper($hasil);
                break;
            case 2:
                $hasil = strtolower($hasil);
                break;
            case 3:
                $hasil = ucwords($hasil);
                break;
            default:
                $hasil = ucfirst($hasil);
                break;
        }
        return $hasil;
    }

    public function get_surat_cuti($idp, $idcm){
        $sql = "SELECT cuti_pegawai.*, g.pangkat as pangkat_pjbt
                  FROM
                  (SELECT cuti_pegawai.*, g.pangkat AS pangkat_atsl FROM
                  (SELECT cuti_pegawai.*, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                  p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) as nama, p.nip_baru,
                  DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti,  '%d') AS tgl_usulan,
                  DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti,  '%m') AS bln_usulan,
                  DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti,  '%Y') AS thn_usulan,
                  DATE_FORMAT(cuti_pegawai.tmt_awal,  '%d/%m/%Y') AS tmt_awal_cuti,
                  DATE_FORMAT(cuti_pegawai.tmt_akhir,  '%d/%m/%Y') AS tmt_akhir_cuti,
                  CASE
                  WHEN (p.ponsel IS NULL = 0 AND p.ponsel != '') AND (p.telepon IS NULL = 0 AND p.telepon != '') THEN
                    CONCAT(p.ponsel, ' / ',p.telepon)
                  ELSE
                    CASE WHEN (p.ponsel IS NULL = 0 AND p.ponsel != '') THEN p.ponsel ELSE
                      CASE WHEN (p.telepon IS NULL = 0 AND p.telepon != '') THEN p.telepon ELSE '' END
                    END
                  END AS nokontak
                     FROM
                     (SELECT cm.*, rs.status_cuti, cj.deskripsi, g.pangkat AS pangkat_p FROM cuti_master cm, ref_status_cuti rs, cuti_jenis cj, golongan g
                     WHERE cm.id_status_cuti = rs.idstatus_cuti AND cm.id_jenis_cuti = cj.id_jenis_cuti AND cm.last_gol = g.golongan
                      AND cm.id_pegawai = $idp AND cm.id_cuti_master = ".$idcm.") as cuti_pegawai, pegawai p
                    WHERE cuti_pegawai.id_pegawai = p.id_pegawai AND p.id_pegawai = $idp) AS cuti_pegawai
                    LEFT JOIN golongan g ON cuti_pegawai.last_atsl_gol = g.golongan) AS cuti_pegawai
                    LEFT JOIN golongan g ON cuti_pegawai.last_pjbt_gol = g.golongan";
        $result = $this->mysqli->query($sql);
        return $result;
    }

    public function hapusDataCuti($data){
        $this->mysqli->autocommit(FALSE);
        $sql = "DELETE FROM cuti_master WHERE id_cuti_master = ".$data['idcm'];
        if ($this->mysqli->query($sql) == TRUE){
            $this->mysqli->commit();
            echo 1;
        } else {
            $this->mysqli->rollback();
            echo 0;
        }
    }

    public function batalUsulanCuti($data){
        $this->mysqli->autocommit(FALSE);
        $sqlUpdate = "update cuti_master set id_status_cuti=9, tgl_approve_status=NOW(),
                      approved_by=".$data['idpApprover'].",approved_note= '".$data['keterangan']."'
                      where id_cuti_master=".$data['idcm'];
        if ($this->mysqli->query($sqlUpdate) == TRUE){
            $sqlInsert_Approved_Hist = "INSERT INTO cuti_historis_approve(tgl_approve_hist, approved_by_hist, idstatus_cuti_hist, approved_note_hist, id_cuti_master)
                                VALUES (NOW(),".$data['idpApprover'].",9,'".$data['keterangan']."',".$data['idcm'].")";
            if ($this->mysqli->query($sqlInsert_Approved_Hist) == TRUE){
                $this->mysqli->commit();
                echo 1;
            }else{
                $this->mysqli->rollback();
                echo 0;
            }
        } else {
            $this->mysqli->rollback();
            echo 0;
        }
    }

    public function kirimDataCuti($data){
        $this->mysqli->autocommit(FALSE);
        if($data['idKepAtsl']==3){
            $tmtMulaiPenangguhanAtsl = explode("-", $data['tmtMulaiPenangguhanAtsl']);
            $tmtMulaiPenangguhanAtsl = $tmtMulaiPenangguhanAtsl[2].'-'.$tmtMulaiPenangguhanAtsl[1].'-'.$tmtMulaiPenangguhanAtsl[0];
            $tmtSelesaiPenangguhanAtsl = explode("-", $data['tmtSelesaiPenangguhanAtsl']);
            $tmtSelesaiPenangguhanAtsl = $tmtSelesaiPenangguhanAtsl[2].'-'.$tmtSelesaiPenangguhanAtsl[1].'-'.$tmtSelesaiPenangguhanAtsl[0];
            $lamaPenangguhanAtsl = $data['lamaPengguhanAtsl'];
        }
        if($data['idKepPjbt']==3){
            $tmtMulaiPenangguhanPjbt = explode("-", $data['tmtMulaiPenangguhanPjbt']);
            $tmtMulaiPenangguhanPjbt = $tmtMulaiPenangguhanPjbt[2].'-'.$tmtMulaiPenangguhanPjbt[1].'-'.$tmtMulaiPenangguhanPjbt[0];
            $tmtSelesaiPenangguhanPjbt = explode("-", $data['tmtSelesaiPenangguhanPjbt']);
            $tmtSelesaiPenangguhanPjbt = $tmtSelesaiPenangguhanPjbt[2].'-'.$tmtSelesaiPenangguhanPjbt[1].'-'.$tmtSelesaiPenangguhanPjbt[0];
            $lamaPenangguhanPjbt = $data['tmtMulaiPenangguhanPjbt'];
        }
        if($data['flag_uk_atasan_sama']==1){
            if($data['idKepAtsl']==1 and $data['idKepPjbt']==1){
                $idStatusCuti = 12;
            }else{
                $idStatusCuti = 13;
            }
        }else{
            if($data['istim']=='TRUE'){
                if($data['idKepAtsl']==1 and $data['idKepPjbt']==1){
                    $idStatusCuti = 12;
                }else{
                    if($data['idpAdmin']==$data['idp_pemohon']){
                        $idStatusCuti = 14;
                    }else{
                        $idStatusCuti = 13;
                    }
                }
            }else{
                if($data['idKepAtsl']==1){
                    $idStatusCuti = 14;
                }else{
                    $idStatusCuti = 13;
                }
            }
        }
        if($data['idKepAtsl']!=0){
            $sqlKep = "SELECT cka.status_keputusan_cuti 
                            FROM cuti_keputusan_atasan cka 
                            WHERE cka.id_sts_keputusan_cuti = ".$data['idKepAtsl'];
            $q = $this->mysqli->query($sqlKep);
            while ($oto = $q->fetch_array(MYSQLI_NUM)) {
                $kepAtsl = $oto[0];
            }
            $kepAtsl = ' Pertimbangan Atasan Langsung '.$kepAtsl;
        }
        if($data['idKepPjbt']!=0){
            $sqlKep = "SELECT cka.status_keputusan_cuti 
                            FROM cuti_keputusan_atasan cka 
                            WHERE cka.id_sts_keputusan_cuti = ".$data['idKepPjbt'];
            $q = $this->mysqli->query($sqlKep);
            while ($oto = $q->fetch_array(MYSQLI_NUM)) {
                $kepPjbt = $oto[0];
            }
            $kepPjbt = ' Keputusan Pejabat Berwenang '.$kepPjbt;
        }
        $ket = $data['txtKeterangan'];
        $sqlUpdateCuti = "UPDATE cuti_master set id_status_cuti=$idStatusCuti, tgl_approve_status=NOW(),
                          approved_by=".$data['idpApprover'].",approved_note= '".$ket."', 
                          id_sts_keputusan_atsl = ".$data['idKepAtsl'].", alasan_pertimbangan_atsl = '".$data['cttn_atsl']."',
                          id_sts_keputusan_pjbt = ".$data['idKepPjbt'].", alasan_keputusan_pjbt = '".$data['cttn_pjbt']."' 
                          where id_cuti_master=".$data['idcm'];

        if ($this->mysqli->query($sqlUpdateCuti) == TRUE){
            if($data['idKepAtsl']==3){
                $sqlInsertPenangguhan = "insert into cuti_penangguhan(tgl_mulai_penangguhan,tgl_akhir_penangguhan,lama_penangguhan,id_cuti_master) 
                                         values ('$tmtMulaiPenangguhanAtsl','$tmtSelesaiPenangguhanAtsl',$lamaPenangguhanAtsl,".$data['idcm'].")";
                if ($this->mysqli->query($sqlInsertPenangguhan) == TRUE){
                    $stsInsPenangguhanAtsl = true;
                }else{
                    $stsInsPenangguhanAtsl = false;
                }
            }else{
                $stsInsPenangguhanAtsl = true;
            }
            if($data['idKepPjbt']==3){
                $sqlInsertPenangguhan = "insert into cuti_penangguhan(tgl_mulai_penangguhan,tgl_akhir_penangguhan,lama_penangguhan,id_cuti_master) 
                                         values ('$tmtMulaiPenangguhanPjbt','$tmtSelesaiPenangguhanPjbt',$lamaPenangguhanPjbt,".$data['idcm'].")";
                if ($this->mysqli->query($sqlInsertPenangguhan) == TRUE){
                    $stsInsPenangguhanPjbt = true;
                }else{
                    $stsInsPenangguhanPjbt = false;
                }
            }else{
                $stsInsPenangguhanPjbt = true;
            }
            if($stsInsPenangguhanAtsl==true and $stsInsPenangguhanPjbt==true){
                $sqlInsert_Approved_Hist = "INSERT INTO cuti_historis_approve(tgl_approve_hist, approved_by_hist, idstatus_cuti_hist, approved_note_hist, id_cuti_master)
                            VALUES (NOW(),".$data['idpApprover'].",$idStatusCuti,'".$ket."',".$data['idcm'].")";
                if ($this->mysqli->query($sqlInsert_Approved_Hist) == TRUE){
                    $this->mysqli->commit();
                    return 1;
                }else{
                    $this->mysqli->rollback();
                    return 0;
                }
            }else{
                $this->mysqli->rollback();
                return 0;
            }
        }else{
            $this->mysqli->rollback();
            return 0;
        }
    }
    
    public function rekap_cuti_pada_opd($thn, $id_opd){
        $sql = "SELECT IF(rsc.status_cuti IS NULL, 'Total', rsc.status_cuti) AS status_cuti,
                b.CLTN, b.C_ALASAN_PENTING, b.C_BERSALIN, b.C_BESAR, b.C_SAKIT, b.C_TAHUNAN,
                (b.CLTN + b.C_ALASAN_PENTING + b.C_BERSALIN + b.C_BESAR + b.C_SAKIT + b.C_TAHUNAN) AS 'Total'
                FROM (SELECT a.id_status_cuti,
                SUM(if(a.id_jenis_cuti = 'CLTN', a.jumlah, 0)) as 'CLTN',
                SUM(if(a.id_jenis_cuti = 'C_ALASAN_PENTING', a.jumlah, 0)) as 'C_ALASAN_PENTING',
                SUM(if(a.id_jenis_cuti = 'C_BERSALIN', a.jumlah, 0)) as 'C_BERSALIN',
                SUM(if(a.id_jenis_cuti = 'C_BESAR', a.jumlah, 0)) as 'C_BESAR',
                SUM(if(a.id_jenis_cuti = 'C_SAKIT', a.jumlah, 0)) as 'C_SAKIT',
                SUM(if(a.id_jenis_cuti = 'C_TAHUNAN', a.jumlah, 0)) as 'C_TAHUNAN'
                FROM (SELECT cm.id_status_cuti, cm.id_jenis_cuti, COUNT(cm.id_cuti_master) AS jumlah
                FROM cuti_master cm INNER JOIN unit_kerja uk ON cm.last_id_unit_kerja = uk.id_unit_kerja
                WHERE YEAR(cm.tmt_awal)=$thn AND YEAR(cm.tgl_usulan_cuti) = $thn AND uk.id_skpd = $id_opd
                GROUP BY cm.id_status_cuti, cm.id_jenis_cuti) a
                GROUP BY a.id_status_cuti WITH ROLLUP) b
                LEFT JOIN ref_status_cuti rsc ON b.id_status_cuti = rsc.idstatus_cuti";
        $result = $this->mysqli->query($sql);
        return $result;
    }
    
    public function rekap_cuti_semua_opd($thn, $id_status_cuti){
        $andKlause = "";
        if($id_status_cuti!=0 and $id_status_cuti!=''){
            $andKlause .= " AND cm.id_status_cuti = $id_status_cuti";
        }
        $sql = "SELECT IF(c.opd IS NULL, 'Total',c.opd) AS opd, SUM(c.CLTN) AS CLTN, SUM(c.C_ALASAN_PENTING) AS C_ALASAN_PENTING, SUM(c.C_BERSALIN) AS C_BERSALIN,
                SUM(c.C_BESAR) AS C_BESAR, SUM(c.C_SAKIT) AS C_SAKIT, SUM(c.C_TAHUNAN) AS C_TAHUNAN,
                SUM(CASE WHEN c.Total IS NULL THEN 0 ELSE c.Total END) AS Total
                FROM (SELECT uk.nama_baru as opd,
                IF(b.CLTN IS NULL,0,b.CLTN) AS CLTN,
                IF(b.C_ALASAN_PENTING IS NULL,0,b.C_ALASAN_PENTING) AS C_ALASAN_PENTING,
                IF(b.C_BERSALIN IS NULL,0,b.C_BERSALIN) AS C_BERSALIN,
                IF(b.C_BESAR IS NULL,0,b.C_BESAR) AS C_BESAR,
                IF(b.C_SAKIT IS NULL,0,b.C_SAKIT) AS C_SAKIT,
                IF(b.C_TAHUNAN IS NULL,0,b.C_TAHUNAN) AS C_TAHUNAN,
                (b.CLTN+b.C_ALASAN_PENTING+b.C_BERSALIN+b.C_BESAR+b.C_SAKIT+b.C_TAHUNAN) AS 'Total'
                FROM unit_kerja uk LEFT JOIN
                (SELECT a.id_skpd,
                SUM(if(a.id_jenis_cuti = 'CLTN', a.jumlah, 0)) as 'CLTN',
                SUM(if(a.id_jenis_cuti = 'C_ALASAN_PENTING', a.jumlah, 0)) as 'C_ALASAN_PENTING',
                SUM(if(a.id_jenis_cuti = 'C_BERSALIN', a.jumlah, 0)) as 'C_BERSALIN',
                SUM(if(a.id_jenis_cuti = 'C_BESAR', a.jumlah, 0)) as 'C_BESAR',
                SUM(if(a.id_jenis_cuti = 'C_SAKIT', a.jumlah, 0)) as 'C_SAKIT',
                SUM(if(a.id_jenis_cuti = 'C_TAHUNAN', a.jumlah, 0)) as 'C_TAHUNAN'
                FROM (SELECT uk.id_skpd, cm.id_jenis_cuti, COUNT(cm.id_cuti_master) AS jumlah
                FROM cuti_master cm INNER JOIN unit_kerja uk ON cm.last_id_unit_kerja = uk.id_unit_kerja
                WHERE YEAR(cm.tmt_awal)=$thn AND YEAR(cm.tgl_usulan_cuti) = $thn $andKlause
                GROUP BY uk.id_skpd, cm.id_jenis_cuti) a
                GROUP BY a.id_skpd WITH ROLLUP) b ON uk.id_unit_kerja = b.id_skpd
                WHERE uk.id_unit_kerja = uk.id_skpd AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)) c
                GROUP BY c.opd WITH ROLLUP";
        $result = $this->mysqli->query($sql);
        return $result;
    }

    public function rekap_cuti_bulanan($thn, $id_status_cuti, $id_opd){
        $andKlause = "";
        if($id_status_cuti!=0 and $id_status_cuti!=''){
            $andKlause .= " AND cm.id_status_cuti = $id_status_cuti";
        }

        if($id_opd!=0 and $id_opd!=''){
            $andKlause .= " AND uk.id_skpd = $id_opd";
        }

        $sql = "SELECT d.bln, d.nama_bln, SUM(d.CLTN) AS CLTN, SUM(d.C_ALASAN_PENTING) AS C_ALASAN_PENTING,
                SUM(d.C_BERSALIN) AS C_BERSALIN, SUM(d.C_BESAR) AS C_BESAR, SUM(d.C_SAKIT) AS C_SAKIT,
                SUM(d.C_TAHUNAN) AS C_TAHUNAN, SUM(d.TOTAL) AS TOTAL
                FROM (SELECT lb.bln, lb.nama_bln,
                CASE WHEN c.CLTN IS NULL = 1 THEN 0 ELSE c.CLTN END AS CLTN,
                CASE WHEN c.C_ALASAN_PENTING IS NULL = 1 THEN 0 ELSE c.C_ALASAN_PENTING END AS C_ALASAN_PENTING,
                CASE WHEN c.C_BERSALIN IS NULL = 1 THEN 0 ELSE c.C_BERSALIN END AS C_BERSALIN,
                CASE WHEN c.C_BESAR IS NULL = 1 THEN 0 ELSE c.C_BESAR END AS C_BESAR,
                CASE WHEN c.C_SAKIT IS NULL = 1 THEN 0 ELSE c.C_SAKIT END AS C_SAKIT,
                CASE WHEN c.C_TAHUNAN IS NULL = 1 THEN 0 ELSE c.C_TAHUNAN END AS C_TAHUNAN,
                CASE WHEN c.TOTAL IS NULL = 1 THEN 0 ELSE c.TOTAL END AS TOTAL
                FROM list_bulan lb LEFT JOIN 
                (SELECT b.bln, b.bulan,
                CLTN, C_ALASAN_PENTING, C_BERSALIN, C_BESAR, C_SAKIT, C_TAHUNAN,
                (CLTN + C_ALASAN_PENTING + C_BERSALIN + C_BESAR + C_SAKIT + C_TAHUNAN) AS TOTAL
                FROM (SELECT a.bln, a.bulan, 
                SUM(if(a.id_jenis_cuti = 'CLTN', a.jumlah, 0)) as 'CLTN',
                SUM(if(a.id_jenis_cuti = 'C_ALASAN_PENTING', a.jumlah, 0)) as 'C_ALASAN_PENTING',
                SUM(if(a.id_jenis_cuti = 'C_BERSALIN', a.jumlah, 0)) as 'C_BERSALIN',
                SUM(if(a.id_jenis_cuti = 'C_BESAR', a.jumlah, 0)) as 'C_BESAR',
                SUM(if(a.id_jenis_cuti = 'C_SAKIT', a.jumlah, 0)) as 'C_SAKIT',
                SUM(if(a.id_jenis_cuti = 'C_TAHUNAN', a.jumlah, 0)) as 'C_TAHUNAN'
                FROM 
                (SELECT cm.id_jenis_cuti, MONTH(cm.tgl_approve_status) bln,
                CUSTOM_MONTH_NAME(MONTH(cm.tgl_approve_status)) AS bulan,
                COUNT(cm.id_cuti_master) AS jumlah
                FROM cuti_master cm INNER JOIN unit_kerja uk ON cm.last_id_unit_kerja = uk.id_unit_kerja
                WHERE YEAR(cm.tmt_awal) = $thn AND YEAR(cm.tgl_usulan_cuti) = $thn $andKlause
                GROUP BY cm.id_jenis_cuti, bln) a
                GROUP BY a.bln) b) c ON lb.bln = c.bln
                ORDER BY lb.bln) d GROUP BY d.bln WITH ROLLUP";
        $result = $this->mysqli->query($sql);
        return $result;
    }

    public function listTahun(){
        $i = 2;
        $thn[$i] = date("Y");
        for ($x = 0; $x <= 1; $x++) {
            $thn[$x] = $thn[$i] - ($i-$x);
        }
        for ($x = 3; $x <= 6; $x++) {
            $thn[$x] = $thn[$i] + ($x-2);
        }
        return $thn;
    }

}

?>