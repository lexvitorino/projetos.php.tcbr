<div class="titulo">
	<h1>Participantes - Editar Participante</h1>
</div>

<?php if(isset($error) && !empty($error)): ?>
    <div class="alert alert_warning">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
	<label for="id_client">Cliente</label><br/>
	<select name="id_client" required>
	<?php foreach ($permission_clients_list as $item): ?>
	<option value="<?php echo $item['id'] ?>" <?php echo ($item['id']==$participant['id_client'])?'selected="selected"':''; ?>> <?php echo $item['name']; ?></option>
	<?php endforeach; ?>
	</select><br/><br/>

	<label for="id_course">Curso</label><br/>
	<select name="id_course" required>
	<?php foreach ($permission_courses_list as $item): ?>
	<option value="<?php echo $item['id'] ?>" <?php echo ($item['id']==$participant['id_course'])?'selected="selected"':''; ?>> <?php echo $item['name']; ?></option>
	<?php endforeach; ?>
	</select><br/><br/>

	<label for="date_start">Data Inicio</label><br/>
	<input type="date" name="date_start" value="<?php echo $participant['date_start']; ?>" required/><br/><br/>

	<label for="date_end">Data Fim</label><br/>
	<input type="date" name="date_end" value="<?php echo $participant['date_end']; ?>" required/><br/><br/>

	<label for="expiration_date">Data Validade</label><br/>
	<input type="date" name="expiration_date" value="<?php echo $participant['expiration_date']; ?>"/><br/><br/>

	<label for="value">Valor Real</label><br/>
	<input type="text" name="value" value="<?php echo $participant['value']; ?>" required/><br/><br/>

	<label for="payment_form">Valor com Desconto</label><br/>
	<input type="text" name="payment_form" value="<?php echo $participant['payment_form']; ?>" /><br/><br/>

	<label for="discount_manager">Responsável pelo Desconto</label><br/>
	<input type="text" name="discount_manager" value="<?php echo $participant['discount_manager']; ?>" /><br/><br/>

	<label for="certificate_url">Certificado</label><br/>
	<input id="certificate_url" type="file" name="certificate_url" value="<?php echo $participant['certificate_url']; ?>"/><br/><br/>
	
	<input type="submit" value="Salvar"/><br/><br/>

	<div class="certificates-img">
		<div class="certificates-img-title">
			Cetificado
		</div>
		<div class="certificates-img-body">
			<img id="certificate_url_img" src="<?php echo BASE_URL.'/assets/images/certificates/'.$participant['certificate_url']; ?>" alt="certificates" width="400" style="<?php echo ($participant['certificate_url']=='')?'display: none':'display: block'; ?>">
		</div>
	</div>
	<br/><br/>
</form>