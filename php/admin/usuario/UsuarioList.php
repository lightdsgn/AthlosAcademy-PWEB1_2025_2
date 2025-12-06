<?php 
require '../db.class.php';
require '../header.php';

// ❌ REMOVER: session_start();  <-- CAUSA DO ERRO

$db = new db("usuario");
$db->checkLogin();

// Somente instrutor pode ver esta lista
if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'instrutor') {
    header("Location: ../login.php");
    exit;
}

// Excluir usuário
if (!empty($_GET['id'])) {
    $db->destroy($_GET['id']);
    header("Location: UsuarioList.php");
    exit;
}

$busca = $_GET['busca'] ?? '';

if ($busca) {
    $busca = "%$busca%";
    $stmt = $db->conn()->prepare("
        SELECT * FROM usuario 
        WHERE nome LIKE ? 
           OR email LIKE ? 
           OR telefone LIKE ?
           OR cpf LIKE ?
        ORDER BY nome
    ");
    $stmt->execute([$busca, $busca, $busca, $busca]);
    $dados = $stmt->fetchAll(PDO::FETCH_OBJ);
} else {
    $dados = $db->all();
}

?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listagem de Usuários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            background: #f90030;
            font-family: 'Sora', sans-serif;
            padding: 50px 0;
            min-height: 100vh;
            display: flex;
            justify-content: center;
        }

        .card-lista {
            margin-top: 50px;
            margin-bottom: 100px;
            background: #fff;
            width: 95%;
            max-width: 1100px;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
            animation: fade .3s ease-out;
        }

        @keyframes fade {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .titulo {
            font-weight: 800;
            color: #000;
            font-size: 28px;
            border-left: 6px solid #f90030;
            padding-left: 15px;
            margin-bottom: 25px;
        }

        .btn-add {
            background: #f90030;
            border: 2px solid #f90030;
            color: #fff;
            font-weight: 700;
            border-radius: 12px;
            padding: 10px 25px;
            transition: .25s;
        }
        .btn-add:hover {
            background: #ff003c;
            transform: scale(1.05);
        }

        .table {
            border-radius: 12px;
            overflow: hidden;
        }

        thead tr {
            background: #f90030;
            color: #fff;
            font-weight: 600;
        }

        tbody tr:hover {
            background: rgba(249,0,48,0.06);
        }

        .btn-warning, .btn-danger {
            border-radius: 10px;
            font-weight: 600;
        }

        .btn-back {
            background: #000;
            color: #fff;
            border: 2px solid #000;
            padding: 10px 25px;
            border-radius: 12px;
            font-weight: 600;
            transition: .25s;
        }

        .btn-back:hover {
            transform: scale(1.05);
        }
            .form-control  {
            border-radius: 12px;
            border: 2px solid #f90030;
            padding: 12px;
            max-width: 700px;
        }

        .form-control:focus {
            border: 2px solid #ff0038;
            box-shadow: 0 0 0 0.18rem rgba(249, 0, 48, 0.25);
        }
    </style>
</head>

<body>

<div class="card-lista">

    <h3 class="titulo">Listagem de Usuários</h3>

    <a href="UsuarioForm.php" class="btn btn-add mb-3">Cadastrar Usuário</a>
<form method="GET" class="mb-4">
    <div style="display:flex; align-items:center; gap:15px;">
        <input 
            type="text" 
            name="busca" 
            class="form-control" 
            placeholder="Buscar por nome, email, CPF ou telefone..."
            value="<?= htmlspecialchars($_GET['busca'] ?? '') ?>"
        >
        <button style="background-color: #f90030; padding:10px; border-radius:10px; border:none; color:#fff; font-family: Sora Extrabold;margin-left:15px; margin-right:-5px; padding-right:35px;padding-left:35px " type="submit">Buscar</button>
        <?php if (!empty($_GET['busca'])): ?>
            <a href="UsuarioList.php" style="background-color: #000; padding:10px; border-radius:10px; border:none;font-family: Sora Extrabold; color:#fff;text-decoration:none;padding-right:35px;padding-left:35px ">Limpar</a>
        <?php endif; ?>
    </div>
</form>

    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Telefone</th>
                <th>CPF</th>
                <th>Email</th>
                <th>Tipo</th>
                <th style="width:170px;">Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($dados as $item): ?>
            <tr>
                <td><?= $item->id ?></td>
                <td><?= htmlspecialchars($item->nome) ?></td>
                <td><?= htmlspecialchars($item->telefone) ?></td>
                <td><?= htmlspecialchars($item->cpf) ?></td>
                <td><?= htmlspecialchars($item->email) ?></td>
                <td><?= htmlspecialchars($item->tipo) ?></td>

                <td>
                    <a href="UsuarioForm.php?id=<?= $item->id ?>" 
                       class="btn btn-sm btn-primary" 
                       style="border-radius:10px; width:100px;">
                       <svg style="margin-right:10px" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 512 512"><path fill="#ffffffff" d="M404 0c19.2 0 37.6 7.6 51.1 21.2l35.7 35.7C504.4 70.4 512 88.8 512 108s-7.6 37.6-21.2 51.1L445.9 204L308 66.1l44.9-44.9C366.4 7.6 384.8 0 404 0M58.9 315.1L274.1 100L412 237.9L196.9 453.1c-10.7 10.7-24.1 18.5-38.7 22.6L30.4 511.1c-8.3 2.3-17.3 0-23.4-6.2s-8.5-15.1-6.2-23.4l35.6-127.7c4.1-14.6 11.8-27.9 22.6-38.7zM225.4 80.8L80.8 225.4l-69.1-69.1c-15.6-15.6-15.6-40.9 0-56.6l88-88c15.6-15.6 40.9-15.6 56.6 0l5.9 5.9l-56.3 56.3c-7.8 7.8-7.8 20.5 0 28.3s20.5 7.8 28.3 0l56.3-56.3zm205.8 205.8l34.9 34.9l-56.3 56.3c-7.8 7.8-7.8 20.5 0 28.3s20.5 7.8 28.3 0l56.3-56.3l5.9 5.9c15.6 15.6 15.6 40.9 0 56.6l-88 88c-15.6 15.6-40.9 15.6-56.6 0l-69.1-69.1z"/></svg>Editar
                    </a>

                    <a href="UsuarioList.php?id=<?= $item->id ?>"
                       onclick="return confirm('Deseja realmente excluir?')"
                       class="btn btn-sm btn-danger"
                       style="border-radius:10px; width:100px; margin-top:5px"><svg style="margin-right:10px; margin-bottom:5px" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 448 512"><path fill="#ffffffff" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16M53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"/></svg>
                       Excluir
                    </a>
                </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</div>

</body>
</html>
