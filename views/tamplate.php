<html>
    <head>
        <meta charset="UTF-8">
        <title>Painel - <?php echo $viewData['subscriber_name'] ?> </title>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/template.css">
        <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/jquery-3.1.0.min.js"></script>
        <script type="text/javascript">var BASE_URL = '<?php echo BASE_URL; ?>';</script>
        <script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
    </head>
    <body>
    	<div class="leftmenu">
    		<div class="subscriber_name">
    			<img class="subscriber_logo" src="<?php echo BASE_URL; ?>/assets/images/logo.png">
    		</div>
    		<div class="menuarea">            
    			<ul>
                    <li style="<?php echo ($_SESSION['has_dashboard']==1)?'display: block':'display: none'; ?>"><a href="<?php echo BASE_URL; ?>">Dashboard</a></li>
                    <li style="<?php echo ($_SESSION['has_emails']==1)?'display: block':'display: none'; ?>"><a href="<?php echo BASE_URL; ?>/emails">E-Mails Enviados</a></li>
                    <li style="<?php echo ($_SESSION['has_permissions']==1)?'display: block':'display: none'; ?>"><a href="<?php echo BASE_URL; ?>/permissions">Permissões</a></li>
                    <li style="<?php echo ($_SESSION['has_users']==1)?'display: block':'display: none'; ?>"><a href="<?php echo BASE_URL; ?>/users">Usuários</a></li>
                    <li style="<?php echo ($_SESSION['has_courses']==1)?'display: block':'display: none'; ?>"><a href="<?php echo BASE_URL; ?>/courses">Cursos</a></li>
                    <li style="<?php echo ($_SESSION['has_certificates']==1)?'display: block':'display: none'; ?>"><a href="<?php echo BASE_URL; ?>/certificates">Certificados</a></li>
                    <li style="<?php echo ($_SESSION['has_certificatesItens']==1)?'display: block':'display: none'; ?>"><a href="<?php echo BASE_URL; ?>/certificatesItens">Lançar Certificados</a></li>
                    <li style="<?php echo ($_SESSION['has_companies']==1)?'display: block':'display: none'; ?>"><a href="<?php echo BASE_URL; ?>/companies">Empresas</a></li>
                    <li style="<?php echo ($_SESSION['has_clients']==1)?'display: block':'display: none'; ?>"><a href="<?php echo BASE_URL; ?>/clients">Clientes</a></li>
                    <li style="<?php echo ($_SESSION['has_participants']==1)?'display: block':'display: none'; ?>"><a href="<?php echo BASE_URL; ?>/participants">Participantes</a></li>
                    <li style="<?php echo ($_SESSION['has_reports']==1)?'display: block':'display: none'; ?>"><a href="<?php echo BASE_URL; ?>/reports">Relatórios</a></li>
    			</ul>
    		</div>
    	</div>
    	<div class="container">
    		<div class="top">
    			<div class="top_right logout"><a href="<?php echo BASE_URL.'/login/logout'; ?>">Sair</a></div>
    			<div class="top_right"><?php echo $viewData['user_name'] ?></div>
    		</div>
    		<div class="area">
    			<?php $this->loadViewInTamplate($viewName, $viewData); ?>
    		</div>
    	</div>
    </body>
</html>