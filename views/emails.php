<div class="titulo">
	<h1>E-mails Enviados</h1>
</div>

<?php if(isset($msg) && !empty($msg)): ?>
    <div class="alert alert_info">
        <?php echo $msg; ?>
    </div>
<?php endif; ?>

<table border="0" width="100%">
	<tr>
		<th style="text-align: left">ID</th>
		<th style="text-align: left">Destinatário</th>
		<th style="text-align: left">Assunto</th>
		<th style="text-align: left">Ações</th>
	</tr>	
	<?php foreach($emails_list as $p): ?>
	<tr>
		<td width="50"><?php echo $p['id']; ?></td>
		<td width="200"><?php echo $p['recipient']; ?></td>
		<td><?php echo $p['subject_matter']; ?></td>
		<td width="210">
			<a class="button button_small" href="<?php echo BASE_URL; ?>/emails/edit/<?php echo $p['id']; ?>">Editar</a>
			<a class="button button_small button_info" href="<?php echo BASE_URL; ?>/emails/resend/<?php echo $p['id']; ?>">Reenviar Email</a>
		</td>
	</tr>
	<?php endforeach; ?>	
</table>

<div class="pagination <?php echo ($paginas_count<=1)?'pag_inactive':''; ?>">
	<div class="pag_item <?php echo ($pagina==1)?'pag_inactive':''; ?>">
		<a href="<?php echo BASE_URL; ?>/emails?p=<?php echo 1; ?>"><<</a>
	</div>
	<div class="pag_item <?php echo ($pagina==1)?'pag_inactive':''; ?>">
		<a href="<?php echo BASE_URL; ?>/emails?p=<?php echo $pagina-1; ?>"><</a>
	</div>
	<?php for($q=($pagina<4?1:($pagina-3)); $q<=($pagina<4?7:($pagina+3)); $q++): ?>
		<div class="pag_item <?php echo ($q==$pagina)?'pag_active':''; ?> <?php echo ($paginas_count<$q)?'pag_invisible':''; ?>">
			<a href="<?php echo BASE_URL; ?>/emails?p=<?php echo $q; ?>"><?php echo $q; ?></a>
		</div>
	<?php endfor; ?>
	<div class="pag_item <?php echo ($paginas_count==$pagina)?'pag_inactive':''; ?>">
		<a href="<?php echo BASE_URL; ?>/emails?p=<?php echo $pagina+1; ?>">></a>
	</div>
	<div class="pag_item <?php echo ($paginas_count==$pagina)?'pag_inactive':''; ?>">
		<a href="<?php echo BASE_URL; ?>/emails?p=<?php echo $paginas_count; ?>">>></a>
	</div>
	<div style="clear: both;"></div>
</div>