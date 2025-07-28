<?php
include 'config/db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$user_id = $_GET["id"] ?? "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = $_POST['id'];

    $profile_pic = NULL;

    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == UPLOAD_ERR_OK) {

        $upload_dir = 'profile_pics/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $profile_pic = $upload_dir . basename($_FILES['profile_pic']['name']);
        move_uploaded_file($_FILES['profile_pic']['tmp_name'], $profile_pic);
    }

    try {
        $stmt = $pdo->prepare('UPDATE users SET profile_pic = :profile_pic WHERE id = :id');
        $stmt->execute(['profile_pic' => $profile_pic, 'id' => $id]);

        $_SESSION["success"] = "Selecione seu plano para finalizar o cadastro";
        header('Location: register3.php?id=' . $id);
        exit();
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            $error = 'Nome de usuário ou e-mail já existe. Por favor, escolha outro.';
        } else {
            $error = 'Erro ao registrar usuário: ' . $e->getMessage();
        }
    }
}

#include 'views/header.php'; // Inclua o cabeçalho

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">

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

        .alert-success {
            background-color: #32a852;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 20px;
            display: block;
            object-fit: cover;
            border: 3px solid #3498db;
        }

        .default-avatar {
            background: #e0e0e0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .default-avatar svg {
            width: 60%;
            height: 60%;
            fill: #999;
        }

        .file-input-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .custom-file-input {
            display: none;
        }

        .file-input-label {
            background: var(--primary-color);
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .file-input-label:hover {
            background: #2980b9;
        }
    </style>


    <title>Escolha sua foto de perfil</title>
</head>

<body>
    <div class="login-container">
        <div class="login-box">

            <div class="logo">NextPlay</div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" style="color:#fff"><?php echo $error; ?></div>
            <?php endif; ?>

            <?php if (!empty($_SESSION["success"])): ?>
                <div id="message" class="alert alert-success" style="color:#fff"><?php echo $_SESSION["success"]; ?></div>
                <?php unset($_SESSION["success"]); ?>
            <?php endif; ?>

            <form action="register2.php" method="POST" enctype="multipart/form-data">
                <div class="profile-picture default-avatar" id="profilePicture">
                    <svg viewBox="0 0 24 24">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                </div>

                <div class="file-input-container">
                    <label class="file-input-label" for="imageInput">
                        Escolher Imagem
                    </label>
                    <input type="file" name="profile_pic" id="imageInput" class="custom-file-input" accept="image/*">
                    <input type="hidden" name="id" value="<?= $user_id ?>">
                </div>

                <button type="submit" class="btn btn-primary btn-dark">Registrar</button>
            </form>
        </div>
    </div>
</body>

<script>
    const message = document.getElementById('message');

    if (message) {
        setTimeout(() => {
            message.style.transition = "opacity 0.5s";
            message.style.opacity = "0";
            setTimeout(() => message.remove(), 500);
        }, 5000);
    }
</script>

<script>
    const imageInput = document.getElementById('imageInput');
    const profilePicture = document.getElementById('profilePicture');
    const errorMessage = document.getElementById('errorMessage');

    imageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];

        if (file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    profilePicture.classList.remove('default-avatar');
                    profilePicture.innerHTML = '';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.classList.add('profile-picture');
                    img.alt = "Foto de perfil do usuário";

                    profilePicture.appendChild(img);

                    errorMessage.style.display = 'none';
                };

                reader.onerror = function() {
                    errorMessage.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                errorMessage.style.display = 'block';
                errorMessage.textContent = 'Por favor, selecione um arquivo de imagem válido.';
            }
        }
    });
</script>

</html>

<?php 
?>