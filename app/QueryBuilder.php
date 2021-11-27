<?php

namespace App;
use Aura\SqlQuery\QueryFactory;
use PDO;
class QueryBuilder{
    private $pdo;
    private $queryFactory;
    public function __construct()
    {
        $this->pdo = new PDO('mysql:host=127.0.0.1;dbname=marlindev', 'root', '');
        $this->queryFactory = new QueryFactory('mysql');
    } 
    public function getAll($table)
    {
        $select =   $this->queryFactory->newSelect();
        $select->cols(['*'])
        ->from($table);
        $sth = $this->pdo->prepare($select->getStatement());
        $sth->execute($select->getBindValues());
        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }
    public function insert($data, $table)
    {
        $insert  =   $this->queryFactory->newInsert();;
        $insert->into($table)->cols($data);
        $sth = $this->pdo->prepare($insert->getStatement());
        $sth->execute($insert->getBindValues());
    }
    public function update($data, $table,  $id)
    {
        $update =   $this->queryFactory->newUpdate();

        $update->table($table)->cols($data)->where('id = :id')->bindValue("id", $id);

        $sth = $this->pdo->prepare($update->getStatement());
        $sth->execute($update->getBindValues());
    }
    public function delete($table,$id)
    {
        $delete  =   $this->queryFactory->newDelete();
        $delete->from($table)->where('id = :id')->bindValue("id", $id);
        $sth = $this->pdo->prepare($delete->getStatement());
        $sth->execute($delete->getBindValues());
    }
}