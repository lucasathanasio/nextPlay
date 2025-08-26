<?php
session_start(); // Iniciar a sessão
include 'config/db.php';
include 'views/header.php'; // Inclui o cabeçalho

// Função para redirecionar com header
function redirect($url) {
    // Verifica se os headers já foram enviados ao navegador
    if (!headers_sent()) {
        // Se os headers ainda não foram enviados, usa a função header() para redirecionar o navegador para a URL especificada
        header('Location: ' . $url);
        exit();
    } else {
        // Se os headers já foram enviados, usa JavaScript para redirecionar o usuário
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
        exit();
    }
}

// Verifica se é uma solicitação POST para atualizar o post
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id']) && isset($_POST['post_id'])) {
    try {
        $post_id = $_POST['post_id'];
        $user_id = $_SESSION['user_id'];

        // Verifica se o post pertence ao usuário logado
        $stmt = $pdo->prepare('SELECT user_id, content, image_path, youtube_link FROM postnormal WHERE id = :id');
        $stmt->execute(['id' => $post_id]);
        $post = $stmt->fetch();

        if ($post && $post['user_id'] == $user_id) {
            // Atualizar conteúdo
            if (isset($_POST['content'])) {
                $new_content = $_POST['content'];
                $stmt = $pdo->prepare('UPDATE postnormal SET content = :content WHERE id = :id');
                $stmt->execute(['content' => $new_content, 'id' => $post_id]);
            }

            // Atualizar link do YouTube
            if (isset($_POST['youtube_link'])) {
                $new_youtube_link = $_POST['youtube_link'];
                $stmt = $pdo->prepare('UPDATE postnormal SET youtube_link = :youtube_link WHERE id = :id');
                $stmt->execute(['youtube_link' => $new_youtube_link, 'id' => $post_id]);
            }

            // Verificar se foi enviada uma nova imagem
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                if ($post['image_path'] && file_exists($post['image_path'])) {
                    unlink($post['image_path']); // Excluir a imagem antiga
                }

                // Salvar a nova imagem
                $image_path = 'uploads/' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

                // Atualizar caminho da imagem no post
                $stmt = $pdo->prepare('UPDATE postnormal SET image_path = :image_path WHERE id = :id');
                $stmt->execute(['image_path' => $image_path, 'id' => $post_id]);
            }

            // Redirecionar para o feed
            redirect('feed.php');
        } else {
            echo 'Ação não permitida.';
            exit();
        }
    } catch (Exception $e) {
        echo 'Erro: ' . $e->getMessage();
    }
} 
// Verifica se é uma solicitação GET para carregar o formulário de edição
else if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['post_id']) && isset($_SESSION['user_id'])) {
    try {
        $post_id = $_GET['post_id'];
        $user_id = $_SESSION['user_id'];

        // Verificar se o post pertence ao usuário logado
        $stmt = $pdo->prepare('SELECT user_id, content, image_path, youtube_link FROM postnormal WHERE id = :id');
        $stmt->execute(['id' => $post_id]);
        $post = $stmt->fetch();

        if ($post && $post['user_id'] == $user_id) {
            // Formulário para editar a postagem
            echo '<div class="container">';
            echo '<h2>Editar Postagem</h2>';
            echo '<form action="edit_post.php" method="post" enctype="multipart/form-data">';
            echo '<input type="hidden" name="post_id" value="' . htmlspecialchars($post_id) . '">';
            echo '<div class="form-group">';
            echo '<label for="content">Conteúdo:</label>';
            echo '<textarea class="form-control" name="content" id="content" rows="5">' . htmlspecialchars($post['content']) . '</textarea>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="youtube_link">Link do YouTube:</label>';
            echo '<input type="url" class="form-control" name="youtube_link" id="youtube_link" value="' . htmlspecialchars($post['youtube_link']) . '">';
            echo '</div>';
            if ($post['image_path']) {
                echo '<div class="form-group">';
                echo '<label for="current_image">Imagem Atual:</label>';
                echo '<img src="' . htmlspecialchars($post['image_path']) . '" class="img-fluid mb-3" alt="Post Image">';
                echo '</div>';
            }
            echo '<div class="form-group">';
            echo '<label for="image">Alterar Imagem:</label>';
            echo '<input type="file" class="form-control-file" name="image" id="image">';
            echo '</div>';
            echo '<button type="submit" class="btn btn-primary btn-success">Salvar Alterações</button>';
            echo '</form>';
            echo '</div>';
        } else {
            echo 'Ação não permitida.';
            exit();
        }
    } catch (Exception $e) {
        echo 'Erro: ' . $e->getMessage();
    }
} else {
    redirect('feed.php');
}
?>
