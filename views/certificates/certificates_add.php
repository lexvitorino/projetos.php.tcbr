<div class="titulo">
	<h1>Cusrsos - Adicionar Certificado</h1>
</div>

<?php if(isset($error) && !empty($error)): ?>
    <div class="alert alert_warning">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<form method="POST">
	<label for="name">Nome</label><br/>
	<input type="text" name="name" required/><br/><br/>

	<label for="id_course">Curso</label><br/>
	<select name="id_course">
	<option value=""></option>
	<?php foreach ($courses_list as $item): ?>
	<option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
	<?php endforeach; ?>
	</select><br/><br/>

	<label for="amount">Quantidade</label><br/>
	<input type="number" name="amount"/><br/><br/>

	<input type="submit" value="Salvar"/>
</form>