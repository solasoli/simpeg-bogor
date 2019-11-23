
<?php
$error = ! empty($validation_errors) ? $validation_errors : $this->session->flashdata('pesan_error');
?>
<?php if (is_array($error)): ?>
    <?php foreach($error as $err): ?>
        <br>
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <?php echo $err; ?>
        </div>
    <?php endforeach ?>
<?php else: ?>
    <?php if ($error<>""): ?>
        <br>
        <div class="alert alert-danger" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <?php echo $error; ?>
        </div>
    <?php endif ?>
<?php endif ?>
