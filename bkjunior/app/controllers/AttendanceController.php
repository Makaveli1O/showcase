<?php
  include_once '../Dbclass.php';
  include_once '../models/Attendance.php';
  include_once '../models/PlayerAttendance.php';

  class AttendanceController extends DBClass{
    public $connection;

    /*
    constructor
    */
    public function __construct(){
        $this->connection = $this->getConnection();
    }
      /* * * * * * * * * * * * * * * 
    ------------------------------
    Return's players list back to app
    * * * * * * * * * * * * * * */
    public function getAttendances($type){
      $Attendance = new Attendance($this->connection);

      $result = $Attendance->getAttendances($type);
      if($result ===FALSE){
            http_response_code(500);
            return false;
      }

      $attendanceArr = array();
      while ($row = $result->fetch_assoc()){
        $Attendance->id = $row['id'];
        $Attendance->type = $row['type'];
        $Attendance->date = $row['date'];
        $Attendance->u17 = $row['u17'];
        $Attendance->u15 = $row['u15'];
        $Attendance->u12 = $row['u12'];

        array_push($attendanceArr, clone $Attendance);
      }
      return json_encode($attendanceArr);
    }
      /* * * * * * * * * * * * * * * 
    ------------------------------
    Return's id list that attend
    to the given attendance ID.
    * * * * * * * * * * * * * * */
    public function getEventPlayers($attendance_id){
      $PlayerAttendance = new PlayerAttendance($this->connection);

      $result = $PlayerAttendance->getPlayers($attendance_id);

      $ids = array();
      while($row = $result->fetch_assoc()){
        $PlayerAttendance->player_id = $row['player_id'];
        //strval -> react requires string format
        array_push($ids, $PlayerAttendance->player_id);
      }

      return json_encode($ids);


    }

      /* * * * * * * * * * * * * * * 
    ------------------------------
    Insert player's attendance to given
    event.
    * * * * * * * * * * * * * * */
    public function create($attendance_id, $player_id){
      
      $PlayerAttendance = new PlayerAttendance($this->connection);

      $result = $PlayerAttendance->create($attendance_id, $player_id);

      return "Execution 'create PlayerAttendance': ".$result;
    }
      /* * * * * * * * * * * * * * * 
    ------------------------------
    Removes player's attendance to given
    event.
    * * * * * * * * * * * * * * */
    public function remove($attendance_id, $player_id){
      
      $PlayerAttendance = new PlayerAttendance($this->connection);

      $result = $PlayerAttendance->remove($attendance_id, $player_id);

      return "Execution 'remove PlayerAttendance': ".$result;
    }
      /* * * * * * * * * * * * * * * 
    ------------------------------
    Create attendance event.
    * * * * * * * * * * * * * * */
    public function createEvent($date, $type, $u17, $u15, $u12){
      $Attendance = new Attendance($this->connection);
      $result = $Attendance->create($date, $type, $u17, $u15, $u12);

      return "Execution 'create attendance Event': ".$result;
    }

  }
?>