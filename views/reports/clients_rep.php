<div class="titulo">
	<h1>Relatório de Clientes</h1>
</div>

<form method="GET" onsubmit="return openPopupClients(this)">
	<div class="report_filter">
		<label for="dtInicial">Data Inicial</label><br/>
		<input type="date" name="dtInicial" /><br/><br/>

		<label for="dtFinal">Data Final</label><br/>
		<input type="date" name="dtFinal" /><br/><br/>

		<label for="name">Nome</label><br/>
		<input type="text" name="name" /><br/><br/>

		<label for="id_company">Empresa</label><br/>
		<select name="id_company">
			<option value="">Todos</option>
			<?php foreach ($companies_list as $item): ?>
			<option value="<?php echo $item['id'] ?>"><?php echo $item['name'] ?></option>
			<?php endforeach; ?>
		</select><br/><br/>

		<label for="order">Ordenação</label><br/>
		<select name="order">
			<option value="id">ID</option>
			<option value="name">Nome</option>
			<option value="course_date">Data Curso</option>
			<option value="expiration_date">Data Validade</option>
		</select><br/><br/>
	</div>

	<div style="clear: both;"></div>
	
	<input class="button" type="submit" value="Gerar Relatório" />
</form>

<script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/script_report.js"></script>