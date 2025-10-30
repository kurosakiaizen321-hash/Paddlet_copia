<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Conta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f5f5f5;
      font-family: 'Segoe UI', sans-serif;
    }
    .form-container {
      background: #fff;
      border-radius: 15px;
      padding: 40px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      max-width: 450px;
      margin: 80px auto;
    }
    h2 {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }
    .form-text a {
      text-decoration: none;
      color: #555;
    }
    .form-text a:hover {
      color: #000;
    }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Criar Conta</h2>
    <form method="POST" action="criar_conta_action.php">
      <div class="mb-3">
        <label class="form-label">Nome</label>
        <input type="text" name="nome" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">E-mail</label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Senha</label>
        <input type="password" name="senha" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-dark w-100 mt-3">Criar Conta</button>

      <p class="form-text text-center mt-3">Já tem conta? <a href="login.php">Entrar</a></p>
    </form>
  </div>

</body>
</html>
