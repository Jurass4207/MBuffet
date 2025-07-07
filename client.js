// 右上角人物頭像相關
document.addEventListener('DOMContentLoaded', function() {
    var userAvatar = document.getElementById('userAvatar');
    var userinfoPopup = document.getElementById('userinfoPopup');
    var usernameDisplay = document.getElementById('usernameDisplay');
    var logoutBtn = document.getElementById('logoutBtn');
    var username = '<?php echo $account; ?>';
    var timeoutID;

    // 顯示用戶名和彈出視窗
    function showUserInfo() {
        clearTimeout(timeoutID);
        usernameDisplay.innerHTML = ' 歡迎回來！<br>' + username;
        userinfoPopup.style.display = 'block';
    }

    // 隱藏彈出視窗
    function hideUserInfo() {
        timeoutID = setTimeout(function() {
            userinfoPopup.style.display = 'none';
        }, 300);
    }

    userAvatar.addEventListener('mouseenter', showUserInfo);
    userAvatar.addEventListener('mouseleave', hideUserInfo);
    userinfoPopup.addEventListener('mouseenter', function() {
        clearTimeout(timeoutID);
    });
    userinfoPopup.addEventListener('mouseleave', hideUserInfo);
    userinfoPopup.addEventListener('click', function(event) {
        event.stopPropagation();
    });
    logoutBtn.addEventListener('click', function() {
        window.location.href = 'index.php';
    });
    document.addEventListener('click', hideUserInfo);
});
// 搜尋按鈕相關
document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('searchInput');
    searchInput.addEventListener('input', function() {
        var searchText = searchInput.value.trim().toLowerCase();
        if (searchText.length > 0) {
            fetch('search_songs.php?query=' + encodeURIComponent(searchText))
                .then(response => response.json())
                .then(songs => {
                    var musicContainer = document.getElementById('globalSongList');
                    musicContainer.innerHTML = '';
                    songs.forEach(song => {
                        var songItem = document.createElement('div');
                        songItem.className = 'music-item';
                        songItem.innerHTML = `
                            <div class="music-info">
                                <img src="${song.coverImage}" alt="${song.songName}" class="music-cover">
                            </div>
                            <h3 class="songName">${song.songName}</h3>
                            <p class="artistName">${song.singer_name}</p>
                        `;
                        musicContainer.appendChild(songItem);
                    });
                })
                .catch(error => {
                    console.error('Error fetching songs:', error);
                });
        } else {
            // 重新加载当前页的歌曲
            window.location.reload();
        }
    });
});
// 顯示歌曲清單控制
document.addEventListener('DOMContentLoaded', function() {
    var showMusicButton = document.getElementById('showMusicButton');
    var checkPlaylistButton = document.getElementById('checkPlaylistButton');
    var playlistContainer = document.getElementById('playlistContainer');
    var musicList = document.querySelector('.music-list');
    var showUsersButton = document.getElementById('showUsersButton');
    var accountContainer = document.getElementById('accountContainer');
    showMusicButton.style.color = 'lightblue';
    musicList.style.display = 'grid';
    showMusicButton.addEventListener('click', function() {
        playlistContainer.style.display = 'none';
        checkPlaylistButton.style.color = '#000';
        accountContainer.style.display = 'none';
        showUsersButton.style.color = '#000';
        if (musicList.style.display === 'none') {
            musicList.style.display = 'grid';
            showMusicButton.style.color = 'lightblue';
        } else {
            musicList.style.display = 'none';
            showMusicButton.style.color = '#000';
        }
    });
});

// 建立播放清單顯示控制
document.addEventListener('DOMContentLoaded', function() {
    var createPlaylistButton = document.getElementById('createPlaylistButton');
    var createSonglistForm = document.querySelector('.create-songlist-form');
    createPlaylistButton.addEventListener('click', function() {
        // 切換表單的顯示狀態
        if (createSonglistForm.style.display === 'block') {
            createSonglistForm.style.display = 'none';
            createPlaylistButton.style.color = '#000';
        } else {
            createSonglistForm.style.display = 'block';
            createPlaylistButton.style.color = 'lightblue';
        }
    });
    document.addEventListener('click', function(event) {
        var targetElement = event.target;
        if (!createSonglistForm.contains(targetElement) && targetElement !== createPlaylistButton) {
            createSonglistForm.style.display = 'none';
            createPlaylistButton.style.color = '#000';
        }
    });
});
// 刪除播放清單顯示控制
document.addEventListener('DOMContentLoaded', function() {
    var deletePlaylistButton = document.getElementById('deletePlaylistButton');
    var deleteSonglistForm = document.querySelector('.delete-songlist-form');
    deletePlaylistButton.addEventListener('click', function() {
        // 切換表單的顯示狀態
        if (deleteSonglistForm.style.display === 'block') {
            deleteSonglistForm.style.display = 'none';
            deletePlaylistButton.style.color = '#000';
        } else {
            deleteSonglistForm.style.display = 'block';
            deletePlaylistButton.style.color = 'lightcoral';
        }
    });
    document.addEventListener('click', function(event) {
        var targetElement = event.target;
        if (!deleteSonglistForm.contains(targetElement) && targetElement !== deletePlaylistButton) {
            deleteSonglistForm.style.display = 'none';
            deletePlaylistButton.style.color = '#000';
        }
    });
});
// 顯示音樂播放列表
document.addEventListener('DOMContentLoaded', function() {
    var checkPlaylistButton = document.getElementById('checkPlaylistButton');
    var showMusicButton = document.getElementById('showMusicButton');
    var musicList = document.querySelector('.music-list');
    var playlistContainer = document.getElementById('playlistContainer');
    var showUsersButton = document.getElementById('showUsersButton');
    var accountContainer = document.getElementById('accountContainer');

    checkPlaylistButton.addEventListener('click', function() {
        musicList.style.display = 'none';
        showMusicButton.style.color = '#000';
        accountContainer.style.display = 'none';
        showUsersButton.style.color = '#000';
        if (playlistContainer.style.display === 'grid') {
            playlistContainer.style.display = 'none';
            checkPlaylistButton.style.color = '#000';
        } else {
            playlistContainer.style.display = 'grid';
            checkPlaylistButton.style.color = 'lightblue';
        }
    });
});
// 管理使用者視窗
document.addEventListener('DOMContentLoaded', function() {
    var showUsersButton = document.getElementById('showUsersButton');
    var accountContainer = document.getElementById('accountContainer');
    var showMusicButton = document.getElementById('showMusicButton');
    var musicList = document.querySelector('.music-list');
    var checkPlaylistButton = document.getElementById('checkPlaylistButton');
    var playlistContainer = document.getElementById('playlistContainer');
    showUsersButton.addEventListener('click', function() {
        musicList.style.display = 'none';
        showMusicButton.style.color = '#000';
        playlistContainer.style.display = 'none';
        checkPlaylistButton.style.color = '#000';
        if (accountContainer.style.display === 'grid') {
            accountContainer.style.display = 'none';
            showUsersButton.style.color = '#000';
        } else {
            accountContainer.style.display = 'grid';
            showUsersButton.style.color = 'lightblue';
        }
    });
});
// 加入播放清單表單顯示控制
document.addEventListener('DOMContentLoaded', function() {
    var addToPlaylistButtons = document.querySelectorAll('.add-to-playlist-btn');
    addToPlaylistButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var songId = button.getAttribute('data-songid');
            console.log('Song ID:', songId);
            if (!songId) {
                return;
            }
            var addToPlaylistForm = document.getElementById('addToPlaylistForm');

            var songIdInput = addToPlaylistForm.querySelector('input[name="songId"]');
            if (!songIdInput) {
                return;
            }
            songIdInput.value = songId;

            addToPlaylistForm.style.display = 'block';
        });
    });

    document.addEventListener('click', function(event) {
        var addToPlaylistForm = document.getElementById('addToPlaylistForm');
        if (!addToPlaylistForm.contains(event.target) && !event.target.classList.contains('add-to-playlist-btn')) {
            addToPlaylistForm.style.display = 'none';
        }
    });
});


// 刪除播放清單內的歌曲
$(document).ready(function() {
    $(document).on('click', '.delete-play-btn', function() {
        var songId = $(this).data('songid');
        var confirmDelete = confirm('確定要從播放清單中刪除這首歌嗎？');
        if (confirmDelete) {
            $.ajax({
                url: 'delete_from_playlist.php',
                type: 'POST',
                data: { songId: songId },
                success: function(response) {
                    alert('歌曲已成功刪除！');
                    location.reload();
                },
                error: function(xhr, status, error) {
                    alert('刪除歌曲時發生錯誤：' + error);
                }
            });
        }
    });
});

// 詳細顯示音樂播放清單
document.addEventListener('DOMContentLoaded', function() {
    var playlistDetailContainer = document.getElementById('playlistDetailContainer');
    var menuButtons = document.querySelectorAll('.menu');
    var songList = [];

    menuButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            playlistDetailContainer.style.display = 'none';
        });
    });

    $('.show-playlistdetail-button').click(function() {
        var playlistId = $(this).data('playlistid');
        playlistContainer.style.display = 'none';
        checkPlaylistButton.style.color = '#000';
        $.ajax({
            url: 'load_playlist_detail.php',
            method: 'GET',
            data: { playlist_id: playlistId },
            success: function(response) {
                $('#playlistDetailContent').html(response);
                $('#playlistDetailContainer').show();
                songList = [];
                $('#playlistDetailContainer .music-item').each(function() {
                    var song = {
                        src: $(this).find('.play-playlist-button').data('src'),
                        cover: $(this).find('.music-cover').attr('src'),
                        name: $(this).find('h3').text(),
                        artist: $(this).find('p.artistName').text()
                    };
                    songList.push(song);
                });

                bindPlayButtons();
            },
            error: function(xhr, status, error) {
                $('#playlistDetailContent').html('<p>無法獲取播放清单詳細内容。</p>');
                $('#playlistDetailContainer').show();
            }
        });
    });

    $('.play-all-button').click(function() {
        playAllSongs();
    });

    function playAllSongs() {
        if (songList.length > 0) {
            playSong(0); // 播放第一首歌曲
        }
    }

    function playSong(index) {
        var song = songList[index];
        if (!song) return;

        var musicPlayer = document.getElementById('musicPlayer');
        var musicCover = document.querySelector('.bottom-music-cover');
        var musicName = document.querySelector('.bottom-songName');
        var artistName = document.querySelector('.bottom-artistName');

        musicPlayer.src = song.src;
        musicCover.src = song.cover;
        musicName.innerText = song.name;
        artistName.innerText = song.artist;

        musicPlayer.play();
    }

    function bindPlayButtons() {
        $('#playlistDetailContainer').on('click', '.play-playlist-button', function() {
            var songUrl = $(this).data('src');
            var songIndex = songList.findIndex(function(song) {
                return song.src === songUrl;
            });

            if (songIndex !== -1) {

                // 播放音樂
                playSong(songIndex);
            }
        });
    }
});

//底部播放器設定
document.addEventListener('DOMContentLoaded', function() {
    var musicPlayer = document.getElementById('musicPlayer');
    var musicCover = document.querySelector('.bottom-music-cover');
    var musicName = document.querySelector('.bottom-songName');
    var artistName = document.querySelector('.bottom-artistName');
    var globalSongList = [];
    var currentSongList = [];
    var currentSongIndex = -1;
    var isPlaying = false;

    musicPlayer.volume = 0.3;

    // 加载全局歌曲列表
    loadGlobalSongs();

    // 绑定全局播放按钮
    bindGlobalPlayButtons();

    $(document).on('click', '.play-all-button', function() {
        console.log('Play all button clicked');
        if (currentSongList.length > 0) {
            playSong(0);
        } else {
            console.error('No songs in the current song list.');
        }
    });

    document.querySelectorAll('.show-playlistdetail-button').forEach(function(button) {
        button.addEventListener('click', function() {
            //console.log('Playlist detail button clicked');
            var playlistId = this.getAttribute('data-playlistid');
            $.ajax({
                url: 'load_playlist_detail.php',
                method: 'GET',
                data: { playlist_id: playlistId },
                success: function(response) {
                    //console.log('Playlist details loaded');
                    var playlistDetailContainer = document.getElementById('playlistDetailContainer');
                    document.getElementById('playlistDetailContent').innerHTML = response;
                    playlistDetailContainer.style.display = 'block';
                    currentSongList = [];
                    document.querySelectorAll('#playlistDetailContainer .music-item').forEach(function(item) {
                        var song = {
                            src: item.querySelector('.play-playlist-button').getAttribute('data-src'),
                            cover: item.querySelector('.music-cover').getAttribute('src'),
                            name: item.querySelector('h3').innerText,
                            artist: item.querySelector('p').innerText,
                            position: parseInt(item.getAttribute('data-position'), 10)
                        };
                        currentSongList.push(song);
                    });
                    currentSongList.sort(function(a, b) {
                        return a.position - b.position;
                    });
                    bindPlayButtons();
                },
                error: function(xhr, status, error) {
                    //console.error('无法获取播放清单详细内容:', error);
                    document.getElementById('playlistDetailContent').innerHTML = '<p>无法获取播放清单详细内容。</p>';
                    playlistDetailContainer.style.display = 'block';
                }
            });
        });
    });

    function bindPlayButtons() {
        //console.log('Binding play buttons for playlist songs');
        document.querySelectorAll('.play-playlist-button').forEach(function(button) {
            button.addEventListener('click', function() {
                var songUrl = button.getAttribute('data-src');
                var songIndex = currentSongList.findIndex(function(song) {
                    return song.src.trim() === songUrl.trim(); // 确保 src 是一致的
                });
                //console.log('Clicked song:', songUrl, 'Index:', songIndex); // 调试信息
                if (songIndex !== -1) {
                    playSong(songIndex);
                } else {
                    console.error('Song not found in currentSongList.');
                }
            });
        });
    }

    function playAllSongs() {
        if (currentSongList.length > 0) {
            //console.log('Playing all songs');
            playSong(0);
        } else {
            //console.error('No songs in the current song list.');
        }
    }

    function playSong(index) {
        var song = currentSongList[index];
        if (!song) {
            //console.error('No song at index:', index);
            return;
        }

        musicPlayer.pause();
        musicPlayer.src = song.src;

        musicPlayer.oncanplay = function() {
            musicCover.src = song.cover;
            musicName.innerText = song.name;
            artistName.innerText = song.artist;
            musicPlayer.play().then(() => {
                isPlaying = true;
                currentSongIndex = index;
                //console.log(`Now playing: ${song.name} by ${song.artist}`);
            }).catch(function(error) {
                //console.error('播放失敗:', error);
            });
        };

        musicPlayer.load();
    }

    // 播放下一首歌曲
    function playNextSong() {
        //console.log('Playing next song');
        if (currentSongIndex < currentSongList.length - 1) {
            playSong(currentSongIndex + 1);
        } else {
            playSong(0);
        }
    }

    // 播放上一首歌曲
    function playPrevSong() {
        //console.log('Playing previous song');
        if (currentSongIndex > 0) {
            playSong(currentSongIndex - 1);
        } else {
            playSong(currentSongList.length - 1);
        }
    }

    function loadGlobalSongs() {
        //console.log('Loading global songs');
        $('#globalSongList .music-item').each(function() {
            var song = {
                src: $(this).find('.play-button').data('src'),
                cover: $(this).find('.music-cover').attr('src'),
                name: $(this).find('h3').text(),
                artist: $(this).find('p').text()
            };
            //console.log('Loaded song:', song);
            globalSongList.push(song);
        });
        //console.log('Global song list:', globalSongList);
    }

    // 绑定全局播放按钮
    function bindGlobalPlayButtons() {
        //console.log('Binding global play buttons');
        var playButtons = document.querySelectorAll('.play-button');
        playButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var parentElement = button.parentElement.parentElement;
                var song = {
                    src: button.getAttribute('data-src').trim(),
                    cover: parentElement.querySelector('.music-cover').getAttribute('src'),
                    name: parentElement.querySelector('h3').innerText,
                    artist: parentElement.querySelector('p').innerText
                };

                //console.log('Global play button clicked:', song);

                // 更新 currentSongList 和 currentSongIndex
                currentSongList = globalSongList;
                currentSongIndex = globalSongList.findIndex(function(s) {
                    return s.src === song.src;
                });

                //console.log('Found song at index:', currentSongIndex);

                if (currentSongIndex !== -1) {
                    playSong(currentSongIndex);
                } else {
                    //console.error('Song not found in globalSongList.');
                }
            });
        });
    }

    document.getElementById('prevSongBtn').addEventListener('click', playPrevSong);
    document.getElementById('nextSongBtn').addEventListener('click', playNextSong);

    musicPlayer.addEventListener('ended', playNextSong);
});