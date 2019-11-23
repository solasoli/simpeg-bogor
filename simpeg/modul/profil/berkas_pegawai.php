<?php
/*
echo "<pre>";
print_r($_POST);
echo "</pre>";
*/

if(@$_POST['jnk_pangkat']!=NULL and @$_POST['nsk_pangkat']!=NULL and @$_POST['tmsk_pangkat']!=NULL and @$_POST['tsk_pangkat']!=NULL)
{
if(!$pbsk)
$pbsk='-';

if(!$pgsk)
$pgsk='-';

$cboGol = $_POST["gol_sk_pangkat"];
$thnMkg = $_POST["thn_mkg_pangkat"];
$blnMkg = $_POST["bln_mkg_pangkat"];
if($thnMkg==""){
    $thnMkg = 0;
}
if($blnMkg==""){
    $blnMkg = 0;
}

$kete = $cboGol.','.$thnMkg.','.$blnMkg;

$t10=substr($_POST['tsk_pangkat'],0,2);
			$b10=substr($_POST['tsk_pangkat'],3,2);
			$th10=substr($_POST['tsk_pangkat'],6,4);

$t11=substr($_POST['tmsk_pangkat'],0,2);
			$b11=substr($_POST['tmsk_pangkat'],3,2);
			$th11=substr($_POST['tmsk_pangkat'],6,4);


$query_insert_sk = ("insert into sk
		(id_pegawai,id_kategori_sk,no_sk,tgl_sk,tmt,pemberi_sk,pengesah_sk,keterangan,gol,mk_tahun,mk_bulan)
		values ($id,$jnk_pangkat,'$nsk_pangkat','$th10-$b10-$t10','$th11-$b11-$t11','$pbsk','$pgsk','$kete','$cboGol','$thnMkg','$blnMkg')");

mysqli_query($mysqli, $query_insert_sk);
}
//update sk
for($z=1;$z<=@$jsk_;$z++)
{


$nona=$_POST["nosk_"."$z"];
$tmtna=$_POST["tmsk_"."$z"];
//$golna = $_POST["ket".$z];
$tglna=$_POST["tgsk_"."$z"];
$sahna=$_POST["sah_"."$z"];
$idna=$_POST["idsk_"."$z"];
$berina=$_POST["beri_"."$z"];
$iks=$_POST["a_"."$z"];

$cboGol = $_POST["gol_sk_"."$z"];
$thnMkg = $_POST["thn_mkg_"."$z"];
$blnMkg = $_POST["bln_mkg_"."$z"];
if($thnMkg==""){
    $thnMkg = 0;
}
if($blnMkg==""){
    $blnMkg = 0;
}

$golna = $cboGol.','.$thnMkg.','.$blnMkg;



$t8=substr($tglna,0,2);
			$b8=substr($tglna,3,2);
			$th8=substr($tglna,6,4);

$t9=substr($tmtna,0,2);
			$b9=substr($tmtna,3,2);
			$th9=substr($tmtna,6,4);

$query_update_sk = ("update sk set
			no_sk='$nona',
			keterangan='$golna',
      catatan='$golna',
			gol='$cboGol',
			mk_tahun='$thnMkg',
			mk_bulan='$blnMkg',
			tgl_sk='$th8-$b8-$t8',
			tmt='$th9-$b9-$t9',
			pengesah_sk='$sahna',
			pemberi_sk='$berina',id_kategori_sk=$iks where id_pegawai=$id and id_sk=$idna");

//echo $query_update_sk;
mysqli_query($mysqli, $query_update_sk);



//echo("insert into sk (id_pegawai,id_kategori_sk,no_sk,tgl_sk,tmt,pemberi_sk,pengesah_sk) values ($id,$jnk,'$nsk','$th10-$b10-$t10','$th11-$b11-$t11','$pbsk','$pgsk')");


}
?>
<table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup table">
            <tr>
              <td>No</td>
              <td>Jenis SK</td>
              <td nowrap="nowrap">No SK</td>
			  <td>Golongan</td>
              <td>Thn. MKG</td>
              <td>Bln. MKG</td>
              <td>Tanggal SK</td>
              <td>TMT SK</td>
              <td>Berkas Digital</td>
            </tr>

            <?php


            $arrGol = array();
            $qkg=mysqli_query($mysqli, "SELECT * FROM `golongan`");
            while($dag=mysqli_fetch_array($qkg))
            {
                $arrGol[] = array('val'=>$dag[1], 'title'=>$dag[1].' ('.$dag[2].')');
            }

			$k=1;
      $qsk_ = "select *,
            gol,
            mk_tahun AS thn,
            mk_bulan AS bln
            from sk
            where id_pegawai=".$od." and (id_kategori_sk in (5,6,7,22))
            order by tmt desc, id_kategori_sk";
            //echo $qsk_; exit;
			$qsk=mysqli_query($mysqli, $qsk_ );

			while($cu=mysqli_fetch_array($qsk))
			{
				$qt=mysqli_query($mysqli, "select nama_sk from kategori_sk where id_kategori_sk=$cu[2]");
				$tipe=mysqli_fetch_array($qt);
				echo("  <tr>
              <td>$k</td>
              <td>");

              ?>
			  <select class="form-control" name="a_<? echo($k); ?>" id="a_<? echo($k); ?>" style="width:160px;" >
              <?php
			  $nama_berkas = "";

			  $qks=mysqli_query($mysqli, "SELECT * FROM `kategori_sk`");
                while($da=mysqli_fetch_array($qks))
				{
					if($cu[2]==$da[0])
					{
						echo("<option value=$da[0] selected>$da[1]</option>");
						$nama_berkas = $da[1];
					}
					else
						echo("<option value=$da[0]>$da[1]</option>");
				}

				?>
            </select>

            <!-- <td><input type=text name=ket$k id=ket$k value='$cu[keterangan]'  style=width:90px; /></td> -->
			  <?php

			  $tsk1=substr($cu[4],8,2);
			  $bsk1=substr($cu[4],5,2);
			  $thsk1=substr($cu[4],0,4);

			  $tsk2=substr($cu[8],8,2);
			  $bsk2=substr($cu[8],5,2);
			  $thsk2=substr($cu[8],0,4);

			  echo("</td>
              <td nowrap> <input class='form-control' type=text name=nosk_$k id=nosk_$k value='$cu[3]' style=width:180px; class=hurup /> </td>");
                ?>

              <td>
            <select class="form-control" name="gol_sk_<? echo($k); ?>" id="gol_sk_<? echo($k); ?>" style="width:160px;" >
                <option value="">Silahkan Pilih</option>
                <?php
                    foreach ($arrGol as $optGol){
                        if($optGol['val']==$cu['gol']) {
                            echo("<option value=" . $optGol['val'] . " selected>" . $optGol['title'] . "</option>");
                        }else{
                            echo("<option value=" . $optGol['val'] . ">" . $optGol['title'] . "</option>");
                        }
                    }
                ?>
            </select>
        </td>

			  <?php echo ("
              <td><input type=text name=thn_mkg_$k id=thn_mkg_$k value='$cu[thn]' style='width:50px;' /></td>
	          <td><input type=text name=bln_mkg_$k id=bln_mkg_$k value='$cu[bln]' style='width:50px;' /></td>
			  <td><input type=text name=tgsk_$k id=tgsk_$k value=$tsk1-$bsk1-$thsk1 class=tcal style=width:90px; /></td>
			  <td><input type=text name=tmsk_$k id=tmsk_$k value=$tsk2-$bsk2-$thsk2 class=tcal style=width:90px; /></td>
			  <input type=hidden name=idsk_$k id=idsk_$k value=$cu[0] />
				   </td>
              <td>");
			if($cu[10]==NULL or $cu[10]==0)
			{
			  echo("<a href='index3.php?x=uploader_berkas.php&id_sk=$cu[id_sk]&nama_berkas=$nama_berkas&tgl_berkas=$tsk1-$bsk1-$thsk1&od=$_REQUEST[od]' target=''>UPLOAD</a> </td>");
			}
			else
          echo "<a href=http://103.14.229.15/simpeg/berkas.php?idb=".$cu[10]." target='_blank'>view </a>";
			  //echo("<a href='index3.php?x=uploader_berkas.php&id_b=$cu[10]&nama_berkas=$nama_berkas&tgl_berkas=$tsk1-$bsk1-$thsk1&od=$_REQUEST[od]' target=''>View</a> </td>");

            echo("</td></tr>");
				$k++;
				}

			?>

             <tr>
              <td>+ <input type="hidden" name="jsk_" value="<? $jambleh=$k-1; echo($jambleh); ?>" id="jsk_" /></td>
              <td nowrap="nowrap"><!--<label for="select"></label>-->
                <select name="jnk_pangkat" id="jnk_pangkat" style="width:160px;">
                <?php

				 $qks2=mysqli_query($mysqli, "SELECT * FROM `kategori_sk`");
                while($da=mysqli_fetch_array($qks2))
				echo("<option value=$da[0]>$da[1]</option>");
				?>
               </select></td>
              <td nowrap="nowrap">
					<!--<label for="textfield"></label> -->
					<input type="text" name="nsk_pangkat" id="nsk_pangkat" style=width:180px; />
				</td>
				 <td nowrap="nowrap">
				 <select name="gol_sk_pangkat" id="gol_sk_pangkat" style="width:160px;">
				 <?php
				    foreach ($arrGol as $optGol){
                            echo("<option value=" . $optGol['val'] . ">" . $optGol['title'] . "</option>");

                    }
                 ?>
                 </select>
					<!--<label for="textfield"></label>
					<input type="text" style="width:100px;"	name="kete" id="kete"/>-->
				</td>
				<td nowrap="nowrap"> <input type=text id="thn_mkg_pangkat" name="thn_mkg_pangkat" style='width:50px;' /></td>
				<td nowrap="nowrap"> <input type=text id="bln_mkg_pangkat" name="bln_mkg_pangkat" style='width:50px;' /></td>
              <td nowrap="nowrap">
				 <!--<label for="select"></label>-->
                <input type="text" name="tsk_pangkat" id="tsk_pangkat" class="tcal" style="width:100px;" />
               </td>
              <td nowrap="nowrap">
				  <input type="text" name="tmsk_pangkat" id="tmsk_pangkat" class="tcal" style="width:100px;" />
			</td>

              <td>
              </td>
            </tr>
          </table>

<script type="text/javascript">
	function show_modal(){
		$("#sk_add").modal("show");
	}
</script>
