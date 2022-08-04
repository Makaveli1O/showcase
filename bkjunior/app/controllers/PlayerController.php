<?php
  include_once '../Dbclass.php';
  include_once '../models/Player.php';
  include_once '../models/PlayerStats.php';

  class PlayerController extends DBClass{
    public $connection;

    /*
    constructor
    */
    public function __construct(){
        $this->connection = $this->getConnection();
    }

    /*
      RETURN: list of players as json array of objects
    */

    public function getAllPlayers(){
      $Player = new Player($this->connection);

      $result = $Player->getAllPlayers();
      $playersArr = array();
        while ($row = $result->fetch_assoc()){
          $Player->id = $row['id'];
          $Player->name = $row['name'];
          $Player->subname = $row['subname'];
          $Player->number = $row['number'];
          $Player->img = $row['img'];
          $Player->team = $row['team'];
          array_push($playersArr, clone $Player);
        }
        return json_encode($playersArr);
      }

    /*
      Recursieve function to recieve player stats
      RETURN: player stats as json array of given player
    */


    public function getPlayerStats($player_id, $stats_num){


      $PlayerStats = new PlayerStats ($this->connection);

      $result = $PlayerStats->getPlayerStats($player_id);
      if($result->num_rows > 0){//record found
        $statsArr = array();
        while($row = $result->fetch_assoc()){
          $PlayerStats->id = $row['id'];
          $PlayerStats->player_id = $row['player_id'];
          $PlayerStats->stat_id = $row['stat_id'];
          $PlayerStats->value = $row['value'];

          array_push($statsArr, clone $PlayerStats);
        }
        return json_encode($statsArr);
        /*
          stats were not found, create them with default value,
          then recursive call this function
        */
      }else if($result->num_rows <=4){
        for($i = 1; $i <= $stats_num; $i++){
          $result = $PlayerStats->createPlayerStats($player_id, $i);
        }
        return $this->getPlayerStats($player_id, $stats_num);
      }else{
        echo "Error get playerStats";
        exit(500);
      }
      //
    }

    /*
      Updates existing statistic of given player
      RETURN: TRUE on succes. False on failure.
    */

    public function updateAdd($stat_id, $player_id, $value, $record_id){
      $PlayerStats = new PlayerStats($this->connection);

      $result = $PlayerStats->updateAdd($stat_id, $player_id, $value, $record_id);

      return "Execution 'updateAdd': ".$result;

    }

    /*
      Updates existing statistic of given player
      RETURN: TRUE on succes. False on failure.
    */

    public function updateSub($stat_id, $player_id, $value, $record_id){
      $PlayerStats = new PlayerStats($this->connection);

      $result = $PlayerStats->updateSub($stat_id, $player_id, $value, $record_id);

      return "Execution 'updateAdd': ".$result;

    }

    /*
      Set player's stats to 0
    */

    public function restartStats($player_id){
      $PlayerStats = new PlayerStats($this->connection);

      $result = $PlayerStats->restartStats($player_id);

      return "Execution restarStats: ".$result;
    }

  }
?>