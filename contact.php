<?php
include 'components/connect.php';
session_start();

$message = [];

if(isset($_POST['submit'])){

    $name = trim($_POST['name']);
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = trim($_POST['email']);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $subject = trim($_POST['subject']);
    $subject = filter_var($subject, FILTER_SANITIZE_STRING);

    $msg = trim($_POST['message']);
    $msg = filter_var($msg, FILTER_SANITIZE_STRING);

    $id = unique_id();
    $insert = $conn->prepare("INSERT INTO `messages`(id, name, email, subject, message) VALUES(?,?,?,?,?)");
    $insert->execute([$id, $name, $email, $subject, $msg]);

    $message[] = 'success:Message sent successfully!';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - WebPro Italy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="form-container">

    <?php
        if(!empty($message)){
            foreach($message as $msg){
                $type = strstr($msg, ':', true);
                $text = substr($msg, strpos($msg, ':') + 1);
                echo '<div class="'.$type.'-msg">'.$text.'</div>';
            }
        }
    ?>

    <form action="" method="POST" class="contact">
        <h3>Contact Us</h3>

        <p>Your Name <span>*</span></p>
        <input type="text" name="name" placeholder="Enter your name"
               maxlength="50" required class="box">

        <p>Your Email <span>*</span></p>
        <input type="email" name="email" placeholder="Enter your email"
               maxlength="50" required class="box">

        <p>Subject <span>*</span></p>
        <input type="text" name="subject" placeholder="Enter subject"
               maxlength="100" required class="box">

        <p>Message <span>*</span></p>
        <textarea name="message" placeholder="Write your message..."
                  maxlength="1000" required class="box"></textarea>

        <input type="submit" name="submit" value="Send Message" class="btn">
    </form>

</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>