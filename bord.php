<?php
echo ini_set('display_errors', 1);
?>
<?php session_start(); ?>
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
        .center {
            text-align: center;
        }

        .flex {
            text-align: center;
            display: flex;
            justify-content: space-around;
            margin: auto;
            width: 500px;
        }
    </style>
</head>

<body>
    
<?php require('nav.php'); ?>
    <?php
    
    $pdo = new PDO("mysql:host=localhost;dbname=practice;charset=utf8", "root", "mariadb");
    if (isset($_SESSION['customer'])) {
        $customer=$_SESSION['customer'];
    };
    

    //データベースの編集の処理
    if (isset($_REQUEST['move'])) {
        switch ($_REQUEST['move']) {
            case 'add': //コメントの追加
                $sql = $pdo->prepare('insert into chat_data value(null,?,?,0,?)');
                $sql->execute([$_REQUEST['name'], date("Y/m/d H:i:s"), $_REQUEST['text']]);
                header('Location:http://localhost/~itsys/practice extra/online_bord/bord.php');
                exit;
            case 'nice': //いいねの処理
                $sql = $pdo->prepare('update chat_data set nice=nice+1 where id=?');
                $sql->execute([$_REQUEST['id']]);
                header('local:http://localhost/~itsys/practice extra/online_bord/bord.php');
                exit;
            case 'nomal': //次のぺージ
                $customer['sort']="";
                break;
            case 'desc': //次のぺージ
                $customer['sort']="order by id desc";
                break;
            case 'page_up': //次のぺージ
                $pagenum++;
                break;
            case 'page_down': //前のページ
                $pagenum--;
                break;
            default:
        }
    }
    //現在のページ番号を取得
    if (isset($_SESSION[`pagenum`])) {
        $pagenum = $_SESSION[`pagenum`];
    }
    if (!isset($pagenum)) {
        $pagenum = 0;
    }
    ?>

    <?php 
    if (!isset($_SESSION['customer'])) {
        echo '<p>書き込みにはログインが必要です。</p>';
    }else{
        if (isset($customer['name'])) {
            $name=$customer['name'];
        }else {
            $name="";
        }
        
        echo '<form action="bord.php" method="post" id="input">
        <input type="hidden" name="move" value="add">
        <input type="hidden" name="pagenum" value="<?php
                                                    echo $pagenum
                                                    ?>">
        <label>
            <p>名前</p>

            <input type="text" name="name" value="',$name,'">
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
    <div class="line">
        <form action="bord.php" method="post">
            <input type="hidden" name="move" value="desc">
            <input type="submit" value="新しい順">
        </form>
        <form action="bord.php" method="post">
            <input type="hidden" name="move" value="nomal">
            <input type="submit" value="古い順">
        </form>
    </div>
    <br>';
    }
     ?>
    



    <?php

    $page = [$pagenum * 30, ($pagenum + 1) * 30];
    if (isset($_SESSION['customer'])) {
        $sort=$customer['sort'];
    }else {
        $sort="order by id desc";
    }
    
    $pagedata = $pdo->query("select * from chat_data $sort limit $page[0],$page[1]");

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
        echo '<input type="hidden" name="id" value="', $data['id'], '">';
        echo '<input type="hidden" name="name" value="';
        if (isset($customer['name'])) {
            echo $customer['name'];
        }
        echo '">';
        echo '<input type="hidden" name="move" value="nice">';
        echo '<input type="submit" value="いいね">';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }
    ?>
</body>

</html>