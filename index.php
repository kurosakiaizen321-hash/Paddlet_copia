<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "paddlet_db";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Conexão falhou: " . $conn->connect_error);

// 🔹 Buscar posts destacados
$destaques = [];
$resultDest = $conn->query("SELECT * FROM posts WHERE destaque = TRUE AND vencimento >= NOW() ORDER BY criado_em DESC");
if ($resultDest && $resultDest->num_rows > 0) {
    while ($row = $resultDest->fetch_assoc()) {
        $destaques[] = $row;
    }
}

// 🔹 Buscar posts normais (não vencidos)
$result = $conn->query("SELECT * FROM posts WHERE vencimento >= NOW() ORDER BY criado_em DESC");

$postsPorCategoria = [
    "Produto" => [],
    "Saúde" => [],
    "Vagas de Emprego" => [],
    "Notícias" => [],
    "Educação" => [],
    "Eventos" => []
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        if (isset($postsPorCategoria[$row['categoria']])) {
            $postsPorCategoria[$row['categoria']][] = $row;
        }
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mini Padlet</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f5f5f5;
            font-family: 'Segoe UI', sans-serif;
            min-height: 100vh;
        }
        h1 {
            text-align: center;
            margin: 30px 0;
            color: #222;
        }
        h2 {
            text-align: center;
            margin: 40px 0 20px 0;
            color: #333;
            font-size: 1.5rem;
        }
        .card-post {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin: 0 auto;
            overflow: hidden;
        }
        .card-post img {
            width: 100%;
            height: auto;
        }
        .card-body {
            padding: 20px;
        }
        .card-body h5 {
            margin-bottom: 10px;
            font-weight: 600;
        }
        .card-body p {
            color: #555;
        }
        .card-body small {
            display: block;
            text-align: right;
            color: #888;
        }
        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            background-size: 60% 60%;
        }
        .carousel-control-prev,
        .carousel-control-next {
            width: 5%;
        }

        /* Destaques com borda dourada */
        .destaque .card-post {
            border: 3px solid gold;
        }
    </style>
</head>
<body>
    <h1>Mini Padlet</h1>

    <div class="container mb-5">

        <!-- 🟨 CARROSSEL DE DESTAQUES -->
        <?php if (count($destaques) > 0): ?>
            <div class="categoria-section destaque mb-5">
                <h2>⭐ Destaques</h2>
                <div id="carousel_destaques" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php foreach ($destaques as $index => $post): ?>
                            <div class="carousel-item <?php if ($index == 0) echo 'active'; ?>">
                                <div class="card-post">
                                    <?php
                                    if (!empty($post['midia'])) {
                                        if (filter_var($post['midia'], FILTER_VALIDATE_URL) || file_exists($post['midia'])) {
                                            echo "<img src='{$post['midia']}' alt='Mídia do post'>";
                                        }
                                    }
                                    ?>
                                    <div class="card-body">
                                        <h5><?php echo htmlspecialchars($post['titulo']); ?></h5>
                                        <p><?php echo nl2br(htmlspecialchars($post['descricao'])); ?></p>
                                        <small>Vence em: <?php echo date("d/m/Y H:i", strtotime($post['vencimento'])); ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <?php if (count($destaques) > 1): ?>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carousel_destaques" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carousel_destaques" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                            <span class="visually-hidden">Próximo</span>
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>

        <!-- 🧩 OUTRAS CATEGORIAS -->
        <?php foreach ($postsPorCategoria as $categoria => $posts): ?>
            <div class="categoria-section mb-5">
                <h2><?php echo htmlspecialchars($categoria); ?></h2>

                <?php if (count($posts) > 0): ?>
                    <div id="carousel_<?php echo strtolower(str_replace(' ', '_', $categoria)); ?>" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($posts as $index => $post): ?>
                                <div class="carousel-item <?php if ($index == 0) echo 'active'; ?>">
                                    <div class="card-post">
                                        <?php
                                        if (!empty($post['midia'])) {
                                            if (filter_var($post['midia'], FILTER_VALIDATE_URL) || file_exists($post['midia'])) {
                                                echo "<img src='{$post['midia']}' alt='Mídia do post'>";
                                            }
                                        }
                                        ?>
                                        <div class="card-body">
                                            <h5><?php echo htmlspecialchars($post['titulo']); ?></h5>
                                            <p><?php echo nl2br(htmlspecialchars($post['descricao'])); ?></p>
                                            <small>Vencimento: <?php echo date("d/m/Y H:i", strtotime($post['vencimento'])); ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <?php if (count($posts) > 1): ?>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel_<?php echo strtolower(str_replace(' ', '_', $categoria)); ?>" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel_<?php echo strtolower(str_replace(' ', '_', $categoria)); ?>" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                                <span class="visually-hidden">Próximo</span>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center text-muted">Nenhum post nesta categoria.</p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
