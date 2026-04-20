<?php
if(!isset($_SESSION['admin_id'])){
    header('location:../admin/login.php');
    die();
}

$verify_admin = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
$verify_admin->execute([$_SESSION['admin_id']]);

if($verify_admin->rowCount() == 0){
    session_destroy();
    header('location:../admin/login.php');
    die();
}
?>

<header class="admin-header">
    <div class="logo">
        <a href="dashboard.php">WebPro Italy — Admin</a>
    </div>
    <nav>
        <a href="dashboard.php">Dashboard</a>
        <a href="services.php">Services</a>
        <a href="messages.php">Messages</a>
        <a href="users.php">Users</a>
        <a href="admins.php">Admins</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>