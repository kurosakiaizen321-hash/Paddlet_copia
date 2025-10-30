<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "paddlet_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Conexão falhou: " . $conn->connect_error);

// Buscar todos os posts
$result = $conn->query("SELECT * FROM posts ORDER BY criado_em");

$posts = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Mini Padlet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', sans-serif;
            padding: 30px;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #222;
        }
        table {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        thead {
            background: #343a40;
            color: #fff;
        }
        th, td {
            vertical-align: middle !important;
        }
        td img {
            width: 60px;
            height: 40px;
            object-fit: cover;
            border-radius: 5px;
        }
        .action-icons a {
            color: #495057;
            margin-right: 10px;
            font-size: 1.2rem;
            transition: color 0.2s;
        }
        .action-icons a:hover {
            color: #0d6efd;
        }
    </style>
</head>
<body>
    <h1>Administração de Posts</h1>

    <div class="container">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Título</th>
                    <th>Vencimento</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($posts as $post): ?>
                <tr>
                    <td>
                        <?php if(!empty($post['midia'])): ?>
                            <img src="<?php echo htmlspecialchars($post['midia']); ?>" alt="Imagem do post">
                        <?php else: ?>
                            <span class="text-muted">Sem imagem</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($post['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($post['vencimento']); ?></td>
                    <td class="action-icons">
                        <a href="editar.php?id=<?php echo $post['id']; ?>" title="Editar"><i class="bi bi-pencil-square"></i></a>
                        <a href="excluir.php?id=<?php echo $post['id']; ?>" title="Excluir"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(count($posts) === 0): ?>
                <tr>
                    <td colspan="3" class="text-center text-muted">Nenhum post cadastrado.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="text-end">
            <a href="cadastrar_postagem.php" class="btn btn-success fw-bold">Adicionar posts</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
