<?php
include '../../config/db.php';

// Inicia a sessão
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepara a consulta para verificar o usuário
    $stmt = $pdo->prepare('SELECT id, senha FROM users WHERE username = :username');
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch();

    // Verifica se o usuário existe e se a senha está correta
    if ($user && password_verify($password, $user['senha'])) {
        // Salva o ID do usuário na sessão
        $_SESSION['user_id'] = $user['id'];

        // Redireciona para a página do feed
        header('Location: feed.php');
        exit();
    } else {
        // Exibe mensagem de erro se o login falhar
        $error = 'Nome de usuário ou senha incorretos';
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        :root {
            --primary-color: #7289DA;
            --hover-color: #5865F2;
        }

        body {
            background-color: #1e2124;
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #fff;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
        }

        .login-box {
            background-color: #2c2f33;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 350px;
            text-align: center;
        }

        .logo {
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            text-align: left;
            display: block;
        }


        .form-control {
            width: 92%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #40444b;
            color: #fff;
            font-size: 16px;
        }

        .form-control::placeholder {
            color: #99AAB5;
            opacity: 1;
        }

        .btn {
            background-color: #7289DA;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: var(--hover-color);
        }

        p {
            margin-top: 20px;
            margin-bottom: -10px;
            color: #fff;
        }

        a {
            color: #7289DA;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #5a6fae;
        }

        .alert-danger {
            background-color: #ff4757;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: #32a852;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>

    <title>Login</title>
</head>

<body>
    <div class="login-container">
        <div class="login-box">

            <div class="logo">NextPlay</div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" style="color:#fff"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (!empty($_SESSION["success"])): ?>
                <div class="alert alert-success" style="color:#fff"><?php echo $_SESSION["success"]; ?></div>
                <?php unset($_SESSION["success"]); ?>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="form-group">
                    <label for="username">Nome de usuário:</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="username">Senha:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-dark">Login</button>
            </form>
            <p>Ainda não possui uma conta? <a href="register.php">Clique aqui</a></p>
            <p>Esqueceu a senha? <a href="forgotPassword.php">Clique aqui</a></p>
        </div>
    </div>
</body>

</html>

<?php 
?>