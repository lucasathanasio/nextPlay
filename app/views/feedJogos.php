<?php
session_start();
include '../../config/db.php';
include '../layouts/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query principal
if ($search) {
    $stmt = $pdo->prepare("
    SELECT pj.id, pj.descricao, pj.data_partida, pj.horario,
            u.username, u.profile_pic,
            j.nome AS jogo_nome,
            p.user_id
        FROM postjogo pj
        JOIN jogos j ON pj.jogo_id = j.id
        JOIN posts p ON pj.post_id = p.id
        JOIN users u ON p.user_id = u.id
        WHERE j.nome LIKE :search
        ORDER BY pj.data_partida DESC
    ");
    $stmt->execute(['search' => "%$search%"]);
} else {
    $stmt = $pdo->query("
        SELECT pj.id, pj.descricao, pj.data_partida, pj.horario,
               j.nome AS jogo_nome,
               p.user_id,
               u.username, u.profile_pic
        FROM postjogo pj
        JOIN jogos j ON pj.jogo_id = j.id
        JOIN posts p ON pj.post_id = p.id
        JOIN users u ON p.user_id = u.id
        ORDER BY pj.data_partida DESC
    ");
}

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1e2124;
            color: white;
        }

        .search-container {
            max-width: 1000px;
            margin: 0 auto;
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
        }

        .profile-view {
            background-color: #343a40;
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
            gap: 0 15px;
        }

        .post-container {
            max-width: 1000px;
            margin: 20px auto;
        }

        .card {
            background-color: #2c2f33;
            color: white;
            border: none;
            margin-bottom: 15px;
        }

        .profile-view {
            background-color: #343a40;
            color: white;
            padding: 10px 15px;
            border-radius: 14px;
            transition: all ease-in-out 0.3s;
        }

        .profile-view:hover {
            text-decoration: none;
            color: black;
        }
    </style>
</head>

<body style="margin-left: 100px">

    <div class="search-container">
    <form method="GET" action="" class="search">
        <input type="text" name="search" id="search-input" placeholder="Pesquisar convites pelo nome do jogo..." value="<?= htmlspecialchars($search) ?>">
        <button class="profile-view">Pesquisar</button>
    </form>
</div>

<div class="post-container">
    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $row): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <!-- Foto e nome do usuário -->
                    <div class="d-flex align-items-center mb-3">
                        <?php if (!empty($row['profile_pic'])): ?>
                            <img src="<?= htmlspecialchars($row['profile_pic']) ?>" alt="Foto do Usuário" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                        <?php endif; ?>
                        <span><strong><?= htmlspecialchars($row['username']) ?></strong></span>
                    </div>

                    <!-- Info do post -->
                    <p class="card-text">Jogo: <?= htmlspecialchars($row['jogo_nome']) ?></p>
                    <p class="card-text">Data da Partida: <?= date('d-m-Y', strtotime($row['data_partida'])) ?></p>
                    <p class="card-text">Horário: <?= date('H:i', strtotime($row['horario'])) ?></p>
                    <h5 class="card-title"><?= htmlspecialchars($row['descricao']) ?></h5> <br>
                    <a href="../chat/chat.php?user_id=<?= $row['user_id'] ?>" class="profile-view">Conversar</a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color:#fff">Nenhuma postagem encontrada</p>
    <?php endif; ?>
</div>

</body>
</html>