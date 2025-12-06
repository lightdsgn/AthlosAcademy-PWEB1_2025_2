<?php
require './db.class.php';
require './header.php';
error_reporting(0);
ini_set('display_errors', 0);

$db = new db();
$db->checkLogin();


if ($_SESSION['usuario_tipo'] === 'cliente') {
    header('Location: cliente.php');
    exit;
}

// Buscar quantidades reais
$dbUsuarios = new db('usuario');
$totalUsuarios = count($dbUsuarios->all());

$dbPosts = new db('post');
$totalPosts = count($dbPosts->all());

$dbTreinos = new db('treino');
$totalTreinos = count($dbTreinos->all());

$dbProdutos = new db('produto');
$totalProdutos = count($dbProdutos->all());




$alertas = [
    ['mensagem'=>'Produto "Creatina Monohidratada" com estoque baixo','tipo'=>'danger'],
    ['mensagem'=>'Treino do cliente João cancelado','tipo'=>'warning']
];
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<title>Dashboard Admin</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
body {font-family:'Sora',sans-serif; background:#f4f4f4;}
.navbar {background:#111; border-bottom:3px solid #f90030; box-shadow:0 4px 10px rgba(0,0,0,0.5);}
.navbar-brand{font-weight:800; color:#f90030 !important;}
.card{border-radius:15px; transition:0.3s;}
.card:hover{transform:translateY(-5px); box-shadow:0 15px 30px rgba(249,0,48,0.3);}
.card-body h5{font-weight:700;}
.icon-card{font-size:3rem; margin-bottom:10px; color:#f90030;}
.kpi-card{text-align:center; color:#fff;}
.kpi-card .card-body{padding:20px;}
.alert-dashboard{border-radius:10px;}
h3{font-weight:800; margin-bottom:30px; color:#f90030;}
</style>
</head>
<body>



<div class="container mt-5">
    <h1 style="margin-top: 27px;width:120%;margin-left:-100px;  background-color: #000000ff; color:#f90030; font-family:Untyped; text-align:center; padding:40px 100px; font-size:55px">PAINEL ADMINISTRATIVO - <span style="color:#fff; ">ATHLOS</span></h1>
<h3 style="margin-top:50px">Bem vindo, <?= htmlspecialchars($_SESSION['nome']) ?></h3>

<div class="row g-4 mb-5">

         <div class="col-md-3" style="margin-right:-10px">
            <div class="card dash-card text-white shadow"style="background-color: #f90030; color:#fff; border:none">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5>Usuarios</h5>
                        <h2><?= $totalUsuarios ?></h2>

                    </div>
                    <i class="bi bi-people-fill display-4"></i>
                </div>
            </div>
        </div>
        
         <div class="col-md-3"style="margin-right:-10px">
            <div class="card dash-card text-white shadow"style="background-color: #f90030; color:#fff; border:none">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5>Postagens</h5>
                        <h2><?= $totalPosts ?></h2>

                    </div>
                    <i class="bi bi-person-badge-fill display-4"></i>
                </div>
            </div>
        </div>
       
        <div class="col-md-3"style="margin-right:-10px">
            <div class="card dash-card text-white shadow"style="background-color: #f90030; color:#fff; border:none">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5>Treinos</h5>
                        <h2><?= $totalTreinos ?></h2>

                    </div>
                    <i class="bi bi-card-checklist display-4"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3"style="margin-right:-10px">
            <div class="card dash-card text-white shadow"style="background-color: #f90030; color:#fff; border:none">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h5>Produtos</h5>
                        <h2><?= $totalProdutos ?></h2>

                    </div>
                   <i class="bi bi-bag-fill display-4"></i>
                </div>
            </div>
        </div>



<div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card shadow dash-action-card">
                <div class="card-body text-center" >
                    <i style="color:#f90030; font-size: 55px; margin-bottom:10px;margin-top:10px" class="fa-solid fa-address-card"></i>
                    <h5>Gerenciar Usuários</h5>
                    <a style="background-color:#f90030; border:none; padding:10px" href="usuario/UsuarioList.php" class="btn btn-primary btn-sm mt-2 w-100">Acessar</a>
                    <a style="background-color:#f90030; border:none; padding:10px"  href="usuario/UsuarioForm.php" class="btn btn-primary btn-sm mt-2 w-100">Criar Usuario</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow dash-action-card">
                <div class="card-body text-center">
                    <i style="color:#f90030; font-size: 55px; margin-bottom:10px; margin-top:10px"  class="fa-solid fa-cart-shopping"></i>
                    <h5>Gerenciar Produtos</h5>
                    <a style="background-color:#f90030; border:none; padding:10px"  href="produto/ProdutoList.php" class="btn btn-success btn-sm mt-2 w-100">Acessar</a>
                    <a style="background-color:#f90030; border:none; padding:10px"  href="produto/ProdutoForm.php" class="btn btn-success btn-sm mt-2 w-100">Criar Produto</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow dash-action-card">
                <div class="card-body text-center">
                   <i style="color:#f90030; font-size: 55px; margin-bottom:10px;margin-top:10px" class="fa-solid fa-dumbbell"></i>
                    <h5>Gerenciar Treinos</h5>
                    <a style="background-color:#f90030; border:none; padding:10px; color:#fff"  href="treino/TreinoList.php" class="btn btn-warning btn-sm mt-2 w-100">Acessar</a>
                    <a style="background-color:#f90030; border:none; padding:10px; color:#fff"  href="treino/TreinoForm.php" class="btn btn-warning btn-sm mt-2 w-100">Criar treino</a>
                </div>
                
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow dash-action-card">
                <div class="card-body text-center">
                     <i style="color:#f90030; font-size: 55px; margin-bottom:10px;margin-top:10px" class="fa-solid fa-newspaper"></i>
                    <h5>Gerenciar Posts</h5>
                    <a style="background-color:#f90030; border:none; padding:10px; color:#fff"  href="post/PostList.php" class="btn btn-info btn-sm mt-2 w-100">Acessar</a>
                     <a style="background-color:#f90030; border:none; padding:10px; color:#fff"  href="post/PostForm.php" class="btn btn-info btn-sm mt-2 w-100">Criar Postagem</a>
                </div>
            </div>
        </div>
    </div>

</div>


<div class="row g-4 mb-4">
<div class="col-md-6"><div class="card p-3"><h5>Novos usuários (última semana)</h5><canvas id="usuariosChart"></canvas></div></div>
<div class="col-md-6"><div class="card p-3"><h5>Treinos por Instrutor</h5><canvas id="treinosChart"></canvas></div></div>
</div>


<div class="row g-4 mb-4">
<div class="col-md-12">
<?php foreach($alertas as $a): ?>
<div class="alert alert-<?= $a['tipo'] ?> alert-dashboard"><i class="bi bi-exclamation-triangle"></i> <?= $a['mensagem'] ?></div>
<?php endforeach; ?>
</div>
</div>


</div>

<script>
    
const ctx1 = document.getElementById('usuariosChart').getContext('2d');
new Chart(ctx1,{type:'bar',data:{labels:['Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],datasets:[{label:'Novos usuários',data:<?= json_encode($novosUsuariosSemana) ?>,backgroundColor:'#f90030'}]},options:{responsive:true}});

const ctx2 = document.getElementById('treinosChart').getContext('2d');
new Chart(ctx2,{type:'line',data:{labels:['Instrutor 1','Instrutor 2','Instrutor 3','Instrutor 4','Instrutor 5','Instrutor 6','Instrutor 7','Instrutor 8'],datasets:[{label:'Treinos',data:<?= json_encode($treinosPorInstrutor) ?>,backgroundColor:'rgba(249,0,48,0.2)',borderColor:'#f90030',borderWidth:2,fill:true} ]},options:{responsive:true}});
</script>

</body>
</html>
