<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/login.css">
    </head>
    <body>
        <div class="loginlogo">
            <img src="<?php echo BASE_URL; ?>/assets/images/logo.png">
        </div>

        <div class="loginarea">
            <form method="POST">
                <input type="text" name="login" placeholder="Digite seu login" />
                <input type="password" name="password" placeholder="Digite sua senha" />
                <input class="button_danger" type="submit" value="Entrar"><br/>
                <?php if(isset($error) && !empty($error)): ?>
                    <div class="alert_danger">
                        <?php echo $error; ?>;
                    </di>
                <?php endif; ?>
            </form>
        </div>
    </body>
</html>