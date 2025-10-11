<?php
include '../../config/db.php';
require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../../vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Inicia a sessão
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Verifica se o e-mail existe no banco de dados
    $stmt = $pdo->prepare('SELECT id, email FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        // Gera uma nova senha aleatória
        $newPassword = bin2hex(random_bytes(4));
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Atualiza a nova senha no banco de dados
        $updateStmt = $pdo->prepare('UPDATE users SET senha = :senha WHERE id = :id');
        $updateStmt->execute(['senha' => $hashedPassword, 'id' => $user['id']]);

        // Configurações do PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Configuração do servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'lucasbuenodeandrade@eaportal.org';
            $mail->Password = 'utqscixvfpbylkif';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Remetente e destinatário
            $mail->setFrom('lucasbuenodeandrade@eaportal.org', 'NextPlay');
            $mail->addAddress($user['email']);

            // Conteúdo do e-mail
            $mail->isHTML(true);
            $mail->Subject = 'Redefinir senha';
            $mail->Body = 'Sua nova senha é: <strong>' . $newPassword . '</strong>. Por favor, altere-a assim que fizer login.';

            // Envio do e-mail
            if ($mail->send()) {
                $_SESSION["success"] = "Um email com sua nova senha foi enviado.";
            } else {
                $error = "Não foi possível enviar o email. Tente novamente mais tarde.";
            }
        } catch (Exception $e) {
            $error = "Erro ao enviar o email: {$mail->ErrorInfo}";
        }
    } else {
        $error = "Email não encontrado.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/styles.css">
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
        }

        label {
            display: block;
            text-align: left;
        }

        .form-control {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #40444b;
            color: #fff;
            font-size: 16px;
        }

        .form-control::placeholder {
            color: #99AAB5;
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
            color: #fff;
        }

        .alert-success {
            background-color: #32a852;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
            color: #fff;
        }
    </style>
    <title>Redefinir Senha</title>
</head>

<body>
    <div class="login-container">
        <div class="login-box">
            <div class="logo">NextPlay</div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (!empty($_SESSION["success"])): ?>
                <div class="alert alert-success"><?php echo $_SESSION["success"]; ?></div>
                <?php unset($_SESSION["success"]); ?>
            <?php endif; ?>

            <form action="forgotPassword.php" method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Digite seu email" required>
                </div>

                <button type="submit" name="reset_password" class="btn">Gerar nova senha</button>
            </form>
            <p><a href="login.php">Voltar</a></p>
        </div>
    </div>
</body>

</html>
