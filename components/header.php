<?php
if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];
}else{
    $user_id = '';
    $user_name = '';
}
?>

<header>
    <div class="logo">
        <a href="index.php">WebPro Italy</a>
    </div>
    <nav>
        <a href="index.php">Home</a>
        <a href="about.php">About</a>
        <a href="services.php">Services</a>
        <a href="contact.php">Contact</a>
        <?php if($user_id != ''){ ?>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        <?php }else{ ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php } ?>
    </nav>
</header>