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

$message = [];

if(isset($_POST['add'])){
    $name = trim($_POST['name']);
    $name = filter_var($name, FILTER_SANITIZE_STRING);

    $email = trim($_POST['email']);
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $pass = $_POST['pass'];

    $check = $conn->prepare("SELECT * FROM `admins` WHERE email = ?");
    $check->execute([$email]);

    if($check->rowCount() > 0){
        $message[] = 'error:Admin with this email already exists!';
    } elseif(strlen($pass) < 6){
        $message[] = 'error:Password must be at least 6 characters!';
    } else {
        $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
        $id = unique_id();
        $insert = $conn->prepare("INSERT INTO `admins`(id, name, email, password) VALUES(?,?,?,?)");
        $insert->execute([$id, $name, $email, $hashed_pass]);
        $message[] = 'success:Admin added successfully!';
    }
}

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];

    // prevent admin from deleting themselves
    if($delete_id == $_SESSION['admin_id']){
        $message[] = 'error:You cannot delete your own account!';
    } else {
        $delete = $conn->prepare("DELETE FROM `admins` WHERE id = ?");
        $delete->execute([$delete_id]);
        header('location:admins.php');
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admins - WebPro Italy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="admin-container">

    <h1>Manage Admins</h1>
    <p class="subtitle">Add or remove admin accounts</p>

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
        <h2>Add New Admin</h2>
        <form action="" method="POST">
            <input type="text" name="name" placeholder="Admin name" required>
            <input type="email" name="email" placeholder="Admin email" required>
            <input type="password" name="pass" placeholder="Password (min 6 characters)" required>
            <input type="submit" name="add" value="Add Admin" class="btn">
        </form>
    </div>

    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $select = $conn->prepare("SELECT * FROM `admins`");
            $select->execute();
            if($select->rowCount() > 0){
                $count = 1;
                while($row = $select->fetch(PDO::FETCH_ASSOC)){
        ?>
            <tr>
                <td><?= $count++; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['email']; ?></td>
                <td>
                    <?php if($row['id'] != $_SESSION['admin_id']){ ?>
                    <a href="admins.php?delete=<?= $row['id']; ?>"
                       class="delete-btn"
                       onclick="return confirm('Delete this admin?')">
                        Delete
                    </a>
                    <?php } else { ?>
                    <span style="color:#888; font-size:0.9rem;">You</span>
                    <?php } ?>
                </td>
            </tr>
        <?php
                }
            } else {
                echo '<tr><td colspan="4" style="text-align:center; color:#888;">No admins found!</td></tr>';
            }
        ?>
        </tbody>
    </table>

</section>

</body>
</html>