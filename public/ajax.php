<?php

$action = $_POST['action'];
$mydb = new mydb();
switch ($action)
{
    case 'create':
        $mydb->addItem();
        break;
    case 'delete':
        $mydb->delItem();
        break;
    default:
        $mydb->getAll();
}

class mydb
{
    private $pdo = null;
    public function __construct()
    {
        $host = 'mysql';
        $db   = 'testdb';
        $user = 'root';
        $pass = '123456';
        $port = "3306";
        $charset = 'utf8';

        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
        try {
            $this->pdo = new \PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            //throw new \PDOException($e->getMessage(), (int)$e->getCode());
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public function getAll()
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM tb1 ORDER BY id DESC LIMIT 10");
            $stmt->execute();
            $response = $stmt->fetchAll();
            $stmt = $this->pdo->prepare(
                "select (
                    (SELECT SUM(sum) as income from tb1 where type='income')
                    - (SELECT SUM(sum) as income from tb1 where type='outcome')
                    ) as sum"
            );
            $stmt->execute();
            $sumTotal = $stmt->fetchColumn();
            $data = [
                'data' => $response,
                'sum_total' => $sumTotal,
            ];
            echo json_encode($data);
        } catch (\Throwable $ex) {
            echo json_encode(['message' => $ex->getMessage()]);
        }
    }

    public function addItem()
    {
        try {
            $sum = $_POST['sum'];
            $type = $_POST['type'];
            $comment = $_POST['comment'];

            $data = [
                'sum' => $sum,
                'type' => $type,
                'comment' => $comment,
            ];
            $sql = "INSERT INTO tb1 (sum, type, comment) VALUES (:sum, :type, :comment)";
            $stmt= $this->pdo->prepare($sql);
            $stmt->execute($data);
            echo json_encode(['message' => 'OK']);
        } catch (\Throwable $ex) {
            echo json_encode(['message' => $ex->getMessage()]);
        }
    }

    public function delItem()
    {
        try {
            $id = $_POST['id'];
            $data = ['id' => $id];
            $stmt = $this->pdo->prepare( "DELETE FROM tb1 WHERE id =:id");
            //$stmt->bindParam(':id', $id);
            $stmt->execute($data);
            echo json_encode(['message' => 'OK']);
        } catch (\Throwable $ex) {
            echo json_encode(['message' => $ex->getMessage()]);
        }
    }
}