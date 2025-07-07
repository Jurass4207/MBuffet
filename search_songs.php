
<?php
    require_once('database.php');

    if (isset($_GET['query'])) {
        $searchQuery = "%" . $link->real_escape_string($_GET['query']) . "%";
        $query = "
            SELECT s.songId, s.songName, s.coverImage, s.songFile, si.singer_name 
            FROM songs s
            JOIN singers si ON s.singer_id = si.singer_id
            WHERE s.songName LIKE ? OR si.singer_name LIKE ?";
        $stmt = $link->prepare($query);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($link->error));
        }
        $stmt->bind_param("ss", $searchQuery, $searchQuery);
        $stmt->execute();
        $result = $stmt->get_result();

        $songs = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $songs[] = [
                    'songId' => $row['songId'],
                    'songName' => htmlspecialchars($row['songName']),
                    'coverImage' => htmlspecialchars($row['coverImage']),
                    'songFile' => htmlspecialchars($row['songFile']),
                    'singer_name' => htmlspecialchars($row['singer_name']),
                ];
            }
        }
        echo json_encode($songs);
    }
?>
