<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $sql = "INSERT INTO cards (titulo, descricao, usuario, urgencia, estado) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['titulo'],
        $_POST['descricao'],
        $_POST['usuario'],
        $_POST['urgencia'],
        $_POST['estado']
    ]);
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
    <h1>Plataforma de Criação de Cards</h1>

    <form method="post">
        <input type="text" name="titulo" placeholder="Título" required><br>
        <textarea name="descricao" placeholder="Descrição" required></textarea><br>
        <input type="text" name="usuario" placeholder="Nome do usuário" required><br>

        <label>Urgência:</label>
        <select name="urgencia" required>
            <option value="1">1 - Baixa</option>
            <option value="2">2 - Média</option>
            <option value="3">3 - Alta</option>
        </select><br>

        <label>Estado:</label>
        <select name="estado" required>
            <option>Iniciado</option>
            <option>Em desenvolvimento</option>
            <option>Concluído</option>
            <option>Em revisão</option>
        </select><br>

        <button type="submit">Criar Card</button>
    </form>

    <div class="cards-container">
        <?php foreach ($cards as $card): ?>
            <div class="card urgencia-<?php echo $card['urgencia']; ?>">
                <h3><?php echo htmlspecialchars($card['titulo']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($card['descricao'])); ?></p>
                <p><strong>Responsável:</strong> <?php echo htmlspecialchars($card['usuario']); ?></p>
                <p><strong>Urgência:</strong> <?php echo $card['urgencia']; ?></p>
                <p><strong>Estado:</strong> <?php echo htmlspecialchars($card['estado']); ?></p>
                <p><em>Criado em: <?php echo $card['criado_em']; ?></em></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>