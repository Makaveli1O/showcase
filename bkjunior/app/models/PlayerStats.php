<?php
class PlayerStats{
	public const INIT_VAL = 0;

	private $connection;
	private $table = 'player_stats';

	public int $id = 0;
	public int $player_id = 0;
	public int $stat_id = 0;
	public int $value = 0;

	public function __construct($connection){
        $this->connection = $connection;
    }

    public function getPlayerStats($player_id){
        $sql = "SELECT * FROM " . $this->table . " WHERE player_id = '$player_id' ORDER BY stat_id";

        $result = $this->connection->query($sql);
        if($result ===FALSE){
            http_response_code(500);
            return false;
        }else{
            return $result;
        }

    }

    public function createPlayerStats($player_id, $i){
		$sql = "INSERT INTO ". $this->table ." (player_id, stat_id, value) VALUES('$player_id','$i', $INIT_VAL)";
		//echo $sql."\n";
		$result = $this->connection->query($sql);
        if($result ===FALSE){
            http_response_code(500);
            return false;
        }else{
			return $result;
		}
    }

    public function updateAdd($stat_id, $player_id, $value, $record_id){
        $sql = "INSERT INTO player_stats (id, player_id, stat_id, value)
            VALUES('$record_id', '$player_id', '$stat_id', '$value')
            ON DUPLICATE KEY UPDATE value = value+1
            ";
        $result=$this->connection->query($sql);
        if($result ===FALSE){
            http_response_code(500);
            return false;
        }else{
            return $result;
        }
    }

    public function updateSub($stat_id, $player_id, $value, $record_id){
        $sql = "INSERT INTO player_stats (id, player_id, stat_id, value)
            VALUES('$record_id', '$player_id', '$stat_id', '$value')
            ON DUPLICATE KEY UPDATE value = value-1
            ";
        $result=$this->connection->query($sql);
        if($result ===FALSE){
            http_response_code(500);
            return false;
        }else{
            return $result;
        }
    }

    public function restartStats($player_id){
        $sql = "UPDATE player_stats SET value = 0 WHERE player_id = '$player_id'";

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