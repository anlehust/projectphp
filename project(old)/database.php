<?php

    $servername = "localhost";
    $username = "root";
    $password = "";
    $database_name = "comic";
    $connection = new mysqli($servername, $username, $password, $database_name);
    ini_set('max_execution_time', '0');

    function createTableListComic($connection)
    {
        $sql = 'CREATE TABLE list_comic'
            . '( id INT(5) UNSIGNED AUTO_INCREMENT,'
            . 'name VARCHAR(100) NOT NULL UNIQUE,'
            . 'new_chap VARCHAR(50) NOT NULL,'
            . 'date VARCHAR(20) NOT NULL,'
            . 'author VARCHAR(100), '
            . 'PRIMARY KEY(id, name))';
        $connection->query($sql);
    }

    function createTableChap($connection)
    {
        $sql = 'CREATE TABLE chap'
              .'(id_chap INT(8) UNSIGNED AUTO_INCREMENT ,'
              .'name VARCHAR(100) NOT NULL,'
              .'name_of_chap VARCHAR(50) NOT NULL,'
              .'date VARCHAR(20),'
              .'PRIMARY KEY (id_chap),'
              .'FOREIGN KEY (name) REFERENCES list_comic(name))';
        $connection->query($sql);
    }

    function createTableImageSource($connection)
    {
        $sql = 'CREATE TABLE image'
              .'(id_chap INT(8) UNSIGNED NOT NULL , '
              .'name_of_chap VARCHAR(50) NOT NULL,'
              .'source MEDIUMTEXT ,'
              .'FOREIGN KEY (id_chap) REFERENCES chap(id_chap))';
        $connection->query($sql);
    }

    function createTableUser($connection)
    {
        $sql = 'CREATE TABLE users'
              .'(user_id INT(7) UNSIGNED AUTO_INCREMENT NOT NULL, '
              .'username VARCHAR(100) NOT NULL UNIQUE, '
              .'password VARCHAR(50) NOT NULL, '
              .'name VARCHAR(50) NOT NULL, '
              .'recent_chap INT(8) UNSIGNED,'
              .'PRIMARY KEY(user_id),'
              .'FOREIGN KEY (recent_chap) REFERENCES chap(id_chap))'   ;
        $connection -> query($sql);
    }
    function createTableHistory($connection)
    {
        $sql = 'CREATE TABLE history'
              .'(id INT(9) UNSIGNED AUTO_INCREMENT NOT NULL,'
              .'user_id INT(7) UNSIGNED NOT NULL,'
              .'id_chap INT(8) UNSIGNED,'
              .'PRIMARY KEY (id),'
              .'FOREIGN KEY (user_id) REFERENCES users(user_id))';
        $connection -> query($sql);
    }
    function insertElementListComic ($connection, $name, $new_chap, $date, $author)
    {
        $sql = 'INSERT INTO  list_comic( name, new_chap, date, author)'
              .'VALUES ("'.$name.'","'.$new_chap.'","'.$date.'","'.$author.'")';
        $connection ->query($sql);
    }

    function matchRegex()
    {
        $html = file_get_contents('http://truyentranhtuan.com/danh-sach-truyen');
        $html = str_replace("\n","\0",$html);
        $pattern = '/<span class="manga"><a href="(.{0,}?)" rel="bookmark" >(.{0,}?)<\/a>.{0,}?(Chương [0-9]{1,3}).{0,}?([0-9]{2}\.[0-9]{2}.[0-9]{4})/';

        preg_match_all($pattern, $html, $matches);

        return $matches;
    }

    function insertTableListComic($connection)
    {
        $matches = matchRegex();
        $count = count($matches[0]);
        for ($i = 0; $i < $count; $i++){
            insertElementListComic($connection, $matches[2][$i], $matches[3][$i], $matches[4][$i], NULL);
        }
    }

    function insertChap($connection)
    {
     $arr = matchRegex();
     $length =count($arr[0]);
     $sql = 'INSERT INTO chap(name, name_of_chap, date)';
        for($k = 0; $k < $length; $k++) {
            $name = $arr[2][$k];
            $link = $arr[1][$k];
            $html = file_get_contents($link);
            $html = str_replace("\n", "\0", $html);
            $pattern_author = '/itemprop="author".{0,}?itemprop="name">(.{0,}?)</';

            preg_match_all($pattern_author,$html,$authors);

            if(count($authors[0]) > 0){
                $author_all="";
                foreach ($authors[1] as $author){
                    $author_name = ltrim($author);
                    $author_name = rtrim($author_name);
                    $author_all = $author_all.'_'.$author_name;
                }
                $connection->query('UPDATE list_comic SET author ="' . $author_all . '" WHERE name ="' . $name . '"');
            }
            $pattern = '/<span class="chapter-name">.{0,}?".{0,}?">(.{0,}?)<\/a>.{0,}?<span class="date-name">([0-9]{1,}\.[0-9]{1,}.[0-9]{4})/';

            preg_match_all($pattern, $html, $chapters);

            $length_chapters = count($chapters[0]);
            for ($i=0 ; $i < $length_chapters; $i++){
                $connection->query($sql.' VALUES("'.$name.'","'.$chapters[1][$i].'","'.$chapters[2][$i].'")');
            }
        }
     }

    function insertImage($connection)
    {
        $arr = matchRegex();

        $id_chap = 1;
        foreach ($arr[1] as $link) {
            $sql = 'INSERT INTO image(id_chap, name_of_chap, source)';
            $html = file_get_contents($link);
            $html = str_replace("\n", "\0", $html);
            $pattern = '/<span class="chapter-name">.{0,}?"(.{0,}?)">(.{0,}?)<\/a>/';

            preg_match_all($pattern, $html, $chapters);

            $length = count($chapters[0]);
            for ($i = 0; $i < $length; $i++) {
                echo $id_chap;
                echo '<br>';
                $url = $chapters[1][$i];
                $chapter = $chapters[2][$i];
                echo $chapter;
                echo '<br>';
                $html = file_get_contents($url);
                $html = str_replace("\n", "\0", $html);
                $pattern = '/slides_page_url_path = .{0,}?\[(.{0,}?)\]/';

                preg_match_all($pattern, $html, $temp);

                foreach (explode(',', $temp[1][0]) as $image){
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
                    $connection->query($sql . ' VALUES ("'.$id_chap.'","' . $chapter . '","' . base64_encode(file_get_contents($image)) . '")');
                }
                $id_chap++;
            }
        }
    }
    insertImage($connection);


