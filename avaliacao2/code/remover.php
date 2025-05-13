<?php
// Conexão com banco de dados
try {
    $pdo = new PDO("mysql:host=localhost;dbname=artesanato_db", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Remover produto se o parâmetro ?remover=id estiver presente
    if (isset($_GET['remover'])) {
        $idRemover = intval($_GET['remover']);
        $stmt = $pdo->prepare("DELETE FROM produtos_artesanais WHERE id = ?");
        $stmt->execute([$idRemover]);
        header("Location: remover.php?msg=removido");
        exit;
    }

    // Buscar todos os produtos
    $stmt = $pdo->query("SELECT * FROM produtos_artesanais");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Visualizar Produtos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #6c63ff;
            color: white;
            padding: 20px 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        main {
            padding: 40px;
        }

        .mensagem {
            text-align: center;
            color: green;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        th, td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #6c63ff;
            color: white;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .btn-remover {
            color: red;
            text-decoration: none;
            font-weight: bold;
        }

        .btn-remover:hover {
            text-decoration: underline;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            color: #777;
            font-size: 0.9em;
        }
        .btn-container {
            text-align: center;
            margin-top: 30px;
        }

        button {
            padding: 12px 24px;
            background-color: #6c63ff;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
    </style>
</head>
<body>

    <header>
        <h1>Produtos Cadastrados</h1>
    </header>

    <main>
        <?php if (isset($_GET['msg']) && $_GET['msg'] === 'removido'): ?>
            <p class="mensagem">Produto removido com sucesso.</p>
        <?php endif; ?>

        <?php if (isset($produtos) && is_array($produtos) && count($produtos) > 0): ?>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome do Produto</th>
                        <th>Preço</th>
                        <th>Descrição</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($produtos as $produto): ?>
                        <tr>
                            <td><?= htmlspecialchars($produto['id']) ?></td>
                            <td><?= htmlspecialchars($produto['nome_produto']) ?></td>
                            <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                            <td><?= htmlspecialchars($produto['descricao']) ?></td>
                            <td><?= htmlspecialchars($produto['categoria']) ?></td>
                            <td>
                                <a href="?remover=<?= $produto['id'] ?>"
                                   class="btn-remover"
                                   onclick="return confirm('Tem certeza que deseja remover este produto?');">
                                   Remover
                                   
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align:center;">Nenhum produto cadastrado ainda.</p>
        <?php endif; ?>
    </main>
     <div class="btn-container">
                <a href="home.php"><button type="submit">Voltar</button></a>
            </div>

    <footer>
        &copy; 2025 Lojinha Artesanal - Fatec Araras
    </footer>

</body>
</html>
 