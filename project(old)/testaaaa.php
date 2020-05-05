<?php

$servername = "localhost";
$username = "root";
$password = "";
$database_name = "comic";
$connection = new mysqli($servername, $username, $password, $database_name);
ini_set('max_execution_time', '0');
function ttest($connection)
{
    $sql = 'SELECT * FROM list_comic';
    foreach ($connection->query($sql) as $comic) {
        $sql = 'INSERT INTO image(name_of_chap, source)';
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
                $connection->query($sql . ' VALUES ("' . $chapter . '","' . base64_encode(file_get_contents($image)) . '")');


            }
        }

    }
}
ttest($connection);
