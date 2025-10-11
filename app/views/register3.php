<?php
include '../../config/db.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$user_id = $_GET["id"] ?? "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];

    $_SESSION['success'] = "Conta criada com sucesso";

    // Redireciona para a página do feed
    header('Location: login.php');
    exit();
}


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        :root {
            --primary-color: #7289DA;
            --secondary-color: #99AAB5;
            --background-color: #1e2124;
            --text-color: #FFFFFF;
            --accent-color: #43B581;
            --hover-color: #5865F2;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--background-color);
            color: var(--text-color);
            line-height: 1.6;
            overflow-x: hidden;
        }

        .plans {
            background-color: #1e2124;
            padding: 100px 20px;
            text-align: center;
        }

        .plans h2 {
            margin-bottom: 50px;
        }

        .plan-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .plan-item {
            background-color: rgba(255, 255, 255, 0.05);
            padding: 30px;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .plan-item:hover {
            transform: scale(1.05);
        }

        .plan-name {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .plan-price {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .plan-features {
            list-style: none;
            margin-bottom: 30px;
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
            text-decoration: none;
        }

        .btn:hover {
            background-color: var(--hover-color);
        }
    </style>

    <title>Escolha seu plano</title>
</head>

<body>
    <section id="plans" class="plans">
        <div class="container">
            <h2>Escolha seu plano</h2>
            <div class="plan-grid">
                <div class="plan-item">
                    <div class="plan-name">Básico</div>
                    <div class="plan-price">Grátis</div>
                    <ul class="plan-features">
                        <li>Acesso a comunidades</li>
                        <li>Chat em tempo real</li>
                        <li>Perfil personalizável</li>
                    </ul>
                    <form method="post">
                        <input type="hidden" name="id" value="<?= $user_id ?>">
                        <button class="btn">Comece Agora</button>
                    </form>
                </div>
                <div class="plan-item">
                    <div class="plan-name">Pro</div>
                    <div class="plan-price">R$9.99/mês</div>
                    <ul class="plan-features">
                        <li>Todos os resursos do Plano Básico</li>
                        <li>Sem anúncios</li>
                        <li>Badges exclusivos</li>
                    </ul>
                    <form method="post">
                        <input type="hidden" name="id" value="<?= $user_id ?>">
                        <button class="btn">Experimente</button>
                    </form>
                </div>
                <div class="plan-item">
                    <div class="plan-name">Ultimate</div>
                    <div class="plan-price">R$19.99/mês</div>
                    <ul class="plan-features">
                        <li>Todos os recursos do Plano Pro</li>
                        <!-- <li>Hospedagem de eventos VIP</li> -->
                        <li>Análises avançadas</li>
                        <li>Acesso antecipado a novos recursos</li>
                    </ul>
                    <form method="post">
                        <input type="hidden" name="id" value="<?= $user_id ?>">
                        <button class="btn">Experimente</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>


</html>

<?php
?>