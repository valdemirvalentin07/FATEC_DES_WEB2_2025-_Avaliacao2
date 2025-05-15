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
     private $pdo;

public function __construct() {
    $config = require __DIR__ . '/config/config.php'; // Caminho para proteger os dados 
    $this->conectar($config);
}
      private function conectar($config) {
        try {
            $this->pdo = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4",
                $config['user'],
                $config['pass']
            );
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            error_log("Erro na conexão: " . $e->getMessage());
            die("Erro ao conectar ao banco de dados.");
        }
    }

    public function cadastrarProduto($nome, $preco, $descricao, $categoria) {
        $sql = "INSERT INTO produtos_artesanais (nome_produto, preco, descricao, categoria) 
                VALUES (?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$nome, $preco, $descricao, $categoria]);
    }

    public function listarProdutos() {
        $sql = "SELECT * FROM produtos_artesanais";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function removerProduto($id) {
        $sql = "DELETE FROM produtos_artesanais WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$id]);
    }
}
    

?>
