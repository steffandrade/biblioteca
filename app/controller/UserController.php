<?php
require_once 'app\model\UserModel.php';


class UserController {
    private $userModel;

    public function __construct($pdo) {

        $this->userModel = new UserModel($pdo);
    }

    public function criarUser($nome, $email, $senha, $nivel_permissao) {
        $this->userModel->criarUser($nome, $email, $senha, $nivel_permissao);
    }

    public function listarUsers() {
        return $this->userModel->listarUsers();
    }

    public function exibirListaUsers() {
        $users = $this->userModel->listarUsers();
        include 'app/view/user/listar.php';
    }

    public function atualizarUser($id, $nome, $email, $senha, $nivel_permissao) {
        $this->userModel->atualizarUser($id, $nome, $email, $senha, $nivel_permissao);
    }
    
    public function excluirUser ($id) {
        $this->userModel->excluirUser($id);
    }
}
?>
