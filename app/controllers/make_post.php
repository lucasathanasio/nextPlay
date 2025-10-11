<?php
session_start();
include '../../config/db.php';
include '../layouts/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}


$stmt = $pdo->prepare('SELECT username, profile_pic FROM users WHERE id = :id');
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - Mini Rede Social</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="styles.css" rel="stylesheet"> -->
    <style>
        body {
            background: #1e2124;
        }

        label {
            color: black;
        }
    </style>
</head>

<body>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">

                        <form action="post_status.php" method="POST" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="status">Postar uma atualização de status:</label>
                                <textarea id="status" name="status" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="image">Upload de imagem:</label>
                                <input type="file" id="image" name="image" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="image">Arquivo:</label>
                                <input type="file" id="image" name="file" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="youtube_link">Link do YouTube:</label>
                                <input type="url" id="youtube_link" name="youtube_link" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary btn-block btn-dark">Postar</button>
                            <a href="make_post2.php" class="btn btn-primary btn-block btn-dark">Ir para Post de Jogo</a>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        
</body>

</html>