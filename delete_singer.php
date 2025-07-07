
<?php
require_once('database.php');

if (isset($_GET['singerToDelete'])) {
    $singerToDelete = $_GET['singerToDelete'];

    // 刪除相關聯的歌曲
    $deleteSongsQuery = "DELETE FROM songs WHERE singer_id = ?";
    if ($deleteSongsStmt = $link->prepare($deleteSongsQuery)) {
        $deleteSongsStmt->bind_param("i", $singerToDelete);
        $deleteSongsStmt->execute();
        $deleteSongsStmt->close();
    }

    // 刪除歌手或樂團
    $deleteSingerQuery = "DELETE FROM singers WHERE singer_id = ?";
    if ($deleteSingerStmt = $link->prepare($deleteSingerQuery)) {
        $deleteSingerStmt->bind_param("i", $singerToDelete);
        if ($deleteSingerStmt->execute()) {
            echo '<script>alert("歌手或樂團名稱及相關歌曲已成功刪除！");</script>';
            echo '<meta http-equiv="refresh" content="0;url=developer.php">';
        } else {
            echo '<script>alert("刪除失敗！");</script>';
            echo '<meta http-equiv="refresh" content="0;url=developer.php">';
        }
        $deleteSingerStmt->close();
    } else {
        echo '<script>alert("刪除失敗！");</script>';
        echo '<meta http-equiv="refresh" content="0;url=developer.php">';
    }

    $link->close();
} else {
    echo '<script>alert("無效的請求！");</script>';
    echo '<meta http-equiv="refresh" content="0;url=developer.php">';
}
?>

