<?php
	//error_reporting(E_ALL);
	//error_reporting(-1);
	//ini_set('error_reporting', E_ALL);
	include_once './Dbclass.php';

	include_once './controllers/PlayerController.php';
	include_once './controllers/AttendanceController.php';

	include_once './models/Player.php';
	include_once './models/PlayerStats.php';
	include_once './models/Attendance.php';
	include_once './models/PlayerAttendance.php';

	/*
	 Initialize usefull variables
	 */
	$dbclass = new DBClass();
	$connection = $dbclass->getConnection();
	$method = $_SERVER["REQUEST_METHOD"];
	
	/*
		Recognize request method
	*/
	if ($method === 'GET') {
		header('Content-Type: application/json');
		header("Access-Control-Allow-Origin: *");

		/*
		GET actions handling
		*/

		(!isset($_GET['action'])) ? http_response_code(405) : $action = $_GET['action'];
		switch ($action) {
			case 'players':
				$controller = new PlayerController();
				echo $controller->getAllPlayers();
				break;
			case 'playerstats':
				(!isset($_GET['player_id'])) ? http_response_code(405) : $player_id=$_GET['player_id'];
				(!isset($_GET['stats_num'])) ? $stats_num : $stats_num = $_GET['stats_num'];
				$controller = new PlayerController();
				echo $controller->getPlayerStats($player_id, $stats_num);
				break;
			case 'attendance':
				(!isset($_GET['type'])) ? http_response_code(405) : $type = $_GET['type'];
				$controller = new AttendanceController();
				echo $controller->getAttendances($type);
				break;
			case 'attendance_player':
				(!isset($_GET['attendance_id'])) ? http_response_code(405) : $attendance_id = $_GET['attendance_id'];
				$controller = new AttendanceController();
				echo $controller->getEventPlayers($attendance_id);
				break;
			
			default:
				http_response_code(405);
				break;
		}
		/*
		POST actions handling
		*/
	}else if ($method === 'POST') {
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: Content-Type");
		$_POST = json_decode(file_get_contents("php://input"),true);

		(!isset($_POST['action'])) ? http_response_code(405) : $action = $_POST['action'];
		switch ($action) {
			case 'player_attendance_add':
				(!isset($_POST['player_id'])) ? http_response_code(405) : $player_id = $_POST["player_id"];
				(!isset($_POST['attendance_id'])) ? http_response_code(405) : $attendance_id = $_POST['attendance_id'];
				$controller = new AttendanceController();
				echo $controller->create($attendance_id, $player_id);
				break;
			case 'player_attendance_remove':
				(!isset($_POST['player_id'])) ? http_response_code(405) : $player_id = $_POST["player_id"];
				(!isset($_POST['attendance_id'])) ? http_response_code(405) : $attendance_id = $_POST['attendance_id'];
				$controller = new AttendanceController();
				echo $controller->remove($attendance_id, $player_id);
				break;
			case 'add_attendance':
				(!isset($_POST['date'])) ? http_response_code(405) : $date = $_POST["date"];
				(!isset($_POST['type'])) ? http_response_code(405) : $type = $_POST['type'];
				(!isset($_POST['u17'])) ? http_response_code(405) : $u17 = $_POST["u17"];
				(!isset($_POST['u15'])) ? http_response_code(405) : $u15 = $_POST['u15'];
				(!isset($_POST['u12'])) ? http_response_code(405) : $u12 = $_POST['u12'];

				$controller =new AttendanceController();
				echo $controller->createEvent($date, $type, $u17, $u15, $u12);

				break;
			case 'addStat':
				if (!isset($_POST['stat_id']) ||
					!isset($_POST['player_id']) ||
					!isset($_POST['value']) ||
					!isset($_POST['record_id'])) {
					http_response_code(405);
					return;
				}
				$stat_id = $_POST['stat_id'];
				$player_id = $_POST['player_id'];
				$value = $_POST['value'];
				$record_id = $_POST['record_id'];

				$controller = new PlayerController();
				echo $controller->updateAdd($stat_id, $player_id, $value, $record_id);
				break;
			case 'subStat':
				if (!isset($_POST['stat_id']) ||
					!isset($_POST['player_id']) ||
					!isset($_POST['value']) ||
					!isset($_POST['record_id'])) {
					http_response_code(405);
					return;
				}
				$stat_id = $_POST['stat_id'];
				$player_id = $_POST['player_id'];
				$value = $_POST['value'];
				$record_id = $_POST['record_id'];

				$controller = new PlayerController();
				echo $controller->updateSub($stat_id, $player_id, $value, $record_id);
				break;
			case 'restartStats':
				(!isset($_POST['player_id'])) ? http_response_code(405) : $player_id = $_POST["player_id"];
				$controller = new PlayerController();
				echo $controller->restartStats($player_id);
				break;
			default:
				# code...
				break;
		}
	}

?>

