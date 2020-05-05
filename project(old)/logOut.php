<?php
    session_start();
?>
<html>
<head></head>
<body>
<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $dbname= 'comic';
    $connect_server = new ConnectServer('localhost', 'root', '', 'comic');
//    $result = $connection ->query('SELECT TOP 1 id_chap FROM chap WHERE name_of_chap ="'.$_SESSION['recent_chap'].'"');
    $sql = 'UPDATE users SET recent_chap ='.$_SESSION['recent_chap'].' WHERE user_id = '.$_SESSION['id'];
    $connect_server->query($sql);
    session_unset();
    session_destroy();
    echo 'Đăng xuất thành công';
?>
</body>
</html>
