<?php
/*
Security, SQL injection handling.
*/
class Query extends Dbh{
    public $sql;
    //public $conn;

    public function __construct()
    {
        $this->sql = "";
    }

    private function checkTable($table){
        $tables = array(
            "albums",
            "articles",
            "gallery",
            "players",
            "results",
            "teams",
            "users"
        );

        if (in_array($table, $tables) ) {
            return true;
        }else{
            return false;
        }

    }
    //returns as total row
    public function countRecords($table){
        $legit = $this->checkTable($table);
        if (!$legit) {
            echo "<script>console.log('Table is not permitted.')</script>";
            exit();
        }
        $conn = $this->connect();
        $safe_table = $conn->real_escape_string($table);
        $this->sql = "SELECT COUNT(*) as total FROM $safe_table";
        return $this->sql;
    }

    public function executeCount($sql){
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }

    public function limitNum($start, $end){
        $conn = $this->connect();
        $this->sql .=" LIMIT ".$start.", ".$end;
        return $this->sql;
    }

    public function selectQuery($table){
        $legit = $this->checkTable($table);
        if (!$legit) {
            echo "<script>console.log('Table is not permitted.')</script>";
            exit();
        }
        $conn = $this->connect();
        $safe_table = $conn->real_escape_string($table);
        $this->sql = "SELECT * FROM $safe_table";
        return $this->sql;
    } 

    public function addParametrizedClausule($col){
        //$this->sql .=" WHERE ".$left." = '".$right."'";
        $conn = $this->connect();
        $safe_col = $conn->real_escape_string($col);
        $this->sql .=" WHERE ".$safe_col." = ?"; //parametrized
        return $this->sql;
    }

    public function orderBy($col, $desc = false){
        $conn = $this->connect();
        $safe_col = $conn->real_escape_string($col);
        if ($desc) {
            $this->sql .= " ORDER BY ".$safe_col." DESC";
        }else{
            $this->sql .= " ORDER BY ".$safe_col;
        }
        return $this->sql;
    }

    public function executePreparedQuery($sql, $var, $type){
        $conn = $this->connect();
        $stmt = $conn->prepare($this->sql);
        $safe_var = $conn->real_escape_string($var);
        $stmt->bind_param($type,$safe_var);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }
}
/*

        $stmt = $conn->prepare("SELECT * FROM players WHERE team = ? ORDER BY number");
        $safe_team = $conn->real_escape_string($team);
        $stmt->bind_param('s',$team);
        $stmt->execute();
        $result = $stmt->get_result();
        
*/
?>

