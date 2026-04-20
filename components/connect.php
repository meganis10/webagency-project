<?php 

$db_host = 'localhost';
$db_name = 'webagency_db';
$db_user = 'root';
$db_pass = '';

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user , $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {

    die("Connection failed: " . $e->getMessage());
}

if(!function_exists ('unique_id')) {
    function unique_id(){
        return bin2hex(random_bytes(16));
}
}
?>