<div class="titulo">
	<h1>Clientes - Adicionar Cliente</h1>
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
			<input type="text" name="name" required /><br/><br/>

			<label for="cpf">CPF</label><br/>
			<input type="text" name="cpf" required /><br/><br/>

			<label for="rg">RG</label><br/>
			<input type="text" name="rg" required /><br/><br/>

			<label for="email">E-mail</label><br/>
			<input type="email" name="email" /><br/><br/>

			<label for="phone">Telefone</label><br/>
			<input type="text" name="phone"/><br/><br/>

			<label for="stars">Estrelas</label><br/>
			<select type="text" name="stars" id="stars"/>
				<option value="1">1 Estrela</option>		
				<option value="2">2 Estrelas</option>		
				<option value="3" selected="selected">3 Estrelas</option>		
				<option value="4">4 Estrelas</option>		
				<option value="5">5 Estrelas</option>		
			</select><br/><br/>

			<label for="id_company">Empresa</label><br/>
			<select name="id_company">
			<?php foreach ($companies_list as $item): ?>
			<option value=""></option>
			<option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
			<?php endforeach; ?>
			</select><br/><br/>

			<label for="internal_obs">Observação</label><br/>
			<textarea name="internal_obs"/></textarea><br/><br/>
		</div>
		<div class="tabbody" style="display: none;">
			<label for="address_zipcode">CEP</label><br/>
			<input type="text" name="address_zipcode"/><br/><br/>

			<label for="address">Rua</label><br/>
			<input type="text" name="address"/><br/><br/>

			<label for="address_number">Número</label><br/>
			<input type="text" name="address_number"/><br/><br/>

			<label for="address2">Complemnto</label><br/>
			<input type="text" name="address2"/><br/><br/>

			<label for="address_neighb">Bairro</label><br/>
			<input type="text" name="address_neighb"/><br/><br/>

			<label for="address_city">Cidade</label><br/>
			<input type="text" name="address_city"/><br/><br/>

			<label for="address_country">País</label><br/>
			<input type="text" name="address_country"/><br/><br/>
		</div>
	</div>		
	<input type="submit" value="Salvar"/>
</form>

<script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/script_zipcode.js"></script>