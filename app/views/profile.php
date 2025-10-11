<?php
session_start();
include '../../config/db.php';
include '../layouts/header.php';

if (empty($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

//Seleciona o user
$stmt = $pdo->prepare('SELECT username, profile_pic FROM users WHERE id = :id');
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NextPlay - perfil</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="styles.css" rel="stylesheet"> -->
    <style>
        body {
            background: #1e2124;
        }

        .custom-file-input {
            visibility: hidden;
            width: 0;
            height: 0;

        }

        .custom-file-label {
            display: inline-block;
            background-color: #7289da;
            color: #fff;
            padding: 10px 20px;
            border-color: #25292d;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }



        .custom-file-label:hover {
            background-color: #25292d;
            color: white;
        }

        .custom-file-label.selected {
            background-color: #25292d;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body text-center">
                        <?php if ($user['profile_pic']): ?>
                            <img src="<?php echo htmlspecialchars($user['profile_pic']); ?>" alt="Foto de perfil" class="img-thumbnail mb-3" style="width: 150px; height: 150px;">
                        <?php else: ?>
                            <img src="../../assets/profile_pics/perfil_sem_foto.png" alt="Perfil sem foto" class="img-thumbnail mb-3" style="width: 150px; height: 150px;">
                        <?php endif; ?>
                        <h2 class="card-title"><?php echo htmlspecialchars($user['username']); ?></h2>
                        <?php if (isset($_SESSION["error"])): ?>
                            <div class="alert alert-danger"><?php echo $_SESSION["error"]; ?></div>
                            <?php unset($_SESSION["error"]); ?>
                        <?php endif; ?>
                        <form action="profile_action.php" method="POST" enctype="multipart/form-data" class="mb-3">
 
                            <div class="custom-file">
                                <input type="file" id="file-upload" name="new_profile_pic" class="custom-file-input">
                                <label for="file-upload" class="custom-file-label">Selecione um arquivo</label>
                            </div>

                            <button type="submit" class="btn btn-primary btn-block btn-dark mt-3">Atualizar Foto</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('.custom-file-input').addEventListener('change', function(e) {
            var fileName = document.getElementById("file-upload").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    </script>
</body>

</html>