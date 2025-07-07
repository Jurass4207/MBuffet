
<?php
    session_start();
    require_once('database.php');

    if (isset($_POST['songId']) && isset($_POST['playlists'])) {
        $songId = $_POST['songId'];
        $playlistName = $_POST['playlists'];

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

            // 檢查歌曲是否已存在於播放清單中
            $checkStmt = $link->prepare("SELECT * FROM playlist_songs WHERE playlist_id = ? AND song_id = ?");
            $checkStmt->bind_param('ii', $playlistId, $songId);
            $checkStmt->execute();
            $checkResult = $checkStmt->get_result();

            if ($checkResult->num_rows == 0) {
                // 查詢目前播放清單中的歌曲數量
                $countStmt = $link->prepare("SELECT COUNT(*) AS song_count FROM playlist_songs WHERE playlist_id = ?");
                $countStmt->bind_param('i', $playlistId);
                $countStmt->execute();
                $countResult = $countStmt->get_result();
                $countRow = $countResult->fetch_assoc();
                $position = $countRow['song_count'] + 1;

                // 將歌曲加入播放清單並設定 position
                $insertStmt = $link->prepare("INSERT INTO playlist_songs (playlist_id, song_id, position) VALUES (?, ?, ?)");
                $insertStmt->bind_param('iii', $playlistId, $songId, $position);
                if ($insertStmt->execute()) {
                    $successMessage = "歌曲成功加入播放清單!";
                } else {
                    $errorMessage = "歌曲加入播放清單失敗!";
                }
            } else {
                $errorMessage = "歌曲已存在於播放清單中!";
            }

            $checkStmt->close();
        } else {
            $errorMessage = "播放清單不存在!";
        }

        $stmt->close();
    } else {
        $errorMessage = "無效的請求!";
    }

    // 根據使用者 ID 導向不同頁面並顯示相應訊息
    if ($userId == 1) {
        $redirectUrl = "developer.php";
    } else {
        $redirectUrl = "client.php";
    }

    if (isset($successMessage)) {
        echo "<script>alert('$successMessage'); window.location.href = '$redirectUrl';</script>";
    } elseif (isset($errorMessage)) {
        echo "<script>alert('$errorMessage'); window.location.href = '$redirectUrl';</script>";
    }
?>
