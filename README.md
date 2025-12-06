# Athlos Academy – Sistema Web de Gestão & E-commerce

O **Athlos Academy** é um sistema web desenvolvido para auxiliar academias, treinadores e alunos na organização, gerenciamento e acompanhamento de atividades esportivas. O projeto foi criado no contexto da disciplina **Programação Web I (PWEB1)** e foi desenvolvido com foco em clareza, usabilidade e boas práticas.

---

## 🚀 Funcionalidades Principais

- Cadastro e gestão de usuários (alunos, instrutores e administradores)  
- Autenticação e controle de permissões  
- Criação e organização de treinos e exercícios  
- Planos personalizados por aluno  
- Acompanhamento de desempenho e registros de progresso  
- Gestão de turmas, horários e aulas  
- Painel administrativo com métricas básicas  
- Interface responsiva e estilizada

---

## 🛠️ Tecnologias Utilizadas

- **HTML5**  
- **CSS3**  
- **JavaScript (ES6+)**  
- **PHP 7/8**  
- **MySQL**  
- **Laragon / XAMPP**  
- **Git & GitHub**

---

## 📁 Estrutura do Projeto (exemplo)

/
├── css/ # Arquivos de estilo
├── img/ # Imagens e ícones
├── paginas/ # Páginas internas do sistema
├── php/ # Scripts PHP (admin, CRUD, conexões)
│ └── admin/
├── sql/ # Arquivos de exportação do banco (dump .sql)
├── index.html # Página inicial (front-end estático)
├── README.md # Esta documentação
└── style.css # Estilo principal


---

## ▶️ Como Executar Localmente

1. Instale o **Laragon**
2. Copie o projeto para:  
   - `C:/laragon/www/` (Laragon)   
3. Inicie o Laragon e clique em Database
4. Abra o database e confira se o banco está lá
5. Após isso, configure o código no Visual Studio Code
6. Acesse no navegador: `http://localhost/PWEB_ATHLOSACADEMY/index.html`

> Observação: o GitHub Pages só serve sites estáticos. Parte PHP só funciona localmente ou em servidor com suporte PHP.

---

## 📸 Sugestão de Capturas de Tela

Adicione imagens dentro da pasta


---

## ✅ Boas Práticas e Recomendações

- Adicione um arquivo `.env` ou `config.php` para credenciais (não versionar dados sensíveis).  
- Use `.gitignore` para excluir `node_modules`, `vendor/`, arquivos temporários e credenciais.  
- Estruture o código por módulos (auth, usuarios, produtos, treinos, posts).  
- Comente queries SQL e regras de negócio importantes.  
- Faça backups regulares do banco (dump SQL).

---

## 🤝 Como Contribuir

1. Faça um **fork** do repositório.  
2. Crie uma branch: `git checkout -b minha-feature`  
3. Faça commits claros: `git commit -m "feat: descrição da alteração"`  
4. Envie para o seu fork e abra um Pull Request.  

---

## 📄 Licença

Uso acadêmico / permissões conforme necessidade. Recomenda-se adicionar **LICENSE (MIT)** se desejar distribuição permissiva.

---

## 👨‍💻 Autores

**Lucas Eduardo Dacroce** e **Erik Martins Gollo**
Professor/Orientador: Jackson Meires Canuto
Instituto Federal de Santa Catarina
CC: Programação Web I - 2025.2
Módulo: VII - Curso Técnico em Informática integrado ao Ensino Médio
GitHub: https://github.com/lightdsgn
