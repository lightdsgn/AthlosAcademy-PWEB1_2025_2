<?php
require '../db.class.php';
require '../header.php';

$db = new db('post');
$db->checkLogin();

if ($_SESSION['tipo'] !== 'instrutor') {
    header("Location: ../login.php");
    exit;
}


if (!empty($_GET['id'])) {
    $db->destroy($_GET['id']);
    header("Location: PostList.php");
    exit;
}


if (!empty($_POST['valor'])) {

    $campo = $_POST['tipo'];
    $valor = "%" . $_POST['valor'] . "%";

    $stmt = $db->conn()->prepare("
        SELECT p.*, u.nome AS instrutor
        FROM post p
        LEFT JOIN usuario u ON u.id = p.instrutor_id
        WHERE $campo LIKE ?
        ORDER BY p.id DESC
    ");

    $stmt->execute([$valor]);
    $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

} else {
    $stmt = $db->conn()->query("
        SELECT p.*, u.nome AS instrutor
        FROM post p
        LEFT JOIN usuario u ON u.id = p.instrutor_id
        ORDER BY p.id DESC
    ");
    $posts = $stmt->fetchAll(PDO::FETCH_OBJ);
}
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Listagem de Posts</title>

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

        thead tr {
            background: #f90030;
            color: #fff;
            font-weight: 600;
        }

        tbody tr:hover {
            background: rgba(249,0,48,0.06);
        }

        .post-img {
            width: 55px;
            height: 55px;
            border-radius: 10px;
            object-fit: cover;
        }

        .form-select,
        .form-control {
            border-radius: 12px;
            border: 2px solid #f90030;
            padding: 12px;
        }

        .form-control:focus, .form-select:focus {
            border: 2px solid #ff0038;
            box-shadow: 0 0 0 0.18rem rgba(249,0,48,0.25);
        }

        .btn-search {
            background: #f90030;
            color: #fff;
            font-weight: 600;
            border-radius: 12px;
            padding: 10px 25px;
            border: none;
            transition: .25s;
            max-width:150px
        }
        .btn-search:hover {
            transform: scale(1.05);
        }
    </style>
</head>

<body>

<div class="card-lista">

    <h3 class="titulo">Listagem de Posts</h3>
    <a href="PostForm.php" class="btn btn-add" style="flex:1; margin-top:20px; margin-bottom:15px">Cadastrar Post</a>


    <form method="post" class="mb-4">
        <div class="row g-2 align-items-center">

            <div class="col-md-3">
                <select name="tipo" class="form-select">
                    <option value="titulo">Título</option>
                    <option value="categoria">Categoria</option>
                    <option value="resumo">Resumo</option>
                </select>
            </div>

            <div class="col-md-6">
                <input name="valor" class="form-control" placeholder="Pesquisar...">
            </div>

            <div class="col-md-3 d-flex gap-2">
                <button class="btn-search" style="flex:1;">Buscar</button>
                
            </div>
            

        </div>
    </form>


    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>#</th>
                <th>Imagem</th>
                <th>Título</th>
                <th>Categoria</th>
                <th>Instrutor</th>
                <th>Criado em</th>
                <th style="width:170px;">Ações</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($posts as $p): ?>
            <tr>
                <td><?= $p->id ?></td>

                <td>
                    <?php if (!empty($p->imagem)): ?>
                        <img src="<?= $p->imagem ?>" class="post-img">
                    <?php else: ?>
                        <span class="text-muted">Sem imagem</span>
                    <?php endif; ?>
                </td>

                <td><?= htmlspecialchars($p->titulo) ?></td>
                <td><?= htmlspecialchars($p->categoria) ?></td>
                <td><?= $p->instrutor ?? "Desconhecido" ?></td>
                <td><?= date("d/m/Y H:i", strtotime($p->criado_em)) ?></td>

                <td>
                    <a href="PostForm.php?id=<?= $p->id ?>"
                       class="btn btn-sm btn-primary"
                       style="border-radius:10px; width:100px; margin-bottom:5px;">
                       <svg style="margin-right:10px" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 512 512"><path fill="#ffffffff" d="M404 0c19.2 0 37.6 7.6 51.1 21.2l35.7 35.7C504.4 70.4 512 88.8 512 108s-7.6 37.6-21.2 51.1L445.9 204L308 66.1l44.9-44.9C366.4 7.6 384.8 0 404 0M58.9 315.1L274.1 100L412 237.9L196.9 453.1c-10.7 10.7-24.1 18.5-38.7 22.6L30.4 511.1c-8.3 2.3-17.3 0-23.4-6.2s-8.5-15.1-6.2-23.4l35.6-127.7c4.1-14.6 11.8-27.9 22.6-38.7zM225.4 80.8L80.8 225.4l-69.1-69.1c-15.6-15.6-15.6-40.9 0-56.6l88-88c15.6-15.6 40.9-15.6 56.6 0l5.9 5.9l-56.3 56.3c-7.8 7.8-7.8 20.5 0 28.3s20.5 7.8 28.3 0l56.3-56.3zm205.8 205.8l34.9 34.9l-56.3 56.3c-7.8 7.8-7.8 20.5 0 28.3s20.5 7.8 28.3 0l56.3-56.3l5.9 5.9c15.6 15.6 15.6 40.9 0 56.6l-88 88c-15.6 15.6-40.9 15.6-56.6 0l-69.1-69.1z"/></svg>Editar
                    </a>

                    <a href="PostList.php?id=<?= $p->id ?>"
                       onclick="return confirm('Deseja realmente excluir?')"
                       class="btn btn-sm btn-danger"
                       style="border-radius:10px; width:100px;">
                       <svg style="margin-right:10px; margin-bottom:5px" xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 448 512"><path fill="#ffffffff" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16M53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"/></svg>Excluir
                    </a>
                </td>

            </tr>
            <?php endforeach ?>
        </tbody>
    </table>

</div>

</body>
</html>
