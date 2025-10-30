<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Postagem</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <h2>Criar Postagem</h2>
        <form action="salvar_post.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="titulo" class="form-label">Título</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>

            <div class="mb-3">
                <label for="categoria" class="form-label">Categoria</label>
                <select class="form-select" id="categoria" name="categoria" required>
                    <option value="" selected disabled>Selecione uma categoria</option>
                    <option value="Produto">Produto</option>
                    <option value="Saúde">Saúde</option>
                    <option value="Vagas de Emprego">Vagas de Emprego</option>
                    <option value="Notícias">Notícias</option>
                    <option value="Educação">Educação</option>
                    <option value="Eventos">Eventos</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label for="vencimento" class="form-label">Data de Vencimento</label>
                <input type="datetime-local" class="form-control" id="vencimento" name="vencimento" required>
            </div>

            <div class="mb-3">
                <label for="midia_link" class="form-label">Link da Mídia</label>
                <input type="url" class="form-control" id="midia_link" name="midia_link" placeholder="https://exemplo.com/imagem.jpg">
            </div>

            <div class="mb-3">
                <label for="midia_arquivo" class="form-label">Arquivo de Mídia</label>
                <input type="file" class="form-control" id="midia_arquivo" name="midia_arquivo">
            </div>

            <button type="submit" class="btn btn-primary">Publicar</button>
        </form>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>