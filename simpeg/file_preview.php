<title>Pratinjau Dokumen</title>
<h2>Pratinjau Dokumen</h2>
<?php
    $file = $_GET['file'];
    $fileLocation = './downloads/'.$file;
    $fileType = finfo_file(finfo_open(FILEINFO_MIME), $fileLocation);
    $fileType = explode(";",$fileType);
    echo 'Nama File : '.$file.'<br>';
    echo 'Tipe File : '.$fileType[0];
?>
<br>
<?php if($fileType[0]=='application/msword'): ?>
    <?php
        //$_SERVER['SERVER_NAME']
        $url = 'simpeg.kotabogor.go.id/simpeg/downloads/'.$file;
    ?>
    <iframe class="doc" src="https://docs.google.com/gview?url=<?php echo $url;?>&embedded=true"
    width="100%" height="800px"></iframe>
<?php else:?>
    <object data="./downloads/<?php echo $file;?>" type="<?php echo BASE_URL.$fileType[0];?>"
            width="100%" height="100%" style="border: 1px solid #cdcfc7;" ></object>
<?php endif; ?>
