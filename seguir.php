<?php
session_start();
include 'config/db.php';

if (isset($_GET['id'])) {
    $perfil_id = intval($_GET['id']); // Obtém o ID do perfil a ser seguido via GET
    $usuarioLogado_id = $_SESSION['user_id']; // ID do usuário logado


    // Preparar uma consulta para verificar se o usuário já está seguindo o perfil
    $stmtVerificaSeguindo = $pdo->prepare("SELECT * FROM seguidores WHERE id_seguindo = :perfil_id AND id_seguidor = :usuarioLogado_id");
    $stmtVerificaSeguindo->bindParam(':perfil_id', $perfil_id, PDO::PARAM_INT);
    $stmtVerificaSeguindo->bindParam(':usuarioLogado_id', $usuarioLogado_id, PDO::PARAM_INT);
    $stmtVerificaSeguindo->execute();

    // Verificar se já está seguindo
    if ($stmtVerificaSeguindo->fetch(PDO::FETCH_ASSOC)) {
        // Se o usuário já está seguindo, excluir o registro
        $stmtExcluir = $pdo->prepare("DELETE FROM seguidores WHERE id_seguindo = :perfil_id AND id_seguidor = :usuarioLogado_id");
        $stmtExcluir->bindParam(':perfil_id', $perfil_id, PDO::PARAM_INT);
        $stmtExcluir->bindParam(':usuarioLogado_id', $usuarioLogado_id, PDO::PARAM_INT);
        $stmtExcluir->execute();

    } else {
        // Se o usuário não está seguindo, inserir novo registro na tabela de seguidores
        $stmtSeguir = $pdo->prepare("INSERT INTO seguidores (id_seguidor, id_seguindo) VALUES (:usuarioLogado_id, :perfil_id)");
        $stmtSeguir->bindParam(':usuarioLogado_id', $usuarioLogado_id, PDO::PARAM_INT);
        $stmtSeguir->bindParam(':perfil_id', $perfil_id, PDO::PARAM_INT);
        $stmtSeguir->execute();

    }

    header("Location: userPerfil.php?id=$perfil_id");
    exit;
}
