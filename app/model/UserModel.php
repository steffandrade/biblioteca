<?php
class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Model para criar Users
    public function criarUser($nome, $email, $senha, $nivel_permissao) {
        $sql = "INSERT INTO usuarios (nome, email, senha, nivel_permissao) VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nome, $email, $senha, $nivel_permissao]);
    }

    // Model para listar Users
    public function listarUsers() {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Model para atualizar Users
    public function atualizarUser($id, $nome, $email, $senha, $nivel_permissao){
        $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ?, nivel_permissao = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$nome, $email, $senha, $nivel_permissao, $id]);
    }
    
    // Model para deletar User
    public function excluirUser($id) {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$id]);
    }
    
}
?>
