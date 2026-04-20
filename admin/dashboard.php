<?php
include '../components/connect.php';
session_start();


if(!isset($_SESSION['admin_id'])){
    header('location:login.php');
    die();
}

$verify = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
$verify->execute([$_SESSION['admin_id']]);
if($verify->rowCount() == 0){
    session_destroy();
    header('location:login.php');
    die();
}

$admin_name = $_SESSION['admin_name'];

$count_users = $conn->prepare("SELECT * FROM `users`");
$count_users->execute();
$total_users = $count_users->rowCount();

$count_messages = $conn->prepare("SELECT * FROM `messages`");
$count_messages->execute();
$total_messages = $count_messages->rowCount();

$count_services = $conn->prepare("SELECT * FROM `services`");
$count_services->execute();
$total_services = $count_services->rowCount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - WebPro Italy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="admin-container">

    <h1>Welcome, <?= $admin_name; ?>!</h1>
    <p class="subtitle">Manage your website from here</p>

    <div class="stats-container">
        <div class="stat-box">
            <i class="fas fa-users"></i>
            <h3><?= $total_users; ?></h3>
            <p>Total Users</p>
        </div>
        <div class="stat-box">
            <i class="fas fa-envelope"></i>
            <h3><?= $total_messages; ?></h3>
            <p>Total Messages</p>
        </div>
        <div class="stat-box">
            <i class="fas fa-cogs"></i>
            <h3><?= $total_services; ?></h3>
            <p>Total Services</p>
        </div>
    </div>

    <div class="quick-links">
        <a href="services.php" class="quick-box">
            <i class="fas fa-cogs"></i>
            <span>Manage Services</span>
        </a>
        <a href="messages.php" class="quick-box">
            <i class="fas fa-envelope"></i>
            <span>View Messages</span>
        </a>
        <a href="users.php" class="quick-box">
            <i class="fas fa-users"></i>
            <span>View Users</span>
        </a>
        <a href="logout.php" class="quick-box logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
    </a>
        
        <a href="admins.php" class="quick-box">
    <i class="fas fa-user-shield"></i>
    <span>Manage Admins</span>
    </a>

    </div>

</section>

</body>
</html>