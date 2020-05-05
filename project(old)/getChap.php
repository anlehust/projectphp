<?php
include 'class/Chap.php';
include 'class/ConnectServer.php';
$a=array();
ini_set('max_execution_time', '0');
$connect_server = new ConnectServer('localhost', 'root', '', 'comic');
$sql = 'SELECT name_of_chap, id_chap FROM chap,list_comic WHERE id ='.$_POST['comic'].' AND chap.name = list_comic.name'
.' ORDER BY id_chap  DESC';
foreach ($connect_server->query($sql) as $element){
    $chap = new Chap($element['id_chap'], $element['name_of_chap']);
    array_push($a,$chap);
}
echo json_encode($a);


//die;
