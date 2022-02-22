<?php  

include_once '../model/Conexao.php';
include_once '../model/Manager.php';
include_once '../model/Validator.php';

const RULES = [
    'type' => ['required'],
    'name' => ['required'],
    'document' => ['required', 'cpfOrCnpj'],
    'email' => ['required'],
    'phone' => ['required'],
];

$manager = new Manager();

$update_user = $_POST;
$id = $_POST['id'];
$validator = new Validator(RULES, $update_user);

if(isset($id) && !empty($id)) {
	$errors = $validator->validate();
	if(!$errors) {
		$manager->updateUser("users", $update_user, $id);
		header("Location: ../index.php?user_update");
		return;
	}

	http_response_code(400);
	header('Content-Type: application/json; charset=utf-8');
	echo json_encode($errors);
}

?>