<?php session_start(); ?>
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
<?php 
unset($_SESSION['customer']);
 ?>
 ログアウトしました。２秒後<a href="bord.php">ホーム</a>に戻ります。
<script>
setTimeout(function () {
            window.location.href= "bord.php";
         },2000);
</script>
</body>
</html>