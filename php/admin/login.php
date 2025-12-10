<?php
session_start();
require './db.class.php';

$db = new db();

if (!empty($_POST)) {
    $login = trim($_POST['login'] ?? '');
    $senha = $_POST['senha'] ?? '';

    if (empty($login) || empty($senha)) {
        $erro = "Preencha login e senha.";
    } else {
        $res = $db->login([
            'login' => $login,
            'senha' => $senha
        ]);

        if ($res === 'error') {
            $erro = "Login ou senha inválidos.";
        } else {
            if ($_SESSION['tipo'] === 'instrutor') {
                header("Location: index.php");
                exit;
            }
            if ($_SESSION['tipo'] === 'cliente') {
                header("Location: ../../index.html");
                exit;
            }
        }
    }
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Login - Sistema Athlos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;800&display=swap" rel="stylesheet">
  <link rel="icon" type="image/png" href="../../img/favicon.png">
    <style>
body {
    font-family: 'Sora', sans-serif;
    background: #f90030;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 40px;
    overflow-x: hidden;
}



        header {
            width: 100%;
            background: #000;
            padding: 22px 50px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            border-bottom: 2px solid #f90030;
            box-shadow: 0 4px 10px rgba(0,0,0,0.3);
            z-index: 100;
        }

        .header-logo {
            height: 55px;
            margin-left:20px;
            transition: transform 0.3s ease-in-out; 
        }
           
        .header-logo:hover {
            transform: scale(1.05);
        }

        .btn-header-voltar {
            background: #f90030;
            padding: 10px 25px;
            color: #fff;
            border-radius: 10px;
            font-weight: 700;
            text-decoration: none;
            border: 2px solid #f90030;
            transition: 0.2s ease;
        }
        .btn-header-voltar:hover {
            background: #fff;
            color: #f90030;
            border-color: #fff;
        }


        .login-card {
            background: #fff;
            border-radius: 18px;
            padding: 40px;
            width: 100%;
            max-width: 550px;
            box-shadow: 0px 8px 30px rgba(0,0,0,0.20);
            margin-top: 130px;
        }

        .login-card h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 800;
            color: #000;
        }

        .form-control {
            padding: 12px;
            border-radius: 10px;
            border: 2px solid #f90030;
        }

        .form-control:focus {
            border: 2px solid #f90030;
            box-shadow: 0 0 0 0.2rem rgba(249,0,48,0.25);
        }

        .btn-login {
            background-color: #f90030;
            border: 2px solid #f90030;
            border-radius: 10px;
            padding: 12px 40px;
            font-weight: 800;
            color: #fff;
            width: 100%;
            transition: all 0.3s ease;
        }
        .btn-login:hover {
            background-color: #ff004d;
            transform: scale(1.05);
            color: #fff;
        }
        .botao-login {
            background-color: #000;
            border: 2px solid #f90030;
            border-radius: 10px;
            margin-right:20px;
            padding: 10px 40px;
            font-family: 'Sora ExtraBold', sans-serif;
            color: #ffffff;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .botao-login:hover {
            background-color: #ff004d;
            transform: scale(1.05);
        }

        .btn-secondary {
            background: #000;
            border-radius: 10px;
            border: 2px solid #000;
            width: 100%;
            padding: 12px;
            font-weight: 700;
            margin-top: 12px;
            color: white;
            transition: 0.3s ease;
        }
        .btn-secondary:hover {
            transform: scale(1.05);
            border-color: #000000ff;

            background: #000;
        }

        .alert {
            border-radius: 10px;
        }
    </style>

</head>
<body>



    <header>
        <img src="../../img/LOGO-ATHLOS2.png" class="header-logo" alt="Athlos Logo">

                   <button 
    style="margin-left:30px;width: 160px; padding-left:3px; padding-right:3px" 
    class="botao-login" 
    onclick="window.location.href='../../index.html'">
    
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
        style="margin-right:10px; margin-top:-3px"
        fill="currentColor" viewBox="0 0 16 16">
        <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
    </svg>
    VOLTAR
</button>

    </header>


   
    <div class="login-card">
        <h2>Faça login no sistema</h2>

        <?php if (!empty($erro)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="mb-3">
                <label class="form-label">Login</label>
                <input class="form-control" type="text" name="login" value="<?= htmlspecialchars($_POST['login'] ?? '') ?>" placeholder="Digite seu login">
            </div>

            <div class="mb-3">
                <label class="form-label">Senha</label>
                <input class="form-control" type="password" name="senha" placeholder="Digite sua senha">
            </div>

            <button class="btn btn-login" type="submit">ENTRAR</button>
            <a class="btn btn-secondary" href="usuario/UsuarioForm.php">CRIAR CONTA</a>
        </form>
    </div>

</body>
</html>
