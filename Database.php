<?php

class Database{
    public $connection;

    public function __construct($config){
        $dsn = 'mysql:' . http_build_query($config,"",";");

        $this->connection = new PDO($dsn,'root','Max232004');
    }

    public function query($query,$params = []){
        $stmt = $this->connection->prepare($query);

        $stmt->execute($params);

        return $stmt;
    }
}