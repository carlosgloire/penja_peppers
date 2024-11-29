<?php
session_start();
if (isset($_POST['comment_id']) && isset($_SESSION['user_id'])) {
    $commentId = $_POST['comment_id'];
    $userId = $_SESSION['user_id'];

    // Connect to the database
    require_once ("../controllers/database/db.php");

    // Check if the comment belongs to the logged-in user
    $stmt = $db->prepare("SELECT user_id FROM comments WHERE comment_id = ?");
    $stmt->execute([$commentId]);
    $commentOwner = $stmt->fetchColumn();

    if ($commentOwner == $userId) {
        // Delete the comment
        $deleteStmt = $db->prepare("DELETE FROM comments WHERE comment_id = ?");
        $deleteStmt->execute([$commentId]);

        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "You are not allowed to delete this comment."]);
    }
}
?>
