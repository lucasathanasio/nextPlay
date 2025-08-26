<?php
include 'config/db.php';
include 'views/header.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

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

    // Redirecionar com JavaScript
    echo '<script type="text/javascript">';
    echo 'window.location.href = "feed.php";';
    echo '</script>';
    exit();
} else {
    if (!isset($_GET['comment_id'])) {
        header('Location: feed.php');
        exit();
    }

    $comment_id = $_GET['comment_id'];
    $query = $pdo->prepare("SELECT content FROM comments WHERE id = ? AND user_id = ?");
    $query->execute([$comment_id, $user_id]);

    $comment = $query->fetch();

    if (!$comment) {
        $_SESSION['message'] = "Comentário não encontrado ou você não tem permissão para editá-lo.";
        header('Location: feed.php');
        exit();
    }
}
?>

<div class="container">
    <h2>Editar Comentário</h2>
    <form action="edit_comment.php" method="POST">
        <div class="form-group">
            <textarea name="content" class="form-control" rows="3"><?= htmlspecialchars($comment['content']) ?></textarea>
        </div>
        <input type="hidden" name="comment_id" value="<?= htmlspecialchars($comment_id) ?>">
        <button type="submit" class="btn btn-primary btn-dark">Salvar Alterações</button>
        <a href="feed.php" class="btn btn-secondary btn-danger">Cancelar</a>
    </form>
</div>
