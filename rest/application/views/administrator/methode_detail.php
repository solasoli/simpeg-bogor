<p>Parameter yang digunakan : </p>
<?php if (isset($params) and sizeof($params) > 0): ?>
    <?php $a = 1; ?>
    <?php if ($params != ''): ?>
        <ul>
            <?php foreach ($params as $lsdata2): ?>
                <li><?php echo $lsdata2->params_name.' = '.$lsdata2->values.
                        '. Tipe: '.$lsdata2->params_type.' ('.($lsdata2->is_required==1?'Required':'Optional').')';?>
                </li>
                <?php
                $a++;
            endforeach; ?>
        </ul>
    <?php else: ?>
        <ul><li>Tidak Ada </li></ul>
    <?php endif; ?>
<?php else: ?>
    <ul><li>Tidak Ada </li></ul>
<?php endif; ?>

<p>Hasil Respons</p>
<?php if (isset($response) and sizeof($response) > 0): ?>
    <?php $a = 1; ?>
    <?php if ($response != ''): ?>
        <ul>
            <?php foreach ($response as $lsdata3): ?>
                <li><code style="color: black"><?php echo 'Status Code : '.$lsdata3->status_code.'<br>'.'Content : '.$lsdata3->content;?></code></li>
                <?php
                $a++;
            endforeach; ?>
        </ul>
    <?php else: ?>
        <ul><li>Belum Ada Data</li></ul>
    <?php endif; ?>
<?php else: ?>
    <ul><li>Belum Ada Data</li></ul>
<?php endif; ?>
