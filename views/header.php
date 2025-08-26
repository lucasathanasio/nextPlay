<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NextPlay</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --primary-color: #7289DA;
        }

        .logo {
            margin-bottom: 50px;
            margin-top: 20px;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            transition: 0.3s;
        }

        .logo:hover {
            color: #99AAB5;
            cursor: default;
        }

        .sidebar {
            height: 100%;
            width: 150px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #1e2124;
            padding-top: 20px;
            z-index: 1000;
            overflow-x: hidden;
            transition: 0.5s;
            border-right: #7289da 1px solid;
            display: flex;
            justify-content: start;
            flex-direction: column;
            align-items: center;
        }

        .sidebar li {
            display: flex;
            align-items: center;
        }

        .sidebar a,
        .sidebar i {
            padding: 10px 5px;
            text-decoration: none;
            font-size: 18px;
            color: #7289da;
            display: block;
            transition: 0.3s;
        }

        .sidebar i {
            font-size: 30px;
        }

        .sidebar li:hover a,
        .sidebar li:hover i {
            color: #99AAB5;
            text-decoration: none;
        }

        .sidebar svg {
            margin: 0 auto;
            display: block;
        }

        .content {
            margin-left: 260px;
            padding: 20px;
        }

        .footer {
            background-color: #7289da;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
            bottom: 0;
            width: 100%;
        }

        .card-body {
            background-color: #7289da;
            border: 0;
            color: #1e2124;
        }

        small {
            color: #1e2124;
        }

        body {
            background: #1e2124;
        }

        h2 {
            margin-top: 30px;
            color: var(--primary-color);
        }

        label {
            color: var(--primary-color);
        }

        
    </style>
</head>

<body>
    <script>
        window.onbeforeunload = function() {
            localStorage.setItem('scrollPosition', window.scrollY);
        };

        window.onload = function() {
            const scrollPosition = localStorage.getItem('scrollPosition');
            if (scrollPosition !== null) {
                window.scrollTo(0, scrollPosition);
            }
        };
    </script>

    <div class="sidebar">
        
        <div class="logo">NextPlay</div>


        <ul class="navbar-nav">
            <?php if (isset($_SESSION['user_id'])): ?>
                <li>
                    <i class="bi bi-house"></i>
                    <a href="feed.php">Home</a>
                </li>

                <li>
                    <i class="bi bi-controller"></i>
                    <a href="feedJogos.php">Convites</a>
                </li>

                <li>
                    <i class="bi bi-person-circle"></i>
                    <a href="userPerfil.php">Perfil</a>
                </li>

                <li>
                    <i class="bi bi-chat"></i>
                    <a href="users.php">Bate bapo</a>
                </li>

                <li>
                    <i class="bi bi-search"></i>
                    <a href="search.php">Pesquisar</a>
                </li>

                <li>
                    <i class="bi bi-plus-square"></i>
                    <a href="choosePost.php">Criar post</a>
                </li>

                <li>
                    <i class="bi bi-door-closed"></i>
                    <a href="logout.php">Logout</a>
                </li>
            <?php else: ?>

            <?php endif; ?>
        </ul>
    </div>
    <div class="container mt-4">