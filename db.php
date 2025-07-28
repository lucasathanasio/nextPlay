<?php
$host = 'localhost';
//$port = '9090';  // Porta especificada
$dbname = 'chat';
$user = 'root';  // Altere se necessário
$pass = '';      // Coloque a senha do seu banco de dados se existir

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    // Definindo o modo de erro do PDO para exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>
