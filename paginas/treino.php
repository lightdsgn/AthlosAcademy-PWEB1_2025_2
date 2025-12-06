<?php

require __DIR__ . '/../php/admin/db.class.php'; 

if (session_status() !== PHP_SESSION_ACTIVE) session_start();


if (!isset($_SESSION['tipo']) || $_SESSION['tipo'] !== 'cliente') {
    header("Location: ../php/admin/login.php");
    exit;
}

$alunoId = $_SESSION['usuario_id'];

$dbTreino = new db('treino');
$conn = $dbTreino->conn();


$st = $conn->prepare("SELECT * FROM treino WHERE aluno_id = ? ORDER BY data_prevista ASC");
$st->execute([$alunoId]);
$treinos = $st->fetchAll(PDO::FETCH_OBJ);


function esc($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'utf-8'); }
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>Meus Treinos - Athlos</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <style>
    :root{ --brand:#f90030; --bg:#000; --card:#161617; }
    body{ background:var(--bg); color:#fff; font-family: 'Sora', sans-serif; padding-top:120px; }
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
    .logo-athlos2{ height:46px; margin-right:150px}

    .container{ max-width:1100px; margin:auto; }
    .title{ text-align:center; margin-bottom:20px; }
    .title h1{ color:var(--brand); font-weight:800; letter-spacing:1px; }
    .info-row{ display:flex; gap:12px; align-items:center; justify-content:space-between; margin-bottom:20px; flex-wrap:wrap; }
    .search { max-width:420px; width:100%; }
    .treino-card{ background:var(--card); border:1px solid rgba(249,0,48,0.12); border-radius:14px; padding:16px; box-shadow:0 8px 30px rgba(249,0,48,0.06); height:100%; display:flex; flex-direction:column; }
    .treino-img{ width:100%; height:180px; object-fit:cover; border-radius:10px; margin-bottom:12px; }
    .badge-cat{ background:var(--brand); color:#000; padding:6px 10px; font-weight:800; border-radius:8px; display:inline-block; margin-bottom:8px;}
    .card-footer{ margin-top:auto; display:flex; gap:8px; align-items:center; justify-content:space-between; }
    .btn-primary-outline{ border:1px solid var(--brand); color:var(--brand); background:transparent; padding:8px 12px; border-radius:10px; font-weight:700; }
    .no-data{ background:#121212; padding:28px; text-align:center; border-radius:12px; border:1px solid rgba(255,255,255,0.03); }
    @media (max-width:900px){ header{ padding:12px 16px } }
        .treino-hero {
      margin-top: 50px;
      background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,1)),
                  url("https://www.feitodeiridium.com.br/wp-content/uploads/2016/10/triceps-barras-paralelas.jpg") top/cover no-repeat;
      color: white;
      height: 400px;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      animation: fadeIn 1.5s ease;
      border-radius: 20px;
    }
    .treino-hero-text h1 {
      font-size: 90px;
      font-weight: 800;
      text-transform: uppercase;
      color: #f90030;
      font-family: Untyped;
    }

    .treino-hero-text h1 { font-size:56px; margin:0; color:var(--accent); font-weight:800; letter-spacing:1px; }
    .treino-hero-text p { margin:12px 0 0; color:#fff; font-size:18px; opacity:0.95; }

  </style>
</head>
<body>

<header>
  <div style="display:flex;align-items:center;gap:18px">
    <img src="../img/LOGO-ATHLOS2.png" alt="Athlos">
    <nav>
    <a href="index.html" >Início</a>
    <a href="sobre.html">Sobre Nós</a>
    <a href="loja.php">Loja</a>
    <a class="active" href="paginas/treino.php">Treinos</a>
    <a href="blog.php">Blog</a>
    <a href="avaliacao.html">Avaliação</a>
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
<section class="treino-hero">
    <div class="treino-hero-text">
      <h1 style="font-size: 90px; margin-bottom: -20px;  color:#f90030">SEUS TREINOS</h1>
      <p>Aqui você encontra seus treinos cadastrados pelo seu instrutor!</p>
    </div>
  </section>

  <div class="info-row">
    <div style="color:#ddd">Total de treinos: <strong><?= count($treinos) ?></strong></div>

    <div style="display:flex;gap:12px; align-items:center;">
      <input id="searchInput" class="form-control search" placeholder="Pesquisar por título...">
      <select id="sortSelect" class="form-select" style="width:160px;">
        <option value="date-asc">Data ↑</option>
        <option value="date-desc" selected>Data ↓</option>
        <option value="title-asc">Título A→Z</option>
        <option value="title-desc">Título Z→A</option>
      </select>
    </div>
  </div>

  <?php if (empty($treinos)): ?>
    <div class="no-data">
      <h4>Nenhum treino cadastrado pra você ainda.</h4>
      <p style="color:#bbb">Quando seu instrutor criar um treino, ele aparecerá aqui. Precisa de treino urgente? Fale com seu instrutor.</p>
    </div>
  <?php else: ?>
    <div class="row g-3" id="treinosGrid">
      <?php foreach ($treinos as $t): 
        $img = !empty($t->imagem) ? $t->imagem : '../img/no-image.png';
        $data_pre = !empty($t->data_prevista) ? date('d/m/Y', strtotime($t->data_prevista)) : '—';
        ?>
        <div class="col-sm-6 col-lg-4 treino-item" 
             data-title="<?= esc(mb_strtolower($t->titulo)) ?>" 
             data-date="<?= esc($t->data_prevista ?: '0000-00-00') ?>">
          <div class="treino-card h-100">
            <img src="<?= esc($img) ?>" class="treino-img" alt="<?= esc($t->titulo) ?>">
            <span class="badge-cat"><?= esc(ucfirst($t->categoria ?? '')) ?></span>
            <h4 style="margin-top:8px"><?= esc($t->titulo) ?></h4>
            <p style="color:#cfcfcf; font-size:0.95rem; margin-top:6px;"><?= nl2br(esc(substr($t->descricao ?? '',0,200))) ?><?= (strlen($t->descricao ?? '')>200) ? '...' : '' ?></p>

            <div class="card-footer">
              <div style="font-size:0.95rem; color:#ddd">
                <div><strong>Nível:</strong> <?= esc(ucfirst($t->nivel ?? '-')) ?></div>
                <div><strong>Data:</strong> <?= esc($data_pre) ?></div>
              </div>

             
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</main>

<script>

const searchInput = document.getElementById('searchInput');
const sortSelect = document.getElementById('sortSelect');
const grid = document.getElementById('treinosGrid');

function applySearchSort(){
  const q = searchInput.value.trim().toLowerCase();
  const items = Array.from(document.querySelectorAll('.treino-item'));

  items.forEach(it => {
    const title = it.dataset.title || '';
    it.style.display = title.includes(q) ? '' : 'none';
  });


  const visible = items.filter(i => i.style.display !== 'none');
  const mode = sortSelect.value;
  visible.sort((a,b) => {
    if(mode === 'date-asc') return (a.dataset.date || '') > (b.dataset.date || '') ? 1 : -1;
    if(mode === 'date-desc') return (a.dataset.date || '') < (b.dataset.date || '') ? 1 : -1;
    if(mode === 'title-asc') return a.dataset.title.localeCompare(b.dataset.title);
    if(mode === 'title-desc') return b.dataset.title.localeCompare(a.dataset.title);
    return 0;
  });
  visible.forEach(v => grid.appendChild(v));
}

searchInput.addEventListener('input', applySearchSort);
sortSelect.addEventListener('change', applySearchSort);


function addToCalendar(title, date){
  if(!date){ alert('Data inválida para esse treino'); return; }
  const d = new Date(date);
  if(isNaN(d)) { alert('Data inválida'); return; }
  const txt = encodeURIComponent(title + ' — Treino Athlos on ' + d.toLocaleDateString());
  alert('Adicionado (simulado): ' + title + ' — ' + d.toLocaleDateString());
}
</script>

</body>
</html>
