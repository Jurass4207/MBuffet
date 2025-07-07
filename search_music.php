<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once('database.php');

        $keyword = $_POST['keyword'];

        $query = "SELECT * FROM songs WHERE songName LIKE '%$keyword%' OR artistName LIKE '%$keyword%'";
        $result = $link->query($query);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="music-item">';
                echo '<div class="music-info">';
                echo '<img src="' . $row['coverImage'] . '" alt="' . $row['songName'] . '" class="music-cover">';
                echo '<img src="images/playbutton.png" class="play-button" data-src="' . $row['songFile'] . '">';
                echo '</div>';
                echo '<h3 class="songName">' . $row['songName'] . '</h3>';
                echo '<p class="artistName">' . $row['artistName'] . '</p>';
                echo '</div>';
            }
        } else {
            echo '沒有找到任何符合搜尋的音樂。';
        }

        $link->close();
    }
?>