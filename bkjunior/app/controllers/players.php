<?php
  include_once '../Dbclass.php';
  include_once '../models/Player.php';

  class PlayersController{


    public function getAllPlayers(){
      $player = new Player($connection);

      $result = $player->read();

      $players = array();

      $i = 0;
      while ($row = $result->fetch_assoc()){
        $players[$i]['id'] = $row['id'];
        $players[$i]['name'] = $row['name'];
        $players[$i]['subname'] = $row['subname'];
        $players[$i]['number'] = $row['number'];
        $players[$i]['img'] = $row['img'];
        $players[$i]['team'] = $row['team'];
        $i++;
      }
      return json_encode($players);
    }

  }




/*
  $dbclass = new DBClass();
  $connection = $dbclass->getConnection();

  $player = new Player($connection);

  $result = $player->read();

  $players = array();

  $i = 0;
  while ($row = $result->fetch_assoc()){
      $players[$i]['id'] = $row['id'];
      $players[$i]['name'] = $row['name'];
      $players[$i]['subname'] = $row['subname'];
      $players[$i]['number'] = $row['number'];
      $players[$i]['img'] = $row['img'];
      $players[$i]['team'] = $row['team'];
      $i++;
  }

echo json_encode($players);

?>