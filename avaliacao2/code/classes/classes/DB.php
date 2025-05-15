<?php

class DB {
    private $pdo;

public function __construct() {
    $config = require __DIR__ . '/config/config.php'; // Caminho relativo correto
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
