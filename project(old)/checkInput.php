<?php
include 'class/ConnectServer.php';
$username = $_POST["username"];
$password = $_POST["password"];
//$servername = "localhost";
//$db_username = "root";
//$db_password = "";
//$database_name = "comic";
//$connection = new mysqli($servername, $db_username, $db_password, $database_name);
$connect_server = new ConnectServer('localhost', 'root', '', 'comic');
ini_set('max_execution_time', '0');
$sql = 'SELECT * FROM users WHERE username = "' . $username . '" AND password = "' . $password . '"';
$result = $connect_server-> query($sql);
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
          session_start();
          $_SESSION["username"] = $row['username'];
          $_SESSION["id"] = $row['user_id'];
          echo 'Welcome '.$row['name'];
          echo '<br>'.$_SESSION['id'];
          include 'test_2.php';
    }
} else {
    echo "Sai tên đăng nhập hoặc mật khẩu";
    include 'login_comics.html';
}


//    if($username == 'admin' && $password == 'admin'){
//        include "C:/xampp2/htdocs/comics.php";
//    } else {
//        echo 'Tên đăng nhập hoặc mật khẩu không đúng vui lòng đăng nhập lại';
//        echo '<br>';
//        echo '<a href="login_comics.html"> Quay lại đăng nhập </a>';
//}