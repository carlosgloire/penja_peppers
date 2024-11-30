<?php
    session_start();
    require_once('functions.php');
    require_once('database/db.php');
    notconnected();

    if (!isset($_GET['order_item_id']) || empty($_GET['order_item_id'])) {
        echo '<script>alert("No order item ID provided.");</script>';
        echo '<script>window.location.href="../pages/userDashboard.php";</script>';
        exit;
    }

    $order_item_id = $_GET['order_item_id'];
    // Get the order_id associated with this order_item
    $orderQuery = $db->prepare("SELECT order_id FROM order_item WHERE order_item_id = ?");
    $orderQuery->execute([$order_item_id]);
    $order = $orderQuery->fetch();

    if ($order) {
        $order_id = $order['order_id'];

        // Delete the specific order item
        $deleteQuery = $db->prepare("DELETE FROM order_item WHERE order_item_id = ?");
        $deleteQuery->execute([$order_item_id]);

        // Check if there are any remaining items in the order
        $remainingItemsQuery = $db->prepare("SELECT COUNT(*) FROM order_item WHERE order_id = ?");
        $remainingItemsQuery->execute([$order_id]);
        $remainingItems = $remainingItemsQuery->fetchColumn();

        if ($remainingItems == 0) {
            // No items remain, delete the order
            $deleteOrderQuery = $db->prepare("DELETE FROM orders WHERE order_id = ?");
            $deleteOrderQuery->execute([$order_id]);
        }
        echo '<script>alert("Order item deleted successfully.");</script>';
        echo '<script>window.location.href="../pages/userDashboard.php";</script>';
        exit;
    } else {
        echo '<script>alert("Order item not found.");</script>';
        echo '<script>window.location.href="../pages/userDashboard.php";</script>';
        exit;
    }
?>
