<?php session_start(); ?>
<?php require "header.php"; ?>

    <?php
    unset($_SESSION['customer']);
    $id = $_REQUEST["id"];
    $pass = $_REQUEST["pass"];
    $returnCheck = true;

    $pdo = new PDO("mysql:host=localhost;dbname=suna_hotel;charset=utf8", "owner", "anjera");
    $sql = $pdo->prepare("select * from user where (id=? or name=?) and password=?");
    $sql->execute([$_REQUEST["id"], $_REQUEST["id"], $_REQUEST["pass"]]);
    foreach ($sql as $row) {
        $_SESSION['customer'] = ['id' => $row['id'], 'name' => $row['name'], 'password' => $row['password'], 'pagenum' => 0, 'sort' => 'desc'];
    }

    echo "<p>";
    if (isset($_SESSION['customer'])) {
        $returnCheck = false;
        echo "ログインに成功しました。";
        echo '<p>2秒後に<a href="index.php">ホーム</a>へ移動します。</
        p>';
        echo '<script>setTimeout(function () {
            window.location.href= "index.php";
         
         },2000);</script>';
    } else {
        echo "IDまたはパスワードが違います。";
    }
    echo "</p>";
    if ($returnCheck) {
        echo '<a href="login-input.php"><p>戻る</p></a>';
    }
    ?>

    <?php require "footer.php"; ?>