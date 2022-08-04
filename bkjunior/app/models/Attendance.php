<?php
class Attendance{
	private $connection;
	private $table = 'attendance';

	public int $id = 0;
	public string $type = "";
	public string $date = "";
	public int $u17 = 0;
	public int $u15 = 0;
	public int $u12 = 0;

	public function __construct($connection){
        $this->connection = $connection;
    }

    public function getAttendances($type){

        $sql = "SELECT * FROM ".$this->table." WHERE type = '$type' ORDER BY id DESC";

        $result=$this->connection->query($sql);
        if($result ===FALSE){
            http_response_code(500);
            return false;
        }else{
        	return $result;
        }
    }

    public function create($date, $type, $u17, $u15, $u12){
        $sql = "INSERT INTO attendance (type,date, u17, u15, u12)
                VALUES ('$type', '$date', '$u17', '$u15', '$u12')";
        $result=$this->connection->query($sql);
        if($result ===FALSE){
            http_response_code(500);
            return false;
        }else{
            return $result;
        }
    }


}

?>