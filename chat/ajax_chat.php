<?php
session_start();
include('db.php');

$remetente_id = $_SESSION['user_id'];
$destinatario_id = $_GET['destinatario_id'];

$stmt = $pdo->prepare("SELECT * FROM messages WHERE (remetente_id = :remetente AND destinatario_id = :destinatario) 
    OR (remetente_id = :destinatario AND destinatario_id = :remetente) ORDER BY timestamp ASC");
$stmt->execute(['remetente' => $remetente_id, 'destinatario' => $destinatario_id]);
$messages = $stmt->fetchAll();

foreach ($messages as $message) {
    $class = $message['remetente_id'] == $remetente_id ? 'sent' : 'received';
    echo "<div class='$class'>{$message['mensagem']}</div>";
}
