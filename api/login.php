<?php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

include '../components/connect.php';

$response = [];

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    echo json_encode(['status' => 'error', 'message' => 'Only POST method allowed']);
    exit;
}

$data = json_decode(file_get_contents('php://input'), true);

$email = isset($data['email']) ? filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL) : '';
$pass = isset($data['pass']) ? $data['pass'] : '';

if(empty($email) || empty($pass)){
    echo json_encode(['status' => 'error', 'message' => 'Email and password required']);
    exit;
}

$check = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
$check->execute([$email]);

if($check->rowCount() > 0){
    $row = $check->fetch(PDO::FETCH_ASSOC);
    
    if(password_verify($pass, $row['password'])){
        echo json_encode([
            'status' => 'success',
            'message' => 'Login successful',
            'user_id' => $row['id'],
            'user_name' => $row['name']
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Wrong password']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No account found with this email']);
}
?>