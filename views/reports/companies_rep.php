<div class="titulo">
	<h1>Relatório de Empresas</h1>
</div>

<form method="GET" onsubmit="return openPopupCompanies(this)">
	<div class="report_filter">
		<label for="name">Nome</label><br/>
		<input type="text" name="name" /><br/><br/>

		<label for="order">Ordenação</label><br/>
		<select name="order">
			<option value="id">ID</option>
			<option value="name">Nome</option>
		</select><br/><br/>
	</div>

	<div style="clear: both;"></div>
	
	<input class="button" type="submit" value="Gerar Relatório" />
</form>

<script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/script_report.js"></script>