<?php
require_once 'Config/config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Gerenciamento da biblioteca</title>
</head>
<body>
    
<div>
    <h1>Cadastro de Usuário</h1>
    <?php
    if (isset($_POST['submit'])) {
        $nome = $_POST['nome'];
        $cpf = $_POST['cpf'];
        $telefone = $_POST['telefone'];
        $senha = $_POST['senha'];

        $stmt = $pdo->prepare('SELECT COUNT(*) FROM usuarios WHERE cpf = ?');
        $stmt->execute([$cpf]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $error = 'Já existe um cadastro com esse cpf.';
        } else {

            $stmt = $pdo->prepare('INSERT INTO usuarios(nome, cpf, telefone, senha)
            VALUES(:nome, :cpf, :telefone, :senha)');
            $stmt->execute(['nome'=> $nome, 'cpf'=> $cpf, 'telefone'=> $telefone, 'senha'=> $senha]);

            if ($stmt->rowCount()) {
                echo '<span>Cadastro feito com sucesso!</span>';
            } else {
                echo '<span>Erro ao cadastrar, tente novamente mais tarde.</span>';
            }
        }
        
        if (isset($error)) {
            echo '<span>' . $error . '</span>';
        }
    }
?>

<form method="post">

<label for="nome">Nome:</label>
<input type="text" name="nome" required></br>

<label for="cpf">cpf:</label>
<input type="cpf" name="cpf" required></br>

<label for="telefone">Telefone:</label>
<input type="text" name="telefone" maxLength="20" required></br>

<label for="senha">senha:</label>
<input type="password" name="senha" required></br>


<div>
    <button type="submit" name="submit" value="Cadastrar" >Cadastrar</button>
    <button><a  href="login.php">Login</a></button>
</div>
</form>
</div>

</body>

</html>