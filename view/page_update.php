<?php

include_once '../model/Conexao.php';
include_once '../model/Manager.php';
include_once 'dependencias.php';

$manager = new Manager();

$id = $_POST['id'];

?>

<h2 class="text-center">
	Atualizar Usário <i class="fa fa-user-edit"></i>
</h2><hr>

<form id="form-update">

<div class="container col-md-6">
	<div class="form-row">

		<?php foreach($manager->getInfo("users", $id) as $user_info): ?>

		<div class="col-md-12 d-flex">
			<div class="form-check col-md-6">
					<input class="form-check-input" type="radio" name="type" id="pf" value="pf" <?php if($user_info['type'] == 'pf') echo 'checked'; ?> required onchange="setMask()">
					<label class="form-check-label" for="pf">Pessoa Fisica</label>
			</div>
			<div class="form-check cold-md-6">
				<input class="form-check-input" type="radio" name="type" id="pj" value="pj" <?php if($user_info['type'] == 'pj') echo 'checked'; ?> required onchange="setMask()">
				<label class="form-check-label" for="pj">Pessoa Juridica</label>
			</div>
		</div>

		<div class="col-md-12 form-name">
			<label>Nome:</label>
			<input class="form-control" type="text" name="name" required autofocus value="<?=$user_info['name']?>"><br>
		</div>

		<div class="col-md-12 form-document">
				<label>CPF:</label>
				<input class="form-control" type="text" name="document" required id="document" value="<?=$user_info['document']?>"><br>
		</div>

		<div class="col-md-12">
				<label>E-mail:</label>
				<input class="form-control" type="email" name="email" required value="<?=$user_info['email']?>"><br>
		</div>

		<div class="col-md-12">
				<label>Telefone:</label>
				<input class="form-control" type="text" name="phone" required id="phone" value="<?=$user_info['phone']?>"><br>
			</div>

		<div id="radio" class="col-md-12">
			<input class="form-check-input" type="checkbox" id="partner" name="partner" onchange="setPartner()" value="<?=$user_info['partner']?>" <?php if($user_info['partner']) echo 'checked' ?> >
			<label class="form-check-label">Já é sócio?</label>
		</div>


		<div id="buttons" class="col-md-12 d-flex">
			<input type="hidden" name="id" value="<?=$user_info['id']?>">
			<?php endforeach; ?>
			<a class="col-md-6" href="../index.php">
				Voltar
			</a>
			<button class="btn btn-warning btn-lg col-md-16" type="button"  onclick="save()">
				Atualizar user <i class="fa fa-user-edit"></i>
			</button><br><br>
		</div>
	</div>
</div>
</form>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script type="text/javascript">

function getType() {
	return $("#form-update input[name='type']:checked").val();
}

function setPartner() {
	if($('#partner').is(":checked")){
		$('#partner:checked').val(1);
	} else {
		$('#partner').val(0);
	}
}

function setMask () {
	if(getType() == 'pf'){
		$('#document').mask('000.000.000-00');
		$('.form-name label').text('Nome:');
		$('.form-document label').text('CPF:');
	} else {
		$('#document').mask('00.000.000/0000-00');
		$('.form-name label').text('Razão socail:');
		$('.form-document label').text('CNPJ:');
	}
}

$( document ).ready(function() {
	$("#phone").mask("(00) 0000-0000");
	setMask();
});

function save() {
	var form = $("#form-update");
	var actionUrl = form.attr('action');

		$.ajax({
			type: "POST",
			url: "../controller/update_user.php",
			data: form.serialize(),
			success: function(data)
			{
				document.location.href="../index.php";
				console.log(data);
			},
			error: function(exception)
			{
				var erros = Object.entries(exception.responseJSON)
				erros.forEach(appendError)
			}
		});
}

function removeError() {
	$('.alert-danger').remove();
}

function appendError(error) {
	$("input[name='"+ error[0] +"']").after('<div class="alert alert-danger" role="alert">' + error[1] + '</div>')
	setTimeout( removeError, 5000);
	console.log('<div class="alert alert-danger" role="alert">' + error[1] + '</div>');
}
</script>