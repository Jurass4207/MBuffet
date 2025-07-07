<!DOCTYPE html>
<html lang="zh-TW">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <title>登入</title>
    </head>
    <style>
        div.result {
            text-align:center;
        }
    </style>
    <body>
        <div style="text-align: center;">
            <a href='index.php'>登入</a>
            <a href='register.php'>註冊</a>
        </div>
        <div class="result">
            <?php
                require_once('database.php');
                //取得傳送過來的帳號密碼
                $account = $_POST['account'];
                $password = $_POST['password'];
                //取得資料庫已有的帳戶資料
                $query = "SELECT * FROM `members` WHERE `account` ='$account' AND `password`='$password'";
                $result = $link->query($query);
                $queryAllUsers = "SELECT account FROM `members`";
                $resultAllUsers = $link->query($queryAllUsers);
                if($result-> num_rows > 0)
                {
                    //帳號密碼皆正確，登入成功
                    $count = 1;
                    while ($row = $resultAllUsers->fetch_assoc())
                    {
                        $account = $row["account"];
                        echo "使用者" . $count++ . ": " . $account . "<br>";
                    }
                }
                else 
                {   
                    //登入失敗
                    echo "<h3>帳號或密碼錯誤，請重新登入</h3>";
                }
                $link->close();
            ?>
        </div>
    </body>
</html>