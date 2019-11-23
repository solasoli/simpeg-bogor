<?php
define('WEB_ROOT', 'http://localhost/');
define('APP_DIR', str_replace("\\", "/", getcwd()));
define('SYSTEM_DIR', APP_DIR . '/');
include(SYSTEM_DIR . "class/cls_koncil.php");
include(SYSTEM_DIR . "class/cls_koncil_gaji.php");

class Ptk
{
    public $id_pegawai;
    public $nip;
    private $db;
    public $mysqli;
    private $dbgaji;
    public $mysqligaji;

    public function __construct()
    {
        $this->db = Database::getInstance();
        $this->mysqli = $this->db->getConnection();
    }

    public function connectSimGaji()
    {
        $this->dbgaji = DatabaseGaji::getInstance();
        if ($this->dbgaji->getConnGajiStatus()) {
            $this->mysqligaji = $this->dbgaji->getConnection();
            return true;
        } else {
            return false;
        }
    }

    public function isServerStillALive()
    {
        return $this->dbgaji->getIsServerAlive();
    }

    public function closeKonekGaji()
    {
        return $this->dbgaji->closeConnGaji();
    }

    public function view_keluarga_simpeg($idp)
    {
        $sql = "SELECT b.*,
                  CASE WHEN b.status_tunjangan_skum = 'Dapat' AND (b.id_status_verifikasi = 1 OR b.id_status_verifikasi = 4
                  OR b.id_status_verifikasi = 5) THEN 'Valid' ELSE
                  (CASE WHEN b.status_tunjangan_skum = 'Tidak Dapat' AND (b.id_status_verifikasi = 2 OR b.id_status_verifikasi = 3
                  OR b.id_status_verifikasi = 6 OR b.id_status_verifikasi = 7 OR b.id_status_verifikasi = 8 OR b.id_status_verifikasi = 9
                  OR b.id_status_verifikasi = 10 OR b.id_status_verifikasi = 11)
                  THEN 'Valid' ELSE 'Belum Valid' END)
                  END AS status_validasi, DATE_FORMAT(b.tgl_lahir, '%d/%m/%Y') AS tgl_lahir,
                  CONCAT(TIMESTAMPDIFF(YEAR, DATE_FORMAT(b.tgl_lahir, '%Y/%m/%d'), CURRENT_DATE),' Thn ',
                  MOD(TIMESTAMPDIFF(MONTH, DATE_FORMAT(b.tgl_lahir, '%Y/%m/%d'), CURRENT_DATE), 12), ' Bln ',
                  (DATEDIFF(NOW(),DATE_FORMAT(b.tgl_lahir, '%Y/%m/%d')) -
                  DATEDIFF(DATE_ADD(b.tgl_lahir, INTERVAL (
                  (TIMESTAMPDIFF(YEAR, DATE_FORMAT(b.tgl_lahir, '%Y/%m/%d'), CURRENT_DATE)*12)+
                  MOD(TIMESTAMPDIFF(MONTH, DATE_FORMAT(b.tgl_lahir, '%Y/%m/%d'), CURRENT_DATE), 12)
                  ) MONTH) - INTERVAL 1 DAY,
                  DATE_FORMAT(b.tgl_lahir, '%Y/%m/%d')))-1, ' hari') AS umur
                  FROM
                (SELECT a.id_pegawai, a.id_keluarga, a.id_status, a.status_keluarga, a.nama, a.tempat_lahir, a.tgl_lahir, a.pekerjaan,
                CASE WHEN a.jk = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jenis_kelamin,
                CASE WHEN a.dapat_tunjangan = 0 THEN 'Tidak Dapat' ELSE 'Dapat' END AS status_tunjangan_skum, a.usia,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 'Meninggal (Tidak Dapat)' ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN 'Cerai (Tidak Dapat)' ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN 'Menikah (Dapat)' ELSE 'Tgl. Menikah Blm Diisi' END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 'Meninggal (Tidak Dapat)' ELSE
                  (CASE WHEN a.id_status = 10 THEN
                      (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN 'Anak < 21 Thn Menikah (Tidak Dapat)' ELSE
                            (CASE WHEN a.sudah_bekerja = 1 THEN 'Anak < 21 Thn Bekerja (Tidak Dapat)' ELSE 'Anak < 21 Thn (Dapat)' END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN 'Anak kuliah (Dapat)' ELSE 'Anak lulus kuliah (Tidak Dapat)' END) ELSE
                        'Anak tidak kuliah (Tidak Dapat)' END) ELSE 'Anak > 25 Thn (Tidak Dapat)' END) END)
                  ELSE 'Bukan Cakupan'END)
                 END)END AS status_verifikasi_data,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN DATE_FORMAT(a.tgl_cerai, '%d/%m/%Y') ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN DATE_FORMAT(a.tgl_menikah, '%d/%m/%Y') ELSE NULL END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') ELSE
                  (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.tgl_menikah ELSE
                            (CASE WHEN a.sudah_bekerja = 1 THEN NULL ELSE NULL END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE DATE_FORMAT(a.tgl_lulus, '%d/%m/%Y') END) ELSE
                        NULL END) ELSE NULL END) END) END)
                END AS ref_tanggal,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN a.akte_cerai ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE NULL END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
                  (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE
                            (CASE WHEN a.sudah_bekerja = 1 THEN CONCAT(a.akte_kerja,' - ',a.nama_perusahaan) ELSE NULL END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE NULL END) ELSE
                        NULL END) ELSE NULL END) END) END)
                END AS ref_keterangan,
                CASE WHEN a.id_status = 9 THEN
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 2 ELSE
                  (CASE WHEN a.tgl_cerai IS NOT NULL THEN 3 ELSE
                    (CASE WHEN a.tgl_menikah IS NOT NULL THEN 1 ELSE 0 END) END) END)
                ELSE
                (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 6 ELSE
                  (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN 10 ELSE
                            (CASE WHEN a.sudah_bekerja = 1 THEN 11 ELSE 4 END) END) ELSE
                    (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                      (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN 5 ELSE 7 END) ELSE
                        8 END) ELSE 9 END) END) END)
                END AS id_status_verifikasi,
                a.akte_kelahiran, DATE_FORMAT(a.tgl_akte_kelahiran, '%d/%m/%Y') AS tgl_akte_kelahiran,
                DATE_FORMAT(a.tgl_menikah, '%d/%m/%Y') AS tgl_menikah, a.akte_menikah, DATE_FORMAT(a.tgl_akte_menikah, '%d/%m/%Y') AS tgl_akte_menikah,
                DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') AS tgl_meninggal, a.akte_meninggal, DATE_FORMAT(a.tgl_akte_meninggal, '%d/%m/%Y') AS tgl_akte_meninggal,
                DATE_FORMAT(a.tgl_cerai, '%d/%m/%Y') AS tgl_cerai, a.akte_cerai, DATE_FORMAT(a.tgl_akte_cerai, '%d/%m/%Y') AS tgl_akte_cerai,
                a.no_ijazah, a.nama_sekolah, DATE_FORMAT(a.tgl_lulus, '%d/%m/%Y') AS tgl_lulus
                FROM
                (SELECT k.id_pegawai, k.id_keluarga, k.id_status, sk.status_keluarga, k.nama, k.tempat_lahir,
                k.tgl_lahir, k.pekerjaan, k.jk, k.dapat_tunjangan,
                ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(k.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia,
                k.tgl_menikah, k.akte_menikah, k.tgl_meninggal, k.akte_meninggal, k.tgl_cerai, k.akte_cerai,
                k.kuliah, k.tgl_lulus, k.akte_kelahiran, k.tgl_akte_kelahiran, k.tgl_akte_menikah,
                k.tgl_akte_meninggal, k.tgl_akte_cerai, k.no_ijazah, k.nama_sekolah, k.sudah_bekerja, k.akte_kerja, k.nama_perusahaan
                FROM keluarga k, status_kel sk
                WHERE k.id_pegawai = $idp AND k.id_status = sk.id_status AND (k.id_status = 9 OR k.id_status = 10)) a) b
                INNER JOIN keluarga k ON b.id_keluarga = k.id_keluarga
                ORDER BY b.id_status, b.tgl_lahir, b.nama";
        $result = $this->mysqli->query($sql);
        return $result;
    }

    public function view_keluarga_simgaji($nip)
    {
        $sql = "SELECT k.NIP, k.KDHUBKEL, k.NMKEL, CASE WHEN k.KDJENKEL = 1 THEN 'Laki-laki'
                      ELSE 'Perempuan' END AS jenkel, ht.NMHUBKEL ,
                    DATE_FORMAT(k.TGLLHR, '%d/%m/%Y') AS TGLLHR, DATE_FORMAT(k.TGLNIKAH, '%d/%m/%Y') AS TGLNIKAH,
                    DATE_FORMAT(k.TGLCERAI, '%d/%m/%Y') AS TGLCERAI, DATE_FORMAT(k.TGLWAFAT, '%d/%m/%Y') AS TGLWAFAT,
                    DATE_FORMAT(k.TGLSKS, '%d/%m/%Y') AS TGLSKS, k.TATSKS, k.NOSKS,
                    CASE WHEN k.KDTUNJANG = 0 THEN 'Tidak Tertunjang' ELSE
                      (CASE WHEN k.KDTUNJANG = 1 THEN 'Tidak Tertunjang' ELSE (
                      CASE WHEN k.KDTUNJANG = 2 THEN 'Tertunjang' ELSE (
                      CASE WHEN k.KDTUNJANG = 3 THEN 'Tercatat' ELSE 'Tidak diketahui' END) END) END)
                      END as status_tunjangan, k.NIPSUAMIISTRI,
                    DATE_FORMAT(k.UPDSTAMP, '%d/%m/%Y %H:%i:%s') AS TGLUPDATE, k.PEKERJAAN, k.INPUTER,
                    CONCAT(TIMESTAMPDIFF(YEAR, DATE_FORMAT(k.TGLLHR, '%Y/%m/%d'), CURRENT_DATE),' Thn ',
                      MOD(TIMESTAMPDIFF(MONTH, DATE_FORMAT(k.TGLLHR, '%Y/%m/%d'), CURRENT_DATE), 12), ' Bln ',
                      (DATEDIFF(NOW(),DATE_FORMAT(k.TGLLHR, '%Y/%m/%d')) -
                      DATEDIFF(DATE_ADD(k.TGLLHR, INTERVAL (
                      (TIMESTAMPDIFF(YEAR, DATE_FORMAT(k.TGLLHR, '%Y/%m/%d'), CURRENT_DATE)*12)+
                      MOD(TIMESTAMPDIFF(MONTH, DATE_FORMAT(k.TGLLHR, '%Y/%m/%d'), CURRENT_DATE), 12)
                      ) MONTH) - INTERVAL 1 DAY,
                      DATE_FORMAT(k.TGLLHR, '%Y/%m/%d')))-1, ' hari') AS USIA
                    FROM keluarga k, hubkel_tbl ht
                    WHERE k.KDHUBKEL = ht.KDHUBKEL AND k.NIP = '" . $nip . "' AND k.KDHUBKEL <> '00'";
        $result = $this->mysqligaji->query($sql);
        return $result;
    }

    public function updatePtkBPKAD($data)
    {
        if ($data['statusEdit'] == 'proses') {
            $idstatus = 9;
        } elseif ($data['statusEdit'] == 'tolak') {
            $idstatus = 10;
        } else {
            $idstatus = 11;
        }
        $strPTKStore = $data['strPTKStore'];
        $this->mysqli->autocommit(FALSE);
        $strPTKStore = explode('@', $strPTKStore);
        $qryOk = true;
        for ($x = 0; $x < sizeof($strPTKStore); $x++) {
            $strPtkItem = explode("#", $strPTKStore[$x]);
            $sqlInsert_Approved_Hist = "INSERT INTO ptk_historis_approve(tgl_approve_hist, approved_by_hist, id_status_ptk, approved_note_hist, id_ptk)
                            VALUES (NOW()," . $data['idpApprover'] . ",$idstatus,'" . $data['txtCatatanBpkad'] . "'," . $strPtkItem[0] . ")";
            if ($this->mysqli->query($sqlInsert_Approved_Hist) == TRUE) {
                $sqlUpdatePtk = "UPDATE ptk_master set idstatus_ptk=$idstatus, tgl_approve=NOW(),
                                        approved_by=" . $data['idpApprover'] . ",approved_note= '" . $data['txtCatatanBpkad'] . "'
                                        where id_ptk=" . $strPtkItem[0];
                if ($this->mysqli->query($sqlUpdatePtk) == TRUE){
                    //$this->mysqli->commit();
                    $qryOk = true;
                } else {
                    $this->mysqli->rollback();
                    $qryOk = false;
                    break;
                }
            }
        }
        if($qryOk == true){
            echo 1;
        }else{
            echo 0;
        }
    }

    public function addDraftMutasiTunjanganJiwa($data){
        if ($this->connectSimGaji()) {
            $strPTKStore = $data['strPTKStore'];
            $strPTKStore = explode('@', $strPTKStore);
            $jmlNotInpAll = 0;
            $jmlNotExecAll = 0;
            error_reporting(0);
            for ($x = 0; $x < sizeof($strPTKStore); $x++) {
                $strSKItem = explode("#", $strPTKStore[$x]);
                if ($this->dbgaji->getIsServerAlive()) {
                    $sql = "SELECT COUNT(NIP) as jumlah, m.KDSTAWIN, m.KDDATI2, m.KDDATI1
                            FROM mstpegawai m WHERE m.NIP = '" . $strSKItem[1] . "'";
                    $query = $this->mysqligaji->query($sql);
                    while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                        $countNIP = $oto[0];
                        $kdStawin = $oto[1];
                        $kd_dati2 = $oto[2];
                        $kd_dati1 = $oto[3];
                    }
                    if ((Int)$countNIP > 0) {
                        $findInGaji = 'TRUE';
                    } else {
                        $findInGaji = 'FALSE';
                    }

                    $sqlJns = "SELECT pj.jenis_pengajuan FROM ptk_master pm, ptk_jenis_pengajuan pj 
                            WHERE pm.id_jenis_pengajuan = pj.id_jenis_pengajuan AND pm.id_ptk = ".$strSKItem[0];
                    $qJenis = $this->mysqli->query($sqlJns);
                    while ($o = $qJenis->fetch_array(MYSQLI_NUM)) {
                        $jenisPengajuan = $o[0];
                    }
                    $sqlInsert = "INSERT INTO gaji_historis_jiwa(TMTGAJI,NIP,JISTRI,JANAK,KETERANGAN,
                    KDDATI1,KDDATI2,kdstawin,id_ptk_simpeg,sts_execute,idpegawai_drafter,is_find_simgaji)
                    VALUES ('" . $data['thnGaji'] . '-' . $data['blnGaji'] . "-01','" . $strSKItem[1] . "'," .
                    $strSKItem[2] . "," . $strSKItem[3] . ",'".$jenisPengajuan."','".$kd_dati1."','".$kd_dati2."',".$kdStawin.
                    ",".$strSKItem[0].",FALSE,". $_SESSION['profil']->id_pegawai . ",$findInGaji)";
                    if ($this->mysqli->query($sqlInsert) == TRUE) {
                        $statusAlive = true;
                        //Insert data ke Tabel historis jiwa di SIMGAJI
                        //=============================================
                        $dataGaji['TMTGAJI'] = "'" . $data['thnGaji'] . '-' . $data['blnGaji'] . "-01'";
                        $dataGaji['NIP'] = "'" . $strSKItem[1] . "'";
                        $dataGaji['JISTRI'] = $strSKItem[2];
                        $dataGaji['JANAK'] = $strSKItem[3];
                        $dataGaji['KETERANGAN'] = "'".$jenisPengajuan."'";
                        $dataGaji['KDDATI1'] = "'" . $kd_dati1 . "'";
                        $dataGaji['KDDATI2'] = "'" . $kd_dati2 . "'";
                        $dataGaji['kdstawin'] = $kdStawin;
                        $resultCode = $this->insertHistorisJiwaToSIMGAJI($dataGaji);
                        switch ($resultCode) {
                            case 200:
                                $msg = "Tereksekusi ke SIMGAJI";
                                $sts_execute = 'TRUE';
                                break;
                            case 1062:
                                $msg = 'Err.Code: ' . $resultCode . ". Data sudah ada di SIMGAJI";
                                $sts_execute = 'FALSE';
                                $jmlNotExecAll += 1;
                                break;
                            case 1142:
                                $msg = 'Err.Code: ' . $resultCode . ". Tidak memiliki akses untuk memperbarui data ke SIMGAJI";
                                $sts_execute = 'FALSE';
                                $jmlNotExecAll += 1;
                                break;
                            case 1304 :
                                $msg = 'Err.Code: ' . $resultCode . ". Data sudah ada di SIMGAJI";
                                $sts_execute = 'FALSE';
                                $jmlNotExecAll += 1;
                                break;
                            default:
                                $msg = 'Err.Code: ' . $resultCode . ". Ada permasalahan sehingga tidak dapat memperbarui data ke SIMGAJI";
                                $sts_execute = 'FALSE';
                                $jmlNotExecAll += 1;
                        }
                        $sqlupdate = "UPDATE gaji_historis_jiwa SET sts_execute = " . $sts_execute . ", tgl_execute = NOW(),
                                idpegawai_execute = " . $_SESSION['profil']->id_pegawai . ",keterangan_execute = '" . $msg . "'" .
                            " WHERE TMTGAJI = " . $dataGaji['TMTGAJI'] . " AND NIP = " . $dataGaji['NIP'];
                        if ($this->mysqli->query($sqlupdate) == TRUE) {
                        } else {
                            $jmlNotExecAll += 1;
                        }
                    } else {
                        $statusAlive = true;
                        $jmlNotInpAll += 1; //printf("Errorcode: %d\n", $this->mysqli->errno);
                    }
                } else {
                    $statusAlive = false;
                    break;
                }
            }
            if ($statusAlive) {
                if ($jmlNotInpAll == 0) {
                    if ($jmlNotExecAll == 0) {
                        echo 1;
                    } else {
                        echo 2;
                    }
                } else {
                    echo 3;
                }
            } else {
                echo 5; //rollback_notconnect_sim_gaji
            }
            $this->dbgaji->closeConnGaji();
            error_reporting(1);
        } else {
            echo 4; //notconnect_simgaji
        }
    }

    public function insertHistorisJiwaToSIMGAJI($data){
        $sql = "INSERT INTO historis_jiwa(TMTGAJI,NIP,JISTRI,JANAK,KETERANGAN,KDDATI1,KDDATI2,kdstawin) VALUES
                (" . $data['TMTGAJI'] . "," . $data['NIP'] . "," . $data['JISTRI'] . "," . $data['JANAK'] . "," .
            $data['KETERANGAN'] . "," . $data['KDDATI1'] . "," . $data['KDDATI2'] . "," . $data['kdstawin'] . ")";
        //echo $sql;
        $result = $this->mysqligaji->query($sql);
        if ($result) {
            return 200;
        } else {
            return $this->mysqligaji->errno; //printf("Errorcode: %d\n", $this->mysqligaji->errno);
        }
    }

    public function checkHistorisJiwa($blngaji, $thngaji, $nip)
    {
        $sql = "SELECT COUNT(*) AS jumlah
                    FROM historis_jiwa hj
                    WHERE hj.NIP = '" . $nip . "' AND MONTH(hj.TMTGAJI) = $blngaji AND YEAR(hj.TMTGAJI) = $thngaji";
        $result = $this->mysqligaji->query($sql);
        return $result;
    }

    public function view_biodata_simpeg($idp)
    {
        $sql = "SELECT b.*,
            CASE WHEN b.jenjab = 'Struktural'
              THEN (CASE WHEN (b.eselon = 'IIA' OR b.eselon = 'IIB') THEN 60 ELSE 58 END)
              ELSE (CASE WHEN jaf.bup IS NULL THEN 58 ELSE jaf.bup END)
              END AS usia_pensiun,
            DATE_FORMAT(CASE WHEN b.jenjab = 'Struktural' THEN DATE_SUB(
            LAST_DAY(DATE_ADD(DATE_ADD(b.tgl_lahir, INTERVAL (SELECT CASE WHEN (b.eselon = 'IIA' OR b.eselon = 'IIB') THEN 60 ELSE 58 END) YEAR), INTERVAL 1 MONTH)
            ), INTERVAL DAY(LAST_DAY(DATE_ADD(DATE_ADD(b.tgl_lahir, INTERVAL (SELECT CASE WHEN (b.eselon = 'IIA' OR b.eselon = 'IIB') THEN 60 ELSE 58 END) YEAR), INTERVAL 1 MONTH))
            )-1 DAY) ELSE DATE_SUB( LAST_DAY( DATE_ADD(DATE_ADD(b.tgl_lahir, INTERVAL (SELECT CASE WHEN jaf.bup IS NULL THEN 58 ELSE jaf.bup END) YEAR), INTERVAL 1 MONTH)),
            INTERVAL DAY(LAST_DAY(DATE_ADD(DATE_ADD(b.tgl_lahir, INTERVAL (SELECT CASE WHEN jaf.bup IS NULL THEN 58 ELSE jaf.bup END) YEAR), INTERVAL 1 MONTH))
            )-1 DAY) END,'%d/%m/%Y') AS tmt_bup
            FROM (SELECT
            a.*, GROUP_CONCAT(' ',a.tingkat_pendidikan,'-',a.jurusan_pendidikan,' (',a.tahun_lulus,')') AS sekolah,
            DATE_FORMAT(a.tgl_lahir,  '%d/%m/%Y') AS tgl_lahir_2,
            CONCAT(TIMESTAMPDIFF(YEAR, DATE_FORMAT(a.tgl_lahir, '%Y/%m/%d'), CURRENT_DATE),' Thn ',
              MOD(TIMESTAMPDIFF(MONTH, DATE_FORMAT(a.tgl_lahir, '%Y/%m/%d'), CURRENT_DATE), 12), ' Bln ',
              (DATEDIFF(NOW(),DATE_FORMAT(a.tgl_lahir, '%Y/%m/%d')) -
              DATEDIFF(DATE_ADD(a.tgl_lahir, INTERVAL (
              (TIMESTAMPDIFF(YEAR, DATE_FORMAT(a.tgl_lahir, '%Y/%m/%d'), CURRENT_DATE)*12)+
              MOD(TIMESTAMPDIFF(MONTH, DATE_FORMAT(a.tgl_lahir, '%Y/%m/%d'), CURRENT_DATE), 12)
              ) MONTH) - INTERVAL 1 DAY,
              DATE_FORMAT(a.tgl_lahir, '%Y/%m/%d')))-1, ' hari') AS usia
            FROM
            (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
            nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, p.jenjab, p.pangkat_gol, j.eselon,
            CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
            (SELECT jm.nama_jfu AS jabatan
             FROM jfu_pegawai jp, jfu_master jm
             WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
            ELSE j.jabatan END END AS jabatan, uk.nama_baru as unit, p.tempat_lahir,
            p.tgl_lahir, p.telepon, p.ponsel, p.email, pend.tingkat_pendidikan, pend.jurusan_pendidikan, pend.tahun_lulus,
            DATE_FORMAT(p.tgl_pensiun_dini,  '%d/%m/%Y') AS tgl_pensiun, p.status_aktif, p.flag_pensiun
            FROM pegawai p
            LEFT JOIN jabatan j ON p.id_j = j.id_j
            LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
            LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
            LEFT JOIN pendidikan pend ON p.id_pegawai = pend.id_pegawai
            WHERE p.id_pegawai = " . $idp . ") a
            GROUP BY a.id_pegawai) b
            LEFT JOIN (SELECT nama_jafung, pangkat_gol, MAX(bup) AS bup FROM jafung
            GROUP BY nama_jafung, pangkat_gol) jaf ON jaf.nama_jafung = b.jabatan AND jaf.pangkat_gol = b.pangkat_gol";

        $result = $this->mysqli->query($sql);
        return $result;
    }

    public function rekap_keluarga($idp)
    {
        $sql = "SELECT d.*, COUNT(pm.id_ptk) AS jml_ptk FROM
                    (SELECT c.id_pegawai, c.nip_baru, c.nama_pegawai, c.pangkat_gol, c.jabatan, c.eselon,
                    SUM(IF(c.id_status = 9,1,0)) as jml_pasangan, SUM(IF(c.id_status = 10,1,0)) as jml_anak,
                    SUM(IF((c.id_status <> 9 AND c.id_status <> 10),1,0)) as jml_lainnya,
                    COUNT(c.id_keluarga) AS jml_keluarga,
                    SUM(IF(c.status_validasi = 'Valid',1,0)) as jml_valid,
                    SUM(IF(c.status_validasi = 'Belum Valid / Tunjangan di Pasangan',1,0)) as jml_non_valid,
                    SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) as pasangan_valid_dapat,
                    SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) as anak_valid_dapat,
                    CASE WHEN SUM(IF(c.status_validasi = 'Belum Valid / Tunjangan di Pasangan',1,0)) = 0 THEN
                    1 ELSE (
                      CASE WHEN
                      (SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) +
                      SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0))) = 3
                      THEN 1 ELSE (CASE WHEN
                        (SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) +
                        SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0))) = 0
                      THEN 2 ELSE (CASE WHEN
                      (SUM(IF(c.id_status = 9 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) <= 1 AND
                      SUM(IF(c.id_status = 10 AND c.status_validasi = 'Valid' AND c.status_tunjangan_skum = 'Dapat',1,0)) <= 2 AND
                      SUM(IF(c.id_status = 10,1,0)) > 2)
                      THEN 1 ELSE 3 END)END)
                      END)
                    END as status_verifikasi
                    FROM (SELECT b.*,
                      CASE WHEN b.status_tunjangan_skum = 'Dapat' AND (b.id_status_verifikasi = 1 OR b.id_status_verifikasi = 4
                      OR b.id_status_verifikasi = 5) THEN 'Valid' ELSE
                      (CASE WHEN b.status_tunjangan_skum = 'Tidak Dapat' AND (b.id_status_verifikasi = 2 OR b.id_status_verifikasi = 3
                      OR b.id_status_verifikasi = 6 OR b.id_status_verifikasi = 7 OR b.id_status_verifikasi = 8 OR b.id_status_verifikasi = 9
                      OR b.id_status_verifikasi = 10 OR b.id_status_verifikasi = 11)
                      THEN 'Valid' ELSE 'Belum Valid / Tunjangan di Pasangan' END)
                      END AS status_validasi
                      FROM
                    (SELECT a.id_pegawai, a.nip_baru, a.nama_pegawai, a.pangkat_gol, a.jabatan, a.eselon,
                    a.id_keluarga, a.id_status, a.status_keluarga, a.nama, a.tempat_lahir, a.tgl_lahir, a.pekerjaan,
                    CASE WHEN a.jk = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS jenis_kelamin,
                    CASE WHEN a.dapat_tunjangan = 0 THEN 'Tidak Dapat' ELSE 'Dapat' END AS status_tunjangan_skum, a.usia,
                    CASE WHEN a.id_status = 9 THEN
                    (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 'Meninggal (Tidak Dapat)' ELSE
                      (CASE WHEN a.tgl_cerai IS NOT NULL THEN 'Cerai (Tidak Dapat)' ELSE
                        (CASE WHEN a.tgl_menikah IS NOT NULL THEN 'Menikah (Dapat)' ELSE 'Tgl. Menikah Blm Diisi' END) END) END)
                    ELSE
                    (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 'Meninggal (Tidak Dapat)' ELSE
                      (CASE WHEN a.id_status = 10 THEN
                          (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN 'Anak < 21 Thn Menikah (Tidak Dapat)' ELSE
                      (CASE WHEN a.sudah_bekerja = 1 THEN 'Anak < 21 Thn Bekerja (Tidak Dapat)' ELSE 'Anak < 21 Thn (Dapat)' END) END) ELSE
                        (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                          (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN 'Anak kuliah (Dapat)' ELSE 'Anak lulus kuliah (Tidak Dapat)' END) ELSE
                            'Anak tidak kuliah (Tidak Dapat)' END) ELSE 'Anak > 25 Thn (Tidak Dapat)' END) END)
                      ELSE 'Bukan Cakupan'END)
                     END)END AS status_verifikasi_data,

                    CASE WHEN a.id_status = 9 THEN
                    (CASE WHEN a.tgl_meninggal IS NOT NULL THEN DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') ELSE
                      (CASE WHEN a.tgl_cerai IS NOT NULL THEN DATE_FORMAT(a.tgl_cerai, '%d/%m/%Y') ELSE
                        (CASE WHEN a.tgl_menikah IS NOT NULL THEN DATE_FORMAT(a.tgl_menikah, '%d/%m/%Y') ELSE NULL END) END) END)
                    ELSE
                    (CASE WHEN a.tgl_meninggal IS NOT NULL THEN DATE_FORMAT(a.tgl_meninggal, '%d/%m/%Y') ELSE
                      (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.tgl_menikah ELSE
                      (CASE WHEN a.sudah_bekerja = 1 THEN NULL ELSE NULL END) END) ELSE
                        (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                          (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE DATE_FORMAT(a.tgl_lulus, '%d/%m/%Y') END) ELSE
                            NULL END) ELSE NULL END) END) END)
                    END AS ref_tanggal,

                    CASE WHEN a.id_status = 9 THEN
                    (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
                      (CASE WHEN a.tgl_cerai IS NOT NULL THEN a.akte_cerai ELSE
                        (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE NULL END) END) END)
                    ELSE
                    (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
                      (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE
                      (CASE WHEN a.sudah_bekerja = 1 THEN a.akte_kerja ELSE NULL END) END) ELSE
                        (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                          (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE NULL END) ELSE
                            NULL END) ELSE NULL END) END) END)
                    END AS ref_keterangan,

                    CASE WHEN a.id_status = 9 THEN
                    (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 2 ELSE
                      (CASE WHEN a.tgl_cerai IS NOT NULL THEN 3 ELSE
                        (CASE WHEN a.tgl_menikah IS NOT NULL THEN 1 ELSE 0 END) END) END)
                    ELSE
                    (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 6 ELSE
                      (CASE WHEN a.usia < 21 THEN (CASE WHEN a.tgl_menikah IS NOT NULL THEN 10 ELSE
                      (CASE WHEN a.sudah_bekerja = 1 THEN 11 ELSE 4 END) END) ELSE
                        (CASE WHEN (a.usia >= 21 AND a.usia < 25) THEN
                          (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN 5 ELSE 7 END) ELSE
                            8 END) ELSE 9 END) END) END)
                    END AS id_status_verifikasi
                    FROM
                    (SELECT p.id_pegawai, p.nip_baru, p.nama as nama_pegawai, p.pangkat_gol,
                    CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                    (SELECT jm.nama_jfu AS jabatan
                     FROM jfu_pegawai jp, jfu_master jm
                     WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                    ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon,
                    k.id_keluarga, k.id_status, sk.status_keluarga, k.nama, k.tempat_lahir, k.tgl_lahir, k.pekerjaan, k.jk, k.dapat_tunjangan,
                    ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(k.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia,
                    k.tgl_menikah, k.akte_menikah, k.tgl_meninggal, k.akte_meninggal, k.tgl_cerai, k.akte_cerai,
                    k.kuliah, k.tgl_lulus, k.sudah_bekerja, k.akte_kerja
                    FROM pegawai p LEFT JOIN keluarga k ON p.id_pegawai = k.id_pegawai
                    LEFT JOIN jabatan j ON p.id_j = j.id_j
                    LEFT JOIN status_kel sk ON k.id_status = sk.id_status
                    LEFT JOIN current_lokasi_kerja clk ON p.id_pegawai = clk.id_pegawai
                    LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja
                    WHERE p.id_pegawai = " . $idp . ") a
                    WHERE a.id_pegawai IS NOT NULL) b
                    INNER JOIN keluarga k ON b.id_keluarga = k.id_keluarga
                    ORDER BY b.id_status, b.tgl_lahir, b.nama) c
                    GROUP BY c.id_pegawai, c.nip_baru, c.nama_pegawai
                    ORDER BY c.eselon, c.pangkat_gol DESC, c.nama_pegawai ASC) d
                    LEFT JOIN ptk_master pm ON d.id_pegawai = pm.id_pegawai_pemohon
                    GROUP BY d.id_pegawai ORDER BY d.eselon, d.pangkat_gol DESC, d.nama_pegawai ASC";
        $result = $this->mysqli->query($sql);
        return $result;
    }

    public function view_biodata_simgaji($nip)
    {
        $sql = "SELECT m.NIP, m.GLRDEPAN, m.NAMA, m.GLRBELAKANG, m.KDJENKEL, m.TEMPATLHR,
                    DATE_FORMAT(m.TGLLHR,  '%d/%m/%Y') AS TGLLHR,
                    CONCAT(TIMESTAMPDIFF(YEAR, DATE_FORMAT(m.TGLLHR, '%Y/%m/%d'), CURRENT_DATE),' Thn ',
                      MOD(TIMESTAMPDIFF(MONTH, DATE_FORMAT(m.TGLLHR, '%Y/%m/%d'), CURRENT_DATE), 12), ' Bln ',
                      (DATEDIFF(NOW(),DATE_FORMAT(m.TGLLHR, '%Y/%m/%d')) -
                      DATEDIFF(DATE_ADD(m.TGLLHR, INTERVAL (
                      (TIMESTAMPDIFF(YEAR, DATE_FORMAT(m.TGLLHR, '%Y/%m/%d'), CURRENT_DATE)*12)+
                      MOD(TIMESTAMPDIFF(MONTH, DATE_FORMAT(m.TGLLHR, '%Y/%m/%d'), CURRENT_DATE), 12)
                      ) MONTH) - INTERVAL 1 DAY,
                      DATE_FORMAT(m.TGLLHR, '%Y/%m/%d')))-1, ' hari') AS USIA,
                    m.AGAMA, m.PENDIDIKAN, m.TMTCAPEG,m.KDSTAPEG, DATE_FORMAT(m.TMTSTOP,'%d/%m/%Y') AS TMTSTOP,
                    m.KDPANGKAT, m.MKGOLT, m.BLGOLT, m.GAPOK, m.KDESELON, m.KDFUNGSI,
                    m.BUP, m.KDSKPD, m.KDSATKER, m.ALAMAT, m.NOTELP, m.NOKTP, m.NPWP, m.NPWPZ,
                    m.NOKARPEG, st.NMSTAPEG, pt.NMGOL, satker.NMSATKER, skpd.NMSKPD, ft.NM_FUNGSI
                    FROM mstpegawai m LEFT JOIN fungsional_tbl ft ON m.KDFUNGSI = ft.KDFUNGSI,
                    stapeg_tbl st, pangkat_tbl pt, skpd_tbl skpd, satker_tbl satker
                    WHERE m.KDSTAPEG = st.KDSTAPEG AND
                    m.NIP IN ('" . $nip . "') AND m.KDPANGKAT = pt.KDPANGKAT AND m.KDSKPD = skpd.KDSKPD
                    AND m.KDSATKER = satker.KDSATKER";
        $result = $this->mysqligaji->query($sql);
        return $result;
    }

    public function view_rekap_keluarga_simgaji($nip)
    {
        $sql = "SELECT gm.NIP, gm.NAMA, DATE_FORMAT(gm.TGLLHR, '%d-%m-%Y') AS TGLLHR, gpt.NMGOL, gst.NMSTAPEG,
                    DATE_FORMAT(gm.TMTSTOP, '%d-%m-%Y') AS TMTSTOP,
                    SUM(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'isteri / suami%') THEN 1 ELSE 0 END) AS jml_pasangan,
                    COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) REGEXP 'anak+$')
                      AND (LOWER(ht.NMHUBKEL) NOT LIKE '%tiri%')
                      AND (LOWER(ht.NMHUBKEL) NOT LIKE '%angkat%') THEN k.NMKEL END) AS jml_anak_kandung,
                    COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak tiri%') THEN k.NMKEL END) AS jml_anak_tiri,
                    COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak angkat%') THEN k.NMKEL END) AS jml_anak_angkat,
                    (COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) REGEXP 'anak+$')
                      AND (LOWER(ht.NMHUBKEL) NOT LIKE '%tiri%')
                      AND (LOWER(ht.NMHUBKEL) NOT LIKE '%angkat%') THEN k.NMKEL END) +
                    COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak tiri%') THEN k.NMKEL END) +
                    COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak angkat%') THEN k.NMKEL END)) AS jml_anak,
                    COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE '%lain-lain%') THEN k.NMKEL END) AS jml_lainnya,
                    (
                      SUM(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'isteri / suami%') THEN 1 ELSE 0 END) +
                      COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) REGEXP 'anak+$')
                      AND (LOWER(ht.NMHUBKEL) NOT LIKE '%tiri%')
                      AND (LOWER(ht.NMHUBKEL) NOT LIKE '%angkat%') THEN k.NMKEL END) +
                      COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak tiri%') THEN k.NMKEL END) +
                      COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE 'anak angkat%') THEN k.NMKEL END) +
                      COUNT(CASE WHEN (LOWER(ht.NMHUBKEL) LIKE '%lain-lain%') THEN k.NMKEL END)
                    ) AS jml_keluarga,
                    SUM(CASE WHEN ((LOWER(ht.NMHUBKEL) LIKE 'isteri / suami%') AND k.KDTUNJANG = 2) THEN 1 ELSE 0 END) AS jml_pasangan_tertunjang,
                    SUM(CASE WHEN ((LOWER(ht.NMHUBKEL) LIKE 'anak%') AND k.KDTUNJANG = 2) THEN 1 ELSE 0 END) AS jml_anak_tertunjang
                    FROM mstpegawai gm
                    LEFT JOIN keluarga k ON gm.NIP = k.NIP AND k.KDHUBKEL <> '00'
                    LEFT JOIN hubkel_tbl ht ON k.KDHUBKEL = ht.KDHUBKEL
                    LEFT JOIN pangkat_tbl gpt ON gm.KDPANGKAT = gpt.KDPANGKAT
                    LEFT JOIN stapeg_tbl gst ON gm.KDSTAPEG = gst.KDSTAPEG
                    WHERE gm.KDSTAPEG = 4 AND gm.KDSTAPEG NOT IN (1,2,22,11) AND gm.NIP = '" . $nip . "'
                    GROUP BY gm.NIP";
        $result = $this->mysqligaji->query($sql);
        return $result;
    }

    public function view_historis_jiwa($nip)
    {
        $sql = "SELECT DATE_FORMAT(hj.TMTGAJI, '%d/%m/%Y') AS TMTGAJI, hj.JISTRI, hj.JANAK, hj.KETERANGAN,
                    DATE_FORMAT(hj.TGLUPDATE, '%d/%m/%Y %H:%i:%s') AS TGLUPDATE, st.nmstawin
                    FROM historis_jiwa hj, stawin_tbl st
                    WHERE hj.NIP = '" . $nip . "' AND hj.kdstawin = st.kdstawin
                    ORDER BY hj.TMTGAJI";
        $result = $this->mysqligaji->query($sql);
        return $result;
    }

    public function listBulan()
    {
        $bln = array
        (
            array(1, "Januari"),
            array(2, "Februari"),
            array(3, "Maret"),
            array(4, "April"),
            array(5, "Mei"),
            array(6, "Juni"),
            array(7, "Juli"),
            array(8, "Agustus"),
            array(9, "September"),
            array(10, "Oktober"),
            array(11, "November"),
            array(12, "Desember")
        );
        return $bln;
    }

    public function listTahun()
    {
        /*$i = 0;
        $thn[$i] = date("Y");
        for ($x = 1; $x <= 4; $x++) {
            $thn[$x] = $thn[$i] + $x;
        }
        return $thn;*/
        $i = 3;
        $thn[$i] = date("Y");
        for ($x = 0; $x <= 2; $x++) {
            $thn[$x] = $thn[$i] - ($i-$x);
        }
        for ($x = 4; $x <= 6; $x++) {
            $thn[$x] = $thn[$i] + ($x-2);
        }
        return $thn;
    }

    public function addDraftMutasiGapok($data)
    {
        if ($this->connectSimGaji()) {
            //$this->mysqli->autocommit(FALSE); Engine MyISAM tdk support Transaction
            $strSKStore = $data['strSKStore'];
            $penerbit = 'BKPSDA';//$data['penerbitSk']
            $strSKStore = explode("@", $strSKStore);
            $jmlNotInpAll = 0;
            $jmlNotExecAll = 0;
            error_reporting(0);
            for ($x = 0; $x < sizeof($strSKStore); $x++) {
                $strSKItem = explode("#", $strSKStore[$x]);
                if ($this->dbgaji->getIsServerAlive()) {
                    $sql = "SELECT KDPANGKAT FROM gaji_pangkat_tbl WHERE NMGOL = '" . $strSKItem[5] . "'";
                    $query = $this->mysqli->query($sql);
                    while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                        $kdpangkat = $oto[0];
                    }
                    $sql = "SELECT COUNT(NIP) as jumlah, m.KDSTAPEG, m.KDDATI2, m.KDDATI1
                            FROM mstpegawai m WHERE m.NIP = '" . $strSKItem[9] . "'";
                    $query = $this->mysqligaji->query($sql);
                    while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                        $countNIP = $oto[0];
                        $kdStapeg = $oto[1];
                        $kd_dati2 = $oto[2];
                        $kd_dati1 = $oto[3];
                    }
                    if ((Int)$countNIP > 0) {
                        $findInGaji = 'TRUE';
                    } else {
                        $findInGaji = 'FALSE';
                        $kdStapeg = 'NULL';
                    }
                    $sqlInsert = "INSERT INTO gaji_historis_gapok(TMTGAJI,NIP,kdstapeg,KDPANGKAT,GAPOK,MASKER,PRSNGAPOK,TMTTABEL,
                            TGLSKEP,NOMORSKEP,PENERBITSKEP,tmt,KETERANGAN,KDDATI1,KDDATI2,BLGOLT,INPUTER,id_sk_simpeg,sts_execute,
                            idpegawai_drafter,is_find_simgaji)
                            VALUES ('" . $data['thnGaji'] . '-' . $data['blnGaji'] . "-01','" . $strSKItem[9] . "',$kdStapeg, '$kdpangkat',
                            " . $strSKItem[10] . "," . $strSKItem[6] . "," . $strSKItem[11] . ",'" . $data['thnPeraturanGaji'] . "-01-01'," .
                        "'" . $strSKItem[3] . "','" . $strSKItem[2] . "','" . $penerbit . "','" . $strSKItem[4] . "','" . $strSKItem[0] . "'," .
                        "'" . $kd_dati1 . "','" . $kd_dati2 . "'," . $strSKItem[7] . ",'" . $_SESSION['profil']->nip . "'," . $strSKItem[1] . ",FALSE," . $_SESSION['profil']->id_pegawai . ",
                            $findInGaji)";
                    if ($this->mysqli->query($sqlInsert) == TRUE) {
                        $statusAlive = true;
                        //Insert data ke Tabel historis gapok di SIMGAJI
                        //==============================================
                        $dataGaji['TMTGAJI'] = "'" . $data['thnGaji'] . '-' . $data['blnGaji'] . "-01'";
                        $dataGaji['NIP'] = "'" . $strSKItem[9] . "'";
                        $dataGaji['kdstapeg'] = $kdStapeg;
                        $dataGaji['kd_dati2'] = "'" . $kd_dati2 . "'";
                        $dataGaji['kd_dati1'] = "'" . $kd_dati1 . "'";
                        $dataGaji['KDPANGKAT'] = "'" . $kdpangkat . "'";
                        $dataGaji['GAPOK'] = $strSKItem[10];
                        $dataGaji['MASKER'] = $strSKItem[6];
                        $dataGaji['PRSNGAPOK'] = $strSKItem[11];
                        $dataGaji['TMTTABEL'] = "'" . $data['thnPeraturanGaji'] . "-01-01'";
                        $dataGaji['TGLSKEP'] = "'" . $strSKItem[3] . "'";
                        $dataGaji['NOMORSKEP'] = "'" . $strSKItem[2] . "'";
                        $dataGaji['PENERBITSKEP'] = "'" . $penerbit . "'";
                        $dataGaji['tmt'] = "'" . $strSKItem[4] . "'";
                        $dataGaji['KETERANGAN'] = "'" . $strSKItem[0] . "'";
                        $dataGaji['TGLUPDATE'] = "NOW()";
                        $dataGaji['FSCAN'] = 'NULL';
                        $dataGaji['TMTKGB'] = 'NULL';
                        $dataGaji['BLGOLT'] = $strSKItem[7];
                        $dataGaji['FLAG'] = 0;
                        $dataGaji['INPUTER'] = "'" . $_SESSION['profil']->nip . "'";
                        $resultCode = $this->insertHistorisGapokToSIMGAJI($dataGaji);
                        switch ($resultCode) {
                            case 200:
                                $msg = "Tereksekusi ke SIMGAJI";
                                $sts_execute = 'TRUE';
                                break;
                            case 1062:
                                $msg = 'Err.Code: ' . $resultCode . ". Data sudah ada di SIMGAJI";
                                $sts_execute = 'FALSE';
                                $jmlNotExecAll += 1;
                                break;
                            case 1142:
                                $msg = 'Err.Code: ' . $resultCode . ". Tidak memiliki akses untuk memperbarui data ke SIMGAJI";
                                $sts_execute = 'FALSE';
                                $jmlNotExecAll += 1;
                                break;
                            case 1304 :
                                $msg = 'Err.Code: ' . $resultCode . ". Data sudah ada di SIMGAJI";
                                $sts_execute = 'FALSE';
                                $jmlNotExecAll += 1;
                                break;
                            default:
                                $msg = 'Err.Code: ' . $resultCode . ". Ada permasalahan sehingga tidak dapat memperbarui data ke SIMGAJI";
                                $sts_execute = 'FALSE';
                                $jmlNotExecAll += 1;
                        }
                        $sqlupdate = "UPDATE gaji_historis_gapok SET sts_execute = " . $sts_execute . ", tgl_execute = NOW(),
                                idpegawai_execute = " . $_SESSION['profil']->id_pegawai . ",keterangan_execute = '" . $msg . "'" .
                            " WHERE TMTGAJI = " . $dataGaji['TMTGAJI'] . " AND NIP = " . $dataGaji['NIP'];
                        if ($this->mysqli->query($sqlupdate) == TRUE) {
                        } else {
                            $jmlNotExecAll += 1;
                        }
                    } else {
                        $statusAlive = true;
                        $jmlNotInpAll += 1; //printf("Errorcode: %d\n", $this->mysqli->errno);
                    }
                } else {
                    $statusAlive = false;
                    break;
                }
            }
            if ($statusAlive) {
                //$this->mysqli->commit();
                if ($jmlNotInpAll == 0) {
                    if ($jmlNotExecAll == 0) {
                        echo 1;
                    } else {
                        echo 2;
                    }
                } else {
                    echo 3;
                }
            } else {
                //$this->mysqli->rollback();
                echo 5; //rollback_notconnect_sim_gaji
            }
            $this->dbgaji->closeConnGaji();
            error_reporting(1);
        } else {
            echo 4; //notconnect_simgaji
        }
    }

    public function checkHistorisGapok($blngaji, $thngaji, $nip)
    {
        $sql = "SELECT COUNT(*) AS jumlah
                    FROM historis_gapok hg
                    WHERE hg.NIP = '" . $nip . "' AND MONTH(hg.TMTGAJI) = $blngaji AND YEAR(hg.TMTGAJI) = $thngaji";
        $result = $this->mysqligaji->query($sql);
        return $result;
    }

    public function checkNIP($nip)
    {
        $sql = "SELECT COUNT(*) AS jumlah
                    FROM mstpegawai m
                    WHERE m.NIP = '" . $nip . "'";
        $result = $this->mysqligaji->query($sql);
        return $result;
    }

    public function insertHistorisGapokToSIMGAJI($data)
    {
        $sql = "INSERT INTO historis_gapok(TMTGAJI,NIP,kdstapeg,KDPANGKAT,GAPOK,MASKER,PRSNGAPOK,TMTTABEL,TGLSKEP,NOMORSKEP,
                PENERBITSKEP,tmt,KETERANGAN,TGLUPDATE,KDDATI1,KDDATI2,FSCAN,TMTKGB,BLGOLT,FLAG,INPUTER) VALUES
                (" . $data['TMTGAJI'] . "," . $data['NIP'] . "," . $data['kdstapeg'] . "," . $data['KDPANGKAT'] . "," .
            $data['GAPOK'] . "," . $data['MASKER'] . "," . $data['PRSNGAPOK'] . "," . $data['TMTTABEL'] . "," .
            $data['TGLSKEP'] . "," . $data['NOMORSKEP'] . "," . $data['PENERBITSKEP'] . "," . $data['tmt'] . "," .
            $data['KETERANGAN'] . "," . $data['TGLUPDATE'] . ",'" . $data['KDDATI1'] . "','" . $data['KDDATI2'] . "'," . $data['FSCAN'] . "," . $data['TMTKGB'] . "," .
            $data['BLGOLT'] . "," . $data['FLAG'] . "," . $data['INPUTER'] . ")";
        //echo $sql;
        $result = $this->mysqligaji->query($sql);
        if ($result) {
            return 200;
        } else {
            return $this->mysqligaji->errno; //printf("Errorcode: %d\n", $this->mysqligaji->errno);
        }
    }

    public function reExecuteHistorisGapokToSIMGAJI($data)
    {
        if ($this->connectSimGaji()) {
            //$this->mysqli->autocommit(FALSE); Engine MyISAM tdk support Transaction
            $strSKStore = $data['strSKStore'];
            $strSKStore = explode("@", $strSKStore);
            $jmlNotExecAll = 0;
            error_reporting(0);
            for ($x = 0; $x < sizeof($strSKStore); $x++) {
                $strSKItem = explode("#", $strSKStore[$x]);
                if ($this->dbgaji->getIsServerAlive()) {
                    $statusAlive = true;
                    if ($data['statusEdit'] == 're_excute') {
                        // ReExecute ----------
                        $sql = "SELECT COUNT(NIP) as jumlah, m.KDSTAPEG, m.KDDATI2, m.KDDATI1
                        FROM mstpegawai m WHERE m.NIP = '" . $strSKItem[0] . "'";
                        $query = $this->mysqligaji->query($sql);
                        while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                            $countNIP = $oto[0];
                            $kdStapeg = $oto[1];
                            $kd_dati2 = $oto[2];
                            $kd_dati1 = $oto[3];
                        }
                        if ((Int)$countNIP > 0) {
                            //Insert data ke Tabel historis gapok di SIMGAJI
                            //==============================================
                            $dataGaji['TMTGAJI'] = "'" . $data['thnGaji'] . '-' . $data['blnGaji'] . "-01'";
                            $dataGaji['NIP'] = "'" . $strSKItem[0] . "'";
                            $dataGaji['kdstapeg'] = $kdStapeg;
                            $dataGaji['kd_dati2'] = "'" . $kd_dati2 . "'";
                            $dataGaji['kd_dati1'] = "'" . $kd_dati1 . "'";
                            $dataGaji['KDPANGKAT'] = "'" . $strSKItem[2] . "'";
                            $dataGaji['GAPOK'] = $strSKItem[3];
                            $dataGaji['MASKER'] = $strSKItem[4];
                            $dataGaji['PRSNGAPOK'] = $strSKItem[5];
                            $dataGaji['TMTTABEL'] = "'" . $strSKItem[6] . "'";
                            $dataGaji['TGLSKEP'] = "'" . $strSKItem[7] . "'";
                            $dataGaji['NOMORSKEP'] = "'" . $strSKItem[8] . "'";
                            $dataGaji['PENERBITSKEP'] = "'" . $strSKItem[9] . "'";
                            $dataGaji['tmt'] = "'" . $strSKItem[10] . "'";
                            $dataGaji['KETERANGAN'] = "'" . $strSKItem[11] . "'";
                            $dataGaji['TGLUPDATE'] = "NOW()";
                            $dataGaji['FSCAN'] = 'NULL';
                            $dataGaji['TMTKGB'] = 'NULL';
                            $dataGaji['BLGOLT'] = $strSKItem[12];
                            $dataGaji['FLAG'] = 0;
                            $dataGaji['INPUTER'] = "'" . $_SESSION['profil']->nip . "'";
                            $resultCode = $this->insertHistorisGapokToSIMGAJI($dataGaji);
                            switch ($resultCode) {
                                case 200:
                                    $msg = "Tereksekusi ke SIMGAJI";
                                    $sts_execute = 'TRUE';
                                    break;
                                case 1062:
                                    $msg = 'Err.Code: ' . $resultCode . ". Data sudah ada di SIMGAJI";
                                    $sts_execute = 'FALSE';
                                    $jmlNotExecAll += 1;
                                    break;
                                case 1142:
                                    $msg = 'Err.Code: ' . $resultCode . ". Tidak memiliki akses untuk memperbarui data ke SIMGAJI";
                                    $sts_execute = 'FALSE';
                                    $jmlNotExecAll += 1;
                                    break;
                                case 1304 :
                                    $msg = 'Err.Code: ' . $resultCode . ". Data sudah ada di SIMGAJI";
                                    $sts_execute = 'FALSE';
                                    $jmlNotExecAll += 1;
                                    break;
                                default:
                                    $msg = 'Err.Code: ' . $resultCode . ". Ada permasalahan sehingga tidak dapat memperbarui data ke SIMGAJI";
                                    $sts_execute = 'FALSE';
                                    $jmlNotExecAll += 1;
                            }
                            $sqlupdate = "UPDATE gaji_historis_gapok SET sts_execute = " . $sts_execute . ", tgl_execute = NOW(),
                                idpegawai_execute = " . $_SESSION['profil']->id_pegawai . ",keterangan_execute = '" . $msg . "'" .
                                " WHERE TMTGAJI = " . $dataGaji['TMTGAJI'] . " AND NIP = " . $dataGaji['NIP'];
                            if ($this->mysqli->query($sqlupdate) == TRUE) {
                            } else {
                                $jmlNotExecAll += 1;
                            }
                        } else {
                            $jmlNotExecAll += 1;
                        }
                    } else {
                        // Delete ----------
                        $sqldelete = "DELETE FROM gaji_historis_gapok ".
                               "WHERE TMTGAJI = '" . $data['thnGaji'] . '-' . $data['blnGaji'] . "-01' AND NIP = '" . $strSKItem[0]."'";
                        if ($this->mysqli->query($sqldelete) == TRUE) {
                        } else {
                            $jmlNotExecAll += 1;
                        }
                    }
                } else {
                    $statusAlive = false;
                    break;
                }
            }
            if ($statusAlive) {
                //$this->mysqli->commit();
                if ($jmlNotExecAll == 0) {
                    echo 1;
                } else {
                    echo 2;
                }
            } else {
                //$this->mysqli->rollback();
                echo 5; //rollback_notconnect_sim_gaji
            }
            $this->dbgaji->closeConnGaji();
            error_reporting(1);
        } else {
            echo 4; //notconnect_simgaji
        }
    }

    public function reExecuteHistorisPtkToSIMGAJI($data)
    {
        if ($this->connectSimGaji()) {
            $strPTKStore = $data['strPTKStore'];
            $strPTKStore = explode("@", $strPTKStore);
            $jmlNotExecAll = 0;
            error_reporting(0);
            for ($x = 0; $x < sizeof($strPTKStore); $x++) {
                $strSKItem = explode("#", $strPTKStore[$x]);
                if ($this->dbgaji->getIsServerAlive()) {
                    $statusAlive = true;
                    if ($data['statusEdit'] == 're_excute') {
                        // ReExecute ----------
                        $sql = "SELECT COUNT(NIP) as jumlah, m.KDSTAWIN, m.KDDATI2, m.KDDATI1
                            FROM mstpegawai m WHERE m.NIP = '" . $strSKItem[0] . "'";
                        $query = $this->mysqligaji->query($sql);
                        while ($oto = $query->fetch_array(MYSQLI_NUM)) {
                            $countNIP = $oto[0];
                            $kdStawin = $oto[1];
                            $kd_dati2 = $oto[2];
                            $kd_dati1 = $oto[3];
                        }
                        if ((Int)$countNIP > 0) {
                            $sqlJns = "SELECT pj.jenis_pengajuan FROM ptk_master pm, ptk_jenis_pengajuan pj 
                            WHERE pm.id_jenis_pengajuan = pj.id_jenis_pengajuan AND pm.id_ptk = ".$strSKItem[3];
                            $qJenis = $this->mysqli->query($sqlJns);
                            while ($o = $qJenis->fetch_array(MYSQLI_NUM)) {
                                $jenisPengajuan = $o[0];
                            }
                            //Insert data ke Tabel historis jiwa di SIMGAJI
                            $dataGaji['TMTGAJI'] = "'" . $data['thnGaji'] . '-' . $data['blnGaji'] . "-01'";
                            $dataGaji['NIP'] = "'" . $strSKItem[0] . "'";
                            $dataGaji['JISTRI'] = $strSKItem[1];
                            $dataGaji['JANAK'] = $strSKItem[2];
                            $dataGaji['KETERANGAN'] = "'".$jenisPengajuan."'";
                            $dataGaji['KDDATI1'] = "'" . $kd_dati1 . "'";
                            $dataGaji['KDDATI2'] = "'" . $kd_dati2 . "'";
                            $dataGaji['kdstawin'] = $kdStawin;
                            $resultCode = $this->insertHistorisJiwaToSIMGAJI($dataGaji);
                            switch ($resultCode) {
                                case 200:
                                    $msg = "Tereksekusi ke SIMGAJI";
                                    $sts_execute = 'TRUE';
                                    break;
                                case 1062:
                                    $msg = 'Err.Code: ' . $resultCode . ". Data sudah ada di SIMGAJI";
                                    $sts_execute = 'FALSE';
                                    $jmlNotExecAll += 1;
                                    break;
                                case 1142:
                                    $msg = 'Err.Code: ' . $resultCode . ". Tidak memiliki akses untuk memperbarui data ke SIMGAJI";
                                    $sts_execute = 'FALSE';
                                    $jmlNotExecAll += 1;
                                    break;
                                case 1304 :
                                    $msg = 'Err.Code: ' . $resultCode . ". Data sudah ada di SIMGAJI";
                                    $sts_execute = 'FALSE';
                                    $jmlNotExecAll += 1;
                                    break;
                                default:
                                    $msg = 'Err.Code: ' . $resultCode . ". Ada permasalahan sehingga tidak dapat memperbarui data ke SIMGAJI";
                                    $sts_execute = 'FALSE';
                                    $jmlNotExecAll += 1;
                            }
                            $sqlupdate = "UPDATE gaji_historis_jiwa SET sts_execute = " . $sts_execute . ", tgl_execute = NOW(),
                                idpegawai_execute = " . $_SESSION['profil']->id_pegawai . ",keterangan_execute = '" . $msg . "'" .
                                " WHERE TMTGAJI = " . $dataGaji['TMTGAJI'] . " AND NIP = " . $dataGaji['NIP'];
                            if ($this->mysqli->query($sqlupdate) == TRUE) {
                            } else {
                                $jmlNotExecAll += 1;
                            }
                        }else{
                            $jmlNotExecAll += 1;
                        }
                    }else {
                        // Delete ----------
                        $sqldelete = "DELETE FROM gaji_historis_jiwa ".
                            "WHERE TMTGAJI = '" . $data['thnGaji'] . '-' . $data['blnGaji'] . "-01' AND NIP = '" . $strSKItem[0]."'";
                        if ($this->mysqli->query($sqldelete) == TRUE) {
                        } else {
                            $jmlNotExecAll += 1;
                        }
                    }
                } else {
                    $statusAlive = false;
                    break;
                }
            }
            if ($statusAlive) {
                //$this->mysqli->commit();
                if ($jmlNotExecAll == 0) {
                    echo 1;
                } else {
                    echo 2;
                }
            } else {
                //$this->mysqli->rollback();
                echo 5; //rollback_notconnect_sim_gaji
            }
            $this->dbgaji->closeConnGaji();
            error_reporting(1);
        } else {
            echo 4; //notconnect_simgaji
        }
    }

}

?>