<h1>Relatório de Clientes</h1>

<fieldset>
<?php 
	if(!empty($filters['name'])) {
      echo "Nome.: ".$filters['name']."<br/>";
    }

    if(!empty($filters['dtInicial']) && !empty($filters['dtFinal'])) {
      echo "Data do Curso.: ".date('d/m/Y',strtotime($filters['dtInicial']))." até ".date('d/m/Y',strtotime($filters['dtFinal']))."<br/>";
    }

    if(!empty($filters['id_company'])) {
      echo "Empresa.: ".$filters['company']."<br/>";
    }
?>
</fieldset>

<br/>

<table border="0" width="100%">
	<tr>
		<th style="text-align: left">ID</th>
		<th style="text-align: left">Nome</th>
		<th style="text-align: left">Empresa</th>
		<th style="text-align: left">Estrelas</th>
	</tr>	
	<?php foreach($clients_list as $p): ?>
	<tr>
		<td width="50"><?php echo $p['id']; ?></td>
		<td><?php echo $p['name']; ?></td>
		<td><?php echo $p['company']; ?></td>
		<td><?php echo $p['stars']; ?></td>
	</tr>
	<?php endforeach; ?>	
</table>