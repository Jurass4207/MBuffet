<?php
    session_start();
?>
<!doctype html>
<html lang="zh-Hant-TW">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="login.css">
        <link rel="icon" type="image/png" href="images/icon.png">
        <title>登入 - MBuffet</title>
    </head>
    <style>
        body {
            background: url('images/index-background.gif') center center fixed;
            background-size: cover;
        }
        form {
            position: fixed;
            right: 250px;
            border: #aaa solid 1px;
            border-radius: 10px;
            margin: 250px auto;
            text-align: center;
            padding: 30px;
            width: 370px;
            background-color: #000;
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.3);
        }
        .error {
            color:red;
        }
    </style>
    <body>
        <a><div class="main-icon"><img src="images/icon.PNG" alt="圖片"></div></a>
        <div class="top-bar"></div>
        <div class="marketing-word1"><img src="images/marking-word1.PNG" alt="圖片"></div>
        <div class="marketing-word2"><img src="images/marking-word2.PNG" alt="圖片"></div>
        <form method="POST">
            <div class="input-row-pic"><img src="images/MBuffet.PNG" alt="圖片" class="icon"></div>
            <div class="input-row">帳號或使用者名稱</div>
            <div class="input-row"><input type="text" name="account" placeholder="帳號或使用者名稱" style="width: 100%;"></div>
            <div class="input-row">密碼</div>
            <div class="input-row"><input type="password" name="password" placeholder="密碼" style="width: 100%;"></div>
            <input type="submit" value="登入" class="login-button">
            <?php 
                require_once('database.php');
                if ($_SERVER['REQUEST_METHOD'] == 'POST')
                {
                    $account = $_POST['account'];
                    $password = $_POST['password'];
                    if (empty($account) || empty($password))
                    {
                        echo "<h5 class='result-div-n'>帳號或密碼不能為空白</h5>";
                    }
                    else
                    {   //取得資料庫已有的帳戶資料
                        // 做帳號密碼驗證
                        $query = "SELECT * FROM `accounts` WHERE `account` = ? AND `password` = ?";
                        $stmt = $link->prepare($query);
                        $stmt->bind_param("ss", $account, $password);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows == 1) {
                            $row = $result->fetch_assoc();
                            $user_id = $row['member_id']; // 獲取使用者 ID

                            $_SESSION['account'] = $account; // 保存使用者帳號名稱
                            $_SESSION['user_id'] = $user_id; // 保存使用者 ID

                            if ($account === 'root') {
                                header('Location: developer.php');
                                exit;
                            } else {
                                header('Location: client.php');
                                exit;
                            }
                        } else {
                            echo "<h5 class='result-div-n'>帳號或密碼錯誤，請重新輸入</h5>";
                        }
                    }
                }
                $link->close();
            ?>
            <div class="input-row" style="color: gray;">未註冊帳戶?<a href="register.php" class="link-button">註冊MBuffet</a></div>
            <div class="input-row" style="color: gray;">註:管理員登入，帳號密碼皆為:root</div>
        </form>
    </body>
</html>