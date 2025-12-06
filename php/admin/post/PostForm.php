<?php
require '../db.class.php';
require '../header.php';

$db = new db("post");
$db->checkLogin();


if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'instrutor') {
    header("Location: ../login.php");
    exit;
}

$data = null;
$msgErrors = "";

if (!empty($_GET['id'])) {
    $data = $db->find($_GET['id']);
}

if (!empty($_POST)) {

    $required = ['titulo','categoria','resumo','conteudo','imagem'];

    foreach ($required as $r) {
        if (empty($_POST[$r])) {
            $msgErrors .= "O campo {$r} é obrigatório<br>";
        }
    }

    if (empty($msgErrors)) {

        $post = [
            'titulo' => $_POST['titulo'],
            'categoria' => $_POST['categoria'],
            'resumo' => $_POST['resumo'],
            'conteudo' => $_POST['conteudo'],
            'imagem' => $_POST['imagem'],
            'instrutor_id' => $_SESSION['usuario_id']
        ];

        if (!empty($_POST['id'])) {
            
            $post['id'] = $_POST['id'];
            $db->update($post);
        } else {
       
            $post['criado_em'] = date("Y-m-d H:i:s");
            $db->store($post);
        }

        header("Location: PostList.php");
        exit;
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Formulário de Post</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;800&display=swap" rel="stylesheet">

    <style>
        body { background: #f90030; font-family: 'Sora', sans-serif; min-height: 100vh; padding: 40px 0; display: flex; justify-content: center; }
        .card-form { background: #fff; width: 100%;margin-bottom: 100px; margin-left: 110px; margin-top: 60px; max-width: 900px; border-radius: 20px; padding: 35px; box-shadow: 0 12px 30px rgba(0,0,0,0.12); animation: fade .3s ease-out; }
        @keyframes fade { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        .title { font-weight: 800; color: #000; border-left: 6px solid #f90030; padding-left: 15px; margin-bottom: 25px; }
        .form-label { font-weight: 600; }
        .form-control, .form-select { border-radius: 12px; border: 2px solid #f90030; padding: 12px; }
        .form-control:focus, .form-select:focus { border: 2px solid #ff0038; box-shadow: 0 0 0 0.18rem rgba(249, 0, 48, 0.25); }
        .btn-save { background: #f90030; color: #fff; font-weight: 700; border-radius: 12px; padding: 14px 30px; border: 2px solid #f90030; transition: .25s; width: 100%; }
        .btn-save:hover { transform: scale(1.04); background: #ff003c; }
        .alert { border-radius: 12px; font-weight: 600; }
    </style>
</head>

<body>

<div class="card-form">

    <h3 class="title"><?= !empty($data) ? "Editar Postagem" : "Criar Nova Postagem" ?></h3>

    <?php if (!empty($msgErrors)): ?>
        <div class="alert alert-danger"><?= $msgErrors ?></div>
    <?php endif; ?>

    <form method="post">

        <input type="hidden" name="id" value="<?= $data->id ?? '' ?>">

        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label">Título</label>
                <input class="form-control" name="titulo" value="<?= $data->titulo ?? '' ?>">
            </div>

            <div class="col-md-12">
                <label class="form-label">Categoria</label>
                <select class="form-select" name="categoria">
                    <option value="">Selecione</option>
                    <option value="treinos"     <?= ($data->categoria ?? '') == 'treinos' ? 'selected' : '' ?>>Treinos</option>
                    <option value="nutricao"    <?= ($data->categoria ?? '') == 'nutricao' ? 'selected' : '' ?>>Nutrição</option>
                    <option value="atletas"     <?= ($data->categoria ?? '') == 'atletas' ? 'selected' : '' ?>>Atletas</option>
                    <option value="conquistas"  <?= ($data->categoria ?? '') == 'conquistas' ? 'selected' : '' ?>>Conquistas</option>
                </select>
            </div>
        </div>

        <div class="mt-3">
            <label class="form-label">Resumo</label>
            <textarea class="form-control" rows="3" name="resumo"><?= $data->resumo ?? '' ?></textarea>
        </div>

        <div class="mt-3">
            <label class="form-label">Conteúdo Completo</label>
            <textarea class="form-control" rows="6" name="conteudo"><?= $data->conteudo ?? '' ?></textarea>
        </div>

        <div class="mt-3">
            <label class="form-label">URL da Imagem</label>
            <input class="form-control" name="imagem" value="<?= $data->imagem ?? '' ?>">
        </div>

        <div class="mt-4 d-flex">
            <button class="btn-save">Salvar</button>
        </div>

    </form>

</div>

</body>
</html>
