<?php
include '../koneksi/koneksi.php';
include '../query/query_edit.php';
date_default_timezone_set('Asia/Jakarta');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit <?= htmlspecialchars($tabel, ENT_QUOTES, 'UTF-8')?></title>
    <link rel="stylesheet" href="../dist/css/crud.css?v=<?= filemtime('../dist/css/crud.css')?>">
    <link rel="stylesheet" href="../dist/css/form.css?v=<?= filemtime('../dist/css/form.css')?>">
</head>
<body>
    <h2 class="judul"> Edit <?= htmlspecialchars(ucfirst($tabel), ENT_QUOTES, 'UTF-8')?></h2>

    <form action="../query/query_update.php" method="POST" class="form_container edit__form">
        <?php if (isset($editFields) && is_array($editFields)): ?>
            <?php foreach ($editFields as $name => $field): ?>
                <?php
                $fieldLabel = htmlspecialchars($field['label'], ENT_QUOTES, 'UTF-8');
                $fieldId = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
                ?>
                <?php if ($field['type'] === 'select'): ?>
                    <div class="wrapper wrapper-select wrapper-add">
                        <label for="<?= $fieldId ?>" class="info-select stacked"><?= $fieldLabel ?></label>
                        <select name="<?= $name ?>" id="<?= $fieldId ?>" class="select select-edit">
                            <?php if (isset($field['col']) && $field['col'] === $name): ?>
                                <?= ${'selected' . ucfirst($name)} ?>
                            <?php elseif (!empty($field['options']) && is_array($field['options'])): ?>
                                <?php foreach ($field['options'] as $key => $label): ?>
                                    <option class="option" value="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>"
                                    <?= (in_array($label, array_column($field['value'], 'jenis_kelamin'))) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">Data tidak tersedia</option>
                            <?php endif; ?>
                        </select>
                    </div>
                <?php elseif ($field['type'] === 'hidden'): ?>
                    <?php foreach ($field['value'] as $value): ?>
                        <input type="hidden" class="input input-edit" name="<?= $name ?>" value="<?= htmlspecialchars($value[$name], ENT_QUOTES, 'UTF-8') ?>" readonly>
                    <?php endforeach; ?>
                <?php elseif ($field['type'] === 'text'): ?>
                    <div class="wrapper wrapper-add">
                        <?php foreach ($field['value'] as $value): ?>
                            <input type="text" class="input input-edit <?= ($field['status'] === 'read') ? 'read' : '' ?>" name="<?= $name ?>" id="<?= $fieldId ?>" value="<?= htmlspecialchars($value[$field['col']], ENT_QUOTES, 'UTF-8') ?>" <?= ($field['status'] === 'req') ? 'required' : 'readonly' ?>>
                            <label for="<?= $fieldId ?>" class="info <?= ($field['status'] === 'read') ? 'info-read stacked' : '' ?>"><?= $fieldLabel ?></label>
                        <?php endforeach; ?>
                    </div>
                <?php elseif (in_array($field['type'], ['time', 'date'])): ?>
                    <div class="content_jam wrapper-add">
                        <?php foreach ($field['value'] as $value): ?>
                            <input type="<?= $field['type'] ?>" class="input input-jam  ?>" 
                                name="<?= $name ?>" id="<?= $fieldId ?>" 
                                value="<?= date(($field['type'] === 'time') ? 'H:i' : 'Y-m-d', strtotime($value[$name])) ?>" 
                                <?= ($field['status'] === 'req') ? 'required' : 'readonly' ?>>
                            <label for="<?= $fieldId ?>" class="info info-jam stacked"><?= $fieldLabel ?></label>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Error: Form Data Tidak ditemukan</p>
        <?php endif; ?>

        <button type="submit" class="btn btn__edit">Submit</button>
    </form>
</body>
</html>