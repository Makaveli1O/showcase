<?php
class Player{
	private $connection;
	private $table = 'players';

	public int $id = 0;
	public string $name = "";
	public string $subname = "";
	public int $number = 0;
	public string $team = "";

	public function __construct($connection){
        $this->connection = $connection;
    }

	/* * * * * * * * * * * * * * * 
	------------------------------
	Return's players list back to app
	* * * * * * * * * * * * * * */
    public function getAllPlayers(){

        $sql = "SELECT * FROM ".$this->table." WHERE number!=0 ORDER BY subname";

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