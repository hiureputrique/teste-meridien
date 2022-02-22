<?php include_once 'dependencias.php'; ?>

<h2 class="text-center">
	Cadastro de Usuário <i class="fa fa-user-plus"></i>
</h2>
<hr>

<form id="form-register">
	<div class="container col-md-6">
		<div class="form-row">
			<div class="col-md-12 d-flex">
				<div class="form-check col-md-6">
						<input class="form-check-input" type="radio" name="type" id="pf" value="pf" onchange="setMask()" checked>
						<label class="form-check-label" for="pf">Pessoa Fisica</label>
				</div>
				<div class="form-check cold-md-6">
					<input class="form-check-input" type="radio" name="type" id="pj" value="pj" onchange="setMask()">
					<label class="form-check-label" for="pj">Pessoa Juridica</label>
				</div>
			</div>
			<div class="col-md-12 form-name">
				<label>Nome:</label>
				<input class="form-control" type="text" name="name" required autofocus><br>
			</div>
			<div class="col-md-12 form-document">
				<label>CPF:</label>
				<input class="form-control" type="text" name="document" required id="document"><br>
			</div>
			<div class="col-md-12">
				<label>E-mail:</label>
				<input class="form-control" type="email" name="email" required><br>
			</div>
			<div class="col-md-12">
				<label>Telefone:</label>
				<input class="form-control" type="text" name="phone" required id="phone"><br>
			</div>
			<div id="radio" class="col-md-12">
				<input class="form-check-input" type="checkbox" id="partner" name="partner" onchange="setPartner()" value="0"> 
				<label class="form-check-label">Já é sócio?</label>
			</div>
			<div id="buttons" class="col-md-12 d-flex">
				<a class="col-md-6" href="../index.php">
						Voltar
				</a>
				<button class="btn btn-primary btn-lg col-md-6" type="button"  onclick="save()">
					Adicionar Usuario <i class="fa fa-user-plus"></i>
				</button><br><br>
			</div>
		</div>
	</div>
</form>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script type="text/javascript">

function getType() {
	return $("#form-register input[name='type']:checked").val(); 
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
	$('#document').mask('000.000.000-00');
	$("#phone").mask("(00) 0000-0000")
});

function save() {
	var form = $("#form-register");
	var actionUrl = form.attr('action');

		$.ajax({
			type: "POST",
			url: "../controller/insert_user.php",
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