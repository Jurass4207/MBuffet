
<?php
    require_once('database.php');
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $singerName = $_POST['singerName'];
        $query = "INSERT INTO singers (singer_name, create_time) VALUES (?, NOW())";
        if ($stmt = $link->prepare($query)) {
            $stmt->bind_param("s", $singerName);

            if ($stmt->execute()) {
                echo '<script>alert("新歌手或樂團名稱已成功添加！");</script>';
                echo '<meta http-equiv="refresh" content="0;url=developer.php">'; // 0 秒後導向 developer.php
            } else {
                echo '<script>alert("添加失敗！");</script>';
                echo '<meta http-equiv="refresh" content="0;url=developer.php">';
            }

            $stmt->close();
        } else {
            echo '<script>alert("添加失敗！");</script>';
            echo '<meta http-equiv="refresh" content="0;url=developer.php">';
        }
        $link->close();
    }
?>
