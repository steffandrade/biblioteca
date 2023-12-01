<?php
require_once 'Config/config.php';
require_once 'app/controller/EmprestimoController.php';

$emprestimoController = new EmprestimoController($pdo);

$emprestimos = $emprestimoController->listarhistorico();

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="Public/Assets/_31554896-b491-466e-b129-d77e088c3b0c-removebg-preview.png" type="image/x-icon">
    <title>Histórico</title>
</head>
<body>
    <a href="admin.php">Voltar</a>
    <h1>Histórico de Empréstimos</h1>
    <ul>
        <?php foreach ($emprestimos as $emprestimo): ?>
            <li><strong>Livro: </strong><?php echo $emprestimo['nome_livro']; ?>;<br> <strong>Usuário:</strong> <?php echo $emprestimo['nome_aluno']; ?><br> <strong>Horário da devolução:</strong> <?php echo $emprestimo['hora']; ?><br><br></li>
        <?php endforeach; ?>
    </ul>

</body>
</html>
