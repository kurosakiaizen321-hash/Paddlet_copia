<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "paddlet_db";

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}



$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Conexão falhou: " . $conn->connect_error);

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID inválido.");
}

$id = (int)$_GET['id'];

// Buscar dados do post
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    die("Post não encontrado.");
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Postagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
            padding: 30px 0;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #222;
        }
        .form-card {
            background: #fff;
            border-radius: 15px;
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .form-card label {
            font-weight: 600;
        }
        .form-card button {
            width: 100%;
        }
        .current-media {
            margin-top: 5px;
            font-size: 0.9rem;
            color: #555;
        }
    </style>
</head>
<body>

    <h2>Editar Postagem</h2>
    <div class="form-card">
        <form action="editar_post.php?id=<?php echo $post['id']; ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo htmlspecialchars($post['titulo']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <option value="Produto" <?php if($post['categoria']=='Produto') echo 'selected'; ?>>Produto</option>
                    <option value="Saúde" <?php if($post['categoria']=='Saúde') echo 'selected'; ?>>Saúde</option>
                    <option value="Vagas de Emprego" <?php if($post['categoria']=='Vagas de Emprego') echo 'selected'; ?>>Vagas de Emprego</option>
                    <option value="Notícias" <?php if($post['categoria']=='Notícias') echo 'selected'; ?>>Notícias</option>
                    <option value="Educação" <?php if($post['categoria']=='Educação') echo 'selected'; ?>>Educação</option>
                    <option value="Eventos" <?php if($post['categoria']=='Eventos') echo 'selected'; ?>>Eventos</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="4" required><?php echo htmlspecialchars($post['descricao']); ?></textarea>
            </div>

            <div class="mb-3">
                <label for="vencimento" class="form-label">Data de Vencimento</label>
                <input type="datetime-local" class="form-control" id="vencimento" name="vencimento" value="<?php echo date('Y-m-d\TH:i', strtotime($post['vencimento'])); ?>" required>
            </div>

            <div class="mb-3">
                <label for="midia_link" class="form-label">Link da Mídia</label>
                <input type="url" class="form-control" id="midia_link" name="midia_link" value="<?php echo htmlspecialchars($post['midia']); ?>">
            </div>

            <div class="mb-3">
                <label for="midia_arquivo" class="form-label">Arquivo de Mídia</label>
                <input type="file" class="form-control" id="midia_arquivo" name="midia_arquivo">
                <?php if(!empty($post['midia'])): ?>
                    <div class="current-media">Imagem atual: <?php echo htmlspecialchars($post['midia']); ?></div>
                <?php endif; ?>
            </div>

            <!-- Campo Destaque -->
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" id="destaque" name="destaque" value="1" <?php if($post['destaque']) echo 'checked'; ?>>
                <label class="form-check-label" for="destaque">Destaque</label>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar Postagem</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
