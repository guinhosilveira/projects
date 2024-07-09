<?php

class Connection {

    private $databaseFile;
    private $connection;

    public function __construct()
    {
        $this->databaseFile = realpath(__DIR__ . "/database/db.sqlite");
        $this->connect();
    }

    private function connect()
    {
        if (!file_exists($this->databaseFile)) {
            throw new Exception("Database file not found: " . $this->databaseFile);
        }
        $this->connection = new PDO("sqlite:{$this->databaseFile}");
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection()
    {
        return $this->connection ?: $this->connect();
    }

    public function query($query)
    {
        try {
            
            $result = $this->getConnection()->query($query);
            
            $result->setFetchMode(PDO::FETCH_OBJ);
            return $result;
        } catch (PDOException $e) {
            
            throw new Exception("Query failed: " . $e->getMessage());
        }
    }
}