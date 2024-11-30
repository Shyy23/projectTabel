<?php

function selectQuery($conn, $sql, $limit, $offset) {
    $sql .= " LIMIT ? OFFSET ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $limit, $offset);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}

// Fungsi untuk menghitung total halaman
function getTotalPages($conn, $table, $limit) {
    $sql = "SELECT COUNT(*) AS total FROM $table";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    $totalRecords = $result->fetch_assoc()['total'];
    return ceil($totalRecords / $limit);
}

// Menentukan nilai page dan limit
$page = (isset($_GET['page'])) ? $_GET['page'] : 1;
$limit = (isset($_GET['limit'])) ? $_GET['limit'] : 10;
$offset = ($page - 1) * $limit;
?>