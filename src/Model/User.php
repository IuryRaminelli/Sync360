<?php
class User {
    private $id;
    private $cpf;
    private $nome;
    private $email;
    private $dataNascimento;
    private $tipo;
    private $senha;
    private $imagem;
    private $biografia;
    private $rua;
    private $bairro;
    private $id_estado;
    private $id_cidade;

    public function __construct() {
        if (func_num_args() != 0) {
            $atributos = func_get_args()[0];
            foreach ($atributos as $atributo => $valor) {
                if (isset($valor) && property_exists($this, $atributo)) {
                    $this->$atributo = $valor;
                }
            }
        }
    }

    public function getIdUser() {
        return $this->id;
    }
    public function setIdUser($id) {
        $this->id = $id;
    }

    public function getCPF() {
        return $this->cpf;
    }
    public function setCPF($cpf) {
        $this->cpf = $cpf;
    }

    public function getNome() {
        return $this->nome;
    }
    public function setNome($nome) {
        $this->nome = $nome;
    }

    public function getEmail() {
        return $this->email;
    }
    public function setEmail($email) {
        $this->email = $email;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }
    public function setDataNascimento($dataNascimento) {
        $this->dataNascimento = $dataNascimento;
    }

    public function getTipo() {
        return $this->tipo;
    }
    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getSenha() {
        return $this->senha;
    }
    public function setSenha($senha) {
        $this->senha = $senha;
    }

    public function getImagem() {
        return $this->imagem;
    }
    public function setImagem($imagem) {
        $this->imagem = $imagem;
    }
    public function getBiografia() {
        return $this->biografia;
    }
    public function setBiografia($biografia) {
        $this->biografia = $biografia;
    }

    public function getRua() {
        return $this->rua;
    }
    public function setRua($rua) {
        $this->rua = $rua;
    }

    public function getBairro() {
        return $this->bairro;
    }
    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function getIdEstado() {
        return $this->id_estado;
    }
    public function setIdEstado($id_estado) {
        $this->id_estado = $id_estado;
    }

    public function getIdCidade() {
        return $this->id_cidade;
    }
    public function setIdCidade($id_cidade) {
        $this->id_cidade = $id_cidade;
    }

    public function __toString() {
        return "id: " . $this->id .
            " CPF: " . $this->cpf .
            " nome: " . $this->nome .
            " email: " . $this->email .
            " dataNascimento: " . $this->dataNascimento .
            " tipo: " . $this->tipo .
            " senha: " . $this->senha .
            " imagem: " . $this->imagem .
            " biografia: " . $this->biografia .
            " rua: " . $this->rua .
            " bairro: " . $this->bairro .
            " id_estado: " . $this->id_estado .
            " id_cidade: " . $this->id_cidade . "<br><br>";
    }
}
?>
