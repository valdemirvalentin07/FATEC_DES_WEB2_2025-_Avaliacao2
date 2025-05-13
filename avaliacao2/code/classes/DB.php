<?php
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
