<?php
require __DIR__ . '/../php/admin/db.class.php';

if (session_status() !== PHP_SESSION_ACTIVE) session_start();


if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'cliente') {
    header("Location: ../php/admin/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: blog.php");
    exit;
}

$id = intval($_GET['id']);

$dbPost = new db('post');
$conn = $dbPost->conn();

$st = $conn->prepare("
    SELECT p.*, u.nome AS instrutor
    FROM post p
    LEFT JOIN usuario u ON u.id = p.instrutor_id
    WHERE p.id = ?
    LIMIT 1
");
$st->execute([$id]);
$post = $st->fetch(PDO::FETCH_OBJ);

if (!$post) {
    header("Location: blog.php");
    exit;
}

function esc($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'utf-8'); }
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title><?= esc($post->titulo) ?> - Blog Athlos</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

  <style>
    :root{ --brand:#f90030; --bg:#000; --card:#161617; }
    body{
        background:var(--bg);
        color:#fff;
        font-family:'Sora',sans-serif;
        padding-top:120px;
    }

       header{ position:fixed; top:0; left:0; right:0; height:100px; background:#000; border-bottom:3px solid var(--brand); display:flex; align-items:center; justify-content:space-between; padding:12px 28px; z-index:1000;}
    header img{ width:150px; }
    header nav a{ color:#fff; margin:0 12px; text-decoration:none; font-weight:600;}
    header nav a.active{ color:var(--brand); }
        header {
  position: fixed;        
  top: 0;                 
  left: 0;               
  width: 100%;           
  display: flex;
  align-items: center;
  justify-content: space-between; 
  gap: 1px;
  padding: 0 120px;               
  height: 100px;
  background-color: #000000;
  box-sizing: border-box;
  z-index: 1000; 
  border-bottom: 2px solid #f90030;   
box-shadow: 0 4px 10px rgba(0,0,0,0.2);
}
    header nav a{ color:#ddd; text-decoration:none; margin-right:14px; font-weight:600;}
    header nav a.active{ color: var(--brand); }

header a,
header nav a,
header .nav-link {
    color: #ffffff !important;
    text-decoration: none;
    font-weight: 600;
    padding: 6px 4px;       
    position: relative;
    transition: color 0.3s ease;
    font-family: 'Sora', sans-serif;
}


header a::after,
header nav a::after,
header .nav-link::after {
    content: "";
    position: absolute;
    left: 50%;         
    bottom: 3px; 
    width: 0%;
    height: 2px;
    background: #f90030;
    transition: all 0.3s ease;
    transform: translateX(-50%);
}

header a:hover::after,
header nav a:hover::after,
header .nav-link:hover::after {
    width: 100%;
}


header a:hover,
header nav a:hover,
header .nav-link:hover {
    color: #f90030 !important;
}

header a.active {
  color: #f90030 !important;
}

    .container{ max-width:900px; margin:auto; }

    .post-header h1{
        font-size:2.8rem;
        font-weight:800;
        color:var(--brand);
        margin-bottom:10px;
        text-transform:uppercase;
    }

    .post-meta{
        color:#bbb;
        font-size:0.95rem;
        margin-bottom:22px;
    }

    .post-img{
        width:100%;
        height:380px;
        object-fit:cover;
        border-radius:16px;
        margin-bottom:25px;
        box-shadow:0 6px 30px rgba(249,0,48,0.2);
    }

    .post-content{
        background:var(--card);
        padding:28px;
        border-radius:16px;
        box-shadow:0 6px 30px rgba(0,0,0,0.25);
        font-size:1.1rem;
        line-height:1.7rem;
        color:#e0e0e0;
        white-space:pre-wrap;
    }

    .badge-cat{
        background:var(--brand);
        color:#000;
        font-weight:800;
        padding:6px 12px;
        border-radius:10px;
        display:inline-block;
        margin-bottom:18px;
    }

    .btn-back{
        background:var(--brand);
        border:none;
        padding:12px 20px;
        color:#fff;
        font-weight:800;
        border-radius:10px;
        margin-top:30px;
        text-decoration:none;
        display:inline-block;
        transition:.2s;
    }

    .btn-back:hover{
        background:#ff003c;
        transform:scale(1.04);
    }
  </style>
</head>

<body>

<header>
  <div style="display:flex;align-items:center;gap:18px">
     <img class="logo-athlos2" src="../img/LOGO-ATHLOS2.png" alt="logo athlos">
  <nav style="display:flex; gap:18px; align-items:center;">
    <a href="../index.html">Início</a>
    <a href="../paginas/sobre.html">Sobre Nós</a>
    <a href="../paginas/loja.php" >Loja</a>
    <a href="../paginas/treino.php">Treinos</a>
    <a class="active" href="../paginas/blog.php">Blog</a>
    <a href="../paginas/avaliacao.html">Avaliação</a>
  </nav>
  </div>

  <div style="display:flex;align-items:center;gap:12px">
    <div style="text-align:right;font-weight:700">
      <div style="font-size:12px;color:#bbb">Olá,</div>
      <div><?= esc($_SESSION['nome'] ?? 'Aluno') ?></div>
    </div>
    <a href="../php/admin/logout.php" class="btn" style="background:var(--brand); color:#fff; padding:8px 14px; border-radius:10px; text-decoration:none;">Sair</a>
  </div>
</header>


<main class="container">

    <div class="post-header">

        <span class="badge-cat">
            <?= esc(ucfirst($post->categoria)) ?>
        </span>

        <h1><?= esc($post->titulo) ?></h1>

        <div class="post-meta">
            Publicado por <strong><?= esc($post->instrutor ?? 'Instrutor') ?></strong><br>
            em <?= date('d/m/Y H:i', strtotime($post->criado_em)) ?>
        </div>

    </div>

    <img src="<?= esc($post->imagem ?: '../img/no-image.png') ?>" class="post-img">

    <div class="post-content">
        <h4 style="font-weight:700; margin-bottom:14px; color:#fff;">Resumo</h4>
        <p><?= nl2br(esc($post->resumo)) ?></p>

        <hr style="border-color:#333; margin:25px 0;">

        <h4 style="font-weight:700; margin-bottom:14px; color:#fff;">Conteúdo Completo</h4>
        <p><?= nl2br(esc($post->conteudo)) ?></p>
    </div>

    <a href="blog.php" class="btn-back">
        <i class="fa-solid fa-arrow-left"></i> Voltar ao Blog
    </a>

</main>

</body>
</html>
