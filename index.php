<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "produtos_db";

$conn = new mysqli($server, $user, $password, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " .$conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Produtos</title>
    <style>

    </style>
</head>
<body>
    <h2>Cadastro de Clientes</h2>
    <form id="produtoForm">
        <input type="hidden" name="action" id="action" value="create">

        <input type="hidden" name="id" id="id">

        <label for="ref">Referência:</label>
        <input type="text" name="ref" id="ref" required>

        <label for="desc">Descrição:</label>
        <input type="text" name="desc" id="desc" required>

        <label for="preco">Preço:</label>
        <input type="text" name="preco" id="preco" required>

        <label for="familia">Família:</label>
        <input type="text" name="familia" id="familia">

        <button type="submit">Salvar</button>
    </form>

    <h2>Lista de Clientes</h2>
    <table>
        <tr>
            <th>Referência</th>
            <th>Descrição</th>
            <th>Preço</th>
            <th>Família</th>
        </tr>
        <?php foreach ($produtos as $produto) : ?>
            <tr>
                <td><?= $produto['id'] ?></td>
                <td><?= $produto['ref'] ?></td>
                <td><?= $produto['desc'] ?></td>
                <td><?= $produto['preco'] ?></td>
                <td><?= $produto['familia'] ?></td>
                <td>
                    <button onClick="editar(<?= $produto['id']?>, '<?= $produto['ref']?>', '<?= $produto['desc']?>', '<?= $produto['preco']?>', '<?= $produto['familia']?>' )">Excluir</button>
                    <button onClick="excluir(<?= $produto['id']?>)">Excluir</button>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
</body>
</html>