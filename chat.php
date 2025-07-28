<?php
session_start();
require('./config/db.php');
include './views/header.php';


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$destinatario_id = $_GET['user_id'];


$stmt = $pdo->prepare("SELECT username FROM users WHERE id = :id");
$stmt->execute(['id' => $destinatario_id]);
$destinatario = $stmt->fetch();


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
    <title>Chat com <?= htmlspecialchars($destinatario['username']); ?></title>
    <link rel="stylesheet" href="./styleChat.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="chat-container">
        <h3>Conversando com: <?= htmlspecialchars($destinatario['username']); ?></h3>
        <div class="messages" id="messages">

        </div>
        <form id="messageForm" method="POST">
            <input type="text" name="mensagem" id="mensagem" placeholder="Digite sua mensagem...">
            <button type="submit">Enviar</button>
        </form>
    </div>
    
    <script>
        function loadMessages() {
            $.ajax({
                url: "ajax_chat.php",
                type: "GET",
                data: {
                    destinatario_id: <?= $destinatario_id ?>
                },
                success: function(data) {
                    $('#messages').html(data);
                }
            });
        }

        $(document).ready(function() {
            loadMessages();
            setInterval(loadMessages, 2000);

            $('#messageForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "chat.php?user_id=<?= $destinatario_id ?>",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function() {
                        $('#mensagem').val('');
                        loadMessages();
                    }
                });
            });
        });
    </script>
</body>

</html>