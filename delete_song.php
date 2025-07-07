
<?php
    require_once('database.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['songId'])) { // 請使用 songId
            $songId = $_POST['songId'];

            // 執行刪除歌曲的 SQL 指令
            $delete_query = "DELETE FROM songs WHERE songId = ?";
            $stmt = $link->prepare($delete_query);
            $stmt->bind_param("i", $songId);

            if ($stmt->execute()) {
                // 刪除成功
                echo json_encode(array('success' => true, 'message' => '歌曲已成功刪除。'));

                // 更新資料庫中的 ID
                $update_query = "UPDATE songs SET songId = songId - 1 WHERE songId > ?";
                $stmt_update = $link->prepare($update_query);
                $stmt_update->bind_param("i", $songId);
                $stmt_update->execute();
            } else {
                // 刪除失敗
                echo json_encode(array('success' => false, 'message' => '刪除歌曲失敗。'));
            }
        } else {
            // songId 未設置
            echo json_encode(array('success' => false, 'message' => '未提供歌曲 ID。'));
        }
    } else {
        // 不是 POST 請求
        echo json_encode(array('success' => false, 'message' => '請使用 POST 請求。'));
    }

    $link->close();
?>

