<?php 
 echo ini_set('display_errors',1);
 ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<?php session_start(); ?>

    <?php
    $newId = $_REQUEST["newId"];
    $newPass = $_REQUEST["newPass"];
    $returnCheck = true;

    $pdo = new PDO("mysql:host=localhost;dbname=practice;charset=utf8", "owner", "anjera");
    $sqlSel = $pdo->prepare("select * from user where name=?");
    $sqlSel->execute([$newId]);
    foreach ($sqlSel as $row) {
        $acount=$row['id'];
    }

    
    if (!isset($acount)&&!preg_match('/^[0-9].*$/',$newId)) {
        // $sqlUpd=$pdo->prepare("update user set name=? password=? where id=?");
        // $sqlUpd->execute([$newId,$newPass,$_SESSION['customer']['id']]);
        echo "<p>";
        echo "変更に成功しました。";
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