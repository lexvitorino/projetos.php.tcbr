<div class="titulo">
	<h1>Permissões - Adicionar Grupo de Permissões</h1>
</div>

<form method="POST">
	<label for="name">Nome Grupo</label><br/>
	<input type="text" name="name" required/><br/><br/>

	<label>Permissões</label><br/><br/>
	<?php foreach($permission_params_list as $p): ?>
	<div class="p_item">
		<input type="checkbox" name="permissions[]" value="<?php echo $p['id']; ?>" id="<?php echo $p['id']; ?>" />	
		<label for="<?php echo $p['id']; ?>"><?php echo $p['name']; ?></label><br/>
	</div>	
	<?php endforeach; ?><br/>

	<input type="submit" value="Salvar"/>
</form>