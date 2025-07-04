<?php
    include_once __DIR__ . '/../Conexao/Conexao.php';
    include_once __DIR__ . '/../Model/User.php';

    class ConUser{
        private $conexao;
        public function __construct(){
            $this->conexao = Conexao::getConexao();
        }
        public function insertUser(User $User){
            $pstmt = $this->conexao->prepare("INSERT INTO user 
            (cpf, nome, email, senha, dataNascimento, tipo, imagem) VALUES 
            (?,?,?,?,?,?,?)");
            $pstmt->bindValue(1, $User->getCPF());
            $pstmt->bindValue(2, $User->getNome());
            $pstmt->bindValue(3, $User->getEmail());
            $pstmt->bindValue(4, password_hash($User->getSenha(), PASSWORD_DEFAULT));
            $pstmt->bindValue(5, $User->getDataNascimento());
            $pstmt->bindValue(6, $User->getTipo());
            $pstmt->bindValue(7, $User->getImagem());
            $pstmt->execute();
            return $pstmt;
        }
        public function selectLoginUser1($email){
            $pstmt = $this->conexao->prepare("SELECT * FROM user WHERE email = :email ");
            $pstmt->bindValue(":email", $email);
            $pstmt->execute();
            $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, user::class);
            return $lista;
        } 

        public function isLoggedIn(){
            if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == true){
                return true;
            }
            return false;
        }

        public function alterarUser(User $User) {
            try {
                // Preparar a consulta para atualizar os dados do usuário
                $query = "UPDATE user SET 
                            cpf = :cpf, 
                            nome = :nome, 
                            email = :email, 
                            dataNascimento = :dataNascimento, 
                            tipo = :tipo, 
                            imagem = :imagem";
        
                // Se a senha for fornecida, adiciona a coluna senha à consulta
                if (!empty($User->getSenha())) {
                    $query .= ", senha = :senha";
                }
        
                // Adiciona a condição WHERE para o id
                $query .= " WHERE id = :id";
        
                // Preparar a consulta
                $pstmt = $this->conexao->prepare($query);
        
                // Vincula os parâmetros da consulta
                $pstmt->bindValue(':cpf', $User->getCPF());
                $pstmt->bindValue(':nome', $User->getNome());
                $pstmt->bindValue(':email', $User->getEmail());
                $pstmt->bindValue(':dataNascimento', $User->getDataNascimento());
                $pstmt->bindValue(':tipo', $User->getTipo());
                $pstmt->bindValue(':imagem', $User->getImagem());
        
                // Se a senha não estiver vazia, processa a senha e faz o bind
                if (!empty($User->getSenha())) {
                    $pstmt->bindValue(':senha', password_hash($User->getSenha(), PASSWORD_DEFAULT));
                }
        
                // Agora, vincula o id do usuário
                $pstmt->bindValue(':id', $User->getIdUser());
        
                // Executa a consulta
                $pstmt->execute();
        
                // Retorna verdadeiro se a atualização afetou pelo menos uma linha
                return $pstmt->rowCount() > 0;
            } catch (PDOException $e) {
                // Em caso de erro, registra o erro e retorna falso
                error_log('Erro ao alterar usuário: ' . $e->getMessage());
                return false;
            }
        }
        
              
        public function deleteUser($id) {
            try {
                $stmt = $this->conexao->prepare("DELETE FROM user WHERE id = :id");
                $stmt->bindParam(':cpf', $id, PDO::PARAM_INT);
    
                $stmt->execute();
    
                if ($stmt->rowCount() > 0) {
                    return true;
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                echo "Erro ao excluir a usuário: " . $e->getMessage();
                return false;
            }
        }

        public function selectUserById($id) {
            $pstmt = $this->conexao->prepare("SELECT * FROM user WHERE id = :id");
            $pstmt->bindValue(":id", $id);
            $pstmt->execute();
            $lista = $pstmt->fetchObject(User::class);
            return $lista;
        }

        public function selectAllUser(){
            $pstmt = $this->conexao->prepare("SELECT * FROM user");
            $pstmt->execute();
            $lista = $pstmt->fetchAll(PDO::FETCH_CLASS, User::class);
            return $lista;
        }

    }

    
?>