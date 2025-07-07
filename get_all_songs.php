
<?php
    require_once('database.php');

    $query = "SELECT * FROM songs";
    $result = $link->query($query);

    $songs = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $songs[] = [
                'songId' => $row['songId'],
                'songName' => htmlspecialchars($row['songName']),
                'artistName' => htmlspecialchars($row['artistName']),
                'coverImage' => htmlspecialchars($row['coverImage']),
                'songFile' => htmlspecialchars($row['songFile'])
            ];
        }
    }

    echo json_encode(['songs' => $songs]);
?>
