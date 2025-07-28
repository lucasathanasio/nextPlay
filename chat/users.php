<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Consultar todos os usuários, exceto o usuário logado
$stmt = $pdo->prepare("SELECT id, nome, foto FROM users WHERE id != :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$users = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Usuários - Chat</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="users-container">
        <h2>Selecione um usuário para conversar:</h2>
        <ul>
            <?php foreach ($users as $user): ?>
                <li>
                    <!-- Exibir a foto do usuário -->
                    <img src="images/<?= htmlspecialchars($user['foto']) ?>" alt="Foto de <?= htmlspecialchars($user['nome']) ?>" class="user-photo">
                    <a href="chat.php?user_id=<?= $user['id'] ?>"><?= htmlspecialchars($user['nome']) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
