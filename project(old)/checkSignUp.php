<?php
$username = $_POST["username"];
$password = $_POST["password"];
$name = $_POST["fullname"];
$servername = "localhost";
$db_username = "root";
$db_password = "";
$database_name = "comic";
$connection = new mysqli($servername, $db_username, $db_password, $database_name);
ini_set('max_execution_time', '0');
$sql = 'INSERT INTO users(username, password, name)'
      .'VALUES ("'.$username.'","'.$password.'","'.$name.'")';
class userException extends Exception {
    public function errorMessage() {
        //error message
        $errorMsg = ': <b>'.$this->getMessage().'</b>';
        return $errorMsg;
    }
}
            try{
                if(!$connection->query($sql))
            throw new userException($connection->error);
            echo 'Register success. You can Log In now';
            include 'login_comics.html';
            } catch (userException $e){
                echo $e->errorMessage();
                echo '<br>';
                echo 'If you have an acount <a href = "login_comics.html">Log In</a>  now or <a href="signup.html">Register</a> new account';
            }



