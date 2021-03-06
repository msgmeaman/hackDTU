<?php
	
	include_once 'db_functions.php';
    $db = new DB_Functions();

    $inputJSON = file_get_contents('php://input');
	$data = json_decode($inputJSON, FALSE);

	$username = $data->{"username"};
	$user = $db->findUserByUsername($username);
	$user = mysqli_fetch_array($user);

	$id = $user["id"];
	$name = $user["name"];

	$allpets = $db->getPetById($id);

	$pets = array();
	while($row = mysqli_fetch_array($allpets, MYSQLI_ASSOC)) {
        $pets[] = $row;
    }

	$arr = array();

	if($user) {
		$arr["status"] = "success";
		$data = array();
		$data["id"] = $id;
		$data["name"] = $name;
		$data["username"] = $username;
		$data["pets"] = $pets;
		$arr["data"] = $data;
	}
	else
		$arr["status"] = "failed";

	echo json_encode($arr);
	header('Content-Type: application/json');
	return;

?>