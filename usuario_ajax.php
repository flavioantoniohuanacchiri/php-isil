<?php session_start();

include __DIR__."/enviroment.php";

$action = isset($_REQUEST["action"])? $_REQUEST["action"] : "";
$requestData = $_REQUEST;

$objController = new App\Master\Controllers\UsuarioController;

switch ($action) {
	case "list":
		echo $objController->list($requestData);
    	exit;
		break;
	case "show":
		echo $objController->show($requestData["id"]);
    	exit;
		break;
	case "save":
		echo $objController->save($requestData);
    	exit;
		break;
	case "delete":
		echo $objController->destroy($requestData["id"]);
    	exit;
		break;
	default:
		# code...
		break;
}