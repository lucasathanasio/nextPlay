<?php
session_start();
include '../../config/db.php';
include '../layouts/header.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    </style>
</head>
<body>
<div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <a href="../controllers/make_post.php" class="btn btn-primary btn-block btn-dark">Criar Post</a>
                        <a href="../controllers/make_post2.php" class="btn btn-primary btn-block btn-dark">Criar Convite</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>