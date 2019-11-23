<?php
class Cuti_pegawai_model extends CI_Model{
    public function __construct(){

    }

    public function getTitleList($idproses){
        switch ($idproses){
            case 0:
                $a = "Dalam Proses Pegawai YBS ";
                break;
            case 1:
                $a = "Dalam Proses Admin SKPD ";
                break;
            case 2:
                $a = "Order Pemrosesan BKPSDA ";
                break;
            case 3:
                $a = "Permohonan Disetujui ";
                break;
            case 4:
                $a = "Permohonan Ditolak ";
                break;
            case 5:
                $a = "Permohonan Dibatalkan ";
                break;
        }
        return $a;
    }

    public function getListCutiByProses($idproses,$row_number_start,$limit,$idskpd,$jenis,$status,$cek_sk,$keywordCari,$stsExpire){
        switch ($idproses){
            case 0: // Dlm proses Ybs
                $whereKlause = "AND (cuti_pegawai.id_status_cuti=1 OR cuti_pegawai.id_status_cuti=4) ";
            break;
            case 1: // Dlm proses OPD
                $whereKlause = "AND (cuti_pegawai.id_status_cuti=2 OR cuti_pegawai.id_status_cuti=14) ";
            break;
            case 2: // Dlm proses BKPSDA
                $whereKlause = "AND (cuti_pegawai.id_status_cuti=3 OR cuti_pegawai.id_status_cuti=5 OR cuti_pegawai.id_status_cuti=12) ";
            break;
            case 3: // Disetujui
                $whereKlause = "AND (cuti_pegawai.id_status_cuti=6 OR cuti_pegawai.id_status_cuti=10)";
            break;
            case 4: // Ditolak
                $whereKlause = "AND (cuti_pegawai.id_status_cuti=7 OR cuti_pegawai.id_status_cuti=8 OR cuti_pegawai.id_status_cuti=13) ";
            break;
            case 5: // Dibatalkan
                $whereKlause = "AND cuti_pegawai.id_status_cuti=9 ";
            break;
            default:
                $whereKlause = "AND cuti_pegawai.id_status_cuti=0 ";
        }

        $whereKlause2 = ' ';
        if($idskpd!='0'){
            $whereKlause2 .= " AND cuti_pegawai.id_skpd = ".$idskpd." ";
        }

        if($jenis!='0'){
            $whereKlause2 .= " AND cuti_pegawai.id_jenis_cuti = '".$jenis."' ";
        }

        if($status!='0'){
            $whereKlause2 .= " AND cuti_pegawai.id_status_cuti = ".$status." ";
        }

        if($cek_sk!='0'){
            if($cek_sk=='1'){
                $whereKlause2 .= " AND cuti_pegawai.idberkas_sk_cuti <> 0 ";
            }else{
                $whereKlause2 .= " AND cuti_pegawai.idberkas_sk_cuti = 0 ";
            }
        }

        if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")){
            $whereKlause2 .= " AND (last_jabatan LIKE '%".$keywordCari."%'
                                OR nip_baru LIKE '%".$keywordCari."%'
								OR nip_baru_approved LIKE '%".$keywordCari."%'
								OR nama LIKE '%".$keywordCari."%'
								OR cuti_pegawai.keterangan LIKE '%".$keywordCari."%') ";
        }

        $whereKlause3 = ' ';
        if($stsExpire!='0'){
            switch ($stsExpire){
                case "1":
                    $whereKlause3 .= " AND DATEDIFF(cuti_pegawai.tmt_awal,DATE(NOW())) > 3 ";
                    break;
                case "2":
                    $whereKlause3 .= " AND DATEDIFF(cuti_pegawai.tmt_awal,DATE(NOW())) <= 3 AND DATEDIFF(cuti_pegawai.tmt_awal,DATE(NOW())) > 0 ";
                    break;
                case "3":
                    $whereKlause3 .= " AND cuti_pegawai.tmt_awal <= DATE(NOW()) ";
                    break;
            }
        }

        $this->db->query("SET @row_number := $row_number_start");
        $sql_list = "SELECT b.*, ckb.status_keputusan_cuti as sts_keputusan_pjbt FROM
                    (SELECT a.*, cka.status_keputusan_cuti as sts_keputusan_atsl
                    FROM (SELECT FCN_ROW_NUMBER() as no_urut, dt.* FROM (SELECT cuti_pegawai.*, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) as nama, g.pangkat,
                    DATE_FORMAT(cuti_pegawai.tmt_awal,  '%d/%m/%Y') AS tmt_awal_cuti,
                    DATE_FORMAT(cuti_pegawai.tmt_akhir,  '%d/%m/%Y') AS tmt_akhir_cuti,
                    DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti,  '%d/%m/%Y %H:%i:%s') AS tgl_usulan_cuti2,
                    DATE_FORMAT(cuti_pegawai.tgl_approve_status,  '%d/%m/%Y %H:%i:%s') AS tgl_approve_status2
                    FROM
                    (SELECT cuti_pegawai.*, p.nama as nama_approved, p.nip_baru as nip_baru_approved, uk.id_skpd FROM
                    (SELECT cm.*, rs.status_cuti, cj.deskripsi FROM cuti_master cm, ref_status_cuti rs, cuti_jenis cj
                    WHERE cm.id_status_cuti = rs.idstatus_cuti AND cm.id_jenis_cuti = cj.id_jenis_cuti) as cuti_pegawai, pegawai p, unit_kerja uk
                    WHERE cuti_pegawai.approved_by = p.id_pegawai AND cuti_pegawai.last_id_unit_kerja = uk.id_unit_kerja ".$whereKlause.
                    "ORDER BY cuti_pegawai.tgl_usulan_cuti DESC) AS cuti_pegawai, pegawai p, golongan g
                    WHERE cuti_pegawai.id_pegawai = p.id_pegawai AND cuti_pegawai.last_gol = g.golongan and  id_status_cuti<=14 ".$whereKlause2.$whereKlause3.
                    "ORDER BY cuti_pegawai.tgl_approve_status DESC LIMIT ".$row_number_start.",".$limit.") dt) a
                    LEFT JOIN cuti_keputusan_atasan cka ON a.id_sts_keputusan_atsl = cka.id_sts_keputusan_cuti) b
                    LEFT JOIN cuti_keputusan_atasan ckb ON b.id_sts_keputusan_pjbt = ckb.id_sts_keputusan_cuti
                    ORDER BY b.tgl_approve_status DESC";
        //echo $sql_list;
        $query = $this->db->query($sql_list);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;

    }

    public function getCountAllListCutiByProses($idproses,$idskpd,$jenis,$status,$cek_sk,$keywordCari,$stsExpire){
        switch ($idproses){
            case 0: // Dlm proses Ybs
                $whereKlause = "AND (cuti_pegawai.id_status_cuti=1 OR cuti_pegawai.id_status_cuti=4) ";
                break;
            case 1: // Dlm proses OPD
                $whereKlause = "AND (cuti_pegawai.id_status_cuti=2 OR cuti_pegawai.id_status_cuti=14)";
                break;
            case 2: // Dlm proses BKPSDA
                $whereKlause = "AND (cuti_pegawai.id_status_cuti=3 OR cuti_pegawai.id_status_cuti=5 OR cuti_pegawai.id_status_cuti=12) ";
                break;
            case 3: // Disetujui
                $whereKlause = "AND (cuti_pegawai.id_status_cuti=6 OR cuti_pegawai.id_status_cuti=10)";
                break;
            case 4: // Ditolak
                $whereKlause = "AND (cuti_pegawai.id_status_cuti=7 OR cuti_pegawai.id_status_cuti=8 OR cuti_pegawai.id_status_cuti=13) ";
                break;
            case 5: // Dibatalkan
                $whereKlause = "AND cuti_pegawai.id_status_cuti=9 ";
                break;
            default:
                $whereKlause = "AND cuti_pegawai.id_status_cuti=0 ";
        }

        $whereKlause2 = ' ';
        if($idskpd!='0'){
            $whereKlause2 .= " AND cuti_pegawai.id_skpd = ".$idskpd." ";
        }

        if($jenis!='0'){
            $whereKlause2 .= " AND cuti_pegawai.id_jenis_cuti = '".$jenis."' ";
        }

        if($status!='0'){
            $whereKlause2 .= " AND cuti_pegawai.id_status_cuti = ".$status." ";
        }

        if($cek_sk!='0'){
            if($cek_sk=='1'){
                $whereKlause2 .= " AND cuti_pegawai.idberkas_sk_cuti <> 0 ";
            }else{
                $whereKlause2 .= " AND cuti_pegawai.idberkas_sk_cuti = 0 ";
            }
        }

        if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")){
            $whereKlause2 .= " AND (last_jabatan LIKE '%".$keywordCari."%'
                                OR p.nip_baru LIKE '%".$keywordCari."%'
								OR nip_baru_approved LIKE '%".$keywordCari."%'
								OR nama LIKE '%".$keywordCari."%'
								OR cuti_pegawai.keterangan LIKE '%".$keywordCari."%') ";
        }

        $whereKlause3 = ' ';
        if($stsExpire!='0'){
            switch ($stsExpire){
                case "1":
                    $whereKlause3 .= " AND DATEDIFF(cuti_pegawai.tmt_awal,DATE(NOW())) > 3 ";
                    break;
                case "2":
                    $whereKlause3 .= " AND DATEDIFF(cuti_pegawai.tmt_awal,DATE(NOW())) <= 3 AND DATEDIFF(cuti_pegawai.tmt_awal,DATE(NOW())) > 0 ";
                    break;
                case "3":
                    $whereKlause3 .= " AND cuti_pegawai.tmt_awal <= DATE(NOW()) ";
                    break;
            }
        }

        $sql_list = "SELECT COUNT(*) as jumlah_all
                    FROM
                    (SELECT cuti_pegawai.*, p.nama as nama_approved, p.nip_baru as nip_baru_approved, uk.id_skpd FROM
                    (SELECT cm.*, rs.status_cuti, cj.deskripsi FROM cuti_master cm, ref_status_cuti rs, cuti_jenis cj
                    WHERE cm.id_status_cuti = rs.idstatus_cuti AND cm.id_jenis_cuti = cj.id_jenis_cuti) as cuti_pegawai, pegawai p, unit_kerja uk
                    WHERE cuti_pegawai.approved_by = p.id_pegawai AND cuti_pegawai.last_id_unit_kerja = uk.id_unit_kerja ".$whereKlause.
                    "ORDER BY cuti_pegawai.tgl_usulan_cuti DESC) AS cuti_pegawai, pegawai p, golongan g
                    WHERE cuti_pegawai.id_pegawai = p.id_pegawai AND cuti_pegawai.last_gol = g.golongan".$whereKlause2.$whereKlause3.
                    "ORDER BY cuti_pegawai.tgl_usulan_cuti DESC";
        $query = $this->db->query($sql_list);
        foreach ($query->result() as $row){
            $count = $row->jumlah_all;
        }
        return $count;
    }

    public function hist_cuti_byid($id){
        $qrun="select nama, DATE_FORMAT(tgl_approve_hist,  '%d/%m/%Y %H:%i:%s') AS tgl_approve_hist , approved_note_hist,status_cuti
                        from cuti_historis_approve inner join pegawai on cuti_historis_approve.approved_by_hist=pegawai.id_pegawai
                        inner join ref_status_cuti on ref_status_cuti.idstatus_cuti = cuti_historis_approve.idstatus_cuti_hist
                        where id_cuti_master=$id";
        $query = $this->db->query($qrun);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function cekBerkas($idberkas_surat_cuti){
        $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama
                         FROM berkas b, isi_berkas ib, pegawai p
                         WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = " . $idberkas_surat_cuti .
                        " AND b.created_by = p.id_pegawai";

        $query = $this->db->query($sqlCekBerkas);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function updateCutiMaster($idstatus_cuti, $approvedBy, $approvedNote, $id_cuti_master, $idp_pengesah){
        $this->db->trans_begin();
        $sql = "UPDATE cuti_master SET " .
                "id_status_cuti = " . $idstatus_cuti . ", tgl_approve_status = NOW(), " .
                "approved_by = " . $approvedBy . ", approved_note =  '" . $approvedNote .
                "', id_pegawai_pengesah = " . $idp_pengesah .
                " WHERE id_cuti_master = " . $id_cuti_master;
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $query = false;
        }else{
            $sql2 = "INSERT INTO cuti_historis_approve(tgl_approve_hist, approved_by_hist,
                    idstatus_cuti_hist, approved_note_hist, id_cuti_master) VALUES (NOW(), $approvedBy,
                    $idstatus_cuti, '".$approvedNote."', $id_cuti_master)";
            $this->db->query($sql2);
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $query = false;
            }else{
                $this->db->trans_commit();
                $query = true;
            }
        }
        return $query;
    }

	 public function bos($gol,$idj){

		if($gol=='IV' or is_numeric($idj))
			$qbos="select id_j from jabatan where jabatan like 'kepala badan kepegawaian%' order by tahun desc limit 1";
		elseif($gol=='III')
			$qbos="select id_j from jabatan where jabatan like 'Sekretaris badan kepegawaian%' order by tahun desc limit 1";
		elseif($gol=='II')
        $qbos="select id_j from jabatan where jabatan like 'Kepala Bidang Informasi, Administrasi dan Kesejahteraan Pegawai%' order by tahun desc limit 1";
        $query = $this->db->query($qbos);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

	public function pejabat($bosnya){
		 $qbos="select concat(gelar_depan,' ',nama,' ',gelar_belakang) as nama,nip_baru,pangkat from pegawai inner join golongan on golongan.golongan=pegawai.pangkat_gol where id_j=$bosnya";
        $query = $this->db->query($qbos);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
	}
    public function cetakSKcuti($idcuti_m){
        $sqlSKCuti = "SELECT h.*, j.eselon FROM
                    (SELECT cuti_pegawai.*, g.pangkat as pangkat_pjbt FROM
                    (SELECT cuti_pegawai.*, g.pangkat AS pangkat_atsl FROM
                    (SELECT cuti_pegawai.*, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                    p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) as nama,
                    p.nip_baru, DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti, '%d') AS tgl_usulan,
                    DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti, '%m') AS bln_usulan,
                    DATE_FORMAT(cuti_pegawai.tgl_usulan_cuti, '%Y') AS thn_usulan,
                    DATE_FORMAT(cuti_pegawai.tmt_awal, '%d/%m/%Y') AS tmt_awal_cuti,
                    DATE_FORMAT(cuti_pegawai.tmt_akhir, '%d/%m/%Y') AS tmt_akhir_cuti,
                    CASE WHEN (p.ponsel IS NULL = 0 AND p.ponsel != '') AND (p.telepon IS NULL = 0 AND p.telepon != '') THEN CONCAT(p.ponsel, ' / ',p.telepon) ELSE CASE WHEN (p.ponsel IS NULL = 0 AND p.ponsel != '') THEN p.ponsel ELSE CASE WHEN (p.telepon IS NULL = 0 AND p.telepon != '') THEN p.telepon ELSE '' END END END AS nokontak,
                    p.id_j
                    FROM (SELECT cm.*, rs.status_cuti, cj.deskripsi, g.pangkat AS pangkat_p
                    FROM cuti_master cm, ref_status_cuti rs, cuti_jenis cj, golongan g
                    WHERE cm.id_status_cuti = rs.idstatus_cuti AND cm.id_jenis_cuti = cj.id_jenis_cuti AND
                    cm.last_gol = g.golongan AND cm.id_cuti_master = $idcuti_m) as cuti_pegawai,
                    pegawai p WHERE cuti_pegawai.id_pegawai = p.id_pegawai) AS cuti_pegawai LEFT JOIN golongan g
                    ON cuti_pegawai.last_atsl_gol = g.golongan) AS cuti_pegawai LEFT JOIN golongan g
                    ON cuti_pegawai.last_pjbt_gol = g.golongan) h LEFT JOIN
                    jabatan j ON h.id_j = j.id_j";

        $query = $this->db->query($sqlSKCuti);
        return $query->result();
    }

    public function getLiburNasionalList(){

		return $this->db->get('libur_nasional');

	}

	public function getCutiBersamaList(){

		return $this->db->get('cuti_bersama');
	}

	public function saveLiburNasional($tglLN, $hari, $ket){

		$data = array(
				'tanggal'=>$tglLN,
				'hari'=>$hari,
				'ket'=>$ket
				);

		if($this->db->insert('libur_nasional',$data)){
			return true;
		}else{
			return false;
		}
	}

	public function delLiburNasional($no){

		return $this->db->delete('libur_nasional', array('no'=>$no));
	}

	public function getJenisCutiList(){

		return $this->db->get('cuti_jenis');
	}

	public function getRekapCuti($year=NULL){

		if(!$year) $year = date('yyyy');

		$sql = "
				select
				CM.deskripsi,
				sum( CASE  month(tmt_awal) WHEN 1 THEN jumlah ELSE 0 END ) AS 'Januari',
				sum( CASE  month(tmt_awal) WHEN 2 THEN jumlah ELSE 0 END ) AS 'Februari',
				sum( CASE  month(tmt_awal) WHEN 3 THEN jumlah ELSE 0 END ) AS 'Maret',
				sum( CASE  month(tmt_awal) WHEN 4 THEN jumlah ELSE 0 END ) AS 'April',
				sum( CASE  month(tmt_awal) WHEN 5 THEN jumlah ELSE 0 END ) AS 'Mei',
				sum( CASE  month(tmt_awal) WHEN 6 THEN jumlah ELSE 0 END ) AS 'Juni',
				sum( CASE  month(tmt_awal) WHEN 7 THEN jumlah ELSE 0 END ) AS 'Juli',
				sum( CASE  month(tmt_awal) WHEN 8 THEN jumlah ELSE 0 END ) AS 'Agustus',
				sum( CASE  month(tmt_awal) WHEN 9 THEN jumlah ELSE 0 END ) AS 'September',
				sum( CASE  month(tmt_awal) WHEN 10 THEN jumlah ELSE 0 END ) AS 'Oktober',
				sum( CASE  month(tmt_awal) WHEN 11 THEN jumlah ELSE 0 END ) AS 'November',
				sum( CASE  month(tmt_awal) WHEN 12 THEN jumlah ELSE 0 END ) AS 'Desember',

				sum( jumlah ) as Total
			from
			(
				select cj.deskripsi, tmt_awal, count(*) as jumlah
				from cuti_master
				inner join cuti_jenis cj on cj.id_jenis_cuti = cuti_master.id_jenis_cuti
				where year(tmt_awal) = ".$year."
				group by cuti_master.id_jenis_cuti, cuti_master.tmt_awal

			) as CM
			group by CM.deskripsi
				";

		return $this->db->query($sql);
	}

    public function getSKPD(){
        $sql = "select id_unit_kerja, nama_baru from unit_kerja
				where tahun = (select max(tahun) from unit_kerja)
				and id_unit_kerja = id_skpd
				order by nama_baru ASC";
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getJenisCuti(){
        $sql = "SELECT cj.id_jenis_cuti, cj.deskripsi FROM cuti_jenis cj";
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getStatusCuti($idproses){
        $whereKlause = "WHERE rsc.idstatus_cuti > 0";
        switch ($idproses){
            case 0:
                $whereKlause .= " AND (rsc.idstatus_cuti=1 OR rsc.idstatus_cuti=4) ";
                break;
            case 1:
                $whereKlause .= " AND (rsc.idstatus_cuti=2 OR rsc.idstatus_cuti=14) ";
                break;
            case 2:
                $whereKlause .= " AND (rsc.idstatus_cuti=3 OR rsc.idstatus_cuti=5 OR rsc.idstatus_cuti=12) ";
                break;
            case 3:
                $whereKlause .= " AND (rsc.idstatus_cuti=6 OR rsc.idstatus_cuti=10)";
                break;
            case 4:
                $whereKlause .= " AND (rsc.idstatus_cuti=7 OR rsc.idstatus_cuti=8 OR rsc.idstatus_cuti=13) ";
                break;
        }
        $sql = "SELECT * FROM ref_status_cuti rsc ".$whereKlause;
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getRekapStatusExpire(){
        $sql = "SELECT
                sum(if(a.status_cm = 'aktual', a.jml, 0)) AS `aktual`,
                sum(if(a.status_cm = 'hampir_kadaluarsa', a.jml, 0)) AS `hampir_kadaluarsa`,
                sum(if(a.status_cm = 'kadaluarsa', a.jml, 0)) AS `kadaluarsa`
                FROM
                (SELECT '1' AS idd,'aktual' AS status_cm, COUNT(cm.id_cuti_master) AS jml
                FROM cuti_master cm WHERE (cm.id_status_cuti = 3 OR cm.id_status_cuti = 5) AND DATEDIFF(cm.tmt_awal,DATE(NOW())) > 3
                UNION
                SELECT '1' AS idd,'hampir_kadaluarsa' AS status_cm, COUNT(cm.id_cuti_master) AS jml
                FROM cuti_master cm WHERE (cm.id_status_cuti = 3 OR cm.id_status_cuti = 5) AND
                DATEDIFF(cm.tmt_awal,DATE(NOW())) <= 3 AND DATEDIFF(cm.tmt_awal,DATE(NOW())) > 0
                UNION
                SELECT '1' AS idd,'kadaluarsa' AS status_cm, COUNT(cm.id_cuti_master) AS jml
                FROM cuti_master cm WHERE (cm.id_status_cuti = 3 OR cm.id_status_cuti = 5) AND cm.tmt_awal <= DATE(NOW())) a
                GROUP BY a.idd;";

        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }


	  public function getriwayatcuti($idpegawai){
        $sql = "select deskripsi,tmt_awal,lama_cuti from cuti_master inner join cuti_jenis on cuti_jenis.id_jenis_cuti=cuti_master.id_jenis_cuti where cuti_master.id_pegawai=$idpegawai order by tmt_awal";

        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getPengesah($idcuti_m){
        $sql = "SELECT e.*, p6.pangkat_gol as pangkat_gol_plt,
            (CASE WHEN e.last_gol = p6.pangkat_gol THEN /* jika gol pegawai sama dengan gol plt maka naikkan lagi pengesahnya */
              (CASE WHEN e.eselon_pengesah = 'IIIB' THEN (SELECT id_pegawai FROM pegawai WHERE id_j = 3120) ELSE
                (CASE WHEN e.eselon_pengesah = 'IIIA' THEN (SELECT id_pegawai FROM pegawai WHERE id_j = 3082) ELSE
                  (CASE WHEN e.eselon_pengesah = 'IIB' THEN (SELECT id_pegawai FROM pegawai WHERE id_j = 4376) ELSE
                    (CASE WHEN e.eselon_pengesah = 'IIA' THEN (SELECT id_pegawai FROM pegawai WHERE id_j = 4375) END) END) END) END) ELSE NULL END) AS id_pegawai_pengesah_up
            FROM
              (SELECT d.*, jp.id_pegawai as id_pegawai_plt, jh.id_pegawai as id_pegawai_plh FROM
                (SELECT c.*, CASE WHEN p5.id_j IS NULL THEN c.id_j_pengesah ELSE p5.id_j END AS id_j, CASE WHEN p5.id_j IS NULL THEN (SELECT eselon FROM jabatan WHERE id_j = c.id_j_pengesah) ELSE j2.eselon END as eselon_pengesah FROM
                  (SELECT b.*, j.eselon,
                     CASE WHEN (b.last_gol='I/a' OR b.last_gol='I/b' OR b.last_gol='I/c' OR b.last_gol='I/d'
                                OR b.last_gol='II/a' OR b.last_gol='II/b' OR b.last_gol='II/c' OR b.last_gol='II/d') AND (b.last_idj_pemohon IS NULL)
                       THEN (SELECT p1.id_pegawai FROM pegawai p1 WHERE p1.id_j = 3190)
                     ELSE (CASE WHEN (b.last_gol='III/a' OR b.last_gol='III/b' OR b.last_gol='III/c' OR b.last_gol='III/d'
                                       /*OR b.last_gol='IV/a' OR b.last_gol='IV/b' OR b.last_gol='IV/c' OR b.last_gol='IV/d'*/) AND (b.last_idj_pemohon IS NULL OR j.eselon='IVA' OR j.eselon='IVB')
                       THEN (SELECT p2.id_pegawai FROM pegawai p2 WHERE p2.id_j = 3120)
                           ELSE (CASE WHEN (/*b.last_gol='III/a' OR b.last_gol='III/b' OR b.last_gol='III/c' OR b.last_gol='III/d'
                              OR */(b.last_gol='IV/a' OR b.last_gol='IV/b' OR b.last_gol='IV/c' OR b.last_gol='IV/d') AND (b.last_idj_pemohon IS NULL OR j.eselon='IVA' OR j.eselon='IVB')) OR
                                           j.eselon='IIIA' OR j.eselon='IIIB'
                             THEN (SELECT p3.id_pegawai FROM pegawai p3 WHERE p3.id_j = 3082)
                                 ELSE (CASE WHEN (b.last_gol='IV/a' OR b.last_gol='IV/b' OR b.last_gol='IV/c' OR b.last_gol='IV/d') AND (j.eselon='IIA' OR j.eselon='IIB')
                                   THEN (SELECT p4.id_pegawai FROM pegawai p4 WHERE p4.id_j = 4376) ELSE NULL END) END) END)
                     END as id_pegawai_pengesah,
                     CASE WHEN (b.last_gol='I/a' OR b.last_gol='I/b' OR b.last_gol='I/c' OR b.last_gol='I/d'
                                OR b.last_gol='II/a' OR b.last_gol='II/b' OR b.last_gol='II/c' OR b.last_gol='II/d') AND (b.last_idj_pemohon IS NULL)
                       THEN 3190
                     ELSE (CASE WHEN (b.last_gol='III/a' OR b.last_gol='III/b' OR b.last_gol='III/c' OR b.last_gol='III/d'
                                       /*OR b.last_gol='IV/a' OR b.last_gol='IV/b' OR b.last_gol='IV/c' OR b.last_gol='IV/d'*/) AND (b.last_idj_pemohon IS NULL OR j.eselon='IVA' OR j.eselon='IVB')
                       THEN 3120
                           ELSE (CASE WHEN (/*b.last_gol='III/a' OR b.last_gol='III/b' OR b.last_gol='III/c' OR b.last_gol='III/d'
                              OR */(b.last_gol='IV/a' OR b.last_gol='IV/b' OR b.last_gol='IV/c' OR b.last_gol='IV/d') AND (b.last_idj_pemohon IS NULL OR j.eselon='IVA' OR j.eselon='IVB')) OR
                                           j.eselon='IIIA' OR j.eselon='IIIB'
                             THEN 3082
                                 ELSE (CASE WHEN (b.last_gol='IV/a' OR b.last_gol='IV/b' OR b.last_gol='IV/c' OR b.last_gol='IV/d') AND (j.eselon='IIA' OR j.eselon='IIB')
                                   THEN 4376 ELSE NULL END) END) END)
                     END as id_j_pengesah
                   FROM (SELECT a.*, p.id_j AS last_idj_pemohon FROM
                     (SELECT cm.id_cuti_master, cm.id_pegawai, cm.last_gol
                      FROM cuti_master cm
                      WHERE cm.id_cuti_master = $idcuti_m) a LEFT JOIN pegawai p
                       ON a.id_pegawai = p.id_pegawai) b LEFT JOIN jabatan j
                       ON b.last_idj_pemohon = j.id_j) c LEFT JOIN pegawai p5 ON c.id_pegawai_pengesah = p5.id_pegawai
                  LEFT JOIN jabatan j2 ON p5.id_j = j2.id_j) d
                LEFT JOIN jabatan_plt jp ON d.id_j = jp.id_j AND jp.status_aktif = 1
                LEFT JOIN jabatan_plh jh ON d.id_j = jh.id_j AND jh.status_aktif = 1) e
                LEFT JOIN pegawai p6 ON e.id_pegawai_plt = p6.id_pegawai
                LEFT JOIN pegawai p7 ON e.id_pegawai_plh = p7.id_pegawai";
          //print_r($sql);exit;
        $query = $this->db->query($sql);
        foreach ($query->result() as $row){
            if($row->id_pegawai_plt==''){
                if($row->id_pegawai_plh==''){
                    $idp_pengesah = $row->id_pegawai_pengesah;
                }else{
                    if($row->id_pegawai_pengesah_up==''){
                        $idp_pengesah = $row->id_pegawai_plh;
                    }else{
                        $idp_pengesah = $row->id_pegawai_pengesah_up;
                    }
                }
            }else{
                if($row->id_pegawai_pengesah_up==''){
                    $idp_pengesah = $row->id_pegawai_plt;
                }else{
                    $idp_pengesah = $row->id_pegawai_pengesah_up;
                }
            }
        }

        $sql = " SELECT a.*, jp.id_pegawai as id_pegawai_plt,
            jh.id_pegawai as id_pegawai_plh FROM
            (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
			nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama, j.jabatan, j.eselon, g.pangkat
            FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
            LEFT JOIN golongan g ON p.pangkat_gol = g.golongan
            WHERE p.id_pegawai = $idp_pengesah) a
            LEFT JOIN jabatan_plt jp ON a.id_pegawai = jp.id_pegawai
            LEFT JOIN jabatan_plh jh ON a.id_pegawai = jh.id_pegawai";
            //print_r($sql);exit;
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getPengesahById($idp){
        /*if($idp==3344){ //Pa Hidayat
            $idp = 2905;
        }elseif($idp==12521){ //Pa Dani
            $idp = 1719;
        }*/

        $sql = "SELECT a.*, jp.id_j as id_j_plt, jp.id_pegawai AS id_pegawai_plt,
                jh.id_pegawai as id_pegawai_plh FROM
                (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                ELSE j.jabatan END END AS jabatan, j.eselon AS eselon, j.id_j, g.pangkat
                FROM pegawai p
                LEFT JOIN jabatan j ON p.id_j = j.id_j LEFT JOIN golongan g ON p.pangkat_gol = g.golongan,
                current_lokasi_kerja clk, unit_kerja uk
                WHERE p.id_pegawai = clk.id_pegawai AND clk.id_unit_kerja = uk.id_unit_kerja
                AND p.id_pegawai = $idp) a
                LEFT JOIN jabatan_plt jp ON a.id_pegawai = jp.id_pegawai
                LEFT JOIN jabatan_plh jh ON a.id_j = jh.id_j AND jh.status_aktif = 1";
        //echo $sql;
        $query = $this->db->query($sql);
        foreach ($query->result() as $row){
            if($row->id_pegawai_plt==''){
                if($row->id_pegawai_plh==''){
                    $idp_pengesah = $row->id_pegawai;
                }else{
                    $idp_pengesah = $row->id_pegawai_plh;
                }
            }else{
                $idp_pengesah = $row->id_pegawai_plt;
            }
        }

        $sql = " SELECT a.*, jp.id_pegawai as id_pegawai_plt,
            jh.id_pegawai as id_pegawai_plh FROM
            (SELECT p.id_pegawai, p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
			nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama, j.jabatan, j.eselon, g.pangkat
            FROM pegawai p LEFT JOIN jabatan j ON p.id_j = j.id_j
            LEFT JOIN golongan g ON p.pangkat_gol = g.golongan
            WHERE p.id_pegawai = $idp_pengesah) a
            LEFT JOIN jabatan_plt jp ON a.id_pegawai = jp.id_pegawai
            LEFT JOIN jabatan_plh jh ON a.id_pegawai = jh.id_pegawai";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getIdPengesahByCuti($idcuti_m){
        $sql = "SELECT id_pegawai_pengesah FROM cuti_master WHERE id_cuti_master = $idcuti_m";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getInfoPegawai($nip){
        $sql = "SELECT a.nip_baru, a.nama, a.jenjab, a.pangkat_gol,
		CASE WHEN a.jenjab = 'Fungsional' THEN a.jabatan ELSE CASE WHEN a.id_j IS NULL THEN
		(SELECT jm.nama_jfu AS jabatan
		 FROM jfu_pegawai jp, jfu_master jm
		 WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = a.id_pegawai LIMIT 1)
		ELSE j.jabatan END END AS jabatan, CASE WHEN j.eselon IS NULL THEN 'Z' ELSE j.eselon END AS eselon,
		  uk.nama_baru, a.flag_pensiun, a.id_pegawai FROM
		(SELECT p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
		nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
		p.jenjab, p.pangkat_gol, p.id_j, p.flag_pensiun, p.jabatan,p.id_pegawai
		FROM pegawai p WHERE p.nip_baru = '".$nip."') a
		LEFT JOIN jabatan j ON a.id_j = j.id_j
		LEFT JOIN current_lokasi_kerja clk ON a.id_pegawai = clk.id_pegawai
		LEFT JOIN unit_kerja uk ON clk.id_unit_kerja = uk.id_unit_kerja;";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function reportPerPeriodeJenisStatus($bln, $thn){
        $sql = "SELECT c.idstatus_cuti, IF(c.idstatus_cuti IS NULL, 'TOTAL', c.status_cuti) AS status_cuti,
                c.CLTN, c.C_ALASAN_PENTING, c.C_BERSALIN, c.C_BESAR, c.C_SAKIT, c.C_TAHUNAN,
                c.CLTN + c.C_ALASAN_PENTING + c.C_BERSALIN + c.C_BESAR + c.C_SAKIT + c.C_TAHUNAN AS 'TOTAL'
                FROM (SELECT rsc.idstatus_cuti, rsc.status_cuti,
                SUM(IF(b.CLTN IS NULL, 0, b.CLTN)) AS 'CLTN',
                SUM(IF(b.C_ALASAN_PENTING IS NULL, 0, b.C_ALASAN_PENTING)) AS 'C_ALASAN_PENTING',
                SUM(IF(b.C_BERSALIN IS NULL, 0, b.C_BERSALIN)) AS 'C_BERSALIN',
                SUM(IF(b.C_BESAR IS NULL, 0, b.C_BESAR)) AS 'C_BESAR',
                SUM(IF(b.C_SAKIT IS NULL, 0, b.C_SAKIT)) AS 'C_SAKIT',
                SUM(IF(b.C_TAHUNAN IS NULL, 0, b.C_TAHUNAN)) AS 'C_TAHUNAN'
                FROM ref_status_cuti rsc LEFT JOIN (SELECT a.id_status_cuti,
                SUM(if(a.id_jenis_cuti = 'CLTN', a.jumlah, 0)) as 'CLTN',
                SUM(if(a.id_jenis_cuti = 'C_ALASAN_PENTING', a.jumlah, 0)) as 'C_ALASAN_PENTING',
                SUM(if(a.id_jenis_cuti = 'C_BERSALIN', a.jumlah, 0)) as 'C_BERSALIN',
                SUM(if(a.id_jenis_cuti = 'C_BESAR', a.jumlah, 0)) as 'C_BESAR',
                SUM(if(a.id_jenis_cuti = 'C_SAKIT', a.jumlah, 0)) as 'C_SAKIT',
                SUM(if(a.id_jenis_cuti = 'C_TAHUNAN', a.jumlah, 0)) as 'C_TAHUNAN'
                FROM
                (SELECT cm.id_status_cuti, cm.id_jenis_cuti, COUNT(cm.id_cuti_master) AS jumlah
                FROM cuti_master cm WHERE MONTH(cm.tmt_awal) = $bln AND YEAR(cm.tmt_awal) = $thn
                GROUP BY cm.id_status_cuti, cm.id_jenis_cuti) a
                GROUP BY a.id_status_cuti WITH ROLLUP) b ON
                rsc.idstatus_cuti = b.id_status_cuti
                GROUP BY rsc.idstatus_cuti WITH ROLLUP) c";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function reportCutiPerOPD($bln, $thn){
        $sql = "SELECT uk.id_unit_kerja, uk.nama_baru as opd, b.*
        FROM unit_kerja uk LEFT JOIN (SELECT a.id_skpd,
        SUM(if(a.id_jenis_cuti = 'CLTN', a.jumlah, 0)) as 'CLTN',
        SUM(if(a.id_jenis_cuti = 'C_ALASAN_PENTING', a.jumlah, 0)) as 'C_ALASAN_PENTING',
        SUM(if(a.id_jenis_cuti = 'C_BERSALIN', a.jumlah, 0)) as 'C_BERSALIN',
        SUM(if(a.id_jenis_cuti = 'C_BESAR', a.jumlah, 0)) as 'C_BESAR',
        SUM(if(a.id_jenis_cuti = 'C_SAKIT', a.jumlah, 0)) as 'C_SAKIT',
        SUM(if(a.id_jenis_cuti = 'C_TAHUNAN', a.jumlah, 0)) as 'C_TAHUNAN'
        FROM
        (SELECT uk.id_skpd, cm.id_jenis_cuti, COUNT(cm.id_cuti_master) AS jumlah
        FROM cuti_master cm, unit_kerja uk WHERE cm.last_id_unit_kerja = uk.id_unit_kerja AND
        MONTH(cm.tmt_awal) = $bln AND YEAR(cm.tmt_awal) = $thn
        GROUP BY uk.id_skpd, cm.id_jenis_cuti) a
        GROUP BY a.id_skpd) b ON uk.id_unit_kerja = b.id_skpd
        WHERE uk.id_unit_kerja = uk.id_skpd AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)
        ORDER BY uk.nama_baru";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function deleteCutiMaster($id_cuti_master){
        $this->db->trans_begin();
        $sql = "DELETE FROM cuti_master WHERE id_cuti_master = " . $id_cuti_master;
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $query = false;
        }else{
            $this->db->trans_commit();
            $query = true;
        }
        return $query;
    }

    public function updateJenisCuti($data){
        $this->db->trans_begin();
        $sql = "update cuti_master set id_jenis_cuti = '".$data['ddFilterJnsEd']."'
            where id_cuti_master = ".$data['id_cm_ed'];
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = false;
        }else{
            $this->db->trans_commit();
            $query = true;
        }
        return $query;
    }

    public function getPonsel($idpegawai){
        $sql = "SELECT CONCAT('62', SUBSTRING(ponsel, 2, LENGTH(ponsel)-1)) as ponsel
                FROM pegawai WHERE id_pegawai = $idpegawai";
        $query = $this->db->query($sql);
        $rowcount = $query->num_rows();
        if($rowcount > 0) {
            foreach ($query->result() as $hp) {
                $ponsel = $hp->ponsel;
            }
        }else{
            $ponsel = 0;
        }
        return $ponsel;
    }

}

?>
