<?php

mysql_connect("localhost","simpeg_root","51mp36"); mysql_select_db("simpeg");

mysql_connect("localhost","simpeg_root","51mp36"); mysql_select_db("simpeg");

$q1 = mysql_query("select * from pegawai limit 2001,10000");

echo "Running.. <br />";

while($data1=mysql_fetch_array($q1))

{"simpeg.db.kotabogor.net","simpeg","Madangkara2017"



	$q2=mysql_query("select nama_baru from riwayat_mutasi_kerja inner join unit_kerja on riwayat_mutasi_kerja.id_unit_kerja=unit_kerja.id_unit_kerja inner join pegawai on riwayat_mutasi_kerja.id_pegawai=pegawai.id_pegawai where pegawai.id_pegawai=$data1[0]");



	$uker=mysql_fetch_array($q2);



	mysql_connect("simpeg.db.kotabogor.net","simpeg","Madangkara2017"); mysql_select_db("simpeg_new");

	//generate kode pns

	$t=substr(time(),0,7);

	$qi=mysql_query("select count(*) from tpegawai_identitas");

	$jd=mysql_fetch_array($qi);

	if($jd[0]==0)

		$kode='0001';

	$qlast=mysql_query("select right(kode_pns,4) from tpegawai_identitas order by right(kode_pns,4) desc");

	$gi = mysql_fetch_array($qlast);

	if(substr($gi[0],2,1) == '0')

	{//satuan

		$id1=substr($gi[0],3,1);

		$id1=$id1+1;

		$key="000".$id1;

	}

	else if (substr($gi[0],1,1)=='0')

	{

		//puluhan

		$id1=substr($gi[0],2,2);

		$id1=$id1+1;

		$key="00".$id1;

	}

	else if (substr($gi[0],0,1)=='0')

	{

		//ratusan

		$id1=substr($gi[0],1,3);

		$id1=$id1+1;

		$key="0".$id1;

	}

	else

	{

		//ribuan

		$key++;

	}



	$kode_pns="PNS".$t.$key;





	//generate agama

	if($data1[5]!='-')

	{

		$qag=mysql_query("select kode_agama from tagama where nama like '%$data1[5]%'");

		$da=mysql_fetch_array($qag);

		$kode_agama=$da[0];

	}

	else

		$kode_agama='AG11635924911';



	//generate status nikah

	if($data1[22]!='-')

		$kode_status='PW11635925441';

	else if($data1[22]=='Menikah')

		$kode_status='PW11635925441';

	else if($data1[22]=='Belum Menikah')

		$kode_status='PW11635925501';

	else if($data1[22]=='Duda')

		$kode_status='PW11635925781';

	else

		$kode_status='PW11635925781';



	//generate golongan darah

	if($data1[4]!='-')

		$kode_gol_darah='GD11635926071';

	else if($data1[4]=='A')

		$kode_gol_darah='GD1163592600';

	else if($data1[4]=='B')

		$kode_gol_darah='GD1163592600';

	else if($data1[4]=='AB')

		$kode_gol_darah='GD11635926121';

	else if($data1[4]=='O')

		$kode_gol_darah='GD11635926171';



	//generate tipe pns

	if($data1[13]=='-')

		$kode_tipe_pns='TP11648136071';

	else

		$kode_tipe_pns='TP11648135921';



	//kode_propinsi

	$kode_propinsi='PRO11635927961';



	//generate kode_instansi

	$kode_instansi_induk='001';

	

	//generate kode_kedudukan

	$kedudukans = mysql_query("SELECT kode_kedudukan,nama from tkedudukan_pgw");

	while($r= mysql_fetch_array($kedudukans))

	{

		if(strstr($data1[19], $r[nama]))

		{

			$kode_kedudukan = $r[kode_kedudukan];

		}

	}

	

	//generate path foto

	$path_foto = $data1['nip_baru'];

	$created_on = date("Y-m-d");

	$last_modified = $created_on;

	$created_by = "root";

	$modified_by = "root";

	

	

	mysql_query("insert into tpegawai_identitas (

					kode_pns, nip, kode_agama, kode_status, kode_gol_darah, kode_tipe, kode_propinsi, kode_instansi_induk, 

					kode_kedudukan, nama, gelar_didepan, gelar_dibelakang, tempat_lahir, tgl_lahir, jenis_kelamin, alamat_rumah, kota, kecamatan, kelurahan, 

					desa, jalan, kode_pos, no_telp, no_karpeg, no_akses, no_taspen, no_istri_suami, npwp, nik, path_foto, status_pensiun, 

					tgl_pensiun, tmt_pensiun, tinggi, berat_badan, rambut, bentuk_muka, warna_kulit, ciri_khas, cacat_tubuh, kegemaran, 

					created_on, last_modified, created_by, modified_by

				) values (

					'$kode_pns','$data1[nip_baru]','$kode_agama','$kode_status','$kode_gol_darah','$kode_tipe_pns','$kode_propinsi','$kode_instansi_induk',

					'$kode_kedudukan','$data1[1]','-','-','$data1[tempat_lahir]','$data1[tgl_lahir]','$data1[jenis_kelamin]','$data1[alamat]','-','-','-',

					'-','-','-','-','-','-','-','-','-','-','$path_foto','N',

					'0000-00-00','','-','-','-','-','-','-','-','-',

					'$created_on','$last_modified','root','root')");

					

}

echo "Finished!";

?>