<?php
require __DIR__ . '/../php/admin/db.class.php';
$db = new db('produto');


$produtos = $db->all(); // retorna array de objetos

function esc($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'utf-8'); }
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Loja - Athlos Suplementos</title>


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800&display=swap" rel="stylesheet">

  <style>
    :root{
      --brand:#f90030;
      --brand-dark:#0f0f12;
      --accent:#ff004d;
      --card-radius:14px;
      --glass: rgba(255,255,255,0.04);
    }
    *{box-sizing:border-box}
    body{
      margin:0;
      font-family: 'Sora', system-ui, -apple-system, "Segoe UI", Roboto, Arial;
      background: linear-gradient(180deg,#0b0b0d 0%, #050505 100%);
      color: #eee;
      -webkit-font-smoothing:antialiased;
      -moz-osx-font-smoothing:grayscale;
    }

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
    .logo-athlos2{ height:46px; }

    .botao-contato{
      background-color:var(--brand);
      border-radius:10px;
      border:none;
      padding:8px 18px;
      color:#fff;
      cursor:pointer;
      font-weight:700;
      box-shadow: 0 6px 18px rgba(249,0,48,0.15);
    }

    /* Main wrapper */
    main.wrapper{ padding-top:110px; padding-bottom:80px; max-width:1200px; margin:0 auto; }

    .loja-hero{
      background:linear-gradient(90deg, rgba(249,0,48,0.95), rgba(255,0,76,0.9));
      padding:28px 20px;
      border-radius:12px;
      margin:16px 0;
      color:#fff;
      display:flex;
      gap:20px;
      align-items:center;
      box-shadow: 0 12px 40px rgba(0,0,0,0.6);
    }
    .hero-text h1{ font-size:2rem; margin:0; color:#fff; font-weight:800; letter-spacing:0.6px;}
    .hero-text p{ margin:6px 0 0; color:#ffe6e9; font-weight:600;}
    .hero-cta{ margin-left:auto; }

    /* Cards grid */
    .product-card{
      background: linear-gradient(180deg, rgba(255,255,255,0.02), rgba(255,255,255,0.01));
      color:#fff;
      border-radius:var(--card-radius);
      padding:12px;
      position:relative;
      overflow:hidden;
      border: 1px solid rgba(255,255,255,0.03);
      transition: transform .18s ease, box-shadow .18s ease;
      display:flex; flex-direction:column; height:100%;
    }
    .product-card:hover{ transform: translateY(-6px); box-shadow: 0 18px 40px rgba(0,0,0,0.6); }

    .product-img{
      width:100%;
      height:200px;
      object-fit:cover;
      border-radius:10px;
      display:block;
      border: 3px solid rgba(255,255,255,0.02);
      background: linear-gradient(180deg,#0f0f0f,#151515);
    }

    .product-badge{ position:absolute; left:12px; top:12px; background:linear-gradient(90deg, rgba(0,0,0,0.5), rgba(0,0,0,0.25)); color:#fff; padding:6px 10px; border-radius:10px; font-weight:700; text-transform:uppercase; font-size:12px; }

    .product-title{ font-weight:800; margin-top:12px; font-size:1rem; color:#fff; min-height:44px; }
    .product-price{ color:var(--brand); font-weight:900; margin-top:6px; font-size:1.05rem; }

    .product-actions{ display:flex; gap:8px; margin-top:auto; align-items:center; }
    .btn-comprar{ flex:1; background:linear-gradient(90deg,var(--brand),var(--accent)); border:none; padding:10px 12px; color:#fff; border-radius:10px; font-weight:800; cursor:pointer; box-shadow:0 8px 20px rgba(249,0,48,0.12);}
    .btn-comprar:disabled{ opacity:0.5; cursor:not-allowed; background:gray; }
    .btn-quick{ background:transparent; color:#fff; border:1px solid rgba(255,255,255,0.06); padding:8px 10px; border-radius:10px; font-weight:700; }

    .cart-badge{ position:absolute; top:-6px; right:-8px; background:var(--brand); color:#fff; padding:3px 7px; border-radius:999px; font-weight:700; font-size:11px; }

    /* Filters row */
    .filters-wrap{ margin-top:8px; margin-bottom:18px; padding:12px; border-radius:12px; background: rgba(255,255,255,0.02); border:1px solid rgba(255,255,255,0.02); }

    /* Offcanvas (carrinho) */
    .offcanvas-cart .offcanvas-header{ border-bottom:1px solid rgba(255,255,255,0.03); }
    .offcanvas-cart .offcanvas-body{ color:#e9e9e9; background: linear-gradient(180deg,#0b0b0d,#070707); min-height:320px; }
    .cart-item img{ width:72px; height:72px; object-fit:cover; border-radius:10px; border:2px solid rgba(249,0,48,0.12); }

    /* Toaster */
    .toast-container-fixed{ position:fixed; right:18px; bottom:18px; z-index:12000; }

    /* Toast styles (custom) */
    .toast{
      transition: transform .25s ease, opacity .25s ease;
    }

    /* Quick view modal */
    .modal-content.bg-dark{ background: linear-gradient(180deg,#0b0b0d,#0a0a0a); border-radius:12px; color:#fff; }

    /* Empty state */
    .empty-illustration{ opacity:0.6; }

    /* small screens */
    @media (max-width:900px){
      header{ padding:10px 14px; }
      main.wrapper{ padding-top:120px; padding-left:14px; padding-right:14px; }
      .product-img{ height:160px; }
      .loja-hero{ flex-direction:column; text-align:center; align-items:flex-start; gap:8px; padding:18px; }
      .hero-cta{ margin-left:0; width:100%; text-align:right;}
    }
  </style>
</head>
<body>

<header>
  <img class="logo-athlos2" src="../img/LOGO-ATHLOS2.png" alt="logo athlos">
  <nav style="display:flex; gap:18px; align-items:center;">
    <a href="../index.html">Início</a>
    <a href="../paginas/sobre.html">Sobre Nós</a>
    <a href="../paginas/loja.php" class="active">Loja</a>
    <a href="../paginas/treino.php">Treinos</a>
    <a href="../paginas/blog.php">Blog</a>
    <a href="../paginas/avaliacao.html">Avaliação</a>
  </nav>

  <div style="display:flex;align-items:center;gap:14px">
    <button class="botao-contato" onclick="window.location.href='contatos.html'">Contatos</button>

    <button class="btn-cart position-relative" id="openCart" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas" style="background:none;border:none;color:#fff;font-size:20px">
      <i class="fas fa-shopping-cart"></i>
      <span class="cart-badge" id="cartCount">0</span>
    </button>
  </div>
</header>

<main class="wrapper">
<section class="loja-hero container-fluid" style="margin: 0 auto; text-align: center;">
  <div>
    <h1 style="font-size: 3.4rem;font-family: Untyped; font-weight: 900; margin-bottom: -5px; margin-left: 90px; color: #fff;">
      SEU SUPLEMENTO PARA A GUERRA AQUI!
    </h1>
    <p style="font-size: 1.8rem; font-weight: 600; margin-bottom: 20px;margin-left: 90px; color: #000;">
      "Aqui o ferro é religião, a dor é caminho e a glória é destino."
    </p>

    <div style="margin-top: 20px; max-width: 800px; margin-left: 120px;">
     
      <small style="display:block; color:rgb(255, 255, 255); font-weight:600; font-size:1.1rem; white-space:normal; word-wrap:break-word; margin-left: 90px; background-color: #000; border-radius: 10px; padding: 20px;"><i style="color: rgb(0, 214, 0); margin-right: 10px;" class="fa-solid fa-truck-fast"></i>
        <span style="color: rgb(0, 214, 0); ">Frete grátis acima de R$399</span> • Entrega rápida
      </small>
    </div>
  </div>
</section>
 

  <section class="filters-wrap container-fluid"style="background-color: #fff;" >
    <div class="row g-2 align-items-center" >
      <div class="col-md-6 col-lg-7" >
        <input id="searchBar" class="form-control bg-transparent " placeholder="Pesquisar produto, ex: 'Whey'..." style="border: 2px solid #F90030; color:#000">
      </div>
      <div class="col-md-3 col-lg-2">
        <select id="categoryFilter" class="form-select " style="background-color:#f90030; border: 2px solid #F90030; color:#fff">
          <option value="all">Tudo</option>
          <option value="creatina">Creatinas</option>
          <option value="whey">Wheys</option>
          <option value="pretreino">Pré-Treinos</option>
          <option value="strap">Straps</option>
          <option value="adulterados">Adulterados</option>
        </select>
      </div>
      <div class="col-md-3 col-lg-3 text-end">
        <small style="color:#000; margin-right:6px">Ordenar por:</small>
        <select id="sortBy" class="form-select d-inline-block" style="background-color:#f90030; border-color:#fff;color:#fff; width:auto">
          <option value="default">Relevância</option>
          <option value="price-asc">Preço ↑</option>
          <option value="price-desc">Preço ↓</option>
          <option value="name-asc">A-Z</option>
        </select>
      </div>
    </div>
  </section>

  <section id="produtos" class="container my-4">
    <div class="row g-3" id="productsGrid">

      <?php if (!empty($produtos)): ?>
        <?php foreach ($produtos as $idx => $p):

          $nome = $p->nome ?? 'Produto';
          $descricao = $p->descricao ?? 'Sem descrição disponível.';
          $categoria = $p->categoria ?? 'outros';
          $preco = is_numeric($p->preco) ? number_format((float)$p->preco, 2, '.', '') : '0.00';
          $preco_display = is_numeric($p->preco) ? 'R$ ' . number_format((float)$p->preco, 2, ',', '.') : 'R$ 0,00';
          $imagem = $p->imagem ?? '../img/no-image.png';
          $estoque = isset($p->estoque) ? (int)$p->estoque : 0;
          $id = $p->id ?? ('prod_' . $idx);

        ?>
        <div class="col-sm-6 col-md-4 col-lg-3 reveal product-item"
             data-category="<?= esc($categoria) ?>"
             data-name="<?= esc($nome) ?>"
             data-price="<?= esc($preco) ?>"
             data-id="<?= esc($id) ?>"
             data-desc="<?= esc($descricao) ?>"
             data-img="<?= esc($imagem) ?>">
             

          <div class="product-card">

            <div class="product-badge"><?= esc(ucfirst($categoria)) ?></div>

            <img class="product-img" src="<?= esc($imagem) ?>" alt="<?= esc($nome) ?>">

            <div class="product-title"><?= esc($nome) ?></div>
            <div class="product-price"><?= $preco_display ?></div>

            <?php if ($estoque <= 0): ?>
              <small style="display:block; margin-top:6px; color:#ffc8c8;">Esgotado</small>
            <?php endif; ?>

            <div class="product-actions">
              <a href="loja.php?comprar=<?= esc($id) ?>" 
   class="btn-comprar" 
   style="text-align:center; text-decoration:none; display:block; <?= $estoque <= 0 ? 'pointer-events:none; opacity:0.5;' : '' ?>">
   <?= $estoque <= 0 ? 'Esgotado' : 'Comprar' ?>
</a>

              </button>
              <button class="btn-quick" data-bs-toggle="modal" data-bs-target="#quickViewModal">Ver</button>
            </div>

          </div>
        </div>
        <?php endforeach; ?>

      <?php else: ?>
        <div class="col-12">
          <div class="alert alert-info">Nenhum produto encontrado.</div>
        </div>
      <?php endif; ?>

    </div>
  </section>

  <footer style="margin-top:28px; text-align:center;">
    <small style="color:#9a9a9a">&copy; <?= date('Y') ?> Athlos Suplementos • Todos os direitos reservados</small>
  </footer>
</main>

<!-- QUICK VIEW MODAL -->
<div class="modal fade" id="quickViewModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark text-light">
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-6">
            <img id="quickImg" src="" alt="" style="width:100%;height:360px;object-fit:cover;border-radius:12px">
          </div>
          <div class="col-md-6">
            <h4 id="quickTitle"></h4>
            <p id="quickPrice" style="color:var(--brand);font-weight:900;font-size:1.3rem"></p>
            <p id="quickDesc" style="color:rgba(255,255,255,0.85)"></p>

            <div class="mt-3 d-flex gap-2 align-items-center">
              <button id="quickAdd" class="btn-comprar">Adicionar ao carrinho</button>
              <button class="btn btn-outline-light" data-bs-dismiss="modal">Fechar</button>
            </div>

            <hr style="border-color: rgba(255,255,255,0.04)">

            <div style="font-size:0.9rem;color:#cfcfcf">
              <strong>Entrega</strong>
              <p style="margin:6px 0 0">Prazo estimado: 2-5 dias úteis. Frete grátis acima de R$99,00.</p>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="offcanvas offcanvas-end offcanvas-cart" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
  <div class="offcanvas-header bg-dark text-light">
    <h5 id="cartOffcanvasLabel"><i style="margin-right: 10px;" class="fa-solid fa-cart-shopping"></i> Seu carrinho</h5>
    <button  type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>
  <div class="offcanvas-body">
    <div id="cartList" style="min-height:160px"></div>

    <div class="d-flex justify-content-between align-items-center mt-3">
      <h5>Total</h5>
      <h5 id="cartTotal">R$ 0,00</h5>
    </div>

    <div class="mt-3 d-grid gap-2">
      <button id="checkoutBtn" class="btn-finalizar w-100" style="background:linear-gradient(90deg,var(--brand),var(--accent)); border-radius:10px; border:none; padding:10px; color:#fff; font-weight:800;">
        Finalizar compra
      </button>
      <button id="checkoutWhatsapp" class="btn btn-outline-light w-100" title="Finalizar via WhatsApp">
        <i class="fa-brands fa-whatsapp"></i> Pagar via WhatsApp
      </button>
    </div>
  </div>
</div>

<div class="toast-container-fixed" id="toastContainer"></div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>

  const formatBRL = v => new Intl.NumberFormat('pt-BR',{style:'currency',currency:'BRL'}).format(v);


  const WHATSAPP_PHONE = '5511999999999';

  const cartCountEl = document.getElementById('cartCount');
  const cartListEl = document.getElementById('cartList');
  const cartTotalEl = document.getElementById('cartTotal');
  const checkoutBtn = document.getElementById('checkoutBtn');
  const checkoutWhatsapp = document.getElementById('checkoutWhatsapp');
  const toastContainer = document.getElementById('toastContainer');

  let cart = JSON.parse(localStorage.getItem('athlosCart') || '[]');

  function saveCart(){ localStorage.setItem('athlosCart', JSON.stringify(cart)); renderCart(); }

  function addToCart(item){
    const exists = cart.find(ci => ci.id === item.id);
    if(exists) exists.qty++;
    else cart.push({...item, qty:1});
    saveCart();
    showToast(`${item.name} adicionado ao carrinho`);
  }

  function removeFromCart(id){ cart = cart.filter(i => i.id !== id); saveCart(); }
  function changeQty(id, delta){ const it = cart.find(i=>i.id===id); if(!it) return; it.qty += delta; if(it.qty < 1) removeFromCart(id); saveCart(); }

  function renderCart(){
    cartCountEl.innerText = cart.reduce((s,i)=>s+i.qty,0);
    cartListEl.innerHTML = '';
    let total = 0;

    if(cart.length === 0){
      cartListEl.innerHTML = `
        <div class="text-center py-4 text-muted">
          <i class="fa-solid fa-box-open fa-2x empty-illustration" style="opacity:0.5"></i>
          <p style="margin-top:10px;color:#bfbfbf">Seu carrinho está vazio.</p>
        </div>`;
      cartTotalEl.innerText = formatBRL(0);
      return;
    }

    cart.forEach(it => {
      total += it.price * it.qty;
      const row = document.createElement('div');
      row.className = 'cart-item d-flex gap-3 align-items-center mb-3 p-2 rounded';

      row.innerHTML = `
        <img src="${it.img}" alt="${it.name}">
        <div style="flex:1">
          <div class="fw-bold text-light">${it.name}</div>
          <div class="text-muted small">Qtd: <span class="fw-bold">${it.qty}</span></div>
        </div>
        <div class="text-end">
          <div class="fw-bold text-light mb-1">${formatBRL(it.price * it.qty)}</div>
          <div class="d-flex gap-1 justify-content-end">
            <button class="btn btn-sm btn-outline-light" data-action="dec" data-id="${it.id}">-</button>
            <button class="btn btn-sm btn-outline-light" data-action="inc" data-id="${it.id}">+</button>
            <button class="btn btn-sm btn-danger" data-action="remove" data-id="${it.id}" title="Remover">
              <i class="fa-solid fa-trash"></i>
            </button>
          </div>
        </div>
      `;
      cartListEl.appendChild(row);
    });

    cartTotalEl.innerText = formatBRL(total);
  }


  cartListEl.addEventListener('click', (e) => {
    const btn = e.target.closest('button');
    if(!btn) return;
    const action = btn.dataset.action;
    const id = btn.dataset.id;
    if(action === 'inc') changeQty(id, 1);
    if(action === 'dec') changeQty(id, -1);
    if(action === 'remove') removeFromCart(id);
  });


  checkoutBtn.addEventListener('click', () => {
    if(cart.length === 0){ showToast('Carrinho vazio', true); return; }
    showToast('Compra finalizada! Seu pedido será enviado, verifique o status no dashboard!');

    cart = []; saveCart();
  });


  checkoutWhatsapp.addEventListener('click', () => {
    if(cart.length === 0){ showToast('Carrinho vazio', true); return; }
    const lines = [];
    lines.push('Olá! Gostaria de fazer o pedido:');
    let total = 0;
    cart.forEach((it,i) => {
      lines.push(`${i+1}. ${it.name} x${it.qty} - ${formatBRL(it.price * it.qty)}`);
      total += it.price * it.qty;
    });
    lines.push(`TOTAL: ${formatBRL(total)}`);
    lines.push('');
    lines.push('Endereço:');
    lines.push('Telefone:');
    const text = encodeURIComponent(lines.join('\n'));

    const url = `https://wa.me/${WHATSAPP_PHONE}?text=${text}`;
    window.open(url, '_blank');
  });


  const productNodes = document.querySelectorAll('.product-item');

  productNodes.forEach((node, idx) => {
    const card = node.querySelector('.product-card');
    const imgEl = node.querySelector('.product-img');
    const name = node.dataset.name;
    const price = parseFloat(node.dataset.price) || 0;
    const id = node.dataset.id || (name.replace(/\s+/g,'_').toLowerCase() + '_' + idx);
    const desc = node.dataset.desc || 'Sem descrição disponível.';
    const img = node.dataset.img || (imgEl ? imgEl.src : '');

    node.dataset.id = id;

    const comprarBtn = card.querySelector('.btn-comprar');
    if (comprarBtn) {
      comprarBtn.addEventListener('click', (e)=> {
        if (comprarBtn.disabled) return;
        addToCart({ id, name, price, img });
        e.target.innerHTML = '<i class="fa-solid fa-check"></i>';
        setTimeout(()=> e.target.innerText = 'Comprar', 900);
      });
    }


    const quickBtn = card.querySelector('.btn-quick');
    if (quickBtn) {
      quickBtn.addEventListener('click', ()=> {
        document.getElementById('quickImg').src = img;
        document.getElementById('quickTitle').innerText = name;
        document.getElementById('quickPrice').innerText = formatBRL(price);
        document.getElementById('quickDesc').innerText = desc;

        document.getElementById('quickAdd').onclick = () => {
          addToCart({ id, name, price, img });
          const quickModal = bootstrap.Modal.getInstance(document.getElementById('quickViewModal'));
          quickModal.hide();
        };
      });
    }
  });

  const searchBar = document.getElementById('searchBar');
  const categoryFilter = document.getElementById('categoryFilter');
  const sortBy = document.getElementById('sortBy');

  searchBar.addEventListener('input', applyFilters);
  categoryFilter.addEventListener('change', applyFilters);
  sortBy.addEventListener('change', applySort);

  function applyFilters(){
    const query = searchBar.value.trim().toLowerCase();
    const cat = categoryFilter.value;
    const nodes = document.querySelectorAll('.product-item');
    nodes.forEach(n => {
      const name = (n.dataset.name || '').toLowerCase();
      const matchesQuery = name.includes(query);
      const matchesCat = (cat === 'all') ? true : n.dataset.category === cat;
      n.style.display = (matchesQuery && matchesCat) ? '' : 'none';
    });
    applySort();
  }

  function applySort(){
    const mode = sortBy.value;
    const grid = document.getElementById('productsGrid');
    const items = Array.from(grid.querySelectorAll('.product-item')).filter(i => i.style.display !== 'none');
    items.sort((a,b)=>{
      const pa = parseFloat(a.dataset.price) || 0, pb = parseFloat(b.dataset.price) || 0;
      const na = (a.dataset.name||'').toLowerCase(), nb = (b.dataset.name||'').toLowerCase();
      if(mode === 'price-asc') return pa - pb;
      if(mode === 'price-desc') return pb - pa;
      if(mode === 'name-asc') return na.localeCompare(nb);
      return 0;
    });
    items.forEach(i => grid.appendChild(i));
  }

  const io = new IntersectionObserver(entries=>{ entries.forEach(e=>{ if(e.isIntersecting) e.target.classList.add('visible'); }); }, { threshold:.12 });
  function revealOnScroll(){ document.querySelectorAll('.reveal').forEach(el => io.observe(el)); }
  revealOnScroll();

  function showToast(msg, isError=false){
    const t = document.createElement('div');
    t.className = 'toast align-items-center text-bg-dark border-0 mb-2';
    t.role = 'alert';
    t.innerHTML = `<div class="d-flex"><div class="toast-body">${msg}</div><button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button></div>`;
    toastContainer.appendChild(t);
    const bs = new bootstrap.Toast(t, { delay: 2000 });
    bs.show();
    t.addEventListener('hidden.bs.toast', ()=> t.remove());
  }

  renderCart();
  applyFilters();
  window.addEventListener('resize', revealOnScroll);
</script>
</body>
</html>
