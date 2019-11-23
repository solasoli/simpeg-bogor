
<?php
$error = ! empty($validation_errors) ? $validation_errors : $this->session->flashdata('pesan_error');
?>
<?php if (is_array($error)): ?>
    <?php foreach($error as $err): ?>
        <br>
            <span style="color: red;"><?php echo $err; ?></span>
    <?php endforeach ?>
<?php else: ?>
    <?php if ($error<>""): ?>
        <br>
            <span style="color: red;"><?php echo $error; ?></span>

    <?php endif ?>
<?php endif ?>


