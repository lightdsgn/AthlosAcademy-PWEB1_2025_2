<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
ob_start();

$currentPage = basename($_SERVER['PHP_SELF']);
$pagesSemSair = ['login.php', 'UsuarioForm.php'];
?>

<style>
header img{ width:150px; }
header nav a{ color:#fff; margin:0 10px; text-decoration:none; font-weight:600;}
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
    margin-right:-27px;
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

.botao-login {
    background-color: #000;
    border: 2px solid #f90030;
    border-radius: 10px;
    margin-right:-10px;
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
</style>

<header>
    <img class="logo-athlos2" src="/PWEB_ATHLOSACADEMY/img/LOGO-ATHLOS2.png" alt="logo athlos">

    <nav style="display:flex; gap:25px; align-items:center;">
        <a href="/PWEB_ATHLOSACADEMY/php/admin/index.php">Dashboard</a>
        <a href="/PWEB_ATHLOSACADEMY/php/admin/usuario/UsuarioList.php">Usuários</a>
        <a href="/PWEB_ATHLOSACADEMY/php/admin/produto/ProdutoList.php">Produtos</a>
        <a href="/PWEB_ATHLOSACADEMY/php/admin/treino/TreinoList.php">Treinos</a>
        <a href="/PWEB_ATHLOSACADEMY/php/admin/post/PostList.php">Postagens</a>
    </nav>

    <div style="display:flex; gap:20px; align-items:center;">
        
      
        <button style="margin-left:30px;width: 140px; padding-left:3px; padding-right:3px" 
                class="botao-login" onclick="window.history.back()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                style="margin-right:10px; margin-top:-3px"
                fill="currentColor" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0m3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z" />
            </svg>
            VOLTAR
        </button>


        <?php if (!in_array($currentPage, $pagesSemSair)): ?>
        <button style="background-color: #f90030;" class="botao-login"
            onclick="window.location.href='/PWEB_ATHLOSACADEMY/index.html'">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                style="margin-right:10px; margin-top:-4px" viewBox="0 0 24 24">
                <path fill="#ffffff"
                    d="M23 12c0 3.345-1.493 6.342-3.85 8.36A10.96 10.96 0 0 1 12 23c-2.73 0-5.227-.994-7.15-2.64A10.98 10.98 0 0 1 1 12C1 5.925 5.925 1 12 1s11 4.925 11 11m-7-3.5a4 4 0 1 0-8 0a4 4 0 0 0 8 0m2.5 9.725V18a4 4 0 0 0-4-4h-5a4 4 0 0 0-4 4v.225q.31.323.65.615A8.96 8.96 0 0 0 12 21a8.96 8.96 0 0 0 6.5-2.775" />
            </svg>
            SAIR
        </button>
        <?php endif; ?>

    </div>
</header>

<div class="container mt-4">
    <div class="row">
