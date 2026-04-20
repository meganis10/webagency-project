<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

include '../components/connect.php';

$response = [];

try {
    $select = $conn->prepare("SELECT * FROM `services`");
    $select->execute();
    
    if($select->rowCount() > 0){
        $services = $select->fetchAll(PDO::FETCH_ASSOC);
        $response = [
            'status' => 'success',
            'count' => count($services),
            'data' => $services
        ];
    } else {
        $response = [
            'status' => 'success',
            'count' => 0,
            'data' => []
        ];
    }
} catch(Exception $e){
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);
?>