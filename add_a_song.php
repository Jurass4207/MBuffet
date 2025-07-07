
<?php
    require_once('database.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $songName = $_POST['songName'];
        $artistId = $_POST['artistName'];
        $coverImage = $_FILES['coverImage'];
        $songFile = $_FILES['songFile'];

        $coverImagePath = 'uploads/' . basename($coverImage['name']);
        move_uploaded_file($coverImage['tmp_name'], $coverImagePath);

        $songFilePath = 'uploads/' . basename($songFile['name']);
        move_uploaded_file($songFile['tmp_name'], $songFilePath);

        $query = "INSERT INTO songs (songName, singer_id, coverImage, songFile, created_at) VALUES (?, ?, ?, ?, NOW())";
        if ($stmt = $link->prepare($query)) {
            $stmt->bind_param("siss", $songName, $artistId, $coverImagePath, $songFilePath);

            if ($stmt->execute()) {
                echo '<script>alert("資料成功插入到資料庫中！");</script>';
                echo '<meta http-equiv="refresh" content="0;url=developer.php">'; // 0 秒後導向 developer.php
                exit;
            } else {
                echo '<script>alert("資料插入失敗！' . $link->error . '");</script>';
            }

            $stmt->close();
        } else {
            echo '<script>alert("請填寫完整的表單！");</script>';
        }

        $link->close();
    }
?>
