
<?php
    require_once 'database.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user_id = $_POST['user_id'];

        if (empty($user_id)) {
            echo json_encode(['status' => 'error', 'error' => 'User ID is required']);
            exit;
        }

        $stmt = $link->prepare("DELETE FROM accounts WHERE member_id = ?");
        $stmt->bind_param('i', $user_id);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'error' => 'Failed to delete user']);
        }

        $stmt->close();
        $link->close();
    }
?>
