
<?php
    session_start();
    require_once('database.php');
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['songId']) && isset($_SESSION['user_id'])) {
        $songId = $_POST['songId'];
        $userId = $_SESSION['user_id'];

        // 檢查歌曲是否存在於播放清單中
        $checkStmt = $link->prepare("SELECT * FROM playlist_songs ps
                                    INNER JOIN playlists p ON ps.playlist_id = p.playlist_id
                                    WHERE ps.song_id = ? AND p.user_id = ?");
        $checkStmt->bind_param('ii', $songId, $userId);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // 刪除歌曲
            $deleteStmt = $link->prepare("DELETE FROM playlist_songs WHERE song_id = ?");
            $deleteStmt->bind_param('i', $songId);
            if ($deleteStmt->execute()) {
                echo json_encode(['success' => true, 'message' => '歌曲已成功從播放清單中刪除']);
            } else {
                echo json_encode(['success' => false, 'message' => '刪除歌曲失敗']);
            }
            $deleteStmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => '歌曲不存在於播放清單中']);
        }

        $checkStmt->close();
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => '無效的請求']);
    }
?>
