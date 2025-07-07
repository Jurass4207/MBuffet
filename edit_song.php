
<?php
    require_once('database.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['editSongId']) && isset($_POST['editSongName']) && isset($_POST['editArtistName'])) {
            $editSongId = $_POST['editSongId'];
            $editSongName = $_POST['editSongName'];
            $editArtistName = $_POST['editArtistName'];
            
            // 檢查是否上傳了新的封面圖片
            if (!empty($_FILES['editCoverImage']['name'])) {
                $editCoverImage = $_FILES['editCoverImage'];
                $editCoverImagePath = 'uploads/' . basename($editCoverImage['name']);
                move_uploaded_file($editCoverImage['tmp_name'], $editCoverImagePath);
            }

            // 檢查是否上傳了新的歌曲檔案
            if (!empty($_FILES['editSongFile']['name'])) {
                $editSongFile = $_FILES['editSongFile'];
                $editSongFilePath = 'songs/' . basename($editSongFile['name']);
                move_uploaded_file($editSongFile['tmp_name'], $editSongFilePath);
            }

            // 構建更新查詢
            if (!empty($_FILES['editCoverImage']['name']) && !empty($_FILES['editSongFile']['name'])) {
                $update_query = "UPDATE songs SET songName=?, singer_id=?, coverImage=?, songFile=? WHERE songId=?";
                $stmt = $link->prepare($update_query);
                $stmt->bind_param("sissi", $editSongName, $editArtistName, $editCoverImagePath, $editSongFilePath, $editSongId);
            } elseif (!empty($_FILES['editCoverImage']['name'])) {
                $update_query = "UPDATE songs SET songName=?, singer_id=?, coverImage=? WHERE songId=?";
                $stmt = $link->prepare($update_query);
                $stmt->bind_param("sisi", $editSongName, $editArtistName, $editCoverImagePath, $editSongId);
            } elseif (!empty($_FILES['editSongFile']['name'])) {
                $update_query = "UPDATE songs SET songName=?, singer_id=?, songFile=? WHERE songId=?";
                $stmt = $link->prepare($update_query);
                $stmt->bind_param("sisi", $editSongName, $editArtistName, $editSongFilePath, $editSongId);
            } else {
                $update_query = "UPDATE songs SET songName=?, singer_id=? WHERE songId=?";
                $stmt = $link->prepare($update_query);
                $stmt->bind_param("sii", $editSongName, $editArtistName, $editSongId);
            }

            if ($stmt->execute()) {
                echo '<script>alert("歌曲資料更新成功！");</script>';
                echo '<meta http-equiv="refresh" content="0;url=developer.php">';
                exit;
            } else {
                echo '<script>alert("歌曲資料更新失敗！' . $link->error . '");</script>';
            }
        } else {
            echo '<script>alert("請填寫完整的表單！");</script>';
        }
    }
    $link->close();
?>
