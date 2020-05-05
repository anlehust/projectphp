<?php
session_start();
?>
<html>
<head>
</head>
<body>
<button><a href = "logOut.php">Log Out</a></button>
<form action="test.php" id="comic_form" method="post">
    <label for="comic_name">Comic name:</label>
    <select id="comics" name="comic_list" form="comic_form" onchange="show(this.value)">
        <?php
            $servername = 'localhost';
            $username = 'root';
            $password = '';
            $dbname= 'comic';
            ini_set('max_execution_time', '0');
            $connection = new mysqli($servername, $username, $password, $dbname);
            $sql = 'SELECT * FROM list_comic ';
            foreach ($connection->query($sql)as $element){
                echo '<option value="'.$element['id'].'">'.$element['name'].'</option>';
            }
        ?>
    </select><br><br>
    <label for="chaps">Choose a chap:</label>
    <select id="chaps" name="chap_list" form="comic_form">
    </select><br>
    <input type="submit">
</form>
<br>
<?php
include 'class/ConnectServer.php';
//    echo 'Truyện '.$_POST['comic_list'].' Chương '.$_POST['chap_list'];
//    $servername = 'localhost';
//    $username = 'root';
//    $password = '';
//    $dbname= 'comic';
    $_SESSION['recent_chap'] = $_POST['chap_list'];
    ini_set('max_execution_time', '0');
    $connect_server = new ConnectServer('localhost', 'root', '', 'comic');
    $sql = 'SELECT source FROM image WHERE  id_chap = '.$_POST['chap_list'];
    foreach ($connect_server->connection->query($sql)as $element){
        echo '<img src="data:image/jpg;base64,' . $element['source'] . '" />';
        echo '<br>';
    }
?>
<script src ="/jquery_26.02/jquery-3.4.1.js"></script>
<script src ="/jquery_26.02/jquery-1.12.4.js"></script>
<script src ="/getChap.js"></script>
</body>
</html>
