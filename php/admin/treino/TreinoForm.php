<?php
require '../db.class.php';
require '../header.php';

if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'instrutor') {
    header("Location: ../login.php");
    exit;
}

$dbTreino = new db("treino");
$dbUser   = new db("usuario");

// Pega alunos (somente clientes)
$alunos = array_filter($dbUser->all(), fn($u) => $u->tipo === 'cliente');

$treino = null;
$msg = "";

// SE TIVER ID → EDITAR
if (!empty($_GET['id'])) {
    $treino = $dbTreino->find($_GET['id']);
}

// SE ENVIADO FORMULÁRIO
if (!empty($_POST)) {

    $required = ['aluno_id', 'titulo', 'categoria', 'nivel'];

    foreach ($required as $r) {
        if (empty($_POST[$r])) {
            $msg .= "O campo {$r} é obrigatório<br>";
        }
    }

    if (empty($msg)) {

        // DADOS QUE EXISTEM NO BANCO (JÁ CONFIRMADOS POR VOCÊ)
        $dados = [
            'aluno_id'      => $_POST['aluno_id'],
            'instrutor_id'  => $_SESSION['usuario_id'],
            'titulo'        => $_POST['titulo'],
            'descricao'     => $_POST['descricao'] ?? '',
            'categoria'     => $_POST['categoria'],
            'nivel'         => $_POST['nivel'],
            'imagem'        => $_POST['imagem'] ?? '',
            'data_prevista' => $_POST['data_prevista'] ?? null,
        ];

        if (!empty($_POST['id'])) {
            // EDITA
            $dados['id'] = $_POST['id'];
            $dbTreino->update($dados);
        } else {
            // CRIA
            $dbTreino->store($dados);
        }

        header("Location: TreinoList.php");
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cadastro de Treino</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body {
            background:#f90030;
            font-family: 'Sora', sans-serif;
            padding:40px 0;
            display:flex;
            margin-left:150px;
            justify-content:center;
        }
        .card-box {
            background:#fff;
            width:95%;
            max-width:900px;
            margin-top:60px;
            margin-bottom: 100px;
            padding:35px;
            border-radius:20px;
            box-shadow:0 12px 30px rgba(0,0,0,0.12);
        }
        .title {
            font-weight:800;
            border-left:6px solid #f90030;
            padding-left:12px;
            margin-bottom:25px;
        }
        .btn-save {
            background:#f90030;
            border:2px solid #f90030;
            color:#fff;
            font-weight:700;
            border-radius:12px;
            padding:10px 30px;
        }
        .btn-save:hover { background:#ff003c; }
                .form-label {
            font-weight: 600;
        }

        .form-control, .form-select {
            border-radius: 12px;
            border: 2px solid #f90030;
            padding: 12px;
        }
    </style>
</head>

<body>

<div class="card-box">

    <h3 class="title"><?= $treino ? "Editar Treino" : "Cadastrar Treino" ?></h3>

    <?php if (!empty($msg)): ?>
    <div class="alert alert-danger"><?= $msg ?></div>
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="id" value="<?= $treino->id ?? '' ?>">

        <label class="form-label">Aluno</label>
        <select class="form-select" name="aluno_id">
            <option value="">Selecione...</option>
            <?php foreach ($alunos as $a): ?>
            <option value="<?= $a->id ?>" <?= ($treino->aluno_id ?? '') == $a->id ? 'selected' : '' ?>>
                <?= htmlspecialchars($a->nome) ?>
            </option>
            <?php endforeach; ?>
        </select>

        <label class="form-label mt-3">Título</label>
        <input class="form-control" name="titulo" value="<?= $treino->titulo ?? '' ?>">

        <label class="form-label mt-3">Categoria</label>
        <select class="form-select" name="categoria">
            <option value="">Selecione</option>
            <option value="hipertrofia"    <?= ($treino->categoria ?? '')=='hipertrofia'?'selected':'' ?>>Hipertrofia</option>
            <option value="forca"          <?= ($treino->categoria ?? '')=='forca'?'selected':'' ?>>Força</option>
            <option value="resistencia"    <?= ($treino->categoria ?? '')=='resistencia'?'selected':'' ?>>Resistência</option>
            <option value="cardio"         <?= ($treino->categoria ?? '')=='cardio'?'selected':'' ?>>Cardio</option>
        </select>

        <label class="form-label mt-3">Nível</label>
        <select class="form-select" name="nivel">
            <option value="">Selecione</option>
            <option value="iniciante"      <?= ($treino->nivel ?? '')=='iniciante'?'selected':'' ?>>Iniciante</option>
            <option value="intermediario"  <?= ($treino->nivel ?? '')=='intermediario'?'selected':'' ?>>Intermediário</option>
            <option value="avancado"       <?= ($treino->nivel ?? '')=='avancado'?'selected':'' ?>>Avançado</option>
        </select>

        <label class="form-label mt-3">Imagem (URL)</label>
        <input class="form-control" name="imagem" value="<?= $treino->imagem ?? '' ?>">

        <label class="form-label mt-3">Descrição</label>
        <textarea class="form-control" rows="4" name="descricao"><?= $treino->descricao ?? '' ?></textarea>

        <label class="form-label mt-3">Data prevista</label>
        <input type="date" class="form-control" name="data_prevista" value="<?= $treino->data_prevista ?? '' ?>">

        <button class="btn-save mt-4">Salvar</button>
    </form>

</div>

</body>
</html>
