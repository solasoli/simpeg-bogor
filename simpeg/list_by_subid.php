
<h1>HIRARKI PEGAWAI</h1>
<br/>
<p class="well">
	Berikut ini merupakan daftar pegawai yang disusun menurut hirarki struktur organisasi SKPD. Klik nama pegawai untuk melakukan perubahan data.
	Bila terjadi perubahan posisi pegawai, silahkan lakukan perubahan dan wajib melaporkan perubahan tersebut dengan menekan tombol LAPORKAN PERUBAHAN.
</p>
<a class="btn" id="btn_laporkan">Laporkan Perubahan</a>
<br/>
<br/>
<?php
//require_once "konek.php";
	$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
$listed = [];
$list_count = 0; $level = 1;
$qu = mysqli_query($mysqli,"select id_unit_kerja from current_lokasi_kerja where id_pegawai=".$ata['id_pegawai']);
$unit = mysqli_fetch_array($qu);

function print_separator()
{
	global $level;
	for($i=0; $i<$level; $i++)
	{
		echo ("&nbsp;&nbsp;&nbsp;&nbsp;");
	}
}

function write_down_tree($r)
{
	$mysqli = new mysqli("simpeg.db.kotabogor.net","simpeg","Madangkara2017","simpeg");
	global $listed, $list_count, $level;

	if(!on_list($r['id_pegawai']))
	{

		$qRmk = "SELECT rmk.id_j_bos, rmk.jabatan
				 FROM riwayat_mutasi_kerja rmk
				 INNER JOIN sk s on s.id_sk = rmk.id_sk
				 WHERE rmk.id_pegawai = $r[id_pegawai]
				 ORDER BY s.tmt DESC
				 LIMIT 0,1";

		//$rsRmk = mysqli_query($mysqli,$qRmk);
		$rsRmk = mysqli_query($mysqli, $qRmk);
		$rmk = mysqli_fetch_array($rsRmk);


		$listed[$list_count] = $r['id_pegawai'];
		$list_count++;
		if($r['id_j'] > 0)
		{
			echo "<a target='_blank' href='index3.php?x=box.php&od=$r[id_pegawai]'><strong>$r[nama]</strong><i>($rmk[jabatan])</i></a><br/>";
			$q_staf = "SELECT rmk.id_j_bos, p.nama, p.id_j, rmk.id_pegawai
						FROM riwayat_mutasi_kerja rmk
						INNER JOIN pegawai p on p.id_pegawai = rmk.id_pegawai
						INNER JOIN
						(
							SELECT s.id_sk, tmt
							FROM sk s
							INNER JOIN
							(
								SELECT rmk.id_pegawai, MAX(s.tmt) as max_tmt, s.id_sk
								FROM riwayat_mutasi_kerja rmk
								INNER JOIN sk s ON s.id_sk = rmk.id_sk
								GROUP BY rmk.id_pegawai
							) AS t ON t.id_pegawai = s.id_pegawai AND s.tmt = t.max_tmt
						) AS t ON t.id_sk = rmk.id_sk
					   WHERE rmk.id_j_bos = $r[id_j] AND p.flag_pensiun = 0";


			$rs_staf = mysqli_query($mysqli,$q_staf);
			while($staf = mysqli_fetch_array($rs_staf))
			{
					$level++;
					print_separator();
					write_down_tree($staf);
			}
		}
		else
			echo "<a target='_blank' href='index3.php?x=box.php&od=$r[id_pegawai]'>$r[nama]</a><br/>";

		$level--;
	}
	mysqli_close($mysqli);
}

function on_list($id_pegawai)
{
	
	global $listed;
	for($i = 0; $i < sizeof($listed); $i++)
	{
		if($listed[$i] == $id_pegawai)
			return true;
	}
	return false;
}

$qo = mysqli_query($mysqli,"select pegawai.id_j, pegawai.id_pegawai, nama, pegawai.pangkat_gol, nip_baru, pegawai.id_pegawai, nama_baru , current_lokasi_kerja.id_unit_kerja
				 from pegawai
				 inner join current_lokasi_kerja on pegawai.id_pegawai=current_lokasi_kerja.id_pegawai
				 inner join unit_kerja on unit_kerja.id_unit_kerja=current_lokasi_kerja.id_unit_kerja
				 where unit_kerja.id_skpd=$unit[0] and flag_pensiun=0
				 ORDER BY `pegawai`.`pangkat_gol` DESC ");

while($r = mysqli_fetch_array($qo))
{
	set_time_limit(0);
	write_down_tree($r);
}
?>

<script type="text/javascript">
$("#btn_laporkan").click(function()
{
	$.post('send_perubahan_hirarki.php', { id: <?php echo $ata['id_pegawai']; ?> }, function(data)
	{
		alert("Perubahan hirarki pegawai telah dilaporkan");
	});
});
</script>
