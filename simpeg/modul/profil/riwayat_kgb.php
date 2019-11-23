<table width="100%" border="0" cellpadding="3" cellspacing="0" class="table table-bordered">
            <thead>
			<tr>

              <th>No</th>
              <th>Jenis SK</th>
              <th nowrap="nowrap">No SK</th>
			  <th>Golongan</th>
              <th>Thn. MKG</th>
              <th>Bln. MKG</th>
              <th>Tanggal SK</th>
              <th>TMT SK</th>

              <th>Berkas Digital</th>
            </tr>
			</thead>
			<tbody>
            <?php


            $arrGol = array();
            $qkg=mysqli_query($mysqli, "SELECT * FROM `golongan`");
            while($dag=mysqli_fetch_array($qkg))
            {
                $arrGol[] = array('val'=>$dag[1], 'title'=>$dag[1].' ('.$dag[2].')');
            }

			$k=1;
			$qsk=mysqli_query($mysqli, "select *, FCN_PARSE_KETERANGAN_SK(keterangan, 1) AS gol,
            FCN_PARSE_KETERANGAN_SK(keterangan, 2) AS thn, FCN_PARSE_KETERANGAN_SK(keterangan, 3) AS bln
            from sk
            where id_pegawai=$od and (id_kategori_sk=9)
            order by tmt desc, id_kategori_sk");

			while($cu=mysqli_fetch_array($qsk))
			{
				$qt=mysqli_query($mysqli, "select nama_sk from kategori_sk where id_kategori_sk=$cu[2]");
				$tipe=mysqli_fetch_array($qt);
				echo("  <tr>
              <td>$k</td>
              <td>");

              ?>
			  <select name="a<? echo($k); ?>" id="a<? echo($k); ?>" style="width:160px;" class='form-control' >
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
              <td nowrap> <input type=text name=nosk$k id=nosk$k value='$cu[3]' style=width:180px; class='form-control' /> </td>");
                ?>

              <td>
            <select name="gol_sk<? echo($k); ?>" id="gol_sk<? echo($k); ?>" style="width:160px;" class='form-control' >
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
              <td><input type=text name=thn_mkg$k id=thn_mkg$k value='$cu[thn]' style='width:50px;' class='form-control'/></td>
	          <td><input type=text name=bln_mkg$k id=bln_mkg$k value='$cu[bln]' style='width:50px;' class='form-control'/></td>
			  <td><input type=text name=tgsk$k id=tgsk$k value=$tsk1-$bsk1-$thsk1 class=tcal style=width:90px; class='form-control' /></td>
			  <td><input type=text name=tmsk$k id=tmsk$k value=$tsk2-$bsk2-$thsk2 class=tcal style=width:90px; class='form-control'/></td>

				  <input type=hidden name=idsk$k id=idsk$k value=$cu[0] />

              <td>");
			if($cu[10]==NULL or $cu[10]==0)
			{
			  echo("<a href='index3.php?x=uploader_berkas.php&id_sk=$cu[id_sk]&nama_berkas=$nama_berkas&tgl_berkas=$tsk1-$bsk1-$thsk1&od=$_REQUEST[od]' target=''>UPLOAD</a> </td>");
			}
			else
			   echo "<a href=http://103.14.229.15/simpeg/berkas.php?idb=".$cu[10]." target='_blank'>view </a>";
			  //echo("<a href='index3.php?x=uploader_berkas.php&id_b=$cu[10]&nama_berkas=$nama_berkas&tgl_berkas=$tsk1-$bsk1-$thsk1&od=$_REQUEST[od]' target=''>View</a> </td>");

            echo("</tr>");
				$k++;
				}

			?>

             <tr>
              <td>+ <input type="hidden" name="jsk" value="<? $jambleh=$k-1; echo($jambleh); ?>" id="jsk" /></td>
              <td nowrap="nowrap"><!--<label for="select"></label>-->
                <select name="jnk" id="jnk" style="width:160px;" class='form-control'>
                <?php

				 $qks2=mysqli_query($mysqli, "SELECT * FROM `kategori_sk`");
                while($da=mysqli_fetch_array($qks2))
				echo("<option value=$da[0]>$da[1]</option>");
				?>
               </select></td>
              <td nowrap="nowrap">
					<!--<label for="textfield"></label> -->
					<input type="text" name="nsk" id="nsk" style=width:180px; class='form-control' />
				</td>
				 <td nowrap="nowrap">
				 <select name="gol_sk" id="gol_sk" style="width:160px;" class='form-control'>
				 <?php
				    foreach ($arrGol as $optGol){
                            echo("<option value=" . $optGol['val'] . ">" . $optGol['title'] . "</option>");

                    }
                 ?>
                 </select>
					<!--<label for="textfield"></label>
					<input type="text" style="width:100px;"	name="kete" id="kete"/>-->
				</td>
				<td nowrap="nowrap"> <input type=text id=thn_mkg name=thn_mkg style='width:50px;' class='form-control' /></td>
				<td nowrap="nowrap"> <input type=text id=bln_mkg name=bln_mkg style='width:50px;' class='form-control' /></td>
              <td nowrap="nowrap">
				 <!--<label for="select"></label>-->
                <input type="text" name="tsk" id="tsk" class="tcal" style="width:100px;" class='form-control'/>
               </td>
              <td nowrap="nowrap">
				  <input type="text" name="tmsk" id="tmsk" class="tcal" style="width:100px;" class='form-control' />
			</td>

              <td>
              </td>
            </tr>
			</tbody>
          </table>
