<?php
class Login_model extends CI_Model {


	function __construct() {
		parent::__construct();
	}

	function asupcoy($userx, $passx) {
		$sql = "SELECT distinct
   	p.id_pegawai,
    p.nip_baru AS nip,
    IF(LENGTH(p.gelar_belakang) > 1,
        CONCAT(IF(LENGTH(p.gelar_depan) > 1,
                    CONCAT(p.gelar_depan, ' '),
                    ''),
                p.nama,
                CONCAT(', ', p.gelar_belakang)),
        CONCAT(IF(LENGTH(p.gelar_depan) > 1,
                    CONCAT(p.gelar_depan, ' '),
                    ''),
                p.nama)) AS nama,
    IF(p.id_j IS NOT NULL,
        'id_j',
        IF(p.jenjab = 'Struktural',
            'id_jfu',
            'id_jft')) AS kolom,
    IF(p.id_j IS NOT NULL,
        j.id_j,
        IF(p.jenjab = 'Struktural',
            jfu_master.id_jfu,
            'id_jft')) AS isi_kolom,

    clk.id_unit_kerja AS id_unit_kerja,
    uk.id_skpd AS id_skpd

FROM
    pegawai p
        LEFT JOIN
    view_pejabat_struktural_tmt j ON j.id_j = p.id_j
        LEFT JOIN
    jfu_pegawai jfu ON jfu.id_pegawai = p.id_pegawai
        LEFT JOIN
    jfu_master ON jfu_master.kode_jabatan = jfu.kode_jabatan

        INNER JOIN
    current_lokasi_kerja clk ON clk.id_pegawai = p.id_pegawai
        INNER JOIN
    unit_kerja uk ON uk.id_unit_kerja = clk.id_unit_kerja
		WHERE p.nip_baru = '".$userx."' and password = '".$passx."'";
		$query = $this->db->query($sql);
		if($query->num_rows()>0) {
			return $query->result_array();
		}
	}
}
?>
