<?php
session_start();
include '../../config/db.php';
include '../layouts/header.php';

// Função para redirecionar
function redirect($url) {
    if (!headers_sent()) {
        header('Location: ' . $url);
        exit();
    } else {
        echo '<script>window.location.href="' . $url . '";</script>';
        exit();
    }
}

// Pega de onde o usuário veio
$from = $_POST['from'] ?? $_GET['from'] ?? 'feed'; // padrão: feed

// Atualizar post (POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id']) && isset($_POST['post_id'])) {
    try {
        $user_id = $_SESSION['user_id'];
        $post_id = $_POST['post_id'];

        // Pega o postnormal_id e dados do post
        $stmt = $pdo->prepare('
            SELECT pn.id AS postnormal_id, p.user_id, pn.conteudo, pn.image_path, pn.youtube_link
            FROM postnormal pn
            JOIN posts p ON pn.post_id = p.id
            WHERE p.id = :post_id
        ');
        $stmt->execute(['post_id' => $post_id]);
        $post = $stmt->fetch();

        if ($post && $post['user_id'] == $user_id) {
            $postnormal_id = $post['postnormal_id'];

            // Atualiza conteúdo
            if (isset($_POST['conteudo'])) {
                $stmt = $pdo->prepare('UPDATE postnormal SET conteudo = :conteudo WHERE id = :id');
                $stmt->execute(['conteudo' => $_POST['conteudo'], 'id' => $postnormal_id]);
            }

            // Atualiza link do YouTube
            if (isset($_POST['youtube_link'])) {
                $stmt = $pdo->prepare('UPDATE postnormal SET youtube_link = :youtube_link WHERE id = :id');
                $stmt->execute(['youtube_link' => $_POST['youtube_link'], 'id' => $postnormal_id]);
            }

            // Atualiza imagem, se enviada
            if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                if ($post['image_path'] && file_exists($post['image_path'])) {
                    unlink($post['image_path']); // remove antiga
                }
                $image_path = 'uploads/' . basename($_FILES['image']['name']);
                move_uploaded_file($_FILES['image']['tmp_name'], $image_path);

                $stmt = $pdo->prepare('UPDATE postnormal SET image_path = :image_path WHERE id = :id');
                $stmt->execute(['image_path' => $image_path, 'id' => $postnormal_id]);
            }

            // Redireciona conforme a origem
            if ($from === 'feed') {
                redirect('../views/feed.php');
            } elseif ($from === 'userPerfil') {
                redirect('../views/userPerfil.php?id=' . $_SESSION['user_id']);
            } else {
                redirect('../views/feed.php');
            }

        } else {
            echo 'Ação não permitida.';
        }
    } catch (Exception $e) {
        echo 'Erro: ' . $e->getMessage();
    }
}

// Carregar formulário de edição (GET)
elseif ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['post_id']) && isset($_SESSION['user_id'])) {
    try {
        $user_id = $_SESSION['user_id'];
        $post_id = $_GET['post_id'];

        $stmt = $pdo->prepare('
            SELECT pn.id AS postnormal_id, p.user_id, pn.conteudo, pn.image_path, pn.youtube_link
            FROM postnormal pn
            JOIN posts p ON pn.post_id = p.id
            WHERE p.id = :post_id
        ');
        $stmt->execute(['post_id' => $post_id]);
        $post = $stmt->fetch();

        if ($post && $post['user_id'] == $user_id) {
            $postnormal_id = $post['postnormal_id'];

            echo '<div class="card" style="margin-left: 100px">';
            echo '<div class="card-body">';
            echo '<h2 style="color: #1e2124">Editar Postagem</h2>';
            echo '<form action="edit_post.php" method="post" enctype="multipart/form-data">';
            echo '<input type="hidden" name="post_id" value="' . htmlspecialchars($post_id) . '">';
            echo '<input type="hidden" name="from" value="' . htmlspecialchars($from) . '">'; // campo oculto com a origem

            echo '<div class="form-group">';
            echo '<label for="conteudo" style="color: #1e2124">Conteúdo:</label>';
            echo '<textarea class="form-control" name="conteudo" id="conteudo" rows="5">' . htmlspecialchars($post['conteudo']) . '</textarea>';
            echo '</div>';

            echo '<div class="form-group">';
            echo '<label for="youtube_link" style="color: #1e2124">Link do YouTube:</label>';
            echo '<input type="url" class="form-control" name="youtube_link" id="youtube_link" value="' . htmlspecialchars($post['youtube_link']) . '">';
            echo '</div>';

            if ($post['image_path']) {
                echo '<div class="form-group">';
                echo '<label style="color: #1e2124">Imagem Atual:</label><br>';
                echo '<img src="' . htmlspecialchars($post['image_path']) . '" class="img-fluid mb-3" style="width: 300px; height: 300px;">';
                echo '</div>';
            }

            echo '<div class="form-group">';
            echo '<label for="image" style="color: #1e2124">Alterar Imagem:</label>';
            echo '<input type="file" class="form-control" name="image" id="image">';
            echo '</div>';

            echo '<button type="submit" class="btn btn-success">Salvar Alterações</button>';
            echo '</form>';
            echo '</div>'; // fecha card-body
            echo '</div>'; // fecha card

        } else {
            echo 'Ação não permitida.';
        }
    } catch (Exception $e) {
        echo 'Erro: ' . $e->getMessage();
    }
} else {
    redirect('../views/feed.php');
}
?>
