<?php
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
//        $servername = 'localhost';
//        $username = 'root';
//        $password = '';
//        $dbname= 'comic';
        ini_set('max_execution_time', '0');
        $connect_server = new ConnectServer('localhost', 'root', '', 'comic');
        $sql = 'SELECT * FROM list_comic ';
        foreach ($connect_server->query($sql)as $element){
            echo '<option value="'.$element['name'].'">'.$element['name'].'</option>';
        }
        ?>
    </select><br><br>
    <label for="chaps">Choose a chap:</label>
    <select id="chaps" name="chap_list" form="comic_form">
    </select><br>
    <input type="submit">
</form>
<br>

<!---->
<?php
//
//$servername = 'localhost';
//$username = 'root';
//$password = '';
//$dbname= 'comics';
//ini_set('max_execution_time', '0');
//$connection = new mysqli($servername, $username, $password, $dbname);
//$sql = 'SELECT * FROM imagesrc WHERE name ="'.$_POST['comic_list'].'" AND chap = "'.$_POST['chap_list'].'"';
//foreach ($connection->query($sql)as $element){
//    echo '<img src="data:image/jpg;base64,' . $element['imgsrc'] . '" />';
//    echo '<br>';
//}
//?>
<script src ="/jquery_26.02/jquery-3.4.1.js"></script>
<script src ="/jquery_26.02/jquery-1.12.4.js"></script>
<script src ="/getChap.js"></script>

</body>
</html>
