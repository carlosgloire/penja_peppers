<?php
    session_start();
    require_once('../controllers/database/db.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $postId = $data['post_id'];
            $userIp = $_SERVER['REMOTE_ADDR']; // Use the user's IP address as an identifier

            // Check if the user has already liked the post
            $stmt = $db->prepare("SELECT * FROM likes WHERE post_id = ? AND user_ip = ?");
            $stmt->execute([$postId, $userIp]);
            $like = $stmt->fetch();

            if ($like) {
                // Unlike the post
                $stmt = $db->prepare("DELETE FROM likes WHERE post_id = ? AND user_ip = ?");
                $stmt->execute([$postId, $userIp]);
            } else {
                // Like the post
                $stmt = $db->prepare("INSERT INTO likes (post_id, user_ip) VALUES (?, ?)");
                $stmt->execute([$postId, $userIp]);
            }
            // Get the updated like count
            $stmt = $db->prepare("SELECT COUNT(*) as like_count FROM likes WHERE post_id = ?");
            $stmt->execute([$postId]);
            $likeCount = $stmt->fetchColumn();

            echo json_encode(['success' => true, 'like_count' => $likeCount]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => 'An error occurred.']);
        }
    } else {
        http_response_code(405); // Method Not Allowed
        echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    }
