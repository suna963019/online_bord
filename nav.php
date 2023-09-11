<h1 text-algon="center">Y</h1>
<div display="flex">
    <?php 
    if (isset($_SESSION['customer'])) {
        echo '<a href="logout.php"><p>ログアウト</p></a>';
    }else{
        echo '<a href="acount-input.php"><p>新規アカウント登録</p></a>';
        echo '<a href="login-input.php"><p>ログイン</p></a>';
    }
     ?>
</div>