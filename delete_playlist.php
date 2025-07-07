
<?php
    session_start();
    require_once('database.php');

    if (isset($_POST['playlistName'])) {
        $playlistName = $_POST['playlistName'];

        // 取得 user_id
        $userId = $_SESSION['user_id'];

        // 查詢對應的 playlist_id
        $stmt = $link->prepare("SELECT playlist_id FROM playlists WHERE playlist_name = ? AND user_id = ?");
        $stmt->bind_param('si', $playlistName, $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $playlistId = $row['playlist_id'];

            // 刪除播放清單中的音樂
            $deleteSongsQuery = "DELETE FROM playlist_songs WHERE playlist_id = ?";
            $deleteSongsStmt = $link->prepare($deleteSongsQuery);
            $deleteSongsStmt->bind_param('i', $playlistId);
            if ($deleteSongsStmt->execute()) {
                // 刪除播放清單
                $deletePlaylistQuery = "DELETE FROM playlists WHERE playlist_id = ?";
                $deletePlaylistStmt = $link->prepare($deletePlaylistQuery);
                $deletePlaylistStmt->bind_param('i', $playlistId);
                if ($deletePlaylistStmt->execute()) {
                    // 顯示成功訊息並根據 user_id 導向不同的頁面
                    echo '<script>alert("播放清單刪除成功!");</script>';
                    if ($userId == 1) {
                        echo '<meta http-equiv="refresh" content="1;url=developer.php">';
                    } else {
                        echo '<meta http-equiv="refresh" content="1;url=client.php">';
                    }
                    exit;
                } else {
                    // 刪除播放清單失敗
                    echo '<script>alert("刪除播放清單失敗! Error: ' . $deletePlaylistStmt->error . '");</script>';
                    if ($userId == 1) {
                        echo '<meta http-equiv="refresh" content="0;url=developer.php">';
                    } else {
                        echo '<meta http-equiv="refresh" content="0;url=client.php">';
                    }
                    exit;
                }
            } else {
                // 刪除播放清單中的音樂失敗
                echo '<script>alert("刪除播放清單中的音樂失敗! Error: ' . $deleteSongsStmt->error . '");</script>';
                if ($userId == 1) {
                    echo '<meta http-equiv="refresh" content="0;url=developer.php">';
                } else {
                    echo '<meta http-equiv="refresh" content="0;url=client.php">';
                }
                exit;
            }
        } else {
            // 未找到對應的播放清單
            echo '<script>alert("未找到對應的播放清單!");</script>';
            if ($userId == 1) {
                echo '<meta http-equiv="refresh" content="0;url=developer.php">';
            } else {
                echo '<meta http-equiv="refresh" content="0;url=client.php">';
            }
            exit;
        }
    } else {
        // 無效的請求
        echo '<script>alert("無效的請求!");</script>';
        if ($userId == 1) {
            echo '<meta http-equiv="refresh" content="0;url=developer.php">';
        } else {
            echo '<meta http-equiv="refresh" content="0;url=client.php">';
        }
        exit;
    }

?>
