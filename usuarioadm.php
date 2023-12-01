<?php
require_once 'Config/config.php';
require_once 'app/controller/UserController.php';

$userController = new UserController($pdo);

if (isset($_POST['nome']) && 
    isset($_POST['email']) &&
    isset($_POST['senha']) &&
    isset($_POST['nivel_permissao'])) 
{
    $userController->criarUser($_POST['nome'], $_POST['email'], $_POST['senha'], $_POST['nivel_permissao']);
    header('Location: #');
}

// Atualiza User
if (isset($_POST['id']) && isset($_POST['atualizar_nome']) && isset($_POST['atualizar_email']) && isset($_POST['atualizar_senha']) && isset($_POST['atualizar_nivel_permissao'])) {
    $userController->atualizarUser($_POST['id'], $_POST['atualizar_nome'], $_POST['atualizar_email'], $_POST['atualizar_senha'], $_POST['atualizar_nivel_permissao']);
}

// Excluir User
if (isset($_POST['excluir_id'])) {
    $userController->excluirUser($_POST['excluir_id']);
}

$users = $userController->listarUsers();

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="shortcut icon" href="Public/Assets/_31554896-b491-466e-b129-d77e088c3b0c-removebg-preview.png" type="image/x-icon">
    <title>Usuários</title>
</head>
<body>
    <a href="index.php">Voltar</a>
    <h1>Usuário</h1>
    <form method="post">
        <input type="text" name="nome" placeholder="Nome Usuário" required>
        <input type="text" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <input type="number" name="nivel_permissao" placeholder="Nível de Permissão" >
        <button type="submit">Adicionar Usuário</button>
    </form>

<?php
$userController->exibirListaUsers();
?>

<h2>Atualizar Usuário</h2>
    <form method="post">
        <select name="id">
        <?php foreach ($users as $user): ?>
                                <option value="<?php echo $user['id']; ?>"><?php echo $user['id']; ?></option>
                                <?php endforeach; ?>
        </select>
                <input type="text" name="atualizar_nome" placeholder="Novo Nome" required>
                <input type="text" name="atualizar_email" placeholder="Nova E-mail" required>
                <input type="password" name="atualizar_senha" placeholder="Nova Senha" required>
                <input type="number" name="atualizar_nivel_permissao" placeholder="Novo nível de Permissão" required>
        <button type="submit">Atualizar Usuário</button>
    </form>

    <h2>Excluir Usuário</h2>
    <form method="post">
        <select name="excluir_id">
            <?php foreach ($users as $user): ?>
                <option value="<?php echo $user['id']; ?>"><?php echo $user['nome']; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Excluir Usuário</button>
    </form>
</body>
</html>
