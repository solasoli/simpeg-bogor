<table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup">
	<tr>
	  <td>No</td>
	  <td>Jenis SK</td>
	  <td>Golongan,Masa Kerja</td>
	  <td nowrap="nowrap">No SK</td>
	  <td>Tanggal SK</td>
	  <td>TMT SK</td>
	  <td>Pegesah SK</td>
	  <td>Pemberi SK</td>
	  <td>Berkas Digital</td>
	  <td>Aksi</td>
	</tr>
	<?
	$k=1;
	$qsk=mysqli_query($mysqli,"select * from sk where id_pegawai=$id order by tmt desc, id_kategori_sk");
	while($cu=mysqli_fetch_array($qsk))
	{
		$qt=mysqli_query($mysqli,"select nama_sk from kategori_sk where id_kategori_sk=$cu[2]");
		$tipe=mysqli_fetch_array($qt);
		echo("  <tr>
	  <td>$k</td>
	  <td>"); ?>
	  <select name="a<? echo($k); ?>" id="a<? echo($k); ?>" style="width:160px;" >
	  <?

	  $qks=mysqli_query($mysqli,"SELECT * FROM `kategori_sk`");
		while($da=mysqli_fetch_array($qks))
		{
			if($cu[2]==$da[0])
		echo("<option value=$da[0] selected>$da[1]</option>");
		else
		echo("<option value=$da[0]>$da[1]</option>");
		}

		?>
	</select>
	  <?php

	  $tsk1=substr($cu[4],8,2);
	  $bsk1=substr($cu[4],5,2);
	  $thsk1=substr($cu[4],0,4);

	   $tsk2=substr($cu[8],8,2);
	  $bsk2=substr($cu[8],5,2);
	  $thsk2=substr($cu[8],0,4);
	  echo("</td>
	  <td><input type=text name=keket$k id=keket$k value='$cu[keterangan]' /></td>
	  <td nowrap> <input type=text name=nosk$k id=nosk$k value='$cu[3]' size=30 class=hurup /> </td>
	  <td><input type=text name=tgsk$k id=tgsk$k value=$tsk1-$bsk1-$thsk1 class=tcal size=8 /></td>
	  <td><input type=text name=tmsk$k id=tmsk$k value=$tsk2-$bsk2-$thsk2 class=tcal size=8 /></td>
	  <td nowrap> <input type=text name=sah$k id=sah$k value='$cu[6]' size=27 class=hurup /> </td>
		<td nowrap> <input type=text name=beri$k id=beri$k value='$cu[5]' size=27 class=hurup /> </td>
		<input type=hidden name=idsk$k id=idsk$k value=$cu[0] />
	  <td>");
	if($cu[10]==NULL or $cu[10]==0)
	  echo("Belum Ada </td>");
	  else
	  {

	  $qli=mysqli_query($mysqli,"select file_name from isi_berkas where id_berkas=$cu[10]");
		$lihat=mysqli_fetch_array($qli);
		$nf=basename($lihat[0]);
	$ext = pathinfo("$lihat[0]", PATHINFO_EXTENSION);
	   if($ext!="pdf")
	  echo("<a href=berkas.php?idb=$bata[15] target=_blank>Previews </a></td>");
	  else
	  echo("<a href=../simpeg/berkas/$nf target=_blank>Previews </a></td>");
	  }
	  ?>


	  <td><a href="<?php echo "hapus_berkas.php?idsk=$cu[id_sk]&id=$cu[id_pegawai]"?>" onclick="return confirm('yakin lw mau ngehapus?');">hapus</a></td>
	<?php
  echo("</tr>");
		$k++;
		}

	?>
	  <input type="hidden" name="jsk" value="<? $jambleh=$k-1; echo($jambleh); ?>" id="jsk" />
	  <form name="form11" id="form11" method="post" action="dock2.php">
	  <tr>
		<td>  [+]</td>
		<td>  Jenis Berkas
	</select></td>
		<td>  </td>
		<td>  </td>
		<td>  </td>
		<td>  </td>
		<td>  </td>
		<td>  </td>
		<td>  </td>
		<td>  </td>


		</tr>
		<tr>
		<td>  </td>
		<td>  <select name="arsip" id="arsip" style="width:160px;" >
	  <?

	  $qks=mysqli_query($mysqli,"SELECT * FROM `kat_berkas`");
		while($da=mysqli_fetch_array($qks))
		{
		echo("<option value=$da[0]>$da[1]</option>");
		}

		?>
	</select>
	    <script type="text/javascript">
		$(document).ready(function(){
		$('select').change(function () {
     var optionSelected = $(this).find("option:selected");
     var valueSelected  = optionSelected.val();
     var textSelected   = optionSelected.text();

	 alert(textSelected);
 });

 });
		</script>

	</td>
		<td>  </td>
		<td>  </td>
		<td>  </td>
		<td>  </td>
		<td>  </td>
		<td>  </td>
		<td>  </td>
		<td>  </td>


		</tr>
		</form>
  </table>
