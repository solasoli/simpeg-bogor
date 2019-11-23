<?php
class Ptk_model extends CI_Model
{
    public function __construct()
    {

    }

    public function getTitleList($idproses){
        switch ($idproses){
            case 1:
                $a = "Dalam Proses Pegawai YBS ";
                break;
            case 2:
                $a = "Dalam Proses BKPSDA ";
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
            case 6:
                $a = "Surat ke BPKAD Terbit ";
                break;
        }
        return $a;
    }

    public function getReportJenisStatus(){
        $sql = "SELECT e.* FROM
                (SELECT d.*, CASE WHEN d.id_unit_kerja IS NULL THEN '*JUMLAH' ELSE d.opd_lama END AS opd,
                (total_plus + d.total_min + d.total_plus_min) AS grand_total
                FROM (SELECT c.id_unit_kerja, opd as opd_lama,
                SUM(c.plus_Proses_Ybs) AS plus_Proses_Ybs,
                SUM(c.plus_Proses_BKPSDA) AS plus_Proses_BKPSDA,
                SUM(c.plus_Disetujui) AS plus_Disetujui,
                SUM(c.plus_Ditolak) AS plus_Ditolak,
                SUM(c.plus_Dibatalkan) AS plus_Dibatalkan,
                SUM(c.plus_Surat_Terbit) AS plus_Surat_Terbit,
                SUM(c.plus_Proses_Bpkad) AS plus_Proses_Bpkad,
                SUM(c.plus_Tolak_Bpkad) AS plus_Tolak_Bpkad,
                SUM(c.plus_Tunjangan_Berubah) AS plus_Tunjangan_Berubah,
                (SUM(c.plus_Proses_Ybs)+SUM(c.plus_Proses_BKPSDA)+SUM(c.plus_Disetujui)+SUM(c.plus_Ditolak)+SUM(c.plus_Dibatalkan)+
                SUM(c.plus_Surat_Terbit)+SUM(c.plus_Proses_Bpkad)+SUM(c.plus_Tolak_Bpkad)+SUM(c.plus_Tunjangan_Berubah)) AS total_plus,

                SUM(c.min_Proses_Ybs) AS min_Proses_Ybs,
                SUM(c.min_Proses_BKPSDA) AS min_Proses_BKPSDA,
                SUM(c.min_Disetujui) AS min_Disetujui,
                SUM(c.min_Ditolak) AS min_Ditolak,
                SUM(c.min_Dibatalkan) AS min_Dibatalkan,
                SUM(c.min_Surat_Terbit) AS min_Surat_Terbit,
                SUM(c.min_Proses_Bpkad) AS min_Proses_Bpkad,
                SUM(c.min_Tolak_Bpkad) AS min_Tolak_Bpkad,
                SUM(c.min_Tunjangan_Berubah) AS min_Tunjangan_Berubah,
                (SUM(c.min_Proses_Ybs)+SUM(c.min_Proses_BKPSDA)+SUM(c.min_Disetujui)+SUM(c.min_Ditolak)+SUM(c.min_Dibatalkan)+
                SUM(c.min_Surat_Terbit)+SUM(c.min_Proses_Bpkad)+SUM(c.min_Tolak_Bpkad)+SUM(c.min_Tunjangan_Berubah)) AS total_min,

                SUM(c.plusmin_Proses_Ybs) AS plusmin_Proses_Ybs,
                SUM(c.plusmin_Proses_BKPSDA) AS plusmin_Proses_BKPSDA,
                SUM(c.plusmin_Disetujui) AS plusmin_Disetujui,
                SUM(c.plusmin_Ditolak) AS plusmin_Ditolak,
                SUM(c.plusmin_Dibatalkan) AS plusmin_Dibatalkan,
                SUM(c.plusmin_Surat_Terbit) AS plusmin_Surat_Terbit,
                SUM(c.plusmin_Proses_Bpkad) AS plusmin_Proses_Bpkad,
                SUM(c.plusmin_Tolak_Bpkad) AS plusmin_Tolak_Bpkad,
                SUM(c.plusmin_Tunjangan_Berubah) AS plusmin_Tunjangan_Berubah,
                (SUM(c.plusmin_Proses_Ybs)+SUM(c.plusmin_Proses_BKPSDA)+SUM(c.plusmin_Disetujui)+ SUM(c.plusmin_Ditolak)+ SUM(c.plusmin_Dibatalkan)+
                SUM(c.plusmin_Surat_Terbit)+SUM(c.plusmin_Proses_Bpkad)+SUM(c.plusmin_Tolak_Bpkad)+SUM(c.plusmin_Tunjangan_Berubah)) AS total_plus_min

                FROM (SELECT uk.id_unit_kerja, uk.nama_baru as opd, b.*
                FROM unit_kerja uk LEFT JOIN (SELECT a.id_skpd,
                /* Penambahan Tunjangan */
                SUM(if(a.id_jenis_pengajuan = 1 AND (a.idstatus_ptk = 1 OR a.idstatus_ptk = 3), a.jumlah, 0)) as 'plus_Proses_Ybs',
                SUM(if(a.id_jenis_pengajuan = 1 AND (a.idstatus_ptk = 2 OR a.idstatus_ptk = 4), a.jumlah, 0)) as 'plus_Proses_BKPSDA',
                SUM(if(a.id_jenis_pengajuan = 1 AND a.idstatus_ptk = 5, a.jumlah, 0)) as 'plus_Disetujui',
                SUM(if(a.id_jenis_pengajuan = 1 AND a.idstatus_ptk = 6, a.jumlah, 0)) as 'plus_Ditolak',
                SUM(if(a.id_jenis_pengajuan = 1 AND a.idstatus_ptk = 7, a.jumlah, 0)) as 'plus_Dibatalkan',
                SUM(if(a.id_jenis_pengajuan = 1 AND a.idstatus_ptk = 8, a.jumlah, 0)) as 'plus_Surat_Terbit',
                SUM(if(a.id_jenis_pengajuan = 1 AND a.idstatus_ptk = 9, a.jumlah, 0)) as 'plus_Proses_Bpkad',
                SUM(if(a.id_jenis_pengajuan = 1 AND a.idstatus_ptk = 10, a.jumlah, 0)) as 'plus_Tolak_Bpkad',
                SUM(if(a.id_jenis_pengajuan = 1 AND a.idstatus_ptk = 11, a.jumlah, 0)) as 'plus_Tunjangan_Berubah',
                /* Pengurangan Tunjangan */
                SUM(if(a.id_jenis_pengajuan = 2 AND (a.idstatus_ptk = 1 OR a.idstatus_ptk = 3), a.jumlah, 0)) as 'min_Proses_Ybs',
                SUM(if(a.id_jenis_pengajuan = 2 AND (a.idstatus_ptk = 2 OR a.idstatus_ptk = 4), a.jumlah, 0)) as 'min_Proses_BKPSDA',
                SUM(if(a.id_jenis_pengajuan = 2 AND a.idstatus_ptk = 5, a.jumlah, 0)) as 'min_Disetujui',
                SUM(if(a.id_jenis_pengajuan = 2 AND a.idstatus_ptk = 6, a.jumlah, 0)) as 'min_Ditolak',
                SUM(if(a.id_jenis_pengajuan = 2 AND a.idstatus_ptk = 7, a.jumlah, 0)) as 'min_Dibatalkan',
                SUM(if(a.id_jenis_pengajuan = 2 AND a.idstatus_ptk = 8, a.jumlah, 0)) as 'min_Surat_Terbit',
                SUM(if(a.id_jenis_pengajuan = 2 AND a.idstatus_ptk = 9, a.jumlah, 0)) as 'min_Proses_Bpkad',
                SUM(if(a.id_jenis_pengajuan = 2 AND a.idstatus_ptk = 10, a.jumlah, 0)) as 'min_Tolak_Bpkad',
                SUM(if(a.id_jenis_pengajuan = 2 AND a.idstatus_ptk = 11, a.jumlah, 0)) as 'min_Tunjangan_Berubah',
                /* Penambahan & Pengurangan Tunjangan */
                SUM(if(a.id_jenis_pengajuan = 3 AND (a.idstatus_ptk = 1 OR a.idstatus_ptk = 3), a.jumlah, 0)) as 'plusmin_Proses_Ybs',
                SUM(if(a.id_jenis_pengajuan = 3 AND (a.idstatus_ptk = 2 OR a.idstatus_ptk = 4), a.jumlah, 0)) as 'plusmin_Proses_BKPSDA',
                SUM(if(a.id_jenis_pengajuan = 3 AND a.idstatus_ptk = 5, a.jumlah, 0)) as 'plusmin_Disetujui',
                SUM(if(a.id_jenis_pengajuan = 3 AND a.idstatus_ptk = 6, a.jumlah, 0)) as 'plusmin_Ditolak',
                SUM(if(a.id_jenis_pengajuan = 3 AND a.idstatus_ptk = 7, a.jumlah, 0)) as 'plusmin_Dibatalkan',
                SUM(if(a.id_jenis_pengajuan = 3 AND a.idstatus_ptk = 8, a.jumlah, 0)) as 'plusmin_Surat_Terbit',
                SUM(if(a.id_jenis_pengajuan = 3 AND a.idstatus_ptk = 9, a.jumlah, 0)) as 'plusmin_Proses_Bpkad',
                SUM(if(a.id_jenis_pengajuan = 3 AND a.idstatus_ptk = 10, a.jumlah, 0)) as 'plusmin_Tolak_Bpkad',
                SUM(if(a.id_jenis_pengajuan = 3 AND a.idstatus_ptk = 11, a.jumlah, 0)) as 'plusmin_Tunjangan_Berubah'
                FROM
                (SELECT uk.id_skpd, pm.id_jenis_pengajuan, pm.idstatus_ptk, COUNT(pm.id_ptk) AS jumlah
                FROM ptk_master pm, unit_kerja uk WHERE pm.last_id_unit_kerja = uk.id_unit_kerja
                GROUP BY uk.id_skpd, pm.id_jenis_pengajuan, pm.idstatus_ptk) a
                GROUP BY a.id_skpd) b ON uk.id_unit_kerja = b.id_skpd
                WHERE uk.id_unit_kerja = uk.id_skpd AND uk.tahun = (SELECT MAX(tahun) FROM unit_kerja uk1)
                ORDER BY uk.nama_baru) c
                GROUP BY c.id_unit_kerja WITH ROLLUP) d) e ORDER BY e.opd ASC;";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getReportJenis(){
        $sql = "SELECT CASE WHEN pjp.jenis_pengajuan IS NULL THEN 'Jumlah'
                  ELSE pjp.jenis_pengajuan END AS jenis_pengajuan, a.*
                FROM
                (SELECT pm.id_jenis_pengajuan, COUNT(pm.id_ptk) AS jumlah
                FROM ptk_master pm
                GROUP BY pm.id_jenis_pengajuan WITH ROLLUP) a LEFT JOIN ptk_jenis_pengajuan pjp
                ON a.id_jenis_pengajuan = pjp.id_jenis_pengajuan";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getReportStatus(){
        $sql = "SELECT CASE WHEN pjp.jenis_pengajuan IS NULL THEN 'Jumlah' ELSE pjp.jenis_pengajuan END AS jenis_pengajuan,
        b.* FROM (SELECT a.id_jenis_pengajuan,
        SUM(if(a.idstatus_ptk = 1, a.jumlah, 0)) as 'Permohonan_Baru',
        SUM(if(a.idstatus_ptk = 2, a.jumlah, 0)) as 'Sudah_Upload_Syarat',
        SUM(if(a.idstatus_ptk = 3, a.jumlah, 0)) as 'Revisi_Permohonan',
        SUM(if(a.idstatus_ptk = 4, a.jumlah, 0)) as 'Sedang_Proses_BKPSDA',
        SUM(if(a.idstatus_ptk = 5, a.jumlah, 0)) as 'Disetujui_BKPSDA',
        SUM(if(a.idstatus_ptk = 6, a.jumlah, 0)) as 'Ditolak_BKPSDA',
        SUM(if(a.idstatus_ptk = 7, a.jumlah, 0)) as 'Dibatalkan_BKPSDA',
        SUM(if(a.idstatus_ptk = 8, a.jumlah, 0)) as 'Surat_Terbit',
        SUM(if(a.idstatus_ptk = 9, a.jumlah, 0)) as 'Proses_BPKAD',
        SUM(if(a.idstatus_ptk = 10, a.jumlah, 0)) as 'Tolak_BPKAD',
        SUM(if(a.idstatus_ptk = 11, a.jumlah, 0)) as 'Tunjangan_Berubah'
        FROM
        (SELECT pm.id_jenis_pengajuan, pm.idstatus_ptk, COUNT(pm.id_ptk) AS jumlah
        FROM ptk_master pm
        GROUP BY pm.id_jenis_pengajuan, pm.idstatus_ptk) a
        GROUP BY a.id_jenis_pengajuan WITH ROLLUP) b LEFT JOIN ptk_jenis_pengajuan pjp
        ON pjp.id_jenis_pengajuan = b.id_jenis_pengajuan";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_list_data_ptk($idproses,$row_number_start,$limit,$idskpd,$jenis,$status,$keywordCari){
        $whereKlause = "";
        switch ($idproses) {
            case 1:
                $whereKlause = " AND (pm.idstatus_ptk=1 OR pm.idstatus_ptk=3) ";
                break;
            case 2:
                $whereKlause = " AND (pm.idstatus_ptk=2 OR pm.idstatus_ptk=4) ";
                break;
            case 3:
                $whereKlause = " AND pm.idstatus_ptk=5";
                break;
            case 4:
                $whereKlause = " AND (pm.idstatus_ptk=6 OR pm.idstatus_ptk=12) ";
                break;
            case 5:
                $whereKlause = " AND pm.idstatus_ptk=7";
                break;
            case 6:
                $whereKlause = " AND (pm.idstatus_ptk=8 OR pm.idstatus_ptk=9 OR pm.idstatus_ptk=10 OR pm.idstatus_ptk=11) ";
                break;
        }

        if($idskpd!='0'){
            $whereKlause .= " AND uk.id_skpd = ".$idskpd." ";
        }

        if($jenis!='0'){
            $whereKlause .= " AND pm.id_jenis_pengajuan = '".$jenis."' ";
        }

        if($status!='0'){
            $whereKlause .= " AND pm.idstatus_ptk = ".$status." ";
        }

        if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")){
            $whereKlause .= " AND (pm.last_jabatan LIKE '%".$keywordCari."%'
                                OR p.nip_baru LIKE '%".$keywordCari."%'
								OR p.nama LIKE '%".$keywordCari."%') ";
        }

        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT FCN_ROW_NUMBER() as no_urut, b.*, p.nip_baru AS nip_pengesah,
        CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_pengesah, p.pangkat_gol,
        CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
		(SELECT jm.nama_jfu AS jabatan
		 FROM jfu_pegawai jp, jfu_master jm
		 WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
		ELSE j.jabatan END END AS jabatan, p.flag_pensiun FROM
        (SELECT a.id_ptk, a.tgl_input_pengajuan, a.tgl_update_pengajuan, a.nomor, a.sifat, a.lampiran,
        a.id_jenis_pengajuan, a.last_jml_pasangan, a.last_jml_anak, a.id_pegawai_pemohon,
        a.last_id_unit_kerja, a.last_gol, a.last_jabatan, a.last_alamat, a.id_pegawai_kepala_opd,
        a.last_idj_kepala, a.keterangan, a.idstatus_ptk, a.tgl_approve, a.approved_by, a.approved_note,
        a.nomor_sk_ptk, a.sifat_sk_ptk, a.lampiran_sk_ptk, a.tgl_update_sk_ptk,
        CASE WHEN a.id_pegawai_pengesah IS NOT NULL THEN a.id_pegawai_pengesah ELSE
          (CASE WHEN (a.last_gol='I/a' OR a.last_gol='I/b' OR a.last_gol='I/c' OR a.last_gol='I/d'
          OR a.last_gol='II/a' OR a.last_gol='II/b' OR a.last_gol='II/c' OR a.last_gol='II/d') AND (a.last_idj_pemohon IS NULL)
          THEN (SELECT p1.id_pegawai FROM pegawai p1 WHERE p1.id_j = 3190)
          ELSE (CASE WHEN
          /*(a.last_gol='III/a' OR a.last_gol='III/b' OR a.last_gol='III/c' OR a.last_gol='III/d'
          OR a.last_gol='IV/a' OR a.last_gol='IV/b' OR a.last_gol='IV/c' OR a.last_gol='IV/d') AND (a.last_idj_pemohon IS NULL OR a.eselon='IVA' OR a.eselon='IVB')*/
          (a.last_gol='III/a' OR a.last_gol='III/b' OR a.last_gol='III/c' OR a.last_gol='III/d') AND (a.last_idj_pemohon IS NULL OR a.eselon='IVA' OR a.eselon='IVB')
          THEN (SELECT p2.id_pegawai FROM pegawai p2 WHERE p2.id_j = 3120)
          ELSE (CASE WHEN
          /*(a.last_gol='III/a' OR a.last_gol='III/b' OR a.last_gol='III/c' OR a.last_gol='III/d'
          OR a.last_gol='IV/a' OR a.last_gol='IV/b' OR a.last_gol='IV/c' OR a.last_gol='IV/d') AND (a.eselon='IIIA' OR a.eselon='IIIB')*/
          ((a.last_gol='IV/a' OR a.last_gol='IV/b' OR a.last_gol='IV/c' OR a.last_gol='IV/d') AND (a.last_idj_pemohon IS NULL OR a.eselon='IVA' OR a.eselon='IVB')) OR
          a.eselon='IIIA' OR a.eselon='IIIB'
          THEN (SELECT p3.id_pegawai FROM pegawai p3 WHERE p3.id_j = 3082)
          ELSE (CASE WHEN (a.last_gol='IV/a' OR a.last_gol='IV/b' OR a.last_gol='IV/c' OR a.last_gol='IV/d') AND (a.eselon='IIA' OR a.eselon='IIB')
          THEN (SELECT p4.id_pegawai FROM pegawai p4 WHERE p4.id_j = 4376) ELSE NULL END) END) END)
          END)
        END id_pegawai_pengesah,
        a.flag_atas_nama, a.id_berkas_pengajuan, a.id_berkas_skum, a.id_berkas_sk_pangkat_last,
        a.id_berkas_daftar_gaji_last, id_berkas_kk_last, a.id_berkas_ptk, a.last_idj_pemohon, a.eselon, a.jenis_pengajuan,
        a.status_ptk, a.id_pegawai, a.nip_baru, a.nama, a.unit, a.id_skpd, g.pangkat, uk.nama_baru AS last_unit_kerja,
        p.nip_baru as nip_approved, p.nama AS nama_approved, a.id_berkas_daftar_gaji_pasangan_pns FROM
        (SELECT pm.*, j.eselon, pjp.jenis_pengajuan, rsp.status_ptk, p.id_pegawai, p.nip_baru,
        CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
        uk.nama_baru as unit, uk.id_skpd
        FROM ptk_master pm LEFT JOIN jabatan j ON pm.last_idj_pemohon = j.id_j,
        ptk_jenis_pengajuan pjp, ref_status_ptk rsp, pegawai p, unit_kerja uk
        WHERE pm.id_jenis_pengajuan = pjp.id_jenis_pengajuan AND pm.idstatus_ptk = rsp.id_status_ptk AND
        pm.id_pegawai_pemohon = p.id_pegawai AND pm.last_id_unit_kerja = uk.id_unit_kerja ".$whereKlause.")a
        LEFT JOIN pegawai p ON a.approved_by = p.id_pegawai, golongan g, unit_kerja uk
        WHERE a.last_gol = g.golongan AND a.last_id_unit_kerja = uk.id_unit_kerja) b
        LEFT JOIN pegawai p ON b.id_pegawai_pengesah = p.id_pegawai
        LEFT JOIN jabatan j ON p.id_j = j.id_j
        ORDER BY b.tgl_approve DESC LIMIT ".$row_number_start.",".$limit;
        //echo $sql;
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_countall_list_data_ptk($idproses,$idskpd,$jenis,$status,$keywordCari){
        $whereKlause = "";
        switch ($idproses) {
            case 1:
                $whereKlause = " AND (pm.idstatus_ptk=1 OR pm.idstatus_ptk=3) ";
                break;
            case 2:
                $whereKlause = " AND (pm.idstatus_ptk=2 OR pm.idstatus_ptk=4) ";
                break;
            case 3:
                $whereKlause = " AND pm.idstatus_ptk=5";
                break;
            case 4:
                $whereKlause = " AND (pm.idstatus_ptk=6 OR pm.idstatus_ptk=12) ";
                break;
            case 5:
                $whereKlause = " AND pm.idstatus_ptk=7";
                break;
            case 6:
                $whereKlause = " AND (pm.idstatus_ptk=8 OR pm.idstatus_ptk=9 OR pm.idstatus_ptk=10 OR pm.idstatus_ptk=11) ";
                break;
        }

        if($idskpd!='0'){
            $whereKlause .= " AND uk.id_skpd = ".$idskpd." ";
        }

        if($jenis!='0'){
            $whereKlause .= " AND pm.id_jenis_pengajuan = '".$jenis."' ";
        }

        if($status!='0'){
            $whereKlause .= " AND pm.idstatus_ptk = ".$status." ";
        }

        if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")){
            $whereKlause .= " AND (pm.last_jabatan LIKE '%".$keywordCari."%'
                                OR p.nip_baru LIKE '%".$keywordCari."%'
								OR p.nama LIKE '%".$keywordCari."%') ";
        }

        $sql = "SELECT COUNT(a.id_ptk) as jumlah_all
        FROM (SELECT pm.*, pjp.jenis_pengajuan, rsp.status_ptk, p.id_pegawai, p.nip_baru,
        CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
        nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama,
        uk.nama_baru as unit
        FROM ptk_master pm, ptk_jenis_pengajuan pjp, ref_status_ptk rsp, pegawai p, unit_kerja uk
        WHERE pm.id_jenis_pengajuan = pjp.id_jenis_pengajuan AND pm.idstatus_ptk = rsp.id_status_ptk AND
        pm.id_pegawai_pemohon = p.id_pegawai AND pm.last_id_unit_kerja = uk.id_unit_kerja".$whereKlause.") a";

        $query = $this->db->query($sql);
        foreach ($query->result() as $row){
            $count = $row->jumlah_all;
        }
        return $count;
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

    public function getJenisPTK(){
        $sql = "SELECT * FROM ptk_jenis_pengajuan pjp";
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function getStatusPTK($idproses){
        $whereKlause = "WHERE rsp.id_status_ptk > 0";
        switch ($idproses){
            case 1:
                $whereKlause .= " AND (rsp.id_status_ptk=1 OR rsp.id_status_ptk=3) ";
                break;
            case 2:
                $whereKlause .= " AND (rsp.id_status_ptk=2 OR rsp.id_status_ptk=4) ";
                break;
            case 6:
                $whereKlause .= " AND (rsp.id_status_ptk=8 OR rsp.id_status_ptk=9 OR rsp.id_status_ptk=10 OR rsp.id_status_ptk=11) ";
        }
        $sql = "SELECT * FROM ref_status_ptk rsp ".$whereKlause;
        $query = $this->db->query($sql);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function get_list_keluarga_ptk($idptk){
        $sql = "SELECT pk.id_ptk_keluarga, ptp.id_tipe_pengubahan_tunjangan, ptp.kategori_pengubahan, ptp.tipe_pengubahan_tunjangan,
                sk.status_keluarga, pk.last_nama, pk.last_tempat_lahir, pk.last_tgl_lahir, pk.last_pekerjaan,
                CASE WHEN pk.last_jk = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS last_jk,
                CASE WHEN pk.last_status_tunjangan = 0 THEN 'Tidak Dapat' ELSE 'Dapat' END AS last_status_tunjangan,
                ps.last_tgl_references, ps.last_keterangan_reference, ps.id_berkas_syarat, ptp.nama_berkas_syarat, ps.id_syarat
                FROM ptk_keluarga pk, ptk_tipe_pengubahan ptp, status_kel sk, ptk_syarat ps
                WHERE pk.id_ptk = $idptk AND pk.id_tipe_pengubahan_tunjangan = ptp.id_tipe_pengubahan_tunjangan AND
                pk.last_id_status_keluarga = sk.id_status AND pk.id_ptk_keluarga = ps.id_ptk_keluarga
                ORDER BY pk.last_id_status_keluarga, pk.last_nama";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function get_jml_keluarga_pns($idp){
        $sql = "SELECT COUNT(*) AS jumlah FROM keluarga k
                WHERE k.id_pegawai = $idp AND k.id_status = 9 AND
                      (LOWER(k.pekerjaan) = 'pns'
                       OR LOWER(k.pekerjaan) = 'pegawai negeri sipil'
                       OR LOWER(k.pekerjaan) = 'tni'
                       OR LOWER(k.pekerjaan) = 'polri'
                       OR LOWER(k.pekerjaan) = 'p n s')";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function cekBerkas($idberkas){
        $sqlCekBerkas = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama
                         FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                         WHERE b.id_berkas = ib.id_berkas AND b.id_berkas = " . $idberkas;

        $query = $this->db->query($sqlCekBerkas);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function cekBerkasSyaratLain($idberkas1,$idberkas2,$idberkas3,$idberkas4,$idberkas5,$idberkas6){
        $sql = "SELECT ib.file_name, b.created_by, DATE_FORMAT(b.created_date,  '%d/%m/%Y %H:%i:%s') AS created_date, p.nip_baru, p.nama, b.id_kat
                FROM berkas b LEFT JOIN pegawai p ON b.created_by = p.id_pegawai, isi_berkas ib
                WHERE b.id_berkas = ib.id_berkas AND b.id_berkas IN ($idberkas1,$idberkas2,$idberkas3,$idberkas4,$idberkas5,$idberkas6)";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function updatePtkMaster($idstatus_ptk, $approvedBy, $approvedNote, $idptk){
        $this->db->trans_begin();
        $sql = "UPDATE ptk_master SET " .
            "idstatus_ptk = " . $idstatus_ptk . ", tgl_approve = NOW(), " .
            "approved_by = " . $approvedBy . ", approved_note =  '" . $approvedNote .
            "' WHERE id_ptk = " . $idptk;
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $query = false;
        }else{
            $sql2 = "INSERT INTO ptk_historis_approve(tgl_approve_hist, approved_by_hist,
                    id_status_ptk, approved_note_hist, id_ptk) VALUES (NOW(), $approvedBy,
                    $idstatus_ptk, '".$approvedNote."', $idptk)";
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

    public function hist_ptk_byid($id){
        $qrun="select nama, DATE_FORMAT(tgl_approve_hist,  '%d/%m/%Y %H:%i:%s') AS tgl_approve_hist , approved_note_hist,status_ptk
                        from ptk_historis_approve inner join pegawai on ptk_historis_approve.approved_by_hist=pegawai.id_pegawai
                        inner join ref_status_ptk on ref_status_ptk.id_status_ptk = ptk_historis_approve.id_status_ptk
                        where id_ptk=$id";
        $query = $this->db->query($qrun);
        $data = null;
        foreach ($query->result() as $row)
        {
            $data[] = $row;
        }
        return $data;
    }

    public function cetakSKPtk($id_ptk){
        $sql = "SELECT d.*, jplt.id_pegawai AS id_pegawai_plt, jplh.id_pegawai AS id_pegawai_plh 
                FROM (SELECT c.*, j.eselon FROM 
                (SELECT b.*, g.pangkat AS pangkat_pengesah, uk.nama_baru as opd FROM
                (SELECT a.*, p.nip_baru AS nip_pengesah,
                CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama_pengesah, p.pangkat_gol,
                CASE WHEN p.jenjab = 'Fungsional' THEN p.jabatan ELSE CASE WHEN p.id_j IS NULL THEN
                (SELECT jm.nama_jfu AS jabatan
                FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = p.id_pegawai LIMIT 1)
                ELSE j.jabatan 
                /*(CASE WHEN j.jabatan LIKE '%Kasubid Penempatan dalam Jabatan%' THEN 'Kepala Bidang Formasi, Data, dan Penatausahaan Pegawai pada Badan Kepegawaian dan Pengembangan Sumber Daya Aparatur Kota Bogor' ELSE j.jabatan END)*/ 
                END END AS jabatan, p.flag_pensiun
                FROM (SELECT pm.id_ptk,
                DATE_FORMAT(pm.tgl_update_sk_ptk,  '%d') AS tgl_usulan,
                DATE_FORMAT(pm.tgl_update_sk_ptk,  '%m') AS bln_usulan,
                DATE_FORMAT(pm.tgl_update_sk_ptk,  '%Y') AS thn_usulan,
                pm.nomor_sk_ptk, pm.sifat_sk_ptk, pm.lampiran_sk_ptk, pjp.jenis_pengajuan, p.id_pegawai, p.nip_baru,
                CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(', ',p.gelar_belakang) END) AS nama, p.tempat_lahir,
                p.jenis_kelamin, p.tgl_lahir, p.jenjab, pm.last_gol, g.pangkat, pm.last_jabatan, pm.last_id_unit_kerja, p.alamat,
                pm.last_jml_pasangan, pm.last_jml_anak, pm.id_jenis_pengajuan, pm.id_pegawai_pengesah,
                /*CASE WHEN pm.id_pegawai_pengesah = 3344 THEN 2905 ELSE (CASE WHEN pm.id_pegawai_pengesah = 12521 THEN 1719 ELSE pm.id_pegawai_pengesah END) END AS id_pegawai_pengesah,*/ 
                pm.flag_atas_nama, uk.nama_baru as unit_kerja,
                DATE_FORMAT(pm.tgl_input_pengajuan,'%d-%m-%Y') AS tgl_pengajuan, pm.nomor, uk.id_skpd, pm.last_idj_pemohon
                FROM ptk_master pm LEFT JOIN golongan g ON pm.last_gol = g.golongan,
                ptk_jenis_pengajuan pjp, pegawai p, unit_kerja uk
                WHERE pm.id_ptk = $id_ptk AND pm.id_jenis_pengajuan = pjp.id_jenis_pengajuan
                AND pm.id_pegawai_pemohon = p.id_pegawai AND pm.last_id_unit_kerja = uk.id_unit_kerja) a
                LEFT JOIN pegawai p ON a.id_pegawai_pengesah = p.id_pegawai
                LEFT JOIN jabatan j ON p.id_j = j.id_j) b
                LEFT JOIN golongan g ON b.pangkat_gol = g.golongan
                LEFT JOIN unit_kerja uk ON b.id_skpd = uk.id_unit_kerja) c LEFT JOIN
                jabatan j ON c.last_idj_pemohon = j.id_j) d 
                LEFT JOIN jabatan_plt jplt ON  d.id_pegawai_pengesah = jplt.id_pegawai AND jplt.status_aktif = 1
                LEFT JOIN jabatan_plh jplh ON d.id_pegawai_pengesah = jplh.id_pegawai AND jplh.status_aktif = 1";
        
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function cetakSKPtkKeluarga($id_ptk){
        $this->db->query("SET @row_number := 0");
        $sql = "SELECT FCN_ROW_NUMBER() as no_urut, fam.kategori_pengubahan, fam.status_keluarga, COUNT(fam.rank) AS jumlah,
                CASE WHEN (COUNT(fam.rank)>1) THEN
                  (GROUP_CONCAT(DISTINCT fam.rank,') ',UPPER(fam.last_nama),
                ' Tempat/tanggal lahir : ', fam.last_tempat_lahir,', ',fam.last_tgl_lahir,
                ' berdasarkan Kutipan ',fam.nama_berkas_syarat,
                ' Nomor : ',fam.last_keterangan_reference,
                ' dari ',(CASE WHEN fam.pengesah_akte IS NULL THEN '' ELSE fam.pengesah_akte END),
                ' tanggal ', (CASE WHEN fam.last_tgl_akte IS NULL THEN '' ELSE fam.last_tgl_akte END)
                ORDER BY fam.rank ASC SEPARATOR ', '))
                  ELSE
                  (GROUP_CONCAT(DISTINCT UPPER(fam.last_nama),
                ' Tempat/tanggal lahir : ', fam.last_tempat_lahir,', ',fam.last_tgl_lahir,
                ' berdasarkan Kutipan ',fam.nama_berkas_syarat,
                ' Nomor : ',fam.last_keterangan_reference,
                ' dari ',(CASE WHEN fam.pengesah_akte IS NULL THEN '' ELSE fam.pengesah_akte END),
                ' tanggal ', (CASE WHEN fam.last_tgl_akte IS NULL THEN '' ELSE fam.last_tgl_akte END)
                ORDER BY fam.idf ASC SEPARATOR ', ')) END AS uraian
                FROM (SELECT CASE a.id_status WHEN @curIdstatus THEN @curRow := @curRow + 1 ELSE @curRow := 1 END AS rank,
                a.kategori_pengubahan, a.status_keluarga, a.tipe_pengubahan_tunjangan,
                a.last_nama, a.last_tgl_lahir, a.last_tempat_lahir, a.last_tgl_references, a.last_keterangan_reference,
                a.last_tgl_akte, a.pengesah_akte, a.nama_sekolah, a.nama_berkas_syarat,
                @curIdstatus := a.id_status AS id_status_kel, idf
                FROM (SELECT ptp.id_tipe_pengubahan_tunjangan AS idf, ptp.kategori_pengubahan, sk.id_status, sk.status_keluarga, ptp.tipe_pengubahan_tunjangan,
                pk.last_nama, CONCAT(DATE_FORMAT(pk.last_tgl_lahir,'%d'),' ',CUSTOM_MONTH_NAME(DATE_FORMAT(pk.last_tgl_lahir,'%m')),' ',DATE_FORMAT(pk.last_tgl_lahir,'%Y')) AS last_tgl_lahir, pk.last_tempat_lahir,
                CONCAT(DATE_FORMAT(ps.last_tgl_references,'%d'),' ',CUSTOM_MONTH_NAME(DATE_FORMAT(ps.last_tgl_references,'%m')),' ',DATE_FORMAT(ps.last_tgl_references,'%Y')) AS last_tgl_references, ps.last_keterangan_reference,
                CONCAT(DATE_FORMAT(ps.last_tgl_akte,'%d'),' ',CUSTOM_MONTH_NAME(DATE_FORMAT(ps.last_tgl_akte,'%m')),' ',DATE_FORMAT(ps.last_tgl_akte,'%Y')) AS last_tgl_akte, ps.pengesah_akte, ps.nama_sekolah, ptp.nama_berkas_syarat
                FROM ptk_keluarga pk, ptk_tipe_pengubahan ptp, status_kel sk, ptk_syarat ps
                WHERE pk.id_ptk = $id_ptk AND pk.id_tipe_pengubahan_tunjangan = ptp.id_tipe_pengubahan_tunjangan AND
                pk.last_id_status_keluarga = sk.id_status AND pk.id_ptk_keluarga = ps.id_ptk_keluarga
                ORDER BY ptp.kategori_pengubahan, sk.id_status, ptp.id_tipe_pengubahan_tunjangan) a
                JOIN (SELECT @curRow := 0, @curIdstatus := 0) r) fam
                GROUP BY fam.kategori_pengubahan, fam.id_status_kel";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function updateDataPtk($data){
        $this->db->trans_begin();
        $sql = "SELECT j.eselon FROM
        (SELECT p.id_j FROM pegawai p
        WHERE p.id_pegawai = ".$data['idp_pengesah'].") a LEFT JOIN jabatan j ON a.id_j = j.id_j";
        $query = $this->db->query($sql);
        $eselon = $query->row()->eselon;
        if($eselon=='IIB'){
            $an = 0;
        }else if($eselon=='IIIA'){
            $an = 1;
        }else if($eselon=='IIIB'){
            $an = 2;
        }else{
            $an = 4;
        }
        $sql = "update ptk_master set nomor_sk_ptk = '".$data['nomorSkPtk']."', sifat_sk_ptk = '".$data['sifatSkPtk']."', lampiran_sk_ptk = '".
            $data['lampPtk']."', id_pegawai_pengesah = ".$data['idp_pengesah'].", flag_atas_nama = $an
            where id_ptk = ".$data['id_ptk'];
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

    public function updateNomorUsulanPtk($data){
        $this->db->trans_begin();
        $sql = "update ptk_master set nomor = '".$data['txtNomorPtk']."'
            where id_ptk = ".$data['id_ptk'];
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

    public function getUbahPtkSyarat($id_syarat){
        $sql = "SELECT ps.*, DATE_FORMAT(ps.last_tgl_references,'%d.%m.%Y') as tgl_ref,
        DATE_FORMAT(ps.last_tgl_akte,'%d.%m.%Y') as tgl_akte,
        pk.id_tipe_pengubahan_tunjangan, ptp.tipe_pengubahan_tunjangan,
        b.nm_berkas, kb.nm_kat, kb.id_kat_berkas
        FROM ptk_syarat ps, berkas b, kat_berkas kb, ptk_keluarga pk, ptk_tipe_pengubahan ptp
        WHERE ps.id_syarat = $id_syarat AND ps.id_berkas_syarat = b.id_berkas
        AND ps.id_ptk_keluarga = pk.id_ptk_keluarga AND pk.id_tipe_pengubahan_tunjangan = ptp.id_tipe_pengubahan_tunjangan
        AND b.id_kat = kb.id_kat_berkas";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function updateDataSyaratPtk($data){
        $this->db->trans_begin();
        if($data['tglRef']=='') {
            $tglref = 'NULL';
        }else{
            $tglref = explode(".", $data['tglRef']);
            $tglref = "'".$tglref[2].'-'.$tglref[1].'-'.$tglref[0]."'";
        }
        if($data['tglBerkas']=='') {
            $tglBerkas = 'NULL';
        }else{
            $tglBerkas = explode(".", $data['tglBerkas']);
            $tglBerkas = "'".$tglBerkas[2].'-'.$tglBerkas[1].'-'.$tglBerkas[0]."'";
        }
        $ketInstitusi = ($data['ketInstitusi']==''?'NULL':"'".$data['ketInstitusi']."'");
        $sql = "update ptk_syarat set last_tgl_references = ".$tglref.", last_keterangan_reference = '".$data['ketRef']."', last_tgl_akte = ".
            $tglBerkas.", pengesah_akte = '".$data['ketPengesah']."', nama_sekolah = ".$ketInstitusi."
            where id_syarat = ".$data['id_syarat'];
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

    public function infoKeluargaPegawai($idp){
        $sql = "SELECT b.*,
          CASE WHEN b.status_tunjangan_skum = 'Dapat' AND (b.id_status_verifikasi = 1 OR b.id_status_verifikasi = 4
          OR b.id_status_verifikasi = 5) THEN 'Valid' ELSE
          (CASE WHEN b.status_tunjangan_skum = 'Tidak Dapat' AND (b.id_status_verifikasi = 2 OR b.id_status_verifikasi = 3
          OR b.id_status_verifikasi = 6 OR b.id_status_verifikasi = 7 OR b.id_status_verifikasi = 8 OR b.id_status_verifikasi = 9)
          THEN 'Valid' ELSE 'Belum Valid' END)
          END AS status_validasi
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
              (CASE WHEN a.usia <= 21 THEN 'Anak < 21 Thn (Dapat)' ELSE
            (CASE WHEN (a.usia > 21 AND a.usia < 25) THEN
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
          (CASE WHEN a.usia <= 21 THEN NULL ELSE
            (CASE WHEN (a.usia > 21 AND a.usia < 25) THEN
              (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE DATE_FORMAT(a.tgl_lulus, '%d/%m/%Y') END) ELSE
                NULL END) ELSE NULL END) END) END)
        END AS ref_tanggal,
        CASE WHEN a.id_status = 9 THEN
        (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
          (CASE WHEN a.tgl_cerai IS NOT NULL THEN a.akte_cerai ELSE
            (CASE WHEN a.tgl_menikah IS NOT NULL THEN a.akte_menikah ELSE NULL END) END) END)
        ELSE
        (CASE WHEN a.tgl_meninggal IS NOT NULL THEN a.akte_meninggal ELSE
          (CASE WHEN a.usia <= 21 THEN NULL ELSE
            (CASE WHEN (a.usia > 21 AND a.usia < 25) THEN
              (CASE WHEN a.kuliah = 1 THEN (CASE WHEN a.tgl_lulus IS NULL THEN NULL ELSE NULL END) ELSE
                NULL END) ELSE NULL END) END) END)
        END AS ref_keterangan,
        CASE WHEN a.id_status = 9 THEN
        (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 2 ELSE
          (CASE WHEN a.tgl_cerai IS NOT NULL THEN 3 ELSE
            (CASE WHEN a.tgl_menikah IS NOT NULL THEN 1 ELSE 0 END) END) END)
        ELSE
        (CASE WHEN a.tgl_meninggal IS NOT NULL THEN 6 ELSE
          (CASE WHEN a.usia <= 21 THEN 4 ELSE
            (CASE WHEN (a.usia > 21 AND a.usia < 25) THEN
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
        DATE_FORMAT(k.tgl_lahir, '%d-%m-%Y') AS tgl_lahir, k.pekerjaan, k.jk, k.dapat_tunjangan,
        ROUND(DATEDIFF(CURRENT_DATE, DATE_FORMAT(k.tgl_lahir, '%Y/%m/%d'))/365,2) AS usia,
        k.tgl_menikah, k.akte_menikah, k.tgl_meninggal, k.akte_meninggal, k.tgl_cerai, k.akte_cerai,
        k.kuliah, k.tgl_lulus, k.akte_kelahiran, k.tgl_akte_kelahiran, k.tgl_akte_menikah,
        k.tgl_akte_meninggal, k.tgl_akte_cerai, k.no_ijazah, k.nama_sekolah
        FROM keluarga k, status_kel sk
        WHERE k.id_pegawai = $idp AND k.id_status = sk.id_status) a) b
        INNER JOIN keluarga k ON b.id_keluarga = k.id_keluarga
        ORDER BY b.id_status, b.tgl_lahir, b.nama";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getCountAllPengantarBPKADList($bln, $thn){
        $andKlausa = "";
        if($bln!='0'){
            $andKlausa .= " AND MONTH(pm.tgl_input_pengajuan) = ".$bln;
        }

        if($thn!='0'){
            $andKlausa .= " AND YEAR(pm.tgl_input_pengajuan) = ".$thn;
        }

        $sql = "SELECT COUNT(*) AS jumlah FROM
                (SELECT MONTH(pm.tgl_input_pengajuan) AS bln, YEAR(pm.tgl_input_pengajuan) AS thn,
                COUNT(pm.id_ptk) AS semua,
                SUM(IF((pm.idstatus_ptk = 1 OR pm.idstatus_ptk = 3),1,0)) AS dlm_proses_ybs,
                SUM(IF((pm.idstatus_ptk = 2 OR pm.idstatus_ptk = 4),1,0)) AS dlm_proses_bkpsda,
                SUM(IF(pm.idstatus_ptk = 5,1,0)) AS disetujui_bkpsda,
                SUM(IF(pm.idstatus_ptk = 6,1,0)) AS ditolak_bkpsda,
                SUM(IF(pm.idstatus_ptk = 7,1,0)) AS dibatalkan_bkpsda,
                SUM(IF(pm.idstatus_ptk = 8,1,0)) AS surat_bpkad_terbit,
                SUM(IF(pm.idstatus_ptk = 9,1,0)) AS dlm_proses_bpkad,
                SUM(IF(pm.idstatus_ptk = 10,1,0)) AS ditolak_bpkad,
                SUM(IF(pm.idstatus_ptk = 11,1,0)) AS tunjangan_berubah
                FROM ptk_master pm WHERE MONTH(pm.tgl_input_pengajuan) IS NOT NULL $andKlausa
                GROUP BY bln, thn) a";
        $query = $this->db->query($sql);
        foreach ($query->result() as $row){
            $count = $row->jumlah;
        }
        return $count;
    }

    public function getDropDataPengantarBPKADList($row_number_start, $bln, $thn, $limit){
        $andKlausa = "";
        if($bln!='0'){
            $andKlausa .= " AND MONTH(pm.tgl_input_pengajuan) = ".$bln;
        }

        if($thn!='0'){
            $andKlausa .= " AND YEAR(pm.tgl_input_pengajuan) = ".$thn;
        }

        $this->db->query("SET @row_number := $row_number_start");
        $sql = "SELECT FCN_ROW_NUMBER() as no_urut, b.* FROM
                (SELECT a.*, COUNT(p.id_pengantar) AS pengantar FROM
                (SELECT MONTH(pm.tgl_input_pengajuan) AS bln, YEAR(pm.tgl_input_pengajuan) AS thn,
                COUNT(pm.id_ptk) AS semua,
                SUM(IF((pm.idstatus_ptk = 1 OR pm.idstatus_ptk = 3),1,0)) AS dlm_proses_ybs,
                SUM(IF((pm.idstatus_ptk = 2 OR pm.idstatus_ptk = 4),1,0)) AS dlm_proses_bkpsda,
                SUM(IF(pm.idstatus_ptk = 5,1,0)) AS disetujui_bkpsda,
                SUM(IF(pm.idstatus_ptk = 6,1,0)) AS ditolak_bkpsda,
                SUM(IF(pm.idstatus_ptk = 7,1,0)) AS dibatalkan_bkpsda,
                SUM(IF(pm.idstatus_ptk = 8,1,0)) AS surat_bpkad_terbit,
                SUM(IF(pm.idstatus_ptk = 9,1,0)) AS dlm_proses_bpkad,
                SUM(IF(pm.idstatus_ptk = 10,1,0)) AS ditolak_bpkad,
                SUM(IF(pm.idstatus_ptk = 11,1,0)) AS tunjangan_berubah
                FROM ptk_master pm WHERE MONTH(pm.tgl_input_pengajuan) IS NOT NULL ".$andKlausa."
                GROUP BY bln, thn ".$limit.") a LEFT JOIN pengantar p ON a.bln = p.bln AND a.thn = p.thn AND p.id_jenis_pengantar = 1
                GROUP BY a.bln, a.thn) b";

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function viewPengantarPTKByPeriode($bln, $thn){
        $this->db->query("SET @row_number := 0");
        $sql = "SELECT FCN_ROW_NUMBER() as no_urut, p.id_pengantar, DATE_FORMAT(p.tgl_pembuatan, '%d/%m/%Y %H:%i:%s') AS tgl_pembuatan, p.bln, p.thn, p.nomor,
                p1.nip_baru, CONCAT(CASE WHEN p1.gelar_depan = '' THEN '' ELSE CONCAT(p1.gelar_depan, ' ') END,
                p1.nama, CASE WHEN p1.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p1.gelar_belakang) END) AS nama_kepala,
                COUNT(pd.idpengantar_detail) AS jumlah_usulan, p.id_berkas
                FROM pengantar p LEFT JOIN pegawai p1 ON p.id_pegawai_kepala = p1.id_pegawai
                LEFT JOIN pengantar_detail pd ON p.id_pengantar = pd.id_pengantar
                WHERE p.bln = $bln AND p.thn = $thn GROUP BY p.id_pengantar";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function nominatifRekapPTK_ByAktual($bln, $thn, $keywordCari, $stsPtk){
        if($stsPtk=='all'){
            $whereKlause = " AND MONTH(pm.tgl_input_pengajuan) = $bln AND YEAR(pm.tgl_input_pengajuan) = $thn";
            $orderKlause = " ORDER BY c.tgl_input_pengajuan_ori ASC";
        }else{
            $whereKlause = " AND MONTH(pm.tgl_approve) = $bln AND YEAR(pm.tgl_approve) = $thn AND pm.idstatus_ptk = 8";
            $orderKlause = " ORDER BY c.tgl_approve ASC";
        }

        $whereKlause1 = "WHERE c.id_ptk IS NOT NULL ";
        if (!(trim($keywordCari)== "") && !(trim($keywordCari)== "0")){
            $whereKlause1 .= " AND (c.nip_baru LIKE '%".$keywordCari."%'
                                OR c.nama LIKE '%".$keywordCari."%'
                                OR c.last_jabatan LIKE '%".$keywordCari."%'
								OR c.unit_kerja LIKE '%".$keywordCari."%') ";
        }

        $sql = "SELECT c.*, uk.nama_baru as opd, SUBSTRING(c.nip_baru,15,1) AS jk FROM
                (SELECT a.*, COUNT(pk.id_ptk_keluarga) AS jml_pengubahan,
                SUM(CASE WHEN (ptp.id_status_keluarga = 9 AND pk.id_tipe_pengubahan_tunjangan = 1 AND SUBSTRING(p.nip_baru,15,1)=1) THEN 1 ELSE 0 END) AS istri_nambah,
                SUM(CASE WHEN (ptp.id_status_keluarga = 9 AND pk.id_tipe_pengubahan_tunjangan = 1 AND SUBSTRING(p.nip_baru,15,1)=2) THEN 1 ELSE 0 END) AS suami_nambah,
                SUM(CASE WHEN (ptp.id_status_keluarga = 9 AND pk.id_tipe_pengubahan_tunjangan IN (2,3,12) AND SUBSTRING(p.nip_baru,15,1)=1) THEN 1 ELSE 0 END) AS istri_ngurang,
                SUM(CASE WHEN (ptp.id_status_keluarga = 9 AND pk.id_tipe_pengubahan_tunjangan IN (2,3,12) AND SUBSTRING(p.nip_baru,15,1)=2) THEN 1 ELSE 0 END) AS suami_ngurang,SUM(CASE WHEN (ptp.id_status_keluarga = 10 AND pk.id_tipe_pengubahan_tunjangan IN (4,5,15)) THEN 1 ELSE 0 END) AS anak_nambah,
                SUM(CASE WHEN (ptp.id_status_keluarga = 10 AND pk.id_tipe_pengubahan_tunjangan IN (6,7,8,9,10,11,13,14)) THEN 1 ELSE 0 END) AS anak_ngurang,
                p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.pangkat,
                uk.nama_baru AS unit_kerja, uk.id_skpd
                FROM
                (SELECT pm.id_ptk, DATE_FORMAT(pm.tgl_input_pengajuan, '%d/%m/%Y %H:%i:%s') AS tgl_input_pengajuan, pjp.jenis_pengajuan,
                pm.tgl_input_pengajuan AS tgl_input_pengajuan_ori, rsp.status_ptk,
                DATE_FORMAT(pm.tgl_update_pengajuan, '%d/%m/%Y %H:%i:%s') AS tgl_update_pengajuan, pm.last_jml_pasangan, pm.last_jml_anak,
                (pm.last_jml_pasangan+pm.last_jml_anak) AS jumlah_tertunjang_keluarga,
                pm.id_pegawai_pemohon, pm.last_id_unit_kerja, pm.last_gol, pm.last_jabatan,
                (1+pm.last_jml_pasangan+pm.last_jml_anak) AS jumlah_total_tertunjang, pm.id_berkas_ptk, pm.tgl_approve,
                pm.tgl_update_sk_ptk, DATE_FORMAT(pm.tgl_approve, '%d/%m/%Y %H:%i:%s') AS tgl_approve2
                FROM ptk_master pm INNER JOIN ptk_jenis_pengajuan pjp
                ON pm.id_jenis_pengajuan = pjp.id_jenis_pengajuan, ref_status_ptk rsp
                WHERE pm.idstatus_ptk = rsp.id_status_ptk ".$whereKlause.") a
                INNER JOIN ptk_keluarga pk ON a.id_ptk = pk.id_ptk
                INNER JOIN ptk_tipe_pengubahan ptp ON ptp.id_tipe_pengubahan_tunjangan = pk.id_tipe_pengubahan_tunjangan
                INNER JOIN pegawai p ON a.id_pegawai_pemohon = p.id_pegawai
                INNER JOIN golongan g ON a.last_gol = g.golongan
                INNER JOIN unit_kerja uk ON a.last_id_unit_kerja = uk.id_unit_kerja
                GROUP BY a.id_ptk ORDER BY a.tgl_input_pengajuan ASC) c
                INNER JOIN unit_kerja uk ON c.id_skpd = uk.id_unit_kerja ".$whereKlause1.$orderKlause;

        $query = $this->db->query($sql);
        return $query->result();
    }

    public function nominatifRekapPTK_ByPengantar($id_pengantar){
        $sql = "SELECT c.*, uk.nama_baru as opd, SUBSTRING(c.nip_baru,15,1) AS jk FROM
                (SELECT a.*, COUNT(pk.id_ptk_keluarga) AS jml_pengubahan,
                SUM(CASE WHEN (ptp.id_status_keluarga = 9 AND pk.id_tipe_pengubahan_tunjangan = 1 AND SUBSTRING(p.nip_baru,15,1)=1) THEN 1 ELSE 0 END) AS istri_nambah,
                SUM(CASE WHEN (ptp.id_status_keluarga = 9 AND pk.id_tipe_pengubahan_tunjangan = 1 AND SUBSTRING(p.nip_baru,15,1)=2) THEN 1 ELSE 0 END) AS suami_nambah,
                SUM(CASE WHEN (ptp.id_status_keluarga = 9 AND pk.id_tipe_pengubahan_tunjangan IN (2,3,12) AND SUBSTRING(p.nip_baru,15,1)=1) THEN 1 ELSE 0 END) AS istri_ngurang,
                SUM(CASE WHEN (ptp.id_status_keluarga = 9 AND pk.id_tipe_pengubahan_tunjangan IN (2,3,12) AND SUBSTRING(p.nip_baru,15,1)=2) THEN 1 ELSE 0 END) AS suami_ngurang,
                SUM(CASE WHEN (ptp.id_status_keluarga = 10 AND pk.id_tipe_pengubahan_tunjangan IN (4,5,15)) THEN 1 ELSE 0 END) AS anak_nambah,
                SUM(CASE WHEN (ptp.id_status_keluarga = 10 AND pk.id_tipe_pengubahan_tunjangan IN (6,7,8,9,10,11,13,14,16)) THEN 1 ELSE 0 END) AS anak_ngurang,
                p.nip_baru, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama, g.pangkat,
                uk.nama_baru AS unit_kerja, uk.id_skpd
                FROM
                (SELECT e.id_referensi as id_ptk, e.idpengantar_detail, e.jml_pegawai_tertunjang,
                DATE_FORMAT(pm.tgl_input_pengajuan, '%d/%m/%Y %H:%i:%s') AS tgl_input_pengajuan,
                pm.tgl_input_pengajuan as tgl_input_pengajuan_ori, pm.id_jenis_pengajuan,
                pjp.jenis_pengajuan, pm.last_jml_pasangan, pm.last_jml_anak, (pm.last_jml_pasangan+pm.last_jml_anak) AS jumlah_tertunjang_keluarga,
                pm.id_pegawai_pemohon, pm.last_id_unit_kerja, pm.last_gol, pm.last_jabatan,
                (e.jml_pegawai_tertunjang+pm.last_jml_pasangan+pm.last_jml_anak) AS jumlah_total_tertunjang
                FROM (SELECT pd.id_referensi, pd.idpengantar_detail,
                SUM(1) AS jml_pegawai_tertunjang
                FROM pengantar p, pengantar_detail pd
                WHERE p.id_pengantar = $id_pengantar AND p.id_pengantar = pd.id_pengantar
                GROUP BY pd.id_referensi) e INNER JOIN ptk_master pm ON e.id_referensi = pm.id_ptk
                INNER JOIN ptk_jenis_pengajuan pjp ON pm.id_jenis_pengajuan = pjp.id_jenis_pengajuan ) a
                INNER JOIN ptk_keluarga pk ON a.id_ptk = pk.id_ptk
                INNER JOIN ptk_tipe_pengubahan ptp ON ptp.id_tipe_pengubahan_tunjangan = pk.id_tipe_pengubahan_tunjangan
                INNER JOIN pegawai p ON a.id_pegawai_pemohon = p.id_pegawai
                INNER JOIN golongan g ON a.last_gol = g.golongan
                INNER JOIN unit_kerja uk ON a.last_id_unit_kerja = uk.id_unit_kerja
                GROUP BY a.id_ptk ORDER BY a.tgl_input_pengajuan ASC) c
                INNER JOIN unit_kerja uk ON c.id_skpd = uk.id_unit_kerja
                ORDER BY c.tgl_input_pengajuan_ori DESC";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getBulanDataPengantar($id_pengantar){
        $sql = "SELECT a.thn_approve, a.bln_approve FROM
                (SELECT MONTH(pm.tgl_approve) as bln_approve, YEAR(pm.tgl_approve) as thn_approve
                FROM (SELECT pd.id_referensi, pd.idpengantar_detail,
                SUM(1) AS jml_pegawai_tertunjang
                FROM pengantar p, pengantar_detail pd
                WHERE p.id_pengantar = $id_pengantar AND p.id_pengantar = pd.id_pengantar
                GROUP BY pd.id_referensi) e INNER JOIN ptk_master pm ON e.id_referensi = pm.id_ptk
                INNER JOIN ptk_jenis_pengajuan pjp ON pm.id_jenis_pengajuan = pjp.id_jenis_pengajuan
                ORDER BY pm.tgl_approve ASC) a GROUP BY a.thn_approve, a.bln_approve";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getUbahPengantar($id_pengantar){
        $sql = "SELECT pj.jenis_pengantar, p.bln, p.thn, DATE_FORMAT(p.tgl_pembuatan, '%d/%m/%Y %H:%i:%s') AS tgl_pembuatan, p.nomor,
                pe.id_pegawai as id_pegawai_pengesah, pe.nip_baru AS nip_pengesah, CONCAT(CASE WHEN pe.gelar_depan = '' THEN '' ELSE CONCAT(pe.gelar_depan, ' ') END,
                pe.nama, CASE WHEN pe.gelar_belakang = '' THEN '' ELSE CONCAT(' ',pe.gelar_belakang) END) AS nama_pengesah,
                CASE WHEN pe.jenjab = 'Fungsional' THEN pe.jabatan ELSE CASE WHEN pe.id_j IS NULL THEN
                (SELECT jm.nama_jfu AS jabatan FROM jfu_pegawai jp, jfu_master jm
                WHERE jp.kode_jabatan = jm.kode_jabatan AND jp.id_pegawai = pe.id_pegawai LIMIT 1)
                ELSE j.jabatan END END AS jabatan, pe.flag_pensiun
                FROM pengantar p INNER JOIN pengantar_jenis pj ON p.id_jenis_pengantar = pj.id_jenis_pengantar
                INNER JOIN pegawai pe ON p.id_pegawai_kepala = pe.id_pegawai
                LEFT JOIN jabatan j ON pe.id_j = j.id_j
                WHERE p.id_pengantar = $id_pengantar";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function updateDataPengantarPTK($data){
        $this->db->trans_begin();
        $sql = "update pengantar set nomor = '".$data['nomorPtr']."', id_pegawai_kepala = ".$data['txtIdPegawaiPengesah']."
            where id_pengantar = ".$data['id_ptr'];
        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = false;
        }else{
            $strIdPtk = explode('#',$data['strIdPtk']);
            $sql = "delete from pengantar_detail where id_pengantar = ".$data['id_ptr'];
            $this->db->query($sql);
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $query = false;
            }else {
                for ($x = 0; $x < sizeof($strIdPtk); $x++) {
                    $sql = "insert into pengantar_detail(id_referensi, id_pengantar)
                            values (".$strIdPtk[$x].",".$data['id_ptr'].")";
                    $this->db->query($sql);
                }
                if ($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $query = false;
                }else{
                    $this->db->trans_commit();
                    $query = true;
                }
            }
        }
        return $query;
    }

    public function hapusDataPengantarPTK($id_pengantar){
        $this->db->trans_begin();
        $sql = "delete from pengantar where id_pengantar = $id_pengantar";
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

    public function cetakPengantarPtk($id_pengantar){
        $sql = "SELECT p.id_pengantar, DATE_FORMAT(p.tgl_pembuatan, '%d/%m/%Y') AS tgl_pembuatan, p.bln, p.thn, p.nomor, p1.id_pegawai,
                p1.nip_baru, CONCAT(CASE WHEN p1.gelar_depan = '' THEN '' ELSE CONCAT(p1.gelar_depan, ' ') END,
                p1.nama, CASE WHEN p1.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p1.gelar_belakang) END) AS nama_kepala,
                g.pangkat, COUNT(pd.idpengantar_detail) AS jumlah_usulan, p.id_berkas
                FROM pengantar p LEFT JOIN pegawai p1 ON p.id_pegawai_kepala = p1.id_pegawai
                LEFT JOIN golongan g ON p1.pangkat_gol = g.golongan
                LEFT JOIN pengantar_detail pd ON p.id_pengantar = pd.id_pengantar
                WHERE p.id_pengantar = $id_pengantar GROUP BY p.id_pengantar";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function getPengesah(){
        $sql = "SELECT a.*, p.id_pegawai as id_pegawai_pengesah, p.nip_baru AS nip_pengesah, CONCAT(CASE WHEN p.gelar_depan = '' THEN '' ELSE CONCAT(p.gelar_depan, ' ') END,
                p.nama, CASE WHEN p.gelar_belakang = '' THEN '' ELSE CONCAT(' ',p.gelar_belakang) END) AS nama_pengesah, p.flag_pensiun
                FROM (SELECT j.id_j, j.jabatan FROM jabatan j
                WHERE j.Tahun = (SELECT MAX(Tahun) FROM jabatan j1)
                AND j.eselon = 'IIB' AND j.id_unit_kerja = (SELECT uk.id_unit_kerja FROM unit_kerja uk
                WHERE uk.tahun = (SELECT MAX(uk1.tahun) FROM unit_kerja uk1) AND uk.nama_baru LIKE '%Kepegawaian%')) a
                LEFT JOIN pegawai p ON p.id_j = a.id_j";
        $query = $this->db->query($sql);
        return $query->result();
    }

    public function tambah_data_pengantar($data){
        $this->db->trans_begin();
        $sql = "insert into pengantar(id_jenis_pengantar, tgl_pembuatan, bln, thn, nomor, id_pegawai_kepala) ".
                "values (1,NOW(),".$data['bln'].",".$data['thn'].",'".$data['nomor']."',".$data['idp_pengesah'].")";

        $this->db->query($sql);
        if ($this->db->trans_status() === FALSE){
            $this->db->trans_rollback();
            $query = false;
            $idptr = 0;
        }else{
            $idptr = $this->db->insert_id();
            foreach( $data['chkIdPTKPilih'] as $key => $n ) {
                $sql = "insert into pengantar_detail(id_referensi, id_pengantar)
                        values (".$data['chkIdPTKPilih'][$key].",".$idptr.")";
                $this->db->query($sql);
            }
            if ($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $query = false;
                $idptr = 0;
            }else{
                $this->db->trans_commit();
                $query = true;
            }
        }
        return array(
            'query' => $query,
            'idptr' => $idptr
        );
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