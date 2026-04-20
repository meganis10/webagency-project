<?php
include '../components/connect.php';
session_start();

if(isset($_SESSION['admin_id'])){
    header('location:dashboard.php');
}

$message = [];

if(isset($_POST['submit'])){

    $email = trim($_POST['email']);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    $pass = $_POST['pass'];

    $check = $conn->prepare("SELECT * FROM `admins` WHERE email = ?");
    $check->execute([$email]);

    if($check->rowCount() > 0){
        $row = $check->fetch(PDO::FETCH_ASSOC);
        
        if(password_verify($pass, $row['password'])){
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_name'] = $row['name'];
            header('location:dashboard.php');
        } else {
            $message[] = 'Wrong password!';
        }
    } else {
        $message[] = 'No admin account found!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - WebPro Italy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<section class="form-container" style="margin-top:5rem;">

    <?php
        if(!empty($message)){
            foreach($message as $msg){
                echo '<div class="error-msg">'.$msg.'</div>';
            }
        }
    ?>

    <form action="" method="POST" class="login">
        <h3>Admin Login</h3>

        <p>Email <span>*</span></p>
        <input type="email" name="email" placeholder="Enter admin email"
               maxlength="50" required class="box">

        <p>Password <span>*</span></p>
        <input type="password" name="pass" placeholder="Enter password"
               maxlength="30" required class="box">

        <input type="submit" name="submit" value="Login" class="btn">
        <p class="link">Don't have an admin account? <a href="register.php">Register here</a></p>
    </form>

</section>

</body>
</html>