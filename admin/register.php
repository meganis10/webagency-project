<?php
include '../components/connect.php';
session_start();

if(isset($_SESSION['admin_id'])){
    header('location:dashboard.php');
}

$message = [];

if(isset($_POST['submit'])){

    $name = trim($_POST['name']);
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = trim($_POST['email']);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];

    $check = $conn->prepare("SELECT * FROM `admins` WHERE email = ?");
    $check->execute([$email]);

    if($check->rowCount() > 0){
        $message[] = 'error:Admin email already exists!';
    } elseif($pass != $cpass){
        $message[] = 'error:Passwords do not match!';
    } elseif(strlen($pass) < 6){
        $message[] = 'error:Password must be at least 6 characters!';
    } else {
        $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
        $id = unique_id();
        $insert = $conn->prepare("INSERT INTO `admins`(id, name, email, password) VALUES(?,?,?,?)");
        $insert->execute([$id, $name, $email, $hashed_pass]);
        $message[] = 'success:Admin account created! You can now login.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Register - WebPro Italy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<section class="form-container" style="margin-top:5rem;">

    <?php
    if(!empty($message)){
        foreach($message as $msg){
            $parts = explode(':', $msg, 2);
            $type = $parts[0];
            $text = $parts[1];
            echo '<div class="'.$type.'-msg">'.$text.'</div>';
        }
    }
    ?>

    <form action="" method="POST" class="register">
        <h3>Create Admin Account</h3>

        <p>Name <span>*</span></p>
        <input type="text" name="name" placeholder="Enter your name" maxlength="50" required class="box">

        <p>Email <span>*</span></p>
        <input type="email" name="email" placeholder="Enter your email" maxlength="50" required class="box">

        <p>Password <span>*</span></p>
        <input type="password" name="pass" placeholder="Enter password" maxlength="30" required class="box">

        <p>Confirm Password <span>*</span></p>
        <input type="password" name="cpass" placeholder="Confirm password" maxlength="30" required class="box">

        <input type="submit" name="submit" value="Create Admin" class="btn">
        <p class="link">Already have account? <a href="login.php">Login</a></p>
    </form>

</section>

</body>
</html>