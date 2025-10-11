<?php
session_start();
include('../../config/db.php');
include '../layouts/header.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$users = []; // Lista de usuários
$user_id = $_SESSION['user_id'];

// Lógica de pesquisa
if (isset($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%';

    $stmt = $pdo->prepare("SELECT id, username, profile_pic FROM users WHERE username LIKE :search AND id != :user_id");
    $stmt->bindParam(':search', $search, PDO::PARAM_STR);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // Exibição automática das conversas recentes
    $query = "
    SELECT 
        u.id AS id, 
        u.username, 
        u.profile_pic, 
        m.mensagem AS last_message, 
        m.timestamp AS last_message_time
    FROM 
        users u
    JOIN 
        (
            SELECT 
                CASE 
                    WHEN remetente_id = :user_id THEN destinatario_id 
                    ELSE remetente_id 
                END AS other_user_id, 
                MAX(timestamp) AS last_message_time
            FROM 
                messages
            WHERE 
                remetente_id = :user_id OR destinatario_id = :user_id
            GROUP BY 
                other_user_id
        ) last_messages 
    ON 
        u.id = last_messages.other_user_id
    JOIN 
        messages m
    ON 
        m.timestamp = last_messages.last_message_time 
        AND (
            (m.remetente_id = :user_id AND m.destinatario_id = u.id) OR 
            (m.destinatario_id = :user_id AND m.remetente_id = u.id)
        )
    ORDER BY 
        last_message_time DESC
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NextPlay - Conversas</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1e2124;
        }

        .search-container {
            max-width: 1000px;
            margin: 20px auto;
            color: white;
        }

        #search-input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            background-color: #2c2f33;
            color: #ffffff;
        }

        .profile-list {
            margin-top: 20px;
        }

        .profile-item {
            display: flex;
            align-items: center;
            background-color: #2c2f33;
            border-radius: 5px;
            padding: 10px;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .profile-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
            border: 2px solid #7289da;
        }

        .profile-info {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .profile-info .profile-name {
            font-size: 18px;
            color: #fff;
            font-weight: bold;
        }

        .profile-info .last-message {
            font-size: 14px;
            color: #b9bbbe;
            margin-top: 5px;
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            max-width: 200px;
        }

        .profile-view {
            background-color: #7289da;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
            transition: 0.3s;
        }

        .profile-view:hover {
            background-color: #5865F2;
            text-decoration: none;
            color: white;
        }

        .search {
            display: flex;
            gap: 15px;
        }
    </style>
</head>

<body>

    <div class="search-container">
        <form method="GET" action="" class="search">
            <input type="text" name="search" id="search-input" placeholder="Pesquisar perfis...">
            <button class="profile-view">Pesquisar</button>
        </form><br>

        <h2>Conversas</h2>

        <div class="profile-list" id="profile-list">
            <?php if (!empty($users)): ?>
                <?php foreach ($users as $user): ?>
                    <div class="profile-item">
                        <img src="<?= (!empty($user['profile_pic'])) ? $user['profile_pic'] : "../../assets/profile_pics/perfil_sem_foto.png" ?>" 
                             alt="<?= htmlspecialchars($user['username']) ?>" 
                             class="profile-image">
                        <div class="profile-info">
                            <span class="profile-name"><?= htmlspecialchars($user['username']) ?></span>
                            <?php if (isset($user['last_message'])): ?>
                                <small class="last-message"><?= htmlspecialchars($user['last_message']) ?></small>
                            <?php endif; ?>
                        </div>
                        <a href="../chat/chat.php?user_id=<?= $user['id'] ?>" class="profile-view">Conversar</a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="color:#fff">Nenhum perfil encontrado.</p>
            <?php endif; ?>
        </div>
    </div>

</body>

</html>
