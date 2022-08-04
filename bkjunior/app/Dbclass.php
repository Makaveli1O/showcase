<?php
class DBClass {
    private $host = "xxx";
    private $username = "xxx";
    private $password = "xxx";
    private $database = "xxx";

    public $connection;

    // get the database connection
    public function getConnection(){

        $this->connection = null;

            $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
            $this->connection->set_charset("utf8");

        return $this->connection;
    }
}
?>