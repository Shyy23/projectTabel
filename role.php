<?php
session_start();
$response = [
    'role' => isset($_SESSION['role']) ? $_SESSION['role'] : 'user',
    'status' => 'success'
];
echo json_encode($response)
?>
