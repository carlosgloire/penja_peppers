<?php
    session_start();
    require_once('../controllers/functions.php');
    require_once('../controllers/database/db.php');
    logout();
    $user = null;
    if (isset($_SESSION['user_id'])) {
        $query = $db->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $query->execute(['user_id' => $_SESSION['user_id']]);
        $user = $query->fetch();
    }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    notconnected();
    $postId = $_POST['post_id'];
    $comment = $_POST['comment'];


    $stmt = $db->prepare("INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)");
    $stmt->execute([$postId, $_SESSION['user_id'], $comment]);

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}
?>