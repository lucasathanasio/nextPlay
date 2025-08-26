<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: black;
        }

        .ellipsis-container {
            position: relative;
        }

        .ellipsis {
            cursor: pointer;
            font-size: 30px;
            user-select: none;
        }

        .dropdown {
            position: absolute;
            right: 0;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
            display: none;
            width: 120px;
            z-index: 1000;
        }

        .dropdown ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .dropdown li {
            padding: 10px;
            border-bottom: 1px solid #f4f4f4;
        }

        .dropdown li:last-child {
            border-bottom: none;
        }

        .dropdown li a {
            text-decoration: none;
            color: #333;
            display: block;
        }

        .dropdown.active {
            display: block;
        }

        .btn.btn-danger,
        .btn.btn-primary {
            width: 100%;
        }

        .post-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            color: white;
        }
    </style>
</head>

<body>
    <div class="post-container">
        <?php
        include './config/db.php';
        include 'views/header.php';

        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location: login.php');
            exit();
        }

        $user_id = $_SESSION['user_id'];

        // Mensagem de sucesso ou erro
        if (isset($_SESSION['message'])) {
            echo "<div class='alert alert-info' role='alert'>" . htmlspecialchars($_SESSION['message']) . "</div>";
            unset($_SESSION['message']);
        }

        // Processa ação de like e dislike
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['like'])) {
                $post_id = $_POST['post_id'];

                // Verifica se o usuário já deu like
                $query = $pdo->prepare("SELECT * FROM likes WHERE user_id = ? AND post_id = ?");
                $query->execute([$user_id, $post_id]);

                if ($query->fetch()) {
                    // Se já deu like, remove o like
                    $query = $pdo->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
                    $query->execute([$user_id, $post_id]);
                } else {
                    // Caso contrário, adiciona o like e remove o dislike (se existir)
                    $query = $pdo->prepare("INSERT INTO likes (user_id, post_id) VALUES (?, ?)");
                    $query->execute([$user_id, $post_id]);
                    $query = $pdo->prepare("DELETE FROM dislikes WHERE user_id = ? AND post_id = ?");
                    $query->execute([$user_id, $post_id]);
                }
            } elseif (isset($_POST['dislike'])) {
                $post_id = $_POST['post_id'];

                // Verifica se o usuário já deu dislike
                $query = $pdo->prepare("SELECT * FROM dislikes WHERE user_id = ? AND post_id = ?");
                $query->execute([$user_id, $post_id]);

                if ($query->fetch()) {
                    // Se já deu dislike, remove o dislike
                    $query = $pdo->prepare("DELETE FROM dislikes WHERE user_id = ? AND post_id = ?");
                    $query->execute([$user_id, $post_id]);
                } else {
                    // Caso contrário, adiciona o dislike e remove o like (se existir)
                    $query = $pdo->prepare("INSERT INTO dislikes (user_id, post_id) VALUES (?, ?)");
                    $query->execute([$user_id, $post_id]);
                    $query = $pdo->prepare("DELETE FROM likes WHERE user_id = ? AND post_id = ?");
                    $query->execute([$user_id, $post_id]);
                }
            }
        }


        // Exibe as postagens
        $stmt = $pdo->query('SELECT postnormal.id, users.username, users.profile_pic, postnormal.content, postnormal.image_path, postnormal.file_path, postnormal.youtube_link, postnormal.created_at, postnormal.user_id FROM postnormal JOIN users ON postnormal.user_id = users.id ORDER BY postnormal.created_at DESC');
        while ($row = $stmt->fetch()) {
            echo "<div class='card mb-3'>";
            echo "<div class='card-body'>";
            echo "<div class='media'>";
            if ($row['profile_pic']) {
                echo "<img src='" . htmlspecialchars($row['profile_pic']) . "' class='mr-3 rounded-circle' alt='Profile Picture' style='width: 50px; height: 50px;'>";
            } else {
                echo "<img src='default-profile.png' class='mr-3 rounded-circle' alt='Default Profile Picture' style='width: 50px; height: 50px;'>";
            }
            echo "<div class='media-body'>";
            echo "<h5 class='mt-0'>" . htmlspecialchars($row['username']) . "</h5>";
            echo "<p>" . htmlspecialchars($row['content']) . "</p>";

            // Diminui 3 horas à data de criação
            $created_at = new DateTime($row['created_at']);
            $created_at->modify('-3 hours'); // Diminui 3 horas
            echo "<p class='text-muted'><small class='d-block mt-2'>" . htmlspecialchars($created_at->format('d-m-Y - H:i:s')) . "</small></p>"; // Formata a data e hora

            // Exibe os três pontinhos (menu de opções)
            if ($row['user_id'] == $user_id) {
                echo "<div class='ellipsis-container'>";
                echo "    <div class='ellipsis' id='ellipsis-btn'>";
                echo "        &#x2022;&#x2022;&#x2022;";
                echo "    </div>";

                echo "    <div class='dropdown' id='dropdown-menu'>";
                echo "        <ul>";
                echo "            <li>";
                echo "                <form action='edit_post.php' method='GET' style='display:inline;'>";
                echo "                    <input type='hidden' name='post_id' value='" . $row['id'] . "'>";
                echo "                    <button type='submit' class='btn btn-primary btn-sm'>Editar</button>";
                echo "                </form>";
                echo "            </li>";
                echo "            <li>";
                echo "                <form action='delete_post.php' method='POST' style='display:inline;'>";
                echo "                    <input type='hidden' name='post_id' value='" . $row['id'] . "'>";
                echo "                    <button type='submit' class='btn btn-danger btn-sm'>Excluir</button>";
                echo "                </form>";
                echo "            </li>";
                echo "        </ul>";
                echo "    </div>";
                echo "</div>";
            }

            if ($row['image_path']) {
                echo "<img src='" . htmlspecialchars($row['image_path']) . "' class='img-fluid rounded mb-3' alt='Post Image' style='width: 300px; height: auto;'>";
            }

            if ($row['youtube_link']) {
                preg_match('/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $row['youtube_link'], $matches);
                if (isset($matches[1])) {
                    $youtube_id = $matches[1];
                    echo "<div class='embed-responsive embed-responsive-16by9 mb-3'>";
                    echo "<iframe class='embed-responsive-item' src='https://www.youtube.com/embed/" . htmlspecialchars($youtube_id) . "' allowfullscreen></iframe>";
                    echo "</div>";
                }
            }

            if ($row['file_path']) {
                echo "<div class='mb-3'>";
                echo "<a href='" . htmlspecialchars($row['file_path']) . "' class='btn btn-secondary' download>Baixar Arquivo</a>";
                echo "</div>";
            }

            // Exibe os comentários da postagem
            $comments_stmt = $pdo->prepare('SELECT comments.id, comments.user_id, comments.content, comments.created_at, users.username FROM comments JOIN users ON comments.user_id = users.id WHERE comments.post_id = ? ORDER BY comments.created_at ASC');
            $comments_stmt->execute([$row['id']]);

            echo "<div class='comments-section'>";
            while ($comment = $comments_stmt->fetch()) {
                echo "<div class='border rounded p-2 mb-2'>";
                echo "<p><strong>" . htmlspecialchars($comment['username']) . ":</strong> " . htmlspecialchars($comment['content']) . "</p>";
                echo "<p class='text-muted'><small>" . htmlspecialchars($comment['created_at']) . "</small></p>";

                if ($comment['user_id'] == $user_id) {
                    echo "<div class='ellipsis-container'>";
                    echo "    <div class='ellipsis' id='ellipsis-btn-comment-" . $comment['id'] . "'>";
                    echo "        &#x2022;&#x2022;&#x2022;";
                    echo "    </div>";

                    echo "    <div class='dropdown' id='dropdown-menu-comment-" . $comment['id'] . "'>";
                    echo "        <ul>";

                    echo "            <li>";
                    echo "                <form action='edit_comment.php' method='GET' style='display:inline;'>";
                    echo "                    <input type='hidden' name='comment_id' value='" . $comment['id'] . "'>";
                    echo "                    <button type='submit' class='btn btn-primary btn-sm'>Editar</button>";
                    echo "                </form>";
                    echo "            </li>";

                    echo "            <li>";
                    echo "                <form action='delete_comment.php' method='POST' style='display:inline;'>";
                    echo "                    <input type='hidden' name='comment_id' value='" . $comment['id'] . "'>";
                    echo "                    <button type='submit' class='btn btn-danger btn-sm'>Excluir</button>";
                    echo "                </form>";
                    echo "            </li>";

                    echo "        </ul>";
                    echo "    </div>";
                    echo "</div>";
                }

                echo "</div>";
            }
            echo "</div>";

            /// Formulário para adicionar um novo comentário
            echo "<form action='add_comment.php' method='POST'>";
            echo "<input type='hidden' name='post_id' value='" . $row['id'] . "'>";
            echo "<textarea name='content' class='form-control mb-2' placeholder='Adicione um comentário'></textarea>";
            echo "<button type='submit' class='btn btn-dark btn-sm'>Comentar</button>";
            echo "</form>";

            $stmt_likes = $pdo->prepare('SELECT COUNT(*) FROM likes WHERE user_id = :user_id AND post_id = :post_id');
            $stmt_likes->execute(['user_id' => $user_id, 'post_id' => $row["id"]]);
            $liked = $stmt_likes->fetchColumn() > 0;

            $stmt_dislikes = $pdo->prepare('SELECT COUNT(*) FROM dislikes WHERE user_id = :user_id AND post_id = :post_id');
            $stmt_dislikes->execute(['user_id' => $user_id, 'post_id' => $row["id"]]);
            $disliked = $stmt_dislikes->fetchColumn() > 0;

            $likeButtonClass = $liked ? 'btn-success' : 'btn-secondary';
            $dislikeButtonClass = $disliked ? 'btn-success' : 'btn-secondary';

            // Botões de like e deslike
            echo "<div style='text-align: left; margin-top: 10px;'>";
            echo "<form method='POST' style='display:inline;'>";
            echo "<input type='hidden' name='post_id' value='" . $row['id'] . "'>";
            echo "<button type='submit' name='like' class='btn $likeButtonClass'>❤</button>";
            echo "<button type='submit' name='dislike' class='btn $dislikeButtonClass' style='margin-left: 10px;'>👎</button>";
            echo "</form>";
            echo "</div>";

            // Conta o número de likes e dislikes
            $query = $pdo->prepare("SELECT COUNT(*) AS like_count FROM likes WHERE post_id = ?");
            $query->execute([$row['id']]);
            $like_count = $query->fetch()['like_count'] ?? 0;

            $query = $pdo->prepare("SELECT COUNT(*) AS dislike_count FROM dislikes WHERE post_id = ?");
            $query->execute([$row['id']]);
            $dislike_count = $query->fetch()['dislike_count'] ?? 0;

            echo "<p class='text-muted'><small>" . $like_count . " likes | " . $dislike_count . " dislikes</small></p>";

            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }


        // include 'views/footer.php';
        ?>

        <script>
            const ellipsisBtn = document.getElementById('ellipsis-btn');
            const dropdownMenu = document.getElementById('dropdown-menu');

            ellipsisBtn.addEventListener('click', () => {
                dropdownMenu.classList.toggle('active');
            });

            document.addEventListener('click', (event) => {
                if (!ellipsisBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.remove('active');
                }
            });
        </script>
        <script>
            document.querySelectorAll('.ellipsis').forEach(ellipsisBtn => {
                const commentId = ellipsisBtn.id.split('-')[3]; // Extrai o ID do comentário a partir do ID do botão
                const dropdownMenu = document.getElementById('dropdown-menu-comment-' + commentId);

                ellipsisBtn.addEventListener('click', () => {
                    dropdownMenu.classList.toggle('active');
                });

                document.addEventListener('click', (event) => {
                    if (!ellipsisBtn.contains(event.target) && !dropdownMenu.contains(event.target)) {
                        dropdownMenu.classList.remove('active');
                    }
                });
            });
        </script>
    </div>