<?php
echo ini_set('display_errors', 1);
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
    <h1 id="title">ログイン</h1>
    <form action="login-output.php" method="post">
        <label class="line" for="id">
            <p><span class="required">* </span>お名前（又はID）</p>
            <input type="text" name="id" id="id" required>
        </label>
        <label class="line" for="pass">
            <p><span class="required">* </span>パスワード</p>
            <input type="password" name="pass" id="pass" required>
        </label>
        <div class="line">
            <input type="submit" value="ログイン" id="submit">
        </div>
        <div class="line">
            <p><a href="acount-input.php">新規登録</a></p>
        </div>
    </form>

</body>

</html>