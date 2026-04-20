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

if(isset($_GET['delete'])){
    $delete_id = $_GET['delete'];
    $delete = $conn->prepare("DELETE FROM `messages` WHERE id = ?");
    $delete->execute([$delete_id]);
    header('location:messages.php');
    die();
}

$view_message = null;
if(isset($_GET['view'])){
    $view_id = $_GET['view'];
    $select_single = $conn->prepare("SELECT * FROM `messages` WHERE id = ?");
    $select_single->execute([$view_id]);
    $view_message = $select_single->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages - WebPro Italy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="admin-container">

    <h1>Messages</h1>
    <p class="subtitle">Messages sent from the contact form</p>

    <?php if($view_message): ?>
    <div class="add-form" style="margin-bottom:2rem;">
        <h2>Full Message</h2>
        <table class="profile-table" style="width:100%;">
            <tr>
                <td><strong>From:</strong></td>
                <td><?= $view_message['name']; ?></td>
            </tr>
            <tr>
                <td><strong>Email:</strong></td>
                <td><?= $view_message['email']; ?></td>
            </tr>
            <tr>
                <td><strong>Subject:</strong></td>
                <td><?= $view_message['subject']; ?></td>
            </tr>
            <tr>
                <td><strong>Date:</strong></td>
                <td><?= date('d M Y', strtotime($view_message['created_at'])); ?></td>
            </tr>
            <tr>
                <td><strong>Message:</strong></td>
                <td style="line-height:1.8; word-break:break-all; max-width:500px;"><?= nl2br($view_message['message']); ?></td>            </tr>
        </table>
        <a href="messages.php" class="btn" style="margin-top:1rem; border:none; cursor:pointer;">
            Back to Messages
        </a>
    </div>
    <?php endif; ?>

    <table class="admin-table">
    <thead>
        <tr>
            <th style="width:5%">#</th>
            <th style="width:15%">Name</th>
            <th style="width:25%">Email</th>
            <th style="width:25%">Subject</th>
            <th style="width:15%">Date</th>
            <th style="width:15%">Action</th>
        </tr>
    </thead>
        <tbody>
        <?php
            $select = $conn->prepare("SELECT * FROM `messages` ORDER BY created_at DESC");
            $select->execute();
            if($select->rowCount() > 0){
                $count = 1;
                while($row = $select->fetch(PDO::FETCH_ASSOC)){
        ?>
            <tr>
                <td><?= $count++; ?></td>
                <td><?= $row['name']; ?></td>
                <td><?= $row['email']; ?></td>
                <td><?= $row['subject']; ?></td>
                <td><?= date('d M Y', strtotime($row['created_at'])); ?></td>
                <td>
    <div style="display:flex; gap:0.5rem; align-items:center;">
        <a href="messages.php?view=<?= $row['id']; ?>"
           style="background:#2563eb; color:#fff; padding:0.3rem 0.8rem; border-radius:5px; font-size:0.85rem; white-space:nowrap;">
            View
        </a>
        <a href="messages.php?delete=<?= $row['id']; ?>"
           style="background:#fee2e2; color:#dc2626; padding:0.3rem 0.8rem; border-radius:5px; font-size:0.85rem; white-space:nowrap;"
           onclick="return confirm('Delete this message?')">
            Delete
        </a>
    </div>
</td>
            </tr>
        <?php
                }
            } else {
                echo '<tr><td colspan="6" style="text-align:center; color:#888;">No messages yet!</td></tr>';
            }
        ?>
        </tbody>
    </table>

</section>

</body>
</html>