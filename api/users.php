<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include '../components/connect.php';

$response = [];

$admin_key = isset($_GET['admin_key']) ? $_GET['admin_key'] : '';

if($admin_key !== 'webpro2025'){
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

$select = $conn->prepare("SELECT id, name, email, country, city, created_at FROM `users`");
$select->execute();

if($select->rowCount() > 0){
    $users = $select->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode([
        'status' => 'success',
        'count' => count($users),
        'data' => $users
    ]);
} else {
    echo json_encode([
        'status' => 'success',
        'count' => 0,
        'data' => []
    ]);
}
?>