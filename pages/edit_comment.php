<?php
session_start();
if (isset($_POST['comment_id'], $_POST['comment']) && isset($_SESSION['user_id'])) {
    $commentId = $_POST['comment_id'];
    $commentText = $_POST['comment'];
    $userId = $_SESSION['user_id'];

    // Connect to the database
    require_once ("../controllers/database/db.php");

    // Check if the comment belongs to the logged-in user
    $stmt = $db->prepare("SELECT user_id FROM comments WHERE comment_id = ?");
    $stmt->execute([$commentId]);
    $commentOwner = $stmt->fetchColumn();

    if ($commentOwner == $userId) {
        // Update the comment
        $updateStmt = $db->prepare("UPDATE comments SET comment = ? WHERE comment_id = ?");
        $updateStmt->execute([$commentText, $commentId]);

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "You are not allowed to edit this comment."]);
    }
}
?>
