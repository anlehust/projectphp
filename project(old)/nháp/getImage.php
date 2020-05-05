<?php
//$servername = 'localhost';
//$username = 'root';
//$password = '';
//$dbname = 'comics';
//$connection = new mysqli($servername, $username, $password, $dbname);
//if ($connection->connect_error){
//    echo "Connection error".$connection->connect_error;
//}
//else {
//    echo "Connection successfully";
//}
function checkURL($url){
    $handle = curl_init($url);
    curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

    /* Get the HTML or whatever is linked in $url. */
    $response = curl_exec($handle);

    /* Check for 404 (file not found). */
    $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
    if($httpCode == 404) {
        /* Handle 404 here. */
        return false;
    }
    if($httpCode == 500) {
        /* Handle 404 here. */
        return true;
    }
    return true;
    curl_close($handle);
}
$episode = 1;
$page = 1;
ini_set('max_execution_time', '0');
for($episode = 1; $episode <= 45; $episode++) {
    if(opendir('H:/comics/doraemon/episode'.$episode)== false) {
        mkdir('H:/comics/doraemon/episode' . $episode);
    }
    for ($page = 1; $page <= 200; $page++) {

        $img_url = 'H:/comics/doraemon/episode'.$episode.'/page'.$page.'.png';
        $url = 'http://comicserver.vuilen.com/imagecache/w480/doremon/tap'.$episode.'/img/Untitled-'.$page.'.jpg';
        file_put_contents($img_url, file_get_contents($url));
//        if(!file_get_contents($url)){
//           if (!checkURL($url))
//           break;
//        }
        }
}
echo 'success';