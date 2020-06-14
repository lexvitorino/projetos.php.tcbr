<div class="titulo">
	<h1>Certificados - Lançar Certificado</h1>
</div>

<?php if(isset($error) && !empty($error)): ?>
    <div class="alert alert_warning">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<form method="POST">
	<label for="id_certificates">Certificado</label><br/>
	<select name="id_certificates" required>
	<?php foreach ($certificates_list as $item): ?>
	<option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
	<?php endforeach; ?>
	</select><br/><br/>

	<label for="tipo_movimento">Tipo de Movimento</label><br/>
	<select name="tipo_movimento">
	<option value="E">Entrada</option>
	<option value="S">Saída</option>
	</select><br/><br/>

	<label for="amount">Quantidade</label><br/>
	<input type="text" name="amount" required/><br/><br/>

	<label for="comment">Observação</label><br/>
	<textarea name="comment"/></textarea><br/><br/>

	<input type="submit" value="Salvar"/>
</form>