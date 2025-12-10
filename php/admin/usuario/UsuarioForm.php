<?php
require '../db.class.php';
require '../header.php';

$db = new db();




if (!empty($_GET['id'])) {
    $db->checkLogin();
    if ($_SESSION['tipo'] !== 'instrutor') {
        header("Location: ../login.php");
        exit;
    }
}

$data = null;
$msgErrors = "";


if (!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

if (!empty($_POST)) {
    try {
        $errors = [];


        $required = ['nome','telefone','cpf','email','login','endereco','data','tipo'];
        
        foreach ($required as $r) {
            if (empty($_POST[$r])) {
                $errors[] = "O campo {$r} é obrigatório";
            }
        }

        if (!in_array($_POST['tipo'], ['cliente','instrutor'])) {
            $errors[] = "Tipo de usuário inválido";
        }


        if (empty($_POST['id']) && empty($_POST['senha'])) {
            $errors[] = "A senha é obrigatória no cadastro";
        }


        if (!empty($errors)) {
            $msgErrors = implode("<br>", $errors);
            $data = (object) $_POST;

            } else {
          
            if (empty($_POST['id'])) {

                if ($_POST['senha'] !== $_POST['c_senha']) {
                    $msgErrors = "As senhas não coincidem";
                } else {

                    $post = $_POST;
                    unset($post['id'], $post['c_senha']);
                    $post['senha'] = password_hash($_POST['senha'], PASSWORD_DEFAULT);

                    $db->store($post);

                    header("Location: ../login.php?sucesso=1");
                    exit;
                }

    
            } else {

                $data = $db->find($_POST['id']);
                $post = $_POST;


                if (!empty($_POST['senha'])) {

                    if ($_POST['senha'] !== $_POST['c_senha']) {
                        $msgErrors = "As senhas não coincidem";
                    } else {
                        $post['senha'] = password_hash($_POST['senha'], PASSWORD_DEFAULT);
                    }

                } else {
                    $post['senha'] = $data->senha;
                }

                unset($post['c_senha']);

                $db->update($post);

                header("Location: UsuarioList.php");
                exit;
            }
        }

    } catch (Exception $e) {
        $msgErrors = "Erro: " . $e->getMessage();
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Formulário de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f90030;
            font-family: 'Sora', sans-serif;
            min-height: 100vh;
            padding: 40px 0;
            display: flex;
            justify-content: center;
        }

        .card-form {
            background: #fff;
            width: 100%;
            margin-left: 50px;
            margin-top: 60px;
            margin-bottom: 100px;
            max-width: 1000px;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
            animation: fade .3s ease-out;
        }

        @keyframes fade {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .title {
            font-weight: 800;
            color: #000;
            border-left: 6px solid #f90030;
            padding-left: 15px;
            margin-bottom: 25px;
        }

        .form-label {
            font-weight: 600;
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid #f90030;
            padding: 12px;
        }

        .form-control:focus, .form-select:focus {
            border: 2px solid #ff0038;
            box-shadow: 0 0 0 0.18rem rgba(249, 0, 48, 0.25);
        }

        .btn-save {
            background: #f90030;
            color: #fff;
            font-weight: 700;
            border-radius: 12px;
            padding: 12px 30px;
            border: 2px solid #f90030;
            transition: .25s;
        }
        .btn-save:hover {
            transform: scale(1.04);
            background: #ff003c;
        }

        .btn-back {
            background: #000;
            color: #fff;
            font-weight: 600;
            border-radius: 12px;
            padding: 12px 30px;
            border: 2px solid #000;
            margin-left: 10px;
            transition: .25s;
        }
        .btn-back:hover {
            transform: scale(1.04);
        }

        .alert {
            border-radius: 12px;
            font-weight: 600;
        }
    </style>
</head>

<body>

<div class="card-form">

    <h3 class="title"><?= !empty($data) ? "Editar Usuário" : "Cadastro de Usuário" ?></h3>

    <?php if (!empty($msgErrors)): ?>
        <div class="alert alert-danger"><?= $msgErrors ?></div>
    <?php endif; ?>

    <form action="" method="post">

        <input type="hidden" name="id" value="<?= $data->id ?? '' ?>">

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nome</label>
                <input class="form-control" type="text" name="nome" value="<?= htmlspecialchars($data->nome ?? '') ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">Email</label>
                <input class="form-control" type="text" name="email" value="<?= htmlspecialchars($data->email ?? '') ?>">
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-md-4">
                <label class="form-label">CPF</label>
                <input class="form-control" type="text" name="cpf" value="<?= htmlspecialchars($data->cpf ?? '') ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label">Telefone</label>
                <input class="form-control" type="text" name="telefone" value="<?= htmlspecialchars($data->telefone ?? '') ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label">Data</label>
                <input class="form-control" type="date" name="data" value="<?= htmlspecialchars($data->data ?? '') ?>">
            </div>
        </div>


        <div class="row g-3 mt-1">
            <div class="col-md-12">
                <label class="form-label">Endereço</label>
                <input class="form-control" type="text" name="endereco" value="<?= htmlspecialchars($data->endereco ?? '') ?>">
            </div>
        </div>


        <div class="row g-3 mt-1">
            <div class="col-md-4">
                <label class="form-label">Login</label>
                <input class="form-control" type="text" name="login" value="<?= htmlspecialchars($data->login ?? '') ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label">Senha</label>
                <input class="form-control" type="password" name="senha">
            </div>

            <div class="col-md-4">
                <label class="form-label">Confirmar Senha</label>
                <input class="form-control" type="password" name="c_senha">
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-md-4">
                <label class="form-label">Tipo de Usuário</label>
                <select name="tipo" class="form-select">
                    <option value="">Selecione</option>
                    <option value="cliente" <?= (!empty($data) && $data->tipo == 'cliente') ? 'selected' : '' ?>>Cliente</option>
                    <option value="instrutor" <?= (!empty($data) && $data->tipo == 'instrutor') ? 'selected' : '' ?>>Instrutor</option>
                </select>
            </div>
        </div>


        <div class="mt-4">
            <button class="btn-save" type="submit">Salvar</button>
        </div>

    </form>
</div>

</body>
</html>
