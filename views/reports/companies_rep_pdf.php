<h1>Relatório de Empresas</h1>

<fieldset>
<?php 
	if(!empty($filters['name'])) {
      echo "Nome.: ".$filters['name']."<br/>";
    }
?>
</fieldset>

<br/>

<table border="0" width="100%">
	<tr>
		<th style="text-align: left">ID</th>
		<th style="text-align: left">Nome</th>
	</tr>	
	<?php foreach($companies_list as $p): ?>
	<tr>
		<td width="50"><?php echo $p['id']; ?></td>
		<td><?php echo $p['name']; ?></td>
	</tr>
	<?php endforeach; ?>	
</table>