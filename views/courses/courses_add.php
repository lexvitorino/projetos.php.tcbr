<div class="titulo">
	<h1>Cusrsos - Adicionar Curso</h1>
</div>

<?php if(isset($error) && !empty($error)): ?>
    <div class="alert alert_warning">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<form method="POST">
	<label for="name">Nome</label><br/>
	<input type="text" name="name" required/><br/><br/>

	<input type="submit" value="Salvar"/>
</form>