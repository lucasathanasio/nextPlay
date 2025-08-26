

<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$destinatario_id = $_GET['user_id'];

// Recuperar o nome da pessoa com quem o usuário está conversando
$stmt = $pdo->prepare("SELECT nome FROM users WHERE id = :id");
$stmt->execute(['id' => $destinatario_id]);
$destinatario = $stmt->fetch();

// Função para sair e encerrar a sessão
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensagem = $_POST['mensagem'];
    $stmt = $pdo->prepare("INSERT INTO messages (remetente_id, destinatario_id, mensagem) VALUES (:remetente_id, :destinatario_id, :mensagem)");
    $stmt->execute(['remetente_id' => $_SESSION['user_id'], 'destinatario_id' => $destinatario_id, 'mensagem' => $mensagem]);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat com <?= htmlspecialchars($destinatario['nome']); ?></title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<body>
    <div class="chat-container">
        <!-- Botões de Sair e Voltar -->
        <div class="button-group">
            <a href="chat.php?logout=true" class="logout-button">Sair</a>
            <a href="users.php" class="back-button">Voltar</a>
        </div>
        <!-- Exibir o nome da pessoa com quem você está conversando -->
        <h3>Conversando com: <?= htmlspecialchars($destinatario['nome']); ?></h3>
        <div class="messages" id="messages"></div>
        <form id="messageForm" method="POST">
            <input type="text" name="mensagem" id="mensagem" placeholder="Digite sua mensagem..." required>
            <button type="submit">Enviar</button>
        </form>
    </div>


    <script>
        function loadMessages() {
            $.ajax({
                url: "ajax_chat.php",
                type: "GET",
                data: { destinatario_id: <?= $destinatario_id ?> },
                success: function (data) {
                    $('#messages').html(data);
                    scrollToBottom();  // Certifica-se de que a barra de rolagem está sempre no final
                }
            });
        }

        function scrollToBottom() {
            var messagesDiv = document.getElementById("messages");
            messagesDiv.scrollTop = messagesDiv.scrollHeight;
        }

        $(document).ready(function () {
            loadMessages();
            setInterval(loadMessages, 2000);

            $('#messageForm').submit(function (e) {
                e.preventDefault();
                $.ajax({
                    url: "chat.php?user_id=<?= $destinatario_id ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function () {
                        $('#mensagem').val('');
                        loadMessages();
                    }
                });
            });
        });
    </script>
</body>
</html>
