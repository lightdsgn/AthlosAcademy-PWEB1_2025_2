    <?php

    class db
    {
        private $host = 'localhost';
        private $user = 'root';
        private $password = '';
        private $port = '3306';
        private $dbname = 'pweb_athlos';
        private $table = 'usuario';

        public function __construct($table = null)
        {
            if (!empty($table)) {
                $this->table = $table;
            }
        }

        public function conn()
        {
            try {
                $conn = new PDO(
                    "mysql:host={$this->host};dbname={$this->dbname};port={$this->port};charset=utf8mb4",
                    $this->user,
                    $this->password,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                    ]
                );
                return $conn;
            } catch (PDOException $e) {
                die('Erro de conexão com o banco: ' . $e->getMessage());
            }
        }

        public function store($dados)
        {
            $conn = $this->conn();
            $campos = array_keys($dados);
            $placeholders = array_fill(0, count($campos), '?');

            $sql = "INSERT INTO {$this->table} (" . implode(',', $campos) . ") 
                    VALUES (" . implode(',', $placeholders) . ")";

            $st = $conn->prepare($sql);
            $st->execute(array_values($dados));

            return $conn->lastInsertId();
        }
public function countWhere($where)
{
    $conn = $this->conn();
    $sql = "SELECT COUNT(*) FROM {$this->table} WHERE $where";
    return (int) $conn->query($sql)->fetchColumn();
}

      
        public function find($id)
        {
            $conn = $this->conn();
            $sql = "SELECT * FROM {$this->table} WHERE id = ?";
            $st = $conn->prepare($sql);
            $st->execute([$id]);
            return $st->fetch();
        }

        public function all()
        {
            $conn = $this->conn();
            $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
            $st = $conn->prepare($sql);
            $st->execute();

            return $st->fetchAll();
        }

        public function destroy($id)
        {
            $conn = $this->conn();
            $sql = "DELETE FROM {$this->table} WHERE id = ?";
            $st = $conn->prepare($sql);
            $st->execute([$id]);
        }

        public function login($dados)
        {
            $conn = $this->conn();
            $sql = "SELECT * FROM usuario WHERE login = ? LIMIT 1";
            $st = $conn->prepare($sql);
            $st->execute([$dados['login']]);
            $result = $st->fetch();

            if (!$result) return 'error';
            if (!password_verify($dados['senha'], $result->senha)) return 'error';

            if (session_status() !== PHP_SESSION_ACTIVE) session_start();

            $_SESSION['usuario_id'] = $result->id;
            $_SESSION['nome'] = $result->nome;
            $_SESSION['tipo'] = $result->tipo; 

            return $result;
        }
public function update($dados)
{
    $conn = $this->conn();

    $id = $dados['id'];
    unset($dados['id']);

    $campos = array_keys($dados);
    $set = implode(', ', array_map(fn($c) => "$c = ?", $campos));

    $sql = "UPDATE {$this->table} SET $set WHERE id = ?";

    $values = array_values($dados);
    $values[] = $id;

    $st = $conn->prepare($sql);
    $st->execute($values);
}


        public function checkLogin()
        {
            if (session_status() !== PHP_SESSION_ACTIVE) session_start();

            if (!isset($_SESSION['usuario_id'])) {
                header("Location: ../login.php");
                exit;
            }
        }
    }
