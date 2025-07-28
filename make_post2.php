<?php
session_start();
include 'config/db.php';
include 'views/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Consultar os jogos
$jogosStmt = $pdo->prepare("SELECT * FROM jogos");
$jogosStmt->execute();
$jogos = $jogosStmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT username, profile_pic FROM users WHERE id = :id');
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();

$successMessage = ""; // Variável para armazenar a mensagem de sucesso

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jogo_id = $_POST['jogo_id'];
    $horario = $_POST['horario'];
    $max_jogadores = $_POST['max_jogadores'];
    $descricao = $_POST['descricao'];
    $user_id = $_SESSION['user_id'];

    // Preparar o INSERT
    $insertStmt = $pdo->prepare("INSERT INTO postjogo (jogo_id, horario, max_jogadores, descricao, id_criador, data_criacao) 
                                 VALUES (:jogo_id, :horario, :max_jogadores, :descricao, :id_criador, NOW())");
    $insertStmt->execute([
        ':jogo_id' => $jogo_id,
        ':horario' => $horario,
        ':max_jogadores' => $max_jogadores,
        ':descricao' => $descricao,
        ':id_criador' => $user_id,
    ]);

    $successMessage = "Convite criado com sucesso!";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NextPlay</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #1e2124;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        label {
            color: black;
        }

        .form-container {
            background-color: #7289da;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        textarea {
            height: 80px;
            resize: none;
        }

        button {
            background-color: #e53935;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c62828;
            transition: background-color 0.3s ease;
        }
    </style>
</head>

<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <?php if (!empty($successMessage)): ?>
                    <div class="alert alert-success text-center" role="alert">
                        <?= $successMessage; ?>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <select name="jogo_id" required>
                                <option value="" disabled selected>Selecione um jogo</option>
                                <?php foreach ($jogos as $jogo): ?>
                                    <option value="<?= htmlspecialchars($jogo['id']); ?>">
                                        <?= htmlspecialchars($jogo['nome']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>

                            <input type="time" name="horario" placeholder="Horário" style="width: 100%;" required>

                            <select name="max_jogadores" required>
                                <option value="" disabled selected>Quantidade necessária</option>
                                <option value="1">1 jogador</option>
                                <option value="2">2 jogadores</option>
                                <option value="3">3 jogadores</option>
                                <option value="4">4 jogadores</option>
                                <option value="5">5 jogadores</option>
                            </select>

                            <textarea name="descricao" placeholder="Descrição do post" required></textarea>

                            <button type="submit" class="btn btn-primary btn-block btn-dark">Postar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
