<div class="titulo">
	<h1>Clientes</h1>
</div>

<?php if($has_clients_add): ?>
<a class="button" href="<?php echo BASE_URL; ?>/clients/add/">Adicionar Cliente</a>
<?php endif; ?>

<input type="text" id="search" data-type="search_clients">

<table border="0" width="100%">
	<tr>
		<th style="text-align: left">ID</th>
		<th style="text-align: left">Nome</th>
		<th style="text-align: left">Empresa</th>
		<th style="text-align: left">Estrelas</th>
		<th style="text-align: left">Ações</th>
	</tr>	
	<?php foreach($clients_list as $p): ?>
	<tr>
		<td width="50"><?php echo $p['id']; ?></td>
		<td><?php echo $p['name']; ?></td>
		<td><?php echo $p['company']; ?></td>
		<td><?php echo $p['stars']; ?></td>
		<td width="170">
			<?php if($has_clients_edit): ?>
			<a class="button button_small" href="<?php echo BASE_URL; ?>/clients/edit/<?php echo $p['id']; ?>">Editar</a>
			<?php endif; ?>
			<a class="button button_small button_danger" href="<?php echo BASE_URL; ?>/clients/delete/<?php echo $p['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')">Excluir</a>
		</td>
	</tr>
	<?php endforeach; ?>	
</table>

<div class="pagination <?php echo ($paginas_count<=1)?'pag_inactive':''; ?>">
	<div class="pag_item <?php echo ($pagina==1)?'pag_inactive':''; ?>">
		<a href="<?php echo BASE_URL; ?>/clients?p=<?php echo 1; ?>"><<</a>
	</div>
	<div class="pag_item <?php echo ($pagina==1)?'pag_inactive':''; ?>">
		<a href="<?php echo BASE_URL; ?>/clients?p=<?php echo $pagina-1; ?>"><</a>
	</div>
	<?php for($q=($pagina<4?1:($pagina-3)); $q<=($pagina<4?7:($pagina+3)); $q++): ?>
		<div class="pag_item <?php echo ($q==$pagina)?'pag_active':''; ?> <?php echo ($paginas_count<$q)?'pag_invisible':''; ?>">
			<a href="<?php echo BASE_URL; ?>/clients?p=<?php echo $q; ?>"><?php echo $q; ?></a>
		</div>
	<?php endfor; ?>
	<div class="pag_item <?php echo ($pagina==$paginas_count)?'pag_inactive':''; ?>">
		<a href="<?php echo BASE_URL; ?>/clients?p=<?php echo $pagina+1; ?>">></a>
	</div>
	<div class="pag_item <?php echo ($pagina==$paginas_count)?'pag_inactive':''; ?>">
		<a href="<?php echo BASE_URL; ?>/clients?p=<?php echo $paginas_count; ?>">>></a>
	</div>
	<div style="clear: both;"></div>
</div>