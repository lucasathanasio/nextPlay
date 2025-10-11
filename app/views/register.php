<?php
include '../../config/db.php'; 

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare('INSERT INTO users (username, email, senha, data_cadastro, tipo) VALUES (:username, :email, :senha, CURDATE(), "comum")');
        $stmt->execute(['username' => $username, 'email' => $email, 'senha' => $password]);

        $userId = $pdo->lastInsertId();

        $_SESSION["success"] = "Primeira parte do cadastro realizado com sucesso!!";
        header('Location: register2.php?id=' . $userId);
        exit();
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            $error = 'Nome de usuário ou e-mail já existe. Por favor, escolha outro.';
        } else {
            $error = 'Erro ao registrar usuário: ' . $e->getMessage();
        }
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

        /* Container principal */
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
        }

        /* Caixa de login */
        .login-box {
            background-color: #2c2f33;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }

        .logo {
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
        }

        /* Input fields */
        .form-group {
            margin-bottom: 20px;
            position: relative;
            text-align: start;
            color: white;
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

        /* Botão de registro */
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

        /* Texto de link para login */
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

        /* Alerta de erro */
        .alert-danger {
            background-color: #ff4757;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>


    <title>Registrar</title>
</head>

<body>
    <div class="login-container">
        <div class="login-box">

            <div class="logo">NextPlay</div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" style="color:#fff"><?php echo $error; ?></div>
            <?php endif; ?>
            <form action="register.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="username">Nome de usuário:</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Senha:</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary btn-dark">Registrar</button>
            </form>
            <p>Já possui uma conta? <a href="login.php">Faça login aqui</a></p>
        </div>
    </div>
</body>

</html>

<?php 
?>