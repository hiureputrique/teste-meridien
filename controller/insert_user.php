<?php  

include_once '../model/Conexao.php';
include_once '../model/Manager.php';
include_once '../model/Validator.php';

const RULES = [
	'type' => ['required'],
	'name' => ['required'],
	'document' => ['unique', 'required', 'cpfOrCnpj'],
	'email' => ['required'],
	'phone' => ['required'],
];

$manager = new Manager();

$data = $_POST;
$validator = new Validator(RULES, $data);

if(isset($data) && !empty($data)) {
	$errors = $validator->validate();
	if(!$errors) {
		$manager->insertUser("users", $data);
		header("Location: ../index.php?user_add_success");
		return;
	}

	http_response_code(400);
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($errors);
}

?>