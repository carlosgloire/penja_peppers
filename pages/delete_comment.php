<?php
    require_once('../controllers/database/db.php');

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['comment_id'])) {
        $stmt = $db->prepare("DELETE FROM comments WHERE id = :id");
        $result = $stmt->execute(['id' => $data['comment_id']]);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete comment.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    }
