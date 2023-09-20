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

        .row:nth-of-type(2n+1) {
            background-color: palegreen;
        }

        .row:nth-of-type(2n) {
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

    $pdo = new PDO("mysql:host=localhost;dbname=suna_bord;charset=utf8", "root", "mariadb");
    if (isset($_SESSION['customer'])) {
        $customer = $_SESSION['customer'];
    };

    $page_max = $pdo->query("select count(*) as max_num from chat_data");
    $page_max = $page_max->fetch();
    $page_max=floor($page_max['max_num']/30);

    //データベースの編集の処理
    if (isset($_REQUEST['move'])) {
        switch ($_REQUEST['move']) {
            case 'add': //コメントの追加
                $sql = $pdo->prepare('insert into chat_data value(null,?,null,?)');
                $sql->execute([$_SESSION['customer']['id'], $_REQUEST['text']]);
                header('Location:http://localhost/~itsys/practice extra/online_bord/bord.php');
                exit;
            case 'nice': //いいねの処理
                try {
                    $sql = $pdo->prepare('insert into nice values(?,?)');
                    $sql->execute([$_SESSION['customer']['id'], $_REQUEST['id']]);
                } catch (PDOException $sh) {
                    $sql = $pdo->prepare('delete from nice where user_id=? and chat_id=?');
                    $sql->execute([$_SESSION['customer']['id'], $_REQUEST['id']]);
                }
                header('Location:http://localhost/~itsys/practice extra/online_bord/bord.php');
                exit;
            case 'nomal': //古い順
                $customer['sort'] = "";
                break;
            case 'desc': //新しい順
                $customer['sort'] = "order by chat_data.id desc";
                break;
            case 'page_up': //次のぺージ
                $_SESSION['customer']['pagenum']++;
                break;
            case 'page_down': //前のページ
                $_SESSION['customer']['pagenum']--;
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
        $login = false;
    } else {
        $login = true;
        if (isset($customer['name'])) {
            $name = $customer['name'];
        } else {
            $name = "";
        }

        echo '<form action="bord.php" method="post" id="input">
        <input type="hidden" name="move" value="add">
        <input type="hidden" name="pagenum" value="<?php
                                                    echo $pagenum
                                                    ?>">
        <label>
            <p>名前</p>

            <p>', $name, '</p>
        </label>
        <label>
            <p>内容</p>
            <textarea name="text" rows="10"></textarea>
        </label>
        <label>
            <input type="submit" value="追加">
        </label>
    </form>
    <br>';
    }
    ?>
    <div class="line">
        <form action="bord.php" method="post">
            <input type="hidden" name="move" value="desc">
            <input type="submit" value="新しい順">
        </form>
        <form action="bord.php" method="post">
            <input type="hidden" name="move" value="nomal">
            <input type="submit" value="古い順">
        </form>
        <p>page</p>
        <?php 
        if ($_SESSION['customer']['pagenum'] >0) {
            echo '<form action="bord.php" method="post">
            <input type="hidden" name="move" value="page_down">
            <input type="submit" value="<">
        </form>';
        }
        echo '<p>',$_SESSION['customer']['pagenum'], '/', $page_max,'</p>';
        if ($_SESSION['customer']['pagenum'] < $page_max) {
            echo '<form action="bord.php" method="post">
            <input type="hidden" name="move" value="page_up">
            <input type="submit" value=">">
        </form>';
        }
         ?>
    </div>
    <br>




    <?php
    $pagenum = $_SESSION['customer']['pagenum'];
    $page = [$pagenum * 30, ($pagenum + 1) * 30];
    if (isset($_SESSION['customer'])) {
        $sort = $customer['sort'];
    } else {
        $sort = "order by chat_data.id desc";
    }

    $pagedata = $pdo->query("select * from chat_data join user on chat_data.name_id=user.user_id group by chat_data.id $sort limit $page[0],$page[1] "); //

    //チャットの表示
    foreach ($pagedata as $data) {
        echo '<div class="row">';
        echo '<div class="line">';
        echo '<p>';
        echo $data['id'], ':';
        echo '</p>';
        echo '<h4>';
        if (empty($data['name'])) {
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
        $user_id = $data['name_id'];
        $chat_id = $data['id'];
        $nice_data = $pdo->query("select count(*) as count from nice where chat_id=$chat_id ");
        $nice_count = $nice_data->fetch();
        echo '<p>';
        echo $nice_count['count'];
        echo '</p>';
        if ($login) {
            echo '<form action="bord.php" method="post">';
            echo '<input type="hidden" name="id" value="', $data['id'], '">';
            echo '<input type="hidden" name="move" value="nice">';
            echo '<input type="submit" value="いいね">';
            echo '</form>';
        }

        echo '</div>';
        echo '</div>';
    }
    ?>
</body>

</html>