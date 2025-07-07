
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['playlist_id'])) {
        $playlistId = filter_input(INPUT_GET, 'playlist_id', FILTER_SANITIZE_NUMBER_INT);

        require_once('database.php');

        $playlist_query = "SELECT playlist_name FROM playlists WHERE playlist_id = ?";
        $stmt_playlist = $link->prepare($playlist_query);
        if ($stmt_playlist === false) {
            http_response_code(500);
            echo '準備查詢失敗: ' . htmlspecialchars($link->error);
            exit;
        }
        $stmt_playlist->bind_param("i", $playlistId);
        $stmt_playlist->execute();
        $playlist_result = $stmt_playlist->get_result();

        if ($playlist_result->num_rows > 0) {
            $playlist_row = $playlist_result->fetch_assoc();
            $playlist_name = $playlist_row['playlist_name'];

            echo '<div class="music-list">';
            echo '<div class="playlist-header">';
            echo '<h3 style="font-weight: bold; margin-bottom: 20px;">' . htmlspecialchars($playlist_name) . '</h3>';
            echo '<button id="playAllBtn" class="play-all-button">播放全部</button>';
            echo '</div>';

            $query = "SELECT s.songId, s.songName, singers.singer_name AS artistName, s.coverImage, s.songFile 
                    FROM songs s
                    INNER JOIN playlist_songs ps ON s.songId = ps.song_id
                    INNER JOIN singers ON s.singer_id = singers.singer_id
                    WHERE ps.playlist_id = ?
                    ORDER BY ps.position ASC";

            $stmt = $link->prepare($query);
            if ($stmt === false) {
                http_response_code(500);
                echo '準備查詢失敗: ' . htmlspecialchars($link->error);
                exit;
            }
            $stmt->bind_param("i", $playlistId);
            $stmt->execute();
            $result = $stmt->get_result();

            echo '<div class="music-container" id="playlistSongs">';

            if ($result->num_rows > 0) {       
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="music-item">';
                    echo '<div class="music-info">';
                    echo '<img src="' . htmlspecialchars($row['coverImage']) . '" alt="' . htmlspecialchars($row['songName']) . '" class="music-cover">';
                    echo '<img src="images/deletebutton.png" alt="Delete" class="delete-play-btn" data-songid="' . htmlspecialchars($row['songId']) . '">';
                    echo '<img src="images/playbutton.png" class="play-playlist-button" data-src="' . htmlspecialchars($row['songFile']) . '">';
                    echo '</div>';
                    echo '<h3 class="songName">' . htmlspecialchars($row['songName']) . '</h3>';
                    echo '<p class="artistName">' . htmlspecialchars($row['artistName']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p style="white-space: nowrap;">該播放清單內沒有任何音樂。</p>';
            }

            echo '</div>';
            echo '</div>';

            $stmt->close();
        } else {
            echo '<p>找不到該播放清單。</p>';
        }

        $stmt_playlist->close();
        $link->close();
    } else {
        http_response_code(400);
        echo '無效的請求';
    }
?>
