SELECT distinct
	NULL,
    p.id_pegawai,
    concat('\'',p.nip_baru) as nip,
    p.tempat_lahir,
    p.tgl_lahir,
    IF(LENGTH(p.gelar_belakang) > 1,
        concat(IF(LENGTH(p.gelar_depan) > 1,
                    concat(p.gelar_depan, ' '),
                    ''),
                p.nama,
                concat(', ', p.gelar_belakang)),
        concat(IF(LENGTH(p.gelar_depan) > 1,
                    concat(p.gelar_depan, ' '),
                    ''),
                p.nama)) as nama,
    gol.gol_akhir,
    gol.gol_akhir_tmt,
    IF(p.id_j IS NOT NULL,
        j.jabatan,
        IF(p.jenjab = 'Struktural',
            jfu_master.nama_jfu,
            p.jabatan)) as jabatan,
	IF(p.id_j IS NOT NULL,
        j.eselon,
        'NS') as eselon,
    IF(p.id_j IS NOT NULL,
        j.tmt,
        IF(p.jenjab = 'Struktural',
            '2015-01-01',
            gol.gol_akhir_tmt)) as jabatan_tmt,	
    FLOOR(datediff('2015-12-31', tmt_mundur) / 365) - gol.pengurang as mkt,
    FLOOR(((datediff('2015-12-31', tmt_mundur)) - (365 * FLOOR(datediff(curdate(), tmt_mundur) / 365))) / 30) as mkb,
    view_last_diklat_pim.nama_diklat,
    view_last_diklat_pim.tgl_diklat as tgl_diklat,
	view_last_diklat_pim.jml_jam_diklat,
    pendidikan.lembaga_pendidikan,
    pendidikan.tahun_lulus,
    pendidikan.tingkat_pendidikan,
	pendidikan.level_p,
    YEAR(curdate()) - YEAR(tgl_lahir) as usia,
    clk.id_unit_kerja as id_unit_kerja,
    uk.id_skpd as id_skpd
    
FROM
    pegawai p
        INNER JOIN
    view_pangkat_awal_terakhir gol ON p.id_pegawai = gol.id_pegawai
        LEFT JOIN
    view_pejabat_struktural_tmt j ON j.id_j = p.id_j
        LEFT JOIN
    jfu_pegawai jfu ON jfu.id_pegawai = p.id_pegawai
		LEFT JOIN
	jfu_master on jfu_master.kode_jabatan = jfu.kode_jabatan
        inner join
    (select 
        v.id_pegawai,
            subdate(v.gol_awal_tmt, interval concat(v.gol_awal_mkt,'-',v.gol_awal_mkb) YEAR_MONTH) as tmt_mundur
    from
        view_pangkat_awal_terakhir v) as hitung ON hitung.id_pegawai = p.id_pegawai
        left join
    view_last_diklat_pim ON view_last_diklat_pim.id_pegawai = p.id_pegawai
        left join
    pendidikan_terakhir pendidikan ON pendidikan.id_pegawai = p.id_pegawai
        inner join
    current_lokasi_kerja clk ON clk.id_pegawai = p.id_pegawai
        inner join
    unit_kerja uk ON uk.id_unit_kerja = clk.id_unit_kerja       
WHERE
    p.flag_pensiun = 0	
	AND p.id_pegawai = 11301
ORDER BY 
	gol.gol_akhir DESC , 
	gol.gol_akhir_tmt ASC , 
	j.eselon ASC , 
	jabatan_tmt ASC , 
	mkt DESC , 
	mkb DESC , 
	pendidikan.level_p ASC , 
	pendidikan.tahun_lulus ASC , 
	usia DESC;