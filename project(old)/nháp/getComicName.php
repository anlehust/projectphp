<?php

$servername = 'localhost';
$username = 'root';
$password = '';
$dbname = 'comics';
ini_set('max_execution_time', '0');
$connection = new mysqli($servername, $username, $password,$dbname);
$doc = new DOMDocument();
class customException extends Exception {
    public function errorMessage() {
        //error message
        $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
            .': <b>'.$this->getMessage().'</b> is died';
        return $errorMsg;
    }
}
function createTableInDB($connection){
$sql = 'CREATE TABLE comiclist'
    .'( id INT(5) UNSIGNED AUTO_INCREMENT,'
    .'name VARCHAR(100) NOT NULL UNIQUE,'
    .'link VARCHAR(300) NOT NULL UNIQUE,'
    .'newchap VARCHAR(20) NOT NULL,'
    .'date VARCHAR(20) NOT NULL,'
    .'author VARCHAR(100), '
    .'PRIMARY KEY(id, name, link))';
$connection ->query($sql);}
//createTableInDB($connection);
function insertTable ($connection,$name, $link, $newchap, $date, $author){
    $sql = 'INSERT INTO comiclist(name, link, newchap, date, author)'
            .'VALUES ("'.$name.'","'.$link.'","'.$newchap.'","'.$date.'","'.$author.'")';
    $connection ->query($sql);
}

function getInformationAndAdd($connection){
$html = file_get_contents('http://truyentranhtuan.com/danh-sach-truyen');
$html = str_replace("\n","\0",$html);
$pattern = '/<span class="manga"><a href="(.{0,}?)" rel="bookmark" >(.{0,}?)<\/a>.{0,}?(Chương [0-9]{1,3}).{0,}?([0-9]{2}\.[0-9]{2}.[0-9]{4})/';
preg_match_all($pattern, $html, $matches);
$count = count($matches[0]);
for ($i = 0; $i < $count; $i++){
    insertTable($connection, $matches[2][$i], $matches[1][$i], $matches[3][$i], $matches[4][$i], NULL);
}}
function createTableSrcImage($connection){
    $sql = 'CREATE TABLE imagesrc'
        .'( id INT(10) UNSIGNED AUTO_INCREMENT,'
        .'name VARCHAR(100) NOT NULL ,'
        .'chap VARCHAR(20) NOT NULL,'
        .'imgsrc MEDIUMTEXT NOT NULL,'
        .'PRIMARY KEY(id)'
        .')';
    $connection ->query($sql);
    if($connection->error){
        echo $connection->error;
    } else echo 'Success';
}

function createFK($connection){
    $sql = 'ALTER TABLE imagesrc '
            .'ADD FOREIGN KEY (name) REFERENCES comiclist(name);';
    $connection ->query($sql);
    if($connection->error){
        echo $connection->error;
    } else echo 'Success';
    echo $sql;
}
createFK($connection);
$sql = 'SELECT * FROM comiclist';
// lấy tên truyện và link

function ttest($connection, $sql)
{
    foreach ($connection->query($sql) as $comic) {
        $sql = 'INSERT INTO imagesrc(name, chap, imgsrc)';
        $name = $comic['name'];
        $link = $comic['link'];
        $html = file_get_contents($link);
        $html = str_replace("\n", "\0", $html);
        $pattern = '/<span class="chapter-name">.{0,}?"(.{0,}?)">(.{0,}?)<\/a>/';
        preg_match_all($pattern, $html, $chapters);
        $length = count($chapters[0]);

        for ($i = 0; $i < $length; $i++) {
            $url = $chapters[1][$i];
            $chapter = $chapters[2][$i];
            $html = file_get_contents($url);
            $html = str_replace("\n", "\0", $html);
            $pattern = '/slides_page_url_path = .{0,}?\[(.{0,}?)\]/';
            preg_match_all($pattern, $html, $temp);
            foreach (explode(',', $temp[1][0]) as $image) {
                $image = trim($image, '"');
                $image = ltrim($image);
                $image = rtrim($image);
                $image = str_replace(' ', '_', $image);
//            try{
//                if(file_get_contents($image) == false)
//            throw new customException($image);
//            echo 'Get file success';
//            } catch (customException $e){
//                echo $e->errorMessage();
//            }
//     $img = base64_encode(file_get_contents($image));
//            if ($img == NULL)
//            $connection ->query($sql.' VALUES ("'.$name.'","'.$chapter.'","0")');
                $connection->query($sql . ' VALUES ("' . $name . '","' . $chapter . '","' . base64_encode(file_get_contents($image)) . '")');


            }
        }

    }
}



?>