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
    <h1>Login</h1>
    <?php
    if (isset($_POST['submit'])) {
        $cpf = $_POST['cpf'];
        $senha = $_POST['senha'];

        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE cpf = ? AND senha = ?');
        $stmt->execute([$cpf, $senha]);
        
        $count = $stmt->fetch();

        if ($count > 0) {

            if ($count['nivel_permissao'] == 1) {
                header('Location: admin.php');
            } else {
                header('Location: user.php');
            }
            
        } else {

          echo "Erro ao fazer login";

        }
        
        
    }
?>

<form method="post">

<label for="cpf">Cpf:</label>
<input type="cpf" name="cpf" required></br>

<label for="senha">Senha:</label>
<input type="password" name="senha" required></br>


<div>
    <button type="submit" name="submit" value="login" >Login</button>
    <button><a  href="#">Esqueceu a senha?</a></button>
</div>
</form>
</div>

</body>

</html>