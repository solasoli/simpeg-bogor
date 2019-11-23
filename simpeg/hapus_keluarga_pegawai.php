<?php
    include "konek.php";
    $sqlDelete = "delete from keluarga where id_keluarga=".$_POST['idkel'];
    if ($mysqli->query($sqlDelete)){
        echo "<script type=\"text/javascript\">
            alert('Data sukses terhapus');
          </script>";
        echo("<script type=\"text/javascript\">location.href='/simpeg/index3.php?x=ptk.php';</script>");
    }else{
        echo "<script type=\"text/javascript\">
            alert('Data gagal terhapus. Silahkan coba lagi.');
          </script>";
    }
?>