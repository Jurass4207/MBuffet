<!doctype html>
<html lang="zh-TW">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="login.css">
        <link rel="icon" type="image/png" href="images/icon.png">
        <title>註冊 - MBuffet</title>
    </head>
    <style>
        body {
            background: url('images/register-background.gif') center center fixed;
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
        .error
        {
            color:red;
        }
    </style>
    <body>
        <a><div class="main-icon"><img src="images/icon.PNG" alt="圖片"></div></a>
        <div class="top-bar"></div>
        <div class="marketing-word3"><img src="images/marking-word3.PNG" alt="圖片"></div>
        <div class="marketing-word4"><img src="images/marking-word4.PNG" alt="圖片"></div>
        <form method="POST">
            <div class="input-row-pic"><img src="images/MBuffet.PNG" alt="圖片" class="icon"></div>
            <div class="input-row">帳號或使用者名稱</div>
            <div class="input-row"><input type="text" name="account" placeholder="帳號或使用者名稱" style="width: 100%;"></div>
            <div class="input-row">密碼</div>
            <div class="input-row"><input type="password" name="password" placeholder="密碼" style="width: 100%;"></div>
            <input type="submit" value="註冊" class="login-button">
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
                        $query = "SELECT * FROM `accounts` WHERE `account` ='$account' OR `password`='$password'";
                        $result = $link->query($query);
                        if($result-> num_rows > 0)
                        {   //帳號已經有人使用，註冊失敗
                            echo "<h5 class='result-div-n'>此帳號或密碼已有人使用</h5>";
                        }
                        else 
                        {   //註冊成功
                            echo "<h5 class='result-div-y'>註冊成功!</h5>";
                            $insert_query = "INSERT INTO accounts (account, password) VALUES ('$account', '$password');";
                            $link->query($insert_query);
                        }
                    }
                }
                $link->close();
            ?>
            <div class="input-row" style="color: gray;">已擁有帳戶?<a href="index.php" class="link-button">請在此處登入</a></div>
        </form>
    </body>
</html>