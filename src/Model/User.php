<?php
    class User{
        private $id;
        private $cpf;
        private $nome;
        private $email;
        private $dataNascimento;
        private $tipo;
        private $senha;
        private $imagem;
        public function __construct(){
            if (func_num_args() != 0) {
                $atributos = func_get_args()[0];
                foreach ($atributos as $atributo => $valor) {
                    if(isset($valor) && property_exists(get_class($this), $atributo)){
                        $this->$atributo = $valor;
                    }    			
                }
            }
        }
        public function getIdUser(){
            return $this->id;
        } 
        public function setIdUser($id){
            return $this->id = $id;
        }
        public function getCPF(){
            return $this->cpf;
        } 
        public function setCPF($cpf){
            return $this->cpf = $cpf;
        }
        public function getNome(){
            return $this->nome;
        } 
        public function setNome($nome){
            return $this->nome = $nome;
        }
        public function getEmail(){
            return $this->email;
        } 
        public function setEmail($email){
            return $this->email = $email;
        }
        
        public function getDataNascimento(){
            return $this->dataNascimento;
        } 
        public function setDataNascimento($dataNascimento) {
            $this->dataNascimento = $dataNascimento;
        }
        public function getTipo(){
            return $this->tipo;
        } 
        public function setTipo($tipo){
            return $this->tipo = $tipo;
        }
        public function getSenha(){
            return $this->senha;
        } 
        public function setSenha($senha){
            return $this->senha = $senha;
        }
        
        public function getImagem(){
            return $this->imagem;
        } 
        public function setImagem($imagem){
            return $this->imagem = $imagem;
        }
        public function __toString(){
            return "id: " . $this->id . "CPF: " . $this->cpf . " nome: " . $this->nome . " Email: " . $this->email . " DataNascimetno: " . $this->dataNascimento . " Tipo: " . $this->tipo . " senha: " . $this->senha . " imagem: " . $this->imagem . "<br><br>";
        } 
    }
?>