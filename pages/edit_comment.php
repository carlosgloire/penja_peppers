<?php
    require_once('../controllers/database/db.php');

    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['comment_id'], $data['comment'])) {
        $stmt = $db->prepare("UPDATE comments SET comment = :comment WHERE id = :id");
        $result = $stmt->execute([
            'comment' => $data['comment'],
            'id' => $data['comment_id']
        ]);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update comment.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    }
