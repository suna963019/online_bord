<?php 
 echo ini_set('display_errors',1);
 session_start();
 if (empty($_SESSION['token'])||$_POST['token']!==$_SESSION['token']) {
    die('正規の画面からご使用ください');
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

    <?php
    unset($_SESSION['customer']);
    $id = $_REQUEST["id"];
    $pass = $_REQUEST["pass"];
    $returnCheck = true;

    $pdo = new PDO("mysql:host=localhost;dbname=suna_bord;charset=utf8", "owner", "anjera");
    $sql = $pdo->prepare("select * from user where (user_id=? or name=?) and password=?");
    $sql->execute([$_REQUEST["id"], $_REQUEST["id"], $_REQUEST["pass"]]);
    foreach ($sql as $row) {
        $_SESSION['customer'] = ['id' => $row['user_id'], 'name' => $row['name'], 'password' => $row['password'], 'pagenum' => 0, 'sort' => 'order by chat_data.id desc'];
    }

    echo "<p>";
    if (isset($_SESSION['customer'])) {
        $returnCheck = false;
        echo "ログインに成功しました。";
        echo '<p>2秒後に<a href="bord.php">ホーム</a>へ移動します。</
        p>';
        echo '<script>setTimeout(function () {
            window.location.href= "bord.php";
         
         },2000);</script>';
    } else {
        echo "IDまたはパスワードが違います。";
    }
    echo "</p>";
    if ($returnCheck) {
        echo '<a href="login-input.php"><p>戻る</p></a>';
    }
    ?>

</body>
</html>