
<table width="100%" border="1" cellpadding="3" cellspacing="0" class="hurup">
	<tr>
	  <td>No</td>
	  <td>Jenis SK</td>
	  <!--<td>Keterangan</td>-->
      <td>Golongan</td>
      <td>Thn. MKG</td>
      <td>Bln. MKG</td>
	  <td nowrap="nowrap">No SK</td>
	  <td>Tanggal SK</td>
	  <td>TMT SK</td>
	  <td>Berkas Digital</td>
	  <td>id_j</td>
	  <td>Aksi</td>
		<td>id_sk</td>
		<td></td>
	</tr>
	<?php
    $arrGol = array();
    $qkg=mysqli_query($con,"SELECT * FROM `golongan`");
    while($dag=mysqli_fetch_array($qkg))
    {
        $arrGol[] = array('val'=>$dag[1], 'title'=>$dag[1].' ('.$dag[2].')');
    }

	$k=1;
	//$qsk=mysqli_query($con,"select *, FCN_PARSE_KETERANGAN_SK(keterangan, 1) AS gol,
    //FCN_PARSE_KETERANGAN_SK(keterangan, 2) AS thn, FCN_PARSE_KETERANGAN_SK(keterangan, 3) AS bln
    //from sk where id_pegawai=$id order by tmt desc, id_kategori_sk");
	$qsk = mysqli_query($con,"select * from sk
						left join jabatan j on j.id_j = sk.id_j
						where sk.id_pegawai = $id
						order by sk.tmt DESC, sk.id_kategori_sk");

	while($cu=mysqli_fetch_array($qsk))
	{
		$qt=mysqli_query($con,"select nama_sk from kategori_sk where id_kategori_sk=$cu[2] order by nama_sk");
		$tipe=mysqli_fetch_array($qt);
		echo("  <tr>
	  <td>$k</td>
	  <td>"); ?>
	  <select name="a<? echo($k); ?>" id="a<? echo($k); ?>" style="width:160px;" >
	  <?php

	  $qks=mysqli_query($con,"SELECT * FROM `kategori_sk` order by nama_sk");
		while($da=mysqli_fetch_array($qks))
		{
			if($cu[2]==$da[0]) {
                echo("<option value=$da[0] selected>$da[1]</option>");
                $nama_sknya = $da[1];
            }else {
                echo("<option value=".$da[0].">".$da[1]."</option>");
            }
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
      ?>
        </td>
        <?php //echo "<td><input type=text name=keket$k id=keket$k value='$cu[keterangan]' style='width: width:160px;' /></td>"?>
        <td>
            <select name="gol_sk<? echo($k); ?>" id="gol_sk<? echo($k); ?>" style="width:160px;" >
                <option value="">Silahkan Pilih</option>
                <?php
                    foreach ($arrGol as $optGol){
                        if($optGol['val']==$cu[gol]) {
                            echo("<option value=" . $optGol['val'] . " selected>" . $optGol['title'] . "</option>");
                        }else{
                            echo("<option value=" . $optGol['val'] . ">" . $optGol['title'] . "</option>");
                        }
                    }
                ?>
            </select>
        </td>

        <!-- <td><input type=text name=keket$k id=keket$k value='$cu[keterangan]' style='width: 30px;' /></td> -->
        <!-- <td><input type=text name=gol$k id=gol$k value='$cu[gol]' style='width: width:160px;' /></td> -->
	  <?php
        echo("

	  <td><input type=text name=thn_mkg$k id=thn_mkg$k value='$cu[mk_tahun]' style='width: 50px;' /></td>
	  <td><input type=text name=bln_mkg$k id=bln_mkg$k value='$cu[mk_bulan]' style='width: 50px;' /></td>
	  <td nowrap> <input type=text name=nosk$k id=nosk$k value='$cu[3]' size=30 class=hurup /> ");?>

        <?php echo
    ("</td>
	  <td><input type=text name=tgsk$k id=tgsk$k value=$tsk1-$bsk1-$thsk1 class=tcal size=8 /></td>
	  <td><input type=text name=tmsk$k id=tmsk$k value=$tsk2-$bsk2-$thsk2 class=tcal size=8 /></td>
	  <td>");
	if($cu[10]==NULL or $cu[10]==0)
	  echo("<input type=file id=fupdate$k name=fupdate$k /> </td>"); //Belum Ada
	  else
	  echo("<a href=berkas.php?idb=$cu[10] target=_blank>Preview </a>"); ?>
        <?php
            if($nama_sknya=='NIP Baru'){?>
                &nbsp; | &nbsp; <a href="https://wa.me/<?php echo '62'.(substr($ponsel,1,strlen($ponsel)-1)); ?>?text=Yth. Bpk/Ibu Pegawai Pemkot Bogor a.n <?php echo $namap;?> diberitahukan bahwa SK Konversi NIP sudah terbit. terimakasih" target="_blank">Kirim pesan via WA <?php echo($ponsel); ?></a>
        <?php
            }elseif($nama_sknya=='SK Sumpah Janji PNS'){?>
                &nbsp; | &nbsp; <a href="https://wa.me/<?php echo '62'.(substr($ponsel,1,strlen($ponsel)-1)); ?>?text=Yth. Bpk/Ibu Pegawai Pemkot Bogor a.n <?php echo $namap;?> diberitahukan bahwa Berita Acara Sumpah Janji PNS sudah terbit. terimakasih" target="_blank">Kirim pesan via WA <?php echo($ponsel); ?></a>
        <?php }
        ?>
      <?php  echo ("</td>"); ?>
	  <td><?php echo $cu['jabatan'] ?></td>
	  <td>
			<a href="<?php echo "hapus_berkas.php?idsk=$cu[id_sk]&id=$cu[id_pegawai]"?>" onclick="return confirm('yakin lw mau ngehapus?');">hapus</a>
				<a  href="<?php echo "hapus_file.php?idsk=$cu[id_sk]&id=$cu[id_pegawai]"?>" onclick="return confirm('yakin lw mau ngehapus file?');">hapus file</a>
		</td>
		<td><?php echo $cu[0]; ?></td>
		<?php
			echo ("<td nowrap><input type=hidden name=beri$k id=beri$k value='$cu[5]' size=27 class=hurup />
	  <input type=hidden name=sah$k id=sah$k value='$cu[6]' size=27 class=hurup />
	  <input type=hidden name=idsk$k id=idsk$k value=$cu[id_sk] /></td>");
 		?>
	<?php
  echo("</tr>");
		$k++;
		}
	$qberkas=mysqli_query($con,"select nm_berkas,id_berkas from berkas where id_pegawai=$ata[0] and id_kat!=2");
	while($berkas=mysqli_fetch_array($qberkas))
	{


		$qli=mysqli_query($con,"select file_name from isi_berkas where id_berkas=$berkas[1]");
		$lihat=mysqli_fetch_array($qli);
		$nf=basename($lihat[0]);
		$ext = pathinfo("$lihat[0]", PATHINFO_EXTENSION);
	   if($ext!="pdf")
	$link="<a href=lihat_berkas.php?id=$berkas[1]  target=_blank>Preview</a>";
	  else
	  $link="<a href=../simpeg/Berkas/$nf target=_blank>Preview </a></td>";
		echo(" <tr>
		<td>  $k</td>
		<td> $berkas[0]
	</td>
		<td> $link  </td>
		<td> <a href=dock2.php?id=$ata[0]&delete=$berkas[1]  target=_blank>Hapus</a>  </td>")?>
		<td>
            <?php
                if($berkas[0]=='Karis/Karsu'){
                    ?>
            <a href="https://wa.me/<?php echo '62'.(substr($ponsel,1,strlen($ponsel)-1)); ?>?text=Yth. Bpk/Ibu Pegawai Pemkot Bogor a.n <?php echo $namap;?> diberitahukan bahwa Karis/Karsu sudah terbit. terimakasih" target="_blank">Kirim pesan via WA <?php echo($ponsel); ?></a>

            <?php    }elseif($berkas[0]=='Kartu Pegawai'){ ?>
                    <a href="https://wa.me/<?php echo '62'.(substr($ponsel,1,strlen($ponsel)-1)); ?>?text=Yth. Bpk/Ibu Pegawai Pemkot Bogor a.n <?php echo $namap;?> diberitahukan bahwa KARPEG sudah terbit. terimakasih" target="_blank">Kirim pesan via WA <?php echo($ponsel); ?></a>
                <?php    }elseif($berkas[0]=='Kartu Pegawai'){ ?>
                <?php } ?>
        </td>
		<?php ("<td>   </td>
		<td>   </td>
		<td>   </td>
		<td>   </td>
		<td>   </td>


		</tr>");

		$k++;
	}
	?>
	  <input type="hidden" name="jsk" value="<?php $jambleh=$k-1; echo($jambleh); ?>" id="jsk" />

	  <tr>
		<td>  [+]</td>
		<td>  Jenis Berkas
	</td>
		<td> <div id="judul2"> </div>  </td>
		<td> <div id="judul3"> </div>  </td>
		<td> <div id="judul4"> </div>  </td>
		<td> <div id="judul5"> </div>  </td>
		<td> <div id="judul6"> </div>  </td>
		<td> <div id="judul7"> </div>  </td>
		<td> <div id="judul8"> </div>  </td>
		<td> <div id="judul9"> </div>  </td>


		</tr>
		<tr>
		<td></td>
		<td valign="top">  <select name="arsip" id="arsip" style="width:160px;" >
		<option value="0">Pilih Jenis Berkas</option>
	  <?php

	  $qks=mysqli_query($con,"SELECT * FROM `kat_berkas`");
		while($da=mysqli_fetch_array($qks))
		{
		echo("<option value=$da[0]>$da[1]</option>");
		}

		?>
	</select>
	    <script type="text/javascript">

					function hapus_file(id_sk, id_pegawai){

						alert(id_sk, id_pegawai);
					}


            function getValCboJsk(sel){
                if(sel.value == 1) {
					var elementExists = document.getElementById("divSkpd");
					if (typeof(elementExists) != 'undefined' && elementExists != null) {
						var d = document.getElementById('kol3');
						var olddiv = document.getElementById('divSkpd');
						d.removeChild(olddiv);
					}
					var kolom = document.getElementById("kol3");
					var newdiv = document.createElement('div');
					var divIdName = 'divSkpd';
					newdiv.setAttribute('id', divIdName);
					newdiv.innerHTML = 'Unit Kerja<br><input type=text id=nama_skpd name=nama_skpd size=30 /><input type=hidden id=idskpd name=idskpd size=30 />';
					kolom.appendChild(newdiv);

					$("#nama_skpd").autocomplete({
						source: function (request, response) {
							$.ajax({
								url: "json_skpd.php",
								dataType: "json",
								data: {
									q: request.term
								},
								success: function (data) {
									response($.map(data, function (item) {
										return {
											label: item.label,
											value: item.label,
											idunit_kerja: item.value
										};
									}));//response
								}
							});
						},
						minLength: 1,
						select: function (event, ui) {
							$('#idskpd').val(ui.item.idunit_kerja);
						}
					});
				}else if(sel.value == 34 || sel.value == 35) {
					var elementExists = document.getElementById("divSkpd");
					if (typeof(elementExists) != 'undefined' && elementExists != null) {
						var d = document.getElementById('kol3');
						var olddiv = document.getElementById('divSkpd');
						d.removeChild(olddiv);
					}
					var kolom = document.getElementById("kol3");
					var newdiv = document.createElement('div');
					var divIdName = 'divSkpd';
					newdiv.setAttribute('id', divIdName);
					newdiv.innerHTML = 'Instansi Tujuan<br><input type=text id=nama_skpd name=nama_skpd size=30 /><input type=hidden id=idskpd name=idskpd size=30 />';
					kolom.appendChild(newdiv);

					$("#nama_skpd").autocomplete({
						source: function (request, response) {
							$.ajax({
								url: "json_instansi.php",
								dataType: "json",
								data: {
									q: request.term
								},
								success: function (data) {
									response($.map(data, function (item) {
										return {
											label: item.label,
											value: item.label,
											idunit_kerja: item.value
										};
									}));//response
								}
							});
						},
						minLength: 1,
						select: function (event, ui) {
							$('#idskpd').val(ui.item.idunit_kerja);
						}
					});
				}else if(sel.value == 23 || sel.value == 32){

					var elementExistsJafung = document.getElementById("divJafung");
					if (typeof(elementExistsJafung) != 'undefined' && elementExistsJafung != null) {
						var d = document.getElementById('kol2');
						var olddiv = document.getElementById('divJafung');
						d.removeChild(olddiv);
					}
					var kolom = document.getElementById("kol2");
					var newdiv = document.createElement('div');
					var divIdName = 'divJafung';
					newdiv.setAttribute('id', divIdName);
					newdiv.innerHTML = 'Jafung<br><input type=text id=nama_jafung name=nama_jafung size=30 /><input type=hidden id=id_jafung name=id_jafung size=30 /><br/>Angka Kredit<br/><input type=text id=nilai_ak name=nilai_ak size=30 />';
					kolom.appendChild(newdiv);

					$("#nama_jafung").autocomplete({
						source: function (request, response) {
							$.ajax({
								url: "json_jafung.php",
								dataType: "json",
								data: {
									q: request.term
								},
								success: function (data) {
									response($.map(data, function (item) {
										return {
											label: item.label,
											value: item.label,
											id_jafung: item.value
										};
									}));//response
								}
							});
						},
						minLength: 1,
						select: function (event, ui) {
							//alert("id " + ui.item.id_jafung);
							$('#id_jafung').val(ui.item.id_jafung);
						}
					});



					}else{
                var elementExists = document.getElementById("divSkpd");
                if(typeof(elementExists) != 'undefined' && elementExists != null){
                    var d = document.getElementById('kol3');
                    var olddiv = document.getElementById('nama_skpd');
                    d.removeChild(olddiv);
                }

								var elementExistsJafung = document.getElementById("divJafung");
                if(typeof(elementExistsJafung) != 'undefined' && elementExistsJafung != null){
                    var e = document.getElementById('kol2');
                    var olddivJafung = document.getElementById('nama_jafung');
                    e.removeChild(olddivJafung);
                }
            }
        }


		$(document).ready(function(){

		$('#arsip').change(function () {
        var optionSelected = $(this).find("option:selected");
        var valueSelected  = optionSelected.val();
        var textSelected   = optionSelected.text();

	 <?php
	 //sk
	 $option="<select name=jsk id=jsk style=\"width:160px;\" onchange=\"getValCboJsk(this);\">";
	 $qjsk=mysqli_query($con,"select * from kategori_sk order by nama_sk");
	 while($jsk=mysqli_fetch_array($qjsk)){
		$option.=("<option value=$jsk[0]>$jsk[1] </option>");
	 }
	 $option.="</select>";  ?>
	 var ts='<?php echo $option; ?>';
	 <?php
	 //bidang pendidikan
	 $option2="<select name=bp id=bp style=width:160px>";
	 $qjsk2=mysqli_query($con,"select * from bidang_pendidikan order by bidang");
	 while($jsk2=mysqli_fetch_array($qjsk2)){
		$option2.=("<option value=$jsk2[0]>$jsk2[1] </option>");
	 }
	 $option2.="</select>";  ?>
	 var ts2='<?php echo $option2; ?>';


	 if(valueSelected==1)
	 {
	  $("#judul2").html('File KTP');
	 $("#kol2").html('<input type=file id=filektp name=filektp />');
	  $("#judul3").html('');
	 	 $("#kol3").html('<input type=submit value=Simpan />');

		 $("#judul4").html('');
	 	 $("#kol4").html('<input type=text id=isiktp name=isiktp value=NIK />');
		  $("#judul5").html('');
	 	 $("#kol5").html('');
		  $("#judul6").html('');
	 	 $("#kol6").html('');
		  $("#judul7").html('');
	 	 $("#kol7").html('');
		  $("#judul8").html('');
	 	 $("#kol8").html('');
		  $("#judul9").html('');
	 	 $("#kol9").html('');
	 }

	  if(valueSelected==14)
	 {
	  $("#judul2").html('File KK');
	 $("#kol2").html('<input type=file id=filekk name=filekk />');
	  $("#judul3").html('');
	 	 $("#kol3").html('<input type=submit value=Simpan />');

		 $("#judul4").html('');
	 	 $("#kol4").html('<input type=text id=isikk name=isikk value=No_KK />');
		  $("#judul5").html('');
	 	 $("#kol5").html('');
		  $("#judul6").html('');
	 	 $("#kol6").html('');
		  $("#judul7").html('');
	 	 $("#kol7").html('');
		  $("#judul8").html('');
	 	 $("#kol8").html('');
		  $("#judul9").html('');
	 	 $("#kol9").html('');
	 }

	   if(valueSelected==39)
	 {
	  $("#judul2").html('File PUPNS');
	 $("#kol2").html('<input type=file id=filekk name=pupns />');
	  $("#judul3").html('');
	 	 $("#kol3").html('<input type=submit value=Simpan />');

		 $("#judul4").html('');
	 	 $("#kol4").html('');
		  $("#judul5").html('');
	 	 $("#kol5").html('');
		  $("#judul6").html('');
	 	 $("#kol6").html('');
		  $("#judul7").html('');
	 	 $("#kol7").html('');
		  $("#judul8").html('');
	 	 $("#kol8").html('');
		  $("#judul9").html('');
	 	 $("#kol9").html('');
	 }


	  if(valueSelected==13)
	 {
	  $("#judul2").html('File NPWP');
	 $("#kol2").html('<input type=file id=filenpwp name=filenpwp />');
	  $("#judul3").html('');
	 	 $("#kol3").html('<input type=submit value=Simpan />');

		 $("#judul4").html('');
	 	 $("#kol4").html('<input type=text id=isinpwp name=isinpwp value=No_NPWP />');
		  $("#judul5").html('');
	 	 $("#kol5").html('');
		  $("#judul6").html('');
	 	 $("#kol6").html('');
		  $("#judul7").html('');
	 	 $("#kol7").html('');
		  $("#judul8").html('');
	 	 $("#kol8").html('');
		  $("#judul9").html('');
	 	 $("#kol9").html('');
	 }

	 //akta kelahiran

	 if(valueSelected==16)
	 {
	  $("#judul2").html('File Akta');
	 $("#kol2").html('<input type=file id=fileakta name=fileakta />');
	  $("#judul3").html('');
	 	 $("#kol3").html('<input type=submit value=Simpan />');

		 $("#judul4").html('Tanggal Lahir');
	 	 $("#kol4").html('<input type=text id=tglahir name=tglahir value=dd/mm/yy />');
		  $("#judul5").html('');
	 	 $("#kol5").html('');
		  $("#judul6").html('');
	 	 $("#kol6").html('');
		  $("#judul7").html('');
	 	 $("#kol7").html('');
		  $("#judul8").html('');
	 	 $("#kol8").html('');
		  $("#judul9").html('');
	 	 $("#kol9").html('');
	 }
	 //buku nikah
	  if(valueSelected==15)
	 {
	  $("#judul2").html('File Buku Nikah');
	 $("#kol2").html('<input type=file id=filenikah name=filenikah />');
	  $("#judul3").html('Nama Istri/Suami');
	 	 $("#kol3").html('<input type=text id=namaisu name=namaisu  />');

		 $("#judul4").html('Tg Nikah');
	 	 $("#kol4").html('<input type=text id=tglnikah name=tglnikah value=dd/mm/yy />');
		  $("#judul5").html('');
	 	 $("#kol5").html('<input type=submit value=Simpan />');
		  $("#judul6").html('');
	 	 $("#kol6").html('');
		  $("#judul7").html('');
	 	 $("#kol7").html('');
		  $("#judul8").html('');
	 	 $("#kol8").html('');
		  $("#judul9").html('');
	 	 $("#kol9").html('');
	 }
	 if(valueSelected==10)
	 {
	  $("#judul2").html('No Karpeg');
	 $("#kol2").html('<input type=text id=karpeg name=karpeg />');
	  $("#judul3").html('File Karpeg');
	 	 $("#kol3").html('<input type=file id=fkarpeg name=fkarpeg />');


		  $("#judul4").html('');
	 	 $("#kol4").html('');
		  $("#judul5").html('');
	 	 $("#kol5").html('');
		  $("#judul6").html('');
	 	 $("#kol6").html('');
		  $("#judul7").html('');
	 	 $("#kol7").html('');
		  $("#judul8").html('');
	 	 $("#kol8").html('');
		  $("#judul9").html('');
	 	 $("#kol9").html('');
	 }
	 //sk
	 else if(valueSelected==2)
	 {
	 $("#judul2").html('Jenis SK');
	 $("#kol2").html(ts);
	 $("#judul3").html('No SK');
	 $("#kol3").html('<input type=text id=nosk name=nosk size=30 /><br><br>');
	$("#judul4").html('Tanggal SK');
	 $("#kol4").html('<input type=text id=tglsk name=tglsk size=10 />');
	$("#judul5").html('TMT SK');
	 $("#kol5").html('<input type=text id=tmtsk name=tmtsk size=10 />');
$("#judul6").html('Upload SK');
	 $("#kol6").html('<input type=file id=filesk name=filesk /><input type=hidden id=berisk name=berisk size=27  /><input type=hidden id=sahsk name=sahsk size=27  />');
$("#judul7").html('');
	 $("#kol7").html('<input type=submit value=Simpan />');
	 $("#kol8").html('');
	 $("#kol9").html('');

         var kolom = document.getElementById("kol3");
         var newdiv = document.createElement('div');
         var divIdName = 'divSkpd';
         newdiv.setAttribute('id', divIdName);
         newdiv.innerHTML = 'Unit Kerja<br><input type=text id=nama_skpd name=nama_skpd size=30 /><input type=hidden id=idskpd name=idskpd size=30 />';
         kolom.appendChild(newdiv);

         var newdiv2 = document.createElement('div');
         var divIdName2 = 'divGol';
         newdiv2.setAttribute('id', divIdName2);
         newdiv2.innerHTML = '<br>Golongan<br>' +
         '<select name="gol_sk" id="gol_sk" ><?php
                    foreach ($arrGol as $optGol){
                            echo("<option value=" . $optGol['val'] . ">" . $optGol['title'] . "</option>");

                    }
                ?></select>';
         kolom.appendChild(newdiv2);

         var newdiv3 = document.createElement('div');
         var divIdName3 = 'divThnMkg';
         newdiv3.setAttribute('id', divIdName3);
         newdiv3.innerHTML = 'Thn. MKG<br>' +
         '<input type=text id=thn_mkg name=thn_mkg size=30 />';
         kolom.appendChild(newdiv3);

         var newdiv4 = document.createElement('div');
         var divIdName4 = 'divBlnMkg';
         newdiv4.setAttribute('id', divIdName4);
         newdiv4.innerHTML = 'Bln. MKG<br>' +
         '<input type=text id=bln_mkg name=bln_mkg size=30 />';
         kolom.appendChild(newdiv4);

         $( "#nama_skpd" ).autocomplete({
             source: function( request, response ) {
                 $.ajax({
                     url: "json_skpd.php",
                     dataType: "json",
                     data: {
                         q: request.term
                     },
                     success: function( data ) {
                         response($.map(data, function(item) {
                             return {
                                 label: item.label,
                                 value: item.label,
                                 idunit_kerja: item.value
                             };
                         }));//response
                     }
                 });
             },
             minLength: 1,
             select: function(event, ui) {
                 $('#idskpd').val(ui.item.idunit_kerja);
             }
         });
	 }
	 //ijasah
	  else if(valueSelected==3)
	 {
	 $("#judul2").html('Tingkat Pendidikan');
	 $("#kol2").html('<select name=tp id=tp><option value=1>S3</option><option value=2>S2</option><option value=3>S1</option><option value=4>D3</option><option value=5>D2</option><option value=6>D1</option><option value=7>SMA</option><option value=8>SMP</option><option value=9>SD</option></select>');
	 $("#judul3").html('Lembaga Pendidikan');
	 $("#kol3").html('<input type=text id=lp name=lp size=30 />');
	$("#judul4").html('Jurusan');
	 $("#kol4").html('<input type=text id=jur name=jur size=10 />');
	$("#judul5").html('Bidang Pendidikan');
	 	 $("#kol5").html(ts2);
$("#judul6").html('Tahun Lulus');
	 $("#kol6").html('<input type=text id=tahun name=tahun size=15  />');
$("#judul7").html('Upload Ijazah');
	 $("#kol7").html('<input type=file id=fileij name=fileij />');
	 $("#judul8").html('');
	 $("#kol8").html('<input type=submit value=Simpan />');
	$("#judul9").html('');
	 $("#kol9").html('');

	 $( "#jur" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					  url: "prosesj.php",
					  dataType: "json",
					  data: {
					    q: request.term,
						ins: document.getElementById('lembaga').value,
					    kategori: $("#lembaga").val()
					  },
					  success: function( data,ui ) {
					    response( data );

					  }
				});
			},

			minLength: 1,
			select: function(event, ui) {
        var origEvent = event;
        while (origEvent.originalEvent !== undefined)
            origEvent = origEvent.originalEvent;
        if (origEvent.type == 'keydown')
            { $("#jur").click();



			}
    }

		});


	  $( "#lp" ).autocomplete({
			source: function( request, response ) {
				$.ajax({
					  url: "prosesi.php",
					  dataType: "json",
					  data: {
					    q: request.term
					  },
					  success: function( data ) {
					    response( data );
					  }
				});
			},
			minLength: 1,
			select: function(event, ui) {
            var origEvent = event;
            while (origEvent.originalEvent !== undefined)
                origEvent = origEvent.originalEvent;
                if (origEvent.type == 'keydown') {
                    $("#lp").click();
			    }
            }
		});

	 }else if(valueSelected==11){
		 var idwin;
		 idwin = document.getElementById('idwin').value;
		 if(idwin == ''){
			 $("#judul2").html('Nama Istri/Suami');
			 $("#kol2").html('<input name="inpKarisu" type="hidden" id="inpKarisu" value="insKarisBaru">' +
					 '<input type=text id=nmkarisu name=nmkarisu />');
			 $("#judul3").html('Tempat Lahir');
			 $("#kol3").html('<input type=text id=tmptlhr_ris name=tmptlhr_ris /><br>Tgl.Lahir<br><input type=text id=tgllahir_ris name=tgllahir_ris />');
			 $("#judul4").html('Tgl.Menikah');
			 $("#kol4").html('<input type=text id=tglnikah_ris name=tglnikah_ris /><br>Tunjangan<br>' +
					 '<select name="tunjangan" id="tunjangan"><option value=1 selected>Dapat</option><option value=0>Tidak Dapat</option></select>');
			 $("#judul5").html('Pekerjaan');
			 $("#kol5").html('<input type=text id=pekerjaan name=pekerjaan /><br>No. Karis/Karsu<br><input type=text id=nokarisu name=nokarisu />');
			 $("#judul6").html('File Karis/Karsu');
			 $("#kol6").html('<input type=file id=fkarisu name=fkarisu />');
			 $("#judul7").html('');
			 $("#kol7").html('<input type=submit value=Simpan />');
		 }else{
			 $("#judul2").html('No. Karis/Karsu');
			 $("#kol2").html('<input name="inpKarisu" type="hidden" id="inpKarisu" value="updNoKarsus">' +
					 '<input type=text id=nokarisu name=nokarisu />');
			 $("#judul3").html('File Karis/Karsu');
			 $("#kol3").html('<input type=file id=fkarisu name=fkarisu />');
			 $("#judul4").html('');
			 $("#kol4").html('<input type=submit value=Simpan />');
			 $("#judul5").html('');
			 $("#kol5").html('');
			 $("#judul6").html('');
			 $("#kol6").html('');
			 $("#judul7").html('');
			 $("#kol7").html('');
			 $("#judul8").html('');
			 $("#kol8").html('');
			 $("#judul9").html('');
			 $("#kol9").html('');
		 }
	 }


 });

 });


		</script>

	</td>
		<td valign="top"><div id="kol2"> </div>  </td>
		<td valign="top"><div id="kol3"> </div>  </td>
		<td valign="top"><div id="kol4"> </div>   </td>
		<td valign="top"><div id="kol5"> </div>   </td>
		<td valign="top"> <div id="kol6"> </div>  </td>
		<td valign="top"> <div id="kol7"> </div>  </td>
		<td valign="top"> <div id="kol8"> </div>  </td>
		<td valign="top">  <div id="kol9"> </div> </td>


		</tr>

  </table>
