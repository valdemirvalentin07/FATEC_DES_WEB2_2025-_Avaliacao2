<?php
require_once 'classes/DB.php'; 

$mensagem = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome_produto'] ?? '';
    $preco = $_POST['preco'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $categoria = $_POST['categoria'] ?? '';

    if (!empty($nome) && !empty($preco)) {
        $db = new DB();
        $sucesso = $db->cadastrarProduto($nome, $preco, $descricao, $categoria);

        if ($sucesso) {
            $mensagem = "Produto cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar o produto.";
        }
    } else {
        $mensagem = "Nome e preço são obrigatórios.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Produto</title>
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
            text-align: center;
        }

        form {
            max-width: 500px;
            margin: auto;
            text-align: left;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
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

        button:hover {
            background-color: #4e47d4;
        }

        footer {
            text-align: center;
            margin-top: 40px;
            color: #777;
            font-size: 0.9em;
        }

        .mensagem {
            margin-top: 20px;
            color: green;
            font-weight: bold;
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
        <h1>Cadastro de Produto</h1>
    </header>

    <main>
        <?php if (isset($mensagem)) echo "<p class='mensagem'>$mensagem</p>"; ?>

        <form method="POST" action="">
            <label for="nome_produto">Nome do Produto:</label>
            <input type="text" name="nome_produto" id="nome_produto" required>

            <label for="preco">Preço:</label>
            <input type="text" name="preco" id="preco" step="0.01" required>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" rows="4"></textarea>

            <label for="categoria">Categoria:</label>
            <input type="text" name="categoria" id="categoria">

            <div class="btn-container">
                <button type="submit">Cadastrar</button>
            </div>
        </form>
    </main>
     <div class="btn-container">
                <a href="home.php"><button type="submit">Voltar</button></a>
            </div>


    <footer>
        &copy; 2025 Lojinha Artesanal - Fatec Araras
    </footer>
</body>
</html>