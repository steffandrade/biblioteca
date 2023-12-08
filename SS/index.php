<?php
require_once '../Config/config.php';
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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Euphoria+Script&display=swap">
    <link rel="shortcut icon" href="Public/Assets/_31554896-b491-466e-b129-d77e088c3b0c-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="Public/Css/style.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="Public/Js/script.js"></script>
    <link rel="stylesheet" href="Public/Css/style_index.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <title>Home</title>
</head>
<body>
    <header>
        <div class="logo">
        <img src="../uploads/logo1.png">
        </div>
        <div class="links">
            <a href="index.php">
                <ion-icon name="home-outline"></ion-icon>
                <span class="text">Home</span>
            </a>
            <a href="book.php">
                <ion-icon name="book-outline"></ion-icon>
                <span class="text">Acervo</span>
            </a>
        </div>
   
        <div class="user-icon" id="user-icon" onclick="showUserInfo()">
            <ion-icon name="person-circle-outline"></ion-icon>
        </div>
        <div class="user-info" id="user-info">
        <?php
            include '../Login/verifica_login.php'
        ?>
        <h3>Olá <?php echo $_SESSION['usuarioNomedeUsuario'] , "!"; ?> </h3><br>
        <h4>Livros Emprestados</h4><br>
            <ul>
                <?php $livrosEmprestados = $emprestimoController->listarLivrosEmprestados($_SESSION['usuarioNomedeUsuario']); ?>
                <?php foreach ($livrosEmprestados as $emprestimo): ?>
                    <li>
                        <?php echo "<strong>ID do Livro: </strong>" . $emprestimo['livro_emprestimo']; ?> <br>
                        <?php echo "<strong>Livro: </strong>" . $emprestimo['nome_livro']; ?> <br>
                        <?php echo "<strong>Nome do Usuário: </strong>" . $emprestimo['aluno_emprestimo']; ?>
                        <form method="post" action="book.php">
                            <input type="hidden" name="livro_id" value="<?php echo $emprestimo['emprestimo_id']; ?>">
                            <button type="submit" name="devolver">Devolver</button><br><br>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <button id="log" onclick="logout()"><ion-icon name="log-out-outline"></ion-icon></button></div>
    </header>
    <section>
        <div class="banner">
            <div class="lines"></div>
            <div class="lines2"></div>
            <img src="Public/Assets/banner.png">
            <div class="lines"></div>
            <div class="lines2"></div>
        </div>
        <div class="bioP">
        <div class="title">
        <h1>Sobre</h1>
        </div>
            <div class="lineBio"></div>
            <div class="desc"><p>Explorando o Universo Literário: Conheça a Biblioteca Online

                                No vasto mundo digital, onde a informação e o conhecimento 
                                estão ao alcance de um clique, 
                                emerge um oásis literário virtual: a Biblioteca Online. 
                                Este espaço digital, meticulosamente projetado para os amantes da leitura e da aprendizagem, 
                                oferece uma experiência única e acessível a todos os públicos.</p></div>
        </div>
        <div class="bioO">
        <div class="title">
        <h1 style="font-size:80px">Sobre Nós</h1>
        </div>
            <div class="lineBio"></div>
            <div class="desc"><p>Oscar Osvaldo é um talentoso autor e programador cujo dom para contar histórias se funde elegantemente com sua habilidade em código. 
            Desde jovem, Oscar cativou leitores com narrativas envolventes, e ao abraçar a era digital, ele se tornou um mestre na programação, criando soluções inovadoras.
            Contribuindo significativamente para este site, Oscar é reconhecido por seus artigos informativos e por compartilhar seu conhecimento tanto em escrita quanto em programação.
            Sua paixão por inspirar outros é evidente, tornando-o uma figura respeitada na comunidade online. 
            Oscar Osvaldo continua a explorar os limites entre palavras e códigos, deixando um impacto duradouro como um pioneiro em ambos os campos.</p></div>
        </div>
        <div class="pub">
            <div class="cub"></div>
            <div class="pubtext"><p>Clique <a href="book.php">Aqui</a> para acessar nosso acervo digital!</p></div>
        </div>
    </section>
    <footer>
    <div class="logo">
        <img src="../uploads/banner1.png"></div>
    
        <div class="redes">
    <p>Siga nossas redes sociais:</p>
    <img src="../uploads/facebook.png">
    <img src="../uploads/insta.png">
    <img src="../uploads/linkdin.png">
    </div>
    
    </footer>
</body>
</html>