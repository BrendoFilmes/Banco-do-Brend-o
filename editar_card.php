<?php
require 'db.php';

$id = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $sql = "UPDATE cards SET titulo = ?, descricao = ?, usuario = ?, urgencia = ?, estado = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            $_POST['titulo'],
            $_POST['descricao'],
            $_POST['usuario'],
            $_POST['urgencia'],
            $_POST['estado'],
            $id
        ]);
        header('Location: index.php');
        exit;
}

$cards = $pdo->query("SELECT * FROM cards ORDER BY criado_em DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cards App</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastro de Casos</h1>

    <form method="post">
        <input type="text" name="titulo" placeholder="Título" required><br>
        <textarea name="descricao" placeholder="Descrição" required></textarea><br>
        <input type="text" name="usuario" placeholder="Nome do paciente" required><br>

        <label>Urgência:</label>
        <select name="urgencia" required>
            <option value="Baixa">Baixa</option>
            <option value="Média">Média</option>
            <option value="Intermediária">Intermediária</option>
            <option value="Alta">Alta</option>
            <option value="Extrema">Extrema</option>
        </select><br>

        <label>Estado:</label>
        <select name="estado" required>
            <option>Iniciado</option>
            <option>Em desenvolvimento</option>
            <option>Concluído</option>
            <option>Em revisão</option>
        </select><br>

        <button id="create" type="submit">Criar Card</button>
        
    </form>

    <div class="cards-container">
        <?php foreach ($cards as $card): ?>
            <div class="card urgencia-<?php echo $card['urgencia']; ?>">
                <h3><?php echo htmlspecialchars($card['titulo']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($card['descricao'])); ?></p>
                <p><strong>Paciente:</strong> <?php echo htmlspecialchars($card['usuario']); ?></p>
                <p><strong>Urgência:</strong> <?php echo $card['urgencia']; ?></p>
                <p><strong>Estado:</strong> <?php echo htmlspecialchars($card['estado']); ?></p>
                <p><em>Criado em: <?php echo $card['criado_em']; ?></em></p>
               
                <form method="post">
                    <input type="hidden" name="delete_id" value="<?php echo $card['id']; ?>">
                    <button id="delete" type="submit">Apagar</button>
                </form>
                <a id="edit" href="editar_card.php?id=<?php echo $card['id']; ?>">Editar</a>
            </div>
        <?php endforeach; ?>
    </div>
</form>
</body>
</html>
