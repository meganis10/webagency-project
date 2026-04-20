<?php
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
    header('location:index.php');
}

$message = [];

if(isset($_POST['submit'])){

    $email = trim($_POST['email']);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    $pass = $_POST['pass'];

    $check = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $check->execute([$email]);

    if($check->rowCount() > 0){
        $row = $check->fetch(PDO::FETCH_ASSOC);
        
        if(password_verify($pass, $row['password'])){
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            header('location:index.php');
        } else {
            $message[] = 'error:Wrong password!';
        }
    } else {
        $message[] = 'error:No account found with this email!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - WebPro Italy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="form-container">

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

    <form action="" method="POST" class="login">
        <h3>Login</h3>

        <p>Your Email <span>*</span></p>
        <input type="email" name="email" placeholder="Enter your email"
               maxlength="50" required class="box">

        <p>Your Password <span>*</span></p>
        <input type="password" name="pass" placeholder="Enter your password"
               maxlength="30" required class="box">

        <input type="submit" name="submit" value="Login Now" class="btn">
        <p class="link">Don't have an account? <a href="register.php">Register now</a></p>
    </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>