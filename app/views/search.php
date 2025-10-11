<?php
session_start();
include '../../config/db.php';
include '../layouts/header.php';

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$result = [];

// Verificar se a busca foi feita
if (isset($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%'; // Preparar a string de busca

    // Preparar a consulta
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username LIKE :search");
    $stmt->bindParam(':search', $search, PDO::PARAM_STR);

    // Executar a consulta
    $stmt->execute();

    // Verificar e exibir resultados
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NextPlay - Pesquisar</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #1e2124;
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

        .profile-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 15px;
        }

        .profile-name {
            flex-grow: 1;
            color: #fff;
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

        .profile-view:hover{
            background-color: #5865F2;
            text-decoration: none;
            color: white;
        }

        .search {
            display: flex;
            gap: 0 15px;
        }
    </style>
</head>

<body>

    <div class="search-container">
        <form method="GET" action="" class="search">
            <input type="text" name="search" id="search-input" placeholder="Pesquisar perfis...">
            <button class="profile-view">Pesquisar</button>
        </form>

        <div class="profile-list" id="profile-list">
            <?php if (!empty($result)): ?>
                <?php foreach ($result as $user): ?>

                    <div class="profile-item">
                        <img src="<?= (!empty($user['profile_pic'])) ? $user['profile_pic'] : "../../assets/profile_pics/perfil_sem_foto.png" ?>" alt="${profile.name}" class="profile-image">
                        <span class="profile-name"><?= $user['username'] ?></span>
                        <a href="userPerfil.php?id=<?=$user['id']?>" class="profile-view">Ver</a>
                    </div>

                <?php endforeach; ?>

            <?php else: ?>
                <p style="color:#fff">Nenhum perfil encontrado</p>
            <?php endif; ?>

        </div>
    </div>

</body>

</html>