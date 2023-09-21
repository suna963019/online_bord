<?php
echo ini_set('display_errors', 1);
session_start();
if (empty($_SESSION['token'])) {
    $token=bin2hex(openssl_random_pseudo_bytes(24));
    $_SESSION['token']=$token;
}else{
    $token=$_SESSION['token'];
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>

<body>
    <style>
        body {
            background-color: bisque;
        }

        #title {
            text-align: center;
        }

        form {
            width: 400px;
            padding: 20px;
            margin: 100px auto;
            border: 1px solid black;
            border-radius: 4px;
            background-color: aliceblue;
        }

        p {
            width: 400px;
            text-align: center;
        }

        #id,
        #pass {
            width: 200px;
        }

        .required {
            color: red;
        }

        .line {
            width: 380px;
            margin: 20px 0px;
            display: flex;
            justify-content: space-between;
            height: 2rem;
            line-height: 0rem;
        }

        #submit {
            margin-left: auto;
        }

        .center {
            text-align: center;
        }

        .flex {
            text-align: center;
            display: flex;
            margin: auto;
            width: 400px;
        }
    </style>
    <?php require('nav.php'); ?>
    <h1 id="title">プロフィール変更</h1>
    <form action="login-output.php" method="post">
    <input type="hidden" name="token" value="<?php 
        echo htmlspecialchars($token,ENT_COMPAT,'UTF-8');?>">
        <label class="line" for="id">
            <p>お名前</p>
            <input type="text" name="newId" id="id" <?php
            echo 'value="', $_SESSION['id'], '"';?>>
        </label>
        <label class="line" for="pass">
            <p>パスワード</p>
            <input type="password" name="newPass" id="pass" <?php
            echo 'value="', $_SESSION['pass'], '"';?>>
        </label>
        <div class="line">
            <input type="submit" value="変更" id="submit">
        </div>
    </form>

</body>

</html>