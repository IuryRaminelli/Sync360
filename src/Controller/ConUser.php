<?php
    include_once __DIR__ . '/../Conexao/Conexao.php';
    include_once __DIR__ . '/../Model/User.php';

    class ConUser{
        private $conexao;
        public function __construct(){
            $this->conexao = Conexao::getConexao();
        }
        public function insertUser(User $User) {
            $pstmt = $this->conexao->prepare("INSERT INTO user 
                (cpf, nome, email, senha, dataNascimento, tipo, imagem, biografia, rua, bairro, id_estado, id_cidade) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $pstmt->bindValue(1, $User->getCPF());
            $pstmt->bindValue(2, $User->getNome());
            $pstmt->bindValue(3, $User->getEmail());
            $pstmt->bindValue(4, password_hash($User->getSenha(), PASSWORD_DEFAULT));
            $pstmt->bindValue(5, $User->getDataNascimento());
            $pstmt->bindValue(6, $User->getTipo());
            $pstmt->bindValue(7, $User->getImagem());
            $pstmt->bindValue(8, $User->getBiografia());
            $pstmt->bindValue(9, $User->getRua());
            $pstmt->bindValue(10, $User->getBairro());
            $pstmt->bindValue(11, $User->getIdEstado());
            $pstmt->bindValue(12, $User->getIdCidade());
            return $pstmt->execute();
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
                // Monta a base da query
                $query = "UPDATE user SET 
                            cpf = :cpf, 
                            nome = :nome, 
                            email = :email, 
                            dataNascimento = :dataNascimento, 
                            tipo = :tipo, 
                            imagem = :imagem,
                            biografia = :biografia,
                            rua = :rua,
                            bairro = :bairro,
                            id_estado = :id_estado,
                            id_cidade = :id_cidade";

                // Se a senha for fornecida, adiciona à query
                if (!empty($User->getSenha())) {
                    $query .= ", senha = :senha";
                }

                $query .= " WHERE id = :id";

                // Prepara a query
                $pstmt = $this->conexao->prepare($query);

                // Bind dos parâmetros obrigatórios
                $pstmt->bindValue(':cpf', $User->getCPF());
                $pstmt->bindValue(':nome', $User->getNome());
                $pstmt->bindValue(':email', $User->getEmail());
                $pstmt->bindValue(':dataNascimento', $User->getDataNascimento());
                $pstmt->bindValue(':tipo', $User->getTipo());
                $pstmt->bindValue(':imagem', $User->getImagem());
                $pstmt->bindValue(':biografia', $User->getBiografia());
                $pstmt->bindValue(':rua', $User->getRua());
                $pstmt->bindValue(':bairro', $User->getBairro());
                $pstmt->bindValue(':id_estado', $User->getIdEstado());
                $pstmt->bindValue(':id_cidade', $User->getIdCidade());

                // Se houver nova senha
                if (!empty($User->getSenha())) {
                    $pstmt->bindValue(':senha', password_hash($User->getSenha(), PASSWORD_DEFAULT));
                }

                // ID do usuário
                $pstmt->bindValue(':id', $User->getIdUser());

                // Executa
                $pstmt->execute();

                // Verifica se algo foi alterado
                return $pstmt->rowCount() > 0;
            } catch (PDOException $e) {
                error_log('Erro ao alterar usuário: ' . $e->getMessage());
                return false;
            }
        }
              
        public function deleteUser($id) {
            try {
                $stmt = $this->conexao->prepare("DELETE FROM user WHERE id = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
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




        public function estados() {
            $pstmt = $this->conexao->prepare('SELECT Uf, Nome FROM estado');
            $pstmt->execute();
            return $pstmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function cidades($Uf) {
            $pstmt = $this->conexao->prepare('SELECT * FROM cidade WHERE estado_Uf = :uf ORDER BY Nome');
            $pstmt->bindParam(':uf', $Uf, PDO::PARAM_STR);
            $pstmt->execute();
            return $pstmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function getNomeEstado($uf) {
            $stmt = $this->conexao->prepare("SELECT Nome FROM estado WHERE Uf = :uf");
            $stmt->bindValue(':uf', $uf);
            $stmt->execute();
            return $stmt->fetchColumn();
        }

        public function getNomeCidade($idCidade) {
            $stmt = $this->conexao->prepare("SELECT Nome FROM cidade WHERE Id = :id");
            $stmt->bindValue(':id', $idCidade, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn();
        }


    }

    
?>