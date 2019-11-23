<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php if (isset($methode) and sizeof($methode) > 0): ?>
    <?php $i = 1; ?>
    <?php if ($methode != ''): ?>
        <?php foreach ($methode as $lsdata): ?>
            <?php
                $masehi = $lsdata->tgl.' '.$this->umum->monthName($lsdata->bln).' '.$lsdata->thn;
                $hijriyah = $this->umum->getTglCurHijriyah($lsdata->tgl,$lsdata->bln,$lsdata->thn);
            ?>
            <div class="blog-post">
                <h2 class="blog-post-title"><?php echo $lsdata->judul;?></h2>
                <p class="blog-post-meta"><?php echo $masehi.' ('.$hijriyah.'), '; ?> oleh <?php echo $lsdata->inputer; ?></p>
                <p><?php echo $lsdata->uraian;?>.</p>
                <hr>
                <p><span style="font-weight: bold; color: blue;">ID : <?php echo $lsdata->id_methode;?></span>. Entitas : <?php echo $lsdata->entitas;?>. Nama Fungsi : <?php echo $lsdata->function;?></p>

                <h4>URL</h4>
                <pre><code><?php echo $lsdata->url;?></code></pre>

                <h4>Methode</h4>
                <p><?php echo $lsdata->methode;?></p>

                <h4>URL Params</h4>
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

                <h4>Sample Call</h4>
                <pre><code><?php echo $lsdata->sample_call;?></code></pre>

                <h4>Hasil Respons</h4>
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

            </div>
            <?php
            $i++;
        endforeach; ?>
    <?php else: ?>
        Tidak Ada Data
    <?php endif; ?>
<?php else: ?>
    Tidak Ada Data
<?php endif; ?>
