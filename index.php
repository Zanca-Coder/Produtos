<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "produtos_db";

$conn = new mysqli($server, $user, $password, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " .$conn->connect_error);
}

$sql = "CREATE TABLE IF NOT EXISTS produtos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        referencia VARCHAR(50) NOT NULL UNIQUE,
        descricao VARCHAR(50) NOT NULL,
        preco FLOAT(10),
        familia VARCHAR(20)
        )";
$conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == "create") {
        $referencia = $_POST['referencia'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $familia = $_POST['familia'];
        $sql = "INSERT INTO produtos (referencia, descricao, preco, familia) VALUES ('$referencia', '$descricao', '$preco', '$familia')";
        $conn->query($sql);
    }
    if ($action == "update") {
        $referencia = $_POST['referencia'];
        $descricao = $_POST['descricao'];
        $preco = $_POST['preco'];
        $familia = $_POST['familia'];
        $sql = "UPDATE produtos SET referencia='$referencia', descricao='$descricao', preco='$preco', familia='$familia'";
        $conn->query($sql);
    }
    if ($action == "delete") {
        $id = $_POST['id'];
        $sql = "DELETE FROM produtos WHERE id=$id";
        $conn->query($sql);
    }
}

$result = $conn->query("SELECT * FROM produtos");
$produtos = [];

while ($row = $result->fetch_assoc()) {
    $produtos[] = $row;
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Produtos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 20px;
        }
        button {
            margin: 5px;
            padding: 5px 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Cadastro de Clientes</h2>
    <form id="produtoForm">
        <input type="hidden" name="action" id="action" value="create">

        <input type="hidden" name="id" id="id">

        <label for="referencia">Referência:</label>
        <input type="text" name="referencia" id="referencia" required>

        <label for="descricao">Descrição:</label>
        <input type="text" name="descricao" id="descricao" required>

        <label for="preco">Preço:</label>
        <input type="text" name="preco" id="preco" required>

        <label for="familia">Família:</label>
        <input type="text" name="familia" id="familia">

        <button type="submit">Salvar</button>
    </form>

    <h2>Lista de Clientes</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Referência</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Família</th>
            <th>Ações</th>
        </tr>
        <?php foreach ($produtos as $produto) : ?>
            <tr>
                <td><?= $produto['id'] ?></td>
                <td><?= $produto['referencia'] ?></td>
                <td><?= $produto['descricao'] ?></td>
                <td><?= $produto['preco'] ?></td>
                <td><?= $produto['familia'] ?></td>
                <td>
                    <button onClick="editar(<?= $produto['id']?>, '<?= $produto['referencia']?>', '<?= $produto['descricao']?>', '<?= $produto['preco']?>', '<?= $produto['familia']?>' )">Editar</button>
                    <button onClick="excluir(<?= $produto['id']?>)">Excluir</button>
                </td>
            </tr>
        <?php endforeach;?>
    </table>

    <script>
        document.getElementById("produtoForm").addEventListener("submit", function(event) {
            event.preventDefault();
            const formData = new FormData(this);
            fetch("", {method: "POST", body: formData}).then(response => location.reload());
        });

        function editar(id, referencia, descricao, preco, familia) {
            document.getElementById("id").value = id;
            document.getElementById("referencia").value = referencia;
            document.getElementById("descricao").value = descricao;
            document.getElementById("preco").value = preco;
            document.getElementById("familia").value = familia;
            document.getElementById("action").value = "update";
        }

        function excluir(id) {
            if (confirm("Deseja realmente excluir este produto?")) {
                const formData = new FormData();
                formData.append("action", "delete");
                formData.append("id", id);
                fetch("", {method: "POST", body: formData}).then(response => location.reload());
            }
        }
    </script>
</body>
</html>