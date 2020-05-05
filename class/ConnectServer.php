<?php
class ConnectServer{
    public $servername;
    public $username;
    public $password;
    public $dbname;
    public $connection;
    public function __construct($servername, $username, $password, $dbname){
        $this ->servername = $servername;
        $this ->username = $username;
        $this ->password = $password;
        $this->dbname = $dbname;
        $this->connection= new mysqli($servername, $username, $password, $dbname);
    }
    public function query($sql){
        return $this->connection->query($sql);
    }
}
?>