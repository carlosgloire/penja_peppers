<?php
    session_start();
    require_once('../controllers/database/db.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $commentId = $data['comment_id'];
            $userIp = $_SERVER['REMOTE_ADDR']; // Use the user's IP address as an identifier

            // Check if the user has already liked the comment
            $stmt = $db->prepare("SELECT * FROM comments_likes WHERE comment_id = ? AND user_ip = ?");
            $stmt->execute([$commentId, $userIp]);
            $like = $stmt->fetch();

            if ($like) {
                // Unlike the comment
                $stmt = $db->prepare("DELETE FROM comments_likes WHERE comment_id = ? AND user_ip = ?");
                $stmt->execute([$commentId, $userIp]);
            } else {
                // Like the comment
                $stmt = $db->prepare("INSERT INTO comments_likes (comment_id, user_ip) VALUES (?, ?)");
                $stmt->execute([$commentId, $userIp]);
            }

            // Get the updated like count
            $stmt = $db->prepare("SELECT COUNT(*) as like_count FROM comments_likes WHERE comment_id = ?");
            $stmt->execute([$commentId]);
            $likeCount = $stmt->fetchColumn();

            echo json_encode(['success' => true, 'like_count' => $likeCount]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'An error occurred.']);
        }
    } else {
        http_response_code(405); // Method Not Allowed
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }
