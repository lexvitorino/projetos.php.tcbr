<div class="titulo">
	<h1>Usuários - Adicionar Usuário</h1>
</div>

<?php if(isset($error) && !empty($error)): ?>
    <div class="alert alert_warning">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<form method="POST">
	<label for="name">Nome</label><br/>
	<input type="text" name="name" required/><br/><br/>

	<label for="login">Login</label><br/>
	<input type="text" name="login" required/><br/><br/>

	<label for="password">Password</label><br/>
	<input type="password" name="password"/><br/><br/>

	<label for="id_group">Grupo de Permissões</label><br/>
	<select name="id_group" required>
	<?php foreach ($permission_groups_list as $item): ?>
	<option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
	<?php endforeach; ?>
	</select><br/><br/>

	<input type="submit" value="Salvar"/>
</form>