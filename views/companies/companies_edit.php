<div class="titulo">
	<h1>Empresas - Editar Empresa</h1>
</div>

<?php if(isset($error) && !empty($error)): ?>
    <div class="alert alert_warning">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<form method="POST">
	<div class="tabarea">
		<div class="tabitem tabitem-2 activetab">
			Gerais
		</div>
		<div class="tabitem tabitem-2">
			Endereço
		</div>
	</div>

	<div class="tabcontent">
		<div class="tabbody" style="display: block;">
		<label for="name">Nome</label><br/>
		<input type="text" name="name" value="<?php echo $company['name']; ?>" required/><br/><br/>

		<label for="cnpj">CNPJ</label><br/>
		<input type="text" name="cnpj" value="<?php echo $company['cnpj']; ?>" required/><br/><br/>

		<label for="ie">Inscrição Estadual</label><br/>
		<input type="text" name="ie" value="<?php echo $company['ie']; ?>" required /><br/><br/>

		<label for="im">Inscrição Municipal</label><br/>
		<input type="text" name="im" value="<?php echo $company['im']; ?>" /><br/><br/>

		<label for="email">E-mail</label><br/>
		<input type="email" name="email" value="<?php echo $company['email']; ?>" required/><br/><br/>

		<label for="phone">Telefone</label><br/>
		<input type="text" name="phone" value="<?php echo $company['phone']; ?>"/><br/><br/>

		<label for="stars">Estrelas</label><br/>
		<select type="text" name="stars" id="stars"/>
			<option value="1" <?php echo ($company['stars']=='1')?'selected="selected"':''; ?>>1 Estrela</option>		
			<option value="2" <?php echo ($company['stars']=='2')?'selected="selected"':''; ?>>2 Estrelas</option>		
			<option value="3" <?php echo ($company['stars']=='3')?'selected="selected"':''; ?>>3 Estrelas</option>		
			<option value="4" <?php echo ($company['stars']=='4')?'selected="selected"':''; ?>>4 Estrelas</option>		
			<option value="5" <?php echo ($company['stars']=='5')?'selected="selected"':''; ?>>5 Estrelas</option>		
		</select><br/><br/>

		<label for="internal_obs">Observação</label><br/>
		<textarea name="internal_obs" value="<?php echo $company['internal_obs']; ?>"/></textarea><br/><br/>
	</div>
	<div class="tabbody" style="display: none;">
		<label for="address_zipcode">CEP</label><br/>
		<input type="text" name="address_zipcode" value="<?php echo $company['address_zipcode']; ?>"/><br/><br/>

		<label for="address">Rua</label><br/>
		<input type="text" name="address" value="<?php echo $company['address']; ?>"/><br/><br/>

		<label for="address_number">Número</label><br/>
		<input type="text" name="address_number" value="<?php echo $company['address_number']; ?>"/><br/><br/>

		<label for="address2">Complemnto</label><br/>
		<input type="text" name="address2" value="<?php echo $company['address2']; ?>"/><br/><br/>

		<label for="address_neighb">Bairro</label><br/>
		<input type="text" name="address_neighb" value="<?php echo $company['address_neighb']; ?>"/><br/><br/>

		<label for="address_city">Cidade</label><br/>
		<input type="text" name="address_city" value="<?php echo $company['address_city']; ?>"/><br/><br/>

		<label for="address_country">País</label><br/>
		<input type="text" name="address_country" value="<?php echo $company['address_country']; ?>"/><br/><br/>
	</div>

	<input type="submit" value="Salvar"/>
</form>

<script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/script_zipcode.js"></script>