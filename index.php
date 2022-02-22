<?php  

include_once 'model/Conexao.php';
include_once 'model/Manager.php';

$manager = new Manager();

?>
<!DOCTYPE html>
<html>
<head>
	<?php include_once 'view/dependencias.php'; ?>
</head>
<body>

<div class="container">
	<h2 class="text-center">
		Lista de Usuários <i class="fa fa-list"></i>
	</h2>
	<h5 class="text-right">
		<a href="view/page_register.php" class="btn btn-primary btn-xs">
			<i class="fa fa-user-plus"></i>
		</a>
	</h5>
	<div class="table-responsive">
		<table class="table table-hover">
			<thead class="thead">
				<tr>
					<th>ID</th>
					<th>Tipo</th>
					<th>Nome</th>
					<th>Documento</th>
					<th>Email</th>
					<th>Telefone</th>
					<th>Socio</th>
					<th colspan="3">AÇÕES</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($manager->listUser("users") as $user): ?>
				<tr>
					<td><?php echo $user['id']; ?></td>
					<td><?php if($user['type'] === "pf"){echo "Pessoa Fisica";}else{echo "Pessoa Juridica";} ?></td>
					<td><?php echo $user['name']; ?></td>
					<td><?php echo $user['document']; ?></td>
					<td><?php echo $user['email']; ?></td>
					<td><?php echo $user['phone']; ?></td>
					<td><?php if($user['partner']){echo "sim";}else{echo "não";}?></td>
					<td>
						<form method="POST" action="view/page_update.php">
							<input type="hidden" name="id" value="<?=$user['id']?>">
							<button class="btn btn-warning btn-xs">
								<i class="fa fa-user-edit"></i>
							</button>
						</form>
					</td>
					<td>
						<button class="btn btn-danger btn-xs" type="button"  onclick="del(<?=$user['id']?>)">
							<i class="fa fa-trash"></i>
						</button>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>

</div>
</body>
</html>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>

<script type="text/javascript">
function del(id) {
		$.ajax({
			type: "DELETE",
			url: "controller/delete_user.php?id="+id,
			success: function(data)
			{
				location.reload();
			},
		});
}
</script>