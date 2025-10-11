<?php
session_start();
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    try {
        $status = $_POST['status'];
        $user_id = $_SESSION['user_id'];
        $image_path = NULL;
        $youtube_link = NULL;
        $file_path = NULL;

        // Upload de arquivo
        if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
            $upload_dir = '../../assets/files/'; // Caminho físico no servidor
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            $file_name = basename($_FILES['file']['name']);
            $file_path = $upload_dir . $file_name;
            if (!move_uploaded_file($_FILES['file']['tmp_name'], $file_path)) {
                throw new Exception('Erro ao mover o arquivo.');
            }
            $file_path = 'assets/files/' . $file_name; // Caminho relativo salvo no banco
        }

        // Upload de imagem
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $upload_dir = '../../assets/uploads/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);
            $file_name = basename($_FILES['image']['name']);
            $image_path = $upload_dir . $file_name;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                throw new Exception('Erro ao mover o arquivo de imagem.');
            }
            $image_path = 'assets/uploads/' . $file_name;
        }


        // Link do YouTube
        if (!empty($_POST['youtube_link'])) {
            if (filter_var($_POST['youtube_link'], FILTER_VALIDATE_URL)) {
                $youtube_link = $_POST['youtube_link'];
            } else {
                throw new Exception('Link do YouTube inválido.');
            }
        }

        // Inserir na tabela posts
        $stmt = $pdo->prepare('INSERT INTO posts (user_id, tipo) VALUES (:user_id, :tipo)');
        $stmt->execute([
            'user_id' => $user_id,
            'tipo' => 'normal'
        ]);

        $post_id = $pdo->lastInsertId(); // pega o id gerado

        // Inserir na tabela postnormal
        $stmt = $pdo->prepare('INSERT INTO postnormal (post_id, conteudo, image_path, file_path, youtube_link) 
                            VALUES (:post_id, :conteudo, :image_path, :file_path, :youtube_link)');
        $stmt->execute([
            'post_id' => $post_id,
            'conteudo' => $status,
            'image_path' => $image_path,
            'file_path' => $file_path,
            'youtube_link' => $youtube_link
        ]);

        // Redireciona para o feed
        header('Location: ../views/feed.php');
        exit();

    } catch (Exception $e) {
        echo 'Erro: ' . $e->getMessage();
    }
} else {
    echo 'Ação não permitida ou sessão expirada.';
}
