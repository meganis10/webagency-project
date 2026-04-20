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

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete = $conn->prepare("DELETE FROM `users` WHERE id = ?");
    $delete->execute([$delete_id]);
    header('location:users.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users - WebPro Italy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="admin-container">

    <h1>Users</h1>
    <p class="subtitle">All registered users on the website</p>

    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Registered On</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $select = $conn->prepare("SELECT * FROM `users` ORDER BY created_at DESC");
            $select->execute();
            if($select->rowCount() > 0){
                $count = 1;
                while($row = $select->fetch(PDO::FETCH_ASSOC)){
        ?>
            <tr>
                <td><?= $count++; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= date('d M Y', strtotime($row['created_at'])); ?></td>
                <td>
                    <a href="users.php?delete=<?= $row['id']; ?>"
                       class="delete-btn"
                       onclick="return confirm('Delete this user?')">
                        Delete
                    </a>
                </td>
            </tr>
        <?php
                }
            } else {
                echo '<tr><td colspan="5" style="text-align:center; color:#888;">No users registered yet!</td></tr>';
            }
        ?>
        </tbody>
    </table>

</section>

</body>
</html>