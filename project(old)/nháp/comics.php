<html>
<head>
</head>
<body>
<form action="../test.php" id="comic_form" method="post">
    <label for="comic_name">Comic name:</label>
    <select id="comics" name="comic_list" form="comic_form"  onchange="show(this.value)">
        <?php
//        $servername = 'localhost';
//        $username = 'root';
//        $password = '';
//        $dbname= 'comics';
        ini_set('max_execution_time', '0');
        $connect_server = new ConnectServer('localhost', 'root', '', 'comic');
        $sql = 'SELECT * FROM comiclist ';
        foreach ($connect_server->connection->query($sql)as $element){
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
<script src ="/jquery_26.02/jquery-3.4.1.js"></script>
<script src ="/jquery_26.02/jquery-1.12.4.js"></script>
<script src ="/nháp/getChap.jsap.js"></script>

</body>
</html>

