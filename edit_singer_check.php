
<?php
    require_once('database.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $singerToEdit = $_POST['singerToEdit'];
        $newSingerName = $_POST['editSingerName'];

        // 開始一個事務
        $link->begin_transaction();

        try {
            // 更新歌手表中的名稱
            $updateSingerQuery = "UPDATE singers SET singer_name = ? WHERE singer_id = ?";
            if ($updateSingerStmt = $link->prepare($updateSingerQuery)) {
                $updateSingerStmt->bind_param("si", $newSingerName, $singerToEdit);
                if ($updateSingerStmt->execute()) {
                    echo '<script>alert("歌手或樂團名稱已成功編輯！");</script>';
                    echo '<meta http-equiv="refresh" content="0;url=developer.php">';
                } else {
                    throw new Exception("編輯失敗！");
                }
                $updateSingerStmt->close();
            } else {
                throw new Exception("編輯失敗！");
            }

            // 提交事務
            $link->commit();
        } catch (Exception $e) {
            // 回滾事務
            $link->rollback();
            echo '<script>alert("' . $e->getMessage() . '");</script>';
            echo '<meta http-equiv="refresh" content="0;url=developer.php">';
        }

        $link->close();
    } else {
        echo '<script>alert("無效的請求！");</script>';
        echo '<meta http-equiv="refresh" content="0;url=developer.php">';
    }
?>