<?php
echo ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <title>Document</title>

    <style>
        body {
            background-color: antiquewhite;
        }

        h1 {
            text-align: center;
        }

        #input {
            width: 90%;
            border: 1px solid black;
            border-radius: 10px;
            background-color: coral;
            margin: 5%;

        }

        label {
            display: flex;
            margin: 15px;
        }

        label p {
            margin: 0px 5px;
        }

        input[type="text"] {
            width: 200px;
            height: 1rem;
            margin-right: auto;
        }

        input[type="submit"] {
            text-align: right;
            margin: 0px 10px 0px auto;
        }

        textarea {
            width: 90%;
            overflow-y: scroll;
        }

        .row {
            border-top: 1px solid black;
            padding: 10px;
        }

        .row:last-child {
            border-bottom: 1px solid black;
        }

        .row:nth-child(2n+1) {
            background-color: palegreen;
        }

        .row:nth-child(2n) {
            background-color: paleturquoise;
        }

        .line {
            display: flex;
        }

        .line * {
            margin: 10px;
        }
    </style>
</head>

<body>
<?php
    $pdo = new PDO("mysql:host=localhost;dbname=practice;charset=utf8", "root", "mariadb");
    $lastId = $pdo->query("select max(id) as maxId from chat_data");
    foreach ($lastId as $row) {
        $newId = $row['maxId']+1;
    }

    $doubleCheck = false;
    if (isset($_REQUEST['newId'])){
        if ($_REQUEST['newId'] >= $newId) {

        $doubleCheck = true;
        }
    }
    if (isset($_REQUEST['move']) && $doubleCheck) {
        switch ($_REQUEST['move']) {
            case 'add': //コメントの追加
                $sql = $pdo->prepare('insert into chat_data value(null,?,?,0,?)');
                $sql->execute([$_REQUEST['name'], date("Y/m/d H:i:s"), $_REQUEST['text']]);
                break;
            case 'nice': //いいねの処理
                $sql = $pdo->prepare('update chat_data set nice=nice+1 where id=?');
                $sql->execute([$_REQUEST['id']]);
                break;
            default:
        }
    }
    $lastId = $pdo->query("select max(id) as maxId from chat_data");
    foreach ($lastId as $row) {
        $newId = $row['maxId']+1;
    }
    ?>

    <h1>Y</h1>

    <form action="bord.php" method="post" id="input">
        <input type="hidden" name="move" value="add">
        <input type="hidden" name="newId" value="<?php
        echo $newId
        ?>">
        <label>
            <p>名前</p>

            <input type="text" name="name" value="<?php
                                                    if (isset($_REQUEST['name'])) {
                                                        echo $_REQUEST['name'];
                                                    } ?>">
        </label>
        <label>
            <p>内容</p>
            <textarea name="text" rows="10"></textarea>
        </label>
        <label>
            <input type="submit" value="追加">
        </label>
    </form>
    <br>
    


    <?php
    // if (is_null($pagenum)) {
    //     $pagenum = 0;
    // }
    $pagenum = 0;
    $page = [$pagenum * 30, ($pagenum + 1) * 30];
    $pagedata = $pdo->query("select * from chat_data order by id desc limit $page[0],$page[1]");

    //チャットの表示
    foreach ($pagedata as $data) {
        echo '<div class="row">';
        echo '<div class="line">';
        echo '<p>';
        echo $data['id'], ':';
        echo '</p>';
        echo '<h4>';
        if (is_null($data['name'])) {
            echo '名無しさん';
        } else {
            echo $data['name'], 'さん';
        }
        echo '</h4>';
        echo '<p>';
        echo $data['datetime'];
        echo '</p>';
        echo '</div>';
        echo '<div class="line">';
        echo '<p>';
        echo $data['text'];
        echo '</p>';
        echo '</div>';
        echo '<div class="line">';
        echo '<p>';
        echo $data['nice'];
        echo '</p>';
        echo '<form action="bord.php" method="post">';
        echo '<input type="hidden" name="point" value="', $data['nice'], '">';
        echo '<input type="hidden" name="newId" value="', $newId, '">';
        echo '<input type="hidden" name="id" value="', $data['id'], '">';
        echo '<input type="hidden" name="name" value="';
        if (isset($_REQUEST['name'])) {
            echo $_REQUEST['name'];
        }
        echo '">';
        echo '<input type="hidden" name="move" value="nice">';
        echo '<input type="submit" value="いいね">';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
    ?>

    <!-- <form action="bord.php" method="post">
 <input type="hidden" name="name" value="<?php $_REQUEST['name']; ?>">
    <input type="hidden" name="pagenum" value="<?php echo $pagenum; ?>">
    <input type="hidden" name="move" value="back">
    <input type="submit" value="前のページ">
</form>
 <form action="bord.php" method="post">
 <input type="hidden" name="name" value="<?php $_REQUEST['name']; ?>">
    <input type="hidden" name="pagenum" value="<?php echo $pagenum; ?>">
    <input type="hidden" name="move" value="next">
    <input type="submit" value="次のページ">
</form> -->
</body>

</html>