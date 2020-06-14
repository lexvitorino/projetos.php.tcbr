<div class="titulo">
	<h1>Permissões</h1>
</div>

<div class="tabarea">
	<div class="tabitem tabitem-2 activetab">
		Grupos de Permissões
	</div>
	<div class="tabitem tabitem-2">
		Permissões
	</div>
</div>
<div class="tabcontent">
	<div class="tabbody tabbody" style="display: block;">
		<a class="button" href="<?php echo BASE_URL; ?>/permissions/add_group/">Adicionar Grupo de Permissões</a><br/><br/>
		<table border="0" width="100%">
			<tr>
				<th style="text-align: left">ID</th>
				<th style="text-align: left">Nome</th>
				<th style="text-align: left">Ações</th>
			</tr>	
			<?php foreach($permission_groups_list as $p): ?>
			<tr>
				<td width="50"><?php echo $p['id']; ?></td>
				<td><?php echo $p['name']; ?></td>
				<td width="170">
					<a class="button button_small" href="<?php echo BASE_URL; ?>/permissions/edit_group/<?php echo $p['id']; ?>">Editar</a>
					<a class="button button_small button_danger" href="<?php echo BASE_URL; ?>/permissions/delete_group/<?php echo $p['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')">Excluir</a>
				</td>
			</tr>
			<?php endforeach; ?>	
		</table>	
	</div>
	<div class="tabbody" style="display: none;">
		<a class="button" href="<?php echo BASE_URL; ?>/permissions/add_param">Adicionar Permissão</a><br/><br/>
		<table border="0" width="100%">
			<tr>
				<th style="text-align: left">ID</th>
				<th style="text-align: left">Nome</th>
			</tr>	
			<?php foreach($permission_params_list as $p): ?>
			<tr>
				<td width="50"><?php echo $p['id']; ?></td>
				<td><?php echo $p['name']; ?></td>
			</tr>
			<?php endforeach; ?>	
		</table>	
	</div>
</div>