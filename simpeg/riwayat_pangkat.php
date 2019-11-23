<!-- tab berkas pegawai -->

          <table width="100%" border="0" cellpadding="3" cellspacing="0" class="hurup table bordered">
            <tr>
              <td>No</td>                      
			  <td>Gol</td>
			  <td>MK Tahun</td>
			  <td>MK Bulan</td>
			  <td nowrap="nowrap">No SK</td>
              <td>Tanggal SK</td>
              <td>TMT Golongan</td>
              <td>Pengesah SK</td>
              <td>Pemberi SK</td>
              <td>Berkas Digital</td>
            </tr>
           
            <?
			$k=1;
			$qsk=mysqli_query($mysqli,"select * from sk where id_pegawai=$od and id_kategori_sk in ('5','6','7') order by tmt desc, id_kategori_sk");
			while($cu=mysqli_fetch_array($qsk))
			{
				$qt=mysqli_query($mysqli,"select nama_sk from kategori_sk where id_kategori_sk=$cu[2]");
				$tipe=mysqli_fetch_array($qt);
				echo("  <tr><td>$k</td>"); 
			  
			  
			  $tsk1=substr($cu[4],8,2);
			  $bsk1=substr($cu[4],5,2);
			  $thsk1=substr($cu[4],0,4);
			  
			  $tsk2=substr($cu[8],8,2);
			  $bsk2=substr($cu[8],5,2);
			  $thsk2=substr($cu[8],0,4);
			  
			  list($pangkat,$mk_thn,$mk_bln) = explode(',',$cu['keterangan']);
			  
			  echo("              
              <td>$pangkat</td>
			  <td>$mk_thn</td>
			  <td>$mk_bln </td>
			  <td>$cu[3]</td>
			  <td>$tsk1-$bsk1-$thsk1</td>              
			  <td>$tsk2-$bsk2-$thsk2 </td>
			  <td>$cu[6]</td>
				<td >$cu[5]</td>
				  
				  <input type=hidden name=idsk$k id=idsk$k value=$cu[0] />
				   </td>
              <td>");
			if($cu[10]==NULL or $cu[10]==0)
			{
			  echo("<a href='index3.php?x=uploader_berkas.php&id_sk=$cu[id_sk]&nama_berkas=$nama_berkas&tgl_berkas=$tsk1-$bsk1-$thsk1&od=$_REQUEST[od]' target=''>UPLOAD</a> </td>");
			}
			else
			  //echo("<a href=file.php?idb=$cu[10] target=_blank>Lihat</a></td>");
			  echo("<a href='index3.php?x=uploader_berkas.php&id_b=$cu[10]&nama_berkas=$nama_berkas&tgl_berkas=$tsk1-$bsk1-$thsk1&od=$_REQUEST[od]' target=''>View</a> </td>");
			  
            echo("</tr>");
				$k++;
				}
			
			?>
            <input type="hidden" name="jsk" value="<? $jambleh=$k-1; echo($jambleh); ?>" id="jsk" />
             <!--tr>
              <td>+</td>
              <td><label for="select"></label>
                <select name="jnk" id="jnk" style="width:160px;">
                <?
				/*
				 $qks2=mysqli_query($mysqli,"SELECT * FROM `kategori_sk`");
                while($da=mysqli_fetch_array($qks2))
				echo("<option value=$da[0]>$da[1]</option>");
				*/
				?>
               </select></td>
              <td nowrap="nowrap"><label for="textfield"></label>
               <input type="text" name="nsk" id="nsk" style="width:160px;" /></td>
              <td><label for="select"></label>
                <input type="text" name="tsk" id="tsk" class="tcal" style="width:100px;" /></td>
              <td><input type="text" name="tmsk" id="tmsk" class="tcal" style="width:100px;" /></td>
              <td>
              <input type="text" name="pgsk" id="pgsk"  style="width:100px;" />
              </td>
              <td><input type="text" name="pbsk" id="pbsk"  style="width:100px;" /></td>
              <td>
              </td>
            </tr-->
          </table>
