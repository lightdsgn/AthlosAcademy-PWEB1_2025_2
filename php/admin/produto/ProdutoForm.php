<?php
ob_start(); 
require '../db.class.php';
require '../header.php';

$db = new db("produto");
$db->checkLogin();


if ($_SESSION['tipo'] !== 'instrutor') {
    header("Location: ../login.php");
    exit;
}

$data = null;
$msgErrors = "";

if (!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

function esc($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }


if (!empty($_POST)) {

    $required = ['nome','categoria','preco','estoque'];

    if (empty($_POST['id'])) {
        $required[] = 'imagem';
    }

    foreach ($required as $r) {
        if (empty($_POST[$r])) {
            $msgErrors .= "O campo {$r} é obrigatório<br>";
        }
    }

    if (empty($msgErrors)) {

        
        $img = $_POST['imagem'] ?? "";
        if ($img === "" && !empty($_POST['id']) && $data) {
            $img = $data->imagem;
        }

        $post = [
            'nome'      => $_POST['nome'],
            'categoria' => $_POST['categoria'],
            'preco'     => $_POST['preco'],
            'estoque'   => $_POST['estoque'],
            'imagem'    => $img,
            'descricao' => $_POST['descricao'] ?? ""
        ];


        if (!empty($_POST['id'])) {
            $post['id'] = $_POST['id'];
            $db->update($post);
        } 

        else {
            $db->store($post);
        }

        ob_end_clean();
header("Location: ProdutoList.php");
exit;

        header("Location: ProdutoList.php");
        exit;
    }
}
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Formulário de Produto</title>

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
            margin-left: 110px;
            margin-top: 60px;
            max-width: 900px;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
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

        .btn-save {
            background: #f90030;
            color: #fff;
            font-weight: 700;
            border-radius: 12px;
            padding: 12px 30px;
            width: 100%;
        }
    </style>
</head>

<body>

<div class="card-form">

    <h3 class="title"><?= !empty($data) ? "Editar Produto" : "Cadastro de Produto" ?></h3>

    <?php if (!empty($msgErrors)): ?>
        <div class="alert alert-danger"><?= $msgErrors ?></div>
    <?php endif; ?>

    <form method="post">

        <input type="hidden" name="id" value="<?= $data->id ?? '' ?>">

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Nome</label>
                <input class="form-control" name="nome" value="<?= $data->nome ?? '' ?>">
            </div>

            <div class="col-md-6">
                <label class="form-label">Categoria</label>
                <select class="form-select" name="categoria">
                    <option value="">Selecione</option>
                    <option value="creatina"    <?= ($data->categoria ?? '') === 'creatina' ? 'selected' : '' ?>>Creatina</option>
                    <option value="whey"        <?= ($data->categoria ?? '') === 'whey' ? 'selected' : '' ?>>Whey</option>
                    <option value="pretreino"   <?= ($data->categoria ?? '') === 'pretreino' ? 'selected' : '' ?>>Pré-treino</option>
                    <option value="strap"       <?= ($data->categoria ?? '') === 'strap' ? 'selected' : '' ?>>Strap</option>
                    <option value="adulterados" <?= ($data->categoria ?? '') === 'adulterados' ? 'selected' : '' ?>>Adulterados</option>
                </select>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-md-4">
                <label class="form-label">Preço</label>
                <input class="form-control" type="number" step="0.01" name="preco" value="<?= $data->preco ?? '' ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label">Estoque</label>
                <input class="form-control" type="number" name="estoque" value="<?= $data->estoque ?? '' ?>">
            </div>

            <div class="col-md-4">
                <label class="form-label">URL da Imagem</label>
                <input class="form-control" name="imagem" value="<?= $data->imagem ?? '' ?>">
            </div>
        </div>

        <div class="mt-3">
            <label class="form-label">Descrição</label>
            <textarea class="form-control" rows="4" name="descricao"><?= $data->descricao ?? '' ?></textarea>
        </div>

        <div class="mt-4">
            <button class="btn-save">Salvar</button>
        </div>

    </form>

</div>

</body>
</html>
