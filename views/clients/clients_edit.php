<div class="titulo">
	<h1>Clientes - Editar Cliente</h1>
</div>

<?php if(isset($error) && !empty($error)): ?>
    <div class="alert alert_warning">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<form method="POST">
	<div class="tabarea">
		<div class="tabitem tabitem-3 activetab">
			Gerais
		</div>
		<div class="tabitem tabitem-3">
			Endereço
		</div>
		<div class="tabitem tabitem-3">
			Cursos
		</div>
	</div>

	<div class="tabcontent">
		<div class="tabbody" style="display: block;">
			<label for="name">Nome</label><br/>
			<input type="text" name="name" value="<?php echo $client['name']; ?>" required/><br/><br/>

			<label for="cpf">CPF</label><br/>
			<input type="text" name="cpf" value="<?php echo $client['cpf']; ?>" required/><br/><br/>

			<label for="rg">RG</label><br/>
			<input type="text" name="rg" value="<?php echo $client['rg']; ?>" required/><br/><br/>

			<label for="email">E-mail</label><br/>
			<input type="email" name="email" value="<?php echo $client['email']; ?>"/><br/><br/>

			<label for="phone">Telefone</label><br/>
			<input type="text" name="phone" value="<?php echo $client['phone']; ?>"/><br/><br/>

			<label for="stars">Estrelas</label><br/>
			<select type="text" name="stars" id="stars"/>
				<option value="1" <?php echo ($client['stars']=='1')?'selected="selected"':''; ?>>1 Estrela</option>		
				<option value="2" <?php echo ($client['stars']=='2')?'selected="selected"':''; ?>>2 Estrelas</option>		
				<option value="3" <?php echo ($client['stars']=='3')?'selected="selected"':''; ?>>3 Estrelas</option>		
				<option value="4" <?php echo ($client['stars']=='4')?'selected="selected"':''; ?>>4 Estrelas</option>		
				<option value="5" <?php echo ($client['stars']=='5')?'selected="selected"':''; ?>>5 Estrelas</option>		
			</select><br/><br/>

			<label for="id_company">Empresa</label><br/>
			<select name="id_company">
			<?php foreach ($companies_list as $item): ?>
			<option value=""></option>
			<option value="<?php echo $item['id'] ?>" <?php echo ($item['id']==$client['id_company'])?'selected="selected"':''; ?>> <?php echo $item['name']; ?></option>
			<?php endforeach; ?>
			</select><br/><br/>

			<label for="internal_obs">Observação</label><br/>
			<textarea name="internal_obs" value="<?php echo $client['internal_obs']; ?>"/></textarea><br/><br/>
		</div>
		<div class="tabbody" style="display: none;">
			<label for="address_zipcode">CEP</label><br/>
			<input type="text" name="address_zipcode" value="<?php echo $client['address_zipcode']; ?>"/><br/><br/>

			<label for="address">Rua</label><br/>
			<input type="text" name="address" value="<?php echo $client['address']; ?>"/><br/><br/>

			<label for="address_number">Número</label><br/>
			<input type="text" name="address_number" value="<?php echo $client['address_number']; ?>"/><br/><br/>

			<label for="address2">Complemnto</label><br/>
			<input type="text" name="address2" value="<?php echo $client['address2']; ?>"/><br/><br/>

			<label for="address_neighb">Bairro</label><br/>
			<input type="text" name="address_neighb" value="<?php echo $client['address_neighb']; ?>"/><br/><br/>

			<label for="address_city">Cidade</label><br/>
			<input type="text" name="address_city" value="<?php echo $client['address_city']; ?>"/><br/><br/>

			<label for="address_country">País</label><br/>
			<input type="text" name="address_country" value="<?php echo $client['address_country']; ?>"/><br/><br/>
		</div>
		<div class="tabbody" style="display: none;">
			<table border="0" width="100%">
				<tr>
					<th style="text-align: left">ID</th>
					<th style="text-align: left">Curso</th>
					<th style="text-align: left">Data Inicio</th>
					<th style="text-align: left">Data Fim</th>
					<th style="text-align: left">Velidade</th>
					<th style="text-align: left">Ações</th>
				</tr>	
				<?php foreach($participants_list as $p): ?>
				<tr>
					<td width="50"><?php echo $p['id']; ?></td>
					<td><?php echo $p['course']; ?></td>
					<td width="150"><?php echo date('d/m/Y', strtotime($p['date_start'])); ?></td>
					<td width="150"><?php echo date('d/m/Y', strtotime($p['date_end'])); ?></td>
					<td width="150"><?php echo date('d/m/Y', strtotime($p['expiration_date'])); ?></td>
					<td width="170">
						<a class="button button_small" href="<?php echo BASE_URL; ?>/participants/edit/<?php echo $p['id']; ?>">Editar</a>
						<a class="button button_small button_danger" href="<?php echo BASE_URL; ?>/participants/delete/<?php echo $p['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')">Excluir</a>
					</td>
				</tr>
				<?php endforeach; ?>	
			</table><br/><br/>
		</div>
	</div>		

	<input type="submit" value="Salvar"/>
</form>

<script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/script_zipcode.js"></script>