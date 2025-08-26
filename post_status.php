<?php
session_start();
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    try {
        $status = $_POST['status'];
        $user_id = $_SESSION['user_id'];
        $image_path = NULL;
        $youtube_link = NULL;
        $file_path = NULL;

        // Processa o arquivo
        if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $upload_dir = 'files/'; 

            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            $file_path = $upload_dir . basename($_FILES['file']['name']);

            // Verifica se o arquivo foi movido corretamente
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
                throw new Exception('Erro ao mover o arquivo.');
            } 
        } 

        // Processar upload de imagem
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $image_path = $upload_dir . basename($_FILES['image']['name']);
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                throw new Exception('Erro ao mover o arquivo de imagem.');
            }
        }

        // Processar link do YouTube
        if (isset($_POST['youtube_link']) && !empty($_POST['youtube_link'])) {
            // Opcional: Valide o formato do link do YouTube
            if (filter_var($_POST['youtube_link'], FILTER_VALIDATE_URL)) {
                $youtube_link = $_POST['youtube_link'];
            } else {
                throw new Exception('Link do YouTube inválido.');
            }
        }

        // Inserir no banco de dados
        $stmt = $pdo->prepare('INSERT INTO postnormal (user_id, content, image_path, file_path, youtube_link) VALUES (:user_id, :content, :image_path, :file_path, :youtube_link)');
        $stmt->execute([
            'user_id' => $user_id,
            'content' => $status,
            'image_path' => $image_path,
            'file_path' => $file_path,
            'youtube_link' => $youtube_link
        ]);

        // Redirecionar para o feed após a postagem
        header('Location: feed.php');
        exit();
    } catch (Exception $e) {
        // Exibir mensagem de erro
        echo 'Erro: ' . $e->getMessage();
    }
} else {
    echo 'Ação não permitida ou sessão expirada.';
}
