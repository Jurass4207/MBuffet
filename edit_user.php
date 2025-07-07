
<?php
    session_start();
    require_once('database.php');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // 假設有資料庫連線 $link

        if (isset($_POST['editUserName'], $_POST['editPassWord'], $_POST['editUserId'])) {
            $editUserName = $_POST['editUserName'];
            $editPassWord = $_POST['editPassWord'];
            $userId = $_POST['editUserId'];

            // 使用預處理語句以避免 SQL 注入
            $editQuery = "UPDATE accounts SET account = ?, password = ? WHERE member_id = ?";
            if ($stmt = $link->prepare($editQuery)) {
                $stmt->bind_param("ssi", $editUserName, $editPassWord, $userId);

                if ($stmt->execute()) {
                    $redirectUrl = $_SESSION['user_id'] == 1 ? 'developer.php' : 'client.php';
                    echo '<script>alert("編輯成功!"); window.location.href = "' . $redirectUrl . '";</script>';
                } else {
                    $response = ['error' => 'Error updating user information: ' . $stmt->error];
                    echo json_encode($response);
                    $redirectUrl = $_SESSION['user_id'] == 1 ? 'developer.php' : 'client.php';
                    echo '<script>alert("編輯失敗!"); window.location.href = "' . $redirectUrl . '";</script>';
                }
                $stmt->close();
            } else {
                $response = ['error' => 'Failed to prepare statement: ' . $link->error];
                echo json_encode($response);
                $redirectUrl = $_SESSION['user_id'] == 1 ? 'developer.php' : 'client.php';
                echo '<script>alert("編輯失敗!"); window.location.href = "' . $redirectUrl . '";</script>';
            }
        } else {
            $response = ['error' => 'Incomplete POST data'];
            echo json_encode($response);
            $redirectUrl = $_SESSION['user_id'] == 1 ? 'developer.php' : 'client.php';
            echo '<script>alert("編輯失敗!"); window.location.href = "' . $redirectUrl . '";</script>';
        }
    } else {
        $response = ['error' => 'Invalid request method'];
        echo json_encode($response);
        $redirectUrl = $_SESSION['user_id'] == 1 ? 'developer.php' : 'client.php';
        echo '<script>alert("編輯失敗!"); window.location.href = "' . $redirectUrl . '";</script>';
    }

    $link->close();
?>
