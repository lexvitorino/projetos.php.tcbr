<div class="titulo">
	<h1>Lançar Certificados</h1>
</div>

<?php if(isset($msg) && !empty($msg)): ?>
    <div class="alert alert_error">
        <?php echo $msg; ?>
    </div>
<?php endif; ?>

<a class="button" href="<?php echo BASE_URL; ?>/certificatesItens/add/">Adicionar Certificado</a><br/><br/>
<table border="0" width="100%">
	<tr>
		<th style="text-align: left">ID</th>
		<th style="text-align: left">Nome</th>
		<th style="text-align: left">Data</th>
		<th style="text-align: left">Movimento</th>
		<th style="text-align: left">Quantidade</th>
		<th style="text-align: left">Observações</th>
		<th style="text-align: left">Ações</th>
	</tr>	
	<?php foreach($certificatesItens_list as $p): ?>
	<tr>
		<td width="50"><?php echo $p['id']; ?></td>
		<td><?php echo $p['certificate']; ?></td>
		<td width="100"><?php echo date('d/m/Y', strtotime($p['created_date'])); ?></td>
		<td width="100"><?php echo $p['tipo_movimento']; ?></td>
		<td width="100"><?php echo $p['amount']; ?></td>
		<td><?php echo $p['comment']; ?></td>
		<td width="85">
			<a class="button button_small button_danger" href="<?php echo BASE_URL; ?>/certificatesItens/delete/<?php echo $p['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir o registro?')">Excluir</a>
		</td>
	</tr>
	<?php endforeach; ?>	
</table>

<div class="pagination <?php echo ($paginas_count<=1)?'pag_inactive':''; ?>">
	<div class="pag_item <?php echo ($pagina==1)?'pag_inactive':''; ?>">
		<a href="<?php echo BASE_URL; ?>/certificatesItens?p=<?php echo 1; ?>"><<</a>
	</div>
	<div class="pag_item <?php echo ($pagina==1)?'pag_inactive':''; ?>">
		<a href="<?php echo BASE_URL; ?>/certificatesItens?p=<?php echo $pagina-1; ?>"><</a>
	</div>
	<?php for($q=($pagina<4?1:($pagina-3)); $q<=($pagina<4?7:($pagina+3)); $q++): ?>
		<div class="pag_item <?php echo ($q==$pagina)?'pag_active':''; ?> <?php echo ($paginas_count<$q)?'pag_invisible':''; ?>">
			<a href="<?php echo BASE_URL; ?>/certificatesItens?p=<?php echo $q; ?>"><?php echo $q; ?></a>
		</div>
	<?php endfor; ?>
	<div class="pag_item <?php echo ($paginas_count==$pagina)?'pag_inactive':''; ?>">
		<a href="<?php echo BASE_URL; ?>/certificatesItens?p=<?php echo $pagina+1; ?>">></a>
	</div>
	<div class="pag_item <?php echo ($paginas_count==$pagina)?'pag_inactive':''; ?>">
		<a href="<?php echo BASE_URL; ?>/certificatesItens?p=<?php echo $paginas_count; ?>">>></a>
	</div>
	<div style="clear: both;"></div>
</div>
