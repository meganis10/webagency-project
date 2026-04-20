<?php
include 'components/connect.php';
session_start();

if(!isset($_SESSION['user_id'])){
    header('location:login.php');
    die();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

$select = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
$select->execute([$user_id]);
$user = $select->fetch(PDO::FETCH_ASSOC);

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    
    if($delete_id == $user_id){
        $delete = $conn->prepare("DELETE FROM `users` WHERE id = ?");
        $delete->execute([$delete_id]);
        session_destroy();
        header('location:index.php');
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - WebPro Italy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="form-container">
    <div class="profile-box">
        <h2>My Profile</h2>
        <div class="profile-info">
            <div class="profile-icon">
                <i class="fas fa-user-circle"></i>
            </div>
            <table class="profile-table">
                <tr>
                    <td><strong>Name:</strong></td>
                    <td><?= $user['name']; ?></td>
                </tr>
                <tr>
                    <td><strong>Email:</strong></td>
                    <td><?= $user['email']; ?></td>
                </tr>
                <tr>
                    <td><strong>Member Since:</strong></td>
                    <td><?= date('d M Y', strtotime($user['created_at'])); ?></td>
                </tr>
                <tr>
    <td><strong>Date of Birth:</strong></td>
    <td><?= date('d M Y', strtotime($user['dob'])); ?></td>
</tr>
<tr>
    <td><strong>Country:</strong></td>
    <td><?= $user['country']; ?></td>
</tr>
<tr>
    <td><strong>City:</strong></td>
    <td><?= $user['city']; ?></td>
</tr>
            </table>
        </div>
<a href="logout.php" class="btn" style="margin-top:1rem;">Logout</a>
<a href="profile.php?delete=<?= $user['id']; ?>" 
   class="delete-btn" 
   style="display:inline-block; margin-top:1rem; padding:0.8rem 2rem;"
   onclick="return confirm('Are you sure you want to delete your account? This cannot be undone!')">
    Delete My Account
</a>   

    </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>