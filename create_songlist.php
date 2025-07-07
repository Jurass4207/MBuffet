
<?php
    session_start();
    require_once('database.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['SongListName'])) {
            $songListName = trim($_POST['SongListName']);
            $accountId = $_SESSION['user_id'];

            if (empty($songListName)) {
                echo '<script>alert("播放清單名稱不能為空白。");</script>';
                exit;
            }

            $check_query = "SELECT * FROM playlists WHERE playlist_name = ? AND user_id = ?";
            $stmt = $link->prepare($check_query);
            $stmt->bind_param("si", $songListName, $accountId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                echo '<script>alert("此播放清單名稱已存在。");</script>';
            } else {
                // 執行新增播放清單的 SQL 指令
                $insert_query = "INSERT INTO playlists (playlist_name, user_id) VALUES (?, ?)";
                $stmt = $link->prepare($insert_query);
                $stmt->bind_param("si", $songListName, $accountId);

                if ($stmt->execute()) {
                    // 新增播放清單成功
                    echo '<script>alert("播放清單已成功建立。");</script>';
                } else {
                    // 新增播放清單失敗
                    echo '<script>alert("建立播放清單失敗。");</script>';
                }
            }

            $stmt->close();

            // 根據用戶ID決定導向的頁面
            if ($accountId == 1) {
                echo '<meta http-equiv="refresh" content="0;url=developer.php">'; // 導向 developer.php
            } else {
                echo '<meta http-equiv="refresh" content="0;url=client.php">'; // 導向 client.php
            }
        } else {
            // SongListName 未設置
            echo '<script>alert("未提供播放清單名稱。");</script>';
            echo '<meta http-equiv="refresh" content="0;url=developer.php">'; // 0 秒後導向 developer.php
        }
    } else {
        // 不是 POST 請求
        echo '<script>alert("請使用 POST 請求。");</script>';
    }

    $link->close();
?>
