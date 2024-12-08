<?php
include '../koneksi/koneksi.php';
include '../query/query_add.php';
date_default_timezone_set('Asia/Jakarta');


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah <?= htmlspecialchars($tabel, ENT_QUOTES, 'UTF-8')?></title>
    <link rel="stylesheet" href="../dist/css/crud.css?v=<?= filemtime('../dist/css/crud.css')?>">
    <link rel="stylesheet" href="../dist/css/form.css?v=<?= filemtime('../dist/css/form.css')?>">
</head>
<body>
    <h2 class="judul">Tambah Data <?= htmlspecialchars( ucfirst($tabel), ENT_QUOTES, 'UTF-8') ?> </h2>
<form action="../query/query_proses.php" method="POST" class="form_container form__add">
    <input type="hidden" name="tabel" value="<?= $tabel ?>" readonly>
    <?php 
    // Cek apakah role pengguna adalah 'user' dan jika 'jadwal_id' ada di URL
    if ($_SESSION['role'] === 'user' && isset($_GET['jadwal_id'])): ?>
        <!-- Menambahkan input hidden untuk jadwal_id hanya jika role adalah user -->
        <input type="hidden" name="jadwal_id" value="<?= htmlspecialchars($_GET['jadwal_id'], ENT_QUOTES, 'UTF-8') ?>" readonly>
    <?php endif; ?>
    <?php if (isset($formFields) && is_array($formFields)): ?>
        <?php foreach ($formFields as $name => $field): ?>
            <div class="wrapper <?= $field['type'] === 'select' ? 'wrapper_select' : '' ?>">
                <?php if ($field['type'] === 'select'): ?>
                    <label for="<?= $name ?>" class="info-select stacked"><?= htmlspecialchars($field['label'], ENT_QUOTES, 'UTF-8') ?></label>
                    <select name="<?= $name ?>" id="<?= $name ?>" class="select add__select" required>
                        <?php foreach ($field['options'] as $key => $value): ?>
                            <?php if (is_array($value)): ?>
                                <option value="<?= htmlspecialchars($value['value'], ENT_QUOTES, 'UTF-8') ?>" class="option"><?= htmlspecialchars($value['label'], ENT_QUOTES, 'UTF-8') ?></option>
                            <?php else: ?>
                                <option value="<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>" class="option"><?= htmlspecialchars($value, ENT_QUOTES, 'UTF-8') ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <?php 
                    $value = ''; // Variabel untuk nilai input
                    $readonly = ''; // Tidak ada readonly
                    $stackedClass = ''; // Tidak ada kelas stacked
                    if ($name === 'siswa' && $_SESSION['role'] === 'user') {
                        $field['type'] = 'text'; // Ubah type menjadi text untuk 'user'
                        $value = $_SESSION['nama'];
                        $readonly = 'readonly'; // Set readonly untuk input siswa
                        $stackedClass = 'stacked read'; // Tambahkan kelas stacked // Set value dengan nama dari session
                    } else {
                        // Untuk tipe 'time' atau 'date' dengan auto set
                        if (($field['type'] === 'time' || $field['type'] === 'date') && isset($field['auto']) && $field['auto'] === 'true') {
                            $value = $field['type'] === 'time' ? date('H:i') : date('Y-m-d');
                        }
                    }

                    ?>
                    <input type="<?= $field['type'] ?>" 
                           class="input <?= $field['type'] === 'time' ? 'input-jam input-add' : 'add' ?>" 
                           name="<?= $name ?>" 
                           id="<?= $name ?>" 
                           value="<?= $value ?>" 
                           <?= $field['type'] === 'time' ? 'step="60"' : '' ?> 
                           <?= $readonly ?>
                           required>
                    <label for="<?= $name ?>" 
                           class="info <?= $field['type'] === 'time' ? 'info-jam waktu stacked' : ($field['type'] === 'date' ? 'info-jam tanggal stacked' : '') ?> <?= $stackedClass ?>">
                           <?= htmlspecialchars($field['label'],ENT_QUOTES, 'UTF-8') ?>
                    </label>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Error: Form Data Tidak ditemukan</p>
    <?php endif; ?>
    <button type="submit" class="btn btn__add">Submit</button>
</form>
<a href="../viewTabel/Tabel<?php 
if($tabel === 'presensi'){
    $tabel = 'absen';    
} else {
    $tabel;
}
echo ucfirst($tabel)?>.php"><button class="btn btn__back">Kembali</button></a>

</body>
</html>