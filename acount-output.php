<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>

    <?php
    $id = $_REQUEST["id"];
    $pass = $_REQUEST["pass"];
    $returnCheck = true;

    $pdo = new PDO("mysql:host=localhost;dbname=suna_hotel;charset=utf8", "owner", "anjera");
    $sqlSel = $pdo->prepare("select * from user where name=?");
    $sqlSel->execute([$id]);
    foreach ($sqlSel as $row) {
        $acount=$row['id'];
    }

    
    if (!isset($acount)&&!preg_match('/^[0-9].*$/',$id)) {
        // $sqlUpd=$pdo->prepare("insert into user values(null,?,?)");
        // $sqlUpd->execute([$id,$pass]);
        echo "<p>";
        echo "登録に成功しました。";
        echo "</p>";
        echo '<p>２秒後<a href="acount-input.php">ログイン画面</a>へ移動します。</
        p>';
        echo '<script>setTimeout(function(){
            window.location.href = "login-input.php";
          }, 2*1000)</script>';
    } else {
        echo "<p>";
        echo "この名前は使用できません。";
        echo "</p>";
        echo '<a href="acount-input.php"><p>戻る</p></a>';
    }
    ?>

</body>
</html>