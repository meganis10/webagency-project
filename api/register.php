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

$name = isset($data['name']) ? filter_var(trim($data['name']), FILTER_SANITIZE_STRING) : '';
$email = isset($data['email']) ? filter_var(trim($data['email']), FILTER_SANITIZE_EMAIL) : '';
$pass = isset($data['pass']) ? $data['pass'] : '';
$dob = isset($data['dob']) ? $data['dob'] : '';
$country = isset($data['country']) ? filter_var($data['country'], FILTER_SANITIZE_STRING) : '';
$city = isset($data['city']) ? filter_var(trim($data['city']), FILTER_SANITIZE_STRING) : '';

if(empty($name) || empty($email) || empty($pass) || empty($dob) || empty($country) || empty($city)){
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit;
}

if(strlen($pass) < 6){
    echo json_encode(['status' => 'error', 'message' => 'Password must be at least 6 characters']);
    exit;
}

$check = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
$check->execute([$email]);

if($check->rowCount() > 0){
    echo json_encode(['status' => 'error', 'message' => 'Email already taken']);
    exit;
}

$hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
$id = unique_id();

$insert = $conn->prepare("INSERT INTO `users`(id, name, email, password, dob, country, city) VALUES(?,?,?,?,?,?,?)");
$insert->execute([$id, $name, $email, $hashed_pass, $dob, $country, $city]);

echo json_encode([
    'status' => 'success',
    'message' => 'User registered successfully',
    'user_id' => $id
]);
?>