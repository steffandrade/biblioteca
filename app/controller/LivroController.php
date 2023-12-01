<?php
require_once 'App/Model/LivroModel.php';


class LivroController {
    private $livroModel;

    public function __construct($pdo) {
        $this->livroModel = new LivroModel($pdo);
    }

    public function criarLivro($nome, $categoria, $quantidade, $imagem, $categoria_id) {
        $this->livroModel->criarLivro($nome, $categoria, $quantidade, $imagem, $categoria_id);
    }

    public function listarLivros() {
        return $this->livroModel->listarLivros();
    }

    public function exibirListaLivros() {
        $livros = $this->livroModel->listarLivros();
        include 'app/view/livro/lista.php';
    }

    public function atualizarLivro($livro_id, $nome, $categoria, $quantidade, $categoria_id) {
        $this->livroModel->atualizarLivro($livro_id, $nome, $categoria, $quantidade, $categoria_id);
    }
    
    public function excluirLivro ($livro_id) {
        $this->livroModel->excluirLivro($livro_id);
    }
}
?>
