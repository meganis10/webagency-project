<?php
include 'components/connect.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - WebPro Italy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="hero" style="padding:5rem 5%;">
    <h1>About Us</h1>
    <p>We are a professional web design agency based in Italy</p>
</section>

<section class="about">
    <div class="about-container">
        <div class="about-text">
            <h2>Who We Are</h2>
            <p>WebPro Italy is a leading web design and development agency based in Italy. We specialize in creating beautiful, functional websites that help businesses grow online.</p>
            <p>Our team of experienced developers and designers work together to deliver outstanding digital experiences for our clients across Italy and beyond.</p>
            <h2>Our Mission</h2>
            <p>To provide businesses with modern, secure and high-performing websites that drive real results. We believe every business deserves a great online presence.</p>
        </div>
        <div class="about-stats">
            <div class="stat">
                <h3>50+</h3>
                <p>Projects Completed</p>
            </div>
            <div class="stat">
                <h3>30+</h3>
                <p>Happy Clients</p>
            </div>
            <div class="stat">
                <h3>5+</h3>
                <p>Years Experience</p>
            </div>
        </div>
    </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>