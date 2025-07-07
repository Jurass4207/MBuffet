<?php
    session_start();
    require_once('database.php');

    // 检查用户是否登录
    if (isset($_SESSION['account']) && isset($_SESSION['user_id'])) {
        $account = $_SESSION['account'];    
        $user_id = $_SESSION['user_id'];
        $welcome_message = "你好! $account!";
    } else {
        header('Location: index.php');
        exit;
    }
    // 获取用户列表
    $user_query = "SELECT * FROM accounts"; // 此處改為資料表名稱 accounts
    $user_result = $link->query($user_query);

    $users = [];
    if ($user_result->num_rows > 0) {
        while ($row = $user_result->fetch_assoc()) {
            $users[] = [
                'user_id' => $row['member_id'], // 此處改為資料表欄位名稱 member_id
                'account' => htmlspecialchars($row['account']), // 此處改為資料表欄位名稱 account
                'password' => $row['password'],
            ];
        }
    }
    // 获取播放清单
    $playlist_query = "
        SELECT p.playlist_id, p.playlist_name, COUNT(ps.song_id) AS song_count
        FROM playlists p
        LEFT JOIN playlist_songs ps ON p.playlist_id = ps.playlist_id
        WHERE p.user_id = ?
        GROUP BY p.playlist_id, p.playlist_name
    ";
    $stmt = $link->prepare($playlist_query);
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($link->error));
    }
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $playlists = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $playlists[] = [
                'playlist_id' => $row['playlist_id'],
                'playlist_name' => htmlspecialchars($row['playlist_name']),
                'song_count' => htmlspecialchars($row['song_count'])
            ];
        }
    }
    // 設置分頁相關變數
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // 從 URL 參數獲取當前頁數，默認為第一頁
    $records_per_page = 4; // 每頁顯示的記錄數
    $offset = ($page - 1) * $records_per_page; // 計算偏移量

    // 從資料庫中獲取指定範圍的資料
    $query = "SELECT * FROM songs LIMIT $offset, $records_per_page";
    $result = $link->query($query);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // 顯示資料
        }
    } else {
        echo '沒有找到任何音樂。';
    }

    // 計算總頁數
    $total_pages_query = "SELECT COUNT(*) AS total FROM songs";
    $total_pages_result = $link->query($total_pages_query);
    $total_pages_row = $total_pages_result->fetch_assoc();

    $total_pages = ceil($total_pages_row['total'] / $records_per_page);
    $singerQuery = "SELECT singer_id, singer_name FROM singers";
    $singerResult = $link->query($singerQuery);
    $singers = [];

    if ($singerResult->num_rows > 0) {
        while($singerRow = $singerResult->fetch_assoc()) {
            $singers[] = $singerRow;
        }
    }
?>
<!DOCTYPE html>
<html lang="zh-TW">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="developer.css">
        <link rel="stylesheet" href="public.css">
        <link rel="icon" type="image/png" href="images/icon.png">
        <title>MBuffet</title>
    </head>
    <body>
        <h2 class="mode">𝄞管理員模式</h2>
        <a href="developer.php" class="main-icon"><img src="images/icon.PNG" alt="圖片"></a>
        <div class="top-bar bar"></div>
        <div class="top-left-bar bar"></div>
        <div class="left-bar bar"></div>
        <div class="welcome-word"><?php echo $welcome_message; ?></div>
        <div class="hint-word">以下部分可上下滑動↓</div>
        <div><!-- 右上角人物頭像相關 -->
            <img src="images/head.png" alt="頭像" class="user-avatar" id="userAvatar">
            <div class="userinfo-popup" id="userinfoPopup">
                <p id="usernameDisplay"></p>
                <hr style="border-top: 1px solid #000;">
                <button id="logoutBtn" class="logoutBtn">登出</button>
            </div>
        </div>
        <!-- 底部播放器相關 -->
        <div class="music-player-container">
            <img src="" class="bottom-music-cover">
            <div class="music-details-container">
                <h4 class="songName bottom-songName"> </h4>
                <p class="artistName bottom-artistName"> </p>
            </div>
            <button id="prevSongBtn" class="prevSong-btn Song-list-control-btn">上一首歌</button>
            <button id="nextSongBtn" class="nextSong-btn Song-list-control-btn">下一首歌</button>
            <audio id="musicPlayer" controls class="music-player"></audio>
        </div>
        <!-- 菜單按鈕 -->
        <div class="container-fluid">
            <div class="col-12">
                <div id="showMusicButton" class="menu showMusiclist-button">• 音樂列表</div>
                <div id="addNewSinger" class="menu add-new-singer-button">• 新增歌手或樂團名稱</div>
                <div id="editSinger" class="menu edit-singer-button">• 編輯歌手或樂團名稱</div>
                <div id="deleteSinger" class="menu delete-singer-button">• 刪除歌手或樂團名稱</div>
                <div id="showFormButton" class="menu show-form-button">• 新增歌曲</div>
                <div id="createPlaylistButton" class="menu createPlaylist-button">• 建立播放清單</div>
                <div id="deletePlaylistButton" class="menu deletePlaylist-button">• 刪除播放清單</div>
                <div id="checkPlaylistButton" class="menu checkPlaylist-button">• 檢視播放清單</div>
                <div id="showUsersButton" class="menu control-users-button">• 管理使用者帳號</div>
            </div>
        </div>
        <!-- 加入播放清單表單 -->
        <div class="add-to-playlist-form songinfo-form" id="addToPlaylistForm" style="display: none;">
            <form method="POST" action="add_to_playlist.php" enctype="multipart/form-data">
                <input type="hidden" name="songId" id="songId"> 
                <label for="playlists">選擇播放清單:</label>
                <select id="playlists" name="playlists" class="form-control" required>
                    <?php foreach ($playlists as $playlist): ?>
                        <option value="<?php echo htmlspecialchars($playlist['playlist_name']); ?>"><?php echo htmlspecialchars($playlist['playlist_name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="form-button">加入</button>
            </form>
        </div>
        <!-- 編輯歌曲 -->
        <div class="edit-songinfo-form songinfo-form" id="editSongModal" tabindex="-1" role="dialog" aria-labelledby="editSongModalLabel" aria-hidden="true">
            <form id="editSongForm" method="POST" action="edit_song.php" enctype="multipart/form-data">
                <h5 style="font-weight: bold;">編輯歌曲</h5>
                <div class="input-row" for="editSongName">要改成甚麼歌曲名稱?</div>
                <div class="input-row"><input type="text" id="editSongName" name="editSongName" placeholder="歌曲名稱" style="width: 100%;" required></div>
                <div class="input-row" for="editArtistName">要改成甚麼歌手或樂團名稱?</div>    
                <div class="input-row">
                    <select id="editArtistName" name="editArtistName" style="width: 100%;" required>
                        <?php
                        require_once('database.php');
                        $query = "SELECT singer_id, singer_name FROM singers";
                        $result = $link->query($query);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['singer_id'] . '">' . $row['singer_name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
                <div class="input-row" for="editCoverImage">歌曲封面圖片<span style="color: #999;">(非必填)</span></div>    
                <div class="input-row"><input type="file" id="editCoverImage" name="editCoverImage" accept="image/*"></div>
                <div class="input-row" for="editSongFile">歌曲檔案<span style="color: #999;">(非必填)</span></div>    
                <div class="input-row"><input type="file" id="editSongFile" name="editSongFile" accept="audio/mpeg"></div>
                <input type="hidden" id="editSongId" name="editSongId">
                <button type="submit" class="form-button">提交</button>
            </form>
        </div>
        <!-- 音樂列表區塊 -->
        <div class="music-list">
            <h2 style="font-weight: bold;">音樂列表</h2>
            <div class="search-container">
                <div class="searchicon">🔍</div>
                <input type="text" id="searchInput" placeholder="搜尋">
            </div>
            <div id="globalSongList" class="music-container">
            <?php
                // 設置分頁相關變數
                $page = isset($_GET['page']) ? $_GET['page'] : 1; // 從 URL 參數獲取當前頁數，默認為第一頁
                $records_per_page = 21; // 每頁顯示的記錄數
                $offset = ($page - 1) * $records_per_page; // 計算偏移量

                // 從資料庫中獲取指定範圍的資料
                $query = "
                    SELECT s.songId, s.songName, s.coverImage, s.songFile, si.singer_name 
                    FROM songs s
                    JOIN singers si ON s.singer_id = si.singer_id
                    LIMIT $offset, $records_per_page";
                $result = $link->query($query);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo '<div class="music-item">';
                        echo '<div class="music-info">';
                        echo '<button style="float:left;" class="add-to-playlist-btn" data-songid="' . $row['songId'] . '">加入播放清單</button>';
                        echo '<button style="float:right;" class="edit-song-btn" data-songid="' . $row['songId'] . '">編輯</button>';
                        echo '<img src="' . $row['coverImage'] . '" alt="' . $row['songName'] . '" class="music-cover">';
                        echo '<img src="images/deletebutton.png" alt="Delete" class="delete-btn" data-songid="' . $row['songId'] . '">';
                        echo '<img src="images/playbutton.png" class="play-button" data-src="' . $row['songFile'] . '">';
                        echo '</div>';
                        echo '<h3 class="songName">' . $row['songName'] . '</h3>';
                        echo '<p class="artistName">' . $row['singer_name'] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '沒有找到任何音樂。';
                }
            ?>
            </div>
            <!-- 顯示分頁控制按鈕 -->
            <div class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <a href="developer.php?page=<?php echo $i; ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>
            </div>
        </div>
        <!-- 新增歌手或樂團名稱 -->
        <div class="add-singer-form songinfo-form">
            <form method="POST"  action="add_singer.php" enctype="multipart/form-data">
                <h5 style="font-weight: bold;">新增歌手或樂團名稱</h5>
                <div class="input-row">歌手或樂團名稱:</div>
                <div class="input-row"><input type="text" id="singerName" name="singerName" placeholder="歌手或樂團名稱" style="width: 100%;" required></div>
                <input type="submit" value="新增" class="form-button">
            </form>
        </div>
        <!-- 編輯歌手或樂團名稱 -->
        <div class="edit-singer-form songinfo-form">
            <form method="POST" action="edit_singer_check.php" enctype="multipart/form-data">
                <h5 style="font-weight: bold;">編輯歌手或樂團名稱</h5>
                <div class="input-row">選擇要編輯的歌手或樂團名稱:</div>
                <div class="input-row">
                    <select name="singerToEdit" id="singerToEdit    e" required>
                        <?php foreach ($singers as $singer): ?>
                            <option value="<?php echo htmlspecialchars($singer['singer_id']); ?>"><?php echo htmlspecialchars($singer['singer_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-row">要更改成的歌手或樂團名稱:</div>
                <div class="input-row"><input type="text" id="editSingerName" name="editSingerName" placeholder="歌手或樂團名稱" style="width: 100%;" required></div>
                <input type="submit" value="編輯" class="form-button">
            </form>
        </div>
        <!-- 刪除歌手或樂團名稱 -->
        <div class="delete-singer-form songinfo-form">
            <form method="POST" action="delete_singer_check.php" enctype="multipart/form-data">
                <h5 style="font-weight: bold;">刪除歌手或樂團名稱</h5>
                <div class="input-row">選擇要刪除歌手或樂團名稱:</div>
                <div class="input-row">
                    <select name="singerToDelete" id="singerToDelete" required>
                        <?php foreach ($singers as $singer): ?>
                            <option value="<?php echo htmlspecialchars($singer['singer_id']); ?>"><?php echo htmlspecialchars($singer['singer_name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <input type="submit" value="刪除" class="form-button">
            </form>
        </div>
        <!-- 新增歌曲 -->
        <div class="input-songinfo-form songinfo-form">
            <form method="POST" enctype="multipart/form-data">
                <h5 style="font-weight: bold;">新增歌曲</h5>
                <div class="input-row">歌曲名稱:</div>
                <div class="input-row"><input type="text" id="songName" name="songName" placeholder="歌曲名稱" style="width: 100%;" required></div>
                <div class="input-row">歌手或樂團名稱:</div>
                <div class="input-row">
                    <select id="artistName" name="artistName" style="width: 100%;" required>
                        <option value="">選擇歌手或樂團</option>
                        <?php
                            foreach ($singers as $singer) {
                                echo '<option value="' . $singer['singer_id'] . '">' . $singer['singer_name'] . '</option>';
                            }
                        ?>
                    </select>
                </div>
                <div class="input-row">歌曲封面圖片:</div>
                <div class="input-row"><input type="file" id="coverImage" name="coverImage" accept="image/*" required></div>
                <div class="input-row">歌曲檔案:</div>
                <div class="input-row"><input type="file" id="songFile" name="songFile" accept="audio/mpeg" required></div>
                <input type="submit" value="新增" class="form-button">
                <?php
                    require_once('add_a_song.php');
                ?>
            </form>
        </div>
        <!-- 建立播放清單 -->
        <div class="create-songlist-form songinfo-form">
            <form id="CreateSongList-form" method="POST" action="create_songlist.php" enctype="multipart/form-data">
                <h5 style="font-weight: bold;">要建立的播放清單</h5>
                <div class="input-row" for="SongListName">播放清單名稱</div>
                <div class="input-row"><input type="text" id="SongListName" name="SongListName" placeholder="播放清單名稱" style="width: 100%;" required></div>
                <button type="submit" class="form-button">建立</button>
                <div id="existingPlaylists" style="margin-top: 20px;">
                    <h5 style="font-weight: bold;">目前已有的播放清單</h5>
                    <ul id="playlistList">
                        <?php
                            if (!empty($playlists)) {
                                foreach ($playlists as $playlist) {
                                    echo "<li>{$playlist['playlist_name']}</li>";
                                }
                            } else {
                                echo '<li>沒有任何播放清單。</li>';
                            }
                        ?>
                    </ul>
                </div>
            </form>
        </div>
        <!-- 刪除播放清單 -->
        <div class="delete-songlist-form songinfo-form">
            <form id="DeleteSongList-form" method="POST" action="delete_playlist.php" enctype="multipart/form-data">
                <h5 style="font-weight: bold;">刪除播放清單</h5>
                <input type="hidden" id="deleteSonglistId" name="deleteSonglistId">
                <label for="deletePlaylists">選擇要刪除播放清單:</label>
                <select id="deletePlaylists" name="playlistName" class="form-control" required>
                    <?php foreach ($playlists as $playlist): ?>
                        <option value="<?php echo htmlspecialchars($playlist['playlist_name']); ?>"><?php echo htmlspecialchars($playlist['playlist_name']); ?></option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="form-button">刪除</button>
            </form>
        </div>
        <!-- 檢視播放清單 -->
        <div id="playlistContainer" class="playlist-list">
            <h2 style="font-weight: bold; margin-bottom: 20px;">音樂播放清單</h2>
            <div class="playlist-container">
                <?php if (!empty($playlists)): ?>
                    <div class="playlist-items">
                        <?php foreach ($playlists as $playlist): ?>
                            <div class="playlist-item">
                                <h4 class="playlist-name"><?php echo $playlist['playlist_name']; ?></h4>
                                <p class="song-count">歌曲數量：<?php echo $playlist['song_count']; ?> 首</p>
                                <button id="show-playlistdetail-button" class="show-playlistdetail-button" data-playlistid="<?php echo $playlist['playlist_id']; ?>">查看播放清單</button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>沒有找到任何播放清单。</p>
                <?php endif; ?>
            </div>
        </div>
        <!-- 詳細檢視播放清單 -->
        <div id="playlistDetailContainer" class="playlist-detail-container" style="display: none;">
            <div id="playlistDetailContent" class="playlist-detail-content">
                <!-- 這裡會動態添加播放清單的詳細內容 -->
            </div>
        </div>
        <!-- 管理使用者帳號區塊 -->
        <div id="accountContainer" class="account-container">
            <h2 style="font-weight: bold; margin-bottom: 20px;">使用者帳號列表</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>使用者 ID</th>
                        <th>帳號或使用者名稱</th>
                        <th>密碼</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo $user['user_id']; ?></td>
                            <td><?php echo $user['account']; ?></td>
                            <td><?php echo $user['password']; ?></td>
                            <td>
                                <?php if ($user['account'] !== 'root'): ?>
                                    <button class="btn btn-primary editUserButton" data-userid="<?php echo $user['user_id']; ?>">編輯</button>
                                    <button class="btn btn-danger deleteUserButton" data-userid="<?php echo $user['user_id']; ?>">刪除</button>
                                <?php else: ?>
                                    <span class="adminTag">管理員</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div id="editUserForm" class="edit-user-form songinfo-form" style="display: none;">
            <form method="POST" action="edit_user.php">
                <h5 style="font-weight: bold;">編輯使用者</h5>
                <div class="input-row" for="editUserName">帳號或使用者名稱</div>
                <div class="input-row"><input type="text" id="editUserName" name="editUserName" placeholder="帳號或使用者名稱" style="width: 100%;" required></div>
                <div class="input-row" for="editPassWord">密碼</div>
                <div class="input-row"><input type="password" id="editPassWord" name="editPassWord" placeholder="密碼" style="width: 100%;" required></div>
                <input type="hidden" id="editUserId" name="editUserId">
                <button type="submit" class="form-button">提交</button>
            </form>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="developer.js"></script>
    </body>
</html>