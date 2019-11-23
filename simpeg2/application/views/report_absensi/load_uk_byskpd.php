<select id="ddFilterUk" style="background-color: #e3c800;">
    <?php foreach ($list_uk as $ls): ?>
        <?php if($ls->id_unit_kerja == $idunit): ?>
            <option value="<?php echo $ls->id_unit_kerja; ?>" selected><?php echo $ls->unit; ?></option>
        <?php else: ?>
            <option value="<?php echo $ls->id_unit_kerja; ?>"><?php echo $ls->unit; ?></option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>