
<?php
    require_once('database.php');
    if (isset($_GET['songId'])) {
        $songId = $_GET['songId'];
    
        $query = "SELECT songId, songName, singer_id FROM songs WHERE songId = ?";
        if ($stmt = $link->prepare($query)) {
            $stmt->bind_param("i", $songId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                echo json_encode($data);
            } else {
                echo json_encode(['error' => '歌曲未找到']);
            }
            $stmt->close();
        } else {
            echo json_encode(['error' => '準備語句失敗']);
        }
    } else {
        echo json_encode(['error' => '缺少參數songId']);
    }
?>
