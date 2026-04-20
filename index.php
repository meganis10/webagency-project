<?php
include 'components/connect.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebPro Italy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/header.php'; ?>


<section class="hero">
    <h1>We Build Beautiful Websites</h1>
    <p>Professional web design and development services in Italy</p>
    <a href="services.php" class="btn">Our Services</a>
    <a href="contact.php" class="btn-outline">Contact Us</a>
</section>

<section class="services">
    <h2>What We Do</h2>
    <div class="box-container">
        <?php
            $select_services = $conn->prepare("SELECT * FROM `services`");
            $select_services->execute();
            if($select_services->rowCount() > 0){
                while($service = $select_services->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="box">
            <i class="fas <?= $service['icon']; ?>"></i>
            <h3><?= $service['title']; ?></h3>
            <p><?= $service['description']; ?></p>
        </div>
        <?php
                }
            }else{
                echo '<p class="empty">No services added yet!</p>';
            }
        ?>
    </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>