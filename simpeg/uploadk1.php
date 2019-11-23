
<div style="padding: 20px;padding-bottom: 20px;">
<?php
include("konek.php");
extract($_POST);

$uploaddir = 'Berkas/';
$uploadfileSK = $uploaddir . basename($_FILES["sk"]['name']);
$txtNoSK = '810.45 - 132 Tahun 2017';
$tglSK = '2017-12-19';
$ketera = '';
$tmtSKMulai = '2018-01-01';
$tmtSKAkhir = '2018-12-31';
$value = explode('-',$idtkk);
$idtkk = $value[0];
$idunit = $value[1];

if (isset($_FILES["sk"])) {
    if ($_FILES["sk"]['name'] <> "") {
        if ($_FILES["sk"]['type']== 'binary/octet-stream' or $_FILES["sk"]['type'] == "application/pdf") {
            if (move_uploaded_file($_FILES["sk"]['tmp_name'], $uploadfileSK)) {
                $query_insert_sk = "insert into sk_tkk (id_tkk,id_kategori_sk,no_sk,tgl_sk,pemberi_sk,pengesah_sk,keterangan,tmt_mulai,tmt_akhir,id_unit_kerja)
		        values ($idtkk,37,'$txtNoSK','$tglSK','','','$ketera','$tmtSKMulai','$tmtSKAkhir',$idunit)";
                if (mysqli_query($mysqli,$query_insert_sk)) {
                    $idsk = mysqli_insert_id();
                    $sqlInsert = "insert into berkas_tkk (id_tkk,id_kat,nm_berkas,tgl_upload,created_by,created_date,ket_berkas) " .
                        "values (" . $idtkk . ", 2,'Pengangkatan Kembali Pegawai Honorer/Tidak Tetap', DATE(NOW()), '" . $idtkk . "', NOW(), 'Pengangkatan Kembali Pegawai Honorer/Tidak Tetap')";
                    if (mysqli_query($mysqli,$sqlInsert)) {
                        $idarsip = mysqli_insert_id();
                        $sqlInsertIsi = "insert into isi_berkas_tkk (id_berkas, ket) values ($idarsip, 'Pengangkatan Kembali Pegawai Honorer/Tidak Tetap')";
                        if (mysqli_query($mysqli,$sqlInsertIsi)) {
                            $idisi = mysqli_insert_id();
                            $nf = $idtkk . "-" . $idarsip . "-" . $idisi . ".pdf";
                            $sqlUpdateIsi = "update isi_berkas_tkk set file_name='$nf' where id_isi_berkas=$idisi";
                            if (mysqli_query($mysqli,$sqlUpdateIsi)) {
                                $updateSK = "update sk_tkk set id_berkas=$idarsip where id_sk=$idsk";
                                if (mysqli_query($mysqli,$updateSK)) {
                                    rename($uploadfileSK, "Berkas/" . $nf);
                                    echo "<span style='font-size: medium; font-weight: bold; color: darkgreen;'>Sukses menambah data dan mengupload berkas SK</span>";
                                }else{
                                    echo "<span style='font-size: medium; font-weight: bold; color: darkred;'>File terupload, data sk tersimpan, data berkas tersimpan, data isi berkas tersimpan, data sk tidak terupdate</span>";
                                }
                            }
                        } else {
                            echo "<span style='font-size: medium; font-weight: bold; color: darkred;'>File terupload, data sk tersimpan, data berkas tersimpan, data isi berkas tidak tersimpan</span>";
                        }
                    } else {
                        echo "<span style='font-size: medium; font-weight: bold; color: darkred;'>File terupload, data sk tersimpan, data berkas tidak tersimpan</span>";
                    }
                }else{
                    echo "<span style='font-size: medium; font-weight: bold; color: darkred;'>File terupload, data sk tidak tersimpan</span>";
                }
            }else{
                echo "<span style='font-size: medium; font-weight: bold; color: darkred;'>File gagal terupload</span>";
            }
        }else{
            echo "<span style='font-size: medium; font-weight: bold; color: darkred;'>Tipe file harus PDF</span>";
        }
    }else{
        echo "<span style='font-size: medium; font-weight: bold; color: darkred;'>SK belum terlampir</span>";
    }
}else{
    echo "<span style='font-size: medium; font-weight: bold; color: darkred;'>SK belum terlampir</span>";
}

?>
&nbsp;&nbsp; <a href="/simpeg/k1.php"><strong>Kembali</strong></a>
</div>