<?php
include 'components/connect.php';
session_start();

if(isset($_SESSION['user_id'])){
    header('location:index.php');
}

$message = [];

if(isset($_POST['submit'])){

    $name = trim($_POST['name']);
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    
    $email = trim($_POST['email']);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    $pass = $_POST['pass'];
    $cpass = $_POST['cpass'];

    $dob = $_POST['dob'];
$country = filter_var($_POST['country'], FILTER_SANITIZE_STRING);
$city = trim($_POST['city']);
$city = filter_var($city, FILTER_SANITIZE_STRING);

    $check_email = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $check_email->execute([$email]);

    if($check_email->rowCount() > 0){
        $message[] = 'error:Email already taken! Please use another.';
    } elseif($pass != $cpass){
        $message[] = 'error:Passwords do not match!';
    } elseif(strlen($pass) < 6){
        $message[] = 'error:Password must be at least 6 characters!';
    } else {
        $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
        $id = unique_id();
       $insert = $conn->prepare("INSERT INTO `users`(id, name, email, password, dob, country, city) VALUES(?,?,?,?,?,?,?)");
$insert->execute([$id, $name, $email, $hashed_pass, $dob, $country, $city]);
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        header('location:index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - WebPro Italy</title>
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

    <form action="" method="POST" class="register">
        <h3>Create Account</h3>

        <p>Your Name <span>*</span></p>
        <input type="text" name="name" placeholder="Enter your name" maxlength="50" required class="box">

        <p>Your Email <span>*</span></p>
        <input type="email" name="email" placeholder="Enter your email" maxlength="50" required class="box">

        <p>Date of Birth <span>*</span></p>
<input type="date" name="dob" required class="box">

<p>Country <span>*</span></p>
<select name="country" required class="box">
    <option value="">Select your country</option>
    <option value="Italy">Italy</option>
    <option value="Germany">Germany</option>
    <option value="France">France</option>
    <option value="Spain">Spain</option>
    <option value="UK">UK</option>
    <option value="USA">USA</option>
    <option value="Other">Other</option>
</select>

<p>Current City <span>*</span></p>
<input type="text" name="city" placeholder="Enter your city" maxlength="50" required class="box">

        <p>Your Password <span>*</span></p>
        <input type="password" name="pass" placeholder="Enter your password" maxlength="30" required class="box">

        <p>Confirm Password <span>*</span></p>
        <input type="password" name="cpass" placeholder="Confirm your password" maxlength="30" required class="box">

        <input type="submit" name="submit" value="Register Now" class="btn">
        <p class="link">Already have an account? <a href="login.php">Login now</a></p>
    </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>