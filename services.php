<?php
include 'components/connect.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - WebPro Italy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'components/header.php'; ?>

<section class="hero" style="padding:5rem 5%;">
    <h1>Our Services</h1>
    <p>Everything you need to succeed online</p>
</section>

<section class="services" style="padding:5rem 5%;">
    <div class="box-container">
        <?php
            $select = $conn->prepare("SELECT * FROM `services`");
            $select->execute();
            if($select->rowCount() > 0){
                while($row = $select->fetch(PDO::FETCH_ASSOC)){
        ?>
        <div class="box">
            <i class="fas <?= $row['icon']; ?>"></i>
            <h3><?= $row['title']; ?></h3>
            <p><?= $row['description']; ?></p>
        </div>
        <?php
                }
            } else {
                echo '<p class="empty">No services added yet!</p>';
            }
        ?>
    </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>
</body>
</html>