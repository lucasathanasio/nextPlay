<?php
session_start();
include 'config/db.php';
include 'views/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$result = [];

// Verificar se a busca foi feita
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%'; // Preparar a string de busca

    // Preparar a consulta para filtrar os jogos
    $stmt = $pdo->prepare("
        SELECT postjogo.id, postjogo.id_criador, postjogo.jogo_id, postjogo.horario, postjogo.max_jogadores, 
               DATE_FORMAT(postjogo.data_criacao, '%d/%m/%Y %H:%i') AS data_criacao, postjogo.descricao, jogos.nome AS nome_jogo,
               users.username, users.profile_pic
        FROM postjogo
        JOIN jogos ON postjogo.jogo_id = jogos.id
        JOIN users ON postjogo.id_criador = users.id
        WHERE jogos.nome LIKE :search
        ORDER BY postjogo.data_criacao DESC
    ");
    $stmt->bindParam(':search', $search, PDO::PARAM_STR);
} else {
    // Caso contrário, buscar todos os jogos
    $stmt = $pdo->query("
        SELECT postjogo.id, postjogo.id_criador, postjogo.jogo_id, postjogo.horario, postjogo.max_jogadores, 
               DATE_FORMAT(postjogo.data_criacao, '%d/%m/%Y %H:%i') AS data_criacao, postjogo.descricao, jogos.nome AS nome_jogo,
               users.username, users.profile_pic
        FROM postjogo
        JOIN jogos ON postjogo.jogo_id = jogos.id
        JOIN users ON postjogo.id_criador = users.id
        ORDER BY postjogo.data_criacao DESC
    ");
}


// Executar a consulta e obter resultados
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);


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

<body>

    <div class="search-container">
        <form method="GET" action="" class="search">
            <input type="text" name="search" id="search-input" placeholder="Pesquisar convites pelo nome do jogo...">
            <button class="profile-view">Pesquisar</button>
        </form>
    </div>

    <div class="post-container">
        <?php if (!empty($result)): ?>
            <?php foreach ($result as $row): ?>
                <?php
                // Mover a criação do objeto DateTime para dentro do loop
                $created_at = new DateTime($row['data_criacao']);
                $created_at->modify('-3 hours'); // Diminui 3 horas
                ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <!-- Exibir a foto e o nome do usuário -->
                        <div class="d-flex align-items-center mb-3">
                            <?php if (!empty($row['profile_pic'])): ?>
                                <img src="<?= htmlspecialchars($row['profile_pic']) ?>" alt="Foto do Usuário" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 10px;">
                            <?php endif; ?>
                            <span><strong><?= htmlspecialchars($row['username']) ?></strong></span>
                        </div>

                        <p class="card-text">Jogo: <?= htmlspecialchars($row['nome_jogo']) ?></p>
                        <p class="card-text">Horário: <?= htmlspecialchars($row['horario']) ?></p>
                        <p class="card-text">Máximo de Jogadores: <?= htmlspecialchars($row['max_jogadores']) ?></p>
                        <h5 class="card-title"><?= htmlspecialchars($row['descricao']) ?></h5>
                        <?php echo "<p class='text-muted'><small class='d-block mt-2'>Criado em: " . htmlspecialchars($created_at->format('d/m/Y - H:i')) . "</small></p>"; ?>
                        <?php echo "<a href='chat.php?user_id=" . $row['id_criador']  . "'class='profile-view'>Conversar</a>"; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color:#fff">Nenhuma postagem encontrada</p>
        <?php endif; ?>
    </div>

</body>

</html>