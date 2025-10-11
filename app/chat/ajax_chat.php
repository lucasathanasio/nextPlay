<?php
session_start();
include('../..//config/db.php'); // Ajuste o caminho para o db.php

$remetente_id = $_SESSION['user_id'];
$destinatario_id = $_GET['destinatario_id'];

$query = "
    SELECT 
        messages.mensagem, 
        messages.timestamp, 
        messages.remetente_id, 
        users.profile_pic 
    FROM 
        messages 
    JOIN 
        users 
    ON 
        messages.remetente_id = users.id 
    WHERE 
        (messages.remetente_id = :remetente AND messages.destinatario_id = :destinatario) 
        OR 
        (messages.remetente_id = :destinatario AND messages.destinatario_id = :remetente) 
    ORDER BY 
        messages.timestamp ASC
";
$stmt = $pdo->prepare($query);
$stmt->execute(['remetente' => $remetente_id, 'destinatario' => $destinatario_id]);
$messages = $stmt->fetchAll();

foreach ($messages as $message) {
    $class = $message['remetente_id'] == $remetente_id ? 'sent' : 'received';
    $profile_pic = $message['profile_pic'];
    echo '
    <div class="' . $class . '">
        <img src="' . $profile_pic . '" onerror="this.src=\'../../assets/profile_pics/perfil_sem_foto.png\'" class="profile-pic" width="30px">
        <span>' . htmlspecialchars($message['mensagem']) . '</span>
    </div>
';

}
?>
