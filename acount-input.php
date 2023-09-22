<?php
echo ini_set('display_errors', 1);
session_start();
if (empty($_SESSION['token'])) {
    $token = bin2hex(openssl_random_pseudo_bytes(24));
    $_SESSION['token'] = $token;
} else {
    $token = $_SESSION['token'];
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
            width: 500px;
            padding: 20px;
            margin: 100px auto;
            border: 1px solid black;
            border-radius: 4px;
            background-color: aliceblue;
        }

        p {
            width: 300px;
            overflow-wrap: break-all;
            line-height: 0em;
        }

        #id,
        #pass,
        #re_pass {
            width: 200px;
        }

        .required {
            color: red;
        }

        .line {
            width: 480px;
            margin: 20px 0px;
            display: flex;
            height: 2rem;
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
            width: 500px;
        }
    </style>
    <?php require('nav.php'); ?>
    <h1 id="title">新規登録</h1>
    <form action="acount-output.php" method="post">
        <input type="hidden" name="token" value="<?php 
        echo htmlspecialchars($token,ENT_COMPAT,'UTF-8');?>">
        <label class="line" for="id">
            <p><span class="required">* </span>お名前(数字のみ不可)</p>
            <input type="text" name="id" id="id" required>
        </label>
        <label class="line" for="pass">
            <p><span class="required">* </span>パスワード（4文字以上）</p>
            <input type="password" name="pass" id="pass" pattern="[0-9a-zA-Z].{3,8}" oninput="checkPass()" required>
        </label>
        <label class="line" for="re_pass">

            <p><span class="required">* </span>パスワード（確認のため再入力）</p>

            <input type="password" name="re_pass" id="re_pass" required oninput="checkPass()">
        </label>
        <div class="line">
            <input type="submit" value="登録" id="submit">
        </div>
        <div class="line">
            <p><a href="login-input.php">ログイン</a></p>
        </div>
    </form>
    <script>
        const element = document.querySelector("#submit");

        function checkPass() {
            re_pass.pattern = pass.value;
        }
    </script>

</body>

</html>