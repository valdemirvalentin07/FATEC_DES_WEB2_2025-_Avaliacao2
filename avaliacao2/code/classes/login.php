<?php 
session_start();

/**
 * Classe responsável por gerenciar o login do usuário.
 */
class Login { 
    private $name = 'admin'; 
    private $password = 'admin'; 
    
    public function verificar_credenciais($name, $password) { 
        if ($name == $this->name) {
            if ($password == $this->password) {
                $_SESSION["logged_in"] = TRUE;
                return TRUE;
            }
        }
        return FALSE;
    } 

    public function verificar_logado() { 
        if ($_SESSION["logged_in"]) {
            return TRUE;
        }
        $this->logout();
    } 

    public function logout() { 
        session_destroy();
        header("Location: index.php");
        exit();
    } 
} 

/**
 * Classe responsável por gerenciar dados no MySQL via PDO.
 */

class DB {
    private $host = 'localhost';
    private $dbname = 'artesanato_db';
    private $user = 'root';
    private $pass = '';
    private $pdo;

    // Construtor: conecta automaticamente ao instanciar
    public function __construct() {
        $this->conectar();
    }

    // Método privado para conexão
    private function conectar() {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", 
                                 $this->user, $this->pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    // Método público para cadastrar produto
    public function cadastrarProduto($nome, $preco, $descricao, $categoria) {
        $sql = "INSERT INTO produtos_artesanais (nome_produto, preco, descricao, categoria) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $preco, $descricao, $categoria]);
    }

    //  Método público para listar todos os produtos
    public function listarProdutos() {
        $sql = "SELECT * FROM produtos_artesanais";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //  Método público para remover produto pelo ID
    public function removerProduto($id) {
        $sql = "DELETE FROM produtos_artesanais WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
?>


