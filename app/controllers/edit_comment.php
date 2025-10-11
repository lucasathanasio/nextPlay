<?php
include '../../config/db.php';
include '../layouts/header.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

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

$redirect_page = '../views/feed.php'; // padrão

if (isset($_POST['from']) && $_POST['from'] === 'userPerfil' && isset($_POST['profile_id'])) {
    $redirect_page = 'userPerfil.php?id=' . $_POST['profile_id'];
} elseif (isset($_GET['from']) && $_GET['from'] === 'userPerfil' && isset($_GET['profile_id'])) {
    $redirect_page = 'userPerfil.php?id=' . $_GET['profile_id'];
}

// Atualizar comentário (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $comment_id = $_POST['comment_id'];
    $content = trim($_POST['content']);

    if (!empty($content)) {
        $query = $pdo->prepare("UPDATE comments SET content = ? WHERE id = ? AND user_id = ?");
        $query->execute([$content, $comment_id, $user_id]);
        $_SESSION['message'] = "Comentário atualizado com sucesso!";
    } else {
        $_SESSION['message'] = "O conteúdo do comentário não pode estar vazio.";
    }

    redirect($redirect_page);
} else {
    // Carregar formulário (GET)
    if (!isset($_GET['comment_id'])) {
        redirect($redirect_page);
    }

    $comment_id = $_GET['comment_id'];
    $query = $pdo->prepare("SELECT content FROM comments WHERE id = ? AND user_id = ?");
    $query->execute([$comment_id, $user_id]);

    $comment = $query->fetch();

    if (!$comment) {
        $_SESSION['message'] = "Comentário não encontrado ou você não tem permissão para editá-lo.";
        redirect($redirect_page);
    }
}
?>

<div class="card card-body" style="margin-left: 100px">
    <h2 style="color: #1e2124">Editar Comentário</h2>
    <form action="edit_comment.php" method="POST">
    <div class="form-group">
        <textarea name="content" class="form-control" rows="3"><?= htmlspecialchars($comment['content']) ?></textarea>
    </div>
    <input type="hidden" name="comment_id" value="<?= htmlspecialchars($comment_id) ?>">
    <input type="hidden" name="from" value="<?= htmlspecialchars($_GET['from'] ?? 'feed') ?>">
    
    <?php if (isset($_GET['profile_id'])): ?>
        <input type="hidden" name="profile_id" value="<?= htmlspecialchars($_GET['profile_id']) ?>">
    <?php endif; ?>
    
    <button type="submit" class="btn btn-primary btn-dark">Salvar Alterações</button>
    <a href="<?= $redirect_page ?>" class="btn btn-secondary btn-danger">Cancelar</a>
</form>
</div>
