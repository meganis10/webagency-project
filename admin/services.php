<?php
include '../components/connect.php';
session_start();

if(!isset($_SESSION['admin_id'])){
    header('location:login.php');
    die();
}

$verify = $conn->prepare("SELECT * FROM `admins` WHERE id = ?");
$verify->execute([$_SESSION['admin_id']]);
if($verify->rowCount() == 0){
    session_destroy();
    header('location:login.php');
    die();
}

$admin_name = $_SESSION['admin_name'];

$message = [];

if(isset($_POST['add'])){
    $title = trim($_POST['title']);
    $title = filter_var($title, FILTER_SANITIZE_STRING);
    
    $description = trim($_POST['description']);
    $description = filter_var($description, FILTER_SANITIZE_STRING);
    
    $icon = trim($_POST['icon']);
    $icon = filter_var($icon, FILTER_SANITIZE_STRING);

    $check = $conn->prepare("SELECT * FROM `services` WHERE title = ?");
    $check->execute([$title]);

    if($check->rowCount() > 0){
        $message[] = 'error:Service with this title already exists!';
    } else {
        $id = unique_id();
        $insert = $conn->prepare("INSERT INTO `services`(id, title, description, icon) VALUES(?,?,?,?)");
        $insert->execute([$id, $title, $description, $icon]);
        $message[] = 'success:Service added successfully!';
    }
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete = $conn->prepare("DELETE FROM `services` WHERE id = ?");
    $delete->execute([$delete_id]);
    header('location:services.php');
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services - WebPro Italy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="admin-container">

    <h1>Manage Services</h1>
    <p class="subtitle">Add or remove services shown on homepage</p>

    <?php
    if(!empty($message)){
        foreach($message as $msg){
            $parts = explode(':', $msg, 2);
            $type = $parts[0];
            $text = $parts[1];
            echo '<div class="'.$type.'-msg" style="max-width:100%;">'.$text.'</div>';
        }
    }
    ?>

    <div class="add-form">
        <h2>Add New Service</h2>
        <form action="" method="POST">
            <input type="text" name="title" placeholder="Service title e.g. Web Design" required>
            <textarea name="description" placeholder="Service description..." required></textarea>
            <input type="text" name="icon" placeholder="Font Awesome icon e.g. fa-laptop-code" required>
            <p style="color:#888; font-size:0.9rem; margin-bottom:1rem;">
                Find icons at <a href="https://fontawesome.com/icons" target="_blank" style="color:#2563eb;">fontawesome.com/icons</a> — copy the icon name e.g. fa-laptop-code
            </p>
            <input type="submit" name="add" value="Add Service" class="btn">
        </form>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Icon</th>
                <th>Title</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $select = $conn->prepare("SELECT * FROM `services`");
            $select->execute();
            if($select->rowCount() > 0){
                $count = 1;
                while($row = $select->fetch(PDO::FETCH_ASSOC)){
        ?>
            <tr>
                <td><?= $count++; ?></td>
                <td><i class="fas <?= $row['icon']; ?>" style="font-size:1.5rem; color:#2563eb;"></i></td>
                <td><?= $row['title']; ?></td>
                <td><?= substr($row['description'], 0, 60); ?>...</td>
                <td>
                    <a href="services.php?delete=<?= $row['id']; ?>" 
                       class="delete-btn"
                       onclick="return confirm('Are you sure you want to delete this service?')">
                        Delete
                    </a>
                </td>
            </tr>
        <?php
                }
            } else {
                echo '<tr><td colspan="5" style="text-align:center; color:#888;">No services added yet!</td></tr>';
            }
        ?>
        </tbody>
    </table>

</section>

</body>
</html>