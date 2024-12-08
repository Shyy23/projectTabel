<?php
include "../../koneksi/koneksi.php";
function selectQuery($conn, $sql) {
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
$sql_aktif = "SELECT aktif FROM vJadwal";
$result_aktif = selectQuery($conn, $sql_aktif);
$active = $result_aktif->fetch_assoc();

?>