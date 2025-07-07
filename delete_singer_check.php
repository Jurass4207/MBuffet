
<?php
require_once('database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $singerToDelete = $_POST['singerToDelete'];

    // 檢查是否有相關聯的歌曲
    $checkSongsQuery = "SELECT 1 FROM songs WHERE singer_id = ?";
    if ($checkStmt = $link->prepare($checkSongsQuery)) {
        $checkStmt->bind_param("i", $singerToDelete);
        $checkStmt->execute();
        $checkResult = $checkStmt->get_result();

        if ($checkResult->num_rows > 0) {
            // 有相關聯的歌曲，顯示確認視窗
            echo '<script>';
            echo 'if(confirm("刪除此歌手或樂團可能會導致相關歌曲全部被移除，確定嗎?")) {';
            echo 'window.location.href = "delete_singer.php?singerToDelete=' . $singerToDelete . '";';
            echo '} else {';
            echo 'window.location.href = "developer.php";';
            echo '}';
            echo '</script>';
        } else {
            // 沒有相關聯的歌曲，直接刪除
            $query = "DELETE FROM singers WHERE singer_id = ?";
            if ($stmt = $link->prepare($query)) {
                $stmt->bind_param("i", $singerToDelete);
                if ($stmt->execute()) {
                    echo '<script>alert("歌手或樂團名稱已成功刪除！");</script>';
                    echo '<meta http-equiv="refresh" content="0;url=developer.php">';
                } else {
                    echo '<script>alert("刪除失敗！");</script>';
                    echo '<meta http-equiv="refresh" content="0;url=developer.php">';
                }
                $stmt->close();
            } else {
                echo '<script>alert("刪除失敗！");</script>';
                echo '<meta http-equiv="refresh" content="0;url=developer.php">';
            }
        }
    } else {
        echo '<script>alert("刪除失敗！");</script>';
        echo '<meta http-equiv="refresh" content="0;url=developer.php">';
    }

    $link->close();
}
?>
