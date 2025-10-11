<?php
session_start();
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['new_profile_pic'])) {
    $user_id = $_SESSION['user_id'];
    $upload_dir = 'profile_pics/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    $profile_pic = $upload_dir . basename($_FILES['new_profile_pic']['name']);
    if (move_uploaded_file($_FILES['new_profile_pic']['tmp_name'], $profile_pic)) {
        $stmt = $pdo->prepare('UPDATE users SET profile_pic = :profile_pic WHERE id = :id');
        $stmt->execute(['profile_pic' => $profile_pic, 'id' => $user_id]);
        $_SESSION['profile_pic'] = $profile_pic; 
        header('Location: profile.php');
        exit();
    } else {
        $_SESSION["error"] = 'Erro ao fazer upload da foto de perfil.';
    }
}