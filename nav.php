<h1 class="center">Y</h1>
<div class="flex">
    <p><a href="bord.php">ホーム</a></p>
    <?php 
    if (isset($_SESSION['customer'])) {
        echo '<p><a href="logout.php">ログアウト</a></p>';
    }else{
        echo '<p><a href="acount-input.php">新規アカウント登録</a></p>';
        echo '<p><a href="login-input.php">ログイン</a></p>';
    }
     ?>
</div>