<?php

$localhost = "45.152.44.154";
$dbname = "u451416913_2024grupo25";
$username = "u451416913_2024grupo25";
$pass = 'Grupo25@123';
// $port = 3366


try{

    $pdo = new PDO("mysql:host=45.152.44.154;dbname=u451416913_2024grupo25" , $username, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
    echo "ERRO: " . $e->getMessage();
}


?>
