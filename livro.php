<?php
require_once 'Config/config.php';
require_once 'App/Controller/LivroController.php';
require_once 'App/Controller/EmprestimoController.php';

session_start();

$livroController = new LivroController($pdo);
$emprestimoController = new EmprestimoController($pdo);

$livros = $livroController->listarLivros();

$livrosPorCategoria = [];
foreach ($livros as $livro) {
    $categoria = $livro['categoria'];
    if (!isset($livrosPorCategoria[$categoria])) {
        $livrosPorCategoria[$categoria] = [];
    }
    $livrosPorCategoria[$categoria][] = $livro;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['emprestar'])) {
    $livroID = $_POST['livro_id'];
    $livroNome = $_POST['nome'];
    $usuarioNome = $_SESSION['usuarioNomedeUsuario'];

    $emprestimoController->emprestarLivro($livroID, $livroNome, $usuarioNome);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['devolver'])) {
    $livroID = $_POST['livro_id'];

    $emprestimoController->devolverLivro($livroID);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Public/Css/style.css">
    <script src="Public/Js/script.js"></script>
    <link rel="shortcut icon" href="Public/Assets/_31554896-b491-466e-b129-d77e088c3b0c-removebg-preview.png" type="image/x-icon">
    <title>Lista de Livros</title>
</head>
<body>
    <div class="user-icon" id="user-icon" onclick="showUserInfo()">
    </div>
    <div class="user-info" id="user-info">
        <?php include '../Login/verifica_login.php'; ?>
        <h2>Olá <?php echo $_SESSION['usuarioNomedeUsuario'], "!"; ?> </h2><br>
        <button onclick="logout()"><h6>Sair</h6></button>
    </div>

    <a href="index.php">Voltar</a>
    
    <?php foreach ($livrosPorCategoria as $categoria => $livrosNaCategoria): ?>
        <h2><?php echo $categoria; ?></h2>
        <ul>
            <?php foreach ($livrosNaCategoria as $livro): ?>
                <li>
                    <?php
                    if (!empty($livro['imagem'])) {
                        echo '<img src="' . $livro['imagem'] . '" alt="Imagem do Livro" width="100">';
                    } else {
                        echo 'Sem Imagem';
                    }
                    ?>
                    <?php echo $livro['nome']; ?> -
                    <?php echo $livro['quantidade']; ?> -
                    <form method="post" action="book.php">
                        <input type="hidden" name="livro_id" value="<?php echo $livro['livro_id']; ?>">
                        <input type="hidden" name="nome" value="<?php echo $livro['nome']; ?>">
                        <button type="submit" name="emprestar">Emprestar</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>

    <h2>Livros Emprestados</h2>
    <ul>
        <?php $livrosEmprestados = $emprestimoController->listarLivrosEmprestados($_SESSION['usuarioNomedeUsuario']); ?>
        <?php foreach ($livrosEmprestados as $emprestimo): ?>
            <li>
                <?php echo "<strong>ID do Livro: </strong>" . $emprestimo['livro_emprestimo']; ?> <br>
                <?php echo "<strong>Livro: </strong>" . $emprestimo['nome_livro']; ?> <br>
                <?php echo "<strong>Nome do Usuário: </strong>" . $emprestimo['aluno_emprestimo']; ?>
                <form method="post" action="book.php">
                    <input type="hidden" name="livro_id" value="<?php echo $emprestimo['emprestimo_id']; ?>">
                    <button type="submit" name="devolver">Devolver</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</body>
</html>