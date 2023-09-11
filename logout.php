<?php session_start(); ?>
<?php require "header.php";?>
<?php 
unset($_SESSION['customer']);
 ?>
 ログアウトしました。２秒後<a href="index.php">ホーム</a>に戻ります。
<script>
setTimeout(function () {
            window.location.href= "index.php";
         },2000);
</script>
<?php require "footer.php";?>