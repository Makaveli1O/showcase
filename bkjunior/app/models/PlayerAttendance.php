<?php
class PlayerAttendance{
	private $connection;
	private $table = 'player_attendance';

	public int $id = 0;
	public int $player_id = 0;
	public int $attendance_id = 0;
	public int $value = 0;

	public function __construct($connection){
        $this->connection = $connection;
    }
    /* * * * * * * * * * * * * * * *
    --------------------------------
    Return player's ids assigned to given
    attendance id.
    * * * * * * * * * * * * * * * * */
    public function getPlayers($attendance_id){

    	$sql = "SELECT player_id FROM ".$this->table." WHERE attendance_id = '$attendance_id'";
		
    	$result = $this->connection->query($sql);
        if($result ===FALSE){
            http_response_code(500);
            return false;
        }else{
            return $result;
        }
    }

    public function create($attendance_id, $player_id){
        $sql = "INSERT INTO player_attendance (player_id, attendance_id) VALUES ('$player_id', '$attendance_id')";

        $result = $this->connection->query($sql);
        if($result ===FALSE){
            http_response_code(500);
            return false;
        }else{
            return true;
        }
    
    }

    public function remove($attendance_id, $player_id){
        $sql = "DELETE FROM player_attendance
                WHERE player_id = '$player_id' AND attendance_id = '$attendance_id'";

        $result = $this->connection->query($sql);
        if($result ===FALSE){
            http_response_code(500);
            return false;
        }else{
            return true;
        }
    
    }
}
?>