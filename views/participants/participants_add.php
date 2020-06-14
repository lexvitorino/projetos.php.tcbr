<div class="titulo">
	<h1>Participantes - Adicionar Participante</h1>
</div>

<?php if(isset($error) && !empty($error)): ?>
    <div class="alert alert_warning">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
	<label for="name_client">Cliente</label><br/>
	<input id="id_client" type="hidden" name="id_client">
	<input type="text" name="name_client" id="search_clients" data-type="search_clients" required><br/><br/>

	<label for="id_course">Curso</label><br/>
	<select name="id_course" required>
	<?php foreach ($courses_list as $item): ?>
	<option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
	<?php endforeach; ?>
	</select><br/><br/>

	<label for="date_start">Data Inicio</label><br/>
	<input type="date" name="date_start" required/><br/><br/>

	<label for="date_end">Data Fim</label><br/>
	<input type="date" name="date_end" required/><br/><br/>

	<label for="expiration_date">Data Validade</label><br/>
	<input type="date" name="expiration_date" required/><br/><br/>

	<label for="payment_form">Forma de Pagamento</label><br/>
	<select name="payment_form" required>
		<option value=""></option>
		<option value="A">A Vista</option>
		<option value="C">Cartão</option>
	</select><br/><br/>

	<label for="value">Valor Real</label><br/>
	<input type="text" name="value" value="0" required/><br/><br/>

	<label for="discount_value">Valor com Desconto</label><br/>
	<input type="text" name="discount_value" value="0"/><br/><br/>

	<label for="discount_manager">Responsável pelo Desconto</label><br/>
	<input type="text" name="discount_manager" /><br/><br/>

	<label for="certificate_url">Certificado</label><br/>
	<input id="certificate_url" type="file" name="certificate_url"/><br/><br/>
	
	<input type="submit" value="Salvar"/>
</form>