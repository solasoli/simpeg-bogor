<?php 
include("konek.php");
$q=mysql_query("select * from (select count(*) as jumlah,berkas.id_berkas from berkas inner join isi_berkas on berkas.id_berkas=isi_berkas.id_berkas inner join pegawai on pegawai.id_pegawai=berkas.id_pegawai where flag_pensiun=0 group by id_berkas) as d where jumlah>1");
?>